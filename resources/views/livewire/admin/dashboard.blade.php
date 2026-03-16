<div>
    {{-- Page Header --}}
    <x-admin.page-header title="Dashboard Overview" subtitle="Welcome back! Here's what's happening today.">
        <x-slot:actions>
            <x-admin.button variant="primary" icon="fas fa-plus">New Report</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <x-admin.stat-card icon="fas fa-dollar-sign" label="Total Revenue" value="$48,574"
                trend-value="12.5% from last month" trend-direction="up" variant="primary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-admin.stat-card icon="fas fa-shopping-bag" label="New Orders" value="1,245"
                trend-value="8.2% from last month" trend-direction="up" variant="secondary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-admin.stat-card icon="fas fa-users" label="Total Users" value="8,456" trend-value="15.3% from last month"
                trend-direction="up" variant="success" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-admin.stat-card icon="fas fa-chart-pie" label="Conversion Rate" value="3.24%"
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
                <x-admin.button variant="primary">Primary Button</x-admin.button>
                <x-admin.button variant="secondary">Secondary Button</x-admin.button>
                <x-admin.button variant="success">Success Button</x-admin.button>
                <x-admin.button variant="warning">Warning Button</x-admin.button>
                <x-admin.button variant="danger">Danger Button</x-admin.button>
                <x-admin.button variant="outline">Outline Button</x-admin.button>
            </div>
        </div>

        {{-- Badges Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Badges</div>
            <div class="d-flex flex-wrap gap-2">
                <x-admin.badge variant="primary" icon="fas fa-circle">Primary</x-admin.badge>
                <x-admin.badge variant="success" icon="fas fa-check-circle">Success</x-admin.badge>
                <x-admin.badge variant="warning" icon="fas fa-exclamation-circle">Warning</x-admin.badge>
                <x-admin.badge variant="danger" icon="fas fa-times-circle">Danger</x-admin.badge>
                <x-admin.badge variant="info" icon="fas fa-info-circle">Info</x-admin.badge>
            </div>
        </div>

        {{-- Alerts Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Alerts</div>
            <x-admin.alert variant="success" title="Success!" class="mb-3">
                Your changes have been saved successfully.
            </x-admin.alert>
            <x-admin.alert variant="danger" title="Error!" class="mb-3">
                There was a problem processing your request.
            </x-admin.alert>
            <x-admin.alert variant="info" title="Info!">
                You have 3 new notifications waiting for you.
            </x-admin.alert>
        </div>

        {{-- Progress Bars Preview --}}
        <div class="preview-section" style="margin-bottom: 2.5rem;">
            <div class="preview-title">Progress Bars</div>
            <x-admin.progress-bar :value="75" label="Project Progress" variant="primary" class="mb-3" />
            <x-admin.progress-bar :value="45" label="Storage Used" variant="secondary" class="mb-3" />
            <x-admin.progress-bar :value="32" label="CPU Usage" variant="success" />
        </div>

        {{-- Feature Cards Preview --}}
        <div class="preview-section">
            <div class="preview-title">Feature Cards</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <x-admin.feature-card icon="fas fa-rocket" title="Fast Performance"
                        description="Lightning fast load times and smooth interactions" variant="primary" />
                </div>
                <div class="col-md-4">
                    <x-admin.feature-card icon="fas fa-shield-alt" title="Secure by Default"
                        description="Enterprise-grade security for your data" variant="secondary" />
                </div>
                <div class="col-md-4">
                    <x-admin.feature-card icon="fas fa-mobile-alt" title="Mobile Responsive"
                        description="Perfect experience on any device" variant="success" />
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <x-admin.table-card title="Recent Orders" view-all-href="#orders" :headers="['Order ID', 'Customer', 'Product', 'Amount', 'Status', 'Date']">
        @foreach($orders as $order)
            <tr>
                <td><strong style="color: var(--text-primary);">{{ $order->order_id }}</strong></td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->product_name }}</td>
                <td><strong style="color: var(--text-primary);">{{ $order->amount }}</strong></td>
                <td><x-admin.badge :variant="$order->status_variant"
                        :icon="$order->status_icon">{{ $order->status }}</x-admin.badge></td>
                <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
        @endforeach
    </x-admin.table-card>
</div>