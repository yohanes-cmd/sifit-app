<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'opd_id');
    }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class, 'opd_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'instansi_id');
    }
}
