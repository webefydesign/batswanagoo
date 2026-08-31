<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\ChatListUpdated;
use Illuminate\Http\Request;
use Session;
use App\Models\AdvertiseChat;
use App\Models\AdvertiseChatMessages;
use App\Models\Notifications;
use App\Models\ChatStickers;


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

    // API methods for Vue.js
    public function getChats(Request $request) {
        $ad_ids = auth()->user()->activeAds->pluck('id')->toArray();
        $chats = [];
        
        if(!empty($ad_ids)) {
            $chats = AdvertiseChat::with(['lastMessage', 'ad.gallery', 'ad.user', 'user'])
                ->whereIn('ad_id', $ad_ids)
                ->OrderBy('id', 'DESC')
                ->get();
        } else {
            $chats = AdvertiseChat::with(['lastMessage', 'ad.gallery', 'ad.user', 'user'])
                ->where('user_id', auth()->user()->id)
                ->OrderBy('id', 'DESC')
                ->get();
        }
        
        // Filter out chats that don't have valid ads or users
        $chats = $chats->filter(function($chat) {
            return $chat->ad && $chat->ad->exists && $chat->user && $chat->user->exists;
        });

        return response()->json([
            'chats' => $chats->values()->map(function($chat) {
                $c_img = null;
                if($chat->ad && $chat->ad->gallery && $chat->ad->gallery->first()) {
                    $c_img = $chat->ad->gallery->first()->mobile_img;
                }

                return [
                    'id' => $chat->id,
                    'is_new' => $chat->is_new,
                    'is_archived' => $chat->is_archived,
                    'unread_count' => \App\Models\AdvertiseChatMessages::where('advertise_chat_id', $chat->id)
                        ->where('user_id', '!=', auth()->id())
                        ->where('unread', 1)
                        ->count(),
                    'ad_title' => $chat->ad ? $chat->ad->title : 'Ad Not Available',
                    'ad_image' => $c_img ? asset('uploads/post/' . $c_img) : asset('assets_frontend/img/ic-11.png'),
                    'user_name' => $chat->user && $chat->user->id == auth()->user()->id 
                        ? ($chat->ad && $chat->ad->user ? ($chat->ad->user->first_name ?? $chat->ad->user->name) : 'Unknown User')
                        : ($chat->user ? ($chat->user->first_name ?? $chat->user->name) : 'Unknown User'),
                    'last_message' => $chat->last_message_text,
                    'created_at' => $chat->created_at->format('d M h:i a'),
                    'ad_id' => $chat->ad ? $chat->ad->id : null,
                    'ad_slug' => $chat->ad ? $chat->ad->slug : null,
                    'category_id' => $chat->ad ? $chat->ad->category_id : null
                ];
            })
        ]);
    }

    public function getMessages(Request $request) {
        $chat = AdvertiseChat::with(['ad.gallery', 'ad.user', 'user'])->find($request->chat_id);
        
        if(!$chat || !$chat->user || !$chat->user->exists) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        // Mark chat as read when user opens it
        $chat->update(['is_new' => 0]);
        // Mark messages from the other user as read (unread = 0)
        \App\Models\AdvertiseChatMessages::where('advertise_chat_id', $request->chat_id)
            ->where('user_id', '!=', auth()->id())
            ->where('unread', 1)
            ->update(['unread' => 0]);

        $messages = AdvertiseChatMessages::with('user')
            ->where('advertise_chat_id', $request->chat_id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($item){
                return $item->created_at->format('d-m-Y');
            });

        return response()->json([
            'chat' => [
                'id' => $chat->id,
                'ad_title' => $chat->ad ? $chat->ad->title : 'Ad Not Available',
                'ad_image' => $chat->ad && $chat->ad->gallery && $chat->ad->gallery->first() 
                    ? asset('uploads/post/' . $chat->ad->gallery->first()->mobile_img) 
                    : asset('assets_frontend/img/ic-11.png'),
                'user_name' => $chat->user && $chat->user->id == auth()->user()->id 
                    ? ($chat->ad && $chat->ad->user ? ($chat->ad->user->first_name ?? $chat->ad->user->name) : 'Unknown User')
                    : ($chat->user ? ($chat->user->first_name ?? $chat->user->name) : 'Unknown User'),
                'ad_phone' => $chat->ad ? $chat->ad->phone : null,
                'ad_slug' => $chat->ad ? $chat->ad->slug : null,
                'category_id' => $chat->ad ? $chat->ad->category_id : null
            ],
            'messages' => $messages->map(function($dayMessages, $date) {
                return [
                    'date' => $date,
                    'messages' => $dayMessages->map(function($msg) {
                        return [
                            'id' => $msg->id,
                            'user_id' => $msg->user_id,
                            'message' => $msg->message,
                            'type' => $msg->type,
                            'sticker' => $msg->sticker,
                            'images' => $msg->images,
                            'user_name' => $msg->user->first_name ?? $msg->user->name,
                            'user_image' => $msg->user->image ? asset('uploads/profile/' . $msg->user->image) : asset('assets_frontend/img/ic-11.png'),
                            'timestamp' => $msg->created_at->format('h:i a'),
                            'is_current_user' => $msg->user_id == auth()->id()
                        ];
                    })
                ];
            })
        ]);
    }

    public function sendMessage(Request $request) {
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
            'type'=>$type,
            // New message is unread for the recipient
            'unread'=>1
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

            // Broadcast chat list update to recipient
            event(new ChatListUpdated($recipientUserId, $chat->id, 'new_message'));
        }
        
        // Broadcast the message
        event(new MessageSent($request->chat_id, auth()->user()->id, $message));
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'message' => $message->message,
                'type' => $message->type,
                'sticker' => $message->sticker,
                'images' => $message->images,
                'user_name' => auth()->user()->first_name ?? auth()->user()->name,
                'user_image' => auth()->user()->image ? asset('uploads/profile/' . auth()->user()->image) : asset('assets_frontend/img/ic-11.png'),
                'timestamp' => $message->created_at->format('h:i a'),
                'is_current_user' => true
            ]
        ]);
    }

    public function getStickers() {
        $stickers = ChatStickers::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();
        
        return response()->json([
            'stickers' => $stickers->map(function($sticker) {
                return [
                    'id' => $sticker->id,
                    'name' => $sticker->name,
                    'sticker' => asset($sticker->sticker)
                ];
            })
        ]);
    }
}
