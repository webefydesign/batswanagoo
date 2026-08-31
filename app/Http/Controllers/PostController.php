<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\AdvertiseGallery;
use App\Models\AdvertisePromo;
use App\Models\Promote;
use App\Models\Categories;
use App\Models\PlanCategory;
use App\Models\PlanPricing;
use App\Models\Plans;
use App\Models\PlanType;
use App\Models\PlanTypeCategory;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use App\Models\Wallets;
use App\Models\WalletTransactions;
use Carbon\Carbon;
use Session;
// use Cartalyst\Stripe\Stripe;
use URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function postAdd(Request $request){
        // Ad posting no longer requires a purchased plan - any user with a
        // complete profile can post directly. Category selection happens
        // entirely through the "You are now posting in" modal (unlimited
        // nesting, fetched on demand via categoryModal()) - nothing to
        // preload here except when duplicating a previous ad via "?like=".
        $post = null;
        $initialCategory = null;
        if ($request->filled('like')) {
            $post = Advertise::find($request->get('like'));
            if ($post && $post->category_id) {
                $initialCategory = Categories::find($post->category_id);
            }
        }

        $promotes = Promote::where('is_active', 1)->get();
        if(profileCompletionPercentage() == 100) {
            return view('frontend.postAds', compact('promotes', 'initialCategory', 'post'));
        } else {
            return redirect()->route('dashboard.profile');
        }
    }

    /**
     * JSON data source for the "You are now posting in" category modal.
     * With no `id`, returns the root categories. With `id`, returns that
     * category's children plus its breadcrumb. With `search`, returns a
     * flat, ranked match list across every category regardless of depth.
     */
    public function categoryModal(Request $request)
    {
        $childrenCountScope = function ($query) {
            $query->where('is_active', 1);
        };

        if ($request->filled('search')) {
            $term = trim($request->get('search'));

            $items = Categories::where('is_active', 1)
                ->where('name', 'LIKE', '%' . $term . '%')
                ->withCount(['childrens' => $childrenCountScope])
                ->orderBy('name', 'ASC')
                ->limit(50)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'has_children' => $category->childrens_count > 0,
                        'path' => collect($category->breadcrumbs)->pluck('name')->implode(' > '),
                    ];
                });

            return response()->json(['mode' => 'search', 'items' => $items]);
        }

        $parentId = $request->get('id') ?: null;
        $parent = $parentId ? Categories::find($parentId) : null;

        $items = Categories::where('is_active', 1)
            ->where('parent_id', $parentId)
            ->withCount(['childrens' => $childrenCountScope])
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'has_children' => $category->childrens_count > 0,
                ];
            });

        $breadcrumb = $parent
            ? collect($parent->breadcrumbs)->map(function ($category) {
                return ['id' => $category->id, 'name' => $category->name];
            })->values()
            : collect();

        return response()->json([
            'mode' => 'browse',
            'parent' => $parent ? ['id' => $parent->id, 'name' => $parent->name] : null,
            'breadcrumb' => $breadcrumb,
            'items' => $items,
        ]);
    }

    public function select_plantype(){

        $plan_types = PlanType::where('is_active', 1)->get();
        if(profileCompletionPercentage() == 100) {
            return view('frontend.plantype', compact('plan_types'));        
        } else {
            return redirect()->route('dashboard.profile');
        }
    }

    public function select_plan(Request $request, $id){
        if(profileCompletionPercentage() != 100) {
            return redirect()->route('dashboard.profile');
        }

        if(isset($id)){

            $plan_type = PlanType::where('name', $id)->first();

            if (!$plan_type) {
                return redirect()->route('select_plantype');
            }

            $planIds = Plans::where('plan_type_id', $plan_type->id)->where('is_active', 1)->pluck('id');

            $pricing = PlanPricing::with('plan.planType','plan.getPlanCategory.category')
                ->whereIn('plan_id', $planIds)
                ->orderBy('month', 'ASC')
                ->orderBy('price', 'ASC')
                ->get()
                ->toArray();

            $grouped = collect($pricing)->groupBy('month')->map(function ($items) {
                // Collect plans with prices for each month
                $mergedPlans = $items->map(function ($item) {
                    return [
                        'id' => $item['plan']['id'] ?? null,
                        'name' => $item['plan']['name'] ?? null,
                        'plan_type_id' => $item['plan']['plan_type_id'] ?? null,
                        'slug' => $item['plan']['slug'] ?? null,
                        'points' => $item['plan']['points'] ?? null,
                        'media_links' => $item['plan']['media_links'] ?? null,
                        'dedicated_link' => $item['plan']['dedicated_link'] ?? null,
                        'sms' => $item['plan']['sms'] ?? null,
                        'price' => $item['price'] ?? '0.00', // price from PlanPricing
                        'planType' => $item['plan']['plan_type'] ?? [],
                        'PlanCategory' => $item['plan']['get_plan_category'] ?? [],
                    ];
                })->unique('id')->values()->all();

                return [
                    'month' => $items->first()['month'],
                    'plans' => $mergedPlans,
                ];
            })->values()->toArray();

            // Scoped to *this* plan type - planData() only ever returns the
            // single most-recently-purchased plan across all types, so a
            // user with active plans in multiple types would only ever see
            // "Active"/expiry on whichever one they bought last.
            $userPlan = UserPlan::with('plan.planType')
                ->where('user_id', auth()->id())
                ->where('paid', 1)
                ->where('expired', 0)
                ->where('unsub', 0)
                ->where('plan_type', $plan_type->id)
                ->where('plan_expire_date', '>', now()->format('Y-m-d'))
                ->orderBy('created_at', 'desc')
                ->first();

            // $morePlan = PlanType::where('name', '!=', $id)->where('is_active', 1)->get();
            $morePlan = PlanType::where('is_active', 1)->get();

            return view('frontend.plan',compact('grouped', 'plan_type', 'userPlan', 'morePlan'));
        }else{
            return redirect()->route('select_plantype');
        }
    }

    public function plan_active(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'plan_month' => 'required|integer|min:1|max:12',
            'price' => 'required|numeric|min:0',
            'plan_name' => 'required|string',
            'plan_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        
        try {
            $data = $request->except('_token');
            $data['user_id'] = auth()->id();
            $data['plan_expire_date'] = Carbon::now()->addMonths((int) $request->plan_month)->format('Y-m-d');
            
            // Delete old unpaid/unexpired plans
            UserPlan::where('user_id', auth()->id())
                ->where('paid', 0)
                ->where('expired', 0)
                ->where('unsub', 0)
                ->delete();
            
            $plan_price = (float) $data['price'];
            
            // Free plan handling
            if ($plan_price == 0) {
                $data['paid'] = 1;
                $plan = UserPlan::create($data);
                DB::commit();
                
                Session::flash('success', 'Plan Purchased Successfully');
                // return redirect()->route('home');
                return response()->json([
                    'success' => true,
                    'plan_id' => $plan->id,
                    'type' => 'wallet'
                ]);
            }
            
            // Paid plan handling
            $wallet = Wallets::lockForUpdate()->where('user_id', auth()->id())->first();
            $wallet_balance = (float) ($wallet->balance ?? 0);
            
            $deduction_amount = 0;
            $payable_amount = $plan_price;
            
            // Calculate wallet usage
            if ($wallet_balance > 0) {
                if ($plan_price > $wallet_balance) {
                    // Wallet covers partially
                    $deduction_amount = $wallet_balance;
                    $payable_amount = $plan_price - $wallet_balance;
                } else {
                    // Wallet covers fully
                    $deduction_amount = $plan_price;
                    $payable_amount = 0;
                }
            }
            
            // Validate sufficient funds for full wallet payment
            if ($payable_amount == 0 && $wallet_balance < $plan_price) {
                DB::rollBack();
                return response()->json(['error' => 'Insufficient wallet balance'], 422);
            }
            
            // Create the plan
            $plan = UserPlan::create($data);
            
            // Handle payment based on amount
            if ($payable_amount > 0) {
                // Need Stripe payment
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => round($payable_amount * 100), // Convert to cents
                    // 'currency' => strtolower(config('app.currency', 'usd')),
                    'currency' => baseSymbol(),
                    'automatic_payment_methods' => ['enabled' => true],
                    'metadata' => [
                        'user_id' => auth()->id(),
                        'plan_id' => $plan->id,
                        'type' => 'plan_purchase'
                    ]
                ]);
                
                $plan->update(['transaction_id' => $paymentIntent->id]);
                
                // Create pending wallet deduction if wallet was used
                if ($deduction_amount > 0) {
                    WalletTransactions::create([
                        'user_id' => auth()->id(),
                        'wallet_id' => $wallet->id,
                        'amount' => $deduction_amount,
                        'type' => 'debit',
                        'description' => 'Partial payment for ' . $data['plan_name'] . ' plan (' . $data['plan_month'] . ' months)',
                        'ref' => $plan->id,
                        'plan_id' => $plan->plan_id,
                        'payment_method' => 'wallet',
                        'payment_status' => 'pending', // Will be completed when Stripe payment succeeds
                    ]);
                }
                
                DB::commit();
                
                return response()->json([
                    'clientSecret' => $paymentIntent->client_secret,
                    'plan_id' => $plan->id,
                    'type' => 'stripe',
                    'deduction_amount' => $deduction_amount,
                    'payable_amount' => $payable_amount
                ]);
                
            } else {
                // Full wallet payment
                if (!$wallet) {
                    throw new \Exception('Wallet not found');
                }
                
                // Deduct from wallet
                $wallet->decrement('balance', $deduction_amount);
                
                // Record transaction
                WalletTransactions::create([
                    'user_id' => auth()->id(),
                    'wallet_id' => $wallet->id,
                    'amount' => $deduction_amount,
                    'type' => 'debit',
                    'description' => 'Payment for ' . $data['plan_name'] . ' plan (' . $data['plan_month'] . ' months)',
                    'ref' => $plan->id,
                    'plan_id' => $plan->plan_id,
                    'payment_method' => 'wallet',
                    'payment_status' => 'completed',
                ]);
                
                // Mark plan as paid
                $plan->update(['paid' => 1]);
                
                /* sending email */
                try {
                    $to = auth()->user()->email;                    
                    $data = $plan->toArray();
                    $data['plan'] = $plan->plan->toArray();
                    $data['price'] = $plan_price;
                    $data['user'] = auth()->user();
                    // dd($data);

                    $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                    $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';                
                    Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                        $m->from($from_mail, $from);
                        $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    });
    
                    // $emails = getpreferences()['contact_email'];
                    // $to = explode(",", trim($emails));
                    // $plan['to_admin'] = 1;
                    // Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                    //     $m->from($from_mail, $from);
                    //     $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    // });
    
                } catch (\Exception $e) {
                    // dd($e);
                }

                /* end sending email */
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'plan_id' => $plan->id,
                    'type' => 'wallet'
                ]);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Plan purchase error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Plan purchase failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function plan_success(Request $request)
    {
        DB::beginTransaction();
        
        try {
            if ($request->type === 'stripe') {
                // Stripe payment
                $payment_intent = $request->payment_intent;
                
                if (!$payment_intent) {
                    throw new \Exception('Payment intent missing');
                }
                
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $payment = \Stripe\PaymentIntent::retrieve($payment_intent);
                
                if ($payment->status !== 'succeeded') {
                    throw new \Exception('Payment not successful');
                }
                
                $plan = UserPlan::where('transaction_id', $payment_intent)->first();
                
                if (!$plan) {
                    throw new \Exception('Plan not found');
                }
                
                // Mark plan as paid
                $plan->update(['paid' => 1]);
                
                // Complete any pending wallet transactions for this plan
                $pendingTransaction = WalletTransactions::where('user_id', auth()->id())
                    ->where('ref', $plan->id)
                    ->where('payment_status', 'pending')
                    ->first();
                
                if ($pendingTransaction) {
                    $wallet = Wallets::lockForUpdate()->findOrFail($pendingTransaction->wallet_id);
                    $wallet->decrement('balance', $pendingTransaction->amount);
                    $pendingTransaction->update(['payment_status' => 'completed']);
                }
                
                DB::commit();

                /* sending email */
                try {
                    $user = auth()->user();
                    $to = $user->email;                    
                    $data = $plan->toArray();
                    $data['plan'] = $plan->plan->toArray();
                    $data['user'] = $user;
                    // dd($data);

                    $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                    $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';                
                    Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                        $m->from($from_mail, $from);
                        $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    });
    
                    // $emails = getpreferences()['contact_email'];
                    // $to = explode(",", trim($emails));
                    // $plan['to_admin'] = 1;
                    // Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                    //     $m->from($from_mail, $from);
                    //     $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    // });
    
                } catch (\Exception $e) {
                    // dd($e);
                }

                /* end sending email */
                
                Session::flash('success', 'Plan purchased successfully!');
                return view('frontend.plan.stripe_success', ['plan' => $plan]);
                
            } else {
                // Wallet-only payment (already completed in plan_active)
                $plan = UserPlan::findOrFail($request->plan_id);
                
                DB::commit();

                /* sending email */
                try {
                    $to = auth()->user()->email;                    
                    $data = $plan->toArray();
                    $data['plan'] = $plan->plan->toArray();
                    $data['user'] = auth()->user();
                    // $data['price'] = $plan_price;
                    // dd($data);

                    $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                    $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';                
                    Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                        $m->from($from_mail, $from);
                        $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    });
    
                    // $emails = getpreferences()['contact_email'];
                    // $to = explode(",", trim($emails));
                    // $plan['to_admin'] = 1;
                    // Mail::send('emails.plan', $data, function ($m) use ($to, $from, $from_mail) {
                    //     $m->from($from_mail, $from);
                    //     $m->to($to)->subject('New Plan Successfully Bought ' . $from);
                    // });
    
                } catch (\Exception $e) {
                    // dd($e);
                }

                /* end sending email */
                
                Session::flash('success', 'Plan purchased successfully!');
                return view('frontend.plan.stripe_success', ['plan' => $plan]);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Plan success error: ' . $e->getMessage());
            
            Session::flash('error', 'Payment verification failed: ' . $e->getMessage());
            return redirect()->route('select_plan');
        }
    }

    public function fetchCategory(Request $request)
    {
        $other = 0;
        if ($request->has('pid')) {
            $parent_id = $request->get('pid');
        } else {
            $parent_id = $request->get('id');
        }

        $id = ($request->has('id')) ? $request->get('id') : 0;

        if ($request->has('category_search') && $request->get('category_search') == 1) {
            $category = Categories::find($id);
            $parent = $category->parent;
            if ($parent != null && $request->has('sub')) {
                $sub = json_decode($request->get('sub'));
                $childrens =  $parent->childrens->whereNotIn('id', $sub);
            } elseif ($parent != null) {
                $childrens =  $parent->childrens;
            } else {
                $childrens = [];
            }
            $html = view('frontend.includes.category_fields', ['page' => 1, 'category' => $category, 'childrens' => $childrens])->render();
        } else {
            if ($id == 'other') {
                $other = 1;
                $firstMain = Categories::where('is_active', 1)->where('is_special', 0)
                    ->where('parent_id', null)->orderBy('sort_order', 'ASC')->get();
            } else {
                $firstMain = Categories::find($parent_id);
            }
            $html = view('frontend.includes.main_category', compact('other', 'firstMain', 'id'))->render();
        }

        return response(['msg' => '', 'status' => 1, 'html' => $html]);
    }

    public function fetchSubCategory(Request $request)
    {
        $data = $request->all();
        $html = '';

        $categories = Categories::where('parent_id', $data['id'])->orderBy('name', 'ASC')->get();

        if (count($categories) > 0) {
            $html = '<select name="category[' . $data["id"] . ']" class="form-control select_2 fetchSubCategory" required data-sub="sub_category_' . $data["id"] . '"><option value="">Select your category</option>';
            foreach ($categories as $category) {
                $html .= '<option value="' . $category->id . '">' . $category->name . '</option>';
            }
            $html .= '</select>';
        }
        $category = Categories::find($data['id']);
        $field_html = view('frontend.includes.category_fields', compact('category'))->render();

        return response()->json(['msg' => null, 'status' => 1, 'categories' => $html, 'category_fields' => $field_html]);
    }

    public function addAds(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'description' => 'required',
            // 'phone' => 'required',
            'images' => 'required|array|min:3',
        ]);
        // dd($request->all());
        
        DB::beginTransaction();
        
        try {
            $data = $request->all();

            // Ad posting is unlimited and plan-free - no per-category ad
            // count/plan check here anymore.

            // Create the ad
            $adv = Advertise::creator($data);
            
            if (isset($data['images'])) {
                AdvertiseGallery::creator($data['images'], $adv);
            }
            
            $promotions = [];
            if (isset($data['promo'])) {
                $promotions = AdvertisePromo::creator($data['promo'], $adv);
            }

            adsCount($adv->category_id);

            // Send emails
            try {
                $to = $adv->user->email;
                $general_meta = getConfigurations();
                $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';    

                $advArray = Advertise::where('id', $adv->id)->with('user', 'promotions', 'gallery')->first()->toArray();
                $advArray['to_admin'] = 0;
                Mail::send('emails.postAdv', $advArray, function ($m) use ($to, $from, $from_mail) {
                    $m->from($from_mail, $from);
                    $m->to($to)->subject('New Advertise Mail ' . $from);
                });
                /*
                $emails = getpreferences()['contact_email'];
                $to = explode(",", trim($emails));
                $advArray['to_admin'] = 1;
                Mail::send('emails.postAdv', $advArray, function ($m) use ($to, $from, $from_mail) {
                    $m->from($from_mail, $from);
                    $m->to($to)->subject('New Advertise Mail ' . $from);
                }); */
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }

            // Handle promotions payment
            if (count($promotions) > 0) {
                $total_price = collect($promotions)->sum('price');
                
                // Get wallet balance
                $wallet = Wallets::lockForUpdate()->where('user_id', auth()->id())->first();
                $wallet_balance = (float) ($wallet->balance ?? 0);
                
                $deduction_amount = 0;
                $payable_amount = $total_price;
                
                // Calculate wallet usage
                if ($wallet_balance > 0) {
                    if ($total_price > $wallet_balance) {
                        // Wallet covers partially
                        $deduction_amount = $wallet_balance;
                        $payable_amount = $total_price - $wallet_balance;
                    } else {
                        // Wallet covers fully
                        $deduction_amount = $total_price;
                        $payable_amount = 0;
                    }
                }
                
                // ============================================
                // FIXED: Check if payment_intent exists (card payment already completed)
                // ============================================
                if ($request->has('payment_intent')) {
                    // Card payment already completed in modal
                    $payment_intent = $request->payment_intent;
                    
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $payment = \Stripe\PaymentIntent::retrieve($payment_intent);
                    
                    if ($payment->status !== 'succeeded') {
                        throw new \Exception('Payment not successful');
                    }
                    
                    // Store transaction ID
                    $adv->update(['transaction_id' => $payment_intent]);
                    
                    // Complete wallet deduction if any
                    if ($deduction_amount > 0) {
                        $wallet->decrement('balance', $deduction_amount);
                        
                        WalletTransactions::create([
                            'user_id' => auth()->id(),
                            'wallet_id' => $wallet->id,
                            'amount' => $deduction_amount,
                            'type' => 'debit',
                            'description' => 'Partial payment for ad promotions (wallet portion)',
                            'ref' => $adv->id,
                            'promotion_id' => $adv->id,
                            'payment_method' => 'wallet',
                            'payment_status' => 'completed',
                        ]);
                    }
                    
                    // Record Stripe payment transaction
                    WalletTransactions::create([
                        'user_id' => auth()->id(),
                        'wallet_id' => $wallet->id ?? null,
                        'amount' => $payable_amount,
                        'type' => 'debit',
                        'description' => 'Card payment for ad promotions',
                        'ref' => $payment_intent,
                        'promotion_id' => $adv->id,
                        'payment_method' => 'card',
                        'payment_status' => 'completed',
                    ]);
                    
                    // Mark promotions as paid
                    $adv->promotions()->update(['paid' => 1]);
                    
                    DB::commit();
                    
                    Session::flash('success', 'Your ad is successfully posted and promoted!');
                    return redirect('dashboard/my_ads');
                    
                } else if ($payable_amount > 0) {
                    // Need card payment but not done yet - this shouldn't happen with new flow
                    // but kept as fallback for safety
                    DB::rollBack();
                    Session::flash('error', 'Payment required. Please try again.');
                    return redirect()->back()->withInput();
                    
                } else {
                    // Full wallet payment (no card needed)
                    if (!$wallet) {
                        throw new \Exception('Wallet not found');
                    }
                    
                    // Deduct from wallet
                    $wallet->decrement('balance', $deduction_amount);
                    
                    // Record transaction
                    WalletTransactions::create([
                        'user_id' => auth()->id(),
                        'wallet_id' => $wallet->id,
                        'amount' => $deduction_amount,
                        'type' => 'debit',
                        'description' => 'Payment for ad promotions (full wallet)',
                        'ref' => $adv->id,
                        'promotion_id' => $adv->id,
                        'payment_method' => 'wallet',
                        'payment_status' => 'completed',
                    ]);
                    
                    // Mark promotions as paid
                    $adv->promotions()->update(['paid' => 1]);
                    
                    DB::commit();
                    
                    Session::flash('success', 'Your ad is successfully posted and promoted!');
                    return redirect('dashboard/my_ads');
                }
                
            } else {
                // No promotions
                DB::commit();
                
                Session::flash('success', 'Your ad is successfully posted');
                return redirect('dashboard/my_ads');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Ad posting error: ' . $e->getMessage());
            
            Session::flash('error', 'Ad posting failed: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function adPromotionSuccess(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $session_id = $request->session_id;
            
            if (!$session_id) {
                throw new \Exception('Session ID missing');
            }
            
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            
            if ($session->payment_status !== 'paid') {
                throw new \Exception('Payment not completed');
            }
            
            $adv_id = $session->metadata->adv_id ?? null;
            $deduction_amount = $session->metadata->deduction_amount ?? 0;
            
            if (!$adv_id) {
                throw new \Exception('Advertisement ID missing');
            }
            
            $adv = Advertise::findOrFail($adv_id);
            
            // Mark promotions as paid
            $adv->promotions()->update(['paid' => 1]);
            
            // Complete pending wallet transaction if exists
            if ($deduction_amount > 0) {
                $pendingTransaction = WalletTransactions::where('user_id', auth()->id())
                    ->where('ref', $adv->id)
                    ->where('payment_status', 'pending')
                    ->first();
                
                if ($pendingTransaction) {
                    $wallet = Wallets::lockForUpdate()->findOrFail($pendingTransaction->wallet_id);
                    $wallet->decrement('balance', $pendingTransaction->amount);
                    $pendingTransaction->update(['payment_status' => 'completed']);
                }
            }
            
            DB::commit();
            
            Session::flash('success', 'Your ad is successfully posted and promoted!');
            return redirect('dashboard/my_ads');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Ad promotion payment error: ' . $e->getMessage());
            
            Session::flash('error', 'Payment verification failed: ' . $e->getMessage());
            return redirect('dashboard/my_ads');
        }
    }

    public function createPromotionIntent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:999999'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $amount = $request->amount;
        
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => round($amount * 100), // Convert to cents
                // 'currency' => strtolower(config('app.currency', 'usd')),
                'currency' => baseSymbol(),
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'user_id' => auth()->id(),
                    'type' => 'ad_promotion'
                ]
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
            
        } catch (\Exception $e) {
            \Log::error('Promotion payment intent creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment initialization failed: ' . $e->getMessage()], 500);
        }
    }

    public function checkDuplicateAd(Request $request)
    {
        $data = $request->all();
        // $ad = Advertise::where('title', $data['title'])->where('user_id', auth()->user()->id)->first();
        $ad = Advertise::where('title', $data['title'])->where('status', 'active')->first();
        if($ad){
            return response()->json(['status' => 1, 'message' => 'Ad already exists']);
        }
        return response()->json(['status' => 0, 'message' => 'Ad does not exist']);
    }
}
