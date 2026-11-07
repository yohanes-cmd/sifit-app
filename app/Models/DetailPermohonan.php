<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPermohonan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function masterObat()
    {
        return $this->belongsTo(MasterObat::class, 'master_obat_id');
    }
}
