<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DatatableController as AdminDatatableController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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
    return redirect('/login');
});

Auth::routes();

Route::controller(AdminLoginController::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginCheck')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin-panel'], function () {
    Route::post('update/sort/order', [AdminDatatableController::class, 'updateSortOrder'])->name('update.sort.order');
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('admin', AdminController::class);
    Route::get('admin/status/{admin}', [AdminController::class, 'status'])->name('admin.status');

    Route::resource('user', AdminUserController::class);
    Route::get('user/status/{user}', [AdminUserController::class, 'status'])->name('user.status');
});
