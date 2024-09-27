<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DatatableController as AdminDatatableController;
use App\Http\Controllers\Admin\FileManageController as AdminFileManageController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\DatatableController as UserDatatableController;
use App\Http\Controllers\User\FileManageController as UserFileManageController;
use App\Http\Controllers\User\MessageController as UserMessageController;
use App\Http\Controllers\User\TicketController as UserTicketController;

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
    Route::get('file/download/{file}', [AdminFileManageController::class, 'download'])->name('admin.file.download');
    Route::post('update/sort/order', [AdminDatatableController::class, 'updateSortOrder'])->name('update.sort.order');
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('admin', AdminController::class);
    Route::get('admin/status/{admin}', [AdminController::class, 'status'])->name('admin.status');

    Route::resource('user', AdminUserController::class);
    Route::get('user/status/{user}', [AdminUserController::class, 'status'])->name('user.status');

    Route::controller(AdminTicketController::class)->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/details/{id}', 'details')->name('details');
        Route::get('/details/close/{id}', 'close')->name('close');
    });
    Route::controller(AdminMessageController::class)->prefix('message')->name('message.')->group(function () {
        Route::post('/send', 'message')->name('send');
    });
});

Route::group(['middleware' => 'auth', 'as' => 'user.', 'prefix' => 'user-panel'], function () {
    Route::get('file/download/{file}', [UserFileManageController::class, 'download'])->name('file.download');
    Route::post('update/sort/order', [UserDatatableController::class, 'updateSortOrder'])->name('update.sort.order');
    Route::get('/', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::controller(UserTicketController::class)->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('create');
        Route::get('/details/{id}', 'details')->name('details');
    });
    Route::controller(UserMessageController::class)->prefix('message')->name('message.')->group(function () {
        Route::post('/send', 'message')->name('send');
    });
});
