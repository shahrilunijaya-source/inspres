@extends('layouts.public')

@section('content')
<section class="container" style="padding: 32px 24px;">
    <a href="{{ route('applications.index') }}" class="btn-ghost">← Kembali ke Permohonan Saya</a>
    <div class="flex justify-between items-center mt-3 mb-4">
        <div>
            <h2 class="mb-0">{{ $application->moduleLabel() }}</h2>
            <div class="muted">No. Permohonan: <strong>{{ $application->app_no }}</strong></div>
        </div>
        <div class="flex gap-2">
            <x-priority-badge :level="$application->priority_level" />
            <x-sla-badge :application="$application" />
        </div>
    </div>

    <div class="row row-2">
        <div>
            <x-smart-tracker :application="$application" />

            @if ($application->certificate)
                <div class="card mt-4">
                    <h3 class="mt-0">Sijil Dikeluarkan</h3>
                    <div class="muted">No. Sijil: <strong>{{ $application->certificate->cert_no }}</strong></div>
                    <div class="muted mb-3">Dikeluarkan: {{ $application->certificate->issued_at->translatedFormat('d M Y') }}</div>
                    <a href="{{ route('certificate.verify', $application->certificate->cert_no) }}" target="_blank" class="btn btn-primary">Sahkan Sijil (QR)</a>
                </div>
            @endif
        </div>

        <div>
            {{-- 10A.8 audit timeline --}}
            <div class="card">
                <h3 class="mt-0">Audit Trail</h3>
                <p class="muted" style="font-size: 12px;">Simulasi audit kekal — direkod dalam pangkalan data.</p>
                <div style="position: relative; padding-left: 20px; border-left: 2px solid var(--border); margin-top: 16px;">
                    @forelse ($application->auditLogs as $log)
                        <div style="margin-bottom: 16px; position: relative;">
                            <div style="position: absolute; left: -27px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: var(--accent);"></div>
                            <div style="font-size: 11px; color: var(--slate);">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</div>
                            <div style="font-weight: 600; font-size: 14px;">{{ str_replace('_', ' ', ucfirst($log->action)) }}</div>
                            <div class="muted" style="font-size: 12px;">{{ $log->user_label }}</div>
                            @if ($log->status_before || $log->status_after)
                                <div class="muted" style="font-size: 12px;">{{ $log->status_before ?: '—' }} → {{ $log->status_after ?: '—' }}</div>
                            @endif
                            @if ($log->remarks)<div style="font-size: 12px;">{{ $log->remarks }}</div>@endif
                        </div>
                    @empty
                        <div class="muted">Tiada log lagi.</div>
                    @endforelse
                </div>
            </div>

            <div class="card mt-4">
                <h3 class="mt-0">Dokumen</h3>
                @forelse ($application->documents as $doc)
                    <div class="flex justify-between items-center" style="padding: 8px 0; border-bottom: 1px solid var(--border);">
                        <div><strong>{{ $doc->label }}</strong><div class="muted" style="font-size: 12px;">{{ $doc->file_name ?? '—' }}</div></div>
                        @if ($doc->verified)<span class="badge badge-green">✓ Disahkan</span>@else<span class="badge badge-amber">Menunggu</span>@endif
                    </div>
                @empty
                    <div class="muted">Tiada dokumen.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
