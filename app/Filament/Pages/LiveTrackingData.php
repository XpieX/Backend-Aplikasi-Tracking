<?php

namespace App\Filament\Pages;

use App\Models\Location;
use App\Models\Vehicle;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;

class LiveTrackingData extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static string $view = 'filament.pages.live-tracking-data';
    protected static ?string $navigationLabel = 'Tabel Live Tracking';
    protected static ?int $navigationSort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Location::select('locations.*')
                    ->joinSub(
                        Location::selectRaw('MAX(id) as id')
                            ->groupBy('user_id'),
                        'latest_locations',
                        'locations.id',
                        '=',
                        'latest_locations.id'
                    )
            )
            ->columns([
                TextColumn::make('user.name')->label('Nama Pekerja'),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
                TextColumn::make('updated_at')
                    ->label('Terakhir Update')
                    ->since()
                    ->sortable(),
            ])
            ->poll('2s'); // auto-refresh tiap 2 detik
    }
    
}
