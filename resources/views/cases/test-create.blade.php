@extends('layouts.app')

@section('title', 'Test Add Case')
@section('page-title', 'Test Add Case')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Test Case Creation</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('cases.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="case_number" class="form-label">Case Number</label>
                            <input type="text" class="form-control" id="case_number" name="case_number" value="TEST-{{ time() }}">
                        </div>

                        <div class="mb-3">
                            <label for="docket_no" class="form-label">Docket Number</label>
                            <input type="text" class="form-control" id="docket_no" name="docket_no" value="DOC-123">
                        </div>

                        <div class="mb-3">
                            <label for="case_title" class="form-label">Case Title</label>
                            <input type="text" class="form-control" id="case_title" name="case_title" value="Test Case Title">
                        </div>

                        <div class="mb-3">
                            <label for="handling_counsel_ncip" class="form-label">Handling Counsel for NCIP</label>
                            <input type="text" class="form-control" id="handling_counsel_ncip" name="handling_counsel_ncip" value="John Doe">
                        </div>

                        <div class="mb-3">
                            <label for="actions_taken" class="form-label">Actions Taken / Documents Filed</label>
                            <textarea class="form-control" id="actions_taken" name="actions_taken" rows="3">Test actions filed</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Test Case</button>
                        <a href="{{ route('cases.index') }}" class="btn btn-secondary">Back to Cases</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
