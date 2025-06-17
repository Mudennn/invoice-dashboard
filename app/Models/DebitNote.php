<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Invoices;
use App\Models\DebitNoteItems;

class DebitNote extends Model
{
    protected $table = 'debit_notes';
    protected $primaryKey = 'id';
    protected $fillable = ['customer', 'billing_attention', 'billing_address', 'shipping_info', 'shipping_attention', 'shipping_address', 'invoice_no', 'invoice_uuid', 'debit_note_no', 'debit_note_date', 'reference_number', 'title', 'internal_note', 'description', 'tags', 'currency', 'control', 'status', 'created_by', 'updated_by'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoices::class, 'invoice_no', 'invoice_no');
    }

    public function debitItems()
    {
        return $this->hasMany(DebitNoteItems::class);
    }

    public function getControlTextAttribute()
    {
        $types = [
            '1' => 'Draft',
            '2' => 'Pending',
            '3' => 'Ready',
        ];

        return $types[$this->control] ?? $this->control;
    }
}
