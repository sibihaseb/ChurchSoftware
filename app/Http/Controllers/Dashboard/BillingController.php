<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Church;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ServiceInvoice;
use App\Models\ServiceInvoiceItem;
use App\Http\Controllers\Controller;
use App\DataTables\DonationHistoryDataTable;
use App\Models\PaymentMethod;
use Faker\Provider\ar_EG\Payment;

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
            'product_id' => 'required',
        ]);

        $amount = $request->input('amount');

        // Redirect to the payment form with the amount
        return redirect()->route('donor.payment', [
            'member' => auth()->user()->id,
            'amount' => $amount,
            'church_id' => $request->input('church_id'),
            'product_id' => $request->input('product_id'),
        ]);
        // $this->showPaymentForm(auth()->user()->id, $amount, $request->input('church_id'), $request->input('product_id'));
    }

    public function showPaymentForm($memberId, $amount, Request $request)
    {
        // Find the member by ID
        $member = User::findOrFail($memberId);
        return view('dashboard.payment', [
            'member' => $member,
            'church_id' => $request->church_id,
            'product_id' => $request->product_id,
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

        if ($request->has('product_id') != null) {
            $paymentMethod = PaymentMethod::where('church_id', $request->input('church_id'))->where('name', 'like', '%stripe%')->first();
            if (!$paymentMethod) {
                $paymentMethod = PaymentMethod::create([
                    'name' => 'Stripe',
                    'church_id' => $request->input('church_id'),
                ]);
            }
            $invoiceCreated = ServiceInvoice::create(
                [
                    'user_id' => $memberId,
                    'sales_receipt_date' => Carbon::now(),
                    'payment_method' => $paymentMethod->id,
                    'church_id' => $request->input('church_id'),
                ]
            );

            // If the invoice is successfully created or updated
            if ($invoiceCreated) {
                // Add new items
                ServiceInvoiceItem::create([
                    'service_invoice_id' => $invoiceCreated->id,
                    'product_id' => $request->input('product_id'),
                    'amount' => $amount  / 100,
                    'quantity' => 1,
                    'church_id' => $request->input('church_id'),
                ]);
            }
        }

        return response()->json(['message' => 'Payment Successful!']);
    }

    public function donationHistory(DonationHistoryDataTable $dataTable)
    {
        return $dataTable->render('donor.index');
    }
}
