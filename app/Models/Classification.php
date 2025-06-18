<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Classification extends Model 
{
    protected $table = 'classifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'classification_code',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

  
}
