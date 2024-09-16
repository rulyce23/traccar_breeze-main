<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\TraccarApiController;
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
        Route::put('/device/{id}', [DeviceController::class, 'update'])->name('device.update');
       Route::get('/device/models', [DeviceController::class, 'getDevicesModel']);
        Route::get('/device/users', [DeviceController::class, 'getUsersModel']);
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('device.destroy');
    //  Route::get('/device/user', [DeviceController::class, 'getDevicesUser']);
       // Route::get('/device/status', [DeviceController::class, 'getDevicesStatus']);
        Route::resource('/device', DeviceController::class);
        Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::get('/account', [AccountController::class, 'create'])->name('account.create');
        Route::post('/account', [AccountController::class, 'store'])->name('user.store');
        Route::put('/users/{id}', [AccountController::class, 'update'])->name('user.update');
        Route::get('/account/models', [AccountController::class, 'getDevicesModel']);
        Route::get('/account/users', [AccountController::class, 'getUsersModel']);
        Route::delete('/users/{id}', [AccountController::class, 'destroy'])->name('user.destroy');

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
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('device.destroy');
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
