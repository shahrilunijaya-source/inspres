@props(['application'])
@php
    $status = $application->sla_status;
    $cls = 'pill-' . str_replace('_', '-', $status);
    $label = match ($status) {
        'on_track' => 'On Track',
        'due_soon' => 'Due Soon',
        'breach_risk' => 'Breach Risk',
        'breached' => 'Breached',
        default => $status,
    };
    $days = $application->slaDaysRemaining();
@endphp
<span class="pill {{ $cls }}">
    @if ($status === 'breached')
        ⚠ Breached ({{ abs((int) $days) }}h lewat)
    @elseif ($days !== null)
        {{ $label }} — {{ $days }} hari
    @else
        {{ $label }}
    @endif
</span>
