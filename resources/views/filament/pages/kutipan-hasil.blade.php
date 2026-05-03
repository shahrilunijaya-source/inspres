<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($s = $this->getStats())

    <div class="card" style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 4px solid #d97706; padding: 18px 22px;">
        <div class="flex items-center gap-3">
            <span style="font-size: 24px;">⚠️</span>
            <div>
                <strong style="color: #92400e;">Modul Separa Diaktifkan</strong>
                <div class="muted" style="font-size: 13px; color: #78350f;">Modul ini menyokong rekod bayaran asas sahaja. Modul penuh (resit, rekonsiliasi bank, laporan kewangan, integrasi FPX) akan disediakan dalam fasa pelaksanaan sebenar.</div>
            </div>
        </div>
    </div>

    <div class="row row-4 mt-6" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        <div class="card" style="border-left: 4px solid var(--accent);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Jumlah Hasil Dikutip</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--accent);">RM {{ number_format($s['total_collected'], 2) }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #16a34a;">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Hari Ini (Bilangan)</div>
            <div style="font-size: 28px; font-weight: 700; color: #15803d;">{{ $s['today_count'] }}</div>
        </div>
        <div class="card" style="border-left: 4px solid #16a34a;">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Hari Ini (Jumlah)</div>
            <div style="font-size: 28px; font-weight: 700; color: #15803d;">RM {{ number_format($s['today_amount'], 2) }}</div>
        </div>
        <div class="card" style="border-left: 4px solid var(--amber);">
            <div class="muted" style="font-size: 11px; text-transform: uppercase;">Bayaran Tertunggak</div>
            <div style="font-size: 28px; font-weight: 700; color: var(--amber);">{{ $s['pending'] }}</div>
        </div>
    </div>

    <div class="card mt-6" style="padding: 0; overflow: hidden;">
        <div style="padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
            <h3 class="mt-0 mb-0" style="font-size: 16px;">Transaksi Terkini</h3>
            <span class="badge badge-amber">10 transaksi terbaru</span>
        </div>
        <table class="tbl">
            <thead><tr><th>Resit</th><th>Permohonan</th><th>Pemohon</th><th>Modul</th><th>Jumlah</th><th>Status</th><th>Bayar Pada</th></tr></thead>
            <tbody>
            @forelse ($s['transactions'] as $p)
                <tr>
                    <td><strong style="font-family: monospace;">{{ $p->receipt_no ?? '—' }}</strong></td>
                    <td>{{ $p->application->app_no }}</td>
                    <td>{{ $p->application->applicant->name }}</td>
                    <td>{{ $p->application->moduleLabel() }}</td>
                    <td><strong>RM {{ number_format($p->amount, 2) }}</strong></td>
                    <td>
                        @if ($p->status === 'paid')<span class="badge badge-green">Selesai</span>
                        @elseif ($p->status === 'refunded')<span class="badge badge-red">Pulangan</span>
                        @else<span class="badge badge-amber">Tertunggak</span>@endif
                    </td>
                    <td>{{ $p->paid_at?->translatedFormat('d M Y, H:i') ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted text-center" style="padding: 32px;">Tiada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card mt-6" style="background: var(--accent-bg); border: 1px dashed var(--accent);">
        <h3 class="mt-0">Belum Diaktifkan Dalam Prototaip</h3>
        <ul style="margin: 0; padding-left: 18px; color: var(--slate);">
            <li>Penjanaan resit rasmi (PDF dengan QR pengesahan)</li>
            <li>Rekonsiliasi bank (BIMB, Maybank, RHB)</li>
            <li>Integrasi FPX langsung</li>
            <li>Laporan kewangan harian / bulanan / tahunan</li>
            <li>Pulangan bayaran (refund flow)</li>
            <li>Modul EFT untuk bayaran kakitangan</li>
        </ul>
    </div>
</x-filament-panels::page>
