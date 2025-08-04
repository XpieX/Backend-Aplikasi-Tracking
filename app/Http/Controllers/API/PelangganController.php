<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pekerjaan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pekerjaans = Pelanggan::with('user')
        ->where('user_id', $id)
        ->orderBy('id')
        ->get();

    $data = $pekerjaans->map(fn ($item) => [
        'id' => $item->id,
        'nama_user' => $item->user?->name,
        'nama_pelanggan' => $item->nama_pelanggan,
        'alamat' => $item->alamat,
        'status' => $item->status,
        'latitude' => $item->latitude,
        'longitude' => $item->longitude,
    ]);

    return response()->json([
        'status' => true,
        'message' => $data->isNotEmpty() ? 'Data ditemukan' : 'Tidak ada pekerjaan',
        'data' => $data,
    ]);
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

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|integer|in:0,1',
    ]);

    $job = Pelanggan::findOrFail($id);
    $job->status = $request->status;
    $job->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated',
        'data' => $job,
    ]);
}
}
