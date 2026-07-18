<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class MyDigitalIdProvision extends Page
{
    protected string $view = 'filament.pages.mydigital-id';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'MyDigital ID · Auto-Provision';
    protected static ?int $navigationSort = 11;
    protected static ?string $slug = 'mydigital-id';

    public function getTitle(): string { return 'MyDigital ID · Auto-Provision Akaun'; }
    public function getSubheading(): ?string { return 'Setiap MyKad baru auto-create akaun MyDigital ID · MAMPU MyGDX'; }

    public function getData(): array
    {
        return [
            'stats' => [
                'provisioned_today' => 4821,
                'total_active' => '21,847,392',
                'agencies_linked' => 74,
                'avg_provision_ms' => 1240,
            ],
            'log' => [
                ['ts' => '20:41:31', 'mykad' => 'MK-2026-987654', 'name' => 'Arjun a/l Subramaniam', 'action' => 'BIOMETRIC_UPDATE', 'status' => 'success'],
                ['ts' => '20:40:12', 'mykad' => 'MK-2026-987655', 'name' => 'Siti Aminah binti Hasan', 'action' => 'AUTO_PROVISION', 'status' => 'success'],
                ['ts' => '20:38:55', 'mykad' => 'MK-2026-987656', 'name' => 'Raj Kumar a/l Suresh', 'action' => 'AUTO_PROVISION', 'status' => 'success'],
                ['ts' => '20:37:22', 'mykad' => 'MK-2018-554321', 'name' => 'Arjun a/l Subramaniam', 'action' => 'CARD_REVOKED', 'status' => 'success'],
                ['ts' => '20:35:08', 'mykad' => 'MK-2026-987657', 'name' => 'John Tan Wei Ming', 'action' => 'AUTO_PROVISION', 'status' => 'success'],
                ['ts' => '20:33:41', 'mykad' => 'MK-2026-987658', 'name' => 'Faridah binti Salleh', 'action' => 'AUTO_PROVISION', 'status' => 'success'],
                ['ts' => '20:31:19', 'mykad' => 'MK-2026-987659', 'name' => 'Dr. Ahmad Hisham', 'action' => 'AUTO_PROVISION', 'status' => 'success'],
                ['ts' => '20:29:55', 'mykad' => 'MK-2026-987660', 'name' => 'Anand Singh', 'action' => 'AUTO_PROVISION', 'status' => 'pending'],
            ],
            'agencies' => [
                ['name' => 'LHDN e-Filing', 'users' => '14.2M', 'last_used' => '2 saat lalu'],
                ['name' => 'KWSP i-Akaun', 'users' => '15.8M', 'last_used' => '5 saat lalu'],
                ['name' => 'PERKESO PERKESO ASSIST', 'users' => '8.1M', 'last_used' => '12 saat lalu'],
                ['name' => 'JPJ MySIKAP', 'users' => '6.7M', 'last_used' => '8 saat lalu'],
                ['name' => 'JPA MyEPF', 'users' => '1.3M', 'last_used' => '1 minit lalu'],
                ['name' => 'KKM MySejahtera', 'users' => '22.4M', 'last_used' => '1 saat lalu'],
                ['name' => 'SPR myUndi', 'users' => '12.8M', 'last_used' => '4 minit lalu'],
                ['name' => 'KPM MySchool Portal', 'users' => '5.1M', 'last_used' => '3 minit lalu'],
            ],
        ];
    }
}
