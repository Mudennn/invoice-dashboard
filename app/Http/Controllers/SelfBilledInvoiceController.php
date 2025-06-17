<?php

namespace App\Http\Controllers;

use App\Models\SelfBilledInvoice;
use App\Models\SelfBilledInvoiceItems;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SelfBilledInvoiceFormRequest;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Selections;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class SelfBilledInvoiceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $self_billed_invoices = SelfBilledInvoice::select('self_billed_invoices.*')->where('self_billed_invoices.status', '0')->orderBy('self_billed_invoices.created_at', 'desc')->get();
        
        // FOR API fetch invoice for each credit note, debit note, refund note
        // Return JSON response if requested
        if (request()->wantsJson() || request()->has('format') && request()->format === 'json') {
            // Calculate subtotal for each invoice from its items
            $self_billed_invoices->each(function($self_billed_invoice) {
                $self_billed_invoice->subtotal = $self_billed_invoice->selfBilledInvoiceItems->sum('total');
            });
            
            return response()->json($self_billed_invoices);
        }
        
        return view('self_billed_invoices.index', compact('self_billed_invoices'));
    }

    public function generateNextInvoiceNo($lastInvoiceNo): string
    {
        //Extract the numeric part
        $number = (int) substr($lastInvoiceNo, 3);

        //Increment the number
        $number++;

        return 'INV' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $self_billed_invoice = new SelfBilledInvoice();

        // Generate next Invoice Number
        $lastInvoice = SelfBilledInvoice::orderBy('self_billed_invoice_no', 'desc')->first();
        $nextInvoiceNo = $lastInvoice ? $this->generateNextInvoiceNo($lastInvoice->self_billed_invoice_no) : 'INV0001';
        $self_billed_invoice->self_billed_invoice_no = $nextInvoiceNo;

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $ro = '';

        return view('self_billed_invoices.create', compact('self_billed_invoice', 'customers', 'ro'));
    }

    public function store(SelfBilledInvoiceFormRequest $request)
    {
        try {

            DB::beginTransaction();
            // $user = Auth::user();

            // Generate Invoice UUID
            $self_billed_invoice_uuid = $request->self_billed_invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
            $subtotal = collect($request->items)->sum('total');

            // Create Invoice
            $self_billed_invoice = SelfBilledInvoice::create([
                'self_billed_invoice_uuid' => $self_billed_invoice_uuid,
                'self_billed_invoice_no' => $request->self_billed_invoice_no,
                'self_billed_invoice_date' => $request->self_billed_invoice_date ? \Carbon\Carbon::parse($request->self_billed_invoice_date)->format('Y/m/d') : null,
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
                // 'created_by' => $user->id,
                // 'updated_by' => $user->id,
            ]);

            // Create Invoice Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $self_billed_invoice->selfBilledInvoiceItems()->create([
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
                    'message' => 'Self-Billed Invoice created successfully',
                    'redirect' => route('self_billed_invoices.index'),
                ]);
            }

            Alert::toast('Self-Billed Invoice created successfully', 'success');
            return redirect()->route('self_billed_invoices.index');
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
        $self_billed_invoice = SelfBilledInvoice::with(['selfBilledInvoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->where('id', $id)->first();

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();
        $ro = '';

        return view('self_billed_invoices.edit', compact('self_billed_invoice', 'customers', 'states', 'ro'));
    }

    public function update(SelfBilledInvoiceFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $self_billed_invoice = SelfBilledInvoice::findOrFail($id);

            // Generate Invoice UUID
            $self_billed_invoice_uuid = $request->self_billed_invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
            $subtotal = collect($request->items)->sum('total');

            // Update Invoice
            $self_billed_invoice->update([
                'self_billed_invoice_uuid' => $self_billed_invoice_uuid,
                'customer' => $request->customer,
                'self_billed_invoice_no' => $request->self_billed_invoice_no,
                'self_billed_invoice_date' => $request->self_billed_invoice_date ? \Carbon\Carbon::parse($request->self_billed_invoice_date)->format('Y/m/d') : null,
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
                'currency' => $request->currency,
                'control' => $request->control,
                'status' => '0',
                // 'updated_by' => $user->id,
            ]);

            //  Get existing item IDs for tracking
            $existingIds = $self_billed_invoice->selfBilledInvoiceItems()->where('status', '0')->pluck('id')->toArray();

            $processedIds = [];

            // Update or create invoice items
            if ($request->has('items')) {
                foreach ($request->items as $item) {

                    if (!empty($item['id'])) {
                        // Update existing item
                        $self_billed_invoice->selfBilledInvoiceItems()->where('id', $item['id'])->where('status', '0')->update([
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
                        $self_billed_invoice->selfBilledInvoiceItems()->create([
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
                $self_billed_invoice->selfBilledInvoiceItems()->whereIn('id', $removeIds)->delete();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Self-Billed Invoice updated successfully',
                    'redirect' => route('self_billed_invoices.index'),
                ]);
            }

            Alert::toast('Self-Billed Invoice updated successfully', 'success');
            return redirect()->route('self_billed_invoices.index');
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
        $self_billed_invoice = SelfBilledInvoice::with(['selfBilledInvoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->findOrFail($id);

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();
        $ro = '';

        return view('self_billed_invoices.show', compact('self_billed_invoice', 'customers', 'states', 'ro'));
    }

    public function view($id)
    {
        $self_billed_invoice = SelfBilledInvoice::with(['selfBilledInvoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->findOrFail($id);

        return view('self_billed_invoices.view', compact('self_billed_invoice'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();

        SelfBilledInvoice::where('id', $id)->update([
            'status' => '1',
            // 'updated_by' => $user->id,
        ]);

        Alert::toast('Self-Billed Invoice deleted successfully', 'success');
        return redirect()->route('self_billed_invoices.index');
    }

    /**
     * Get invoice details by invoice number.
     * This method can be used by credit notes, debit notes, etc.
     *
     * @param string $invoice_no
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetails($self_billed_invoice_no)
    {
        try {
            $self_billed_invoice = SelfBilledInvoice::with(['selfBilledInvoiceItems' => function ($query) {
                $query->where('status', '0');
            }])->where('self_billed_invoice_no', $self_billed_invoice_no)->where('status', '0')->first();
            
            if (!$self_billed_invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }
            
            // Format the response with items
            $response = [
                'self_billed_invoice_no' => $self_billed_invoice->self_billed_invoice_no,
                'self_billed_invoice_uuid' => $self_billed_invoice->self_billed_invoice_uuid,
                'self_billed_invoice_date' => $self_billed_invoice->self_billed_invoice_date,
                'customer' => $self_billed_invoice->customer,
                'billing_attention' => $self_billed_invoice->billing_attention,
                'billing_address' => $self_billed_invoice->billing_address,
                'shipping_attention' => $self_billed_invoice->shipping_attention,
                'shipping_address' => $self_billed_invoice->shipping_address,
                'shipping_info' => $self_billed_invoice->shipping_info,
                'reference_number' => $self_billed_invoice->reference_number,
                'items' => []
            ];
            
            // Add items to the response
            foreach ($self_billed_invoice->selfBilledInvoiceItems as $item) {
                $response['items'][] = [
                    'quantity' => $item->quantity,
                    'description' => $item->description,
                    'unit_price' => $item->unit_price,
                    'amount' => $item->amount,
                    'total' => $item->total
                ];
            }
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

     // Print Invoice
     public function print($id)
     {
        $self_billed_invoice = SelfBilledInvoice::with(['selfBilledInvoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->findOrFail($id);
        
        // Get company profile with state information
        $ourCompany = DB::table('company_profiles')
            ->select('company_profiles.*', 'state.selection_data as s_state')
            ->leftJoin('selections as state', 'company_profiles.state', '=', 'state.id')
            ->where('company_profiles.status', '0')
            ->first();
        
        // Get customer profile if available with state information
        $customerProfile = DB::table('customers')
            ->select('customers.*', 'state.selection_data as s_state')
            ->leftJoin('selections as state', 'customers.state', '=', 'state.id')
            ->where('customers.customer_name', $self_billed_invoice->customer)
            ->where('customers.status', '0')
            ->first();
 
        return view('self_billed_invoices.print', compact('self_billed_invoice', 'ourCompany', 'customerProfile'));
     }
}
