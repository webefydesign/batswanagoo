<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    protected $table = 'plans';
    protected $fillable = ['name', 'slug', 'plan_type_id', 'icon', 'points', 'sms', 'media_links', 'dedicated_link', 'is_active'];

    public function setPointsAttribute($value)
    {
        $this->attributes['points'] = json_encode($value);
    }

    public function getPointsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getPlanPrice()
    {
        return $this->hasMany(PlanPricing::class, 'plan_id', 'id')->orderBy('month', "ASC");
    }

    public function getPlanPromotion()
    {
        return $this->hasMany(PlanPromotion::class, 'plan_id', 'id');
    }
    public function getPlanCategory()
    {
        return $this->hasMany(PlanCategory::class, 'plan_id', 'id');
    }
    public function planType()
    {
        return $this->hasOne(PlanType::class, 'id', 'plan_type_id');
    }
}
