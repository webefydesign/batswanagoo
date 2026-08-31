<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryAdsCount extends Model
{
    use SoftDeletes;

    protected $table = 'category_ads_counts';
    protected $fillable = ['category_id', 'advertise'];
    protected $dates = ['deleted_at'];

    public function category()
	{
	    return $this->hasOne(Categories::class, 'category_id');
	}

}
