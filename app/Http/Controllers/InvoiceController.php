<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\DepositeAccount;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Member;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        $paymentmethods = PaymentMethod::all();
        $depositetos = DepositeAccount::all();
        return view('pages.invoice.create', compact('members', 'paymentmethods', 'depositetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $validatedData = $request->validated();

        // Create invoice
        dd($validatedData);
        $invoice = Invoice::create([
            'member_id' => $validatedData['member_id'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'billing_address' => $validatedData['billing_address'] ?? null,
            'sales_receipt_date' => $validatedData['sales_receipt_date'] ?? null,
            'tags' => $validatedData['tags'] ?? null,
            'payment_method' => $validatedData['payment_method'] ?? null,
            'deposit_to' => $validatedData['deposit_to'] ?? null,
        ]);
        dd($validatedData['items']);
        // Save invoice items
        foreach ($validatedData['items'] as $item) {
            dd($item);
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['qty'],
                'price' => $item['rate'],
                'amount' => $item['amount'],
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
