@extends('layouts.app')

@section('title', 'Regions Overview')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-geo-alt me-2 icon-location"></i>Regions Overview</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Regions</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        @foreach($regions as $region)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card region-card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="mb-2">
                                <i class="bi bi-geo-alt-fill fs-2 icon-location"></i>
                            </div>
                            <h5 class="card-title mb-0">{{ $region }}</h5>
                        </div>
                        <span class="badge bg-primary rounded-pill fs-6">{{ $stats[$region]['total'] }}</span>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Active</div>
                            <div class="stat-value text-success fw-bold">{{ $stats[$region]['active'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Due Soon</div>
                            <div class="stat-value text-warning fw-bold">{{ $stats[$region]['due_soon'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Overdue</div>
                            <div class="stat-value text-danger fw-bold">{{ $stats[$region]['overdue'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('regions.show', $region) }}" class="btn btn-outline-primary w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>View Cases
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.region-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.region-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-label {
    font-size: 0.7rem;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.25rem;
}
</style>
@endsection
