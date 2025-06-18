<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoices;
use App\Models\Taxes;
use App\Models\Classification;

class InvoiceItems extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $fillable = ['invoice_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'status', 'currency_code', 'tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'classification_code', 'created_by', 'updated_by'];

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo(Taxes::class, 'tax', 'id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'classification_code');
    }
}
