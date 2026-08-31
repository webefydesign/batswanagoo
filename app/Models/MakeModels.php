<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeModels extends Model
{
    use HasFactory;

    protected $table = 'make_model';
    protected $fillable = ['make_id', 'name', 'is_active'];
    protected $dates = ['deleted_at'];

    function make() {
        return $this->belongsTo(Make::class, 'make_id', 'id');
    }

    // function cars(){
    //     return $this->hasMany(Car::class, 'model_id');
    // }

    // function reviews(){
    //     return $this->hasMany(Reviews::class, 'model_id');
    // }

    // function shipping(){
    //     return $this->hasMany(Shipping::class, 'model_id');
    // }
}
