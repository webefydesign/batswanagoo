<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    protected $table = 'faqs';
    protected $fillable = ['category_id','title','description', 'is_active'];

    function category() {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
}
