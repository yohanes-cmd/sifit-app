<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $fillable = [
        'nama',
        'keterangan',
        'status',
    ];
}
