<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    // Route::get('invoice', fn (Request $request) => $request->user())->name('invoice');
});

Route::middleware(['auth:sanctum', 'session_expiration', 'connection'])
->controller(Modules\Invoice\app\Http\Controllers\InvoiceController::class)
->prefix('invoices')
->group(function() {
    Route::get('list',  'list')->middleware('role:Admin|User');
    Route::get('search', 'search')->middleware('role:Admin|User');
    Route::get('export', 'export')->middleware('permission:export-excel');
    Route::get('export-pdf', 'exportPDF')->middleware('permission:export-pdf');
});

