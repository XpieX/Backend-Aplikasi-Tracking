<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class LiveTracking extends Component
{
    public $latitude = -6.2;
    public $longitude = 106.816666;

    protected $listeners = ['updateLocation' => 'updateLocation'];

    public function mount()
    {
        // Awal posisi default
    }

    public function updateLocation($data)
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }

    public function render()
    {
        return view('livewire.live-tracking');
    }
}
