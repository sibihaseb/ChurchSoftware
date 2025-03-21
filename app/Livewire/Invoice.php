<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\Product;
use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\DepositeAccount;
use App\Models\ServiceInvoice;
use App\Models\ServiceInvoiceItem;
use Illuminate\Validation\Rule;

class Invoice extends Component
{
    public $invoiceEditId;
    public $member_id;
    public $email;
    public $billing_address;
    public $sales_receipt_date;
    public $tags;
    public $payment_method;
    public $deposit_to;
    public $items = [];
    public $edit_mode = false;

    public function mount($invoiceEditId = null)
    {
        $this->invoiceEditId = $invoiceEditId;
        if ($invoiceEditId) {
            $this->edit_mode = true;
            $invoiceData = ServiceInvoice::findOrFail($invoiceEditId);
            $itemsInvoice = $invoiceData->items()->get()->toArray();
            $this->items = $itemsInvoice;
            $this->member_id = $invoiceData->member_id;
            $this->email = $invoiceData->email;
            $this->billing_address = $invoiceData->billing_address;
            $this->sales_receipt_date = $invoiceData->sales_receipt_date;
            $this->tags = $invoiceData->tags;
            $this->payment_method = $invoiceData->payment_method;
            $this->deposit_to = $invoiceData->deposit_to;
        } else {
            $this->items = [
                ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0]
            ];
        }
    }

    public function rules()
    {
        return [
            'member_id' => ['required', Rule::exists('members', 'id')],
            'email' => 'nullable|email',
            'billing_address' => 'nullable|string',
            'sales_receipt_date' => 'required|date',
            'tags' => 'nullable|string',
            'payment_method' => ['required', Rule::exists('payment_methods', 'id')],
            'deposit_to' => ['required', Rule::exists('deposite_accounts', 'id')],
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

    public function calculateAmount($index)
    {
        $qty = $this->items[$index]['qty'] ?? 1;
        $rate = $this->items[$index]['rate'] ?? 0;
        $this->items[$index]['amount'] = $qty * $rate;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $invoiceCreated = ServiceInvoice::create([
            'member_id' => $validatedData['member_id'],
            'email' => $validatedData['email'],
            'billing_address' => $validatedData['billing_address'],
            'sales_receipt_date' => $validatedData['sales_receipt_date'],
            'tags' => $validatedData['tags'],
            'payment_method' => $validatedData['payment_method'],
            'deposit_to' => $validatedData['deposit_to'],
        ]);

        if ($invoiceCreated) {
            foreach ($validatedData['items'] as $item) {
                ServiceInvoiceItem::create([
                    'service_invoice_id' => $invoiceCreated->id,
                    'product_id' => $item['product_id'],
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'rate' => $item['rate'],
                    'amount' => $item['amount'],
                ]);
            }
        }

        if ($this->edit_mode) {
            $this->dispatch('success', __('Power of Attorney updated'));
        } else {
            $this->dispatch('success', __('Power of Attorney created'));
        }

        // Reset the form fields after successful submission
        // return redirect()->to('/admin/home');
        $this->reset();
    }

    public function render()
    {
        $members = Member::all();
        $paymentmethods = PaymentMethod::all();
        $depositetos = DepositeAccount::all();
        $products = Product::all();
        return view('livewire.invoice', compact('members', 'paymentmethods', 'depositetos', 'products'));
    }
}
