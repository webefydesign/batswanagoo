<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $table = 'user_plans';
    protected $fillable = [
        'user_id', 'plan_id', 'plan_month', 'plan_expire_date', 'paid', 'price', 'transaction_id', 'unsub', 'expired','plan_name','plan_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function plan()
    {
        return $this->hasOne(Plans::class, 'id', 'plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }

    public function plantype()
    {
        return $this->belongsTo(PlanType::class, 'plan_type' , 'id');
    }
}
