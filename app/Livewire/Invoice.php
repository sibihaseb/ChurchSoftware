<?php

namespace App\Livewire;

use App\Models\Church;
use App\Models\Member;
use App\Models\Product;
use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\DepositeAccount;
use App\Models\MemberType;
use App\Models\ServiceInvoice;
use App\Models\ServiceInvoiceItem;
use Illuminate\Validation\Rule;

class Invoice extends Component
{
    public $invoiceEditId;
    public $member_id;
    public $member_type_id;
    public $first_name;
    public $last_name;
    public $address;
    public $email;
    public $memberemail;
    public $phone;
    public $church_id;
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
        $rules = [
            'member_id' => ['nullable', Rule::exists('members', 'id'), 'required_without:member_type_id'],
            'member_type_id' => 'nullable|integer',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'memberemail' => 'nullable|email',
            'phone' => 'nullable|string|min:10',
            'church_id' => 'nullable|integer',
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

        return $rules;
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

    public function save($action)
    {
        $validatedData = $this->validate();
        $member_id = null;
        if ($validatedData['member_type_id']) {
            $memberdata = Member::create([
                'member_type_id' => $validatedData['member_type_id'],
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'address' => $validatedData['address'],
                'email' => $validatedData['memberemail'],
                'phone' => $validatedData['phone'],
                'church_id' => $validatedData['church_id'],
            ]);
            $member_id = $memberdata->id;
        } else {
            $member_id = $validatedData['member_id'];
        }

        $invoiceCreated = ServiceInvoice::create([
            'member_id' => $member_id,
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

        $message = $this->edit_mode ? 'Power of Attorney updated' : 'Power of Attorney created';
        $this->dispatch('success', __($message));

        if ($action === 'save') {
            return redirect()->to('/admin/invoice');  // Redirect on "Save"
        }

        $this->reset();  // Reset form on "Save & Create New"
        // Ensure there's at least one empty item in the form
        $this->items = [
            ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0]
        ];
    }

    public function render()
    {
        $members = Member::all();
        $paymentmethods = PaymentMethod::all();
        $depositetos = DepositeAccount::all();
        $products = Product::all();
        $churchs = Church::all();
        $allmembertype = MemberType::all();
        return view('livewire.invoice', compact('members', 'paymentmethods', 'depositetos', 'products', 'churchs', 'allmembertype'));
    }

    public function messages()
    {
        return [
            'member_id.required_without' => 'Either create new donor or select donor',
            // Product ID
            'items.*.product_id.required' => 'The product field is required.',
            'items.*.product_id.exists' => 'The selected product does not exist.',

            // Description (Optional)
            'items.*.description.string' => 'The description must be a string.',

            // Quantity
            'items.*.qty.required' => 'The quantity field is required.',
            'items.*.qty.integer' => 'The quantity must be an integer.',
            'items.*.qty.min' => 'The quantity must be at least 1.',

            // Rate
            'items.*.rate.required' => 'The rate field is required.',
            'items.*.rate.numeric' => 'The rate must be a valid number.',
            'items.*.rate.min' => 'The rate cannot be negative.',

            // Amount
            'items.*.amount.required' => 'The amount field is required.',
            'items.*.amount.numeric' => 'The amount must be a valid number.',
            'items.*.amount.min' => 'The amount cannot be negative.',
        ];
    }
}
