<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">

    @php($stats = $this->getStats())
    @php($modules = $this->getModules())

    <div class="row row-4 mt-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <div class="card" style="border-left: 4px solid var(--accent);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Total Permohonan</div>
            <div style="font-size: 28px; font-weight: 700;">{{ $stats['total'] }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #16a34a;">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">SLA On Track</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--accent);">{{ $stats['on_track'] }}</div>
        </div>
        <div class="card" style="border-left: 4px solid var(--amber);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Risiko / Due Soon</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--amber);">{{ $stats['breach_risk'] }}</div>
        </div>
        <div class="card" style="border-left: 4px solid var(--red);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Breached</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--red);">{{ $stats['breached'] }}</div>
        </div>
    </div>

    <div class="card mt-6">
        <h3 class="mt-0">Permohonan Mengikut Modul</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            @foreach ($stats['by_module'] as $module => $total)
                <div style="background: var(--accent-bg); padding: 12px 18px; border-radius: 8px;">
                    <div class="muted" style="font-size: 11px;">{{ \App\Models\Application::MODULES[$module] ?? $module }}</div>
                    <div style="font-size: 22px; font-weight: 700;">{{ $total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <h3 class="mt-6">Heatmap Modul INPReS</h3>
    <p class="muted">Status semua modul sistem — aktif, separa, dan dalam skop perancangan.</p>
    <div class="row row-3 mt-4" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
        @foreach ($modules as $m)
            @php($cls = match($m['status']) { 'active' => 'tile-active', 'partial' => 'tile-partial', 'scope' => 'tile-scope', default => 'tile-disabled' })
            @php($badge = match($m['status']) { 'active' => 'badge-green', 'partial' => 'badge-amber', 'scope' => 'badge-grey', default => 'badge-grey' })
            @php($badgeText = match($m['status']) { 'active' => 'Aktif', 'partial' => 'Separa', 'scope' => 'Dalam Skop', default => '—' })
            <div class="tile {{ $cls }}">
                <div class="flex items-center justify-between mb-2">
                    <span style="font-size: 28px;">{{ $m['icon'] }}</span>
                    <span class="badge {{ $badge }}">{{ $badgeText }}</span>
                </div>
                <h3 style="margin: 8px 0; font-size: 16px;">{{ $m['name'] }}</h3>
                <div class="muted" style="font-size: 12px;">{{ $m['desc'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="muted text-center mt-6" style="font-size: 12px;">Legenda: Hijau = Aktif | Amber = Separa | Kelabu = Dalam Skop</div>
</x-filament-panels::page>
