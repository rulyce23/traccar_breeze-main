<?php

use App\Http\Controllers\api\TraccarApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/server', [TraccarApiController::class, 'server']);
Route::get('/session', [TraccarApiController::class, 'session']);
Route::post('/session/token', [TraccarApiController::class, 'sessionToken'])->name('session.token');
Route::get('/session/socket', [TraccarApiController::class, 'sessionSocket'])->name('session.socket');
Route::get('/session/openid/auth', [TraccarApiController::class, 'sessionOpenidAuth'])->name('session.auth');
Route::get('/session/openid/callback', [TraccarApiController::class, 'sessionOpenidCallback'])->name('session.callback');
Route::get('/devices', [TraccarApiController::class, 'devices']);
Route::get('/devices/{id}', [TraccarApiController::class, 'devicesById']);
Route::get('/groups', [TraccarApiController::class, 'groups']);
Route::get('/positions', [TraccarApiController::class, 'positions']);
Route::get('/positions/{id}', [TraccarApiController::class, 'positionsById']);
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
