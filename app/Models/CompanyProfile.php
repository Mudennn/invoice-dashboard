<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CompanyProfile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'company_profiles';

    protected $primaryKey = 'id';

    protected $fillable = ['company_name', 'other_name', 'address_line_1', 'address_line_2', 'state', 'city', 'postcode', 'country', 'email', 'phone', 'is_image', 'registration_type', 'tin', 'sst_registration_no', 'registration_no', 'old_registration_no', 'status', 'created_by', 'updated_by'];

    // Update profile picture
    public function updateProfilePicture($id, $status)
    {
        $companyProfile = CompanyProfile::find($id);
        if ($companyProfile) {
            $companyProfile->is_image = $status;
            $companyProfile->save();
        }
    }

    public function getRegistrationTypeTextAttribute()
    {
        $types = [
            '1' => 'None',
            '2' => 'BRN',
            '3' => 'NRIC',
            '4' => 'Passport',
            '5' => 'Army',
        ];

        return $types[$this->registration_type] ?? $this->registration_type;
    }
}
