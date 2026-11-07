<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterObat extends Model
{
    use HasFactory;

    protected $guarded = []; // Mengizinkan semua kolom diisi (mass assignment)

    protected static function booted(): void
    {
        static::saving(function (MasterObat $masterObat) {
            if (empty($masterObat->slug)) {
                $base = ! empty($masterObat->nama_obat) ? Str::slug($masterObat->nama_obat) : 'obat';
                $masterObat->slug = $base.'-'.time();
            }
        });
    }

    public function stokObats()
    {
        return $this->hasMany(StokObat::class);
    }

    /**
     * Hitung total stok dari seluruh relasi stok obat di gudang.
     */
    public function getTotalStokAttribute(): int
    {
        if (array_key_exists('total_stok', $this->attributes)) {
            return (int) $this->attributes['total_stok'];
        }

        return (int) $this->stokObats()->sum('jumlah');
    }

    /**
     * Resolusi URL gambar produk atau fallback ke default SVG.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (! empty($this->gambar)) {
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
            if (file_exists(public_path('storage/'.$this->gambar))) {
                return asset('storage/'.$this->gambar);
            }
        }

        return asset('assets/images/product-default.svg');
    }

    /**
     * Slug dengan fallback otomatis jika belum ada di database.
     */
    public function getSlugAttribute(?string $value): string
    {
        if (! empty($value)) {
            return $value;
        }

        $base = ! empty($this->nama_obat) ? Str::slug($this->nama_obat) : 'obat';

        return $base.'-'.$this->id;
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'name'.
     */
    public function getNameAttribute(): string
    {
        return $this->nama_obat ?? '';
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'price'.
     */
    public function getPriceAttribute(): float
    {
        return (float) ($this->harga ?? 0);
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'unit'.
     */
    public function getUnitAttribute(): string
    {
        return $this->satuan ?? 'Pcs';
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'description'.
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->deskripsi;
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'image'.
     */
    public function getImageAttribute(): ?string
    {
        return $this->gambar;
    }

    /**
     * Kompatibilitas untuk frontend yang memanggil properti 'stock'.
     */
    public function getStockAttribute(): int
    {
        return $this->total_stok;
    }

    /**
     * Kompatibilitas untuk frontend yang mengakses relasi category->name.
     */
    public function getCategoryAttribute(): object
    {
        return (object) [
            'id' => $this->kategori ?? 'Obat',
            'name' => $this->kategori ?? 'Obat',
        ];
    }

    /**
     * Golongan obat dinamis untuk kebutuhan tampilan regulasi farmasi.
     */
    public function getGolonganObatAttribute(): string
    {
        if ($this->kategori === 'Logistik') {
            return 'Logistik Medis';
        }

        return $this->requires_prescription ? 'Obat Keras' : 'Obat Bebas';
    }

    /**
     * Accessor untuk batch_obat (alias dari kode_kemkes untuk kategori Obat).
     */
    public function getBatchObatAttribute(): ?string
    {
        return $this->kode_kemkes;
    }

    /**
     * Mutator untuk batch_obat.
     */
    public function setBatchObatAttribute(?string $value): void
    {
        $this->attributes['kode_kemkes'] = $value;
    }

    /**
     * Label dinamis berdasarkan kategori: Batch Obat (untuk Obat) atau Kode Kemkes (untuk Logistik).
     */
    public function getLabelBatchOrKemkesAttribute(): string
    {
        return $this->kategori === 'Logistik' ? 'Kode Kemkes' : 'Batch Obat';
    }

    /**
     * Teks identifikasi dinamis dengan prefix (Batch: ... atau Kemkes: ...).
     */
    public function getFormattedBatchOrKemkesAttribute(): string
    {
        if (empty($this->kode_kemkes)) {
            return '-';
        }

        return ($this->kategori === 'Logistik' ? 'Kemkes: ' : 'Batch: ').$this->kode_kemkes;
    }
}
