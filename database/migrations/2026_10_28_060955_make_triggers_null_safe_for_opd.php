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
        // 1. Update after_detail_transaksi_insert agar aman jika gudang_asal atau gudang_tujuan bernilai NULL (transaksi tingkat OPD)
        DB::unprepared('DROP TRIGGER IF EXISTS after_detail_transaksi_insert');
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
                    IF v_gudang_tujuan IS NOT NULL THEN
                        IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                            UPDATE stok_obats
                            SET jumlah = jumlah + NEW.jumlah
                            WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                        ELSE
                            INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, exp_date, jumlah, created_at, updated_at)
                            VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.exp_date, NEW.jumlah, NOW(), NOW());
                        END IF;
                    END IF;

                -- Logika PENGELUARAN
                ELSEIF v_jenis_transaksi = "pengeluaran" THEN
                    IF v_gudang_asal IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah - NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;
                    END IF;

                -- Logika PEMINDAHAN
                ELSEIF v_jenis_transaksi = "pemindahan" THEN
                    IF v_gudang_asal IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah - NEW.jumlah
                        WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_asal;
                    END IF;

                    IF v_gudang_tujuan IS NOT NULL THEN
                        IF EXISTS (SELECT 1 FROM stok_obats WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan) THEN
                            UPDATE stok_obats
                            SET jumlah = jumlah + NEW.jumlah
                            WHERE master_obat_id = NEW.master_obat_id AND no_batch = NEW.no_batch AND gudang_id = v_gudang_tujuan;
                        ELSE
                            INSERT INTO stok_obats (master_obat_id, gudang_id, no_batch, exp_date, jumlah, created_at, updated_at)
                            VALUES (NEW.master_obat_id, v_gudang_tujuan, NEW.no_batch, NEW.exp_date, NEW.jumlah, NOW(), NOW());
                        END IF;
                    END IF;
                END IF;
            END
        ');

        // 2. Update before_detail_transaksi_delete agar aman saat penghapusan transaksi tingkat OPD
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
                    IF v_gudang_tujuan IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah - OLD.jumlah
                        WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_tujuan;
                    END IF;

                -- Revert PENGELUARAN: kembalikan stok ke gudang asal
                ELSEIF v_jenis_transaksi = "pengeluaran" THEN
                    IF v_gudang_asal IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah + OLD.jumlah
                        WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_asal;
                    END IF;

                -- Revert PEMINDAHAN: kembalikan ke asal, kurangi dari tujuan
                ELSEIF v_jenis_transaksi = "pemindahan" THEN
                    IF v_gudang_asal IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah + OLD.jumlah
                        WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_asal;
                    END IF;

                    IF v_gudang_tujuan IS NOT NULL THEN
                        UPDATE stok_obats
                        SET jumlah = jumlah - OLD.jumlah
                        WHERE master_obat_id = OLD.master_obat_id AND no_batch = OLD.no_batch AND gudang_id = v_gudang_tujuan;
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
        // Revert triggers to previous state if needed
    }
};
