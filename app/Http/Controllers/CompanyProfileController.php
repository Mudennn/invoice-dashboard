<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use App\Models\Selections;
use App\Http\Requests\CompanyProfileFormRequest;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Msic;

class CompanyProfileController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $company_profile = CompanyProfile::select(
			'company_profiles.*'
			, 'state.selection_data as s_state' 
		)
		->leftJoin('selections as state', 'company_profiles.state', '=', 'state.id')
		->where('company_profiles.status', '0')
		->first();
        
        // Debug: Check if we have a company profile
        if ($company_profile) {
            // We have a profile, show it
            return view('company_profile.index', compact('company_profile'));
        } else {
            // No profile found, redirect to create
            return redirect()->route('company_profile.create');
        }
    }

    public function create()
    {        
        $existingProfile = CompanyProfile::where('status', '0')->first();
        if ($existingProfile) {
            Alert::toast('A company profile already exists. Please edit the existing profile.', 'info');
            return redirect()->route('company_profile.index');
        }
        
        $company_profile = new CompanyProfile();
    	$states = Selections::select('id', 'selection_data')->where('selection_type', 'state')->where('status', '0')->get();
        $msics = Msic::select('id', 'msic_code', 'description')->where('status', '0')->get();
        $ro = ''; 
        
        return view('company_profile.create', compact('company_profile', 'states', 'msics', 'ro'));
    }
    
    public function store(CompanyProfileFormRequest $request)
    {

        try {
            DB::beginTransaction();

        // $user = Auth::user();
        
        $company_profile = CompanyProfile::create([  
                 'company_name'  => $request->company_name,
                 'other_name'  => $request->other_name,
                 'address_line_1'  => $request->address_line_1,
                 'address_line_2'  => $request->address_line_2,
                 'state'  => $request->state,
                 'city'  => $request->city,
                 'postcode'  => $request->postcode,
                 'country'  => $request->country,
                 'email'  => $request->email,
                 'phone'  => $request->phone,
                 'msic_code'  => $request->msic_code,
                 'company_description'  => $request->company_description,
                 'tin'  => $request->tin,
                 'registration_type'  => $request->registration_type,
                 'sst_registration_no'  => $request->sst_registration_no,
                 'registration_no'  => $request->registration_no,
                 'old_registration_no'  => $request->old_registration_no,
                 'status' => '0',
                 // 'created_by' => $user->id
            ]);

            if ($request->hasFile('is_image') && $request->file('is_image')->isValid()) {
                $company_profile->addMediaFromRequest('is_image')->toMediaCollection('is_image');
                $company_profile->updateProfilePicture($company_profile->id, 1);
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company Profile created successfully',
                    'redirect' => route('company_profile.index'),
                ]);
            }

            Alert::toast('Company Profile created successfully', 'success');
            return redirect()->route('company_profile.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast('Failed to create company profile: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
    
    public function edit($id)
    {
        $company_profile = CompanyProfile::findOrFail($id);
    	$states = Selections::select('id', 'selection_data')->where('selection_type', 'state')->where('status', '0')->get();
        $msics = Msic::select('id', 'msic_code', 'description')->where('status', '0')->get();
        $ro = ''; 
        
        return view('company_profile.edit', compact('company_profile', 'states', 'msics', 'ro'));
    }
    
    public function update(CompanyProfileFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();

        // $user = Auth::user();

        $company_profile = CompanyProfile::where('id', $id)
            ->update([
                 'company_name'  => $request->company_name,
                 'other_name'  => $request->other_name,
                 'address_line_1'  => $request->address_line_1,
                 'address_line_2'  => $request->address_line_2,
                 'state'  => $request->state,
                 'city'  => $request->city,
                 'postcode'  => $request->postcode,
                 'country'  => $request->country,
                 'email'  => $request->email,
                 'phone'  => $request->phone,
                 'msic_code'  => $request->msic_code,
                 'company_description'  => $request->company_description,
                 'registration_type'  => $request->registration_type,
                 'tin'  => $request->tin,
                 'sst_registration_no'  => $request->sst_registration_no,
                 'registration_no'  => $request->registration_no,
                 'old_registration_no'  => $request->old_registration_no,
                 'status' => '0',
                 // 'updated_by' => $user->id
            ]);

            if ($request->hasFile('is_image') && $request->file('is_image')->isValid()) {
                $company_profile = CompanyProfile::findOrFail($id);
                $company_profile->clearMediaCollection('is_image');
                $company_profile->addMediaFromRequest('is_image')->toMediaCollection('is_image');
                $company_profile->updateProfilePicture($id, 1);
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company Profile updated successfully',
                    'redirect' => route('company_profile.index'),
                ]);
            }

            Alert::toast('Company Profile updated successfully', 'success');
            return redirect()->route('company_profile.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast('Failed to update company profile: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }

      
    public function destroy($id)
    {
        // Instead of soft deleting, we'll keep the profile but mark it for recreation
        try {
            $company_profile = CompanyProfile::findOrFail($id);
            $company_profile->update([
                'status' => '1'
            ]);
            
            Alert::toast('Company Profile deleted successfully', 'success');
            return redirect()->route('company_profile.create');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete company profile: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
