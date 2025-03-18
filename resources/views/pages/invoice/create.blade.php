@extends('layouts.master')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Sales Receipt</h2>

        <form method="POST" action="{{ route('invoice.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-bold">Donor</label>
                    <select name="donor_id" class="border rounded p-2 w-full">
                        <option value="">Choose a donor</option>
                        {{-- Populate with donors --}}
                    </select>
                </div>
                <div>
                    <label class="block font-bold">Email</label>
                    <input type="email" name="email" class="border rounded p-2 w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-bold">Billing Address</label>
                    <textarea name="billing_address" class="border rounded p-2 w-full"></textarea>
                </div>
                <div>
                    <label class="block font-bold">Sales Receipt Date</label>
                    <input type="date" name="sales_receipt_date" class="border rounded p-2 w-full">
                </div>
            </div>

            <div>
                <label class="block font-bold">Tags</label>
                <input type="text" name="tags" class="border rounded p-2 w-full">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-bold">Payment Method</label>
                    <select name="payment_method" class="border rounded p-2 w-full">
                        <option value="">Choose payment method</option>
                        {{-- Populate payment methods --}}
                    </select>
                </div>
                <div>
                    <label class="block font-bold">Deposit To</label>
                    <select name="deposit_to" class="border rounded p-2 w-full">
                        <option value="">Choose account</option>
                        {{-- Populate accounts --}}
                    </select>
                </div>
            </div>

            @livewire('invoice-items')

            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
