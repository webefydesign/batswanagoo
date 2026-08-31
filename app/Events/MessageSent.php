<?php

namespace App\Events;

use App\Models\AdvertiseChatMessages;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(AdvertiseChatMessages $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // must match your frontend channel name
        return new Channel('chat.' . (int)$this->message->advertise_chat_id);
    }

    public function broadcastAs()
    {
        // must match your frontend event name
        return 'message.sent';
    }
}