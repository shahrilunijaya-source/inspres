<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class KafkaEvents extends Page
{
    protected string $view = 'filament.pages.kafka-events';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Kafka Event Bus';
    protected static ?int $navigationSort = 7;
    protected static ?string $slug = 'kafka-events';

    public function getTitle(): string { return 'Apache Kafka · Event Bus Antara Modul'; }
    public function getSubheading(): ?string { return '3 broker · 6 topic utama · Avro schema registry · publish 4.8k msg/saat'; }

    public function getData(): array
    {
        return [
            'topics' => [
                ['name' => 'event.kelahiran.registered', 'partitions' => 6, 'consumers' => 7, 'lag' => 0, 'rate' => 87, 'retention' => '7 hari'],
                ['name' => 'event.mykad.issued', 'partitions' => 8, 'consumers' => 9, 'lag' => 0, 'rate' => 124, 'retention' => '7 hari'],
                ['name' => 'event.mykad.revoked', 'partitions' => 4, 'consumers' => 6, 'lag' => 0, 'rate' => 12, 'retention' => '7 hari'],
                ['name' => 'event.kahwin.registered', 'partitions' => 4, 'consumers' => 6, 'lag' => 2, 'rate' => 41, 'retention' => '7 hari'],
                ['name' => 'event.kahwin.caveat_lodged', 'partitions' => 4, 'consumers' => 3, 'lag' => 0, 'rate' => 21, 'retention' => '30 hari'],
                ['name' => 'event.kematian.registered', 'partitions' => 4, 'consumers' => 8, 'lag' => 0, 'rate' => 56, 'retention' => '7 hari'],
                ['name' => 'event.warganegara.naturalised', 'partitions' => 2, 'consumers' => 5, 'lag' => 0, 'rate' => 3, 'retention' => '30 hari'],
                ['name' => 'event.audit.officer_action', 'partitions' => 12, 'consumers' => 2, 'lag' => 12, 'rate' => 412, 'retention' => '90 hari'],
            ],
            'stream' => [
                ['ts' => '20:41:32.187', 'topic' => 'event.kahwin.registered', 'key' => 'PK-2026-009876', 'payload' => '{"ref":"PK-2026-009876","groom":"Ahmad","bride":"Faridah",...}'],
                ['ts' => '20:41:31.943', 'topic' => 'event.mykad.issued', 'key' => 'MK-2026-987654', 'payload' => '{"serial":"MK-2026-987654","type":"replacement",...}'],
                ['ts' => '20:41:30.011', 'topic' => 'event.mykad.revoked', 'key' => 'MK-2018-554321', 'payload' => '{"serial":"MK-2018-554321","reason":"rosak_cip",...}'],
                ['ts' => '20:41:28.612', 'topic' => 'event.audit.officer_action', 'key' => 'OFC-2031', 'payload' => '{"officer":"OFC-2031","action":"approve_mykad",...}'],
                ['ts' => '20:41:27.421', 'topic' => 'event.kelahiran.registered', 'key' => 'KLH-2026-001234', 'payload' => '{"ref":"KLH-2026-001234","baby":"Adam","mother":"Siti",...}'],
                ['ts' => '20:41:25.890', 'topic' => 'event.kematian.registered', 'key' => 'KMT-2026-004412', 'payload' => '{"ref":"KMT-2026-004412","deceased":"Tan Ah Kow",...}'],
            ],
            'consumers' => [
                ['group' => 'mykid-auto-provisioner', 'topic' => 'event.kelahiran.registered', 'lag' => 0],
                ['group' => 'mydigital-id-sync', 'topic' => 'event.mykad.issued', 'lag' => 0],
                ['group' => 'kwsp-nominee-sync', 'topic' => 'event.kahwin.registered', 'lag' => 2],
                ['group' => 'spr-voter-roll', 'topic' => 'event.mykad.issued', 'lag' => 0],
                ['group' => 'pdrm-blacklist', 'topic' => 'event.kematian.registered', 'lag' => 0],
                ['group' => 'family-tree-updater', 'topic' => 'event.kahwin.registered', 'lag' => 0],
                ['group' => 'hl-fabric-publisher', 'topic' => 'event.audit.officer_action', 'lag' => 12],
                ['group' => 'lhdn-tax-status', 'topic' => 'event.kahwin.registered', 'lag' => 0],
            ],
        ];
    }
}
