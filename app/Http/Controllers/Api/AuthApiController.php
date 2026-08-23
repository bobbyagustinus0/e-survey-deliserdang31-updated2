<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    /**
     * Login via API -> mengembalikan token (dipakai sebagai Bearer Token di setiap request selanjutnya).
     * POST /api/login
     * body: { "username": "...", "password": "..." }
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = \App\Models\User::where($loginField, $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email atau password salah.',
            ], 401);
        }

        if ($user->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Akun anda tidak aktif. Hubungi administrator.',
            ], 403);
        }

        // Hapus token lama (opsional, supaya 1 device = 1 token aktif)
        $user->tokens()->delete();

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role->nama_role ?? null,
                ],
            ],
        ]);
    }

    /**
     * Logout -> mencabut token yang sedang dipakai.
     * POST /api/logout  (perlu header Authorization: Bearer <token>)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Data profil user yang sedang login (untuk cek token masih valid atau tidak).
     * GET /api/profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role->nama_role ?? null,
            ],
        ]);
    }
}
