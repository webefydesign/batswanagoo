<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\AdvertiseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pages;
use App\Models\PageComponents;
use App\Models\News;
use App\Models\NewsCategories;
use App\Models\Events;
use App\Models\EventCategories;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\Services;
use App\Models\ContactMails;
use App\Models\Subscribers;
use App\Models\Albums;
use App\Models\BlogCategoryRelation;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\AdvertiseAvailability;
use Session;
use Mail;

use DB;
use App\Models\BodyTypes;
use App\Models\Brands;
use App\Models\Career;
use App\Models\Make;
use App\Models\MakeModels;
use App\Models\Fields;
use App\Models\Categories;
use App\Models\CategoryFields;
use App\Models\PlanType;
use App\Models\PlanTypeCategory;
use App\Models\Plans;
use App\Models\PlanPricing;
use App\Models\PlanCategory;
use App\Models\Posts;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Notifications;
use App\Models\BlogComments;
use Carbon\Carbon;

use Laravel\Socialite\Facades\Socialite;
use Auth;
use Str;

class HomeController extends Controller
{
    public function index()
    {
        /* $data = DB::connection('test_db')->table('plans')->get();
        dd($data);
        foreach($data as $k => $v) {
            $c_name = DB::connection('test_db')->table('categories')->where('id', $v->category_id)->value('name');
            $category_id = Categories::where('name', $c_name)->value('id');

            $t_name = DB::connection('test_db')->table('plan_type')->where('id', $v->plan_type_id)->value('name');
            $type_id = PlanType::where('name', $t_name)->value('id');

            dd($c_name, $category_id, $t_name, $type_id);
            PlanTypeCategory::create([
                'plan_type_id'=>$type_id,
                'category_id'=>$category_id
            ]);
        }
        dd('success');*/
        $data = Pages::where('is_home',1)->first();
        $components = PageComponents::where('page_id',$data['id'])->OrderBy('sort_order','ASC')->get();
        // return view('frontend.page', compact('data','components'));
        return view('frontend.page',['data'=>$data,'components'=>$components]);
    }

    public function page($slug, $sub=null)
    {
        /* Service */
        $service = Services::where('slug', $slug)->where('is_active', 1)->first();
        if($service) {
            if ($service->childrens->where('is_active', 1)->count() > 0) {
                $childrens = $service->childrens->where('is_active', 1);
            } else {
                $s = Services::where('id', $service->parent_id)->where('is_active',1)->first();
	            $childrens = $s->childrens->where('id', '!=', $service->id);
            }
            $others = Services::whereNull('parent_id')->where('is_active', 1)->where('id', '!=', $service['id'])->get();
            $sidebar = [];
            if(isset(getConfigurations()['sidebar_meta']['on_service']) && getConfigurations()['sidebar_meta']['on_service']==1) {
                $sidebar = getConfigurations()['sidebar_meta']['service'];
            }
            return view('frontend.service', ['data'=>$service, 'childrens'=>$childrens, 'others'=> $others, 'sidebar'=>$sidebar]);
        }
        /* Page */
        // $page = Pages::where('slug',$slug)->where('parent_id', null)->first();
        $page = Pages::where('slug',$slug)->first();
        if($page) {
            $sub_page=null;
            if($sub!==null){
                $sub_page = Pages::where('slug',$sub)->where('is_active', 1)->where('parent_id', ($page->id)??0)->first();
                $page=null;
            }
            $components = PageComponents::where('page_id',$page['id'])->OrderBy('sort_order','ASC')->get();
            return view('frontend.page',['data'=>$page,'components'=>$components]);
        }
        abort(404);
    }

    public function news(Request $request)
    {
        if($request->has('category')) {
            $categoryId = $request->category;
            $data = News::where('is_active', 1)->whereHas('newsCategoryRelations', function ($query) use ($categoryId) {
                        $query->where('category_id', $categoryId);
                    })->orderBy('id', 'DESC')->paginate(10);
        } else {
            $data = News::where('is_active', 1)->OrderBy('id', 'DESC')->paginate(10);
        }
        $categories = NewsCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        $sidebar = [];
        if(isset(getConfigurations()['sidebar_meta']['on_news']) && getConfigurations()['sidebar_meta']['on_news']==1) {
            $sidebar = getConfigurations()['sidebar_meta']['news'];
        }
        $seo = getConfigurations()['news_seo']??[];
        return view('frontend.news', compact('data', 'categories', 'sidebar', 'seo'));
    }

    public function news_detail($slug)
    {
        $data = News::where('is_active', 1)->where('slug', $slug)->first();
        $categories = NewsCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        $recents = [];
        if(!empty($data)) {
            $recents = News::where('id', '!=', $data['id'])->where('is_active', 1)->OrderBy('id', 'DESC')->limit(4)->get();
        }
        $sidebar = [];
        if(isset(getConfigurations()['sidebar_meta']['on_news']) && getConfigurations()['sidebar_meta']['on_news']==1) {
            $sidebar = getConfigurations()['sidebar_meta']['news'];
        }
        return view('frontend.news_detail', compact('data', 'categories', 'recents', 'sidebar'));
    }

    public function blogs(Request $request)
    {
        if($request->has('category')) {
            $categoryId = $request->category;
            $posts = Blogs::where('is_active', 1)->whereHas('blogCategoryRelations', function ($query) use ($categoryId) {
                        $query->where('category_id', $categoryId);
                    })->orderBy('id', 'DESC')->paginate(10);
        } else {
            $posts = Blogs::where('is_active', 1)->OrderBy('id', 'DESC')->paginate(10);
        }
        $categories = BlogCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        // $sidebar = [];
        // if(isset(getConfigurations()['sidebar_meta']['on_blogs']) && getConfigurations()['sidebar_meta']['on_blogs']==1) {
        //     $sidebar = getConfigurations()['sidebar_meta']['blogs'];
        // }
        $seo = getConfigurations()['blogs_seo']??[];
        return view('frontend.blogs', compact('posts', 'categories', 'seo'));
    }

    public function blog_detail($slug)
    {
        // $data = Blogs::where('is_active', 1)->where('slug', $slug)->first();
        // $categories = BlogCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        // $recents = [];
        // if(!empty($data)) {
        //     $recents = Blogs::where('id', '!=', $data['id'])->where('is_active', 1)->OrderBy('id', 'DESC')->limit(4)->get();
        // }
        // $sidebar = [];
        // if(isset(getConfigurations()['sidebar_meta']['on_blogs']) && getConfigurations()['sidebar_meta']['on_blogs']==1) {
        //     $sidebar = getConfigurations()['sidebar_meta']['blogs'];
        // }
        // return view('frontend.blog_detail', compact('data', 'categories', 'recents', 'sidebar'));

        if ($slug == 'sitemap.xml') {
            $blog = Blogs::pluck('slug', 'updated_at')->toArray();
            return generateSitemap($blog, 'event');
        }
        $data = Blogs::where('slug', $slug)->first();
        if (empty($data)) {
            return abort(404);
        }
        if ($data) {
            $data->update(['views' => (int)$data['views'] + 1]);
        }
        $posts = Blogs::with('categories')->where('is_active', 1)->OrderBy('id', 'DESC')->paginate(6);
        $categories = BlogCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        $cat_ids = BlogCategoryRelation::where('blog_id', $data['id'])->pluck('category_id')->toArray();
        $blog_ids = BlogCategoryRelation::whereIn('category_id', $cat_ids)->pluck('blog_id')->toArray();
        $related = Blogs::with('categories')->where('is_active', 1)->whereIn('id', $blog_ids)->where('id', '!=', $data['id'])->OrderBy('id', 'DESC')->limit(4)->get();
        return view('frontend.blog_detail', ['data' => $data, 'categories' => $categories, 'related' => $related, 'posts' => $posts]);
    }

    public function events(Request $request)
    {
        if($request->has('category')) {
            $categoryId = $request->category;
            $data = Events::where('is_active', 1)->whereHas('eventCategoryRelations', function ($query) use ($categoryId) {
                        $query->where('category_id', $categoryId);
                    })->orderBy('id', 'DESC')->paginate(10);
        } else {
            $data = Events::where('is_active', 1)->OrderBy('id', 'DESC')->paginate(10);
        }
        $categories = EventCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        $sidebar = [];
        if(isset(getConfigurations()['sidebar_meta']['on_events']) && getConfigurations()['sidebar_meta']['on_events']==1) {
            $sidebar = getConfigurations()['sidebar_meta']['events'];
        }
        $seo = getConfigurations()['events_seo']??[];
        return view('frontend.events', compact('data', 'categories', 'sidebar', 'seo'));
    }

    public function events_detail($slug)
    {
        $data = Events::where('is_active', 1)->where('slug', $slug)->first();
        $categories = EventCategories::where('is_active', 1)->OrderBy('sort_order')->get();
        $recents = [];
        if(!empty($data)) {
            $recents = Events::where('id', '!=', $data['id'])->where('is_active', 1)->OrderBy('id', 'DESC')->limit(4)->get();
        }
        $sidebar = [];
        if(isset(getConfigurations()['sidebar_meta']['on_events']) && getConfigurations()['sidebar_meta']['on_events']==1) {
            $sidebar = getConfigurations()['sidebar_meta']['events'];
        }
        return view('frontend.event_detail', compact('data', 'categories', 'recents', 'sidebar'));
    }

    public function album_detail($slug)
    {
        $data = Albums::where('is_active', 1)->where('slug', $slug)->first();
        $recents = Albums::where('id', '!=', $data['id'])->where('is_active', 1)->OrderBy('id', 'DESC')->get();
        $sidebar = [];
        if(isset(getConfigurations()['sidebar_meta']['on_album']) && getConfigurations()['sidebar_meta']['on_album']==1) {
            $sidebar = getConfigurations()['sidebar_meta']['album'];
        }
        return view('frontend.album', compact('data', 'recents', 'sidebar'));
    }

    public function contact_mail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:5000',
            'g-recaptcha-response' => 'required',
        ]);

        $data = $request->only(['name', 'email', 'message']);
        $data['msg'] = $data['message'];
        $data['phone'] = $request->filled('phone') ? '+'.$request->country_code.$request->phone : null;

        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }
        try{
            $general_meta = getConfigurations();
            $emails = $general_meta['contact_mails'];
            $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
            $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';
            $to = explode(",", trim($emails));
            Mail::send('emails.contact', $data, function ($m) use($to, $from, $from_mail) {
                $m->from($from_mail, $from);
                $m->to($to)->subject('Contact Form Submittion from '.env('MAIL_FROM_NAME'));
            });
        }catch(\Exception $e){
            dd($e);
        }
        ContactMails::create($data);
        Session::flash('success', 'Thank You for contacting us.');
        return redirect()->back();
    }

    public function subscribe(Request $request)
    {
        $msg = "";
        $subs = Subscribers::where('email',$request->email)->first();
        if(empty($subs)) {
            Subscribers::create([
                'email'=>$request->email,
                'name'=>$request->name??null,
                // 'phone'=>$request->phone??'',
            ]);
            $msg = "You have successfully Subscribed";
        } else { $msg = 'You are already subscribed.'; }
        return $msg;
    }

    public function getStates($countryId)
    {
        $states = States::where('country_id', $countryId)->pluck('name', 'id');
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = Cities::where('state_id', $stateId)->pluck('name', 'id');
        return response()->json($cities);
    }

    public function categories(Request $request, $any = null)
    {
        $product_slug = NULL;
        $categories = $any ? explode('/', $any) : [];
        if(count($categories) > 0){
            $product_slug = $categories[array_key_last($categories)];
        }

        $all_parent_categories = [];
        $related = [];

        $data = Advertise::where('slug', $product_slug)
                        ->where('status', 'active')
                        ->with('gallery', 'category')->first();

        if ($data != null) {
            $data->update(['views' => $data->views + 1]);
            $cates_slug = $data->category->slug;
            $cates_slug = explode('/', $cates_slug);
            $slug_order = implode(',', $cates_slug);

            $all_parent_categories = Categories::whereIn('slug', $cates_slug)->orderByRaw("FIELD(slug, '$slug_order')")->get();
            $related = Advertise::where('category_id', $data->category_id)
                                ->where('status', 'active')
                                ->where('id', '!=', $data->id)
                                ->limit(2)
                                ->get();

            //add visitor
            if (auth()->check() && auth()->user()->id != $data->user_id) {
                performance($data->user_id, ['visitor']);
            }

            $suggested = Advertise::where('status', 'active')
                            ->where('category_id', $data->category_id)
                            ->where('id', '!=', $data->id)
                            ->where('views', '!=', 0)
                            ->orderBy('views', 'DESC')
                            ->limit(20)
                            ->get();

            $populars = [];

            if ($data->category->parent != null) {
                $populars = Categories::where('parent_id', $data->category->parent->id)->limit(20)->get();
            }

            return view('frontend.ad_detail', compact('data', 'all_parent_categories', 'related', 'suggested', 'populars'));
        }else{
            $category = Categories::where('slug', $product_slug)->first();

            $col = 'id is not null';
            $col_order = 'created_at desc';

            if ($category != null) {

                $cids = allChildCategoryIds([$category->id]);
                if (count($cids) > 0) {
                    $col .= ' and category_id in (' . implode(',', $cids) . ')';
                }

                $cates_slug = explode('/', $category->slug);

                foreach ($cates_slug as $cat) {
                    $cc = Categories::where('slug', $cat)->first();
                    if ($cc != null) {
                        $all_parent_categories[] = $cc;
                    }
                }

                $dd = $category->seo_meta;

                $dd['meta_title'] = $category->meta_title;
                $dd['meta_desc'] = $category->meta_description;

                $category->seo = $dd;
            }
            if ($request->has('country') && $request->get('country') != null) {
                $col .= ' and country LIKE "%' . Countries::find($request->get('country'))->name . '%"';
            }
            if ($request->has('state') && $request->get('state') != null) {
                $col .= ' and state LIKE "%' . States::find($request->get('state'))->name . '%"';
            }
            if ($request->has('city') && $request->get('city') != null) {
                $col .= ' and city LIKE "%' . Cities::find($request->get('city'))->name . '%"';
            }
            if ($request->has('sort') && $request->get('sort') != null) {
                if ($request->get('sort') == 'low_price') {
                    $col_order = 'price IS NULL, price asc';
                } elseif ($request->get('sort') == 'high_price') {
                    $col_order = 'price desc';
                } elseif ($request->get('sort') == 'call_for_price') {
                    $col_order = 'price IS NOT NULL, price asc';
                } elseif ($request->get('sort') == 'old') {
                    $col_order = 'created_at asc';
                }
            }
            if ($request->has('min') && $request->has('max') && $request->get('min') != null && $request->get('max')  != null) {
                $col .= ' and price >= "' . $request->get('min') . '" and price <= ' . $request->get('max');
            }
            $req = $request->all();

            $ads = Advertise::where('status', 'active')
                            ->with('fields')
                            ->whereRaw($col)
                            ->orderByRaw($col_order);

            if ($request->has('make') && $request->get('make') != null) {
                $make = Make::find($req['make']);
                $make = ($make->name) ?? null;
                $ads = $ads->whereHas('fields', function ($q) use ($make) {
                    $q->where('name', 'Make')->where('value', $make);
                });
            }
            if ($request->has('makemodel') && $request->get('makemodel') != null) {
                $model = MakeModels::find($req['makemodel']);
                $model = ($model->name) ?? null;
                $ads = $ads->whereHas('fields', function ($q) use ($model) {
                    $q->where('name', 'Model')->where('value', $model);
                });
            }
            if ($request->has('post') && $request->get('post') != null) {
                $posts = explode(',', $request->get('post'));
                foreach ($posts as $key => $post) {
                    $post = explode('_', $post);
                    $val = end($post);
                    unset($post[count($post) - 1]);
                    $post = implode(' ', $post);
                    if (isset($post) && isset($val)) {
                        $val = Posts::find($val);
                        $val = ($val->title) ?? null;
                        $ads = $ads->whereHas('fields', function ($q) use ($post, $val) {
                            $q->where('name', $post)->where('value', $val);
                        });
                    }
                }
            }

            if ($request->has('field') && $request->get('field') != null) {
                $fields = explode(',', $request->get('field'));
                foreach ($fields as $key => $field) {
                    $field = explode('_', $field);
                    $val = end($field);
                    unset($field[count($field) - 1]);
                    $field = implode(' ', $field);
                    if (isset($field) && isset($val)) {
                        $ads = $ads->whereHas('fields', function ($q) use ($field, $val) {
                            $q->where('name', $field)->where('value', 'LIKE', "%" . $val . "%");
                        });
                    }
                }
            }

            if ($request->has('range') && $request->get('range') != null) {
                $fields = explode(',', $request->get('range'));
                foreach ($fields as $key => $field) {
                    $field = explode('_', $field);
                    $val = end($field);
                    unset($field[count($field) - 1]);
                    $field = implode(' ', $field);
                    if (isset($field) && isset($val)) {
                        $val = explode('|', $val);
                        $ads = $ads->whereHas('fields', function ($q) use ($field, $val) {
                            $q->where('name', $field)->where('value', '>=', $val[0])->where('value', '<=', $val[1]);
                        });
                    }
                }
            }

            $ads = $ads->paginate(15)->appends(request()->query());

            if (request()->ajax()) {
                $type = 'listing';
                $view = view('frontend.includes.ads_listing', compact('ads', 'type'))->render();
                $type = 'count';
                $count = view('frontend.includes.ads_listing', compact('ads', 'category', 'type', 'all_parent_categories'))->render();
                $type = 'sidebar';
                $sidebar = view('frontend.includes.ads_listing', compact('category', 'type', 'all_parent_categories'))->render();
                $type = 'breadcrumbs';
                $breadcrumbs = view('frontend.includes.ads_listing', compact('all_parent_categories', 'type'))->render();
                return ['html' => $view, 'count' => $count, 'sidebar' => $sidebar, 'breadcrumbs' => $breadcrumbs];
            } else {
                $data['seo'] = [];
                if ($category != null) {
                    $data = $category;
                }else{
                    $data = getConfigurations()['search_meta'];
                }
                
                return view('frontend.search', compact('ads', 'all_parent_categories', 'category', 'data'));
            }
        }
    }

    public function addToList(Request $request)
    {
        $id = $request->get('id');
        $wishlist = Wishlist::where('adv_id', $id)->where('user_id', auth()->user()->id)->first();
        if ($wishlist == null) {
            Wishlist::create(['adv_id' => $id, 'user_id' => auth()->user()->id]);
            return 1;
        } else {
            $wishlist->delete();
            return 0;
        }
    }

    public function profile($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            return abort(404);
        }

        if (request()->ajax()) {
            $col_order = 'created_at desc';

            if ($request->has('sort') && $request->get('sort') != null) {
                if ($request->get('sort') == 'low_price') {
                    $col_order = 'price IS NULL, price asc';
                } elseif ($request->get('sort') == 'high_price') {
                    $col_order = 'price desc';
                } elseif ($request->get('sort') == 'call_for_price') {
                    $col_order = 'price IS NOT NULL, price asc';
                } elseif ($request->get('sort') == 'old') {
                    $col_order = 'created_at asc';
                }
            }

            $ads = Advertise::where('status', 'active')
                ->where('user_id', $user->id)->orderByRaw($col_order)->paginate(10);

            $type = 'listing';
            $view = view('frontend.includes.ads_listing', compact('ads', 'type'))->render();
            return ['html' => $view];
        } else {
            $ads = Advertise::where('status', 'active')->where('user_id', $user->id)->paginate(10);
            return view('frontend.profile', compact('user', 'ads'));
        }
    }

    public function myOffer(Request $request)
    {
        $data = $request->all();

        if ($data['type'] == 'offer') {
            $adv = Advertise::find($data['adv_id']);
            $data['user_id'] = $adv->user_id;
            $data['msg'] = 'Hi, I like to offer you <span style="color:#1eaf38;font-weight:500;">' . formatPrice($data['myOffer']) . '</span> for ' . $adv->title . '. Please contact me. Thanks!';
            $offer = AdvertiseMessage::create($data);
            $offer = $offer->toArray();
            $offer['is_offer'] = 1;
        } else {
            $adv = Advertise::find($data['adv_id']);
            $data['user_id'] = $adv->user_id;
            $offer = AdvertiseMessage::create($data);
            $offer = $offer->toArray();
            $offer['is_offer'] = 0;
        }
        if (auth()->check() && auth()->user()->id != $data['user_id']) {
            performance($data['user_id'], ['chat_request']);
        }
        $offer['adv_name'] = $adv->title;
        $offer['adv_id'] = $adv->id;
        $offer['user_name'] = $adv->user->name;

        Notifications::create([
            'user_id' => $adv->user_id,
            'title' => 'New message from ' . $adv->user->name,
            'message' => 'You have a new message from ' . $adv->user->name,
            'advertise_id' => $adv->id,
            'type' => 'message',
            'is_read' => 0,
            'msg_id' => $offer['id'],
        ]);

        try {
            $to = $adv->user->email;
            $general_meta = getConfigurations();
            $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
            $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';

            Mail::send('emails.message', $offer, function ($m) use ($to, $from, $from_mail) {
                $m->from($from_mail, $from);
                $m->to($to)->subject('Advertise response from ' . $from);
            });
        } catch (\Exception $e) {
            // dd($e);
        }
        // try {
        //     $offer['title'] = ($offer['is_offer'] == 0) ? 'Message From ' . $offer['name'] : 'Offer From ' . $offer['phone'];
        //     sendWebNotification($offer);
        // } catch (\Exception $e) {
        //     dd($e);
        // }
        return 1;
    }

    public function sellerpage($slug)
    {
        $user = User::where('slug', $slug)->first();
        if ($user) {
            $allAds = Advertise::where('user_id', $user->id)
                ->where('status', 'active')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
            return view('frontend.dashboard.seller_page', compact('user', 'allAds'));
        } else {
            return abort(404);
        }
    }

    public function career(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|max:255',
            'number' => 'required|string',
            'address' => 'required|string',
            'file' => 'required|max:2000|mimes:doc,docx,pdf',
        ]);
        $data = $request->except('_token');
        if($request->hasFile('file'))
        {
            $name = Carbon::now()->format('Ymd').mt_rand(10000, 99999).'.'.$request->file('file')->getClientOriginalExtension();
            $request->file->move(public_path("/uploads/cvs"), $name);
        }
        $data['file'] = $name;
        $data = Career::create($data);

        $general_meta = getConfigurations();
        $to = ($general_meta['contact_meta']['email']) ?? env('MAIL_FROM_ADDRESS');
        $from = ($general_meta['contact_meta']['website']) ?? env('MAIL_FROM_NAME');
        $from_mail = ($general_meta['contact_meta']['email']) ?? env('MAIL_FROM_ADDRESS');

        try {
            Mail::send('emails.career', $data->toArray(), function ($m) use ($to, $from, $from_mail) {
                $m->from($from_mail, $from);
                $m->to($to)->subject('You Have New Career ' . $from);
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
        Session::flash('success', 'Request Submited Successfully');
        return redirect()->back();
    }

    public function subCateHTML(Request $request)
    {
        $id = $request->id;
        $category = Categories::find($id);
        if ($category != null) {
            $html = null;
            $categories = $category->childrens;
            foreach ($categories as $cates) {
                $html .= view('frontend.includes.category_option', ['type' => 'search', 'meta' => [], 'cates' => $cates, 'dash' => ''])->render();
            }
            return ['html' => $html];
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if (!empty($finduser)) {
                Auth::login($finduser);
                if (profileCompletionPercentage() < 100) {
                    return redirect()->route('dashboard.profile');
                }
                return redirect('/');
            } else {
                $rand = Str::random('8');

                // Google's raw payload includes given_name/family_name; fall
                // back to splitting the full name on the first space when
                // they're missing.
                $firstName = $user->user['given_name'] ?? null;
                $lastName = $user->user['family_name'] ?? null;
                if (!$firstName && !$lastName) {
                    $nameParts = preg_split('/\s+/', trim($user['name'] ?? ''), 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                }

                $newuser = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $user['email'],
                    // 'role' => 'customer',
                    'user_type' => 'customer',
                    'password' => bcrypt($rand),
                    'is_verified'=>1,
                    'is_active'=>1,
                ]);

                $data = $newuser->toArray();
                $data['hash'] = $rand;
                $to = $data['email'];
                $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';
                Mail::send('emails.registration', $data, function ($m) use ($to, $from, $from_mail) {
                    $m->from($from_mail, $from);
                    $m->to($to)->subject('Your account is successfully registered');
                });
                Session::flash('success', 'Your account is successfully registered');
                Auth::login($newuser);
                
                if (profileCompletionPercentage() < 100) {
                    return redirect()->route('dashboard.profile');
                }

                return redirect('/');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect('/login')->withErrors(['email' => ['Something went wrong! Please try again.']]);
        }
    }

    public function mainSearch(Request $request)
    {
        $name = $request->name;
        if (strlen($name) > 2) {
            $advs = Advertise::where('status', 'active')->with('category')
                ->where('title', 'LIKE', '%' . $name . '%')->limit(20)->get();
            $html = '';

            foreach ($advs as $adv) {
                $html .= '
                <li class="select_me">
                    <div>
                        <h4 onclick="window.location.href=`' . url(generateUrl($adv->category_id, 'category', $adv->slug)) . '`">' . $adv->title . '</h4>
                        <span onclick="window.location.href=`' . url(generateUrl($adv->category_id, 'category')) . '`">' . $adv->category->name . '</span>
                    </div>
                </li>';
            }
            if($html == ''){
                $html = '<li class="select_me">
                    <div>
                        <h4>No results found</h4>
                    </div>
                </li>';
            }

            // $html .= '</ul>';

            return response()->json($html);
        }
    }

    public function makeUnavailable(Request $request)
    {
        $data = $request->all();
        $check = AdvertiseAvailability::where('user_id', auth()->user()->id)->where('adv_id', $request->adv_id)->where('report', 0)->first();
        if (!$check) {
            // $data = new AdvertiseAvailability;
            $data['user_id'] = auth()->user()->id;
            AdvertiseAvailability::create($data);
            Session::flash('success', 'We received your request, we will soon look into this !');
            return 1;
        } else {
            Session::flash('success', 'You have already done!');
            return 0;
        }
    }
    
    public function makeReport(Request $request)
    {
        $data = $request->all();
        $check = AdvertiseAvailability::where('user_id', auth()->user()->id)->where('adv_id', $request->adv_id)->where('report', 1)->first();
        if (!$check) {
            // $data = new AdvertiseAvailability;
            $data['user_id'] = auth()->user()->id;
            AdvertiseAvailability::create($data);
            Session::flash('success', 'We received your request, we will soon look into this !');
            return 1;
        } else {
            Session::flash('success', 'You have already done!');
            return 0;
        }
    }

    public function statusChangeAd(Request $request)
    {
        $data = Advertise::find($request->id);
        if($request->status=="active") {
            if(empty($data['meta_title']) && empty($data['meta_description'])) {
                $desc = Str::limit($data['description'], 160, '...');
                $data->update(['meta_title'=>$data['title'], 'meta_description'=>$desc]);
            }
        }
        $data->update([
            'status' => $request->status,
        ]);
        return 1;
    }

    public function adSEOUpdate(Request $request) {
        $data = Advertise::find($request->_id);
        $data->update($request->except('_id'));
        Session::flash('success', 'SEO Data updated!');
        return redirect()->back();
    }

    public function ReportAbuse(Request $request){

        $data = $request->all();
        $check = AdvertiseAvailability::where('user_id', auth()->user()->id)->where('adv_id', $request->adv_id)->where('report', 1)->first();
        if (!$check) {
            $data['user_id'] = auth()->user()->id;
            $data['report'] = 1;
            AdvertiseAvailability::create($data);
            Session::flash('success', 'We received your request, we will soon look into this !');
            return redirect()->back();
        } else {
            Session::flash('success', 'You have already done!');
            return redirect()->back();
        }
    }

    public function blog_comment($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'comment' => 'required|max:2000',
        ]);

        $comment = BlogComments::create([
            'blog_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'is_active' => 0,
        ]);

        return response()->json([ 'status' => true, 'message' => 'Thank you! Your comment has been submitted successfully and will appear once approved.' ]);
    }

    // public function rollback() {
    //     $freePlan = Plans::where('name', 'Free')->first();

    //     $userIds = Advertise::distinct()->pluck('user_id');

    //     foreach ($userIds as $userId) {

    //         \App\Models\UserPlan::firstOrCreate(
    //             ['user_id' => $userId],
    //             [
    //                 'plan_id'          => $freePlan->id,
    //                 'plan_month'       => 1, // or whatever your free plan duration is
    //                 'plan_expire_date' => now()->addMonths(1), // or your desired expiry
    //                 'paid'             => 1,
    //                 'price'            => 0,
    //                 'transaction_id'   => null,
    //                 'unsub'            => 0,
    //                 'expired'          => 0,
    //                 'plan_name'        => $freePlan->name,
    //                 'plan_type'        => $freePlan->plan_type_id,
    //             ]
    //         );
    //     }
    //     return 'test';
    // }
}
