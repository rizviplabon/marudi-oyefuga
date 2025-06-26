<!--sidebar end-->
<!--main content start-->
<div class="wrapper">
<div class="main-content">
<div class="page-content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo $page_title; ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
                    &nbsp;&nbsp;
                    <?php if($this->ion_auth->in_group('admin')){                
                    if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                    <?php }} ?>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo lang('home'); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('labworkflow/labTests'); ?>">Lab Workflow</a></li>
                            <li class="breadcrumb-item active"><?php echo $page; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->
        <div class="row">
            <section class="col-md-8">
                <div class="card">
                    <div class="card-header table_header">
                        <h4 class="card-title mb-0 col-lg-12">
                            <i class="fa fa-flask"></i> Order New Lab Test
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="adv-table editable-table">
                            <div class="clearfix">
                                <?php if (validation_errors()) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo validation_errors(); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <form role="form" action="<?php echo base_url('labworkflow/addLabTest'); ?>" method="post" class="clearfix row" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">
                                        <label for="patient_id">Patient <span class="text-danger">*</span></label>
                                        <select name="patient_id" class="form-control m-bot15 js-example-basic-single" required>
                                            <option value="">Select Patient</option>
                                            <?php foreach ($patients as $patient) : ?>
                                                <option value="<?php echo $patient->id; ?>" <?php echo set_select('patient_id', $patient->id); ?>>
                                                    <?php echo $patient->name; ?> (ID: <?php echo $patient->patient_id; ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="template_id">Test Template <span class="text-danger">*</span></label>
                                        <select name="template_id" class="form-control m-bot15 js-example-basic-single" required>
                                            <option value="">Select Test</option>
                                            <?php foreach ($templates as $template) : ?>
                                                <option value="<?php echo $template->id; ?>" <?php echo set_select('template_id', $template->id); ?>>
                                                    <?php echo $template->name; ?> (<?php echo $template->test_code; ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="specimen_id">Specimen</label>
                                        <select name="specimen_id" class="form-control m-bot15 js-example-basic-single">
                                            <option value="">Select Specimen (Optional)</option>
                                            <?php foreach ($specimens as $specimen) : ?>
                                                <option value="<?php echo $specimen->id; ?>" <?php echo set_select('specimen_id', $specimen->id, ($this->input->get('specimen_id') == $specimen->id)); ?>>
                                                    <?php echo $specimen->specimen_id; ?> - <?php echo $specimen->specimen_type_name; ?>
                                                    (<?php echo date('d/m/Y', strtotime($specimen->collection_date)); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Leave empty to collect specimen later</small>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="doctor_id">Doctor</label>
                                        <select name="doctor_id" class="form-control m-bot15 js-example-basic-single">
                                            <option value="">Select Doctor (Optional)</option>
                                            <?php foreach ($doctors as $doctor) : ?>
                                                <option value="<?php echo $doctor->id; ?>" <?php echo set_select('doctor_id', $doctor->id); ?>>
                                                    <?php echo $doctor->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="priority">Priority</label>
                                        <select name="priority" class="form-control m-bot15 js-example-basic-single">
                                            <option value="routine" <?php echo set_select('priority', 'routine', TRUE); ?>>Routine</option>
                                            <option value="urgent" <?php echo set_select('priority', 'urgent'); ?>>Urgent</option>
                                            <option value="emergency" <?php echo set_select('priority', 'emergency'); ?>>Emergency</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="due_date">Due Date</label>
                                        <input type="date" name="due_date" class="form-control" value="<?php echo set_value('due_date', date('Y-m-d', strtotime('+1 day'))); ?>">
                                        <small class="text-muted">When the test results are expected</small>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="clinical_notes">Clinical Notes</label>
                                        <textarea name="clinical_notes" class="form-control" rows="3"><?php echo set_value('clinical_notes'); ?></textarea>
                                        <small class="text-muted">Any relevant clinical information or special instructions</small>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" name="submit" class="btn btn-info pull-right">
                                            <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                                        </button>
                                        <a href="<?php echo base_url('labworkflow/labTests'); ?>" class="btn btn-light pull-right mr-2">
                                            <i class="fa fa-times"></i> <?php echo lang('cancel'); ?>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- page end-->
    </div>
</div>
</div>
</div>
<!--main content end-->

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.js-example-basic-single').select2({
        width: '100%'
    });

    // Update specimen dropdown based on selected test template
    $('select[name="template_id"]').change(function() {
        var templateId = $(this).val();
        if (templateId) {
            $.ajax({
                url: '<?php echo base_url('labworkflow/getSpecimensByTemplate/'); ?>' + templateId,
                type: 'GET',
                success: function(response) {
                    var specimens = JSON.parse(response);
                    var specimenSelect = $('select[name="specimen_id"]');
                    specimenSelect.empty();
                    specimenSelect.append('<option value="">Select Specimen (Optional)</option>');
                    
                    specimens.forEach(function(specimen) {
                        specimenSelect.append(
                            '<option value="' + specimen.id + '">' + 
                            specimen.specimen_id + ' - ' + specimen.specimen_type_name +
                            ' (' + new Date(specimen.collection_date).toLocaleDateString() + ')' +
                            '</option>'
                        );
                    });
                }
            });
        }
    });
});
</script> 