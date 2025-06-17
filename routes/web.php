<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\RefundNoteController;
use App\Http\Controllers\CompanyProfileController;

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard.index');

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
