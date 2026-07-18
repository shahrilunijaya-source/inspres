<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($devices = $this->getDevices())
    @php($branches = $this->getBranches())
    @php($total_units = collect($devices)->sum('units'))
    @php($total_online = collect($devices)->sum('online'))
    @php($uptime = round($total_online * 100 / $total_units, 1))

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Jenis Perkakasan</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">{{ count($devices) }}</div>
            <div class="muted" style="font-size:11px;">APPENDIX C tender</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Unit Online</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ number_format($total_online) }}</div>
            <div class="muted" style="font-size:11px;">dari {{ number_format($total_units) }} unit</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Uptime</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ $uptime }}%</div>
            <div class="muted" style="font-size:11px;">24 jam terakhir</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Waranti</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">5 tahun</div>
            <div class="muted" style="font-size:11px;">on-site SLA 4 jam</div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0" style="font-size:14px;">Inventori Perkakasan</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;margin-top:14px;">
            @foreach($devices as $dev)
                @php($offline = $dev['units'] - $dev['online'])
                @php($up = round($dev['online']*100/$dev['units'], 1))
                @php($tone = $up >= 99 ? 'green' : ($up >= 95 ? 'amber' : 'red'))
                @php($dot = $tone === 'green' ? '#16a34a' : ($tone === 'amber' ? '#d97706' : '#dc2626'))
                <div style="border:1px solid var(--border);border-radius:10px;padding:14px;background:#fff;position:relative;">
                    <div style="position:absolute;top:10px;right:10px;width:10px;height:10px;border-radius:50%;background:{{ $dot }};box-shadow:0 0 8px {{ $dot }};"></div>
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <div style="width:42px;height:42px;background:var(--grey-bg);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:22px;">{{ $dev['icon'] }}</div>
                        <div style="flex:1;">
                            <div style="font-weight:700;font-size:13px;color:#0b1e3f;line-height:1.2;">{{ $dev['name'] }}</div>
                            <div class="muted" style="font-size:10px;margin-top:2px;">{{ $dev['model'] }}</div>
                        </div>
                    </div>
                    <div style="background:#f8fafc;border-radius:6px;padding:8px 10px;margin-top:8px;">
                        <div style="display:flex;justify-content:space-between;font-size:11px;font-family:monospace;">
                            <span class="muted">Piawaian</span>
                            <span style="font-weight:600;">{{ $dev['std'] }}</span>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:10px;padding-top:8px;border-top:1px dashed var(--border);">
                        <div>
                            <div class="muted" style="font-size:10px;">Unit</div>
                            <div style="font-weight:700;">{{ $dev['online'] }} / {{ $dev['units'] }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="muted" style="font-size:10px;">Uptime</div>
                            <span class="badge badge-{{ $tone }}">{{ $up }}%</span>
                        </div>
                    </div>
                    @if($offline > 0)
                        <div style="margin-top:8px;font-size:11px;color:#dc2626;font-weight:600;">⚠ {{ $offline }} unit offline</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-6" style="padding:0;overflow:hidden;">
        <div style="padding:14px 22px;border-bottom:1px solid var(--border);">
            <h3 class="mt-0 mb-0" style="font-size:15px;">Cawangan JPN · Status Kaunter</h3>
        </div>
        <table class="tbl">
            <thead><tr><th>Cawangan</th><th>Kaunter</th><th>Online</th><th>Uptime</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($branches as $b)
                @php($up = round($b['online']*100/$b['kaunter'], 1))
                <tr>
                    <td style="font-weight:600;">{{ $b['name'] }}</td>
                    <td>{{ $b['kaunter'] }}</td>
                    <td><strong>{{ $b['online'] }}</strong></td>
                    <td>{{ $up }}%</td>
                    <td><span class="badge badge-{{ $b['tone'] }}">{{ $b['tone'] === 'green' ? '● PENUH OPS' : '● ADA ISU' }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi APPENDIX C · Waranti 5 Tahun</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Tender INPReS LAMPIRAN A Para 2.2 mewajibkan 9 jenis perkakasan biometrik dan kaunter dengan piawaian ISO/IEC 19794 (data interchange) + ISO/IEC 30107 PAD (anti-spoofing). Waranti 5 tahun + SLA on-site 4 jam (Klang Valley) / 8 jam (luar) untuk pastikan kelangsungan operasi.</p>
    </div>
</x-filament-panels::page>
