<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CitizenLifecycleEvent;
use App\Services\SlaCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function landing()
    {
        $birth30 = Application::where('module', 'birth')->where('created_at', '>=', now()->subDays(30))->count();
        $birthApproved = Application::where('module', 'birth')->whereIn('status', ['approved','cert_generated','completed'])->count();
        $mykadPending = Application::where('module', 'mykad')->whereIn('status', ['submitted','doc_review','officer_review'])->count();
        $mykadApproved = Application::where('module', 'mykad')->whereIn('status', ['approved','cert_generated','completed'])->count();
        $marriagePending = Application::where('module', 'marriage')->whereIn('status', ['submitted','doc_review','officer_review'])->count();
        $marriageApproved = Application::where('module', 'marriage')->whereIn('status', ['approved','cert_generated','completed'])->count();
        $certIssued = \App\Models\Certificate::count();
        $certVerified = \App\Models\CertificateVerification::sum('verify_count');

        $modules = [
            [
                'code' => 'birth', 'tag' => 'e-Lahir', 'name' => 'Pendaftaran Kelahiran',
                'desc' => 'Daftarkan kelahiran anak dalam talian — sijil dijana digital dengan kod QR pengesahan.',
                'status' => 'active', 'icon' => 'baby', 'route' => 'apply.birth',
                'stats' => [['v' => $birth30, 'l' => 'Permohonan 30 Hari', 't' => 'amber'], ['v' => $birthApproved, 'l' => 'Diluluskan', 't' => 'green']],
            ],
            [
                'code' => 'mykad', 'tag' => 'e-MyKad', 'name' => 'Permohonan MyKad',
                'desc' => 'Permohonan MyKad pertama, gantian, pembaharuan, atau MyKid ke MyKad.',
                'status' => 'active', 'icon' => 'card', 'route' => 'apply.mykad',
                'stats' => [['v' => $mykadPending, 'l' => 'Menunggu', 't' => 'amber'], ['v' => $mykadApproved, 'l' => 'Selesai', 't' => 'green']],
            ],
            [
                'code' => 'marriage', 'tag' => 'e-Kahwin', 'name' => 'Pendaftaran Perkahwinan',
                'desc' => 'Daftar perkahwinan rasmi — caveat, semakan status sivil, dan penjadualan akad.',
                'status' => 'active', 'icon' => 'ring', 'route' => 'apply.marriage',
                'stats' => [['v' => $marriagePending, 'l' => 'Diproses', 't' => 'amber'], ['v' => $marriageApproved, 'l' => 'Diluluskan', 't' => 'green']],
            ],
            [
                'code' => 'cert', 'tag' => 'e-Sijil', 'name' => 'Sijil & Dokumen',
                'desc' => 'Muat turun & sahkan sijil rasmi melalui pengesahan QR pada sebarang masa.',
                'status' => 'active', 'icon' => 'doc', 'route' => 'track',
                'stats' => [['v' => $certIssued, 'l' => 'Dikeluarkan', 't' => 'green'], ['v' => $certVerified, 'l' => 'Disahkan', 't' => 'amber']],
            ],
            ['code' => 'death', 'tag' => 'e-Mati', 'name' => 'Pendaftaran Kematian', 'desc' => 'Pendaftaran sijil kematian.', 'status' => 'scope', 'icon' => 'urn'],
            ['code' => 'adoption', 'tag' => 'e-Anak', 'name' => 'Anak Angkat', 'desc' => 'Permohonan anak angkat.', 'status' => 'scope', 'icon' => 'users'],
            ['code' => 'citizenship', 'tag' => 'e-Warga', 'name' => 'Kewarganegaraan', 'desc' => 'Permohonan kewarganegaraan.', 'status' => 'scope', 'icon' => 'flag'],
            ['code' => 'aduan', 'tag' => 'e-Aduan', 'name' => 'Aduan & Khidmat Pelanggan', 'desc' => 'Hantar aduan ICT atau kaunter.', 'status' => 'scope', 'icon' => 'chat'],
        ];

        return view('landing', compact('modules'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        $applications = Application::where('applicant_user_id', $user->id)
            ->latest('submitted_at')
            ->latest('id')
            ->get();

        $lifecycleEvents = CitizenLifecycleEvent::where('user_id', $user->id)
            ->orderBy('order_index')
            ->get();

        if ($lifecycleEvents->isEmpty()) {
            $lifecycleEvents = collect([
                (object) ['title' => 'Pendaftaran Kelahiran', 'status' => 'future', 'description' => 'Sijil kelahiran direkodkan.'],
                (object) ['title' => 'MyKid', 'status' => 'future', 'description' => 'MyKid untuk kanak-kanak.'],
                (object) ['title' => 'MyKad', 'status' => 'future', 'description' => 'MyKad warganegara.'],
                (object) ['title' => 'Perkahwinan', 'status' => 'future', 'description' => 'Pendaftaran perkahwinan.'],
            ]);
        }

        return view('dashboard', compact('applications', 'lifecycleEvents'));
    }

    public function track(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $module = $request->query('module');

        $application = null;
        $searched = false;

        if ($q !== '') {
            $searched = true;
            $query = Application::with(['applicant', 'auditLogs'])
                ->where('app_no', strtoupper($q));
            if ($module) $query->where('module', $module);
            $application = $query->first();

            if ($application) {
                SlaCalculator::refresh($application);
                $application->refresh();
            }
        }

        return view('track', compact('application', 'q', 'module', 'searched'));
    }
}
