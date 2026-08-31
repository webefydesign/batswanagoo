<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertiseChatMessages extends Model
{
    protected $table = 'advertise_chat_messages';

    protected $fillable = [ 'advertise_chat_id', 'user_id', 'type', 'message', 'images', 'sticker', 'unread' ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function chat()
    {
        return $this->hasOne(AdvertiseChat::class, 'id', 'advertise_chat_id');
    }

    public function setImagesAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['images'] = $value;
        } elseif (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } else {
            $this->attributes['images'] = null;
        }
    }

    // public function getImagesAttribute($value)
    // {
    //     $data = json_decode($value, true);
    //     return $data;
    // }

    public function getImagesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // Try decoding JSON
        $decoded = json_decode($value, true);

        // If decoding fails or returns a string, normalize it into an array
        if (is_array($decoded)) {
            $images = $decoded;
        } elseif (is_string($decoded)) {
            $images = [$decoded];
        } elseif (is_string($value)) {
            $images = [$value];
        } else {
            $images = [];
        }

        // Ensure all paths are converted to full URLs
        return array_map(function ($img) {
            return asset($img);
        }, $images);
    }

}
