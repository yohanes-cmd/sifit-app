<?php

namespace App\Models;

// 1. Tambahkan baris use ini di bagian atas
use Spatie\Permission\Traits\HasRoles; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    // 2. Pasang HasRoles di sini!
    use HasRoles; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'opd',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}

