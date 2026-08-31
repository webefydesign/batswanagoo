<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $table = 'currencies';
    protected $fillable = ['code', 'name', 'rate', 'symbol', 'symbol_place', 'decimal_token', 'thousand_token', 'decimal_places', 'is_default', 'is_active'];
}
