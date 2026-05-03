<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($users = $this->getUsers())
    @php($byRole = $users->groupBy('role'))

    <div class="card" style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 4px solid #d97706; padding: 18px 22px;">
        <div class="flex items-center gap-3">
            <span style="font-size: 24px;">🔐</span>
            <div>
                <strong style="color: #92400e;">Modul Separa Diaktifkan</strong>
                <div class="muted" style="font-size: 13px; color: #78350f;">Senarai pengguna dan peranan boleh dilihat. Tindakan ACL penuh, polisi kata laluan, MFA, dan audit dasar akan datang.</div>
            </div>
        </div>
    </div>

    <div class="row row-4 mt-6" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <div class="card" style="border-left: 4px solid var(--red);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Pentadbir</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--red);">{{ $byRole->get('admin', collect())->count() }}</div>
        </div>
        <div class="card" style="border-left: 4px solid var(--amber);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Penyelia</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--amber);">{{ $byRole->get('supervisor', collect())->count() }}</div>
        </div>
        <div class="card" style="border-left: 4px solid var(--accent);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Pegawai</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--accent);">{{ $byRole->get('officer', collect())->count() }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #16a34a;">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Pengguna Awam</div>
            <div style="font-size: 28px; font-weight: 700; color: #15803d;">{{ $byRole->get('public', collect())->count() }}</div>
        </div>
    </div>

    <div class="card mt-6" style="padding: 0; overflow: hidden;">
        <div style="padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 class="mt-0 mb-0" style="font-size: 16px;">Senarai Akaun Pengguna</h3>
            <span class="badge badge-amber">Read-only · Pelaksanaan ACL akan datang</span>
        </div>
        <table class="tbl">
            <thead><tr><th>Nama</th><th>Email</th><th>NRIC</th><th>Peranan</th><th>Cawangan</th><th>Akses Panel</th></tr></thead>
            <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>
                        <strong>{{ $u->name }}</strong>
                        @if ($u->is_demo)
                            <span class="badge badge-grey" style="margin-left: 6px; font-size: 10px;">Demo</span>
                        @endif
                    </td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->nric ?? '—' }}</td>
                    <td>
                        <span class="badge {{ ['admin' => 'badge-red', 'supervisor' => 'badge-amber', 'officer' => 'badge-blue', 'public' => 'badge-green'][$u->role] ?? 'badge-grey' }}">
                            {{ $u->roleLabel() }}
                        </span>
                    </td>
                    <td>{{ $u->branch?->name ?? '—' }}</td>
                    <td>
                        @if (in_array($u->role, ['officer','supervisor','admin'], true))
                            <span class="badge badge-green">/admin</span>
                        @else
                            <span class="badge badge-grey">/dashboard</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row row-2 mt-6" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
        <div class="card">
            <h3 class="mt-0">Peranan & ACL Sedia Ada</h3>
            <table style="width: 100%; font-size: 13px;">
                <tr><td><strong>Pentadbir</strong></td><td>Akses penuh sistem, semua modul.</td></tr>
                <tr><td><strong>Penyelia</strong></td><td>Lulus permohonan, akses laporan & DWH.</td></tr>
                <tr><td><strong>Pegawai</strong></td><td>Semak permohonan, dokumen, dan resit.</td></tr>
                <tr><td><strong>Pengguna Awam</strong></td><td>Hantar permohonan, semak status.</td></tr>
            </table>
        </div>
        <div class="card" style="background: var(--accent-bg); border: 1px dashed var(--accent);">
            <h3 class="mt-0">Belum Diaktifkan</h3>
            <ul style="margin: 0; padding-left: 18px; color: var(--slate); font-size: 13.5px;">
                <li>Cipta / kemaskini / lumpuh akaun pengguna</li>
                <li>Tetapkan peranan custom dengan ACL granular</li>
                <li>Polisi kata laluan (kerumitan, tempoh luput)</li>
                <li>MFA / 2FA wajib untuk peranan terpilih</li>
                <li>Audit log percubaan log masuk</li>
                <li>Integrasi SSO (e.g., MyDigital ID, AD)</li>
                <li>Sesi & token penghantaran kekal</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
