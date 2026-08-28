<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar Modul dan Aksi Standar
        $modules = [
            'opd', 'user', 'role', 'katalog', 'berita', 'kategori-berita', 
            'metadata', 'data-spasial', 'jdih', 'ogc', 'tes'
        ];

        $actions = [
            'view', 'create', 'edit', 'delete', 
            'submit', 'verify', 'validate', 'publish', 
            'unpublish', 'reject_verification', 'reject_validation', 'revise'
        ];

        // Generate permission otomatis (contoh: opd-view, user-create, dll)
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '-' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}