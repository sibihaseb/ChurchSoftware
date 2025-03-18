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
                            class="border rounded p-1 w-full" readonly>
                    </td>
                    <td class="border p-2">
                        <input type="text" wire:model="items.{{ $index }}.amount"
                            class="border rounded p-1 w-full" readonly>
                    </td>
                    <td class="border p-2">
                        <button wire:click="removeItem({{ $index }})" class="text-red-500">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button wire:click="addItem" class="bg-green-500 text-white px-3 py-1 rounded mt-3">Add Line</button>
</div>
