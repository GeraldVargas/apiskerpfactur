<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'cuenta' => ['required', 'string', 'max:100'],
            'contrasena' => ['required', 'string'],
        ]);

        $usuario = DB::table('segu.tusuario')
            ->where('cuenta', $credentials['cuenta'])
            ->first();

        if (! $usuario) {
            return response()->json([
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        $passwordMatches = Hash::check($credentials['contrasena'], (string) $usuario->contrasena)
            || hash_equals((string) $usuario->contrasena, md5($credentials['contrasena']));

        if (! $passwordMatches) {
            return response()->json([
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        $email = Str::lower($credentials['cuenta']).'@api.local';

        $authUser = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => $credentials['cuenta'],
                'password' => Str::password(40),
            ]
        );

        $token = $authUser->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso.',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => [
                'id' => $authUser->id,
                'name' => $authUser->name,
                'email' => $authUser->email,
                'cuenta' => $credentials['cuenta'],
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout exitoso.',
        ]);
    }
}
