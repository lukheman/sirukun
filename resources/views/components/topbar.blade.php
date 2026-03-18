@props([
    'userName' => 'John Doe',
    'userRole' => 'Administrator',
    'userInitials' => null,
    'notificationCount' => 0,
    'searchPlaceholder' => 'Search anything...',
    'showLogout' => true,
    'showThemeToggle' => false
])

@php
    // Generate initials from user name if not provided
    $initials = $userInitials;
    if (!$initials && $userName) {
        $words = explode(' ', $userName);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        $initials = substr($initials, 0, 2);
    }
@endphp

<div class="topbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-link mobile-toggle me-3" onclick="toggleSidebar()" style="color: var(--text-secondary);">
            <i class="fas fa-bars"></i>
        </button>

        {{--
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="{{ $searchPlaceholder }}">
        </div>
     --}}

    </div>
    <div class="d-flex align-items-center gap-3">

        {{-- 

        <button class="btn btn-link position-relative" style="color: var(--text-secondary);">
            <i class="fas fa-bell" style="font-size: 1.15rem;"></i>
            @if($notificationCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="font-size: 0.6rem; background: var(--primary-color);">{{ $notificationCount }}</span>
            @endif
        </button>
        --}}


        <a href="{{ route('admin.profile') }}" class="d-flex align-items-center gap-2 text-decoration-none" title="Go to Profile">
            <div class="user-avatar">{{ $initials }}</div>
            <div class="d-none d-md-block">
                <div class="user-name">{{ $userName }}</div>
                <small class="user-role">{{ $userRole }}</small>
            </div>
        </a>
        @if($showLogout)
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link" title="Logout" style="color: var(--text-secondary);">
                    <i class="fas fa-sign-out-alt" style="font-size: 1.15rem;"></i>
                </button>
            </form>
        @endif
        {{ $actions ?? '' }}
    </div>
</div>

