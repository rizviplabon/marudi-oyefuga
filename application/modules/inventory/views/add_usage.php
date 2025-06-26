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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
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
                            <i class="fa fa-minus"></i> Record Usage
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

                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo base_url(); ?>inventory/addUsage" method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Item <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="item_id" class="form-control" required id="item_select">
                                        <option value="">Select Item</option>
                                        <?php foreach ($inventory_items as $item) : ?>
                                            <option value="<?php echo $item->id; ?>" data-stock="<?php echo $item->current_stock; ?>" <?php echo set_select('item_id', $item->id); ?>>
                                                <?php echo $item->name; ?> (<?php echo $item->item_code; ?>) - Stock: <?php echo $item->current_stock; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Quantity Used <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="number" name="quantity_used" class="form-control" value="<?php echo set_value('quantity_used'); ?>" min="1" required id="quantity_used">
                                    <small class="text-muted" id="stock_info"></small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Usage Type <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="usage_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="patient" <?php echo set_select('usage_type', 'patient'); ?>>Patient Use</option>
                                        <option value="internal" <?php echo set_select('usage_type', 'internal'); ?>>Internal Use</option>
                                        <option value="damaged" <?php echo set_select('usage_type', 'damaged'); ?>>Damaged/Expired</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Patient Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="patient_name" class="form-control" value="<?php echo set_value('patient_name'); ?>">
                                    <small class="text-muted">Required only for patient use</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Reference Number</label>
                                <div class="col-sm-6">
                                    <input type="text" name="reference_id" class="form-control" value="<?php echo set_value('reference_id'); ?>">
                                    <small class="text-muted">e.g., Prescription ID, Order ID</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Notes</label>
                                <div class="col-sm-6">
                                    <textarea name="notes" class="form-control" rows="3"><?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Record Usage</button>
                                    <a href="<?php echo base_url(); ?>inventory/usage" class="btn btn-light">Cancel</a>
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
    $('#item_select').change(function() {
        var selectedOption = $(this).find('option:selected');
        var stock = selectedOption.data('stock') || 0;
        $('#stock_info').text('Available stock: ' + stock);
        $('#quantity_used').attr('max', stock);
    });
    
    $('#quantity_used').on('input', function() {
        var max = parseInt($(this).attr('max')) || 999999;
        var current = parseInt($(this).val()) || 0;
        if (current > max) {
            $(this).val(max);
            alert('Quantity cannot exceed available stock: ' + max);
        }
    });
});
</script> 