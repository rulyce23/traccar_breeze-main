<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['api.auth'])->controller(MonitorController::class)->group(
    function () {
        Route::get('/monitor', 'index')->name('monitor');
        Route::get('/api/token', [AuthController::class, 'getToken']);
    }
);

Route::middleware(['api.auth'])->controller(AccountController::class)->group(
    function () {
        Route::get('/account', 'index')->name('account');
        Route::get('/api/token', [AuthController::class, 'getToken']);
    }
);

Route::middleware(['api'])->controller(MonitorController::class)->group(
    function () {
        Route::get('/monitor', 'index')->name('monitor');
        Route::get('/api/token', [AuthController::class, 'getToken']);
    }
);

Route::middleware(['api'])->controller(AccountController::class)->group(
    function () {
        Route::get('/account', 'index')->name('account');
        Route::get('/api/token', [AuthController::class, 'getToken']);
    }
);


Route::middleware(['api.auth'])->group(
    function () {
        Route::resource('/monitor', MonitorController::class);
        Route::get('/tree', [MonitorController::class, 'tree']);
        Route::get('/device', [DeviceController::class, 'create'])->name('device.create');
        Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
        Route::resource('/device', DeviceController::class);
        Route::get('/account', [AccountController::class, 'create'])->name('account.create');
        Route::post('/account', [AccountController::class, 'store'])->name('account.store');
        Route::get('/api/token', [AuthController::class, 'getToken']);
        Route::post('/account/search', [AccountController::class, 'search'])
        ->name('account.search')
        ->middleware('api.auth');


        Route::post('/monitor', [MonitorController::class, 'index'])
        ->name('monitor.index')
        ->middleware('api.auth');
        Route::resource('/account', AccountController::class);
        Route::get('/logout', [AuthController::class, 'logout']);

    }
);


Route::middleware(['api'])->group(
    function () {
        Route::resource('/monitor', MonitorController::class);
        Route::get('/tree', [MonitorController::class, 'tree']);
        Route::get('/device', [DeviceController::class, 'create'])->name('device.create');
        Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
        Route::resource('/device', DeviceController::class);
        Route::get('/account', [AccountController::class, 'create'])->name('account.create');
        Route::post('/account', [AccountController::class, 'store'])->name('account.store');
        Route::get('/api/token', [AuthController::class, 'getToken']);
        Route::post('/account/search', [AccountController::class, 'search'])
        ->name('account.search')
        ->middleware('api.auth');


        Route::post('/monitor', [MonitorController::class, 'index'])
        ->name('monitor.index')
        ->middleware('api.auth');
        Route::resource('/account', AccountController::class);
        Route::get('/logout', [AuthController::class, 'logout']);

    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
