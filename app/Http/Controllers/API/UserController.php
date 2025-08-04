<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => "Data ditemukan",
            'data' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function getFotoProfil($id)
    {
        $user = User::find($id);
    
        if (!$user || !$user->foto) {
            return response()->json([
                'success' => false,
                'message' => 'Foto tidak ditemukan',
                'foto_url' => null,
            ], 404);
        }
    
        // Pastikan kamu sudah menjalankan `php artisan storage:link`
        $url = asset('storage/' . $user->foto);
    
        return response()->json([
            'success' => true,
            'message' => 'Foto profil ditemukan',
            'foto_url' => $url
        ]);
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
