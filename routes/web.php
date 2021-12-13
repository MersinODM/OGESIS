<?php

use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\AuthController;
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
Route::post('auth/login', [AuthController::class, "login"])->name('login');
Route::post('auth/logout', [AuthController::class, "logout"])->name('logout');

Route::get('{any?}', [AppController::class, "app"])
    ->where('any', '^(?!api|password\/reset).*$')
    ->name("app");
