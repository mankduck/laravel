<?php

use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//Backend Routes
Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('admin');

//User Routes

Route::group(['prefix' => 'user'], function () {
    Route::get('index', [UserController::class, 'index'])->name('user.index');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
    Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
    Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
    Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
});

Route::group(['prefix' => 'user/catalogue'], function () {
    Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
    Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
    Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
    Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
    // Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
    // Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.updatePermission');
});


/* AJAX */
Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');




Route::get('admin', [AuthController::class, 'admin'])->name('auth.admin')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
