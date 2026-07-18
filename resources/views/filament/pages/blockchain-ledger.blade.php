<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">
    @php($d = $this->getData())

    <div class="row row-4" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        <div class="card" style="border-left:4px solid #a855f7;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Jumlah Blok</div>
            <div style="font-size:26px;font-weight:700;color:#7c3aed;">#{{ number_format($d['total_blocks']) }}</div>
            <div class="muted" style="font-size:11px;">+{{ number_format($d['today_blocks']) }} hari ini</div>
        </div>
        <div class="card" style="border-left:4px solid #16a34a;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Rangkaian</div>
            <div style="font-size:14px;font-weight:600;line-height:1.5;margin-top:4px;">
                {{ $d['peers'] }} peer · {{ $d['orderers'] }} orderer
            </div>
            <div class="muted" style="font-size:11px;">{{ $d['channels'] }} channel aktif</div>
        </div>
        <div class="card" style="border-left:4px solid var(--accent);">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Block Time Purata</div>
            <div style="font-size:26px;font-weight:700;color:var(--accent);">{{ $d['avg_block_ms'] }}ms</div>
            <div class="muted" style="font-size:11px;">RAFT consensus</div>
        </div>
        <div class="card" style="border-left:4px solid #dc2626;">
            <div class="muted" style="font-size:11px;text-transform:uppercase;">Bukti Mahkamah</div>
            <div style="font-size:14px;font-weight:600;line-height:1.4;margin-top:4px;color:#0b1e3f;">Akta Keterangan 1950 S.90A</div>
            <div class="muted" style="font-size:11px;">Bukti dokumentari diterima tanpa percaya pentadbir</div>
        </div>
    </div>

    <div class="row mt-6" style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
        <div class="card" style="padding:0;overflow:hidden;">
            <div style="padding:14px 22px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
                <h3 class="mt-0 mb-0" style="font-size:15px;">Blok Terkini · Lejer Immutable</h3>
                <span class="badge badge-green">● 8 blok / 4 saat</span>
            </div>
            <table class="tbl">
                <thead><tr><th>Blok</th><th>Hash</th><th>Chaincode</th><th>Event</th><th>Subjek</th><th>Masa</th></tr></thead>
                <tbody>
                @foreach($d['recent'] as $r)
                    <tr>
                        <td><strong style="font-family:monospace;color:#7c3aed;">#{{ $r['block'] }}</strong></td>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['hash'] }}</td>
                        <td><span class="badge badge-amber">{{ $r['cc'] }}</span></td>
                        <td style="font-weight:600;font-size:12px;">{{ $r['event'] }}</td>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['subj'] }}</td>
                        <td style="font-family:monospace;font-size:11px;">{{ $r['ts'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <div class="card">
                <h3 class="mt-0" style="font-size:14px;">Topologi Rangkaian</h3>
                <div style="display:flex;flex-direction:column;gap:8px;font-size:12px;">
                    @foreach([['peer0.jpn-putrajaya','142.789 blok','green'],['peer1.jpn-shah-alam','142.788 blok','green'],['peer2.jpn-johor','142.788 blok','green'],['peer3.jpn-kk-sabah','142.785 blok','amber'],['orderer0.mampu','—','green'],['orderer1.mampu','—','green'],['orderer2.mampu-dr','—','green']] as $n)
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 8px;background:#f8fafc;border-radius:6px;">
                            <span style="font-family:monospace;font-size:11px;">{{ $n[0] }}</span>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <span class="muted" style="font-size:10px;">{{ $n[1] }}</span>
                                <span class="badge badge-{{ $n[2] }}" style="font-size:10px;">●</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card mt-6">
                <h3 class="mt-0" style="font-size:14px;">Chaincode Dipasang</h3>
                <div style="display:flex;flex-direction:column;gap:6px;font-size:12px;">
                    @foreach(['kelahiran-cc v2.1','kematian-cc v2.0','mykad-cc v3.0','kahwin-cc v1.8','warganegara-cc v2.2','anak-angkat-cc v1.5','audit-cc v4.1'] as $cc)
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed var(--border);">
                            <span style="font-family:monospace;">{{ $cc }}</span>
                            <span class="badge badge-green" style="font-size:10px;">INSTANTIATED</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-6" style="background:var(--accent-bg);border:1px dashed var(--accent);">
        <h3 class="mt-0">Justifikasi LAMPIRAN A Para 2.1(viii)</h3>
        <p style="margin:0;color:var(--slate);font-size:13px;">Hyperledger Fabric immutable ledger mewajibkan setiap rekod kelahiran, MyKad, perkahwinan, perceraian, dan kematian dicatat dengan crypto signature. Sekali blok diterbit, tiada sesiapa boleh ubah atau padam — termasuk pentadbir JPN sendiri. Memenuhi syarat bukti dokumentari di mahkamah tanpa perlu percaya kepada pentadbir.</p>
    </div>
</x-filament-panels::page>
