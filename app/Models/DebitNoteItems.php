<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DebitNote;

class DebitNoteItems extends Model
{
    protected $table = 'debit_note_items';
    protected $primaryKey = 'id';
    protected $fillable = ['debit_note_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal','tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function debitNote()
    {
        return $this->belongsTo(DebitNote::class, 'debit_note_id', 'id');
    }
}
