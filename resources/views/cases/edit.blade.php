@extends('layouts.app')

@section('title', 'Edit Case')
@section('page-title', 'Edit Case: ' . $case->case_number)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('cases.update', $case) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Court/Agency -->
                        <div class="col-md-6">
                            <label for="court_agency" class="form-label">Court/Agency</label>
                            <select class="form-select @error('court_agency') is-invalid @enderror" 
                                    id="court_agency" name="court_agency" onchange="toggleEditFormFields()">
                                <option value="">Select Court/Agency</option>
                                <option value="SC" {{ old('court_agency', $case->court_agency) == 'SC' ? 'selected' : '' }}>Supreme Court (SC)</option>
                                <option value="CA" {{ old('court_agency', $case->court_agency) == 'CA' ? 'selected' : '' }}>Court of Appeals (CA)</option>
                                <option value="RTC" {{ old('court_agency', $case->court_agency) == 'RTC' ? 'selected' : '' }}>Regional Trial Court (RTC)</option>
                                <option value="MTC" {{ old('court_agency', $case->court_agency) == 'MTC' ? 'selected' : '' }}>Municipal Trial Court (MTC)</option>
                                <option value="OMB" {{ old('court_agency', $case->court_agency) == 'OMB' ? 'selected' : '' }}>Office of the Ombudsman (OMB)</option>
                                <option value="ADMIN" {{ old('court_agency', $case->court_agency) == 'ADMIN' ? 'selected' : '' }}>Administrative</option>
                                <option value="NCIP" {{ old('court_agency', $case->court_agency) == 'NCIP' ? 'selected' : '' }}>NCIP</option>
                                <option value="REGIONS" {{ old('court_agency', $case->court_agency) == 'REGIONS' ? 'selected' : '' }}>Regions</option>
                                <option value="OJ" {{ old('court_agency', $case->court_agency) == 'OJ' ? 'selected' : '' }}>Office of Justice (OJ)</option>
                                <option value="Others" {{ old('court_agency', $case->court_agency) == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('court_agency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case Number -->
                        <div class="col-md-6">
                            <label for="case_number" class="form-label">Case Number</label>
                            <input type="text" class="form-control @error('case_number') is-invalid @enderror" 
                                   id="case_number" name="case_number" value="{{ old('case_number', $case->case_number) }}">
                            @error('case_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Docket Number -->
                        <div class="col-md-6">
                            <label for="docket_no" class="form-label">Docket Number</label>
                            <input type="text" class="form-control @error('docket_no') is-invalid @enderror" 
                                   id="docket_no" name="docket_no" value="{{ old('docket_no', $case->docket_no) }}" 
                                   placeholder="e.g., G.R. No. 123456">
                            @error('docket_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Old Folder No. -->
                        <div class="col-md-6">
                            <label for="old_folder_no" class="form-label">Old Folder No.</label>
                            <input type="text" class="form-control @error('old_folder_no') is-invalid @enderror" 
                                   id="old_folder_no" name="old_folder_no" value="{{ old('old_folder_no', $case->old_folder_no) }}" 
                                   placeholder="Enter old folder number">
                            @error('old_folder_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case Title -->
                        <div class="col-md-12">
                            <label for="case_title" class="form-label">Case Title</label>
                            <input type="text" class="form-control @error('case_title') is-invalid @enderror" 
                                   id="case_title" name="case_title" value="{{ old('case_title', $case->case_title) }}">
                            @error('case_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Client Name -->
                        <div class="col-md-6">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" value="{{ old('client_name', $case->client_name) }}">
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assigned Lawyer -->
                        <div class="col-md-6">
                            <label for="assigned_lawyer" class="form-label">Assigned Lawyer</label>
                            <input type="text" class="form-control @error('assigned_lawyer') is-invalid @enderror" 
                                   id="assigned_lawyer" name="assigned_lawyer" value="{{ old('assigned_lawyer', $case->assigned_lawyer) }}" 
                                   placeholder="Enter lawyer name">
                            @error('assigned_lawyer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section -->
                        <div class="col-md-6">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select @error('section') is-invalid @enderror" 
                                    id="section" name="section">
                                <option value="">Select Section</option>
                                <option value="Criminal" {{ old('section', $case->section) == 'Criminal' ? 'selected' : '' }}>Criminal</option>
                                <option value="Civil" {{ old('section', $case->section) == 'Civil' ? 'selected' : '' }}>Civil</option>
                                <option value="Labor" {{ old('section', $case->section) == 'Labor' ? 'selected' : '' }}>Labor</option>
                                <option value="Administrative" {{ old('section', $case->section) == 'Administrative' ? 'selected' : '' }}>Administrative</option>
                                <option value="Special/IP" {{ old('section', $case->section) == 'Special/IP' ? 'selected' : '' }}>Special/IP</option>
                                <option value="OJ" {{ old('section', $case->section) == 'OJ' ? 'selected' : '' }}>OJ (Office of Justice)</option>
                            </select>
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case Type -->
                        <div class="col-md-6">
                            <label for="case_type" class="form-label">Case Type</label>
                            <input type="text" class="form-control @error('case_type') is-invalid @enderror" 
                                   id="case_type" name="case_type" value="{{ old('case_type', $case->case_type) }}" 
                                   placeholder="e.g., Homicide, Breach of Contract">
                            @error('case_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Handling Counsel for NCIP -->
                        <div class="col-md-6">
                            <label for="handling_counsel_ncip" class="form-label">Handling Counsel for NCIP</label>
                            <input type="text" class="form-control @error('handling_counsel_ncip') is-invalid @enderror" 
                                   id="handling_counsel_ncip" name="handling_counsel_ncip" value="{{ old('handling_counsel_ncip', $case->handling_counsel_ncip) }}" 
                                   placeholder="Enter handling counsel name">
                            @error('handling_counsel_ncip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div class="col-md-6">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select @error('region') is-invalid @enderror" 
                                    id="region" name="region">
                                <option value="">Select Region</option>
                                <option value="NCR" {{ old('region', $case->region) == 'NCR' ? 'selected' : '' }}>NCR</option>
                                <option value="Region I" {{ old('region', $case->region) == 'Region I' ? 'selected' : '' }}>Region I</option>
                                <option value="Region II" {{ old('region', $case->region) == 'Region II' ? 'selected' : '' }}>Region II</option>
                                <option value="Region III" {{ old('region', $case->region) == 'Region III' ? 'selected' : '' }}>Region III</option>
                                <option value="Region IV-A" {{ old('region', $case->region) == 'Region IV-A' ? 'selected' : '' }}>Region IV-A (CALABARZON)</option>
                                <option value="Region IV-B" {{ old('region', $case->region) == 'Region IV-B' ? 'selected' : '' }}>Region IV-B (MIMAROPA)</option>
                                <option value="Region V" {{ old('region', $case->region) == 'Region V' ? 'selected' : '' }}>Region V</option>
                                <option value="Region VI" {{ old('region', $case->region) == 'Region VI' ? 'selected' : '' }}>Region VI</option>
                                <option value="Region VII" {{ old('region', $case->region) == 'Region VII' ? 'selected' : '' }}>Region VII</option>
                                <option value="Region VIII" {{ old('region', $case->region) == 'Region VIII' ? 'selected' : '' }}>Region VIII</option>
                                <option value="Region IX" {{ old('region', $case->region) == 'Region IX' ? 'selected' : '' }}>Region IX</option>
                                <option value="Region X" {{ old('region', $case->region) == 'Region X' ? 'selected' : '' }}>Region X</option>
                                <option value="Region XI" {{ old('region', $case->region) == 'Region XI' ? 'selected' : '' }}>Region XI</option>
                                <option value="Region XII" {{ old('region', $case->region) == 'Region XII' ? 'selected' : '' }}>Region XII</option>
                                <option value="Region XIII" {{ old('region', $case->region) == 'Region XIII' ? 'selected' : '' }}>Region XIII</option>
                                <option value="BARMM" {{ old('region', $case->region) == 'BARMM' ? 'selected' : '' }}>BARMM</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Filed -->
                        <div class="col-md-3">
                            <label for="date_filed" class="form-label">Date Filed</label>
                            <input type="date" class="form-control @error('date_filed') is-invalid @enderror" 
                                   id="date_filed" name="date_filed" value="{{ old('date_filed', $case->date_filed?->format('Y-m-d')) }}">
                            @error('date_filed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline Days -->
                        <div class="col-md-3">
                            <label for="deadline_days" class="form-label">Deadline Period (Days)</label>
                            <input type="number" class="form-control @error('deadline_days') is-invalid @enderror" 
                                   id="deadline_days" name="deadline_days" value="{{ old('deadline_days', $case->deadline_days) }}" placeholder="Enter days">
                            @error('deadline_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hearing Date -->
                        <div class="col-md-3">
                            <label for="hearing_date" class="form-label">Hearing Date</label>
                            <input type="date" class="form-control @error('hearing_date') is-invalid @enderror" 
                                   id="hearing_date" name="hearing_date" value="{{ old('hearing_date', $case->hearing_date?->format('Y-m-d')) }}">
                            @error('hearing_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $case->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="due_soon" {{ old('status', $case->status) == 'due_soon' ? 'selected' : '' }}>Due Soon</option>
                                <option value="overdue" {{ old('status', $case->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="completed" {{ old('status', $case->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="archived" {{ old('status', $case->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions Taken/Documents Filed -->
                        <div class="col-md-12">
                            <label for="actions_taken" class="form-label">Actions Taken/Documents Filed</label>
                            <textarea class="form-control @error('actions_taken') is-invalid @enderror" 
                                      id="actions_taken" name="actions_taken" rows="3" placeholder="Enter actions taken or documents filed">{{ old('actions_taken', $case->actions_taken) }}</textarea>
                            @error('actions_taken')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $case->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SC-Specific Fields -->
                        <div id="sc-edit-fields" style="display: none;">
                            <div class="row g-3">
                                <div class="col-12">
                                    <hr class="my-3">
                                    <h6 class="text-primary">Supreme Court Specific Information</h6>
                                </div>

                                <div class="col-md-6">
                                    <label for="new_sc_no" class="form-label">New SC No.</label>
                                    <input type="text" class="form-control @error('new_sc_no') is-invalid @enderror" 
                                           id="new_sc_no" name="new_sc_no" value="{{ old('new_sc_no', $case->new_sc_no) }}" 
                                           placeholder="Enter new SC number">
                                    @error('new_sc_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control @error('remarks') is-invalid @enderror" 
                                           id="remarks" name="remarks" value="{{ old('remarks', $case->remarks) }}" 
                                           placeholder="Enter remarks">
                                    @error('remarks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="action" class="form-label">Action</label>
                                    <textarea class="form-control @error('action') is-invalid @enderror" 
                                              id="action" name="action" rows="3" placeholder="Describe the action...">{{ old('action', $case->action) }}</textarea>
                                    @error('action')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="issues_grounds" class="form-label">Issues/Grounds for Allowance of the Petition</label>
                                    <textarea class="form-control @error('issues_grounds') is-invalid @enderror" 
                                              id="issues_grounds" name="issues_grounds" rows="4" placeholder="Enter issues and grounds...">{{ old('issues_grounds', $case->issues_grounds) }}</textarea>
                                    @error('issues_grounds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="prayers_relief" class="form-label">Prayers (Relief)</label>
                                    <textarea class="form-control @error('prayers_relief') is-invalid @enderror" 
                                              id="prayers_relief" name="prayers_relief" rows="3" placeholder="Enter prayers and relief sought...">{{ old('prayers_relief', $case->prayers_relief) }}</textarea>
                                    @error('prayers_relief')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="optional_blank_section" class="form-label">Optional / Additional Notes</label>
                                    <textarea class="form-control @error('optional_blank_section') is-invalid @enderror" 
                                              id="optional_blank_section" name="optional_blank_section" rows="2" placeholder="Any additional information...">{{ old('optional_blank_section', $case->optional_blank_section) }}</textarea>
                                    @error('optional_blank_section')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Case
                            </button>
                            <a href="{{ route('cases.show', $case) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function toggleEditFormFields() {
        const courtAgency = document.getElementById('court_agency').value;
        const scFields = document.getElementById('sc-edit-fields');
        
        // Helper function to disable/enable all inputs in a section
        function toggleInputs(section, enable) {
            const inputs = section.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = !enable;
            });
        }
        
        if (courtAgency === 'SC') {
            scFields.style.display = 'block';
            toggleInputs(scFields, true);  // Enable SC-specific fields
        } else {
            scFields.style.display = 'none';
            toggleInputs(scFields, false);  // Disable SC-specific fields
        }
    }

    // Run on page load to show appropriate fields
    document.addEventListener('DOMContentLoaded', function() {
        toggleEditFormFields();
    });
</script>
@endpush