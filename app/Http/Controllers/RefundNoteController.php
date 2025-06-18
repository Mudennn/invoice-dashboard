<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefundNote;
use App\Models\Selections;
use App\Models\Invoices;
use App\Models\Taxes;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RefundNoteFormRequest;
use App\Models\Customer;
use App\Models\Classification;

class RefundNoteController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $refund_notes = RefundNote::with('invoice')
            ->select('refund_notes.*')
            ->where('refund_notes.status', '0')
            ->orderBy('refund_notes.created_at', 'desc')
            ->get();

        return view('refund_notes.index', compact('refund_notes'));
    }

    public function view($id)
    {
        $refund_note = RefundNote::with([
            'refundItems' => function ($query) {
                $query->where('refund_note_items.status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $reasons = Selections::select('id', 'selection_data') 
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

        $ro = 'readonly';

        return view('refund_notes.view', compact('refund_note', 'reasons', 'ro'));
    }

    public function generateNextRefundNoteNo($lastRefundNoteNo): string
    {
        //Extract the numeric part
        $number = (int) substr($lastRefundNoteNo, 3);

        //Increment the number
        $number++;

        return 'RN' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $refund_note = new RefundNote();

        // Generate next invoice number
        $lastRefundNote = RefundNote::orderBy('refund_note_no', 'desc')->first();
        $nextRefundNoteNo = $lastRefundNote ? $this->generateNextRefundNoteNo($lastRefundNote->refund_note_no) : 'RN0001';
        $refund_note->refund_note_no = $nextRefundNoteNo;

        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('refund_notes.create', compact('refund_note', 'invoices', 'customers', 'reasons', 'taxes', 'classifications', 'ro'));
    }

    public function store(RefundNoteFormRequest $request)
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

            // Create Refund Note
            $refund_note = RefundNote::create([
                'refund_note_no' => $request->refund_note_no,
                'invoice_no' => $request->invoice_no,
                'refund_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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

            // Create Refund Note Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $refund_note->refundItems()->create([
                        'quantity' => $item['quantity'],
                        'description' => $item['description'],
                        'unit_price' => $item['unit_price'],
                        'amount' => $item['amount'],
                        'total' => $item['total'],
                        'subtotal' => $subtotal,
                        'currency_code' => 'MYR',
                        'tax_type' => $item['tax_type'] ?? null,
                        'tax_code' => $item['tax_code'] ?? null,
                        'tax_rate' => $item['tax_rate'] ?? 0,
                        'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                        'tax_amount' => $item['tax_amount'] ?? 0,
                        'classification_code' => $item['classification_code'] ?? null,
                        'status' => '0',
                    ]);
                }
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Refund note created successfully',
                    'redirect' => route('refund_notes.index')
                ]);
            }

            Alert::toast('Refund note created successfully', 'success');
            return redirect()->route('refund_notes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => [$e->getMessage()]]
                ], 422);
            }

            Alert::toast('Error creating refund note: ' . $e->getMessage(), 'error');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $refund_note = RefundNote::with([
            'refundItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $refund_note->refundItems->first()->subtotal ?? 0;
        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'refund_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('refund_notes.edit', compact('refund_note', 'invoices', 'customers', 'reasons', 'taxes', 'classifications', 'ro', 'subtotal'));
    }

    public function update(RefundNoteFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $refund_note = RefundNote::findOrFail($id);

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

            // Update Refund Note
            $refund_note->update([
                'refund_note_no' => $request->refund_note_no,
                'invoice_no' => $request->invoice_no,
                'refund_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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
            $existingIds = $refund_note->refundItems()
                ->where('status', '0')
                ->pluck('id')
                ->toArray();

            $processedIds = [];

            // Update or create invoice items
            if ($request->has('items')) {
                foreach ($request->items as $item) {

                    if (!empty($item['id'])) {
                        // Update existing item
                        $refund_note->refundItems()->where('id', $item['id'])->where('status', '0')->update([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                            'tax_type' => $item['tax_type'] ?? null,
                            'tax_code' => $item['tax_code'] ?? null,
                            'tax_rate' => $item['tax_rate'] ?? 0,
                            'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                            'tax_amount' => $item['tax_amount'] ?? 0,
                            'classification_code' => $item['classification_code'] ?? null,
                        ]);
                        $processedIds[] = $item['id'];
                    } else {
                        // Only create if it's truly a new item
                        $refund_note->refundItems()->create([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                            'tax_type' => $item['tax_type'] ?? null,
                            'tax_code' => $item['tax_code'] ?? null,
                            'tax_rate' => $item['tax_rate'] ?? 0,
                            'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                            'tax_amount' => $item['tax_amount'] ?? 0,
                            'classification_code' => $item['classification_code'] ?? null,
                            'status' => '0',
                        ]);
                    }
                }
            }
            // Soft delete any items that were removed from the form
            $removeIds = array_diff($existingIds, $processedIds);
            if (!empty($removeIds)) {
                $refund_note->refundItems()->whereIn('id', $removeIds)->delete();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Refund note updated successfully',
                    'redirect' => route('refund_notes.index')
                ]);
            }


            Alert::toast('Refund note updated successfully', 'success');
            return redirect()->route('refund_notes.index');
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
        $refund_note = RefundNote::with([
            'refundItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $refund_note->refundItems->first()->subtotal ?? 0;

        // Get classification list
        $classifications = Classification::select('id', 'classification_code', 'description')->where('status', '0')->get();

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
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

        return view('refund_notes.show', compact('refund_note', 'subtotal', 'reasons', 'customers', 'states', 'taxes', 'classifications', 'ro'));
    }

    public function destroy($id)
    {
        try {
            $refund_note = RefundNote::findOrFail($id);
            
            // Update status to deleted (soft delete)
            $refund_note->update(['status' => '1']);
            
            // Also mark refund items as deleted if any exist
            if ($refund_note->refundItems()->count() > 0) {
                $refund_note->refundItems()->update(['status' => '1']);
            }
            
            Alert::toast('Refund note deleted successfully', 'success');
            
            // Return direct response for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Refund note deleted successfully',
                    'redirect' => route('refund_notes.index')
                ]);
            }
            
            return redirect()->route('refund_notes.index');
        } catch (\Exception $e) {
            Log::error('Refund Note deletion error: ' . $e->getMessage());
            
            Alert::toast('Error deleting refund note', 'error');
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting refund note'
                ], 500);
            }
            
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
