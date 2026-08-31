<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    // use SoftDeletes;

    protected $table =
    'feedbacks';

    protected $fillable = ['user_id', 'seller_id', 'message', 'rating', 'parent_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
