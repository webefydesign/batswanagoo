<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\EmailVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    // public function create(): Response
    // {
    //     // return Inertia::render('auth/login', [
    //     //     'canResetPassword' => Route::has('password.request'),
    //     //     'status' => session('status'),
    //     // ]);
    // }

    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function front_store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect()->to($this->getLoginRedirect());

        // return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('frontend.auth.login');
    }

    public function store_register(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->except('_token');
        $data['user_type'] = 'customer';

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'secret' => $data['password'],
            'user_type' => $data['user_type'],
            'is_active' => 1,
            'is_verified' => 0,
        ]);

        $to = $data['email'];
        $general_meta = getConfigurations();
        $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
        $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';
        try {
            Mail::to($to)->send(new EmailVerification($user, $from, $from_mail));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        Session::flash('success', 'Your account is successfully registered, please verify your email to continue.');
        return redirect(route('home', absolute: false));
    }

    public function checkEmail($email)
    {
        $check = User::where('email', decrypt($email))->first();
        if ($check) {
            if ($check->is_verified == 0) {
                $check->is_verified = 1;
                $check->save();
                $status = "success";
                $message = "Your Have Verified, Please Login";
                $data = $check->toArray();
                $to = $data['email'];
                $from = env('MAIL_FROM_NAME') ?? 'Batswana Goo';
                $from_mail = env('MAIL_FROM_ADDRESS') ?? 'noreply@batswanagoo.co.bw';
                Mail::send('emails.registration', $data, function ($m) use ($to, $from, $from_mail) {
                    $m->from($from_mail, $from);
                    $m->to($to)->subject('Your account is successfully verified');
                });
            } else {
                $status = "success";
                $message = "You Have Already Verified";
            }
        } else {
            $status = "error";
            $message = "Email Not Found";
        }        
        Session::flash($status, $message);
        return redirect('login');
    }

    protected function getLoginRedirect()
    {
        $user = Auth::user();

        // Profile incomplete
        if (profileCompletionPercentage() < 100) {
            return route('dashboard.profile');
        }

        // Profile complete
        return route('home');
    }
}
