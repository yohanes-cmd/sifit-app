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
        'opd_id',
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

    public function opdInstansi()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class, 'user_id');
    }

    /**
     * Check if user is the Super Admin (Admin Gudang Pusat).
     * Has full authority over central warehouse stock, supplier receipts, SBBK fulfillment, and system settings.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin')
            || in_array(strtolower((string) $this->role), ['super_admin', 'superadmin', 'administrator']);
    }

    /**
     * Check if user is an OPD Admin (Admin dari tiap-tiap OPD pemohon).
     * Responsible for submitting drug requests, monitoring status, and printing receipts for their OPD.
     */
    public function isAdminOpd(): bool
    {
        if ($this->isSuperAdmin()) {
            return false;
        }

        return $this->hasAnyRole(['admin', 'opd']) || ! empty($this->opd_id);
    }

    /**
     * Alias for isAdminOpd for consistency across permohonan views.
     */
    public function isOpd(): bool
    {
        return $this->isAdminOpd();
    }

    /**
     * Check if user has administrative privileges (either Super Admin or Admin OPD).
     */
    public function isAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminOpd();
    }

    /**
     * Check if user is an internal officer / staff (any role except viewer).
     */
    public function isStaff(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()->whereNotIn('name', ['viewer'])->exists();
    }
}
