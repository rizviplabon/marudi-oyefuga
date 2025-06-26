<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 content-header">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">
                            <i class="fas fa-wallet me-2"></i><?php echo lang('patient'); ?> <?php echo lang('account_balance'); ?>
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                <li class="breadcrumb-item"><?php echo lang('patient'); ?></li>
                                <li class="breadcrumb-item active"><?php echo lang('account_balance'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Patient Account Balance Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">
                                    <i class="fas fa-table me-2"></i>Patient Account Balances
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="refreshTable()">
                                        <i class="fas fa-sync-alt me-1"></i> Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0" id="accountOverviewTable" style="width: 100%;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient Name</th>
                                            <th>Phone</th>
                                            <th>Account Balance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data loaded via DataTables -->
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

<!-- Account Details Modal -->
<div class="modal fade" id="accountDetailsModal" tabindex="-1" aria-labelledby="accountDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="accountDetailsModalLabel">
                    <i class="fas fa-wallet me-2"></i>Account Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Patient Info -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Patient Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Name:</strong> <span id="modalPatientName">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>ID:</strong> <span id="modalPatientId">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Phone:</strong> <span id="modalPatientPhone">-</span>
                                    </div>
                                </div>
                                <div class="row mt-2" id="relationshipInfo" style="display: none;">
                                    <div class="col-12">
                                        <hr class="my-2">
                                        <div id="relationshipBadges"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-header bg-success bg-opacity-10">
                                <h6 class="mb-0"><i class="fas fa-balance-scale me-2"></i>Current Balance</h6>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="mb-0" id="modalCurrentBalance">-</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs for transaction history -->
                <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button" role="tab">
                            <i class="fas fa-plus-circle me-2"></i>Deposits (Money In)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
                            <i class="fas fa-minus-circle me-2"></i>Payments (Money Out) <span id="paymentsTabInfo" class="badge bg-info ms-2" style="display: none;"></span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="transactionTabContent">
                    <!-- Deposits Tab -->
                    <div class="tab-pane fade show active" id="deposits" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="depositsTable">
                                <thead class="table-success">
                                    <tr>
                                        <th>Date</th>
                                        <th>Deposit Amount</th>
                                        <th>Remaining Balance</th>
                                        <th>Deposit Type</th>
                                        <th>Account No</th>
                                        <th>Transaction ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payments Tab -->
                    <div class="tab-pane fade" id="payments" role="tabpanel">
                        <div class="alert alert-info" id="paymentsInfo" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="paymentsInfoText"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="paymentsTable">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Payment Details</th>
                                        <th>Account Source</th>
                                        <th>Invoice #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#accountOverviewTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url(); ?>account/getAccountOverviewData",
            "type": "POST"
        },
        "columns": [
            { "data": 0 },
            { "data": 1 },
            { "data": 2 },
            { "data": 3, "orderable": false },
            { "data": 4, "orderable": false }
        ],
        "order": [[ 0, "desc" ]],
        "pageLength": 25,
        "responsive": true,
        "language": {
            "emptyTable": "No patients found",
            "processing": "<i class='fas fa-spinner fa-spin'></i> Loading..."
        }
    });
});

// Function to view account details
function viewAccountDetails(patientId, patientName) {
    // Show loading state
    $('#modalPatientName').text(patientName);
    $('#modalPatientId').text(patientId);
    $('#modalPatientPhone').text('Loading...');
    $('#modalCurrentBalance').text('Loading...');
    
    // Clear tables
    $('#depositsTable tbody').html('<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
    $('#paymentsTable tbody').html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
    
    // Show modal
    $('#accountDetailsModal').modal('show');
    
    // Fetch account details
    var ajaxUrl = '<?php echo base_url(); ?>account/getPatientAccountDetails';
    console.log('AJAX URL:', ajaxUrl); // Debug log
    console.log('Patient ID being sent:', patientId); // Debug log
    $.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: { patient_id: patientId },
        dataType: 'json',
        success: function(response) {
            console.log('AJAX Response:', response); // Debug log
            console.log('Patient Type - Is Dependant:', response.is_dependant, 'Is Guardian:', response.is_guardian); // Debug log
            if (response && response.success) {
                // Update patient info
                $('#modalPatientName').text(response.patient.name);
                $('#modalPatientId').text(response.patient.id);
                $('#modalPatientPhone').text(response.patient.phone);
                
                // Update balance with color coding
                var balanceClass = response.total_balance < 0 ? 'text-danger' : (response.total_balance > 0 ? 'text-success' : 'text-muted');
                $('#modalCurrentBalance').html('<span class="' + balanceClass + '">' + response.total_balance_formatted + '</span>');
                
                // Handle relationship information
                var relationshipHtml = '';
                var paymentsInfoText = '';
                var paymentsTabInfo = '';
                
                if (response.is_dependant) {
                    relationshipHtml += '<span class="badge bg-warning text-dark me-2"><i class="fas fa-user-friends me-1"></i>Dependant</span>';
                    paymentsInfoText = 'Showing only expenses made for this dependant patient using their OWN account balance (excludes expenses paid by guardian).';
                    paymentsTabInfo = 'Dependant';
                }
                
                if (response.is_guardian) {
                    relationshipHtml += '<span class="badge bg-success text-white me-2"><i class="fas fa-user-shield me-1"></i>Guardian</span>';
                    paymentsInfoText = 'Showing all expenses paid from this guardian\'s account, including expenses for dependants and self.';
                    paymentsTabInfo = 'Guardian';
                }
                
                if (relationshipHtml) {
                    $('#relationshipBadges').html(relationshipHtml);
                    $('#relationshipInfo').show();
                    $('#paymentsInfo').show();
                    $('#paymentsInfoText').text(paymentsInfoText);
                    $('#paymentsTabInfo').text(paymentsTabInfo).show();
                } else {
                    $('#relationshipInfo').hide();
                    $('#paymentsInfo').hide();
                    $('#paymentsTabInfo').hide();
                }
                
                // Populate deposits table
                var depositsHtml = '';
                if (response.account_entries.length > 0) {
                    response.account_entries.forEach(function(entry) {
                        depositsHtml += '<tr>';
                        depositsHtml += '<td>' + entry.date + '</td>';
                        depositsHtml += '<td class="text-success fw-bold">+' + response.currency + ' ' + entry.deposit_amount + '</td>';
                        depositsHtml += '<td>' + response.currency + ' ' + entry.balance_amount + '</td>';
                        depositsHtml += '<td><span class="badge bg-primary">' + entry.deposit_type + '</span></td>';
                        depositsHtml += '<td>' + (entry.account_no || '-') + '</td>';
                        depositsHtml += '<td>' + (entry.transaction_id || '-') + '</td>';
                        depositsHtml += '</tr>';
                    });
                } else {
                    depositsHtml = '<tr><td colspan="6" class="text-center text-muted">No deposits found</td></tr>';
                }
                $('#depositsTable tbody').html(depositsHtml);
                
                // Populate payments table
                var paymentsHtml = '';
                if (response.deposit_entries.length > 0) {
                    response.deposit_entries.forEach(function(entry) {
                        paymentsHtml += '<tr>';
                        paymentsHtml += '<td>' + entry.date + '</td>';
                        paymentsHtml += '<td class="text-danger fw-bold">-' + response.currency + ' ' + entry.amount + '</td>';
                        
                        // Enhanced payment details with dependent name highlighting for guardians
                        var paymentDetails = entry.payment_type;
                        if (response.is_guardian && paymentDetails.includes('(for ') && !paymentDetails.includes('(for self)')) {
                            // Extract and highlight dependent name
                            var forMatch = paymentDetails.match(/\(for ([^)]+)\)/);
                            if (forMatch && forMatch[1]) {
                                var dependentName = forMatch[1];
                                paymentDetails = paymentDetails.replace(
                                    '(for ' + dependentName + ')',
                                    '<span class="dependent-highlight">(for <strong class="text-primary">' + dependentName + '</strong>)</span>'
                                );
                            }
                        }
                        
                        paymentsHtml += '<td>' + paymentDetails + '</td>';
                        
                        // Enhanced account source display with color coding
                        var accountBadgeClass = 'bg-info';
                        if (entry.account_type.includes('Guardian')) {
                            accountBadgeClass = 'bg-success';
                        } else if (entry.account_type === 'Own Account') {
                            accountBadgeClass = 'bg-primary';
                        }
                        
                        paymentsHtml += '<td><span class="badge ' + accountBadgeClass + ' text-white">' + entry.account_type + '</span></td>';
                        paymentsHtml += '<td><a href="finance/invoice?id=' + entry.payment_id + '" target="_blank" class="btn btn-sm btn-outline-primary">#' + entry.payment_id + '</a></td>';
                        paymentsHtml += '</tr>';
                    });
                } else {
                    paymentsHtml = '<tr><td colspan="5" class="text-center text-muted">No payments found</td></tr>';
                }
                $('#paymentsTable tbody').html(paymentsHtml);
                
            } else {
                console.log('Response error:', response); // Debug log
                alert('Error: ' + (response.message || 'Unknown error'));
                $('#accountDetailsModal').modal('hide');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', xhr.responseText); // Debug log
            console.log('Status:', status, 'Error:', error); // Debug log
            alert('Error loading account details. Please try again. Status: ' + status);
            $('#accountDetailsModal').modal('hide');
        }
    });
}

// Function to refresh the table
function refreshTable() {
    $('#accountOverviewTable').DataTable().ajax.reload();
}
</script>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
}

.badge {
    font-size: 0.75rem;
}

.modal-xl {
    max-width: 1200px;
}

#accountOverviewTable td {
    vertical-align: middle;
}

.nav-tabs .nav-link {
    border-radius: 8px 8px 0 0;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    font-weight: 600;
}

/* Enhanced relationship badges */
#relationshipBadges .badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

/* Payment info alert styling */
#paymentsInfo {
    border-left: 4px solid #0dcaf0;
    background-color: rgba(13, 202, 240, 0.1);
    border-color: #0dcaf0;
}

/* Account source badge styling */
.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
}

.badge.bg-info {
    background-color: #0dcaf0 !important;
    color: #000 !important;
}

/* Table row hover effects */
#paymentsTable tbody tr:hover,
#depositsTable tbody tr:hover {
    background-color: rgba(0,0,0,0.05);
}

/* Payment tab info badge */
#paymentsTabInfo {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

/* Dependent name highlighting for guardians */
.dependent-highlight {
    background-color: rgba(13, 110, 253, 0.1);
    border-radius: 4px;
    padding: 2px 6px;
    border-left: 3px solid #0d6efd;
}

.dependent-highlight .text-primary {
    font-weight: 600;
    color: #0d6efd !important;
}
</style>
