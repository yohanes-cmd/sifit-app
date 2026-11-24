<?php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Super Admin: pekanbarufarmasi@gmail.com
        $superAdmin = User::updateOrCreate(
            ['email' => 'pekanbarufarmasi@gmail.com'],
            [
                'name' => 'Pekanbaru Farmasi',
                'password' => Hash::make('pekanbaru123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        if (Role::where('name', 'super_admin')->exists()) {
            $superAdmin->syncRoles(['super_admin']);
        }

        // 2. Data Instansi OPD untuk Apotek 1
        $opdApotek = Opd::firstOrCreate(
            ['nama_opd' => 'Apotek 1'],
            [
                'status_kantor' => 'Aktif',
                'alamat' => 'Kota Pekanbaru',
            ]
        );

        // 3. Akun OPD: apotek1@gmail.com
        $userApotek = User::updateOrCreate(
            ['email' => 'apotek1@gmail.com'],
            [
                'name' => 'Apotek 1',
                'password' => Hash::make('123321'),
                'role' => 'opd',
                'opd' => $opdApotek->nama_opd,
                'opd_id' => $opdApotek->id,
                'email_verified_at' => now(),
            ]
        );

        if (Role::where('name', 'opd')->exists()) {
            $userApotek->syncRoles(['opd']);
        }
    }
}
