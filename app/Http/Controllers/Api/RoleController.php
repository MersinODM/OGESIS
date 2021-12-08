<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Composer\DependencyResolver\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends ApiController
{
    /*
     * Bu api sadece adminler tarafından kullanılacak
     * Sistem rollerini listeleme işini yapar
     */
    public function getSystemRoles(): JsonResponse {

    }

    /*
     * Kullanıcılara rol atanabilir
     */
    public function addRoleToUser(): JsonResponse
    {

    }

    /*
     * Kullancıdan rol silinebilir
     */
    public function removeRoleFromUser(): JsonResponse {

    }

    /*
     * Sisteme yeni roller tanımlanabilir çünkü tüm işlemler izinler
     * üzerinden yürütülecek (Permission based)
     */
    public function create(Request $request) : JsonResponse {

    }

    /*
     * Sistemdeki rollerin adı güncellenebilir
     */
    public function update(Request $request) : JsonResponse {

    }

    /*
     * Sistemdeki roller silinebilir
     */
    public function delete(Request $request) : JsonResponse {

    }
}