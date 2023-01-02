<?php

use App\Filament\Resources\AppraisalResponseResource\Pages\CreateAppraisalResponse;
use App\Http\Controllers\AppraisalResponseRequest;
use App\Http\Controllers\AttendanceController;
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

Route::get('/', function () {
    return redirect(route('filament.auth.login'));
});

Route::get('/oa-dashboard', function () {
    return redirect('/cp-dashboard');
});
