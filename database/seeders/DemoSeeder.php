<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\AuditLog;
use App\Models\BirthApplication;
use App\Models\Branch;
use App\Models\Certificate;
use App\Models\CertificateVerification;
use App\Models\CitizenLifecycleEvent;
use App\Models\DemoWalkthroughStep;
use App\Models\Document;
use App\Models\MarriageApplication;
use App\Models\MykadApplication;
use App\Models\Payment;
use App\Models\User;
use App\Services\AppNumberGenerator;
use App\Services\SlaCalculator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::create([
            'name' => 'JPN Putrajaya',
            'code' => 'PJY-01',
            'state' => 'Putrajaya',
            'address' => 'No. 20, Persiaran Perdana, Presint 2, 62551 Putrajaya',
        ]);

        $branchKL = Branch::create([
            'name' => 'JPN Kuala Lumpur',
            'code' => 'KUL-01',
            'state' => 'Wilayah Persekutuan',
            'address' => 'Kompleks Pusat Bandar Damansara, KL',
        ]);

        // demo users
        $public = User::create([
            'name' => 'Puan Siti Aisyah binti Hassan',
            'email' => 'siti@demo.gov.my',
            'password' => bcrypt('Password123!'),
            'role' => 'public',
            'nric' => '880412-14-5678',
            'phone' => '012-3456789',
            'is_demo' => true,
        ]);

        $officer = User::create([
            'name' => 'Puan Hafizah binti Omar',
            'email' => 'hafizah@jpn.gov.my',
            'password' => bcrypt('Password123!'),
            'role' => 'officer',
            'nric' => '850315-08-1234',
            'branch_id' => $branch->id,
            'is_demo' => true,
        ]);

        $supervisor = User::create([
            'name' => 'Puan Mariam binti Yusoff',
            'email' => 'mariam@jpn.gov.my',
            'password' => bcrypt('Password123!'),
            'role' => 'supervisor',
            'nric' => '780622-10-9876',
            'branch_id' => $branch->id,
            'is_demo' => true,
        ]);

        $admin = User::create([
            'name' => 'Encik Aiman bin Zulkifli',
            'email' => 'aiman@jpn.gov.my',
            'password' => bcrypt('Password123!'),
            'role' => 'admin',
            'nric' => '750108-14-4321',
            'branch_id' => $branch->id,
            'is_demo' => true,
        ]);

        $public2 = User::create([
            'name' => 'Encik Ahmad bin Rashid',
            'email' => 'ahmad@demo.gov.my',
            'password' => bcrypt('Password123!'),
            'role' => 'public',
            'nric' => '900208-14-7777',
            'phone' => '019-7654321',
            'is_demo' => true,
        ]);

        // === Birth application — completed (Siti registered her child) ===
        $birthApp = $this->makeApp('birth', $public, $branch, 'completed', now()->subDays(5), $officer, $supervisor);
        BirthApplication::create([
            'application_id' => $birthApp->id,
            'child_name' => 'Aisyah Nur binti Khairul',
            'child_gender' => 'perempuan',
            'child_dob' => now()->subDays(10),
            'child_time_of_birth' => '08:45',
            'hospital' => 'Hospital Putrajaya',
            'place_of_birth' => 'Putrajaya',
            'father_name' => 'Khairul bin Ismail',
            'father_nric' => '870922-14-3344',
            'mother_name' => 'Siti Aisyah binti Hassan',
            'mother_nric' => '880412-14-5678',
        ]);
        $this->makeBirthDocs($birthApp, true);
        $this->makePayment($birthApp, 20.00, 'paid');
        $cert = $this->makeCertificate($birthApp, 'birth_cert', 'Aisyah Nur binti Khairul');
        $this->makeAuditTrail($birthApp, $public, $officer, $supervisor, true);
        $this->lifecycle($public, $birthApp, 'birth_registered', 'Pendaftaran Kelahiran', 'completed', 1);
        $this->lifecycle($public, null, 'mykid_issued', 'MyKid', 'future', 2);
        $this->lifecycle($public, null, 'mykad_issued', 'MyKad', 'future', 3);
        $this->lifecycle($public, null, 'marriage_registered', 'Perkahwinan', 'future', 4);

        // === MyKad application — officer review ===
        $mykadApp = $this->makeApp('mykad', $public2, $branch, 'officer_review', now()->subDays(2), $officer);
        MykadApplication::create([
            'application_id' => $mykadApp->id,
            'type' => 'first_time',
            'full_name' => 'Ahmad bin Rashid',
            'nric' => '900208-14-7777',
            'dob' => now()->subYears(35),
            'reason' => 'Permohonan kali pertama selepas mencapai umur 12 tahun (mykid expired)',
            'biometric_status' => 'verified',
            'blacklist_check' => 'clear',
        ]);
        $this->makeBirthDocs($mykadApp, true, ['mykad_photo' => 'Gambar Pasport', 'birth_cert' => 'Sijil Kelahiran', 'mykid' => 'MyKid Lama']);
        $this->makePayment($mykadApp, 10.00, 'paid');
        $this->makeAuditTrail($mykadApp, $public2, $officer, null, false);
        $this->lifecycle($public2, null, 'birth_registered', 'Pendaftaran Kelahiran', 'completed', 1);
        $this->lifecycle($public2, null, 'mykid_issued', 'MyKid', 'completed', 2);
        $this->lifecycle($public2, $mykadApp, 'mykad_issued', 'MyKad', 'current', 3);
        $this->lifecycle($public2, null, 'marriage_registered', 'Perkahwinan', 'future', 4);

        // === Marriage application — submitted, breach risk ===
        $marriageApp = $this->makeApp('marriage', $public, $branchKL, 'doc_review', now()->subDays(6), $officer);
        MarriageApplication::create([
            'application_id' => $marriageApp->id,
            'groom_name' => 'Khairul bin Ismail',
            'groom_nric' => '870922-14-3344',
            'groom_religion' => 'Islam',
            'bride_name' => 'Siti Aisyah binti Hassan',
            'bride_nric' => '880412-14-5678',
            'bride_religion' => 'Islam',
            'witness1_name' => 'Ismail bin Ali',
            'witness1_nric' => '600101-14-1111',
            'witness2_name' => 'Hassan bin Yusof',
            'witness2_nric' => '550215-14-2222',
            'caveat_status' => 'clear',
            'civil_status_check' => 'clear',
            'appointment_at' => now()->addDays(3)->setTime(10, 0),
            'appointment_location' => 'JPN KL',
        ]);
        $this->makeBirthDocs($marriageApp, false, ['groom_ic' => 'Salinan IC Lelaki', 'bride_ic' => 'Salinan IC Perempuan', 'sijil_doa' => 'Sijil Permohonan']);
        $this->makePayment($marriageApp, 30.00, 'paid');
        $this->makeAuditTrail($marriageApp, $public, $officer, null, false);

        // === Extra: Birth — submitted, draft + breached ===
        $draftBirth = $this->makeApp('birth', $public2, $branch, 'submitted', now()->subDays(8), null);
        BirthApplication::create([
            'application_id' => $draftBirth->id,
            'child_name' => 'Adam bin Ahmad',
            'child_gender' => 'lelaki',
            'child_dob' => now()->subDays(12),
            'hospital' => 'Hospital Selayang',
            'father_name' => 'Ahmad bin Rashid',
            'father_nric' => '900208-14-7777',
            'mother_name' => 'Nurul Huda binti Karim',
            'mother_nric' => '920310-14-5555',
        ]);
        $this->makeBirthDocs($draftBirth, false);
        $this->makeAuditTrail($draftBirth, $public2, null, null, false);

        // refresh SLA on all applications
        Application::all()->each(fn ($a) => SlaCalculator::refresh($a));

        // demo walkthrough steps (20)
        $this->seedWalkthrough();
    }

    private function makeApp(string $module, User $applicant, Branch $branch, string $status, $submittedAt, ?User $officer = null, ?User $approver = null): Application
    {
        $sub = $submittedAt instanceof \Carbon\Carbon ? $submittedAt : \Carbon\Carbon::parse($submittedAt);
        $due = SlaCalculator::dueAt($module, $sub);

        return Application::create([
            'app_no' => AppNumberGenerator::generate($module),
            'module' => $module,
            'applicant_user_id' => $applicant->id,
            'branch_id' => $branch->id,
            'status' => $status,
            'priority_level' => 'normal',
            'sla_due_at' => $due,
            'sla_status' => SlaCalculator::status($due),
            'estimated_completion_at' => $due,
            'demo_current_step' => Application::TRACKER_STEPS[$status] ?? 1,
            'submitted_at' => $sub,
            'assigned_officer_id' => $officer?->id,
            'approved_by_officer_id' => $status === 'completed' ? $approver?->id : null,
            'approved_at' => $status === 'completed' ? $sub->copy()->addDays(2) : null,
        ]);
    }

    private function makeBirthDocs(Application $app, bool $verified, array $extra = []): void
    {
        $defaults = $extra ?: [
            'birth_notification' => 'Notifikasi Hospital',
            'parent_ic' => 'Salinan IC Ibu Bapa',
            'marriage_cert' => 'Sijil Perkahwinan',
        ];

        foreach ($defaults as $type => $label) {
            Document::create([
                'application_id' => $app->id,
                'type' => $type,
                'label' => $label,
                'file_name' => $type . '.pdf',
                'verified' => $verified,
                'verified_at' => $verified ? now() : null,
            ]);
        }
    }

    private function makePayment(Application $app, float $amount, string $status): Payment
    {
        return Payment::create([
            'application_id' => $app->id,
            'amount' => $amount,
            'receipt_no' => $status === 'paid' ? 'RCP-' . strtoupper(Str::random(8)) : null,
            'status' => $status,
            'method' => $status === 'paid' ? 'FPX' : null,
            'paid_at' => $status === 'paid' ? $app->submitted_at?->copy()->addHour() : null,
        ]);
    }

    private function makeCertificate(Application $app, string $type, string $subject): Certificate
    {
        $certNo = AppNumberGenerator::generateCertNo($app->module);
        $token = Str::random(32);

        $cert = Certificate::create([
            'application_id' => $app->id,
            'cert_no' => $certNo,
            'type' => $type,
            'subject_name' => $subject,
            'issued_at' => now()->subDay(),
            'qr_token' => $token,
            'payload' => [
                'subject' => $subject,
                'application' => $app->app_no,
                'module' => $app->module,
            ],
        ]);

        CertificateVerification::create([
            'certificate_id' => $cert->id,
            'certificate_no' => $certNo,
            'verification_code' => $token,
            'verification_url' => url('/verify/certificate/' . $certNo),
            'status' => 'valid',
        ]);

        return $cert;
    }

    private function makeAuditTrail(Application $app, User $applicant, ?User $officer, ?User $supervisor, bool $finalised): void
    {
        $base = $app->submitted_at ?? now();
        AuditLog::create([
            'application_id' => $app->id,
            'user_id' => $applicant->id,
            'user_role' => 'public',
            'user_label' => 'Pengguna Awam — ' . $applicant->name,
            'action' => 'submit_application',
            'status_before' => 'draft',
            'status_after' => 'submitted',
            'created_at' => $base,
        ]);

        if ($officer) {
            AuditLog::create([
                'application_id' => $app->id,
                'user_id' => $officer->id,
                'user_role' => 'officer',
                'user_label' => 'Pegawai — ' . $officer->name,
                'action' => 'review_documents',
                'status_before' => 'submitted',
                'status_after' => 'doc_review',
                'created_at' => $base->copy()->addHours(3),
            ]);
            AuditLog::create([
                'application_id' => $app->id,
                'user_id' => $officer->id,
                'user_role' => 'officer',
                'user_label' => 'Pegawai — ' . $officer->name,
                'action' => 'verify_documents',
                'status_before' => 'doc_review',
                'status_after' => 'officer_review',
                'created_at' => $base->copy()->addHours(4),
            ]);
        }

        if ($supervisor && $finalised) {
            AuditLog::create([
                'application_id' => $app->id,
                'user_id' => $supervisor->id,
                'user_role' => 'supervisor',
                'user_label' => 'Penyelia — ' . $supervisor->name,
                'action' => 'approve_application',
                'status_before' => 'officer_review',
                'status_after' => 'approved',
                'remarks' => 'Permohonan diluluskan.',
                'created_at' => $base->copy()->addHours(8),
            ]);
            AuditLog::create([
                'application_id' => $app->id,
                'user_id' => null,
                'user_role' => 'system',
                'user_label' => 'Sistem',
                'action' => 'generate_certificate',
                'status_before' => 'approved',
                'status_after' => 'cert_generated',
                'created_at' => $base->copy()->addHours(9),
            ]);
        }
    }

    private function lifecycle(User $user, ?Application $app, string $type, string $title, string $status, int $order): void
    {
        CitizenLifecycleEvent::create([
            'user_id' => $user->id,
            'application_id' => $app?->id,
            'event_type' => $type,
            'title' => $title,
            'description' => $this->lifecycleDesc($type),
            'event_date' => $status === 'completed' ? ($app?->approved_at ?? now()->subWeeks($order)) : null,
            'status' => $status,
            'order_index' => $order,
        ]);
    }

    private function lifecycleDesc(string $type): string
    {
        return match ($type) {
            'birth_registered' => 'Sijil kelahiran direkodkan dalam INPReS.',
            'mykid_issued' => 'MyKid dikeluarkan untuk kanak-kanak di bawah umur 12 tahun.',
            'mykad_issued' => 'MyKad dikeluarkan kepada warganegara Malaysia berumur 12 tahun ke atas.',
            'marriage_registered' => 'Perkahwinan didaftarkan secara rasmi.',
            'death_registered' => 'Pendaftaran kematian.',
            default => '',
        };
    }

    private function seedWalkthrough(): void
    {
        $steps = [
            [1, 'Halaman Utama', 'Tunjuk laman utama dengan nilai sebelum & selepas.', '/', 'Bermula dari konteks bisnes — INPReS bukan sekadar borang, ia platform digital lengkap.'],
            [2, 'Direktori Modul Penuh', 'Paparkan semua 16+ modul INPReS.', '/#modules', 'Tunjuk skop penuh — modul aktif vs in-scope.'],
            [3, 'Modul Aktif vs In-Scope', 'Heatmap modul, status berkod warna.', '/admin/management', 'Klien lihat sistem berfikir holistik.'],
            [4, 'Log Masuk sebagai Pengguna Awam', 'Switch demo ke Puan Siti Aisyah.', '/demo/switch?role=public', 'Mulakan perjalanan rakyat.'],
            [5, 'Hantar Pendaftaran Kelahiran', 'Borang pendaftaran kelahiran.', '/apply/birth', 'Tunjuk pengalaman warganegara.'],
            [6, 'Muat Naik Dokumen', 'Lampiran disahkan secara digital.', '/applications', 'Tiada lagi datang kaunter berulang kali.'],
            [7, 'Smart Tracker', 'Penjejak permohonan ala kurier.', '/applications', 'Status jelas, tindakan seterusnya jelas.'],
            [8, 'Tukar ke Pegawai', 'Demo switcher → Pegawai Hafizah.', '/demo/switch?role=officer', 'Mula sebelah pejabat.'],
            [9, 'Semak Permohonan + AI Panel', 'AI Review Assistant beri saranan.', '/admin/applications', 'Buat sistem rasa moden tanpa kompleksiti AI sebenar.'],
            [10, 'Luluskan Permohonan', 'Pegawai luluskan, audit dilog.', '/admin/applications', 'Tindakan dilog dalam audit trail.'],
            [11, 'Jana Sijil + QR', 'Sijil dijana dengan pautan QR pengesahan.', '/admin/certificates', 'Pengesahan dokumen tanpa cap basah.'],
            [12, 'Hantar Permohonan MyKad', 'Tunjuk modul kedua.', '/apply/mykad', 'Lifecycle bersambung.'],
            [13, 'Mock ABIS & Senarai Hitam', 'Semakan biometrik & sekatan.', '/admin/applications', 'Boleh tambah integrasi sebenar kelak.'],
            [14, 'Hantar Permohonan Perkahwinan', 'Modul ketiga.', '/apply/marriage', 'Genapkan demo lifecycle.'],
            [15, 'Caveat & Penjadualan Temujanji', 'Tetapkan tarikh akad nikah.', '/admin/applications', 'Logik perniagaan diintegrasi.'],
            [16, 'Tukar ke Penyelia', 'Demo switcher → Mariam.', '/demo/switch?role=supervisor', 'Lihat dari sudut pengurusan.'],
            [17, 'Dashboard Pengurusan', 'Heatmap modul, statistik.', '/admin/management', 'Pengurusan ada visibility penuh.'],
            [18, 'Pemantauan SLA', 'Pantau breach risk.', '/admin/management', 'Sistem bantu fokus tindakan.'],
            [19, 'Audit Trail', 'Garis masa kebolehauditan.', '/admin/audit-logs', 'Compliance + traceability.'],
            [20, 'Citizen Lifecycle Timeline', 'Tutup dengan visualisasi lifecycle.', '/dashboard', 'Mesej penutup: INPReS sambungkan kehidupan rakyat.'],
        ];

        foreach ($steps as [$no, $title, $desc, $url, $notes]) {
            DemoWalkthroughStep::create([
                'step_no' => $no,
                'title' => $title,
                'description' => $desc,
                'route_url' => $url,
                'presenter_notes' => $notes,
                'is_active' => true,
            ]);
        }
    }
}
