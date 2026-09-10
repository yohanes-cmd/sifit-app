<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_obats', function (Blueprint $table) {
            // Menambahkan fitur-fitur dari tabel lama
            $table->string('slug')->unique()->after('nama_obat')->nullable();
            $table->decimal('harga', 12, 2)->default(0)->after('satuan');
            $table->boolean('requires_prescription')->default(false)->after('deskripsi');
            $table->enum('status', ['published', 'draft', 'inactive'])->default('published')->after('requires_prescription');
        });
    }

    public function down(): void
    {
        Schema::table('master_obats', function (Blueprint $table) {
            $table->dropColumn(['slug', 'harga', 'requires_prescription', 'status']);
        });
    }
};