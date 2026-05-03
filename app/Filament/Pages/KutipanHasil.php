<?php

namespace App\Filament\Pages;

use App\Models\Payment;
use BackedEnum;
use Filament\Pages\Page;

class KutipanHasil extends Page
{
    protected string $view = 'filament.pages.kutipan-hasil';

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return 'Kutipan Hasil';
    }

    public function getSubheading(): ?string
    {
        return 'Modul Separa — Bayaran asas sahaja diaktifkan dalam prototaip ini.';
    }

    public function getStats(): array
    {
        return [
            'total_collected' => Payment::where('status', 'paid')->sum('amount'),
            'today_count' => Payment::whereDate('paid_at', today())->count(),
            'today_amount' => Payment::whereDate('paid_at', today())->sum('amount'),
            'pending' => Payment::where('status', 'pending')->count(),
            'transactions' => Payment::with('application.applicant')->latest()->take(10)->get(),
        ];
    }
}
