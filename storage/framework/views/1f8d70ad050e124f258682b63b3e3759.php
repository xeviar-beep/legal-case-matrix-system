

<?php $__env->startSection('title', 'Deadline Compliance Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar-check me-2 icon-warning"></i>Deadline Compliance Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('reports.index')); ?>">Reports</a></li>
                <li class="breadcrumb-item active">Deadline Compliance</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('reports.deadline-compliance')); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e($startDate); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e($endDate); ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter"></i> Apply Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Overall Compliance Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-1"><?php echo e($compliance['total']); ?></h3>
                    <p class="text-muted small mb-0">Total Deadlines</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h3 class="text-success mb-1"><?php echo e($compliance['on_time']); ?></h3>
                    <p class="text-muted small mb-0">Met On Time</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h3 class="text-danger mb-1"><?php echo e($compliance['overdue']); ?></h3>
                    <p class="text-muted small mb-0">Overdue</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <?php
                        $complianceRate = $compliance['total'] > 0 ? round(($compliance['on_time'] / $compliance['total']) * 100, 1) : 0;
                        $ratingClass = $complianceRate >= 80 ? 'text-success' : ($complianceRate >= 60 ? 'text-warning' : 'text-danger');
                    ?>
                    <h3 class="<?php echo e($ratingClass); ?> mb-1"><?php echo e($complianceRate); ?>%</h3>
                    <p class="text-muted small mb-0">Compliance Rate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance Gauge -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-3 text-title" style="font-weight: 700;">Overall Compliance Rating</h6>
                    <div class="progress" style="height: 40px;">
                        <div class="progress-bar bg-success" style="width: <?php echo e($complianceRate); ?>%">
                            <span class="fw-bold"><?php echo e($complianceRate); ?>% On Time</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Poor (0-50%)</small>
                        <small class="text-muted">Fair (51-70%)</small>
                        <small class="text-muted">Good (71-85%)</small>
                        <small class="text-muted">Excellent (86-100%)</small>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <h1 class="<?php echo e($ratingClass); ?>" style="font-size: 4rem; font-weight: 700;">
                        <?php if($complianceRate >= 86): ?>
                            A
                        <?php elseif($complianceRate >= 71): ?>
                            B
                        <?php elseif($complianceRate >= 51): ?>
                            C
                        <?php else: ?>
                            F
                        <?php endif; ?>
                    </h1>
                    <p class="text-muted">Grade</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance by Court -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-building icon-building"></i> Compliance by Court/Agency</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Court/Agency</th>
                            <th class="text-center">Total Cases</th>
                            <th class="text-center">On Time</th>
                            <th class="text-center">Overdue</th>
                            <th class="text-center">Compliance Rate</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $compliance['by_court']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $court): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $courtRate = $court->total > 0 ? round(($court->on_time / $court->total) * 100, 1) : 0;
                            ?>
                            <tr>
                                <td class="text-bold" style="font-weight: 700;"><?php echo e($court->court_agency ?: 'Unassigned'); ?></td>
                                <td class="text-center"><strong><?php echo e($court->total); ?></strong></td>
                                <td class="text-center">
                                    <span class="badge bg-success"><?php echo e($court->on_time); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger"><?php echo e($court->overdue); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold 
                                        <?php if($courtRate >= 80): ?> text-success
                                        <?php elseif($courtRate >= 60): ?> text-warning
                                        <?php else: ?> text-danger
                                        <?php endif; ?>">
                                        <?php echo e($courtRate); ?>%
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            <?php if($courtRate >= 80): ?> bg-success
                                            <?php elseif($courtRate >= 60): ?> bg-warning
                                            <?php else: ?> bg-danger
                                            <?php endif; ?>"
                                            style="width: <?php echo e($courtRate); ?>%">
                                            <?php echo e($courtRate); ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No compliance data available.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Overdue Cases Details -->
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h6 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Overdue Cases (Immediate Attention Required)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Court/Agency</th>
                            <th>Lawyer</th>
                            <th>Deadline</th>
                            <th>Days Overdue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $overdueCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $daysOverdue = now()->diffInDays($case->deadline_date, false);
                                $daysOverdue = abs($daysOverdue);
                            ?>
                            <tr class="table-danger">
                                <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                                <td><?php echo e(Str::limit($case->case_title, 30)); ?></td>
                                <td><?php echo e($case->court_agency); ?></td>
                                <td class="text-bold" style="font-weight: 600;"><?php echo e($case->assigned_lawyer ?: 'Unassigned'); ?></td>
                                <td><?php echo e($case->deadline_date->format('M d, Y')); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php if($daysOverdue > 30): ?> bg-danger
                                        <?php elseif($daysOverdue > 14): ?> bg-warning text-dark
                                        <?php else: ?> bg-secondary
                                        <?php endif; ?>">
                                        <?php echo e($daysOverdue); ?> days
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">Overdue</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-success">
                                    <i class="bi bi-check-circle fs-3"></i>
                                    <p class="mb-0 mt-2">No overdue cases! Excellent work!</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .card-body form, .btn { display: none; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/reports/deadline-compliance.blade.php ENDPATH**/ ?>