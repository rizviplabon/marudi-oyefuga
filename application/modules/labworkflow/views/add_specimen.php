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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('labworkflow/specimens'); ?>">Lab Workflow</a></li>
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
                            <i class="fa fa-flask"></i> Collect New Specimen
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

                                <form role="form" action="<?php echo base_url('labworkflow/addSpecimen'); ?>" method="post" class="clearfix row" enctype="multipart/form-data">
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

                                    <div class="form-group col-md-6">
                                        <label for="specimen_type_id">Specimen Type <span class="text-danger">*</span></label>
                                        <select name="specimen_type_id" class="form-control m-bot15 js-example-basic-single" required>
                                            <option value="">Select Type</option>
                                            <?php foreach ($specimen_types as $type) : ?>
                                                <option value="<?php echo $type->id; ?>" <?php echo set_select('specimen_type_id', $type->id); ?>>
                                                    <?php echo $type->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="collection_method">Collection Method</label>
                                        <select name="collection_method" class="form-control m-bot15 js-example-basic-single">
                                            <option value="standard" <?php echo set_select('collection_method', 'standard', TRUE); ?>>Standard</option>
                                            <option value="venipuncture" <?php echo set_select('collection_method', 'venipuncture'); ?>>Venipuncture</option>
                                            <option value="fingerstick" <?php echo set_select('collection_method', 'fingerstick'); ?>>Fingerstick</option>
                                            <option value="swab" <?php echo set_select('collection_method', 'swab'); ?>>Swab</option>
                                            <option value="urine" <?php echo set_select('collection_method', 'urine'); ?>>Urine Collection</option>
                                            <option value="other" <?php echo set_select('collection_method', 'other'); ?>>Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="collection_date">Collection Date/Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="collection_date" class="form-control" value="<?php echo set_value('collection_date', date('Y-m-d\TH:i')); ?>" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="quantity">Volume/Quantity</label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" value="<?php echo set_value('quantity'); ?>" step="0.01">
                                            <div class="input-group-append">
                                                <select name="quantity_unit" class="form-control">
                                                    <option value="ml" <?php echo set_select('quantity_unit', 'ml', TRUE); ?>>ml</option>
                                                    <option value="mg" <?php echo set_select('quantity_unit', 'mg'); ?>>mg</option>
                                                    <option value="g" <?php echo set_select('quantity_unit', 'g'); ?>>g</option>
                                                    <option value="pieces" <?php echo set_select('quantity_unit', 'pieces'); ?>>pieces</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="container_type">Container Type</label>
                                        <select name="container_type" class="form-control m-bot15 js-example-basic-single">
                                            <option value="">Select Container</option>
                                            <option value="tube" <?php echo set_select('container_type', 'tube'); ?>>Test Tube</option>
                                            <option value="vacutainer" <?php echo set_select('container_type', 'vacutainer'); ?>>Vacutainer</option>
                                            <option value="container" <?php echo set_select('container_type', 'container'); ?>>Sterile Container</option>
                                            <option value="swab" <?php echo set_select('container_type', 'swab'); ?>>Swab Tube</option>
                                            <option value="slide" <?php echo set_select('container_type', 'slide'); ?>>Slide</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="condition_on_collection">Condition on Collection</label>
                                        <select name="condition_on_collection" class="form-control m-bot15 js-example-basic-single">
                                            <option value="good" <?php echo set_select('condition_on_collection', 'good', TRUE); ?>>Good</option>
                                            <option value="hemolyzed" <?php echo set_select('condition_on_collection', 'hemolyzed'); ?>>Hemolyzed</option>
                                            <option value="clotted" <?php echo set_select('condition_on_collection', 'clotted'); ?>>Clotted</option>
                                            <option value="insufficient" <?php echo set_select('condition_on_collection', 'insufficient'); ?>>Insufficient</option>
                                            <option value="contaminated" <?php echo set_select('condition_on_collection', 'contaminated'); ?>>Contaminated</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="notes">Notes</label>
                                        <textarea name="notes" class="form-control" rows="3"><?php echo set_value('notes'); ?></textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" name="submit" class="btn btn-info pull-right">
                                            <i class="fa fa-check"></i> <?php echo lang('submit'); ?>
                                        </button>
                                        <a href="<?php echo base_url('labworkflow/specimens'); ?>" class="btn btn-light pull-right mr-2">
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
});
</script> 