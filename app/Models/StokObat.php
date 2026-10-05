<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'exp_date' => 'date',
        'tgl_faktur' => 'date',
        'tgl_kontrak' => 'date',
        'harga_satuan' => 'decimal:2',
    ];

    public function masterObat()
    {
        return $this->belongsTo(MasterObat::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    /**
     * Get display kode obat/logistik
     */
    public function getDisplayKodeAttribute(): string
    {
        return $this->kode_obat_logistik ?: ($this->masterObat->kode_obat ?? '-');
    }

    /**
     * Get display nama obat/logistik
     */
    public function getDisplayNamaAttribute(): string
    {
        return $this->nama_obat_logistik ?: ($this->masterObat->nama_obat ?? '-');
    }

    /**
     * Get display kategori
     */
    public function getDisplayKategoriAttribute(): string
    {
        return $this->kategori ?: ($this->masterObat->kategori ?? 'APBN');
    }

    /**
     * Get display satuan
     */
    public function getDisplaySatuanAttribute(): string
    {
        return $this->satuan ?: ($this->masterObat->satuan ?? 'Pcs');
    }

    /**
     * Get display harga satuan
     */
    public function getDisplayHargaAttribute(): float
    {
        if ($this->harga_satuan && (float) $this->harga_satuan > 0) {
            return (float) $this->harga_satuan;
        }

        return (float) ($this->masterObat->harga ?? 0);
    }

    /**
     * Get total nilai (Harga Satuan * Jumlah)
     */
    public function getTotalNilaiAttribute(): float
    {
        return $this->display_harga * ($this->jumlah ?? 0);
    }
}
