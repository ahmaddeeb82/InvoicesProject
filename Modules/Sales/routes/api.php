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

Route::prefix('branches-Sales')
->middleware(['auth:sanctum', 'session_expiration', 'connection'])
->controller(SalesController::class)
->group(function () {

    Route::get('All-branches' , "index")->middleware('role:Admin|User');

    Route::get('getBranch' ,   "show")->middleware('role:Admin|User');

    Route::get('getSortedBranches' , "SortByBranchSales")->middleware('role:Admin|User');

    Route::get('getGreatestBranch' , "GetGreatestBranchSales")->middleware('role:Admin|User');

    Route::get('getSalesValue' , "GetBranchsSales")->middleware('role:Admin|User');

    Route::get('GetSalesMonthly',  "GetSalesValueForMonth")->middleware('role:Admin|User');
    Route::get('Search-For' , "searchForBranch")->middleware('role:Admin|User');

    Route::get('getSalesBetween' , "GetSalesValueBetweenMonths")->middleware('role:Admin|User');

    Route::get('num-of-branches' , "GetNumOfBranches")->middleware('role:Admin|User');

    Route::get('ExcelForm' , "GetBranchesSalesBetweenMonths")->middleware('permission:export-excel');

    Route::get('PDFForm' , "GetBranchesSalesBetweenMonthsForPDF")->middleware('permission:export-pdf');
});

// Route::get('branch ' , [SalesController::class , "index"]);

// Route::get('getBranch' , [SalesController::class , "show"]);

// Route::get('getSortedBranches' , [SalesController::class , "GetGreatestBranchSales"]);

// Route::get('getSalesValue' , [SalesController::class , "GetBranchsSales"]);

// Route::get('GetSalesMonthly' , [SalesController::class , "GetSalesValueForMonth"]);
