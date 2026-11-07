<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tanggal_permohonan' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function detailPermohonans()
    {
        return $this->hasMany(DetailPermohonan::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'permohonan_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Verifikasi',
            'disetujui' => 'Disetujui (Siap Dikeluarkan)',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai (Sudah SBBK)',
            'ditolak' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => '<span class="badge bg-warning text-dark"><i class="las la-clock me-1"></i> Menunggu Verifikasi</span>',
            'disetujui' => '<span class="badge bg-info text-white"><i class="las la-check me-1"></i> Disetujui (Acuan Barang)</span>',
            'diproses' => '<span class="badge bg-primary text-white"><i class="las la-spinner me-1"></i> Diproses</span>',
            'selesai' => '<span class="badge bg-success text-white"><i class="las la-check-circle me-1"></i> Selesai (SBBK)</span>',
            'ditolak' => '<span class="badge bg-danger text-white"><i class="las la-times-circle me-1"></i> Ditolak</span>',
            default => '<span class="badge bg-secondary">'.ucfirst((string) $this->status).'</span>',
        };
    }

    public function getTotalDimintaAttribute(): int
    {
        return (int) $this->detailPermohonans->sum('jumlah_diminta');
    }

    public function getTotalDisetujuiAttribute(): int
    {
        return (int) $this->detailPermohonans->sum(function ($item) {
            return $item->jumlah_disetujui ?? $item->jumlah_diminta;
        });
    }
}
