<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek kredensial
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Ambil user yang login
        $user = Auth::user();

        // Hapus token lama jika perlu (opsional)
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirim response
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
{
    // Hapus token saat ini (token yang dipakai dalam request ini)
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'status' => true,
        'message' => 'Logout berhasil',
    ]);
}

}
