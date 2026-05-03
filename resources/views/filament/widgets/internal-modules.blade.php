<x-filament-widgets::widget>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">

    @php($modules = $this->getModules())
    @php($counts = $this->getCounts())

    <div class="im-wrap">
        <div class="im-head">
            <div class="im-head-label">MODUL SISTEM</div>
            <div class="im-head-counts">
                {{ $counts['total'] }} modul
                <span class="im-head-sep">·</span>
                <span class="im-head-active">{{ $counts['active'] }} aktif</span>
                <span class="im-head-sep">·</span>
                <span class="im-head-pending">{{ $counts['partial'] + $counts['scope'] }} dalam pembangunan</span>
            </div>
        </div>

        <div class="im-grid">
            @foreach ($modules as $m)
                @php($cls = match($m['status']) { 'active' => 'im-active', 'partial' => 'im-partial', default => 'im-scope' })
                @php($statusLabel = match($m['status']) { 'active' => 'Aktif', 'partial' => 'Separa', default => 'Akan Datang' })
                @php($statusDot = match($m['status']) { 'active' => '#16a34a', 'partial' => '#d97706', default => '#94a3b8' })
                <div class="im-card {{ $cls }}">
                    <div class="im-tag">{{ $m['tag'] }}</div>
                    <div class="im-icon">{{ $m['icon'] }}</div>
                    <div class="im-name">{{ $m['name'] }}</div>
                    <div class="im-desc">{{ $m['desc'] }}</div>

                    @if (!empty($m['stats']))
                        <div class="im-stats">
                            @foreach ($m['stats'] as $s)
                                <div class="im-stat">
                                    <div class="im-stat-value im-tone-{{ $s['tone'] }}">{{ $s['value'] }}</div>
                                    <div class="im-stat-label">{{ $s['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="im-stats im-stats-disabled">
                            <div class="im-stat"><div class="im-stat-value">—</div><div class="im-stat-label">Belum Tersedia</div></div>
                            <div class="im-stat"><div class="im-stat-value">—</div><div class="im-stat-label">Belum Tersedia</div></div>
                        </div>
                    @endif

                    <div class="im-foot">
                        <span class="im-status"><span class="im-dot" style="background: {{ $statusDot }};"></span>{{ $statusLabel }}</span>
                        @if (!empty($m['url']))
                            <a href="{{ $m['url'] }}" class="im-arrow" aria-label="Buka {{ $m['name'] }}">→</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .im-wrap { margin-top: 16px; }
        .im-head { display: flex; justify-content: space-between; align-items: baseline; padding: 0 4px 14px; border-bottom: 1px solid rgba(229,237,245,0.6); margin-bottom: 18px; }
        .dark .im-head { border-bottom-color: rgba(75,85,99,0.5); }
        .im-head-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; color: var(--slate, #64748d); text-transform: uppercase; }
        .im-head-counts { font-size: 12px; color: var(--slate, #64748d); }
        .im-head-active { color: #15803d; font-weight: 600; }
        .im-head-pending { color: #b45309; font-weight: 600; }
        .im-head-sep { margin: 0 6px; opacity: 0.5; }

        .im-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        @media (max-width: 1280px) { .im-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 960px)  { .im-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .im-grid { grid-template-columns: 1fr; } }

        .im-card { position: relative; background: #fff; border: 1px solid var(--border, #e5edf5); border-radius: 12px; padding: 22px 20px 16px; display: flex; flex-direction: column; min-height: 240px; transition: all 200ms; }
        .dark .im-card { background: rgb(31 41 55); border-color: rgb(55 65 81); }
        .im-card:hover { box-shadow: 0 10px 28px rgba(0,0,0,0.10); transform: translateY(-2px); }
        .im-card.im-active { border-top: 3px solid var(--accent, #1d4ed8); }
        .im-card.im-partial { border-top: 3px solid #d97706; }
        .im-card.im-scope { border-top: 3px solid transparent; opacity: 0.85; }
        .im-card.im-scope:hover { opacity: 1; }

        .im-tag { position: absolute; top: 14px; right: 14px; font-size: 10.5px; font-weight: 600; color: var(--slate, #64748d); background: var(--grey-bg, #f1f5f9); padding: 3px 10px; border-radius: 999px; letter-spacing: 0.4px; }
        .dark .im-tag { background: rgb(55 65 81); color: rgb(209 213 219); }

        .im-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px; background: var(--grey-bg, #f1f5f9); color: var(--slate, #64748d); }
        .im-card.im-active .im-icon { background: var(--navy, #0b1e3f); color: #fff; }
        .im-card.im-partial .im-icon { background: #fef3c7; color: #b45309; }

        .im-name { font-weight: 700; font-size: 15px; color: var(--navy, #0b1e3f); margin-bottom: 4px; }
        .dark .im-name { color: rgb(243 244 246); }
        .im-desc { font-size: 12.5px; color: var(--slate, #64748d); line-height: 1.5; margin-bottom: 14px; flex: 1; }

        .im-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
        .im-stat { background: #fff; border: 1px solid var(--border, #e5edf5); border-radius: 8px; padding: 12px 8px; text-align: center; }
        .dark .im-stat { background: rgb(31 41 55); border-color: rgb(55 65 81); }
        .im-stat-value { font-size: 24px; font-weight: 700; line-height: 1.1; color: var(--navy, #0b1e3f); }
        .dark .im-stat-value { color: rgb(243 244 246); }
        .im-stat-label { font-size: 10.5px; color: var(--slate, #64748d); margin-top: 4px; text-transform: lowercase; }
        .im-tone-amber { color: #d97706; }
        .im-tone-red { color: #dc2626; }
        .im-tone-green { color: #15803d; }
        .im-stats-disabled .im-stat { background: var(--grey-bg, #f1f5f9); border-style: dashed; }
        .im-stats-disabled .im-stat-value { color: #cbd5e1; }
        .im-stats-disabled .im-stat-label { color: #94a3b8; }

        .im-foot { display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid var(--border, #e5edf5); margin-top: auto; }
        .dark .im-foot { border-color: rgb(55 65 81); }
        .im-status { font-size: 12px; font-weight: 600; color: var(--slate, #64748d); display: flex; align-items: center; gap: 6px; }
        .im-card.im-active .im-status { color: #15803d; }
        .im-card.im-partial .im-status { color: #d97706; }
        .im-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .im-arrow { width: 32px; height: 32px; border-radius: 8px; background: var(--accent, #1d4ed8); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; transition: all 150ms; }
        .im-arrow:hover { background: var(--accent-dark, #1e3a8a); transform: translateX(2px); text-decoration: none; color: #fff; }
    </style>
</x-filament-widgets::widget>
