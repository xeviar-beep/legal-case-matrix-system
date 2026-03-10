

<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bell-fill me-2 icon-chart"></i>Notifications</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="bi bi-inbox-fill icon-chart fs-2"></i>
                    <h3 class="mt-2 mb-1 text-primary"><?php echo e($stats['total']); ?></h3>
                    <p class="text-muted small mb-0">Total Notifications</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    <h3 class="mt-2 mb-1 text-danger"><?php echo e($stats['critical']); ?></h3>
                    <p class="text-muted small mb-0">Critical Alerts</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="bi bi-exclamation-circle-fill text-warning fs-2"></i>
                    <h3 class="mt-2 mb-1 text-warning"><?php echo e($stats['warning']); ?></h3>
                    <p class="text-muted small mb-0">Warnings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="bi bi-info-circle-fill text-info fs-2"></i>
                    <h3 class="mt-2 mb-1 text-info"><?php echo e($stats['info']); ?></h3>
                    <p class="text-muted small mb-0">Information</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                All (<?php echo e($stats['total']); ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="critical-tab" data-bs-toggle="tab" data-bs-target="#critical" type="button">
                <span class="text-danger">Critical (<?php echo e($stats['critical']); ?>)</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="warning-tab" data-bs-toggle="tab" data-bs-target="#warning" type="button">
                <span class="text-warning">Warning (<?php echo e($stats['warning']); ?>)</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">
                <span class="text-info">Info (<?php echo e($stats['info']); ?>)</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="notificationTabsContent">
        <!-- All Notifications -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            <?php if($allNotifications->count() > 0): ?>
                <div class="card">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $allNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('cases.show', $notification['case'])); ?>" class="list-group-item notification-item <?php echo e($notification['type']); ?> notification-clickable" data-type="<?php echo e($notification['type']); ?>">
                            <div class="d-flex w-100 flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1 w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <?php if($notification['type'] === 'critical'): ?>
                                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2"></i>
                                        <?php elseif($notification['type'] === 'warning'): ?>
                                            <i class="bi bi-exclamation-circle-fill text-warning fs-5 me-2"></i>
                                        <?php else: ?>
                                            <i class="bi bi-info-circle-fill text-info fs-5 me-2"></i>
                                        <?php endif; ?>
                                        <h6 class="mb-0 fw-bold text-dark"><?php echo e($notification['title']); ?></h6>
                                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                    </div>
                                    <p class="mb-2 text-muted"><?php echo e($notification['message']); ?></p>
                                    <div class="d-flex flex-wrap gap-2 gap-md-3 align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?php echo e($notification['case']->client_name); ?>

                                        </small>
                                        <?php if($notification['case']->section): ?>
                                        <small>
                                            <span class="badge bg-secondary"><?php echo e($notification['case']->section); ?></span>
                                        </small>
                                        <?php endif; ?>
                                        <?php if($notification['case']->assigned_lawyer): ?>
                                        <small class="text-muted">
                                            <i class="bi bi-briefcase"></i> <?php echo e($notification['case']->assigned_lawyer); ?>

                                        </small>
                                        <?php endif; ?>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($notification['created_at'])->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-bell-slash fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No Notifications</h5>
                        <p class="text-muted">You're all caught up!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Critical Notifications -->
        <div class="tab-pane fade" id="critical" role="tabpanel">
            <?php if($stats['critical'] > 0): ?>
                <div class="card">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $allNotifications->where('type', 'critical'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('cases.show', $notification['case'])); ?>" class="list-group-item notification-item critical notification-clickable">
                            <div class="d-flex w-100 flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1 w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark"><?php echo e($notification['title']); ?></h6>
                                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                    </div>
                                    <p class="mb-2 text-muted"><?php echo e($notification['message']); ?></p>
                                    <div class="d-flex flex-wrap gap-2 gap-md-3 align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?php echo e($notification['case']->client_name); ?>

                                        </small>
                                        <small>
                                            <span class="badge bg-secondary"><?php echo e($notification['case']->section); ?></span>
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($notification['created_at'])->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-check-circle fs-1 text-success d-block mb-3"></i>
                        <h5 class="text-muted">No Critical Alerts</h5>
                        <p class="text-muted">No overdue cases at the moment.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Warning Notifications -->
        <div class="tab-pane fade" id="warning" role="tabpanel">
            <?php if($stats['warning'] > 0): ?>
                <div class="card">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $allNotifications->where('type', 'warning'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('cases.show', $notification['case'])); ?>" class="list-group-item notification-item warning notification-clickable">
                            <div class="d-flex w-100 flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1 w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-exclamation-circle-fill text-warning fs-5 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark"><?php echo e($notification['title']); ?></h6>
                                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                    </div>
                                    <p class="mb-2 text-muted"><?php echo e($notification['message']); ?></p>
                                    <div class="d-flex flex-wrap gap-2 gap-md-3 align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?php echo e($notification['case']->client_name); ?>

                                        </small>
                                        <small>
                                            <span class="badge bg-secondary"><?php echo e($notification['case']->section); ?></span>
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($notification['created_at'])->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-check-circle fs-1 text-success d-block mb-3"></i>
                        <h5 class="text-muted">No Warnings</h5>
                        <p class="text-muted">No cases due soon.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Info Notifications -->
        <div class="tab-pane fade" id="info" role="tabpanel">
            <?php if($stats['info'] > 0): ?>
                <div class="card">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $allNotifications->where('type', 'info'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('cases.show', $notification['case'])); ?>" class="list-group-item notification-item info notification-clickable">
                            <div class="d-flex w-100 flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1 w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-info-circle-fill text-info fs-5 me-2"></i>
                                        <h6 class="mb-0 fw-bold text-dark"><?php echo e($notification['title']); ?></h6>
                                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                                    </div>
                                    <p class="mb-2 text-muted"><?php echo e($notification['message']); ?></p>
                                    <div class="d-flex flex-wrap gap-2 gap-md-3 align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?php echo e($notification['case']->client_name); ?>

                                        </small>
                                        <small>
                                            <span class="badge bg-secondary"><?php echo e($notification['case']->section); ?></span>
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($notification['created_at'])->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No Hearings Today</h5>
                        <p class="text-muted">No hearing schedules for today.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.notification-item {
    padding: 1.25rem;
    transition: all 0.2s ease;
    border-left: 4px solid transparent;
    text-decoration: none;
    color: inherit;
    display: block;
}

.notification-clickable {
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.notification-item.critical {
    border-left-color: #dc3545;
    background-color: #fff5f5;
}

.notification-item.critical:hover {
    background-color: #ffe5e5;
}

.notification-item.warning {
    border-left-color: #ffc107;
    background-color: #fffbf0;
}

.notification-item.warning:hover {
    background-color: #fff3d0;
}

.notification-item.info {
    border-left-color: #0dcaf0;
    background-color: #f0f9ff;
}

.notification-item.info:hover {
    background-color: #e0f2fe;
}

.notification-item .text-dark {
    color: #212529 !important;
}

.notification-item:hover .bi-chevron-right {
    transform: translateX(5px);
    transition: transform 0.2s ease;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #dee2e6;
}

.nav-tabs .nav-link.active {
    color: var(--lao-primary);
    border-bottom-color: var(--lao-primary);
    background: none;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .notification-item {
        padding: 1rem;
    }
    
    .notification-item h6 {
        font-size: 0.95rem;
    }
    
    .notification-item p {
        font-size: 0.875rem;
    }
    
    .notification-item small {
        font-size: 0.75rem;
    }
    
    .d-flex.gap-3 {
        gap: 0.5rem !important;
    }
    
    .card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .notification-item {
        padding: 0.75rem;
    }
    
    .notification-item:hover {
        transform: none;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/notifications/index.blade.php ENDPATH**/ ?>