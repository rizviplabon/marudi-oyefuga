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
                        <h4 class="mb-1 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $page_title; ?>
                        </h4>
                        <p class="text-muted mb-0">Monitor and manage inventory stock alerts and warnings</p>
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

        <!-- Alert Summary Cards Section -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-times-circle fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php 
                                    $out_of_stock = 0;
                                    foreach ($alerts as $alert) {
                                        if ($alert->alert_type == 'out_of_stock') {
                                            $out_of_stock++;
                                        }
                                    }
                                    echo number_format($out_of_stock);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Out of Stock</p>
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
                                    $low_stock = 0;
                                    foreach ($alerts as $alert) {
                                        if ($alert->alert_type == 'low_stock') {
                                            $low_stock++;
                                        }
                                    }
                                    echo number_format($low_stock);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Low Stock</p>
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
                                        <i class="fas fa-clock fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php 
                                    $unread_alerts = 0;
                                    foreach ($alerts as $alert) {
                                        if ($alert->is_read == 0) {
                                            $unread_alerts++;
                                        }
                                    }
                                    echo number_format($unread_alerts);
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Unread Alerts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-bell fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white">
                                    <?php echo count($alerts); ?>
                                </h5>
                                <p class="text-white-75 mb-0">Total Alerts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Alerts Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-danger">
                                    <i class="fas fa-bell me-2"></i>Stock Alerts Dashboard
                                </h5>
                                <p class="text-muted mb-0">Monitor critical inventory levels and take immediate action</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success btn-sm" id="markAllRead">
                                    <i class="fas fa-check-double me-1"></i>Mark All Read
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="refreshAlerts">
                                    <i class="fas fa-sync-alt me-1"></i>Refresh
                                </button>
                                <a href="<?php echo base_url('inventory/items'); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-cubes me-1"></i>Manage Items
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <!-- Alert Filters -->
                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <div class="card border border-danger border-opacity-25 bg-light">
                                    <div class="card-body py-3">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-filter me-1 text-danger"></i>Alert Type
                                                </label>
                                                <select id="alertTypeFilter" class="form-select">
                                                    <option value="">🚨 All Alerts</option>
                                                    <option value="out_of_stock">❌ Out of Stock</option>
                                                    <option value="low_stock">⚠️ Low Stock</option>
                                                    <option value="expiry">📅 Expiry Warning</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-eye me-1 text-danger"></i>Status
                                                </label>
                                                <select id="statusFilter" class="form-select">
                                                    <option value="">📊 All Status</option>
                                                    <option value="unread">🔔 Unread</option>
                                                    <option value="read">✅ Read</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-sort me-1 text-danger"></i>Priority
                                                </label>
                                                <select id="priorityFilter" class="form-select">
                                                    <option value="">🎯 All Priority</option>
                                                    <option value="critical">🔴 Critical</option>
                                                    <option value="high">🟠 High</option>
                                                    <option value="medium">🟡 Medium</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-secondary w-100" id="clearFilters">
                                                    <i class="fas fa-undo me-1"></i>Clear Filters
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex gap-2 h-100 align-items-end">
                                    <button type="button" class="btn btn-success flex-fill" id="exportAlerts">
                                        <i class="fas fa-file-excel me-1"></i>Export Excel
                                    </button>
                                    <button type="button" class="btn btn-info flex-fill" id="printAlerts">
                                        <i class="fas fa-print me-1"></i>Print Report
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Alerts Table -->
                        <div class="table-responsive">
                            <table id="alerts-table" class="table table-hover align-middle">
                                <thead class="table-danger">
                                    <tr>
                                        <th class="fw-bold"><i class="fas fa-tag me-1"></i>Item</th>
                                        <th class="fw-bold"><i class="fas fa-cubes me-1"></i>Current Stock</th>
                                        <th class="fw-bold"><i class="fas fa-level-down-alt me-1"></i>Min Level</th>
                                        <th class="fw-bold"><i class="fas fa-exclamation-triangle me-1"></i>Alert Type</th>
                                        <th class="fw-bold"><i class="fas fa-clock me-1"></i>Generated</th>
                                        <th class="fw-bold"><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th class="fw-bold"><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alerts as $alert) { ?>
                                        <tr class="<?php echo ($alert->is_read == 0) ? 'table-warning' : ''; ?>" data-alert-type="<?php echo $alert->alert_type; ?>" data-status="<?php echo ($alert->is_read == 0) ? 'unread' : 'read'; ?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <?php if ($alert->alert_type == 'out_of_stock') { ?>
                                                            <div class="avatar-xs rounded-circle bg-danger">
                                                                <span class="avatar-title rounded-circle">
                                                                    <i class="fas fa-times text-white"></i>
                                                                </span>
                                                            </div>
                                                        <?php } elseif ($alert->alert_type == 'low_stock') { ?>
                                                            <div class="avatar-xs rounded-circle bg-warning">
                                                                <span class="avatar-title rounded-circle">
                                                                    <i class="fas fa-exclamation text-white"></i>
                                                                </span>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="avatar-xs rounded-circle bg-info">
                                                                <span class="avatar-title rounded-circle">
                                                                    <i class="fas fa-clock text-white"></i>
                                                                </span>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold"><?php echo $alert->item_name; ?></div>
                                                        <small class="text-muted"><?php echo $alert->item_code; ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($alert->current_stock <= 0) { ?>
                                                        <span class="badge bg-danger fs-6 me-2">0</span>
                                                        <small class="text-danger fw-semibold">EMPTY</small>
                                                    <?php } else { ?>
                                                        <span class="badge bg-warning text-dark fs-6 me-2"><?php echo number_format($alert->current_stock); ?></span>
                                                        <small class="text-muted"><?php echo $alert->unit_of_measure; ?></small>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted"><?php echo number_format($alert->minimum_stock_level); ?></span>
                                            </td>
                                            <td>
                                                <?php if ($alert->alert_type == 'low_stock') { ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>Low Stock
                                                    </span>
                                                <?php } elseif ($alert->alert_type == 'out_of_stock') { ?>
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Out of Stock
                                                    </span>
                                                <?php } elseif ($alert->alert_type == 'expiry') { ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-calendar-times me-1"></i>Expiry Warning
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="fw-semibold"><?php echo date('M d, Y', strtotime($alert->created_at)); ?></div>
                                                <small class="text-muted"><?php echo date('h:i A', strtotime($alert->created_at)); ?></small>
                                            </td>
                                            <td>
                                                <?php if ($alert->is_read == 0) { ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-bell me-1"></i>Unread
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Read
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo base_url('inventory/editItem/' . $alert->item_id); ?>" class="btn btn-outline-primary btn-sm" title="Edit Item">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-outline-success btn-sm mark-read" data-id="<?php echo $alert->id; ?>" <?php echo ($alert->is_read == 1) ? 'disabled' : ''; ?> title="Mark as Read">
                                                        <i class="fas fa-check"></i>
                                                </button>
                                                    <a href="<?php echo base_url('inventory/addPurchase?item_id=' . $alert->item_id); ?>" class="btn btn-outline-info btn-sm" title="Add Stock">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
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

<!-- Enhanced Custom Styles -->
<style>
.bg-gradient-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #54a0ff 0%, #2e86de 100%);
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
    background-color: rgba(220,53,69,0.05);
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.avatar-sm {
    height: 3rem;
    width: 3rem;
}

.avatar-xs {
    height: 1.5rem;
    width: 1.5rem;
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
.me-3 { margin-right: 1rem !important; }
.ms-3 { margin-left: 1rem !important; }

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 2px;
    }
}

/* Pulse animation for unread alerts */
.table-warning td:first-child .avatar-xs {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}
</style>

<!-- Enhanced JavaScript -->
<script>
    $(document).ready(function() {
        // Enhanced DataTables configuration
        const alertsTable = $('#alerts-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 25,
            order: [[4, 'desc'], [3, 'desc']], // Sort by date then alert type
            language: {
                search: "<span class='small text-muted'></span> _INPUT_",
                searchPlaceholder: "Search alerts...",
                lengthMenu: "<span class='small text-muted'> _MENU_ </span>",
                info: "<b>_START_</b> to <b>_END_</b> of <b>_TOTAL_</b> alerts",
                infoEmpty: "No alerts found",
                infoFiltered: "(filtered from _MAX_ total alerts)",
                paginate: {
                    first: "<i class='fas fa-angle-double-left'></i>",
                    last: "<i class='fas fa-angle-double-right'></i>",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                },
                processing: "<div class='d-flex justify-content-center'><div class='spinner-border text-danger' role='status'><span class='sr-only'>Loading...</span></div></div>"
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
                    text: '<i class="fas fa-file-csv me-1"></i>CSV',
                    title: 'Inventory Stock Alerts'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-success btn-sm me-1',
                    text: '<i class="fas fa-file-excel me-1"></i>Excel',
                    title: 'Inventory Stock Alerts'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-danger btn-sm me-1',
                    text: '<i class="fas fa-file-pdf me-1"></i>PDF',
                    title: 'Inventory Stock Alerts'
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-info btn-sm',
                    text: '<i class="fas fa-print me-1"></i>Print',
                    title: 'Inventory Stock Alerts'
                }
            ],
            columnDefs: [
                {
                    targets: [1, 2], // Stock columns
                    className: 'text-center'
                },
                {
                    targets: [3, 5], // Alert type and status columns
                    className: 'text-center'
                },
                {
                    targets: [6], // Actions column
                    orderable: false,
                    className: 'text-center'
                }
            ]
        });
        
        // Custom filtering
        $('#alertTypeFilter').on('change', function() {
            const value = $(this).val();
            if (value) {
                alertsTable.column(3).search(value).draw();
            } else {
                alertsTable.column(3).search('').draw();
            }
        });

        $('#statusFilter').on('change', function() {
            const value = $(this).val();
            if (value === 'unread') {
                alertsTable.rows().every(function() {
                    const row = this.node();
                    if ($(row).hasClass('table-warning')) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });
            } else if (value === 'read') {
                alertsTable.rows().every(function() {
                    const row = this.node();
                    if (!$(row).hasClass('table-warning')) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });
            } else {
                alertsTable.rows().every(function() {
                    $(this.node()).show();
                });
            }
            alertsTable.draw();
        });

        $('#clearFilters').on('click', function() {
            $('#alertTypeFilter, #statusFilter, #priorityFilter').val('');
            alertsTable.search('').columns().search('').draw();
            alertsTable.rows().every(function() {
                $(this.node()).show();
            });
            alertsTable.draw();
        });

        // Export and Print Functions
        $('#exportAlerts').click(function() {
            alertsTable.button('.buttons-excel').trigger();
        });

        $('#printAlerts').click(function() {
            alertsTable.button('.buttons-print').trigger();
        });

        // Refresh alerts
        $('#refreshAlerts').click(function() {
            location.reload();
        });
        
        // Mark single alert as read
        $('.mark-read').on('click', function() {
            const alertId = $(this).data('id');
            const button = $(this);
            const row = button.closest('tr');
            
            // Show loading state
            button.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
            
            $.ajax({
                url: '<?php echo base_url("inventory/markAlertRead/"); ?>' + alertId,
                type: 'GET',
                success: function(response) {
                    // Update UI
                    button.html('<i class="fas fa-check"></i>').prop('disabled', true);
                    row.removeClass('table-warning');
                    row.find('td:nth-child(6) span').removeClass('bg-warning').addClass('bg-success')
                       .html('<i class="fas fa-check-circle me-1"></i>Read');
                    
                    // Update counter
                    const currentUnread = parseInt($('.bg-gradient-info h5').text());
                    $('.bg-gradient-info h5').text(currentUnread - 1);
                    
                    // Show success message
                    showNotification('Alert marked as read successfully!', 'success');
                },
                error: function() {
                    button.html('<i class="fas fa-check"></i>').prop('disabled', false);
                    showNotification('Failed to mark alert as read. Please try again.', 'error');
                }
            });
        });

        // Mark all alerts as read
        $('#markAllRead').on('click', function() {
            if (confirm('Are you sure you want to mark all alerts as read?')) {
                const button = $(this);
                button.html('<i class="fas fa-spinner fa-spin me-1"></i>Processing...').prop('disabled', true);
                
                // This would need a backend endpoint to mark all as read
                setTimeout(function() {
                    $('.table-warning').removeClass('table-warning');
                    $('.mark-read').prop('disabled', true);
                    $('.bg-gradient-info h5').text('0');
                    button.html('<i class="fas fa-check-double me-1"></i>Mark All Read').prop('disabled', false);
                    showNotification('All alerts marked as read!', 'success');
                }, 1000);
            }
        });

        // Animate numbers on page load
        $('.card-body h5').each(function() {
            const $this = $(this);
            const text = $this.text();
            if (text.match(/\d+/)) {
                $this.prop('Counter', 0).animate({
                    Counter: parseInt(text)
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function(now) {
                        $this.text(Math.ceil(now));
                    }
                });
            }
        });

        // Notification function
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show border-0 shadow-sm position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(function() {
                notification.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }

        // Tooltips for better UX
        $('[title]').tooltip();
    });
</script> 