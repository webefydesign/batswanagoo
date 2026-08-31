<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComments extends Model
{
    protected $table = 'blog_comments';
    protected $fillable = [ 'blog_id', 'name', 'email', 'comment', 'is_active' ];

    public function blog()
    {
        return $this->belongsTo(Blogs::class, 'blog_id');
    }
}
