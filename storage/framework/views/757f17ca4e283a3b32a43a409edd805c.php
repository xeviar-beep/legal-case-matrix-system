

<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-circle me-2"></i>My Profile</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
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
                        <?php if($user->profile_picture): ?>
                            <img src="<?php echo e($user->profile_picture_url); ?>" alt="<?php echo e($user->name); ?>" class="profile-picture-large rounded-circle" id="profilePicturePreview">
                        <?php else: ?>
                            <div class="profile-picture-large rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" id="profilePicturePreview">
                                <span style="font-size: 3rem; font-weight: 700;"><?php echo e($user->initials); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form action="<?php echo e(route('profile.update-picture')); ?>" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(this)" required>
                            <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-upload me-1"></i> Upload Picture
                        </button>
                    </form>

                    <?php if($user->profile_picture): ?>
                    <form action="<?php echo e(route('profile.remove-picture')); ?>" method="POST" onsubmit="return confirm('Are you sure you want to remove your profile picture?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-1"></i> Remove Picture
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Account Information</h6>
                    <div class="mb-3">
                        <small class="text-muted d-block">Role</small>
                        <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : ($user->role === 'attorney' ? 'primary' : 'secondary')); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-<?php echo e($user->is_active ? 'success' : 'danger'); ?>">
                            <?php echo e($user->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Member Since</small>
                        <strong><?php echo e($user->created_at->format('M d, Y')); ?></strong>
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
                    <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <form action="<?php echo e(route('profile.update-password')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/profile/show.blade.php ENDPATH**/ ?>