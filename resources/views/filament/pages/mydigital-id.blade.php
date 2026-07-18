<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Akaun Aktif</div>
            <div style="font-size:24px;font-weight:700;color:var(--accent);">{{ $d['stats']['total_active'] }}</div>
            <div class="muted" style="font-size:11px;">warganegara dewasa</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Provision Hari Ini</div>
            <div style="font-size:24px;font-weight:700;color:#15803d;">{{ number_format($d['stats']['provisioned_today']) }}</div>
            <div class="muted" style="font-size:11px;">auto-create MyKad baru</div>
        </div>
        <div class="card" style="border-left:4px solid #6366f1;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Agensi Tersambung</div>
            <div style="font-size:24px;font-weight:700;color:#4f46e5;">{{ $d['stats']['agencies_linked'] }}</div>
            <div class="muted" style="font-size:11px;">via MAMPU MyGDX</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Masa Provision</div>
            <div style="font-size:24px;font-weight:700;color:#d97706;">{{ $d['stats']['avg_provision_ms'] }}ms</div>
            <div class="muted" style="font-size:11px;">end-to-end purata</div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0" style="font-size:14px;">Aliran Auto-Provision</h3>
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:6px;margin-top:12px;">
            @foreach([['Modul MyKad','Sijil siap','#3b82f6'],['Event Kafka','event.mykad.issued','#6366f1'],['MyDigital ID Service','Receive event','#a855f7'],['Generate Identity','Keycloak account','#ec4899'],['SSO Aktif','74 agensi siap guna','#16a34a']] as $i => $step)
                <div style="background:{{ $step[2] }}15;border:1px solid {{ $step[2] }}55;border-radius:8px;padding:14px 10px;text-align:center;position:relative;">
                    <div style="font-size:11px;font-weight:700;color:{{ $step[2] }};margin-bottom:4px;">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div style="font-size:13px;font-weight:600;color:#0b1e3f;">{{ $step[0] }}</div>
                    <div class="muted" style="font-size:10px;margin-top:4px;">{{ $step[1] }}</div>
                    @if($i < 4)
                        <div style="position:absolute;right:-9px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;z-index:1;">→</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Log Provision Terkini</h3>
                <span class="badge badge-green">● Live</span>
            </div>
            <table class="tbl">
                <thead><tr><th>Masa</th><th>MyKad</th><th>Nama</th><th>Action</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($d['log'] as $l)
                    <tr>
                        <td style="font-family:monospace;font-size:11px;">{{ $l['ts'] }}</td>
                        <td style="font-family:monospace;font-size:11px;">{{ $l['mykad'] }}</td>
                        <td style="font-size:12px;">{{ $l['name'] }}</td>
                        <td><span class="badge badge-amber" style="font-size:9px;">{{ $l['action'] }}</span></td>
                        <td><span class="badge badge-{{ $l['status'] === 'success' ? 'green' : 'amber' }}">{{ strtoupper($l['status']) }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Agensi Pengguna MyDigital ID (Top 8 dari 74)</h3>
            </div>
            <table class="tbl">
                <thead><tr><th>Agensi · Perkhidmatan</th><th>Pengguna</th><th>Aktiviti Terakhir</th></tr></thead>
                <tbody>
                @foreach($d['agencies'] as $a)
                    <tr>
                        <td style="font-weight:600;font-size:12px;">{{ $a['name'] }}</td>
                        <td><strong>{{ $a['users'] }}</strong></td>
                        <td class="muted" style="font-size:11px;">{{ $a['last_used'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi · MyDigital ID Integration</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Setiap MyKad baru auto-create akaun MyDigital ID. Rakyat boleh terus guna untuk 74 perkhidmatan kerajaan online tanpa setup berasingan. MAMPU MyGDX sebagai federation backbone — single sign-on rentas agensi tanpa coupling ketat.</p>
    </div>
</x-filament-panels::page>
