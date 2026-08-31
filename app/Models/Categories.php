<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
	protected $fillable = ['name', 'slug', 'image', 'icon_image', 'parent_id', 'is_active', 'is_special', 'display', 'sort_order', 'schema_code', 'seo_meta', 'meta_title', 'meta_description', 'link_canonicals'];

    public function parent()
	{
		return $this->hasOne(Categories::class, 'id', 'parent_id');
	}

	public function childrens()
	{
		return $this->hasMany($this, 'parent_id');
	}

    public function fields()
	{
		return $this->hasMany(CategoryFields::class, 'category_id')->orderBy('sort_order', 'ASC');
	}

    public function products()
	{
		return $this->hasMany(Advertise::class, 'category_id')->where('status', 'active');
	}

	public function filteredProducts()
	{
		if ($this->parent_id === null) {
			// Get child category IDs
			$childCategoryIds = $this->childrens()->pluck('id');

			// Fetch products of child categories
			return Advertise::whereIn('category_id', $childCategoryIds)
				->where('status', 'active');
		} else {
			// For child category, return related products
			return $this->products()
				->where('status', 'active');
		}
	}

    public function faqs()
	{
		return $this->hasMany(FAQs::class, 'category_id')->where('is_active', 1);
	}

    public static function moreParent($parent, $parent_slug)
	{
		$parent_slug = '/' . $parent->getAttributes()['slug'];
		if ($parent->parent != null) {
			$parent_slug .= Categories::moreParent($parent->parent, $parent_slug);
		}
		return $parent_slug;
	}

    public function getSlugAttribute($slug)
	{
		// $parent_slug = 'categories';
		// if ($this->parent != null) {
		// 	$parent_slug .= Categories::moreParent($this->parent, $parent_slug);
		// }
		// return $parent_slug . '/' . $slug;
		return $slug;
	}

	public function getSlug($slug)
	{
		$parent_slug = 'categories';
		if ($this->parent != null) {
			$parent_slug .= Categories::moreParent($this->parent, $parent_slug);
		}
		return $parent_slug . '/' . $slug;
	}

    public function getRootParentAttribute()
    {
        $category = $this;
        while ($category->parent) {
            $category = $category->parent;
        }
        return $category;
    }

	public function setSeoMetaAttribute($value)
    {
    	$this->attributes['seo_meta'] = json_encode($value);
    }

    public function getSeoMetaAttribute($value)
    {
    	return json_decode($value, true);
    }

	public function setLinkCanonicalsAttribute($value)
    {
    	$this->attributes['link_canonicals'] = json_encode($value);
    }

    public function getLinkCanonicalsAttribute($value)
    {
    	return json_decode($value);
    }

	public function page()
	{
		return $this->hasOne(Pages::class, 'category_id');
	}

	public function getBreadcrumbsAttribute()
	{
		$breadcrumbs = [];
		$current = $this;
		
		while ($current) {
			array_unshift($breadcrumbs, $current);
			$current = $current->parent;
		}
		
		return $breadcrumbs;
	}


	public static function getUserCategories()
	{
		if (!auth()->check()) {
			return collect([]);
		}

		$userPlans = UserPlan::where('user_id', auth()->user()->id)
			->where('paid', 1)
			->where('expired', 0)
			->where('unsub', 0)
			->get(); // ✅ Get ALL plans

		if ($userPlans->isEmpty()) {
			return collect([]);
		}

		$userPlanIds = $userPlans->pluck('plan_id')->toArray();

		$categoryIds = PlanCategory::whereIn('plan_id', $userPlanIds)
			->pluck('category_id')
			->unique()
			->toArray();

		return self::whereIn('id', $categoryIds)
			->with('childrens')
			->orderBy('sort_order', 'ASC')
			->get();
	}

	/**
	 * Get FIRST main category from user's plans
	 */
	public static function getUserFirstMainCategory()
	{
		$userPlans = UserPlan::where('user_id', auth()->user()->id)
			->where('paid', 1)
			->where('expired', 0)
			->where('unsub', 0)
			->with('plan.planType')
			->get();

		if ($userPlans->isEmpty()) {
			return null;
		}

		$planTypeIds = $userPlans->pluck('plan.planType.id')
			->unique()
			->toArray();

		$categoryIds = PlanTypeCategory::whereIn('plan_type_id', $planTypeIds)
			->pluck('category_id')
			->unique()
			->toArray();

		return self::whereIn('id', $categoryIds)
			->where('parent_id', null)      // ✅ Main only
			->where('is_special', 1)        // ✅ Featured
			->where('is_active', 1)
			->with('childrens')
			->orderBy('sort_order', 'ASC')
			->first();
	}

	/**
	 * Category ids covered by any of the authenticated user's active,
	 * paid plans (plan_categories rows target the sub-categories directly
	 * beneath a main/root category, never the root itself).
	 */
	public static function getUserPlanCategoryIds()
	{
		if (!auth()->check()) {
			return [];
		}

		$userPlanIds = UserPlan::where('user_id', auth()->user()->id)
			->where('paid', 1)
			->where('expired', 0)
			->where('unsub', 0)
			->pluck('plan_id')
			->toArray();

		return PlanCategory::whereIn('plan_id', $userPlanIds)
			->pluck('category_id')
			->unique()
			->toArray();
	}

	/**
	 * Get FIRST main category for a specific plan type, scoped to the
	 * authenticated user's active plans (so a user can't request a
	 * category belonging to a plan type they haven't purchased).
	 */
	public static function getMainCategoryByPlanType($planTypeId)
	{
		$ownsPlanType = UserPlan::where('user_id', auth()->user()->id)
			->where('paid', 1)
			->where('expired', 0)
			->where('unsub', 0)
			->where('plan_type', $planTypeId)
			->exists();

		if (!$ownsPlanType) {
			return null;
		}

		$categoryIds = PlanTypeCategory::where('plan_type_id', $planTypeId)
			->pluck('category_id')
			->unique()
			->toArray();

		return self::whereIn('id', $categoryIds)
			->where('parent_id', null)      // ✅ Main only
			->where('is_special', 1)        // ✅ Featured
			->where('is_active', 1)
			->with('childrens')
			->orderBy('sort_order', 'ASC')
			->first();
	}

	/**
	 * Get ALL main categories from user's plans
	 */
	public static function getUserMainCategories()
	{
		$userPlans = UserPlan::where('user_id', auth()->user()->id)
			->where('paid', 1)
			->where('expired', 0)
			->where('unsub', 0)
			->with('plan.planType')
			->get();

		if ($userPlans->isEmpty()) {
			return null;
		}

		$planTypeIds = $userPlans->pluck('plan.planType.id')
			->unique()
			->toArray();

		$categoryIds = PlanTypeCategory::whereIn('plan_type_id', $planTypeIds)
			->pluck('category_id')
			->unique()
			->toArray();

		return self::whereIn('id', $categoryIds)
			->where('parent_id', null)      // ✅ Main only
			->where('is_special', 1)        // ✅ Featured
			->where('is_active', 1)
			->with('childrens')
			->orderBy('sort_order', 'ASC')
			->get();
	}
}
