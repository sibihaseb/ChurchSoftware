<div class="container mx-auto bg-white shadow-md p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Sales Receipt</h2>

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold">Donor</label>
                <select wire:model="member_id" class="border rounded p-2 w-full">
                    <option selected disabled>{{ __('Select Donar') }}</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                            {{ old('member_id') == $member->id || (isset($invoice) && $invoice->member_id == $member->id) ? 'selected' : '' }}>
                            {{ $member->first_name . ' ' . $member->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold">Email</label>
                <input type="email" wire:model="email" name="email" class="border rounded p-2 w-full">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold">Billing Address</label>
                <textarea name="billing_address" wire:model="billing_address" class="border rounded p-2 w-full"></textarea>
            </div>
            <div>
                <label class="block font-bold">Sales Receipt Date</label>
                <input type="date" name="sales_receipt_date" wire:model="sales_receipt_date"
                    class="border rounded p-2 w-full">
            </div>
        </div>

        <div>
            <label class="block font-bold">Tags</label>
            <input type="text" name="tags" wire:model="tags" class="border rounded p-2 w-full">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold">Payment Method</label>
                <select name="payment_method" wire:model="payment_method" class="border rounded p-2 w-full">
                    <option selected disabled>{{ __('Select Payment Method') }}</option>
                    @foreach ($paymentmethods as $method)
                        <option value="{{ $method->id }}"
                            {{ old('member_id') == $method->id || (isset($invoice) && $invoice->payment_method == $method->id) ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold">Deposit To</label>
                <select name="deposit_to" class="border rounded p-2 w-full">
                    <option selected disabled>{{ __('Select Deposite Method') }}</option>
                    @foreach ($depositetos as $deposite)
                        <option value="{{ $deposite->id }}"
                            {{ old('member_id') == $deposite->id || (isset($invoice) && $invoice->deposit_to == $deposite->id) ? 'selected' : '' }}>
                            {{ $deposite->name }}
                        </option>
                    @endforeach
                </select>
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
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.description"
                                    class="border rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <input type="number" wire:model="items.{{ $index }}.qty"
                                    class="border rounded p-1 w-full" min="1">
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.rate"
                                    class="border rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model="items.{{ $index }}.amount"
                                    class="border rounded p-1 w-full">
                            </td>
                            <td class="border p-2">
                                <button type="button" wire:click="removeItem({{ $index }})"
                                    class="text-red-500">Remove</button>
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
