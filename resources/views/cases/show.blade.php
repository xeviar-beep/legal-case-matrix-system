@extends('layouts.app')

@section('title', 'Case Details')
@section('page-title', $case->case_number)
@section('page-subtitle', $case->case_title)

@push('styles')
<style>
    .table-container {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .table-header {
        background: #001F3F;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #FFFFFF !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-title i {
        color: #FFFFFF !important;
    }

    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .stat-icon.red {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }

    .stat-icon.yellow {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-icon.green {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
    }

    .badge-overdue {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
        font-weight: 700;
    }

    .badge-due-soon {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        font-weight: 700;
    }

    .badge-active {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        font-weight: 700;
    }

    /* Dark Mode Styles */
    body.dark-mode .table-container {
        background: #111827;
        border-color: #2a3446;
    }

    body.dark-mode .table-header {
        background: #1e293b;
        border-bottom-color: #2a3446;
    }

    body.dark-mode .table-title {
        color: #FFFFFF !important;
    }

    body.dark-mode .table-title i {
        color: #FFFFFF !important;
    }

    body.dark-mode .stat-card {
        background: #111827;
        border-color: #2a3446;
    }

    body.dark-mode .p-2[style*="background: #f9fafb"],
    body.dark-mode .p-2[style*="background: var(--lao-gray)"],
    body.dark-mode .p-3[style*="background: var(--lao-gray)"],
    body.dark-mode .text-center[style*="background: var(--lao-gray)"] {
        background: #1e293b !important;
    }

    body.dark-mode div[style*="color: #000000"],
    body.dark-mode div[style*="color: #1a1a1a"] {
        color: #ffffff !important;
    }

    body.dark-mode small[style*="color: #1a1a1a"] {
        color: #cbd5e1 !important;
    }

    body.dark-mode p[style*="color: #1a1a1a"] {
        color: #cbd5e1 !important;
    }

    body.dark-mode .alert-danger {
        background: #7f1d1d;
        border-color: #991b1b;
        color: #fecaca;
    }

    body.dark-mode .alert-warning {
        background: #78350f;
        border-color: #92400e;
        color: #fde68a;
    }

    body.dark-mode .stat-icon.red {
        background: rgba(220, 38, 38, 0.2);
    }

    body.dark-mode .stat-icon.yellow {
        background: rgba(245, 158, 11, 0.2);
    }

    body.dark-mode .stat-icon.green {
        background: rgba(5, 150, 105, 0.2);
    }

    body.dark-mode .badge-overdue {
        background: rgba(220, 38, 38, 0.2);
    }

    body.dark-mode .badge-due-soon {
        background: rgba(245, 158, 11, 0.2);
    }

    body.dark-mode .badge-active {
        background: rgba(5, 150, 105, 0.2);
    }

    body.dark-mode .timeline div[style*="width: 30px"] {
        background: #1e293b !important;
    }
</style>
@endpush

@section('content')
<!-- Case Status Alert -->
@if($case->status === 'overdue' && $case->deadline_date)
<div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <div>
        <strong>OVERDUE:</strong> This case deadline passed {{ abs($case->remaining_days) }} days ago on {{ $case->deadline_date->format('F d, Y') }}. Immediate action required!
    </div>
</div>
@elseif($case->status === 'due_soon' && $case->deadline_date)
<div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
    <i class="bi bi-clock-fill me-2"></i>
    <div>
        <strong>DUE SOON:</strong> This case deadline is in {{ $case->remaining_days }} days on {{ $case->deadline_date->format('F d, Y') }}. Please prepare submission.
    </div>
</div>
@endif

<div class="row">
    <!-- Single Column Layout -->
    <div class="col-12">
        <!-- Case Details Panel -->
        <div class="table-container mb-3">
            <div class="table-header">
                <h5 class="table-title">
                    <i class="bi bi-info-circle-fill"></i> Case Information
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('cases.edit', $case) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Edit Case
                    </a>
                    <a href="{{ route('cases.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="p-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Case Number</label>
                            <div style="font-size: 15px; font-weight: 700; color: #000000;">{{ $case->case_number }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Docket Number</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $case->docket_no ?: 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Case Title</label>
                            <div style="font-size: 14px; font-weight: 600; color: #000000;">{{ $case->case_title }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Client Name</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $case->client_name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Assigned Lawyer</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $case->assigned_lawyer ?: 'Not Assigned' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--lao-text-light); margin-bottom: 4px;">Section</label>
                            <div style="font-size: 14px; font-weight: 500;">
                                @if($case->section)
                                    <span class="badge bg-primary">{{ $case->section }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Case Type</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $case->case_type ?: 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--lao-text-light); margin-bottom: 4px;">Status</label>
                            <div>
                                @if($case->status === 'overdue')
                                    <span class="badge bg-danger">Overdue</span>
                                @elseif($case->status === 'due_soon')
                                    <span class="badge bg-warning text-dark">Due Soon</span>
                                @elseif($case->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($case->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Court/Agency</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">
                                @if($case->court_agency)
                                    @php
                                        $courtNames = [
                                            'SC' => 'Supreme Court',
                                            'CA' => 'Court of Appeals',
                                            'RTC' => 'Regional Trial Court',
                                            'OMB' => 'Office of the Ombudsman',
                                            'NCIP' => 'NCIP',
                                            'Special/IP' => 'Special/IP',
                                            'Other' => 'Other'
                                        ];
                                    @endphp
                                    <span class="badge bg-info">{{ $case->court_agency }}</span>
                                    <span class="text-muted ms-2" style="font-size: 12px; font-weight: 500;">{{ $courtNames[$case->court_agency] ?? $case->court_agency }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--lao-text-light); margin-bottom: 4px;">Region</label>
                            <div style="font-size: 14px; font-weight: 500;">
                                @if($case->region)
                                    <span class="badge bg-secondary">{{ $case->region }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Filing Date</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">
                                <i class="bi bi-calendar3"></i> {{ $case->date_filed ? $case->date_filed->format('M d, Y') : 'Not set' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Deadline Date</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">
                                <i class="bi bi-calendar-x"></i> {{ $case->deadline_date ? $case->deadline_date->format('M d, Y') : 'Not set' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--lao-text-light); margin-bottom: 4px;">Days Remaining</label>
                            <div>
                                @if($case->status === 'overdue')
                                    <span class="badge badge-overdue" style="font-size: 11px; padding: 6px 10px;">
                                        <i class="bi bi-x-circle-fill"></i> {{ abs($case->remaining_days) }} DAYS OVERDUE
                                    </span>
                                @elseif($case->status === 'due_soon')
                                    <span class="badge badge-due-soon" style="font-size: 11px; padding: 6px 10px;">
                                        <i class="bi bi-clock-fill"></i> {{ $case->remaining_days }} DAYS LEFT
                                    </span>
                                @else
                                    <span class="badge badge-active" style="font-size: 11px; padding: 6px 10px;">
                                        <i class="bi bi-check-circle-fill"></i> {{ $case->remaining_days }} DAYS LEFT
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($case->hearing_date)
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Next Hearing Date</label>
                            <div style="font-size: 13px; font-weight: 600; color: #1a1a1a;">
                                <i class="bi bi-calendar-event text-success"></i> {{ $case->hearing_date->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($case->description)
                    <div class="col-12">
                        <div class="mb-0">
                            <label class="form-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">Case Description</label>
                            <div style="font-size: 13px; color: #1a1a1a; line-height: 1.5; font-weight: 500;">{{ $case->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline of Actions -->
        <div class="table-container mb-3">
            <div class="table-header">
                <h5 class="table-title">
                    <i class="bi bi-clock-history"></i> Case Timeline
                </h5>
            </div>
            <div class="p-2">
                <div class="timeline">
                    <!-- Filed Event -->
                    @if($case->date_filed)
                    <div class="d-flex mb-2">
                        <div class="me-2">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: rgba(5, 150, 105, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-plus text-success" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-weight: 700; color: #000000; font-size: 12px;">Case Filed</div>
                            <div style="font-size: 11px; color: #6b7280; font-weight: 600;">{{ $case->date_filed->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif

                    @if($case->hearing_date)
                    <!-- Hearing Event -->
                    <div class="d-flex mb-2">
                        <div class="me-2">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-event text-warning" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-weight: 700; color: #000000; font-size: 12px;">Hearing Scheduled</div>
                            <div style="font-size: 11px; color: #6b7280; font-weight: 600;">{{ $case->hearing_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif

                    <!-- Deadline Event -->
                    @if($case->deadline_date)
                    <div class="d-flex">
                        <div class="me-2">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: rgba(220, 38, 38, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-flag-fill text-danger" style="font-size: 12px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-weight: 700; color: #000000; font-size: 12px;">Filing Deadline</div>
                            <div style="font-size: 11px; color: #6b7280; font-weight: 600;">{{ $case->deadline_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-2 p-2" style="background: var(--lao-gray); border-radius: 6px;">
                    <small style="color: #1a1a1a; font-weight: 500;">
                        <i class="bi bi-info-circle"></i> Timeline shows key dates and milestones for this case.
                    </small>
                </div>
            </div>
        </div>

        <!-- Case Status and Important Dates in Row -->
        <div class="row g-3 mb-3">
            <!-- Case Status Card -->
            <div class="col-lg-6">
                <div class="stat-card">
                    <h5 class="mb-2" style="font-size: 14px; font-weight: 700; color: #000000;">
                        <i class="bi bi-kanban"></i> Case Status
                    </h5>
                    <div class="text-center p-3" style="background: var(--lao-gray); border-radius: 8px;">
                        @if($case->status === 'overdue')
                            <div class="stat-icon red mx-auto mb-2" style="width: 48px; height: 48px; font-size: 20px;">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h4 class="text-danger mb-1" style="font-weight: 700; font-size: 18px;">OVERDUE</h4>
                            <p style="font-size: 12px; color: #1a1a1a; margin: 0; font-weight: 600;">
                                {{ abs($case->remaining_days) }} days past deadline
                            </p>
                        @elseif($case->status === 'due_soon')
                            <div class="stat-icon yellow mx-auto mb-2" style="width: 48px; height: 48px; font-size: 20px;">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h4 class="text-warning mb-1" style="font-weight: 700; font-size: 18px;">DUE SOON</h4>
                            <p style="font-size: 12px; color: #1a1a1a; margin: 0; font-weight: 600;">
                                {{ $case->remaining_days }} days remaining
                            </p>
                        @else
                            <div class="stat-icon green mx-auto mb-2" style="width: 48px; height: 48px; font-size: 20px;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="text-success mb-1" style="font-weight: 700; font-size: 18px;">ACTIVE</h4>
                            <p style="font-size: 12px; color: #1a1a1a; margin: 0; font-weight: 600;">
                                {{ $case->remaining_days }} days remaining
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Important Dates Section -->
            <div class="col-lg-6">
                <div class="stat-card">
                    <h5 class="mb-2" style="font-size: 14px; font-weight: 700; color: #000000;">
                        <i class="bi bi-calendar-range"></i> Important Dates
                    </h5>
                    <div class="row g-2">
                        @if($case->date_filed)
                        <div class="col-12">
                            <div class="p-2" style="background: #f9fafb; border-radius: 6px;">
                                <div style="font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; font-weight: 600;">Date Filed</div>
                                <div style="font-size: 13px; font-weight: 700; color: #000000;">
                                    <i class="bi bi-calendar3"></i> {{ $case->date_filed->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($case->hearing_date)
                        <div class="col-12">
                            <div class="p-2" style="background: #f9fafb; border-radius: 6px;">
                                <div style="font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; font-weight: 600;">Next Hearing</div>
                                <div style="font-size: 13px; font-weight: 700; color: #000000;">
                                    <i class="bi bi-calendar-event"></i> {{ $case->hearing_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($case->deadline_date)
                        <div class="col-12">
                            <div class="p-2" style="background: #f9fafb; border-radius: 6px;">
                                <div style="font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; font-weight: 600;">Deadline</div>
                                <div style="font-size: 13px; font-weight: 700; color: #000000;" class="{{ $case->status === 'overdue' ? 'text-danger' : '' }}">
                                    <i class="bi bi-flag-fill"></i> {{ $case->deadline_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
