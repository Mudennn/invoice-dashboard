<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\RefundNoteController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SelfBilledInvoiceController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\MsicController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard.index');

    // Admin Routes - Accessible by all authenticated users since all users are admins
    Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::patch('admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');
    Route::get('admins/{id}', [AdminController::class, 'show'])->name('admins.show');

    // Invoice Routes
    Route::get('invoices', [InvoicesController::class, 'index'])->name('invoices.index');
    Route::get('invoices/create', [InvoicesController::class, 'create'])->name('invoices.create');
    Route::post('invoices', [InvoicesController::class, 'store'])->name('invoices.store');
    Route::get('invoices/{id}/edit', [InvoicesController::class, 'edit'])->name('invoices.edit');
    Route::patch('invoices/{id}', [InvoicesController::class, 'update'])->name('invoices.update');
    Route::get('invoices/{id}', [InvoicesController::class, 'show'])->name('invoices.show');
    Route::delete('invoices/{id}', [InvoicesController::class, 'destroy'])->name('invoices.destroy');
    Route::get('invoices/{id}/view', [InvoicesController::class, 'view'])->name('invoices.view');
    Route::post('search', [InvoicesController::class, 'search'])->name('invoices.search');

    // Add generic invoice details endpoint
    Route::get('invoices/get-details/{invoice_no}', [InvoicesController::class, 'getInvoiceDetails'])
        ->name('invoices.get-details');

    // Contacts Routes
    Route::get('contacts', [CustomerController::class, 'index'])->name('contacts.index');
    Route::get('contacts/create', [CustomerController::class, 'create'])->name('contacts.create');
    Route::post('contacts', [CustomerController::class, 'store'])->name('contacts.store');
    Route::get('contacts/{id}/edit', [CustomerController::class, 'edit'])->name('contacts.edit');
    Route::patch('contacts/{id}', [CustomerController::class, 'update'])->name('contacts.update');
    Route::get('contacts/{id}', [CustomerController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{id}', [CustomerController::class, 'destroy'])->name('contacts.destroy');
    Route::get('contacts/{id}/view', [CustomerController::class, 'view'])->name('contacts.view');
    Route::post('search', [InvoicesController::class, 'search'])->name('invoices.search');

    // Credit Note Routes
    Route::get('credit_notes', [CreditNoteController::class, 'index'])->name('credit_notes.index');
    Route::get('credit_notes/create', [CreditNoteController::class, 'create'])->name('credit_notes.create');
    Route::post('credit_notes', [CreditNoteController::class, 'store'])->name('credit_notes.store');
    Route::get('credit_notes/{id}/edit', [CreditNoteController::class, 'edit'])->name('credit_notes.edit');
    Route::patch('credit_notes/{id}', [CreditNoteController::class, 'update'])->name('credit_notes.update');
    Route::get('credit_notes/{id}', [CreditNoteController::class, 'show'])->name('credit_notes.show');
    Route::delete('credit_notes/{id}', [CreditNoteController::class, 'destroy'])->name('credit_notes.destroy');
    Route::get('credit_notes/{id}/view', [CreditNoteController::class, 'view'])->name('credit_notes.view');

    // Debit Note Routes
    Route::get('debit_notes', [DebitNoteController::class, 'index'])->name('debit_notes.index');
    Route::get('debit_notes/create', [DebitNoteController::class, 'create'])->name('debit_notes.create');
    Route::post('debit_notes', [DebitNoteController::class, 'store'])->name('debit_notes.store');
    Route::get('debit_notes/{id}/edit', [DebitNoteController::class, 'edit'])->name('debit_notes.edit');
    Route::patch('debit_notes/{id}', [DebitNoteController::class, 'update'])->name('debit_notes.update');
    Route::get('debit_notes/{id}', [DebitNoteController::class, 'show'])->name('debit_notes.show');
    Route::delete('debit_notes/{id}', [DebitNoteController::class, 'destroy'])->name('debit_notes.destroy');
    Route::get('debit_notes/{id}/view', [DebitNoteController::class, 'view'])->name('debit_notes.view');

    // Refund Note Routes
    Route::get('refund_notes', [RefundNoteController::class, 'index'])->name('refund_notes.index');
    Route::get('refund_notes/create', [RefundNoteController::class, 'create'])->name('refund_notes.create');
    Route::post('refund_notes', [RefundNoteController::class, 'store'])->name('refund_notes.store');
    Route::get('refund_notes/{id}/edit', [RefundNoteController::class, 'edit'])->name('refund_notes.edit');
    Route::patch('refund_notes/{id}', [RefundNoteController::class, 'update'])->name('refund_notes.update');
    Route::get('refund_notes/{id}', [RefundNoteController::class, 'show'])->name('refund_notes.show');
    Route::delete('refund_notes/{id}', [RefundNoteController::class, 'destroy'])->name('refund_notes.destroy');
    Route::get('refund_notes/{id}/view', [RefundNoteController::class, 'view'])->name('refund_notes.view');

    // Print Invoice
    Route::get('/invoices/{id}/print', [InvoicesController::class, 'print'])->name('invoices.print');

    // Company Profile Routes
    Route::get('company_profile', [CompanyProfileController::class, 'index'])->name('company_profile.index');
    Route::get('company_profile/create', [CompanyProfileController::class, 'create'])->name('company_profile.create');
    Route::post('company_profile', [CompanyProfileController::class, 'store'])->name('company_profile.store');
    Route::get('company_profile/{id}/edit', [CompanyProfileController::class, 'edit'])->name('company_profile.edit');
    Route::patch('company_profile/{id}', [CompanyProfileController::class, 'update'])->name('company_profile.update');
    Route::delete('company_profile/{id}', [CompanyProfileController::class, 'destroy'])->name('company_profile.destroy');

    // Receipt Routes
    Route::get('receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::get('receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');
    Route::post('receipts', [ReceiptController::class, 'store'])->name('receipts.store');
    Route::get('receipts/{id}/edit', [ReceiptController::class, 'edit'])->name('receipts.edit');
    Route::patch('receipts/{id}', [ReceiptController::class, 'update'])->name('receipts.update');
    Route::get('receipts/{id}', [ReceiptController::class, 'show'])->name('receipts.show');
    Route::delete('receipts/{id}', [ReceiptController::class, 'destroy'])->name('receipts.destroy');
    Route::get('receipts/{id}/view', [ReceiptController::class, 'view'])->name('receipts.view');


    // Self-Billed Invoice Routes
    Route::get('self_billed_invoices', [SelfBilledInvoiceController::class, 'index'])->name('self_billed_invoices.index');
    Route::get('self_billed_invoices/create', [SelfBilledInvoiceController::class, 'create'])->name('self_billed_invoices.create');
    Route::post('self_billed_invoices', [SelfBilledInvoiceController::class, 'store'])->name('self_billed_invoices.store');
    Route::get('self_billed_invoices/{id}/edit', [SelfBilledInvoiceController::class, 'edit'])->name('self_billed_invoices.edit');
    Route::patch('self_billed_invoices/{id}', [SelfBilledInvoiceController::class, 'update'])->name('self_billed_invoices.update');
    Route::get('self_billed_invoices/{id}', [SelfBilledInvoiceController::class, 'show'])->name('self_billed_invoices.show');
    Route::delete('self_billed_invoices/{id}', [SelfBilledInvoiceController::class, 'destroy'])->name('self_billed_invoices.destroy');
    Route::get('self_billed_invoices/{id}/view', [SelfBilledInvoiceController::class, 'view'])->name('self_billed_invoices.view');
    Route::post('search', [SelfBilledInvoiceController::class, 'search'])->name('self_billed_invoices.search');

    // Add generic invoice details endpoint
    Route::get('self_billed_invoices/get-details/{self_billed_invoice_no}', [SelfBilledInvoiceController::class, 'getInvoiceDetails'])
        ->name('self_billed_invoices.get-details');

    // Print Invoice
    Route::get('/self_billed_invoices/{id}/print', [SelfBilledInvoiceController::class, 'print'])->name('self_billed_invoices.print');


    // Tax Routes
    Route::get('taxes', [TaxController::class, 'index'])->name('taxes.index');
    Route::get('taxes/create', [TaxController::class, 'create'])->name('taxes.create');
    Route::post('taxes', [TaxController::class, 'store'])->name('taxes.store');
    Route::get('taxes/{id}/edit', [TaxController::class, 'edit'])->name('taxes.edit');
    Route::patch('taxes/{id}', [TaxController::class, 'update'])->name('taxes.update');
    Route::get('taxes/{id}', [TaxController::class, 'show'])->name('taxes.show');
    Route::delete('taxes/{id}', [TaxController::class, 'destroy'])->name('taxes.destroy');
    Route::get('taxes/{id}/view', [TaxController::class, 'view'])->name('taxes.view');

    // Classification Routes
    Route::get('classifications', [ClassificationController::class, 'index'])->name('classifications.index');
    Route::get('classifications/create', [ClassificationController::class, 'create'])->name('classifications.create');
    Route::post('classifications', [ClassificationController::class, 'store'])->name('classifications.store');
    Route::get('classifications/{id}/edit', [ClassificationController::class, 'edit'])->name('classifications.edit');
    Route::patch('classifications/{id}', [ClassificationController::class, 'update'])->name('classifications.update');
    Route::get('classifications/{id}', [ClassificationController::class, 'show'])->name('classifications.show');
    Route::delete('classifications/{id}', [ClassificationController::class, 'destroy'])->name('classifications.destroy');
    Route::get('classifications/{id}/view', [ClassificationController::class, 'view'])->name('classifications.view');

    // MSIC Routes
    Route::get('msics', [MsicController::class, 'index'])->name('msics.index');
    Route::get('msics/create', [MsicController::class, 'create'])->name('msics.create');
    Route::post('msics', [MsicController::class, 'store'])->name('msics.store');
    Route::get('msics/{id}/edit', [MsicController::class, 'edit'])->name('msics.edit');
    Route::patch('msics/{id}', [MsicController::class, 'update'])->name('msics.update');
    Route::get('msics/{id}', [MsicController::class, 'show'])->name('msics.show');
    Route::delete('msics/{id}', [MsicController::class, 'destroy'])->name('msics.destroy');
    Route::get('msics/{id}/view', [MsicController::class, 'view'])->name('msics.view');
});

