<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Cek dulu, kalau kolomnya BELUM ada, baru ditambahkan
            if (!Schema::hasColumn('roles', 'akses_data')) {
                $table->string('akses_data')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Cek dulu, kalau kolomnya ADA, baru dihapus
            if (Schema::hasColumn('roles', 'akses_data')) {
                $table->dropColumn('akses_data');
            }
        });
    }
};