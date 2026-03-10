@extends('layouts.app')

@section('title', 'Deadlines Calendar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar-check me-2 icon-calendar"></i>Deadlines Calendar</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Deadlines</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    <h3 class="mt-2 mb-1 text-danger">{{ $stats['overdue'] }}</h3>
                    <p class="text-muted small mb-0">Overdue</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="bi bi-clock-fill text-warning fs-2"></i>
                    <h3 class="mt-2 mb-1 text-warning">{{ $stats['today'] }}</h3>
                    <p class="text-muted small mb-0">Due Today</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="bi bi-calendar-date text-info fs-2"></i>
                    <h3 class="mt-2 mb-1 text-info">{{ $stats['tomorrow'] }}</h3>
                    <p class="text-muted small mb-0">Due Tomorrow</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="bi bi-calendar-week icon-calendar fs-2"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $stats['this_week'] }}</h3>
                    <p class="text-muted small mb-0">This Week</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-secondary">
                <div class="card-body">
                    <i class="bi bi-calendar-range text-secondary fs-2"></i>
                    <h3 class="mt-2 mb-1 text-secondary">{{ $stats['next_week'] }}</h3>
                    <p class="text-muted small mb-0">Next Week</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="bi bi-calendar-month text-success fs-2"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $stats['this_month'] }}</h3>
                    <p class="text-muted small mb-0">This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Cases -->
    @if($overdueCases->count() > 0)
    <div class="card border-danger mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Overdue Cases ({{ $overdueCases->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Assigned Lawyer</th>
                            <th>Deadline</th>
                            <th>Days Overdue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueCases as $case)
                        <tr class="table-danger">
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 30) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>{{ \Carbon\Carbon::parse($case->deadline_date)->format('M d, Y') }}</td>
                            <td><span class="badge bg-danger">{{ abs($case->remaining_days) }} days</span></td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Due Today -->
    @if($dueTodayCases->count() > 0)
    <div class="card border-warning mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0"><i class="bi bi-clock-fill me-2"></i>Due Today ({{ $dueTodayCases->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dueTodayCases as $case)
                        <tr class="table-warning">
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 40) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Due Tomorrow -->
    @if($dueTomorrowCases->count() > 0)
    <div class="card border-info mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-date me-2"></i>Due Tomorrow ({{ $dueTomorrowCases->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dueTomorrowCases as $case)
                        <tr>
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 40) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- This Week -->
    <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Due This Week ({{ $dueThisWeekCases->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Deadline</th>
                            <th>Days Left</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dueThisWeekCases as $case)
                        <tr>
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 30) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($case->deadline_date)->format('M d, Y') }}</td>
                            <td><span class="badge bg-primary">{{ $case->remaining_days }} days</span></td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-check fs-1 d-block mb-2"></i>
                                No cases due this week
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Next Week -->
    @if($dueNextWeekCases->count() > 0)
    <div class="card border-secondary mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>Due Next Week ({{ $dueNextWeekCases->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Deadline</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dueNextWeekCases as $case)
                        <tr>
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 35) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($case->deadline_date)->format('M d, Y') }}</td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- All Deadlines This Month -->
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-month me-2"></i>All Deadlines This Month</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Court/Agency</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dueThisMonthCases as $case)
                        <tr>
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ Str::limit($case->case_title, 30) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td><span class="badge bg-secondary">{{ $case->section }}</span></td>
                            <td>
                                @if($case->court_agency)
                                    <span class="badge bg-info">{{ $case->court_agency }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($case->deadline_date)->format('M d, Y') }}</td>
                            <td>
                                @if($case->status === 'overdue')
                                    <span class="badge bg-danger">Overdue</span>
                                @elseif($case->status === 'due_soon')
                                    <span class="badge bg-warning text-dark">Due Soon</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                No deadlines this month
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($dueThisMonthCases->hasPages())
            <div class="card-footer">
                {{ $dueThisMonthCases->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
