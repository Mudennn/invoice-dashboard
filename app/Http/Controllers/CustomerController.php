<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Selections;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\CustomerFormRequest;

class CustomerController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customer::select('customers.*')->where('customers.status', '0')->orderBy('customers.created_at', 'desc')->get();
        return view('contacts.index', compact('customers'));
    }

    public function view($id)
    {
        $customer_profile = Customer::findOrFail($id);
        $states = Selections::select('id', 'selection_data')->where('selection_type', 'state')->where('status', '0')->get();

        $ro = 'readonly';

        return view('contacts.view', compact('customer_profile', 'states', 'ro'));
    }

    public function create()
    {
        $customer_profile = new Customer();
        $states = Selections::select('id', 'selection_data')->where('selection_type', 'state')->where('status', '0')->get();

        $ro = '';

        return view('contacts.create', compact('customer_profile', 'states', 'ro'));
    }

    public function store(CustomerFormRequest $request)
    {
        try {
            // $user = Auth::user();

            $customer = Customer::create([
                'entity_type' => $request->entity_type,
                'customer_name' => $request->customer_name,
                'other_name' => $request->other_name,
                'registration_number_type' => $request->registration_number_type,
                'registration_number' => $request->registration_number,
                'old_registration_number' => $request->old_registration_number,
                'tin' => $request->tin,
                'sst_registration_number' => $request->sst_registration_number,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'state' => $request->state,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'contact_name_1' => $request->contact_name_1,
                'contact_1'  => $request->contact_1,
                'email_1'  => $request->email_1,
                'contact_name_2'  => $request->contact_name_2,
                'contact_2'  => $request->contact_2,
                'email_2'  => $request->email_2,
                'contact_name_3'  => $request->contact_name_3,
                'contact_3'  => $request->contact_3,
                'email_3'  => $request->email_3,
                'status' => '0',
                // 'created_by' => $user->id,
                // 'updated_by' => $user->id,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer created successfully',
                    'redirect' => route('contacts.index'),
                ]);
            }

            Alert::toast('Customer created successfully', 'success');
            return redirect()->route('contacts.index');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast($e->getMessage(), 'error');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $customer_profile = Customer::findOrFail($id);
        $states = Selections::select('id', 'selection_data')->where('selection_type', 'state')->where('status', '0')->get();
        $ro = '';

        return view('contacts.edit', compact('customer_profile', 'states', 'ro'));
    }

    public function update(CustomerFormRequest $request, $id)
    {
        try {
            // $user = Auth::user();

            $customer = Customer::findOrFail($id);

            $customer->update([
                'entity_type' => $request->entity_type,
                'customer_name' => $request->customer_name,
                'other_name' => $request->other_name,
                'registration_number_type' => $request->registration_number_type,
                'registration_number' => $request->registration_number,
                'old_registration_number' => $request->old_registration_number,
                'tin' => $request->tin,
                'sst_registration_number' => $request->sst_registration_number,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'state' => $request->state,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'contact_name_1' => $request->contact_name_1,
                'contact_1'  => $request->contact_1,
                'email_1'  => $request->email_1,
                'contact_name_2'  => $request->contact_name_2,
                'contact_2'  => $request->contact_2,
                'email_2'  => $request->email_2,
                'contact_name_3'  => $request->contact_name_3,
                'contact_3'  => $request->contact_3,
                'email_3'  => $request->email_3,
                // 'updated_by' => $user->id,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer updated successfully',
                    'redirect' => route('contacts.index'),
                ]);
            }

            Alert::toast('Customer updated successfully', 'success');
            return redirect()->route('contacts.index');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast($e->getMessage(), 'error');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        $customer_profile = Customer::findOrFail($id);
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('contacts.show', compact('customer_profile', 'states', 'ro'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();

        Customer::where('id', $id)
            ->update([
                // 'updated_by' => $user->id,
                'status' => '1'
            ]);

        Alert::toast('Customer deleted successfully', 'success');
        return redirect()->route('contacts.index');
    }
}
