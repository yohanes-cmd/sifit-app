<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
        'content',
        'status', // draft / publish
        'image',
        'pdf_file',
        'published_at',
    ];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke User / Penulis
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}