<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    use HasFactory;

    protected $table = 'make';
    protected $fillable = ['name', 'image', 'is_active'];
    protected $dates = ['deleted_at'];

    // function cars() {
    //     return $this->hasMany('App\Model\Car', 'make_id', 'id');
    // }

    function make_model() {
        return $this->hasMany(MakeModels::class, 'make_id', 'id');
    }
}
