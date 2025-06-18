<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Taxes extends Model 
{
    protected $table = 'taxes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tax_code',
        'tax_type',
        'tax_rate',
        'status',
        'created_by',
        'updated_by'
    ];

  
}
