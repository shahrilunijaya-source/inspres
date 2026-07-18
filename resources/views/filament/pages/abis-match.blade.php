<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($s = $this->getStats())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Rekod Biometrik</div>
            <div style="font-size:26px;font-weight:700;color:var(--accent);">{{ $s['records'] }}</div>
            <div class="muted" style="font-size:11px;">10 cap jari + muka + iris</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Padanan Terakhir</div>
            <div style="font-size:26px;font-weight:700;color:#15803d;">{{ number_format($s['last_match_ms']/1000, 2) }}s</div>
            <div class="muted" style="font-size:11px;">SLA: < {{ $s['sla_ms']/1000 }}s</div>
        </div>
        <div class="card" style="border-left:4px solid #6366f1;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">GPU Aktif</div>
            <div style="font-size:14px;font-weight:700;color:#4f46e5;line-height:1.3;margin-top:4px;">{{ $s['gpu'] }}</div>
            <div class="muted" style="font-size:11px;">Engine: {{ $s['engine'] }}</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Padanan Hari Ini</div>
            <div style="font-size:26px;font-weight:700;color:#0b1e3f;">{{ number_format($s['today_matches']) }}</div>
            <div class="muted" style="font-size:11px;"><span style="color:#dc2626;font-weight:600;">{{ $s['today_dupes'] }} pendua</span> dikesan</div>
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Padanan Terkini · Log Masa Nyata</h3>
                <span class="badge badge-green">● Live</span>
            </div>
            <table class="tbl">
                <thead><tr><th>Masa</th><th>Subjek</th><th>Skor</th><th>Tempoh</th><th>Keputusan</th></tr></thead>
                <tbody>
                @foreach($s['recent'] as $r)
                    <tr>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['ts'] }}</td>
                        <td>{{ $r['subj'] }}</td>
                        <td><strong>{{ number_format($r['score'], 2) }}%</strong></td>
                        <td>{{ number_format($r['time'], 2) }}s</td>
                        <td><span class="badge badge-{{ $r['tone'] }}">{{ $r['result'] }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Pelan Padanan</h3>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach([['Capture Biometrik','#22c55e','1.2s'],['Quality Check ISO 19794','#22c55e','0.3s'],['Liveness PAD 30107','#22c55e','0.4s'],['ABIS 1:N (GPU H200)','#3b82f6','3.2s'],['Score Fusion (Face+Finger)','#22c55e','0.1s'],['Audit Submit HL Fabric','#a855f7','0.6s']] as $step)
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ $step[1] }};"></span>
                        <span style="flex:1;font-size:13px;">{{ $step[0] }}</span>
                        <span class="muted" style="font-size:11px;font-family:monospace;">{{ $step[2] }}</span>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:14px;padding-top:14px;border-top:1px dashed var(--border);">
                <div class="muted" style="font-size:11px;text-transform:uppercase;">Piawaian</div>
                <div style="font-size:12px;margin-top:4px;">ISO/IEC 19794 · ISO/IEC 30107 PAD · NIST MINEX</div>
            </div>
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.2 (Modul 04 ms.55)</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">ABIS 1:N matching wajib bagi <strong>setiap</strong> permohonan MyKad untuk halang pendua identiti. CPU ambil ~5 minit untuk banding 30M rekod; GPU NVIDIA H200 dengan tensor cores ambil < 5 saat. Sokong 30 juta rekod biometrik dengan kelajuan SLA dijamin.</p>
    </div>
</x-filament-panels::page>
