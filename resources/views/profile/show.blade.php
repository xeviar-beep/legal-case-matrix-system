@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-circle me-2"></i>My Profile</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Profile Picture Card -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Profile Picture</h5>
                    
                    <div class="profile-picture-wrapper mb-4">
                        @if($user->profile_picture)
                            <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="profile-picture-large rounded-circle" id="profilePicturePreview">
                        @else
                            <div class="profile-picture-large rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" id="profilePicturePreview">
                                <span style="font-size: 3rem; font-weight: 700;">{{ $user->initials }}</span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                        @csrf
                        <div class="mb-3">
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(this)" required>
                            @error('profile_picture')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-upload me-1"></i> Upload Picture
                        </button>
                    </form>

                    @if($user->profile_picture)
                    <form action="{{ route('profile.remove-picture') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove your profile picture?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-1"></i> Remove Picture
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Account Information</h6>
                    <div class="mb-3">
                        <small class="text-muted d-block">Role</small>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'attorney' ? 'primary' : 'secondary') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Member Since</small>
                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Information
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                @error('new_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-key me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-picture-large {
    width: 200px;
    height: 200px;
    object-fit: cover;
    margin: 0 auto;
    border: 4px solid #e5e7eb;
}

.profile-picture-wrapper {
    display: flex;
    justify-content: center;
}

.card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control:focus {
    border-color: var(--lao-primary);
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('profilePicturePreview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="profile-picture-large rounded-circle">';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
