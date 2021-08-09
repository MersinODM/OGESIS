<?php

use App\Http\Controllers\Api\AuthController;
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
Route::post('app/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], static function () {

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
