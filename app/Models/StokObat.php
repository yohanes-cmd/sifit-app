<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function masterObat()
    {
        return $this->belongsTo(MasterObat::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}