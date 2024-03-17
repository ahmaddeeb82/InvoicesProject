<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Database\App\Http\Controllers\DatabaseController;

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
    Route::get('database', fn (Request $request) => $request->user())->name('database');
});

Route::middleware(['auth:sanctum', 'role:Admin', 'connection'])
->controller(Modules\Database\app\Http\Controllers\DatabaseController::class)
->prefix('databases')
->group(function() {
    Route::get('list','list');
    Route::post('set-admin',  'setAdmin');
    Route::post('set-users',  'setUsers');
    Route::get('get-users',  'getUsers');
    Route::get('get-admin',  'getAdmin');
});