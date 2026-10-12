<?php

namespace App\Models;

// 1. Tambahkan baris use ini di bagian atas
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 2. Pasang HasRoles di sini!
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'phone',
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

    /**
     * Get avatar url or fallback to default.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/'.$this->avatar))) {
            return asset('storage/'.$this->avatar);
        }

        return asset('assets/images/users/avatar-1.jpg');
    }

    /**
     * Check if user has admin privileges.
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['admin', 'super_admin'])
            || in_array(strtolower((string) $this->role), ['admin', 'super_admin', 'administrator']);
    }

    /**
     * Check if user is an internal officer / staff (any role except viewer).
     */
    public function isStaff(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->roles()->whereNotIn('name', ['viewer'])->exists();
    }
}
