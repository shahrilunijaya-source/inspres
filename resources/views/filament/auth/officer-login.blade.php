<div>
    <div class="auth-card auth-officer-card">
        <div class="officer-pill">🛡 Portal Pegawai</div>
        <h2 class="mt-0 mb-2">Log Masuk Pegawai</h2>
        <p class="muted mb-4">Untuk pegawai, penyelia, dan pentadbir JPN sahaja.</p>

        <form wire:submit="authenticate">
            {{ $this->form }}

            <button type="submit" style="width: 100%; padding: 12px; background: #1e293b; color: #fff; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; margin-top: 18px; transition: all 150ms;">
                Log Masuk Pegawai
            </button>
        </form>

        <div style="border-top: 1px solid var(--border); margin: 20px 0; padding-top: 16px; text-align: center; font-size: 13px; color: var(--slate);">
            Akaun pegawai diuruskan oleh Pentadbir Sistem
        </div>

        <div class="text-center mt-4">
            <a href="javascript:void(0)" onclick="openOfficerDemo()" style="font-size: 13px; text-decoration: underline; color: var(--slate);">Lihat Akaun Demo →</a>
        </div>
    </div>

    <div class="modal-backdrop" id="officerDemoModal" onclick="if(event.target.id==='officerDemoModal') closeOfficerDemo()">
        <div class="modal-card">
            <div class="modal-head">
                <span>Akaun Demo Pegawai</span>
                <button onclick="closeOfficerDemo()" class="modal-close" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <table class="tbl">
                    <thead><tr><th>Peranan</th><th>Nama</th><th>Email</th><th>Kata Laluan</th></tr></thead>
                    <tbody>
                    @foreach ($this->getDemoUsers() as $u)
                        <tr style="cursor: pointer;" onclick="fillOfficerCredentials('{{ $u->email }}', 'Password123!')">
                            <td><span class="role-pill role-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><code>Password123!</code></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-foot">Klik baris untuk auto-isi borang. Demo sahaja — bukan akaun pengeluaran.</div>
        </div>
    </div>
</div>
