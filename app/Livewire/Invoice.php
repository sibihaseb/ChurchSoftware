<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\Product;
use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\DepositeAccount;
use Illuminate\Validation\Rule;

class Invoice extends Component
{
    public $member_id;
    public $email;
    public $billing_address;
    public $sales_receipt_date;
    public $tags;
    public $payment_method;
    public $deposit_to;
    public $items = [];
    public $members;
    public $paymentmethods;
    public $depositetos;
    public $products;

    public function mount()
    {
        $this->items = [
            ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0]
        ];
        $this->members = Member::all();
        $this->paymentmethods = PaymentMethod::all();
        $this->depositetos = DepositeAccount::all();
        $this->products = Product::all();
    }

    public function rules()
    {
        return [
            'member_id' => 'nullable',
            'email' => 'nullable|email',
            'billing_address' => 'nullable|string',
            'sales_receipt_date' => 'nullable|date',
            'tags' => 'nullable|string',
            'payment_method' => ['nullable', Rule::exists('payment_methods', 'id')],
            'deposit_to' => ['nullable', Rule::exists('deposite_accounts', 'id')],
            'items.*.product_id' => ['required', Rule::exists('products', 'id')],
            'items.*.description' => 'nullable|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Here you can process and save the invoice
        dd($validatedData); // Debugging purpose - check validated data
    }

    public function render()
    {
        return view('livewire.invoice');
    }
}
