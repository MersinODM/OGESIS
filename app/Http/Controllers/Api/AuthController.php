<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Verilen kullanıcı giriş bilgileri hatalı!'],
            ]);
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
            ResponseKeys::MESSAGE => "Kullanıcı bilgileri doğrulandı.",
            "access_token" => $user->createToken($request->device_name)->plainTextToken,
            "token_type" => "Bearer"
        ]);
    }

    public function logout(): void {

    }

    /*
     * Mevcut kullanıcıya ait rolleri ve izinleri sağlar
     * @return JsonResponse
     */
    public function me(): JsonResponse {
        $user = Auth::user()
            ->with('roles:id,name,slug', 'institution:id,name')
            ->select('id', 'institution_id', 'full_name', 'phone', 'email')
            ->first();
        $user['permissions'] = Auth::user()->getAllPermissions();
        return response()->json($user);
    }
}