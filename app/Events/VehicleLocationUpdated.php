<?php

namespace App\Events;

use App\Models\Location;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VehicleLocationUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $location;
    public $user;

    public function __construct(Location $location)
    {
        $this->location = $location;
        $this->user = $location->user; // relasi user di model Location

        Log::info('📦 Membuat event VehicleLocationUpdated', [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'lat' => $this->location->latitude,
            'lng' => $this->location->longitude,
        ]);
    }

    /**
     * Data yang dikirim ke Pusher.
     */
    public function broadcastWith(): array
    {
        $payload = [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'lat' => (float) $this->location->latitude,
            'lng' => (float) $this->location->longitude,
            'updated_at' => $this->location->created_at->toDateTimeString(),
        ];

        Log::info('📤 Mengirim event ke frontend:', $payload);

        return $payload;
    }

    /**
     * Channel tempat event ini dipancarkan.
     */
    public function broadcastOn()
    {
        return new Channel('vehicle-tracking');
    }

    /**
     * Nama event yang akan diterima di frontend.
     */
    public function broadcastAs(): string
    {
        return 'location.updated';
    }
}
