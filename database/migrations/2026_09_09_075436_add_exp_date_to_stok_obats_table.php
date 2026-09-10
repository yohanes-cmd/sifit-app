<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_obats', function (Blueprint $table) {
            // Menambahkan kolom exp_date setelah no_batch
            // Dibuat nullable() sementara agar data batch001 & batch002 yang sudah ada tidak bikin error saat di-migrate
            $table->date('exp_date')->nullable()->after('no_batch');
        });
    }

    public function down(): void
    {
        Schema::table('stok_obats', function (Blueprint $table) {
            $table->dropColumn('exp_date');
        });
    }
};