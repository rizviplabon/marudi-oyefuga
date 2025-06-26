<!-- Main content -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Laboratory Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active">Laboratory</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
                                <div class="mb-3 mb-sm-0">
                                    <h5 class="text-white mb-1">Welcome back, <?php 
                                        // Get user details more reliably
                                        $user_id = $this->ion_auth->get_user_id();
                                        $user_details = $this->db->get_where('users', array('id' => $user_id))->row();
                                        
                                        // Try to get laboratorist details first
                                        $laboratorist = $this->db->get_where('laboratorist', array('ion_user_id' => $user_id))->row();
                                        
                                        if ($laboratorist && !empty($laboratorist->name)) {
                                            echo htmlspecialchars($laboratorist->name);
                                        } elseif ($user_details && !empty($user_details->first_name)) {
                                            echo htmlspecialchars($user_details->first_name);
                                        } elseif ($user_details && !empty($user_details->username)) {
                                            echo htmlspecialchars($user_details->username);
                                        } else {
                                            echo 'User';
                                        }
                                    ?>!</h5>
                                    <p class="text-white-50 mb-0">Here's your laboratory overview for today</p>
                                </div>
                                <div class="text-center">
                                    <div class="avatar-lg">
                                        <span class="avatar-title rounded-circle bg-white bg-opacity-10">
                                            <i class="mdi mdi-microscope font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lab Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Pending Tests</p>
                                    <h4 class="mb-0"><?php echo $lab_stats['pending_tests']; ?></h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-warning font-size-11">
                                            <i class="mdi mdi-clock-outline"></i> Awaiting
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-test-tube font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Completed Today</p>
                                    <h4 class="mb-0"><?php echo $lab_stats['completed_today']; ?></h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-success font-size-11">
                                            <i class="mdi mdi-check-circle"></i> Done
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-check-circle font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Specimens Today</p>
                                    <h4 class="mb-0"><?php echo $lab_stats['specimens_today']; ?></h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-info font-size-11">
                                            <i class="mdi mdi-flask"></i> Collected
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-info">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-flask font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Awaiting Verification</p>
                                    <h4 class="mb-0"><?php echo $lab_stats['awaiting_verification']; ?></h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-warning font-size-11">
                                            <i class="mdi mdi-shield-check"></i> Review
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-shield-check font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Total Inventory Value</p>
                                    <h4 class="mb-0"><?php echo $settings->currency; ?> <?php echo number_format($inventory_stats['total_value'], 2); ?></h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-success font-size-11">
                                            <i class="mdi mdi-trending-up"></i> Active
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-currency-usd font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Low Stock Items</p>
                                    <h4 class="mb-0 <?php echo $inventory_stats['low_stock_count'] > 0 ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $inventory_stats['low_stock_count']; ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-<?php echo $inventory_stats['low_stock_count'] > 0 ? 'danger' : 'success'; ?> font-size-11">
                                            <i class="mdi mdi-package-variant"></i> Items
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-<?php echo $inventory_stats['low_stock_count'] > 0 ? 'danger' : 'success'; ?>">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-package-variant font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Unread Alerts</p>
                                    <h4 class="mb-0 <?php echo $inventory_stats['unread_alerts'] > 0 ? 'text-warning' : 'text-success'; ?>">
                                        <?php echo $inventory_stats['unread_alerts']; ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-<?php echo $inventory_stats['unread_alerts'] > 0 ? 'warning' : 'success'; ?> font-size-11">
                                            <i class="mdi mdi-bell"></i> Alerts
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-<?php echo $inventory_stats['unread_alerts'] > 0 ? 'warning' : 'success'; ?>">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-bell font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Expiring Soon</p>
                                    <h4 class="mb-0 <?php echo $inventory_stats['expiring_soon'] > 0 ? 'text-warning' : 'text-success'; ?>">
                                        <?php echo $inventory_stats['expiring_soon']; ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <span class="badge badge-soft-<?php echo $inventory_stats['expiring_soon'] > 0 ? 'warning' : 'success'; ?> font-size-11">
                                            <i class="mdi mdi-clock-outline"></i> Items
                                        </span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-<?php echo $inventory_stats['expiring_soon'] > 0 ? 'warning' : 'success'; ?>">
                                        <span class="avatar-title">
                                            <i class="mdi mdi-clock-outline font-size-16 text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Quick Actions</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('labworkflow/writeReport'); ?>" class="btn btn-primary w-100 btn-action">
                                        <i class="mdi mdi-pencil me-2"></i>
                                        <span class="d-none d-sm-inline">Write Lab Report</span>
                                        <span class="d-sm-none">Write Report</span>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('labworkflow/labTests'); ?>" class="btn btn-info w-100 btn-action">
                                        <i class="mdi mdi-test-tube me-2"></i>
                                        <span class="d-none d-sm-inline">View Lab Tests</span>
                                        <span class="d-sm-none">Lab Tests</span>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('labworkflow/specimens'); ?>" class="btn btn-success w-100 btn-action">
                                        <i class="mdi mdi-flask me-2"></i>
                                        <span class="d-none d-sm-inline">Manage Specimens</span>
                                        <span class="d-sm-none">Specimens</span>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('inventory/items'); ?>" class="btn btn-warning w-100 btn-action">
                                        <i class="mdi mdi-package-variant me-2"></i>
                                        <span class="d-none d-sm-inline">Inventory Items</span>
                                        <span class="d-sm-none">Inventory</span>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('inventory/usage'); ?>" class="btn btn-secondary w-100 btn-action">
                                        <i class="mdi mdi-minus me-2"></i>
                                        <span class="d-none d-sm-inline">Record Usage</span>
                                        <span class="d-sm-none">Usage</span>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                    <a href="<?php echo base_url('labworkflow/qualityControl'); ?>" class="btn btn-dark w-100 btn-action">
                                        <i class="mdi mdi-shield-check me-2"></i>
                                        <span class="d-none d-sm-inline">Quality Control</span>
                                        <span class="d-sm-none">QC</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row mb-4">
                <!-- Recent Lab Tests -->
                <div class="col-xl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                            <h4 class="card-title mb-2 mb-sm-0">Recent Lab Tests</h4>
                            <a href="<?php echo base_url('labworkflow/labTests'); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye me-1"></i>View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_lab_tests)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="d-none d-md-table-cell">Patient</th>
                                            <th>Test</th>
                                            <th class="d-none d-lg-table-cell">Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($recent_lab_tests, 0, 5) as $test): ?>
                                        <tr>
                                            <td class="d-none d-md-table-cell">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs me-2">
                                                        <span class="avatar-title rounded-circle bg-primary text-white font-size-12">
                                                            <?php 
                                                            $display_name = !empty($test->patient_name) ? $test->patient_name : 'Patient';
                                                            echo strtoupper(substr($display_name, 0, 1)); 
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <div class="text-truncate" style="max-width: 120px;">
                                                        <div class="font-size-13 fw-medium">
                                                            <?php echo !empty($test->patient_name) ? htmlspecialchars($test->patient_name) : 'Unknown Patient'; ?>
                                                        </div>
                                                        <div class="font-size-11 text-muted">
                                                            ID: <?php echo htmlspecialchars($test->patient_id); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 font-size-13"><?php echo htmlspecialchars($test->test_name); ?></h6>
                                                    <p class="text-muted mb-0 font-size-11 d-md-none">
                                                        <?php 
                                                        $patient_display = !empty($test->patient_name) ? htmlspecialchars($test->patient_name) : 'Unknown Patient';
                                                        echo $patient_display . ' (ID: ' . htmlspecialchars($test->patient_id) . ')';
                                                        ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="d-none d-lg-table-cell">
                                                <span class="font-size-12 text-muted">
                                                    <?php echo date('M d, Y', $test->date); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $status_class = '';
                                                $status_text = '';
                                                $status_to_check = isset($test->actual_status) ? $test->actual_status : $test->test_status;
                                                switch($status_to_check) {
                                                    case 'not_done':
                                                        $status_class = 'warning';
                                                        $status_text = 'Pending';
                                                        break;
                                                    case 'completed':
                                                        $status_class = 'success';
                                                        $status_text = 'Completed';
                                                        break;
                                                    case 'done_no_results':
                                                    case 'done':
                                                        $status_class = 'warning';
                                                        $status_text = 'Pending';
                                                        break;
                                                    case 'pending':
                                                        $status_class = 'warning';
                                                        $status_text = 'Pending';
                                                        break;
                                                    default:
                                                        $status_class = 'secondary';
                                                        $status_text = 'Unknown';
                                                }
                                                ?>
                                                <span class="badge badge-soft-<?php echo $status_class; ?> font-size-11">
                                                    <?php echo $status_text; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $status_to_check = isset($test->actual_status) ? $test->actual_status : $test->test_status;
                                                if ($status_to_check == 'not_done' || $status_to_check == 'pending'): ?>
                                                <a href="<?php echo base_url('labworkflow/writeReport/' . $test->invoice_id); ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Write Report">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <?php elseif ($status_to_check == 'done_no_results' || $status_to_check == 'done'): ?>
                                                <a href="<?php echo base_url('labworkflow/writeReport/' . $test->invoice_id); ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Add Results">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <?php else: ?>
                                                <a href="<?php echo base_url('labworkflow/generateTestPdf/' . $test->id); ?>" 
                                                   class="btn btn-sm btn-outline-success" title="Download Report">
                                                    <i class="mdi mdi-download"></i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-light text-muted">
                                        <i class="mdi mdi-test-tube font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted mb-0">No recent lab tests found</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Stock Alerts -->
                <div class="col-xl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                            <h4 class="card-title mb-2 mb-sm-0">Stock Alerts</h4>
                            <a href="<?php echo base_url('inventory/alerts'); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye me-1"></i>View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($stock_alerts)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Alert</th>
                                            <th class="d-none d-md-table-cell">Level</th>
                                            <th class="d-none d-lg-table-cell">Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($stock_alerts, 0, 5) as $alert): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 font-size-13"><?php echo ucfirst(str_replace('_', ' ', $alert->alert_type)); ?></h6>
                                                    <p class="text-muted mb-0 font-size-11 text-truncate" style="max-width: 150px;">
                                                        <?php echo htmlspecialchars($alert->message); ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <?php
                                                $level_class = '';
                                                switch($alert->alert_level) {
                                                    case 'critical': $level_class = 'danger'; break;
                                                    case 'high': $level_class = 'warning'; break;
                                                    case 'medium': $level_class = 'info'; break;
                                                    default: $level_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-soft-<?php echo $level_class; ?> font-size-11">
                                                    <?php echo ucfirst($alert->alert_level); ?>
                                                </span>
                                            </td>
                                            <td class="d-none d-lg-table-cell">
                                                <span class="font-size-12 text-muted">
                                                    <?php echo date('M d', strtotime($alert->created_at)); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="<?php echo base_url('inventory/items'); ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="View Item">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-success" 
                                                            onclick="markAlertRead(<?php echo $alert->id; ?>)" title="Mark as Read">
                                                        <i class="mdi mdi-check"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-light text-success">
                                        <i class="mdi mdi-shield-check font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted mb-0">No stock alerts at this time</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Specimens and Inventory Usage -->
            <div class="row">
                <!-- Recent Specimens -->
                <div class="col-xl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                            <h4 class="card-title mb-2 mb-sm-0">Recent Specimens</h4>
                            <a href="<?php echo base_url('labworkflow/specimens'); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye me-1"></i>View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_specimens)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Specimen ID</th>
                                            <th class="d-none d-md-table-cell">Type</th>
                                            <th class="d-none d-lg-table-cell">Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_specimens as $specimen): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 font-size-13"><?php echo htmlspecialchars($specimen->specimen_id); ?></h6>
                                                    <p class="text-muted mb-0 font-size-11 d-md-none">
                                                        <?php echo htmlspecialchars($specimen->type ?? 'Unknown'); ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <span class="font-size-12">
                                                    <?php echo htmlspecialchars($specimen->type ?? 'Unknown'); ?>
                                                </span>
                                            </td>
                                            <td class="d-none d-lg-table-cell">
                                                <span class="font-size-12 text-muted">
                                                    <?php echo isset($specimen->collection_date) ? date('M d', strtotime($specimen->collection_date)) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $status = $specimen->status ?? 'unknown';
                                                $status_class = '';
                                                switch($status) {
                                                    case 'collected': $status_class = 'info'; break;
                                                    case 'received': $status_class = 'primary'; break;
                                                    case 'processing': $status_class = 'warning'; break;
                                                    case 'completed': $status_class = 'success'; break;
                                                    case 'rejected': $status_class = 'danger'; break;
                                                    default: $status_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-soft-<?php echo $status_class; ?> font-size-11">
                                                    <?php echo ucfirst($status); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-light text-muted">
                                        <i class="mdi mdi-flask font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted mb-0">No recent specimens found</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Inventory Usage -->
                <div class="col-xl-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                            <h4 class="card-title mb-2 mb-sm-0">Recent Inventory Usage</h4>
                            <a href="<?php echo base_url('inventory/usage'); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye me-1"></i>View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_inventory_usage)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="d-none d-md-table-cell">Quantity</th>
                                            <th class="d-none d-lg-table-cell">Date</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_inventory_usage as $usage): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 font-size-13"><?php echo htmlspecialchars($usage->item_name ?? 'Unknown Item'); ?></h6>
                                                    <p class="text-muted mb-0 font-size-11 d-md-none">
                                                        Qty: <?php echo $usage->quantity_used ?? 0; ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <span class="font-size-12 fw-medium">
                                                    <?php echo $usage->quantity_used ?? 0; ?>
                                                </span>
                                            </td>
                                            <td class="d-none d-lg-table-cell">
                                                <span class="font-size-12 text-muted">
                                                    <?php echo isset($usage->usage_date) ? date('M d', strtotime($usage->usage_date)) : 'N/A'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $usage_type = $usage->usage_type ?? 'other';
                                                $type_class = '';
                                                switch($usage_type) {
                                                    case 'lab_test': $type_class = 'primary'; break;
                                                    case 'service': $type_class = 'info'; break;
                                                    case 'maintenance': $type_class = 'warning'; break;
                                                    case 'waste': $type_class = 'danger'; break;
                                                    default: $type_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-soft-<?php echo $type_class; ?> font-size-11">
                                                    <?php echo ucfirst(str_replace('_', ' ', $usage_type)); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-light text-muted">
                                        <i class="mdi mdi-minus font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted mb-0">No recent inventory usage found</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Interactions -->
<script>
// Mark alert as read
function markAlertRead(alertId) {
    if (confirm('Mark this alert as read?')) {
        fetch('<?php echo base_url('inventory/markAlertRead'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'alert_id=' + alertId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error marking alert as read');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error marking alert as read');
        });
    }
}

// Auto-refresh every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);

// Tooltip initialization
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
/* Custom responsive styles */
.mini-stats-wid {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.mini-stats-wid:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.mini-stat-icon {
    width: 3rem;
    height: 3rem;
}

.btn-action {
    min-height: 2.5rem;
    transition: all 0.2s ease-in-out;
}

.btn-action:hover {
    transform: translateY(-1px);
}

.avatar-xs {
    width: 1.5rem;
    height: 1.5rem;
}

.avatar-sm {
    width: 2.25rem;
    height: 2.25rem;
}

.avatar-lg {
    width: 4rem;
    height: 4rem;
}

.table-responsive {
    border-radius: 0.375rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.badge {
    font-weight: 500;
}

/* Mobile optimizations */
@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn-action {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    
    .mini-stats-wid .card-body {
        padding: 1rem;
    }
    
    .table-sm th,
    .table-sm td {
        padding: 0.5rem 0.25rem;
    }
}

/* Tablet optimizations */
@media (min-width: 577px) and (max-width: 768px) {
    .card-header {
        padding: 1.25rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
}

/* Loading animation */
.card {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Print styles */
@media print {
    .btn, .card-header a {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #dee2e6;
    }
}
</style>
