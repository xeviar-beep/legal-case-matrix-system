@extends('layouts.app')

@section('title', 'Statistical Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bar-chart me-2 icon-analytics"></i>Statistical Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Reports</a></li>
                <li class="breadcrumb-item active">Statistical</li>
            </ol>
        </nav>
    </div>

    <!-- Year Selector -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.statistical') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Select Year</label>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Annual Summary -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-calendar3"></i> {{ $year }} Annual Summary</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded text-center">
                        <h3 class="text-primary mb-1">{{ $stats['total_filed'] }}</h3>
                        <p class="text-muted small mb-0">Cases Filed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded text-center">
                        <h3 class="text-success mb-1">{{ $stats['total_completed'] }}</h3>
                        <p class="text-muted small mb-0">Completed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded text-center">
                        <h3 class="text-info mb-1">{{ $stats['total_active'] }}</h3>
                        <p class="text-muted small mb-0">Active Cases</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-light rounded text-center">
                        <h3 class="text-warning mb-1">
                            {{ $stats['total_filed'] > 0 ? round(($stats['total_completed'] / $stats['total_filed']) * 100, 1) : 0 }}%
                        </h3>
                        <p class="text-muted small mb-0">Resolution Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-graph-up-arrow"></i> Monthly Filing & Completion Trends</h6>
        </div>
        <div class="card-body">
            @php
                $maxValue = max($monthlyData->max('filed'), $monthlyData->max('completed'), 1);
            @endphp
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Filed</th>
                            <th>Completed</th>
                            <th>Visual Comparison</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyData as $month)
                            @php
                                $filedWidth = $maxValue > 0 ? ($month->filed / $maxValue * 100) : 0;
                                $completedWidth = $maxValue > 0 ? ($month->completed / $maxValue * 100) : 0;
                            @endphp
                            <tr>
                                <td class="text-bold" style="font-weight: 700;">{{ $month->month_name }}</td>
                                <td><span class="badge bg-primary">{{ $month->filed }}</span></td>
                                <td><span class="badge bg-success">{{ $month->completed }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted" style="width: 60px;">Filed:</small>
                                        <div class="progress flex-grow-1" style="height: 15px;">
                                            <div class="progress-bar bg-primary" 
                                                style="--bar-width: {{ $filedWidth }}%; width: var(--bar-width);">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <small class="text-muted" style="width: 60px;">Completed:</small>
                                        <div class="progress flex-grow-1" style="height: 15px;">
                                            <div class="progress-bar bg-success" 
                                                style="--bar-width: {{ $completedWidth }}%; width: var(--bar-width);">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Distribution Charts -->
    <div class="row g-3 mb-4">
        <!-- By Section -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-folder icon-folder"></i> Cases by Section</h6>
                </div>
                <div class="card-body">
                    @php
                        $maxSection = $stats['by_section']->max('total') ?: 1;
                    @endphp
                    @forelse($stats['by_section'] as $section)
                        @php
                            $sectionWidth = $maxSection > 0 ? ($section->total / $maxSection * 100) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;">{{ $section->section ?: 'Unassigned' }}</span>
                                <strong>{{ $section->total }} cases</strong>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-primary" 
                                    style="--bar-width: {{ $sectionWidth }}%; width: var(--bar-width);">
                                    {{ $stats['total_filed'] > 0 ? round(($section->total / $stats['total_filed']) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- By Court -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-building icon-building"></i> Cases by Court/Agency</h6>
                </div>
                <div class="card-body">
                    @php
                        $maxCourt = $stats['by_court']->max('total') ?: 1;
                    @endphp
                    @forelse($stats['by_court'] as $court)
                        @php
                            $courtWidth = $maxCourt > 0 ? ($court->total / $maxCourt * 100) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;">{{ $court->court_agency ?: 'Unassigned' }}</span>
                                <strong>{{ $court->total }} cases</strong>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" 
                                    style="--bar-width: {{ $courtWidth }}%; width: var(--bar-width);">
                                    {{ $stats['total_filed'] > 0 ? round(($court->total / $stats['total_filed']) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Regional Distribution -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-geo-alt icon-location"></i> Regional Distribution</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @php
                    $maxRegion = $stats['by_region']->max('total') ?: 1;
                @endphp
                @forelse($stats['by_region'] as $region)
                    @php
                        $regionWidth = $maxRegion > 0 ? ($region->total / $maxRegion * 100) : 0;
                    @endphp
                    <div class="col-md-4">
                        <div class="card border">
                            <div class="card-body text-center">
                                <h4 class="text-primary mb-1">{{ $region->total }}</h4>
                                <p class="mb-2 text-bold" style="font-weight: 600;">{{ $region->region ?: 'Unassigned' }}</p>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-info" 
                                        style="--bar-width: {{ $regionWidth }}%; width: var(--bar-width);">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $stats['total_filed'] > 0 ? round(($region->total / $stats['total_filed']) * 100, 1) : 0 }}% of total
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">No data available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-pie-chart"></i> Case Status Breakdown</h6>
        </div>
        <div class="card-body">
            <div class="row g-3 text-center">
                <div class="col-md-3">
                    <div class="p-4 bg-success bg-opacity-10 rounded">
                        <h2 class="text-success mb-2">{{ $stats['status']['active'] ?? 0 }}</h2>
                        <p class="mb-0 text-bold" style="font-weight: 600;">Active</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-secondary bg-opacity-10 rounded">
                        <h2 class="text-secondary mb-2">{{ $stats['status']['completed'] ?? 0 }}</h2>
                        <p class="mb-0 text-bold" style="font-weight: 600;">Completed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-danger bg-opacity-10 rounded">
                        <h2 class="text-danger mb-2">{{ $stats['status']['overdue'] ?? 0 }}</h2>
                        <p class="mb-0 text-bold" style="font-weight: 600;">Overdue</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-warning bg-opacity-10 rounded">
                        <h2 class="text-warning mb-2">{{ $stats['status']['due_soon'] ?? 0 }}</h2>
                        <p class="mb-0 text-bold" style="font-weight: 600;">Due Soon</p>
                    </div>
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
