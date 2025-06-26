<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="page-icon me-3">
                            <i class="fas fa-chart-pie text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-primary">Inventory Dashboard</h4>
                            <p class="text-muted mb-0">Comprehensive overview of your medical inventory system</p>
                        </div>
                    </div>
                    <div class="page-title-right">
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="refreshDashboard">
                                <i class="fas fa-sync-alt me-1"></i>Refresh
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-plus me-1"></i>Quick Add
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo base_url('inventory/items'); ?>"><i class="fas fa-cube me-2"></i>Add Item</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('inventory/purchases'); ?>"><i class="fas fa-shopping-cart me-2"></i>Record Purchase</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('inventory/usage'); ?>"><i class="fas fa-minus me-2"></i>Record Usage</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('inventory/categories'); ?>"><i class="fas fa-tags me-2"></i>Add Category</a></li>
                                </ul>
                            </div>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 bg-transparent">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('home'); ?>" class="text-primary">
                                        <i class="fas fa-home"></i> Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-dark fw-medium">
                                    <i class="fas fa-chart-pie"></i> Dashboard
                                </li>
                        </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Custom CSS -->
        <style>
            :root {
                --primary: #4f46e5;
                --primary-dark: #4338ca;
                --success: #10b981;
                --warning: #f59e0b;
                --danger: #ef4444;
                --info: #06b6d4;
                --gray-100: #f3f4f6;
                --gray-200: #e5e7eb;
                --gray-300: #d1d5db;
                --gray-400: #9ca3af;
                --gray-500: #6b7280;
                --gray-600: #4b5563;
                --white: #ffffff;
            }

            .dashboard-card {
                border: none;
                border-radius: 20px;
                box-shadow: 0 4px 25px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
                background: linear-gradient(135deg, var(--white) 0%, #fafafa 100%);
                overflow: hidden;
                position: relative;
            }

            .dashboard-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 35px rgba(0,0,0,0.15);
            }

            .dashboard-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary), var(--info));
            }

            .dashboard-icon-wrapper {
                width: 70px;
                height: 70px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.8rem;
                position: relative;
                overflow: hidden;
            }

            .dashboard-icon-wrapper::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                opacity: 0.1;
                border-radius: 20px;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
            }

            .bg-gradient-warning {
                background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, var(--info) 0%, #22d3ee 100%);
            }

            .counter {
                font-weight: 700;
                font-size: 2.5rem;
                line-height: 1;
                background: linear-gradient(135deg, var(--primary), var(--info));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .chart-card {
                border: none;
                border-radius: 20px;
                box-shadow: 0 4px 25px rgba(0,0,0,0.08);
                background: var(--white);
                transition: all 0.3s ease;
            }

            .chart-card:hover {
                box-shadow: 0 8px 35px rgba(0,0,0,0.12);
            }

            .quick-action-btn {
                border-radius: 15px;
                padding: 15px;
                border: 2px solid transparent;
                transition: all 0.3s ease;
                background: linear-gradient(135deg, var(--white), #f8fafc);
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }

            .quick-action-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                border-color: var(--primary);
            }

            .activity-card {
                border: none;
                border-radius: 15px;
                background: var(--white);
                box-shadow: 0 2px 15px rgba(0,0,0,0.05);
                transition: all 0.3s ease;
            }

            .activity-card:hover {
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }

            .table-modern {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }

            .table-modern thead th {
                background: linear-gradient(135deg, var(--primary), #6366f1);
                color: white;
                border: none;
                font-weight: 600;
                padding: 15px;
            }

            .table-modern tbody tr {
                transition: all 0.2s ease;
            }

            .table-modern tbody tr:hover {
                background-color: var(--gray-100);
                transform: scale(1.01);
            }

            .alert-badge {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.7; }
                100% { opacity: 1; }
            }

            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255,255,255,0.9);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                display: none;
            }

            .spinner {
                width: 40px;
                height: 40px;
                border: 4px solid var(--gray-200);
                border-top: 4px solid var(--primary);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .metric-trend {
                font-size: 0.75rem;
                padding: 2px 8px;
                border-radius: 20px;
                font-weight: 600;
            }

            .trend-up {
                background-color: rgba(16, 185, 129, 0.1);
                color: var(--success);
            }

            .trend-down {
                background-color: rgba(239, 68, 68, 0.1);
                color: var(--danger);
            }

            .progress-modern {
                height: 8px;
                border-radius: 10px;
                background-color: var(--gray-200);
                overflow: hidden;
            }

            .progress-modern .progress-bar {
                border-radius: 10px;
                transition: width 0.6s ease;
            }
        </style>

        <!-- Enhanced Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="dashboard-icon-wrapper bg-gradient-primary">
                                    <i class="fas fa-boxes text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1 fw-medium">Total Items</h6>
                                <h4 class="mb-0">
                                    <span class="counter" data-target="<?php echo count($inventory_items); ?>">0</span>
                                </h4>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="metric-trend trend-up">
                                        <i class="fas fa-arrow-up me-1"></i>12%
                            </span>
                                    <small class="text-muted ms-2">vs last month</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo base_url('inventory/items'); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-cogs me-1"></i>Manage Items
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="dashboard-icon-wrapper bg-gradient-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1 fw-medium">Low Stock Items</h6>
                                <h4 class="mb-0">
                                    <span class="counter text-warning" data-target="<?php echo $low_stock_count; ?>">0</span>
                                </h4>
                                <div class="d-flex align-items-center mt-2">
                                    <?php if($low_stock_count > 0): ?>
                                    <span class="metric-trend trend-down alert-badge">
                                        <i class="fas fa-exclamation me-1"></i>Alert
                                    </span>
                                    <?php else: ?>
                                    <span class="metric-trend trend-up">
                                        <i class="fas fa-check me-1"></i>Good
                            </span>
                                    <?php endif; ?>
                                    <small class="text-muted ms-2">Stock levels</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo base_url('inventory/alerts'); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-bell me-1"></i>View Alerts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="dashboard-icon-wrapper bg-gradient-success">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1 fw-medium">Total Stock Value</h6>
                                <h4 class="mb-0">
                                    $<span class="counter" data-target="<?php echo number_format($total_stock_value, 0, '', ''); ?>"><?php echo number_format($total_stock_value, 2); ?></span>
                                </h4>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="metric-trend trend-up">
                                        <i class="fas fa-arrow-up me-1"></i>8%
                            </span>
                                    <small class="text-muted ms-2">from last month</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo base_url('inventory/reports'); ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-chart-line me-1"></i>View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="dashboard-icon-wrapper bg-gradient-info">
                                    <i class="fas fa-tags text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1 fw-medium">Categories</h6>
                                <h4 class="mb-0">
                                    <span class="counter" data-target="<?php echo count($categories); ?>">0</span>
                                </h4>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="metric-trend trend-up">
                                        <i class="fas fa-plus me-1"></i>Active
                            </span>
                                    <small class="text-muted ms-2">Well organized</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo base_url('inventory/categories'); ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-layer-group me-1"></i>Manage Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Charts & Analytics -->
        <div class="row mb-4">
            <!-- Category Distribution Chart -->
            <div class="col-lg-6">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">
                                    <i class="fas fa-chart-pie text-primary me-2"></i>Category Distribution
                                </h5>
                                <p class="text-muted mb-0 small">Inventory distribution by categories</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-filter="all">All Categories</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="active">Active Only</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="low">Low Stock</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="category-chart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Stock Status Chart -->
            <div class="col-lg-6">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">
                                    <i class="fas fa-chart-donut text-success me-2"></i>Stock Status Overview
                                </h5>
                                <p class="text-muted mb-0 small">Current inventory status distribution</p>
                            </div>
                            <button class="btn btn-outline-success btn-sm" id="refreshStockChart">
                                <i class="fas fa-sync-alt me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="stock-status-chart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Activity Section -->
        <div class="row mb-4">
            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card activity-card">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-1 fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                        </h5>
                        <p class="text-muted mb-0 small">Frequently used inventory operations</p>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="<?php echo base_url('inventory/items'); ?>" class="btn quick-action-btn w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-plus text-primary me-2"></i>
                                        <div>
                                            <div class="fw-medium">Add Item</div>
                                            <small class="text-muted">New inventory</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo base_url('inventory/purchases'); ?>" class="btn quick-action-btn w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart text-success me-2"></i>
                                        <div>
                                            <div class="fw-medium">Purchase</div>
                                            <small class="text-muted">Add stock</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo base_url('inventory/usage'); ?>" class="btn quick-action-btn w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-minus text-info me-2"></i>
                                        <div>
                                            <div class="fw-medium">Usage</div>
                                            <small class="text-muted">Record usage</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo base_url('inventory/reports'); ?>" class="btn quick-action-btn w-100 text-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-chart-bar text-secondary me-2"></i>
                                        <div>
                                            <div class="fw-medium">Reports</div>
                                            <small class="text-muted">Analytics</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Purchases -->
            <div class="col-lg-4">
                <div class="card activity-card">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">
                                    <i class="fas fa-shopping-bag text-success me-2"></i>Recent Purchases
                                </h5>
                                <p class="text-muted mb-0 small">Latest inventory acquisitions</p>
                            </div>
                            <a href="<?php echo base_url('inventory/purchases'); ?>" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-eye me-1"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="border-0 fw-medium">Item</th>
                                        <th class="border-0 fw-medium">Qty</th>
                                        <th class="border-0 fw-medium">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($recent_purchases)):
                                        foreach($recent_purchases as $purchase): 
                                            $item = $this->db->get_where('inventory_items', array('id' => $purchase->item_id))->row();
                                            if($item):
                                    ?>
                                        <tr class="border-bottom">
                                            <td class="py-2">
                                                <div class="fw-medium"><?php echo $item->name; ?></div>
                                                <small class="text-muted"><?php echo $item->item_code; ?></small>
                                            </td>
                                            <td class="py-2">
                                                <span class="badge bg-success-subtle text-success"><?php echo $purchase->quantity; ?></span>
                                            </td>
                                            <td class="py-2">
                                                <small class="text-muted"><?php echo date('M d', strtotime($purchase->purchase_date)); ?></small>
                                            </td>
                                        </tr>
                                    <?php 
                                            endif;
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                No recent purchases
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Usage -->
            <div class="col-lg-4">
                <div class="card activity-card">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">
                                    <i class="fas fa-clipboard-list text-info me-2"></i>Recent Usage
                                </h5>
                                <p class="text-muted mb-0 small">Latest inventory consumption</p>
                            </div>
                            <a href="<?php echo base_url('inventory/usage'); ?>" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye me-1"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="border-0 fw-medium">Item</th>
                                        <th class="border-0 fw-medium">Qty</th>
                                        <th class="border-0 fw-medium">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($recent_usage)):
                                        foreach($recent_usage as $usage): 
                                            $item = $this->db->get_where('inventory_items', array('id' => $usage->item_id))->row();
                                            if($item):
                                    ?>
                                        <tr class="border-bottom">
                                            <td class="py-2">
                                                <div class="fw-medium"><?php echo $item->name; ?></div>
                                                <small class="text-muted"><?php echo $item->item_code; ?></small>
                                            </td>
                                            <td class="py-2">
                                                <span class="badge bg-info-subtle text-info"><?php echo $usage->quantity_used; ?></span>
                                            </td>
                                            <td class="py-2">
                                                <small class="text-muted"><?php echo date('M d', strtotime($usage->usage_date)); ?></small>
                                            </td>
                                        </tr>
                                    <?php 
                                            endif;
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                No recent usage
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Low Stock Items -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 fw-bold">
                                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Critical Stock Alerts
                                </h5>
                                <p class="text-muted mb-0">Items requiring immediate attention</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger btn-sm" id="exportLowStock">
                                    <i class="fas fa-download me-1"></i>Export
                                </button>
                                <a href="<?php echo base_url('inventory/alerts'); ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-bell me-1"></i>View All Alerts
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-modern table-hover align-middle mb-0" id="lowStockTable">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">
                                            <i class="fas fa-barcode me-1"></i>Item Code
                                        </th>
                                        <th class="fw-bold">
                                            <i class="fas fa-tag me-1"></i>Name
                                        </th>
                                        <th class="fw-bold">
                                            <i class="fas fa-layer-group me-1"></i>Category
                                        </th>
                                        <th class="fw-bold text-center">
                                            <i class="fas fa-cubes me-1"></i>Current Stock
                                        </th>
                                        <th class="fw-bold text-center">
                                            <i class="fas fa-level-down-alt me-1"></i>Min Level
                                        </th>
                                        <th class="fw-bold text-center">
                                            <i class="fas fa-chart-line me-1"></i>Status
                                        </th>
                                        <th class="fw-bold text-center">
                                            <i class="fas fa-cogs me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $shown = 0;
                                    foreach($inventory_items as $item): 
                                        if($item->current_stock <= $item->minimum_stock_level && $shown < 10):
                                            $shown++;
                                            $urgency = $item->current_stock == 0 ? 'danger' : ($item->current_stock <= ($item->minimum_stock_level * 0.5) ? 'warning' : 'info');
                                            $urgencyText = $item->current_stock == 0 ? 'Out of Stock' : ($item->current_stock <= ($item->minimum_stock_level * 0.5) ? 'Critical' : 'Low Stock');
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="fw-medium"><?php echo $item->item_code; ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-medium"><?php echo $item->name; ?></div>
                                                    <?php if($item->description): ?>
                                                        <small class="text-muted"><?php echo substr($item->description, 0, 50); ?>...</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary"><?php echo $item->category_name; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge bg-<?php echo $urgency; ?> mb-1"><?php echo $item->current_stock; ?> <?php echo $item->unit_of_measure; ?></span>
                                                    <div class="progress-modern w-100" style="max-width: 80px;">
                                                        <div class="progress-bar bg-<?php echo $urgency; ?>" style="width: <?php echo ($item->current_stock / max($item->minimum_stock_level, 1)) * 100; ?>%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted"><?php echo $item->minimum_stock_level; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-<?php echo $urgency; ?>-subtle text-<?php echo $urgency; ?> alert-badge">
                                                    <i class="fas fa-exclamation-triangle me-1"></i><?php echo $urgencyText; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo base_url('inventory/purchases?item_id='.$item->id); ?>" class="btn btn-success btn-sm" title="Restock">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                    <a href="<?php echo base_url('inventory/items?edit='.$item->id); ?>" class="btn btn-info btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-warning btn-sm" title="Set Alert" onclick="setCustomAlert(<?php echo $item->id; ?>)">
                                                        <i class="fas fa-bell"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    if($shown == 0):
                                    ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="text-success">
                                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                                    <h5 class="text-success">All Items Well Stocked!</h5>
                                                    <p class="text-muted">All inventory items have adequate stock levels.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="text-center">
                <div class="spinner mb-3"></div>
                <h6 class="text-muted">Refreshing dashboard...</h6>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    // Initialize counter animations
    $('.counter').each(function() {
        const $this = $(this);
        const target = parseInt($this.data('target')) || parseInt($this.text().replace(/[^0-9]/g, ''));
        
        $({ counter: 0 }).animate({ counter: target }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                if ($this.text().includes('$')) {
                    $this.text('$' + Math.ceil(this.counter).toLocaleString());
                } else {
                    $this.text(Math.ceil(this.counter));
                }
            },
            complete: function() {
                if ($this.text().includes('$')) {
                    $this.text('$' + target.toLocaleString());
                } else {
                    $this.text(target);
                }
            }
        });
    });

    // Enhanced Category Distribution Chart
    var categoryData = {
        labels: [
            <?php foreach($category_distribution as $cat): ?>
                '<?php echo $cat['category']; ?>',
            <?php endforeach; ?>
        ],
        datasets: [{
            data: [
                <?php foreach($category_distribution as $cat): ?>
                    <?php echo $cat['total_stock']; ?>,
                <?php endforeach; ?>
            ],
            backgroundColor: [
                '#4f46e5', '#10b981', '#06b6d4', '#f59e0b', '#ef4444', '#8b5cf6', '#f97316', '#84cc16'
            ],
            borderWidth: 0,
            hoverBorderWidth: 3,
            hoverBorderColor: '#ffffff'
        }]
    };
    
    var categoryCtx = document.getElementById('category-chart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: categoryData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#4f46e5',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} items (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000
            }
        }
    });
    
    // Enhanced Stock Status Chart
    var normalStock = 0;
    var lowStock = 0;
    var outOfStock = 0;
    
    <?php foreach($inventory_items as $item): ?>
        <?php if($item->current_stock == 0): ?>
            outOfStock++;
        <?php elseif($item->current_stock <= $item->minimum_stock_level): ?>
            lowStock++;
        <?php else: ?>
            normalStock++;
        <?php endif; ?>
    <?php endforeach; ?>
    
    var stockStatusData = {
        labels: ['Normal Stock', 'Low Stock', 'Out of Stock'],
        datasets: [{
            data: [normalStock, lowStock, outOfStock],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0,
            hoverBorderWidth: 3,
            hoverBorderColor: '#ffffff'
        }]
    };
    
    var stockStatusCtx = document.getElementById('stock-status-chart').getContext('2d');
    var stockStatusChart = new Chart(stockStatusCtx, {
        type: 'pie',
        data: stockStatusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} items (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000
            }
        }
    });

    // Dashboard refresh functionality
    $('#refreshDashboard').click(function() {
        $('#loadingOverlay').show();
        setTimeout(function() {
            location.reload();
        }, 1000);
    });

    // Stock chart refresh
    $('#refreshStockChart').click(function() {
        stockStatusChart.update('active');
        $(this).find('i').addClass('fa-spin');
        setTimeout(function() {
            $('#refreshStockChart i').removeClass('fa-spin');
        }, 1000);
    });

    // Export low stock functionality
    $('#exportLowStock').click(function() {
        // Create CSV content
        let csvContent = "Item Code,Name,Category,Current Stock,Min Level,Status\n";
        
        $('#lowStockTable tbody tr').each(function() {
            if ($(this).find('td').length > 1) {
                const row = [];
                $(this).find('td').each(function(index) {
                    if (index < 6) { // Exclude actions column
                        let text = $(this).text().trim().replace(/\n/g, ' ').replace(/,/g, ';');
                        row.push(text);
                    }
                });
                csvContent += row.join(',') + '\n';
            }
        });
        
        // Download CSV
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'low_stock_items_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    });

    // Initialize tooltips
    $('[title]').tooltip();

    // Add smooth scrolling for internal links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        const target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
});

// Custom alert function
function setCustomAlert(itemId) {
    // This would open a modal to set custom alert levels
    alert('Custom alert functionality would be implemented here for item ID: ' + itemId);
}

// Auto-refresh dashboard every 5 minutes
setInterval(function() {
    if (document.visibilityState === 'visible') {
        // Only refresh if page is visible
        $.get(window.location.href)
            .done(function(data) {
                // Update counters only
                const newDoc = $(data);
                $('.counter').each(function() {
                    const newValue = newDoc.find('#' + $(this).parent().attr('id') + ' .counter').data('target');
                    if (newValue && newValue !== $(this).data('target')) {
                        $(this).data('target', newValue);
                        // Animate to new value
                        $(this).prop('counter', parseInt($(this).text().replace(/[^0-9]/g, '')))
                            .animate({ counter: newValue }, {
                                duration: 1000,
                                step: function() {
                                    $(this).text(Math.ceil(this.counter));
                                }
                            });
                    }
                });
            });
    }
}, 300000); // 5 minutes
</script> 