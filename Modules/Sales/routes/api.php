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

Route::prefix('branches-Sales')->middleware(['auth:sanctum', 'role:Admin|User', 'session_expiration', 'connection'])
->controller(SalesController::class)
->group(function () {

    Route::get('All-branches' , "index");

    Route::get('getBranch' ,   "show");

    Route::get('getSortedBranches' , "SortByBranchSales");

    Route::get('getSalesValue' , "GetBranchsSales");

    Route::get('GetSalesMonthly',  "GetSalesValueForMonth");
    Route::get('Search-For' , "searchForBranch");

    Route::get('getSalesBetween' , "GetSalesValueBetweenMonths");

    Route::get('num-of-branches' , "GetNumOfBranches");

    Route::get('ExcelForm' , "GetBranchesSalesBetweenMonths");
});

// Route::get('branch ' , [SalesController::class , "index"]);

// Route::get('getBranch' , [SalesController::class , "show"]);

// Route::get('getSortedBranches' , [SalesController::class , "GetGreatestBranchSales"]);

// Route::get('getSalesValue' , [SalesController::class , "GetBranchsSales"]);

// Route::get('GetSalesMonthly' , [SalesController::class , "GetSalesValueForMonth"]);
