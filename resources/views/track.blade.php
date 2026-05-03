@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 40px 24px;">
    <h2>Semakan Status Permohonan</h2>
    <p class="muted">Masukkan nombor permohonan untuk melihat status, kemajuan, dan SLA.</p>

    <form action="{{ route('track') }}" method="GET" class="card mt-4">
        <div class="row row-2">
            <div class="form-group">
                <label class="form-label">Modul</label>
                <select name="module" class="form-control">
                    <option value="">Semua Modul</option>
                    @foreach (\App\Models\Application::MODULES as $code => $label)
                        <option value="{{ $code }}" {{ $module === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">No. Permohonan</label>
                <input type="text" name="q" class="form-control" placeholder="cth. KLH-2026-001234" value="{{ $q }}" required>
            </div>
        </div>
        <button class="btn btn-primary">Semak Status</button>
    </form>

    @if ($searched && !$application)
        <div class="card mt-4" style="border: 2px solid var(--red); background: var(--red-bg);">
            <strong style="color: var(--red);">Tidak Dijumpai</strong>
            <p style="margin: 8px 0 0;">No. permohonan <code>{{ $q }}</code>{{ $module ? ' bagi modul ' . (\App\Models\Application::MODULES[$module] ?? $module) : '' }} tidak ditemui dalam sistem.</p>
        </div>
    @endif

    @if ($application)
        <div class="card mt-6 card-accent">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <div class="muted" style="font-size: 11px; text-transform: uppercase;">{{ $application->moduleLabel() }}</div>
                    <h2 class="mt-0 mb-0">{{ $application->app_no }}</h2>
                </div>
                <div class="flex gap-2">
                    <x-priority-badge :level="$application->priority_level" />
                    <x-sla-badge :application="$application" />
                </div>
            </div>
            <div class="row row-2">
                <div><div class="muted">Pemohon</div><strong>{{ \Illuminate\Support\Str::mask($application->applicant->name, '*', 3, max(0, strlen($application->applicant->name) - 6)) }}</strong></div>
                <div><div class="muted">Status</div><span class="badge badge-blue">{{ $application->statusLabel() }}</span></div>
                <div><div class="muted">Dihantar</div>{{ $application->submitted_at?->translatedFormat('d M Y') ?? '—' }}</div>
                <div><div class="muted">Anggaran Selesai</div>{{ $application->estimated_completion_at?->translatedFormat('d M Y') ?? '—' }}</div>
            </div>
        </div>

        <div class="mt-4">
            <x-smart-tracker :application="$application" />
        </div>

        <div class="card mt-4" style="background: var(--accent-bg);">
            <strong>Akses penuh?</strong>
            <p class="mb-0" style="font-size: 13.5px;">Log masuk sebagai pengguna awam untuk melihat dokumen, audit trail, dan muat turun sijil. <a href="{{ route('login') }}">Log Masuk →</a></p>
        </div>
    @endif
</section>
@endsection
