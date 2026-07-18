<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($couples = $this->getCouples())
    @php($active = collect($couples)->where('status', '!=', 'tamat')->count())
    @php($urgent = collect($couples)->where('days_left', '<=', 7)->where('status', '!=', 'tamat')->count())
    @php($objections = collect($couples)->sum('objections'))

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Kaveat Aktif</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">{{ $active }}</div>
            <div class="muted" style="font-size:11px;">dalam tempoh 21 hari</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Hampir Tamat</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">{{ $urgent }}</div>
            <div class="muted" style="font-size:11px;">≤ 7 hari lagi</div>
        </div>
        <div class="card" style="border-left:4px solid #dc2626;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Bantahan</div>
            <div style="font-size:28px;font-weight:700;color:#dc2626;">{{ $objections }}</div>
            <div class="muted" style="font-size:11px;">perlu siasat</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Tamat Bulan Ini</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">23</div>
            <div class="muted" style="font-size:11px;">sedia untuk upacara</div>
        </div>
    </div>

    <div class="card mt-6" style="padding:0;overflow:hidden;">
        <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;">
            <h3 class="mt-0 mb-0" style="font-size:15px;">Senarai Kaveat · Tempoh 21 Hari Akta 164 S.22</h3>
            <span class="badge badge-amber">Auto-iklan: gazet kerajaan + portal awam</span>
        </div>
        <table class="tbl">
            <thead><tr><th>Rujukan</th><th>Bakal Suami</th><th>Bakal Isteri</th><th>Difailkan</th><th>Tamat</th><th>Tempoh</th><th>Bantahan</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($couples as $c)
                <tr>
                    <td style="font-family:monospace;font-size:11px;"><strong>{{ $c['ref'] }}</strong></td>
                    <td>{{ $c['groom'] }}</td>
                    <td>{{ $c['bride'] }}</td>
                    <td style="font-size:12px;">{{ $c['lodged'] }}</td>
                    <td style="font-size:12px;">{{ $c['expires'] }}</td>
                    <td>
                        @if(($c['status'] ?? '') === 'tamat')
                            <span class="badge badge-green">TAMAT · sedia upacara</span>
                        @else
                            <span class="badge badge-{{ $c['tone'] }}">{{ $c['days_left'] }} hari lagi</span>
                        @endif
                    </td>
                    <td>
                        @if($c['objections'] > 0)
                            <span class="badge badge-red">{{ $c['objections'] }} bantahan</span>
                        @else
                            <span class="badge badge-green">Bersih</span>
                        @endif
                    </td>
                    <td>
                        @if(($c['status'] ?? '') === 'tamat')
                            <span style="font-size:11px;color:#15803d;font-weight:600;">→ Tetapkan tarikh upacara</span>
                        @elseif($c['objections'] > 0)
                            <span style="font-size:11px;color:#dc2626;font-weight:600;">→ Buka siasatan</span>
                        @else
                            <span style="font-size:11px;color:var(--slate);">Menunggu tempoh tamat</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Saluran Pengiklanan Aktif</h3>
            @foreach([['Portal Awam JPN','jpn.gov.my/kaveat','green'],['e-Gazet Kerajaan Persekutuan','gazet.gov.my','green'],['Notis Papan Kenyataan JPN','21 cawangan','green'],['Akhbar Berita Harian (S.22 wajib)','5 keluaran/minggu','amber']] as $ch)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-weight:600;font-size:13px;">{{ $ch[0] }}</div>
                        <div class="muted" style="font-size:11px;">{{ $ch[1] }}</div>
                    </div>
                    <span class="badge badge-{{ $ch[2] }}">● Aktif</span>
                </div>
            @endforeach
        </div>
        <div class="card">
            <h3 class="mt-0" style="font-size:14px;">Semakan Auto Bersilang</h3>
            @foreach([['Family Tree · Hubungan Darah','Cek adik beradik / sedarah','green'],['Perkahwinan Sedia Ada · Modul Family Tree','Cek poligami tanpa kebenaran','green'],['Umur Minimum · Akta 164 S.10','Lelaki 18, Perempuan 16','green'],['Senarai Hitam JPN','Cek sekatan permohonan','green']] as $chk)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-weight:600;font-size:13px;">{{ $chk[0] }}</div>
                        <div class="muted" style="font-size:11px;">{{ $chk[1] }}</div>
                    </div>
                    <span class="badge badge-{{ $chk[2] }}">PASS</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.2 (Modul 05 ms.65)</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Akta 164 S.22 mewajibkan tempoh kaveat 21 hari untuk pengiklanan rasmi dan elak perkahwinan haram (poligami tanpa kebenaran, di bawah umur, sedarah). Sistem auto-publish ke 4 saluran rasmi + auto-cross-check dengan Family Tree, Senarai Hitam, dan rekod perkahwinan sedia ada.</p>
    </div>
</x-filament-panels::page>
