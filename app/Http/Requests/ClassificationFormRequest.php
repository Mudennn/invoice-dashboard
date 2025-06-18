<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassificationFormRequest extends FormRequest
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
            'classification_code' => 'required|string|max:5',
            'description' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'classification_code.required' => 'The classification code is required.',
            'classification_code.string' => 'The classification code must be a string.',
            'classification_code.max' => 'The classification code must be less than 255 characters.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must be less than 255 characters.',
        ];
    }
}
