@extends('layouts.app')

@section('title', 'Sections Overview')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-folder me-2 icon-folder"></i>Sections Overview</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Sections</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        @foreach($sections as $section)
        <div class="col-md-6 col-lg-4">
            <div class="card section-card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-folder-fill me-2 icon-folder"></i>
                            {{ $section }}
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ $stats[$section]['total'] }}</span>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Active</div>
                            <div class="stat-value text-success fw-bold">{{ $stats[$section]['active'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Due Soon</div>
                            <div class="stat-value text-warning fw-bold">{{ $stats[$section]['due_soon'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Overdue</div>
                            <div class="stat-value text-danger fw-bold">{{ $stats[$section]['overdue'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('sections.show', urlencode($section)) }}" class="btn btn-outline-primary w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>View Cases
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.section-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.section-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.stat-item {
    text-align: center;
}

.stat-label {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
}
</style>
@endsection
