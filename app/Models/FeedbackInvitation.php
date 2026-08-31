<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackInvitation extends Model
{
    // use SoftDeletes;

    protected $table =
    'feedback_invitations';

    protected $fillable = ['seller_id', 'email', 'name', 'reviewed'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
