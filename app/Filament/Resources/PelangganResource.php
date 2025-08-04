<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;
    protected static ?string $navigationLabel = 'Pelanggan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("user_id")
                    ->required()
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->placeholder("Pilih Pekerja"),

                TextInput::make('ktp')
                    ->label('Ktp')
                    ->required(),

                TextInput::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->required(),

                TextInput::make('alamat')
                    ->label('Alamat Pelanggan')
                    ->required(),

                TextInput::make('latitude')
                    ->label('Latitude')
                    ->reactive()
                    ->required(),

                TextInput::make('longitude')
                    ->label('Longitude')
                    ->reactive()
                    ->required(),

                // ViewField::make('map_picker')
                //     ->view('forms.components.map-picker')
                //     ->label('Pilih Lokasi di Peta')
                //     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label("Nama Pekerja"),
                TextColumn::make('nama_pelanggan')->label("Nama Pelanggan"),
                TextColumn::make('alamat')->label("Alamat Pelanggan"),
                TextColumn::make('status')->formatStateUsing(fn($state) => match ((int) $state) {
                    0 => 'Belum Selesai',
                    1 => 'Selesai',
                    default => 'Tidak Diketahui',
                })->label("Status"),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
