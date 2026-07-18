<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\AuditLog;
use Filament\Widgets\Widget;

class InternalModulesWidget extends Widget
{
    protected string $view = 'filament.widgets.internal-modules';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['officer', 'supervisor', 'admin'], true);
    }

    public function getModules(): array
    {
        $role = auth()->user()?->role ?? 'guest';

        $all = [
            [
                'code' => 'work_queue',
                'tag'  => 'i-Kerja',
                'name' => 'Antrian Permohonan',
                'desc' => 'Semak permohonan masuk, keutamaan SLA, dan tindakan pegawai.',
                'icon' => '📥',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/applications',
                'stats' => [
                    ['label' => 'Menunggu Tindakan', 'value' => Application::whereIn('status', ['submitted','doc_review','officer_review'])->count(), 'tone' => 'amber'],
                    ['label' => 'Diluluskan Hari Ini', 'value' => Application::whereDate('approved_at', today())->count(), 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'siasatan',
                'tag'  => 'i-Siasatan',
                'name' => 'Siasatan',
                'desc' => 'Siasatan kes pendua, pemalsuan, dan kesahihan dokumen.',
                'icon' => '🔍',
                'status' => 'scope',
                'roles' => ['officer', 'supervisor', 'admin'],
            ],
            [
                'code' => 'blacklist',
                'tag'  => 'i-SenaraiHitam',
                'name' => 'Senarai Hitam',
                'desc' => 'Pengurusan senarai hitam & sekatan permohonan.',
                'icon' => '⚠️',
                'status' => 'scope',
                'roles' => ['supervisor', 'admin'],
            ],
            [
                'code' => 'revenue',
                'tag'  => 'i-Hasil',
                'name' => 'Kutipan Hasil',
                'desc' => 'Bayaran, terimaan, resit, dan rekonsiliasi kewangan.',
                'icon' => '💰',
                'status' => 'partial',
                'roles' => ['officer', 'supervisor', 'admin'],
            ],
            [
                'code' => 'iam',
                'tag'  => 'i-IAM',
                'name' => 'Pengurusan ID & IAM',
                'desc' => 'Pengguna, peranan, ACL, dan polisi kata laluan.',
                'icon' => '🔐',
                'status' => 'partial',
                'roles' => ['admin'],
            ],
            [
                'code' => 'sharing',
                'tag'  => 'i-Sharing',
                'name' => 'Integrasi Agensi (13 + MyGDX)',
                'desc' => 'API rentas agensi · KKM, PDRM, JPJ, LHDN, KWSP, SPR, MAMPU MyGDX.',
                'icon' => '🔄',
                'status' => 'active',
                'roles' => ['supervisor', 'admin'],
                'url' => '/admin/agensi-integrasi',
                'stats' => [
                    ['label' => 'Agensi Aktif', 'value' => 17, 'tone' => 'green'],
                    ['label' => 'Panggilan Hari Ini', 'value' => '21.4k', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'mdm',
                'tag'  => 'i-MDM',
                'name' => 'Pengurusan Data Induk (MDM)',
                'desc' => 'Master data, rujukan, dan kualiti data.',
                'icon' => '🗄️',
                'status' => 'scope',
                'roles' => ['admin'],
            ],
            [
                'code' => 'dwh',
                'tag'  => 'i-DWH',
                'name' => 'Data Warehouse',
                'desc' => 'Gudang data analitik untuk pelaporan eksekutif.',
                'icon' => '📊',
                'status' => 'scope',
                'roles' => ['supervisor', 'admin'],
            ],
            [
                'code' => 'pelaporan',
                'tag'  => 'i-Lapor',
                'name' => 'Pelaporan & Analitik',
                'desc' => 'Laporan operasi, KPI, prestasi cawangan.',
                'icon' => '📈',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/management-dashboard',
                'stats' => [
                    ['label' => 'Jumlah Permohonan', 'value' => Application::count(), 'tone' => 'green'],
                    ['label' => 'Breach SLA', 'value' => Application::where('sla_status', 'breached')->count(), 'tone' => 'red'],
                ],
            ],
            [
                'code' => 'abis',
                'tag'  => 'i-ABIS',
                'name' => 'ABIS 1:N Biometrik',
                'desc' => 'Padanan biometrik 30M+ rekod · GPU NVIDIA H200 · < 5 saat.',
                'icon' => '👁️',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/abis-match',
                'stats' => [
                    ['label' => 'Padanan Hari Ini', 'value' => '4.8k', 'tone' => 'green'],
                    ['label' => 'Pendua Dikesan', 'value' => 7, 'tone' => 'red'],
                ],
            ],
            [
                'code' => 'biometric',
                'tag'  => 'i-Biometrik',
                'name' => 'Penangkapan Biometrik',
                'desc' => '10 cap jari + muka + iris · ISO 19794 + 30107 PAD.',
                'icon' => '🫆',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/biometric-capture',
                'stats' => [
                    ['label' => 'Kaunter Aktif', 'value' => 241, 'tone' => 'green'],
                    ['label' => 'Sesi Hari Ini', 'value' => '6.2k', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'blockchain',
                'tag'  => 'i-Lejer',
                'name' => 'Hyperledger Fabric',
                'desc' => 'Lejer rekod kekal · bukti mahkamah Akta Keterangan S.90A.',
                'icon' => '🔗',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/blockchain-ledger',
                'stats' => [
                    ['label' => 'Jumlah Blok', 'value' => '1.93M', 'tone' => 'green'],
                    ['label' => 'Block Time', 'value' => '612ms', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'kaveat',
                'tag'  => 'i-Kaveat',
                'name' => 'Kaveat 21 Hari',
                'desc' => 'Akta 164 S.22 · pengiklanan rasmi sebelum upacara kahwin.',
                'icon' => '💍',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/kaveat-board',
                'stats' => [
                    ['label' => 'Kaveat Aktif', 'value' => 6, 'tone' => 'amber'],
                    ['label' => 'Bantahan', 'value' => 1, 'tone' => 'red'],
                ],
            ],
            [
                'code' => 'katalog',
                'tag'  => 'i-Katalog',
                'name' => 'Katalog Sub-Fungsi (63)',
                'desc' => 'Semua 63 sub-fungsi · Kelahiran (22) + MyKad (22) + Kahwin (19).',
                'icon' => '📋',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/sub-fungsi-katalog',
                'stats' => [
                    ['label' => 'Fungsi Aktif', 'value' => 31, 'tone' => 'green'],
                    ['label' => 'Dalam Pembangunan', 'value' => 32, 'tone' => 'amber'],
                ],
            ],
            [
                'code' => 'kafka',
                'tag'  => 'i-EventBus',
                'name' => 'Kafka Event Bus',
                'desc' => 'Stream event antara 9 modul dalaman · Avro schema registry.',
                'icon' => '📡',
                'status' => 'active',
                'roles' => ['supervisor', 'admin'],
                'url' => '/admin/kafka-events',
                'stats' => [
                    ['label' => 'Throughput', 'value' => '4.8k/s', 'tone' => 'green'],
                    ['label' => 'Topic Aktif', 'value' => 8, 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'kkm',
                'tag'  => 'i-Hospital',
                'name' => 'Hospital KKM Pra-Daftar',
                'desc' => 'Pra-pendaftaran kelahiran dari 11 hospital KKM · FHIR R4.',
                'icon' => '🏥',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/hospital-pra-daftar',
                'stats' => [
                    ['label' => 'Hari Ini', 'value' => 234, 'tone' => 'green'],
                    ['label' => 'Menunggu', 'value' => 42, 'tone' => 'amber'],
                ],
            ],
            [
                'code' => 'clms',
                'tag'  => 'i-CLMS',
                'name' => 'CLMS Kitar Hayat Kad',
                'desc' => 'Stok · personalization · key injection · ICAO Doc 9303.',
                'icon' => '🆔',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/clms-pipeline',
                'stats' => [
                    ['label' => 'Antrian Cetak', 'value' => 421, 'tone' => 'amber'],
                    ['label' => 'Sedia Serah', 'value' => 287, 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'familytree',
                'tag'  => 'i-Salasilah',
                'name' => 'Salasilah Keluarga',
                'desc' => 'Family tree graph · auto-update dari kelahiran/kahwin/mati.',
                'icon' => '🌳',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/family-tree',
                'stats' => [
                    ['label' => 'Nod', 'value' => '32.8M', 'tone' => 'green'],
                    ['label' => 'Query Hari Ini', 'value' => '18.4k', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'mydigital',
                'tag'  => 'i-MyDigital',
                'name' => 'MyDigital ID',
                'desc' => 'Auto-provision setiap MyKad · SSO 74 agensi via MyGDX.',
                'icon' => '🔑',
                'status' => 'active',
                'roles' => ['supervisor', 'admin'],
                'url' => '/admin/mydigital-id',
                'stats' => [
                    ['label' => 'Akaun Aktif', 'value' => '21.8M', 'tone' => 'green'],
                    ['label' => 'Provision Hari Ini', 'value' => '4.8k', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'perkakasan',
                'tag'  => 'i-Perkakasan',
                'name' => 'Perkakasan Kaunter',
                'desc' => '9 jenis perkakasan APPENDIX C · waranti 5 tahun on-site SLA.',
                'icon' => '🖨️',
                'status' => 'active',
                'roles' => ['officer', 'supervisor', 'admin'],
                'url' => '/admin/perkakasan-status',
                'stats' => [
                    ['label' => 'Unit Online', 'value' => '2.8k', 'tone' => 'green'],
                    ['label' => 'Uptime', 'value' => '99.2%', 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'audit',
                'tag'  => 'i-Audit',
                'name' => 'Audit Trail',
                'desc' => 'Garis masa kebolehauditan permohonan.',
                'icon' => '🛡️',
                'status' => 'active',
                'roles' => ['supervisor', 'admin'],
                'url' => '/admin/audit-logs',
                'stats' => [
                    ['label' => 'Jumlah Log', 'value' => AuditLog::count(), 'tone' => 'green'],
                ],
            ],
            [
                'code' => 'aduan',
                'tag'  => 'i-Aduan',
                'name' => 'Aduan ICT & Kaunter',
                'desc' => 'Aduan pelanggan, isu kaunter, & sokongan ICT.',
                'icon' => '📞',
                'status' => 'scope',
                'roles' => ['officer', 'supervisor', 'admin'],
            ],
        ];

        return array_values(array_filter($all, fn ($m) => in_array($role, $m['roles'], true)));
    }

    public function getRoleLabel(): string
    {
        return auth()->user()?->roleLabel() ?? 'Tetamu';
    }

    public function getCounts(): array
    {
        $modules = $this->getModules();
        return [
            'total' => count($modules),
            'active' => count(array_filter($modules, fn ($m) => $m['status'] === 'active')),
            'partial' => count(array_filter($modules, fn ($m) => $m['status'] === 'partial')),
            'scope' => count(array_filter($modules, fn ($m) => $m['status'] === 'scope')),
        ];
    }
}
