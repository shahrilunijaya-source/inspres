<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())

    <div class="card">
        <h3 class="mt-0" style="font-size:14px;">Pipeline Pengeluaran MyKad</h3>
        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-top:12px;">
            @foreach($d['stages'] as $i => $s)
                @php($colors = ['slate' => ['#f1f5f9','#475569'], 'amber' => ['#fef3c7','#b45309'], 'green' => ['#dcfce7','#15803d']])
                @php($bg = $colors[$s['tone']][0])
                @php($fg = $colors[$s['tone']][1])
                <div style="background:{{ $bg }};border-radius:8px;padding:14px 10px;text-align:center;position:relative;">
                    <div style="font-size:24px;font-weight:700;color:{{ $fg }};">{{ number_format($s['count']) }}</div>
                    <div style="font-size:11px;font-weight:600;color:{{ $fg }};margin-top:4px;">{{ $s['stage'] }}</div>
                    <div class="muted" style="font-size:9px;margin-top:2px;line-height:1.3;">{{ $s['desc'] }}</div>
                    @if($i < count($d['stages']) - 1)
                        <div style="position:absolute;right:-9px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;z-index:1;">→</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Antrian Cetakan Aktif</h3>
                <span class="badge badge-amber">Auto-route by load</span>
            </div>
            <table class="tbl">
                <thead><tr><th>No. Siri</th><th>Pemohon</th><th>Jenis</th><th>Peringkat</th><th>ETA</th><th>Keutamaan</th></tr></thead>
                <tbody>
                @foreach($d['queue'] as $q)
                    <tr>
                        <td style="font-family:monospace;font-size:11px;"><strong>{{ $q['serial'] }}</strong></td>
                        <td>{{ $q['name'] }}</td>
                        <td style="font-size:12px;">{{ $q['type'] }}</td>
                        <td><span class="badge badge-amber">{{ $q['stage'] }}</span></td>
                        <td style="font-family:monospace;font-size:11px;font-weight:600;">{{ $q['eta'] }}</td>
                        <td>
                            @if($q['priority'] === 'urgent')
                                <span class="badge badge-red">SEGERA</span>
                            @elseif($q['priority'] === 'high')
                                <span class="badge badge-amber">TINGGI</span>
                            @else
                                <span class="badge badge-green">Biasa</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Pencetak Kad</h3>
            @foreach($d['printers'] as $p)
                <div style="border:1px solid var(--border);border-radius:8px;padding:10px;margin-bottom:8px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <strong style="font-family:monospace;font-size:12px;">{{ $p['id'] }}</strong>
                        @if($p['status'] === 'printing')
                            <span class="badge badge-green">● Cetak</span>
                        @else
                            <span class="badge badge-amber">○ Idle</span>
                        @endif
                    </div>
                    <div class="muted" style="font-size:11px;margin-top:2px;">{{ $p['model'] }}</div>
                    <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:11px;">
                        <span>Antrian: <strong>{{ $p['queue'] }}</strong></span>
                        <span>Stok: <strong>{{ number_format($p['stock']) }}</strong></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi · Mengapa CLMS Berasingan?</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Card Lifecycle Management System uruskan stok kad kosong, personalisation, key injection PKI, quality control, dan retirement. Kad polikarbonat (bukan PVC) tahan 10+ tahun dan kalis pemalsuan dengan ICAO Doc 9303. Spesialis tersendiri untuk inventory + production line tracking.</p>
    </div>
</x-filament-panels::page>
