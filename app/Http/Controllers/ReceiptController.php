<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiptFormRequest;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $receipts = Receipt::select(
            'receipts.*'
        )
            ->where('receipts.status', '0')
            ->orderBy('receipts.created_at', 'desc')
            ->get();

        return view('receipts.index', compact('receipts'));
    }

    public function view($id)
    {
        $receipt = Receipt::findOrFail($id);

        $ro = 'readonly';

        return view('receipts.view', compact('receipt',  'ro'));
    }

    public function create()
    {
        $receipt = new Receipt();

        // Generate next invoice number
        $lastReceipt = Receipt::orderBy('receipt_no', 'desc')->first();
        $nextReceiptNo = $lastReceipt ? $this->generateNextReceiptNo($lastReceipt->receipt_no) : 'R0001';
        $receipt->receipt_no = $nextReceiptNo;

        $ro = '';

        return view('receipts.create', compact('receipt', 'ro'));
    }

    private function generateNextReceiptNo($lastReceiptNo): string
    {
        // Extract the numeric part
        $number = (int) substr($lastReceiptNo, 3);
        // Increment it
        $number++;
        // Format it back with leading zeros
        return 'R' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function store(ReceiptFormRequest $request)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $receipt = Receipt::create([
                'receipt_no'  => $request->receipt_no,
                'receipt_date'  => $request->receipt_date ? \Carbon\Carbon::parse($request->receipt_date)->format('Y/m/d') : null,
                'receipt_note'  => $request->receipt_note,
                'status'  => '0',
                // 'created_by' => $user->id
            ]);

            if ($request->hasFile('receipt_image') && $request->file('receipt_image')->isValid()) {
                $receipt->addMediaFromRequest('receipt_image')
                    ->toMediaCollection('receipt_image');
                $receipt->receipt_image = 1;
                $receipt->save();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Receipt created successfully',
                    'redirect' => route('receipts.index'),
                ]);
            }

            Alert::toast('Receipt created successfully', 'success');
            return redirect()->route('receipts.index');
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
        $receipt = Receipt::findOrFail($id);

        $ro = '';

        return view('receipts.edit', compact('receipt', 'ro'));
    }

    public function update(ReceiptFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();
            $receipt = Receipt::findOrFail($id);

            $receipt->update([
                'receipt_no'  => $request->receipt_no,
                'receipt_date'  => $request->receipt_date ? \Carbon\Carbon::parse($request->receipt_date)->format('Y/m/d') : null,
                'receipt_note'  => $request->receipt_note,
                // 'updated_by' => $user->id
            ]);

            if ($request->hasFile('receipt_image') && $request->file('receipt_image')->isValid()) {
                // Clear existing media
                $receipt->clearMediaCollection('receipt_image');
                // Add new media
                $receipt->addMediaFromRequest('receipt_image')
                    ->toMediaCollection('receipt_image');
                $receipt->receipt_image = 1;
                $receipt->save();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Receipt updated successfully',
                    'redirect' => route('receipts.index'),
                ]);
            }

            Alert::toast('Receipt updated successfully', 'success');
            return redirect()->route('receipts.index');
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
        $receipt = Receipt::findOrFail($id);

        $ro = '';

        return view('receipts.show', compact('receipt', 'ro'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();
        $receipt = Receipt::findOrFail($id);

        // Clear media before soft delete
        // $receipt->clearMediaCollection('receipt_image');

        $receipt->update([
            // 'updated_by' => $user->id,
            'status' => '1'
        ]);

        Alert::toast('Receipt deleted successfully', 'success');
        return redirect()->route('receipts.index');
    }
}
