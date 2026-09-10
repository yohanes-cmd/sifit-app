<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_obats', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('satuan');
            $table->text('deskripsi')->nullable()->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('master_obats', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'deskripsi']);
        });
    }
};