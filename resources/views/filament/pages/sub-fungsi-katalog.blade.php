<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($modules = $this->getModules())

    @php($all = collect($modules)->flatMap(fn($m) => collect($m['sections'])->flatMap(fn($s) => $s)))
    @php($active = $all->where(1, 'active')->count())
    @php($partial = $all->where(1, 'partial')->count())
    @php($scope = $all->where(1, 'scope')->count())
    @php($total = $all->count())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Jumlah Sub-Fungsi</div>
            <div style="font-size:28px;font-weight:700;color:var(--accent);">{{ $total }}</div>
            <div class="muted" style="font-size:11px;">3 modul LAMPIRAN A</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Aktif</div>
            <div style="font-size:28px;font-weight:700;color:#15803d;">{{ $active }}</div>
            <div class="muted" style="font-size:11px;">{{ round($active*100/$total) }}% siap</div>
        </div>
        <div class="card" style="border-left:4px solid var(--amber);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Separa</div>
            <div style="font-size:28px;font-weight:700;color:#d97706;">{{ $partial }}</div>
            <div class="muted" style="font-size:11px;">{{ round($partial*100/$total) }}% pembangunan</div>
        </div>
        <div class="card" style="border-left:4px solid #94a3b8;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Dalam Skop</div>
            <div style="font-size:28px;font-weight:700;color:#475569;">{{ $scope }}</div>
            <div class="muted" style="font-size:11px;">{{ round($scope*100/$total) }}% fasa seterusnya</div>
        </div>
    </div>

    @foreach($modules as $modName => $modData)
        <div class="card mt-6" style="padding:0;overflow:hidden;">
            <div style="padding:16px 22px;background:linear-gradient(135deg,#0b1e3f,#1e3a8a);color:#fff;display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:16px;color:#fff;">{{ $modName }}</h3>
                <span style="font-size:11px;opacity:0.85;font-family:monospace;">{{ $modData['akta'] }}</span>
            </div>

            <div style="padding:18px 22px;">
                @foreach($modData['sections'] as $secName => $funcs)
                    <div style="margin-bottom:18px;">
                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--slate);margin-bottom:10px;">{{ $secName }}</div>
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:10px;">
                            @foreach($funcs as $f)
                                @php($tone = match($f[1]) { 'active' => 'green', 'partial' => 'amber', default => 'slate' })
                                @php($border = match($f[1]) { 'active' => '#16a34a', 'partial' => '#d97706', default => '#cbd5e1' })
                                @php($label = match($f[1]) { 'active' => 'AKTIF', 'partial' => 'SEPARA', default => 'AKAN DATANG' })
                                <div style="border:1px solid var(--border);border-left:3px solid {{ $border }};border-radius:8px;padding:10px 12px;background:#fff;">
                                    <div style="display:flex;justify-content:space-between;gap:8px;align-items:flex-start;">
                                        <div style="font-weight:600;font-size:13px;color:#0b1e3f;line-height:1.3;">{{ $f[0] }}</div>
                                        <span class="badge badge-{{ $tone === 'slate' ? 'amber' : $tone }}" style="font-size:9px;opacity:{{ $tone === 'slate' ? '0.55' : '1' }};white-space:nowrap;">{{ $label }}</span>
                                    </div>
                                    <div class="muted" style="font-size:11px;margin-top:4px;line-height:1.4;">{{ $f[2] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.2</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Tender menetapkan 63 sub-fungsi merentasi 3 modul ini (22 + 22 + 19). Setiap sub-fungsi mempunyai justifikasi akta, antara muka pengguna, integrasi modul/agensi, dan log transaksi blockchain. Pelan pelaksanaan berfasa: 31 fungsi AKTIF dalam fasa 1, 18 SEPARA dalam fasa 2, 14 AKAN DATANG dalam fasa 3.</p>
    </div>
</x-filament-panels::page>
