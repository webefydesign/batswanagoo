<?php

use App\Model\State;
use App\Models\Advertise;
use App\Models\AdvertisePromo;
use App\Models\Clients;
use App\Models\News;
use App\Models\Blogs;
use App\Models\Testimonials;
use App\Models\Menu;
use App\Models\MenuItems;
use App\Models\Services;
use App\Models\Albums;
use App\Models\BodyTypes;
use App\Models\Brands;
use App\Models\Categories;
use App\Models\Category;
use App\Models\CategoryAdsCount;
use App\Models\Cities;
use App\Models\Configurations;
use App\Models\GroupModules;
use App\Models\Pages;
use App\Models\User;
use App\Models\Countries;
use App\Models\Currencies;
use App\Models\EmailChange;
use App\Models\FAQs;
use App\Models\Feedback;
use App\Models\FeedbackInvitation;
use App\Models\Make;
use App\Models\Media;
use App\Models\Performance;
use App\Models\PlanCategory;
use App\Models\Promote;
use App\Models\Safety;
use App\Models\SalonegooFAQs;
use App\Models\States;
use App\Models\UserPlan;
use App\Models\MakeModels;
use App\Models\AdvertiseChat;
use App\Models\AdvertiseChatMessages;
use Carbon\Carbon;
use App\Models\WalletTransactions;
use App\Models\BlogComments;
use Jenssegers\Agent\Agent;
use Carbon\CarbonPeriod;

function getClients() {
    return Clients::where('is_active', 1)->OrderBy('sort_order')->get();
}

function getTestimonials() {
    return Testimonials::where('is_active', 1)->OrderBy('sort_order')->get();
}

function getNews($limit=null) {
    if($limit!=null) {
        return News::where('is_active', 1)->OrderBy('id', 'DESC')->limit($limit)->get();
    } else {
        return News::where('is_active', 1)->OrderBy('id', 'DESC')->get();
    }
}

function getBlogs($limit=null) {
    if($limit!=null) {
        return Blogs::where('is_active', 1)->OrderBy('id', 'DESC')->limit($limit)->get();
    } else {
        return Blogs::where('is_active', 1)->OrderBy('id', 'DESC')->get();
    }
}

function getAlbums($limit=null) {
    if($limit!=null) {
        return Albums::where('is_active', 1)->OrderBy('id', 'DESC')->limit($limit)->get();
    } else {
        return Albums::where('is_active', 1)->OrderBy('id', 'DESC')->get();
    }
}

function getMenus() {
    return Menu::OrderBy('title')->get();
}

function primaryMenu() {
    $menu_id = Menu::where('is_primary', 1)->value('id');
    return MenuItems::where('menu_id', $menu_id)->whereNull('parent')->OrderBy('sort_order')->get();
}

function getMenuByID($id) {
	return Menu::with('items')->find($id);
}

function parentServices() {
    return Services::where('is_active', 1)->whereNull('parent_id')->OrderBy('sort_order')->get();
}

function getConfigurations() {
    return Configurations::find(1);
}

function pageChildrens($parent_id){
	return Pages::where('is_active',1)->where('parent_id', $parent_id)->get();
}

function relatedPage($page_id){
	$page = Pages::find($page_id);
    if(!empty($page)) {
        if($page->parent_id==null){
            return Pages::where('is_active',1)->where('parent_id', null)->where('id', '!=',$page->id)->get();
        }else{
            return Pages::where('is_active',1)->where('parent_id', $page->parent_id)->where('id', '!=',$page->id)->get();
        }
    }
    return [];
}

function siteModules() {
    return ['sliders' , 'categories', 'plans', 'promotions', 'currencies', 'faqs', 'sl_faqs', 'safeties', 'fields', 'ads', 'payments', 'reports', 'pages', 'blogs', 'clients', 'testimonials', 'users', 'redirections', 'menu', 'configuration', 'inbox', 'subscribers', 'chat-stickers'];
}

function check_access($user_id,$module,$access) {
	if(Auth::check()){
		$user = User::find($user_id);
		if($user['user_type']=='admin' && empty($user['group_id'])) { return true; }
		elseif($user['user_type']=='admin' && !empty($user['group_id'])) {
			$module = GroupModules::where('group_id',$user['group_id'])->where('module',$module)->first();
			if(!empty($module)) {
				return ($module[$access]==1)?true:false;
			} else { return false; }
		} else {
			return false;
		}
	}
}

function getCountries() {
    return Countries::where('status',1)->pluck('id', 'name');
}
function getAllCountries() {
    return Countries::pluck('id', 'name');
}

function getStates($country_id) {
    return States::where('status',1)->where('country_id',$country_id)->pluck('id', 'name');
}

function getCities($country_id, $state_id = NULL) {

    $cities = Cities::with('ads')->where('status',1)->where('country_id',$country_id);
    if($state_id != NULL){
        $cities = $cities->where('state_id',$state_id);
    }
    $cities = $cities->pluck('id', 'name');
    return $cities;
}

function checkUserPlan()
{
	if (auth()->check()) {
		$tmp = Carbon::now()->format('Y-m-d');

		$userPlan = UserPlan::where('user_id', auth()->user()->id)
							->where('paid',1)
							->where('expired', 0)
							->where('unsub', 0)
							->orderBy('created_at','desc')
							->first();
		if (isset($userPlan) && $userPlan->plan_expire_date >= $tmp) {
			return 1;
		} else {
			return 0;
		}
	}
}

function fetchCategories() {
    return Categories::where('is_active', 1)->where('parent_id', null)->get();
}

function categories($display = null, $limit = null, $main = null)
{
    $cates = Categories::where('is_active', 1)->with('childrens');
    if ($display == null) {
        $cates = $cates->where('parent_id', null);
    }else if ($display == 1) {
        $cates = $cates->where('display', 1);
    }
	if ($main == 1) {
        $cates = $cates->where('is_special', 1);
    }
    if ($limit != null) {
        $cates = $cates->take($limit);
    }
    $cates = $cates->orderBy('sort_order', 'ASC')->get();
    return $cates;
}

function checkPCat($id, $ids)
{
	$data = Categories::find($id);
	if(in_array($data->id, $ids)){
		return $data->id;
	}elseif($data->parent_id != null){
        $id = $data->parent_id;
		return checkPCat($id, $ids);
	}else{
		return null;
	}
}

function checkActivePlan($id)
{
    if (auth()->check()) {
        // ========================================
        // FIX: Get ALL active plans, not just one
        // ========================================
        $userPlans = UserPlan::where('user_id', auth()->user()->id)
            ->where('paid', 1)
            ->where('expired', 0)
            ->where('unsub', 0)
            ->orderBy('created_at', 'desc')
            ->get(); // Changed from first() to get()

        $tmp = Carbon::now()->format('Y-m-d');

        // Filter plans that haven't expired
        $activePlans = $userPlans->filter(function($plan) use ($tmp) {
            return $plan->plan_expire_date > $tmp;
        });

        // If no active plans found
        if ($activePlans->isEmpty() || $id == null) {
            return 3; // Plan expired
        }

        // Check if category exists in ANY active plan
        $planCat = null;
        $relevantPlan = null;
        
        foreach ($activePlans as $plan) {
            $planCat = PlanCategory::where('plan_id', $plan->plan_id)
                ->where('category_id', $id)
                ->first();
            
            if ($planCat) {
                $relevantPlan = $plan;
                break; // Found a plan with this category
            }
        }

        // Category not found in any active plan
        if (!$planCat) {
            return 2; // Not have access
        }

        // Count ads in this category
        $adsCount = Advertise::where('user_id', auth()->user()->id)
            ->whereIn('category_id', allChildCategoryIds($id))
            ->count();

        // Check limits
        if ($planCat->unlimited == 1) {
            return 4; // Unlimited
        } elseif ($planCat->ads > $adsCount) {
            $count = ['remaining' => $planCat->ads - $adsCount, 'outOF' => $planCat->ads];
            return $count; // Plan has remaining ads
        } else {
            return 1; // Plan limit reached
        }
    }
    
    return 3; // Not authenticated
}

function getPlanCategory($plans)
{
    $ids = collect($plans)->pluck('id')->toArray();

	return PlanCategory::whereIn('plan_id', $ids)
		->with('category')->get()->groupBy('category_id')->toArray();
}

function getMakes()
{
	return Make::orderBy('name', 'ASC')->where('is_active', 1)->get();
}

function getBodyTypes()
{
	return BodyTypes::orderBy('name', 'ASC')->where('is_active', 1)->get();
}

function baseSymbol()
{
    $default = Currencies::where('is_default', 1)->first();
	return $default['symbol'];
}

function allChildCategoryIds($ids, $cids = [])
{
	if (is_array($ids)) {
		foreach ($ids as $id) {
			$cids[] = (int)$id;
			$cates = Categories::find($id);
			if ($cates != null && count($cates->childrens) > 0) {
				$iids = $cates->childrens->pluck('id')->toArray();
				$cids = allChildCategoryIds($iids, $cids);
			}
		}
	} else {
		$cates = Categories::find($ids);
		if (count($cates->childrens) > 0) {
			$iids = $cates->childrens->pluck('id')->toArray();
			$cids = allChildCategoryIds($iids, $cids);
		}
	}
	return array_unique($cids);
}

function adsCount($id = null)
{
	if ($id == null) {
		$cates = Categories::all();
		foreach ($cates as $cat) {
			$ca = CategoryAdsCount::where('category_id', $cat->id)->first();
			if ($ca == null) {
				$ids = allChildCategoryIds($cat->id);
				$counts = Advertise::whereIn('category_id', $ids)->where('status', '!=', 'sold')->count();
				$cate = CategoryAdsCount::create(['category_id' => $cat->id, 'advertise' => $counts]);
			} else {
				$cate = CategoryAdsCount::find($cat->id);
				$ids = allChildCategoryIds($cat->id);
				$counts = Advertise::whereIn('category_id', $ids)->where('status', '!=', 'sold')->count();
				$cate->update(['category_id' => $cat->id, 'advertise' => $counts]);
			}
		}
	} else {
		$cat = Categories::find($id);
		$ca = CategoryAdsCount::where('category_id', $cat->id)->first();
		if ($ca == null) {
			$ids = allChildCategoryIds($cat->id);
			$counts = Advertise::whereIn('category_id', $ids)->where('status', '!=', 'sold')->count();
			$cate = CategoryAdsCount::create(['category_id' => $cat->id, 'adverties' => $counts]);
		} else {
			$cate = CategoryAdsCount::where('category_id', $cat->id)->first();
			$ids = allChildCategoryIds($cat->id);
			$counts = Advertise::whereIn('category_id', $ids)->where('status', '!=', 'sold')->count();
			$cate->update(['category_id' => $cat->id, 'adverties' => $counts]);
		}
	}
}
function allPromotes(){
	return Promote::where('is_active', 1)->get();
}
function allSliders()
{
	$sliders = Media::where('type', 'slider')->get();
	return $sliders;
}
function categoriesById($ids)
{
	return Categories::with('faqs')->whereIn('id', $ids)->where('is_active', 1)->OrderBy('sort_order', 'ASC')->get();
}
function fetchCountryName($country_id){
    return Countries::find($country_id)->name;
}
function fetchStateName($state_id){
    return States::find($state_id)->name;
}
function fetchCityName($city_id){
    return Cities::find($city_id)->name;
}
function fetchCountryId($country_name){
    return Countries::where('name',$country_name)->first()->id;
}
function fetchStateId($state_id){
    return States::where('name',$state_id)->first()->id;
}
function fetchCityId($city_id){
    return Cities::where('name',$city_id)->first()->id;
}
function country($id)
{
	$country = Countries::find($id);
	return $country;
}
function productsByCategoryId($ids, $limit = 12)
{
	$ids = allChildCategoryIds($ids);
	$ads = Advertise::where('status', 'active')
		->with(['gallery', 'category'])
		->whereIn('category_id', $ids)->limit($limit)->get();
	return $ads;
}
function productsByPromoId($id, $limit = 12)
{
	$ad_ids = AdvertisePromo::where('promotion_id', $id)->where('paid', 1)->where('expire', 0)
		->where('start', '<=', date('Y-m-d H:i:s'))->where('end', '>=', date('Y-m-d H:i:s'))
		->pluck('adv_id')->toArray();

	return Advertise::whereIn('id', $ad_ids)->where('status', 'active')->with('gallery', 'category')->limit($limit)->get();
}

function getSlider($id)
{
	$data = Media::find($id);
	if (!empty($data)) {
		return json_decode($data['meta'], true);
	}
	return [];
}
function liveAds()
{
	return Advertise::where('status', 'active')->count();
}
function allChildCount($child, $i = 0)
{
	$i = $child->products->count();
	if (count($child->childrens) > 0) {
		foreach ($child->childrens as $child) {
			$i += allChildCount($child, $i);
		}
	}
	return $i;
}

function adsInLocation($name, $field, $categoryId = null)
{
    $query = Advertise::where('status', 'active');
    
    if ($categoryId !== null) {
        $categoryIds = allChildCategoryIds([$categoryId]);
        $query->whereIn('category_id', $categoryIds);
    }
    
    // Filter by location
    $query->where($field, $name);
    
    return $query->count();
}

function onlyParents($category, $parents = [])
{
	if ($category->parent == null) {
		return $parents;
	} else {
		$parents[] = $category->parent;
		return onlyParents($category->parent, $parents);
	}
}

function performance($id, $array = [])
{
	$date = Carbon::now()->format('Y-m-d');
	$check = Performance::where('user_id', $id)->where('date', $date)->first();
	if ($check) {
		if (in_array('impression', $array)) {
			$check->impression += 1;
		}
		if (in_array('visitor', $array)) {
			$agent = new Agent();
			if ($agent->isMobile()) {
				$check->phone_view += 1;
			} else {
				$check->visitor += 1;
			}
		}
		if (in_array('chat_request', $array)) {
			$check->chat_request += 1;
		}
		$check->update();
		return 1;
	} else {
		$create = new Performance();
		$create->user_id = $id;
		if (in_array('impression', $array)) {
			$create->impression = 1;
		}
		if (in_array('visitor', $array)) {
			$agent = new Agent();
			if ($agent->isMobile()) {
				$create->phone_view = 1;
			} else {
				$create->visitor = 1;
			}
		}
		if (in_array('chat_request', $array)) {
			$create->chat_request = 1;
		}
		$create->date = $date;
		$create->save();
		return 1;
	}
}

function sendWebNotification($send)
{

	$url = 'https://fcm.googleapis.com/fcm/send';
	$FcmToken = User::find($send['user_id']);
	if ($FcmToken->device_key == null) {
		$FcmToken->update(['device_key' => request()->_token]);
	}


	$data['title'] = $send['title'];
	$data['body'] = $send['msg'];

	$serverKey = 'AAAA5mQdXc0:APA91bH-N10TvQShcT3Xo5lT79u9zxTVy43hwCjxASyQheOSDalzM3HsBeAx1apBNV548Bm-Iqt8gz7IzcPTyc9LTz4aNIMCZBTUzm6aaydNln12RLPAZHaWEd4zmbVR9KgpQeb6mFxH';

	$data = [
		"registration_ids" => [$FcmToken->device_key],
		"notification" => [
			"title" => $data['title'],
			"body" => $data['body'],
		]
	];
	$encodedData = json_encode($data);

	$headers = [
		'Authorization:key=' . $serverKey,
		'Content-Type: application/json',
	];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
	// Execute post
	$result = curl_exec($ch);
	// if ($result === FALSE) {
	// 	die('Curl failed: ' . curl_error($ch));
	// }
	// Close connection
	curl_close($ch);
	// FCM response
	dd($result);
}

function feedbackPermission($seller)
{
	if (auth()->check() && auth()->user()->id != $seller->id) {
		$inv = FeedbackInvitation::where('email', auth()->user()->email)
			->where('seller_id', $seller->id)->first();
		if ($inv != null) {
			$fe = Feedback::where('user_id', auth()->user()->id)->where('seller_id', $seller->id)->first();
			if ($fe == null) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	return false;
}

function allBrandPage($page){
	return User::where('name', 'LIKE', $page.'%')
                ->where('is_active', 1)
                ->where('is_verified', 1)
		        ->where('user_type', 'customer')
		        ->where('slug', '!=', null)
                ->get();
}

function checkAnyUserPlan($id)
{
	$tmp = Carbon::now()->format('Y-m-d');
	$userPlan = UserPlan::where('user_id', $id)
						->where('paid',1)
						->where('expired', 0)
						->where('unsub', 0)
						->first();
	if (isset($userPlan) && $userPlan->plan_expire_date > $tmp) {
		return 1;
	} else {
		return 0;
	}
	// if (auth()->check()) {
	// }
}

function formatPrice($price, $formate = 1, $curr = 1)
{
	$default = Currencies::where('is_default', 1)->first();
	if (!empty(session()->get('currency')) && session()->get('currency') != $default['id']) {
		$currency = Currencies::find(session()->get('currency'));
		$temp_price = round($price / $currency['rate'], 2);
		if ($formate == 0) {
			return $temp_price;
		}
		$price = number_format($temp_price, $currency['decimal_places'], $currency['decimal_token'], $currency['thousan_token']);
	} else {
		$currency = $default;
		if ($formate == 0) {
			return $price;
		}
		$price = number_format($price, $currency['decimal_places'], $currency['decimal_token'], $currency['thousan_token']);
	}
	if ($curr == 1) {
		$price = ($default['symbol_place'] == 'left') ? $default['symbol'] . $price : $price . $default['symbol'];
	}
	return $price;
}

function getSafety(){
    return Safety::where('is_active',1)->get();
}

function getSafetiesById($id){
    return Safety::whereIn('id',$id)->get();
}

function getCategory($id)
{
	return Categories::find($id);
}

function getFaqs(){
    return FAQs::where('is_active',1)->get();
}

function getBrand(){
    return Brands::where('is_active',1)->get();
}

function brandsById($ids)
{
	return Brands::whereIn('id', $ids)->where('is_active', 1)->OrderBy('sort_order', 'ASC')->get();
}

function getCurrency()
{
	$default = Currencies::where('is_default', 1)->first();
	if (!empty(session()->get('currency')) && session()->get('currency') != $default['id']) {
		return Currencies::find(session()->get('currency'));
	} else {
		return Currencies::where('is_default', 1)->first();
	}
}

function getStatesByCountryName($name)
{
	$country = Countries::where('name', $name)->first();
	return States::where('country_id', ($country->id)??0)->get();
}

function getCitiesByStateName($name, $country = null)
{
	$country = Countries::where('name', $country)->first();
	$state = States::where('name', $name)->where('country_id', ($country->id)??0)->first();
	if ($country == null) {
		return Cities::where('state_id', ($state->id)??0)->get();
	} else if($state == null) {
		return Cities::where('country_id', ($country->id)??0)->get();
	}else {
		return Cities::where('state_id', $state->id)->where('country_id', ($country->id)??0)->get();
	}
}

function generateSitemap($slugs, $page)
{
	$url = Configurations::find(1)->sitemap_url;
	$url = ($url !== null) ? $url : url('/');
	if (substr($url, -1) != '/') {
		$url .= '/';
	}
	$url .= ($page != '' || $page != null) ? $page . '/' : $page;
	Header('Content-type: text/xml');
	$xml = new SimpleXMLElement('<urlset/>');
	$xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
	$urls = $xml->addChild('url');
	$urls->addChild('loc', $url);
	$urls->addChild('lastmod', date('c'));
	$urls->addChild('changefreq', "daily");
	foreach ($slugs as $key => $value) {
		$urls = $xml->addChild('url');
		$urls->addChild('loc', htmlentities($url . $value));
		$urls->addChild('lastmod', date('c', strtotime($key)));
		$urls->addChild('changefreq', "daily");
	}
	print $xml->asXML();
}

function resetEmail()
{
	$check = EmailChange::where('user_id', auth()->user()->id)->where('status', 'pending')->first();
	if ($check) {
		$time = Carbon::now()->diffInSeconds($check->expire);
		$minOnly = gmdate("i", $time);
		if ($check->expire > Carbon::now()) {
			$pending['time'] = gmdate("i:s", $time);
		} else {
			$pending['time'] = 0;
		}
		$pending['pending'] = "pending";
		return $pending;
	} else {
		$pending['time'] = 0;
		$pending['pending'] = "Done";
		return $pending;
	}
}

function planData()
{
	if (auth()->check()) {

		$data = UserPlan::with('plan.planType')->where('user_id', auth()->user()->id)->where('paid',1)->where('expired', 0)->where('unsub', 0)->orderBy('created_at','desc')->first();

		$tmp = (new DateTime)->format('Y-m-d');

		if (isset($data) && $data->plan_expire_date > $tmp) {
			return $data;
		}else{
			return null;
		}

	}else{
		return null;
	}
}

function getFaqPosts($search = null)
{
    // return Categories::where('is_active', 1)
    // ->whereHas('faqs', function ($query) use ($search) {
    //     $query->where('is_active',1)->where('title', 'like', '%' . $search . '%');
    // })
    // ->with(['faqs' => function ($query) use ($search) {
    //     $query->where('is_active',1)->where('title', 'like', '%' . $search . '%');
    // }])
    // ->get();

    return SalonegooFAQs::where('is_active',1)
                        ->where('title', 'like', '%' . $search . '%')
                        ->get()
                        ->groupBy('category_name');
}

function getSalonegooFaqs(){
    return SalonegooFAQs::where('is_active',1)->get();
}

function adsStatus($status)
{
	if ($status == 'active') {
		return Advertise::where('status', 'active')->count();
	} elseif ($status == 'pending') {
		return Advertise::where('status', 'pending')->count();
	} elseif ($status == 'promotion') {
		return AdvertisePromo::where('paid', 1)->where('expire', 0)
			->where('start', '<=', date('Y-m-d H:i:s'))->where('end', '>=', date('Y-m-d H:i:s'))
			->pluck('adv_id')->unique()->count();
	} elseif ($status == 'seller') {
		return User::where('user_type', 'customer')->count();
	} elseif ($status == 'today_trans') {
		return AdvertisePromo::where('paid', 1)->where('expire', 0)->whereDate('start_date', date('Y-m-d'))
			->selectRaw('id, convertCurrency(advertises_promotions.id) as cprice')->get()
			->sum('cprice');
	} elseif ($status == 'total_trans') {
		return AdvertisePromo::where('paid', 1)
			->selectRaw('id, convertCurrency(advertises_promotions.id) as cprice')->get()
			->sum('cprice');
	} elseif ($status == 'monthly_trans') {
		$adv = AdvertisePromo::where('paid', 1)
			->whereRaw('MONTH(start_date) = ' . date('m'))
			->selectRaw('id, convertCurrency(advertises_promotions.id) as cprice')->get()
			->sum('cprice');
		// ->get();
		return $adv;
	}
}

function getModels($name)
{
	$make = Make::where('name', $name)->where('is_active', 1)->first();
	return MakeModels::where('make_id', $make->id)->where('is_active', 1)->orderBy('name', 'ASC')->get();
}

function dateDiff($sd, $ed)
{
	$dates = CarbonPeriod::create(date('Y-m-d', strtotime($sd)), date('Y-m-d', strtotime($ed)));
	return count($dates) - 1;
}

function generateUrl($category_id, $type = 'category', $ad_url = NULL){

    $category = Categories::with('parent','page')->find($category_id);

    if($type === 'page'){
        if(isset($category->page)){
            $url = $category->page->slug;
        }else{
            $url = 'categories';
            if ($category->parent != null) {
                $url .= Categories::moreParent($category->parent, $url);
            }
            $url .= '/' . $category->slug;
            if($ad_url != NULL){
                $url .= '/'.$ad_url;
            }
        }
    }else{
        $url = 'categories';
        if ($category && $category->parent != null) {
            $url .= Categories::moreParent($category->parent, $url);
        }
        if ($category) {
			$url .= '/' . $category->slug;
			if ($ad_url !== NULL) {
				$url .= '/' . $ad_url;
			}
		}
    }

    
    return $url;
}

function categoryParents($id, $ids=[]){
	$ids[] = $id*1;
	$cat = Categories::find($id);
	if($cat->parent == null){
		return $ids;
	}else{
		return categoryParents($cat->parent->id, $ids);
	}
}

function getLikeCategories($like){
	$cats = categoryParents($like);
	$cats = array_reverse($cats);
	return Categories::whereIn('id',$cats)->orderBy('id')->get();
}

function getLikeAds($like){
	return Advertise::find($like);
}


function getUnreadChatCount(){
    $userId = auth()->id();
    
    // Get all chat IDs where the current user is a participant
	$adIds = auth()->user()->activeAds->pluck('id')->toArray();
    $userChatIds = AdvertiseChat::where(function($query) use ($userId, $adIds) {
        $query->where('user_id', $userId)
              ->orWhereIn('ad_id', $adIds);
    })->pluck('id')->toArray();
    
    // Count unread messages in those chats that are NOT sent by the current user
    $unreadChatCount = AdvertiseChatMessages::whereIn('advertise_chat_id', $userChatIds)
        ->where('user_id', '!=', $userId)
        ->where('unread', 1)
        ->count();
    
    return $unreadChatCount;
}

function pendingPaymentsCount()
{
    return WalletTransactions::where('payment_status', 'pending')->count();
}

function getWalletSettings()
{
    return Configurations::find(1)->wallet_meta;
}

function profileCompletionPercentage($user = null)
{
	if (!$user) {
		$user = auth()->user();
	}

	if (!$user) {
		return 0;
	}

	$fields = [
		$user->name,
		$user->email,
		$user->phone,
		$user->state,
		$user->city,
		$user->image,
		$user->gender,
		$user->dob,
		$user->address,
	];

	$completed = collect($fields)
		->filter(fn ($value) => !empty($value))

		->count();

	return round(($completed / count($fields)) * 100);
}

function pendingCommentCounts() {
	return BlogComments::where('is_active', 0)->count();
}

function iph() {
	return 'https://placehold.co/600x400';
}