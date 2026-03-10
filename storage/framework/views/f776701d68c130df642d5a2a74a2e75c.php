

<?php $__env->startSection('title', 'Case Summary Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-text me-2 icon-chart"></i>Case Summary Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('reports.index')); ?>">Reports</a></li>
                <li class="breadcrumb-item active">Case Summary</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('reports.case-summary')); ?>" method="GET" class="row g-3">
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

    <!-- Summary Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-1"><?php echo e($summary['total']); ?></h3>
                    <p class="text-muted small mb-0">Total Cases Filed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success mb-1"><?php echo e($summary['by_section']->count()); ?></h3>
                    <p class="text-muted small mb-0">Sections Involved</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning mb-1"><?php echo e($summary['by_court']->count()); ?></h3>
                    <p class="text-muted small mb-0">Courts/Agencies</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info mb-1"><?php echo e($summary['by_region']->count()); ?></h3>
                    <p class="text-muted small mb-0">Regions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Charts -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-folder icon-folder"></i> By Section</h6>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $summary['by_section']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;"><?php echo e($section ?: 'Unassigned'); ?></span>
                                <strong><?php echo e($count); ?></strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: <?php echo e($summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">No data</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-building icon-building"></i> By Court/Agency</h6>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $summary['by_court']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $court => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;"><?php echo e($court ?: 'Unassigned'); ?></span>
                                <strong><?php echo e($count); ?></strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: <?php echo e($summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">No data</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-kanban"></i> By Status</h6>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $summary['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-bold" style="font-weight: 600;"><?php echo e(ucfirst($status)); ?></span>
                                <strong><?php echo e($count); ?></strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar 
                                    <?php if($status == 'overdue'): ?> bg-danger
                                    <?php elseif($status == 'due_soon'): ?> bg-warning
                                    <?php elseif($status == 'completed'): ?> bg-secondary
                                    <?php else: ?> bg-success
                                    <?php endif; ?>" 
                                    style="width: <?php echo e($summary['total'] > 0 ? ($count / $summary['total'] * 100) : 0); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">No data</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Cases Table -->
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-table"></i> Detailed Case List</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case No.</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Section</th>
                            <th>Court/Agency</th>
                            <th>Region</th>
                            <th>Date Filed</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                                <td><?php echo e(Str::limit($case->case_title, 30)); ?></td>
                                <td><?php echo e($case->client_name); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($case->section ?: '-'); ?></span></td>
                                <td><span class="badge bg-info"><?php echo e($case->court_agency ?: '-'); ?></span></td>
                                <td><span class="badge bg-secondary"><?php echo e($case->region ?: '-'); ?></span></td>
                                <td><?php echo e($case->date_filed->format('M d, Y')); ?></td>
                                <td><?php echo e($case->deadline_date->format('M d, Y')); ?></td>
                                <td>
                                    <?php if($case->status === 'overdue'): ?>
                                        <span class="badge bg-danger">Overdue</span>
                                    <?php elseif($case->status === 'due_soon'): ?>
                                        <span class="badge bg-warning text-dark">Due Soon</span>
                                    <?php elseif($case->status === 'completed'): ?>
                                        <span class="badge bg-secondary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No cases found for the selected date range.
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/reports/case-summary.blade.php ENDPATH**/ ?>