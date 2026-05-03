@props(['level'])
@php
    $cls = 'pill-' . $level;
    $label = match ($level) {
        'high' => 'Tinggi',
        'medium' => 'Sederhana',
        'normal' => 'Biasa',
        default => $level,
    };
@endphp
<span class="pill {{ $cls }}">{{ $label }}</span>
