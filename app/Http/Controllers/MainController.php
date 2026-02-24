<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MainController extends Controller
{
    public function loginPage() : View
    {
        return view('login');
    }

    public function loginSubmit($id)
    {
        $user = User::findOrFail($id);
        if($user) {
            auth()->login($user);
            return redirect()->route('plans');
        }
        
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function plans(): View
    {
        $prices = [
            'monthly' => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_MONTHLY_PRICE_ID')),
            'yearly' => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_YEARLY_PRICE_ID')),
            'three_year' => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_THREE_YEAR_PRICE_ID')),
        ];

        return view('plans', compact('prices'));
    }

    public function selectPlan($id)
    {
        // check if id is valid
        $plan = Crypt::decryptString($id);
        if(!$plan)
            return redirect()->route('plans');

        $plan= explode('|', $plan);
        $productId = $plan[0];
        $priceId = $plan[1];

        return auth()->user()
            ->newSubscription($productId, $priceId)
            ->checkout([
                'success_url' => route('subscription.succcess'),
                'cancel_url' => route('plans'),
            ]);
    }

    public function subscriptionSuccess()
    {
        return view('subscription_success');
    }

    public function dashboard()
    {
        $data = [];

        // check subscription expiration
        $timestamp = auth()->user()->subscription(env('STRIPE_PRODUCT_ID'))
                            ->asStripeSubscription()
                            ->items->data[0]?->current_period_end;

        $data['subscription_end'] = date('d/m/Y H:i:s', $timestamp);

        // get invoices
        $invoices = auth()->user()->invoices();
        $data['invoices'] = $invoices;

        return view('dashboard', $data);
    }

    public function invoiceDownload($id)
    {
        // return auth()->user()->downloadInvoice($id);
        return auth()->user()->downloadInvoice($id, [
            'vendor' => 'Maus Inc',
            'product' => 'Laravel Cashier Monthly Plan'
        ]);
    }
}
