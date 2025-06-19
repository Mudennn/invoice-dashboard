<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
            // 'entity_type' => 'required',
            // 'customer_name' => 'nullable|string|max:255',
            // 'other_name' => 'nullable|string|max:255',
            // 'registration_number_type' => 'nullable|string|max:50',
            // 'registration_number' => 'nullable|string|max:50',
            // 'old_registration_number' => 'nullable|string|max:50',
            // 'tin' => 'nullable|string|max:50',
            // 'sst_registration_number' => 'nullable|string|max:50',
            // 'address_line_1' => 'nullable|string|max:255',
            // 'address_line_2' => 'nullable|string|max:255',
            // 'state' => 'nullable',
            // 'city' => 'nullable|string|max:100',
            // 'postcode' => 'nullable|string|max:20',
            // 'country' => 'nullable|string|max:100',
            // 'contact_name_1' => 'nullable|string|max:255',
            // 'contact_1' => 'nullable|string|max:50',
            // 'email_1' => 'nullable|email|max:255',
            // 'contact_name_2' => 'nullable|string|max:255',
            // 'contact_2' => 'nullable|string|max:50',
            // 'email_2' => 'nullable|email|max:255',
            // 'contact_name_3' => 'nullable|string|max:255',
            // 'contact_3' => 'nullable|string|max:50',
            // 'email_3' => 'nullable|email|max:255',
            'msic_code'  => 'nullable | string',
            'company_description'  => 'nullable | string',
        ];
    }
}
