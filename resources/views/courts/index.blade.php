@extends('layouts.app')

@section('title', 'Courts & Agencies Overview')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-building me-2 icon-building"></i>Courts & Agencies Overview</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Courts & Agencies</li>
            </ol>
        </nav>
    </div>

    @php
        $courtNames = [
            'SC' => 'Supreme Court',
            'CA' => 'Court of Appeals',
            'RTC' => 'Regional Trial Court',
            'OMB' => 'Office of the Ombudsman',
            'NCIP' => 'National Commission on Indigenous Peoples',
            'Special/IP' => 'Special Cases & Intellectual Property',
            'Other' => 'Other Agencies'
        ];
        
        $courtIcons = [
            'SC' => 'building-fill-check',
            'CA' => 'building-fill',
            'RTC' => 'building',
            'OMB' => 'shield-fill-check',
            'NCIP' => 'people-fill',
            'Special/IP' => 'lightbulb-fill',
            'Other' => 'archive-fill'
        ];
    @endphp

    <div class="row g-4">
        @foreach($courts as $court)
        <div class="col-md-6 col-lg-4">
            <div class="card court-card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="mb-2">
                                @if($court === 'SC' || $court === 'CA' || $court === 'RTC')
                                    <i class="bi bi-{{ $courtIcons[$court] ?? 'building' }} fs-2 icon-building"></i>
                                @elseif($court === 'OMB')
                                    <i class="bi bi-{{ $courtIcons[$court] ?? 'building' }} fs-2 icon-shield"></i>
                                @elseif($court === 'NCIP')
                                    <i class="bi bi-{{ $courtIcons[$court] ?? 'building' }} fs-2 icon-people"></i>
                                @elseif($court === 'Special/IP')
                                    <i class="bi bi-{{ $courtIcons[$court] ?? 'building' }} fs-2 icon-innovation"></i>
                                @else
                                    <i class="bi bi-{{ $courtIcons[$court] ?? 'building' }} fs-2 icon-archive"></i>
                                @endif
                            </div>
                            <h5 class="card-title mb-1">{{ $court }}</h5>
                            <p class="text-muted small mb-0">{{ $courtNames[$court] ?? $court }}</p>
                        </div>
                        <span class="badge bg-primary rounded-pill fs-6">{{ $stats[$court]['total'] }}</span>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Active</div>
                            <div class="stat-value text-success fw-bold">{{ $stats[$court]['active'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Due Soon</div>
                            <div class="stat-value text-warning fw-bold">{{ $stats[$court]['due_soon'] }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label text-muted small">Overdue</div>
                            <div class="stat-value text-danger fw-bold">{{ $stats[$court]['overdue'] }}</div>
                        </div>
                    </div>

                    <a href="{{ route('courts.show', urlencode($court)) }}" class="btn btn-outline-primary w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>View Cases
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.court-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.court-card:hover {
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
