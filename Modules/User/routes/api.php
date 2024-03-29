<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\UserController;

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
    Route::get('user', fn (Request $request) => $request->user())->name('user');
});

Route::post('login', [UserController::class, 'login']);
Route::get('users/get-current',  [UserController::class,'getCurrentUser'])->middleware(['auth:sanctum', 'role:Admin|User']);
Route::get('users/logout',  [UserController::class,'logout'])->middleware(['auth:sanctum', 'role:Admin|User']);

Route::middleware(['auth:sanctum', 'role:Admin'])
->controller(Modules\User\app\Http\Controllers\UserController::class)
->prefix('users')
->group(function() {
    Route::post('add',  'addUser');
    Route::get('list',  'listUsers');
    Route::get('get',  'getUser');
    Route::post('update',  'updateUser');
    Route::delete('delete',  'deleteUser');
});
