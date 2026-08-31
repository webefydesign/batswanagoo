<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    protected $table = 'wallet_transactions';
    protected $fillable = ['user_id', 'wallet_id', 'amount', 'type', 'description', 'ref', 'payment_method', 'payment_status', 'plan_id', 'promotion_id']  ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallets::class, 'wallet_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(UserPlan::class, 'plan_id', 'id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotions::class, 'promotion_id', 'id');
    }
}
