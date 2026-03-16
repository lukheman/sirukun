<div>
    {{-- Page Header --}}
    <x-page-header title="Dashboard Overview" subtitle="Welcome back! Here's what's happening today.">
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-plus">New Report</x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-dollar-sign" label="Total Revenue" value="$48,574"
                trend-value="12.5% from last month" trend-direction="up" variant="primary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-shopping-bag" label="New Orders" value="1,245"
                trend-value="8.2% from last month" trend-direction="up" variant="secondary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-users" label="Total Users" value="8,456" trend-value="15.3% from last month"
                trend-direction="up" variant="success" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-chart-pie" label="Conversion Rate" value="3.24%"
                trend-value="2.1% from last month" trend-direction="down" variant="warning" />
        </div>
    </div>

    {{-- Component Preview Section --}}
    <div class="component-preview"
        style="background: var(--bg-secondary); border-radius: 20px; padding: 2rem; box-shadow: var(--card-shadow); margin-bottom: 2rem;">
        <h2 class="mb-4" style="color: var(--text-primary); font-weight: 700;">UI Components Preview</h2>

        {{-- Buttons Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Buttons</div>
            <div class="d-flex flex-wrap gap-2">
                <x-button variant="primary">Primary Button</x-button>
                <x-button variant="secondary">Secondary Button</x-button>
                <x-button variant="success">Success Button</x-button>
                <x-button variant="warning">Warning Button</x-button>
                <x-button variant="danger">Danger Button</x-button>
                <x-button variant="outline">Outline Button</x-button>
            </div>
        </div>

        {{-- Badges Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Badges</div>
            <div class="d-flex flex-wrap gap-2">
                <x-badge variant="primary" icon="fas fa-circle">Primary</x-badge>
                <x-badge variant="success" icon="fas fa-check-circle">Success</x-badge>
                <x-badge variant="warning" icon="fas fa-exclamation-circle">Warning</x-badge>
                <x-badge variant="danger" icon="fas fa-times-circle">Danger</x-badge>
                <x-badge variant="info" icon="fas fa-info-circle">Info</x-badge>
            </div>
        </div>

        {{-- Alerts Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Alerts</div>
            <x-alert variant="success" title="Success!" class="mb-3">
                Your changes have been saved successfully.
            </x-alert>
            <x-alert variant="danger" title="Error!" class="mb-3">
                There was a problem processing your request.
            </x-alert>
            <x-alert variant="info" title="Info!">
                You have 3 new notifications waiting for you.
            </x-alert>
        </div>

        {{-- Progress Bars Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Progress Bars</div>
            <x-progress-bar :value="75" label="Project Progress" variant="primary" class="mb-3" />
            <x-progress-bar :value="45" label="Storage Used" variant="secondary" class="mb-3" />
            <x-progress-bar :value="32" label="CPU Usage" variant="success" />
        </div>

        {{-- Feature Cards Preview --}}
        <div class="preview-section">
            <div class="preview-title">Feature Cards</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <x-feature-card icon="fas fa-rocket" title="Fast Performance"
                        description="Lightning fast load times and smooth interactions" variant="primary" />
                </div>
                <div class="col-md-4">
                    <x-feature-card icon="fas fa-shield-alt" title="Secure by Default"
                        description="Enterprise-grade security for your data" variant="secondary" />
                </div>
                <div class="col-md-4">
                    <x-feature-card icon="fas fa-mobile-alt" title="Mobile Responsive"
                        description="Perfect experience on any device" variant="success" />
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <x-table-card title="Recent Orders" view-all-href="#orders" :headers="['Order ID', 'Customer', 'Product', 'Amount', 'Status', 'Date']">
        @foreach($orders as $order)
            <tr>
                <td><strong style="color: var(--text-primary);">{{ $order->order_id }}</strong></td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->product_name }}</td>
                <td><strong style="color: var(--text-primary);">{{ $order->amount }}</strong></td>
                <td><x-badge :variant="$order->status_variant"
                        :icon="$order->status_icon">{{ $order->status }}</x-badge></td>
                <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
        @endforeach
    </x-table-card>
</div>