<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="row">
            <div class="col-12 content-header"> 
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="page-title-left">
                        <h4 class="mb-1 text-primary">
                            <i class="fas fa-chart-bar me-2"></i><?php echo $page_title; ?>
                        </h4>
                        <p class="text-muted mb-0">Comprehensive inventory analytics and reporting</p>
                    </div>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li class="breadcrumb-item active"><?php echo $page; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards Section -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-cubes fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php 
                                    $total_items = count($stock_report);
                                    echo number_format($total_items);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Total Items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-dollar-sign fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php 
                                    $total_value = 0;
                                    foreach ($stock_report as $item) {
                                        $total_value += ($item->current_stock * $item->unit_cost);
                                    }
                                    echo '$' . number_format($total_value, 2);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Total Stock Value</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-exclamation-triangle fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php 
                                    $low_stock_count = 0;
                                    foreach ($stock_report as $item) {
                                        if ($item->current_stock <= $item->minimum_stock_level) {
                                            $low_stock_count++;
                                        }
                                    }
                                    echo number_format($low_stock_count);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Low Stock Items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-tags fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php echo count($categories); ?>
                                </h5>
                                <p class="text-white-75 mb-0">Categories</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Reports Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-primary">
                                    <i class="fas fa-chart-line me-2"></i>Inventory Reports
                                </h5>
                                <p class="text-muted mb-0">Detailed analytics and reports for inventory management</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="refreshReports">
                                    <i class="fas fa-sync-alt me-1"></i>Refresh
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" id="printAllReports">
                                    <i class="fas fa-print me-1"></i>Print All
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Enhanced Navigation Tabs -->
                        <ul class="nav nav-tabs nav-justified border-bottom-0" id="reportTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active d-flex align-items-center justify-content-center py-3" id="stock-tab" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="true">
                                    <i class="fas fa-warehouse me-2 text-primary"></i>
                                    <div class="text-start">
                                        <div class="fw-bold">Stock Report</div>
                                        <small class="text-muted">Current inventory levels</small>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center py-3" id="usage-tab" data-toggle="tab" href="#usage" role="tab" aria-controls="usage" aria-selected="false">
                                    <i class="fas fa-chart-line me-2 text-success"></i>
                                    <div class="text-start">
                                        <div class="fw-bold">Usage Report</div>
                                        <small class="text-muted">Consumption analytics</small>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center py-3" id="purchase-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false">
                                    <i class="fas fa-shopping-cart me-2 text-info"></i>
                                    <div class="text-start">
                                        <div class="fw-bold">Purchase Report</div>
                                        <small class="text-muted">Procurement history</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content p-4" id="reportTabsContent">
                            <!-- Enhanced Stock Report Tab -->
                            <div class="tab-pane fade show active" id="stock" role="tabpanel" aria-labelledby="stock-tab">
                                <!-- Enhanced Filter Section -->
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <div class="card border border-primary border-opacity-25 bg-light">
                                            <div class="card-body py-3">
                                                <form method="get" action="inventory/reports" class="row g-3 align-items-end">
                                                    <div class="col-md-4">
                                                        <label for="category" class="form-label fw-semibold">
                                                            <i class="fas fa-filter me-1 text-primary"></i>Filter by Category
                                                        </label>
                                                        <select name="category" id="category" class="form-select">
                                                            <option value="">🏷️ All Categories</option>
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?php echo $category->id; ?>" <?php echo ($this->input->get('category') == $category->id) ? 'selected' : ''; ?>>
                                                            <?php echo $category->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold">
                                                            <i class="fas fa-eye me-1 text-primary"></i>Stock Status
                                                        </label>
                                                        <select name="stock_status" class="form-select">
                                                            <option value="">📊 All Status</option>
                                                            <option value="in_stock">✅ In Stock</option>
                                                            <option value="low_stock">⚠️ Low Stock</option>
                                                            <option value="out_of_stock">❌ Out of Stock</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fas fa-search me-1"></i>Apply Filters
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="<?php echo base_url('inventory/reports'); ?>" class="btn btn-outline-secondary w-100">
                                                            <i class="fas fa-undo me-1"></i>Reset
                                                        </a>
                                                    </div>
                                        </form>
                                    </div>
                                        </div>
                                    </div>
                                   
                                </div>

                                <!-- Enhanced Stock Table -->
                                <div class="table-responsive">
                                    <table id="stock-table" class="table table-hover align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="fw-bold"><i class="fas fa-barcode me-1"></i>Item Code</th>
                                                <th class="fw-bold"><i class="fas fa-tag me-1"></i>Name</th>
                                                <th class="fw-bold"><i class="fas fa-folder me-1"></i>Category</th>
                                                <th class="fw-bold"><i class="fas fa-cubes me-1"></i>Current Stock</th>
                                                <th class="fw-bold"><i class="fas fa-level-down-alt me-1"></i>Min Level</th>
                                                <th class="fw-bold"><i class="fas fa-level-up-alt me-1"></i>Max Level</th>
                                                <th class="fw-bold"><i class="fas fa-dollar-sign me-1"></i>Unit Cost</th>
                                                <th class="fw-bold"><i class="fas fa-calculator me-1"></i>Total Value</th>
                                                <th class="fw-bold"><i class="fas fa-info-circle me-1"></i>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($stock_report as $item) { ?>
                                                <tr>
                                                    <td><code class="text-primary"><?php echo $item->item_code; ?></code></td>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo $item->name; ?></div>
                                                        <?php if ($item->description) { ?>
                                                            <small class="text-muted"><?php echo substr($item->description, 0, 50) . (strlen($item->description) > 50 ? '...' : ''); ?></small>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <?php echo $item->category_name; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <strong class="me-2"><?php echo number_format($item->current_stock); ?></strong>
                                                            <small class="text-muted"><?php echo $item->unit_of_measure; ?></small>
                                                        </div>
                                                    </td>
                                                    <td><?php echo number_format($item->minimum_stock_level); ?></td>
                                                    <td><?php echo number_format($item->maximum_stock_level); ?></td>
                                                    <td class="fw-semibold text-success">$<?php echo number_format($item->unit_cost, 2); ?></td>
                                                    <td class="fw-bold text-primary">$<?php echo number_format($item->current_stock * $item->unit_cost, 2); ?></td>
                                                    <td>
                                                        <?php if ($item->current_stock <= 0) { ?>
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle me-1"></i>Out of Stock
                                                            </span>
                                                        <?php } elseif ($item->current_stock <= $item->minimum_stock_level) { ?>
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>Low Stock
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i>In Stock
                                                            </span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Enhanced Usage Report Tab -->
                            <div class="tab-pane fade" id="usage" role="tabpanel" aria-labelledby="usage-tab">
                                <!-- Enhanced Filter Section -->
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <div class="card border border-success border-opacity-25 bg-light">
                                            <div class="card-body py-3">
                                                <form method="get" action="inventory/reports" class="row g-3 align-items-end">
                                                    <div class="col-md-3">
                                                        <label for="from_date" class="form-label fw-semibold">
                                                            <i class="fas fa-calendar-alt me-1 text-success"></i>From Date
                                                        </label>
                                                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                                    <div class="col-md-3">
                                                        <label for="to_date" class="form-label fw-semibold">
                                                            <i class="fas fa-calendar-check me-1 text-success"></i>To Date
                                                        </label>
                                                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                                    <div class="col-md-3">
                                                        <label for="usage_category" class="form-label fw-semibold">
                                                            <i class="fas fa-filter me-1 text-success"></i>Category
                                                        </label>
                                                        <select name="category" id="usage_category" class="form-select">
                                                            <option value="">🏷️ All Categories</option>
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?php echo $category->id; ?>" <?php echo ($this->input->get('category') == $category->id) ? 'selected' : ''; ?>>
                                                            <?php echo $category->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-success w-100">
                                                            <i class="fas fa-search me-1"></i>Apply Filters
                                                        </button>
                                                    </div>
                                        </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="d-flex gap-2 h-100 align-items-end">
                                            <button type="button" class="btn btn-success flex-fill" id="exportUsageReport">
                                                <i class="fas fa-file-excel me-1"></i>Export Excel
                                            </button>
                                            <button type="button" class="btn btn-info flex-fill" id="printUsageReport">
                                                <i class="fas fa-print me-1"></i>Print Report
                                        </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Usage Table -->
                                <div class="table-responsive">
                                    <table id="usage-report-table" class="table table-hover align-middle">
                                        <thead class="table-success">
                                            <tr>
                                                <th class="fw-bold"><i class="fas fa-tag me-1"></i>Item</th>
                                                <th class="fw-bold"><i class="fas fa-folder me-1"></i>Category</th>
                                                <th class="fw-bold"><i class="fas fa-minus-circle me-1"></i>Quantity Used</th>
                                                <th class="fw-bold"><i class="fas fa-list me-1"></i>Usage Type</th>
                                                <th class="fw-bold"><i class="fas fa-user-injured me-1"></i>Patient</th>
                                                <th class="fw-bold"><i class="fas fa-calendar me-1"></i>Usage Date</th>
                                                <th class="fw-bold"><i class="fas fa-user-md me-1"></i>Used By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($usage_report as $usage) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo $usage->item_name; ?></div>
                                                        <small class="text-muted"><?php echo $usage->item_code; ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <?php echo $usage->category_name; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark fs-6">
                                                            <?php echo number_format($usage->quantity_used); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            <?php echo ucfirst($usage->usage_type); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($usage->patient_name) { ?>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-user-circle text-muted me-2"></i>
                                                                <?php echo $usage->patient_name; ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo date('M d, Y', strtotime($usage->usage_date)); ?></div>
                                                        <small class="text-muted"><?php echo date('h:i A', strtotime($usage->usage_date)); ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-user-md text-primary me-2"></i>
                                                            <?php echo $usage->user_name; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Enhanced Purchase Report Tab -->
                            <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                                <!-- Enhanced Filter Section -->
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <div class="card border border-info border-opacity-25 bg-light">
                                            <div class="card-body py-3">
                                                <form method="get" action="inventory/reports" class="row g-3 align-items-end">
                                                    <div class="col-md-3">
                                                        <label for="purchase_from_date" class="form-label fw-semibold">
                                                            <i class="fas fa-calendar-alt me-1 text-info"></i>From Date
                                                        </label>
                                                <input type="date" name="from_date" id="purchase_from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                                    <div class="col-md-3">
                                                        <label for="purchase_to_date" class="form-label fw-semibold">
                                                            <i class="fas fa-calendar-check me-1 text-info"></i>To Date
                                                        </label>
                                                <input type="date" name="to_date" id="purchase_to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                                    <div class="col-md-3">
                                                        <label for="purchase_category" class="form-label fw-semibold">
                                                            <i class="fas fa-filter me-1 text-info"></i>Category
                                                        </label>
                                                        <select name="category" id="purchase_category" class="form-select">
                                                            <option value="">🏷️ All Categories</option>
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?php echo $category->id; ?>" <?php echo ($this->input->get('category') == $category->id) ? 'selected' : ''; ?>>
                                                            <?php echo $category->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-info w-100">
                                                            <i class="fas fa-search me-1"></i>Apply Filters
                                                        </button>
                                                    </div>
                                        </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="d-flex gap-2 h-100 align-items-end">
                                            <button type="button" class="btn btn-success flex-fill" id="exportPurchaseReport">
                                                <i class="fas fa-file-excel me-1"></i>Export Excel
                                            </button>
                                            <button type="button" class="btn btn-info flex-fill" id="printPurchaseReport">
                                                <i class="fas fa-print me-1"></i>Print Report
                                        </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Purchase Table -->
                                <div class="table-responsive">
                                    <table id="purchase-report-table" class="table table-hover align-middle">
                                        <thead class="table-info">
                                            <tr>
                                                <th class="fw-bold"><i class="fas fa-receipt me-1"></i>PO #</th>
                                                <th class="fw-bold"><i class="fas fa-tag me-1"></i>Item</th>
                                                <th class="fw-bold"><i class="fas fa-folder me-1"></i>Category</th>
                                                <th class="fw-bold"><i class="fas fa-cubes me-1"></i>Quantity</th>
                                                <th class="fw-bold"><i class="fas fa-dollar-sign me-1"></i>Unit Cost</th>
                                                <th class="fw-bold"><i class="fas fa-calculator me-1"></i>Total Cost</th>
                                                <th class="fw-bold"><i class="fas fa-truck me-1"></i>Supplier</th>
                                                <th class="fw-bold"><i class="fas fa-calendar me-1"></i>Purchase Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($purchase_report as $purchase) { ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($purchase->purchase_order_no) { ?>
                                                            <code class="text-info"><?php echo $purchase->purchase_order_no; ?></code>
                                                        <?php } else { ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo $purchase->item_name; ?></div>
                                                        <small class="text-muted"><?php echo $purchase->item_code; ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border">
                                                            <?php echo $purchase->category_name; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary fs-6">
                                                            <?php echo number_format($purchase->quantity); ?>
                                                        </span>
                                                    </td>
                                                    <td class="fw-semibold text-success">$<?php echo number_format($purchase->unit_cost, 2); ?></td>
                                                    <td class="fw-bold text-primary">$<?php echo number_format($purchase->total_cost, 2); ?></td>
                                                    <td>
                                                        <?php if ($purchase->supplier_name) { ?>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-building text-muted me-2"></i>
                                                                <?php echo $purchase->supplier_name; ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo date('M d, Y', strtotime($purchase->purchase_date)); ?></div>
                                                        <small class="text-muted"><?php echo date('D', strtotime($purchase->purchase_date)); ?></small>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Enhanced Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.nav-tabs .nav-link {
    border: none;
    border-radius: 0;
    position: relative;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    background-color: rgba(0,123,255,0.1);
    border: none;
}

.nav-tabs .nav-link.active {
    background-color: transparent;
    border: none;
    border-bottom: 3px solid #007bff;
    color: #007bff;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.avatar-sm {
    height: 3rem;
    width: 3rem;
}

.avatar-title {
    align-items: center;
    background-color: transparent;
    color: inherit;
    display: flex;
    font-weight: 500;
    height: 100%;
    justify-content: center;
    width: 100%;
}

.text-white-75 {
    color: rgba(255,255,255,0.75) !important;
}

.fs-4 {
    font-size: 1.5rem !important;
}

.fs-6 {
    font-size: 1rem !important;
}

.fw-bold {
    font-weight: 700 !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

.me-1 { margin-right: 0.25rem !important; }
.me-2 { margin-right: 0.5rem !important; }
.ms-3 { margin-left: 1rem !important; }

@media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding: 1rem 0.5rem;
        font-size: 0.9rem;
    }
    
    .nav-tabs .nav-link div {
        text-align: center !important;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<!-- Enhanced JavaScript -->
<script>
    $(document).ready(function() {
        // Enhanced DataTables configuration
        const commonDataTableConfig = {
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 25,
            language: {
                search: "<span class='small text-muted'></span> _INPUT_",
                searchPlaceholder: "Type to search...",
                lengthMenu: "<span class='small text-muted'> _MENU_ </span>",
                info: "<b>_START_</b> to <b>_END_</b> of <b>_TOTAL_</b> entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "<i class='fas fa-angle-double-left'></i>",
                    last: "<i class='fas fa-angle-double-right'></i>",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                },
                processing: "<div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'><span class='sr-only'>Loading...</span></div></div>"
            },
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-outline-secondary btn-sm me-1',
                    text: '<i class="fas fa-copy me-1"></i>Copy'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-outline-success btn-sm me-1',
                    text: '<i class="fas fa-file-csv me-1"></i>CSV'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-success btn-sm me-1',
                    text: '<i class="fas fa-file-excel me-1"></i>Excel'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-danger btn-sm me-1',
                    text: '<i class="fas fa-file-pdf me-1"></i>PDF'
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-info btn-sm',
                    text: '<i class="fas fa-print me-1"></i>Print'
                }
            ]
        };

        // Initialize Stock Report Table
        const stockTable = $('#stock-table').DataTable({
            ...commonDataTableConfig,
            order: [[8, 'desc'], [3, 'asc']], // Sort by status then stock level
            columnDefs: [
                {
                    targets: [3, 4, 5], // Stock columns
                    className: 'text-center'
                },
                {
                    targets: [6, 7], // Price columns
                    className: 'text-end'
                },
                {
                    targets: [8], // Status column
                    className: 'text-center'
                }
            ]
        });
        
        // Initialize Usage Report Table
        const usageTable = $('#usage-report-table').DataTable({
            ...commonDataTableConfig,
            order: [[5, 'desc']], // Sort by usage date
            columnDefs: [
                {
                    targets: [2], // Quantity column
                    className: 'text-center'
                },
                {
                    targets: [3], // Usage type column
                    className: 'text-center'
                }
            ]
        });
        
        // Initialize Purchase Report Table
        const purchaseTable = $('#purchase-report-table').DataTable({
            ...commonDataTableConfig,
            order: [[7, 'desc']], // Sort by purchase date
            columnDefs: [
                {
                    targets: [3], // Quantity column
                    className: 'text-center'
                },
                {
                    targets: [4, 5], // Price columns
                    className: 'text-end'
                }
            ]
        });
        
        // Enhanced Export Functions
        $('#exportStockReport').click(function() {
            stockTable.button('.buttons-excel').trigger();
        });
        
        $('#exportUsageReport').click(function() {
            usageTable.button('.buttons-excel').trigger();
        });
        
        $('#exportPurchaseReport').click(function() {
            purchaseTable.button('.buttons-excel').trigger();
        });

        // Print Functions
        $('#printStockReport').click(function() {
            stockTable.button('.buttons-print').trigger();
        });
        
        $('#printUsageReport').click(function() {
            usageTable.button('.buttons-print').trigger();
        });
        
        $('#printPurchaseReport').click(function() {
            purchaseTable.button('.buttons-print').trigger();
        });

        // Print All Reports
        $('#printAllReports').click(function() {
            if (confirm('This will print all visible reports. Continue?')) {
                window.print();
            }
        });

        // Refresh Reports
        $('#refreshReports').click(function() {
            location.reload();
        });

        // Tab switching with smooth transitions
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // Recalculate column widths for responsive tables
            setTimeout(function() {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
            }, 200);
        });

        // Auto-set date ranges for better UX
        if (!$('#from_date').val()) {
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            $('#from_date').val(thirtyDaysAgo.toISOString().split('T')[0]);
        }

        if (!$('#to_date').val()) {
            const today = new Date();
            $('#to_date').val(today.toISOString().split('T')[0]);
        }

        // Copy date values to other tabs
        $('#from_date').on('change', function() {
            $('#purchase_from_date').val($(this).val());
        });

        $('#to_date').on('change', function() {
            $('#purchase_to_date').val($(this).val());
        });

        // Animate numbers on page load
        $('.card-body h5').each(function() {
            const $this = $(this);
            const text = $this.text();
            if (text.match(/[\d,.$]/)) {
                $this.prop('Counter', 0).animate({
                    Counter: parseFloat(text.replace(/[^0-9.]/g, ''))
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function(now) {
                        if (text.includes('$')) {
                            $this.text('$' + Math.ceil(now).toLocaleString());
                        } else {
                            $this.text(Math.ceil(now).toLocaleString());
                        }
                    }
                });
            }
        });

        // Tooltips for better UX
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Add tooltips to status badges
        $('.badge').each(function() {
            const $this = $(this);
            if ($this.hasClass('bg-danger')) {
                $this.attr('title', 'Immediate attention required');
            } else if ($this.hasClass('bg-warning')) {
                $this.attr('title', 'Stock running low - consider reordering');
            } else if ($this.hasClass('bg-success')) {
                $this.attr('title', 'Stock levels are healthy');
            }
        }).tooltip();
    });
</script> 