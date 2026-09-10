<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Matikan dan buang mesin trigger yang lama
        DB::unprepared('DROP TRIGGER IF EXISTS after_detail_transaksi_insert');

        // 2. Pasang mesin trigger baru yang sudah support Expired Date
        DB::unprepared('
            CREATE TRIGGER after_detail_transaksi_insert
            AFTER INSERT ON detail_transaksis
            FOR EACH ROW
            BEGIN
                DECLARE v_jenis_transaksi VARCHAR(50);
                DECLARE v_gudang_asal INT;
                DECLARE v_gudang_tujuan INT;

                -- Ambil informasi jenis transaksi dan lokasi gudang dari tabel induk
                SELECT jenis_transaksi, gudang_asal_id, gudang_tujuan_id
                INTO v_jenis_transaksi, v_gudang_asal, v_gudang_tujuan
                FROM transaksis
                WHERE id = NEW.transaksi_id;

                -- Logika PEMASUKAN
                IF v_jenis_transaksi = "pemasukan" THEN
                    IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah + NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                    ELSE
                        -- SUNTIKAN EXP_DATE DITAMBAHKAN DI SINI
                        INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, exp_date, jumlah, created_at, updated_at)
                        VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.exp_date, NEW.jumlah, NOW(), NOW());
                    END IF;

                -- Logika PENGELUARAN
                ELSEIF v_jenis_transaksi = "pengeluaran" THEN
                    UPDATE stok_obats
                    SET jumlah = jumlah - NEW.jumlah
                    WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;

                -- Logika PEMINDAHAN
                ELSEIF v_jenis_transaksi = "pemindahan" THEN
                    UPDATE stok_obats
                    SET jumlah = jumlah - NEW.jumlah
                    WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;

                    IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah + NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                    ELSE
                        -- SUNTIKAN EXP_DATE JUGA DITAMBAHKAN DI SINI
                        INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, exp_date, jumlah, created_at, updated_at)
                        VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.exp_date, NEW.jumlah, NOW(), NOW());
                    END IF;
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_detail_transaksi_insert');
    }
};