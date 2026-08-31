<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Session;
use App\Models\Advertise;
use App\Models\AdvertiseChat;
use App\Models\AdvertiseChatMessages;
use App\Models\Notifications;
use App\Models\ChatStickers;


class ChatController extends Controller
{
    public function start_chat(Request $request)
    {
        $buyerId = auth()->id();
        $ad = Advertise::with('user')->findOrFail($request->ad_id);
        $sellerId = $ad->user_id;

        //  Check if chat already exists between this buyer & ad
        $chat = AdvertiseChat::where('ad_id', $ad->id)
            ->where(function ($q) use ($buyerId, $sellerId) {
                $q->where('user_id', $buyerId)
                ->orWhere('user_id', $sellerId);
            })
            ->first();

        //  If not found, create a new one
        if (!$chat) {
            $chat = AdvertiseChat::create([
                'user_id' => $buyerId, // initiator
                'ad_id' => $ad->id,
                'is_archived' => 0,
                'is_new' => 1,
            ]);
        } else {
            // Mark as new again if already exists
            $chat->update(['is_new' => 1]);
        }

        //  Create message (always)
        AdvertiseChatMessages::create([
            'advertise_chat_id' => $chat->id,
            'user_id' => $buyerId,
            'message' => $request->msg,
            'unread' => 1,
            'type' => 'text',
            'images' => null,
            'sticker' => null,
        ]);

        //  Mark chat as new for the receiver (the other person)
        if ($buyerId === $sellerId) {
            // do nothing if same user (edge case)
        } else {
            $chat->update(['is_new' => 1]);
        }

        // Redirect to that same chat
        return redirect('dashboard/chat?chat=' . $chat->id);
    }

    public function chat(Request $request)
    {
        $userId = auth()->id();
        $adIds = auth()->user()->activeAds->pluck('id')->toArray();

        $query = AdvertiseChat::with([
            'lastMessage',
            'ad.gallery',
            'ad.user',
            'user'
        ])->withCount([
            'unreadMessages as unread_count'
        ]);

        $chats = $query->where(function ($q) use ($adIds, $userId) {
                if (!empty($adIds)) {
                    $q->whereIn('ad_id', $adIds);
                }
                $q->orWhere('user_id', $userId);
            })
            ->withMax('lastMessage as last_message_created_at', 'created_at')
            ->orderByDesc('last_message_created_at')
            ->get();
        
        // Filter out chats that don't have valid ads or users
        // $chats = $chats->filter(function($chat) {
        //     return $chat->ad && $chat->ad->exists && $chat->user && $chat->user->exists;
        // });
        $chat = [];
        $messages = [];
        $activeChatId = $request->chat;
        if($request->has('chat') && $request->chat!='') {
            $chat = AdvertiseChat::with(['ad.gallery', 'ad.user', 'user'])->find($request->chat);
            if($chat && $chat->user && $chat->user->exists) {
                // Mark chat as read (set is_new to 0) when user opens the chat
                $chat->update(['is_new' => 0]);
                AdvertiseChatMessages::where('advertise_chat_id', $chat->id)
                    ->where('user_id', '!=', auth()->id()) // only messages not sent by this user
                    ->where('unread', 1)
                    ->update(['unread' => 0]);
                
                $messages = AdvertiseChatMessages::where('advertise_chat_id', $chat['id'])->get()->groupBy(function($item){
                    return $item->created_at->format('d-m-Y');
                });
            } else {
                $chat = null; // Reset chat if user doesn't exist
            }
        }
        $stickers = ChatStickers::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();
        return view('frontend.dashboard.chat', compact('chats', 'chat', 'messages', 'stickers', 'activeChatId'));
    }

    public function send_msg(Request $request)
    {
        $images = [];
        $sticker = null;
        $type = 'text';

        // Handle uploaded images
        if ($request->hasFile('pics')) {
            $uploadPath = '/uploads/chats';
            $path = public_path() . $uploadPath;
            foreach ($request->pics as $pic) {
                $filename = 'pic-' . auth()->id() . '-' . time() . '.' . $pic->getClientOriginalExtension();
                $pic->move($path, $filename);
                $images[] = $uploadPath . '/' . $filename;
            }
        }

        // Handle sticker messages
        if ($request->has('sticker') && $request->sticker) {
            $sticker = $request->sticker;
            $type = 'sticker';
        }

        // Store the message
        $message = AdvertiseChatMessages::create([
            'advertise_chat_id' => $request->chat_id,
            'user_id' => auth()->id(),
            'message' => $request->msg,
            'images' => !empty($images) ? json_encode($images) : null,
            'sticker' => $sticker,
            'type' => $type,
            'unread' => 1,
        ]);
        
        // 🔥 Broadcast the message via Pusher
        event(new MessageSent($message));

        // Fetch the chat for recipient data
        $chat = AdvertiseChat::find($request->chat_id);

        if ($chat) {
            $recipientUserId = ($chat->user_id == auth()->id())
                ? $chat->ad->user_id
                : $chat->user_id;

            // Update is_new flag
            if ($chat->user_id == auth()->id()) {
                $adOwnerChat = AdvertiseChat::where('ad_id', $chat->ad_id)
                    ->where('user_id', $chat->ad->user_id)
                    ->first();

                if ($adOwnerChat) {
                    $adOwnerChat->update(['is_new' => 1]);
                }
            } else {
                $chat->update(['is_new' => 1]);
            }

            // Create notification for the recipient
            // Notifications::create([
            //     'user_id' => $recipientUserId,
            //     'title' => 'New message on "' . $chat->ad->title . '"',
            //     'message' => 'New message on ' . $chat->ad->title,
            //     'is_read' => 0,
            // ]);
        }


        // Return response
        return response()->json([
            'resp' => 'success',
            'message' => $message->message,
            'type' => $message->type,
            'sticker' => $message->sticker,
            'images' => $message->images,
            'user_id' => $message->user_id,
            'chat_id' => $message->advertise_chat_id,
            'created_at' => $message->created_at,
        ]);
    }

    // public function fetch_messages(Request $request) {
    //     $chatId = $request->chat_id;
    //     $messages = AdvertiseChatMessages::with('user')
    //         ->where('advertise_chat_id', $chatId)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Group by date for the Vue loop
    //     $grouped = $messages->groupBy(function($msg) {
    //         return $msg->created_at->format('d-m-Y');
    //     });

    //     return response()->json($grouped);
    // }

    public function fetch_messages(Request $request)
    {
        $chatId = $request->chat_id;
        $userId = auth()->id();

        AdvertiseChatMessages::where('advertise_chat_id', $chatId)
            ->where('user_id', '!=', $userId)
            ->where('unread', 1)
            ->update(['unread' => 0]);

        $messages = AdvertiseChatMessages::with('user')
            ->where('advertise_chat_id', $chatId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Group messages by date
        $grouped = $messages->groupBy(function ($msg) {
            return $msg->created_at->format('d-m-Y');
        });

        return response()->json($grouped);
    }
    
    public function fetchChatList(Request $request)
    {
        $userId = auth()->id();
        $adIds = auth()->user()->activeAds->pluck('id')->toArray();
        $activeChatId = $request->chat_id;

        // Mark messages as read when specific chat is active
        if ($request->chat_id) {
            AdvertiseChatMessages::where('advertise_chat_id', $request->chat_id)
                ->where('user_id', '!=', $userId)
                ->where('unread', 1)
                ->update(['unread' => 0]);
        }

        $query = AdvertiseChat::with([
            'lastMessage',
            'ad.gallery',
            'ad.user',
            'user'
        ])->withCount([
            'unreadMessages as unread_count'
        ])
        ->where(function ($q) use ($adIds, $userId) {
            // Include chats where user is either the ad owner OR chat initiator
            if (!empty($adIds)) {
                $q->whereIn('ad_id', $adIds);
            }
            $q->orWhere('user_id', $userId);
        })
        ->withMax('lastMessage as last_message_created_at', 'created_at')
        ->orderByDesc('last_message_created_at');

        $chats = $query->get();

        return view('frontend.dashboard.chat-list', compact('chats', 'activeChatId'));
    }

}