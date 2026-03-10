@extends('layouts.app')

@section('title', 'Search Results')

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
    
    .card {
        scroll-margin-top: 100px;
    }
    
    .search-highlight {
        background-color: #fff3cd;
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-search me-2"></i>Search Results</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cases.information') }}">Cases</a></li>
                <li class="breadcrumb-item active">Search</li>
            </ol>
        </nav>
    </div>

    <!-- Search Results Banner -->
    <div class="alert alert-primary mb-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-search me-3" style="font-size: 24px;"></i>
            <div>
                <strong>Search Query: "{{ $query }}"</strong>
                <p class="mb-0 mt-1">Found <strong>{{ $resultCount }}</strong> {{ Str::plural('result', $resultCount) }} matching your search.</p>
            </div>
        </div>
    </div>

    @if($resultCount > 0)
        @foreach($cases as $case)
        <!-- Case Card -->
        <div class="card mb-4 shadow-sm" id="case-{{ $case->id }}" style="scroll-margin-top: 100px;">
            <div class="card-header" style="background: linear-gradient(135deg, #1E2A38 0%, #2d3e50 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1" style="font-weight: 700;">
                            <i class="bi bi-folder-fill me-2"></i>{{ $case->case_number }}
                        </h5>
                        <p class="mb-0" style="font-size: 14px; opacity: 0.95;">{{ $case->case_title }}</p>
                    </div>
                    <div>
                        @if($case->status === 'overdue')
                            <span class="badge bg-danger" style="font-size: 12px; padding: 8px 12px;">
                                <i class="bi bi-exclamation-triangle-fill"></i> OVERDUE
                            </span>
                        @elseif($case->status === 'due_soon')
                            <span class="badge bg-warning text-dark" style="font-size: 12px; padding: 8px 12px;">
                                <i class="bi bi-clock-fill"></i> DUE SOON
                            </span>
                        @else
                            <span class="badge bg-success" style="font-size: 12px; padding: 8px 12px;">
                                <i class="bi bi-check-circle-fill"></i> ACTIVE
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row g-4">
                    <!-- Case Details Column -->
                    <div class="col-lg-6">
                        <h6 class="text-primary mb-3"><i class="bi bi-card-text"></i> Case Details</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Docket Number</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->docket_no ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Client Name</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->client_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Court/Agency</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->court_agency ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Case Type</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->case_type ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Section</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->section ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Region</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->region ?: 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Assigned Lawyer</small>
                                    <div class="text-bold" style="font-weight: 600;">{{ $case->assigned_lawyer ?: 'Not Assigned' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <h6 class="text-primary mb-3 mt-4"><i class="bi bi-calendar-check"></i> Important Dates</h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Filing Date</small>
                                    <div class="text-bold" style="font-weight: 600;">
                                        <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($case->date_filed)->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            @if($case->next_hearing_date)
                            <div class="col-md-6">
                                <div class="p-2" style="background: #fff3cd; border-radius: 8px; border: 1px solid #ffc107;">
                                    <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Next Hearing</small>
                                    <div class="text-bold" style="font-weight: 600;">
                                        <i class="bi bi-clock-fill me-1 text-warning"></i>{{ \Carbon\Carbon::parse($case->next_hearing_date)->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documents Column -->
                    <div class="col-lg-6">
                        <h6 class="text-primary mb-3"><i class="bi bi-file-earmark-text"></i> Documents ({{ $case->documents->count() }})</h6>
                        
                        @if($case->documents->count() > 0)
                            <div class="list-group">
                                @foreach($case->documents as $document)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-pdf text-danger me-2" style="font-size: 20px;"></i>
                                        <div>
                                            <div style="font-weight: 600; font-size: 14px;">{{ $document->file_name }}</div>
                                            <small class="text-muted">{{ number_format($document->file_size / 1024, 2) }} KB • Uploaded {{ $document->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('documents.download', $document->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-light border mb-0">
                                <i class="bi bi-info-circle me-2"></i>No documents uploaded yet.
                            </div>
                        @endif

                        @if($case->notes)
                        <h6 class="text-primary mb-3 mt-4"><i class="bi bi-sticky"></i> Case Notes</h6>
                        <div class="alert alert-light border" style="max-height: 200px; overflow-y: auto;">
                            <div style="white-space: pre-wrap; font-size: 13px;">{{ $case->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('cases.show', $case->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-eye"></i> View Full Details
                    </a>
                    <a href="{{ route('cases.edit', $case->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-pencil"></i> Edit Case
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <!-- No Results -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 64px; color: #6c757d; opacity: 0.3;"></i>
                <h4 class="mt-3 mb-2">No Results Found</h4>
                <p class="text-muted mb-4">We couldn't find any cases matching "{{ $query }}".</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('cases.information') }}" class="btn btn-primary">
                        <i class="bi bi-list"></i> View All Cases
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
