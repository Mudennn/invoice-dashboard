<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard.index');
// });
Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard.index');


Route::get('/invoices', function () {
    return view('invoices.index');
})->name('invoices.index');

Route::get('/invoices/create', function () {
    return view('invoices.create');
})->name('invoices.create');

Route::get('/credit-notes', function () {
    return view('credit_notes.index');
})->name('credit_notes.index');

Route::get('/debit-notes', function () {
    return view('debit_notes.index');
})->name('debit_notes.index');

Route::get('/contacts', function () {
    return view('contacts.index');
})->name('contacts.index');

Route::get('/contacts/create', function () {
    return view('contacts.create');
})->name('contacts.create');
