<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class SubFungsiKatalog extends Page
{
    protected string $view = 'filament.pages.sub-fungsi-katalog';
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static string|\UnitEnum|null $navigationGroup = 'Sistem Wajib (LAMPIRAN A)';
    protected static ?string $navigationLabel = 'Katalog Sub-Fungsi (63)';
    protected static ?int $navigationSort = 6;
    protected static ?string $slug = 'sub-fungsi-katalog';

    public function getTitle(): string { return 'Katalog Sub-Fungsi · 63 Fungsi LAMPIRAN A'; }
    public function getSubheading(): ?string { return 'Modul 01 Kelahiran (22) + Modul 04 Kad Pengenalan (22) + Modul 05 Perkahwinan (19)'; }

    public function getModules(): array
    {
        return [
            'Modul 01 · Kelahiran' => [
                'akta' => 'Akta 299 · Ordinan SM/SSL',
                'sections' => [
                    'Pendaftaran (7)' => [
                        ['Pra-Pendaftaran Hospital', 'active', 'Integrasi KKM real-time'],
                        ['Pendaftaran Biasa', 'active', '60 hari SM / 14 hari SSL'],
                        ['Pendaftaran Lambat', 'partial', 'Hari 15-42 SSL sahaja'],
                        ['Pendaftaran Lewat', 'partial', '>60 hari SM / >42 hari SSL'],
                        ['Kelahiran Mati (Stillbirth)', 'partial', 'Minggu ke-28 ke atas'],
                        ['Kelahiran di Hedjaz', 'scope', 'Akta 152 S.4(1) · TBH'],
                        ['Atas Kapal · Semula · Pembetulan', 'scope', 'Akta 299 S.27(3) · Panel'],
                    ],
                    'Sijil + MyKid (8)' => [
                        ['Cabutan Daftar Kelahiran', 'active', 'Salinan sah'],
                        ['Carian Daftar Kelahiran', 'active', 'Bayaran semakan RM5'],
                        ['Cetakan Semula Sijil', 'active', 'JPN.LM05 / Borang XII'],
                        ['Paparan Sijil Digital', 'active', 'QR verification awam'],
                        ['MyKid Kali Pertama', 'active', 'Selepas daftar kelahiran'],
                        ['Gantian MyKid', 'partial', 'Rosak / hilang'],
                        ['Pertanyaan Cip · Pembatalan · Pelupusan', 'scope', 'Lifecycle CLMS'],
                        ['Salasilah Keluarga (Family Tree)', 'active', 'Auto-update hubungan'],
                    ],
                    'Pengurusan Rekod · KRITIKAL (7)' => [
                        ['Pewujudan Rekod (Blockchain)', 'active', 'HL Fabric immutable'],
                        ['Pengesahan Rekod', 'active', 'Crypto signature'],
                        ['Pembatalan Rekod', 'active', 'Audit trail penuh'],
                        ['Pelupusan Rekod', 'partial', 'Akta Arkib 2003'],
                        ['Pengesahan Digital', 'active', 'QR code verification'],
                        ['Carian Sejarah', 'active', 'Full-text + biometric'],
                        ['Log Transaksi Immutable', 'active', 'Akta Keterangan S.90A'],
                    ],
                ],
            ],
            'Modul 04 · Kad Pengenalan' => [
                'akta' => 'Akta 78 (Pendaftaran Negara 1959)',
                'sections' => [
                    'Permohonan Kali Pertama (8)' => [
                        ['MyKad (12 Tahun)', 'active', 'Biometrik wajib · ABIS 1:N'],
                        ['MyPR', 'active', 'Penduduk Tetap'],
                        ['MyKAS', 'partial', 'Warganegara Sementara'],
                        ['MyPOCA', 'partial', 'Orang Asli · JAKOA'],
                        ['Daftar Lewat', 'partial', '> 12 tahun · soal siasat'],
                        ['Orang Baru Tiba', 'scope', 'Baru naturalisasi'],
                        ['Kaunter Bergerak', 'scope', 'Offline mode · pelosok'],
                        ['Kad Khas', 'scope', 'VVIP · diplomat'],
                    ],
                    'Operasi Kad (9)' => [
                        ['Penukaran Kad', 'active', 'Tukar status / tukar nama'],
                        ['Gantian Kad', 'active', 'Hilang / rosak'],
                        ['Pengeluaran Kad', 'active', 'CLMS personalization'],
                        ['Serahan Kad', 'active', 'Verifikasi biometrik'],
                        ['Cetakan Resit', 'active', 'Untuk pemohon'],
                        ['Pembatalan Permohonan', 'partial', 'Sebelum kad keluar'],
                        ['Pelupusan Kad', 'scope', 'Selepas kematian'],
                        ['Pemulangan ke JPN', 'scope', 'Bila diminta semula'],
                        ['Penjadualan Cetakan', 'partial', 'CLMS queue'],
                    ],
                    'VV + ABIS · KRITIKAL (5)' => [
                        ['Verifikasi + Validasi (VV)', 'active', 'Semakan permohonan'],
                        ['ABIS 1:N Matching', 'active', '30M+ rekod · GPU H200'],
                        ['Pewujudan Rekod', 'active', 'HL Fabric'],
                        ['Pengesahan Rekod', 'active', 'Crypto signature'],
                        ['Pembetulan + Panel Khas', 'partial', 'Jawatankuasa Pertimbangan'],
                    ],
                ],
            ],
            'Modul 05 · Perkahwinan & Perceraian Sivil' => [
                'akta' => 'Akta 164 (1976)',
                'sections' => [
                    'Pendaftaran Utama (7)' => [
                        ['Pendaftaran Perkahwinan', 'active', 'Sivil · bukan Islam'],
                        ['Pengurusan Kaveat', 'active', 'Tempoh 21 hari S.22'],
                        ['Pendaftaran Perceraian', 'partial', 'Selepas Perintah Mahkamah'],
                        ['Daftar Semula S.46B', 'scope', 'Sebelum Akta 164 1982'],
                        ['MALAWAKIL Luar Negara', 'scope', 'Kedutaan / Konsulat MY'],
                        ['Pengesahan Taraf', 'active', 'Dalam & luar negara'],
                        ['Tribunal + Badan Pendamai', 'scope', 'S.106 kaunseling'],
                    ],
                    'Sijil + Cabutan (7)' => [
                        ['Carian Daftar', 'active', 'Bayaran semakan'],
                        ['Cabutan Daftar Perkahwinan', 'active', 'Salinan sah'],
                        ['Sijil Perkahwinan', 'active', 'JPN.KC02'],
                        ['Sijil Perceraian', 'partial', 'Decree absolute'],
                        ['Paparan Digital', 'active', 'QR verification'],
                        ['Cetakan Semula', 'active', 'Hilang / rosak'],
                        ['Pelantikan Penolong Pendaftar Rumah Ibadat', 'scope', 'Gereja, Kuil, Persatuan'],
                    ],
                    'Pengurusan Rekod · KRITIKAL (5)' => [
                        ['Pewujudan Rekod', 'active', 'HL Fabric'],
                        ['Pengesahan Rekod', 'active', 'Crypto signature'],
                        ['Pembatalan Permohonan', 'partial', 'Sebelum upacara'],
                        ['Pelupusan Rekod', 'scope', 'Akta Arkib 2003'],
                        ['Pembetulan + Panel Khas', 'partial', 'Fakta + Perkeranian'],
                    ],
                ],
            ],
        ];
    }
}
