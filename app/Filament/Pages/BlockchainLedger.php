<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class BlockchainLedger extends Page
{
    protected string $view = 'filament.pages.blockchain-ledger';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Hyperledger Fabric · Rekod Kekal';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'blockchain-ledger';

    public function getTitle(): string { return 'Hyperledger Fabric · Lejer Rekod Kekal'; }
    public function getSubheading(): ?string { return '4 peer + 3 orderer · Channel: inspres-main · Retention: 7 tahun (Akta Arkib 2003)'; }

    public function getData(): array
    {
        return [
            'total_blocks' => 1925012,
            'today_blocks' => 4821,
            'channels' => 3,
            'peers' => 4,
            'orderers' => 3,
            'avg_block_ms' => 612,
            'recent' => [
                ['block' => 1925012, 'hash' => '0xc5e7a1b9f2...', 'cc' => 'kahwin-cc', 'event' => 'PerkahwinanRegistered', 'subj' => 'PK-2026-009876', 'ts' => '2026-05-29 20:41:31'],
                ['block' => 1925011, 'hash' => '0xa3f9d8e7c4...', 'cc' => 'mykad-cc', 'event' => 'MyKadIssued', 'subj' => 'MK-2026-987654', 'ts' => '2026-05-29 20:40:58'],
                ['block' => 1925010, 'hash' => '0xb8d4e2f1a9...', 'cc' => 'mykad-cc', 'event' => 'CardRevoked', 'subj' => 'MK-2018-554321', 'ts' => '2026-05-29 20:40:58'],
                ['block' => 1925009, 'hash' => '0x7a3b9c2d8e...', 'cc' => 'kelahiran-cc', 'event' => 'BirthRegistered', 'subj' => 'KLH-2026-001234', 'ts' => '2026-05-29 20:39:22'],
                ['block' => 1925008, 'hash' => '0xd2e5f4a1c7...', 'cc' => 'kelahiran-cc', 'event' => 'BiometricVerified', 'subj' => 'KLH-2026-001234', 'ts' => '2026-05-29 20:39:18'],
                ['block' => 1925007, 'hash' => '0x9c8b7a6d5e...', 'cc' => 'kematian-cc', 'event' => 'DeathRegistered', 'subj' => 'KMT-2026-004412', 'ts' => '2026-05-29 20:38:51'],
                ['block' => 1925006, 'hash' => '0x4e3d2c1b0a...', 'cc' => 'audit-cc', 'event' => 'OfficerLogin', 'subj' => 'OFC-2031', 'ts' => '2026-05-29 20:38:11'],
                ['block' => 1925005, 'hash' => '0xf1e2d3c4b5...', 'cc' => 'kahwin-cc', 'event' => 'CaveatExpired', 'subj' => 'KAV-2026-002211', 'ts' => '2026-05-29 20:37:00'],
            ],
        ];
    }
}
