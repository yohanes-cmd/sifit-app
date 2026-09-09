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
      Schema::create('stok_obats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('master_obat_id')->constrained('master_obats')->onDelete('cascade');
    $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
    $table->string('no_batch');
    $table->date('expired_date')->nullable();
    $table->integer('jumlah')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_obats');
    }
};
