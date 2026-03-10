@extends('layouts.app')

@section('title', 'Create Case')
@section('page-title', 'Create New Case')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('cases.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- Case Number -->
                        <div class="col-md-6">
                            <label for="case_number" class="form-label">Case Number</label>
                            <input type="text" class="form-control @error('case_number') is-invalid @enderror" 
                                   id="case_number" name="case_number" value="{{ old('case_number') }}">
                            @error('case_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Docket Number -->
                        <div class="col-md-6">
                            <label for="docket_no" class="form-label">Docket Number</label>
                            <input type="text" class="form-control @error('docket_no') is-invalid @enderror" 
                                   id="docket_no" name="docket_no" value="{{ old('docket_no') }}" 
                                   placeholder="e.g., G.R. No. 123456">
                            @error('docket_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case Title -->
                        <div class="col-md-12">
                            <label for="case_title" class="form-label">Case Title</label>
                            <input type="text" class="form-control @error('case_title') is-invalid @enderror" 
                                   id="case_title" name="case_title" value="{{ old('case_title') }}">
                            @error('case_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Client Name -->
                        <div class="col-md-6">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" value="{{ old('client_name') }}">
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assigned Lawyer -->
                        <div class="col-md-6">
                            <label for="assigned_lawyer" class="form-label">Assigned Lawyer</label>
                            <input type="text" class="form-control @error('assigned_lawyer') is-invalid @enderror" 
                                   id="assigned_lawyer" name="assigned_lawyer" value="{{ old('assigned_lawyer') }}" 
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
                                <option value="Criminal" {{ old('section') == 'Criminal' ? 'selected' : '' }}>Criminal</option>
                                <option value="Civil" {{ old('section') == 'Civil' ? 'selected' : '' }}>Civil</option>
                                <option value="Labor" {{ old('section') == 'Labor' ? 'selected' : '' }}>Labor</option>
                                <option value="Administrative" {{ old('section') == 'Administrative' ? 'selected' : '' }}>Administrative</option>
                                <option value="Special/IP" {{ old('section') == 'Special/IP' ? 'selected' : '' }}>Special/IP</option>
                                <option value="OJ" {{ old('section') == 'OJ' ? 'selected' : '' }}>OJ (Office of Justice)</option>
                            </select>
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case Type -->
                        <div class="col-md-6">
                            <label for="case_type" class="form-label">Case Type</label>
                            <input type="text" class="form-control @error('case_type') is-invalid @enderror" 
                                   id="case_type" name="case_type" value="{{ old('case_type') }}" 
                                   placeholder="e.g., Homicide, Breach of Contract">
                            @error('case_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Court/Agency -->
                        <div class="col-md-6">
                            <label for="court_agency" class="form-label">Court/Agency</label>
                            <select class="form-select @error('court_agency') is-invalid @enderror" 
                                    id="court_agency" name="court_agency">
                                <option value="">Select Court/Agency</option>
                                <option value="SC" {{ old('court_agency') == 'SC' ? 'selected' : '' }}>Supreme Court (SC)</option>
                                <option value="CA" {{ old('court_agency') == 'CA' ? 'selected' : '' }}>Court of Appeals (CA)</option>
                                <option value="RTC" {{ old('court_agency') == 'RTC' ? 'selected' : '' }}>Regional Trial Court (RTC)</option>
                                <option value="OMB" {{ old('court_agency') == 'OMB' ? 'selected' : '' }}>Office of the Ombudsman (OMB)</option>
                                <option value="NCIP" {{ old('court_agency') == 'NCIP' ? 'selected' : '' }}>NCIP</option>
                                <option value="Special/IP" {{ old('court_agency') == 'Special/IP' ? 'selected' : '' }}>Special/IP</option>
                                <option value="Other" {{ old('court_agency') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('court_agency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div class="col-md-6">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select @error('region') is-invalid @enderror" 
                                    id="region" name="region">
                                <option value="">Select Region</option>
                                <option value="NCR" {{ old('region') == 'NCR' ? 'selected' : '' }}>NCR</option>
                                <option value="Region I" {{ old('region') == 'Region I' ? 'selected' : '' }}>Region I</option>
                                <option value="Region II" {{ old('region') == 'Region II' ? 'selected' : '' }}>Region II</option>
                                <option value="Region III" {{ old('region') == 'Region III' ? 'selected' : '' }}>Region III</option>
                                <option value="Region IV-A" {{ old('region') == 'Region IV-A' ? 'selected' : '' }}>Region IV-A (CALABARZON)</option>
                                <option value="Region IV-B" {{ old('region') == 'Region IV-B' ? 'selected' : '' }}>Region IV-B (MIMAROPA)</option>
                                <option value="Region V" {{ old('region') == 'Region V' ? 'selected' : '' }}>Region V</option>
                                <option value="Region VI" {{ old('region') == 'Region VI' ? 'selected' : '' }}>Region VI</option>
                                <option value="Region VII" {{ old('region') == 'Region VII' ? 'selected' : '' }}>Region VII</option>
                                <option value="Region VIII" {{ old('region') == 'Region VIII' ? 'selected' : '' }}>Region VIII</option>
                                <option value="Region IX" {{ old('region') == 'Region IX' ? 'selected' : '' }}>Region IX</option>
                                <option value="Region X" {{ old('region') == 'Region X' ? 'selected' : '' }}>Region X</option>
                                <option value="Region XI" {{ old('region') == 'Region XI' ? 'selected' : '' }}>Region XI</option>
                                <option value="Region XII" {{ old('region') == 'Region XII' ? 'selected' : '' }}>Region XII</option>
                                <option value="Region XIII" {{ old('region') == 'Region XIII' ? 'selected' : '' }}>Region XIII</option>
                                <option value="BARMM" {{ old('region') == 'BARMM' ? 'selected' : '' }}>BARMM</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Filed -->
                        <div class="col-md-4">
                            <label for="date_filed" class="form-label">Date Filed</label>
                            <input type="date" class="form-control @error('date_filed') is-invalid @enderror" 
                                   id="date_filed" name="date_filed" value="{{ old('date_filed', date('Y-m-d')) }}">
                            @error('date_filed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline Days -->
                        <div class="col-md-4">
                            <label for="deadline_days" class="form-label">Deadline Period (days)</label>
                            <select class="form-select @error('deadline_days') is-invalid @enderror" 
                                    id="deadline_days" name="deadline_days">
                                <option value="">Select Deadline</option>
                                <option value="15" {{ old('deadline_days') == 15 ? 'selected' : '' }}>15 days</option>
                                <option value="30" {{ old('deadline_days') == 30 ? 'selected' : '' }}>30 days</option>
                                <option value="60" {{ old('deadline_days') == 60 ? 'selected' : '' }}>60 days</option>
                                <option value="90" {{ old('deadline_days') == 90 ? 'selected' : '' }}>90 days</option>
                            </select>
                            @error('deadline_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">System will auto-calculate the deadline date</small>
                        </div>

                        <!-- Hearing Date -->
                        <div class="col-md-4">
                            <label for="hearing_date" class="form-label">Hearing Date (Optional)</label>
                            <input type="date" class="form-control @error('hearing_date') is-invalid @enderror" 
                                   id="hearing_date" name="hearing_date" value="{{ old('hearing_date') }}">
                            @error('hearing_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Case
                            </button>
                            <a href="{{ route('cases.index') }}" class="btn btn-outline-secondary">
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
