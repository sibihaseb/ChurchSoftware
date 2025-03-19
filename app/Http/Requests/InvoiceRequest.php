<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->has('items') && is_string($this->items)) {
            $this->merge([
                'items' => json_decode($this->items, true) ?? [],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_id' => 'nullable|integer',
            'email' => 'nullable|email',
            'billing_address' => 'nullable|string',
            'sales_receipt_date' => 'nullable|date',
            'tags' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'deposit_to' => 'nullable|string',
            // 'items' => 'required|array|min:1', // Ensure at least one item exists
            // 'items.*.product_id' => 'required|integer|exists:products,id',
            // 'items.*.description' => 'required|string',
            // 'items.*.qty' => 'required|integer|min:1',
            // 'items.*.rate' => 'required|numeric|min:0',
            // 'items.*.amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1', // Ensure at least one item exists
            'items.*.product_id' => 'nullable|integer',
            'items.*.description' => 'nullable|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ];
    }
    /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.array' => 'Invalid format for items.',
            'items.*.product_id.required' => 'The product field is required for each item.',
            'items.*.qty.required' => 'Quantity is required for each item.',
            'items.*.qty.integer' => 'Quantity must be a valid number.',
            'items.*.qty.min' => 'Quantity must be at least 1.',
            'items.*.rate.required' => 'Rate is required for each item.',
            'items.*.rate.numeric' => 'Rate must be a valid number.',
            'items.*.rate.min' => 'Rate must be at least 0.',
            'items.*.amount.required' => 'Amount is required for each item.',
            'items.*.amount.numeric' => 'Amount must be a valid number.',
            'items.*.amount.min' => 'Amount must be at least 0.',
        ];
    }
}
