<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\WebhookController;
use App\Models\User;
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
Route::post('/device',[DeviceController::class,'create' ]);
Route::get('/allDevice',[DeviceController::class,'allDevice' ]);


Route::post('/webhook',[WebhookController::class,'create' ]);
