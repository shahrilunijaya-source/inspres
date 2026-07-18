<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class PerkakasanStatus extends Page
{
    protected string $view = 'filament.pages.perkakasan-status';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Perkakasan Kaunter (9)';
    protected static ?int $navigationSort = 12;
    protected static ?string $slug = 'perkakasan-status';

    public function getTitle(): string { return 'Perkakasan Kaunter · 9 Jenis APPENDIX C'; }
    public function getSubheading(): ?string { return 'Waranti 5 tahun · pemantauan real-time semua 21 cawangan JPN'; }

    public function getDevices(): array
    {
        return [
            ['name' => 'Pengimbas 10 Cap Jari', 'model' => 'Suprema RealScan-G10', 'std' => 'ISO/IEC 19794-2', 'units' => 247, 'online' => 241, 'icon' => '🫆'],
            ['name' => 'Kamera Muka + Iris', 'model' => 'Logitech Brio 500 + IriShield MK2120UL', 'std' => 'ISO/IEC 19794-5/6', 'units' => 247, 'online' => 245, 'icon' => '👁️'],
            ['name' => 'Pengimbas Cap Jari Tunggal', 'model' => 'Crossmatch DigitalPersona U.are.U 5300', 'std' => 'ISO/IEC 19794-2', 'units' => 412, 'online' => 408, 'icon' => '👆'],
            ['name' => 'PC Kaunter Dual Monitor', 'model' => 'Dell OptiPlex 7000 + 2 × 24" 1080p', 'std' => 'Windows 11 LTSC', 'units' => 247, 'online' => 246, 'icon' => '🖥️'],
            ['name' => 'Pencetak Kaunter (Sijil)', 'model' => 'HP LaserJet Enterprise M611dn', 'std' => 'A4 mono 65 ppm', 'units' => 247, 'online' => 240, 'icon' => '🖨️'],
            ['name' => 'Pembaca Kad MyKad (Cip)', 'model' => 'HID OMNIKEY 3121 USB', 'std' => 'PC/SC ISO 7816', 'units' => 412, 'online' => 411, 'icon' => '💳'],
            ['name' => 'Pembaca QR Code', 'model' => 'Honeywell Voyager 1450g 2D', 'std' => 'GS1 DataMatrix', 'units' => 412, 'online' => 410, 'icon' => '📱'],
            ['name' => 'Pencetak Kad MyKad', 'model' => 'Datacard CR805 Retransfer', 'std' => 'ICAO Doc 9303', 'units' => 47, 'online' => 45, 'icon' => '🆔'],
            ['name' => 'Pengimbas Dokumen', 'model' => 'Fujitsu fi-7160 ADF Duplex', 'std' => 'PDF/A archival', 'units' => 247, 'online' => 244, 'icon' => '📄'],
            ['name' => 'Terminal Pembayaran FPX/iGFMAS', 'model' => 'Verifone V200c', 'std' => 'PCI-DSS L1', 'units' => 247, 'online' => 247, 'icon' => '💰'],
            ['name' => 'Tablet Kaunter Bergerak', 'model' => 'Samsung Galaxy Tab Active5 Rugged', 'std' => 'IP68 · offline sync', 'units' => 84, 'online' => 79, 'icon' => '📱'],
        ];
    }

    public function getBranches(): array
    {
        return [
            ['name' => 'JPN Putrajaya HQ', 'kaunter' => 24, 'online' => 24, 'tone' => 'green'],
            ['name' => 'JPN Wangsa Maju KL', 'kaunter' => 18, 'online' => 18, 'tone' => 'green'],
            ['name' => 'JPN Shah Alam', 'kaunter' => 16, 'online' => 16, 'tone' => 'green'],
            ['name' => 'JPN Johor Bahru', 'kaunter' => 14, 'online' => 13, 'tone' => 'amber'],
            ['name' => 'JPN Pulau Pinang', 'kaunter' => 12, 'online' => 12, 'tone' => 'green'],
            ['name' => 'JPN Kota Kinabalu', 'kaunter' => 12, 'online' => 11, 'tone' => 'amber'],
            ['name' => 'JPN Kuching', 'kaunter' => 12, 'online' => 12, 'tone' => 'green'],
            ['name' => 'JPN Ipoh', 'kaunter' => 10, 'online' => 10, 'tone' => 'green'],
            ['name' => 'JPN Kuantan', 'kaunter' => 8, 'online' => 8, 'tone' => 'green'],
            ['name' => 'JPN Alor Setar', 'kaunter' => 8, 'online' => 7, 'tone' => 'amber'],
        ];
    }
}
