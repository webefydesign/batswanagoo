<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $table = 'performances';
    protected $fillable = ['user_id', 'date', 'impression', 'visitor', 'phone_view', 'chat_request'];
}
