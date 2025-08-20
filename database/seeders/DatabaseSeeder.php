<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat role jika belum ada
        // $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        // $dokterRole = Role::firstOrCreate(['name' => 'dokter']);
        // $kasirRole = Role::firstOrCreate(['name' => 'kasir']);
        // Permission::create(['name' => 'view dashboard']);
        // Permission::create(['name' => 'manage master data']);
        // Permission::create(['name' => 'register pasien']);
        // Permission::create(['name' => 'manage tindakan']);
        // Permission::create(['name' => 'manage pembayaran']);
        // Permission::create(['name' => 'view laporan']);
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $petugas = Role::findByName('petugas');
        $petugas->givePermissionTo(['view dashboard','register pasien']);

        $dokter = Role::findByName('dokter');
        $dokter->givePermissionTo(['view dashboard','manage tindakan']);

        $kasir = Role::findByName('kasir');
        $kasir->givePermissionTo(['view dashboard','manage pembayaran']);

        // Buat user dan assign role
        // $admin = User::firstOrCreate(
        //     ['email' => 'admin@example.com'],
        //     ['name' => 'Admin', 'password' => bcrypt('password123')]
        // );
        // $admin->assignRole($adminRole);

        // $petugas = User::firstOrCreate(
        //     ['email' => 'petugas@example.com'],
        //     ['name' => 'Petugas', 'password' => bcrypt('password123')]
        // );
        // $petugas->assignRole($petugasRole);

        // $dokter = User::firstOrCreate(
        //     ['email' => 'dokter@example.com'],
        //     ['name' => 'Dokter', 'password' => bcrypt('password123')]
        // );
        // $dokter->assignRole($dokterRole);

        // $kasir = User::firstOrCreate(
        //     ['email' => 'kasir@example.com'],
        //     ['name' => 'Kasir', 'password' => bcrypt('password123')]
        // );
        // $kasir->assignRole($kasirRole);
    }


}
