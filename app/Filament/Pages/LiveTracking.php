<?php

namespace App\Filament\Pages;

use App\Models\Vehicle;
use Filament\Pages\Page;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Facades\DB;
namespace App\Filament\Pages;

use App\Models\Location;
use Filament\Pages\Page;

class LiveTracking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static string $view = 'filament.pages.live-tracking';
    protected static ?string $navigationLabel = 'Map Live Tracking';
    protected static ?int $navigationSort = 4;
    public $locations;

    public function mount()
    {
        $this->locations = Location::latest('created_at')
            ->get()
            ->groupBy('user_id')
            ->map(function ($locations) {
                return $locations->first();
            })
            ->values()
            ->map(function ($loc) {
                return [
                    'user_id' => $loc->user_id,
                    'name' => optional($loc->user)->name,
                    'latitude' => (float) $loc->latitude,
                    'longitude' => (float) $loc->longitude,
                ];
            })
            ->values();
    }
    
    protected function getViewData(): array
    {
        return [
            'locations' => $this->locations,
        ];
    }
    

    public function refreshData(): void
    {
        $this->mount(); // cukup panggil ulang
    }
}

