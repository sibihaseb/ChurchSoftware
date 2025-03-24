<div class="container mx-auto bg-white shadow-md p-6 rounded-lg">
    <a href="{{ route('invoice.index') }}" class="text-xl font-bold text-blue-500"><i class="ri-arrow-left-line"></i>
        Go Back
    </a>
    <div class="grid grid-cols-2 gap-4 mb-4 mt-4">
        <h2 class="text-2xl font-bold mb-4 text-blue-500">{{ __('Donor receipts') }}</h2>
    </div>


    <form wire:submit.prevent="save">
        @csrf
        <div x-data="{ showDiv: false }" class="mb-4">
            <label class="inline-flex items-center cursor-pointer">
                <!-- Use 'x-model' for reliable two-way binding -->
                <input type="checkbox" x-model="showDiv" class="sr-only peer">
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                </div>
                <span class="ms-3 block font-bold">{{ __('Create Donor') }}</span>
            </label>

            <div class="grid grid-cols-1 gap-4 mb-4 mt-4">
                <!-- Div 1: Visible when checkbox is checked -->
                <div class="grid grid-cols-2 gap-4 mb-4 mt-4" x-show="showDiv">
                    <div>
                        <label class="block font-bold">First Name</label>
                        <input type="text" wire:model="first_name" class="border-2 rounded p-2 w-full"
                            placeholder="Enter First Name">
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block font-bold">Last Name</label>
                        <input type="text" wire:model="last_name" class="border-2 rounded p-2 w-full"
                            placeholder="Enter Last Name">
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-bold">Member Type</label>
                        <select wire:model="member_type_id" class="border-2 rounded p-2 w-full">
                            <option value="">{{ __('Select Member Type') }}</option>
                            @foreach ($allmembertype as $membertype)
                                <option value="{{ $membertype->id }}">
                                    {{ $membertype->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_type_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block font-bold">Address</label>
                        <input type="text" wire:model="address" class="border-2 rounded p-2 w-full"
                            placeholder="Enter Address">
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label class="block font-bold">Email</label>
                        <input type="email" wire:model="memberemail" class="border-2 rounded p-2 w-full"
                            placeholder="Enter Email">
                        @error('memberemail')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block font-bold">Phone</label>
                        <input type="text" wire:model="phone" class="border-2 rounded p-2 w-full"
                            placeholder="Enter Phone Number">
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Church ID -->
                    <div>
                        <label class="block font-bold">Church</label>
                        <select wire:model="church_id" class="border-2 rounded p-2 w-full">
                            <option value="">{{ __('Select Church') }}</option>
                            @foreach ($churchs as $church)
                                <option value="{{ $church->id }}">
                                    {{ $church->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('church_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Div 2: Visible when checkbox is unchecked -->
                <div class="grid grid-cols-2 gap-4 mb-4 mt-4" style="max-width: 50%" x-show="!showDiv" wire:ignore.self>

                    <div>
                        <label class="block font-bold">Donor</label>
                        <select id="member_id" wire:model="member_id" class="border-2 rounded p-2 w-full">
                            <option value="">{{ __('Select Donor') }}</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->first_name . ' ' . $member->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-bold">Email</label>
                        <input type="email" wire:model="email" class="border-2 rounded p-2 w-full"
                            placeholder="Enter Email">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block font-bold">Billing Address</label>
                <input type="text" wire:model="billing_address" placeholder="Enter Address"
                    class="border-2 rounded p-2 w-full">
                @error('billing_address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-bold">Sales Receipt Date</label>
                <input type="date" wire:model="sales_receipt_date" class="border-2 rounded p-2 w-full">
                @error('sales_receipt_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-bold">Payment Method</label>
                <select wire:model="payment_method" class="border-2 rounded p-2 w-full"
                    wire:change="checkNewPaymentMethod($event.target.value)">
                    <option value="">{{ __('Select Payment Method') }}</option>
                    <option value="create_new" class="bg-green-500 text-white">+ Create New</option>
                    @foreach ($paymentmethods as $method)
                        <option value="{{ $method->id }}">
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Modal or Hidden Div for Creating New Payment Method -->
            <!-- Modal for Creating New Payment Method -->
            <div x-data="{ showNewPayment: @entangle('showNewPayment') }" x-show="showNewPayment"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                style="display: none;">
                <!-- Modal Box -->
                <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
                    <h2 class="text-lg font-bold mb-4">Create New Payment Method</h2>

                    <!-- Input Field -->
                    <input type="text" wire:model="new_payment_method" class="border-2 rounded p-2 w-full mb-2"
                        placeholder="Enter New Payment Method">
                    @error('new_payment_method')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <!-- Action Buttons -->
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="showNewPayment = false; $wire.set('payment_method', null)"
                            class="bg-gray-500 text-white px-3 py-1 rounded mr-2">
                            Cancel
                        </button>
                        <button type="button" wire:click="saveNewPaymentMethod"
                            class="bg-blue-500 text-white px-3 py-1 rounded">
                            Save Method
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <label class="block font-bold">Deposit To</label>
                <select wire:model="deposit_to" class="border-2 rounded p-2 w-full"
                    wire:change="checkNewDepositMethod($event.target.value)">
                    <option value="">{{ __('Select Deposit Method') }}</option>
                    <option value="create_new" class="bg-green-500 text-white">+ Create New</option>
                    @foreach ($depositetos as $deposite)
                        <option value="{{ $deposite->id }}">
                            {{ $deposite->name }}
                        </option>
                    @endforeach
                </select>
                @error('deposit_to')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Modal for Creating New Deposit Method -->
            <div x-data="{ showNewDeposit: @entangle('showNewDeposit') }" x-show="showNewDeposit"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                style="display: none;">
                <!-- Modal Box -->
                <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
                    <h2 class="text-lg font-bold mb-4">Create New Deposit Method</h2>

                    <!-- Input Field -->
                    <input type="text" wire:model="new_deposit_method" class="border-2 rounded p-2 w-full mb-2"
                        placeholder="Enter New Deposit Method">
                    @error('new_deposit_method')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <!-- Action Buttons -->
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="showNewDeposit = false; $wire.set('deposit_to', null)"
                            class="bg-gray-500 text-white px-3 py-1 rounded mr-2">
                            Cancel
                        </button>
                        <button type="button" wire:click="saveNewDepositMethod"
                            class="bg-blue-500 text-white px-3 py-1 rounded">
                            Save Method
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- <div>
            <label class="block font-bold">Tags</label>
            <input type="text" wire:model="tags" class="border-2 rounded p-2 w-full">
            @error('tags')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div> --}}
        <div>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">#</th>
                        <th class="border p-2">Product/Service</th>
                        <th class="border p-2">Description</th>
                        <th class="border p-2">Qty</th>
                        <th class="border p-2">Rate</th>
                        <th class="border p-2">Amount</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td class="border p-2">{{ $index + 1 }}</td>
                            <td class="border p-2">
                                <select wire:model="items.{{ $index }}.product_id"
                                    class="border-2 rounded p-1 w-full"
                                    wire:change="checkNewProduct($event.target.value)">
                                    <option value="">Select Product</option>
                                    <option value="create_new" class="bg-green-500 text-white">+ Create New</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has("items.$index.product_id"))
                                    <span
                                        class="text-red-500 text-xs">{{ $errors->first("items.$index.product_id") }}</span>
                                @endif
                            </td>

                            <!-- Modal for Creating New Product -->
                            <div x-data="{ showNewProduct: @entangle('showNewProduct') }" x-show="showNewProduct"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                    <h2 class="text-lg font-bold mb-4">Create New Product</h2>
                                    <input type="text" wire:model="new_product"
                                        class="border-2 rounded p-2 w-full mb-3" placeholder="Enter New Product Name">
                                    @error('new_product')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <div class="flex justify-end">
                                        <button type="button"
                                            @click="showNewProduct = false; $wire.set('items.{{ $index }}.product_id', null)"
                                            class="bg-gray-500 text-white px-3 py-1 rounded mr-2">
                                            Cancel
                                        </button>
                                        <button type="button" wire:click="saveNewProduct({{ $index }})"
                                            class="bg-blue-500 text-white px-3 py-1 rounded">
                                            Save Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.description"
                                    placeholder="Enter Description" class="border-2 rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <input type="number" wire:model="items.{{ $index }}.qty"
                                    wire:input="calculateAmount({{ $index }})"
                                    class="border-2 rounded p-1 w-full" min="1">
                            </td>
                            <td class="border p-2">
                                <input type="number" wire:model="items.{{ $index }}.rate"
                                    wire:input="calculateAmount({{ $index }})"
                                    class="border-2 rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">$</span>
                                    <input type="number" wire:model="items.{{ $index }}.amount"
                                        wire:input="updateTotal({{ $index }})"
                                        class="border-2 rounded p-1 w-full pl-6" min="0">
                                </div>
                            </td>

                            <td class="border p-2 text-center">
                                @if ($index > 0)
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="text-red-500"><i class="ri-delete-bin-2-line"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <!-- Add this row for Total Amount -->
                <tfoot>
                    <tr class="bg-gray-100">
                        <td colspan="5" class="border p-2 text-right font-semibold">Total Amount:</td>
                        <td class="border p-2">
                            <span class="font-semibold">$</span> {{ $this->totalAmount }}
                        </td>
                        <td class="border p-2"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="grid grid-cols-2 gap-4 mb-4 mt-4">
                <div>
                    <button type="button" wire:click="addItem" class="bg-green-500 text-white px-3 py-1 rounded">Add
                        Line</button>
                </div>
                <div class="text-right">
                    <button type="button" wire:click="save('save')"
                        class="bg-blue-500 px-3 py-1 text-white rounded">Save</button>

                    <button type="button" wire:click="save('save_and_create_new')"
                        class="bg-blue-500 text-white px-3 py-1 rounded">Save & Create New</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#member_id').select2();
    });
    $('#member_id').on('change', function(e) {
        @this.set('member_id', e.target.value);
    })
</script>
