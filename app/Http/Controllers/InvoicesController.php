<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InvoiceFormRequest;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Selections;
use RealRashid\SweetAlert\Facades\Alert;

class InvoicesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Invoices::select('invoices.*')->where('invoices.status', '0')->orderBy('invoices.created_at', 'desc')->get();
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
        $nextInvoiceNo = $lastInvoice ? $this->generateNextInvoiceNo($lastInvoice->invoice_no) : 'INV00001';
        $invoice->invoice_no = $nextInvoiceNo;

        // Get customer list
        $customers = Customer::select('customer_name')->where('status', '0')->get()->pluck('customer_name');

        $ro = '';

        return view('invoices.create', compact('invoice', 'customers', 'ro'));
    }

    public function store(InvoiceFormRequest $request)
    {
        try {
            // $user = Auth::user();

            // Generate Invoice UUID
            $invoiceUuid = $request->invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
            $subtotal = collect($request->items)->sum('total');

            // Create Invoice
            $invoice = Invoices::create([
                'invoice_uuid' => $invoiceUuid,
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
                'customer' => $request->customer,
                'title' => $request->title,
                'internal_note' => $request->internal_note,
                'description' => $request->description,
                'tags' => $request->tags,
                'currency' => $request->currency,
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
                        'status' => '0',
                    ]);
                }
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully',
                    'redirect' => route('invoices.index'),
                ]);
            }

            Alert::toast('Success', 'Invoice created successfully', 'success');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast('Error', $e->getMessage(), 'error');
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
        $ro = '';

        return view('invoices.edit', compact('invoice', 'customers', 'states', 'ro'));
    }

    public function update(InvoiceFormRequest $request, $id)
    {
        try {
            // $user = Auth::user();

            $invoice = Invoices::findOrFail($id);

            // Generate Invoice UUID
            $invoiceUuid = $request->invoice_uuid ?? Str::uuid()->toString();

            // Calculate total amount
            $subtotal = collect($request->items)->sum('total');

            // Update Invoice
            $invoice->update([
                'invoice_uuid' => $invoiceUuid,
                'customer' => $request->customer,
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date ? \Carbon\Carbon::parse($request->invoice_date)->format('Y/m/d') : null,
                'customer' => $request->customer,
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
                            'currency_code' => 'MYR',
                        ]);
                        $processedIds[] = $item['id'];
                    } else {
                        // Only create if it's truly a new item
                        $invoice->invoiceItems()->create([
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

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully',
                    'redirect' => route('invoices.index'),
                ]);
            }

            Alert::toast('Success', 'Invoice created successfully', 'success');
            return redirect()->route('invoices.index');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => ['error' => [$e->getMessage()]]
                ], 422);
            }
            Alert::toast('Error', $e->getMessage(), 'error');
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
        $ro = '';

        return view('invoices.show', compact('invoice', 'customers', 'states', 'ro'));
    }

    public function destroy($id)
    {
        // $user = Auth::user();

        Invoices::where('id', $id)->update([
            'status' => '1',
            // 'updated_by' => $user->id,
        ]);

        Alert::toast('Success', 'Invoice deleted successfully', 'success');
        return redirect()->route('invoices.index');
    }
}
