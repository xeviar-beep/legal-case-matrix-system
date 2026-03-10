

<?php $__env->startSection('title', 'Deadlines Calendar'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-calendar-check me-2 icon-calendar"></i>Deadlines Calendar</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Deadlines</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    <h3 class="mt-2 mb-1 text-danger"><?php echo e($stats['overdue']); ?></h3>
                    <p class="text-muted small mb-0">Overdue</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="bi bi-clock-fill text-warning fs-2"></i>
                    <h3 class="mt-2 mb-1 text-warning"><?php echo e($stats['today']); ?></h3>
                    <p class="text-muted small mb-0">Due Today</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="bi bi-calendar-date text-info fs-2"></i>
                    <h3 class="mt-2 mb-1 text-info"><?php echo e($stats['tomorrow']); ?></h3>
                    <p class="text-muted small mb-0">Due Tomorrow</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="bi bi-calendar-week icon-calendar fs-2"></i>
                    <h3 class="mt-2 mb-1 text-primary"><?php echo e($stats['this_week']); ?></h3>
                    <p class="text-muted small mb-0">This Week</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-secondary">
                <div class="card-body">
                    <i class="bi bi-calendar-range text-secondary fs-2"></i>
                    <h3 class="mt-2 mb-1 text-secondary"><?php echo e($stats['next_week']); ?></h3>
                    <p class="text-muted small mb-0">Next Week</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="bi bi-calendar-month text-success fs-2"></i>
                    <h3 class="mt-2 mb-1 text-success"><?php echo e($stats['this_month']); ?></h3>
                    <p class="text-muted small mb-0">This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Cases -->
    <?php if($overdueCases->count() > 0): ?>
    <div class="card border-danger mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Overdue Cases (<?php echo e($overdueCases->count()); ?>)</h5>
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
                            <th>Assigned Lawyer</th>
                            <th>Deadline</th>
                            <th>Days Overdue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $overdueCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-danger">
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 30)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td><?php echo e($case->assigned_lawyer ?? 'Unassigned'); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($case->deadline_date)->format('M d, Y')); ?></td>
                            <td><span class="badge bg-danger"><?php echo e(abs($case->remaining_days)); ?> days</span></td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Due Today -->
    <?php if($dueTodayCases->count() > 0): ?>
    <div class="card border-warning mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0"><i class="bi bi-clock-fill me-2"></i>Due Today (<?php echo e($dueTodayCases->count()); ?>)</h5>
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
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dueTodayCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-warning">
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 40)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td><?php echo e($case->assigned_lawyer ?? 'Unassigned'); ?></td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Due Tomorrow -->
    <?php if($dueTomorrowCases->count() > 0): ?>
    <div class="card border-info mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-date me-2"></i>Due Tomorrow (<?php echo e($dueTomorrowCases->count()); ?>)</h5>
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
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dueTomorrowCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 40)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td><?php echo e($case->assigned_lawyer ?? 'Unassigned'); ?></td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- This Week -->
    <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Due This Week (<?php echo e($dueThisWeekCases->count()); ?>)</h5>
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
                            <th>Deadline</th>
                            <th>Days Left</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dueThisWeekCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 30)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td><?php echo e(\Carbon\Carbon::parse($case->deadline_date)->format('M d, Y')); ?></td>
                            <td><span class="badge bg-primary"><?php echo e($case->remaining_days); ?> days</span></td>
                            <td><?php echo e($case->assigned_lawyer ?? 'Unassigned'); ?></td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-check fs-1 d-block mb-2"></i>
                                No cases due this week
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Next Week -->
    <?php if($dueNextWeekCases->count() > 0): ?>
    <div class="card border-secondary mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>Due Next Week (<?php echo e($dueNextWeekCases->count()); ?>)</h5>
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
                            <th>Deadline</th>
                            <th>Assigned Lawyer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dueNextWeekCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 35)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td><?php echo e(\Carbon\Carbon::parse($case->deadline_date)->format('M d, Y')); ?></td>
                            <td><?php echo e($case->assigned_lawyer ?? 'Unassigned'); ?></td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- All Deadlines This Month -->
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-month me-2"></i>All Deadlines This Month</h5>
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
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dueThisMonthCases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-bold"><?php echo e($case->case_number); ?></td>
                            <td><?php echo e(Str::limit($case->case_title, 30)); ?></td>
                            <td><?php echo e($case->client_name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($case->section); ?></span></td>
                            <td>
                                <?php if($case->court_agency): ?>
                                    <span class="badge bg-info"><?php echo e($case->court_agency); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($case->deadline_date)->format('M d, Y')); ?></td>
                            <td>
                                <?php if($case->status === 'overdue'): ?>
                                    <span class="badge bg-danger">Overdue</span>
                                <?php elseif($case->status === 'due_soon'): ?>
                                    <span class="badge bg-warning text-dark">Due Soon</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Active</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                No deadlines this month
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($dueThisMonthCases->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($dueThisMonthCases->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/deadlines/index.blade.php ENDPATH**/ ?>