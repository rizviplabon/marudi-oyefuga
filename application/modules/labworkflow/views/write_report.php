<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fas fa-microscope"></i> Lab Report Writing</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="labworkflow/labTests">Lab Tests</a></li>
                            <li class="breadcrumb-item active">Write Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patient Info Card -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle"></i> Patient Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Patient Name:</label>
                                    <p class="mb-1"><?php echo $patient->name; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Patient ID:</label>
                                    <p class="mb-1"><?php echo $patient->patient_id; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Age/Gender:</label>
                                    <p class="mb-1"><?php echo $patient->age . ' / ' . $patient->sex; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Phone:</label>
                                    <p class="mb-1"><?php echo $patient->phone; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Referring Doctor:</label>
                                    <p class="mb-1"><?php echo $doctor ? $doctor->name : 'N/A'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="fw-bold text-muted">Invoice ID:</label>
                                    <p class="mb-1"><?php echo $invoice_id; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="labworkflow/saveReport" method="post" id="reportForm">
            <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
            
            <!-- Specimen Management Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-vial"></i> Specimen Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="specimen_type">Specimen Type</label>
                                        <select class="form-control" name="specimen_data[specimen_type]" id="specimen_type">
                                            <option value="">Select Specimen Type</option>
                                            <?php foreach ($specimen_types as $type) { ?>
                                                <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="collection_date">Collection Date</label>
                                        <input type="datetime-local" class="form-control" name="specimen_data[collection_date]" id="collection_date" value="<?php echo date('Y-m-d\TH:i'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="collection_method">Collection Method</label>
                                        <input type="text" class="form-control" name="specimen_data[collection_method]" id="collection_method" placeholder="e.g., Venipuncture">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="container_type">Container Type</label>
                                        <select class="form-control" name="specimen_data[container_type]" id="container_type">
                                            <option value="">Select Container</option>
                                            <option value="EDTA Tube">EDTA Tube</option>
                                            <option value="Serum Tube">Serum Tube</option>
                                            <option value="Heparin Tube">Heparin Tube</option>
                                            <option value="Fluoride Tube">Fluoride Tube</option>
                                            <option value="Plain Tube">Plain Tube</option>
                                            <option value="Urine Container">Urine Container</option>
                                            <option value="Stool Container">Stool Container</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" name="specimen_data[quantity]" id="quantity" step="0.1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="quantity_unit">Unit</label>
                                        <select class="form-control" name="specimen_data[quantity_unit]" id="quantity_unit">
                                            <option value="ml">ml</option>
                                            <option value="g">g</option>
                                            <option value="tubes">tubes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="condition">Specimen Condition</label>
                                        <input type="text" class="form-control" name="specimen_data[condition]" id="condition" placeholder="e.g., Good quality, no hemolysis">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Results Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-list"></i> Test Results & Reports
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($lab_tests as $index => $test) { ?>
                                <div class="test-section mb-4 p-3" style="border: 1px solid #e3e6f0; border-radius: 8px; background-color: #f8f9fc;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="test-title mb-3">
                                                <i class="fas fa-flask text-primary"></i> 
                                                <strong><?php echo $test->category; ?></strong>
                                                <span class="badge badge-secondary ml-2">Test #<?php echo $index + 1; ?></span>
                                            </h6>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="report_<?php echo $test->id; ?>">Test Report</label>
                                                <textarea class="form-control" name="test_reports[<?php echo $test->id; ?>][report]" 
                                                         id="report_<?php echo $test->id; ?>" rows="6" 
                                                         placeholder="Enter detailed test results, observations, and findings..."><?php echo $test->report; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="interpretation_<?php echo $test->id; ?>">Clinical Interpretation</label>
                                                <textarea class="form-control" name="test_reports[<?php echo $test->id; ?>][interpretation]" 
                                                         id="interpretation_<?php echo $test->id; ?>" rows="3" 
                                                         placeholder="Clinical significance and interpretation..."><?php echo $test->interpretation; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="critical_values_<?php echo $test->id; ?>">Critical Values/Alerts</label>
                                                <textarea class="form-control" name="test_reports[<?php echo $test->id; ?>][critical_values]" 
                                                         id="critical_values_<?php echo $test->id; ?>" rows="3" 
                                                         placeholder="Any critical values or urgent findings..."><?php echo $test->critical_values; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Test Parameters Section -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="mb-3"><i class="fas fa-table"></i> Test Parameters</h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm" id="parameters_table_<?php echo $test->id; ?>">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th width="25%">Parameter</th>
                                                            <th width="20%">Result</th>
                                                            <th width="20%">Reference Range</th>
                                                            <th width="15%">Unit</th>
                                                            <th width="15%">Status</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="parameters-body">
                                                        <tr>
                                                            <td><input type="text" class="form-control form-control-sm" name="parameters[<?php echo $test->id; ?>][]" placeholder="Parameter name"></td>
                                                            <td><input type="text" class="form-control form-control-sm" name="values[<?php echo $test->id; ?>][]" placeholder="Result value"></td>
                                                            <td><input type="text" class="form-control form-control-sm" name="reference_ranges[<?php echo $test->id; ?>][]" placeholder="Normal range"></td>
                                                            <td><input type="text" class="form-control form-control-sm" name="units[<?php echo $test->id; ?>][]" placeholder="Unit"></td>
                                                            <td>
                                                                <select class="form-control form-control-sm" name="statuses[<?php echo $test->id; ?>][]">
                                                                    <option value="normal">Normal</option>
                                                                    <option value="high">High</option>
                                                                    <option value="low">Low</option>
                                                                    <option value="critical">Critical</option>
                                                                </select>
                                                            </td>
                                                            <td><button type="button" class="btn btn-sm btn-success add-parameter" data-test-id="<?php echo $test->id; ?>"><i class="fas fa-plus"></i></button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary btn-lg mr-3">
                                <i class="fas fa-save"></i> Save Report
                            </button>
                            <button type="button" class="btn btn-secondary btn-lg mr-3" onclick="saveDraft()">
                                <i class="fas fa-file-alt"></i> Save as Draft
                            </button>
                            <a href="labworkflow/labTests" class="btn btn-light btn-lg">
                                <i class="fas fa-arrow-left"></i> Back to Tests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<!--main content end-->

<!-- Custom CSS -->
<style>
.info-item {
    margin-bottom: 1rem;
}

.test-section {
    transition: all 0.3s ease;
}

.test-section:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.test-title {
    color: #2c3e50;
    font-size: 1.1rem;
}

.parameters-body input, .parameters-body select {
    border: 1px solid #ddd;
}

.card {
    margin-bottom: 1.5rem;
}

.badge {
    font-size: 0.8rem;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1rem;
}
</style>

<!-- JavaScript -->
<script src="common/js/codearistos.min.js"></script>
<script>
$(document).ready(function() {
    // Add parameter row functionality
    $('.add-parameter').on('click', function() {
        var testId = $(this).data('test-id');
        var table = $('#parameters_table_' + testId + ' tbody');
        
        var newRow = `
            <tr>
                <td><input type="text" class="form-control form-control-sm" name="parameters[${testId}][]" placeholder="Parameter name"></td>
                <td><input type="text" class="form-control form-control-sm" name="values[${testId}][]" placeholder="Result value"></td>
                <td><input type="text" class="form-control form-control-sm" name="reference_ranges[${testId}][]" placeholder="Normal range"></td>
                <td><input type="text" class="form-control form-control-sm" name="units[${testId}][]" placeholder="Unit"></td>
                <td>
                    <select class="form-control form-control-sm" name="statuses[${testId}][]">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                        <option value="critical">Critical</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-sm btn-danger remove-parameter"><i class="fas fa-minus"></i></button></td>
            </tr>
        `;
        
        table.append(newRow);
    });
    
    // Remove parameter row functionality
    $(document).on('click', '.remove-parameter', function() {
        $(this).closest('tr').remove();
    });
    
    // Form validation
    $('#reportForm').on('submit', function(e) {
        var hasResults = false;
        $('textarea[name*="[report]"]').each(function() {
            if ($(this).val().trim() !== '') {
                hasResults = true;
                return false;
            }
        });
        
        if (!hasResults) {
            e.preventDefault();
            alert('Please enter at least one test result before saving.');
            return false;
        }
    });
});

function saveDraft() {
    console.log('Draft saved automatically');
}
</script> 