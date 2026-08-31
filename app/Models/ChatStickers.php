<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatStickers extends Model
{
    protected $table = 'chat_stickers';

    protected $fillable = [ 'name', 'sticker', 'is_active', 'sort_order' ];
}
