<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SelfBilledInvoiceItems;
use App\Models\CreditNote;

class SelfBilledInvoice extends Model
{
    protected $table = 'self_billed_invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['customer', 'billing_attention', 'billing_address', 'shipping_info', 'shipping_attention', 'shipping_address', 'self_billed_invoice_no', 'self_billed_invoice_date', 'self_billed_invoice_uuid', 'reference_number', 'title', 'internal_note', 'description', 'tags', 'currency', 'control', 'status', 'created_by', 'updated_by'];

    public function selfBilledInvoiceItems()
    {
        return $this->hasMany(SelfBilledInvoiceItems::class, 'self_billed_invoice_id', 'id')->where('status', '0');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_name', 'customer_name');
    }

    public function getControlTextAttribute()
    {
        $types = [
            '1' => 'Draft',
            '2' => 'Pending',
            '3' => 'Ready',
        ];

        return $types[$this->control] ?? $this->control;
    }

    // Relationship with CreditNotes
    // public function creditNotes(): HasMany
    // {
    //     return $this->hasMany(CreditNote::class, 'invoice_no', 'invoice_no');
    // }

    // // Relationship with DebitNotes
    // public function debitNotes(): HasMany
    // {
    //     return $this->hasMany(DebitNote::class, 'invoice_no', 'invoice_no');
    // }
    
}
