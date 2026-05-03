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
                'name' => 'Perkongsian Maklumat',
                'desc' => 'API & perkongsian rentas agensi (PDRM, JPJ, Imigresen).',
                'icon' => '🔄',
                'status' => 'scope',
                'roles' => ['supervisor', 'admin'],
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
                'name' => 'ABIS Biometrik',
                'desc' => 'Padanan biometrik automatik (cap jari, muka).',
                'icon' => '👁️',
                'status' => 'scope',
                'roles' => ['officer', 'supervisor', 'admin'],
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
