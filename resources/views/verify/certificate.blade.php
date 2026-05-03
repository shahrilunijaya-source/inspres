@extends('layouts.public')

@section('content')
<section class="container-narrow" style="padding: 48px 24px;">
    <div class="verify-success">
        <div class="check">✓</div>
        <h2 style="color: var(--accent); margin: 0;">Sijil Disahkan</h2>
        <p class="muted">Dokumen ini disahkan dalam persekitaran prototaip INPReS.</p>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0">{{ $cert->typeLabel() }}</h3>
        <table style="width: 100%; font-size: 14px;">
            <tr><td class="muted" style="width: 40%; padding: 6px 0;">No. Sijil</td><td><strong>{{ $cert->cert_no }}</strong></td></tr>
            <tr><td class="muted" style="padding: 6px 0;">No. Permohonan</td><td>{{ $cert->application->app_no }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Modul</td><td>{{ $cert->application->moduleLabel() }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Subjek</td><td>{{ $cert->subject_name }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Tarikh Dikeluarkan</td><td>{{ $cert->issued_at->translatedFormat('d M Y') }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Dikeluarkan Oleh</td><td>{{ $cert->issued_by }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Status Pengesahan</td><td><span class="badge badge-green">{{ ucfirst($cert->verification?->status ?? 'valid') }}</span></td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Disahkan Pada</td><td>{{ now()->translatedFormat('d M Y, H:i') }}</td></tr>
            <tr><td class="muted" style="padding: 6px 0;">Bilangan Pengesahan</td><td>{{ $cert->verification?->verify_count ?? 1 }}</td></tr>
        </table>
    </div>

    <div class="card mt-4" style="background: #fffbeb; border-color: #fcd34d;">
        <strong>Nota:</strong> Pengesahan ini adalah untuk demo prototaip sahaja. Tiada pengesahan sijil kerajaan sebenar dilakukan.
    </div>
</section>
@endsection
