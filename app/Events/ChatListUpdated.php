<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatListUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $chat_id;
    public $action; // 'new_message', 'new_chat', 'archived'

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $chat_id, $action = 'new_message')
    {
        $this->user_id = $user_id;
        $this->chat_id = $chat_id;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user_id),
        ];
    }

    public function broadcastAs()
    {
        return 'chat-list-updated';
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->user_id,
            'chat_id' => $this->chat_id,
            'action' => $this->action,
            'timestamp' => now()->toISOString()
        ];
    }
}


