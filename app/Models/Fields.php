<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use HasFactory;

    protected $table = 'fields';
    protected $fillable = ['name','type','data','placeholder','is_active'];

    
    public function setDataAttribute($value)
    {
    	$this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
    	return json_decode($value, true);
    }
}
