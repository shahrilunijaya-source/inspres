@props(['application'])
@php
    $steps = [
        1 => ['Draf Permohonan', 'Permohonan dibuat'],
        2 => ['Permohonan Dihantar', 'Permohonan dihantar untuk pemprosesan'],
        3 => ['Bayaran Selesai', 'Bayaran diterima'],
        4 => ['Semakan Dokumen', 'Pegawai semak lampiran'],
        5 => ['Semakan Pegawai', 'Pegawai luluskan permohonan'],
        6 => ['Diluluskan', 'Permohonan diluluskan oleh penyelia'],
        7 => ['Sijil Dijana', 'Sijil dikeluarkan dengan kod QR'],
        8 => ['Selesai', 'Permohonan selesai sepenuhnya'],
    ];
    $current = $application->trackerStep();
@endphp
<div class="card">
    <div class="flex items-center justify-between mb-4">
        <h3 class="mt-0 mb-0">Smart Tracker</h3>
        <span class="badge badge-blue">Status semasa: {{ $application->statusLabel() }}</span>
    </div>
    <div class="tracker">
        @foreach ($steps as $no => [$title, $desc])
            @php($state = $no < $current ? 'done' : ($no === $current ? 'current' : ''))
            <div class="tracker-step {{ $state }}">
                <div class="tracker-dot">@if($state === 'done')✓@else{{ $no }}@endif</div>
                <div>
                    <div class="tracker-title">{{ $title }}</div>
                    <div class="tracker-meta">{{ $desc }}@if($state === 'done') — selesai @endif</div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card mt-4" style="background: var(--accent-bg); border-color: var(--accent);">
        <div style="font-size: 12px; color: var(--slate); text-transform: uppercase; letter-spacing: 0.5px;">Tindakan Seterusnya</div>
        <div style="font-size: 15px; font-weight: 600; margin-top: 4px;">
            @switch($application->status)
                @case('submitted') Menunggu pemprosesan oleh pegawai. @break
                @case('payment_pending') Sila lengkapkan bayaran untuk teruskan. @break
                @case('doc_review') Pegawai sedang menyemak dokumen anda. @break
                @case('officer_review') Pegawai sedang menilai permohonan. @break
                @case('approved') Penyelia telah meluluskan — sijil sedang dijana. @break
                @case('cert_generated') Sijil tersedia untuk dimuat turun. @break
                @case('completed') Permohonan selesai — sijil disahkan rasmi. @break
                @default Tiada tindakan diperlukan.
            @endswitch
        </div>
        <div class="muted mt-2">Anggaran selesai: {{ $application->estimated_completion_at?->translatedFormat('d M Y') ?? '—' }}</div>
    </div>
</div>
