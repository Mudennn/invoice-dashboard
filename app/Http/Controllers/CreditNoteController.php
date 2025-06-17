<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditNote;
use App\Models\Selections;
use App\Models\Invoices;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreditNoteFormRequest;
use App\Models\Customer;

class CreditNoteController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $credit_notes = CreditNote::with('invoice')
            ->select('credit_notes.*')
            ->where('credit_notes.status', '0')
            ->orderBy('credit_notes.created_at', 'desc')
            ->get();

        return view('credit_notes.index', compact('credit_notes'));
    }

    public function view($id)
    {
        $credit_note = CreditNote::with([
            'creditItems' => function ($query) {
                $query->where('credit_note_items.status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

        $ro = 'readonly';

        return view('credit_notes.view', compact('credit_note', 'reasons', 'ro'));
    }

    public function generateNextCreditNoteNo($lastCreditNoteNo): string
    {
        //Extract the numeric part
        $number = (int) substr($lastCreditNoteNo, 3);

        //Increment the number
        $number++;

        return 'CN' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $credit_note = new CreditNote();

        // Generate next invoice number
        $lastCreditNote = CreditNote::orderBy('credit_note_no', 'desc')->first();
        $nextCreditNoteNo = $lastCreditNote ? $this->generateNextCreditNoteNo($lastCreditNote->credit_note_no) : 'CN0001';
        $credit_note->credit_note_no = $nextCreditNoteNo;

        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('credit_notes.create', compact('credit_note', 'invoices', 'customers', 'reasons', 'ro'));
    }

    public function store(CreditNoteFormRequest $request)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            // Fetch the invoice from the selected invoice
            $invoice = Invoices::where('invoice_no', $request->invoice_no)->first();

            // Calculate totals
            $subtotal = collect($request->items)->sum('total');

            // Create Credit Note
            $credit_note = CreditNote::create([
                'credit_note_no' => $request->credit_note_no,
                'invoice_no' => $request->invoice_no,
                'credit_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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

            // Create Credit Note Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $credit_note->creditItems()->create([
                        'quantity' => $item['quantity'],
                        'description' => $item['description'],
                        'unit_price' => $item['unit_price'],
                        'amount' => $item['amount'],
                        'total' => $item['total'],
                        'subtotal' => $subtotal,
                        'currency_code' => 'MYR',
                        'status' => '0',
                    ]);
                }
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Credit note created successfully',
                    'redirect' => route('credit_notes.index')
                ]);
            }

            Alert::toast('Credit note created successfully', 'success');
            return redirect()->route('credit_notes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['error' => [$e->getMessage()]]
                ], 422);
            }

            Alert::toast('Error creating credit note: ' . $e->getMessage(), 'error');
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $credit_note = CreditNote::with([
            'creditItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $credit_note->creditItems->first()->subtotal ?? 0;
        $invoices = Invoices::where('status', '0')->get();

         // Get customer list
         $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

        $ro = '';

        return view('credit_notes.edit', compact('credit_note', 'invoices', 'customers', 'reasons', 'ro', 'subtotal'));
    }

    public function update(CreditNoteFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $credit_note = CreditNote::findOrFail($id);

            // Fetch the invoice from the selected invoice
            $invoice = Invoices::where('invoice_no', $request->invoice_no)->first();

            // Update Credit Note
            $credit_note->update([
                'credit_note_no' => $request->credit_note_no,
                'invoice_no' => $request->invoice_no,
                'credit_note_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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

            $subtotal = collect($request->items)->sum('total');

            // Get existing item IDs for tracking
            $existingIds = $credit_note->creditItems()
                ->where('status', '0')
                ->pluck('id')
                ->toArray();

            $processedIds = [];

            // Update or create invoice items
            if ($request->has('items')) {
                foreach ($request->items as $item) {

                    if (!empty($item['id'])) {
                        // Update existing item
                        $invoice->invoiceItems()->where('id', $item['id'])->where('status', '0')->update([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                        ]);
                        $processedIds[] = $item['id'];
                    } else {
                        // Only create if it's truly a new item
                        $invoice->invoiceItems()->create([
                            'quantity' => $item['quantity'],
                            'description' => $item['description'],
                            'unit_price' => $item['unit_price'],
                            'amount' => $item['amount'],
                            'total' => $item['total'],
                            'subtotal' => $subtotal,
                            'currency_code' => 'MYR',
                            'status' => '0',
                        ]);
                    }
                }
            }
            // Soft delete any items that were removed from the form
            $removeIds = array_diff($existingIds, $processedIds);
            if (!empty($removeIds)) {
                $invoice->invoiceItems()->whereIn('id', $removeIds)->delete();
            }


            // Delete any items that were removed from the form
            $removedIds = array_diff($existingIds, $processedIds);
            if (!empty($removedIds)) {
                $credit_note->creditItems()
                    ->whereIn('id', $removedIds)
                    ->delete();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Credit note updated successfully',
                    'redirect' => route('credit_notes.index')
                ]);
            }


            Alert::toast('Credit note updated successfully', 'success');
            return redirect()->route('credit_notes.index');
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
        $credit_note = CreditNote::with([
            'creditItems' => function ($query) {
                $query->where('status', '0');
            },
            'invoice'
        ])->findOrFail($id);

        $subtotal = $credit_note->creditItems->first()->subtotal ?? 0;

        $reasons = Selections::select('id', 'selection_data')
            ->where('selection_type', 'credit_reason')
            ->where('status', '0')
            ->get();

            // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();
        $ro = '';

        return view('credit_notes.show', compact('credit_note', 'subtotal', 'reasons', 'customers', 'states', 'ro'));
    }

    public function destroy($id)
    {
        try {
            $credit_note = CreditNote::findOrFail($id);
            
            // Update status to deleted (soft delete)
            $credit_note->update(['status' => '1']);
            
            // Also mark credit items as deleted if any exist
            if ($credit_note->creditItems()->count() > 0) {
                $credit_note->creditItems()->update(['status' => '1']);
            }
            
            Alert::toast('Credit note deleted successfully', 'success');
            
            // Return direct response for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Credit note deleted successfully',
                    'redirect' => route('credit_notes.index')
                ]);
            }
            
            return redirect()->route('credit_notes.index');
        } catch (\Exception $e) {
            Log::error('Credit Note deletion error: ' . $e->getMessage());
            
            Alert::toast('Error deleting credit note', 'error');
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting credit note'
                ], 500);
            }
            
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
