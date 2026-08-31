<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
    protected $fillable = ['name', 'type', 'size', 'meta'];

    /* User Log */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model' => 'Media',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Created media: {$post->name}",
            ]);
        });

        static::updated(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'Media',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Updated media: {$post->name}",
            ]);
        });

        static::deleted(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model' => 'Media',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Deleted media: {$post->name}",
            ]);
        });
    }
    /* User Log */
}
