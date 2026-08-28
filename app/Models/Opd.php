<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    // Mengizinkan kolom 'name' diisi secara massal (mass assignment)
   protected $fillable = ['name'];
}