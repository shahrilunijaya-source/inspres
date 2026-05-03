<?php

namespace App\Filament\Pages;

use App\Models\Application;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class ManagementDashboard extends Page
{
    protected string $view = 'filament.pages.management-dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $navigationLabel = 'Dashboard Pengurusan';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Dashboard Pengurusan & Heatmap Modul';

    public function getStats(): array
    {
        return [
            'total' => Application::count(),
            'on_track' => Application::where('sla_status', 'on_track')->count(),
            'breach_risk' => Application::whereIn('sla_status', ['breach_risk', 'due_soon'])->count(),
            'breached' => Application::where('sla_status', 'breached')->count(),
            'high_priority' => Application::where('priority_level', 'high')->count(),
            'completed' => Application::whereIn('status', ['completed', 'cert_generated', 'approved'])->count(),
            'by_module' => Application::selectRaw('module, COUNT(*) as total')->groupBy('module')->pluck('total', 'module')->toArray(),
        ];
    }

    public function getModules(): array
    {
        return [
            ['code' => 'birth', 'name' => 'Pendaftaran Kelahiran', 'desc' => 'Modul aktif dalam prototaip', 'status' => 'active', 'icon' => '👶'],
            ['code' => 'mykad', 'name' => 'Permohonan MyKad', 'desc' => 'Modul aktif', 'status' => 'active', 'icon' => '🪪'],
            ['code' => 'marriage', 'name' => 'Pendaftaran Perkahwinan', 'desc' => 'Modul aktif', 'status' => 'active', 'icon' => '💍'],
            ['code' => 'death', 'name' => 'Pendaftaran Kematian', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '🪦'],
            ['code' => 'adoption', 'name' => 'Anak Angkat', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '👨‍👩‍👧'],
            ['code' => 'citizenship', 'name' => 'Kewarganegaraan', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '🇲🇾'],
            ['code' => 'investigation', 'name' => 'Siasatan', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '🔍'],
            ['code' => 'blacklist', 'name' => 'Senarai Hitam', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '⚠️'],
            ['code' => 'revenue', 'name' => 'Kutipan Hasil', 'desc' => 'Sokongan separa', 'status' => 'partial', 'icon' => '💰'],
            ['code' => 'cert', 'name' => 'Sijil & Dokumen', 'desc' => 'Aktif (QR pengesahan)', 'status' => 'active', 'icon' => '📜'],
            ['code' => 'iam', 'name' => 'Pengurusan ID & IAM', 'desc' => 'Sokongan separa', 'status' => 'partial', 'icon' => '🔐'],
            ['code' => 'sharing', 'name' => 'Perkongsian Maklumat', 'desc' => 'Disediakan tetapi belum aktif', 'status' => 'scope', 'icon' => '🔄'],
            ['code' => 'mdm', 'name' => 'MDM', 'desc' => 'Disediakan tetapi belum aktif', 'status' => 'scope', 'icon' => '🗄️'],
            ['code' => 'dwh', 'name' => 'Data Warehouse', 'desc' => 'Disediakan tetapi belum aktif', 'status' => 'scope', 'icon' => '📊'],
            ['code' => 'aduan', 'name' => 'Aduan ICT / Kaunter', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '📞'],
            ['code' => 'pelaporan', 'name' => 'Pelaporan', 'desc' => 'Aktif', 'status' => 'active', 'icon' => '📈'],
            ['code' => 'abis', 'name' => 'ABIS Biometrik', 'desc' => 'Dalam skop', 'status' => 'scope', 'icon' => '👁️'],
        ];
    }
}
