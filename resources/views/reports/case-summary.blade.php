@extends('layouts.app')

@section('title', 'Case Summary Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-text me-2 icon-chart"></i>Case Summary Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">Case Summary</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.case-summary') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter"></i> Apply Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-1">{{ $summary['total'] }}</h3>
                    <p class="text-muted small mb-0">Total Cases Filed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success mb-1">{{ $summary['by_section']->count() }}</h3>
                    <p class="text-muted small mb-0">Sections Involved</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning mb-1">{{ $summary['by_court']->count() }}</h3>
                    <p class="text-muted small mb-0">Courts/Agencies</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info mb-1">{{ $summary['by_region']->count() }}</h3>
                    <p class="text-muted small mb-0">Regions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Charts -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-folder icon-folder"></i> By Section</h6>
                </div>
                <div class="card-body">
                    @forelse($summary['by_section'] as $section => $count)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;">{{ $section ?: 'Unassigned' }}</span>
                                <strong>{{ $count }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: {{ $summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-building icon-building"></i> By Court/Agency</h6>
                </div>
                <div class="card-body">
                    @forelse($summary['by_court'] as $court => $count)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;">{{ $court ?: 'Unassigned' }}</span>
                                <strong>{{ $count }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: {{ $summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-kanban"></i> By Status</h6>
                </div>
                <div class="card-body">
                    @forelse($summary['by_status'] as $status => $count)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;">{{ ucfirst($status) }}</span>
                                <strong>{{ $count }}</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar 
                                    @if($status == 'overdue') bg-danger
                                    @elseif($status == 'due_soon') bg-warning
                                    @elseif($status == 'completed') bg-secondary
                                    @else bg-success
                                    @endif" 
                                    style="width: {{ $summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Cases Table -->
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-table"></i> Detailed Case List</h6>
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
                            <th>Region</th>
                            <th>Date Filed</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr>
                                <td class="fw-bold">{{ $case->case_number }}</td>
                                <td>{{ Str::limit($case->case_title, 30) }}</td>
                                <td>{{ $case->client_name }}</td>
                                <td><span class="badge bg-secondary">{{ $case->section ?: '-' }}</span></td>
                                <td><span class="badge bg-info">{{ $case->court_agency ?: '-' }}</span></td>
                                <td><span class="badge bg-secondary">{{ $case->region ?: '-' }}</span></td>
                                <td>{{ $case->date_filed->format('M d, Y') }}</td>
                                <td>{{ $case->deadline_date->format('M d, Y') }}</td>
                                <td>
                                    @if($case->status === 'overdue')
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif($case->status === 'due_soon')
                                        <span class="badge bg-warning text-dark">Due Soon</span>
                                    @elseif($case->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No cases found for the selected date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .card-body form, .btn { display: none; }
    }
</style>
@endsection
