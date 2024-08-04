<?php

use App\Http\Controllers\api\TraccarApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'api.auth'])->group(function () {
    Route::get('/server', [TraccarApiController::class, 'server']);
    Route::get('/session', [TraccarApiController::class, 'session']);
    Route::post('/session/token', [TraccarApiController::class, 'sessionToken'])->name('session.token');
    Route::get('/session/socket', [TraccarApiController::class, 'sessionSocket'])->name('session.socket');
    Route::get('/session/openid/auth', [TraccarApiController::class, 'sessionOpenidAuth'])->name('session.auth');
    Route::get('/session/openid/callback', [TraccarApiController::class, 'sessionOpenidCallback'])->name('session.callback');
    Route::get('/devices', [TraccarApiController::class, 'devices']);
    Route::get('/devices2', [TraccarApiController::class, 'devices2']);
    Route::get('/devices/{id}', [TraccarApiController::class, 'devicesById']);
    Route::get('/devices2/{id}', [TraccarApiController::class, 'devicesById2']);
    Route::get('/groups', [TraccarApiController::class, 'groups']);
    Route::get('/positions', [TraccarApiController::class, 'positions']);
    Route::get('/positions/{id}', [TraccarApiController::class, 'positionsById']);
    Route::get('/positions2/{id}', [TraccarApiController::class, 'positionsById2']);
    Route::get('/events/{id}', [TraccarApiController::class, 'events']);
    Route::get('/reports/route', [TraccarApiController::class, 'reportsRoute']);
    Route::get('/reports/summary', [TraccarApiController::class, 'reportsSummary']);
    Route::get('/reports/trips', [TraccarApiController::class, 'reportsTrips']);
    Route::get('/reports/stops', [TraccarApiController::class, 'reportsStops']);
    Route::get('/notifications', [TraccarApiController::class, 'notifications']);
    Route::get('/notifications/type', [TraccarApiController::class, 'notificationsType']);
    Route::get('/geofences', [TraccarApiController::class, 'geofences']);
    Route::get('/commands', [TraccarApiController::class, 'commands']);
    Route::get('/commands/send', [TraccarApiController::class, 'commandsSend']);
    Route::get('/commands/types', [TraccarApiController::class, 'commandsTypes']);
    Route::get('/attributes/computed', [TraccarApiController::class, 'attributesComputed']);
    Route::get('/drivers', [TraccarApiController::class, 'drivers']);
    Route::get('/calendars', [TraccarApiController::class, 'calendars']);
    Route::get('/statistics', [TraccarApiController::class, 'statistics']);
    Route::get('/users', [TraccarApiController::class, 'users']);
    Route::get('/users/{id}', [TraccarApiController::class, 'usersById']);
});

Route::middleware(['web'])->group(function () {
    Route::get('/test-session', function () {
        $email = session('email');
        $password = session('password');
        return response()->json([
            'email' => $email,
            'password' => $password,
        ]);
    });
});
