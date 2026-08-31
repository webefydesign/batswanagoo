<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promote extends Model
{
    use SoftDeletes;

    protected $table = 'promotes';
    protected $fillable = ['name', 'description', 'promote', 'is_active'];
    protected $dates = ['deleted_at'];

    public function setPromoteAttribute($value)
    {
    	$this->attributes['promote'] = json_encode($value);
    }

    public function getPromoteAttribute($value)
    {
    	return json_decode($value, true);
    }

}
