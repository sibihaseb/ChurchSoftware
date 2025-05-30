<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
class ChurchRequest extends FormRequest
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
            'name'    =>  'required|string',
            'address'    =>  'nullable|string',
            'logo' => File::image(),
            'oldimage' => 'nullable',
            'us_status_id'      => 'nullable',
            'country_id'      => 'nullable',
        ];

        return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'description.required' => __('The Bio Field is required')
    //     ];
    // }
}
