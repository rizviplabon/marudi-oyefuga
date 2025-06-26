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
                        <h4 class="mb-1 text-success">
                            <i class="fas fa-chart-line me-2"></i><?php echo $page_title; ?>
                        </h4>
                        <p class="text-muted mb-0">Track and monitor inventory consumption and usage patterns</p>
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

        <!-- Usage Summary Cards Section -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20">
                                    <span class="avatar-title rounded-circle">
                                        <i class="fas fa-clipboard-list fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white" id="totalUsageRecords">
                                    <?php echo count($usage_records); ?>
                                </h5>
                                <p class="text-white-75 mb-0">Total Records</p>
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
                                        <i class="fas fa-calendar-day fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white" id="todayUsage">
                                    <?php 
                                    $today_usage = 0;
                                    foreach ($usage_records as $usage) {
                                        if (date('Y-m-d', strtotime($usage->usage_date)) == date('Y-m-d')) {
                                            $today_usage++;
                                        }
                                    }
                                    echo $today_usage;
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Today's Usage</p>
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
                                        <i class="fas fa-calendar-week fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white" id="weekUsage">
                                    <?php 
                                    $week_usage = 0;
                                    $week_start = date('Y-m-d', strtotime('monday this week'));
                                    foreach ($usage_records as $usage) {
                                        if (date('Y-m-d', strtotime($usage->usage_date)) >= $week_start) {
                                            $week_usage++;
                                        }
                                    }
                                    echo $week_usage;
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">This Week</p>
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
                                        <i class="fas fa-user-injured fs-4"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-white" id="patientUsage">
                                    <?php 
                                    $patient_usage = 0;
                                    foreach ($usage_records as $usage) {
                                        if ($usage->usage_type == 'patient') {
                                            $patient_usage++;
                                        }
                                    }
                                    echo $patient_usage;
                                    ?>
                                </h5>
                                <p class="text-white-75 mb-0">Patient Care</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Usage Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1 text-success">
                                    <i class="fas fa-chart-line me-2"></i>Usage Tracking Dashboard
                                </h5>
                                <p class="text-muted mb-0">Monitor inventory consumption and track usage patterns</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="refreshUsage">
                                    <i class="fas fa-sync-alt me-1"></i>Refresh
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUsageModal">
                                    <i class="fas fa-plus me-1"></i>Record Usage
                                </button>
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

                        <!-- Usage Filters -->
                        <div class="row mb-4">
                            <div class="col-lg-8">
                                <div class="card border border-success border-opacity-25 bg-light">
                                    <div class="card-body py-3">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-filter me-1 text-success"></i>Usage Type
                                                </label>
                                                <select id="usageTypeFilter" class="form-select">
                                                    <option value="">🏥 All Types</option>
                                                    <option value="patient">👥 Patient Care</option>
                                                    <option value="procedure">🏥 Procedure</option>
                                                    <option value="surgery">⚕️ Surgery</option>
                                                    <option value="emergency">🚨 Emergency</option>
                                                    <option value="administrative">📋 Administrative</option>
                                                    <option value="other">📦 Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-calendar me-1 text-success"></i>Date Range
                                                </label>
                                                <select id="dateRangeFilter" class="form-select">
                                                    <option value="">📅 All Dates</option>
                                                    <option value="today">📅 Today</option>
                                                    <option value="week">📅 This Week</option>
                                                    <option value="month">📅 This Month</option>
                                                    <option value="custom">📅 Custom Range</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-user-md me-1 text-success"></i>Used By
                                                </label>
                                                <select id="userFilter" class="form-select">
                                                    <option value="">👤 All Users</option>
                                                    <!-- Users will be populated dynamically -->
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-outline-secondary w-100" id="clearUsageFilters">
                                                    <i class="fas fa-undo me-1"></i>Clear Filters
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex gap-2 h-100 align-items-end">
                                    <button type="button" class="btn btn-success flex-fill" id="exportUsage">
                                        <i class="fas fa-file-excel me-1"></i>Export Excel
                                    </button>
                                    <button type="button" class="btn btn-info flex-fill" id="printUsage">
                                        <i class="fas fa-print me-1"></i>Print Report
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Usage Table -->
                        <div class="table-responsive">
                            <table id="usage-table" class="table table-hover align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th class="fw-bold"><i class="fas fa-tag me-1"></i>Item</th>
                                        <th class="fw-bold"><i class="fas fa-minus-circle me-1"></i>Quantity Used</th>
                                        <th class="fw-bold"><i class="fas fa-list me-1"></i>Usage Type</th>
                                        <th class="fw-bold"><i class="fas fa-user-injured me-1"></i>Patient</th>
                                        <th class="fw-bold"><i class="fas fa-link me-1"></i>Reference</th>
                                        <th class="fw-bold"><i class="fas fa-barcode me-1"></i>Batch</th>
                                        <th class="fw-bold"><i class="fas fa-calendar me-1"></i>Usage Date</th>
                                        <th class="fw-bold"><i class="fas fa-user-md me-1"></i>Used By</th>
                                        <th class="fw-bold"><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body will be filled by DataTables -->
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
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #54a0ff 0%, #2e86de 100%);
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
    background-color: rgba(40,167,69,0.05);
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

.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e6ed;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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

/* Smooth animations */
.card-body h5 {
    transition: all 0.3s ease;
}

.usage-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}
</style>

<script>
    $(document).ready(function() {
        // Enhanced DataTables configuration
        const usageTable = $('#usage-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('inventory/getUsageData'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data": 0 },
                { "data": 1 },
                { "data": 2 },
                { "data": 3 },
                { "data": 4 },
                { "data": 5 },
                { "data": 6 },
                { "data": 7 },
                { "data": 8, "orderable": false }
            ],
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 25,
            order: [[6, 'desc']], // Sort by usage date
            language: {
                search: "<span class='small text-muted'></span> _INPUT_",
                searchPlaceholder: "Search usage records...",
                lengthMenu: "<span class='small text-muted'> _MENU_ </span>",
                info: "<b>_START_</b> to <b>_END_</b> of <b>_TOTAL_</b> records",
                infoEmpty: "No usage records found",
                infoFiltered: "(filtered from _MAX_ total records)",
                paginate: {
                    first: "<i class='fas fa-angle-double-left'></i>",
                    last: "<i class='fas fa-angle-double-right'></i>",
                    next: "<i class='fas fa-angle-right'></i>",
                    previous: "<i class='fas fa-angle-left'></i>"
                },
                processing: "<div class='d-flex justify-content-center'><div class='spinner-border text-success' role='status'><span class='sr-only'>Loading...</span></div></div>"
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
                    title: 'Inventory Usage Records'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-outline-success btn-sm me-1',
                    text: '<i class="fas fa-file-excel me-1"></i>Excel',
                    title: 'Inventory Usage Records'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-danger btn-sm me-1',
                    text: '<i class="fas fa-file-pdf me-1"></i>PDF',
                    title: 'Inventory Usage Records'
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-info btn-sm',
                    text: '<i class="fas fa-print me-1"></i>Print',
                    title: 'Inventory Usage Records'
                }
            ],
            columnDefs: [
                {
                    targets: [1], // Quantity column
                    className: 'text-center'
                },
                {
                    targets: [2], // Usage type column
                    className: 'text-center'
                },
                {
                    targets: [8], // Actions column
                    orderable: false,
                    className: 'text-center'
                }
            ],
            "drawCallback": function() {
                // Initialize view buttons after table redraw
                $('.viewUsageBtn').on('click', function() {
                    var usageId = $(this).data('id');
                    viewUsageData(usageId);
                });
                
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        
        // Custom filtering
        $('#usageTypeFilter').on('change', function() {
            const value = $(this).val();
            usageTable.column(2).search(value).draw();
        });

        $('#dateRangeFilter').on('change', function() {
            const value = $(this).val();
            // Implement date range filtering logic here
            // This would require backend support
        });

        $('#userFilter').on('change', function() {
            const value = $(this).val();
            usageTable.column(7).search(value).draw();
        });

        $('#clearUsageFilters').on('click', function() {
            $('#usageTypeFilter, #dateRangeFilter, #userFilter').val('');
            usageTable.search('').columns().search('').draw();
        });

        // Export and Print Functions
        $('#exportUsage').click(function() {
            usageTable.button('.buttons-excel').trigger();
        });

        $('#printUsage').click(function() {
            usageTable.button('.buttons-print').trigger();
        });

        // Refresh usage data
        $('#refreshUsage').click(function() {
            usageTable.ajax.reload();
            updateSummaryCards();
        });
        
        // Function to view usage data
        function viewUsageData(usageId) {
            $.ajax({
                url: "<?php echo base_url('inventory/getUsageRecordData/'); ?>" + usageId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        showNotification(response.error, 'error');
                    } else {
                        // Populate the view modal
                        $('#view_usage_id').text(response.id);
                        $('#view_item_name').text(response.item_name);
                        $('#view_quantity_used').text(response.quantity_used);
                        $('#view_usage_type').text(ucfirst(response.usage_type));
                        $('#view_patient_name').text(response.patient_name || 'N/A');
                        
                        var reference = 'N/A';
                        if (response.reference_id && response.reference_type) {
                            reference = ucfirst(response.reference_type) + ' #' + response.reference_id;
                        }
                        $('#view_reference').text(reference);
                        
                        $('#view_batch_number').text(response.batch_number || 'N/A');
                        $('#view_usage_date').text(formatDateTime(response.usage_date));
                        $('#view_used_by').text(response.user_name || 'N/A');
                        $('#view_notes').text(response.notes || 'N/A');
                        
                        // Show the modal
                        $('#viewUsageModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    showNotification("Error loading usage data: " + error, 'error');
                }
            });
        }
        
        // Helper functions
        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        
        function formatDateTime(dateTimeString) {
            var date = new Date(dateTimeString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
        }
        
        // Initialize select2 for item dropdown when modal is shown
        $('#addUsageModal').on('shown.bs.modal', function () {
            console.log('Add Usage Modal shown');
            
            // Destroy existing Select2 if any
            if ($('#usage_item_id').data('select2')) {
                $('#usage_item_id').select2('destroy');
            }
            
            // Initialize Select2
        $('#usage_item_id').select2({
            placeholder: 'Select an item',
                dropdownParent: $('#addUsageModal'),
                width: '100%',
            ajax: {
                url: "<?php echo base_url('inventory/getItemInfo'); ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                            searchTerm: params.term || ''
                    };
                },
                processResults: function (data) {
                        console.log('Usage Modal Select2 AJAX response:', data);
                    return {
                        results: data
                    };
                },
                cache: true
            },
                minimumInputLength: 0,
                allowClear: true
            });
            console.log('Select2 initialized for usage modal');
        });
        
        // Handle add usage form submission via AJAX
        $('#addUsageForm').submit(function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = $('#addUsageForm button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Recording...').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showNotification(response.message, 'success');
                        
                        // Close the modal
                        $('#addUsageModal').modal('hide');
                        
                        // Reset the form
                        $('#addUsageForm')[0].reset();
                        $('#usage_item_id').val(null).trigger('change');
                        
                        // Reload the table and update summary
                        usageTable.ajax.reload();
                        updateSummaryCards();
                    } else {
                        // Show error message
                        var errorHtml = '';
                        if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            errorHtml += value + '<br>';
                        });
                        } else {
                            errorHtml = response.message || 'An error occurred';
                        }
                        $('#usageFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    showNotification("Error: " + error, 'error');
                },
                complete: function() {
                    // Restore button state
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Make sure modals are properly initialized
        $('.modal').modal({
            show: false,
            backdrop: true,
            keyboard: true
        });
        
        // Fix modal z-index issues
        $('.modal').appendTo('body');
        
        // Ensure Add Usage button works
        $('[data-target="#addUsageModal"]').on('click', function(e) {
            e.preventDefault();
            $('#addUsageModal').modal('show');
        });  
        
        // Reset form when modal is closed
        $('#addUsageModal').on('hidden.bs.modal', function () {
            $('#addUsageForm')[0].reset();
            $('#usageFormErrors').hide();
            if ($('#usage_item_id').data('select2')) {
                $('#usage_item_id').val(null).trigger('change');
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

        // Function to update summary cards
        function updateSummaryCards() {
            // This would typically make an AJAX call to get updated statistics
            // For now, we'll just reload the page data
        }

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
    });
</script>

<!-- Include common scripts for inventory modals -->
<?php $this->load->view('inventory/common_scripts'); ?>

<!-- Enhanced Add Usage Modal -->
<div class="modal fade" id="addUsageModal" tabindex="-1" role="dialog" aria-labelledby="addUsageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUsageModalLabel">
                    <i class="fas fa-plus-circle text-success me-2"></i>Record Usage
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="usageFormErrors" class="alert alert-danger border-0 shadow-sm" style="display: none;"></div>
                
                <form id="addUsageForm" action="<?php echo base_url(); ?>inventory/addUsage" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag text-success me-1"></i>Item <span class="text-danger">*</span>
                                </label>
                            <select id="usage_item_id" name="item_id" class="form-control select2" required></select>
                                <small class="text-muted">Search and select the item to record usage for</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-minus-circle text-warning me-1"></i>Quantity Used <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="quantity_used" class="form-control" min="1" required>
                                <small class="text-muted">Enter the quantity consumed</small>
                    </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-list text-primary me-1"></i>Usage Type <span class="text-danger">*</span>
                                </label>
                            <select name="usage_type" class="form-control" required>
                                <option value="">Select Usage Type</option>
                                    <option value="patient">👥 Patient Care</option>
                                    <option value="procedure">🏥 Procedure</option>
                                    <option value="surgery">⚕️ Surgery</option>
                                    <option value="emergency">🚨 Emergency</option>
                                    <option value="administrative">📋 Administrative</option>
                                    <option value="other">📦 Other</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-injured text-info me-1"></i>Patient ID
                                </label>
                                <input type="text" name="patient_id" class="form-control" placeholder="Enter patient ID if applicable">
                                <small class="text-muted">Required for patient care usage</small>
                    </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-link text-secondary me-1"></i>Reference Type
                                </label>
                            <select name="reference_type" class="form-control">
                                <option value="">Select Reference Type</option>
                                    <option value="appointment">📅 Appointment</option>
                                    <option value="prescription">💊 Prescription</option>
                                    <option value="procedure">🏥 Procedure</option>
                                    <option value="surgery">⚕️ Surgery</option>
                                    <option value="other">📋 Other</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-hashtag text-secondary me-1"></i>Reference ID
                                </label>
                                <input type="text" name="reference_id" class="form-control" placeholder="e.g., Appointment ID, Prescription #">
                    </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-barcode text-dark me-1"></i>Batch Number
                                </label>
                                <input type="text" name="batch_number" class="form-control" placeholder="Enter batch number if available">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note text-warning me-1"></i>Notes
                                </label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes or comments"></textarea>
                    </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" form="addUsageForm" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Record Usage
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced View Usage Modal -->
<div class="modal fade" id="viewUsageModal" tabindex="-1" role="dialog" aria-labelledby="viewUsageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUsageModalLabel">
                    <i class="fas fa-eye text-info me-2"></i>Usage Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-tag me-1"></i>Item:
                            </label>
                            <p id="view_item_name" class="form-control-static fw-semibold"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-minus-circle me-1"></i>Quantity Used:
                            </label>
                            <p id="view_quantity_used" class="form-control-static fw-semibold"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-list me-1"></i>Usage Type:
                            </label>
                            <p id="view_usage_type" class="form-control-static"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-user-injured me-1"></i>Patient:
                            </label>
                            <p id="view_patient_name" class="form-control-static"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-link me-1"></i>Reference:
                            </label>
                            <p id="view_reference" class="form-control-static"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-barcode me-1"></i>Batch Number:
                            </label>
                            <p id="view_batch_number" class="form-control-static"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-calendar me-1"></i>Usage Date:
                            </label>
                            <p id="view_usage_date" class="form-control-static"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold text-muted">
                                <i class="fas fa-user-md me-1"></i>Used By:
                            </label>
                            <p id="view_used_by" class="form-control-static"></p>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="fw-semibold text-muted">
                        <i class="fas fa-sticky-note me-1"></i>Notes:
                    </label>
                    <p id="view_notes" class="form-control-static"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>