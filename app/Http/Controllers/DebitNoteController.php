<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selections;
use App\Models\Invoices;
use App\Models\Taxes;
use App\Models\Classification;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DebitNoteFormRequest;
use App\Models\Customer;
use App\Models\DebitNote;

class DebitNoteController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $debit_notes = DebitNote::with('invoice')
            ->select('debit_notes.*')
            ->where('debit_notes.status', '0')
            ->orderBy('debit_notes.created_at', 'desc')
            ->get();

        return view('debit_notes.index', compact('debit_notes'));
    }

    public function view($id)
    {
        $debit_note = DebitNote::with([
            'debitItems' => function ($query) {
                $query->where('debit_note_items.status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'debit_reason')
            ->where('status', '0')
            ->get();

        $ro = 'readonly';

        return view('debit_notes.view', compact('debit_note', 'reasons', 'ro'));
    }

    public function generateNextDebitNoteNo($lastDebitNoteNo): string
    {
        //Extract the numeric part
        $number = (int) substr($lastDebitNoteNo, 3);

        //Increment the number
        $number++;

        return 'DN' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $debit_note = new DebitNote();

        // Generate next invoice number
        $lastDebitNote = DebitNote::orderBy('debit_note_no', 'desc')->first();
        $nextDebitNoteNo = $lastDebitNote ? $this->generateNextDebitNoteNo($lastDebitNote->debit_note_no) : 'DN0001';
        $debit_note->debit_note_no = $nextDebitNoteNo;

        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

         $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'debit_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('debit_notes.create', compact('debit_note', 'invoices', 'customers', 'taxes', 'classifications', 'reasons', 'ro'));
    }

    public function store(DebitNoteFormRequest $request)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            // Fetch the invoice from the selected invoice
            $invoice = Invoices::where('invoice_no', $request->invoice_no)->first();

            // Calculate totals
            $subtotal = 0;
            $excludingTaxTotal = 0;
            $taxAmountTotal = 0;

            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $excludingTaxTotal += floatval($item['excluding_tax'] ?? $item['amount']);
                    $taxAmountTotal += floatval($item['tax_amount'] ?? 0);
                }
                $subtotal = $excludingTaxTotal + $taxAmountTotal;
            }

            // Create Debit Note
            $debit_note = DebitNote::create([
                'debit_note_no' => $request->debit_note_no,
                'invoice_no' => $request->invoice_no,
                'debit_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
                'invoice_uuid' => $invoice->invoice_uuid,
                'customer' => $request->customer,
                'billing_attention' => $request->billing_attention,
                'billing_address' => $request->billing_address,
                'shipping_info' => $request->shipping_info,
                'shipping_attention' => $request->shipping_attention,
                'shipping_address' => $request->shipping_address,
                'reference_number' => $request->reference_number,
                'title' => $request->title,
                'internal_note' => $request->internal_note,
                'description' => $request->description,
                'tags' => $request->tags,
                'currency' => 'MYR',
                'control' => $request->control,
                'status' => '0',
            ]);

            // Create Debit Note Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $debit_note->debitItems()->create([
                        'quantity' => $item['quantity'],
                        'description' => $item['description'],
                        'unit_price' => $item['unit_price'],
                        'amount' => $item['amount'],
                        'total' => $item['total'],
                        'subtotal' => $subtotal,
                        'currency_code' => 'MYR',
                        'classification_code' => $item['classification_code'] ?? null,
                        'tax_type' => $item['tax_type'] ?? null,
                        'tax_code' => $item['tax_code'] ?? null,
                        'tax_rate' => $item['tax_rate'] ?? 0,
                        'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                        'tax_amount' => $item['tax_amount'] ?? 0,
                        'status' => '0',
                    ]);
                }
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Debit note created successfully',
                    'redirect' => route('debit_notes.index')
                ]);
            }

            Alert::toast('Debit note created successfully', 'success');
            return redirect()->route('debit_notes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => [$e->getMessage()]]
                ], 422);
            }

            Alert::toast('Error creating debit note: ' . $e->getMessage(), 'error');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $debit_note = DebitNote::with([
            'debitItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $debit_note->debitItems->first()->subtotal ?? 0;
        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

         $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'debit_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('debit_notes.edit', compact('debit_note', 'invoices', 'customers', 'taxes', 'classifications', 'reasons', 'ro', 'subtotal'));
    }

    public function update(DebitNoteFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $debit_note = DebitNote::findOrFail($id);

            // Fetch the invoice from the selected invoice
            $invoice = Invoices::where('invoice_no', $request->invoice_no)->first();

            $subtotal = 0;
            $excludingTaxTotal = 0;
            $taxAmountTotal = 0;

            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $excludingTaxTotal += floatval($item['excluding_tax'] ?? $item['amount']);
                    $taxAmountTotal += floatval($item['tax_amount'] ?? 0);
                }
                $subtotal = $excludingTaxTotal + $taxAmountTotal;
            }

            // Update Debit Note
            $debit_note->update([
                'debit_note_no' => $request->debit_note_no,
                'invoice_no' => $request->invoice_no,
                'debit_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
                'invoice_uuid' => $invoice->invoice_uuid,
                'customer' => $request->customer,
                'billing_attention' => $request->billing_attention,
                'billing_address' => $request->billing_address,
                'shipping_info' => $request->shipping_info,
                'shipping_attention' => $request->shipping_attention,
                'shipping_address' => $request->shipping_address,
                'reference_number' => $request->reference_number,
                'title' => $request->title,
                'internal_note' => $request->internal_note,
                'description' => $request->description,
                'tags' => $request->tags,
                'currency' => 'MYR',
                'control' => $request->control,
                'status' => '0',
            ]);

            // Get existing item IDs for tracking
            $existingIds = $debit_note->debitItems()
                ->where('status', '0')
                ->pluck('id')
                ->toArray();

            $processedIds = [];

            // Update or create invoice items
            if ($request->has('items')) {
                foreach ($request->items as $item) {

                    if (!empty($item['id'])) {
                        // Update existing item
                        $debit_note->debitItems()->where('id', $item['id'])->where('status', '0')->update([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                            'classification_code' => $item['classification_code'] ?? null,
                            'tax_type' => $item['tax_type'] ?? null,
                            'tax_code' => $item['tax_code'] ?? null,
                            'tax_rate' => $item['tax_rate'] ?? 0,
                            'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                            'tax_amount' => $item['tax_amount'] ?? 0,
                        ]);
                        $processedIds[] = $item['id'];
                    } else {
                        // Only create if it's truly a new item
                        $debit_note->debitItems()->create([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                            'classification_code' => $item['classification_code'] ?? null,
                            'tax_type' => $item['tax_type'] ?? null,
                            'tax_code' => $item['tax_code'] ?? null,
                            'tax_rate' => $item['tax_rate'] ?? 0,
                            'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                            'tax_amount' => $item['tax_amount'] ?? 0,
                            'status' => '0',
                        ]);
                    }
                }
            }
            // Soft delete any items that were removed from the form
            $removeIds = array_diff($existingIds, $processedIds);
            if (!empty($removeIds)) {
                $debit_note->debitItems()->whereIn('id', $removeIds)->delete();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Debit note updated successfully',
                    'redirect' => route('debit_notes.index')
                ]);
            }


            Alert::toast('Debit note updated successfully', 'success');
            return redirect()->route('debit_notes.index');
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
        $debit_note = DebitNote::with([
            'debitItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $debit_note->debitItems->first()->subtotal ?? 0;

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'debit_reason')
            ->where('status', '0')
            ->get();

            // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();

        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();
        $ro = '';

        return view('debit_notes.show', compact('debit_note', 'subtotal', 'reasons', 'customers', 'states', 'taxes', 'classifications', 'ro'));
    }

    public function destroy($id)
    {
        try {
            $debit_note = DebitNote::findOrFail($id);
            
            // Update status to deleted (soft delete)
            $debit_note->update(['status' => '1']);
            
            // Also mark debit items as deleted if any exist
            if ($debit_note->debitItems()->count() > 0) {
                $debit_note->debitItems()->update(['status' => '1']);
            }
            
            Alert::toast('Debit note deleted successfully', 'success');
            
            // Return direct response for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Debit note deleted successfully',
                    'redirect' => route('debit_notes.index')
                ]);
            }
            
            return redirect()->route('debit_notes.index');
        } catch (\Exception $e) {
            Log::error('Debit Note deletion error: ' . $e->getMessage());
            
            Alert::toast('Error deleting debit note', 'error');
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting debit note'
                ], 500);
            }
            
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
