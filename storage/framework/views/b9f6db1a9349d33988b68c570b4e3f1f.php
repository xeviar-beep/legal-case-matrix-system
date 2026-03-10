

<?php $__env->startSection('title', 'Performance Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-graph-up me-2 icon-chart"></i>Performance Report</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('reports.index')); ?>">Reports</a></li>
                <li class="breadcrumb-item active">Performance</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('reports.performance')); ?>" method="GET" class="row g-3">
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

    <!-- Overall Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary mb-1"><?php echo e($lawyerStats->count()); ?></h3>
                    <p class="text-muted small mb-0">Active Lawyers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success mb-1"><?php echo e($lawyerStats->sum('total')); ?></h3>
                    <p class="text-muted small mb-0">Total Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info mb-1"><?php echo e($lawyerStats->sum('completed')); ?></h3>
                    <p class="text-muted small mb-0">Completed Cases</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning mb-1"><?php echo e($lawyerStats->sum('overdue')); ?></h3>
                    <p class="text-muted small mb-0">Overdue Cases</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-people icon-people"></i> Lawyer Performance Statistics</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Lawyer Name</th>
                            <th class="text-center">Total Cases</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Completed</th>
                            <th class="text-center">Overdue</th>
                            <th class="text-center">Due Soon</th>
                            <th class="text-center">Completion Rate</th>
                            <th>Workload</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $maxCases = $lawyerStats->max('total') ?: 1;
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $lawyerStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $completionRate = $lawyer->total > 0 ? round(($lawyer->completed / $lawyer->total) * 100, 1) : 0;
                            ?>
                            <tr>
                                <td class="text-bold" style="font-weight: 700;"><?php echo e($lawyer->assigned_lawyer ?: 'Unassigned'); ?></td>
                                <td class="text-center"><strong><?php echo e($lawyer->total); ?></strong></td>
                                <td class="text-center">
                                    <span class="badge bg-success"><?php echo e($lawyer->active); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?php echo e($lawyer->completed); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger"><?php echo e($lawyer->overdue); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark"><?php echo e($lawyer->due_soon); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold 
                                        <?php if($completionRate >= 70): ?> text-success
                                        <?php elseif($completionRate >= 40): ?> text-warning
                                        <?php else: ?> text-danger
                                        <?php endif; ?>">
                                        <?php echo e($completionRate); ?>%
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 20px;">
                                            <div class="progress-bar 
                                                <?php if($lawyer->total / $maxCases >= 0.8): ?> bg-danger
                                                <?php elseif($lawyer->total / $maxCases >= 0.5): ?> bg-warning
                                                <?php else: ?> bg-success
                                                <?php endif; ?>"
                                                style="width: <?php echo e(($lawyer->total / $maxCases) * 100); ?>%">
                                                <?php echo e($lawyer->total); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No performance data available for the selected date range.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Performance Analysis -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-award"></i> Top Performers</h6>
                </div>
                <div class="card-body">
                    <?php
                        $topPerformers = $lawyerStats->filter(function($lawyer) {
                            return $lawyer->completed > 0;
                        })->sortByDesc('completed')->take(5);
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $topPerformers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge 
                                    <?php if($index == 0): ?> bg-warning
                                    <?php elseif($index == 1): ?> bg-secondary
                                    <?php elseif($index == 2): ?> bg-danger
                                    <?php else: ?> bg-light text-dark
                                    <?php endif; ?> me-2">
                                    #<?php echo e($index + 1); ?>

                                </span>
                                <strong class="text-bold"><?php echo e($lawyer->assigned_lawyer ?: 'Unassigned'); ?></strong>
                            </div>
                            <span class="badge bg-success"><?php echo e($lawyer->completed); ?> completed</span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">No completed cases yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Needs Attention</h6>
                </div>
                <div class="card-body">
                    <?php
                        $needsAttention = $lawyerStats->filter(function($lawyer) {
                            return $lawyer->overdue > 0;
                        })->sortByDesc('overdue')->take(5);
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $needsAttention; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="text-bold"><?php echo e($lawyer->assigned_lawyer ?: 'Unassigned'); ?></strong>
                            <div>
                                <span class="badge bg-danger me-1"><?php echo e($lawyer->overdue); ?> overdue</span>
                                <span class="badge bg-warning text-dark"><?php echo e($lawyer->due_soon); ?> due soon</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">No overdue cases!</p>
                    <?php endif; ?>
                </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/reports/performance.blade.php ENDPATH**/ ?>