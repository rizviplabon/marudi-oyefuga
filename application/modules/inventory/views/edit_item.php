<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-edit"></i> Edit Inventory Item
                </h3>
            </div>
            <div class="panel-body">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo base_url(); ?>inventory/editItem/<?php echo $item->id; ?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Item Name *</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name', $item->name); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Item Code</label>
                        <div class="col-sm-6">
                            <input type="text" name="item_code" class="form-control" value="<?php echo $item->item_code; ?>" readonly>
                            <small class="text-muted">Item code cannot be changed</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category *</label>
                        <div class="col-sm-6">
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo set_select('category_id', $category->id, ($category->id == $item->category_id)); ?>>
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-6">
                            <textarea name="description" class="form-control" rows="3"><?php echo set_value('description', $item->description); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit of Measure *</label>
                        <div class="col-sm-6">
                            <input type="text" name="unit_of_measure" class="form-control" value="<?php echo set_value('unit_of_measure', $item->unit_of_measure); ?>" placeholder="e.g., pieces, ml, kg" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current Stock</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $item->current_stock; ?>" readonly>
                            <small class="text-muted">Current stock cannot be changed directly. Use purchases/usage to modify stock.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Minimum Stock Level</label>
                        <div class="col-sm-6">
                            <input type="number" name="minimum_stock_level" class="form-control" value="<?php echo set_value('minimum_stock_level', $item->minimum_stock_level); ?>" min="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Maximum Stock Level</label>
                        <div class="col-sm-6">
                            <input type="number" name="maximum_stock_level" class="form-control" value="<?php echo set_value('maximum_stock_level', $item->maximum_stock_level); ?>" min="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Unit Cost</label>
                        <div class="col-sm-6">
                            <input type="number" name="unit_cost" class="form-control" value="<?php echo set_value('unit_cost', $item->unit_cost); ?>" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Supplier Name</label>
                        <div class="col-sm-6">
                            <input type="text" name="supplier_name" class="form-control" value="<?php echo set_value('supplier_name', $item->supplier_name); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Supplier Contact</label>
                        <div class="col-sm-6">
                            <input type="text" name="supplier_contact" class="form-control" value="<?php echo set_value('supplier_contact', $item->supplier_contact); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Storage Location</label>
                        <div class="col-sm-6">
                            <input type="text" name="storage_location" class="form-control" value="<?php echo set_value('storage_location', $item->storage_location); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Track Expiry</label>
                        <div class="col-sm-6">
                            <input type="checkbox" name="expiry_tracking" value="1" <?php echo set_checkbox('expiry_tracking', '1', ($item->expiry_tracking == 1)); ?>>
                            Track expiry dates for this item
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            <select name="status" class="form-control">
                                <option value="active" <?php echo set_select('status', 'active', ($item->status == 'active')); ?>>Active</option>
                                <option value="inactive" <?php echo set_select('status', 'inactive', ($item->status == 'inactive')); ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button type="submit" class="btn btn-primary">Update Item</button>
                            <a href="<?php echo base_url(); ?>inventory/items" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 