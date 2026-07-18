<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class BiometricCapture extends Page
{
    protected string $view = 'filament.pages.biometric-capture';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Penangkapan Biometrik';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'biometric-capture';

    public function getTitle(): string { return 'Penangkapan Biometrik · 10 Cap Jari + Muka + Iris'; }
    public function getSubheading(): ?string { return 'Sesi aktif: Encik Arjun · MyKad Gantian · Kaunter 04 Putrajaya'; }
}
