<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefundNote;
use App\Models\Classification;

class RefundNoteItems extends Model
{
    protected $table = 'refund_note_items';
    protected $primaryKey = 'id';
    protected $fillable = ['refund_note_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'tax_type', 'tax_code', 'tax_rate', 'excluding_tax', 'tax_amount', 'classification_code', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function refundNote()
    {
        return $this->belongsTo(RefundNote::class, 'refund_note_id', 'id');
    }
    
    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_code', 'classification_code');
    }
}
