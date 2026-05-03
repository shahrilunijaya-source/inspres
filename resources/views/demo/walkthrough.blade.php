@extends('layouts.public')

@section('content')
<section class="container" style="padding: 32px 24px;">
    <div class="card-accent" style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-mid) 100%); color: #fff; padding: 32px; border-radius: 12px;">
        <div style="font-size: 13px; opacity: 0.85;">Mod Walkthrough Klien</div>
        <h2 style="color: #fff; margin: 4px 0;">Demo INPReS — Langkah {{ $stepNo }} dari {{ $totalSteps }}</h2>
    </div>

    @if ($step)
        <div class="row row-2 mt-6">
            <div class="card">
                <div class="muted" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Langkah {{ $step->step_no }}</div>
                <h2 class="mt-2 mb-3">{{ $step->title }}</h2>
                <p>{{ $step->description }}</p>
                @if ($step->route_url)
                    <a href="{{ $step->route_url }}" target="_blank" class="btn btn-primary mt-3">Buka Skrin →</a>
                @endif
            </div>
            <div class="card" style="background: var(--accent-bg); border-left: 4px solid var(--accent);">
                <h3 class="mt-0">Nota Penyampai</h3>
                <p>{{ $step->presenter_notes }}</p>
            </div>
        </div>

        <div class="flex gap-3 mt-6 items-center">
            <a href="{{ route('demo.walkthrough', ['step' => max(1, $stepNo - 1)]) }}" class="btn btn-secondary">← Sebelumnya</a>
            <a href="{{ route('demo.walkthrough', ['step' => min($totalSteps, $stepNo + 1)]) }}" class="btn btn-primary">Seterusnya →</a>
            <div class="muted" style="margin-left: auto;">Kemajuan: {{ $stepNo }}/{{ $totalSteps }}</div>
        </div>
    @endif

    <div class="mt-6">
        <h3>Semua Langkah Demo</h3>
        <div class="card" style="padding: 0;">
            <table class="tbl">
                <thead><tr><th width="60">#</th><th>Tajuk</th><th>Pautan</th></tr></thead>
                <tbody>
                @foreach ($allSteps as $s)
                    <tr style="{{ $s->step_no === $stepNo ? 'background: var(--accent-bg);' : '' }}">
                        <td>{{ $s->step_no }}</td>
                        <td>
                            <a href="{{ route('demo.walkthrough', ['step' => $s->step_no]) }}"><strong>{{ $s->title }}</strong></a>
                            <div class="muted" style="font-size: 12px;">{{ $s->description }}</div>
                        </td>
                        <td>@if($s->route_url)<a href="{{ $s->route_url }}" target="_blank" class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px;">Skrin</a>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
