<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())
    @php($connected = collect($d['hospitals'])->where('connected', true)->count())
    @php($today_total = collect($d['hospitals'])->sum('today'))

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Hospital Tersambung</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">{{ $connected }} / {{ count($d['hospitals']) }}</div>
            <div class="muted" style="font-size:11px;">FHIR R4 / HL7</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Kelahiran Hari Ini</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ $today_total }}</div>
            <div class="muted" style="font-size:11px;">pra-daftar masuk</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Menunggu Ibu Bapa</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">42</div>
            <div class="muted" style="font-size:11px;">datang JPN</div>
        </div>
        <div class="card" style="border-left:4px solid #6366f1;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Masa Kaunter</div>
            <div style="font-size:28px;font-weight:700;color:#4f46e5;">10 min</div>
            <div class="muted" style="font-size:11px;">turun dari 30 min</div>
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Notifikasi Pra-Daftar Hospital</h3>
                <span class="badge badge-green">● Auto-pull setiap 30s</span>
            </div>
            <table class="tbl">
                <thead><tr><th>Hospital</th><th>Ibu</th><th>MyKad</th><th>Bayi</th><th>Berat</th><th>Notif</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($d['inbox'] as $r)
                    <tr>
                        <td style="font-size:11px;font-weight:600;">{{ $r['hosp'] }}</td>
                        <td>{{ $r['mom'] }}</td>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['mom_nric'] }}</td>
                        <td><span class="badge badge-amber">{{ $r['baby_sex'] }}</span></td>
                        <td style="font-size:12px;">{{ $r['baby_weight'] }}</td>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['ts'] }}</td>
                        <td><span class="badge badge-{{ $r['tone'] }}">{{ strtoupper(str_replace('_',' ', $r['status'])) }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Hospital Sambungan</h3>
            @foreach($d['hospitals'] as $h)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:12px;">
                    <div>
                        <div style="font-weight:600;">{{ $h['name'] }}</div>
                        <div class="muted" style="font-size:10px;">{{ $h['today'] }} kelahiran hari ini</div>
                    </div>
                    <span class="badge badge-{{ $h['connected'] ? 'green' : 'red' }}">{{ $h['connected'] ? '● Live' : '● Down' }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi · Mengapa Integrasi KKM Paling Kritikal?</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">99% kelahiran di hospital KKM. Integrasi FHIR R4 membolehkan pertukaran data klinikal automatik (berat, jantina, hospital, masa lahir, doktor penyambut) mengurangkan ralat dan menjimatkan masa ibu bapa di kaunter JPN dari 30 minit ke 10 minit. Rakyat datang hanya untuk biometrik dan ambil sijil.</p>
    </div>
</x-filament-panels::page>
