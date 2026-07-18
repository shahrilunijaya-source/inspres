<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class ClmsPipeline extends Page
{
    protected string $view = 'filament.pages.clms-pipeline';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'CLMS · Kitar Hayat Kad';
    protected static ?int $navigationSort = 9;
    protected static ?string $slug = 'clms-pipeline';

    public function getTitle(): string { return 'CLMS · Card Lifecycle Management System'; }
    public function getSubheading(): ?string { return 'Stok kad kosong · personalisation · key injection · retirement · ICAO Doc 9303'; }

    public function getData(): array
    {
        return [
            'stages' => [
                ['stage' => 'Stok Kosong', 'count' => 84218, 'desc' => 'Kad polikarbonat unprogrammed', 'tone' => 'slate'],
                ['stage' => 'Antrian Cetakan', 'count' => 421, 'desc' => 'Menunggu personalization', 'tone' => 'amber'],
                ['stage' => 'Personalization', 'count' => 12, 'desc' => 'Laser engrave + cip program', 'tone' => 'amber'],
                ['stage' => 'Key Injection', 'count' => 8, 'desc' => 'PKI cryptographic keypair', 'tone' => 'amber'],
                ['stage' => 'Quality Control', 'count' => 4, 'desc' => 'Visual + cip read test', 'tone' => 'amber'],
                ['stage' => 'Sedia Serahan', 'count' => 287, 'desc' => 'Menunggu pemohon datang', 'tone' => 'green'],
                ['stage' => 'Diserah', 'count' => 4821, 'desc' => 'Bulan ini', 'tone' => 'green'],
            ],
            'queue' => [
                ['serial' => 'MK-2026-987654', 'name' => 'Arjun a/l Subramaniam', 'type' => 'Gantian Rosak', 'stage' => 'Cetakan', 'eta' => '12 min', 'priority' => 'normal'],
                ['serial' => 'MK-2026-987655', 'name' => 'Siti Aminah binti Hasan', 'type' => 'Kali Pertama 12T', 'stage' => 'Key Injection', 'eta' => '5 min', 'priority' => 'normal'],
                ['serial' => 'MK-2026-987656', 'name' => 'Raj Kumar a/l Suresh', 'type' => 'MyPR', 'stage' => 'QC', 'eta' => '3 min', 'priority' => 'high'],
                ['serial' => 'MK-2026-987657', 'name' => 'John Tan Wei Ming', 'type' => 'Penukaran Nama', 'stage' => 'Personalisation', 'eta' => '8 min', 'priority' => 'normal'],
                ['serial' => 'MK-2026-987658', 'name' => 'Faridah binti Salleh', 'type' => 'Gantian Hilang', 'stage' => 'Cetakan', 'eta' => '14 min', 'priority' => 'normal'],
                ['serial' => 'MK-2026-987659', 'name' => 'Dr. Ahmad Hisham', 'type' => 'Kad Khas Diplomat', 'stage' => 'Cetakan', 'eta' => '10 min', 'priority' => 'urgent'],
                ['serial' => 'MK-2026-987660', 'name' => 'Anand Singh', 'type' => 'Naturalisation', 'stage' => 'Cetakan', 'eta' => '15 min', 'priority' => 'normal'],
            ],
            'printers' => [
                ['id' => 'PRT-PJ-01', 'model' => 'Datacard CR805 Retransfer', 'queue' => 42, 'stock' => 8200, 'status' => 'printing'],
                ['id' => 'PRT-PJ-02', 'model' => 'Datacard CR805 Retransfer', 'queue' => 38, 'stock' => 7150, 'status' => 'printing'],
                ['id' => 'PRT-PJ-03', 'model' => 'Matica XID8600', 'queue' => 0, 'stock' => 9000, 'status' => 'idle'],
                ['id' => 'PRT-SBH-01', 'model' => 'Datacard CR805', 'queue' => 22, 'stock' => 4200, 'status' => 'printing'],
                ['id' => 'PRT-SWK-01', 'model' => 'Matica XID8600', 'queue' => 18, 'stock' => 3800, 'status' => 'printing'],
            ],
        ];
    }
}
