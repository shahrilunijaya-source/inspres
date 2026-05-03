<?php

namespace App\Filament\Pages;

use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;

class PengurusanId extends Page
{
    protected string $view = 'filament.pages.pengurusan-id';

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return 'Pengurusan ID & IAM';
    }

    public function getSubheading(): ?string
    {
        return 'Modul Separa — Senarai akaun & peranan sahaja. Polisi penuh ACL akan datang.';
    }

    public function getUsers()
    {
        return User::with('branch')->orderBy('role')->orderBy('name')->get();
    }
}
