<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'            => 'required|string',
            'account_type'  => 'nullable',
            'church_id'      => 'nullable',
            'address'      => 'nullable',
            'state_id'      => 'nullable',
            'postal_code'      => 'nullable',
            'country_id'      => 'nullable',
            'role'          => 'nullable',
            'city'          => 'nullable',
            'status'          => 'required',
        ];

        if ($this->route()->getName() === 'doners.update') {
            $rules['email'] = 'required|email';
        }
        if ($this->route()->getName() === 'doners.store') {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|confirmed';
        }
        if ($this->filled('password')) {
            $rules['password'] = 'required|confirmed';
        }
        return $rules;
    }
}
