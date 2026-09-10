<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            // Menambahkan kolom baru
            $table->string('nama_opd')->after('id')->nullable();
            $table->string('status_kantor')->after('nama_opd')->nullable();
            $table->text('alamat')->after('status_kantor')->nullable();
            
            // Menghapus kolom 'name' yang lama agar rapi (jika sebelumnya ada)
            if (Schema::hasColumn('opds', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('opds', function (Blueprint $table) {
            $table->dropColumn(['nama_opd', 'status_kantor', 'alamat']);
            $table->string('name')->nullable();
        });
    }
};