<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelfBilledInvoiceFormRequest extends FormRequest
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
            'self_billed_invoice_uuid' => 'required|uuid',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.quantity' => 'nullable|numeric|min:0',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'items.*.total' => 'nullable|numeric|min:0',
            'customer' => 'nullable|string',
            'self_billed_invoice_no' => 'required|string',
            'self_billed_invoice_date' => 'nullable|date',
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
            'self_billed_invoice_uuid.required' => 'Self-Billed Invoice UUID is required',
            'self_billed_invoice_uuid.uuid' => 'Self-Billed Invoice UUID must be a valid UUID',
            'self_billed_invoice_no.required' => 'Self-Billed Invoice number is required',
            'items.*.quantity.numeric' => 'Item quantity must be a number',
            'items.*.quantity.min' => 'Item quantity cannot be negative',
            'items.*.unit_price.numeric' => 'Unit price must be a number',
            'items.*.unit_price.min' => 'Unit price cannot be negative',
            'items.*.description.string' => 'Item description must be text',
            'items.*.total.numeric' => 'Item total must be a number',
            'items.*.total.min' => 'Item total cannot be negative',
            'tags.string' => 'Tags must be number',
        ];
    }
}
