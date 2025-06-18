<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditNoteFormRequest extends FormRequest
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
            'credit_note_no' => 'required|string',
            'invoice_uuid' => 'required|uuid',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.quantity' => 'nullable|numeric|min:0',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'items.*.total' => 'nullable|numeric|min:0',
            'items.*.excluding_tax' => 'nullable|numeric|min:0',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.tax_type' => 'nullable|string',
            'items.*.tax_code' => 'nullable|string',
            'items.*.tax_rate' => 'nullable|numeric|min:0',
            'customer' => 'nullable|string',
            'invoice_no' => 'required|string',
            'invoice_date' => 'nullable|date',
            'billing_attention' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'shipping_info' => 'nullable|string',
            'shipping_attention' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'reference_number' => 'nullable|string',
            'title' => 'nullable|string',
            'internal_note' => 'nullable|string',
            'description' => 'nullable|string',
            'tags' => 'nullable|numeric',
            'control' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'credit_note_no.required' => 'Credit note number is required',
            'invoice_uuid.required' => 'Invoice UUID is required',
            'invoice_uuid.uuid' => 'Invoice UUID must be a valid UUID',
            'invoice_no.required' => 'Invoice number is required',
            'items.*.quantity.numeric' => 'Item quantity must be a number',
            'items.*.quantity.min' => 'Item quantity cannot be negative',
            'items.*.unit_price.numeric' => 'Unit price must be a number',
            'items.*.unit_price.min' => 'Unit price cannot be negative',
            'items.*.description.string' => 'Item description must be text',
            'items.*.total.numeric' => 'Item total must be a number',
            'items.*.total.min' => 'Item total cannot be negative',
            'tags.string' => 'Tags must be number',
            'items.*.excluding_tax.numeric' => 'Excluding tax must be a number',
            'items.*.excluding_tax.min' => 'Excluding tax cannot be negative',
            'items.*.tax_amount.numeric' => 'Tax amount must be a number',
            'items.*.tax_amount.min' => 'Tax amount cannot be negative',
            'items.*.tax_type.string' => 'Tax type must be text',
            'items.*.tax_code.string' => 'Tax code must be text',
            'items.*.tax_rate.numeric' => 'Tax rate must be a number',
            'items.*.tax_rate.min' => 'Tax rate cannot be negative',
        ];
    }
}
