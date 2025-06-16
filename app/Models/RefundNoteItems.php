<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CreditNote;

class RefundNoteItems extends Model
{
    protected $table = 'refund_note_items';
    protected $primaryKey = 'id';
    protected $fillable = ['refund_note_id', 'quantity', 'description', 'unit_price', 'amount', 'total', 'subtotal', 'status', 'currency_code', 'created_by', 'updated_by'];

    public function refundNote()
    {
        return $this->belongsTo(RefundNote::class, 'refund_note_id', 'id');
    }
}
