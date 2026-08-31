<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCategory extends Model
{
    protected $table = 'plan_categories';
    protected $fillable = ['category_id', 'plan_type_id', 'plan_id', 'ads', 'unlimited'];

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = json_encode($value);
    }

    public function getCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function plantype()
    {
        return $this->hasOne(PlanType::class, 'id', 'plan_type_id');
    }

    public static function creator($data, $plan)
    {
        foreach ($data['category'] as $data) {
            $data['plan_id'] = $plan->id;
            $data['unlimited'] = (isset($category['unlimited']) && $category['unlimited']==1)?1:0;
            $data['plan_type_id'] = $plan->plan_type_id;
            PlanCategory::create($data);
        }
    }
    public static function dataupdate($data, $id)
    {
        if (count($data['category']) > 0) {
            $findCategory = PlanCategory::where('plan_id', $id)->get();
            if ($findCategory->count() > 0) {
                foreach ($findCategory as $delete) {
                    $delete->delete();
                }
            }
            foreach ($data['category'] as $category) {
                $category['plan_id'] = $id;
                $category['unlimited'] = (isset($category['unlimited']) && $category['unlimited']==1)?1:0;
                $category['plan_type_id'] = $data['plan_type_id'];
                $categories = PlanCategory::create($category);
            }
        }
    }
}
