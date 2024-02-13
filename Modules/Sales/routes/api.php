<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Sales\App\Http\Controllers\SalesController;

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

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('sales', fn (Request $request) => $request->user())->name('sales');
// });

Route::get('branch ' , [SalesController::class , "index"]);

Route::get('getBranch' , [SalesController::class , "show"]);

Route::get('getSortedBranches' , [SalesController::class , "GetGreatestBranchSales"]);

Route::get('getSalesValue' , [SalesController::class , "GetBranchsSales"]);

Route::get('GetSalesMonthly' , [SalesController::class , "GetSalesValueForMonth"]);
