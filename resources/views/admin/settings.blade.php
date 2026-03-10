@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-gear me-2 icon-innovation"></i>System Settings</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- LAO Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-building icon-building"></i> LAO Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Office Name</label>
                        <input type="text" name="office_name" class="form-control" 
                               value="{{ old('office_name', 'Legal Assistance Office') }}" placeholder="Legal Assistance Office">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Office Code</label>
                        <input type="text" name="office_code" class="form-control" 
                               value="{{ old('office_code', 'LAO') }}" placeholder="LAO">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Office Address</label>
                        <textarea name="office_address" class="form-control" rows="2" 
                                  placeholder="Enter complete office address">{{ old('office_address') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" 
                               value="{{ old('contact_number') }}" placeholder="+63 xxx xxx xxxx">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="office_email" class="form-control" 
                               value="{{ old('office_email') }}" placeholder="office@example.com">
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bell"></i> Notification Settings</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Days Before Deadline (Warning)</label>
                        <input type="number" name="warning_days" class="form-control" 
                               value="{{ old('warning_days', 7) }}" min="1" max="30">
                        <small class="text-muted">Send notification X days before deadline</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Days Before Deadline (Alert)</label>
                        <input type="number" name="alert_days" class="form-control" 
                               value="{{ old('alert_days', 3) }}" min="1" max="30">
                        <small class="text-muted">Send urgent alert X days before deadline</small>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_notifications" 
                                   id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Enable Email Notifications
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="daily_summary" 
                                   id="dailySummary" checked>
                            <label class="form-check-label" for="dailySummary">
                                Send Daily Summary Report
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Management Settings -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-briefcase"></i> Case Management Settings</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Default Case Status</label>
                        <select name="default_status" class="form-select">
                            <option value="active" selected>Active</option>
                            <option value="pending">Pending</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Auto-Archive Completed Cases After</label>
                        <input type="number" name="auto_archive_days" class="form-control" 
                               value="{{ old('auto_archive_days', 365) }}" min="30" max="3650">
                        <small class="text-muted">Days (0 to disable auto-archiving)</small>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="require_case_number" 
                                   id="requireCaseNumber" checked>
                            <label class="form-check-label" for="requireCaseNumber">
                                Require Case Number for All Cases
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="allow_duplicate_case_numbers" 
                                   id="allowDuplicates">
                            <label class="form-check-label" for="allowDuplicates">
                                Allow Duplicate Case Numbers
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Settings -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bar-chart icon-analytics"></i> Report Settings</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Default Report Date Range</label>
                        <select name="default_report_range" class="form-select">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                            <option value="365">Last Year</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reports Per Page</label>
                        <input type="number" name="reports_per_page" class="form-control" 
                               value="{{ old('reports_per_page', 50) }}" min="10" max="200">
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="include_archived" 
                                   id="includeArchived">
                            <label class="form-check-label" for="includeArchived">
                                Include Archived Cases in Reports by Default
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Maintenance -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-tools"></i> System Maintenance</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" 
                                   id="maintenanceMode">
                            <label class="form-check-label" for="maintenanceMode">
                                <strong>Enable Maintenance Mode</strong>
                            </label>
                            <br>
                            <small class="text-muted">System will display maintenance page to all users except administrators</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Maintenance Message</label>
                        <textarea name="maintenance_message" class="form-control" rows="3" 
                                  placeholder="Optional message to display during maintenance">{{ old('maintenance_message', 'System is currently under maintenance. Please check back later.') }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-warning" onclick="alert('Database backup feature coming soon!')">
                                <i class="bi bi-database"></i> Backup Database
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Are you sure? This will clear all cache.')) alert('Cache cleared successfully!')">
                                <i class="bi bi-trash"></i> Clear Cache
                            </button>
                            <button type="button" class="btn btn-outline-info" onclick="alert('System logs viewer coming soon!')">
                                <i class="bi bi-file-text"></i> View System Logs
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="card">
            <div class="card-body text-end">
                <button type="reset" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-x-circle"></i> Reset to Defaults
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Save Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
