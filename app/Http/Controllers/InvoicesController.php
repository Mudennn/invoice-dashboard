<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InvoiceFormRequest;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Selections;
use App\Models\Taxes;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Invoices::select('invoices.*')->where('invoices.status', '0')->orderBy('invoices.created_at', 'desc')->get();
        
        // FOR API fetch invoice for each credit note, debit note, refund note
        // Return JSON response if requested
        if (request()->wantsJson() || request()->has('format') && request()->format === 'json') {
            // Calculate subtotal for each invoice from its items
            $invoices->each(function($invoice) {
                $invoice->subtotal = $invoice->invoiceItems->sum('total');
            });
            
            // Get tax list for the response
            $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();
            
            return response()->json([
                'invoices' => $invoices,
                'taxesData' => $taxes
            ]);
        }
        
        return view('invoices.index', compact('invoices'));
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
        $invoice = new Invoices();

        // Generate next Invoice Number
        $lastInvoice = Invoices::orderBy('invoice_no', 'desc')->first();
        $nextInvoiceNo = $lastInvoice ? $this->generateNextInvoiceNo($lastInvoice->invoice_no) : 'INV0001';
        $invoice->invoice_no = $nextInvoiceNo;

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        // Get tax list
        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();
        $ro = '';

        return view('invoices.create', compact('invoice', 'customers', 'taxes', 'ro'));
    }

    public function store(InvoiceFormRequest $request)
    {
        try {

            DB::beginTransaction();
            // $user = Auth::user();

            // Generate Invoice UUID
            $invoiceUuid = $request->invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
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

            // Create Invoice
            $invoice = Invoices::create([
                'invoice_uuid' => $invoiceUuid,
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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
                    $invoice->invoiceItems()->create([
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
                        'status' => '0',
                    ]);
                }
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully',
                    'redirect' => route('invoices.index'),
                ]);
            }

            Alert::toast('Invoice created successfully', 'success');
            return redirect()->route('invoices.index');
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
        $invoice = Invoices::with(['invoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->where('id', $id)->first();

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();

        // Get tax list
        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();
        $ro = '';

        return view('invoices.edit', compact('invoice', 'customers', 'states', 'taxes', 'ro'));
    }

    public function update(InvoiceFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $user = Auth::user();

            $invoice = Invoices::findOrFail($id);

            // Generate Invoice UUID
            $invoiceUuid = $request->invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
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

            // Update Invoice
            $invoice->update([
                'invoice_uuid' => $invoiceUuid,
                'customer' => $request->customer,
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
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
            $existingIds = $invoice->invoiceItems()->where('status', '0')->pluck('id')->toArray();

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
                            'tax_type' => $item['tax_type'] ?? null,
                            'tax_code' => $item['tax_code'] ?? null,
                            'tax_rate' => $item['tax_rate'] ?? 0,
                            'excluding_tax' => $item['excluding_tax'] ?? $item['amount'],
                            'tax_amount' => $item['tax_amount'] ?? 0,
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
                $invoice->invoiceItems()->whereIn('id', $removeIds)->delete();
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice updated successfully',
                    'redirect' => route('invoices.index'),
                ]);
            }

            Alert::toast('Invoice updated successfully', 'success');
            return redirect()->route('invoices.index');
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
        $invoice = Invoices::with(['invoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->findOrFail($id);

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');
        $states = Selections::select('id', 'selection_data')
            ->where('selection_type', 'state')
            ->where('status', '0')
            ->get();

        // Get tax list
        $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();
        $ro = '';

        return view('invoices.show', compact('invoice', 'customers', 'states', 'taxes', 'ro'));
    }

    public function view($id)
    {
        $invoice = Invoices::with(['invoiceItems' => function ($query) {
            $query->where('status', '0');
        }])->findOrFail($id);

        return view('invoices.view', compact('invoice'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();

        Invoices::where('id', $id)->update([
            'status' => '1',
            // 'updated_by' => $user->id,
        ]);

        Alert::toast('Invoice deleted successfully', 'success');
        return redirect()->route('invoices.index');
    }

    /**
     * Get invoice details by invoice number.
     * This method can be used by credit notes, debit notes, etc.
     *
     * @param string $invoice_no
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetails($invoice_no)
    {
        try {
            $invoice = Invoices::with(['invoiceItems' => function ($query) {
                $query->where('status', '0');
            }])->where('invoice_no', $invoice_no)->where('status', '0')->first();
            
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }
            
            // Get tax list for the response
            $taxes = Taxes::select('id', 'tax_type', 'tax_code', 'tax_rate')->where('status', '0')->get();
            
            // Format the response with items
            $response = [
                'invoice_no' => $invoice->invoice_no,
                'invoice_uuid' => $invoice->invoice_uuid,
                'invoice_date' => $invoice->invoice_date,
                'customer' => $invoice->customer,
                'billing_attention' => $invoice->billing_attention,
                'billing_address' => $invoice->billing_address,
                'shipping_attention' => $invoice->shipping_attention,
                'shipping_address' => $invoice->shipping_address,
                'shipping_info' => $invoice->shipping_info,
                'reference_number' => $invoice->reference_number,
                'taxesData' => $taxes,
                'items' => []
            ];
            
            // Add items to the response
            foreach ($invoice->invoiceItems as $item) {
                $response['items'][] = [
                    'quantity' => $item->quantity,
                    'description' => $item->description,
                    'unit_price' => $item->unit_price,
                    'amount' => $item->amount,
                    'total' => $item->total,
                    'tax_type' => $item->tax_type,
                    'tax_code' => $item->tax_code,
                    'tax_rate' => $item->tax_rate,
                    'excluding_tax' => $item->{'excluding_tax'},
                    'tax_amount' => $item->tax_amount,
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
        $invoice = Invoices::with(['invoiceItems' => function ($query) {
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
            ->where('customers.customer_name', $invoice->customer)
            ->where('customers.status', '0')
            ->first();
 
        return view('invoices.print', compact('invoice', 'ourCompany', 'customerProfile'));
     }
}
