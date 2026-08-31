<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = ['user_id', 'title', 'message', 'is_read', 'advertise_id', 'type', 'msg_id', 'wallet_transaction_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ad() {
        return $this->belongsTo(Advertise::class, 'advertise_id', 'id');
    }

    public function msg() {
        return $this->belongsTo(AdvertiseMessage::class, 'msg_id', 'id');
    }

    public function walletTransaction() {
        return $this->belongsTo(WalletTransactions::class, 'wallet_transaction_id', 'id');
    }
}
