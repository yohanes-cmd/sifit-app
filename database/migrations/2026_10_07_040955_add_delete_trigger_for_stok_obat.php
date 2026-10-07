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
        DB::unprepared('DROP TRIGGER IF EXISTS before_detail_transaksi_delete');

        DB::unprepared('
            CREATE TRIGGER before_detail_transaksi_delete
            BEFORE DELETE ON detail_transaksis
            FOR EACH ROW
            BEGIN
                DECLARE v_jenis_transaksi VARCHAR(50);
                DECLARE v_gudang_asal INT;
                DECLARE v_gudang_tujuan INT;

                -- Ambil informasi jenis transaksi dan lokasi gudang
                SELECT jenis_transaksi, gudang_asal_id, gudang_tujuan_id
                INTO v_jenis_transaksi, v_gudang_asal, v_gudang_tujuan
                FROM transaksis
                WHERE id = OLD.transaksi_id;

                -- Revert PEMASUKAN: kurangi stok di gudang tujuan
                IF v_jenis_transaksi = "pemasukan" THEN
                    UPDATE stok_obats
                    SET jumlah = jumlah - OLD.jumlah
                    WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_tujuan;

                -- Revert PENGELUARAN: kembalikan stok ke gudang asal
                ELSEIF v_jenis_transaksi = "pengeluaran" THEN
                    UPDATE stok_obats
                    SET jumlah = jumlah + OLD.jumlah
                    WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_asal;

                -- Revert PEMINDAHAN: kembalikan ke asal, kurangi dari tujuan
                ELSEIF v_jenis_transaksi = "pemindahan" THEN
                    UPDATE stok_obats
                    SET jumlah = jumlah + OLD.jumlah
                    WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_asal;

                    UPDATE stok_obats
                    SET jumlah = jumlah - OLD.jumlah
                    WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_tujuan;
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_detail_transaksi_delete');
    }
};
