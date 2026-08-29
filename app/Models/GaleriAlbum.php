<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriAlbum extends Model
{
    use HasFactory;

    protected $table = 'galeri_album';
    protected $primaryKey = 'id_album';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'judul',
        'tipe_media',
        'media_url',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}