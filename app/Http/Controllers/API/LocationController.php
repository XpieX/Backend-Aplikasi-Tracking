<?php

namespace App\Http\Controllers\Api;

use App\Events\VehicleLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function updateLocation(Request $request)
    {
        Log::info('📥 Lokasi diterima', $request->all());

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Log::warning('❌ Validasi gagal', $validator->errors()->toArray());

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Simpan data lokasi ke tabel locations
            $location = Location::create([
                'user_id' => $request->user_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // Trigger event jika ingin real-time update
            event(new VehicleLocationUpdated($location));

            Log::info('✅ Lokasi berhasil disimpan dan event dikirim', [
                'user_id' => $location->user_id,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Lokasi berhasil diperbarui',
                'data' => $location,
            ], 200);
        } catch (\Exception $e) {
            Log::error('🔥 Gagal menyimpan lokasi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Terjadi kesalahan saat menyimpan lokasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
