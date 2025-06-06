<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $fillable = ['invoice_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id', 'id');
    }
}
