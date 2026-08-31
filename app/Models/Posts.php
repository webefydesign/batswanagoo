<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $fillable = [
        'user_id', 'category_id', 'brand_id', 'title', 'slug', 'short_description', 'description', 'image', 'sku', 'price', 'quantity', 'gallery', 'discount', 'post_type', 'meta_keywords', 'meta_description', 'meta_title', 'link_canonical', 'is_active','is_featured', 'attributes', 'related','best_seller', 'top_rated', 'unit', 'weight','discounted_price'
    ];

    function user() {
        return $this->hasOne('App\User', 'id','user_id');
    }

    function category() {
        return $this->hasOne('App\Model\CustomCategory', 'id','category_id');
    }

    function categorRelation() {
        return $this->hasMany(PostCategoryRelation::class, 'post_id');
    }

    function brand() {
        return $this->hasOne('App\Model\Brands', 'id','brand_id');
    }

    function comments() {
        return $this->hasMany('App\Model\PostsReviews', 'post_id');
    }

    function getprice() {
        if(!empty($this['discounted_price'])){
            return "PKR ".$this['discounted_price']." <del class='price'> PKR ".$this['price']." </del> ";
        } else {
            return "PKR ".$this['price']."";
            return "PKR ".$this['price'];
        }
    }

    public function incoming($id) {
        $items = TransferItems::where('post_id',$id)->get();
        $incoming = $items->sum('recieved_qty') - $items->sum('issued_qty');
        return $incoming;
    }
}
