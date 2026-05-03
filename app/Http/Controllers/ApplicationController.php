<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\BirthApplication;
use App\Models\Document;
use App\Models\MarriageApplication;
use App\Models\MykadApplication;
use App\Models\Payment;
use App\Services\AppNumberGenerator;
use App\Services\AuditLogger;
use App\Services\SlaCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::where('applicant_user_id', Auth::id())
            ->latest('id')
            ->get();
        return view('applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        abort_unless($application->applicant_user_id === Auth::id(), 403);
        $application->load(['birth', 'mykad', 'marriage', 'documents', 'payments', 'certificate', 'auditLogs.user', 'assignedOfficer']);
        SlaCalculator::refresh($application);
        $application->refresh();
        return view('applications.show', compact('application'));
    }

    public function createBirth() { return view('apply.birth'); }
    public function createMykad() { return view('apply.mykad'); }
    public function createMarriage() { return view('apply.marriage'); }

    public function storeBirth(Request $request)
    {
        $data = $request->validate([
            'child_name' => 'required|string|max:120',
            'child_gender' => 'required|in:lelaki,perempuan',
            'child_dob' => 'required|date',
            'hospital' => 'required|string|max:120',
            'place_of_birth' => 'nullable|string|max:120',
            'father_name' => 'required|string|max:120',
            'father_nric' => 'required|string|max:14',
            'mother_name' => 'required|string|max:120',
            'mother_nric' => 'required|string|max:14',
        ]);

        $app = $this->createApp('birth');
        BirthApplication::create([...$data, 'application_id' => $app->id]);
        $this->seedDocs($app, ['birth_notification' => 'Notifikasi Hospital', 'parent_ic' => 'IC Ibu Bapa']);
        $this->createPayment($app, 20.00);
        AuditLogger::log($app, Auth::user(), 'submit_application', 'draft', 'submitted', 'Permohonan kelahiran dihantar.');

        return redirect()->route('applications.show', $app)->with('success', 'Permohonan dihantar.');
    }

    public function storeMykad(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:first_time,replacement,renewal,mykid_to_mykad',
            'full_name' => 'required|string|max:120',
            'nric' => 'required|string|max:14',
            'dob' => 'required|date',
            'reason' => 'nullable|string|max:240',
        ]);

        $app = $this->createApp('mykad');
        MykadApplication::create([...$data, 'application_id' => $app->id, 'biometric_status' => 'verified', 'blacklist_check' => 'clear']);
        $this->seedDocs($app, ['mykad_photo' => 'Gambar Pasport', 'birth_cert' => 'Sijil Kelahiran']);
        $this->createPayment($app, 10.00);
        AuditLogger::log($app, Auth::user(), 'submit_application', 'draft', 'submitted', 'Permohonan MyKad dihantar.');

        return redirect()->route('applications.show', $app)->with('success', 'Permohonan dihantar.');
    }

    public function storeMarriage(Request $request)
    {
        $data = $request->validate([
            'groom_name' => 'required|string|max:120',
            'groom_nric' => 'required|string|max:14',
            'groom_religion' => 'nullable|string|max:30',
            'bride_name' => 'required|string|max:120',
            'bride_nric' => 'required|string|max:14',
            'bride_religion' => 'nullable|string|max:30',
            'witness1_name' => 'required|string|max:120',
            'witness1_nric' => 'required|string|max:14',
            'witness2_name' => 'required|string|max:120',
            'witness2_nric' => 'required|string|max:14',
            'appointment_at' => 'nullable|date',
        ]);

        $app = $this->createApp('marriage');
        MarriageApplication::create([
            ...$data,
            'application_id' => $app->id,
            'caveat_status' => 'clear',
            'civil_status_check' => 'clear',
            'appointment_location' => 'JPN Putrajaya',
        ]);
        $this->seedDocs($app, ['groom_ic' => 'IC Lelaki', 'bride_ic' => 'IC Perempuan']);
        $this->createPayment($app, 30.00);
        AuditLogger::log($app, Auth::user(), 'submit_application', 'draft', 'submitted', 'Permohonan perkahwinan dihantar.');

        return redirect()->route('applications.show', $app)->with('success', 'Permohonan dihantar.');
    }

    private function createApp(string $module): Application
    {
        return DB::transaction(function () use ($module) {
            $now = now();
            $due = SlaCalculator::dueAt($module, $now);
            return Application::create([
                'app_no' => AppNumberGenerator::generate($module),
                'module' => $module,
                'applicant_user_id' => Auth::id(),
                'status' => 'submitted',
                'priority_level' => 'normal',
                'sla_due_at' => $due,
                'sla_status' => SlaCalculator::status($due),
                'estimated_completion_at' => $due,
                'demo_current_step' => Application::TRACKER_STEPS['submitted'],
                'submitted_at' => $now,
            ]);
        });
    }

    private function seedDocs(Application $app, array $docs): void
    {
        foreach ($docs as $type => $label) {
            Document::create([
                'application_id' => $app->id,
                'type' => $type,
                'label' => $label,
                'file_name' => $type . '.pdf',
                'verified' => false,
            ]);
        }
    }

    private function createPayment(Application $app, float $amount): void
    {
        Payment::create([
            'application_id' => $app->id,
            'amount' => $amount,
            'receipt_no' => 'RCP-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'status' => 'paid',
            'method' => 'FPX',
            'paid_at' => now(),
        ]);
        $app->update(['status' => 'doc_review']);
    }
}
