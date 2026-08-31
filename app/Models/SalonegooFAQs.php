<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalonegooFAQs extends Model
{
    protected $table = 'salonegoo_faqs';
    protected $fillable = ['category_name','title','description', 'is_active'];
}
