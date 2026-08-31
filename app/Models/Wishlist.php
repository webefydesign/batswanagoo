<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = "wishlist";
    protected $fillable = ['adv_id', 'user_id'];
}
