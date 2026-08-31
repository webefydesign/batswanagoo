<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\AdvertiseGallery;
use App\Models\AdvertiseMessage;
use App\Models\AdvertisePromo;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\EmailChange;
use App\Models\Feedback;
use App\Models\FeedbackInvitation;
use App\Models\Performance;
use App\Models\States;
use App\Models\Subscribers;
use App\Models\User;
// use App\Models\UserPlan; // Unused - no longer gating anything on a purchased plan.
use App\Models\Wishlist;
use App\Models\Notifications;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Str;
use Illuminate\Support\Facades\DB;
use App\Models\Wallets;
use App\Models\WalletTransactions;

class DashboardController extends Controller
{
    public function index(){

    }

    public function my_ads(){

        $allAds = Advertise::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        $active = Advertise::where('user_id', auth()->user()->id)->where('status', 'active')->orderBy('created_at', 'DESC')->paginate(10);
        $pending = Advertise::where('user_id', auth()->user()->id)->where('status', 'pending')->orderBy('created_at', 'DESC')->paginate(10);
        $sold = Advertise::where('user_id', auth()->user()->id)->where('status', 'sold')->orderBy('created_at', 'DESC')->paginate(10);
        return view('frontend.dashboard.my_ads', compact('allAds', 'active', 'pending', 'sold'));
    }

    public function publishAd(Request $request)
    {
        $id = $request->id;
        $ad = Advertise::find($id);
        if ($ad->status == 'sold') {
            $ad->update(['status' => 'active']);
            adsCount($ad->category_id);
            return 0;
        } else {
            $ad->update(['status' => 'sold']);
            adsCount($ad->category_id);
            return 1;
        }
    }

    public function storeDestroy(Request $request)
    {
        $id = $request->id;
        Advertise::find($id)->delete();
        AdvertisePromo::where('adv_id', $id)->delete();
        $ad_imgs = AdvertiseGallery::where('adv_id', $id)->get();
        $uploadDir = public_path('uploads/post');
        foreach ($ad_imgs as $ad) {
            File::delete($uploadDir . '/' . $ad->image, $uploadDir . '/' . $ad->thumb_img, $uploadDir . '/' . $ad->mobile_img);
            $ad->delete();
        }
        Session::flash('success', 'Successfully deleted');
        return redirect()->route('dashboard.my_ads');
    }

    public function my_message()
    {
        $messages = AdvertiseMessage::where('user_id', auth()->user()->id)->orderBY('created_at', 'DESC')->paginate(10);
        return view('frontend.dashboard.myMsg', compact('messages'));
    }

    public function my_list()
    {
        $adv_ids = Wishlist::where('user_id', auth()->user()->id)->pluck('adv_id')->toArray();
        $ads = Advertise::whereIn('id', $adv_ids)->where('status', 'active')->paginate(10);
        return view('frontend.dashboard.my_list', compact('ads'));
    }

    public function feedback($id)
    {
        $seller = User::find($id);
        $data = Feedback::where('seller_id', $id)->with('user')->get();
        $feedBtn = FeedbackInvitation::where('seller_id', $id)->where('email', auth()->user()->email)->with('user')->get();
        return view('frontend.feedback', compact('data', 'seller', 'feedBtn'));
    }

    public function feedbackProcess(Request $request)
    {
        $data = $request->all();
        if (auth()->check() && auth()->user()->id != $request->seller_id) {
            performance($request->seller_id, ['impression']);
        }
        Feedback::create($data);
        Session::flash('success', 'Thanks You For Feedback!');
        return redirect()->back();
    }

    public function feedbackMail(Request $request)
    {
        $res = $request->all();
        $ads = Advertise::where('user_id', auth()->user()->id)->first();

        if ($ads == null) {
            Session::flash('error', 'You don\'t have any published ads to start with.');
            return redirect()->back();
        }

        $res['seller_id'] = auth()->user()->id;
        $data = FeedbackInvitation::create($res);

        $to = $request->email;
        try {
            $general_meta = getConfigurations();
            $from = ($general_meta['contact_meta']['website']) ?? env('MAIL_FROM_NAME');
            $from_mail = ($general_meta['contact_meta']['email']) ?? env('MAIL_FROM_ADDRESS');

            Mail::send('emails.feedback', compact('data'), function ($m) use ($to, $from, $from_mail) {
                $m->from($from_mail, $from);
                $m->to($to)->subject(env('Website_Name') . ' Feedback');
            });
        } catch (\Exception $e) {
            dd($e);
        }
        Session::flash('success', 'Feedback Link Send Successfully');
        return redirect()->back();
    }

    public function editPost($id)
    {
        $adv = Advertise::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if ($adv == null) {
            return redirect('postAdd');
        }
        AdvertisePromo::where('adv_id', $adv->id)->where('end_date', '<', date('Y-m-d'))->update(['expire' => 1]);
        return view('frontend.dashboard.editPost', compact('adv'));
    }

    public function storeUpdate(Request $request)
    {
        $request->validate([
            // 'category' => 'required',
            'name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'description' => 'required',
            // 'phone' => 'required',
        ]);

        DB::beginTransaction();
        
        try {
            $data = $request->all();

            $id = $data['id'];
            $adv = Advertise::updator($data, $id);
            
            if (isset($data['images']) || $request->has('deleted_images')) {
                // AdvertiseGallery::updator($data['images'], $adv);
                AdvertiseGallery::updator($request, $adv);
            }
            
            AdvertisePromo::where('adv_id', $adv->id)->where('end_date', '<', date('Y-m-d'))->update(['expire' => 1]);
            AdvertisePromo::where('adv_id', $adv->id)->where('paid', 0)->forceDelete();

            $promotions = [];
            if (isset($data['promo'])) {
                $promotions = AdvertisePromo::updator($data['promo'], $adv);
            }

            adsCount($adv->category_id);

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
                
                // Check if payment_intent exists (card payment already completed in modal)
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
                            'description' => 'Partial payment for ad promotions (wallet portion) - Edit Post',
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
                        'description' => 'Card payment for ad promotions - Edit Post',
                        'ref' => $payment_intent,
                        'promotion_id' => $adv->id,
                        'payment_method' => 'card',
                        'payment_status' => 'completed',
                    ]);
                    
                    // Mark promotions as paid
                    $adv->promotions()->where('paid', 0)->update(['paid' => 1]);
                    
                    DB::commit();
                    
                    Session::flash('success', 'Your ad is successfully updated and promoted!');
                    return redirect()->route('dashboard.my_ads');
                    
                } else if ($payable_amount > 0) {
                    // Need card payment but not done yet
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
                        'description' => 'Payment for ad promotions (full wallet) - Edit Post',
                        'ref' => $adv->id,
                        'promotion_id' => $adv->id,
                        'payment_method' => 'wallet',
                        'payment_status' => 'completed',
                    ]);
                    
                    // Mark promotions as paid
                    $adv->promotions()->where('paid', 0)->update(['paid' => 1]);
                    
                    DB::commit();
                    
                    Session::flash('success', 'Your ad is successfully updated and promoted!');
                    return redirect()->route('dashboard.my_ads');
                }
            }

            // No promotions
            DB::commit();
            
            Session::flash('success', 'Your ad is successfully updated');
            return redirect()->route('dashboard.my_ads');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Ad update error: ' . $e->getMessage());
            
            Session::flash('error', 'Ad update failed: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function performance(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $mydates = $this->dateArray($month, $year);

        $data = Performance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        $impression = $visitor = $phone_view = $chat_request = [];

        foreach ($mydates as $date) {
            if (isset($data[$date])) {
                $impression[] = $data[$date]->sum('impression');
                $visitor[] = $data[$date]->sum('visitor');
                $phone_view[] = $data[$date]->sum('phone_view');
                $chat_request[] = $data[$date]->sum('chat_request');
            } else {
                $impression[] = 0;
                $visitor[] = 0;
                $phone_view[] = 0;
                $chat_request[] = 0;
            }
        }

        $max = max([
            max($impression),
            max($visitor),
            max($phone_view),
            max($chat_request),
            1, // Ensures max is never 0
        ]);

        return view('frontend.dashboard.performance', compact('mydates', 'impression', 'visitor', 'phone_view', 'chat_request', 'max'));
    }

    function dateArray($month, $year)
    {
        $dateCount = Carbon::create($year, $month)->daysInMonth;
        return array_map(function ($i) use ($month, $year) {
            return sprintf('%04d-%02d-%02d', $year, $month, $i);
        }, range(1, $dateCount));
    }

    public function mymsg()
    {
        $messages = AdvertiseMessage::where('user_id', auth()->user()->id)->orderBY('created_at', 'DESC')->paginate(10);
        return view('frontend.dashboard.myMsg', compact('messages'));
    }

    public function mymsgDetail(Request $request)
    {
        $data = AdvertiseMessage::find($request->id);
        if ($request->has('nid')) {
            $notification = Notifications::find($request->nid);
            $notification->update(['is_read' => 1]);
        }
        return view('frontend.dashboard.msgDetail', compact('data'))->render();
    }

    public function profile()
    {
        $user = auth()->user();
        return view('frontend.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $request->validate([
            // 'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        // if (Hash::check($data['password'], $user->password)) {
        //     unset($data['password']);
        $country = Countries::find($data['country']);
        $state = States::find($data['state']);
        $city = Cities::find($data['city']);

        $data['country'] = ($country->name) ?? null;
        $data['state'] = ($state->name) ?? null;
        $data['city'] = ($city->name) ?? null;

        if ($request->file('image')) {
            $file = $request->file('image');
            $upload_dir = base_path() . '/public/uploads/profile/';
            if (!File::exists($upload_dir)) {
                File::makeDirectory($upload_dir, 0755, true);
            }
            if ($user->image != null) {
                File::delete($upload_dir . $user->image);
            }

            $exe = $file->getClientOriginalExtension();
            if ($exe == 'jpeg' || $exe == 'jpg' || $exe == 'png') {
                $filename = mt_rand(1000000, 500000000);
                $filename = $filename . '.' . $exe;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->path());
                $image->save($upload_dir . $filename);
                $data['image'] = $filename;
            }
        }

        if ($request->file('cover_image')) {
            $file = $request->file('cover_image');
            $upload_dir = base_path() . '/public/uploads/profile/';
            if ($user->image != null) {
                File::delete($upload_dir . $user->cover_image);
            }

            $exe = $file->getClientOriginalExtension();
            if ($exe == 'jpeg' || $exe == 'jpg' || $exe == 'png') {
                $filename = mt_rand(1000000, 500000000);
                $filename = $filename . '.' . $exe;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->path());
                $image->save($upload_dir . $filename);
                $data['cover_image'] = $filename;
            }
        }

        if (isset($data['subscribe']) && $data['subscribe'] == 1) {
            $subs = Subscribers::updateOrCreate(['email' => $data['email']], ['name' => $data['first_name'] . ' ' . $data['last_name'], 'email' => $data['email'], 'first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'city' => $data['city']]);
        } else {
            Subscribers::where('email', $data['email'])->delete();
        }

        User::find($user->id)->update($data);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function businessInformation()
    {
        $user = auth()->user();
        return view('frontend.dashboard.business_information', compact('user'));
    }

    public function businessInformationUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'own_delivery' => 'required',
            'about_company' => 'required',
            'company_address' => 'required',
            'working_time_start' => 'required',
            'working_time_end' => 'required',
        ]);
        $data = $request->all();
        $data['show_address_on_adds'] = isset($data['show_address_on_adds']) ? 1 : 0;
        if ($data['slug'] == null) {
            $data['slug'] = Str::slug($request->name);
        }
        $id = auth()->user()->id;
        User::find($id)->update($data);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function changeNumber()
    {
        $user = auth()->user();
        return view('frontend.dashboard.add_number', compact('user'));
    }
    public function numberUpdate(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);
        $data = $request->all();
        User::find(auth()->user()->id)->update($data);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function changeEmail()
    {
        $user = auth()->user();
        return view('frontend.dashboard.add_email', compact('user'));
    }

    public function emailUpdate(Request $request)
    {
        $data = $request->all();
        if ($request->change_email == "pending") {
            $request->validate([
                'email' => 'required|unique:users,email,' . auth()->user()->id . ',id',
            ]);
            $check = EmailChange::where('user_id', auth()->user()->id)->where('status', "Pending")->where('updated_at->addMinutes(27)', '>', Carbon::now())->first();
            if (!$check) {
                $data['name'] = auth()->user()->name;
                $data['code'] = rand(100000, 999999);
                $to = $data['email'];
                $general_meta = getConfigurations();
                $from = ($general_meta['contact_meta']['website']) ?? env('MAIL_FROM_NAME');
                $from_mail = ($general_meta['contact_meta']['email']) ?? env('MAIL_FROM_ADDRESS');
                try {
                    Mail::send('emails.emailVerifactionCode', $data, function ($m) use ($to, $from, $from_mail) {
                        $m->from($from_mail, $from);
                        $m->to($to)->subject('Verify Your Email ' . $from);
                    });
                } catch (Exception $e) {
                    Session::flash('error', $e->getMessage());
                    return redirect()->back();
                }
                $data['user_id'] = auth()->user()->id;
                $data['status'] = "Pending";
                $data['expire'] = Carbon::now()->addMinutes(3);
                EmailChange::create($data);
                Session::flash('success', 'Check Your Email And Verify');
                return redirect()->back();
            }

            Session::flash('success', 'Check Your Email OTP Already Send');
            return redirect()->back();
        }
        if ($request->change_email == "Done") {
            $request->validate([
                'otp' => 'required',
            ]);
            $check = EmailChange::where('user_id', auth()->user()->id)->where('status', 'pending')->first();
            if ($check && $check->code == $request->otp && $check->updated_at->addMinutes(27) > Carbon::now()) {
                $check->status = "Done";
                $check->update($data);

                $user = User::find(auth()->user()->id);
                $user->email = $check->email;
                $user->update();
                // $check->delete();
                Session::flash('success', 'Successfully Updated');
                return redirect()->back();
            } else {
                Session::flash('error', 'OTP Not Found');
                return redirect()->back();
            }
        }
        if ($request->change_email == "resendOTP") {
            $check = EmailChange::where('user_id', auth()->user()->id)->where('status', "Pending")->first();
            if ($check) {
                // $data['name'] = $request->name;
                $data['code'] = rand(100000, 999999);
                $to = $check->email;
                $general_meta = getConfigurations();
                $from = ($general_meta['contact_meta']['website']) ?? env('MAIL_FROM_NAME');
                $from_mail = ($general_meta['contact_meta']['email']) ?? env('MAIL_FROM_ADDRESS');
                try {
                    Mail::send('emails.emailVerifactionCode', $data, function ($m) use ($to, $from, $from_mail) {
                        $m->from($from_mail, $from);
                        $m->to($to)->subject('Verify Your Email ' . $from);
                    });
                } catch (\Exception $e) {
                    // dd($e);
                }
                $data['user_id'] = auth()->user()->id;
                $data['status'] = "Pending";
                $data['expire'] = Carbon::now()->addMinutes(3);
                // dd($data);
                EmailChange::where('user_id', auth()->user()->id)->first()->update($data);
                Session::flash('success', 'OTP Resend Successfully');
                return response()->json(array('msg' => "done"), 200);
            } else {
                Session::flash('error', 'Email Not Found');
                return redirect()->back();
            }
        }
        if ($request->change_email == "cancelRequest") {
            $check = EmailChange::where('user_id', auth()->user()->id)->where('status', "Pending")->first();
            if ($check) {
                EmailChange::where('user_id', auth()->user()->id)->first()->delete();
                Session::flash('success', 'Cancel Request Successfully');
                return response()->json(array('msg' => "done"), 200);
            } else {
                Session::flash('error', 'Email Not Found');
                return redirect()->back();
            }
        }
    }

    public function disableChats()
    {
        $user = auth()->user();
        return view('frontend.dashboard.disable_chat', compact('user'));
    }
    public function chatsUpdate(Request $request)
    {

        $data = $request->all();
        User::find(auth()->user()->id)->update($data);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function disableFeedback()
    {
        $user = auth()->user();
        return view('frontend.dashboard.disable_feedback', compact('user'));
    }
    public function feedbackUpdate(Request $request)
    {

        $data = $request->all();
        User::find(auth()->user()->id)->update($data);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function changePassword()
    {
        $user = auth()->user();
        return view('frontend.dashboard.change_password', compact('user'));
    }

    public function deleteAccount()
    {
        $user = auth()->user();
        return view('frontend.dashboard.delete_account', compact('user'));
    }

    public function deleteAccountUpdate(Request $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            $data = User::find(auth()->user()->id);
            $data->is_active = 0;
            $data->reason = $request->reason;
            $data->reason_details = $request->reason_details;
            $data->update();
            Session::flash('success', 'Successfully Deleted');
            auth()->logout();
            return redirect()->back();
        } else {
            Session::flash('error', 'password is incorrect');
            return redirect()->back();
        }
    }

    public function socialLink(){
        if(!auth()->check()){ return abort(404); }
        $user = auth()->user();
        return view('frontend.dashboard.social_link', compact('user'));
    }

    public function storeSocialLink(Request $request){
        $data = $request->except('_token');
        $user = User::find(auth()->user()->id);
        $user->update(['social_links' => $data]);
        Session::flash('success', 'Successfully Updated');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        if(isset($user->password_reset) && date('Y-m-d H:i:s',strtotime($user->password_reset.'+ 30 minute')) >= date('Y-m-d H:i:s')){
            // dd('ok');
            //if ($user->password_reset != null && diffInSec($user->password_reset) >= 0) {
            if ($request->new_password == $request->confirmation_password) {
                User::find($user->id)->update(['password' => Hash::make($request->new_password), 'password_reset' => null, 'password_rand' => null]);
                Session::flash('success', 'Password changed');
                return redirect('dashboard/profile#password-chanage');
            } else {
                Session::flash('error', 'Password does not match');
                return redirect('dashboard/profile#password-chanage');
            }
        } else {
            if (Hash::check($request->password, $user->password)) {
                if ($request->new_password == $request->confirmation_password) {
                    User::find($user->id)->update(['password' => Hash::make($request->new_password)]);

                    Session::flash('success', 'Password changed');
                    return redirect('dashboard/profile#password-chanage');
                } else {
                    Session::flash('error', 'Password does not match');
                    return redirect('dashboard/profile#password-chanage');
                }
            } else {
                Session::flash('error', 'old password is incorrect');
                return redirect('dashboard/profile#password-chanage');
            }
        }
    }

    public function notifications()
    {
        $user = auth()->user();
        $data = Notifications::where('user_id', $user['id'])->OrderBy('id', 'DESC')->paginate(10);
        return view('frontend.dashboard.notifications', compact('user', 'data'));
    }
    
    public function markReadNotification(Request $request)
    {        
        $notification = Notifications::find($request->id);
        $status = $notification->is_read == 0 ? 1 : 0;
        $notification->update(['is_read' => $status]);
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notifications::where('user_id', auth()->user()->id)->update(['is_read' => 1]);
        return redirect()->back();;
    }

    public function getUnreadChatCount()
    {
        $unreadChatCount = getUnreadChatCount();
        return view('frontend.includes.chatMessageButtton', compact('unreadChatCount'))->render();
    }


}
