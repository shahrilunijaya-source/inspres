@extends('layouts.public')

@php
    $u = auth()->user();
    $total = $applications->count();
    $inProgress = $applications->whereIn('status', ['submitted', 'payment_pending', 'payment_completed', 'doc_review', 'officer_review'])->count();
    $approved = $applications->whereIn('status', ['approved', 'cert_generated', 'completed'])->count();
    $rejected = $applications->where('status', 'rejected')->count();
    $needAttention = $applications->whereIn('sla_status', ['breach_risk', 'breached', 'due_soon'])->count();
@endphp

@section('content')
<section class="container" style="padding: 28px 24px;">

    <div style="margin-bottom: 24px;">
        <h2 style="margin: 0 0 4px;">Selamat datang, {{ \Illuminate\Support\Str::of($u->name)->after(' ')->before(' ')->whenEmpty(fn () => \Illuminate\Support\Str::of($u->name))->toString() }}</h2>
        <div class="muted" style="font-size: 13.5px;">
            {{ now()->translatedFormat('l, d F Y') }}
            <span style="opacity: 0.4; margin: 0 6px;">·</span>
            {{ $u->roleLabel() }}
            @if ($u->nric)
                <span style="opacity: 0.4; margin: 0 6px;">·</span>
                {{ $u->nric }}
            @endif
        </div>
    </div>

    {{-- Stats row --}}
    <div class="dash-stats">
        <div class="dash-stat dash-stat-total">
            <div class="dash-stat-label">Jumlah Permohonan</div>
            <div class="dash-stat-value">{{ $total }}</div>
            <div class="dash-stat-foot">Keseluruhan permohonan</div>
        </div>
        <div class="dash-stat dash-stat-progress">
            <div class="dash-stat-label">Dalam Proses</div>
            <div class="dash-stat-value">{{ $inProgress }}</div>
            <div class="dash-stat-foot">
                @if ($needAttention > 0)
                    <strong style="color: var(--amber);">{{ $needAttention }}</strong> perlu perhatian
                @else
                    Semua mengikut SLA
                @endif
            </div>
        </div>
        <div class="dash-stat dash-stat-approved">
            <div class="dash-stat-label">Diluluskan</div>
            <div class="dash-stat-value">{{ $approved }}</div>
            <div class="dash-stat-foot">Permohonan berjaya</div>
        </div>
        <div class="dash-stat dash-stat-rejected">
            <div class="dash-stat-label">Ditolak</div>
            <div class="dash-stat-value">{{ $rejected }}</div>
            <div class="dash-stat-foot">{{ $rejected > 0 ? 'Perlu pembetulan' : 'Tiada penolakan' }}</div>
        </div>
    </div>

    {{-- Action bar --}}
    <div class="dash-actions">
        <div class="dash-actions-label">Buat permohonan baharu:</div>
        <a href="{{ route('apply.birth') }}" class="btn btn-primary">👶 Daftar Kelahiran</a>
        <a href="{{ route('apply.mykad') }}" class="btn btn-primary">🪪 Mohon MyKad</a>
        <a href="{{ route('apply.marriage') }}" class="btn btn-primary">💍 Daftar Perkahwinan</a>
    </div>

    {{-- Recent applications table --}}
    <div class="card mt-6" style="padding: 0; overflow: hidden;">
        <div class="dash-tbl-head">
            <h3 class="mt-0 mb-0" style="font-size: 16px;">Permohonan Terkini</h3>
            @if ($total > 0)
                <a href="{{ route('applications.index') }}" class="muted" style="font-size: 13px;">{{ min(5, $total) }} daripada {{ $total }} · Lihat semua →</a>
            @endif
        </div>

        @if ($applications->isEmpty())
            <div style="padding: 56px 24px; text-align: center;">
                <div style="font-size: 42px; margin-bottom: 8px;">📋</div>
                <h3 style="margin: 0 0 8px;">Belum ada permohonan</h3>
                <p class="muted" style="margin: 0 0 16px;">Mulakan dengan memilih modul di atas untuk membuat permohonan baharu.</p>
            </div>
        @else
            <table class="tbl">
                <thead>
                    <tr>
                        <th>No. Permohonan</th>
                        <th>Modul</th>
                        <th>Status</th>
                        <th>SLA</th>
                        <th>Tarikh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($applications->take(5) as $app)
                    <tr>
                        <td><span class="dash-app-no">{{ $app->app_no }}</span></td>
                        <td>
                            <strong>{{ $app->moduleLabel() }}</strong>
                            @if ($app->birth)<div class="muted" style="font-size: 12px;">{{ $app->birth->child_name }}</div>@endif
                            @if ($app->mykad)<div class="muted" style="font-size: 12px;">{{ ucfirst(str_replace('_', ' ', $app->mykad->type)) }}</div>@endif
                            @if ($app->marriage)<div class="muted" style="font-size: 12px;">{{ $app->marriage->groom_name }} & {{ $app->marriage->bride_name }}</div>@endif
                        </td>
                        <td>
                            @php
                                $statusTone = match (true) {
                                    in_array($app->status, ['completed','approved','cert_generated']) => 'green',
                                    $app->status === 'rejected' => 'red',
                                    default => 'blue',
                                };
                            @endphp
                            <span class="dash-status dash-status-{{ $statusTone }}">● {{ $app->statusLabel() }}</span>
                        </td>
                        <td><x-sla-badge :application="$app" /></td>
                        <td>{{ $app->submitted_at?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td><a href="{{ route('applications.show', $app) }}" class="dash-action-btn">Semak →</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Lifecycle timeline (compact, below) --}}
    <div class="mt-6">
        <x-lifecycle-timeline :events="$lifecycleEvents" />
    </div>

</section>

<style>
    .dash-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    @media (max-width: 1024px) { .dash-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .dash-stats { grid-template-columns: 1fr; } }

    .dash-stat { background: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 18px 20px; position: relative; overflow: hidden; transition: all 200ms; }
    .dash-stat::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; }
    .dash-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
    .dash-stat-total::before { background: var(--accent); }
    .dash-stat-progress::before { background: var(--amber); }
    .dash-stat-approved::before { background: #16a34a; }
    .dash-stat-rejected::before { background: var(--red); }
    .dash-stat-label { font-size: 11px; font-weight: 700; letter-spacing: 0.6px; color: var(--slate); text-transform: uppercase; margin-bottom: 8px; }
    .dash-stat-value { font-size: 36px; font-weight: 700; line-height: 1; color: var(--navy); }
    .dash-stat-progress .dash-stat-value { color: var(--amber); }
    .dash-stat-approved .dash-stat-value { color: #15803d; }
    .dash-stat-rejected .dash-stat-value { color: var(--red); }
    .dash-stat-foot { font-size: 12px; color: var(--slate); margin-top: 8px; }

    .dash-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-top: 24px; padding: 14px 18px; background: var(--accent-bg); border-radius: 10px; border: 1px dashed rgba(29,78,216,0.25); }
    .dash-actions-label { font-size: 12.5px; font-weight: 600; color: var(--accent); margin-right: 4px; }
    .dash-actions .btn { padding: 8px 14px; font-size: 13px; }

    .dash-tbl-head { display: flex; justify-content: space-between; align-items: center; padding: 16px 22px; border-bottom: 1px solid var(--border); }
    .dash-app-no { display: inline-block; padding: 4px 10px; background: var(--grey-bg); border-radius: 6px; font-family: 'JetBrains Mono', monospace; font-size: 12px; color: var(--navy); font-weight: 600; }

    .dash-status { font-size: 12px; font-weight: 600; }
    .dash-status-green { color: #15803d; }
    .dash-status-blue { color: var(--accent); }
    .dash-status-red { color: var(--red); }

    .dash-action-btn { display: inline-block; padding: 6px 14px; background: #fff; border: 1px solid var(--accent); color: var(--accent); border-radius: 6px; font-size: 12.5px; font-weight: 600; transition: all 150ms; }
    .dash-action-btn:hover { background: var(--accent); color: #fff; text-decoration: none; }
</style>
@endsection
