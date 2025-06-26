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
                            <i class="fa fa-shopping-cart"></i> Record New Purchase
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

                        <form action="<?php echo base_url(); ?>inventory/addPurchase" method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Order No</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchase_order_no" class="form-control" value="<?php echo set_value('purchase_order_no'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Item <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="item_id" class="form-control" required>
                                        <option value="">Select Item</option>
                                        <?php foreach ($inventory_items as $item) : ?>
                                            <option value="<?php echo $item->id; ?>" <?php echo set_select('item_id', $item->id); ?>>
                                                <?php echo $item->name; ?> (<?php echo $item->item_code; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Quantity <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="number" name="quantity" class="form-control" value="<?php echo set_value('quantity'); ?>" min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Unit Cost <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="number" name="unit_cost" class="form-control" value="<?php echo set_value('unit_cost'); ?>" step="0.01" min="0" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Supplier Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_name" class="form-control" value="<?php echo set_value('supplier_name'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Supplier Invoice No</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_invoice_no" class="form-control" value="<?php echo set_value('supplier_invoice_no'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Date <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="date" name="purchase_date" class="form-control" value="<?php echo set_value('purchase_date', date('Y-m-d')); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Expiry Date</label>
                                <div class="col-sm-6">
                                    <input type="date" name="expiry_date" class="form-control" value="<?php echo set_value('expiry_date'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Batch Number</label>
                                <div class="col-sm-6">
                                    <input type="text" name="batch_number" class="form-control" value="<?php echo set_value('batch_number'); ?>">
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
                                    <button type="submit" class="btn btn-primary">Record Purchase</button>
                                    <a href="<?php echo base_url(); ?>inventory/purchases" class="btn btn-light">Cancel</a>
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