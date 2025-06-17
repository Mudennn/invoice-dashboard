<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SelfBilledInvoice;

class SelfBilledInvoiceItems extends Model
{
    protected $table = 'self_billed_invoice_items';
    protected $primaryKey = 'id';
    protected $fillable = ['self_billed_invoice_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function selfBilledInvoice()
    {
        return $this->belongsTo(SelfBilledInvoice::class, 'self_billed_invoice_id', 'id');
    }
}
