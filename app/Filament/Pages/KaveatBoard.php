<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class KaveatBoard extends Page
{
    protected string $view = 'filament.pages.kaveat-board';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Kaveat 21 Hari · Perkahwinan';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'kaveat-board';

    public function getTitle(): string { return 'Pengurusan Kaveat 21 Hari · Modul Perkahwinan Sivil'; }
    public function getSubheading(): ?string { return 'Akta 164 Seksyen 22 · Pengiklanan rasmi sebelum upacara perkahwinan'; }

    public function getCouples(): array
    {
        return [
            ['ref' => 'KAV-2026-002214', 'groom' => 'Ahmad bin Hisham', 'bride' => 'Faridah binti Salleh', 'lodged' => '2026-05-12', 'expires' => '2026-06-02', 'days_left' => 4, 'objections' => 0, 'tone' => 'amber'],
            ['ref' => 'KAV-2026-002215', 'groom' => 'Raj Kumar a/l Suresh', 'bride' => 'Priya a/p Krishnan', 'lodged' => '2026-05-15', 'expires' => '2026-06-05', 'days_left' => 7, 'objections' => 0, 'tone' => 'amber'],
            ['ref' => 'KAV-2026-002216', 'groom' => 'John Tan Wei Ming', 'bride' => 'Sarah Lim Hui Yen', 'lodged' => '2026-05-20', 'expires' => '2026-06-10', 'days_left' => 12, 'objections' => 0, 'tone' => 'green'],
            ['ref' => 'KAV-2026-002217', 'groom' => 'Anand Singh', 'bride' => 'Mei Ling Chen', 'lodged' => '2026-05-22', 'expires' => '2026-06-12', 'days_left' => 14, 'objections' => 1, 'tone' => 'red'],
            ['ref' => 'KAV-2026-002218', 'groom' => 'David Lee Chee Keong', 'bride' => 'Angela Wong Mei Fen', 'lodged' => '2026-05-25', 'expires' => '2026-06-15', 'days_left' => 17, 'objections' => 0, 'tone' => 'green'],
            ['ref' => 'KAV-2026-002219', 'groom' => 'Vinod a/l Ramasamy', 'bride' => 'Devi a/p Murthy', 'lodged' => '2026-05-27', 'expires' => '2026-06-17', 'days_left' => 19, 'objections' => 0, 'tone' => 'green'],
            ['ref' => 'KAV-2026-002211', 'groom' => 'Michael Tan Boon Hwa', 'bride' => 'Stephanie Ng Lai Peng', 'lodged' => '2026-05-08', 'expires' => '2026-05-29', 'days_left' => 0, 'objections' => 0, 'tone' => 'red', 'status' => 'tamat'],
        ];
    }
}
