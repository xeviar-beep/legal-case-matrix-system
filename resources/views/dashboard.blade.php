@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Comprehensive overview of your legal affairs office')

@push('styles')
<style>
    .lao-chart-card {
        background: white;
        border: 1px solid var(--lao-border);
        border-radius: 12px;
        padding: 20px;
        height: 100%;
    }

    .lao-chart-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--lao-text);
        margin-bottom: 16px;
    }

    .chart-bar {
        margin-bottom: 12px;
    }

    .chart-bar-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
        color: var(--text-primary);
    }

    .chart-bar-label span {
        color: var(--text-primary);
    }

    .chart-bar-label strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    .chart-bar-track {
        height: 8px;
        background: var(--lao-background);
        border-radius: 4px;
        overflow: hidden;
    }

    .chart-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s;
    }

    /* Dark Mode Styles */
    body.dark-mode .lao-chart-card {
        background: #111827;
        border-color: #2a3446;
    }

    body.dark-mode .lao-chart-title {
        color: #ffffff;
    }

    body.dark-mode .chart-bar-label {
        color: #ffffff;
    }

    body.dark-mode .chart-bar-label span {
        color: #cbd5e1;
    }

    body.dark-mode .chart-bar-label strong {
        color: #ffffff;
    }

    body.dark-mode .chart-bar-track {
        background: #1e293b;
    }

    body.dark-mode .lao-chart-card .text-muted {
        color: #94a3b8 !important;
    }
</style>
@endpush

@section('content')
<!-- Summary Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="lao-stat-card">
            <div class="lao-stat-icon primary">
                <i class="bi bi-folder-fill icon-folder"></i>
            </div>
            <div class="lao-stat-label">Total Active Cases</div>
            <div class="lao-stat-value">{{ $stats['total_active'] }}</div>
            <small class="text-muted">All ongoing matters</small>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="lao-stat-card">
            <div class="lao-stat-icon warning">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="lao-stat-label">Near Deadline Cases</div>
            <div class="lao-stat-value">{{ $stats['due_within_7days'] }}</div>
            <small class="text-muted">Within 7 days</small>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="lao-stat-card">
            <div class="lao-stat-icon danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="lao-stat-label">Overdue Cases</div>
            <div class="lao-stat-value">{{ $stats['overdue'] }}</div>
            <small class="{{ $stats['overdue'] > 0 ? 'text-danger fw-bold' : 'text-muted' }}">Immediate attention required</small>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="lao-stat-card">
            <div class="lao-stat-icon success">
                <i class="bi bi-calendar-event icon-calendar"></i>
            </div>
            <div class="lao-stat-label">Today's Hearings</div>
            <div class="lao-stat-value">{{ $stats['hearing_today'] }}</div>
            <small class="text-muted">Scheduled today</small>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <!-- Cases per Section -->
    <div class="col-lg-4 col-md-6">
        <div class="lao-chart-card">
            <h6 class="lao-chart-title">
                <i class="bi bi-diagram-3-fill icon-chart"></i> Cases per Section
            </h6>
            @forelse($casesBySection as $section => $count)
            <div class="chart-bar">
                <div class="chart-bar-label">
                    <span>{{ $section }}</span>
                    <strong>{{ $count }}</strong>
                </div>
                <div class="chart-bar-track">
                    <div class="chart-bar-fill" style="width: {{ $stats['total_active'] > 0 ? ($count / $stats['total_active'] * 100) : 0 }}%; background: var(--lao-primary);"></div>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">No data available</p>
            @endforelse
        </div>
    </div>

    <!-- Cases per Court/Agency -->
    <div class="col-lg-4 col-md-6">
        <div class="lao-chart-card">
            <h6 class="lao-chart-title">
                <i class="bi bi-bank icon-building"></i> Cases per Court/Agency
            </h6>
            @forelse($casesByCourt as $court => $count)
            <div class="chart-bar">
                <div class="chart-bar-label">
                    <span>{{ $court }}</span>
                    <strong>{{ $count }}</strong>
                </div>
                <div class="chart-bar-track">
                    <div class="chart-bar-fill" style="width: {{ $stats['total_active'] > 0 ? ($count / $stats['total_active'] * 100) : 0 }}%; background: var(--status-green);"></div>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">No data available</p>
            @endforelse
        </div>
    </div>

    <!-- Cases per Region -->
    <div class="col-lg-4 col-md-12">
        <div class="lao-chart-card">
            <h6 class="lao-chart-title">
                <i class="bi bi-geo-alt-fill icon-location"></i> Cases per Region
            </h6>
            @forelse($casesByRegion as $region => $count)
            <div class="chart-bar">
                <div class="chart-bar-label">
                    <span>{{ $region }}</span>
                    <strong>{{ $count }}</strong>
                </div>
                <div class="chart-bar-track">
                    <div class="chart-bar-fill" style="width: {{ $stats['total_active'] > 0 ? ($count / $stats['total_active'] * 100) : 0 }}%; background: var(--status-yellow);"></div>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">No data available</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Urgent Cases Tables -->
<div class="row g-3">
    <!-- Overdue Cases -->
    @if($overdueCases->count() > 0)
    <div class="col-12">
        <div class="lao-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i> 
                    Overdue Cases - Immediate Attention Required
                </h5>
                <span class="lao-badge badge-danger">{{ $overdueCases->count() }} Cases</span>
            </div>
            <div class="table-responsive">
                <table class="lao-table">
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Docket No.</th>
                            <th>Case Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Court/Agency</th>
                            <th>Deadline</th>
                            <th>Days Overdue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueCases as $case)
                        <tr class="status-red">
                            <td><strong>{{ $case->case_number }}</strong></td>
                            <td>{{ $case->docket_no ?: '-' }}</td>
                            <td>{{ Str::limit($case->case_title, 40) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="lao-badge badge-secondary">{{ $case->section }}</span></td>
                            <td><span class="lao-badge badge-secondary">{{ $case->court_agency ?: 'N/A' }}</span></td>
                            <td>{{ $case->deadline_date->format('M d, Y') }}</td>
                            <td>
                                <span class="lao-badge badge-danger">
                                    <i class="bi bi-x-circle-fill"></i> {{ abs($case->remaining_days) }} days
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-lao-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Near Deadline Cases -->
    @if($dueSoonCases->count() > 0)
    <div class="col-12">
        <div class="lao-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history text-warning"></i> 
                    Near Deadline Cases (Within 7 Days)
                </h5>
                <span class="lao-badge badge-warning">{{ $dueSoonCases->count() }} Cases</span>
            </div>
            <div class="table-responsive">
                <table class="lao-table">
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Docket No.</th>
                            <th>Case Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Court/Agency</th>
                            <th>Assigned Lawyer</th>
                            <th>Deadline</th>
                            <th>Days Left</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dueSoonCases as $case)
                        <tr class="status-yellow">
                            <td><strong>{{ $case->case_number }}</strong></td>
                            <td>{{ $case->docket_no ?: '-' }}</td>
                            <td>{{ Str::limit($case->case_title, 40) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="lao-badge badge-secondary">{{ $case->section }}</span></td>
                            <td><span class="lao-badge badge-secondary">{{ $case->court_agency ?: 'N/A' }}</span></td>
                            <td>{{ $case->assigned_lawyer ?: 'Unassigned' }}</td>
                            <td>{{ $case->deadline_date->format('M d, Y') }}</td>
                            <td>
                                <span class="lao-badge badge-warning">
                                    <i class="bi bi-clock-fill"></i> {{ $case->remaining_days }} days
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-lao-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Today's Hearings -->
    @if($hearingTodayCases->count() > 0)
    <div class="col-12">
        <div class="lao-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check text-success"></i> 
                    Today's Hearings
                </h5>
                <span class="lao-badge badge-success">{{ $hearingTodayCases->count() }} Hearings</span>
            </div>
            <div class="table-responsive">
                <table class="lao-table">
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Case Title</th>
                            <th>Client</th>
                            <th>Court/Agency</th>
                            <th>Assigned Lawyer</th>
                            <th>Hearing Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hearingTodayCases as $case)
                        <tr class="status-green">
                            <td><strong>{{ $case->case_number }}</strong></td>
                            <td>{{ Str::limit($case->case_title, 50) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="lao-badge badge-secondary">{{ $case->court_agency ?: 'N/A' }}</span></td>
                            <td>{{ $case->assigned_lawyer ?: 'Unassigned' }}</td>
                            <td>
                                <span class="lao-badge badge-success">
                                    <i class="bi bi-calendar-event"></i> {{ $case->hearing_date->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-lao-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- No Urgent Cases -->
    @if($overdueCases->count() == 0 && $dueSoonCases->count() == 0 && $hearingTodayCases->count() == 0)
    <div class="col-12">
        <div class="lao-card text-center py-5">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 64px;"></i>
            <h4 class="mt-4 mb-2">All Clear!</h4>
            <p class="text-muted">No urgent cases, near deadlines, or hearings scheduled for today.</p>
            <a href="{{ route('cases.create') }}" class="btn btn-lao-primary mt-3">
                <i class="bi bi-plus-circle"></i> Add New Case
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Auto-notification system for dashboard
(async function() {
    // Check if push notifications are enabled
    if (!('serviceWorker' in navigator) || !('Notification' in window)) {
        console.log('Push notifications not supported');
        return;
    }

    if (Notification.permission !== 'granted') {
        console.log('Notification permission not granted');
        return;
    }

    try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();
        
        if (!subscription) {
            console.log('No push subscription found');
            return;
        }

        console.log('✅ Auto-notifications enabled on dashboard');

        // Send notification about overdue cases if any exist
        const overdueCaseCount = {{ $overdueCases->count() }};
        if (overdueCaseCount > 0) {
            setTimeout(async () => {
                await registration.showNotification('🚨 Overdue Cases Alert', {
                    body: `You have ${overdueCaseCount} overdue case${overdueCaseCount > 1 ? 's' : ''} requiring immediate attention!`,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: 'overdue-alert',
                    requireInteraction: true,
                    actions: [
                        { action: 'view', title: 'View Cases' },
                        { action: 'dismiss', title: 'Dismiss' }
                    ],
                    data: {
                        url: '{{ route("deadlines.index") }}',
                        timestamp: new Date().getTime()
                    },
                    vibrate: [200, 100, 200, 100, 200]
                });
                console.log('📢 Sent overdue cases notification');
            }, 3000); // 3 seconds after page load
        }

        // Send notification about upcoming deadlines if any exist
        const dueSoonCount = {{ $dueSoonCases->count() }};
        if (dueSoonCount > 0) {
            setTimeout(async () => {
                await registration.showNotification('⏰ Upcoming Deadlines', {
                    body: `${dueSoonCount} case${dueSoonCount > 1 ? 's have' : ' has'} deadline approaching within 7 days.`,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: 'deadline-reminder',
                    requireInteraction: false,
                    actions: [
                        { action: 'view', title: 'View Deadlines' },
                        { action: 'dismiss', title: 'Dismiss' }
                    ],
                    data: {
                        url: '{{ route("deadlines.index") }}',
                        timestamp: new Date().getTime()
                    },
                    vibrate: [200, 100, 200]
                });
                console.log('📢 Sent deadline reminder notification');
            }, 6000); // 6 seconds after page load
        }

        // Send notification about today's hearings if any exist
        const hearingTodayCount = {{ $hearingTodayCases->count() }};
        if (hearingTodayCount > 0) {
            setTimeout(async () => {
                await registration.showNotification('📅 Hearings Today', {
                    body: `You have ${hearingTodayCount} hearing${hearingTodayCount > 1 ? 's' : ''} scheduled for today.`,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: 'hearing-today',
                    requireInteraction: false,
                    actions: [
                        { action: 'view', title: 'View Schedule' },
                        { action: 'dismiss', title: 'Dismiss' }
                    ],
                    data: {
                        url: '{{ route("dashboard") }}',
                        timestamp: new Date().getTime()
                    },
                    vibrate: [200, 100, 200]
                });
                console.log('📢 Sent hearing reminder notification');
            }, 9000); // 9 seconds after page load
        }

        // Set up periodic check (every 5 minutes)
        setInterval(async () => {
            // This would reload the page or make an AJAX call to check for new alerts
            console.log('🔄 Checking for new alerts...');
            
            // You could make an AJAX call here to check for new overdue cases
            // For now, we'll just log
        }, 5 * 60 * 1000); // 5 minutes

    } catch (error) {
        console.error('Error setting up auto-notifications:', error);
    }
})();
</script>
@endpush
