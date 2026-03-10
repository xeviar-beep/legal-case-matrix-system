

<?php $__env->startSection('title', 'Create Case'); ?>
<?php $__env->startSection('page-title', 'Create New Case'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?php echo e(route('cases.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row g-3">
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
                                   id="case_number" name="case_number" value="<?php echo e(old('case_number')); ?>">
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
                                   id="docket_no" name="docket_no" value="<?php echo e(old('docket_no')); ?>" 
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
                                   id="case_title" name="case_title" value="<?php echo e(old('case_title')); ?>">
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
                                   id="client_name" name="client_name" value="<?php echo e(old('client_name')); ?>">
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
                                   id="assigned_lawyer" name="assigned_lawyer" value="<?php echo e(old('assigned_lawyer')); ?>" 
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
                                <option value="Criminal" <?php echo e(old('section') == 'Criminal' ? 'selected' : ''); ?>>Criminal</option>
                                <option value="Civil" <?php echo e(old('section') == 'Civil' ? 'selected' : ''); ?>>Civil</option>
                                <option value="Labor" <?php echo e(old('section') == 'Labor' ? 'selected' : ''); ?>>Labor</option>
                                <option value="Administrative" <?php echo e(old('section') == 'Administrative' ? 'selected' : ''); ?>>Administrative</option>
                                <option value="Special/IP" <?php echo e(old('section') == 'Special/IP' ? 'selected' : ''); ?>>Special/IP</option>
                                <option value="OJ" <?php echo e(old('section') == 'OJ' ? 'selected' : ''); ?>>OJ (Office of Justice)</option>
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
                                   id="case_type" name="case_type" value="<?php echo e(old('case_type')); ?>" 
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
                                    id="court_agency" name="court_agency">
                                <option value="">Select Court/Agency</option>
                                <option value="SC" <?php echo e(old('court_agency') == 'SC' ? 'selected' : ''); ?>>Supreme Court (SC)</option>
                                <option value="CA" <?php echo e(old('court_agency') == 'CA' ? 'selected' : ''); ?>>Court of Appeals (CA)</option>
                                <option value="RTC" <?php echo e(old('court_agency') == 'RTC' ? 'selected' : ''); ?>>Regional Trial Court (RTC)</option>
                                <option value="OMB" <?php echo e(old('court_agency') == 'OMB' ? 'selected' : ''); ?>>Office of the Ombudsman (OMB)</option>
                                <option value="NCIP" <?php echo e(old('court_agency') == 'NCIP' ? 'selected' : ''); ?>>NCIP</option>
                                <option value="Special/IP" <?php echo e(old('court_agency') == 'Special/IP' ? 'selected' : ''); ?>>Special/IP</option>
                                <option value="Other" <?php echo e(old('court_agency') == 'Other' ? 'selected' : ''); ?>>Other</option>
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
                                <option value="NCR" <?php echo e(old('region') == 'NCR' ? 'selected' : ''); ?>>NCR</option>
                                <option value="Region I" <?php echo e(old('region') == 'Region I' ? 'selected' : ''); ?>>Region I</option>
                                <option value="Region II" <?php echo e(old('region') == 'Region II' ? 'selected' : ''); ?>>Region II</option>
                                <option value="Region III" <?php echo e(old('region') == 'Region III' ? 'selected' : ''); ?>>Region III</option>
                                <option value="Region IV-A" <?php echo e(old('region') == 'Region IV-A' ? 'selected' : ''); ?>>Region IV-A (CALABARZON)</option>
                                <option value="Region IV-B" <?php echo e(old('region') == 'Region IV-B' ? 'selected' : ''); ?>>Region IV-B (MIMAROPA)</option>
                                <option value="Region V" <?php echo e(old('region') == 'Region V' ? 'selected' : ''); ?>>Region V</option>
                                <option value="Region VI" <?php echo e(old('region') == 'Region VI' ? 'selected' : ''); ?>>Region VI</option>
                                <option value="Region VII" <?php echo e(old('region') == 'Region VII' ? 'selected' : ''); ?>>Region VII</option>
                                <option value="Region VIII" <?php echo e(old('region') == 'Region VIII' ? 'selected' : ''); ?>>Region VIII</option>
                                <option value="Region IX" <?php echo e(old('region') == 'Region IX' ? 'selected' : ''); ?>>Region IX</option>
                                <option value="Region X" <?php echo e(old('region') == 'Region X' ? 'selected' : ''); ?>>Region X</option>
                                <option value="Region XI" <?php echo e(old('region') == 'Region XI' ? 'selected' : ''); ?>>Region XI</option>
                                <option value="Region XII" <?php echo e(old('region') == 'Region XII' ? 'selected' : ''); ?>>Region XII</option>
                                <option value="Region XIII" <?php echo e(old('region') == 'Region XIII' ? 'selected' : ''); ?>>Region XIII</option>
                                <option value="BARMM" <?php echo e(old('region') == 'BARMM' ? 'selected' : ''); ?>>BARMM</option>
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
                        <div class="col-md-4">
                            <label for="date_filed" class="form-label">Date Filed</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['date_filed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="date_filed" name="date_filed" value="<?php echo e(old('date_filed', date('Y-m-d'))); ?>">
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
                        <div class="col-md-4">
                            <label for="deadline_days" class="form-label">Deadline Period (days)</label>
                            <select class="form-select <?php $__errorArgs = ['deadline_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="deadline_days" name="deadline_days">
                                <option value="">Select Deadline</option>
                                <option value="15" <?php echo e(old('deadline_days') == 15 ? 'selected' : ''); ?>>15 days</option>
                                <option value="30" <?php echo e(old('deadline_days') == 30 ? 'selected' : ''); ?>>30 days</option>
                                <option value="60" <?php echo e(old('deadline_days') == 60 ? 'selected' : ''); ?>>60 days</option>
                                <option value="90" <?php echo e(old('deadline_days') == 90 ? 'selected' : ''); ?>>90 days</option>
                            </select>
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
                            <small class="text-muted">System will auto-calculate the deadline date</small>
                        </div>

                        <!-- Hearing Date -->
                        <div class="col-md-4">
                            <label for="hearing_date" class="form-label">Hearing Date (Optional)</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['hearing_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hearing_date" name="hearing_date" value="<?php echo e(old('hearing_date')); ?>">
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
                                      id="notes" name="notes" rows="3"><?php echo e(old('notes')); ?></textarea>
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

                        <!-- Submit Buttons -->
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Case
                            </button>
                            <a href="<?php echo e(route('cases.index')); ?>" class="btn btn-outline-secondary">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\LAO Case Matrix System\CASE MATRIX SYSTEM\resources\views/cases/create.blade.php ENDPATH**/ ?>