<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($agencies = $this->getAgencies())
    @php($live = collect($agencies)->where('status','live')->count())
    @php($degraded = collect($agencies)->where('status','degraded')->count())
    @php($total_calls = collect($agencies)->sum('today_calls'))
    @php($avg_success = round(collect($agencies)->avg('success'), 2))

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Agensi Aktif</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ $live }}/{{ count($agencies) }}</div>
            <div class="muted" style="font-size:11px;">+ 74 via MAMPU MyGDX</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Degraded</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">{{ $degraded }}</div>
            <div class="muted" style="font-size:11px;">latency > 500ms</div>
        </div>
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Panggilan Hari Ini</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">{{ number_format($total_calls) }}</div>
            <div class="muted" style="font-size:11px;">API rentas agensi</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Kadar Kejayaan</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ $avg_success }}%</div>
            <div class="muted" style="font-size:11px;">purata 24 jam</div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0" style="font-size:14px;">Topologi Integrasi</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-top:14px;">
            @foreach($agencies as $a)
                @php($tone = $a['status'] === 'live' ? 'green' : 'amber')
                @php($dot = $a['status'] === 'live' ? '#16a34a' : '#d97706')
                <div style="border:1px solid var(--border);border-radius:10px;padding:14px;position:relative;background:#fff;">
                    <div style="position:absolute;top:10px;right:10px;width:8px;height:8px;border-radius:50%;background:{{ $dot }};box-shadow:0 0 8px {{ $dot }};"></div>
                    <div style="font-family:monospace;font-size:11px;color:var(--slate);font-weight:600;">{{ $a['code'] }}</div>
                    <div style="font-weight:700;font-size:13px;margin-top:2px;color:#0b1e3f;">{{ $a['name'] }}</div>
                    <div class="muted" style="font-size:11px;margin-top:4px;line-height:1.4;">{{ $a['usage'] }}</div>
                    <div style="display:flex;justify-content:space-between;margin-top:10px;padding-top:8px;border-top:1px dashed var(--border);font-size:11px;">
                        <span class="muted">{{ $a['latency'] }}ms</span>
                        <span style="color:#15803d;font-weight:600;">{{ $a['success'] }}%</span>
                    </div>
                    <div class="muted" style="font-size:10px;margin-top:4px;">{{ number_format($a['today_calls']) }} panggilan hari ini</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Lapisan Keselamatan</h3>
            @foreach([['mTLS Mutual TLS','Sijil X.509 setiap agensi','green'],['OAuth 2.0 Client Credentials','Token rotation 1 jam','green'],['IP Allowlist','Hanya julat MyGov','green'],['Rate Limiting','1000 req/min per agensi','green'],['Request Signing HMAC-SHA256','Audit non-repudiation','green']] as $sec)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-weight:600;font-size:13px;">{{ $sec[0] }}</div>
                        <div class="muted" style="font-size:11px;">{{ $sec[1] }}</div>
                    </div>
                    <span class="badge badge-{{ $sec[2] }}">● ON</span>
                </div>
            @endforeach
        </div>
        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Kanal Mesej Dalaman</h3>
            @foreach([['Apache Kafka Cluster','3 broker · 6 topic','green','4821 msg/s'],['Kong API Gateway','24 upstream service','green','12.4k req/s'],['Keycloak Auth','SSO + 2FA + WebAuthn','green','312 active sesi'],['Redis Cache Cluster','Token + session store','green','45MB/s'],['MAMPU MyGDX Bus','Federated 74 agensi','green','—']] as $svc)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-weight:600;font-size:13px;">{{ $svc[0] }}</div>
                        <div class="muted" style="font-size:11px;">{{ $svc[1] }}</div>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge badge-{{ $svc[2] }}">● Live</span>
                        <div class="muted" style="font-size:10px;margin-top:2px;">{{ $svc[3] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.2 (Integrasi rentas modul)</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">13 agensi luar wajib disambung mengikut tender INPReS. MyGDX (MAMPU Government Data Exchange) sebagai backbone tambahan menyambung 74 agensi tanpa point-to-point. Semua trafik melalui OAuth 2.0 + mTLS untuk pematuhan PDPA 2010 dan Garis Panduan Keselamatan ICT Sektor Awam.</p>
    </div>
</x-filament-panels::page>
