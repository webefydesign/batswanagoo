<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserLog;

class AdvertiseMessage extends Model
{
    // use SoftDeletes;

    protected $table = 'advertise_message';
    protected $fillable = ['adv_id', 'user_id', 'name', 'email', 'phone', 'msg', 'type'];

    public function advertise(){
        return $this->hasOne(Advertise::class, 'id', 'adv_id');
    }

    /* User Log */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model' => 'AdvertiseMessage',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Created Message: {$post->title}",
            ]);
        });

        static::updated(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'AdvertiseMessage',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Updated Message: {$post->title}",
            ]);
        });

        static::deleted(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model' => 'AdvertiseMessage',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Deleted Message: {$post->title}",
            ]);
        });
    }
    /* User Log */
}
