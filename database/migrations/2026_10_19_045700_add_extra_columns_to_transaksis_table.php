<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id')->nullable()->after('gudang_tujuan_id');
            $table->unsignedBigInteger('pengangkut_id')->nullable()->after('program_id');
            $table->unsignedBigInteger('instansi_id')->nullable()->after('pengangkut_id');
            $table->string('pajak_invoice')->nullable()->after('instansi_id');
            $table->decimal('biaya_kirim', 15, 2)->default(0)->after('pajak_invoice');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'program_id',
                'pengangkut_id',
                'instansi_id',
                'pajak_invoice',
                'biaya_kirim',
            ]);
        });
    }
};
