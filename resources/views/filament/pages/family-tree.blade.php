<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Nod Individu</div>
            <div style="font-size:24px;font-weight:700;color:var(--accent);">{{ $d['stats']['records'] }}</div>
            <div class="muted" style="font-size:11px;">setiap warganegara</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Edge Hubungan</div>
            <div style="font-size:24px;font-weight:700;color:#15803d;">{{ $d['stats']['relationships'] }}</div>
            <div class="muted" style="font-size:11px;">ibu/bapa/anak/pasangan</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Query Hari Ini</div>
            <div style="font-size:24px;font-weight:700;color:#d97706;">{{ number_format($d['stats']['queries_today']) }}</div>
            <div class="muted" style="font-size:11px;">dari 6 modul</div>
        </div>
        <div class="card" style="border-left:4px solid #6366f1;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Latency Purata</div>
            <div style="font-size:24px;font-weight:700;color:#4f46e5;">{{ $d['stats']['avg_traverse_ms'] }}ms</div>
            <div class="muted" style="font-size:11px;">Neo4j cluster</div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0" style="font-size:14px;display:flex;justify-content:space-between;">
            <span>Pohon Salasilah · {{ $d['subject'] }}</span>
            <span class="badge badge-amber">3 generasi · 12 nod</span>
        </h3>

        <div style="display:flex;flex-direction:column;align-items:center;gap:24px;padding:30px 0;background:linear-gradient(180deg,#f8fafc,#fff);border-radius:10px;margin-top:12px;">
            {{-- Gen 1: Datuk Nenek --}}
            <div style="display:flex;gap:60px;">
                @foreach([['Hisham bin Othman','♂','Bapa mertua','#3b82f6'],['Zaharah binti Ali','♀','Ibu mertua','#ec4899'],['Salleh bin Ibrahim','♂','Datuk','#3b82f6'],['Rohani binti Yusof','♀','Nenek','#ec4899']] as $g)
                    <div style="text-align:center;">
                        <div style="width:60px;height:60px;border-radius:50%;background:{{ $g[3] }}22;border:2px solid {{ $g[3] }};display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto;">{{ $g[1] }}</div>
                        <div style="font-size:11px;font-weight:600;margin-top:4px;">{{ $g[0] }}</div>
                        <div class="muted" style="font-size:10px;">{{ $g[2] }}</div>
                    </div>
                @endforeach
            </div>

            <div style="color:#cbd5e1;font-size:12px;">│ │ │ │</div>

            {{-- Gen 2: Bapa, Ibu --}}
            <div style="display:flex;gap:140px;">
                <div style="text-align:center;">
                    <div style="width:64px;height:64px;border-radius:50%;background:#1e3a8a22;border:3px solid #1e3a8a;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto;">♂</div>
                    <div style="font-size:11px;font-weight:600;margin-top:4px;">Hisham bin Othman</div>
                    <div class="muted" style="font-size:10px;">Bapa</div>
                </div>
                <div style="text-align:center;">
                    <div style="width:64px;height:64px;border-radius:50%;background:#be185d22;border:3px solid #be185d;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto;">♀</div>
                    <div style="font-size:11px;font-weight:600;margin-top:4px;">Aishah binti Salleh</div>
                    <div class="muted" style="font-size:10px;">Ibu · arwah 2019</div>
                </div>
            </div>

            <div style="color:#cbd5e1;font-size:12px;">│</div>

            {{-- Gen 3: Subjek + adik beradik --}}
            <div style="display:flex;gap:30px;">
                @foreach([['Aminah binti Hisham','♀','Kakak'],['Ahmad bin Hisham','♂','SUBJEK','active'],['Yusoff bin Hisham','♂','Adik']] as $sib)
                    <div style="text-align:center;">
                        <div style="width:{{ ($sib[3] ?? '') === 'active' ? '72px' : '56px' }};height:{{ ($sib[3] ?? '') === 'active' ? '72px' : '56px' }};border-radius:50%;background:{{ ($sib[3] ?? '') === 'active' ? '#fef3c7' : '#f1f5f9' }};border:{{ ($sib[3] ?? '') === 'active' ? '4px solid #d97706' : '2px solid #cbd5e1' }};display:flex;align-items:center;justify-content:center;font-size:{{ ($sib[3] ?? '') === 'active' ? '32px' : '22px' }};margin:0 auto;">{{ $sib[1] }}</div>
                        <div style="font-size:{{ ($sib[3] ?? '') === 'active' ? '12' : '11' }}px;font-weight:{{ ($sib[3] ?? '') === 'active' ? '700' : '600' }};margin-top:4px;">{{ $sib[0] }}</div>
                        <div class="muted" style="font-size:10px;color:{{ ($sib[3] ?? '') === 'active' ? '#d97706' : '' }};">{{ $sib[2] }}</div>
                    </div>
                @endforeach
            </div>

            <div style="color:#cbd5e1;font-size:12px;">═══ kahwin 2018 ═══</div>

            <div style="text-align:center;">
                <div style="width:60px;height:60px;border-radius:50%;background:#be185d22;border:3px solid #be185d;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto;">♀</div>
                <div style="font-size:11px;font-weight:600;margin-top:4px;">Faridah binti Salleh</div>
                <div class="muted" style="font-size:10px;">Isteri · sah</div>
            </div>

            <div style="color:#cbd5e1;font-size:12px;">│ │</div>

            <div style="display:flex;gap:30px;">
                <div style="text-align:center;">
                    <div style="width:48px;height:48px;border-radius:50%;background:#dcfce7;border:2px solid #16a34a;display:flex;align-items:center;justify-content:center;font-size:18px;margin:0 auto;">♂</div>
                    <div style="font-size:10px;font-weight:600;margin-top:4px;">Adam bin Ahmad</div>
                    <div class="muted" style="font-size:9px;">Anak · 6 thn</div>
                </div>
                <div style="text-align:center;">
                    <div style="width:48px;height:48px;border-radius:50%;background:#fce7f3;border:2px solid #ec4899;display:flex;align-items:center;justify-content:center;font-size:18px;margin:0 auto;">♀</div>
                    <div style="font-size:10px;font-weight:600;margin-top:4px;">Hana binti Ahmad</div>
                    <div class="muted" style="font-size:9px;">Anak · 3 thn</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0" style="font-size:14px;">Modul Pengguna Family Tree</h3>
        <table class="tbl">
            <thead><tr><th>Modul · Use Case</th><th>Tujuan</th></tr></thead>
            <tbody>
            @foreach($d['usage'] as $u)
                <tr><td style="font-weight:600;">{{ $u[0] }}</td><td class="muted">{{ $u[1] }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi · Graph Database</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Hubungan keluarga adalah masalah graf, bukan jadual. Neo4j cluster sokong query traversal "siapa adik-beradik subjek?", "siapa ahli waris terdekat?", "ada hubungan darah dengan bakal pasangan?" dalam <100ms walaupun pohon ada 6+ generasi. SQL biasa tidak praktikal untuk traversal mendalam.</p>
    </div>
</x-filament-panels::page>
