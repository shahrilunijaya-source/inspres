<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class AgensiIntegrasi extends Page
{
    protected string $view = 'filament.pages.agensi-integrasi';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Integrasi Agensi (13 + MyGDX)';
    protected static ?int $navigationSort = 5;
    protected static ?string $slug = 'agensi-integrasi';

    public function getTitle(): string { return 'Integrasi Agensi Luar · 13 Agensi + MyGDX (74 agensi)'; }
    public function getSubheading(): ?string { return 'API Gateway + OAuth 2.0 + mTLS · MAMPU MyGDX backbone'; }

    public function getAgencies(): array
    {
        return [
            ['code' => 'KKM', 'name' => 'Kementerian Kesihatan', 'usage' => 'Kelahiran hospital (pra-daftar)', 'status' => 'live', 'latency' => 142, 'today_calls' => 4821, 'success' => 99.94],
            ['code' => 'JIM', 'name' => 'Jabatan Imigresen Malaysia', 'usage' => 'Nombor paspot · MyPR', 'status' => 'live', 'latency' => 218, 'today_calls' => 1245, 'success' => 99.81],
            ['code' => 'JAKIM', 'name' => 'Jabatan Kemajuan Islam', 'usage' => 'Perkahwinan Islam · cross-ref', 'status' => 'live', 'latency' => 178, 'today_calls' => 892, 'success' => 99.92],
            ['code' => 'MAIS', 'name' => 'Majlis Agama Islam Sarawak', 'usage' => 'Bukan Islam · Sarawak', 'status' => 'live', 'latency' => 311, 'today_calls' => 87, 'success' => 99.50],
            ['code' => 'JKSM', 'name' => 'Jabatan Kehakiman Syariah', 'usage' => 'Perceraian Islam', 'status' => 'live', 'latency' => 254, 'today_calls' => 412, 'success' => 99.78],
            ['code' => 'MAHKAMAH', 'name' => 'Mahkamah Tinggi Malaysia', 'usage' => 'Perintah perceraian sivil', 'status' => 'live', 'latency' => 189, 'today_calls' => 156, 'success' => 99.85],
            ['code' => 'JAKOA', 'name' => 'Jab. Kemajuan Orang Asli', 'usage' => 'MyPOCA · komuniti', 'status' => 'live', 'latency' => 423, 'today_calls' => 34, 'success' => 98.94],
            ['code' => 'JKM', 'name' => 'Jab. Kebajikan Masyarakat', 'usage' => 'Laporan sosial · anak angkat', 'status' => 'live', 'latency' => 201, 'today_calls' => 287, 'success' => 99.62],
            ['code' => 'MAMPU', 'name' => 'MAMPU MyDigital ID', 'usage' => 'Auto-provision setiap MyKad', 'status' => 'live', 'latency' => 94, 'today_calls' => 6231, 'success' => 99.98],
            ['code' => 'KPM', 'name' => 'Kementerian Pendidikan', 'usage' => 'Persekolahan · rekod kelahiran', 'status' => 'live', 'latency' => 167, 'today_calls' => 2104, 'success' => 99.88],
            ['code' => 'LHDN', 'name' => 'Lembaga Hasil Dalam Negeri', 'usage' => 'Status cukai · perkahwinan', 'status' => 'live', 'latency' => 287, 'today_calls' => 1892, 'success' => 99.71],
            ['code' => 'KWSP', 'name' => 'Kumpulan Wang Simpanan', 'usage' => 'Penama · ahli waris', 'status' => 'live', 'latency' => 256, 'today_calls' => 743, 'success' => 99.83],
            ['code' => 'TBH', 'name' => 'Tabung Haji', 'usage' => 'Kelahiran Hedjaz (haji)', 'status' => 'live', 'latency' => 412, 'today_calls' => 18, 'success' => 98.50],
            ['code' => 'PDRM', 'name' => 'Polis Diraja Malaysia', 'usage' => 'Saman · senarai hitam', 'status' => 'live', 'latency' => 178, 'today_calls' => 3214, 'success' => 99.76],
            ['code' => 'SPR', 'name' => 'Suruhanjaya Pilihan Raya', 'usage' => 'Auto-daftar pengundi @ 18', 'status' => 'live', 'latency' => 234, 'today_calls' => 421, 'success' => 99.87],
            ['code' => 'KEMLU', 'name' => 'Kementerian Luar (MALAWAKIL)', 'usage' => 'Perkahwinan luar negara', 'status' => 'degraded', 'latency' => 782, 'today_calls' => 23, 'success' => 96.21],
            ['code' => 'PERKESO', 'name' => 'Pertubuhan Keselamatan Sosial', 'usage' => 'Caruman · ahli waris', 'status' => 'live', 'latency' => 245, 'today_calls' => 567, 'success' => 99.69],
        ];
    }
}
