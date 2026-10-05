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
        Schema::table('stok_obats', function (Blueprint $table) {
            $table->string('kode_obat_logistik')->nullable()->after('master_obat_id');
            $table->string('nama_obat_logistik')->nullable()->after('kode_obat_logistik');
            $table->string('kategori')->nullable()->after('nama_obat_logistik');
            $table->string('sub_kategori')->nullable()->after('kategori');
            $table->string('tahun_penerimaan', 10)->nullable()->after('sub_kategori');
            $table->string('date_expired_kode')->nullable()->after('exp_date');
            $table->string('satuan', 50)->nullable()->after('date_expired_kode');
            $table->string('kemasan')->nullable()->after('satuan');
            $table->decimal('harga_satuan', 15, 2)->default(0)->after('kemasan');
            $table->string('nama_pabrikan')->nullable()->after('harga_satuan');
            $table->string('no_faktur')->nullable()->after('nama_pabrikan');
            $table->date('tgl_faktur')->nullable()->after('no_faktur');
            $table->string('no_kontrak')->nullable()->after('tgl_faktur');
            $table->date('tgl_kontrak')->nullable()->after('no_kontrak');
            $table->integer('peringatan_jumlah')->default(10)->after('tgl_kontrak');
            $table->string('gambar')->nullable()->after('peringatan_jumlah');
            $table->longText('informasi_lengkap')->nullable()->after('gambar');
            $table->text('keterangan')->nullable()->after('informasi_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_obats', function (Blueprint $table) {
            $table->dropColumn([
                'kode_obat_logistik',
                'nama_obat_logistik',
                'kategori',
                'sub_kategori',
                'tahun_penerimaan',
                'date_expired_kode',
                'satuan',
                'kemasan',
                'harga_satuan',
                'nama_pabrikan',
                'no_faktur',
                'tgl_faktur',
                'no_kontrak',
                'tgl_kontrak',
                'peringatan_jumlah',
                'gambar',
                'informasi_lengkap',
                'keterangan',
            ]);
        });
    }
};
