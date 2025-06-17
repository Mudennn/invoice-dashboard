<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyProfileFormRequest extends FormRequest
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
            'company_name'  => 'nullable | string',
            'other_name'  => 'nullable | string',
            'address_line_1'  => 'nullable | string',
            'address_line_2'  => 'nullable | string',
            'state'  => 'nullable',
            'city'  => 'nullable | string', 
            'postcode'  => 'nullable | string',
            'country'  => 'nullable | string',
            'email'  => 'nullable | string',
            'phone'  => 'nullable | string',
            'is_image'  => 'nullable | image | mimes:jpeg,png,jpg,gif | max:2048',
            'registration_type'  => 'nullable | string',
            'tin'  => 'nullable | string',
            'sst_registration_no'  => 'nullable | string',
            'registration_no'  => 'nullable | string',
            'old_registration_no'  => 'nullable | string',
        ];
    }
}
