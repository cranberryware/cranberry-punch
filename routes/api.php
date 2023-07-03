<?php

use App\Http\Controllers\GenericBiometricDeviceController;
use App\Http\Controllers\SmackBioBiometricDeviceController;
use App\Http\Middleware\ClockingDeviceAuth;
use App\Http\Middleware\ClockingDeviceLogging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware([ClockingDeviceAuth::class, ClockingDeviceLogging::class])
    ->post('/attendance/device/generic-biometric', [GenericBiometricDeviceController::class, 'createAttendance']);
Route::middleware([ClockingDeviceAuth::class, ClockingDeviceLogging::class])
    ->post('/attendance/device/smackbio-biometric', [SmackBioBiometricDeviceController::class, 'createAttendance']);
