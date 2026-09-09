<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menghapus trigger lama jika sudah ada (mencegah error saat rollback/migrate ulang)
        DB::unprepared('DROP TRIGGER IF EXISTS after_detail_transaksi_insert');

        // Membuat Trigger Baru
        DB::unprepared('
            CREATE TRIGGER after_detail_transaksi_insert
            AFTER INSERT ON detail_transaksis
            FOR EACH ROW
            BEGIN
                DECLARE v_jenis_transaksi VARCHAR(50);
                DECLARE v_gudang_asal INT;
                DECLARE v_gudang_tujuan INT;

                -- 1. Ambil informasi jenis transaksi dan lokasi gudang dari tabel induk (transaksis)
                SELECT jenis_transaksi, gudang_asal_id, gudang_tujuan_id
                INTO v_jenis_transaksi, v_gudang_asal, v_gudang_tujuan
                FROM transaksis
                WHERE id = NEW.transaksi_id;

                -- 2. Logika jika transaksi = PEMASUKAN
                IF v_jenis_transaksi = "pemasukan" THEN
                    -- Cek apakah obat dengan batch tersebut sudah ada di gudang tujuan
                    IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                        -- Jika ada, tambahkan jumlahnya
                        UPDATE stok_obats
                        SET jumlah = jumlah + NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                    ELSE
                        -- Jika belum ada, buat baris stok baru
                        INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, jumlah, created_at, updated_at)
                        VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.jumlah, NOW(), NOW());
                    END IF;

                -- 3. Logika jika transaksi = PENGELUARAN
                ELSEIF v_jenis_transaksi = "pengeluaran" THEN
                    -- Kurangi stok dari gudang asal
                    UPDATE stok_obats
                    SET jumlah = jumlah - NEW.jumlah
                    WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;

                -- 4. Logika jika transaksi = PEMINDAHAN (Kombinasi kurang dan tambah)
                ELSEIF v_jenis_transaksi = "pemindahan" THEN
                    -- Kurangi stok dari gudang asal
                    UPDATE stok_obats
                    SET jumlah = jumlah - NEW.jumlah
                    WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;

                    -- Tambahkan stok ke gudang tujuan (cek dulu apakah sudah ada record-nya)
                    IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah + NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                    ELSE
                        INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, jumlah, created_at, updated_at)
                        VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.jumlah, NOW(), NOW());
                    END IF;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_detail_transaksi_insert');
    }
};