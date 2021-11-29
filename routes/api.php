<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\ThemeController;
use App\Models\Activity;
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
Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], static function () {

    // İlçeler api endpoint tanımları
    Route::get('districts', [DistrictController::class, 'list']);

    // Planlama api endpoint tanımları
    Route::post('plans', [PlanController::class, 'createAll']);
    Route::put('plans/{id}', [PlanController::class, 'update']);

    // Tema endpoint tanımlamaları
    Route::post('institutions', [InstitutionController::class, 'create']);
    Route::post('institutions/import', [InstitutionController::class, 'importFromExcel']);
    Route::post('institutions/table', [InstitutionController::class, 'getTable']);
    Route::put('institutions/{id}', [InstitutionController::class, 'update']);
    Route::get('institutions/search_by', [InstitutionController::class, 'searchBy']);

    // Tema endpoint tanımlamaları
    Route::post('themes', [ThemeController::class, 'create']);
    Route::put('themes/{id}', [ThemeController::class, 'update']);
    Route::get('themes', [ThemeController::class, 'searchByName']);

    // Aktivite endpoint tanımlamaları
    Route::post('activities', [ActivityController::class, 'create']);
    Route::put('activities/{id}', [ActivityController::class, 'update']);
    Route::get('activities', [ActivityController::class, 'list']);

    // Öğretmen endpoint tanımlamaları
    Route::post('teachers', [TeacherController::class, 'create']);
    Route::put('teachers/{id}', [TeacherController::class, 'update']);
    Route::get('teachers', [TeacherController::class, 'list']);
    Route::post('teachers/table', [TeacherController::class, 'getTable']);

    //Branş endpoint tanımlamaları
    Route::post('branches', [BranchController::class, 'create']);
    Route::put('branches/{id}', [BranchController::class, 'update']);
    Route::get('branches/search_by', [BranchController::class, 'searchBy']);

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
