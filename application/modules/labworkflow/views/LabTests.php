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
                            <i class="fas fa-flask text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-primary"><?php echo lang('all') . " " . lang('lab_tests'); ?></h4>
                            <p class="text-muted mb-0">Comprehensive lab test management and status tracking</p>
                                </div>
                                </div>
                    <div class="page-title-right">
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="refreshTests">
                                <i class="fas fa-sync-alt me-1"></i>Refresh
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-plus me-1"></i>Quick Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo base_url('labworkflow/addLabTest'); ?>"><i class="fas fa-flask me-2"></i>Order Test</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('labworkflow/specimens'); ?>"><i class="fas fa-vial me-2"></i>Manage Specimens</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('labworkflow/testTemplates'); ?>"><i class="fas fa-clipboard-list me-2"></i>Test Templates</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('labworkflow/reports'); ?>"><i class="fas fa-chart-bar me-2"></i>Reports</a></li>
                                </ul>
                            </div>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 bg-transparent">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('home'); ?>" class="text-primary">
                                        <i class="fas fa-home"></i> <?php echo lang('home'); ?>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('labworkflow'); ?>" class="text-primary">
                                        <i class="fas fa-microscope"></i> <?php echo lang('lab'); ?>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-dark fw-medium">
                                    <i class="fas fa-flask"></i> <?php echo lang('lab_tests'); ?>
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

            .enhanced-card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 4px 25px rgba(0,0,0,0.08);
                background: linear-gradient(135deg, var(--white) 0%, #fafafa 100%);
                transition: all 0.3s ease;
            }

            .enhanced-card:hover {
                box-shadow: 0 8px 35px rgba(0,0,0,0.12);
            }

            .filter-card {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border: 1px solid var(--gray-200);
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .status-badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .status-badge.pending {
                background: linear-gradient(135deg, #fef3c7, #fde68a);
                color: #92400e;
                border-color: #f59e0b;
            }

            .status-badge.in-progress {
                background: linear-gradient(135deg, #dbeafe, #bfdbfe);
                color: #1e40af;
                border-color: #3b82f6;
            }

            .status-badge.completed {
                background: linear-gradient(135deg, #d1fae5, #a7f3d0);
                color: #065f46;
                border-color: #10b981;
            }

            .status-badge.critical {
                background: linear-gradient(135deg, #fee2e2, #fecaca);
                color: #991b1b;
                border-color: #ef4444;
                animation: pulse 2s infinite;
            }

            .status-badge.abnormal {
                background: linear-gradient(135deg, #fed7aa, #fdba74);
                color: #9a3412;
                border-color: #f97316;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }

            .test-status-dropdown {
                border-radius: 8px;
                border: 2px solid var(--gray-300);
                padding: 6px 12px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .test-status-dropdown:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .modern-table {
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 4px 25px rgba(0,0,0,0.08);
                background: var(--white);
            }

            .modern-table thead th {
                background: linear-gradient(135deg, var(--primary), #6366f1) !important;
                color: white !important;
                border: none !important;
                font-weight: 600 !important;
                padding: 15px !important;
                text-align: center !important;
                font-size: 0.875rem !important;
            }
            
            .modern-table thead th i {
                color: white !important;
            }
            
            .modern-table thead th .fw-bold {
                color: white !important;
                font-weight: 600 !important;
            }

            .modern-table tbody td {
                padding: 12px;
                vertical-align: middle;
                border-bottom: 1px solid var(--gray-200);
                transition: background-color 0.2s ease;
            }

            .modern-table tbody tr:hover {
                background-color: var(--gray-100);
            }
            
            /* Override DataTables default styling */
            table.dataTable thead th,
            table.dataTable thead td {
                background: linear-gradient(135deg, var(--primary), #6366f1) !important;
                color: white !important;
                border-bottom: none !important;
            }
            
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_processing,
            .dataTables_wrapper .dataTables_paginate {
                color: var(--gray-600) !important;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                color: var(--primary) !important;
            }
            
            /* Specific styling for our table */
            #editable-sample1 thead th {
                background: linear-gradient(135deg, #4f46e5, #6366f1) !important;
                color: #ffffff !important;
                border: none !important;
                font-weight: 600 !important;
                text-align: center !important;
                vertical-align: middle !important;
                padding: 15px 10px !important;
                font-size: 0.875rem !important;
                line-height: 1.2 !important;
            }
            
            #editable-sample1 thead th i {
                color: #ffffff !important;
                margin-right: 5px !important;
            }
            
            #editable-sample1 thead th .fw-bold {
                color: #ffffff !important;
                font-weight: 600 !important;
            }

            .filter-input {
                border-radius: 10px;
                border: 2px solid var(--gray-300);
                padding: 10px 15px;
                transition: all 0.3s ease;
                background: var(--white);
            }

            .filter-input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
                background: var(--white);
            }

            .filter-btn {
                border-radius: 10px;
                padding: 10px 20px;
                font-weight: 600;
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .filter-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            }

            .action-btn {
                border-radius: 8px;
                padding: 6px 12px;
                font-weight: 500;
                border: none;
                transition: all 0.3s ease;
                margin: 0 2px;
            }

            .action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            }

            .priority-indicator {
                width: 4px;
                height: 100%;
                position: absolute;
                left: 0;
                top: 0;
                border-radius: 0 4px 4px 0;
            }

            .priority-high { background: var(--danger); }
            .priority-medium { background: var(--warning); }
            .priority-low { background: var(--success); }

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

            .info-tooltip {
                background: linear-gradient(135deg, #1e293b, #334155);
                color: white;
                padding: 8px 12px;
                border-radius: 8px;
                font-size: 0.875rem;
                max-width: 250px;
            }

            .description-alert {
                background: linear-gradient(135deg, #eff6ff, #dbeafe);
                border: 1px solid #3b82f6;
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 20px;
                position: relative;
            }

            .description-alert .close {
                position: absolute;
                top: 10px;
                right: 15px;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #3b82f6;
                cursor: pointer;
            }

            /* Invoice Grouping Styles */
            .invoice-group-header {
                background: linear-gradient(135deg, var(--primary), #6366f1) !important;
                border-radius: 8px !important;
                margin: 2px 0 !important;
                font-weight: 600 !important;
            }

            .invoice-group-header strong {
                font-size: 0.95rem;
            }

            .invoice-group-header .float-end {
                font-size: 0.85rem;
                font-weight: 500;
            }

            .test-row {
                padding-left: 20px !important;
                border-left: 3px solid var(--primary);
                margin-left: 10px;
                background: rgba(79, 70, 229, 0.05);
                padding: 8px 15px;
                border-radius: 0 8px 8px 0;
                font-weight: 500;
            }

            .test-row i {
                color: var(--primary) !important;
            }

            /* Alternate row styling for better grouping visibility */
            #editable-sample1 tbody tr:nth-child(odd) {
                background-color: #f8f9ff;
            }

            #editable-sample1 tbody tr:nth-child(even) {
                background-color: #ffffff;
            }

            /* Header row styling */
            .invoice-header-row {
                background: linear-gradient(135deg, #f0f4ff, #e0e7ff) !important;
                border-top: 2px solid var(--primary) !important;
                border-bottom: 1px solid var(--primary) !important;
            }

            .invoice-header-row td {
                font-weight: 600 !important;
                color: var(--primary) !important;
            }

            /* Toggle button styling */
            .toggle-group {
                border: 1px solid rgba(255, 255, 255, 0.3) !important;
                background: rgba(255, 255, 255, 0.1) !important;
                color: white !important;
                transition: all 0.3s ease !important;
                padding: 4px 8px !important;
                border-radius: 4px !important;
            }

            .toggle-group:hover {
                background: rgba(255, 255, 255, 0.2) !important;
                border-color: rgba(255, 255, 255, 0.5) !important;
                transform: scale(1.05);
            }

            .toggle-group:focus {
                box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3) !important;
            }

            /* Invoice info responsive styling */
            .invoice-info {
                font-size: 0.85rem;
                font-weight: 500;
            }

            @media (max-width: 768px) {
                .invoice-info {
                    font-size: 0.75rem;
                }
                
                .invoice-group-header .d-flex {
                    flex-direction: column;
                    align-items: flex-start !important;
                }
                
                .invoice-info {
                    margin-top: 5px;
                }
            }
        </style>

        <!-- Enhanced Description Alert -->
       
           
        <!-- Enhanced Filters Section -->
        <div class="filter-card">
            <div class="row align-items-end">
                        <div class="col-md-2">
                    <label class="form-label fw-medium text-dark">
                        <i class="fas fa-filter me-1"></i>Test Status
                    </label>
                    <select class="form-control filter-input status">
                                <option value="all"><?php echo lang('all'); ?></option>
                                <option value="done"><?php echo lang('done'); ?></option>
                                <option value="not_done"><?php echo lang('not_done'); ?></option>
                        <option value="pending">Pending Results</option>
                        <option value="critical">Critical Results</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                    <label class="form-label fw-medium text-dark">
                        <i class="fas fa-tags me-1"></i>Category
                    </label>
                    <select class="form-control filter-input category">
                                <option value="all"><?php echo lang('all'); ?></option>
                                <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->category; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                    <label class="form-label fw-medium text-dark">
                        <i class="fas fa-calendar-alt me-1"></i>From Date
                    </label>
                    <input type="text" class="form-control filter-input default-date-picker readonly" id="from_date" readonly placeholder="Select start date">
                        </div>
                        <div class="col-md-3">
                    <label class="form-label fw-medium text-dark">
                        <i class="fas fa-calendar-alt me-1"></i>To Date
                    </label>
                    <input type="text" class="form-control filter-input default-date-picker readonly" id="to_date" readonly placeholder="Select end date">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success filter-btn dateFilter w-100">
                        <i class="fas fa-search me-1"></i>Apply Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Lab Tests Table -->
        <section class="col-md-12">
            <div class="card enhanced-card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="fas fa-flask text-primary me-2"></i><?php echo lang('all') . " " . lang('lab_tests'); ?>
                            </h5>
                            <p class="text-muted mb-0">Manage and track all laboratory test orders and results</p>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="custom_buttons"></div>
                            <button class="btn btn-outline-secondary btn-sm" id="collapseAll">
                                <i class="fas fa-compress me-1"></i>Collapse All
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" id="expandAll">
                                <i class="fas fa-expand me-1"></i>Expand All
                            </button>
                            <button class="btn btn-outline-primary btn-sm" id="exportData">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
           
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table modern-table mb-0" id="editable-sample1">
                        <thead>
                            <tr>
                                    <th class="fw-bold">
                                        <i class="fas fa-id-card me-1"></i><?php echo lang('patient_id'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-user me-1"></i><?php echo lang('patient'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-calendar me-1"></i><?php echo lang('invoice_date_time'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i><?php echo lang('from'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-toggle-on me-1"></i><?php echo lang('status'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-credit-card me-1"></i><?php echo lang('bill_status'); ?>
                                    </th>
                                    <th class="fw-bold">
                                        <i class="fas fa-cogs me-1"></i><?php echo lang('options'); ?>
                                    </th>
                            </tr>
                        </thead>
                        <tbody>
                                <!-- Data will be loaded via DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
                                </div>
        </section>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="text-center">
                <div class="spinner mb-3"></div>
                <h6 class="text-muted">Loading lab tests...</h6>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Enhanced Done By Modal -->
<div class="modal fade" id="done_by_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2"></i>Done By Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="form-label fw-medium">
                        <i class="fas fa-user me-1"></i>Done By
                    </label>
                    <input type="text" class="form-control filter-input" id="done_by" placeholder="Enter name of person who completed the test">
                </div>
                <input type="hidden" class="form-control" id="done_by_id">
                <input type="hidden" class="form-control" id="done_by_status">
                
                <div class="alert alert-info mt-3" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> This will mark the test as completed and make it available for report generation.
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary done_by_btn">
                    <i class="fas fa-save me-1"></i>Save Changes
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var select_doctor = "<?php echo lang('select_doctor'); ?>";</script>
<script type="text/javascript">var select_patient = "<?php echo lang('select_patient'); ?>";</script>
<script src="common/extranal/js/lab/lab.js"></script>

<script>
    $(document).ready(function () {
        let status = $('.status').val();
        let category = $('.category').val();
        let fromDate = $('#from_date').val();
        let toDate = $('#to_date').val();
    
    function showLoading() {
        $('#loadingOverlay').show();
    }
    
    function hideLoading() {
        $('#loadingOverlay').hide();
    }
        
        function initializeDataTable() {
            "use strict";
        
        showLoading();
            
            // Destroy existing table if it exists
            if ($.fn.DataTable.isDataTable('#editable-sample1')) {
                $('#editable-sample1').DataTable().destroy();
            }
            
            var table = $('#editable-sample1').DataTable({
                responsive: true,
                "processing": true,
                "serverSide": true,
                "searchable": true,
                "ajax": {
                    url: "labworkflow/getLabTestStatus?status=" + status + "&category=" + category + "&from=" + fromDate + '&to=' + toDate,
                    type: 'POST',
                    error: function (xhr, error, code) {
                        console.log('DataTables AJAX Error:', error, code);
                        console.log('Response:', xhr.responseText);
                        
                    hideLoading();
                        $('#editable-sample1_processing').hide();
                                            $('#editable-sample1 tbody').html(`
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-danger">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <h6>Error Loading Data</h6>
                                    <p class="text-muted">Please refresh the page or contact support if the problem persists.</p>
                                </div>
                            </td>
                        </tr>
                    `);
                },
                complete: function() {
                    hideLoading();
                }
                },
                scroller: {
                    loadingIndicator: true
                },
                dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                {
                    extend: 'copyHtml5', 
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                    className: 'btn btn-outline-primary btn-sm',
                    text: '<i class="fas fa-copy me-1"></i>Copy'
                },
                {
                    extend: 'excelHtml5', 
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                    className: 'btn btn-outline-success btn-sm',
                    text: '<i class="fas fa-file-excel me-1"></i>Excel'
                },
                {
                    extend: 'csvHtml5', 
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                    className: 'btn btn-outline-info btn-sm',
                    text: '<i class="fas fa-file-csv me-1"></i>CSV'
                },
                {
                    extend: 'pdfHtml5', 
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                    className: 'btn btn-outline-danger btn-sm',
                    text: '<i class="fas fa-file-pdf me-1"></i>PDF'
                },
                {
                    extend: 'print', 
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                    className: 'btn btn-outline-secondary btn-sm',
                    text: '<i class="fas fa-print me-1"></i>Print'
                }
                ],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            iDisplayLength: 25,
            "order": [[2, "desc"]],
                "language": {
                "lengthMenu": "Show _MENU_ entries",
                    search: "_INPUT_",
                searchPlaceholder: "Search tests...",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json",
                "emptyTable": `
                    <div class="text-center py-4">
                        <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No Lab Tests Found</h6>
                        <p class="text-muted">No tests match your current filter criteria.</p>
                    </div>
                `,
                "zeroRecords": `
                    <div class="text-center py-4">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No Results Found</h6>
                        <p class="text-muted">Try adjusting your search or filter criteria.</p>
                    </div>
                `
            },
            "initComplete": function() {
                hideLoading();
                
                // Force header styling after DataTables initialization
                setTimeout(function() {
                    $('#editable-sample1 thead th').css({
                        'background': 'linear-gradient(135deg, #4f46e5, #6366f1)',
                        'color': '#ffffff',
                        'font-weight': '600',
                        'text-align': 'center',
                        'border': 'none',
                        'padding': '15px 10px'
                    });
                    
                    $('#editable-sample1 thead th i').css({
                        'color': '#ffffff'
                    });

                    // Apply invoice grouping styles
                    applyInvoiceGroupingStyles();
                }, 100);
            },
            "drawCallback": function() {
                // Apply grouping styles after each draw
                applyInvoiceGroupingStyles();
            }
            });
            
            table.buttons().container().appendTo('.custom_buttons');
            return table;
        }

        // Initialize table
        try {
            initializeDataTable();
        } catch (e) {
            console.error('Error initializing DataTable:', e);
        hideLoading();
    }

    // Enhanced filter change handlers
    function updateTable() {
        status = $('.status').val();
        category = $('.category').val();
        fromDate = $('#from_date').val();
        toDate = $('#to_date').val();
        
        showLoading();
        
        try {
            $('#editable-sample1').DataTable().destroy();
            var table = initializeDataTable();
            
            // Apply header styling after table update
            setTimeout(function() {
                $('#editable-sample1 thead th').css({
                    'background': 'linear-gradient(135deg, #4f46e5, #6366f1)',
                    'color': '#ffffff',
                    'font-weight': '600',
                    'text-align': 'center',
                    'border': 'none',
                    'padding': '15px 10px'
                });
                
                $('#editable-sample1 thead th i').css({
                    'color': '#ffffff'
                });

                // Apply invoice grouping styles
                applyInvoiceGroupingStyles();
            }, 200);
        } catch (e) {
            console.error('Error updating DataTable:', e);
            hideLoading();
        }
    }

    $('.status, .category').on("change", updateTable);
    $('.dateFilter').on("click", updateTable);

    // Refresh button
    $('#refreshTests').on('click', function() {
        $(this).find('i').addClass('fa-spin');
        updateTable();
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
        }, 1000);
    });

    // Enhanced test status change handler
    $(document).on("change", '.test_status', function() {
        let id = $(this).data("id");
        let newStatus = $(this).val();
        let $this = $(this);
        
        if (newStatus == 'not_done') {
            // Show loading state
            $this.prop('disabled', true);
            
            $.ajax({
                url: '<?php echo site_url('lab/changeTestStatus'); ?>',
                type: 'POST',
                data: {
                    id: id,
                    status: newStatus,
                    done_by: ""
                },
                success: function(response) {
                    // Show success notification
                    showNotification('Test status updated successfully', 'success');
                    updateTable();
                },
                error: function() {
                    showNotification('Error updating test status', 'error');
                    $this.prop('disabled', false);
                }
            });
        } else {
            $('#done_by_id').val(id);
            $('#done_by_status').val(newStatus);
            $('#done_by').val("");
            $('#done_by_modal').modal("show");
        }
    });

    // Enhanced done by button handler
    $(document).on("click", '.done_by_btn', function() {
        let id = $('#done_by_id').val();
        let status = $('#done_by_status').val();
        let done_by = $('#done_by').val();
        
        if (!done_by.trim()) {
            showNotification('Please enter who completed the test', 'warning');
            return;
        }
        
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Saving...');
        
        $.ajax({
            url: '<?php echo site_url('lab/changeTestStatus'); ?>',
            type: 'POST',
            data: {
                id: id,
                status: status,
                done_by: done_by
            },
            success: function(response) {
                showNotification('Test marked as completed successfully', 'success');
                $('#done_by_modal').modal("hide");
                updateTable();
            },
            error: function() {
                showNotification('Error updating test status', 'error');
            },
            complete: function() {
                $('.done_by_btn').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Save Changes');
            }
        });
    });

    // Notification function
    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const icon = type === 'success' ? 'check-circle' : 
                    type === 'error' ? 'exclamation-circle' : 
                    type === 'warning' ? 'exclamation-triangle' : 'info-circle';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${icon} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.alert('close');
        }, 5000);
    }

    // Function to apply invoice grouping styles
    function applyInvoiceGroupingStyles() {
        // Add special styling to invoice header rows
        $('#editable-sample1 tbody tr').each(function() {
            var $row = $(this);
            var $secondColumn = $row.find('td:nth-child(2)');
            
            // Check if this row contains an invoice header
            if ($secondColumn.find('.invoice-group-header').length > 0) {
                $row.addClass('invoice-header-row');
                $row.css({
                    'background': 'linear-gradient(135deg, #f0f4ff, #e0e7ff)',
                    'border-top': '2px solid #4f46e5',
                    'border-bottom': '1px solid #4f46e5'
                });
            }
            
            // Check if this row contains a test row
            if ($secondColumn.find('.test-row').length > 0) {
                $row.addClass('test-detail-row');
                $row.css({
                    'background': 'rgba(79, 70, 229, 0.02)',
                    'border-left': '3px solid #4f46e5'
                });
            }
        });
        
        // Add hover effects
        $('#editable-sample1 tbody tr.invoice-header-row').hover(
            function() {
                $(this).css('background', 'linear-gradient(135deg, #e0e7ff, #c7d2fe)');
            },
            function() {
                $(this).css('background', 'linear-gradient(135deg, #f0f4ff, #e0e7ff)');
            }
        );
        
        $('#editable-sample1 tbody tr.test-detail-row').hover(
            function() {
                $(this).css('background', 'rgba(79, 70, 229, 0.08)');
            },
            function() {
                $(this).css('background', 'rgba(79, 70, 229, 0.02)');
            }
        );
    }

    // Toggle group functionality
    $(document).on('click', '.toggle-group', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var invoiceId = $(this).data('invoice');
        var $icon = $(this).find('i');
        var $testRows = $('#editable-sample1 tbody tr').filter(function() {
            return $(this).find('.test-row[data-invoice="' + invoiceId + '"]').length > 0;
        });
        
        if ($testRows.is(':visible')) {
            // Hide test rows
            $testRows.hide();
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            $(this).attr('title', 'Show Tests');
        } else {
            // Show test rows
            $testRows.show();
            $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            $(this).attr('title', 'Hide Tests');
        }
    });

    // Collapse all groups functionality
    $(document).on('click', '#collapseAll', function() {
        $('.toggle-group').each(function() {
            var $button = $(this);
            var invoiceId = $button.data('invoice');
            var $icon = $button.find('i');
            var $testRows = $('#editable-sample1 tbody tr').filter(function() {
                return $(this).find('.test-row[data-invoice="' + invoiceId + '"]').length > 0;
            });
            
            $testRows.hide();
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            $button.attr('title', 'Show Tests');
        });
    });

    // Expand all groups functionality
    $(document).on('click', '#expandAll', function() {
        $('.toggle-group').each(function() {
            var $button = $(this);
            var invoiceId = $button.data('invoice');
            var $icon = $button.find('i');
            var $testRows = $('#editable-sample1 tbody tr').filter(function() {
                return $(this).find('.test-row[data-invoice="' + invoiceId + '"]').length > 0;
            });
            
            $testRows.show();
            $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            $button.attr('title', 'Hide Tests');
        });
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Auto-refresh every 2 minutes for critical tests
    setInterval(function() {
        if ($('.status').val() === 'critical' && document.visibilityState === 'visible') {
            updateTable();
        }
    }, 120000);
});

// Close description function
function closeDescription() {
    $('#descriptionAlert').slideUp(300);
}

// Export data function
$('#exportData').on('click', function() {
    const table = $('#editable-sample1').DataTable();
    table.button(1).trigger(); // Trigger Excel export
    });
</script>
