<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Invoice\App\Http\Controllers\InvoiceController;

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

Route::middleware(['auth:sanctum', 'role:Admin,User', 'session_expiration'])
->controller(Modules\Invoice\app\Http\Controllers\InvoiceController::class)
->prefix('invoices')
->group(function() {
    Route::get('list',  'list');
});


Route::get('invoice ' , [InvoiceController::class , "index"]);
Route::get('get', [InvoiceController::class, 'get']);
