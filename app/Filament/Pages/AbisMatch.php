<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class AbisMatch extends Page
{
    protected string $view = 'filament.pages.abis-match';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'ABIS 1:N Biometrik';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'abis-match';

    public function getTitle(): string { return 'ABIS · 1:N Biometric Matching'; }
    public function getSubheading(): ?string { return 'Automated Biometric Identification System · 30M+ rekod · GPU NVIDIA H200'; }

    public function getStats(): array
    {
        return [
            'records' => '30,847,221',
            'last_match_ms' => 3187,
            'sla_ms' => 5000,
            'gpu' => 'NVIDIA H200 · 141GB HBM3e',
            'engine' => 'NEC NeoFace · v9.2',
            'today_matches' => 4821,
            'today_dupes' => 7,
            'recent' => [
                ['ts' => '2026-05-29 20:41:18', 'subj' => 'MyKad Gantian · Encik Arjun', 'score' => 99.94, 'time' => 3.18, 'result' => 'MATCH', 'tone' => 'green'],
                ['ts' => '2026-05-29 20:39:02', 'subj' => 'Kelahiran · Baby Adam', 'score' => 0.00, 'time' => 4.71, 'result' => 'NO MATCH', 'tone' => 'amber'],
                ['ts' => '2026-05-29 20:37:45', 'subj' => 'MyKad Kali Pertama · Siti Aminah', 'score' => 0.21, 'time' => 4.02, 'result' => 'NO MATCH', 'tone' => 'amber'],
                ['ts' => '2026-05-29 20:35:11', 'subj' => 'MyPR · Raj Kumar', 'score' => 98.71, 'time' => 3.54, 'result' => 'MATCH', 'tone' => 'green'],
                ['ts' => '2026-05-29 20:31:29', 'subj' => 'Siasatan Pendua · Case INV-2026-1129', 'score' => 99.99, 'time' => 2.89, 'result' => 'DUP FOUND', 'tone' => 'red'],
                ['ts' => '2026-05-29 20:29:00', 'subj' => 'MyKad Gantian · Faridah binti Hasan', 'score' => 99.88, 'time' => 3.61, 'result' => 'MATCH', 'tone' => 'green'],
            ],
        ];
    }
}
