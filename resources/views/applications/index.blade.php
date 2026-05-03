@extends('layouts.public')

@section('content')
<section class="container" style="padding: 32px 24px;">
    <h2>Permohonan Saya</h2>
    @if ($applications->isEmpty())
        <div class="card muted">Tiada permohonan lagi.</div>
    @else
        <div class="card" style="padding: 0;">
            <table class="tbl">
                <thead>
                    <tr><th>No. Permohonan</th><th>Modul</th><th>Status</th><th>Keutamaan</th><th>SLA</th><th>Dihantar</th><th></th></tr>
                </thead>
                <tbody>
                @foreach ($applications as $app)
                    <tr>
                        <td><strong>{{ $app->app_no }}</strong></td>
                        <td>{{ $app->moduleLabel() }}</td>
                        <td><span class="badge badge-blue">{{ $app->statusLabel() }}</span></td>
                        <td><x-priority-badge :level="$app->priority_level" /></td>
                        <td><x-sla-badge :application="$app" /></td>
                        <td>{{ $app->submitted_at?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td><a href="{{ route('applications.show', $app) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 13px;">Tracker</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
