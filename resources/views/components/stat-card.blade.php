@props([
    'icon' => 'fas fa-chart-bar',
    'label',
    'value',
    'trend' => null,
    'trendValue' => null,
    'trendDirection' => 'up', // 'up' or 'down'
    'variant' => 'primary' // 'primary', 'secondary', 'success', 'warning', 'danger'
])

@php
    $colors = [
        'primary' => ['var(--primary-color)', 'rgba(199, 91, 63, 0.1)'],
        'secondary' => ['var(--secondary-color)', 'rgba(107, 142, 90, 0.1)'],
        'success' => ['var(--success-color)', 'rgba(91, 168, 124, 0.1)'],
        'warning' => ['var(--warning-color)', 'rgba(212, 148, 58, 0.1)'],
        'danger' => ['var(--danger-color)', 'rgba(217, 79, 79, 0.1)'],
    ];
    $color = $colors[$variant][0] ?? $colors['primary'][0];
    $bgColor = $colors[$variant][1] ?? $colors['primary'][1];
    $trendColor = $trendDirection === 'up' ? 'var(--success-color)' : 'var(--danger-color)';
    $trendIcon = $trendDirection === 'up' ? 'fa-arrow-up' : 'fa-arrow-down';
@endphp

<div class="stat-card" style="--accent-color: {{ $color }};">
    <div class="stat-icon" style="background: {{ $bgColor }}; color: {{ $color }};">
        <i class="{{ $icon }}"></i>
    </div>
    <p class="text-muted mb-1" style="font-size: 0.875rem;">{{ $label ?? '' }}</p>
    <h3 class="mb-2" style="color: var(--text-primary); font-weight: 700;">{{ $value }}</h3>
    @if($trendValue)
        <small style="color: {{ $trendColor }}; font-weight: 600;">
            <i class="fas {{ $trendIcon }}"></i> {{ $trendValue }}
        </small>
    @endif
</div>
