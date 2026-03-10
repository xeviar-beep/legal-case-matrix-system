@extends('layouts.app')

@section('title', 'Performance Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-graph-up me-2 icon-chart"></i>Performance Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">Performance</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.performance') }}" method="GET" class="row g-3">
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

    <!-- Overall Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-1">{{ $lawyerStats->count() }}</h3>
                    <p class="text-muted small mb-0">Active Lawyers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success mb-1">{{ $lawyerStats->sum('total') }}</h3>
                    <p class="text-muted small mb-0">Total Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info mb-1">{{ $lawyerStats->sum('completed') }}</h3>
                    <p class="text-muted small mb-0">Completed Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning mb-1">{{ $lawyerStats->sum('overdue') }}</h3>
                    <p class="text-muted small mb-0">Overdue Cases</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-people icon-people"></i> Lawyer Performance Statistics</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Lawyer Name</th>
                            <th class="text-center">Total Cases</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Completed</th>
                            <th class="text-center">Overdue</th>
                            <th class="text-center">Due Soon</th>
                            <th class="text-center">Completion Rate</th>
                            <th>Workload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $maxCases = $lawyerStats->max('total') ?: 1;
                        @endphp
                        @forelse($lawyerStats as $lawyer)
                            @php
                                $completionRate = $lawyer->total > 0 ? round(($lawyer->completed / $lawyer->total) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="text-bold" style="font-weight: 700;">{{ $lawyer->assigned_lawyer ?: 'Unassigned' }}</td>
                                <td class="text-center"><strong>{{ $lawyer->total }}</strong></td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $lawyer->active }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $lawyer->completed }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $lawyer->overdue }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark">{{ $lawyer->due_soon }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold 
                                        @if($completionRate >= 70) text-success
                                        @elseif($completionRate >= 40) text-warning
                                        @else text-danger
                                        @endif">
                                        {{ $completionRate }}%
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($lawyer->total / $maxCases >= 0.8) bg-danger
                                                @elseif($lawyer->total / $maxCases >= 0.5) bg-warning
                                                @else bg-success
                                                @endif"
                                                style="width: {{ ($lawyer->total / $maxCases) * 100 }}%">
                                                {{ $lawyer->total }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No performance data available for the selected date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Performance Analysis -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-award"></i> Top Performers</h6>
                </div>
                <div class="card-body">
                    @php
                        $topPerformers = $lawyerStats->filter(function($lawyer) {
                            return $lawyer->completed > 0;
                        })->sortByDesc('completed')->take(5);
                    @endphp
                    @forelse($topPerformers as $index => $lawyer)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge 
                                    @if($index == 0) bg-warning
                                    @elseif($index == 1) bg-secondary
                                    @elseif($index == 2) bg-danger
                                    @else bg-light text-dark
                                    @endif me-2">
                                    #{{ $index + 1 }}
                                </span>
                                <strong class="text-bold">{{ $lawyer->assigned_lawyer ?: 'Unassigned' }}</strong>
                            </div>
                            <span class="badge bg-success">{{ $lawyer->completed }} completed</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No completed cases yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Needs Attention</h6>
                </div>
                <div class="card-body">
                    @php
                        $needsAttention = $lawyerStats->filter(function($lawyer) {
                            return $lawyer->overdue > 0;
                        })->sortByDesc('overdue')->take(5);
                    @endphp
                    @forelse($needsAttention as $lawyer)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="text-bold">{{ $lawyer->assigned_lawyer ?: 'Unassigned' }}</strong>
                            <div>
                                <span class="badge bg-danger me-1">{{ $lawyer->overdue }} overdue</span>
                                <span class="badge bg-warning text-dark">{{ $lawyer->due_soon }} due soon</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No overdue cases!</p>
                    @endforelse
                </div>
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
