<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterObat extends Model
{
    use HasFactory;

    protected $guarded = []; // Mengizinkan semua kolom diisi (mass assignment)

    public function stokObats()
    {
        return $this->hasMany(StokObat::class);
    }
}