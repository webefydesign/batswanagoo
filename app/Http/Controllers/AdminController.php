<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Blogs;
use App\Models\Events;
use App\Models\ContactMails;
use App\Models\Subscribers;
use App\Models\Pages;
use App\Models\Services;
use App\Models\UserGroups;
use App\Models\User;
use App\Models\Advertise;
use App\Models\AdvertisePromo;
use App\Models\Promote;
use App\Models\AdvertiseAvailability;
use App\Models\Categories;
use App\Models\States;
use App\Models\Cities;
use App\Models\Notifications;
use App\Models\WalletTransactions;
use App\Models\Wallets;
use App\Models\Configurations;
use App\Models\AdvertiseGallery;
use App\Models\BlogComments;
use Session;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $blogs_count = Blogs::where('is_active', 1)->count();
        $users_count = User::where('is_active', 1)->where('user_type', 'admin')->count();
        $customers_count = User::where('is_active', 1)->where('user_type', 'customer')->count();
        $pages_count = Pages::where('is_active', 1)->count();

        // "vs last 7 days" trend cards - each compares the last 7 days
        // against the 7 days before that, using created_at as the signal.
        $last7Start = now()->subDays(6)->startOfDay();
        $prev7Start = now()->subDays(13)->startOfDay();
        $prev7End = now()->subDays(7)->endOfDay();

        $totalAds = Advertise::count();
        $adsLast7 = Advertise::where('created_at', '>=', $last7Start)->count();
        $adsPrev7 = Advertise::whereBetween('created_at', [$prev7Start, $prev7End])->count();

        $pendingAds = Advertise::where('status', 'pending')->count();
        $pendingLast7 = Advertise::where('status', 'pending')->where('created_at', '>=', $last7Start)->count();
        $pendingPrev7 = Advertise::where('status', 'pending')->whereBetween('created_at', [$prev7Start, $prev7End])->count();

        $totalSellers = User::where('user_type', 'customer')->count();
        $newSellersThisWeek = User::where('user_type', 'customer')->where('created_at', '>=', $last7Start)->count();
        $sellersPrev7 = User::where('user_type', 'customer')->whereBetween('created_at', [$prev7Start, $prev7End])->count();

        $stats = [
            'total_ads' => ['value' => $totalAds, 'change' => $this->percentChange($adsLast7, $adsPrev7)],
            'pending_ads' => ['value' => $pendingAds, 'change' => $this->percentChange($pendingLast7, $pendingPrev7)],
            'total_sellers' => ['value' => $totalSellers, 'change' => $this->percentChange($newSellersThisWeek, $sellersPrev7)],
            'new_sellers' => ['value' => $newSellersThisWeek, 'change' => $this->percentChange($newSellersThisWeek, $sellersPrev7)],
        ];

        return view('backend.dashboard', compact('users_count', 'blogs_count', 'customers_count', 'pages_count', 'stats'));
    }

    /**
     * Percentage change of $current vs $previous, null when there's nothing
     * to compare against (so the view can show a neutral state instead of
     * a misleading "+100%").
     */
    private function percentChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? null : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * JSON data source for the dashboard's "Ads Posted" and
     * "Sellers / Customers Registered" charts, bucketed by day/week/month.
     */
    public function dashboardChartData(Request $request)
    {
        $type = $request->get('type', 'ads');
        $period = $request->get('period', 'week');

        $baseQuery = $type === 'customers'
            ? User::where('user_type', 'customer')
            : Advertise::query();

        if ($period === 'day') {
            $start = now()->startOfDay();
            $end = now()->endOfDay();

            $rows = (clone $baseQuery)->whereBetween('created_at', [$start, $end])
                ->selectRaw('HOUR(created_at) as bucket, COUNT(*) as total')
                ->groupBy('bucket')
                ->pluck('total', 'bucket');

            $labels = [];
            $data = [];
            for ($h = 0; $h < 24; $h++) {
                $labels[] = date('g A', mktime($h, 0, 0));
                $data[] = (int) ($rows[$h] ?? 0);
            }
        } else {
            $days = $period === 'month' ? 29 : 6;
            $start = now()->subDays($days)->startOfDay();

            $rows = (clone $baseQuery)->where('created_at', '>=', $start)
                ->selectRaw('DATE(created_at) as bucket, COUNT(*) as total')
                ->groupBy('bucket')
                ->pluck('total', 'bucket');

            $labels = [];
            $data = [];
            for ($i = $days; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('M j');
                $data[] = (int) ($rows[$date->format('Y-m-d')] ?? 0);
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function profile()
    {
        $data = auth()->user();
        $groups = UserGroups::OrderBy('name')->get();
        return view('backend.profile', compact('data', 'groups'));
    }

    public function update_profile(Request $request)
    {
        $id = auth()->id();
        $data = $request->except('_token', 'password');
        if($request->has('password') && $request->password!='') {
            $data['password'] = bcrypt($request->password);
        }
        User::find($id)->update($data);
        Session::flash('success', 'Profile update successfully');
        return redirect()->back();
    }

    public function advertises(Request $request)
    {
        $limit  = $request->get('limit', 25);
        $search = $request->get('q', '');
        $sort   = $request->get('sort', 'desc');

        $query = Advertise::query();

        // 🔍 Search (SAFE)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // 👤 Filter by user
        if ($request->filled('user') && $request->user != 0) {
            $query->where('user_id', $request->user);
        }

        // 🎯 Filter by promotion
        if ($request->filled('promo') && $request->promo != 0) {
            $ad_ids = AdvertisePromo::where('promotion_id', $request->promo)
                ->pluck('adv_id');

            if ($ad_ids->isNotEmpty()) {
                $query->whereIn('id', $ad_ids);
            } else {
                // No ads → return empty result
                $query->whereRaw('1 = 0');
            }

            // dd($ad_ids);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        if ($sort === 'title') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $data = $query->paginate($limit);

        $users = User::whereIn('user_type', ['customer', 'admin'])->get();
        $promotions = Promote::where('is_active', 1)->get();

        return view('backend.ads.index', compact('data', 'users', 'promotions'));
    }

    public function advertise_status(Request $request)
    {
        $advertise = Advertise::find($request->id);
        $wasActive = $advertise->status === 'active';

        $advertise->update([
            'status' => $request->status,
        ]);
        Notifications::create([
            'user_id' => $advertise->user_id,
            'title' => 'Your ad status has been changed',
            'message' => 'Your ad ' . $advertise->title . ' has been changed to ' . $request->status,
            'advertise_id' => $advertise->id,
            'type' => 'advertise',
            'is_read' => 0,
        ]);

        if ($request->status === 'active' && !$wasActive) {
            try {
                $advertise->load('user', 'category');
                $adUrl = url(optional($advertise->category)->getSlug(optional($advertise->category)->slug) . '/' . $advertise->slug);
                $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';

                $advArray = $advertise->toArray();
                $advArray['adUrl'] = $adUrl;

                Mail::send('emails.adApproved', $advArray, function ($m) use ($advertise, $from, $from_mail) {
                    $m->from($from_mail, $from);
                    $m->to($advertise->user->email)->subject('Your ad is approved ' . $from);
                });
            } catch (\Exception $e) {
                \Log::error('Ad approved mail error: ' . $e->getMessage());
            }
        }

        return 1;
    }

    public function reports(Request $request)
    {
        $dat = $request->all();
        $limit = ($dat['limit']) ?? 25;
        $typ = ($dat['type']) ?? '';
        $search = ($dat['search']) ?? '';
        $col = 'id is not null ';
        if ($typ !== '') {
            $col .= ' and ' . $typ . ' LIKE "%' . $search . '%"';
        }

        $ids = AdvertiseAvailability::pluck('adv_Id')->unique()->toArray();
        $data = Advertise::whereRaw($col)->whereIn('id', $ids)
            ->with('reports.user', 'unavailables.user')->orderBy('created_at', 'DESC')->paginate($limit);
        return view('backend.ads.reports', compact('data'));
    }

    public function getAdvertiseSeo($id)
    {
        $advertise = Advertise::findOrFail($id);
        
        // Get the first image from gallery
        $firstImage = $advertise->gallery->first();
        $adImage = $firstImage ? asset('uploads/post/' . $firstImage->image) : '';
        
        // Generate the ad URL with categories
        // $adUrl = url('/categories' . optional($advertise->category)->slug . '/' . $advertise->slug);
        $adUrl = url(optional($advertise->category)->getSlug(optional($advertise->category)->slug) . '/' . $advertise->slug);
        
        // Generate schema code if empty
        $generatedSchema = '';
        if (empty($advertise->schema_code)) {
            $generatedSchema = '<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "' . $advertise->title . '",
  "image": [
    "' . $adImage . '"
  ],
  "description": "' . strip_tags($advertise->description) . '",
  "offers": {
    "@type": "Offer",
    "url": "' . $adUrl . '",
    "priceCurrency": "SLE",
    "price": "' . $advertise->price . '"
  }
}
</script>';
        }
        
        $html = view('backend.ads.seo_data', compact('advertise', 'adImage', 'adUrl', 'generatedSchema'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'adTitle' => $advertise->title
        ]);
    }

    public function updateAdvertiseSeo(Request $request, $id)
    {
        $advertise = Advertise::findOrFail($id);
        
        // Prepare SEO meta data
        $seoMeta = [];
        
        if ($request->has('seo_meta.og_tag')) {
            $seoMeta['og_tag'] = true;
            $seoMeta['og'] = [
                'title' => $request->input('seo_meta.og.title'),
                'description' => $request->input('seo_meta.og.description'),
                'url' => $request->input('seo_meta.og.url'),
                'type' => $request->input('seo_meta.og.type'),
                'image' => $request->input('seo_meta.og.image'),
            ];
        }
        
        if ($request->has('seo_meta.twitter_tag')) {
            $seoMeta['twitter_tag'] = true;
            $seoMeta['twitter'] = [
                'title' => $request->input('seo_meta.twitter.title'),
                'description' => $request->input('seo_meta.twitter.description'),
                'url' => $request->input('seo_meta.twitter.url'),
                'card' => $request->input('seo_meta.twitter.card'),
                'image' => $request->input('seo_meta.twitter.image'),
            ];
        }
        
        if ($request->has('seo_meta.is_schema')) {
            $seoMeta['is_schema'] = true;
        }
        
        if ($request->has('seo_meta.is_tags')) {
            $seoMeta['is_tags'] = true;
            $seoMeta['meta_tags'] = $request->input('seo_meta.meta_tags');
        }
        
        if ($request->has('seo_meta.is_canonicals')) {
            $seoMeta['is_canonicals'] = true;
            $seoMeta['canonical'] = $request->input('seo_meta.canonical');
        }
        
        $advertise->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'seo_meta' => $seoMeta,
            'schema_code' => $request->schema_code,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'SEO data updated successfully!'
        ]);
    }

    public function editAdvertise($id)
    {
        $advertise = Advertise::with(['category', 'gallery'])->findOrFail($id);
        $categories = Categories::where('is_active', 1)->get();
        
        // Get states and cities for Botswana (fixed country)
        $states = getStatesByCountryName('Botswana');
        $cities = getCitiesByStateName($advertise->state ?? '', 'Botswana');
        
        return view('backend.ads.edit', compact('advertise', 'categories', 'states', 'cities'));
    }

    public function updateAdvertise(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'state' => 'required|string',
            'city' => 'required|string',
            // 'phone' => 'required|string|max:13',
            'payment_type' => 'required|in:free,amount,negotiable,contact',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,pending,expired,sold',
        ]);
        $data = $request->all();

        $advertise = Advertise::findOrFail($id);
        
        // Update basic fields
        $advertise->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'state' => $request->state,
            'city' => $request->city,
            'phone' => $request->phone ?? '',
            'payment_type' => $request->payment_type,
            'price' => $request->price,
            'status' => $request->status,
            'country' => 'Botswana', // Fixed country
        ]);

        if($request->has('images') || $request->has('deleted_images')) {
            AdvertiseGallery::updator($request, $advertise);
        }


        Notifications::create([
            'user_id' => $advertise->user_id,
            'title' => 'Your ad has been updated',
            'message' => 'Your ad ' . $advertise->title . ' has been updated',
            'advertise_id' => $advertise->id,
            'type' => 'advertise',
            'is_read' => 0,
        ]);

        return redirect()->route('advertises.index')->with('success', 'Ad updated successfully');
    }

    public function getCitiesByStateName($stateName)
    {
        $cities = getCitiesByStateName($stateName, 'Botswana');
        return response()->json($cities);
    }

    public function deleteAds(Request $request)
    {
        $ids = $request->ids;
        Advertise::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Ads deleted successfully');
    }

    public function walletPayments(Request $request)
    {
        $dat = $request->all();
        $limit = ($dat['limit']) ?? 10;
        $sort = ($dat['sort']) ?? 'desc';
        
        $query = WalletTransactions::query();
        
        // Filter by payment method
        if ($request->has('payment_method') && $request->get('payment_method') != 0) {
            $query->where('payment_method', $request->get('payment_method'));
        }
        
        // Filter by status
        if ($request->has('status') && $request->get('status') != '') {
            $query->where('payment_status', $request->get('status'));
        }
        
        // Filter by user
        if ($request->has('user') && $request->get('user') != 0) {
            $query->where('user_id', $request->get('user'));
        }
        
        // Handle sorting
        if ($sort == 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $data = $query->paginate($limit);
        $wallet_settings = Configurations::find(1)->wallet_meta;
        $users = User::where('user_type', 'customer')->orWhere('user_type', 'admin')->get();
        return view('backend.wallets.index', compact('data', 'wallet_settings', 'users'));
    }

    public function approveWalletPayment(Request $request)
    {
        $transaction = WalletTransactions::find($request->id);
        $transaction->update(['payment_status' => 'completed']);
        $balance = $transaction->wallet->balance ?? 0;
        $wallet = Wallets::updateOrCreate(
            ['user_id' => $transaction->user_id],
            ['balance' => $balance + $transaction->amount]
        );
        Notifications::create([
            'user_id' => $transaction->user_id,
            'title' => 'Your payment has been approved',
            'message' => 'Your payment of ' . number_format($transaction->amount, 2) . ' ' . baseSymbol() . ' has been approved',
            'wallet_transaction_id' => $transaction->id,
            'type' => 'wallet',
            'is_read' => 0,
        ]);
        return redirect()->back()->with('success', 'Payment approved successfully');
    }

    public function walletSettings(Request $request)
    {
        $wallet_meta = $request->wallet_meta ?? [];
        Configurations::find(1)->update(['wallet_meta' => $wallet_meta]);
        return redirect()->back()->with('success', 'Wallet settings updated successfully');
    }

    public function blog_comments(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = BlogComments::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = BlogComments::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.comments.index', compact('data'));
    }

    public function approve_comment($id)
    {
        $comment = BlogComments::find($id);
        $comment->is_active = ($comment->is_active==1)?0:1;
        $comment->save();
        return redirect()->back()->with('success', 'Comment updated successfully');
    }

    public function delete_comments(Request $request)
    {
        $count = count($request->ids);
        BlogComments::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
