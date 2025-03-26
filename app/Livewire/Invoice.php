<?php

namespace App\Livewire;

use App\Models\Church;
use App\Models\Country;
use App\Models\Product;
use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\DepositeAccount;
use App\Models\MemberType;
use App\Models\ServiceInvoice;
use App\Models\ServiceInvoiceItem;
use App\Models\TemporaryAppCode;
use App\Models\User;
use App\Models\USStates;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Invoice extends Component
{
    public $invoiceEditId;
    public $member_id;
    public $member_type_id;
    public $first_name;
    public $last_name;
    public $city;
    public $state_id;
    public $postal_code;
    public $country_id;
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
    public $totalAmount;
    public $new_payment_method;
    public $showNewPayment = false;
    public $paymentmethods;
    public $depositetos;
    public $new_deposit_method;
    public $showNewDeposit = false;
    public $new_product;
    public $showNewProduct = false;
    public $products;

    public function mount($invoiceEditId = null)
    {
        $this->invoiceEditId = $invoiceEditId;
        $this->paymentmethods = PaymentMethod::all();
        $this->depositetos = DepositeAccount::all();
        $this->products = Product::all();

        if ($invoiceEditId) {
            $this->edit_mode = true;
            $invoiceData = ServiceInvoice::findOrFail($invoiceEditId);
            $this->items = $invoiceData->items()->get()->toArray();
            $this->member_id = $invoiceData->user_id;
            $this->email = $invoiceData->email;
            $this->billing_address = $invoiceData->billing_address;
            $this->sales_receipt_date = $invoiceData->sales_receipt_date;
            $this->tags = $invoiceData->tags;
            $this->payment_method = $invoiceData->payment_method;
            $this->deposit_to = $invoiceData->deposit_to;
            $this->totalAmount = array_sum(array_column($this->items, 'amount'));
        } else {

            $this->items = [
                ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0]
            ];
        }
    }

    public function rules()
    {
        $rules = [
            // 'member_id' => ['nullable', Rule::exists('members', 'id'), 'required_without:member_type_id'],
            'member_id' => ['nullable', Rule::exists('users', 'id'), 'required_without:first_name'],
            // 'member_type_id' => 'nullable|integer',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'memberemail' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')
            ],
            'phone' => 'nullable|string|min:10',
            'country_id' => 'nullable|string',
            'city' => 'nullable|string',
            'state_id' => 'nullable|string',
            'postal_code' => 'nullable|string',
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
        // Automatically calculate amount if both qty and rate are present
        // Validate inputs: Ensure numeric values greater than or equal to 0
        if (is_numeric($qty) && $qty >= 0 && is_numeric($rate) && $rate >= 0) {
            $this->items[$index]['amount'] = $qty * $rate;
        } else {
            $this->items[$index]['amount'] = 0; // Reset amount if invalid input
        }
        $this->updateTotal();
    }

    public function save($action)
    {
        $validatedData = $this->validate();
        $member_id = null;
        $currentApp = TemporaryAppCode::where('user_id', auth()->user()->id)
            ->first();
        if ($validatedData['first_name'] && $validatedData['last_name'] && $validatedData['memberemail']) {
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
            $memberdata = User::create([
                'account_type' => "d",
                'name' => $validatedData['first_name'] . " " . $validatedData['last_name'],
                'password' => Hash::make($password),
                'address' => $validatedData['address'],
                'email' => $validatedData['memberemail'],
                'phone' => $validatedData['phone'],
                'country_id' => $validatedData['country_id'],
                'city' => $validatedData['city'],
                'state_id' => $validatedData['state_id'],
                'postal_code' => $validatedData['postal_code'],
                'church_id' => $currentApp->church_id,
            ]);
            $member_id = $memberdata->id;
        } else {
            $member_id = $validatedData['member_id'];
        }

        $invoiceCreated = ServiceInvoice::updateOrCreate(
            ['id' => $this->invoiceEditId], // Check if an invoice exists with this ID
            [
                'user_id' => $member_id,
                'email' => $validatedData['email'],
                'billing_address' => $validatedData['billing_address'],
                'sales_receipt_date' => $validatedData['sales_receipt_date'],
                'tags' => $validatedData['tags'],
                'payment_method' => $validatedData['payment_method'],
                'deposit_to' => $validatedData['deposit_to'],
                'church_id' => $currentApp->church_id,
            ]
        );

        // If the invoice is successfully created or updated
        if ($invoiceCreated) {
            // First, delete existing items if updating
            if ($this->invoiceEditId) {
                ServiceInvoiceItem::where('service_invoice_id', $invoiceCreated->id)->delete();
            }

            // Add new items
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

        $paymentmethoddata = PaymentMethod::find($validatedData['payment_method']);

        if ($paymentmethoddata->name == 'stripe') {
            $totalAmount = array_sum(array_column($validatedData['items'], 'amount'));
            return redirect()->route('show.payment', ['member' => $member_id, 'amount' => $totalAmount]);
        }

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
        $currentApp = TemporaryAppCode::where('user_id', auth()->user()->id)
            ->first();
        $members = User::where('account_type', 'd')
            ->whereRaw("FIND_IN_SET(?, church_id)", [$currentApp->church_id])
            ->get();
        $churchs = Church::all();
        $allmembertype = MemberType::all();

        $countries = Country::all();
        $states = USStates::all();

        return view('livewire.invoice', compact('members', 'churchs', 'allmembertype', 'countries', 'states'));
    }

    public function updateTotal($index = null)
    {
        // If the amount is manually updated
        if (!is_null($index)) {
            $qty = $this->items[$index]['qty'] ?? 0;
            $rate = $this->items[$index]['rate'] ?? 0;
            $amount = $this->items[$index]['amount'] ?? 0;

            // Check if the manually entered amount differs from the calculated value
            if ($qty == "") {
                $this->items[$index]['amount'] = $amount;
            } elseif ($rate == "") {
                $this->items[$index]['amount'] = $amount;
            } elseif ($qty * $rate !== $amount) {
                $this->items[$index]['amount'] = $amount;
            }
        }

        $this->totalAmount = array_sum(array_column($this->items, 'amount'));
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

    public function checkNewPaymentMethod($value)
    {
        if ($value === 'create_new') {
            $this->showNewPayment = true;
        } else {
            $this->showNewPayment = false;
        }
    }

    public function checkNewDepositMethod($value)
    {
        $this->showNewDeposit = ($value === 'create_new');
    }

    public function saveNewPaymentMethod()
    {
        $this->validate([
            'new_payment_method' => 'required|string',
        ]);
        $currentApp = TemporaryAppCode::where('user_id', auth()->user()->id)
            ->first();
        $newMethod = PaymentMethod::create(['name' => $this->new_payment_method, 'church_id' => $currentApp->church_id]);
        $this->paymentmethods = PaymentMethod::all(); // Refresh the list
        $this->payment_method = $newMethod->id;
        $this->new_payment_method = '';
        $this->showNewPayment = false;
    }

    public function saveNewDepositMethod()
    {
        $this->validate([
            'new_deposit_method' => 'required|string',
        ]);
        $currentApp = TemporaryAppCode::where('user_id', auth()->user()->id)
            ->first();
        // Create new deposit method
        $newMethod = DepositeAccount::create(['name' => $this->new_deposit_method, 'church_id' => $currentApp->church_id]);

        // Refresh the list and select the new method
        $this->depositetos = DepositeAccount::all();
        $this->deposit_to = $newMethod->id;

        // Reset input field and modal visibility
        $this->new_deposit_method = '';
        $this->showNewDeposit = false;
    }

    public function checkNewProduct($value)
    {
        if ($value === 'create_new') {
            $this->showNewProduct = true;
        } else {
            $this->showNewProduct = false;
        }
    }

    public function saveNewProduct($index)
    {
        $this->validate([
            'new_product' => 'required|string|unique:products,name',
        ]);
        $currentApp = TemporaryAppCode::where('user_id', auth()->user()->id)
            ->first();
        $newProduct = Product::create(['name' => $this->new_product, 'church_id' => $currentApp->church_id]);
        $this->products = Product::all(); // Refresh the product list
        $this->items[$index]['product_id'] = $newProduct->id; // Set the newly created product
        $this->new_product = '';
        $this->showNewProduct = false;
    }
}
