<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CreditNote;
use App\Models\Classification;

class CreditNoteItems extends Model
{
    protected $table = 'credit_note_items';
    protected $primaryKey = 'id';
    protected $fillable = ['credit_note_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'classification_code', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function creditNote()
    {
        return $this->belongsTo(CreditNote::class, 'credit_note_id', 'id');
    }
    
    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'classification_code');
    }
}
