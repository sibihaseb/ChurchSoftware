<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Church;
use App\Models\Member;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function paymentpage()
    {
        $churches = Church::all();
        $allProducts = Product::get()->groupBy('church_id');
        return view('donor.donate', compact('churches', 'allProducts'));
    }

    public function donorPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'church_id' => 'required',
        ]);

        $amount = $request->input('amount');

        // Redirect to the payment form with the amount
        $this->showPaymentForm(auth()->user()->id, $amount);
        // return redirect()->route('donor.payment', ['member' => auth()->user()->id, 'amount' => $amount]);
    }

    public function showPaymentForm($memberId, $amount)
    {
        $member = User::findOrFail($memberId);
        return view('dashboard.payment', [
            'member' => $member,
            'stripeKey' => env('STRIPE_KEY'),
            'amount' => $amount,
        ]);
    }

    public function processPayment(Request $request, $memberId)
    {
        $member = User::findOrFail($memberId);

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
