@props([
    'variant' => 'primary', // 'primary', 'secondary', 'success', 'warning', 'danger', 'info'
    'icon' => null
])
@php
    $variants = [
        'primary' => ['rgba(199, 91, 63, 0.1)', 'var(--primary-color)'],
        'secondary' => ['rgba(107, 142, 90, 0.1)', 'var(--secondary-color)'],
        'success' => ['rgba(91, 168, 124, 0.1)', 'var(--success-color)'],
        'warning' => ['rgba(212, 148, 58, 0.1)', 'var(--warning-color)'],
        'danger' => ['rgba(217, 79, 79, 0.1)', 'var(--danger-color)'],
        'info' => ['rgba(122, 107, 93, 0.1)', '#7A6B5D'],
    ];
    $bg = $variants[$variant][0] ?? $variants['primary'][0];
    $color = $variants[$variant][1] ?? $variants['primary'][1];

    // Default icons for variants
    $defaultIcons = [
        'primary' => 'fas fa-circle',
        'success' => 'fas fa-check-circle',
        'warning' => 'fas fa-exclamation-circle',
        'danger' => 'fas fa-times-circle',
        'info' => 'fas fa-info-circle',
    ];
@endphp
<span {{ $attributes->merge(['class' => 'badge-modern']) }} style="background: {{ $bg }}; color: {{ $color }};">
    @if($icon)
        <i class="{{ $icon }}" @if($icon === 'fas fa-circle') style="font-size: 0.5rem;" @endif></i>
    @endif
    {{ $slot }}
</span>
