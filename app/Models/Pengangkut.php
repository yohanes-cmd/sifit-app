<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengangkut extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
        'jenis_kendaraan',
        'status',
    ];
}
