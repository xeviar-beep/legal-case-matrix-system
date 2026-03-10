<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cases Export</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #36454F;
        }
        
        .header h1 {
            font-size: 18px;
            color: #36454F;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .export-info {
            text-align: right;
            margin-bottom: 15px;
            font-size: 8px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        thead {
            background-color: #36454F;
            color: white;
        }
        
        th {
            padding: 8px 4px;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            font-size: 8px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 7px;
            display: inline-block;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-active {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-closed {
            background-color: #E5E7EB;
            color: #1F2937;
        }
        
        .priority-overdue {
            color: #DC2626;
            font-weight: bold;
        }
        
        .priority-urgent {
            color: #F59E0B;
            font-weight: bold;
        }
        
        .priority-high {
            color: #3B82F6;
            font-weight: bold;
        }
        
        .priority-normal {
            color: #10B981;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CASE MATRIX SYSTEM</h1>
        <p>Legal Case Deadline & Reminder System - Cases Report</p>
    </div>
    
    <div class="export-info">
        <strong>Export Date:</strong> <?php echo e(now()->format('F d, Y h:i A')); ?><br>
        <strong>Total Cases:</strong> <?php echo e($cases->count()); ?>

    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 7%;">Case No.</th>
                <th style="width: 22%;">Case Title</th>
                <th style="width: 11%;">Client</th>
                <th style="width: 7%;">Section</th>
                <th style="width: 7%;">Court</th>
                <th style="width: 7%;">Filed</th>
                <th style="width: 7%;">Deadline</th>
                <th style="width: 7%;">Days Left</th>
                <th style="width: 7%;">Status</th>
                <th style="width: 7%;">Priority</th>
                <th style="width: 11%;">Lawyer</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($case->case_number); ?></td>
                <td><?php echo e(Str::limit($case->case_title, 60)); ?></td>
                <td><?php echo e(Str::limit($case->client_name, 30)); ?></td>
                <td><?php echo e($case->section); ?></td>
                <td><?php echo e($case->court_agency ?? 'N/A'); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($case->date_filed)->format('Y-m-d')); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($case->deadline_date)->format('Y-m-d')); ?></td>
                <td style="text-align: center;">
                    <span class="priority-<?php echo e(strtolower($case->priority)); ?>">
                        <?php echo e($case->days_remaining); ?> days
                    </span>
                </td>
                <td>
                    <span class="status-badge status-<?php echo e(strtolower($case->status)); ?>">
                        <?php echo e(ucfirst($case->status)); ?>

                    </span>
                </td>
                <td>
                    <span class="priority-<?php echo e(strtolower($case->priority)); ?>">
                        <?php echo e($case->priority); ?>

                    </span>
                </td>
                <td><?php echo e($case->assigned_lawyer ?? 'N/A'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>This is a computer-generated report from the Case Matrix System.</p>
        <p>&copy; <?php echo e(now()->year); ?> Legal Aid Office - All Rights Reserved</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/cases/export-pdf.blade.php ENDPATH**/ ?>