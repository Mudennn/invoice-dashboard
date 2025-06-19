<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Msic;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ['entity_type', 'customer_name', 'other_name','registration_number_type', 'registration_number', 'old_registration_number', 'tin', 'sst_registration_number','address_line_1', 'address_line_2', 'state', 'city', 'postcode', 'country', 'contact_name_1', 'contact_1', 'email_1', 'contact_name_2', 'contact_2', 'email_2', 'contact_name_3', 'contact_3', 'email_3', 'msic_code', 'company_description', 'status', 'created_by', 'updated_by'];

    public function getEntityTypeTextAttribute()
    {
        $types = [
            '1' => 'Company',
            '2' => 'Individual',
            '3' => 'General Public',
            '4' => 'Foreign Company',
            '5' => 'Foreign Individual',
            '6' => 'Exempted Person',
        ];

        return $types[$this->entity_type] ?? $this->entity_type;
    }

    public function getRegistrationNumberTypeTextAttribute()
    {
        $types = [
            '1' => 'None',
            '2' => 'BRN',
            '3' => 'NRIC',
            '4' => 'Passport',
            '5' => 'Army',
        ];

        return $types[$this->registration_number_type] ?? $this->registration_number_type;
    }

    public function msic()
    {
        return $this->belongsTo(Msic::class, 'msic_code', 'id');
    }
}
