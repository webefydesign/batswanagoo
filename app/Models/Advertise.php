<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Str;
use App\Models\UserLog;

class Advertise extends Model
{
    use SoftDeletes;


    protected $connection = 'mysql';
    protected $table = 'advertises';
    protected $fillable = ['title', 'slug', 'user_id', 'description', 'category_id', 'details', 'country', 'state', 'city', 'phone', 'payment_type', 'price', 'published', 'status', 'views', 'transaction_id', 'meta_title', 'meta_description', 'seo_meta', 'schema_code'];

    /* User Log */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'model' => 'Advertise',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Created ad: {$post->title}",
            ]);
        });

        static::updated(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'model' => 'Advertise',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Updated ad: {$post->title}",
            ]);
        });

        static::deleted(function ($post) {
            UserLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'model' => 'Advertise',
                'model_id' => $post->id,
                'user_ip'=>request()->ip(),
                'description' => "Deleted ad: {$post->title}",
            ]);
        });
    }
    /* User Log */

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user_plan()
    {
        return $this->hasOne(UserPlan::class, 'user_id', 'user_id')->where('expired', 0)->where('unsub', 0)->where('paid', 1);
    }

    public function reports()
    {
        return $this->hasMany(AdvertiseAvailability::class, 'adv_id', 'id')->where('report', 1);
    }

    public function unavailables()
    {
        return $this->hasMany(AdvertiseAvailability::class, 'adv_id', 'id')->where('report', 0);
    }


    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'adv_id', 'id')->where('user_id', (auth()->check()) ? auth()->user()->id : 0);
    }

    public function fields()
    {
        return $this->hasMany(AdvertiseField::class, 'adv_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(AdvertiseGallery::class, 'adv_id');
    }

    public function promotions()
    {
        return $this->hasMany(AdvertisePromo::class, 'adv_id');
    }

    public function activePromotions()
    {
        return $this->hasMany(AdvertisePromo::class, 'adv_id')->where('paid', 1)->where('expire', 0)
            ->where('start', '<=', date('Y-m-d H:i:s'))->where('end', '>=', date('Y-m-d H:i:s'));
    }

    public function offers()
    {
        return $this->hasMany(AdvertiseMessage::class, 'adv_id')->where('type', 'offer')->orderBy('created_at', 'DESC');
    }

    public function messages()
    {
        return $this->hasMany(AdvertiseMessage::class, 'adv_id')->where('type', 'msg')->orderBy('created_at', 'DESC');
    }

    public function setSeoMetaAttribute($value)
    {
    	$this->attributes['seo_meta'] = json_encode($value);
    }

    public function getSeoMetaAttribute($value)
    {
    	return json_decode($value, true);
    }

    public static function creator($data)
    {

        $ad['title'] = $data['name'];
        $ad['slug'] = Str::slug($data['name']);
        $ad['user_id'] = auth()->user()->id;
        $ad['description'] = ($data['description']) ?? null;
        $ad['category_id'] = end($data['category']);
        $ad['country'] = Countries::find($data['country'])->name;
        $ad['state'] = States::find($data['state'])->name;
        $ad['city'] = Cities::find($data['city'])->name;
        $ad['status'] = 'pending';
        $ad['payment_type'] = ($data['payment_type']) ?? null;
        $ad['price'] = ($data['price']) ?? 0;
        $ad['phone'] = ($data['phone']) ?? null;
        $ad = Advertise::create($ad);
        $ad->update(['slug' => $ad['slug'] . '-' . $ad->id]);


        if (isset($data['field']) && count($data['field']) > 0) {
            $ids = [];
            foreach ($data['field'] as $name => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                $field = $ad->fields->where('name', $name)->first();
                $ca = Categories::find($ad['category_id']);
                $cat_field = $ca->fields->where('title', $name);
                $field_id = ($cat_field->first() != null && isset($cat_field->first()->id)) ? $cat_field->first()->id : 0;
                if ($field == null) {
                    $field = AdvertiseField::create(['adv_id' => $ad->id, 'name' => $name, 'value' => $value, 'field_id' => $field_id]);
                } else {
                    $field->update(['adv_id' => $ad->id, 'name' => $name, 'value' => $value, 'field_id' => $field_id]);
                }
                $ids[] = $field->id;
            }
            AdvertiseField::where('adv_id', $ad->id)->whereNotIn('id', $ids)->forceDelete();
        }

        return $ad;
    }

    public static function updator($data, $id)
    {

        $ad['title'] = $data['name'];
        $ad['slug'] = Str::slug($data['name']) . '-' . $id;
        $ad['user_id'] = auth()->user()->id;
        $ad['description'] = ($data['description']) ?? null;
        $ad['category_id'] = end($data['category']);
        $ad['country'] = Countries::find($data['country'])->name;
        $ad['state'] = States::find($data['state'])->name;
        $ad['city'] = Cities::find($data['city'])->name;
        $ad['payment_type'] = ($data['payment_type']) ?? null;
        $ad['price'] = ($data['price']) ?? 0;
        $ad['phone'] = ($data['phone']) ?? null;
        $adv = Advertise::find($id);
        $adv->update($ad);

        // dd($data['field']);
        if (isset($data['field']) && count($data['field']) > 0) {
            $ids = [];
            foreach ($data['field'] as $name => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                $field = $adv->fields->where('name', $name)->first();
                $ca = Categories::find($ad['category_id']);
                $cat_field = $ca->fields->where('title', $name);
                $field_id = ($cat_field->first() != null && isset($cat_field->first()->id)) ? $cat_field->first()->id : 0;
                if ($field == null) {
                    $field = AdvertiseField::create(['adv_id' => $id, 'name' => $name, 'value' => $value, 'field_id' => $field_id]);
                } else {
                    $field->update(['adv_id' => $id, 'name' => $name, 'value' => $value, 'field_id' => $field_id]);
                }
                $ids[] = $field->id;
            }
            AdvertiseField::where('adv_id', $id)->whereNotIn('id', $ids)->forceDelete();
        }

        return $adv;
    }
}
