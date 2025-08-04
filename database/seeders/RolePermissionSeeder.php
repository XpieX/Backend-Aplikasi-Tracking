<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $hublang   = Role::firstOrCreate(['name' => 'Hublang']);
        $gudang = Role::firstOrCreate(['name' => 'Gudang']);
        $spi    = Role::firstOrCreate(['name' => 'SPI']);
        $survey    = Role::firstOrCreate(['name' => 'Survey']);

        $permissions = [
            'lihat progress',
            'tambah progress',
            'edit progress',
            'hapus progress',
            'atur pengguna'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $hublang->givePermissionTo(Permission::all());
        $gudang->givePermissionTo(['lihat progress', 'tambah progress', 'edit progress']);
        $spi->givePermissionTo(['lihat progress']);
        $survey->givePermissionTo(['lihat progress']);
    }
}
