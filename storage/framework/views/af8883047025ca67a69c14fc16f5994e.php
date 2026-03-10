

<?php $__env->startSection('title', 'Edit Case'); ?>
<?php $__env->startSection('page-title', 'Edit Case: ' . $case->case_number); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?php echo e(route('cases.update', $case)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <!-- Court/Agency -->
                        <div class="col-md-6">
                            <label for="court_agency" class="form-label">Court/Agency</label>
                            <select class="form-select <?php $__errorArgs = ['court_agency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="court_agency" name="court_agency" onchange="toggleEditFormFields()">
                                <option value="">Select Court/Agency</option>
                                <option value="SC" <?php echo e(old('court_agency', $case->court_agency) == 'SC' ? 'selected' : ''); ?>>Supreme Court (SC)</option>
                                <option value="CA" <?php echo e(old('court_agency', $case->court_agency) == 'CA' ? 'selected' : ''); ?>>Court of Appeals (CA)</option>
                                <option value="RTC" <?php echo e(old('court_agency', $case->court_agency) == 'RTC' ? 'selected' : ''); ?>>Regional Trial Court (RTC)</option>
                                <option value="MTC" <?php echo e(old('court_agency', $case->court_agency) == 'MTC' ? 'selected' : ''); ?>>Municipal Trial Court (MTC)</option>
                                <option value="OMB" <?php echo e(old('court_agency', $case->court_agency) == 'OMB' ? 'selected' : ''); ?>>Office of the Ombudsman (OMB)</option>
                                <option value="ADMIN" <?php echo e(old('court_agency', $case->court_agency) == 'ADMIN' ? 'selected' : ''); ?>>Administrative</option>
                                <option value="NCIP" <?php echo e(old('court_agency', $case->court_agency) == 'NCIP' ? 'selected' : ''); ?>>NCIP</option>
                                <option value="REGIONS" <?php echo e(old('court_agency', $case->court_agency) == 'REGIONS' ? 'selected' : ''); ?>>Regions</option>
                                <option value="OJ" <?php echo e(old('court_agency', $case->court_agency) == 'OJ' ? 'selected' : ''); ?>>Office of Justice (OJ)</option>
                                <option value="Others" <?php echo e(old('court_agency', $case->court_agency) == 'Others' ? 'selected' : ''); ?>>Others</option>
                            </select>
                            <?php $__errorArgs = ['court_agency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Case Number -->
                        <div class="col-md-6">
                            <label for="case_number" class="form-label">Case Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['case_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="case_number" name="case_number" value="<?php echo e(old('case_number', $case->case_number)); ?>">
                            <?php $__errorArgs = ['case_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Docket Number -->
                        <div class="col-md-6">
                            <label for="docket_no" class="form-label">Docket Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['docket_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="docket_no" name="docket_no" value="<?php echo e(old('docket_no', $case->docket_no)); ?>" 
                                   placeholder="e.g., G.R. No. 123456">
                            <?php $__errorArgs = ['docket_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Old Folder No. -->
                        <div class="col-md-6">
                            <label for="old_folder_no" class="form-label">Old Folder No.</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['old_folder_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="old_folder_no" name="old_folder_no" value="<?php echo e(old('old_folder_no', $case->old_folder_no)); ?>" 
                                   placeholder="Enter old folder number">
                            <?php $__errorArgs = ['old_folder_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Case Title -->
                        <div class="col-md-12">
                            <label for="case_title" class="form-label">Case Title</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['case_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="case_title" name="case_title" value="<?php echo e(old('case_title', $case->case_title)); ?>">
                            <?php $__errorArgs = ['case_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Client Name -->
                        <div class="col-md-6">
                            <label for="client_name" class="form-label">Client Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="client_name" name="client_name" value="<?php echo e(old('client_name', $case->client_name)); ?>">
                            <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Assigned Lawyer -->
                        <div class="col-md-6">
                            <label for="assigned_lawyer" class="form-label">Assigned Lawyer</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['assigned_lawyer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="assigned_lawyer" name="assigned_lawyer" value="<?php echo e(old('assigned_lawyer', $case->assigned_lawyer)); ?>" 
                                   placeholder="Enter lawyer name">
                            <?php $__errorArgs = ['assigned_lawyer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Section -->
                        <div class="col-md-6">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="section" name="section">
                                <option value="">Select Section</option>
                                <option value="Criminal" <?php echo e(old('section', $case->section) == 'Criminal' ? 'selected' : ''); ?>>Criminal</option>
                                <option value="Civil" <?php echo e(old('section', $case->section) == 'Civil' ? 'selected' : ''); ?>>Civil</option>
                                <option value="Labor" <?php echo e(old('section', $case->section) == 'Labor' ? 'selected' : ''); ?>>Labor</option>
                                <option value="Administrative" <?php echo e(old('section', $case->section) == 'Administrative' ? 'selected' : ''); ?>>Administrative</option>
                                <option value="Special/IP" <?php echo e(old('section', $case->section) == 'Special/IP' ? 'selected' : ''); ?>>Special/IP</option>
                                <option value="OJ" <?php echo e(old('section', $case->section) == 'OJ' ? 'selected' : ''); ?>>OJ (Office of Justice)</option>
                            </select>
                            <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Case Type -->
                        <div class="col-md-6">
                            <label for="case_type" class="form-label">Case Type</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['case_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="case_type" name="case_type" value="<?php echo e(old('case_type', $case->case_type)); ?>" 
                                   placeholder="e.g., Homicide, Breach of Contract">
                            <?php $__errorArgs = ['case_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Handling Counsel for NCIP -->
                        <div class="col-md-6">
                            <label for="handling_counsel_ncip" class="form-label">Handling Counsel for NCIP</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['handling_counsel_ncip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="handling_counsel_ncip" name="handling_counsel_ncip" value="<?php echo e(old('handling_counsel_ncip', $case->handling_counsel_ncip)); ?>" 
                                   placeholder="Enter handling counsel name">
                            <?php $__errorArgs = ['handling_counsel_ncip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Region -->
                        <div class="col-md-6">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select <?php $__errorArgs = ['region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="region" name="region">
                                <option value="">Select Region</option>
                                <option value="NCR" <?php echo e(old('region', $case->region) == 'NCR' ? 'selected' : ''); ?>>NCR</option>
                                <option value="Region I" <?php echo e(old('region', $case->region) == 'Region I' ? 'selected' : ''); ?>>Region I</option>
                                <option value="Region II" <?php echo e(old('region', $case->region) == 'Region II' ? 'selected' : ''); ?>>Region II</option>
                                <option value="Region III" <?php echo e(old('region', $case->region) == 'Region III' ? 'selected' : ''); ?>>Region III</option>
                                <option value="Region IV-A" <?php echo e(old('region', $case->region) == 'Region IV-A' ? 'selected' : ''); ?>>Region IV-A (CALABARZON)</option>
                                <option value="Region IV-B" <?php echo e(old('region', $case->region) == 'Region IV-B' ? 'selected' : ''); ?>>Region IV-B (MIMAROPA)</option>
                                <option value="Region V" <?php echo e(old('region', $case->region) == 'Region V' ? 'selected' : ''); ?>>Region V</option>
                                <option value="Region VI" <?php echo e(old('region', $case->region) == 'Region VI' ? 'selected' : ''); ?>>Region VI</option>
                                <option value="Region VII" <?php echo e(old('region', $case->region) == 'Region VII' ? 'selected' : ''); ?>>Region VII</option>
                                <option value="Region VIII" <?php echo e(old('region', $case->region) == 'Region VIII' ? 'selected' : ''); ?>>Region VIII</option>
                                <option value="Region IX" <?php echo e(old('region', $case->region) == 'Region IX' ? 'selected' : ''); ?>>Region IX</option>
                                <option value="Region X" <?php echo e(old('region', $case->region) == 'Region X' ? 'selected' : ''); ?>>Region X</option>
                                <option value="Region XI" <?php echo e(old('region', $case->region) == 'Region XI' ? 'selected' : ''); ?>>Region XI</option>
                                <option value="Region XII" <?php echo e(old('region', $case->region) == 'Region XII' ? 'selected' : ''); ?>>Region XII</option>
                                <option value="Region XIII" <?php echo e(old('region', $case->region) == 'Region XIII' ? 'selected' : ''); ?>>Region XIII</option>
                                <option value="BARMM" <?php echo e(old('region', $case->region) == 'BARMM' ? 'selected' : ''); ?>>BARMM</option>
                            </select>
                            <?php $__errorArgs = ['region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Date Filed -->
                        <div class="col-md-3">
                            <label for="date_filed" class="form-label">Date Filed</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['date_filed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="date_filed" name="date_filed" value="<?php echo e(old('date_filed', $case->date_filed?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['date_filed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Deadline Days -->
                        <div class="col-md-3">
                            <label for="deadline_days" class="form-label">Deadline Period (Days)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['deadline_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="deadline_days" name="deadline_days" value="<?php echo e(old('deadline_days', $case->deadline_days)); ?>" placeholder="Enter days">
                            <?php $__errorArgs = ['deadline_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Hearing Date -->
                        <div class="col-md-3">
                            <label for="hearing_date" class="form-label">Hearing Date</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['hearing_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hearing_date" name="hearing_date" value="<?php echo e(old('hearing_date', $case->hearing_date?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['hearing_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status">
                                <option value="active" <?php echo e(old('status', $case->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="due_soon" <?php echo e(old('status', $case->status) == 'due_soon' ? 'selected' : ''); ?>>Due Soon</option>
                                <option value="overdue" <?php echo e(old('status', $case->status) == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                                <option value="completed" <?php echo e(old('status', $case->status) == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="archived" <?php echo e(old('status', $case->status) == 'archived' ? 'selected' : ''); ?>>Archived</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Actions Taken/Documents Filed -->
                        <div class="col-md-12">
                            <label for="actions_taken" class="form-label">Actions Taken/Documents Filed</label>
                            <textarea class="form-control <?php $__errorArgs = ['actions_taken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="actions_taken" name="actions_taken" rows="3" placeholder="Enter actions taken or documents filed"><?php echo e(old('actions_taken', $case->actions_taken)); ?></textarea>
                            <?php $__errorArgs = ['actions_taken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="notes" name="notes" rows="3"><?php echo e(old('notes', $case->notes)); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- SC-Specific Fields -->
                        <div id="sc-edit-fields" style="display: none;">
                            <div class="row g-3">
                                <div class="col-12">
                                    <hr class="my-3">
                                    <h6 class="text-primary">Supreme Court Specific Information</h6>
                                </div>

                                <div class="col-md-6">
                                    <label for="new_sc_no" class="form-label">New SC No.</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['new_sc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="new_sc_no" name="new_sc_no" value="<?php echo e(old('new_sc_no', $case->new_sc_no)); ?>" 
                                           placeholder="Enter new SC number">
                                    <?php $__errorArgs = ['new_sc_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="remarks" name="remarks" value="<?php echo e(old('remarks', $case->remarks)); ?>" 
                                           placeholder="Enter remarks">
                                    <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="action" class="form-label">Action</label>
                                    <textarea class="form-control <?php $__errorArgs = ['action'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="action" name="action" rows="3" placeholder="Describe the action..."><?php echo e(old('action', $case->action)); ?></textarea>
                                    <?php $__errorArgs = ['action'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="issues_grounds" class="form-label">Issues/Grounds for Allowance of the Petition</label>
                                    <textarea class="form-control <?php $__errorArgs = ['issues_grounds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="issues_grounds" name="issues_grounds" rows="4" placeholder="Enter issues and grounds..."><?php echo e(old('issues_grounds', $case->issues_grounds)); ?></textarea>
                                    <?php $__errorArgs = ['issues_grounds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="prayers_relief" class="form-label">Prayers (Relief)</label>
                                    <textarea class="form-control <?php $__errorArgs = ['prayers_relief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="prayers_relief" name="prayers_relief" rows="3" placeholder="Enter prayers and relief sought..."><?php echo e(old('prayers_relief', $case->prayers_relief)); ?></textarea>
                                    <?php $__errorArgs = ['prayers_relief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="optional_blank_section" class="form-label">Optional / Additional Notes</label>
                                    <textarea class="form-control <?php $__errorArgs = ['optional_blank_section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="optional_blank_section" name="optional_blank_section" rows="2" placeholder="Any additional information..."><?php echo e(old('optional_blank_section', $case->optional_blank_section)); ?></textarea>
                                    <?php $__errorArgs = ['optional_blank_section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Case
                            </button>
                            <a href="<?php echo e(route('cases.show', $case)); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    function toggleEditFormFields() {
        const courtAgency = document.getElementById('court_agency').value;
        const scFields = document.getElementById('sc-edit-fields');
        
        // Helper function to disable/enable all inputs in a section
        function toggleInputs(section, enable) {
            const inputs = section.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = !enable;
            });
        }
        
        if (courtAgency === 'SC') {
            scFields.style.display = 'block';
            toggleInputs(scFields, true);  // Enable SC-specific fields
        } else {
            scFields.style.display = 'none';
            toggleInputs(scFields, false);  // Disable SC-specific fields
        }
    }

    // Run on page load to show appropriate fields
    document.addEventListener('DOMContentLoaded', function() {
        toggleEditFormFields();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/cases/edit.blade.php ENDPATH**/ ?>