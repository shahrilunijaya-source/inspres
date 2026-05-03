<?php

namespace App\Filament\Auth;

use App\Models\User;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class OfficerLogin extends BaseLogin
{
    protected string $view = 'filament.auth.officer-login';

    protected static string $layout = 'filament.auth.officer-login-layout';

    public function getTitle(): string|Htmlable
    {
        return 'Log Masuk Pegawai — INPReS';
    }

    public function getHeading(): string|Htmlable|null
    {
        return 'Log Masuk Pegawai';
    }

    public function getDemoUsers()
    {
        return User::where('is_demo', true)
            ->whereIn('role', ['officer', 'supervisor', 'admin'])
            ->orderByRaw("FIELD(role, 'admin','supervisor','officer')")
            ->get(['name', 'email', 'role']);
    }
}
