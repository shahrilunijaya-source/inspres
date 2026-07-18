<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Broker Aktif</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">3 / 3</div>
            <div class="muted" style="font-size:11px;">RF=3 · ISR=3</div>
        </div>
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Throughput</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">4,821</div>
            <div class="muted" style="font-size:11px;">msg/saat</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Consumer Lag</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">14</div>
            <div class="muted" style="font-size:11px;">msg tertunggak</div>
        </div>
        <div class="card" style="border-left:4px solid #6366f1;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Schema Registry</div>
            <div style="font-size:14px;font-weight:600;line-height:1.4;margin-top:4px;">Confluent Avro v7.4</div>
            <div class="muted" style="font-size:11px;">backward-compatible</div>
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Topic Aktif</h3>
            </div>
            <table class="tbl">
                <thead><tr><th>Topic</th><th>Part</th><th>Sub</th><th>Lag</th><th>Rate</th></tr></thead>
                <tbody>
                @foreach($d['topics'] as $t)
                    <tr>
                        <td style="font-family:monospace;font-size:11px;font-weight:600;">{{ $t['name'] }}</td>
                        <td style="font-size:12px;">{{ $t['partitions'] }}</td>
                        <td style="font-size:12px;">{{ $t['consumers'] }}</td>
                        <td><span class="badge badge-{{ $t['lag'] === 0 ? 'green' : 'amber' }}">{{ $t['lag'] }}</span></td>
                        <td style="font-size:11px;font-family:monospace;">{{ $t['rate'] }}/s</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Stream Langsung</h3>
                <span class="badge badge-green">● Tailing</span>
            </div>
            <div style="background:#0b1e3f;color:#a5f3fc;padding:14px;font-family:monospace;font-size:10.5px;max-height:340px;overflow-y:auto;line-height:1.6;">
                @foreach($d['stream'] as $e)
                    <div style="margin-bottom:8px;border-left:2px solid #3b82f6;padding-left:8px;">
                        <span style="color:#94a3b8;">{{ $e['ts'] }}</span>
                        <span style="color:#fde047;"> {{ $e['topic'] }}</span>
                        <span style="color:#86efac;"> key={{ $e['key'] }}</span>
                        <div style="color:#cbd5e1;font-size:10px;margin-top:2px;">{{ $e['payload'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mt-6" style="padding:0;overflow:hidden;">
        <div style="padding:14px 22px;border-bottom:1px solid var(--border);">
            <h3 class="mt-0 mb-0" style="font-size:15px;">Consumer Groups Berlangganan</h3>
        </div>
        <table class="tbl">
            <thead><tr><th>Consumer Group</th><th>Topic</th><th>Lag</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($d['consumers'] as $c)
                <tr>
                    <td style="font-family:monospace;font-size:12px;font-weight:600;">{{ $c['group'] }}</td>
                    <td style="font-family:monospace;font-size:11px;">{{ $c['topic'] }}</td>
                    <td><span class="badge badge-{{ $c['lag'] === 0 ? 'green' : 'amber' }}">{{ $c['lag'] }}</span></td>
                    <td><span class="badge badge-green">RUNNING</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi · Reka Bentuk Event-Driven</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Kelahiran cetuskan tindakan di modul lain (MyKid auto-sedia, Modul Kutipan, Modul Pendidikan). Apache Kafka event-driven memastikan semua 9 modul dalaman + agensi pelanggan dikemas kini serentak tanpa coupling ketat. Schema Registry mengelak breaking change antara modul.</p>
    </div>
</x-filament-panels::page>
