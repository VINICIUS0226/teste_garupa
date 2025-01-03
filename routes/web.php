<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', function () {
return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

Route::get('/forgot-password', function () {
return view('auth.passwords.email');
})->middleware('guest');

Route::any('/password/reset/{any}', function () {
return view('auth.passwords.reset');
})->middleware('guest');

Route::post('password_reset_link', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
->middleware('guest');

Route::post('password_reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
->middleware('guest');

Route::get('/transferList', [TransferController::class, 'index']);

Route::get('transfers/{id}', [\App\Http\Controllers\TransferController::class, 'show']);

Route::post('/transfers', [TransferController::class, 'store']);

Route::group(['middleware' => ['role:admin', 'auth']], function () {
Route::any('/admin/{any?}', [App\Http\Controllers\HomeController::class, 'index'])
->where('any', '.*');
});

Route::get('/login', function () {
return view('login');
});
