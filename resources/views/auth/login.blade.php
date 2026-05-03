<x-layouts.auth-split>
    <div class="auth-card">
        <div style="display: inline-block; padding: 4px 12px; background: var(--accent-bg); color: var(--accent); border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 12px;">Portal Pengguna Awam</div>
        <h2 class="mt-0 mb-2">Log Masuk Awam</h2>
        <p class="muted mb-4">Untuk warganegara menguruskan permohonan kelahiran, MyKad, perkahwinan.</p>

        @if ($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="nama@contoh.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kata Laluan</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="flex items-center justify-between mb-4">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 13px;">
                    <input type="checkbox" name="remember" style="accent-color: var(--accent);"> Ingat saya
                </label>
                <a href="#" style="font-size: 13px;">Lupa Kata Laluan?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Log Masuk</button>
        </form>

        <div style="border-top: 1px solid var(--border); margin: 20px 0; padding-top: 16px; text-align: center; font-size: 13px;">
            Belum ada akaun? <a href="{{ route('register') }}">Daftar Akaun</a>
        </div>

        <div class="text-center mt-4">
            <a href="javascript:void(0)" onclick="openDemo()" class="btn-ghost" style="font-size: 13px; text-decoration: underline;">Lihat Akaun Demo →</a>
        </div>
    </div>

    <div style="text-align: center; margin-top: 18px;">
        <a href="{{ url('/admin/login') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: var(--navy); color: #fff; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none;">
            🛡 Pegawai JPN? Log Masuk di Portal Pegawai →
        </a>
    </div>

    <div class="modal-backdrop" id="demoModal">
        <div class="modal-card">
            <div class="modal-head">
                <span>Akaun Demo INPReS</span>
                <button onclick="closeDemo()" class="modal-close">✕</button>
            </div>
            <div class="modal-body">
                <table class="tbl">
                    <thead><tr><th>Peranan</th><th>Email</th><th>Kata Laluan</th></tr></thead>
                    <tbody>
                    @foreach ($demoUsers as $u)
                        <tr onclick="fillCredentials('{{ $u->email }}', 'Password123!')" style="cursor: pointer;">
                            <td><span class="badge badge-green">{{ ucfirst($u->role) }}</span></td>
                            <td>{{ $u->email }}</td>
                            <td><code>Password123!</code></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-foot">
                <small>Klik baris untuk auto-isi borang.</small>
            </div>
        </div>
    </div>

    <style>
        .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(6,27,49,0.6); z-index: 100; align-items: center; justify-content: center; padding: 20px; }
        .modal-backdrop.open { display: flex; }
        .modal-card { background: #fff; border-radius: 12px; width: 100%; max-width: 640px; max-height: 80vh; overflow: hidden; display: flex; flex-direction: column; }
        .modal-head { background: var(--accent-dark); color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; font-weight: 600; }
        .modal-close { background: rgba(255,255,255,0.15); color: #fff; border: none; width: 28px; height: 28px; border-radius: 4px; cursor: pointer; }
        .modal-body { padding: 0; overflow-y: auto; }
        .modal-foot { background: var(--grey-bg); padding: 12px 20px; font-size: 12px; color: var(--slate); border-top: 1px solid var(--border); }
    </style>

    <script>
        function openDemo() { document.getElementById('demoModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeDemo() { document.getElementById('demoModal').classList.remove('open'); document.body.style.overflow = ''; }
        function fillCredentials(e, p) { document.getElementById('email').value = e; document.getElementById('password').value = p; closeDemo(); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDemo(); });
        document.getElementById('demoModal').addEventListener('click', e => { if (e.target.id === 'demoModal') closeDemo(); });
    </script>
</x-layouts.auth-split>
