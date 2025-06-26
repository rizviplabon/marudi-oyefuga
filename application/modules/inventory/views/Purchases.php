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
                            <i class="fas fa-shopping-cart text-info" style="font-size: 2.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-info"><?php echo $page_title; ?></h4>
                            <p class="text-muted mb-0">Manage inventory purchases and procurement records</p>
                        </div>
                    </div>
                    <div class="page-title-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 bg-transparent">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('home'); ?>" class="text-info">
                                        <i class="fas fa-home"></i> Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('inventory'); ?>" class="text-info">
                                        <i class="fas fa-boxes"></i> Inventory
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-dark fw-medium">
                                    <i class="fas fa-shopping-cart"></i> <?php echo $page; ?>
                                </li>
                        </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card purchase-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="purchase-icon-wrapper bg-gradient-info">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Purchases</h6>
                                <h4 class="mb-0" id="totalPurchasesCount">
                                    <span class="counter">0</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card purchase-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="purchase-icon-wrapper bg-gradient-success">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Value</h6>
                                <h4 class="mb-0" id="totalPurchaseValue">
                                    $<span class="counter">0</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card purchase-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="purchase-icon-wrapper bg-gradient-warning">
                                    <i class="fas fa-calendar-day text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">This Month</h6>
                                <h4 class="mb-0" id="monthlyPurchasesCount">
                                    <span class="counter">0</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card purchase-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="purchase-icon-wrapper bg-gradient-danger">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Pending Orders</h6>
                                <h4 class="mb-0" id="pendingOrdersCount">
                                    <span class="counter">0</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-filter me-2"></i>Advanced Filters
                            </h6>
                            <button class="btn btn-sm btn-outline-secondary" id="toggleFilters">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="filtersContent" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-calendar text-info me-1"></i>Date Range
                                    </label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="filterDateFrom" placeholder="From">
                                        <input type="date" class="form-control" id="filterDateTo" placeholder="To">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-tags text-success me-1"></i>Status
                                    </label>
                                    <select class="form-select" id="filterStatus">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="received">Received</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-truck text-warning me-1"></i>Supplier
                                    </label>
                                    <input type="text" class="form-control" id="filterSupplier" placeholder="Supplier name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-dollar-sign text-danger me-1"></i>Amount Range
                                    </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="filterAmountMin" placeholder="Min">
                                        <input type="number" class="form-control" id="filterAmountMax" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-info" id="applyFilters">
                                        <i class="fas fa-search me-1"></i>Apply Filters
                                    </button>
                                    <button class="btn btn-outline-secondary" id="clearFilters">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- page start-->

        <!-- Main Purchases Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1 fw-bold text-info">
                                    <i class="fas fa-shopping-cart me-2"></i>Purchase Records
                                </h5>
                                <p class="text-muted mb-0 small">Manage and track all inventory purchases</p>
                    </div>
                            <div class="d-flex gap-2">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" title="Export Data">
                                        <i class="fas fa-download me-1"></i>Export
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" title="Print Report">
                                        <i class="fas fa-print me-1"></i>Print
                                </button>
                                </div>
                                <button type="button" class="btn btn-info btn-sm shadow-sm" data-toggle="modal" data-target="#addPurchaseModal">
                                    <i class="fas fa-plus me-1"></i>Add Purchase
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <div class="table-responsive">
                            <table id="purchases-table" class="table table-hover align-middle mb-0">
                                <thead class="table-info">
                                    <tr>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-hashtag me-1"></i>PO #
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-box me-1"></i>Item
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-sort-numeric-up me-1"></i>Quantity
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-dollar-sign me-1"></i>Unit Cost
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-calculator me-1"></i>Total Cost
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-truck me-1"></i>Supplier
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-calendar me-1"></i>Purchase Date
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-calendar-times me-1"></i>Expiry Date
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-info-circle me-1"></i>Status
                                        </th>
                                        <th class="border-0 fw-bold text-center">
                                            <i class="fas fa-cogs me-1"></i>Actions
                                        </th>
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

<!-- Custom CSS for Enhanced Purchases Page -->
<style>
/* Purchase Summary Cards */
.purchase-summary-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.purchase-summary-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.purchase-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

/* Counter Animation */
.counter {
    display: inline-block;
    transition: all 0.5s ease;
}

/* Filter Cards */
.filter-card {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.filter-card:hover {
    border-color: #17a2b8;
    box-shadow: 0 2px 10px rgba(23, 162, 184, 0.1);
}

/* Enhanced Table Styles */
.table-info {
    background: linear-gradient(135deg, #d1ecf1, #bee5eb);
}

.table-hover tbody tr:hover {
    background-color: rgba(23, 162, 184, 0.05);
    transform: scale(1.01);
    transition: all 0.2s ease;
}

/* Status Badges */
.badge-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.badge-pending {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    color: #fff;
}

.badge-received {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #fff;
}

.badge-cancelled {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: #fff;
}

/* Action Buttons */
.btn-action {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 2px;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* Modal Enhancements */
.modal-content {
    border-radius: 20px;
    overflow: hidden;
}

.modal-header.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #138496) !important;
}

.form-control:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
}

.select2-container--default .select2-selection--single:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
}

/* Loading Spinner */
.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    color: #17a2b8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .purchase-summary-card {
        margin-bottom: 1rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-bottom: 0.5rem;
    }
}

/* Animation Classes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.5s ease-out;
}

/* Custom Scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #17a2b8;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #138496;
}

/* Info Cards for View Modal */
.info-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
}

.info-card:hover {
    border-color: #17a2b8;
    box-shadow: 0 2px 10px rgba(23, 162, 184, 0.1);
}

.info-card.highlight-card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-color: #17a2b8;
}

.info-header {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.info-content {
    font-size: 1rem;
    color: #495057;
    font-weight: 500;
    word-break: break-word;
}
</style>

<script>
    $(document).ready(function() {
        // Define BASE_URL for AJAX calls
        var BASE_URL = '<?php echo base_url(); ?>';
        
        // Debug Select2 initialization
        console.log('Document ready for Purchases page');
        console.log('jQuery version:', $.fn.jquery);
        console.log('Select2 available:', typeof $.fn.select2);
        console.log('Item field exists:', $('#item_id').length);
        console.log('Item field HTML:', $('#item_id').prop('outerHTML'));
        
        // Wait a bit for all scripts to load, then initialize Select2
        setTimeout(function() {
            if (typeof $.fn.select2 === 'function') {
                console.log('Initializing Select2 immediately...');
                $('#item_id').select2({
                    placeholder: 'Select an item',
                    width: '100%',
                    ajax: {
                        url: BASE_URL + 'inventory/getActiveItems',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term || ''
                            };
                        },
                        processResults: function (data) {
                            console.log('AJAX data received:', data);
                            return {
                                results: data
                            };
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            console.log('Response:', xhr.responseText);
                        }
                    },
                    minimumInputLength: 0,
                    allowClear: true
                });
                console.log('Select2 initialized!');
            } else {
                console.error('Select2 is not available!');
            }
        }, 1000);
        
        // Initialize Enhanced DataTable
        var purchasesTable = $('#purchases-table').DataTable({ 
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('inventory/getPurchasesData'); ?>",
                "type": "POST",
                "data": function(d) {
                    // Add filter parameters
                    d.status_filter = $('#filterStatus').val();
                    d.date_from = $('#filterDateFrom').val();
                    d.date_to = $('#filterDateTo').val();
                    d.supplier_filter = $('#filterSupplier').val();
                    d.amount_min = $('#filterAmountMin').val();
                    d.amount_max = $('#filterAmountMax').val();
                }
            },
            "columns": [
                { "data": 0, "className": "text-center" },
                { "data": 1 },
                { "data": 2, "className": "text-center" },
                { "data": 3, "className": "text-end" },
                { "data": 4, "className": "text-end fw-bold" },
                { "data": 5 },
                { "data": 6, "className": "text-center" },
                { "data": 7, "className": "text-center" },
                { "data": 8, "className": "text-center" },
                { "data": 9, "orderable": false, "className": "text-center" }
            ],
            "order": [[6, "desc"]],
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                   "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search purchases, items, suppliers...",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ purchases",
                "infoEmpty": "No purchases found",
                "infoFiltered": "(filtered from _MAX_ total purchases)",
                "paginate": {
                    "first": "<i class='fas fa-angle-double-left'></i>",
                    "last": "<i class='fas fa-angle-double-right'></i>",
                    "next": "<i class='fas fa-angle-right'></i>",
                    "previous": "<i class='fas fa-angle-left'></i>"
                },
                "processing": "<div class='loading-spinner'><i class='fas fa-spinner fa-spin fa-3x'></i><br><span class='mt-2'>Loading purchases...</span></div>",
                "emptyTable": "<div class='text-center p-4'><i class='fas fa-shopping-cart fa-3x text-muted mb-3'></i><br><h5>No purchases found</h5><p class='text-muted'>Start by adding your first purchase record.</p></div>"
            },
            "drawCallback": function(settings) {
                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
                
                // Initialize action buttons
                $('.viewPurchaseBtn').off('click').on('click', function() {
                    var purchaseId = $(this).data('id');
                    viewPurchaseData(purchaseId);
                });
                
                $('.editPurchaseBtn').off('click').on('click', function() {
                    var purchaseId = $(this).data('id');
                    editPurchaseData(purchaseId);
                });
                
                // Update summary cards
                updateSummaryCards();
                
                // Add fade-in animation to rows
                $('tbody tr').addClass('fade-in-up');
            },
            "initComplete": function() {
                // Load summary data
                loadSummaryData();
                
                // Initialize filter toggle
                initializeFilters();
            }
        });
        
        // Function to view purchase data
        function viewPurchaseData(purchaseId) {
            $.ajax({
                url: "<?php echo base_url('inventory/getPurchaseData/'); ?>" + purchaseId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate the view modal
                        $('#view_purchase_id').text(response.id);
                        $('#view_item_name').text(response.item_name);
                        $('#view_purchase_order_no').text(response.purchase_order_no || 'N/A');
                        $('#view_quantity').text(response.quantity);
                        $('#view_unit_cost').text(response.unit_cost);
                        $('#view_total_cost').text(response.total_cost);
                        $('#view_supplier_name').text(response.supplier_name || 'N/A');
                        $('#view_supplier_invoice_no').text(response.supplier_invoice_no || 'N/A');
                        $('#view_purchase_date').text(formatDate(response.purchase_date));
                        $('#view_expiry_date').text(response.expiry_date ? formatDate(response.expiry_date) : 'N/A');
                        $('#view_batch_number').text(response.batch_number || 'N/A');
                        $('#view_notes').text(response.notes || 'N/A');
                        
                        // Show the modal
                        $('#viewPurchaseModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
        
        // Function to edit purchase data
        function editPurchaseData(purchaseId) {
            $.ajax({
                url: "<?php echo base_url('inventory/getPurchaseData/'); ?>" + purchaseId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate the edit form
                        $('#edit_purchase_id').val(response.id);
                        
                        // Create a new option and append it to the select
                        var newOption = new Option(response.item_name, response.item_id, true, true);
                        $('#edit_item_id').append(newOption).trigger('change');
                        
                        $('#edit_purchase_order_no').val(response.purchase_order_no);
                        $('#edit_quantity').val(response.quantity);
                        $('#edit_unit_cost').val(response.unit_cost);
                        $('#edit_total_cost').val(response.total_cost);
                        $('#edit_supplier_name').val(response.supplier_name);
                        $('#edit_supplier_invoice_no').val(response.supplier_invoice_no);
                        $('#edit_purchase_date').val(formatDate(response.purchase_date));
                        
                        if (response.expiry_date) {
                            $('#edit_expiry_date').val(formatDate(response.expiry_date));
                        } else {
                            $('#edit_expiry_date').val('');
                        }
                        
                        $('#edit_batch_number').val(response.batch_number);
                        $('#edit_status').val(response.status);
                        $('#edit_notes').val(response.notes);
                        
                        // Show the modal
                        $('#editPurchaseModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
        
        // Helper function to format dates
        function formatDate(dateString) {
            var date = new Date(dateString);
            return date.toISOString().split('T')[0];
        }
        
        // Calculate total cost when quantity or unit cost changes
        $('#quantity, #unit_cost').on('input', function() {
            var quantity = parseFloat($('#quantity').val()) || 0;
            var unitCost = parseFloat($('#unit_cost').val()) || 0;
            $('#total_cost').val((quantity * unitCost).toFixed(2));
        });
        
        // Handle add purchase form submission via AJAX
        $('#addPurchaseForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert(response.message);
                        
                        // Close the modal
                        $('#addPurchaseModal').modal('hide');
                        
                        // Reset the form
                        $('#addPurchaseForm')[0].reset();
                        $('#item_id').val(null).trigger('change');
                        
                        // Reload the table
                        $('#purchases-table').DataTable().ajax.reload();
                    } else {
                        // Show error message
                        var errorHtml = '';
                        $.each(response.errors, function(key, value) {
                            errorHtml += value + '<br>';
                        });
                        $('#purchaseFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX submission error:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        responseJSON: xhr.responseJSON
                    });
                    
                    // Try to show more specific error message
                    var errorMessage = 'An error occurred while processing your request';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        // Check if it's an HTML error page
                        if (xhr.responseText.indexOf('<!DOCTYPE') > -1 || xhr.responseText.indexOf('<html') > -1) {
                            errorMessage = 'Server error occurred. Check console for details.';
                            console.error('HTML Error Response:', xhr.responseText);
                        } else {
                            errorMessage = xhr.responseText;
                        }
                    }
                    
                    alert(errorMessage);
                }
            });
        });
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Make sure modals are properly initialized
        $('.modal').each(function() {
            var $modal = $(this);
            
            // Move modals to body to avoid z-index issues
            if (!$modal.parent().is('body')) {
                $modal.appendTo('body');
            }
            
            // Initialize with proper options
            $modal.modal({ 
                show: false,
                backdrop: true,
                keyboard: true
            });
        });
         
        // Fix modal z-index issues when multiple modals are open
        $(document).on('show.bs.modal', '.modal', function() {
            var zIndex = 1050 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
        
        // Ensure Add Purchase button works
        $('[data-target="#addPurchaseModal"]').on('click', function(e) {
            e.preventDefault();
            $('#addPurchaseModal').modal('show');
        });
        
        // Reinitialize Select2 when modal is shown
        $('#addPurchaseModal').on('shown.bs.modal', function () {
            console.log('Add Purchase Modal shown');
            
            // Destroy existing Select2 if any
            if ($('#item_id').data('select2')) {
                $('#item_id').select2('destroy');
            }
            
            // Initialize Select2
            $('#item_id').select2({
                placeholder: 'Select an item',
                dropdownParent: $('#addPurchaseModal'),
                width: '100%',
                ajax: {
                    url: "<?php echo base_url('inventory/getActiveItems'); ?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term || ''
                        };
                    },
                    processResults: function (data) {
                        console.log('Modal Select2 AJAX response:', data);
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                allowClear: true
            });
            console.log('Select2 reinitialized on modal show');
        });
        
        // Initialize select2 for edit item dropdown
        $('#edit_item_id').select2({
            placeholder: 'Select an item',
            dropdownParent: $('#editPurchaseModal'),
            width: '100%',
            ajax: {
                url: "<?php echo base_url('inventory/getActiveItems'); ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term || ''
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });
        
        // Calculate total cost when quantity or unit cost changes in edit form
        $('#edit_quantity, #edit_unit_cost').on('input', function() {
            var quantity = parseFloat($('#edit_quantity').val()) || 0;
            var unitCost = parseFloat($('#edit_unit_cost').val()) || 0;
            $('#edit_total_cost').val((quantity * unitCost).toFixed(2));
        });
        
        // Handle edit purchase form submission via AJAX
        $('#editPurchaseForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert(response.message);
                        
                        // Close the modal
                        $('#editPurchaseModal').modal('hide');
                        
                        // Reload the table
                        $('#purchases-table').DataTable().ajax.reload();
                    } else {
                        // Show error message
                        var errorHtml = '';
                        $.each(response.errors, function(key, value) {
                            errorHtml += value + '<br>';
                        });
                        $('#editPurchaseFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }); 
        
        // Load Summary Data
        function loadSummaryData() {
            $.ajax({
                url: "<?php echo base_url('inventory/getPurchasesSummary'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Animate counters
                    animateCounter('#totalPurchasesCount .counter', data.total_purchases || 0);
                    animateCounter('#totalPurchaseValue .counter', data.total_value || 0);
                    animateCounter('#monthlyPurchasesCount .counter', data.monthly_purchases || 0);
                    animateCounter('#pendingOrdersCount .counter', data.pending_orders || 0);
                },
                error: function() {
                    console.log('Error loading summary data');
                }
            });
        }
        
        // Animate Counter
        function animateCounter(selector, endValue) {
            var $counter = $(selector);
            var startValue = 0;
            var duration = 1500;
            var increment = endValue / (duration / 16);
            
            function updateCounter() {
                startValue += increment;
                if (startValue >= endValue) {
                    $counter.text(Math.floor(endValue));
                } else {
                    $counter.text(Math.floor(startValue));
                    requestAnimationFrame(updateCounter);
                }
            }
            
            updateCounter();
        }
        
        // Initialize Filters
        function initializeFilters() {
            // Toggle filters visibility
            $('#toggleFilters').on('click', function() {
                var $content = $('#filtersContent');
                var $icon = $(this).find('i');
                
                $content.slideToggle(300);
                $icon.toggleClass('fa-chevron-down fa-chevron-up');
            });
            
            // Apply filters
            $('#applyFilters').on('click', function() {
                purchasesTable.ajax.reload();
            });
            
            // Clear filters
            $('#clearFilters').on('click', function() {
                $('#filterDateFrom, #filterDateTo, #filterSupplier, #filterAmountMin, #filterAmountMax').val('');
                $('#filterStatus').val('');
                purchasesTable.ajax.reload();
            });
            
            // Auto-apply filters on Enter key
            $('.filter-card input, .filter-card select').on('keypress change', function(e) {
                if (e.which === 13) { // Enter key
                    purchasesTable.ajax.reload();
                }
            });
        }
        
        // Update Summary Cards
        function updateSummaryCards() {
            // This can be enhanced to update cards based on current table data
            var info = purchasesTable.page.info();
            if (info.recordsDisplay !== info.recordsTotal) {
                // Update cards to show filtered results
                console.log('Filtered results:', info.recordsDisplay);
            }
        }
        
        // Enhanced Add Purchase Form Reset
        function resetAddPurchaseForm() {
            $('#addPurchaseForm')[0].reset();
            $('#item_id').val(null).trigger('change');
            $('#total_cost').val('');
            $('#purchaseFormErrors').hide();
        }
        
        // Enhanced modal show event
        $('#addPurchaseModal').on('shown.bs.modal', function() {
            resetAddPurchaseForm();
            $('#item_id').focus();
        });
        
        // Enhanced form validation
        $('#addPurchaseForm').on('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            var $submitBtn = $(this).find('button[type="submit"]');
            var originalText = $submitBtn.html();
            $submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Processing...').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success notification
                        showNotification('success', response.message);
                        
                        // Close modal and reload table
                        $('#addPurchaseModal').modal('hide');
                        purchasesTable.ajax.reload();
                        
                        // Reload summary data
                        loadSummaryData();
                    } else {
                        // Show validation errors
                        var errorHtml = '';
                        $.each(response.errors, function(key, value) {
                            errorHtml += '<div class="alert-item"><i class="fas fa-exclamation-triangle me-2"></i>' + value + '</div>';
                        });
                        $('#purchaseFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Form submission error:', error);
                    showNotification('error', 'An error occurred while processing your request. Please try again.');
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Show Notification
        function showNotification(type, message) {
            var bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            var notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                '<i class="fas ' + icon + ' me-2"></i>' + message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>');
            
            $('body').append(notification);
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                notification.alert('close');
            }, 5000);
        }
        
        // Initialize tooltips globally
        function initializeTooltips() {
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        }
        
        // Call initialize tooltips
        initializeTooltips();
        
        // Reinitialize tooltips after AJAX calls
        $(document).ajaxComplete(function() {
            initializeTooltips();
        });
    });
</script>

<!-- Include common scripts for inventory modals -->
<?php $this->load->view('inventory/common_scripts'); ?>

<!-- Enhanced Add Purchase Modal -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white border-0">
                <h5 class="modal-title fw-bold" id="addPurchaseModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add New Purchase
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="purchaseFormErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="addPurchaseForm" action="<?php echo base_url(); ?>inventory/addPurchase" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-box text-info me-1"></i>Item <span class="text-danger">*</span>
                                </label>
                            <select id="item_id" name="item_id" class="form-control select2 item-select" required>
                                <option value="">Select an item</option>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-hashtag text-info me-1"></i>Purchase Order #
                                </label>
                                <input type="text" name="purchase_order_no" class="form-control" placeholder="PO-2024-001">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-sort-numeric-up text-info me-1"></i>Quantity <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="quantity" name="quantity" class="form-control" min="1" required placeholder="0">
                        </div>
                    </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-dollar-sign text-info me-1"></i>Unit Cost <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="unit_cost" name="unit_cost" class="form-control" step="0.01" min="0" required placeholder="0.00">
                        </div>
                    </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-calculator text-info me-1"></i>Total Cost
                                </label>
                                <input type="number" id="total_cost" class="form-control bg-light" readonly placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-truck text-info me-1"></i>Supplier Name
                                </label>
                                <input type="text" name="supplier_name" class="form-control" placeholder="Supplier name">
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-file-invoice text-info me-1"></i>Supplier Invoice #
                                </label>
                                <input type="text" name="supplier_invoice_no" class="form-control" placeholder="INV-001">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-calendar text-info me-1"></i>Purchase Date <span class="text-danger">*</span>
                                </label>
                            <input type="date" name="purchase_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-calendar-times text-info me-1"></i>Expiry Date
                                </label>
                            <input type="date" name="expiry_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-barcode text-info me-1"></i>Batch Number
                                </label>
                                <input type="text" name="batch_number" class="form-control" placeholder="BATCH-001">
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-sticky-note text-info me-1"></i>Notes
                                </label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" form="addPurchaseForm" class="btn btn-info">
                    <i class="fas fa-save me-1"></i>Add Purchase
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced View Purchase Modal -->
<div class="modal fade" id="viewPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="viewPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white border-0">
                <h5 class="modal-title fw-bold" id="viewPurchaseModalLabel">
                    <i class="fas fa-eye me-2"></i>Purchase Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-box text-info me-2"></i>
                                <span class="fw-bold">Item</span>
                            </div>
                            <div class="info-content" id="view_item_name">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-hashtag text-info me-2"></i>
                                <span class="fw-bold">Purchase Order #</span>
                            </div>
                            <div class="info-content" id="view_purchase_order_no">-</div>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-sort-numeric-up text-info me-2"></i>
                                <span class="fw-bold">Quantity</span>
                            </div>
                            <div class="info-content" id="view_quantity">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-dollar-sign text-info me-2"></i>
                                <span class="fw-bold">Unit Cost</span>
                            </div>
                            <div class="info-content" id="view_unit_cost">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card highlight-card">
                            <div class="info-header">
                                <i class="fas fa-calculator text-info me-2"></i>
                                <span class="fw-bold">Total Cost</span>
                            </div>
                            <div class="info-content fw-bold text-info" id="view_total_cost">-</div>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-truck text-info me-2"></i>
                                <span class="fw-bold">Supplier Name</span>
                            </div>
                            <div class="info-content" id="view_supplier_name">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-file-invoice text-info me-2"></i>
                                <span class="fw-bold">Supplier Invoice #</span>
                            </div>
                            <div class="info-content" id="view_supplier_invoice_no">-</div>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-calendar text-info me-2"></i>
                                <span class="fw-bold">Purchase Date</span>
                            </div>
                            <div class="info-content" id="view_purchase_date">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-calendar-times text-info me-2"></i>
                                <span class="fw-bold">Expiry Date</span>
                        </div>
                            <div class="info-content" id="view_expiry_date">-</div>
                    </div>
                </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-barcode text-info me-2"></i>
                                <span class="fw-bold">Batch Number</span>
                </div>
                            <div class="info-content" id="view_batch_number">-</div>
            </div>
            </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-header">
                                <i class="fas fa-sticky-note text-info me-2"></i>
                                <span class="fw-bold">Notes</span>
                            </div>
                            <div class="info-content" id="view_notes">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Purchase Modal -->
<div class="modal fade" id="editPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="editPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPurchaseModalLabel"><i class="fa fa-edit"></i> Edit Purchase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editPurchaseFormErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="editPurchaseForm" action="<?php echo base_url(); ?>inventory/editPurchase" method="post">
                    <input type="hidden" id="edit_purchase_id" name="id">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Item <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select id="edit_item_id" name="item_id" class="form-control select2 item-select" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Purchase Order #</label>
                        <div class="col-sm-9">
                            <input type="text" id="edit_purchase_order_no" name="purchase_order_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Quantity <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="number" id="edit_quantity" name="quantity" class="form-control" min="1" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit Cost <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="number" id="edit_unit_cost" name="unit_cost" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Cost</label>
                        <div class="col-sm-9">
                            <input type="number" id="edit_total_cost" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Supplier Name</label>
                        <div class="col-sm-9">
                            <input type="text" id="edit_supplier_name" name="supplier_name" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Supplier Invoice #</label>
                        <div class="col-sm-9">
                            <input type="text" id="edit_supplier_invoice_no" name="supplier_invoice_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Purchase Date <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="date" id="edit_purchase_date" name="purchase_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Expiry Date</label>
                        <div class="col-sm-9">
                            <input type="date" id="edit_expiry_date" name="expiry_date" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Batch Number</label>
                        <div class="col-sm-9">
                            <input type="text" id="edit_batch_number" name="batch_number" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select id="edit_status" name="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="received">Received</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Notes</label>
                        <div class="col-sm-9">
                            <textarea id="edit_notes" name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editPurchaseForm" class="btn btn-primary">Update Purchase</button>
            </div>
        </div>
    </div>
</div>