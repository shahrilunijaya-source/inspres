<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class HospitalPraDaftar extends Page
{
    protected string $view = 'filament.pages.hospital-pra-daftar';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Hospital KKM · Pra-Daftar Kelahiran';
    protected static ?int $navigationSort = 8;
    protected static ?string $slug = 'hospital-pra-daftar';

    public function getTitle(): string { return 'Pra-Pendaftaran Hospital · Integrasi KKM'; }
    public function getSubheading(): ?string { return '99% kelahiran di hospital KKM · pertukaran data klinikal automatik'; }

    public function getData(): array
    {
        return [
            'inbox' => [
                ['hosp' => 'HOSPITAL KUALA LUMPUR', 'mom' => 'Siti Aisyah binti Hisham', 'mom_nric' => '870519-14-3214', 'baby_sex' => 'L', 'baby_weight' => '3.2 kg', 'ts' => '2026-05-29 20:41', 'status' => 'baru', 'tone' => 'amber'],
                ['hosp' => 'HOSPITAL SELAYANG', 'mom' => 'Aminah binti Yusof', 'mom_nric' => '910822-10-2987', 'baby_sex' => 'P', 'baby_weight' => '2.9 kg', 'ts' => '2026-05-29 20:36', 'status' => 'baru', 'tone' => 'amber'],
                ['hosp' => 'HOSPITAL UMUM SARAWAK', 'mom' => 'Anita anak Joseph', 'mom_nric' => '880314-13-4561', 'baby_sex' => 'L', 'baby_weight' => '3.5 kg', 'ts' => '2026-05-29 20:24', 'status' => 'pemohon_tiba', 'tone' => 'green'],
                ['hosp' => 'HOSPITAL UMUM SABAH', 'mom' => 'Linda binti Mustafa', 'mom_nric' => '930211-12-3145', 'baby_sex' => 'P', 'baby_weight' => '2.7 kg', 'ts' => '2026-05-29 20:15', 'status' => 'baru', 'tone' => 'amber'],
                ['hosp' => 'HOSPITAL TUANKU JA\'AFAR SEREMBAN', 'mom' => 'Priya a/p Krishnan', 'mom_nric' => '900618-05-7821', 'baby_sex' => 'L', 'baby_weight' => '3.1 kg', 'ts' => '2026-05-29 20:02', 'status' => 'dalam_proses', 'tone' => 'amber'],
                ['hosp' => 'HOSPITAL SULTANAH AMINAH JB', 'mom' => 'Mei Ling binti Chong', 'mom_nric' => '920424-01-6531', 'baby_sex' => 'P', 'baby_weight' => '3.0 kg', 'ts' => '2026-05-29 19:48', 'status' => 'siap', 'tone' => 'green'],
                ['hosp' => 'HOSPITAL PUTRAJAYA', 'mom' => 'Faridah binti Ahmad', 'mom_nric' => '850907-14-2245', 'baby_sex' => 'L', 'baby_weight' => '3.4 kg', 'ts' => '2026-05-29 19:31', 'status' => 'siap', 'tone' => 'green'],
                ['hosp' => 'HOSPITAL PULAU PINANG', 'mom' => 'Sarah binti Razak', 'mom_nric' => '940515-07-3398', 'baby_sex' => 'P', 'baby_weight' => '2.8 kg', 'ts' => '2026-05-29 19:12', 'status' => 'siap', 'tone' => 'green'],
            ],
            'hospitals' => [
                ['name' => 'Hospital Kuala Lumpur', 'today' => 47, 'connected' => true],
                ['name' => 'Hospital Putrajaya', 'today' => 18, 'connected' => true],
                ['name' => 'Hospital Selayang', 'today' => 22, 'connected' => true],
                ['name' => 'Hospital Sungai Buloh', 'today' => 31, 'connected' => true],
                ['name' => 'Hospital Tuanku Ja\'afar', 'today' => 15, 'connected' => true],
                ['name' => 'Hospital Sultanah Aminah JB', 'today' => 28, 'connected' => true],
                ['name' => 'Hospital Pulau Pinang', 'today' => 19, 'connected' => true],
                ['name' => 'Hospital Umum Sarawak', 'today' => 14, 'connected' => true],
                ['name' => 'Hospital Umum Sabah', 'today' => 12, 'connected' => true],
                ['name' => 'Hospital Raja Permaisuri Bainun', 'today' => 17, 'connected' => true],
                ['name' => 'Hospital Tengku Ampuan Afzan', 'today' => 11, 'connected' => false],
            ],
        ];
    }
}
