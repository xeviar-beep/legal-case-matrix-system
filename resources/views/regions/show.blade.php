@extends('layouts.app')

@section('title', $region . ' Cases')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-geo-alt me-2 icon-location"></i>{{ $region }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Regions</a></li>
                <li class="breadcrumb-item active">{{ $region }}</li>
            </ol>
        </nav>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Cases</h6>
                    <h3 class="mb-0 text-primary">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Due Soon</h6>
                    <h3 class="mb-0 text-warning">{{ $stats['due_soon'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Overdue</h6>
                    <h3 class="mb-0 text-danger">{{ $stats['overdue'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Docket No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Court/Agency</th>
                            <th>Assigned Lawyer</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                        <tr class="
                            @if($case->status === 'overdue') table-danger
                            @elseif($case->status === 'due_soon') table-warning
                            @endif
                        ">
                            <td class="fw-bold">{{ $case->case_number }}</td>
                            <td>{{ $case->docket_no ?? 'N/A' }}</td>
                            <td>{{ Str::limit($case->case_title, 40) }}</td>
                            <td>{{ $case->client_name }}</td>
                            <td>
                                @if($case->section)
                                    <span class="badge bg-secondary">{{ $case->section }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($case->court_agency)
                                    <span class="badge bg-info">{{ $case->court_agency }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $case->assigned_lawyer ?? 'Unassigned' }}</td>
                            <td>{{ $case->deadline_date ? \Carbon\Carbon::parse($case->deadline_date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                @if($case->status === 'overdue')
                                    <span class="badge bg-danger">Overdue</span>
                                @elseif($case->status === 'due_soon')
                                    <span class="badge bg-warning text-dark">Due Soon</span>
                                @elseif($case->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($case->status === 'completed')
                                    <span class="badge bg-secondary">Completed</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ ucfirst($case->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No cases found in {{ $region }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cases->hasPages())
            <div class="mt-3">
                {{ $cases->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
