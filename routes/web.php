<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('leave_application')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\LeaveApplicationController::class, 'index'])->name('leave_application.index');
    Route::get('/create', [App\Http\Controllers\LeaveApplicationController::class, 'create'])->name('leave_application.create');
    Route::post('/store', [App\Http\Controllers\LeaveApplicationController::class, 'store'])->name('leave_application.store');
    Route::get('/{id}/edit', [App\Http\Controllers\LeaveApplicationController::class, 'edit'])->name('leave_application.edit');
    Route::put('/{id}', [App\Http\Controllers\LeaveApplicationController::class, 'update'])->name('leave_application.update');
    Route::delete('/{id}/delete', [App\Http\Controllers\LeaveApplicationController::class, 'destroy'])->name('leave_application.destroy');
    Route::post('/{id}/approve', [App\Http\Controllers\LeaveApplicationController::class, 'approve'])->name('leave_application.approve');
    Route::post('/{id}/reject', [App\Http\Controllers\LeaveApplicationController::class, 'reject'])->name('leave_application.reject');
    Route::get('/excel', [App\Http\Controllers\LeaveApplicationController::class, 'excel'])->name('leave_application.excel');
});

Route::prefix('travel_authorization')->middleware('auth')->group(function(){
    Route::get('/', [App\Http\Controllers\TravelAuthorizationController::class, 'index'])->name('travel_authorization.index');
    Route::get('/create', [App\Http\Controllers\TravelAuthorizationController::class, 'create'])->name('travel_authorization.create');
    Route::post('/store', [App\Http\Controllers\TravelAuthorizationController::class, 'store'])->name('travel_authorization.store');
    Route::get('/{id}/edit', [App\Http\Controllers\TravelAuthorizationController::class, 'edit'])->name('travel_authorization.edit');
    Route::put('/{id}', [App\Http\Controllers\TravelAuthorizationController::class, 'update'])->name('travel_authorization.update');
    Route::delete('/{id}/delete', [App\Http\Controllers\TravelAuthorizationController::class, 'destroy'])->name('travel_authorization.destroy');
    Route::post('/{id}/approve', [App\Http\Controllers\TravelAuthorizationController::class, 'approve'])->name('travel_authorization.approve');
    Route::post('/{id}/reject', [App\Http\Controllers\TravelAuthorizationController::class, 'reject'])->name('travel_authorization.reject');
    Route::get('/excel', [App\Http\Controllers\TravelAuthorizationController::class, 'excel'])->name('travel_authorization.excel');
});

Route::prefix('user')->middleware('auth')->group(function(){
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
});
