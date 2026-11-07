<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan')->unique();
            $table->date('tanggal_permohonan');
            $table->foreignId('opd_id')->constrained('opds')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'disetujui', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->string('keperluan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('surat_pengantar')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->cascadeOnDelete();
            $table->foreignId('master_obat_id')->constrained('master_obats')->cascadeOnDelete();
            $table->integer('jumlah_diminta');
            $table->integer('jumlah_disetujui')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_permohonans');
        Schema::dropIfExists('permohonans');
    }
};
