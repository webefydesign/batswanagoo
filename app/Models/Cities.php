<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = ['state_id', 'name'];

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function state(){
        return $this->belongsTo(States::class, 'state_id');
    }

    public function ads(){
        return $this->hasMany(Advertise::class, 'city', 'name')->where('status', 'active');
    }
}
