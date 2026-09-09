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
        Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_surat');
    $table->date('tanggal');
    $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran', 'pemindahan']);
    $table->foreignId('gudang_asal_id')->nullable()->constrained('gudangs'); // Kosong jika pemasukan baru
    $table->foreignId('gudang_tujuan_id')->nullable()->constrained('gudangs'); // Kosong jika pengeluaran/musnah
    $table->foreignId('user_id')->constrained('users'); // Siapa yang input
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
