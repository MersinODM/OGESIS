<?php

use App\Helpers\Permissions;
use App\Http\Controllers\Api\{ActivityController,
    AuthController,
    BranchController,
    DistrictController,
    InstitutionController,
    PartnerController,
    PlanController,
    ReportRequestController,
    TeacherController,
    TeamController,
    ThemeController};
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
        Route::get('districts', [DistrictController::class, 'list'])->can(Permissions::DISTRICT_LIST);
    });

    // Planlama api endpoint ve yetki tanımları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::PLAN]], static function () {
        Route::post('plans', [PlanController::class, 'createAll'])->can(Permissions::PLAN_CREATE);
        Route::put('plans/{id}', [PlanController::class, 'update'])->can(Permissions::PLAN_UPDATE);
        Route::get('plans/latest/{count}', [PlanController::class, 'getLastPlans'])->can(Permissions::PLAN_LIST);
    });

    // Kurum endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::INSTITUTION]], static function () {
        Route::post('institutions', [InstitutionController::class, 'create'])->can(Permissions::INSTITUTION_CREATE);
        Route::post('institutions/import', [InstitutionController::class, 'importFromExcel'])->can(Permissions::INSTITUTION_UPLOAD);
        Route::post('institutions/table', [InstitutionController::class, 'getTable'])->can(Permissions::INSTITUTION_LIST);
        Route::put('institutions/{id}', [InstitutionController::class, 'update'])->can(Permissions::INSTITUTION_UPDATE);
        Route::get('institutions/search_by', [InstitutionController::class, 'searchBy'])->can(Permissions::INSTITUTION_LIST);
        Route::get('districts/{id}/institutions', [InstitutionController::class, 'get'])->can(Permissions::INSTITUTION_LIST);
    });

    // Tema endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::THEME]], static function () {
        Route::post('themes', [ThemeController::class, 'create'])->can(Permissions::THEME_CREATE);
        Route::put('themes/{id}', [ThemeController::class, 'update'])->can(Permissions::THEME_UPDATE);
        Route::get('themes', [ThemeController::class, 'getThemes'])->can(Permissions::THEME_LIST);
    });

    // Aktivite endpoint ve yetki denetimleri
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::ACTIVITY]], static function () {
        Route::post('activities', [ActivityController::class, 'create'])->can(Permissions::ACTIVITY_CREATE);
        Route::put('activities/{id}', [ActivityController::class, 'update'])->can(Permissions::ACTIVITY_UPDATE);
        Route::get('institutions/{id}/activities', [ActivityController::class, 'list'])->can(Permissions::ACTIVITY_LIST);
        Route::post('activities/table', [ActivityController::class, 'getTable'])->can(Permissions::ACTIVITY_LIST);

    });

    // Öğretmen endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::TEACHER]], static function () {
        Route::post('teachers', [TeacherController::class, 'create'])->can(Permissions::TEACHER_CREATE);
        Route::put('teachers/{id}', [TeacherController::class, 'update'])->can(Permissions::TEACHER_UPDATE);
        Route::post('teachers/table', [TeacherController::class, 'getTable'])->can(Permissions::TEACHER_LIST);
        Route::get('districts/{district_id}/institutions/{institution_id}/teachers', [TeacherController::class, 'get'])->can(Permissions::TEACHER_LIST);
    });

    // Takım endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::TEAM]], static function () {
        Route::post('teams', [TeamController::class, 'create'])->can(Permissions::TEAM_CREATE);
        Route::put('teams/{id}', [TeamController::class, 'update'])->can(Permissions::TEAM_UPDATE);
        Route::post('teams/table', [TeamController::class, 'getTable'])->can(Permissions::TEAM_LIST);
        Route::get('districts/{district_id}/institutions/{institution_id}/teams', [TeamController::class, 'get'])->can(Permissions::THEME_LIST);
    });

    //Branş endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::BRANCH]], static function (){
        Route::post('branches', [BranchController::class, 'create'])->can(Permissions::BRANCH_CREATE);
        Route::put('branches/{id}', [BranchController::class, 'update'])->can(Permissions::BRANCH_UPDATE);
        Route::get('branches/search_by', [BranchController::class, 'searchBy'])->can(Permissions::BRANCH_LIST);
    });

    //Partner endpoint ve yetki tanılamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::PARTNER]], static function () {
        Route::get('partners/search_by', [PartnerController::class, 'searchBy'])->can(Permissions::PARTNER_LIST);
    });

    //Report endpoint ve yetki tanımlamaları
    Route::group(['middleware' => ['role_or_permission:super-admin|'. Permissions::REPORT]], static function () {
        Route::post('report-requests', [ReportRequestController::class, 'create'])->can(Permissions::REPORT_CREATE);
        Route::post('report-requests/table', [ReportRequestController::class, 'getTable'])->can(Permissions::REPORT_LIST);
        // TODO rapor yükleme tamamlanacak
        Route::post('institutions/{institutionId}/reports/upload');
    });
});
