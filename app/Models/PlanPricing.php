<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPricing extends Model
{
    use HasFactory;

    protected $table = 'plan_pricing';
    protected $fillable = ['plan_id', 'price', 'month'];
    public $timestamps = false;

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = json_encode($value);
    }

    public function getCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getPlanPrice()
    {
        return $this->belongsToMany(Plans::class, 'id', 'plan_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id', 'id');
    }

    public function plansForMonth($month)
    {
        return $this->belongsToMany(Plans::class, 'plan_pricing', 'plan_id', 'id')
                    ->where('month', $month); // Filters by month
    }

    public function setPromotionAttribute($value)
    {
        $this->attributes['promotion'] = json_encode($value);
    }

    public function getPromotionAttribute($value)
    {
        return json_decode($value, true);
    }
    public static function creator($data, $plan)
    {
        foreach ($data['plan'] as $month) {
            $month['plan_id'] = $plan->id;
            PlanPricing::create($month);
        }
    }
    public static function dataupdate($data, $id)
    {
        $find = PlanPricing::where('plan_id', $id)->get();
        if ($find->count() > 0) {
            foreach ($find as $delete) {
                $delete->delete();
            }
        }
        foreach ($data['plan'] as $plan) {
            $plan['plan_id'] = $id;
            PlanPricing::create($plan);
        }
    }
}
