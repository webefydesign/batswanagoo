<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertiseAvailability extends Model
{
    use SoftDeletes;

    protected $table = 'advertise_availability';

    protected $fillable = ['adv_id', 'user_id', 'report', 'reason_type', 'reason_desc'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function reports()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
