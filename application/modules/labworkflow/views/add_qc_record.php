<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header"> 
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo $page_title; ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('labworkflow/qualityControl'); ?>">Quality Control</a></li>
                            <li class="breadcrumb-item active"><?php echo $page; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add Quality Control Record</h5>
                    </div>
                    <div class="card-body">
                        <?php if (validation_errors()) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo validation_errors(); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo base_url('labworkflow/addQCRecord'); ?>" method="post" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Template <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="test_template_id" class="form-control" required>
                                        <option value="">Select Test Template</option>
                                        <?php foreach ($test_templates as $template) : ?>
                                            <option value="<?php echo $template->id; ?>" <?php echo set_select('test_template_id', $template->id); ?>>
                                                <?php echo $template->name; ?> (<?php echo $template->test_code; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Control Type <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="control_type" class="form-control" required>
                                        <option value="">Select Control Type</option>
                                        <option value="normal" <?php echo set_select('control_type', 'normal'); ?>>Normal Control</option>
                                        <option value="high" <?php echo set_select('control_type', 'high'); ?>>High Control</option>
                                        <option value="low" <?php echo set_select('control_type', 'low'); ?>>Low Control</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Control Date <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="date" name="control_date" class="form-control" value="<?php echo set_value('control_date', date('Y-m-d')); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Control Lot</label>
                                <div class="col-sm-6">
                                    <input type="text" name="control_lot" class="form-control" value="<?php echo set_value('control_lot'); ?>">
                                    <small class="text-muted">Lot number of the control material</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Expected Value <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="expected_value" class="form-control" value="<?php echo set_value('expected_value'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Actual Value <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="actual_value" class="form-control" value="<?php echo set_value('actual_value'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Acceptable Range</label>
                                <div class="col-sm-6">
                                    <input type="text" name="acceptable_range" class="form-control" value="<?php echo set_value('acceptable_range'); ?>">
                                    <small class="text-muted">Format: min-max (e.g., 7.2-7.8)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="pass" <?php echo set_select('status', 'pass'); ?>>Pass</option>
                                        <option value="fail" <?php echo set_select('status', 'fail'); ?>>Fail</option>
                                        <option value="warning" <?php echo set_select('status', 'warning'); ?>>Warning</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Notes</label>
                                <div class="col-sm-6">
                                    <textarea name="notes" class="form-control" rows="3"><?php echo set_value('notes'); ?></textarea>
                                    <small class="text-muted">Any additional observations or comments</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Corrective Action</label>
                                <div class="col-sm-6">
                                    <textarea name="corrective_action" class="form-control" rows="3"><?php echo set_value('corrective_action'); ?></textarea>
                                    <small class="text-muted">Required if status is Fail or Warning</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Save Record</button>
                                    <a href="<?php echo base_url('labworkflow/qualityControl'); ?>" class="btn btn-light ml-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2 for better dropdown experience
    $('select').select2();

    // Show/hide corrective action based on status
    $('select[name="status"]').change(function() {
        var status = $(this).val();
        if (status == 'fail' || status == 'warning') {
            $('textarea[name="corrective_action"]').prop('required', true);
            $('textarea[name="corrective_action"]').closest('.form-group').find('small').addClass('text-danger');
        } else {
            $('textarea[name="corrective_action"]').prop('required', false);
            $('textarea[name="corrective_action"]').closest('.form-group').find('small').removeClass('text-danger');
        }
    });
});
</script> 