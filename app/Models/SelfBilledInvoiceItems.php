<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SelfBilledInvoice;
use App\Models\Classification;

class SelfBilledInvoiceItems extends Model
{
    protected $table = 'self_billed_invoice_items';
    protected $primaryKey = 'id';
    protected $fillable = ['self_billed_invoice_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'classification_code', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function selfBilledInvoice()
    {
        return $this->belongsTo(SelfBilledInvoice::class, 'self_billed_invoice_id', 'id');
    }
    
    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'classification_code');
    }
}
