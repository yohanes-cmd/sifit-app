<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar role sesuai desain pembimbing
        $roles = [
            'super_admin',
            'admin',
            'produsen_data',
            'verifikator',
            'validator',
            'publisher',
            'operator',
            'viewer'
        ];

        // Looping untuk memasukkan semua role ke dalam database
        // firstOrCreate digunakan agar tidak error jika data sudah ada
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }
}