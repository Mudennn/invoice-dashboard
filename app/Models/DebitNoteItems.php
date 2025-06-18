<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DebitNote;
use App\Models\Classification;

class DebitNoteItems extends Model
{
    protected $table = 'debit_note_items';
    protected $primaryKey = 'id';
    protected $fillable = ['debit_note_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal','tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'classification_code', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function debitNote()
    {
        return $this->belongsTo(DebitNote::class, 'debit_note_id', 'id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'classification_code');
    }
}
