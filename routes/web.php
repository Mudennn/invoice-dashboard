<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\CustomerController;

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

Route::get('/credit-notes', function () {
    return view('credit_notes.index');
})->name('credit_notes.index');

Route::get('/debit-notes', function () {
    return view('debit_notes.index');
})->name('debit_notes.index');

Route::get('/company_profile', function () {
    return view('company_profile.index');
})->name('company_profile.index');

Route::get('/company_profile/edit', function () {
    return view('company_profile.edit');
})->name('company_profile.edit');
