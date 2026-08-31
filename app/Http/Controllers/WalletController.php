<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransactions;
use App\Models\Wallets;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = WalletTransactions::where('user_id', auth()->id())
            ->where('payment_status', 'completed')
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        return view('frontend.dashboard.wallet', compact('transactions'));
    }

    public function createIntent(Request $request)
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
                'amount' => $amount * 100,
                // 'currency' => strtolower(config('app.currency', 'usd')), // Use currency code like 'usd', not symbol
                'currency' => baseSymbol(),
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'user_id' => auth()->id(),
                    'type' => 'wallet_recharge'
                ]
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment initialization failed: ' . $e->getMessage()], 500);
        }
    }
    
    public function confirmPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:999999',
            'payment_method' => 'required|in:card,bank,orange',
            'bank_receipt' => 'required_if:payment_method,bank|image|mimes:jpeg,jpg,png,webp|max:2048',
            'orange_receipt' => 'required_if:payment_method,orange|image|mimes:jpeg,jpg,png,webp|max:2048',
            'payment_intent' => 'required_if:payment_method,card|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $amount = $request->amount;
        
        DB::beginTransaction();
        
        try {
            if ($request->payment_method !== 'card') {
                // Handle bank/orange money payments
                $status = 'pending';
                $ref = '';
                
                if ($request->payment_method == 'bank' && $request->hasFile('bank_receipt')) {
                    $ref = $this->uploadReceipt($request->file('bank_receipt'));
                }
                
                if ($request->payment_method == 'orange' && $request->hasFile('orange_receipt')) {
                    $ref = $this->uploadReceipt($request->file('orange_receipt'));
                }
                
                // Get or create wallet (without updating balance yet - pending approval)
                $wallet = Wallets::firstOrCreate(
                    ['user_id' => auth()->id()],
                    ['balance' => 0]
                );
                
                WalletTransactions::create([
                    'user_id' => auth()->id(),
                    'wallet_id' => $wallet->id,
                    'amount' => $amount,
                    'type' => 'credit',
                    'description' => 'Added ' . number_format($amount, 2) . ' to wallet with ' . $request->payment_method,
                    'ref' => $ref,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $status,
                ]);
                
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Payment submitted for verification']);
                
            } else {
                // Handle Stripe card payments
                $payment_intent = $request->payment_intent;
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
                $payment = \Stripe\PaymentIntent::retrieve($payment_intent);
                
                if ($payment->status !== 'succeeded') {
                    throw new \Exception('Payment not successful');
                }
                
                // Get or create wallet and update balance atomically
                $wallet = Wallets::lockForUpdate()->firstOrCreate(
                    ['user_id' => auth()->id()],
                    ['balance' => 0]
                );
                
                $wallet->increment('balance', $amount);
                
                WalletTransactions::create([
                    'user_id' => auth()->id(),
                    'wallet_id' => $wallet->id,
                    'amount' => $amount,
                    'type' => 'credit',
                    'description' => 'Added ' . number_format($amount, 2) . ' to wallet with Card Payment',
                    'ref' => $payment_intent,
                    'payment_method' => 'card',
                    'payment_status' => 'completed',
                ]);
                
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Payment successful']);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Payment confirmation failed: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Upload payment receipt
     */
    private function uploadReceipt($file)
    {
        $upload_dir = public_path('uploads/wallet/');
        
        if (!File::exists($upload_dir)) {
            File::makeDirectory($upload_dir, 0755, true);
        }

        $exe = $file->getClientOriginalExtension();
        $allowed = ['jpeg', 'jpg', 'png', 'webp'];
        
        if (!in_array(strtolower($exe), $allowed)) {
            throw new \Exception('Invalid file type');
        }
        
        $filename = Carbon::now()->format('Ymd') . '_' . uniqid() . '.' . $exe;
        $file->move($upload_dir, $filename);
        
        return $filename;
    }
    
    /**
     * Admin: Approve pending wallet transaction
     */
    public function approveTransaction($transactionId)
    {
        DB::beginTransaction();
        
        try {
            $transaction = WalletTransactions::lockForUpdate()->findOrFail($transactionId);
            
            if ($transaction->payment_status !== 'pending') {
                throw new \Exception('Transaction already processed');
            }
            
            $wallet = Wallets::lockForUpdate()->findOrFail($transaction->wallet_id);
            $wallet->increment('balance', $transaction->amount);
            
            $transaction->update(['payment_status' => 'completed']);
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Transaction approved']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
