

<?php $__env->startSection('title', 'Case Information'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    html {
        scroll-behavior: smooth;
    }
    
    .card {
        scroll-margin-top: 100px;
    }

    /* Dark Mode Styles */
    body.dark-mode .card {
        background: #111827;
        border-color: #2a3446;
    }

    body.dark-mode .card-body {
        background: #111827;
        color: #ffffff;
    }

    body.dark-mode .card-body .p-2[style*="background: #f8f9fa"] {
        background: #1e293b !important;
    }

    body.dark-mode .card-body .p-3[style*="background: #f8f9fa"] {
        background: #1e293b !important;
    }

    body.dark-mode .card-body div[style*="background: #f8f9fa"] {
        background: #1e293b !important;
    }

    body.dark-mode .card-body .d-flex[style*="background: white"] {
        background: #1e293b !important;
    }

    body.dark-mode .text-primary {
        color: #60a5fa !important;
    }

    body.dark-mode h6.text-primary {
        color: #60a5fa !important;
    }

    body.dark-mode .alert-info {
        background: #1e3a5f;
        border-color: #2a4a7c;
        color: #ffffff;
    }

    body.dark-mode .modal-content {
        background: #1e293b;
        color: #ffffff;
    }

    body.dark-mode .modal-header {
        border-bottom-color: #2a3446;
    }

    body.dark-mode .modal-footer {
        border-top-color: #2a3446;
    }

    body.dark-mode .form-control {
        background: #111827;
        border-color: #2a3446;
        color: #ffffff;
    }

    body.dark-mode .form-label {
        color: #cbd5e1;
    }

    body.dark-mode .btn-close {
        filter: invert(1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-info-circle-fill me-2"></i>Case Information Overview</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('cases.index')); ?>">Cases</a></li>
                <li class="breadcrumb-item active">Case Information</li>
            </ol>
        </nav>
    </div>

    <!-- Information Banner -->
    <div class="alert alert-info mb-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-3" style="font-size: 24px;"></i>
            <div>
                <strong>Case Information Center</strong>
                <p class="mb-0 mt-1">View detailed information for all cases including documents, notes, and management options. Each case card shows complete case details with quick actions.</p>
            </div>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <!-- Case Card -->
    <div class="card mb-4 shadow-sm" id="case-<?php echo e($case->id); ?>" style="scroll-margin-top: 100px;">
        <div class="card-header" style="background: linear-gradient(135deg, #001F3F 0%, #003D7A 100%); color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1" style="font-weight: 700;">
                        <i class="bi bi-folder-fill me-2"></i><?php echo e($case->case_number); ?>

                    </h5>
                    <p class="mb-0" style="font-size: 14px; opacity: 0.95;"><?php echo e($case->case_title); ?></p>
                </div>
                <div>
                    <?php if($case->status === 'overdue'): ?>
                        <span class="badge bg-danger" style="font-size: 12px; padding: 8px 12px;">
                            <i class="bi bi-exclamation-triangle-fill"></i> OVERDUE
                        </span>
                    <?php elseif($case->status === 'due_soon'): ?>
                        <span class="badge bg-warning text-dark" style="font-size: 12px; padding: 8px 12px;">
                            <i class="bi bi-clock-fill"></i> DUE SOON
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success" style="font-size: 12px; padding: 8px 12px;">
                            <i class="bi bi-check-circle-fill"></i> ACTIVE
                        </span>
                    <?php endif; ?>
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
                                <div class="text-bold" style="font-weight: 600;"><?php echo e($case->docket_no ?: 'N/A'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Client Name</small>
                                <div class="text-bold" style="font-weight: 600;"><?php echo e($case->client_name); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Assigned Lawyer</small>
                                <div class="text-bold" style="font-weight: 600;"><?php echo e($case->assigned_lawyer ?: 'Not Assigned'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Case Type</small>
                                <div class="text-bold" style="font-weight: 600;"><?php echo e($case->case_type ?: 'N/A'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Court/Agency</small>
                                <div class="text-bold" style="font-weight: 600;">
                                    <?php if($case->court_agency): ?>
                                        <span class="badge bg-info"><?php echo e($case->court_agency); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Region</small>
                                <div class="text-bold" style="font-weight: 600;">
                                    <?php if($case->region): ?>
                                        <span class="badge bg-secondary"><?php echo e($case->region); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Filing Date</small>
                                <div class="text-bold" style="font-weight: 600; font-size: 13px;">
                                    <i class="bi bi-calendar3"></i> <?php echo e($case->date_filed ? $case->date_filed->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Deadline</small>
                                <div class="text-bold" style="font-weight: 600; font-size: 13px;">
                                    <i class="bi bi-calendar-x"></i> <?php echo e($case->deadline_date ? $case->deadline_date->format('M d, Y') : 'N/A'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2" style="background: #f8f9fa; border-radius: 8px;">
                                <small class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Days Left</small>
                                <div style="font-weight: 700; font-size: 13px;">
                                    <?php if($case->status === 'overdue'): ?>
                                        <span class="text-danger"><?php echo e(abs($case->remaining_days)); ?> days overdue</span>
                                    <?php else: ?>
                                        <span class="text-success"><?php echo e($case->remaining_days); ?> days</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents and Actions Column -->
                <div class="col-lg-6">
                    <!-- Documents Section -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-primary mb-0"><i class="bi bi-files"></i> Documents (<?php echo e($case->documents->count()); ?>)</h6>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal<?php echo e($case->id); ?>">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                        </div>
                        
                        <div style="max-height: 150px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 8px;">
                            <?php if($case->documents->count() > 0): ?>
                                <?php $__currentLoopData = $case->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: white; border-radius: 6px;">
                                        <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                                            <span style="font-size: 12px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?php echo e($document->file_name); ?>

                                            </span>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="<?php echo e(route('documents.download', $document)); ?>" class="btn btn-sm btn-outline-primary" style="padding: 2px 6px;">
                                                <i class="bi bi-download" style="font-size: 10px;"></i>
                                            </a>
                                            <form action="<?php echo e(route('documents.destroy', $document)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 2px 6px;" onclick="return confirm('Delete this document?')">
                                                    <i class="bi bi-trash" style="font-size: 10px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-3">
                                    <i class="bi bi-file-earmark-x text-muted" style="font-size: 2rem; opacity: 0.4;"></i>
                                    <p class="text-muted mb-0 mt-2" style="font-size: 12px;">No documents uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-primary btn-sm flex-fill">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                        <a href="<?php echo e(route('cases.edit', $case)); ?>" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="<?php echo e(route('cases.destroy', $case)); ?>" method="POST" class="flex-fill">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Delete case <?php echo e($case->case_number); ?>? This action cannot be undone.')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <?php if($case->description): ?>
            <div class="mt-3 p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #99272D;">
                <small class="text-muted d-block mb-1" style="font-size: 10px; text-transform: uppercase; font-weight: 600;">Case Description</small>
                <div class="text-secondary" style="font-size: 13px; line-height: 1.5;"><?php echo e($case->description); ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadModal<?php echo e($case->id); ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-upload"></i> Upload Document - <?php echo e($case->case_number); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('documents.store', $case)); ?>" method="POST" enctype="multipart/form-data" onsubmit="sessionStorage.removeItem('scrollPosition');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="redirect_to" value="<?php echo e(route('cases.information')); ?>#case-<?php echo e($case->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select File</label>
                            <input type="file" name="document" class="form-control" required>
                            <small class="text-muted">Maximum file size: 10MB</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the document..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-folder-x" style="font-size: 4rem; color: #dee2e6;"></i>
            <h4 class="mt-3 text-muted">No Cases Found</h4>
            <p class="text-muted">There are no cases in the system yet.</p>
            <a href="<?php echo e(route('cases.create')); ?>" class="btn btn-primary mt-2">
                <i class="bi bi-plus-circle"></i> Create New Case
            </a>
        </div>
    </div>
    <?php endif; ?>

    <?php if($cases->count() > 0): ?>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing <?php echo e($cases->count()); ?> case(s)
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/cases/information.blade.php ENDPATH**/ ?>