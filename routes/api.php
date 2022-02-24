<?php

use App\Helpers\Permissions;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ReportRequestController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeamController;
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

    // Rol ve izinler api endpoint tanımlamaları
    Route::get('me', [AuthController::class, 'me']);


    // İlçeler api endpoint tanımları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::DISTRICT]], static function () {
        Route::get('districts', [DistrictController::class, 'list'])->can(Permissions::LIST);
    });

    // Planlama api endpoint ve yetki tanımları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::PLAN]], static function () {
        Route::post('plans', [PlanController::class, 'createAll'])->can(Permissions::CREATE);
        Route::put('plans/{id}', [PlanController::class, 'update'])->can(Permissions::UPDATE);
        Route::get('plans/latest/{count}', [PlanController::class, 'getLastPlans'])->can(Permissions::LIST);
    });

    // Kurum endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::INSTITUTION]], static function () {
        Route::post('institutions', [InstitutionController::class, 'create'])->can(Permissions::CREATE);
        Route::post('institutions/import', [InstitutionController::class, 'importFromExcel'])->can(Permissions::CREATE);
        Route::post('institutions/table', [InstitutionController::class, 'getTable'])->can(Permissions::LIST);
        Route::put('institutions/{id}', [InstitutionController::class, 'update'])->can(Permissions::UPDATE);
        Route::get('institutions/search_by', [InstitutionController::class, 'searchBy'])->can(Permissions::LIST);
        Route::get('districts/{id}/institutions', [InstitutionController::class, 'get'])->can(Permissions::LIST);
    });

    // Tema endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::THEME]], static function () {
        Route::post('themes', [ThemeController::class, 'create'])->can(Permissions::CREATE);
        Route::put('themes/{id}', [ThemeController::class, 'update'])->can(Permissions::UPDATE);
        Route::get('themes', [ThemeController::class, 'getThemes'])->can(Permissions::LIST);
        Route::get('districts/{district_id}/institutions/{institution_id}/teams', [TeamController::class, 'get'])->can(Permissions::LIST);
    });

    // Aktivite endpoint ve yetki denetimleri
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::ACTIVITY]], static function () {
        Route::post('activities', [ActivityController::class, 'create'])->can(Permissions::CREATE);
        Route::put('activities/{id}', [ActivityController::class, 'update'])->can(Permissions::UPDATE);
        Route::get('activities', [ActivityController::class, 'list'])->can(Permissions::LIST);
    });

    // Öğretmen endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::TEACHER]], static function () {
        Route::post('teachers', [TeacherController::class, 'create'])->can(Permissions::CREATE);
        Route::put('teachers/{id}', [TeacherController::class, 'update'])->can(Permissions::UPDATE);
        Route::post('teachers/table', [TeacherController::class, 'getTable'])->can(Permissions::LIST);
        Route::get('districts/{district_id}/institutions/{institution_id}/teachers', [TeacherController::class, 'get'])->can(Permissions::LIST);
    });

    // Takım endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::TEAM]], static function () {
        Route::post('teams', [TeamController::class, 'create'])->can(Permissions::CREATE);
        Route::put('teams/{id}', [TeamController::class, 'update'])->can(Permissions::UPDATE);
        Route::post('teams/table', [TeamController::class, 'getTable'])->can(Permissions::LIST);
    });

    //Branş endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::BRANCH]], static function (){
        Route::post('branches', [BranchController::class, 'create'])->can(Permissions::CREATE);
        Route::put('branches/{id}', [BranchController::class, 'update'])->can(Permissions::UPDATE);
        Route::get('branches/search_by', [BranchController::class, 'searchBy'])->can(Permissions::LIST);
    });

    //Partner endpoint ve yetki tanılamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::PARTNER]], static function () {
        Route::get('partners/search_by', [PartnerController::class, 'searchBy'])->can(Permissions::LIST);
    });

    //Report endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::REPORT]], static function () {
        Route::post('report-requests', [ReportRequestController::class, 'create'])->can(Permissions::CREATE);
        Route::post('report-requests/table', [ReportRequestController::class, 'getTable'])->can(Permissions::LIST);
    });
});
