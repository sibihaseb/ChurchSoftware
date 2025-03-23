<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function showPaymentForm($memberId, $amount)
    {
        $member = Member::findOrFail($memberId);
        return view('dashboard.payment', [
            'member' => $member,
            'stripeKey' => env('STRIPE_KEY'),
            'amount' => $amount,
        ]);
    }

    public function processPayment(Request $request, $memberId)
    {
        $member = Member::findOrFail($memberId);

        $paymentMethod = $request->input('payment_method');
        $amount = $request->input('amount') * 100; // Convert dollars to cents

        $member->createOrGetStripeCustomer();
        $member->charge($amount, $paymentMethod, [
            'currency' => 'usd',
            'payment_method_options' => [
                'card' => [
                    'request_three_d_secure' => 'automatic'
                ]
            ],
            'payment_method_types' => ['card'], // Only allow card payments
        ]);

        return response()->json(['message' => 'Payment Successful!']);
    }
}
