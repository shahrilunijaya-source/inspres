<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">

    <div class="row" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
        <div class="card">
            <h3 class="mt-0" style="font-size:14px;display:flex;justify-content:space-between;">
                <span>10 Cap Jari · ISO/IEC 19794-2</span>
                <span class="badge badge-green">● Pengimbas Sambung</span>
            </h3>

            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-top:12px;">
                @foreach(['Ibu Jari','Telunjuk','Hantar','Manis','Kelingking'] as $i => $f)
                    @php($q = [97,99,95,92,88][$i])
                    <div style="text-align:center;">
                        <div style="aspect-ratio:1;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border:2px solid #3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:36px;">🫆</div>
                        <div style="font-size:11px;font-weight:600;margin-top:4px;">Kanan {{ $f }}</div>
                        <div class="badge badge-{{ $q > 90 ? 'green' : 'amber' }}" style="font-size:10px;">Q: {{ $q }}</div>
                    </div>
                @endforeach
                @foreach(['Ibu Jari','Telunjuk','Hantar','Manis','Kelingking'] as $i => $f)
                    @php($q = [96,98,94,90,87][$i])
                    <div style="text-align:center;">
                        <div style="aspect-ratio:1;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border:2px solid #3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:36px;">🫆</div>
                        <div style="font-size:11px;font-weight:600;margin-top:4px;">Kiri {{ $f }}</div>
                        <div class="badge badge-{{ $q > 90 ? 'green' : 'amber' }}" style="font-size:10px;">Q: {{ $q }}</div>
                    </div>
                @endforeach
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:18px;">
                <div style="border:1px solid var(--border);border-radius:10px;padding:14px;">
                    <div class="muted" style="font-size:11px;text-transform:uppercase;">Tangkapan Muka</div>
                    <div style="aspect-ratio:1;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:8px;margin:8px 0;display:flex;align-items:center;justify-content:center;font-size:64px;">👤</div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;">
                        <span>Liveness PAD</span><span class="badge badge-green">PASS</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;margin-top:4px;">
                        <span>Quality NFIQ</span><span class="badge badge-green">96</span>
                    </div>
                </div>
                <div style="border:1px solid var(--border);border-radius:10px;padding:14px;">
                    <div class="muted" style="font-size:11px;text-transform:uppercase;">Imbasan Iris</div>
                    <div style="aspect-ratio:1;background:radial-gradient(circle,#0b1e3f 0%,#1e3a8a 40%,#000 100%);border-radius:8px;margin:8px 0;display:flex;align-items:center;justify-content:center;font-size:64px;">👁️</div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;">
                        <span>Mata Kiri</span><span class="badge badge-green">512 byte</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;margin-top:4px;">
                        <span>Mata Kanan</span><span class="badge badge-green">512 byte</span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <h3 class="mt-0" style="font-size:14px;">Sesi Aktif</h3>
                <table class="tbl" style="font-size:12px;">
                    <tr><td class="muted">No. Kaunter</td><td><strong>K-04 Putrajaya</strong></td></tr>
                    <tr><td class="muted">Pegawai</td><td>Pn. Faridah · OFC-2031</td></tr>
                    <tr><td class="muted">Subjek</td><td>Encik Arjun</td></tr>
                    <tr><td class="muted">Permohonan</td><td>MyKad Gantian Rosak</td></tr>
                    <tr><td class="muted">Mula</td><td>20:38:11</td></tr>
                    <tr><td class="muted">Tempoh</td><td><strong>2 min 47s</strong></td></tr>
                </table>
            </div>

            <div class="card mt-6">
                <h3 class="mt-0" style="font-size:14px;">Status Perkakasan</h3>
                @foreach([['Pengimbas 10 Cap Jari','Suprema RealScan-G10','green'],['Kamera Muka','Logitech Brio 500','green'],['Pengimbas Iris','IriShield MK2120UL','green'],['Pembaca MyKad','HID Omnikey 3121','green']] as $d)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:12px;">
                        <div>
                            <div><strong>{{ $d[0] }}</strong></div>
                            <div class="muted" style="font-size:10px;">{{ $d[1] }}</div>
                        </div>
                        <span class="badge badge-{{ $d[2] }}">● Aktif</span>
                    </div>
                @endforeach
            </div>

            <div class="card mt-6" style="background:#ecfdf5;border:1px solid #22c55e;">
                <div style="font-weight:700;color:#15803d;margin-bottom:4px;">Sedia untuk ABIS 1:N</div>
                <div style="font-size:12px;color:var(--slate);">Semua sampel lulus quality check. Klik untuk hantar ke ABIS engine.</div>
                <button style="margin-top:10px;width:100%;background:#0b1e3f;color:#fff;border:0;padding:10px;border-radius:8px;font-weight:600;cursor:pointer;">Hantar ke ABIS →</button>
            </div>
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.1(viii) + Perkakasan APPENDIX C</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">9 perkakasan biometrik wajib dengan waranti 5 tahun. ISO/IEC 19794 (data interchange) + ISO/IEC 30107 PAD (anti-spoofing). Sokong Modul Kelahiran (ibu bapa), Modul MyKad (semua permohonan), Modul Kewarganegaraan, Modul Anak Angkat.</p>
    </div>
</x-filament-panels::page>
