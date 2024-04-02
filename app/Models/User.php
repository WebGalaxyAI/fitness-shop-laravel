<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->canAccessAdminPanel();
    }

    public function scopeFilamentUsers(Builder $q): Builder
    {
        return $q->whereHas('roles', function (Builder $q) {
            $q->whereIn('name', ['super admin', 'admin', 'writer', 'manager']);
        });
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->hasRole(['super admin', 'admin', 'writer', 'manager']);
    }
}
