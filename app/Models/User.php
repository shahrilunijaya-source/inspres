<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'nric', 'phone', 'branch_id', 'is_demo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_demo' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['officer', 'supervisor', 'admin'], true);
    }

    public function isPublic(): bool { return $this->role === 'public'; }
    public function isOfficer(): bool { return $this->role === 'officer'; }
    public function isSupervisor(): bool { return $this->role === 'supervisor'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'public' => 'Pengguna Awam',
            'officer' => 'Pegawai',
            'supervisor' => 'Penyelia',
            'admin' => 'Pentadbir',
            default => '—',
        };
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'applicant_user_id');
    }

    public function lifecycleEvents(): HasMany
    {
        return $this->hasMany(CitizenLifecycleEvent::class)->orderBy('order_index');
    }
}
