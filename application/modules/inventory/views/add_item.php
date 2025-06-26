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
                            <i class="fa fa-plus"></i> Add New Inventory Item
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

                        <form action="<?php echo base_url(); ?>inventory/addItem" method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Item Name <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Item Code</label>
                                <div class="col-sm-6">
                                    <input type="text" name="item_code" class="form-control" value="<?php echo set_value('item_code'); ?>" placeholder="Leave blank for auto-generation">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select name="category_id" class="form-control" required>
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
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-6">
                                    <textarea name="description" class="form-control" rows="3"><?php echo set_value('description'); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Unit of Measure <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" name="unit_of_measure" class="form-control" value="<?php echo set_value('unit_of_measure'); ?>" placeholder="e.g., pieces, ml, kg" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Minimum Stock Level</label>
                                <div class="col-sm-6">
                                    <input type="number" name="minimum_stock_level" class="form-control" value="<?php echo set_value('minimum_stock_level', 0); ?>" min="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Maximum Stock Level</label>
                                <div class="col-sm-6">
                                    <input type="number" name="maximum_stock_level" class="form-control" value="<?php echo set_value('maximum_stock_level', 0); ?>" min="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Unit Cost</label>
                                <div class="col-sm-6">
                                    <input type="number" name="unit_cost" class="form-control" value="<?php echo set_value('unit_cost', 0.00); ?>" step="0.01" min="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Supplier Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_name" class="form-control" value="<?php echo set_value('supplier_name'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Supplier Contact</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_contact" class="form-control" value="<?php echo set_value('supplier_contact'); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Add Item</button>
                                    <a href="<?php echo base_url(); ?>inventory/items" class="btn btn-light">Cancel</a>
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