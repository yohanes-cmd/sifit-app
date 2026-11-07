<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        // 2. Bersihkan permission usang/tidak relevan dari sistem lama
        $obsoletePrefixes = ['metadata-', 'data-spasial-', 'jdih-', 'ogc-', 'tes-', 'kategori-berita-'];
        foreach ($obsoletePrefixes as $prefix) {
            Permission::where('name', 'like', "{$prefix}%")->delete();
        }

        // 3. Daftar Modul dan Aksi Standar SIFIT (Farmasi & Distribusi)
        $moduleActions = [
            'permohonan' => ['view', 'create', 'edit', 'delete', 'verify', 'print'],
            'pengeluaran' => ['view', 'create', 'delete', 'print'],
            'pemasukan' => ['view', 'create', 'delete', 'import', 'print'],
            'pemindahan' => ['view', 'create', 'delete', 'print'],
            'master-obat' => ['view', 'create', 'edit', 'delete', 'export'],
            'stok-obat' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'opd' => ['view', 'create', 'edit', 'delete', 'import'],
            'user' => ['view', 'create', 'edit', 'delete'],
            'role' => ['view', 'create', 'edit', 'delete'],
            'pengaturan' => ['view', 'manage'],
            'berita' => ['view', 'create', 'edit', 'delete'],
        ];

        $allPermissionNames = [];
        foreach ($moduleActions as $module => $actions) {
            foreach ($actions as $action) {
                $name = $module.'-'.$action;
                Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
                $allPermissionNames[] = $name;
            }
        }

        // Hapus permission lama yang tidak terdaftar dalam skema resmi SIFIT
        Permission::whereNotIn('name', $allPermissionNames)->delete();

        // 4. Pastikan Role Super Admin dan Admin (OPD) ada
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web'], ['akses_data' => 'Global']);
        $adminOpd = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'], ['akses_data' => 'OPD']);
        $roleOpd = Role::firstOrCreate(['name' => 'opd', 'guard_name' => 'web'], ['akses_data' => 'OPD']);

        // 5. Berikan Super Admin SEMUA permission
        $superAdmin->syncPermissions($allPermissionNames);

        // 6. Paket Permission Standar untuk Admin OPD
        $opdPermissionNames = [
            'permohonan-view',
            'permohonan-create',
            'permohonan-edit',
            'permohonan-delete',
            'permohonan-print',
            'pemasukan-view',
            'pemasukan-print',
            'pengeluaran-view',
            'pengeluaran-create',
            'pengeluaran-print',
            'pemindahan-view',
            'pemindahan-create',
            'pemindahan-print',
            'master-obat-view',
        ];

        $adminOpd->syncPermissions($opdPermissionNames);
        $roleOpd->syncPermissions($opdPermissionNames);

        // Reset cache kembali agar perubahan aktif seketika
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
