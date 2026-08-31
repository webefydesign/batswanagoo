<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use HasFactory;

    protected $table = 'plan_type';
    protected $fillable = ['name', 'color', 'image', 'points', 'is_active', 'slug'];
    protected $dates = ['deleted_at'];

    public function planTypeCategory()
    {
        return $this->hasMany(PlanTypeCategory::class, 'plan_type_id', 'id');
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, 'category', 'id');
    }

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
        return $this->hasMany(PlanPricing::class, 'plan_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(PlanTypeCategory::class, 'plan_type_id', 'id');
    }

    /**
     * The distinct plan types the authenticated user has an active, paid
     * plan for, each paired with its main category (used to drive the
     * "You are now posting in" selector - the selector shows the plan type
     * the user purchased, while the category id underneath still powers the
     * existing category/sub-category lookup).
     */
    public static function getUserPurchasedTypes()
    {
        if (!auth()->check()) {
            return collect([]);
        }

        $userPlans = UserPlan::where('user_id', auth()->user()->id)
            ->where('paid', 1)
            ->where('expired', 0)
            ->where('unsub', 0)
            ->with('plan.planType.planTypeCategory')
            ->get();

        return $userPlans->pluck('plan.planType')
            ->filter()
            ->unique('id')
            ->map(function ($planType) {
                $categoryIds = $planType->planTypeCategory->pluck('category_id');

                $category = Categories::whereIn('id', $categoryIds)
                    ->where('parent_id', null)      // Main only
                    ->where('is_special', 1)        // Featured
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->first();

                return (object) [
                    'id' => $planType->id,
                    'name' => $planType->name,
                    'category' => $category,
                ];
            })
            ->filter(fn ($item) => $item->category !== null)
            ->values();
    }
}
