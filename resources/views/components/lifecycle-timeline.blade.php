@props(['events'])
<div class="card card-accent">
    <h3 class="mt-0">Citizen Lifecycle Journey</h3>
    <p class="muted mb-4">INPReS menyambungkan peristiwa penting kehidupan rakyat — dari pendaftaran kelahiran hingga rekod keluarga.</p>
    <div class="lifecycle">
        @foreach ($events as $event)
            <div class="lifecycle-step {{ $event->status }}">
                <div class="lifecycle-dot">{{ $loop->iteration }}</div>
                <div class="lifecycle-label">{{ $event->title }}</div>
                <div class="muted" style="font-size: 11px;">{{ $event->status === 'completed' ? '✓ Selesai' : ($event->status === 'current' ? 'Sedang dijalankan' : 'Akan datang') }}</div>
            </div>
        @endforeach
    </div>
</div>
