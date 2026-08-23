<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'role_id', 'name', 'username', 'email', 'no_hp', 'password', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function integration()
    {
        return $this->hasOne(UserIntegration::class);
    }

    public function isSuperadmin(): bool
    {
        return $this->role?->slug === 'superadmin';
    }

    public function hasMenuAccess(string $menuKey): bool
    {
        return $this->role?->hasMenu($menuKey) ?? false;
    }
}
