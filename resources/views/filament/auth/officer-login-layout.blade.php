<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk Pegawai — INPReS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @filamentStyles
    <style>
        body { background: #f1f5f9; font-family: 'Poppins', sans-serif; }
        .auth-officer-left { background: linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #334155 100%) !important; }
        .auth-officer-left::after { background: radial-gradient(circle, rgba(255,204,0,0.10) 0%, rgba(255,255,255,0.05) 40%, transparent 70%) !important; }
        .auth-officer-card::before { background: linear-gradient(90deg, #1e293b, #475569) !important; }
        .officer-pill { display: inline-block; padding: 4px 12px; background: #1e293b; color: var(--yellow); border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 12px; }
        .officer-foot-cta { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: var(--accent); color: #fff; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; }
        .officer-foot-cta:hover { background: var(--accent-dark); color: #fff; text-decoration: none; }
        .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.7); z-index: 1000; align-items: center; justify-content: center; padding: 20px; }
        .modal-backdrop.open { display: flex; }
        .modal-card { background: #fff; border-radius: 12px; width: 100%; max-width: 640px; max-height: 80vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .modal-head { background: #1e293b; color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; font-weight: 600; }
        .modal-close { background: rgba(255,255,255,0.15); color: #fff; border: none; width: 28px; height: 28px; border-radius: 4px; cursor: pointer; font-size: 18px; line-height: 1; }
        .modal-body { padding: 0; overflow-y: auto; }
        .modal-foot { background: var(--grey-bg); padding: 12px 20px; font-size: 12px; color: var(--slate); border-top: 1px solid var(--border); }
        .role-pill { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; }
        .role-admin { background: #fee2e2; color: #b91c1c; }
        .role-supervisor { background: #fef3c7; color: #b45309; }
        .role-officer { background: #dbeafe; color: #1d4ed8; }
        /* Strip Filament chrome inside our card */
        .auth-officer-card .fi-section, .auth-officer-card .fi-fo, .auth-officer-card .fi-section-content-ctn { background: transparent !important; border: none !important; box-shadow: none !important; padding: 0 !important; }
        .auth-officer-card .fi-section-content { padding: 0 !important; }
        .auth-officer-card form > div, .auth-officer-card .fi-fo-component-ctn { gap: 14px !important; }

        /* Match public login form control styling */
        .auth-officer-card .fi-fo-field-wrp-label,
        .auth-officer-card label.fi-fo-field-wrp-label,
        .auth-officer-card .fi-input-wrp-label { display: block; font-size: 12px; font-weight: 500; color: var(--slate); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .auth-officer-card .fi-fo-field-wrp-label *, .auth-officer-card label.fi-fo-field-wrp-label * { color: var(--slate) !important; font-size: 12px !important; font-weight: 500 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; }
        .auth-officer-card .fi-fo-field-wrp-label sup, .auth-officer-card label sup { color: #b91c1c !important; }
        .auth-officer-card .fi-fo-field-wrp { margin-bottom: 14px; }

        .auth-officer-card .fi-input-wrp { background: #fff !important; border: 1px solid var(--border) !important; border-radius: 6px !important; box-shadow: none !important; transition: all 150ms; }
        .auth-officer-card .fi-input-wrp:focus-within { border-color: #1e293b !important; box-shadow: 0 0 0 3px rgba(30,41,59,0.15) !important; }
        .auth-officer-card .fi-input-wrp input,
        .auth-officer-card .fi-input { padding: 10px 14px !important; font-size: 13.5px !important; font-family: 'Poppins', sans-serif !important; color: var(--navy) !important; background: transparent !important; border: none !important; outline: none !important; box-shadow: none !important; }
        .auth-officer-card .fi-input::placeholder { color: #9aabbc !important; }

        /* Checkbox */
        .auth-officer-card .fi-checkbox input { accent-color: #1e293b; }
        .auth-officer-card .fi-fo-checkbox-row { padding: 4px 0; }
        .auth-officer-card .fi-fo-checkbox-row label { font-size: 13px; color: var(--navy); text-transform: none; letter-spacing: 0; font-weight: 400; }

        /* Hide default Filament submit button (we use our own) */
        .auth-officer-card .fi-form-actions, .auth-officer-card .fi-ac { display: none !important; }

        /* Password reveal eye icon */
        .auth-officer-card .fi-input-wrp button { background: transparent !important; border: none !important; color: var(--slate) !important; }
        .auth-officer-card .fi-input-wrp button:hover { color: var(--navy) !important; }
    </style>
</head>
<body>
    <div class="auth-split">
        <aside class="auth-left auth-officer-left">
            <div>
                <div class="flex gap-3 items-center mb-4">
                    <img src="{{ asset('img/logo_jata.png') }}" alt="Jata Negara" style="height: 80px;">
                    <img src="{{ asset('img/logo_jpn.png') }}" alt="JPN" style="height: 76px;">
                </div>
                <span class="badge-portal" style="background: rgba(255,204,0,0.15); color: var(--yellow);">Portal Pegawai JPN</span>
                <h1 style="margin-top: 24px;">INPReS<br><span style="font-weight: 400; font-size: 22px; opacity: 0.85;">Sistem Pendaftaran Bersepadu</span></h1>
                <p style="opacity: 0.85; margin-top: 12px;">Akses dalaman pegawai, penyelia, dan pentadbir.</p>
                <ul class="features">
                    <li>Antrian permohonan dengan keutamaan SLA</li>
                    <li>Semakan dokumen + AI Review Assistant</li>
                    <li>Audit trail kekal</li>
                    <li>Dashboard pengurusan & pelaporan</li>
                </ul>
            </div>
            <div style="font-size: 12px; opacity: 0.75;">
                © {{ date('Y') }} Jabatan Pendaftaran Negara Malaysia<br>
                Akses terhad kepada kakitangan dengan akaun JPN.
            </div>
        </aside>
        <section class="auth-right">
            <div style="width: 100%; max-width: 460px;">
                <a href="{{ url('/') }}" class="btn-ghost" style="margin-bottom: 18px; display: inline-block;">← Kembali ke Laman Utama</a>
                {{ $slot }}
                <div style="text-align: center; margin-top: 18px;">
                    <a href="{{ route('login') }}" class="officer-foot-cta">
                        👤 Pengguna Awam? Log Masuk di Portal Awam →
                    </a>
                </div>
            </div>
        </section>
    </div>
    @filamentScripts
    @livewire('notifications')
    <script>
        function openOfficerDemo() { document.getElementById('officerDemoModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeOfficerDemo() { document.getElementById('officerDemoModal').classList.remove('open'); document.body.style.overflow = ''; }
        function fillOfficerCredentials(email, pw) {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(el => {
                if (el.type === 'email') { el.value = email; el.dispatchEvent(new Event('input', {bubbles: true})); el.dispatchEvent(new Event('change', {bubbles: true})); }
                if (el.type === 'password') { el.value = pw; el.dispatchEvent(new Event('input', {bubbles: true})); el.dispatchEvent(new Event('change', {bubbles: true})); }
            });
            closeOfficerDemo();
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeOfficerDemo(); });
    </script>
</body>
</html>
