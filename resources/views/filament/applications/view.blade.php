<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/inspres.css') }}">

    <div class="row row-2" style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <div>
            {{-- Application summary --}}
            <div class="card card-accent">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="mt-0 mb-0">{{ $this->record->moduleLabel() }}</h3>
                        <div class="muted">{{ $this->record->app_no }}</div>
                    </div>
                    <div class="flex gap-2">
                        <x-priority-badge :level="$this->record->priority_level" />
                        <x-sla-badge :application="$this->record" />
                    </div>
                </div>
                <div class="row row-2">
                    <div><div class="muted" style="font-size: 11px; text-transform: uppercase;">Pemohon</div><strong>{{ $this->record->applicant->name }}</strong><div class="muted">{{ $this->record->applicant->nric }}</div></div>
                    <div><div class="muted" style="font-size: 11px; text-transform: uppercase;">Cawangan</div><strong>{{ $this->record->branch?->name ?? '—' }}</strong></div>
                    <div><div class="muted" style="font-size: 11px; text-transform: uppercase;">Status</div><span class="badge badge-blue">{{ $this->record->statusLabel() }}</span></div>
                    <div><div class="muted" style="font-size: 11px; text-transform: uppercase;">Dihantar</div>{{ $this->record->submitted_at?->translatedFormat('d M Y, H:i') ?? '—' }}</div>
                </div>
            </div>

            {{-- AI panel --}}
            <div class="mt-4">
                <x-ai-panel :application="$this->record" />
            </div>

            {{-- Module-specific details --}}
            @if ($this->record->birth)
                <div class="card mt-4">
                    <h3 class="mt-0">Maklumat Kelahiran</h3>
                    <div class="row row-2">
                        <div><div class="muted">Anak</div><strong>{{ $this->record->birth->child_name }}</strong></div>
                        <div><div class="muted">Jantina</div>{{ ucfirst($this->record->birth->child_gender) }}</div>
                        <div><div class="muted">Tarikh Lahir</div>{{ $this->record->birth->child_dob->translatedFormat('d M Y') }}</div>
                        <div><div class="muted">Hospital</div>{{ $this->record->birth->hospital }}</div>
                        <div><div class="muted">Bapa</div>{{ $this->record->birth->father_name }} ({{ $this->record->birth->father_nric }})</div>
                        <div><div class="muted">Ibu</div>{{ $this->record->birth->mother_name }} ({{ $this->record->birth->mother_nric }})</div>
                    </div>
                </div>
            @endif

            @if ($this->record->mykad)
                <div class="card mt-4">
                    <h3 class="mt-0">Maklumat MyKad</h3>
                    <div class="row row-2">
                        <div><div class="muted">Jenis</div>{{ str_replace('_', ' ', ucfirst($this->record->mykad->type)) }}</div>
                        <div><div class="muted">Nama</div><strong>{{ $this->record->mykad->full_name }}</strong></div>
                        <div><div class="muted">No. KP</div>{{ $this->record->mykad->nric }}</div>
                        <div><div class="muted">Biometrik (ABIS)</div><span class="badge badge-green">{{ ucfirst($this->record->mykad->biometric_status) }}</span></div>
                        <div><div class="muted">Senarai Hitam</div><span class="badge badge-green">{{ ucfirst($this->record->mykad->blacklist_check) }}</span></div>
                    </div>
                </div>
            @endif

            @if ($this->record->marriage)
                <div class="card mt-4">
                    <h3 class="mt-0">Maklumat Perkahwinan</h3>
                    <div class="row row-2">
                        <div><div class="muted">Pengantin Lelaki</div>{{ $this->record->marriage->groom_name }} ({{ $this->record->marriage->groom_nric }})</div>
                        <div><div class="muted">Pengantin Perempuan</div>{{ $this->record->marriage->bride_name }} ({{ $this->record->marriage->bride_nric }})</div>
                        <div><div class="muted">Saksi 1</div>{{ $this->record->marriage->witness1_name }}</div>
                        <div><div class="muted">Saksi 2</div>{{ $this->record->marriage->witness2_name }}</div>
                        <div><div class="muted">Caveat</div><span class="badge badge-green">{{ ucfirst($this->record->marriage->caveat_status) }}</span></div>
                        <div><div class="muted">Temujanji</div>{{ $this->record->marriage->appointment_at?->translatedFormat('d M Y, H:i') ?? '—' }}</div>
                    </div>
                </div>
            @endif

            {{-- Documents --}}
            <div class="card mt-4">
                <h3 class="mt-0">Dokumen</h3>
                <table class="tbl">
                    <thead><tr><th>Dokumen</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($this->record->documents as $doc)
                        <tr>
                            <td><strong>{{ $doc->label }}</strong><div class="muted" style="font-size: 12px;">{{ $doc->file_name ?? '—' }}</div></td>
                            <td>@if ($doc->verified)<span class="badge badge-green">✓ Disahkan</span>@else<span class="badge badge-amber">Menunggu</span>@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{-- Smart tracker --}}
            <x-smart-tracker :application="$this->record" />

            {{-- Audit timeline --}}
            <div class="card mt-4">
                <h3 class="mt-0">Audit Trail</h3>
                <div style="position: relative; padding-left: 20px; border-left: 2px solid var(--border); margin-top: 12px;">
                    @forelse ($this->record->auditLogs as $log)
                        <div style="margin-bottom: 16px; position: relative;">
                            <div style="position: absolute; left: -27px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: var(--accent);"></div>
                            <div style="font-size: 11px; color: var(--slate);">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</div>
                            <div style="font-weight: 600; font-size: 14px;">{{ str_replace('_', ' ', ucfirst($log->action)) }}</div>
                            <div class="muted" style="font-size: 12px;">{{ $log->user_label }}</div>
                            @if ($log->status_before)<div class="muted" style="font-size: 12px;">{{ $log->status_before }} → {{ $log->status_after }}</div>@endif
                        </div>
                    @empty
                        <div class="muted">Tiada log lagi.</div>
                    @endforelse
                </div>
            </div>

            {{-- Certificate --}}
            @if ($this->record->certificate)
                <div class="card mt-4">
                    <h3 class="mt-0">Sijil</h3>
                    <div class="muted">No. Sijil</div><strong>{{ $this->record->certificate->cert_no }}</strong>
                    <div class="mt-3">
                        <a href="{{ url('/verify/certificate/' . $this->record->certificate->cert_no) }}" target="_blank" class="btn btn-primary">QR Pengesahan</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
