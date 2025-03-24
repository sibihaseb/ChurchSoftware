<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UserRequest extends FormRequest
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
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            // 'image' => File::image(),
            'password' => 'nullable|string|min:6|confirmed'

        ];
        // if ($this->route()->getName() === 'profileupdate') {

        //     $rules['oldpassword'] = 'required';
        // }
        // if ($this->route()->getName() === 'appuser.store') {
        //     $rules['password'] = 'required|confirmed';
        // }
        // if ($this->filled('password')) {
        //     $rules['password'] = 'required|confirmed';
        // }
    }
}
