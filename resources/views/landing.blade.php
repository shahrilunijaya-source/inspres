@extends('layouts.public')

@section('content')
<section class="hero">
    <canvas id="hero-wave-bg" aria-hidden="true"></canvas>
    <div class="container">
        <h1 data-bm="Sistem Pendaftaran Bersepadu Negara" data-en="National Integrated Registration System">Sistem Pendaftaran Bersepadu Negara</h1>
        <p data-bm="INPReS menyatukan pendaftaran kelahiran, MyKad, perkahwinan, dan rekod identiti dalam satu platform digital — dari kaunter manual ke kepercayaan digital." data-en="INPReS unifies birth registration, MyKad, marriage, and identity records into one digital platform — from manual counters to digital trust.">INPReS menyatukan pendaftaran kelahiran, MyKad, perkahwinan, dan rekod identiti dalam satu platform digital — dari kaunter manual ke kepercayaan digital.</p>
        <div class="mt-6 flex gap-3" style="justify-content: center;">
            <a href="{{ route('login') }}" class="btn btn-hero-yellow" data-bm="Log Masuk Awam" data-en="Public Login">Log Masuk Awam</a>
            <a href="{{ route('register') }}" class="btn btn-hero-ghost" data-bm="Daftar Akaun" data-en="Register">Daftar Akaun</a>
            <a href="{{ url('/admin/login') }}" class="btn btn-hero-officer"><span style="margin-right:6px;">🛡</span><span data-bm="Portal Pegawai" data-en="Officer Portal">Portal Pegawai</span></a>
        </div>

        <form action="{{ route('track') }}" method="GET" class="hero-search">
            <div class="hero-search-label" data-bm="Semak Status Permohonan Saya" data-en="Track My Application">Semak Status Permohonan Saya</div>
            <div class="hero-search-row">
                <select name="module" class="hero-search-select">
                    <option value="" data-bm="Semua Modul" data-en="All Modules">Semua Modul</option>
                    @foreach (\App\Models\Application::MODULES as $code => $label)
                        <option value="{{ $code }}" {{ request('module') === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <input type="text" name="q" data-bm-placeholder="No. Permohonan (cth. KLH-2026-001234)" data-en-placeholder="Application No. (e.g. KLH-2026-001234)" placeholder="No. Permohonan (cth. KLH-2026-001234)" class="hero-search-input" value="{{ request('q') }}" required>
                <button type="submit" class="hero-search-btn" data-bm="Semak Status" data-en="Check Status">Semak Status</button>
            </div>
            <div class="hero-search-hint" data-bm="Tiada keperluan log masuk. Masukkan No. Permohonan untuk melihat status & SLA." data-en="No login required. Enter Application No. to view status & SLA.">Tiada keperluan log masuk. Masukkan No. Permohonan untuk melihat status & SLA.</div>
        </form>
    </div>
</section>

{{-- 10A.9 Before vs After table --}}
<section class="container" style="padding: 64px 24px;">
    <h2 class="text-center" data-bm="Dari Susulan Manual ke Kepercayaan Digital" data-en="From Manual Follow-up to Digital Trust">Dari Susulan Manual ke Kepercayaan Digital</h2>
    <p class="muted text-center mb-6" data-bm="INPReS mengubah cara perkhidmatan pendaftaran disampaikan kepada rakyat dan dipantau oleh pengurusan." data-en="INPReS transforms how registration services are delivered to citizens and monitored by management.">INPReS mengubah cara perkhidmatan pendaftaran disampaikan kepada rakyat dan dipantau oleh pengurusan.</p>
    <div class="row row-2">
        <div class="card" style="border-left: 4px solid var(--red);">
            <h3 style="color: var(--red);" data-bm="Keadaan Semasa" data-en="Current State">Keadaan Semasa</h3>
            <ul style="padding-left: 20px;">
                <li data-bm="Susulan manual oleh pemohon" data-en="Manual follow-up by applicant">Susulan manual oleh pemohon</li>
                <li data-bm="Lawatan kaunter berulang" data-en="Repeated counter visits">Lawatan kaunter berulang</li>
                <li data-bm="Visibility lambat untuk pengurusan" data-en="Slow visibility for management">Visibility lambat untuk pengurusan</li>
                <li data-bm="Audit trail sukar dikesan" data-en="Hard-to-trace audit trail">Audit trail sukar dikesan</li>
                <li data-bm="Perkhidmatan terpisah-pisah" data-en="Fragmented services">Perkhidmatan terpisah-pisah</li>
                <li data-bm="Pengutamaan kerja terhad" data-en="Limited work prioritisation">Pengutamaan kerja terhad</li>
            </ul>
        </div>
        <div class="card card-accent" style="border-left: 4px solid var(--accent);">
            <h3 style="color: var(--accent);" data-bm="Penyelesaian INPReS" data-en="INPReS Solution">Penyelesaian INPReS</h3>
            <ul style="padding-left: 20px;">
                <li data-bm="Penjejakan status dalam talian" data-en="Online status tracking">Penjejakan status dalam talian</li>
                <li data-bm="Pembetulan dokumen secara digital" data-en="Digital document corrections">Pembetulan dokumen secara digital</li>
                <li data-bm="Dashboard & pemantauan SLA" data-en="Dashboard & SLA monitoring">Dashboard & pemantauan SLA</li>
                <li data-bm="Sejarah transaksi penuh" data-en="Full transaction history">Sejarah transaksi penuh</li>
                <li data-bm="Lifecycle rakyat bersambung" data-en="Connected citizen lifecycle">Lifecycle rakyat bersambung</li>
                <li data-bm="Antrian pegawai dengan keutamaan SLA" data-en="Officer queue with SLA priority">Antrian pegawai dengan keutamaan SLA</li>
            </ul>
        </div>
    </div>
</section>

{{-- Modules — segmented showcase --}}
@php
$stepIcons = [
    'form'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h4"/></svg>',
    'verify'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg>',
    'pay'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18"/><path d="M7 15h3"/></svg>',
    'biometric'=> '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12c0-3.9 3.1-7 7-7s7 3.1 7 7"/><path d="M7.5 12c0-2.5 2-4.5 4.5-4.5s4.5 2 4.5 4.5v3"/><path d="M10 12c0-1.1.9-2 2-2s2 .9 2 2v5"/><path d="M5 16v3M19 16v3M12 16v5"/></svg>',
    'stamp'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5"/><path d="M9 9l2 2 4-4"/><path d="M5 21h14M5 18h14"/></svg>',
    'cert'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><circle cx="12" cy="14" r="2.5"/><path d="M10.5 16.5L9 21l3-1.5L15 21l-1.5-4.5"/></svg>',
    'handoff' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="14" height="10" rx="1"/><path d="M21 14v-3l-4-3v9z"/><circle cx="7" cy="13" r="1.5"/></svg>',
    'bell'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 1 1 12 0c0 7 3 7 3 9H3c0-2 3-2 3-9z"/><path d="M10 21a2 2 0 0 0 4 0"/></svg>',
    'shield'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"/></svg>',
    'review'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="6"/><path d="M16 16l4 4"/><path d="M9 11h4M11 9v4"/></svg>',
    'qr'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M21 14v3M14 18v3M17 21h4"/></svg>',
    'court'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V10M19 21V10"/><path d="M3 10h18l-9-6z"/><path d="M9 14v4M12 14v4M15 14v4"/></svg>',
    'family'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="8" r="2.5"/><circle cx="17" cy="8" r="2.5"/><circle cx="12" cy="11" r="1.8"/><path d="M3 18c0-2 1.5-3.5 4-3.5s4 1.5 4 3.5"/><path d="M13 18c0-2 1.5-3.5 4-3.5s4 1.5 4 3.5"/><path d="M9 19c0-1.5 1.2-2.5 3-2.5s3 1 3 2.5"/></svg>',
    'speech'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-5l-5 4v-4H5a2 2 0 0 1-2-2z"/><path d="M11 8v3M11 13h.01"/></svg>',
    'ticket'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4z"/><path d="M9 6v12"/></svg>',
    'rating'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2.5 5.5 6 .8-4.4 4.2 1.1 6L12 16.5 6.8 19.5l1.1-6L3.5 9.3l6-.8z"/></svg>',
];

$illustrations = [
    'birth' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="100" cy="60" r="34" stroke-width="1.6"/>
        <path d="M76 56c-3 0-6 2-6 6s3 6 6 6M124 56c3 0 6 2 6 6s-3 6-6 6"/>
        <circle cx="90" cy="60" r="2" fill="currentColor"/>
        <circle cx="110" cy="60" r="2" fill="currentColor"/>
        <path d="M90 72c2 4 6 6 10 6s8-2 10-6"/>
        <path d="M82 40c0-8 8-12 18-12s18 4 18 12" stroke-dasharray="2 3"/>
        <path d="M60 110c0-12 18-22 40-22s40 10 40 22" opacity="0.5"/>
        <path d="M70 122h60" opacity="0.4"/>
        <text x="100" y="138" font-size="9" font-weight="700" fill="currentColor" stroke="none" text-anchor="middle" letter-spacing="2">SIJIL KELAHIRAN</text>
    </svg>',
    'mykad' => '<svg viewBox="0 0 220 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <rect x="20" y="20" width="180" height="110" rx="10" stroke-width="1.6"/>
        <rect x="36" y="40" width="50" height="60" rx="4"/>
        <circle cx="61" cy="62" r="10"/>
        <path d="M48 92c0-7 6-12 13-12s13 5 13 12"/>
        <rect x="100" y="40" width="80" height="6" rx="2" fill="currentColor" opacity="0.15" stroke="none"/>
        <rect x="100" y="54" width="60" height="4" rx="1" fill="currentColor" opacity="0.3" stroke="none"/>
        <rect x="100" y="64" width="70" height="4" rx="1" fill="currentColor" opacity="0.3" stroke="none"/>
        <rect x="100" y="74" width="50" height="4" rx="1" fill="currentColor" opacity="0.3" stroke="none"/>
        <rect x="148" y="92" width="32" height="22" rx="3"/>
        <path d="M154 100h20M154 106h14"/>
        <path d="M156 96v6M162 96v6M168 96v6M174 96v6"/>
        <text x="36" y="124" font-size="8" font-weight="700" fill="currentColor" stroke="none" letter-spacing="2">MYKAD · MALAYSIA</text>
    </svg>',
    'marriage' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="80" cy="80" r="32" stroke-width="2"/>
        <circle cx="120" cy="80" r="32" stroke-width="2"/>
        <path d="M70 50l10-10 10 10M110 50l10-10 10 10"/>
        <path d="M76 38h8M116 38h8" stroke-width="2"/>
        <circle cx="80" cy="80" r="22" opacity="0.4"/>
        <circle cx="120" cy="80" r="22" opacity="0.4"/>
        <text x="100" y="130" font-size="9" font-weight="700" fill="currentColor" stroke="none" text-anchor="middle" letter-spacing="2">SATU IKATAN</text>
    </svg>',
    'cert' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <path d="M40 20h100l20 20v90H40z" stroke-width="1.6"/>
        <path d="M140 20v20h20"/>
        <path d="M52 56h80M52 68h80M52 80h60M52 92h70" opacity="0.4"/>
        <circle cx="148" cy="106" r="14" stroke-width="1.6"/>
        <path d="M142 106l4 4 8-8"/>
        <path d="M142 116l-4 8 6-2 4 6 4-12" opacity="0.6"/>
        <path d="M150 116l4 8-6-2-4 6-4-12" opacity="0.6"/>
        <text x="92" y="38" font-size="10" font-weight="700" fill="currentColor" stroke="none" text-anchor="middle" letter-spacing="3">SIJIL RASMI</text>
    </svg>',
    'death' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <path d="M70 56h60v60a8 8 0 0 1-8 8H78a8 8 0 0 1-8-8z" stroke-width="1.6"/>
        <rect x="64" y="48" width="72" height="10" rx="2"/>
        <path d="M86 76h28M86 88h28M86 100h20" opacity="0.4"/>
        <path d="M100 30v18M92 36c2-4 6-6 8-6s6 2 8 6" opacity="0.5"/>
        <path d="M92 36c0 4 4 8 8 8s8-4 8-8" opacity="0.5"/>
    </svg>',
    'adoption' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="60" cy="50" r="14"/>
        <circle cx="140" cy="50" r="14"/>
        <circle cx="100" cy="60" r="9"/>
        <path d="M36 102c0-12 10-20 24-20s24 8 24 20"/>
        <path d="M116 102c0-12 10-20 24-20s24 8 24 20"/>
        <path d="M82 110c0-9 8-15 18-15s18 6 18 15"/>
        <path d="M70 124h60" opacity="0.4"/>
    </svg>',
    'citizenship' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <rect x="50" y="20" width="100" height="110" rx="6" stroke-width="1.6"/>
        <circle cx="100" cy="65" r="20" stroke-width="1.6"/>
        <path d="M88 65a12 12 0 0 0 24 0" opacity="0.5"/>
        <path d="M100 45v40M85 65h30" opacity="0.4"/>
        <path d="M70 100h60M70 110h40M70 118h50" opacity="0.4"/>
        <text x="100" y="36" font-size="8" font-weight="700" fill="currentColor" stroke="none" text-anchor="middle" letter-spacing="2">PASPORT MALAYSIA</text>
    </svg>',
    'aduan' => '<svg viewBox="0 0 200 140" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
        <path d="M30 36a8 8 0 0 1 8-8h70a8 8 0 0 1 8 8v34a8 8 0 0 1-8 8H78l-18 16v-16H38a8 8 0 0 1-8-8z" stroke-width="1.6"/>
        <path d="M73 44v18M73 68v.01" stroke-width="2"/>
        <path d="M88 64a10 10 0 0 1 10-10h54a10 10 0 0 1 10 10v40a10 10 0 0 1-10 10h-22l-14 14v-14H98a10 10 0 0 1-10-10z" stroke-width="1.6" opacity="0.6"/>
        <path d="M105 80h40M105 90h32" opacity="0.5"/>
    </svg>',
];
$mods = [
    [
        'code'=>'birth','status'=>'active','tag'=>'KLH',
        'name_bm'=>'Pendaftaran Kelahiran','name_en'=>'Birth Registration',
        'tag_bm'=>'Mula daripada hari pertama','tag_en'=>'Start from day one',
        'desc_bm'=>'Sistem pendaftaran kelahiran dalam talian dengan integrasi hospital, klinik, dan kerajaan tempatan. Sijil kelahiran dijana automatik selepas semakan pegawai.','desc_en'=>'Online birth registration with hospital, clinic, and local government integration. Birth certificate auto-generated after officer review.',
        'features'=>[
            ['Pendaftaran dari hospital','Hospital-source registration'],
            ['Sijil digital ditandatangan PKI','PKI-signed digital certificate'],
            ['Notifikasi MyKid pada umur 1','MyKid notification at age 1'],
            ['Sambungan ke modul perkahwinan ibu bapa','Linked to parents\' marriage record'],
        ],
        'flow'=>[['Maklumat Bayi','Baby Info','form'],['Pengesahan Hospital','Hospital Verify','verify'],['Semakan Pegawai','Officer Review','review'],['Sijil Dijana','Certificate Issued','cert']],
    ],
    [
        'code'=>'mykad','status'=>'active','tag'=>'IDC',
        'name_bm'=>'Permohonan MyKad','name_en'=>'MyKad Application',
        'tag_bm'=>'Identiti rasmi rakyat','tag_en'=>'Official citizen identity',
        'desc_bm'=>'Permohonan MyKad pertama (umur 12), gantian (hilang/rosak), dan pembaharuan. Verifikasi biometrik ABIS automatik silang-padan rekod induk.','desc_en'=>'First-time MyKad (age 12), replacement (lost/damaged), and renewal. ABIS biometric verification cross-matches against master record.',
        'features'=>[
            ['Permohonan pertama umur 12','First application at age 12'],
            ['ABIS padan cap jari + wajah','ABIS fingerprint + face match'],
            ['Status real-time + SLA tracker','Real-time status + SLA tracker'],
            ['Tempah temujanji kaunter','Counter appointment booking'],
        ],
        'flow'=>[['Borang & Dokumen','Form & Docs','form'],['Bayaran','Payment','pay'],['ABIS Biometrik','ABIS Biometric','biometric'],['Kelulusan','Approval','stamp'],['Kutip MyKad','Collect MyKad','handoff']],
    ],
    [
        'code'=>'marriage','status'=>'active','tag'=>'PKW',
        'name_bm'=>'Pendaftaran Perkahwinan','name_en'=>'Marriage Registration',
        'tag_bm'=>'Daftar dengan keyakinan','tag_en'=>'Register with confidence',
        'desc_bm'=>'Pendaftaran perkahwinan rasmi dengan semakan silang status pasangan (bujang, janda, duda). Sijil perkahwinan digital dijana sekiranya diluluskan.','desc_en'=>'Official marriage registration with cross-verification of partner status (single, divorced, widowed). Digital marriage certificate generated upon approval.',
        'features'=>[
            ['Borang bersama dua pasangan','Joint form for both partners'],
            ['Semakan silang status pasangan','Partner status cross-check'],
            ['Pengesahan saksi digital','Digital witness verification'],
            ['Sijil perkahwinan digital','Digital marriage certificate'],
        ],
        'flow'=>[['Borang Bersama','Joint Form','form'],['Semakan Silang','Cross-check','review'],['Saksi & Pegawai','Witness & Officer','stamp'],['Sijil Dijana','Certificate Issued','cert']],
    ],
    [
        'code'=>'cert','status'=>'active','tag'=>'SJL',
        'name_bm'=>'Sijil & Dokumen','name_en'=>'Certificates & Documents',
        'tag_bm'=>'Akses 24/7','tag_en'=>'24/7 access',
        'desc_bm'=>'Muat turun, cetak semula, dan sahkan sijil rasmi (kelahiran, perkahwinan, kematian). Setiap sijil ditandatangan secara digital dengan QR pengesahan.','desc_en'=>'Download, reprint, and verify official certificates (birth, marriage, death). Every certificate is digitally signed with verification QR.',
        'features'=>[
            ['Tandatangan digital PKI','PKI digital signature'],
            ['QR code untuk pengesahan awam','Public verification QR code'],
            ['Sejarah muat turun penuh','Full download history'],
            ['Versi BM & BI','BM & EN versions'],
        ],
        'flow'=>[['Pilih Sijil','Select Certificate','cert'],['Bayaran (jika perlu)','Payment (if any)','pay'],['Muat Turun PDF','Download PDF','handoff'],['Sahkan via QR','Verify via QR','qr']],
    ],
    [
        'code'=>'death','status'=>'scope','tag'=>'KMT',
        'name_bm'=>'Pendaftaran Kematian','name_en'=>'Death Registration',
        'tag_bm'=>'Dalam skop perancangan','tag_en'=>'In planned scope',
        'desc_bm'=>'Pendaftaran kematian dengan integrasi hospital, polis, dan pengamal perubatan. Memutuskan rekod aktif (MyKad, perkahwinan) dan menandakan rekod kewarisan.','desc_en'=>'Death registration with hospital, police, and medical practitioner integration. Closes active records (MyKad, marriage) and flags inheritance records.',
        'features'=>[
            ['Pengesahan pengamal perubatan','Medical practitioner certification'],
            ['Penutupan rekod auto','Automatic record closure'],
            ['Notifikasi waris','Heir notification'],
            ['Sijil kematian digital','Digital death certificate'],
        ],
        'flow'=>[['Pengesahan Doktor','Doctor Verify','verify'],['Pendaftaran','Registration','form'],['Penutupan Rekod','Record Closure','stamp'],['Notifikasi Waris','Heir Notify','bell']],
    ],
    [
        'code'=>'adoption','status'=>'scope','tag'=>'AAK',
        'name_bm'=>'Anak Angkat','name_en'=>'Adoption',
        'tag_bm'=>'Dalam skop perancangan','tag_en'=>'In planned scope',
        'desc_bm'=>'Permohonan anak angkat dengan integrasi mahkamah, JKM, dan pendaftaran kelahiran. Kemas kini rekod identiti tanpa kehilangan jejak audit asal.','desc_en'=>'Adoption applications with court, JKM, and birth registration integration. Updates identity records without losing original audit trail.',
        'features'=>[
            ['Integrasi mahkamah','Court integration'],
            ['Semakan JKM','JKM verification'],
            ['Audit trail asal terpelihara','Original audit trail preserved'],
            ['Kemas kini rekod ibu bapa','Parent record update'],
        ],
        'flow'=>[['Permohonan','Application','form'],['JKM Semakan','JKM Review','review'],['Mahkamah','Court','court'],['Kemas Kini Rekod','Record Update','stamp']],
    ],
    [
        'code'=>'citizenship','status'=>'scope','tag'=>'KWN',
        'name_bm'=>'Kewarganegaraan','name_en'=>'Citizenship',
        'tag_bm'=>'Dalam skop perancangan','tag_en'=>'In planned scope',
        'desc_bm'=>'Permohonan kewarganegaraan untuk warga asing yang berhak. Aliran semakan keselamatan, biometrik, dan kelulusan menteri.','desc_en'=>'Citizenship applications for eligible foreigners. Flow includes security review, biometrics, and ministerial approval.',
        'features'=>[
            ['Semakan keselamatan','Security review'],
            ['Biometrik penuh','Full biometric capture'],
            ['Kelulusan menteri','Ministerial approval'],
            ['Sijil kewarganegaraan','Citizenship certificate'],
        ],
        'flow'=>[['Permohonan','Application','form'],['Semakan Keselamatan','Security Check','shield'],['Biometrik','Biometric','biometric'],['Kelulusan Menteri','Minister Approval','stamp']],
    ],
    [
        'code'=>'aduan','status'=>'scope','tag'=>'ADN',
        'name_bm'=>'Aduan & Khidmat Pelanggan','name_en'=>'Complaints & Customer Care',
        'tag_bm'=>'Dalam skop perancangan','tag_en'=>'In planned scope',
        'desc_bm'=>'Hantar aduan ICT atau perkhidmatan kaunter. Sistem tiket dengan SLA, eskalasi, dan jawapan rasmi dari pegawai bertanggungjawab.','desc_en'=>'Submit ICT or counter service complaints. Ticket system with SLA, escalation, and official responses from accountable officers.',
        'features'=>[
            ['Sistem tiket dengan SLA','Ticket system with SLA'],
            ['Eskalasi automatik','Automatic escalation'],
            ['Jawapan pegawai bertanggungjawab','Accountable officer response'],
            ['Penilaian kepuasan','Satisfaction rating'],
        ],
        'flow'=>[['Hantar Aduan','Submit','speech'],['Tiket SLA','SLA Ticket','ticket'],['Pegawai Tindak Balas','Officer Response','review'],['Selesai & Penilaian','Resolved & Rated','rating']],
    ],
];
@endphp

<section id="modules" class="modules-section">
    <div class="container">
        <div class="modules-head">
            <span class="kicker" data-bm="Direktori Modul" data-en="Module Directory">Direktori Modul</span>
            <h2 data-bm="Direktori Modul INPReS" data-en="INPReS Module Directory">Direktori Modul INPReS</h2>
            <p class="muted" data-bm="Setiap modul ialah perkhidmatan lengkap dengan aliran proses sendiri." data-en="Each module is a complete service with its own process flow.">Setiap modul ialah perkhidmatan lengkap dengan aliran proses sendiri.</p>
        </div>

        @php
            $publicIcons = [
                'baby' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="4"/><path d="M9 9h.01M15 9h.01M10 12c1 1 3 1 4 0"/><path d="M5 21c0-4 3-6 7-6s7 2 7 6"/></svg>',
                'card' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8" cy="12" r="2"/><path d="M13 10h6M13 14h4"/></svg>',
                'ring' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="15" r="6"/><path d="M9 6l3-3 3 3M10 6h4"/></svg>',
                'doc'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/></svg>',
                'urn'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 21h10V11H7z"/><rect x="5" y="7" width="14" height="4" rx="1"/></svg>',
                'users'=> '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="9" r="3"/><circle cx="17" cy="11" r="2.5"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6M14 20c0-2.5 2.3-4 4-4s4 1.5 4 4"/></svg>',
                'flag' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 21V4M5 4h13l-3 5 3 5H5"/></svg>',
                'chat' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a8 8 0 1 1-3.5-6.6L21 5l-1.4 3.5A8 8 0 0 1 21 12z"/><path d="M9 11h.01M12 11h.01M15 11h.01"/></svg>',
            ];
        @endphp

        <div class="lrmp-grid">
            @foreach ($modules as $m)
                @php
                    $isActive = $m['status'] === 'active';
                    $statusLabel = $isActive ? 'Aktif' : ($m['status'] === 'partial' ? 'Separa' : 'Akan Datang');
                    $dotColor = $isActive ? '#16a34a' : ($m['status'] === 'partial' ? '#d97706' : '#94a3b8');
                @endphp
                <div class="lrmp-card {{ $isActive ? 'lrmp-active' : 'lrmp-scope' }}">
                    <div class="lrmp-tag">{{ $m['tag'] }}</div>
                    <div class="lrmp-icon-box">{!! $publicIcons[$m['icon']] ?? '' !!}</div>
                    <div class="lrmp-name">{{ $m['name'] }}</div>
                    <div class="lrmp-desc">{{ $m['desc'] }}</div>

                    @if (!empty($m['stats']))
                        <div class="lrmp-stats">
                            @foreach ($m['stats'] as $s)
                                <div class="lrmp-stat">
                                    <div class="lrmp-stat-v lrmp-tone-{{ $s['t'] }}">{{ $s['v'] }}</div>
                                    <div class="lrmp-stat-l">{{ $s['l'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="lrmp-stats lrmp-stats-empty">
                            <div class="lrmp-stat"><div class="lrmp-stat-v">—</div><div class="lrmp-stat-l">Belum Tersedia</div></div>
                            <div class="lrmp-stat"><div class="lrmp-stat-v">—</div><div class="lrmp-stat-l">Belum Tersedia</div></div>
                        </div>
                    @endif

                    <div class="lrmp-foot">
                        <span class="lrmp-status"><span class="lrmp-dot" style="background: {{ $dotColor }};"></span>{{ $statusLabel }}</span>
                        @if ($isActive)
                            <a href="{{ route('login') }}" class="lrmp-arrow" aria-label="Buka {{ $m['name'] }}">→</a>
                        @else
                            <button type="button" class="lrmp-arrow lrmp-arrow-scope" onclick="openInactiveModal('{{ $m['name'] }}', '{{ $statusLabel }}')" aria-label="{{ $m['name'] }}">→</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="modal-backdrop" id="inactiveModal" onclick="if(event.target.id==='inactiveModal') closeInactiveModal()">
    <div class="modal-card">
        <div class="modal-head">
            <span>Modul Tidak Tersedia dalam Prototaip</span>
            <button onclick="closeInactiveModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-body" style="padding: 28px;">
            <div style="font-size: 48px; text-align: center; margin-bottom: 12px;">🚧</div>
            <h3 style="text-align: center; margin: 0 0 8px;">Modul: <span id="inactiveModuleName"></span></h3>
            <p style="text-align: center; color: var(--slate); font-size: 13.5px;">Status: <strong id="inactiveModuleStatus"></strong></p>
            <p>Modul ini <strong>tidak termasuk dalam prototaip semasa</strong>. Ia disenaraikan dalam skop perancangan penuh INPReS dan akan dilaksanakan dalam fasa pelaksanaan sebenar.</p>
            <p class="muted" style="font-size: 12.5px;">Walkthrough demo prototaip ini fokus kepada Pendaftaran Kelahiran, Permohonan MyKad, dan Pendaftaran Perkahwinan.</p>
        </div>
        <div class="modal-foot" style="display: flex; justify-content: flex-end; gap: 8px;">
            <button class="btn btn-secondary" onclick="closeInactiveModal()" style="padding: 8px 16px;">Tutup</button>
        </div>
    </div>
</div>

<style>
    .tile-link { display: block; text-decoration: none; color: inherit; text-align: left; border: 1px solid var(--border); width: 100%; font-family: inherit; }
    .tile-link:hover { text-decoration: none; color: inherit; }
    button.tile-link { background: #fff; cursor: pointer; }
    .tile.tile-scope.tile-link, .tile.tile-disabled.tile-link { cursor: pointer; opacity: 0.85; }
    .tile.tile-scope.tile-link:hover, .tile.tile-disabled.tile-link:hover { opacity: 1; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
    .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(11,30,63,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 20px; }
    .modal-backdrop.open { display: flex; }
    .modal-card { background: #fff; border-radius: 12px; width: 100%; max-width: 520px; max-height: 80vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-head { background: var(--accent); color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; font-weight: 600; }
    .modal-close { background: rgba(255,255,255,0.15); color: #fff; border: none; width: 28px; height: 28px; border-radius: 4px; cursor: pointer; font-size: 18px; line-height: 1; }
    .modal-body { padding: 24px; overflow-y: auto; }
    .modal-foot { background: var(--grey-bg); padding: 12px 20px; border-top: 1px solid var(--border); }

    /* === myLRMP-style module tile grid === */
    .lrmp-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    @media (max-width: 1280px) { .lrmp-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 960px)  { .lrmp-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .lrmp-grid { grid-template-columns: 1fr; } }

    .lrmp-card { position: relative; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 22px 20px 16px; display: flex; flex-direction: column; min-height: 240px; transition: all 200ms; }
    .lrmp-card:hover { box-shadow: 0 10px 28px rgba(0,0,0,0.10); transform: translateY(-2px); }
    .lrmp-card.lrmp-active { border-top: 3px solid var(--accent); }
    .lrmp-card.lrmp-scope { border-top: 3px solid transparent; opacity: 0.85; }
    .lrmp-card.lrmp-scope:hover { opacity: 1; }

    .lrmp-tag { position: absolute; top: 14px; right: 14px; font-size: 10.5px; font-weight: 600; color: var(--slate); background: var(--grey-bg); padding: 3px 10px; border-radius: 999px; letter-spacing: 0.4px; }

    .lrmp-icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; background: var(--grey-bg); color: var(--slate); }
    .lrmp-icon-box svg { width: 24px; height: 24px; }
    .lrmp-card.lrmp-active .lrmp-icon-box { background: var(--navy); color: #fff; }

    .lrmp-name { font-weight: 700; font-size: 15.5px; color: var(--navy); margin-bottom: 4px; }
    .lrmp-desc { font-size: 12.5px; color: var(--slate); line-height: 1.5; margin-bottom: 14px; flex: 1; }

    .lrmp-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
    .lrmp-stat { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 12px 8px; text-align: center; }
    .lrmp-stat-v { font-size: 22px; font-weight: 700; line-height: 1.1; color: var(--navy); }
    .lrmp-stat-l { font-size: 10.5px; color: var(--slate); margin-top: 4px; text-transform: lowercase; }
    .lrmp-tone-amber .lrmp-stat-v, .lrmp-tone-amber { color: #d97706; }
    .lrmp-tone-red   .lrmp-stat-v, .lrmp-tone-red   { color: #dc2626; }
    .lrmp-tone-green .lrmp-stat-v, .lrmp-tone-green { color: #15803d; }
    .lrmp-stats-empty .lrmp-stat { background: var(--grey-bg); border-style: dashed; }
    .lrmp-stats-empty .lrmp-stat-v { color: #cbd5e1; }
    .lrmp-stats-empty .lrmp-stat-l { color: #94a3b8; }

    .lrmp-foot { display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid var(--border); margin-top: auto; }
    .lrmp-status { font-size: 12px; font-weight: 600; color: var(--slate); display: flex; align-items: center; gap: 6px; }
    .lrmp-card.lrmp-active .lrmp-status { color: #15803d; }
    .lrmp-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .lrmp-arrow { width: 32px; height: 32px; border-radius: 8px; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; transition: all 150ms; border: none; cursor: pointer; }
    .lrmp-arrow:hover { background: var(--accent-dark); transform: translateX(2px); text-decoration: none; color: #fff; }
    .lrmp-arrow-scope { background: #cbd5e1; color: #fff; cursor: pointer; }
    .lrmp-arrow-scope:hover { background: #94a3b8; }
</style>
<script>
    function openInactiveModal(name, status) {
        document.getElementById('inactiveModuleName').textContent = name;
        document.getElementById('inactiveModuleStatus').textContent = status;
        document.getElementById('inactiveModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeInactiveModal() {
        document.getElementById('inactiveModal').classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeInactiveModal(); });
</script>

@push('scripts')
<script>
(function () {
  var canvas = document.getElementById('hero-wave-bg');
  if (!canvas) return;
  var gl = canvas.getContext('webgl', { antialias: true });
  if (!gl) return;

  var vsSource = "attribute vec4 aVertexPosition;void main(){gl_Position=aVertexPosition;}";
  var fsSource = `
    precision highp float;
    uniform vec2 iResolution;
    uniform float iTime;

    const float overallSpeed    = 0.2;
    const float gridSmoothWidth = 0.015;
    const float minLineWidth    = 0.005;
    const float maxLineWidth    = 0.08;
    const float lineSpeed       = 1.0  * overallSpeed;
    const float lineAmplitude   = 1.0;
    const float lineFrequency   = 0.2;
    const float warpSpeed       = 0.2  * overallSpeed;
    const float warpFrequency   = 0.5;
    const float warpAmplitude   = 0.4;
    const float offsetFrequency = 0.5;
    const float offsetSpeed     = 1.33 * overallSpeed;
    const float minOffsetSpread = 0.6;
    const float maxOffsetSpread = 2.0;
    const int   linesPerGroup   = 9;
    const float scale           = 5.0;
    const vec4  lineColor       = vec4(0.04, 0.45, 0.65, 1.0);

    #define drawCircle(pos,radius,coord) smoothstep(radius+gridSmoothWidth,radius,length(coord-(pos)))
    #define drawSmoothLine(pos,hw,t)     smoothstep(hw,0.0,abs(pos-(t)))
    #define drawCrispLine(pos,hw,t)      smoothstep(hw+gridSmoothWidth,hw,abs(pos-(t)))

    float random(float t){return(cos(t)+cos(t*1.3+1.3)+cos(t*1.4+1.4))/3.0;}
    float getPlasmaY(float x,float hf,float off){
      return random(x*lineFrequency+iTime*lineSpeed)*hf*lineAmplitude+off;
    }

    void main(){
      vec2 uv    = gl_FragCoord.xy/iResolution.xy;
      vec2 space = (gl_FragCoord.xy-iResolution.xy/2.0)/iResolution.x*2.0*scale;

      float hFade = 1.0-(cos(uv.x*6.28)*0.5+0.5);
      float vFade = 1.0-(cos(uv.y*6.28)*0.5+0.5);

      space.y += random(space.x*warpFrequency+iTime*warpSpeed)*warpAmplitude*(0.5+hFade);
      space.x += random(space.y*warpFrequency+iTime*warpSpeed+2.0)*warpAmplitude*hFade;

      vec4 lines    = vec4(0.0);
      vec4 bgColor1 = vec4(0.06, 0.09, 0.16, 1.0);
      vec4 bgColor2 = vec4(0.12, 0.23, 0.37, 1.0);

      for(int l=0;l<linesPerGroup;l++){
        float nl   = float(l)/float(linesPerGroup);
        float ot   = iTime*offsetSpeed;
        float op   = float(l)+space.x*offsetFrequency;
        float rand = random(op+ot)*0.5+0.5;
        float hw   = mix(minLineWidth,maxLineWidth,rand*hFade)/2.0;
        float off  = random(op+ot*(1.0+nl))*mix(minOffsetSpread,maxOffsetSpread,hFade);
        float lp   = getPlasmaY(space.x,hFade,off);
        float line = drawSmoothLine(lp,hw,space.y)/2.0+drawCrispLine(lp,hw*0.15,space.y);
        float cx   = mod(float(l)+iTime*lineSpeed,25.0)-12.0;
        vec2  cp   = vec2(cx,getPlasmaY(cx,hFade,off));
        line += drawCircle(cp,0.008,space)*1.5;
        lines += line*lineColor*rand;
      }

      vec4 col = mix(bgColor1, bgColor2, uv.x);
      col *= vFade; col.a = 1.0; col += lines * 0.45;
      gl_FragColor = col;
    }
  `;

  function loadShader(gl, type, src) {
    var s = gl.createShader(type);
    gl.shaderSource(s, src); gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) { gl.deleteShader(s); return null; }
    return s;
  }

  var vs = loadShader(gl, gl.VERTEX_SHADER, vsSource);
  var fs = loadShader(gl, gl.FRAGMENT_SHADER, fsSource);
  if (!vs || !fs) return;
  var prog = gl.createProgram();
  gl.attachShader(prog, vs); gl.attachShader(prog, fs); gl.linkProgram(prog);

  var buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1, 1,-1, -1,1, 1,1]), gl.STATIC_DRAW);

  var aPos  = gl.getAttribLocation(prog, 'aVertexPosition');
  var uRes  = gl.getUniformLocation(prog, 'iResolution');
  var uTime = gl.getUniformLocation(prog, 'iTime');

  function resize() {
    var p = canvas.parentElement;
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    canvas.width  = Math.floor(p.clientWidth  * dpr);
    canvas.height = Math.floor(p.clientHeight * dpr);
    canvas.style.width  = p.clientWidth  + 'px';
    canvas.style.height = p.clientHeight + 'px';
    gl.viewport(0, 0, canvas.width, canvas.height);
  }
  window.addEventListener('resize', resize);
  if ('ResizeObserver' in window) { new ResizeObserver(resize).observe(canvas.parentElement); }
  resize();

  var t0 = performance.now();
  (function render() {
    var t = (performance.now() - t0) / 1000;
    gl.clear(gl.COLOR_BUFFER_BIT);
    gl.useProgram(prog);
    gl.uniform2f(uRes, canvas.width, canvas.height);
    gl.uniform1f(uTime, t);
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.vertexAttribPointer(aPos, 2, gl.FLOAT, false, 0, 0);
    gl.enableVertexAttribArray(aPos);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    requestAnimationFrame(render);
  })();
})();
</script>
@endpush
@endsection
