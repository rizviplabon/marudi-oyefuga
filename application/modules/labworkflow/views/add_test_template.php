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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('labworkflow/testTemplates'); ?>">Test Templates</a></li>
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
                        <h5 class="card-title mb-0">
                            <i class="fa fa-file-medical"></i> Create New Test Template
                        </h5>
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

                        <form action="<?php echo base_url('labworkflow/addTestTemplate'); ?>" method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Name <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Test Code <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="test_code" class="form-control" value="<?php echo set_value('test_code'); ?>" required>
                                    <small class="text-muted">Unique identifier for this test (e.g., CBC001)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="category_id" class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?php echo $category->id; ?>" <?php echo set_select('category_id', $category->id); ?>>
                                                <?php echo $category->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Specimen Type <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="specimen_type_id" class="form-control select2" required>
                                        <option value="">Select Type</option>
                                        <?php foreach ($specimen_types as $type) : ?>
                                            <option value="<?php echo $type->id; ?>" <?php echo set_select('specimen_type_id', $type->id); ?>>
                                                <?php echo $type->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Method</label>
                                <div class="col-sm-6">
                                    <input type="text" name="methodology" class="form-control" value="<?php echo set_value('methodology'); ?>">
                                    <small class="text-muted">Testing methodology used (e.g., ELISA, PCR)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Units</label>
                                <div class="col-sm-6">
                                    <input type="text" name="units" class="form-control" value="<?php echo set_value('units'); ?>">
                                    <small class="text-muted">e.g., mg/dL, mmol/L, etc.</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Normal Range</label>
                                <div class="col-sm-6">
                                    <input type="text" name="normal_range" class="form-control" value="<?php echo set_value('normal_range'); ?>">
                                    <small class="text-muted">e.g., 70-100 mg/dL</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cost <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="cost" class="form-control" value="<?php echo set_value('cost', '0.00'); ?>" step="0.01" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Turnaround Time</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="number" name="turnaround_time" class="form-control" value="<?php echo set_value('turnaround_time', '24'); ?>" min="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">hours</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Expected time to complete the test</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Instructions</label>
                                <div class="col-sm-6">
                                    <textarea name="preparation_instructions" class="form-control" rows="3"><?php echo set_value('preparation_instructions'); ?></textarea>
                                    <small class="text-muted">Special instructions for specimen collection or handling</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Result Template</label>
                                <div class="col-sm-6">
                                    <textarea name="result_template" class="form-control" rows="3"><?php echo set_value('result_template'); ?></textarea>
                                    <small class="text-muted">Template for structuring test results (optional)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-6">
                                    <select name="is_active" class="form-control">
                                        <option value="1" <?php echo set_select('is_active', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('is_active', '0'); ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Create Template</button>
                                    <a href="<?php echo base_url('labworkflow/testTemplates'); ?>" class="btn btn-light ml-2">Cancel</a>
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
    $('.select2').select2();

    // Auto-generate test code when name changes
    $('input[name="name"]').on('change', function() {
        if ($('input[name="test_code"]').val() === '') {
            var testName = $(this).val().toUpperCase();
            var code = testName.replace(/[^A-Z0-9]/g, '').substring(0, 3) + 
                      Math.floor(Math.random() * 900 + 100);
            $('input[name="test_code"]').val(code);
        }
    });
});
</script> 