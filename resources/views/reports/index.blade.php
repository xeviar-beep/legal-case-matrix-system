@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-bar-graph me-2 icon-chart"></i>Reports & Analytics</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="bi bi-folder-fill icon-folder fs-2"></i>
                    <h3 class="mt-2 mb-1 text-primary">{{ $stats['total_cases'] }}</h3>
                    <p class="text-muted small mb-0">Total Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                    <h3 class="mt-2 mb-1 text-success">{{ $stats['active_cases'] }}</h3>
                    <p class="text-muted small mb-0">Active Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    <h3 class="mt-2 mb-1 text-danger">{{ $stats['overdue_cases'] }}</h3>
                    <p class="text-muted small mb-0">Overdue Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-secondary">
                <div class="card-body">
                    <i class="bi bi-check-all text-secondary fs-2"></i>
                    <h3 class="mt-2 mb-1 text-secondary">{{ $stats['completed_cases'] }}</h3>
                    <p class="text-muted small mb-0">Completed Cases</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Cards -->
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(153, 39, 45, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="me-3">
                            <i class="bi bi-file-text fs-4" style="color: #99272D;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-title" style="font-weight: 700;">Case Summary Report</h5>
                            <p class="text-muted small mb-0">Comprehensive case overview</p>
                        </div>
                    </div>
                    <p class="mb-3 text-secondary" style="font-size: 13px; font-weight: 500;">View detailed summary of all cases with filtering by date range, section, court, and region.</p>
                    <a href="{{ route('reports.case-summary') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="me-3">
                            <i class="bi bi-graph-up fs-4" style="color: #059669;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-title" style="font-weight: 700;">Performance Report</h5>
                            <p class="text-muted small mb-0">Lawyer performance metrics</p>
                        </div>
                    </div>
                    <p class="mb-3 text-secondary" style="font-size: 13px; font-weight: 500;">Analyze case load distribution and completion rates by assigned lawyer.</p>
                    <a href="{{ route('reports.performance') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="me-3">
                            <i class="bi bi-calendar-check fs-4" style="color: #f59e0b;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-title" style="font-weight: 700;">Deadline Compliance</h5>
                            <p class="text-muted small mb-0">On-time filing analysis</p>
                        </div>
                    </div>
                    <p class="mb-3 text-secondary" style="font-size: 13px; font-weight: 500;">Track compliance rates and identify deadline performance by court and section.</p>
                    <a href="{{ route('reports.deadline-compliance') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="me-3">
                            <i class="bi bi-bar-chart-fill fs-4 icon-chart"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-title" style="font-weight: 700;">Statistical Report</h5>
                            <p class="text-muted small mb-0">Annual trends & patterns</p>
                        </div>
                    </div>
                    <p class="mb-3 text-secondary" style="font-size: 13px; font-weight: 500;">Monthly filing trends, section distribution, and annual case statistics.</p>
                    <a href="{{ route('reports.statistical') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-eye me-2"></i>View Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
