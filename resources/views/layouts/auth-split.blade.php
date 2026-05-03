<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Log Masuk — INPReS' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
</head>
<body>
    <div class="auth-split">
        <aside class="auth-left">
            <div>
                <span class="badge-portal">Portal Pengguna Awam</span>
                <h1 style="margin-top: 28px;">INPReS<br><span style="font-weight: 400; font-size: 22px; opacity: 0.85;">Sistem Pendaftaran Bersepadu</span></h1>
                <p style="opacity: 0.85; margin-top: 12px;">Jabatan Pendaftaran Negara Malaysia</p>
                <ul class="features">
                    <li>Pendaftaran kelahiran, MyKad, perkahwinan dalam talian</li>
                    <li>Penjejak permohonan masa nyata</li>
                    <li>Pengesahan sijil melalui kod QR</li>
                    <li>Notifikasi automatik untuk setiap status</li>
                </ul>
            </div>
            <div style="font-size: 12px; opacity: 0.75;">© {{ date('Y') }} Jabatan Pendaftaran Negara Malaysia</div>
        </aside>
        <section class="auth-right">
            <div style="width: 100%; max-width: 460px;">
                <a href="{{ url('/') }}" class="btn-ghost" style="margin-bottom: 18px; display: inline-block;">← Kembali ke Laman Utama</a>
                {{ $slot }}
            </div>
        </section>
    </div>
</body>
</html>
