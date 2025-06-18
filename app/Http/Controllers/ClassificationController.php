<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassificationFormRequest;
use App\Models\Classification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $classifications = Classification::select(
            'classifications.*'
        )
            ->where('classifications.status', '0')
            ->orderBy('classifications.classification_code', 'asc')
            ->get();

        return view('classifications.index', compact('classifications'));
    }

    public function view($id)
    {
        $classification = Classification::findOrFail($id);

        $ro = 'readonly';

        return view('classifications.view', compact('classification',  'ro'));
    }

    public function create()
    {
        $classification = new Classification();

        $ro = '';

        return view('classifications.create', compact('classification', 'ro'));
    }


    public function store(ClassificationFormRequest $request)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $classification = Classification::create([
                'classification_code'  => $request->classification_code,
                'description'  => $request->description,
                'status'  => '0',
                // 'created_by' => $user->id
            ]);


            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Classification created successfully',
                    'redirect' => route('classifications.index'),
                ]);
            }

            Alert::toast('Classification created successfully', 'success');
            return redirect()->route('classifications.index');
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
        $classification = Classification::findOrFail($id);

        $ro = '';

        return view('classifications.edit', compact('classification', 'ro'));
    }

    public function update(ClassificationFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();
            $classification = Classification::findOrFail($id);

            $classification->update([
                'classification_code'  => $request->classification_code,
                'description'  => $request->description,
                // 'updated_by' => $user->id
            ]);


            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Classification updated successfully',
                    'redirect' => route('classifications.index'),
                ]);
            }

            Alert::toast('Classification updated successfully', 'success');
            return redirect()->route('classifications.index');
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
        $classification = Classification::findOrFail($id);

        $ro = '';

        return view('classifications.show', compact('classification', 'ro'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();
        $classification = Classification::findOrFail($id);


        $classification->update([
            // 'updated_by' => $user->id,
            'status' => '1'
        ]);

        Alert::toast('Classification deleted successfully', 'success');
        return redirect()->route('classifications.index');
    }
}
