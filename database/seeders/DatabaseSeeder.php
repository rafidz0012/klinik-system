<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =========================
         * 1. DEFINISI ROLE & PERMISSION
         * =========================
         */
        $roles = [
            'admin',
            'petugas',
            'dokter',
            'kasir',
        ];

        $permissions = [
            'view dashboard',
            'manage master data',
            'register pasien',
            'manage tindakan',
            'manage pembayaran',
            'view laporan',
        ];

        /**
         * =========================
         * 2. BUAT ROLE (IDEMPOTENT)
         * =========================
         */
        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
        }

        /**
         * =========================
         * 3. BUAT PERMISSION (IDEMPOTENT)
         * =========================
         */
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        /**
         * =========================
         * 4. ASSIGN PERMISSION KE ROLE
         * =========================
         */
        Role::findByName('admin')->syncPermissions(Permission::all());

        Role::findByName('petugas')->syncPermissions([
            'view dashboard',
            'register pasien',
        ]);

        Role::findByName('dokter')->syncPermissions([
            'view dashboard',
            'manage tindakan',
        ]);

        Role::findByName('kasir')->syncPermissions([
            'view dashboard',
            'manage pembayaran',
        ]);

        /**
         * =========================
         * 5. BUAT USER & ASSIGN ROLE
         * =========================
         */
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@example.com',
                'password' => 'password123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Dokter',
                'email' => 'dokter@example.com',
                'password' => 'password123',
                'role' => 'dokter',
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@example.com',
                'password' => 'password123',
                'role' => 'kasir',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            if (! $user->hasRole($data['role'])) {
                $user->assignRole($data['role']);
            }
        }
    }
}
