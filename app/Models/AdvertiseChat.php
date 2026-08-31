<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertiseChat extends Model
{
    protected $table = 'advertise_chat';

    protected $fillable = [ 'ad_id', 'user_id', 'is_archived', 'is_new' ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function ad()
    {
        return $this->hasOne(Advertise::class, 'id', 'ad_id');
    }

    public function msgs()
    {
        return $this->hasMany(AdvertiseChatMessages::class, 'advertise_chat_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(AdvertiseChatMessages::class, 'advertise_chat_id')->latest();
    }

    // public function getLastMessageTextAttribute()
    // {
    //     $lastMessage = $this->lastMessage;
    //     return $lastMessage ? $lastMessage->message : 'No messages yet';
    // }

    public function getLastMessageTextAttribute()
    {
        $lastMessage = $this->lastMessage;
        if (!$lastMessage) return 'No messages yet';

        if ($lastMessage->type === 'sticker') return '📘 Sticker';
        if ($lastMessage->images) return '📷 Image';

        return $lastMessage->message;
    }

    public function unreadMessages()
    {
        return $this->hasMany(AdvertiseChatMessages::class, 'advertise_chat_id')
            ->where('unread', 1)
            ->where('user_id', '!=', auth()->id()); // messages from others
    }
}
