<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    protected $table = 'wallets';
    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransactions::class, 'wallet_id', 'id');
    }
}
