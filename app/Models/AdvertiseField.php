<?php

namespace App\Models;

use App\Model\Advertise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertiseField extends Model
{
    use SoftDeletes;

    protected $table = 'advertise_fields';
    protected $fillable = ['name', 'value', 'adv_id', 'field_id'];

    public function advertise()
    {
        return $this->hasOne(Advertise::class, 'id', 'adv_id');
    }

    public function field()
    {
        return $this->hasOne(CategoryFields::class, 'id', 'field_id');
    }
    
    public function checkFieldType()
    {
        return $this->hasOne(Fields::class, 'id', 'field_id');
    }

    public static function creator($data)
    {
    }


    public static function updator($data, $id)
    {
    }
}
