<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_asal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_tujuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function pengangkut()
    {
        return $this->belongsTo(Pengangkut::class, 'pengangkut_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Opd::class, 'instansi_id');
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    public function getSubtotalItemsAttribute(): float
    {
        return (float) $this->detailTransaksis->sum(function ($item) {
            return (float) ($item->jumlah * ($item->harga_satuan ?? 0));
        });
    }

    public function getPajakNominalAttribute(): float
    {
        $subtotal = $this->subtotal_items;
        $pajakType = strtoupper($this->pajak_invoice ?? '');

        if ($pajakType === 'VAT') {
            return $subtotal * 0.11;
        } elseif ($pajakType === 'GST') {
            return $subtotal * 0.10;
        }

        return 0;
    }

    public function getGrandTotalAttribute(): float
    {
        return $this->subtotal_items + $this->pajak_nominal + (float) ($this->biaya_kirim ?? 0);
    }
}
