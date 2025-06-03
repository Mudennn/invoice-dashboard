<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoices extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['customer', 'invoice_no', 'invoice_date', 'invoice_uuid', 'title', 'internal_note', 'description', 'tags', 'currency', 'control', 'status', 'created_by', 'updated_by'];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItems::class, 'invoice_id', 'id')->where('status', '0');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_name', 'customer_name');
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
