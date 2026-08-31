<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safety extends Model
{
    protected $table = 'safeties';
    protected $fillable = ['title','description', 'is_active','image'];
}
