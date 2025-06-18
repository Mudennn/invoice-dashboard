<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxFormRequest;
use App\Models\Taxes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Taxes::select(
            'taxes.*'
        )
            ->where('taxes.status', '0')
            ->orderBy('taxes.tax_code', 'asc')
            ->get();

        return view('taxes.index', compact('taxes'));
    }

    public function view($id)
    {
        $tax = Taxes::findOrFail($id);

        $ro = 'readonly';

        return view('taxes.view', compact('tax',  'ro'));
    }

    public function create()
    {
        $tax = new Taxes();

        $ro = '';

        return view('taxes.create', compact('tax', 'ro'));
    }


    public function store(TaxFormRequest $request)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $tax = Taxes::create([
                'tax_code'  => $request->tax_code,
                'tax_type'  => $request->tax_type,
                'tax_rate'  => $request->tax_rate,
                'status'  => '0',
                // 'created_by' => $user->id
            ]);


            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tax created successfully',
                    'redirect' => route('taxes.index'),
                ]);
            }

            Alert::toast('Tax created successfully', 'success');
            return redirect()->route('taxes.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $tax = Taxes::findOrFail($id);

        $ro = '';

        return view('taxes.edit', compact('tax', 'ro'));
    }

    public function update(TaxFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();
            $tax = Taxes::findOrFail($id);

            $tax->update([
                'tax_code'  => $request->tax_code,
                'tax_type'  => $request->tax_type,
                'tax_rate'  => $request->tax_rate,
                // 'updated_by' => $user->id
            ]);


            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tax updated successfully',
                    'redirect' => route('taxes.index'),
                ]);
            }

            Alert::toast('Tax updated successfully', 'success');
            return redirect()->route('taxes.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $tax = Taxes::findOrFail($id);

        $ro = '';

        return view('taxes.show', compact('tax', 'ro'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();
        $tax = Taxes::findOrFail($id);


        $tax->update([
            // 'updated_by' => $user->id,
            'status' => '1'
        ]);

        Alert::toast('Tax deleted successfully', 'success');
        return redirect()->route('taxes.index');
    }
}
