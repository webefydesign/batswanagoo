<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Session;
use App\Models\AdvertiseChat;
use App\Models\AdvertiseChatMessages;
use App\Models\Notifications;


class ChatController extends Controller
{
    public function start_chat(Request $request) {
        $chat = AdvertiseChat::create([
            'user_id'=>auth()->user()->id,
            'ad_id'=>$request->ad_id,
            'is_archived'=>0,
            'is_new'=>0, // Chat initiator doesn't need to see it as new
        ]);
        AdvertiseChatMessages::create([
            'advertise_chat_id'=>$chat['id'],
            'user_id'=>auth()->user()->id,
            'message'=>$request->msg
        ]);

        // Set is_new to 1 for the ad owner's chat (if they have one)
        $adOwnerChat = AdvertiseChat::where('ad_id', $request->ad_id)
            ->where('user_id', '!=', auth()->user()->id)
            ->first();
        if($adOwnerChat) {
            $adOwnerChat->update(['is_new' => 1]);
        }

        return redirect('dashboard/chat?chat='.$chat['id']);
    }

    public function chat(Request $request)
    {
        $ad_ids = auth()->user()->activeAds->pluck('id')->toArray();
        $chats = [];
        if(!empty($ad_ids)) {
            $chats = AdvertiseChat::with(['lastMessage', 'ad.gallery', 'ad.user', 'user'])->whereIn('ad_id', $ad_ids)->OrderBy('id', 'DESC')->get();
        } else {
            $chats = AdvertiseChat::with(['lastMessage', 'ad.gallery', 'ad.user', 'user'])->where('user_id', auth()->user()->id)->OrderBy('id', 'DESC')->get();
        }
        
        // Filter out chats that don't have valid ads or users
        $chats = $chats->filter(function($chat) {
            return $chat->ad && $chat->ad->exists && $chat->user && $chat->user->exists;
        });
        $chat = [];
        $messages = [];
        if($request->has('chat') && $request->chat!='') {
            $chat = AdvertiseChat::with(['ad.gallery', 'ad.user', 'user'])->find($request->chat);
            if($chat && $chat->user && $chat->user->exists) {
                // Mark chat as read (set is_new to 0) when user opens the chat
                $chat->update(['is_new' => 0]);
                
                $messages = AdvertiseChatMessages::where('advertise_chat_id', $chat['id'])->get()->groupBy(function($item){
                    return $item->created_at->format('d-m-Y');
                });
            } else {
                $chat = null; // Reset chat if user doesn't exist
            }
        }
        return view('frontend.dashboard.chat', compact('chats', 'chat', 'messages'));
    }

    public function send_msg(Request $request)
    {
        $images = null;
        $sticker = null;
        $type = 'text';
        
        if($request->hasFile('pics')) {
            $uploadPath = '/uploads/chats';
            $path = public_path().$uploadPath;
            foreach($request->pics as $pic) {
                $filename = 'pic-'.auth()->id().'-'.time().'.'.$pic->getClientOriginalExtension();
                $pic->move($path, $filename);
                $images[] = $uploadPath.'/'.$filename;
            }
        }
        
        // Handle sticker messages
        if($request->has('sticker') && $request->sticker) {
            $sticker = $request->sticker;
            $type = 'sticker';
        }
        
        $message = AdvertiseChatMessages::create([
            'advertise_chat_id'=>$request->chat_id,
            'user_id'=>auth()->id(),
            'message'=>$request->msg,
            'images'=>$images,
            'sticker'=>$sticker,
            'type'=>$type
        ]);
        
        // Get the chat to find the other user
        $chat = AdvertiseChat::find($request->chat_id);
        if($chat) {
            // Determine the recipient user (the other user in the chat)
            $recipientUserId = ($chat->user_id == auth()->id()) ? $chat->ad->user_id : $chat->user_id;
            
            // Set is_new to 1 for the recipient's chat
            if($chat->user_id == auth()->id()) {
                // Message sent by chat initiator, notify ad owner
                $adOwnerChat = AdvertiseChat::where('ad_id', $chat->ad_id)
                    ->where('user_id', $chat->ad->user_id)
                    ->first();
                if($adOwnerChat) {
                    $adOwnerChat->update(['is_new' => 1]);
                }
            } else {
                // Message sent by ad owner, notify chat initiator
                $chat->update(['is_new' => 1]);
            }
            
            // Create notification for the recipient
            Notifications::create([
                'user_id' => $recipientUserId,
                'title' => 'New message on "' . $chat->ad->title . '"',
                'message' => 'New message on ' . $chat->ad->title,
                'is_read' => 0
            ]);
        }
        
        event(new MessageSent($request->chat_id, auth()->user()->id, $message));
        return [
            'resp'=>'success',
            'message' => $message->message,
            'type' => $message->type,
            'sticker' => $message->sticker
        ];
    }

    public function fetch_messages(Request $request) {
        $messages = AdvertiseChatMessages::where('advertise_chat_id', $request->chat_id)->get()->groupBy(function($item){
            return $item->created_at->format('d-m-Y');
        });
        return view('frontend.dashboard.chat-messages', compact('messages'))->render();
    }
}
