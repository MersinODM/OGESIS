<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends ApiController
{
    /*
     * Bu api sistemde yer alan tüm izinleri listeler
     * Bunu sadece adminler kullanabilir
     */
    public function getSystemPermissions(): JsonResponse
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    /*
     * Mevcut Kullanıcı izinlerini listleme
     */
    public function minePermissions(): JsonResponse {

    }

    public function addPermissionToRole(): JsonResponse {

    }

    public function removePermissionFromRole(): JsonResponse {

    }

    public function addPermissionToUser(): JsonResponse {

    }

    public function removePermissionFromUser(): JsonResponse {

    }
}