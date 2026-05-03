@php($currentUser = auth()->user())
<nav class="navbar">
    <div class="container navbar-inner">
        <a href="{{ url('/') }}" class="nav-brand">
            <img src="{{ asset('img/logo_jata.png') }}" alt="Jata Negara" style="height: 64px;">
            <img src="{{ asset('img/logo_jpn.png') }}" alt="JPN" style="height: 60px;">
            <span style="border-left: 1px solid var(--border); padding-left: 10px; margin-left: 4px;">INPReS</span>
        </a>
        <div class="nav-links">
            <a href="{{ url('/') }}" data-bm="Utama" data-en="Home">Utama</a>
            <a href="{{ url('/#modules') }}" data-bm="Modul" data-en="Modules">Modul</a>
            <a href="{{ route('track') }}" data-bm="Semak Status" data-en="Track Status">Semak Status</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('applications.index') }}">Permohonan Saya</a>
                <details class="user-menu">
                    <summary class="user-menu-trigger">
                        <span class="user-avatar">{{ \Illuminate\Support\Str::substr($currentUser->name, 0, 1) }}</span>
                        <span class="user-menu-name">{{ \Illuminate\Support\Str::limit($currentUser->name, 18) }}</span>
                        <span class="user-menu-caret">▾</span>
                    </summary>
                    <div class="user-menu-panel">
                        <div class="user-menu-head">
                            <div class="user-menu-name-full">{{ $currentUser->name }}</div>
                            <div class="muted" style="font-size: 12px;">{{ $currentUser->roleLabel() }}</div>
                        </div>
                        <a href="{{ route('dashboard') }}" class="user-menu-item">Dashboard</a>
                        <a href="{{ route('applications.index') }}" class="user-menu-item">Permohonan Saya</a>
                        <form method="POST" action="{{ route('logout') }}" class="user-menu-form">
                            @csrf
                            <button type="submit" class="user-menu-item user-menu-logout">↩  Log Keluar</button>
                        </form>
                    </div>
                </details>
            @else
                <a href="{{ route('login') }}" class="btn btn-hero-yellow btn-nav-sm" data-bm="Log Masuk Awam" data-en="Public Login">Log Masuk Awam</a>
                <a href="{{ url('/admin/login') }}" class="btn btn-hero-officer btn-nav-sm"><span style="margin-right:6px;">🛡</span><span data-bm="Portal Pegawai" data-en="Officer Portal">Portal Pegawai</span></a>
            @endauth
            <div class="lang-toggle" role="group" aria-label="Language">
                <button type="button" data-lang="bm" class="lang-btn active">BM</button>
                <button type="button" data-lang="en" class="lang-btn">EN</button>
            </div>
        </div>
    </div>
</nav>
