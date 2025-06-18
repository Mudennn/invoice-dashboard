<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaxFormRequest extends FormRequest
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
            'tax_code' => 'required|string|max:5',
            'tax_type' => 'required|string|max:50',
            'tax_rate' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'tax_code.required' => 'The tax code is required.',
            'tax_code.string' => 'The tax code must be a string.',
            'tax_code.max' => 'The tax code must be less than 255 characters.',
            'tax_type.required' => 'The tax type is required.',
            'tax_type.string' => 'The tax type must be a string.',
            'tax_type.max' => 'The tax type must be less than 255 characters.',
            'tax_rate.required' => 'The tax rate is required.',
            'tax_rate.numeric' => 'The tax rate must be a number.',
            'tax_rate.min' => 'The tax rate must be greater than 0.'
        ];
    }
}
