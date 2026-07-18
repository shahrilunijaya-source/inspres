<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class FamilyTree extends Page
{
    protected string $view = 'filament.pages.family-tree';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Salasilah Keluarga (Family Tree)';
    protected static ?int $navigationSort = 10;
    protected static ?string $slug = 'family-tree';

    public function getTitle(): string { return 'Salasilah Keluarga · Family Tree Service'; }
    public function getSubheading(): ?string { return 'Auto-update dari Modul Kelahiran, Modul Perkahwinan, Modul Kematian, Modul Anak Angkat'; }

    public function getData(): array
    {
        return [
            'subject' => 'Ahmad bin Hisham · 870519-14-3214',
            'stats' => [
                'records' => '32,841,287',
                'relationships' => '187,212,438',
                'queries_today' => 18421,
                'avg_traverse_ms' => 67,
            ],
            'usage' => [
                ['Modul Perkahwinan · Hubungan Darah','Cek adik beradik / sedarah sebelum kaveat'],
                ['Modul Pencen · Ahli Waris','Auto-link suami isteri + anak'],
                ['Modul KWSP · Penama','Validate hubungan saudara'],
                ['Modul Tabung Pendidikan · Anak Tanggungan','Auto-eligibility'],
                ['Modul Warisan · Probate','Bukti hubungan untuk geran'],
                ['Modul Siasatan · Identity Theft','Cek silang keluarga'],
            ],
        ];
    }
}
