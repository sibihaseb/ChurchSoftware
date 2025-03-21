<div class="container mx-auto bg-white shadow-md p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Sales Receipt</h2>

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div wire:ignore>
                <label class="block font-bold">Donor</label>
                <select id="member_id" wire:model="member_id" class="border rounded p-2 w-full">
                    <option value="">{{ __('Select Donar') }}</option>
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
                <input type="email" wire:model="email" class="border rounded p-2 w-full">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold">Billing Address</label>
                <textarea wire:model="billing_address" class="border rounded p-2 w-full"></textarea>
                @error('billing_address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-bold">Sales Receipt Date</label>
                <input type="date" wire:model="sales_receipt_date" class="border rounded p-2 w-full">
                @error('sales_receipt_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label class="block font-bold">Tags</label>
            <input type="text" wire:model="tags" class="border rounded p-2 w-full">
            @error('tags')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4 mt-4">
            <div>
                <label class="block font-bold">Payment Method</label>
                <select wire:model="payment_method" class="border rounded p-2 w-full">
                    <option value="">{{ __('Select Payment Method') }}</option>
                    @foreach ($paymentmethods as $method)
                        <option value="{{ $method->id }}"
                            {{ old('member_id') == $method->id || (isset($invoice) && $invoice->payment_method == $method->id) ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-bold">Deposit To</label>
                <select wire:model="deposit_to" class="border rounded p-2 w-full">
                    <option value="">{{ __('Select Deposite Method') }}</option>
                    @foreach ($depositetos as $deposite)
                        <option value="{{ $deposite->id }}"
                            {{ old('member_id') == $deposite->id || (isset($invoice) && $invoice->deposit_to == $deposite->id) ? 'selected' : '' }}>
                            {{ $deposite->name }}
                        </option>
                    @endforeach
                </select>
                @error('deposit_to')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
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
                                <select wire:model="items.{{ $index }}.product_id" class="border rounded p-1">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('deposit_to')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.description"
                                    class="border rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <input type="number" wire:model="items.{{ $index }}.qty"
                                    wire:input="calculateAmount({{ $index }})" class="border rounded p-1 w-full"
                                    min="1">
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.rate"
                                    wire:input="calculateAmount({{ $index }})"
                                    class="border rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.amount"
                                    class="border rounded p-1 w-full" readonly>
                            </td>
                            <td class="border p-2 text-center">
                                <button type="button" wire:click="removeItem({{ $index }})"
                                    class="text-red-500"><i class="ri-delete-bin-2-line"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" wire:click="addItem" class="bg-green-500 text-white px-3 py-1 rounded mt-3">Add
                Line</button>
        </div>
        <div class="flex justify-between mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
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
