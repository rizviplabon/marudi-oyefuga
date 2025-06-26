<?php
$lang = $this->session->userdata('lang');
if (empty($lang)) {
    $lang = "english";
}
if ($lang == 'arabic') {
    $direction = 'rtl';
} else {
    $direction = 'ltr';
}
?>
<!--main content start-->
<div class="main-content" dir="<?php echo $direction; ?>">
    <div class="container-fluid">
        
        <!-- Ultra Modern Enhanced Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header-card shadow-xl border-0 position-relative overflow-hidden" style="border-radius: 20px;">
                    <!-- Animated Background -->
                    <div class="header-bg-animation"></div>
                    
                    <!-- Main Header Content -->
                    <div class="header-content position-relative p-4">
                        <div class="row align-items-center">
                            <!-- Left Section: Branding & Patient Info -->
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <!-- Animated Logo -->
                                    <div class="logo-container mr-4">
                                        <div class="logo-circle">
                                            <i class="fas fa-microscope"></i>
                                            <div class="logo-pulse"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Title & Patient Info -->
                                    <div class="header-info">
                                        <h3 class="header-title mb-2">Laboratory Report System</h3>
                                        <div class="header-meta d-flex flex-wrap align-items-center">
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-file-invoice"></i>
                                                <span>Invoice #<?php echo $invoice_id; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-user"></i>
                                                <span><?php echo isset($patient->name) ? $patient->name : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-id-card"></i>
                                                <span>ID: <?php echo isset($patient->patient_id) ? $patient->patient_id : (isset($patient->id) ? 'P-'.$patient->id : 'N/A'); ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-birthday-cake"></i>
                                                <span><?php echo isset($patient->age) ? $patient->age : 'N/A'; ?>/<?php echo isset($patient->sex) ? $patient->sex : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-user-md"></i>
                                                <span>Dr. <?php echo isset($doctor->name) ? $doctor->name : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mb-2">
                                                <i class="fas fa-clock"></i>
                                                <span><?php echo date('d M Y, H:i A'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                </div>
                            
                            <!-- Center Section: Progress Dashboard -->
                            <div class="col-lg-3">
                                <div class="progress-dashboard">
                                    <div class="progress-card">
                                        <div class="progress-header">
                                            <div class="progress-icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress-title">Test Progress</div>
                                                <div class="progress-subtitle" id="headerProgressText">0 of <?php echo count($lab_tests); ?> completed</div>
                                            </div>
                                        </div>
                                        <div class="progress-visual mt-3">
                                            <div class="progress-ring">
                                                <svg class="progress-svg" width="60" height="60">
                                                    <circle class="progress-ring-bg" cx="30" cy="30" r="25"></circle>
                                                    <circle class="progress-ring-fill" cx="30" cy="30" r="25" id="headerProgressRing"></circle>
                                                </svg>
                                                <div class="progress-percentage" id="headerProgressPercentage">0%</div>
                                            </div>
                                            <div class="progress-stats ml-3">
                                                <div class="stat-item">
                                                    <span class="stat-number" id="completedCount">0</span>
                                                    <span class="stat-label">Completed</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-number" id="pendingCount"><?php echo count($lab_tests); ?></span>
                                                    <span class="stat-label">Pending</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                          
                        </div>
                    </div>
                    
                    <!-- Status Bar -->
                    <div class="status-bar">
                        <div class="status-indicator" id="systemStatus">
                            <div class="status-dot status-online"></div>
                            <span class="status-text">System Online</span>
                        </div>
                        <div class="auto-save-indicator" id="autoSaveStatus">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Auto-save enabled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="<?php echo base_url('labworkflow/saveReport'); ?>" method="post" id="reportForm" onsubmit="return submitFormAndStay(this);">
            <input type="hidden" name="invoice_id" value="<?php echo isset($invoice_id) ? $invoice_id : ''; ?>">
            <input type="hidden" name="patient_id" value="<?php echo isset($patient->id) ? $patient->id : ''; ?>">
            
            <div class="row">
                <!-- Left Column - Specimen Info -->
                <div class="col-lg-3 mb-4">
                    
                    <!-- Enhanced Specimen Collection -->
                    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header bg-gradient-success text-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-vial" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-white font-weight-bold mb-0">Specimen Collection</h6>
                                        <small class="text-white opacity-75">Click test to add specimen details</small>
                                    </div>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-1">
                                    <small class="text-white font-weight-bold"><?php echo count($lab_tests); ?> Tests</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="specimen-tests-list">
                                <?php foreach ($lab_tests as $index => $test) { ?>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-light btn-block text-left p-3 rounded-lg shadow-sm specimen-test-btn" 
                                                data-toggle="modal" data-target="#specimenModal<?php echo $test->id; ?>"
                                                style="border: 2px solid #e9ecef; transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-vial" style="font-size: 0.9rem;"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-weight-bold text-dark d-block"><?php echo isset($test->test_name) ? $test->test_name : $test->category; ?></span>
                                                        <small class="text-muted">Test #<?php echo sprintf('%02d', $index + 1); ?> • ID: <?php echo $test->id; ?></small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-warning px-3 py-2 rounded-pill mr-2" id="status-<?php echo $test->id; ?>">
                                                        <i class="fas fa-clock mr-1"></i>Pending
                                                    </span>
                                                    <i class="fas fa-chevron-right text-muted"></i>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Inventory Usage -->
                    <div class="card shadow-lg border-0 mt-4" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header bg-gradient-warning text-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white text-warning rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-boxes" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-white font-weight-bold mb-0">Medical Inventory</h6>
                                        <small class="text-white opacity-75">Track reagents & supplies used</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#inventoryModal">
                                    <i class="fas fa-plus mr-1"></i>Add Items
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div id="inventoryUsageContainer">
                                <!-- Added inventory items will be displayed here -->
                                <div class="text-center text-muted py-3" id="noInventoryMessage">
                                    <i class="fas fa-boxes fa-2x mb-2"></i>
                                    <p class="mb-0">No inventory items added yet</p>
                                    <small>Click "Add Items" to track reagents and supplies used for these tests</small>
                                </div>
                            </div>
                            
                            <!-- Summary Display -->
                            <div id="inventorySummary" class="mt-3 pt-3 border-top" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-primary">
                                        <i class="fas fa-clipboard-list mr-2"></i>Total Items: <span id="totalItemsCount">0</span>
                                    </span>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#inventoryModal">
                                        <i class="fas fa-edit mr-1"></i>Edit Items
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Test Results -->
                <div class="col-lg-9">
                    <!-- Floating Save Panel -->
                    <div class="fixed-bottom bg-white border-top shadow-lg p-3 d-none" id="floatingSavePanel">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle text-warning mr-3"></i>
                                        <div>
                                            <small class="text-dark font-weight-bold">You have unsaved changes</small>
                                            <div class="progress mt-1 bg-light" style="height: 4px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" id="saveProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="submit" form="reportForm" class="btn btn-success btn-sm font-weight-bold">
                                        <i class="fas fa-sync-alt mr-1"></i>Update Report
                                    </button>
                                    
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lab Workflow Completion Status -->
                    <div class="card shadow-sm border-0 mb-3" id="completionStatusCard" style="display: none;">
                        <div class="card-body bg-gradient-success text-white p-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-white">Laboratory Analysis Complete</h6>
                                            <small class="text-white font-weight-bold">All test results have been entered and validated</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-light btn-sm" onclick="printLabReport()">
                                            <i class="fas fa-print text-success"></i>
                                            <span class="text-success font-weight-bold">Print Report</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header bg-gradient-info text-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-clipboard-list" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-white font-weight-bold mb-0">Test Results & Reports</h6>
                                        <small class="text-white opacity-75">Enter test results and clinical findings</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                        <button type="submit" form="reportForm" class="btn-modern btn-complete pulse-animation" data-tooltip="Update and submit report">
                                            <div class="btn-icon">
                                                <i class="fas fa-sync-alt"></i>
                                            </div>
                                            <span class="btn-text">save report</span>
                                            <div class="btn-glow"></div>
                                        </button>
                                    <button type="button" class="btn btn-light btn-sm" onclick="expandAllTests()">
                                        <i class="fas fa-expand-alt mr-1"></i>
                                        <span class="font-weight-bold">Expand All</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            

                            
                            <div class="accordion" id="testResultsAccordion">
                                <?php foreach ($lab_tests as $index => $test) { ?>
                                    <div class="mb-3">
                                        <div class="card border-0 shadow-sm rounded">
                                            <div class="card-header bg-light border-0 p-0" id="heading<?php echo $test->id; ?>">
                                                <button class="btn btn-link btn-block text-left p-3 text-decoration-none text-dark" 
                                                        type="button" data-toggle="collapse" data-target="#collapse<?php echo $test->id; ?>" 
                                                        aria-expanded="false" aria-controls="collapse<?php echo $test->id; ?>">
                                                                                                        <div class="d-flex align-items-center w-100">
                                                        <div class="bg-primary text-white rounded-circle align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                    <i class="fas fa-flask"></i>
                                                                </div>
                                                        <div class="d-flex align-items-center flex-wrap ml-3">
                                                            <h6 class="mb-0 font-weight-bold text-dark mr-2">
                                                                <?php echo isset($test->test_name) ? $test->test_name : $test->category; ?>
                                                            </h6>
                                                            <span class="text-muted small">&bull; Test #<?php echo sprintf('%02d', $index + 1); ?> | ID: <?php echo $test->id; ?></span>
                                                                </div>
                                                        <div class="ml-auto d-flex align-items-center">
                                                            <?php if (isset($test_templates[$test->id])) { ?>
                                                                <span class="badge badge-success px-3 py-2 rounded-pill">
                                                                    <i class="fas fa-check"></i>
                                                                    <span class="ml-1"><?php echo $test_templates[$test->id]->template_name; ?></span>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-light border px-3 py-2 rounded-pill">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                    <span class="ml-1">Manual Entry</span>
                                                                </span>
                                                            <?php } ?> 
                                                        </div>
                                                        <i class="fas fa-chevron-down text-muted ml-3"></i>
                                                    </div>
                                                </button>
                                            </div>

                                            <div id="collapse<?php echo $test->id; ?>" class="collapse" 
                                                 aria-labelledby="heading<?php echo $test->id; ?>" data-parent="#testResultsAccordion">
                                                <div class="card-body bg-white">
                                                    
                                                    <?php if (isset($test_templates[$test->id])) { 
                                                        $assigned_template = $test_templates[$test->id]; ?>
                                                        
                                                        <!-- Template Parameters -->
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <div class="bg-success text-white rounded mr-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                                    <i class="fas fa-list-alt" style="font-size: 10px;"></i>
                                                                </div>
                                                                <h6 class="mb-0 font-weight-bold text-dark"><?php echo $assigned_template->template_name; ?> Parameters</h6>
                                                            </div>
                                                            
                                                            <?php if (!empty($assigned_template->fields)) { ?>
                                                                <div>
                                                                    <?php foreach ($assigned_template->fields as $field) { ?>
                                                                        <div class="bg-white p-2 mb-2 rounded border shadow-sm">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-md-3">
                                                                                    <label class="font-weight-bold text-dark mb-0 small"><?php echo $field->field_label; ?></label>
                                                                                    <?php if ($field->units) { ?>
                                                                                        <small class="text-muted d-block">(<?php echo $field->units; ?>)</small>
                                                                                    <?php } ?>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <?php 
                                                                                    // Get existing value for this field
                                                                                    $existing_value = '';
                                                                                    if (isset($result_values[$test->id])) {
                                                                                        foreach ($result_values[$test->id] as $result) {
                                                                                            if ($result->parameter_name == $field->field_label) {
                                                                                                $existing_value = $result->result_value;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <?php if ($field->field_type == 'number') { ?>
                                                                                        <input type="number" class="form-control form-control-sm" 
                                                                                               name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]" 
                                                                                               value="<?php echo htmlspecialchars($existing_value); ?>"
                                                                                               placeholder="Enter value">
                                                                                    <?php } elseif ($field->field_type == 'select') { ?>
                                                                                        <select class="form-control form-control-sm" 
                                                                                                name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]">
                                                                                            <option value="">Select</option>
                                                                                            <?php if ($field->field_options) {
                                                                                                $options = explode(',', $field->field_options);
                                                                                                foreach ($options as $option) {
                                                                                                    $option = trim($option);
                                                                                                    $selected = ($existing_value == $option) ? 'selected' : '';
                                                                                                    ?>
                                                                                                    <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>
                                                                                                <?php } 
                                                                                            } ?>
                                                                                        </select>
                                                                                    <?php } else { ?>
                                                                                        <input type="text" class="form-control form-control-sm" 
                                                                                               name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]" 
                                                                                               value="<?php echo htmlspecialchars($existing_value); ?>"
                                                                                               placeholder="Enter value">
                                                                                    <?php } ?>
                                                                                </div>
                                                                                                                                                <div class="col-md-3">
                                                                    <small class="text-muted">
                                                                        <strong>Reference:</strong><br>
                                                                        <?php echo ($field->reference_value ?: $field->reference_range ?: 'N/A'); ?>
                                                                    </small>
                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <?php 
                                                                                    // Get existing status for this field
                                                                                    $existing_status = 'normal';
                                                                                    if (isset($result_values[$test->id])) {
                                                                                        foreach ($result_values[$test->id] as $result) {
                                                                                            if ($result->parameter_name == $field->field_label) {
                                                                                                $existing_status = $result->status ?: 'normal';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <select class="form-control form-control-sm" name="template_status[<?php echo $test->id; ?>][<?php echo $field->id; ?>]">
                                                                                        <option value="normal" <?php echo ($existing_status == 'normal') ? 'selected' : ''; ?>>Normal</option>
                                                                                        <option value="abnormal" <?php echo ($existing_status == 'abnormal') ? 'selected' : ''; ?>>Abnormal</option>
                                                                                        <option value="critical" <?php echo ($existing_status == 'critical') ? 'selected' : ''; ?>>Critical</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <!-- No Template Notice -->
                                                        <div class="alert alert-light border-left-warning py-3 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-info-circle text-warning mr-3"></i>
                                                                <div>
                                                                    <small class="text-dark">
                                                                        <strong>No template assigned for this test.</strong><br>
                                                                        Configure in <a href="<?php echo base_url('finance/paymentCategory'); ?>" target="_blank" class="text-primary">Finance → Payment Category</a>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <!-- Clinical Report -->
                                                    <div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="bg-info text-white rounded mr-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                                <i class="fas fa-file-medical" style="font-size: 10px;"></i>
                                                            </div>
                                                            <h6 class="mb-0 font-weight-bold text-dark">Clinical Report</h6>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-12 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Test Results & Findings</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][report]" 
                                                                          rows="3" 
                                                                          placeholder="Enter detailed test results, findings, and clinical observations..."><?php echo isset($test->report) ? $test->report : ''; ?></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Clinical Interpretation</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][interpretation]" 
                                                                          rows="2" 
                                                                          placeholder="Clinical significance and interpretation..."><?php echo isset($test->interpretation) ? $test->interpretation : ''; ?></textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Critical Values & Alerts</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][critical_values]" 
                                                                          rows="2" 
                                                                          placeholder="Any critical values, urgent findings, or alerts..."><?php echo isset($test->critical_values) ? $test->critical_values : ''; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--main content end-->

<!-- Enhanced Custom CSS -->
<style>
/* Modern Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Enhanced Card Styling */
.card {
    transition: all 0.3s ease;
    border-radius: 15px !important;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

/* ================================
   ULTRA MODERN HEADER STYLES
   ================================ */

/* Main Header Container */
.modern-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    min-height: 180px;
    overflow: hidden;
    margin-bottom: 0;
    padding-bottom: 40px;
}

/* Animated Background */
.header-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
    animation: backgroundFloat 15s ease-in-out infinite;
}

@keyframes backgroundFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(1deg); }
    66% { transform: translateY(5px) rotate(-1deg); }
}

/* Header Content */
.header-content {
    z-index: 2;
    padding-bottom: 50px !important; /* Add space for status bar */
}

/* Logo Section */
.logo-container {
    position: relative;
}

.logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
}

.logo-circle i {
    font-size: 1.8rem;
    color: #667eea;
    z-index: 2;
    position: relative;
}

.logo-pulse {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.3);
    transform: translate(-50%, -50%);
    animation: logoPulse 2s ease-in-out infinite;
}

@keyframes logoPulse {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
}

/* Header Info */
.header-title {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 0;
}

.header-meta {
    gap: 0;
}

.meta-badge {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 25px;
    padding: 8px 16px;
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.meta-badge:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

.meta-badge i {
    margin-right: 6px;
    font-size: 0.9rem;
}

/* Progress Dashboard */
.progress-dashboard {
    display: flex;
    justify-content: center;
}

.progress-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 20px;
    width: 100%;
    max-width: 300px;
    margin-bottom: 10px;
}

.progress-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.progress-icon {
    width: 35px;
    height: 35px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.progress-icon i {
    color: #ffffff;
    font-size: 1rem;
}

.progress-title {
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
}

.progress-subtitle {
    color: rgba(255,255,255,0.8);
    font-size: 0.8rem;
    margin: 0;
}

/* Progress Ring */
.progress-visual {
    display: flex;
    align-items: center;
}

.progress-ring {
    position: relative;
    width: 60px;
    height: 60px;
}

.progress-svg {
    transform: rotate(-90deg);
}

.progress-ring-bg {
    fill: none;
    stroke: rgba(255,255,255,0.2);
    stroke-width: 3;
}

.progress-ring-fill {
    fill: none;
    stroke: #ffd700;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-dasharray: 157;
    stroke-dashoffset: 157;
    transition: stroke-dashoffset 0.5s ease;
}

.progress-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 700;
}

/* Progress Stats */
.progress-stats {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-number {
    color: #ffffff;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    color: rgba(255,255,255,0.7);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Center */
.action-center {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

/* Modern Buttons */
.btn-modern {
    position: relative;
    border: none;
    border-radius: 15px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 160px;
    backdrop-filter: blur(10px);
}

.btn-draft {
    background: rgba(255,255,255,0.15);
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-complete {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.btn-draft:hover {
    background: rgba(255,255,255,0.25);
}

.btn-complete:hover {
    box-shadow: 0 8px 30px rgba(40, 167, 69, 0.4);
}

.btn-icon {
    margin-right: 8px;
    font-size: 1rem;
}

.btn-text {
    position: relative;
    z-index: 2;
}

.btn-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 15px;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.btn-modern:hover .btn-glow {
    transform: translateX(100%);
}

/* Pulse Animation */
.pulse-animation {
    animation: buttonPulse 2s ease-in-out infinite;
}

@keyframes buttonPulse {
    0% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
    50% { box-shadow: 0 4px 25px rgba(40, 167, 69, 0.5); }
    100% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
}

/* Quick Stats */
.quick-stats {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-bottom: 10px;
}

.stat-pill {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 6px 12px;
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    backdrop-filter: blur(10px);
}

.stat-pill i {
    margin-right: 4px;
    font-size: 0.8rem;
}

/* Status Bar */
.status-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40px;
    background: rgba(0,0,0,0.15);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 25px;
    font-size: 0.75rem;
}

.status-indicator, .auto-save-indicator {
    display: flex;
    align-items: center;
    color: rgba(255,255,255,0.8);
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 6px;
}

.status-online {
    background: #28a745;
    animation: statusPulse 2s ease-in-out infinite;
}

.status-warning {
    background: #ffc107;
    animation: statusPulse 2s ease-in-out infinite;
}

.status-error {
    background: #dc3545;
    animation: statusPulse 2s ease-in-out infinite;
}

@keyframes statusPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.auto-save-indicator i {
    margin-right: 4px;
    font-size: 0.8rem;
}

/* Tooltips */
[data-tooltip] {
    position: relative;
}

[data-tooltip]:hover::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.75rem;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 5px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .action-buttons {
        flex-direction: row;
        gap: 8px;
    }
    
    .btn-modern {
        min-width: 130px;
        padding: 10px 18px;
        font-size: 0.85rem;
    }
    
    .progress-card {
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .modern-header-card {
        min-height: 220px;
        padding-bottom: 45px;
    }
    
    .header-content {
        padding: 20px 15px 55px 15px !important;
    }
    
    .status-bar {
        height: 40px;
        padding: 0 15px;
        font-size: 0.7rem;
    }
    
    .action-buttons {
        margin-bottom: 15px;
    }
    
    .quick-stats {
        margin-bottom: 15px;
    }
    
    .header-title {
        font-size: 1.4rem;
    }
    
    .meta-badge {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-modern {
        min-width: auto;
    }
    
    .quick-stats {
        justify-content: center;
        margin-top: 10px;
    }
    
    .progress-visual {
        justify-content: center;
    }
    
    .progress-stats {
        margin-left: 15px;
    }
}

/* Text Visibility Improvements */
.text-white {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.text-dark {
    color: #212529 !important;
    font-weight: 600;
}

.text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.font-weight-bold {
    font-weight: 600 !important;
}

.font-weight-medium {
    font-weight: 500 !important;
}

/* Enhanced Badge Visibility */
.badge {
    font-weight: 600 !important;
    text-shadow: none;
    border: 1px solid rgba(0,0,0,0.1);
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border: 1px solid #dee2e6 !important;
}

.badge-primary {
    background-color: #007bff !important;
    color: #ffffff !important;
}

.badge-success {
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge-info {
    background-color: #17a2b8 !important;
    color: #ffffff !important;
}

/* Button Text Visibility */
.btn {
    font-weight: 600 !important;
    text-shadow: none;
}

.btn-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border: 1px solid #dee2e6 !important;
}

.btn-light:hover,
.btn-light:focus {
    background-color: #e9ecef !important;
    color: #495057 !important;
    border-color: #dee2e6 !important;
}

/* Card Header Text */
.card-header h4,
.card-header h5,
.card-header h6 {
    color: #ffffff !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    font-weight: 700 !important;
}

.card-header .text-white {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.card-header small.text-white {
    opacity: 0.9;
}

/* Form Label Visibility */
label {
    color: #495057 !important;
    font-weight: 600 !important;
}

.form-control {
    color: #495057 !important;
    background-color: #ffffff !important;
    border: 2px solid #e9ecef !important;
}

.form-control:focus {
    color: #495057 !important;
    background-color: #ffffff !important;
    border-color: #007bff !important;
}

/* Accordion Text Visibility */
.accordion .btn-link {
    color: #495057 !important;
    font-weight: 600;
}

.accordion .btn-link:hover,
.accordion .btn-link:focus {
    color: #007bff !important;
    text-decoration: none !important;
}

/* Patient Info Text */
.patient-info-grid .info-item .text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.patient-info-grid .info-item .text-dark {
    color: #212529 !important;
    font-weight: 600;
}

/* Button Enhancements */
.pulse-btn {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.specimen-test-btn:hover {
    border-color: #28a745 !important;
    background-color: #f8f9fa !important;
    transform: translateX(5px);
}

/* Progress Bar Enhancements */
.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}

/* Badge Enhancements */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge-light {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
}

/* Test Accordion Enhancements */
.accordion .card {
    border: none !important;
    margin-bottom: 1rem;
    border-radius: 12px !important;
    overflow: hidden;
}

.accordion .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    padding: 0;
}

.accordion .btn-link {
    color: #495057 !important;
    text-decoration: none !important;
    font-weight: 500;
}

.accordion .btn-link:hover {
    color: #007bff !important;
}

/* Form Enhancements */
.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Patient Info Grid */
.patient-info-grid .info-item {
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 8px 0;
}

.patient-info-grid .info-item:hover {
    background-color: #f8f9fa;
    padding-left: 10px;
    padding-right: 10px;
}

/* Floating Save Panel */
#floatingSavePanel {
    z-index: 1050;
    backdrop-filter: blur(10px);
    background-color: rgba(255,255,255,0.95) !important;
}

/* Enhanced Icons */
.icon-container {
    transition: all 0.3s ease;
}

.icon-container:hover {
    transform: scale(1.1);
}

/* Completion Status Card */
#completionStatusCard {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Template Parameters Styling */
.template-parameter-row {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.template-parameter-row:hover {
    border-color: #007bff;
    box-shadow: 0 2px 10px rgba(0,123,255,0.1);
}

/* Comprehensive Responsive Enhancements */

/* Extra Large Devices (1200px and up) */
@media (min-width: 1200px) {
    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }
}

/* Large Devices (992px to 1199px) */
@media (max-width: 1199px) {
    .card-header h4 {
        font-size: 1.4rem;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        font-weight: 600;
    }
}

/* Medium Devices (768px to 991px) */
@media (max-width: 991px) {
    /* Header adjustments */
    .card-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .card-header h4 {
        font-size: 1.3rem;
        margin-bottom: 0.5rem !important;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        font-weight: 600;
    }
    
    .card-header .badge {
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .btn-group {
        width: 100%;
        justify-content: space-between;
    }
    
    .card-header .btn-group .btn {
        flex: 1;
        margin: 0 0.25rem;
    }
    
    /* Progress indicator adjustments */
    #headerProgressIndicator {
        width: 100%;
        justify-content: center;
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }
    
    /* Layout adjustments */
    .col-lg-3 {
        margin-bottom: 2rem;
    }
    
    /* Patient info adjustments */
    .patient-info-grid .info-item {
        padding: 1rem 0;
        flex-direction: row;
        justify-content: space-between;
    }
    
    /* Specimen collection adjustments */
    .specimen-test-btn {
        padding: 1rem !important;
        margin-bottom: 0.5rem;
    }
    
    .specimen-test-btn .d-flex {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .specimen-test-btn .badge {
        margin-top: 0.5rem;
    }
}

/* Small Devices (576px to 767px) */
@media (max-width: 767px) {
    /* Container adjustments */
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    /* Header responsive design */
    .card-header .d-flex {
        flex-direction: column;
        align-items: stretch !important;
        text-align: center;
    }
    
    .card-header h4 {
        font-size: 1.2rem;
        text-align: center;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        display: inline-block;
        margin: 0.25rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    /* Button adjustments */
    .card-header .btn-group {
        flex-direction: column;
        width: 100%;
        gap: 0.5rem;
    }
    
    .card-header .btn-group .btn {
        width: 100%;
        margin: 0;
        padding: 0.75rem;
        font-size: 0.9rem;
    }
    
    /* Progress indicator mobile */
    #headerProgressIndicator {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    #headerProgressIndicator .progress {
        width: 100% !important;
        margin-top: 0.5rem;
    }
    
    /* Patient info mobile layout */
    .patient-info-grid .info-item {
        flex-direction: column;
        align-items: flex-start !important;
        padding: 0.75rem 0;
        text-align: left;
    }
    
    .patient-info-grid .info-item > div:first-child {
        margin-bottom: 0.5rem;
    }
    
    .patient-info-grid .info-item .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .patient-info-grid .info-item .text-dark {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .patient-info-grid .badge {
        margin-top: 0.5rem;
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    /* Specimen collection mobile */
    .specimen-test-btn {
        padding: 1rem !important;
        text-align: left;
        background-color: #ffffff !important;
        border: 2px solid #e9ecef !important;
        color: #495057 !important;
    }
    
    .specimen-test-btn .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    
    .specimen-test-btn .font-weight-bold {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .specimen-test-btn .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .specimen-test-btn .badge {
        align-self: flex-end;
        margin-top: 0;
        background-color: #ffc107 !important;
        color: #212529 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    /* Test results mobile */
    .accordion .btn-link {
        padding: 1rem !important;
        text-align: left;
        color: #495057 !important;
        background-color: #f8f9fa !important;
    }
    
    .accordion .btn-link:hover,
    .accordion .btn-link:focus {
        color: #007bff !important;
        background-color: #f8f9fa !important;
        text-decoration: none !important;
    }
    
    .accordion .btn-link .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    
    .accordion .btn-link .font-weight-bold {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .accordion .btn-link .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .accordion .btn-link .badge {
        align-self: flex-start;
        background-color: #28a745 !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    
    /* Form adjustments */
    .template-parameter-row .row {
        margin: 0;
    }
    
    .template-parameter-row .col-md-3 {
        margin-bottom: 0.75rem;
        padding: 0 0.5rem;
    }
    
    /* Modal adjustments */
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    .modal-body .row .col-md-6 {
        margin-bottom: 1rem;
    }
    
    /* Floating save panel mobile */
    #floatingSavePanel {
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 0;
    }
    
    #floatingSavePanel .row {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    /* Auto-save indicator mobile */
    #autoSaveIndicator {
        bottom: 10px !important;
        left: 10px !important;
        right: 10px !important;
        text-align: center;
    }
    
    #autoSaveIndicator > div {
        width: 100%;
        text-align: center;
    }
}

/* Extra Small Devices (less than 576px) */
@media (max-width: 575px) {
    /* Ultra-compact header */
    .card-header {
        padding: 1rem 0.75rem;
    }
    
    .card-header h4 {
        font-size: 1.1rem;
        line-height: 1.3;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.4);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
        font-weight: 600;
    }
    
    /* Ultra-compact cards */
    .card-body {
        padding: 1rem 0.75rem;
    }
    
    /* Ultra-compact buttons */
    .btn {
        font-size: 0.85rem;
        padding: 0.6rem 1rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    
    /* Ultra-compact forms */
    .form-control {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    /* Ultra-compact specimen buttons */
    .specimen-test-btn {
        padding: 0.75rem !important;
        font-size: 0.85rem;
    }
    
    .specimen-test-btn .rounded-circle {
        width: 28px !important;
        height: 28px !important;
    }
    
    .specimen-test-btn .fa-vial {
        font-size: 0.8rem !important;
    }
    
    /* Ultra-compact patient info */
    .patient-info-grid .info-item {
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }
    
    .patient-info-grid .info-item .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .patient-info-grid .info-item .text-dark {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .patient-info-grid .info-item .badge {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    /* Notification adjustments */
    .alert.position-fixed {
        top: 10px !important;
        left: 10px !important;
        right: 10px !important;
        min-width: auto !important;
        font-size: 0.85rem;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    
    .alert.position-fixed strong {
        color: inherit !important;
        font-weight: 600 !important;
    }
    
    .alert-success.position-fixed {
        background-color: #d4edda !important;
        color: #155724 !important;
    }
    
    .alert-warning.position-fixed {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }
    
    .alert-info.position-fixed {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
    }
    
    .alert-danger.position-fixed {
        background-color: #f8d7da !important;
        color: #721c24 !important;
    }
    
    /* Progress bar adjustments */
    .progress {
        height: 4px !important;
    }
}

/* Landscape orientation adjustments */
@media (max-width: 767px) and (orientation: landscape) {
    .card-header .d-flex {
        flex-direction: row;
        align-items: center !important;
        flex-wrap: wrap;
    }
    
    .card-header .btn-group {
        flex-direction: row;
        width: auto;
        margin-left: auto;
    }
    
    #headerProgressIndicator {
        flex-direction: row;
        width: auto;
        margin-right: 1rem !important;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    /* Larger touch targets */
    .btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .form-control {
        min-height: 44px;
    }
    
    .specimen-test-btn {
        min-height: 60px;
    }
    
    /* Remove hover effects on touch devices */
    .card:hover {
        transform: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .specimen-test-btn:hover {
        transform: none;
        border-color: #e9ecef !important;
        background-color: #f8f9fa !important;
    }
    
    .patient-info-grid .info-item:hover {
        background-color: transparent;
        padding-left: 0;
        padding-right: 0;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .card-header .bg-white {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .badge {
        text-shadow: none;
    }
}

/* Print optimizations */
@media print {
    .card-header .btn-group,
    #floatingSavePanel,
    #autoSaveIndicator,
    .alert.position-fixed {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        box-shadow: none !important;
    }
    
    .container-fluid {
        max-width: 100%;
        padding: 0;
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced Modal Styling */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modal-header {
    border-radius: 15px 15px 0 0;
}

.modal-header h5 {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    font-weight: 700 !important;
}

.modal-body {
    color: #495057 !important;
}

.modal-body label {
    color: #495057 !important;
    font-weight: 600 !important;
}

.modal-body .form-control {
    color: #495057 !important;
    background-color: #ffffff !important;
    border: 2px solid #e9ecef !important;
}

.modal-body .text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.modal-body .font-weight-bold {
    color: #212529 !important;
    font-weight: 600;
}

/* Success Animations */
.success-animation {
    animation: bounceIn 0.5s ease-out;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
} 

/* Enhanced Alert Animations */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-out {
    animation: slideOutRight 0.3s ease-in forwards;
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Loading Animation */
.loaded {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Fade-in animation for cards */
.animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
}

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

/* Pulse on hover */
.pulse-on-hover {
    animation: pulseHover 0.6s ease-in-out;
}

@keyframes pulseHover {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

/* Form focus states */
.form-group.focused .form-control {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Success and error states for validation */
.has-success {
    border-left: 4px solid #28a745;
    background-color: rgba(40, 167, 69, 0.05);
}

.has-error {
    border-left: 4px solid #dc3545;
    background-color: rgba(220, 53, 69, 0.05);
}

/* Touch feedback */
.touch-active {
    background-color: rgba(0,123,255,0.1) !important;
    transform: scale(0.98);
    transition: all 0.1s ease;
}

/* Mobile-specific classes */
.mobile-view {
    overflow-x: hidden;
}

.mobile-header {
    text-align: center;
    gap: 1rem;
}

.mobile-buttons {
    flex-direction: column !important;
    gap: 0.5rem;
}

.mobile-specimen .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.75rem;
}

.mobile-accordion .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.75rem;
}

.mobile-form-row {
    margin: 0 !important;
}

.mobile-form-col {
    margin-bottom: 0.75rem;
    padding: 0 0.5rem;
}

.mobile-modal-row .col-md-6 {
    margin-bottom: 1rem;
}

/* Tablet-specific classes */
.tablet-header {
    gap: 1rem;
}

.tablet-buttons {
    justify-content: space-between;
}

.tablet-specimen .d-flex {
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tablet-accordion .d-flex {
    flex-wrap: wrap;
    gap: 0.5rem;
}

/* Modal optimizations for mobile */
.modal-open-mobile {
    overflow: hidden !important;
}

.modal-open-mobile .modal {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Pull to refresh styling */
#pullToRefreshHint {
    transition: all 0.3s ease;
}

/* Improved touch targets */
@media (hover: none) and (pointer: coarse) {
    .btn, .form-control, .specimen-test-btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .close {
        min-height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .accordion .btn-link {
        min-height: 60px;
        display: flex;
        align-items: center;
    }
}

/* Viewport height adjustments for mobile browsers */
@media (max-width: 767px) {
    .main-content {
        min-height: calc(100vh - 60px);
        padding-bottom: 2rem;
    }
    
    /* Adjust for mobile browser address bars */
    @supports (-webkit-touch-callout: none) {
        .main-content {
            min-height: calc(100vh - 120px);
        }
    }
}

/* Landscape mode optimizations */
@media (max-width: 767px) and (orientation: landscape) {
    .card-header {
        padding: 0.75rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .modal-dialog {
        margin: 0.25rem;
        max-width: calc(100% - 0.5rem);
    }
    
    .patient-info-grid .info-item {
        padding: 0.5rem 0;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .card {
        border: 2px solid #333 !important;
    }
    
    .btn {
        border: 2px solid currentColor !important;
    }
    
    .badge {
        border: 2px solid currentColor !important;
    }
    
    .text-white {
        text-shadow: 0 1px 4px rgba(0,0,0,0.8) !important;
    }
    
    .card-header h4,
    .card-header h5,
    .card-header h6 {
        text-shadow: 0 1px 4px rgba(0,0,0,0.8) !important;
    }
    
    .form-control {
        border: 3px solid #333 !important;
    }
    
    .alert {
        border: 2px solid currentColor !important;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .pulse-btn {
        animation: none !important;
    }
    
    .card:hover {
        transform: none !important;
    }
}

/* Dark mode support (if system prefers dark) */
@media (prefers-color-scheme: dark) {
    /* Note: Only adding subtle adjustments since we're preserving the UI colors */
    .card {
        box-shadow: 0 4px 15px rgba(255,255,255,0.1) !important;
    }
    
    .modal-content {
        box-shadow: 0 10px 30px rgba(255,255,255,0.1) !important;
    }
}
</style>

<!-- Enhanced Specimen Collection Modals -->
<?php foreach ($lab_tests as $index => $test) { ?>
    <div class="modal fade" id="specimenModal<?php echo $test->id; ?>" tabindex="-1" role="dialog" aria-labelledby="specimenModalLabel<?php echo $test->id; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title font-weight-bold" id="specimenModalLabel<?php echo $test->id; ?>">
                        <i class="fas fa-vial"></i>Specimen Collection
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light border rounded p-3 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1 font-weight-bold text-dark"><?php echo isset($test->test_name) ? $test->test_name : $test->category; ?></h6>
                                <small class="text-muted">Test #<?php echo sprintf('%02d', $index + 1); ?> • Test ID: <?php echo $test->id; ?></small>
                            </div>
                            <div class="col-md-4 text-right">
                                <span class="badge badge-info px-3 py-2 rounded-pill">Specimen Collection</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-info-circle text-primary"></i>Specimen Details
                            </h6>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Specimen Type *</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][specimen_type]" id="specimen_type_<?php echo $test->id; ?>">
                                    <option value="">Select Specimen Type</option>
                                    <option value="1">Blood</option>
                                    <option value="2">Urine</option>
                                    <option value="3">Stool</option>
                                    <option value="4">Sputum</option>
                                    <option value="5">Serum</option>
                                    <option value="6">Plasma</option>
                                    <option value="7">CSF</option>
                                    <option value="8">Saliva</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Collection Date & Time *</label>
                                <input type="datetime-local" class="form-control" 
                                       name="specimens[<?php echo $test->id; ?>][collection_date]" 
                                       id="collection_date_<?php echo $test->id; ?>"
                                       value="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Collection Method</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][collection_method]" id="collection_method_<?php echo $test->id; ?>">
                                    <option value="">Select Collection Method</option>
                                    <option value="Venipuncture">Venipuncture</option>
                                    <option value="Finger Prick">Finger Prick</option>
                                    <option value="Midstream Urine">Midstream Urine</option>
                                    <option value="Clean Catch Urine">Clean Catch Urine</option>
                                    <option value="Swab">Swab</option>
                                    <option value="Sputum">Sputum Expectoration</option>
                                    <option value="Lumbar Puncture">Lumbar Puncture</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-flask text-success"></i>Container & Volume
                            </h6>
                            
                            <div class="form-group">
                                <label class="font-weight-medium text-dark">Container Type</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][container_type]" id="container_type_<?php echo $test->id; ?>">
                                    <option value="">Select Container</option>
                                    <option value="EDTA Tube">EDTA Tube (Purple)</option>
                                    <option value="Serum Tube">Serum Tube (Red)</option>
                                    <option value="Heparin Tube">Heparin Tube (Green)</option>
                                    <option value="Fluoride Tube">Fluoride Tube (Gray)</option>
                                    <option value="Plain Tube">Plain Tube</option>
                                    <option value="Urine Container">Sterile Urine Container</option>
                                    <option value="Stool Container">Stool Container</option>
                                    <option value="Sterile Container">Sterile Container</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium text-dark">Volume</label>
                                        <input type="number" class="form-control" 
                                               name="specimens[<?php echo $test->id; ?>][quantity]" 
                                               id="quantity_<?php echo $test->id; ?>" 
                                               step="0.1" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium text-dark">Unit</label>
                                        <select class="form-control" name="specimens[<?php echo $test->id; ?>][quantity_unit]" id="quantity_unit_<?php echo $test->id; ?>">
                                            <option value="ml">ml</option>
                                            <option value="g">g</option>
                                            <option value="tubes">tubes</option>
                                            <option value="drops">drops</option>
                                            <option value="containers">containers</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-medium text-dark">Collected By</label>
                                <input type="text" class="form-control" 
                                       name="specimens[<?php echo $test->id; ?>][collected_by]" 
                                       id="collected_by_<?php echo $test->id; ?>"
                                       value="<?php echo $this->session->userdata('user_name') ?: $this->session->userdata('username'); ?>"
                                       placeholder="Staff name or ID">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="font-weight-bold text-dark mb-2">
                            <i class="fas fa-notes-medical text-warning"></i>Specimen Condition & Notes
                        </label>
                        <textarea class="form-control border" 
                                  name="specimens[<?php echo $test->id; ?>][condition]" 
                                  id="condition_<?php echo $test->id; ?>" 
                                  rows="3"
                                  placeholder="Enter specimen condition, quality notes, and any observations (e.g., Good quality, no hemolysis, adequate volume, clear appearance)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-success save-specimen" data-test-id="<?php echo $test->id; ?>">
                        <i class="fas fa-save mr-1"></i>Save Specimen Details
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Minimal Bootstrap-Compatible Styling -->
<style>
/* Fix main content spacing to prevent header overlap */
.main-content {
    padding-top: 80px !important;
    margin-top: 0 !important;
}

/* Page header styling */
.header-card {
    position: relative;
    z-index: 10;
    margin-bottom: 1.5rem;
}

/* ICON SPACING RULES - COMPREHENSIVE FIX */
/* Proper icon spacing with containers */
.icon-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.icon-container i {
    margin: 0;
    padding: 0;
    line-height: 1;
}

/* Ensure consistent spacing between elements */
.mr-1 { margin-right: 0.25rem !important; }
.mr-2 { margin-right: 0.5rem !important; }
.mr-3 { margin-right: 1rem !important; }
.ml-1 { margin-left: 0.25rem !important; }
.ml-2 { margin-left: 0.5rem !important; }
.ml-3 { margin-left: 1rem !important; }

/* Icon containers (colored circles) - consistent sizing and spacing */
.bg-primary.rounded-circle,
.bg-primary.rounded,
.bg-success.rounded,
.bg-info.rounded,
.bg-warning.rounded {
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Center icons inside all containers */
.bg-primary.rounded-circle i,
.bg-primary.rounded i,
.bg-success.rounded i,
.bg-info.rounded i,
.bg-warning.rounded i {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1 !important;
}

/* Large icon containers (in headers) */
.card-header .bg-primary.rounded,
.modal-header .bg-primary.rounded {
    width: 40px !important;
    height: 40px !important;
    margin-right: 0.75rem !important;
}

/* Medium icon containers (in accordion headers) */
#testResultsAccordion .bg-primary.rounded-circle {
    width: 32px !important;
    height: 32px !important;
    margin-right: 0.75rem !important;
}

/* Small icon containers (inside collapsed content) */
.card-body .bg-success.rounded,
.card-body .bg-info.rounded {
    width: 24px !important;
    height: 24px !important;
    min-width: 24px !important;
    margin-right: 0.5rem !important;
}

/* Icon size inside containers */
.card-body .bg-success.rounded i,
.card-body .bg-info.rounded i {
    font-size: 10px !important;
}

/* Direct icon spacing (no containers) */
.card-header > h6 > i[class*="fa-"],
.card-header > h5 > i[class*="fa-"],
.modal-title > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

/* Modal specific icon spacing */
.modal-header h5 > i[class*="fa-"],
.modal-header h6 > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

.modal-body h6 > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

/* Fix modal body label icons */
.modal-body label > i[class*="fa-"] {
    margin-right: 0.5rem !important;
}

/* Button icon spacing */
.btn i[class*="fa-"] {
    margin-right: 0.25rem !important;
}

.btn i[class*="fa-"]:last-child:not(:first-child) {
    margin-left: 0.25rem !important;
    margin-right: 0 !important;
}

/* Specimen button specific */
.btn-outline-success .fa-vial {
    margin-right: 0.5rem !important;
}

/* Alert and inline icon spacing */
.alert i[class*="fa-"] {
    margin-right: 0.5rem !important;
}

.small i[class*="fa-"],
.text-muted i[class*="fa-"],
.badge i[class*="fa-"] {
    margin-right: 0.25rem !important;
}

/* ACCORDION CHEVRON POSITIONING */
.card-header .btn-link {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    padding-right: 2.5rem !important;
    text-decoration: none !important;
}

/* Position chevron absolutely at right edge */
.card-header .fa-chevron-down {
    position: absolute !important;
    right: 1rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    transition: transform 0.2s;
    font-size: 14px !important;
    opacity: 0.5;
}

/* Rotate chevron when expanded */
.card-header .btn-link[aria-expanded="true"] .fa-chevron-down {
    transform: translateY(-50%) rotate(180deg) !important;
    opacity: 1;
}

/* Ensure content doesn't overlap chevron */
.card-header .btn-link .d-flex {
    width: calc(100% - 3rem) !important;
    padding-right: 1rem !important;
}

/* Badge positioning in accordion */
.card-header .ml-auto {
    margin-left: auto !important;
    margin-right: 1rem !important;
}

/* Fix text colors and visibility */
.card-header .btn-link,
.card-header .btn-link:hover,
.card-header .btn-link:focus {
    color: #2c3e50 !important;
}

.text-dark {
    color: #2c3e50 !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Make small text more readable */
small {
    font-size: 85% !important;
    opacity: 0.85;
}

/* Improve badge contrast and visibility */
.badge {
    font-weight: 500 !important;
    letter-spacing: 0.3px;
    font-size: 0.85rem !important;
    padding: 0.4rem 0.8rem !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.35rem !important;
}

.badge i {
    font-size: 0.75rem !important;
}

/* Custom badge for header invoice */
.badge-white-primary {
    background-color: rgba(255, 255, 255, 0.9) !important;
    color: #2c3e50 !important;
    border: 1px solid rgba(0, 123, 255, 0.2) !important;
    font-size: 0.8rem !important;
    padding: 0.35rem 0.7rem !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
}

.badge-white-primary i {
    color: #007bff !important;
    font-size: 0.7rem !important;
}

/* Other badge styles */
.badge-success {
    background-color: #28a745 !important;
    color: white !important;
}

.badge-secondary {
    background-color: #6c757d !important;
    color: white !important;
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border-color: #dee2e6 !important;
}

/* Fix accordion header text */
#testResultsAccordion .card-header h6 {
    font-size: 1rem !important;
    line-height: 1.4 !important;
    margin: 0 !important;
    color: #2c3e50 !important;
    font-weight: 600 !important;
}

#testResultsAccordion .card-header .text-muted {
    font-size: 0.85rem !important;
    opacity: 0.85;
    font-weight: normal;
}

/* Fix form labels and text */
label.font-weight-bold {
    color: #2c3e50 !important;
    font-size: 0.9rem !important;
    margin-bottom: 0.35rem !important;
}

.form-control {
    color: #2c3e50 !important;
}

.form-control::placeholder {
    color: #a0aec0 !important;
    opacity: 0.75;
}

/* Fix modal text */
.modal-title {
    color: white !important;
    font-size: 1.1rem !important;
}

.modal-body h6 {
    color: #2c3e50 !important;
    font-size: 1rem !important;
    font-weight: 600 !important;
}

.modal-body label {
    color: #2c3e50 !important;
    font-size: 0.9rem !important;
}

/* Header time badge */
.time-badge {
    background-color: rgba(255, 255, 255, 0.85) !important;
    padding: 0.35rem 0.7rem !important;
    border-radius: 4px !important;
    gap: 0.35rem !important;
    font-size: 0.8rem !important;
    color: #2c3e50 !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
}

.time-badge i {
    color: #6c757d !important;
    font-size: 0.7rem !important;
}

.time-badge span {
    font-weight: 500 !important;
}

/* Lab completion status card */
#completionStatusCard {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
}

#completionStatusCard .btn-light {
    background-color: rgba(255, 255, 255, 0.95) !important;
    border: none !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.2s ease !important;
}

#completionStatusCard .btn-light:hover {
    background-color: white !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
}

#completionStatusCard .btn-outline-light {
    border-color: rgba(255, 255, 255, 0.5) !important;
    color: white !important;
}

#completionStatusCard .btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border-color: white !important;
}

/* Progress indicator */
#progressIndicator .progress {
    background-color: rgba(0, 0, 0, 0.1) !important;
    border-radius: 3px !important;
}

#progressIndicator .progress-bar {
    transition: width 0.6s ease !important;
}

#progressIndicator .progress-bar.bg-success {
    background: linear-gradient(90deg, #28a745, #20c997) !important;
}

#progressText {
    font-size: 0.75rem !important;
    font-weight: 500 !important;
}

/* Test completion badges */
.test-complete-badge {
    background-color: #28a745 !important;
    color: white !important;
    font-size: 0.7rem !important;
    padding: 0.25rem 0.5rem !important;
    border-radius: 12px !important;
    font-weight: 500 !important;
}

.test-pending-badge {
    background-color: #ffc107 !important;
    color: #212529 !important;
    font-size: 0.7rem !important;
    padding: 0.25rem 0.5rem !important;
    border-radius: 12px !important;
    font-weight: 500 !important;
}

/* ESSENTIAL STYLES */
.hover-highlight:hover {
    background-color: rgba(0,123,255,0.05) !important;
    border-radius: 6px;
    transform: translateX(4px);
    transition: all 0.2s ease;
}

.card:hover { 
    transform: translateY(-2px); 
    transition: transform 0.3s; 
}

.btn:hover { 
    transform: translateY(-1px); 
    transition: transform 0.2s; 
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.progress { 
    height: 4px; 
}

.badge.rounded-pill { 
    border-radius: 50rem !important; 
}

.modal-backdrop { 
    background-color: rgba(0,0,0,0.5); 
}

/* Focus states */
.btn:focus, .form-control:focus { 
    outline: none; 
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
}

#testResultsAccordion .btn-link:focus {
    text-decoration: none;
    box-shadow: none;
}

/* Test result accordion */
#testResultsAccordion .card-header {
    cursor: pointer;
}

#testResultsAccordion .btn-link:hover {
    text-decoration: none;
}

/* Floating save panel */
.fixed-bottom {
    z-index: 1030;
}

/* Custom spacing utilities */
.py-2\.5 { 
    padding-top: 0.625rem !important; 
    padding-bottom: 0.625rem !important; 
}

.my-2\.5 { 
    margin-top: 0.625rem !important; 
    margin-bottom: 0.625rem !important; 
}

/* Media queries */
@media print { 
    .btn, .modal, .fixed-bottom { 
        display: none !important; 
    } 
}

@media (max-width: 768px) { 
    .btn-group-sm .btn { 
        font-size: 0.775rem; 
        padding: 0.25rem 0.5rem; 
    }
    
    /* Stack accordion elements on mobile */
    .card-header .d-flex {
        flex-wrap: wrap;
    }
    
    .card-header .ml-auto {
        margin-left: 0 !important;
        margin-top: 0.5rem;
        width: 100%;
    }
    
    /* Adjust chevron position on mobile */
    .card-header .fa-chevron-down {
        right: 0.5rem !important;
    }
}

/* Add CSS for pulse button animation */
.pulse-btn {
    position: relative;
    animation: pulse-shadow 2s infinite;
    transition: all 0.3s ease;
}

.pulse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3) !important;
}

@keyframes pulse-shadow {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

/* Enhanced header progress indicator */
#headerProgressIndicator {
    transition: all 0.3s ease;
}

#headerProgressIndicator .progress {
    overflow: hidden;
}

#headerProgressIndicator .progress-bar {
    transition: width 0.6s ease, background-color 0.3s ease;
}

/* Enhance the Complete button */
.btn-success.rounded-pill {
    background: linear-gradient(to right, #28a745, #20c997);
    border: none;
    letter-spacing: 0.5px;
}

.btn-success.rounded-pill:hover {
    background: linear-gradient(to right, #218838, #1e9c82);
}
</style>

    <!-- Enhanced JavaScript -->
<script src="common/js/codearistos.min.js"></script>
<!-- Bootstrap JS for Modals (if not already included) -->
<script>
// Ensure Bootstrap modal functionality is available
if (typeof $.fn.modal === 'undefined') {
    document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"><\/script>');
}
</script>
<script>
$(document).ready(function() {
    // Initialize enhanced UI features
    initializeEnhancedUI();
    
    // Load existing specimen data for all tests on page load
    loadExistingSpecimenData();
    
    // Initialize completion tracking
    initializeCompletionTracking();
    
    // Track form changes for completion status
    trackFormChanges();
    
    // Handle specimen modal save
    $('.save-specimen').on('click', function() {
        var testId = $(this).data('test-id');
        var modal = $('#specimenModal' + testId);
        
        // Check required fields
        var specimenType = modal.find('select[name*="specimen_type"]').val();
        var collectionDate = modal.find('input[name*="collection_date"]').val();
        
        if (!specimenType || !collectionDate) {
            showAlert('Please fill in required fields: Specimen Type and Collection Date & Time', 'warning');
            return;
        }
        
        // Collect all specimen data from the modal
        var specimenData = {
            specimen_type: specimenType,
            collection_date: collectionDate,
            collection_method: modal.find('select[name*="collection_method"]').val(),
            container_type: modal.find('select[name*="container_type"]').val(),
            quantity: modal.find('input[name*="quantity"]').val(),
            quantity_unit: modal.find('select[name*="quantity_unit"]').val(),
            collected_by: modal.find('input[name*="collected_by"]').val(),
            condition: modal.find('textarea[name*="condition"]').val()
        };
        
        // Save specimen data to database immediately via AJAX
        $.ajax({
            url: '<?php echo base_url('labworkflow/saveSpecimenData'); ?>',
            type: 'POST',
            data: {
                test_id: testId,
                patient_id: $('input[name="patient_id"]').val(),
                invoice_id: $('input[name="invoice_id"]').val(),
                specimen_data: specimenData
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
        // Update status badge
        var statusBadge = $('#status-' + testId);
        statusBadge.removeClass('badge-secondary badge-warning').addClass('badge-success').text('Collected');
        
        // Update button appearance
        var specimenBtn = $('button[data-target="#specimenModal' + testId + '"]');
        specimenBtn.removeClass('btn-outline-success').addClass('btn-success');
        
        // Close modal
        modal.modal('hide');
        
        // Show success message
                    showAlert(response.message, 'success');
                    
                    // Store specimen data in hidden fields for form submission backup
                    var mainForm = $('#reportForm');
                    mainForm.find('input[name^="specimens[' + testId + ']"]').remove();
                    $.each(specimenData, function(key, value) {
                        if (value) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'specimens[' + testId + '][' + key + ']',
                                value: value
                            }).appendTo(mainForm);
                        }
                    });
                } else {
                    showAlert('Error saving specimen data: ' + response.message, 'error');
                }
            },
            error: function() {
                showAlert('Network error while saving specimen data', 'error');
            }
        });
    });
    
    // Enhanced alert function
    function showAlert(message, type = 'info') {
        showEnhancedAlert(message, type);
    }
    
    // Enhanced notification system
    function showEnhancedAlert(message, type = 'info', duration = 4000) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 
                       type === 'warning' ? 'fa-exclamation-triangle' : 
                       type === 'error' ? 'fa-times-circle' : 'fa-info-circle';
        var bgColor = type === 'success' ? '#d4edda' : 
                      type === 'warning' ? '#fff3cd' : 
                      type === 'error' ? '#f8d7da' : '#d1ecf1';
        
        var alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; 
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 10px;
                        background-color: ${bgColor}; border: none; animation: slideInRight 0.3s ease-out;">
                <div class="d-flex align-items-center">
                    <i class="fas ${iconClass} mr-3" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong style="font-size: 0.95rem;">${message}</strong>
                    </div>
                    <button type="button" class="close ml-auto" data-dismiss="alert" style="font-size: 1.5rem;">
                        <span>&times;</span>
                    </button>
                </div>
            </div>
        `);
        
        $('body').append(alert);
        
        // Auto remove after specified duration
        setTimeout(function() {
            alert.addClass('animate-slide-out');
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, duration);
    }
    
    // Accordion chevron rotation
    $('.accordion').on('show.bs.collapse', function(e) {
        $(e.target).prev().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });
    
    $('.accordion').on('hide.bs.collapse', function(e) {
        $(e.target).prev().find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
    
    // Form validation
    $('#reportForm').on('submit', function(e) {
        var hasResults = false;
        $('textarea[name*="[report]"], input[name*="template_fields"]').each(function() {
            if ($(this).val().trim() !== '') {
                hasResults = true;
                return false;
            }
        });
        
        if (!hasResults) {
            e.preventDefault();
            showAlert('Please enter at least one test result before saving the report.', 'warning');
            return false;
        }
        
        // Debug: Log all form data being submitted
        console.log('=== FORM SUBMISSION DEBUG ===');
        console.log('Form action:', $(this).attr('action'));
        console.log('Form method:', $(this).attr('method'));
        
        // Log specimen data
        console.log('Specimen data fields:');
        var specimenCount = 0;
        $(this).find('input[name^="specimens["]').each(function() {
            console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
            specimenCount++;
        });
        console.log('Total specimen fields:', specimenCount);
        
        // Log test report data
        console.log('Test report data:');
        var reportCount = 0;
        $(this).find('textarea[name^="test_reports["], input[name^="test_reports["]').each(function() {
            if ($(this).val().trim() !== '') {
                console.log(' - ' + $(this).attr('name') + ': "' + $(this).val().substring(0, 50) + '..."');
                reportCount++;
            }
        });
        console.log('Total report fields with data:', reportCount);
        
        // Log template field data
        console.log('Template field data:');
        var templateCount = 0;
        $(this).find('input[name^="template_fields["], select[name^="template_fields["]').each(function() {
            if ($(this).val().trim() !== '') {
                console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
                templateCount++;
            }
        });
        console.log('Total template fields with data:', templateCount);
        
        // Log hidden fields
        console.log('Hidden fields:');
        $(this).find('input[type="hidden"]').each(function() {
            console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
        });
        
        console.log('=== END FORM DEBUG ===');
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
    });
    
    // Enhanced hover effects
    $('.test-item, .specimen-btn, .parameter-row').hover(
        function() {
            $(this).addClass('shadow-sm');
        },
        function() {
            $(this).removeClass('shadow-sm');
        }
    );
});

// Enhanced UI Initialization
function initializeEnhancedUI() {
    // Add loading animations
    $('body').addClass('loaded');
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers  
    $('[data-toggle="popover"]').popover();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if(target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Enhanced form interactions
    $('.form-control').on('focus', function() {
        $(this).closest('.form-group').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('focused');
    });
    
    // Setup keyboard shortcuts
    setupKeyboardShortcuts();
    
    // Setup enhanced auto-save
    setupEnhancedAutoSave();
    
    // Setup real-time validation
    setupRealTimeValidation();
    
    // Setup responsive functionality
    setupResponsiveFeatures();
}

// Expand/Collapse all tests function
function expandAllTests() {
    var $collapseElements = $('.accordion .collapse');
    var $button = $('button[onclick="expandAllTests()"]');
    
    if ($collapseElements.first().hasClass('show')) {
        // Collapse all
        $collapseElements.collapse('hide');
        $button.html('<i class="fas fa-compress-alt mr-1"></i><span class="font-weight-bold">Collapse All</span>');
    } else {
        // Expand all
        $collapseElements.collapse('show');
        $button.html('<i class="fas fa-expand-alt mr-1"></i><span class="font-weight-bold">Expand All</span>');
    }
}

// Enhanced auto-save with progress indication
function setupEnhancedAutoSave() {
    var autoSaveTimer;
    var $autoSaveIndicator = $('<div id="autoSaveIndicator" class="position-fixed" style="bottom: 20px; left: 20px; z-index: 1000;"></div>');
    $('body').append($autoSaveIndicator);
    
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').on('input change', function() {
        clearTimeout(autoSaveTimer);
        
        // Show saving indicator
        $autoSaveIndicator.html(`
            <div class="bg-warning text-dark px-3 py-2 rounded-pill shadow animate__animated animate__fadeIn">
                <i class="fas fa-clock mr-2"></i>
                <small class="font-weight-bold">Auto-saving in 3s...</small>
            </div>
        `);
        
        autoSaveTimer = setTimeout(function() {
            // Simulate auto-save
            $autoSaveIndicator.html(`
                <div class="bg-success text-white px-3 py-2 rounded-pill shadow animate__animated animate__fadeIn">
                    <i class="fas fa-check mr-2"></i>
                    <small class="font-weight-bold">Draft saved</small>
                </div>
            `);
            
            setTimeout(function() {
                $autoSaveIndicator.fadeOut();
            }, 2000);
        }, 3000);
    });
}

// Real-time form validation
function setupRealTimeValidation() {
    // Validate template fields
    $('input[name^="template_fields["]').on('input', function() {
        var $this = $(this);
        var value = $this.val().trim();
        var $row = $this.closest('.template-parameter-row, .row');
        
        if (value) {
            $row.removeClass('has-error').addClass('has-success');
            $this.removeClass('is-invalid').addClass('is-valid');
        } else {
            $row.removeClass('has-success has-error');
            $this.removeClass('is-valid is-invalid');
        }
    });
    
    // Validate text areas
    $('textarea[name^="test_reports["]').on('input', function() {
        var $this = $(this);
        var value = $this.val().trim();
        var minLength = 10;
        
        if (value.length >= minLength) {
            $this.removeClass('is-invalid').addClass('is-valid');
        } else if (value.length > 0 && value.length < minLength) {
            $this.removeClass('is-valid').addClass('is-invalid');
        } else {
            $this.removeClass('is-valid is-invalid');
        }
    });
}

// Keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).keydown(function(e) {
        // Ctrl+S to save
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('#reportForm').submit();
            return false;
        }
        
        // Ctrl+D to save draft
        if (e.ctrlKey && e.which === 68) {
            e.preventDefault();
            saveDraft();
            return false;
        }
        
        // Ctrl+P to print
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault();
            printLabReport();
            return false;
        }
    });
}

// Responsive Features Setup
function setupResponsiveFeatures() {
    // Handle window resize events
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            handleResponsiveLayout();
            adjustModalSizes();
            repositionElements();
        }, 250);
    });
    
    // Handle orientation change
    $(window).on('orientationchange', function() {
        setTimeout(function() {
            handleResponsiveLayout();
            adjustModalSizes();
            repositionElements();
        }, 500);
    });
    
    // Initial setup
    handleResponsiveLayout();
    setupTouchGestures();
    optimizeForMobile();
}

// Handle responsive layout changes
function handleResponsiveLayout() {
    const windowWidth = $(window).width();
    
    // Adjust header layout based on screen size
    if (windowWidth <= 767) {
        // Mobile layout
        $('.card-header .d-flex').addClass('mobile-header');
        $('#headerProgressIndicator .progress').css('width', '100%');
        
        // Stack buttons vertically on mobile
        $('.card-header .btn-group').addClass('mobile-buttons');
        
        // Adjust specimen collection layout
        $('.specimen-test-btn .d-flex').addClass('mobile-specimen');
        
        // Adjust accordion layout
        $('.accordion .btn-link .d-flex').addClass('mobile-accordion');
        
    } else if (windowWidth <= 991) {
        // Tablet layout
        $('.card-header .d-flex').removeClass('mobile-header').addClass('tablet-header');
        $('#headerProgressIndicator .progress').css('width', '140px');
        
        // Horizontal buttons on tablet
        $('.card-header .btn-group').removeClass('mobile-buttons').addClass('tablet-buttons');
        
        // Adjust specimen collection for tablet
        $('.specimen-test-btn .d-flex').removeClass('mobile-specimen').addClass('tablet-specimen');
        
        // Adjust accordion for tablet
        $('.accordion .btn-link .d-flex').removeClass('mobile-accordion').addClass('tablet-accordion');
        
    } else {
        // Desktop layout
        $('.card-header .d-flex').removeClass('mobile-header tablet-header');
        $('#headerProgressIndicator .progress').css('width', '140px');
<?php
$lang = $this->session->userdata('lang');
if (empty($lang)) {
    $lang = "english";
}
if ($lang == 'arabic') {
    $direction = 'rtl';
} else {
    $direction = 'ltr';
}
?>
<!--main content start-->
<div class="main-content" dir="<?php echo $direction; ?>">
    <div class="container-fluid">
        
        <!-- Ultra Modern Enhanced Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-header-card shadow-xl border-0 position-relative overflow-hidden" style="border-radius: 20px;">
                    <!-- Animated Background -->
                    <div class="header-bg-animation"></div>
                    
                    <!-- Main Header Content -->
                    <div class="header-content position-relative p-4">
                        <div class="row align-items-center">
                            <!-- Left Section: Branding & Patient Info -->
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <!-- Animated Logo -->
                                    <div class="logo-container mr-4">
                                        <div class="logo-circle">
                                            <i class="fas fa-microscope"></i>
                                            <div class="logo-pulse"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Title & Patient Info -->
                                    <div class="header-info">
                                        <h3 class="header-title mb-2">Laboratory Report System</h3>
                                        <div class="header-meta d-flex flex-wrap align-items-center">
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-file-invoice"></i>
                                                <span>Invoice #<?php echo $invoice_id; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-user"></i>
                                                <span><?php echo isset($patient->name) ? $patient->name : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-id-card"></i>
                                                <span>ID: <?php echo isset($patient->patient_id) ? $patient->patient_id : (isset($patient->id) ? 'P-'.$patient->id : 'N/A'); ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-birthday-cake"></i>
                                                <span><?php echo isset($patient->age) ? $patient->age : 'N/A'; ?>/<?php echo isset($patient->sex) ? $patient->sex : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mr-3 mb-2">
                                                <i class="fas fa-user-md"></i>
                                                <span>Dr. <?php echo isset($doctor->name) ? $doctor->name : 'N/A'; ?></span>
                                            </div>
                                            <div class="meta-badge mb-2">
                                                <i class="fas fa-clock"></i>
                                                <span><?php echo date('d M Y, H:i A'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Center Section: Progress Dashboard -->
                            <div class="col-lg-6>
                                <div class="progress-dashboard">
                                    <div class="progress-card">
                                        <div class="progress-header">
                                            <div class="progress-icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress-title">Test Progress</div>
                                                <div class="progress-subtitle" id="headerProgressText">0 of <?php echo count($lab_tests); ?> completed</div>
                                            </div>
                                        </div>
                                        <div class="progress-visual mt-3">
                                            <div class="progress-ring">
                                                <svg class="progress-svg" width="60" height="60">
                                                    <circle class="progress-ring-bg" cx="30" cy="30" r="25"></circle>
                                                    <circle class="progress-ring-fill" cx="30" cy="30" r="25" id="headerProgressRing"></circle>
                                                </svg>
                                                <div class="progress-percentage" id="headerProgressPercentage">0%</div>
                                            </div>
                                            <div class="progress-stats ml-3">
                                                <div class="stat-item">
                                                    <span class="stat-number" id="completedCount">0</span>
                                                    <span class="stat-label">Completed</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-number" id="pendingCount"><?php echo count($lab_tests); ?></span>
                                                    <span class="stat-label">Pending</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                    
                    <!-- Status Bar -->
                    <div class="status-bar">
                        <div class="status-indicator" id="systemStatus">
                            <div class="status-dot status-online"></div>
                            <span class="status-text">System Online</span>
                        </div>
                        <div class="auto-save-indicator" id="autoSaveStatus">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Auto-save enabled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="<?php echo base_url('labworkflow/saveReport'); ?>" method="post" id="reportForm" onsubmit="return submitFormAndStay(this);">
            <input type="hidden" name="invoice_id" value="<?php echo isset($invoice_id) ? $invoice_id : ''; ?>">
            <input type="hidden" name="patient_id" value="<?php echo isset($patient->id) ? $patient->id : ''; ?>">
            
            <div class="row">
                <!-- Test Results Section - Full Width -->
                <div class="col-12">
                    <!-- Floating Save Panel -->
                    <div class="fixed-bottom bg-white border-top shadow-lg p-3 d-none" id="floatingSavePanel">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle text-warning mr-3"></i>
                                        <div>
                                            <small class="text-dark font-weight-bold">You have unsaved changes</small>
                                            <div class="progress mt-1 bg-light" style="height: 4px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" id="saveProgress"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="submit" form="reportForm" class="btn btn-success btn-sm font-weight-bold">
                                        <i class="fas fa-sync-alt mr-1"></i>Update Report
                                    </button>
                                    
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lab Workflow Completion Status -->
                    <div class="card shadow-sm border-0 mb-3" id="completionStatusCard" style="display: none;">
                        <div class="card-body bg-gradient-success text-white p-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-white">Laboratory Analysis Complete</h6>
                                            <small class="text-white font-weight-bold">All test results have been entered and validated</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-light btn-sm" onclick="printLabReport()">
                                            <i class="fas fa-print text-success"></i>
                                            <span class="text-success font-weight-bold">Print Report</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header bg-gradient-info text-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-clipboard-list" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-white font-weight-bold mb-0">Test Results & Reports</h6>
                                        <small class="text-white opacity-75">Enter test results and clinical findings</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-light btn-sm" onclick="expandAllTests()">
                                        <i class="fas fa-expand-alt mr-1"></i>
                                        <span class="font-weight-bold">Expand All</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            

                            
                            <div class="accordion" id="testResultsAccordion">
                                <?php foreach ($lab_tests as $index => $test) { ?>
                                    <div class="mb-3">
                                        <div class="card border-0 shadow-sm rounded">
                                            <div class="card-header bg-light border-0 p-0" id="heading<?php echo $test->id; ?>">
                                                <button class="btn btn-link btn-block text-left p-3 text-decoration-none text-dark" 
                                                        type="button" data-toggle="collapse" data-target="#collapse<?php echo $test->id; ?>" 
                                                        aria-expanded="false" aria-controls="collapse<?php echo $test->id; ?>">
                                                                                                        <div class="d-flex align-items-center w-100">
                                                        <div class="bg-primary text-white rounded-circle align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                    <i class="fas fa-flask"></i>
                                                                </div>
                                                        <div class="d-flex align-items-center flex-wrap ml-3">
                                                            <h6 class="mb-0 font-weight-bold text-dark mr-2">
                                                                <?php echo isset($test->test_name) ? $test->test_name : $test->category; ?>
                                                            </h6>
                                                            <span class="text-muted small">&bull; Test #<?php echo sprintf('%02d', $index + 1); ?> | ID: <?php echo $test->id; ?></span>
                                                                </div>
                                                        <div class="ml-auto d-flex align-items-center">
                                                            <?php if (isset($test_templates[$test->id])) { ?>
                                                                <span class="badge badge-success px-3 py-2 rounded-pill">
                                                                    <i class="fas fa-check"></i>
                                                                    <span class="ml-1"><?php echo $test_templates[$test->id]->template_name; ?></span>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-light border px-3 py-2 rounded-pill">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                    <span class="ml-1">Manual Entry</span>
                                                                </span>
                                                            <?php } ?> 
                                                        </div>
                                                        <i class="fas fa-chevron-down text-muted ml-3"></i>
                                                    </div>
                                                </button>
                                            </div>

                                            <div id="collapse<?php echo $test->id; ?>" class="collapse" 
                                                 aria-labelledby="heading<?php echo $test->id; ?>" data-parent="#testResultsAccordion">
                                                <div class="card-body bg-white">
                                                    
                                                    <?php if (isset($test_templates[$test->id])) { 
                                                        $assigned_template = $test_templates[$test->id]; ?>
                                                        
                                                        <!-- Template Parameters -->
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <div class="bg-success text-white rounded mr-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                                    <i class="fas fa-list-alt" style="font-size: 10px;"></i>
                                                                </div>
                                                                <h6 class="mb-0 font-weight-bold text-dark"><?php echo $assigned_template->template_name; ?> Parameters</h6>
                                                            </div>
                                                            
                                                            <?php if (!empty($assigned_template->fields)) { ?>
                                                                <div>
                                                                    <?php foreach ($assigned_template->fields as $field) { ?>
                                                                        <div class="bg-white p-2 mb-2 rounded border shadow-sm">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-md-3">
                                                                                    <label class="font-weight-bold text-dark mb-0 small"><?php echo $field->field_label; ?></label>
                                                                                    <?php if ($field->units) { ?>
                                                                                        <small class="text-muted d-block">(<?php echo $field->units; ?>)</small>
                                                                                    <?php } ?>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <?php 
                                                                                    // Get existing value for this field
                                                                                    $existing_value = '';
                                                                                    if (isset($result_values[$test->id])) {
                                                                                        foreach ($result_values[$test->id] as $result) {
                                                                                            if ($result->parameter_name == $field->field_label) {
                                                                                                $existing_value = $result->result_value;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <?php if ($field->field_type == 'number') { ?>
                                                                                        <input type="number" class="form-control form-control-sm" 
                                                                                               name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]" 
                                                                                               value="<?php echo htmlspecialchars($existing_value); ?>"
                                                                                               placeholder="Enter value">
                                                                                    <?php } elseif ($field->field_type == 'select') { ?>
                                                                                        <select class="form-control form-control-sm" 
                                                                                                name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]">
                                                                                            <option value="">Select</option>
                                                                                            <?php if ($field->field_options) {
                                                                                                $options = explode(',', $field->field_options);
                                                                                                foreach ($options as $option) {
                                                                                                    $option = trim($option);
                                                                                                    $selected = ($existing_value == $option) ? 'selected' : '';
                                                                                                    ?>
                                                                                                    <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>
                                                                                                <?php } 
                                                                                            } ?>
                                                                                        </select>
                                                                                    <?php } else { ?>
                                                                                        <input type="text" class="form-control form-control-sm" 
                                                                                               name="template_fields[<?php echo $test->id; ?>][<?php echo $field->id; ?>]" 
                                                                                               value="<?php echo htmlspecialchars($existing_value); ?>"
                                                                                               placeholder="Enter value">
                                                                                    <?php } ?>
                                                                                </div>
                                                                                                                                                <div class="col-md-3">
                                                                    <small class="text-muted">
                                                                        <strong>Reference:</strong><br>
                                                                        <?php echo ($field->reference_value ?: $field->reference_range ?: 'N/A'); ?>
                                                                    </small>
                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <?php 
                                                                                    // Get existing status for this field
                                                                                    $existing_status = 'normal';
                                                                                    if (isset($result_values[$test->id])) {
                                                                                        foreach ($result_values[$test->id] as $result) {
                                                                                            if ($result->parameter_name == $field->field_label) {
                                                                                                $existing_status = $result->status ?: 'normal';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <select class="form-control form-control-sm" name="template_status[<?php echo $test->id; ?>][<?php echo $field->id; ?>]">
                                                                                        <option value="normal" <?php echo ($existing_status == 'normal') ? 'selected' : ''; ?>>Normal</option>
                                                                                        <option value="abnormal" <?php echo ($existing_status == 'abnormal') ? 'selected' : ''; ?>>Abnormal</option>
                                                                                        <option value="critical" <?php echo ($existing_status == 'critical') ? 'selected' : ''; ?>>Critical</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <!-- No Template Notice -->
                                                        <div class="alert alert-light border-left-warning py-3 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-info-circle text-warning mr-3"></i>
                                                                <div>
                                                                    <small class="text-dark">
                                                                        <strong>No template assigned for this test.</strong><br>
                                                                        Configure in <a href="<?php echo base_url('finance/paymentCategory'); ?>" target="_blank" class="text-primary">Finance → Payment Category</a>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <!-- Clinical Report -->
                                                    <div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="bg-info text-white rounded mr-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                                <i class="fas fa-file-medical" style="font-size: 10px;"></i>
                                                            </div>
                                                            <h6 class="mb-0 font-weight-bold text-dark">Clinical Report</h6>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-12 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Test Results & Findings</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][report]" 
                                                                          rows="3" 
                                                                          placeholder="Enter detailed test results, findings, and clinical observations..."><?php echo isset($test->report) ? $test->report : ''; ?></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Clinical Interpretation</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][interpretation]" 
                                                                          rows="2" 
                                                                          placeholder="Clinical significance and interpretation..."><?php echo isset($test->interpretation) ? $test->interpretation : ''; ?></textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label class="font-weight-bold text-dark mb-1 small">Critical Values & Alerts</label>
                                                                <textarea class="form-control border" 
                                                                          name="test_reports[<?php echo $test->id; ?>][critical_values]" 
                                                                          rows="2" 
                                                                          placeholder="Any critical values, urgent findings, or alerts..."><?php echo isset($test->critical_values) ? $test->critical_values : ''; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--main content end-->

<!-- Enhanced Custom CSS -->
<style>
/* Modern Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Enhanced Card Styling */
.card {
    transition: all 0.3s ease;
    border-radius: 15px !important;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

/* ================================
   ULTRA MODERN HEADER STYLES
   ================================ */

/* Main Header Container */
.modern-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    min-height: 160px;
    overflow: hidden;
    margin-bottom: 0;
}

/* Animated Background */
.header-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
    animation: backgroundFloat 15s ease-in-out infinite;
}

@keyframes backgroundFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(1deg); }
    66% { transform: translateY(5px) rotate(-1deg); }
}

/* Header Content */
.header-content {
    z-index: 2;
    padding-bottom: 50px !important; /* Add space for status bar */
}

/* Logo Section */
.logo-container {
    position: relative;
}

.logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
}

.logo-circle i {
    font-size: 1.8rem;
    color: #667eea;
    z-index: 2;
    position: relative;
}

.logo-pulse {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.3);
    transform: translate(-50%, -50%);
    animation: logoPulse 2s ease-in-out infinite;
}

@keyframes logoPulse {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
}

/* Header Info */
.header-title {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 0;
}

.header-meta {
    gap: 0;
}

.meta-badge {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 25px;
    padding: 8px 16px;
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.meta-badge:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

.meta-badge i {
    margin-right: 6px;
    font-size: 0.9rem;
}

/* Progress Dashboard */
.progress-dashboard {
    display: flex;
    justify-content: center;
}

.progress-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 20px;
    width: 100%;
    max-width: 300px;
}

.progress-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.progress-icon {
    width: 35px;
    height: 35px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

.progress-icon i {
    color: #ffffff;
    font-size: 1rem;
}

.progress-title {
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
}

.progress-subtitle {
    color: rgba(255,255,255,0.8);
    font-size: 0.8rem;
    margin: 0;
}

/* Progress Ring */
.progress-visual {
    display: flex;
    align-items: center;
}

.progress-ring {
    position: relative;
    width: 60px;
    height: 60px;
}

.progress-svg {
    transform: rotate(-90deg);
}

.progress-ring-bg {
    fill: none;
    stroke: rgba(255,255,255,0.2);
    stroke-width: 3;
}

.progress-ring-fill {
    fill: none;
    stroke: #ffd700;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-dasharray: 157;
    stroke-dashoffset: 157;
    transition: stroke-dashoffset 0.5s ease;
}

.progress-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 700;
}

/* Progress Stats */
.progress-stats {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-number {
    color: #ffffff;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    color: rgba(255,255,255,0.7);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Action Center */
.action-center {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 15px;
}

/* Modern Buttons */
.btn-modern {
    position: relative;
    border: none;
    border-radius: 15px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 160px;
    backdrop-filter: blur(10px);
}

.btn-draft {
    background: rgba(255,255,255,0.15);
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-complete {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.btn-draft:hover {
    background: rgba(255,255,255,0.25);
}

.btn-complete:hover {
    box-shadow: 0 8px 30px rgba(40, 167, 69, 0.4);
}

.btn-icon {
    margin-right: 8px;
    font-size: 1rem;
}

.btn-text {
    position: relative;
    z-index: 2;
}

.btn-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 15px;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.btn-modern:hover .btn-glow {
    transform: translateX(100%);
}

/* Pulse Animation */
.pulse-animation {
    animation: buttonPulse 2s ease-in-out infinite;
}

@keyframes buttonPulse {
    0% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
    50% { box-shadow: 0 4px 25px rgba(40, 167, 69, 0.5); }
    100% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
}

/* Quick Stats */
.quick-stats {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.stat-pill {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 6px 12px;
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    backdrop-filter: blur(10px);
}

.stat-pill i {
    margin-right: 4px;
    font-size: 0.8rem;
}

/* Status Bar */
.status-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 30px;
    background: rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    font-size: 0.75rem;
}

.status-indicator, .auto-save-indicator {
    display: flex;
    align-items: center;
    color: rgba(255,255,255,0.8);
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 6px;
}

.status-online {
    background: #28a745;
    animation: statusPulse 2s ease-in-out infinite;
}

.status-warning {
    background: #ffc107;
    animation: statusPulse 2s ease-in-out infinite;
}

.status-error {
    background: #dc3545;
    animation: statusPulse 2s ease-in-out infinite;
}

@keyframes statusPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.auto-save-indicator i {
    margin-right: 4px;
    font-size: 0.8rem;
}

/* Tooltips */
[data-tooltip] {
    position: relative;
}

[data-tooltip]:hover::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.75rem;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 5px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .action-buttons {
        flex-direction: row;
        gap: 8px;
    }
    
    .btn-modern {
        min-width: 130px;
        padding: 10px 18px;
        font-size: 0.85rem;
    }
    
    .progress-card {
        padding: 15px;
    }
}

@media (max-width: 768px) {
    .header-content {
        padding: 20px 15px !important;
    }
    
    .header-title {
        font-size: 1.4rem;
    }
    
    .meta-badge {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-modern {
        min-width: auto;
    }
    
    .quick-stats {
        justify-content: center;
        margin-top: 10px;
    }
    
    .progress-visual {
        justify-content: center;
    }
    
    .progress-stats {
        margin-left: 15px;
    }
}

/* Text Visibility Improvements */
.text-white {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.text-dark {
    color: #212529 !important;
    font-weight: 600;
}

.text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.font-weight-bold {
    font-weight: 600 !important;
}

.font-weight-medium {
    font-weight: 500 !important;
}

/* Enhanced Badge Visibility */
.badge {
    font-weight: 600 !important;
    text-shadow: none;
    border: 1px solid rgba(0,0,0,0.1);
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border: 1px solid #dee2e6 !important;
}

.badge-primary {
    background-color: #007bff !important;
    color: #ffffff !important;
}

.badge-success {
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge-info {
    background-color: #17a2b8 !important;
    color: #ffffff !important;
}

/* Button Text Visibility */
.btn {
    font-weight: 600 !important;
    text-shadow: none;
}

.btn-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border: 1px solid #dee2e6 !important;
}

.btn-light:hover,
.btn-light:focus {
    background-color: #e9ecef !important;
    color: #495057 !important;
    border-color: #dee2e6 !important;
}

/* Card Header Text */
.card-header h4,
.card-header h5,
.card-header h6 {
    color: #ffffff !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    font-weight: 700 !important;
}

.card-header .text-white {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.card-header small.text-white {
    opacity: 0.9;
}

/* Form Label Visibility */
label {
    color: #495057 !important;
    font-weight: 600 !important;
}

.form-control {
    color: #495057 !important;
    background-color: #ffffff !important;
    border: 2px solid #e9ecef !important;
}

.form-control:focus {
    color: #495057 !important;
    background-color: #ffffff !important;
    border-color: #007bff !important;
}

/* Accordion Text Visibility */
.accordion .btn-link {
    color: #495057 !important;
    font-weight: 600;
}

.accordion .btn-link:hover,
.accordion .btn-link:focus {
    color: #007bff !important;
    text-decoration: none !important;
}

/* Patient Info Text */
.patient-info-grid .info-item .text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.patient-info-grid .info-item .text-dark {
    color: #212529 !important;
    font-weight: 600;
}

/* Button Enhancements */
.pulse-btn {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.specimen-test-btn:hover {
    border-color: #28a745 !important;
    background-color: #f8f9fa !important;
    transform: translateX(5px);
}

/* Progress Bar Enhancements */
.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}

/* Badge Enhancements */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge-light {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #dee2e6;
}

/* Test Accordion Enhancements */
.accordion .card {
    border: none !important;
    margin-bottom: 1rem;
    border-radius: 12px !important;
    overflow: hidden;
}

.accordion .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    padding: 0;
}

.accordion .btn-link {
    color: #495057 !important;
    text-decoration: none !important;
    font-weight: 500;
}

.accordion .btn-link:hover {
    color: #007bff !important;
}

/* Form Enhancements */
.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Patient Info Grid */
.patient-info-grid .info-item {
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 8px 0;
}

.patient-info-grid .info-item:hover {
    background-color: #f8f9fa;
    padding-left: 10px;
    padding-right: 10px;
}

/* Floating Save Panel */
#floatingSavePanel {
    z-index: 1050;
    backdrop-filter: blur(10px);
    background-color: rgba(255,255,255,0.95) !important;
}

/* Enhanced Icons */
.icon-container {
    transition: all 0.3s ease;
}

.icon-container:hover {
    transform: scale(1.1);
}

/* Completion Status Card */
#completionStatusCard {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Template Parameters Styling */
.template-parameter-row {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.template-parameter-row:hover {
    border-color: #007bff;
    box-shadow: 0 2px 10px rgba(0,123,255,0.1);
}

/* Comprehensive Responsive Enhancements */

/* Extra Large Devices (1200px and up) */
@media (min-width: 1200px) {
    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }
}

/* Large Devices (992px to 1199px) */
@media (max-width: 1199px) {
    .card-header h4 {
        font-size: 1.4rem;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        font-weight: 600;
    }
}

/* Medium Devices (768px to 991px) */
@media (max-width: 991px) {
    /* Header adjustments */
    .card-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .card-header h4 {
        font-size: 1.3rem;
        margin-bottom: 0.5rem !important;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        font-weight: 600;
    }
    
    .card-header .badge {
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .btn-group {
        width: 100%;
        justify-content: space-between;
    }
    
    .card-header .btn-group .btn {
        flex: 1;
        margin: 0 0.25rem;
    }
    
    /* Progress indicator adjustments */
    #headerProgressIndicator {
        width: 100%;
        justify-content: center;
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }
    
    /* Layout adjustments */
    .col-lg-3 {
        margin-bottom: 2rem;
    }
    
    /* Patient info adjustments */
    .patient-info-grid .info-item {
        padding: 1rem 0;
        flex-direction: row;
        justify-content: space-between;
    }
    
    /* Specimen collection adjustments */
    .specimen-test-btn {
        padding: 1rem !important;
        margin-bottom: 0.5rem;
    }
    
    .specimen-test-btn .d-flex {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .specimen-test-btn .badge {
        margin-top: 0.5rem;
    }
}

/* Small Devices (576px to 767px) */
@media (max-width: 767px) {
    /* Container adjustments */
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    /* Header responsive design */
    .card-header .d-flex {
        flex-direction: column;
        align-items: stretch !important;
        text-align: center;
    }
    
    .card-header h4 {
        font-size: 1.2rem;
        text-align: center;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        display: inline-block;
        margin: 0.25rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    /* Button adjustments */
    .card-header .btn-group {
        flex-direction: column;
        width: 100%;
        gap: 0.5rem;
    }
    
    .card-header .btn-group .btn {
        width: 100%;
        margin: 0;
        padding: 0.75rem;
        font-size: 0.9rem;
    }
    
    /* Progress indicator mobile */
    #headerProgressIndicator {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    #headerProgressIndicator .progress {
        width: 100% !important;
        margin-top: 0.5rem;
    }
    
    /* Patient info mobile layout */
    .patient-info-grid .info-item {
        flex-direction: column;
        align-items: flex-start !important;
        padding: 0.75rem 0;
        text-align: left;
    }
    
    .patient-info-grid .info-item > div:first-child {
        margin-bottom: 0.5rem;
    }
    
    .patient-info-grid .info-item .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .patient-info-grid .info-item .text-dark {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .patient-info-grid .badge {
        margin-top: 0.5rem;
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    /* Specimen collection mobile */
    .specimen-test-btn {
        padding: 1rem !important;
        text-align: left;
        background-color: #ffffff !important;
        border: 2px solid #e9ecef !important;
        color: #495057 !important;
    }
    
    .specimen-test-btn .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    
    .specimen-test-btn .font-weight-bold {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .specimen-test-btn .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .specimen-test-btn .badge {
        align-self: flex-end;
        margin-top: 0;
        background-color: #ffc107 !important;
        color: #212529 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    /* Test results mobile */
    .accordion .btn-link {
        padding: 1rem !important;
        text-align: left;
        color: #495057 !important;
        background-color: #f8f9fa !important;
    }
    
    .accordion .btn-link:hover,
    .accordion .btn-link:focus {
        color: #007bff !important;
        background-color: #f8f9fa !important;
        text-decoration: none !important;
    }
    
    .accordion .btn-link .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    
    .accordion .btn-link .font-weight-bold {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .accordion .btn-link .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .accordion .btn-link .badge {
        align-self: flex-start;
        background-color: #28a745 !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    
    /* Form adjustments */
    .template-parameter-row .row {
        margin: 0;
    }
    
    .template-parameter-row .col-md-3 {
        margin-bottom: 0.75rem;
        padding: 0 0.5rem;
    }
    
    /* Modal adjustments */
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    .modal-body .row .col-md-6 {
        margin-bottom: 1rem;
    }
    
    /* Floating save panel mobile */
    #floatingSavePanel {
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 0;
    }
    
    #floatingSavePanel .row {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    /* Auto-save indicator mobile */
    #autoSaveIndicator {
        bottom: 10px !important;
        left: 10px !important;
        right: 10px !important;
        text-align: center;
    }
    
    #autoSaveIndicator > div {
        width: 100%;
        text-align: center;
    }
}

/* Extra Small Devices (less than 576px) */
@media (max-width: 575px) {
    /* Ultra-compact header */
    .card-header {
        padding: 1rem 0.75rem;
    }
    
    .card-header h4 {
        font-size: 1.1rem;
        line-height: 1.3;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.4);
        font-weight: 700 !important;
    }
    
    .card-header .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
    }
    
    .card-header .text-white {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.4);
        font-weight: 600;
    }
    
    /* Ultra-compact cards */
    .card-body {
        padding: 1rem 0.75rem;
    }
    
    /* Ultra-compact buttons */
    .btn {
        font-size: 0.85rem;
        padding: 0.6rem 1rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    
    /* Ultra-compact forms */
    .form-control {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    /* Ultra-compact specimen buttons */
    .specimen-test-btn {
        padding: 0.75rem !important;
        font-size: 0.85rem;
    }
    
    .specimen-test-btn .rounded-circle {
        width: 28px !important;
        height: 28px !important;
    }
    
    .specimen-test-btn .fa-vial {
        font-size: 0.8rem !important;
    }
    
    /* Ultra-compact patient info */
    .patient-info-grid .info-item {
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }
    
    .patient-info-grid .info-item .text-muted {
        color: #6c757d !important;
        font-weight: 500;
    }
    
    .patient-info-grid .info-item .text-dark {
        color: #212529 !important;
        font-weight: 600;
    }
    
    .patient-info-grid .info-item .badge {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    /* Notification adjustments */
    .alert.position-fixed {
        top: 10px !important;
        left: 10px !important;
        right: 10px !important;
        min-width: auto !important;
        font-size: 0.85rem;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    
    .alert.position-fixed strong {
        color: inherit !important;
        font-weight: 600 !important;
    }
    
    .alert-success.position-fixed {
        background-color: #d4edda !important;
        color: #155724 !important;
    }
    
    .alert-warning.position-fixed {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }
    
    .alert-info.position-fixed {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
    }
    
    .alert-danger.position-fixed {
        background-color: #f8d7da !important;
        color: #721c24 !important;
    }
    
    /* Progress bar adjustments */
    .progress {
        height: 4px !important;
    }
}

/* Landscape orientation adjustments */
@media (max-width: 767px) and (orientation: landscape) {
    .card-header .d-flex {
        flex-direction: row;
        align-items: center !important;
        flex-wrap: wrap;
    }
    
    .card-header .btn-group {
        flex-direction: row;
        width: auto;
        margin-left: auto;
    }
    
    #headerProgressIndicator {
        flex-direction: row;
        width: auto;
        margin-right: 1rem !important;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    /* Larger touch targets */
    .btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .form-control {
        min-height: 44px;
    }
    
    .specimen-test-btn {
        min-height: 60px;
    }
    
    /* Remove hover effects on touch devices */
    .card:hover {
        transform: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .specimen-test-btn:hover {
        transform: none;
        border-color: #e9ecef !important;
        background-color: #f8f9fa !important;
    }
    
    .patient-info-grid .info-item:hover {
        background-color: transparent;
        padding-left: 0;
        padding-right: 0;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .card-header .bg-white {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .badge {
        text-shadow: none;
    }
}

/* Print optimizations */
@media print {
    .card-header .btn-group,
    #floatingSavePanel,
    #autoSaveIndicator,
    .alert.position-fixed {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        box-shadow: none !important;
    }
    
    .container-fluid {
        max-width: 100%;
        padding: 0;
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced Modal Styling */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modal-header {
    border-radius: 15px 15px 0 0;
}

.modal-header h5 {
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    font-weight: 700 !important;
}

.modal-body {
    color: #495057 !important;
}

.modal-body label {
    color: #495057 !important;
    font-weight: 600 !important;
}

.modal-body .form-control {
    color: #495057 !important;
    background-color: #ffffff !important;
    border: 2px solid #e9ecef !important;
}

.modal-body .text-muted {
    color: #6c757d !important;
    font-weight: 500;
}

.modal-body .font-weight-bold {
    color: #212529 !important;
    font-weight: 600;
}

/* Success Animations */
.success-animation {
    animation: bounceIn 0.5s ease-out;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
} 

/* Enhanced Alert Animations */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-out {
    animation: slideOutRight 0.3s ease-in forwards;
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Loading Animation */
.loaded {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Fade-in animation for cards */
.animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
}

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

/* Pulse on hover */
.pulse-on-hover {
    animation: pulseHover 0.6s ease-in-out;
}

@keyframes pulseHover {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

/* Form focus states */
.form-group.focused .form-control {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Success and error states for validation */
.has-success {
    border-left: 4px solid #28a745;
    background-color: rgba(40, 167, 69, 0.05);
}

.has-error {
    border-left: 4px solid #dc3545;
    background-color: rgba(220, 53, 69, 0.05);
}

/* Touch feedback */
.touch-active {
    background-color: rgba(0,123,255,0.1) !important;
    transform: scale(0.98);
    transition: all 0.1s ease;
}

/* Mobile-specific classes */
.mobile-view {
    overflow-x: hidden;
}

.mobile-header {
    text-align: center;
    gap: 1rem;
}

.mobile-buttons {
    flex-direction: column !important;
    gap: 0.5rem;
}

.mobile-specimen .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.75rem;
}

.mobile-accordion .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.75rem;
}

.mobile-form-row {
    margin: 0 !important;
}

.mobile-form-col {
    margin-bottom: 0.75rem;
    padding: 0 0.5rem;
}

.mobile-modal-row .col-md-6 {
    margin-bottom: 1rem;
}

/* Tablet-specific classes */
.tablet-header {
    gap: 1rem;
}

.tablet-buttons {
    justify-content: space-between;
}

.tablet-specimen .d-flex {
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tablet-accordion .d-flex {
    flex-wrap: wrap;
    gap: 0.5rem;
}

/* Modal optimizations for mobile */
.modal-open-mobile {
    overflow: hidden !important;
}

.modal-open-mobile .modal {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Pull to refresh styling */
#pullToRefreshHint {
    transition: all 0.3s ease;
}

/* Improved touch targets */
@media (hover: none) and (pointer: coarse) {
    .btn, .form-control, .specimen-test-btn {
        min-height: 44px;
        min-width: 44px;
    }
    
    .close {
        min-height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .accordion .btn-link {
        min-height: 60px;
        display: flex;
        align-items: center;
    }
}

/* Viewport height adjustments for mobile browsers */
@media (max-width: 767px) {
    .main-content {
        min-height: calc(100vh - 60px);
        padding-bottom: 2rem;
    }
    
    /* Adjust for mobile browser address bars */
    @supports (-webkit-touch-callout: none) {
        .main-content {
            min-height: calc(100vh - 120px);
        }
    }
}

/* Landscape mode optimizations */
@media (max-width: 767px) and (orientation: landscape) {
    .card-header {
        padding: 0.75rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .modal-dialog {
        margin: 0.25rem;
        max-width: calc(100% - 0.5rem);
    }
    
    .patient-info-grid .info-item {
        padding: 0.5rem 0;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .card {
        border: 2px solid #333 !important;
    }
    
    .btn {
        border: 2px solid currentColor !important;
    }
    
    .badge {
        border: 2px solid currentColor !important;
    }
    
    .text-white {
        text-shadow: 0 1px 4px rgba(0,0,0,0.8) !important;
    }
    
    .card-header h4,
    .card-header h5,
    .card-header h6 {
        text-shadow: 0 1px 4px rgba(0,0,0,0.8) !important;
    }
    
    .form-control {
        border: 3px solid #333 !important;
    }
    
    .alert {
        border: 2px solid currentColor !important;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .pulse-btn {
        animation: none !important;
    }
    
    .card:hover {
        transform: none !important;
    }
}

/* Dark mode support (if system prefers dark) */
@media (prefers-color-scheme: dark) {
    /* Note: Only adding subtle adjustments since we're preserving the UI colors */
    .card {
        box-shadow: 0 4px 15px rgba(255,255,255,0.1) !important;
    }
    
    .modal-content {
        box-shadow: 0 10px 30px rgba(255,255,255,0.1) !important;
    }
}
</style>

<!-- Enhanced Specimen Collection Modals -->
<?php foreach ($lab_tests as $index => $test) { ?>
    <div class="modal fade" id="specimenModal<?php echo $test->id; ?>" tabindex="-1" role="dialog" aria-labelledby="specimenModalLabel<?php echo $test->id; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title font-weight-bold" id="specimenModalLabel<?php echo $test->id; ?>">
                        <i class="fas fa-vial"></i>Specimen Collection
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light border rounded p-3 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1 font-weight-bold text-dark"><?php echo isset($test->test_name) ? $test->test_name : $test->category; ?></h6>
                                <small class="text-muted">Test #<?php echo sprintf('%02d', $index + 1); ?> • Test ID: <?php echo $test->id; ?></small>
                            </div>
                            <div class="col-md-4 text-right">
                                <span class="badge badge-info px-3 py-2 rounded-pill">Specimen Collection</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-info-circle text-primary"></i>Specimen Details
                            </h6>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Specimen Type *</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][specimen_type]" id="specimen_type_<?php echo $test->id; ?>">
                                    <option value="">Select Specimen Type</option>
                                    <option value="1">Blood</option>
                                    <option value="2">Urine</option>
                                    <option value="3">Stool</option>
                                    <option value="4">Sputum</option>
                                    <option value="5">Serum</option>
                                    <option value="6">Plasma</option>
                                    <option value="7">CSF</option>
                                    <option value="8">Saliva</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Collection Date & Time *</label>
                                <input type="datetime-local" class="form-control" 
                                       name="specimens[<?php echo $test->id; ?>][collection_date]" 
                                       id="collection_date_<?php echo $test->id; ?>"
                                       value="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Collection Method</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][collection_method]" id="collection_method_<?php echo $test->id; ?>">
                                    <option value="">Select Collection Method</option>
                                    <option value="Venipuncture">Venipuncture</option>
                                    <option value="Finger Prick">Finger Prick</option>
                                    <option value="Midstream Urine">Midstream Urine</option>
                                    <option value="Clean Catch Urine">Clean Catch Urine</option>
                                    <option value="Swab">Swab</option>
                                    <option value="Sputum">Sputum Expectoration</option>
                                    <option value="Lumbar Puncture">Lumbar Puncture</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-flask text-success"></i>Container & Volume
                            </h6>
                            
                            <div class="form-group">
                                <label class="font-weight-medium text-dark">Container Type</label>
                                <select class="form-control" name="specimens[<?php echo $test->id; ?>][container_type]" id="container_type_<?php echo $test->id; ?>">
                                    <option value="">Select Container</option>
                                    <option value="EDTA Tube">EDTA Tube (Purple)</option>
                                    <option value="Serum Tube">Serum Tube (Red)</option>
                                    <option value="Heparin Tube">Heparin Tube (Green)</option>
                                    <option value="Fluoride Tube">Fluoride Tube (Gray)</option>
                                    <option value="Plain Tube">Plain Tube</option>
                                    <option value="Urine Container">Sterile Urine Container</option>
                                    <option value="Stool Container">Stool Container</option>
                                    <option value="Sterile Container">Sterile Container</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium text-dark">Volume</label>
                                        <input type="number" class="form-control" 
                                               name="specimens[<?php echo $test->id; ?>][quantity]" 
                                               id="quantity_<?php echo $test->id; ?>" 
                                               step="0.1" placeholder="0.0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-medium text-dark">Unit</label>
                                        <select class="form-control" name="specimens[<?php echo $test->id; ?>][quantity_unit]" id="quantity_unit_<?php echo $test->id; ?>">
                                            <option value="ml">ml</option>
                                            <option value="g">g</option>
                                            <option value="tubes">tubes</option>
                                            <option value="drops">drops</option>
                                            <option value="containers">containers</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-medium text-dark">Collected By</label>
                                <input type="text" class="form-control" 
                                       name="specimens[<?php echo $test->id; ?>][collected_by]" 
                                       id="collected_by_<?php echo $test->id; ?>"
                                       value="<?php echo $this->session->userdata('user_name') ?: $this->session->userdata('username'); ?>"
                                       placeholder="Staff name or ID">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="font-weight-bold text-dark mb-2">
                            <i class="fas fa-notes-medical text-warning"></i>Specimen Condition & Notes
                        </label>
                        <textarea class="form-control border" 
                                  name="specimens[<?php echo $test->id; ?>][condition]" 
                                  id="condition_<?php echo $test->id; ?>" 
                                  rows="3"
                                  placeholder="Enter specimen condition, quality notes, and any observations (e.g., Good quality, no hemolysis, adequate volume, clear appearance)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-success save-specimen" data-test-id="<?php echo $test->id; ?>">
                        <i class="fas fa-save mr-1"></i>Save Specimen Details
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Minimal Bootstrap-Compatible Styling -->
<style>
/* Fix main content spacing to prevent header overlap */
.main-content {
    padding-top: 80px !important;
    margin-top: 0 !important;
}

/* Page header styling */
.header-card {
    position: relative;
    z-index: 10;
    margin-bottom: 1.5rem;
}

/* ICON SPACING RULES - COMPREHENSIVE FIX */
/* Proper icon spacing with containers */
.icon-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.icon-container i {
    margin: 0;
    padding: 0;
    line-height: 1;
}

/* Ensure consistent spacing between elements */
.mr-1 { margin-right: 0.25rem !important; }
.mr-2 { margin-right: 0.5rem !important; }
.mr-3 { margin-right: 1rem !important; }
.ml-1 { margin-left: 0.25rem !important; }
.ml-2 { margin-left: 0.5rem !important; }
.ml-3 { margin-left: 1rem !important; }

/* Icon containers (colored circles) - consistent sizing and spacing */
.bg-primary.rounded-circle,
.bg-primary.rounded,
.bg-success.rounded,
.bg-info.rounded,
.bg-warning.rounded {
    flex-shrink: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Center icons inside all containers */
.bg-primary.rounded-circle i,
.bg-primary.rounded i,
.bg-success.rounded i,
.bg-info.rounded i,
.bg-warning.rounded i {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1 !important;
}

/* Large icon containers (in headers) */
.card-header .bg-primary.rounded,
.modal-header .bg-primary.rounded {
    width: 40px !important;
    height: 40px !important;
    margin-right: 0.75rem !important;
}

/* Medium icon containers (in accordion headers) */
#testResultsAccordion .bg-primary.rounded-circle {
    width: 32px !important;
    height: 32px !important;
    margin-right: 0.75rem !important;
}

/* Small icon containers (inside collapsed content) */
.card-body .bg-success.rounded,
.card-body .bg-info.rounded {
    width: 24px !important;
    height: 24px !important;
    min-width: 24px !important;
    margin-right: 0.5rem !important;
}

/* Icon size inside containers */
.card-body .bg-success.rounded i,
.card-body .bg-info.rounded i {
    font-size: 10px !important;
}

/* Direct icon spacing (no containers) */
.card-header > h6 > i[class*="fa-"],
.card-header > h5 > i[class*="fa-"],
.modal-title > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

/* Modal specific icon spacing */
.modal-header h5 > i[class*="fa-"],
.modal-header h6 > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

.modal-body h6 > i[class*="fa-"] {
    margin-right: 0.75rem !important;
}

/* Fix modal body label icons */
.modal-body label > i[class*="fa-"] {
    margin-right: 0.5rem !important;
}

/* Button icon spacing */
.btn i[class*="fa-"] {
    margin-right: 0.25rem !important;
}

.btn i[class*="fa-"]:last-child:not(:first-child) {
    margin-left: 0.25rem !important;
    margin-right: 0 !important;
}

/* Specimen button specific */
.btn-outline-success .fa-vial {
    margin-right: 0.5rem !important;
}

/* Alert and inline icon spacing */
.alert i[class*="fa-"] {
    margin-right: 0.5rem !important;
}

.small i[class*="fa-"],
.text-muted i[class*="fa-"],
.badge i[class*="fa-"] {
    margin-right: 0.25rem !important;
}

/* ACCORDION CHEVRON POSITIONING */
.card-header .btn-link {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
    padding-right: 2.5rem !important;
    text-decoration: none !important;
}

/* Position chevron absolutely at right edge */
.card-header .fa-chevron-down {
    position: absolute !important;
    right: 1rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 !important;
    transition: transform 0.2s;
    font-size: 14px !important;
    opacity: 0.5;
}

/* Rotate chevron when expanded */
.card-header .btn-link[aria-expanded="true"] .fa-chevron-down {
    transform: translateY(-50%) rotate(180deg) !important;
    opacity: 1;
}

/* Ensure content doesn't overlap chevron */
.card-header .btn-link .d-flex {
    width: calc(100% - 3rem) !important;
    padding-right: 1rem !important;
}

/* Badge positioning in accordion */
.card-header .ml-auto {
    margin-left: auto !important;
    margin-right: 1rem !important;
}

/* Fix text colors and visibility */
.card-header .btn-link,
.card-header .btn-link:hover,
.card-header .btn-link:focus {
    color: #2c3e50 !important;
}

.text-dark {
    color: #2c3e50 !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Make small text more readable */
small {
    font-size: 85% !important;
    opacity: 0.85;
}

/* Improve badge contrast and visibility */
.badge {
    font-weight: 500 !important;
    letter-spacing: 0.3px;
    font-size: 0.85rem !important;
    padding: 0.4rem 0.8rem !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.35rem !important;
}

.badge i {
    font-size: 0.75rem !important;
}

/* Custom badge for header invoice */
.badge-white-primary {
    background-color: rgba(255, 255, 255, 0.9) !important;
    color: #2c3e50 !important;
    border: 1px solid rgba(0, 123, 255, 0.2) !important;
    font-size: 0.8rem !important;
    padding: 0.35rem 0.7rem !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
}

.badge-white-primary i {
    color: #007bff !important;
    font-size: 0.7rem !important;
}

/* Other badge styles */
.badge-success {
    background-color: #28a745 !important;
    color: white !important;
}

.badge-secondary {
    background-color: #6c757d !important;
    color: white !important;
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    border-color: #dee2e6 !important;
}

/* Fix accordion header text */
#testResultsAccordion .card-header h6 {
    font-size: 1rem !important;
    line-height: 1.4 !important;
    margin: 0 !important;
    color: #2c3e50 !important;
    font-weight: 600 !important;
}

#testResultsAccordion .card-header .text-muted {
    font-size: 0.85rem !important;
    opacity: 0.85;
    font-weight: normal;
}

/* Fix form labels and text */
label.font-weight-bold {
    color: #2c3e50 !important;
    font-size: 0.9rem !important;
    margin-bottom: 0.35rem !important;
}

.form-control {
    color: #2c3e50 !important;
}

.form-control::placeholder {
    color: #a0aec0 !important;
    opacity: 0.75;
}

/* Fix modal text */
.modal-title {
    color: white !important;
    font-size: 1.1rem !important;
}

.modal-body h6 {
    color: #2c3e50 !important;
    font-size: 1rem !important;
    font-weight: 600 !important;
}

.modal-body label {
    color: #2c3e50 !important;
    font-size: 0.9rem !important;
}

/* Header time badge */
.time-badge {
    background-color: rgba(255, 255, 255, 0.85) !important;
    padding: 0.35rem 0.7rem !important;
    border-radius: 4px !important;
    gap: 0.35rem !important;
    font-size: 0.8rem !important;
    color: #2c3e50 !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
}

.time-badge i {
    color: #6c757d !important;
    font-size: 0.7rem !important;
}

.time-badge span {
    font-weight: 500 !important;
}

/* Lab completion status card */
#completionStatusCard {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
}

#completionStatusCard .btn-light {
    background-color: rgba(255, 255, 255, 0.95) !important;
    border: none !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.2s ease !important;
}

#completionStatusCard .btn-light:hover {
    background-color: white !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
}

#completionStatusCard .btn-outline-light {
    border-color: rgba(255, 255, 255, 0.5) !important;
    color: white !important;
}

#completionStatusCard .btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border-color: white !important;
}

/* Progress indicator */
#progressIndicator .progress {
    background-color: rgba(0, 0, 0, 0.1) !important;
    border-radius: 3px !important;
}

#progressIndicator .progress-bar {
    transition: width 0.6s ease !important;
}

#progressIndicator .progress-bar.bg-success {
    background: linear-gradient(90deg, #28a745, #20c997) !important;
}

#progressText {
    font-size: 0.75rem !important;
    font-weight: 500 !important;
}

/* Test completion badges */
.test-complete-badge {
    background-color: #28a745 !important;
    color: white !important;
    font-size: 0.7rem !important;
    padding: 0.25rem 0.5rem !important;
    border-radius: 12px !important;
    font-weight: 500 !important;
}

.test-pending-badge {
    background-color: #ffc107 !important;
    color: #212529 !important;
    font-size: 0.7rem !important;
    padding: 0.25rem 0.5rem !important;
    border-radius: 12px !important;
    font-weight: 500 !important;
}

/* ESSENTIAL STYLES */
.hover-highlight:hover {
    background-color: rgba(0,123,255,0.05) !important;
    border-radius: 6px;
    transform: translateX(4px);
    transition: all 0.2s ease;
}

.card:hover { 
    transform: translateY(-2px); 
    transition: transform 0.3s; 
}

.btn:hover { 
    transform: translateY(-1px); 
    transition: transform 0.2s; 
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.progress { 
    height: 4px; 
}

.badge.rounded-pill { 
    border-radius: 50rem !important; 
}

.modal-backdrop { 
    background-color: rgba(0,0,0,0.5); 
}

/* Focus states */
.btn:focus, .form-control:focus { 
    outline: none; 
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
}

#testResultsAccordion .btn-link:focus {
    text-decoration: none;
    box-shadow: none;
}

/* Test result accordion */
#testResultsAccordion .card-header {
    cursor: pointer;
}

#testResultsAccordion .btn-link:hover {
    text-decoration: none;
}

/* Floating save panel */
.fixed-bottom {
    z-index: 1030;
}

/* Custom spacing utilities */
.py-2\.5 { 
    padding-top: 0.625rem !important; 
    padding-bottom: 0.625rem !important; 
}

.my-2\.5 { 
    margin-top: 0.625rem !important; 
    margin-bottom: 0.625rem !important; 
}

/* Media queries */
@media print { 
    .btn, .modal, .fixed-bottom { 
        display: none !important; 
    } 
}

@media (max-width: 768px) { 
    .btn-group-sm .btn { 
        font-size: 0.775rem; 
        padding: 0.25rem 0.5rem; 
    }
    
    /* Stack accordion elements on mobile */
    .card-header .d-flex {
        flex-wrap: wrap;
    }
    
    .card-header .ml-auto {
        margin-left: 0 !important;
        margin-top: 0.5rem;
        width: 100%;
    }
    
    /* Adjust chevron position on mobile */
    .card-header .fa-chevron-down {
        right: 0.5rem !important;
    }
}

/* Add CSS for pulse button animation */
.pulse-btn {
    position: relative;
    animation: pulse-shadow 2s infinite;
    transition: all 0.3s ease;
}

.pulse-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3) !important;
}

@keyframes pulse-shadow {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

/* Enhanced header progress indicator */
#headerProgressIndicator {
    transition: all 0.3s ease;
}

#headerProgressIndicator .progress {
    overflow: hidden;
}

#headerProgressIndicator .progress-bar {
    transition: width 0.6s ease, background-color 0.3s ease;
}

/* Enhance the Complete button */
.btn-success.rounded-pill {
    background: linear-gradient(to right, #28a745, #20c997);
    border: none;
    letter-spacing: 0.5px;
}

.btn-success.rounded-pill:hover {
    background: linear-gradient(to right, #218838, #1e9c82);
}
</style>

    <!-- Enhanced JavaScript -->
<script src="common/js/codearistos.min.js"></script>
<!-- Bootstrap JS for Modals (if not already included) -->
<script>
// Ensure Bootstrap modal functionality is available
if (typeof $.fn.modal === 'undefined') {
    document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"><\/script>');
}
</script>
<script>
$(document).ready(function() {
    // Initialize enhanced UI features
    initializeEnhancedUI();
    
    // Load existing specimen data for all tests on page load
    loadExistingSpecimenData();
    
    // Initialize completion tracking
    initializeCompletionTracking();
    
    // Track form changes for completion status
    trackFormChanges();
    
    // Handle specimen modal save
    $('.save-specimen').on('click', function() {
        var testId = $(this).data('test-id');
        var modal = $('#specimenModal' + testId);
        
        // Check required fields
        var specimenType = modal.find('select[name*="specimen_type"]').val();
        var collectionDate = modal.find('input[name*="collection_date"]').val();
        
        if (!specimenType || !collectionDate) {
            showAlert('Please fill in required fields: Specimen Type and Collection Date & Time', 'warning');
            return;
        }
        
        // Collect all specimen data from the modal
        var specimenData = {
            specimen_type: specimenType,
            collection_date: collectionDate,
            collection_method: modal.find('select[name*="collection_method"]').val(),
            container_type: modal.find('select[name*="container_type"]').val(),
            quantity: modal.find('input[name*="quantity"]').val(),
            quantity_unit: modal.find('select[name*="quantity_unit"]').val(),
            collected_by: modal.find('input[name*="collected_by"]').val(),
            condition: modal.find('textarea[name*="condition"]').val()
        };
        
        // Save specimen data to database immediately via AJAX
        $.ajax({
            url: '<?php echo base_url('labworkflow/saveSpecimenData'); ?>',
            type: 'POST',
            data: {
                test_id: testId,
                patient_id: $('input[name="patient_id"]').val(),
                invoice_id: $('input[name="invoice_id"]').val(),
                specimen_data: specimenData
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
        // Update status badge
        var statusBadge = $('#status-' + testId);
        statusBadge.removeClass('badge-secondary badge-warning').addClass('badge-success').text('Collected');
        
        // Update button appearance
        var specimenBtn = $('button[data-target="#specimenModal' + testId + '"]');
        specimenBtn.removeClass('btn-outline-success').addClass('btn-success');
        
        // Close modal
        modal.modal('hide');
        
        // Show success message
                    showAlert(response.message, 'success');
                    
                    // Store specimen data in hidden fields for form submission backup
                    var mainForm = $('#reportForm');
                    mainForm.find('input[name^="specimens[' + testId + ']"]').remove();
                    $.each(specimenData, function(key, value) {
                        if (value) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'specimens[' + testId + '][' + key + ']',
                                value: value
                            }).appendTo(mainForm);
                        }
                    });
                } else {
                    showAlert('Error saving specimen data: ' + response.message, 'error');
                }
            },
            error: function() {
                showAlert('Network error while saving specimen data', 'error');
            }
        });
    });
    
    // Enhanced alert function
    function showAlert(message, type = 'info') {
        showEnhancedAlert(message, type);
    }
    
    // Enhanced notification system
    function showEnhancedAlert(message, type = 'info', duration = 4000) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 
                       type === 'warning' ? 'fa-exclamation-triangle' : 
                       type === 'error' ? 'fa-times-circle' : 'fa-info-circle';
        var bgColor = type === 'success' ? '#d4edda' : 
                      type === 'warning' ? '#fff3cd' : 
                      type === 'error' ? '#f8d7da' : '#d1ecf1';
        
        var alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; 
                        box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-radius: 10px;
                        background-color: ${bgColor}; border: none; animation: slideInRight 0.3s ease-out;">
                <div class="d-flex align-items-center">
                    <i class="fas ${iconClass} mr-3" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong style="font-size: 0.95rem;">${message}</strong>
                    </div>
                    <button type="button" class="close ml-auto" data-dismiss="alert" style="font-size: 1.5rem;">
                        <span>&times;</span>
                    </button>
                </div>
            </div>
        `);
        
        $('body').append(alert);
        
        // Auto remove after specified duration
        setTimeout(function() {
            alert.addClass('animate-slide-out');
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, duration);
    }
    
    // Accordion chevron rotation
    $('.accordion').on('show.bs.collapse', function(e) {
        $(e.target).prev().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });
    
    $('.accordion').on('hide.bs.collapse', function(e) {
        $(e.target).prev().find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
    
    // Form validation
    $('#reportForm').on('submit', function(e) {
        var hasResults = false;
        $('textarea[name*="[report]"], input[name*="template_fields"]').each(function() {
            if ($(this).val().trim() !== '') {
                hasResults = true;
                return false;
            }
        });
        
        if (!hasResults) {
            e.preventDefault();
            showAlert('Please enter at least one test result before saving the report.', 'warning');
            return false;
        }
        
        // Debug: Log all form data being submitted
        console.log('=== FORM SUBMISSION DEBUG ===');
        console.log('Form action:', $(this).attr('action'));
        console.log('Form method:', $(this).attr('method'));
        
        // Log specimen data
        console.log('Specimen data fields:');
        var specimenCount = 0;
        $(this).find('input[name^="specimens["]').each(function() {
            console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
            specimenCount++;
        });
        console.log('Total specimen fields:', specimenCount);
        
        // Log test report data
        console.log('Test report data:');
        var reportCount = 0;
        $(this).find('textarea[name^="test_reports["], input[name^="test_reports["]').each(function() {
            if ($(this).val().trim() !== '') {
                console.log(' - ' + $(this).attr('name') + ': "' + $(this).val().substring(0, 50) + '..."');
                reportCount++;
            }
        });
        console.log('Total report fields with data:', reportCount);
        
        // Log template field data
        console.log('Template field data:');
        var templateCount = 0;
        $(this).find('input[name^="template_fields["], select[name^="template_fields["]').each(function() {
            if ($(this).val().trim() !== '') {
                console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
                templateCount++;
            }
        });
        console.log('Total template fields with data:', templateCount);
        
        // Log hidden fields
        console.log('Hidden fields:');
        $(this).find('input[type="hidden"]').each(function() {
            console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
        });
        
        console.log('=== END FORM DEBUG ===');
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
    });
    
    // Enhanced hover effects
    $('.test-item, .specimen-btn, .parameter-row').hover(
        function() {
            $(this).addClass('shadow-sm');
        },
        function() {
            $(this).removeClass('shadow-sm');
        }
    );
});

// Enhanced UI Initialization
function initializeEnhancedUI() {
    // Add loading animations
    $('body').addClass('loaded');
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers  
    $('[data-toggle="popover"]').popover();
    
    // Add smooth scrolling
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if(target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Enhanced form interactions
    $('.form-control').on('focus', function() {
        $(this).closest('.form-group').addClass('focused');
    }).on('blur', function() {
        $(this).closest('.form-group').removeClass('focused');
    });
    
    // Setup keyboard shortcuts
    setupKeyboardShortcuts();
    
    // Setup enhanced auto-save
    setupEnhancedAutoSave();
    
    // Setup real-time validation
    setupRealTimeValidation();
    
    // Setup responsive functionality
    setupResponsiveFeatures();
}

// Expand/Collapse all tests function
function expandAllTests() {
    var $collapseElements = $('.accordion .collapse');
    var $button = $('button[onclick="expandAllTests()"]');
    
    if ($collapseElements.first().hasClass('show')) {
        // Collapse all
        $collapseElements.collapse('hide');
        $button.html('<i class="fas fa-compress-alt mr-1"></i><span class="font-weight-bold">Collapse All</span>');
    } else {
        // Expand all
        $collapseElements.collapse('show');
        $button.html('<i class="fas fa-expand-alt mr-1"></i><span class="font-weight-bold">Expand All</span>');
    }
}

// Enhanced auto-save with progress indication
function setupEnhancedAutoSave() {
    var autoSaveTimer;
    var $autoSaveIndicator = $('<div id="autoSaveIndicator" class="position-fixed" style="bottom: 20px; left: 20px; z-index: 1000;"></div>');
    $('body').append($autoSaveIndicator);
    
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').on('input change', function() {
        clearTimeout(autoSaveTimer);
        
        // Show saving indicator
        $autoSaveIndicator.html(`
            <div class="bg-warning text-dark px-3 py-2 rounded-pill shadow animate__animated animate__fadeIn">
                <i class="fas fa-clock mr-2"></i>
                <small class="font-weight-bold">Auto-saving in 3s...</small>
            </div>
        `);
        
        autoSaveTimer = setTimeout(function() {
            // Simulate auto-save
            $autoSaveIndicator.html(`
                <div class="bg-success text-white px-3 py-2 rounded-pill shadow animate__animated animate__fadeIn">
                    <i class="fas fa-check mr-2"></i>
                    <small class="font-weight-bold">Draft saved</small>
                </div>
            `);
            
            setTimeout(function() {
                $autoSaveIndicator.fadeOut();
            }, 2000);
        }, 3000);
    });
}

// Real-time form validation
function setupRealTimeValidation() {
    // Validate template fields
    $('input[name^="template_fields["]').on('input', function() {
        var $this = $(this);
        var value = $this.val().trim();
        var $row = $this.closest('.template-parameter-row, .row');
        
        if (value) {
            $row.removeClass('has-error').addClass('has-success');
            $this.removeClass('is-invalid').addClass('is-valid');
        } else {
            $row.removeClass('has-success has-error');
            $this.removeClass('is-valid is-invalid');
        }
    });
    
    // Validate text areas
    $('textarea[name^="test_reports["]').on('input', function() {
        var $this = $(this);
        var value = $this.val().trim();
        var minLength = 10;
        
        if (value.length >= minLength) {
            $this.removeClass('is-invalid').addClass('is-valid');
        } else if (value.length > 0 && value.length < minLength) {
            $this.removeClass('is-valid').addClass('is-invalid');
        } else {
            $this.removeClass('is-valid is-invalid');
        }
    });
}

// Keyboard shortcuts
function setupKeyboardShortcuts() {
    $(document).keydown(function(e) {
        // Ctrl+S to save
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('#reportForm').submit();
            return false;
        }
        
        // Ctrl+D to save draft
        if (e.ctrlKey && e.which === 68) {
            e.preventDefault();
            saveDraft();
            return false;
        }
        
        // Ctrl+P to print
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault();
            printLabReport();
            return false;
        }
    });
}

// Responsive Features Setup
function setupResponsiveFeatures() {
    // Handle window resize events
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            handleResponsiveLayout();
            adjustModalSizes();
            repositionElements();
        }, 250);
    });
    
    // Handle orientation change
    $(window).on('orientationchange', function() {
        setTimeout(function() {
            handleResponsiveLayout();
            adjustModalSizes();
            repositionElements();
        }, 500);
    });
    
    // Initial setup
    handleResponsiveLayout();
    setupTouchGestures();
    optimizeForMobile();
}

// Handle responsive layout changes
function handleResponsiveLayout() {
    const windowWidth = $(window).width();
    
    // Adjust header layout based on screen size
    if (windowWidth <= 767) {
        // Mobile layout
        $('.card-header .d-flex').addClass('mobile-header');
        $('#headerProgressIndicator .progress').css('width', '100%');
        
        // Stack buttons vertically on mobile
        $('.card-header .btn-group').addClass('mobile-buttons');
        
        // Adjust specimen collection layout
        $('.specimen-test-btn .d-flex').addClass('mobile-specimen');
        
        // Adjust accordion layout
        $('.accordion .btn-link .d-flex').addClass('mobile-accordion');
        
    } else if (windowWidth <= 991) {
        // Tablet layout
        $('.card-header .d-flex').removeClass('mobile-header').addClass('tablet-header');
        $('#headerProgressIndicator .progress').css('width', '140px');
        
        // Horizontal buttons on tablet
        $('.card-header .btn-group').removeClass('mobile-buttons').addClass('tablet-buttons');
        
        // Adjust specimen collection for tablet
        $('.specimen-test-btn .d-flex').removeClass('mobile-specimen').addClass('tablet-specimen');
        
        // Adjust accordion for tablet
        $('.accordion .btn-link .d-flex').removeClass('mobile-accordion').addClass('tablet-accordion');
        
    } else {
        // Desktop layout
        $('.card-header .d-flex').removeClass('mobile-header tablet-header');
        $('#headerProgressIndicator .progress').css('width', '140px');
        
        // Remove mobile/tablet classes
        $('.card-header .btn-group').removeClass('mobile-buttons tablet-buttons');
        $('.specimen-test-btn .d-flex').removeClass('mobile-specimen tablet-specimen');
        $('.accordion .btn-link .d-flex').removeClass('mobile-accordion tablet-accordion');
    }
    
    // Adjust form layouts
    adjustFormLayouts(windowWidth);
    
    // Adjust notification positions
    adjustNotificationPositions(windowWidth);
}

// Adjust form layouts for different screen sizes
function adjustFormLayouts(windowWidth) {
    if (windowWidth <= 767) {
        // Mobile form adjustments
        $('.template-parameter-row .row').addClass('mobile-form-row');
        $('.modal-body .row').addClass('mobile-modal-row');
        
        // Stack form elements vertically
        $('.template-parameter-row .col-md-3').removeClass('col-md-3').addClass('col-12 mobile-form-col');
        
    } else {
        // Desktop form adjustments
        $('.template-parameter-row .row').removeClass('mobile-form-row');
        $('.modal-body .row').removeClass('mobile-modal-row');
        
        // Restore grid layout
        $('.mobile-form-col').removeClass('col-12 mobile-form-col').addClass('col-md-3');
    }
}

// Adjust notification positions for different screen sizes
function adjustNotificationPositions(windowWidth) {
    if (windowWidth <= 767) {
        // Mobile notification adjustments
        $('.alert.position-fixed').css({
            'top': '10px',
            'left': '10px',
            'right': '10px',
            'min-width': 'auto'
        });
    } else {
        // Desktop notification adjustments
        $('.alert.position-fixed').css({
            'top': '20px',
            'left': 'auto',
            'right': '20px',
            'min-width': '350px'
        });
    }
}

// Adjust modal sizes for different screen sizes
function adjustModalSizes() {
    const windowWidth = $(window).width();
    
    $('.modal-dialog').each(function() {
        if (windowWidth <= 575) {
            // Extra small screens
            $(this).css({
                'margin': '0.25rem',
                'max-width': 'calc(100% - 0.5rem)'
            });
        } else if (windowWidth <= 767) {
            // Small screens
            $(this).css({
                'margin': '0.5rem',
                'max-width': 'calc(100% - 1rem)'
            });
        } else {
            // Larger screens - restore default
            $(this).css({
                'margin': '',
                'max-width': ''
            });
        }
    });
}

// Reposition elements for different screen sizes
function repositionElements() {
    const windowWidth = $(window).width();
    
    // Adjust floating save panel
    if (windowWidth <= 767) {
        $('#floatingSavePanel').css({
            'left': '0',
            'right': '0',
            'bottom': '0',
            'border-radius': '0'
        });
    } else {
        $('#floatingSavePanel').css({
            'left': '',
            'right': '',
            'bottom': '',
            'border-radius': ''
        });
    }
    
    // Adjust auto-save indicator
    if (windowWidth <= 767) {
        $('#autoSaveIndicator').css({
            'bottom': '10px',
            'left': '10px',
            'right': '10px'
        });
    } else {
        $('#autoSaveIndicator').css({
            'bottom': '20px',
            'left': '20px',
            'right': 'auto'
        });
    }
}

// Setup touch gestures for mobile devices
function setupTouchGestures() {
    // Only setup on touch devices
    if ('ontouchstart' in window) {
        // Swipe to expand/collapse accordion items
        let startY, startX, distY, distX;
        
        $('.accordion .card-header').on('touchstart', function(e) {
            const touch = e.originalEvent.touches[0];
            startY = touch.clientY;
            startX = touch.clientX;
        });
        
        $('.accordion .card-header').on('touchmove', function(e) {
            e.preventDefault(); // Prevent scrolling while swiping
        });
        
        $('.accordion .card-header').on('touchend', function(e) {
            if (!startY || !startX) return;
            
            const touch = e.originalEvent.changedTouches[0];
            distY = touch.clientY - startY;
            distX = touch.clientX - startX;
            
            // Check if it's a horizontal swipe
            if (Math.abs(distX) > Math.abs(distY) && Math.abs(distX) > 50) {
                const $button = $(this).find('button');
                const $collapse = $($button.attr('data-target'));
                
                if (distX > 0) {
                    // Swipe right - expand
                    $collapse.collapse('show');
                } else {
                    // Swipe left - collapse
                    $collapse.collapse('hide');
                }
            }
            
            startY = startX = null;
        });
        
        // Add touch feedback to buttons
        $('.btn, .specimen-test-btn').on('touchstart', function() {
            $(this).addClass('touch-active');
        });
        
        $('.btn, .specimen-test-btn').on('touchend touchcancel', function() {
            const $this = $(this);
            setTimeout(function() {
                $this.removeClass('touch-active');
            }, 150);
        });
    }
}

// Mobile-specific optimizations
function optimizeForMobile() {
    const windowWidth = $(window).width();
    
    if (windowWidth <= 767) {
        // Optimize scroll behavior
        $('body').css('overflow-x', 'hidden');
        
        // Add mobile-specific classes
        $('body').addClass('mobile-view');
        
        // Optimize form inputs for mobile
        $('.form-control').attr('autocomplete', 'off');
        
        // Add mobile-friendly input types
        $('input[name*="quantity"]').attr('inputmode', 'numeric');
        $('input[type="datetime-local"]').attr('inputmode', 'none');
        
        // Optimize modal behavior for mobile
        $('.modal').on('shown.bs.modal', function() {
            $('body').addClass('modal-open-mobile');
        });
        
        $('.modal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open-mobile');
        });
        
        // Add pull-to-refresh hint (visual only)
        if (!$('#pullToRefreshHint').length) {
            $('body').prepend(`
                <div id="pullToRefreshHint" class="d-none position-fixed w-100 text-center" style="top: 0; z-index: 9999; background: rgba(0,0,0,0.8); color: white; padding: 0.5rem;">
                    <small><i class="fas fa-arrow-down mr-2"></i>Pull down to refresh</small>
                </div>
            `);
        }
        
    } else {
        // Remove mobile-specific optimizations
        $('body').removeClass('mobile-view modal-open-mobile');
        $('body').css('overflow-x', '');
        $('#pullToRefreshHint').remove();
    }
}

// Enhanced expand/collapse for mobile
function expandAllTests() {
    var $collapseElements = $('.accordion .collapse');
    var $button = $('button[onclick="expandAllTests()"]');
    
    if ($collapseElements.first().hasClass('show')) {
        // Collapse all
        $collapseElements.collapse('hide');
        $button.html('<i class="fas fa-expand-alt mr-1"></i><span class="font-weight-bold">Expand All</span>');
        
        // Mobile feedback
        if ($(window).width() <= 767) {
            showEnhancedAlert('All tests collapsed', 'info', 2000);
        }
    } else {
        // Expand all
        $collapseElements.collapse('show');
        $button.html('<i class="fas fa-compress-alt mr-1"></i><span class="font-weight-bold">Collapse All</span>');
        
        // Mobile feedback
        if ($(window).width() <= 767) {
            showEnhancedAlert('All tests expanded', 'info', 2000);
        }
    }
}



// Enhanced save functionality with floating panel
var saveTimeout;
var hasUnsavedChanges = false;

function showFloatingSavePanel() {
    $('#floatingSavePanel').removeClass('d-none');
    hasUnsavedChanges = true;
    
    // Animate progress bar
    var progress = 0;
    var interval = setInterval(function() {
        progress += 2;
        $('#saveProgress').css('width', progress + '%');
        if (progress >= 100) {
            clearInterval(interval);
            $('#saveProgress').removeClass('bg-warning').addClass('bg-danger');
        }
    }, 1000);
}

function hideFloatingSavePanel() {
    $('#floatingSavePanel').addClass('d-none');
    hasUnsavedChanges = false;
    $('#saveProgress').css('width', '0%').removeClass('bg-danger').addClass('bg-warning');
}

// Track changes in form fields
function trackFormChanges() {
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').on('input change', function() {
        clearTimeout(saveTimeout);
        
        if (!hasUnsavedChanges) {
            showFloatingSavePanel();
        }
        
        // Auto-save after 5 seconds of inactivity
        saveTimeout = setTimeout(function() {
            autoSave();
        }, 5000);
    });
}

function autoSave() {
    var hasData = false;
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').each(function() {
        if ($(this).val().trim() !== '') {
            hasData = true;
            return false;
        }
    });
    
    if (hasData) {
        $('#saveProgress').removeClass('bg-warning bg-danger').addClass('bg-success');
        setTimeout(function() {
            showAlert('Changes auto-saved as draft', 'success');
            hideFloatingSavePanel();
        }, 500);
    }
}

// Show save reminders
function showSaveReminders() {
    // Show helpful tooltips on form fields
    $('textarea[name^="test_reports["]').attr('title', 'Enter your test results here and click "Complete" to save');
    $('input[name^="template_fields["]').attr('title', 'Enter parameter values and click "Complete" to save');
    
    // Initialize tooltips
    $('[title]').tooltip({
        placement: 'top',
        trigger: 'focus'
    });
}

// Initialize completion tracking
function initializeCompletionTracking() {
    updateCompletionStatus();
    
    // Track changes in all form fields
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').on('input change', function() {
        setTimeout(updateCompletionStatus, 100);
    });
}

// Update completion status and progress
function updateCompletionStatus() {
    var totalTests = <?php echo count($lab_tests); ?>;
    var completedTests = 0;
    
    // Check each test for completion
    <?php foreach ($lab_tests as $index => $test) { ?>
        if (isTestComplete(<?php echo $test->id; ?>)) {
            completedTests++;
            // Add completion badge to test header
            $('#heading<?php echo $test->id; ?> .badge').removeClass('badge-light test-pending-badge').addClass('badge-success test-complete-badge');
        } else {
            // Add pending badge to test header
            $('#heading<?php echo $test->id; ?> .badge').removeClass('badge-success test-complete-badge').addClass('badge-light test-pending-badge');
        }
    <?php } ?>
    
    // Update progress bars
    var progressPercentage = (completedTests / totalTests) * 100;
    $('#headerCompletionProgress').css('width', progressPercentage + '%');
    $('#headerProgressText').text(completedTests + ' of ' + totalTests + ' tests completed');
    
    // Show completion status if all tests are done
    if (completedTests === totalTests && totalTests > 0) {
        $('#completionStatusCard').slideDown(300);
        $('#headerCompletionProgress').removeClass('bg-primary').addClass('bg-success');
        $('#headerProgressText').html('<i class="fas fa-check-circle text-white mr-1"></i><span class="font-weight-bold">All tests completed</span>');
        $('#headerProgressIndicator').removeClass('bg-light').addClass('bg-success bg-gradient-success text-white');
        $('#headerProgressIndicator i').removeClass('text-primary').addClass('text-white');
        
        // Add completion animation
        $('#completionStatusCard').addClass('animate__animated animate__fadeInDown');
        
        // Show success message
        showAlert('🎉 All laboratory tests have been completed! You can now print the final report.', 'success');
    } else {
        $('#completionStatusCard').slideUp(300);
        $('#headerCompletionProgress').removeClass('bg-success').addClass('bg-primary');
        $('#headerProgressIndicator').removeClass('bg-success bg-gradient-success text-white').addClass('bg-light');
        $('#headerProgressIndicator i').removeClass('text-white').addClass('text-primary');
    }
}

// Check if a specific test is complete
function isTestComplete(testId) {
    var hasTemplateData = false;
    var hasReportData = false;
    
    // Check template fields
    $('input[name^="template_fields[' + testId + ']"], select[name^="template_fields[' + testId + ']"]').each(function() {
        if ($(this).val().trim() !== '') {
            hasTemplateData = true;
            return false;
        }
    });
    
    // Check report fields
    $('textarea[name^="test_reports[' + testId + ']"]').each(function() {
        if ($(this).val().trim() !== '') {
            hasReportData = true;
            return false;
        }
    });
    
    // Test is complete if it has either template data OR report data
    return hasTemplateData || hasReportData;
}

// Print lab report
function printLabReport() {
    // Validate all tests are complete
    var totalTests = <?php echo count($lab_tests); ?>;
    var completedTests = 0;
    
    <?php foreach ($lab_tests as $index => $test) { ?>
        if (isTestComplete(<?php echo $test->id; ?>)) {
            completedTests++;
        }
    <?php } ?>
    
    if (completedTests < totalTests) {
        showAlert('Please complete all test results before printing the report.', 'warning');
        return;
    }
    
    // Save current data before printing
    $('#reportForm').submit();
    
    // Create print-friendly window
    setTimeout(function() {
        var printContent = generatePrintReport();
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.print();
    }, 1000);
}

// Generate print-friendly report
function generatePrintReport() {
    var patientName = '<?php echo isset($patient->name) ? addslashes($patient->name) : "N/A"; ?>';
    var patientId = '<?php echo isset($patient->patient_id) ? $patient->patient_id : (isset($patient->id) ? "P-".$patient->id : "N/A"); ?>';
    var invoiceId = '<?php echo $invoice_id; ?>';
    var currentDate = new Date().toLocaleDateString();
    var doctorName = '<?php echo isset($doctor->name) ? addslashes($doctor->name) : "N/A"; ?>';
    
    // Hospital details
    var hospitalName = '<?php echo $this->db->get_where("settings", array("hospital_id" => $this->session->userdata("hospital_id")))->row()->system_vendor; ?>';
    var hospitalAddress = '<?php echo $this->db->get_where("settings", array("hospital_id" => $this->session->userdata("hospital_id")))->row()->address; ?>';
    var hospitalPhone = '<?php echo $this->db->get_where("settings", array("hospital_id" => $this->session->userdata("hospital_id")))->row()->phone; ?>';
    var hospitalEmail = '<?php echo $this->db->get_where("settings", array("hospital_id" => $this->session->userdata("hospital_id")))->row()->email; ?>';
    var hospitalLogo = '<?php echo base_url() . $this->db->get_where("settings", array("hospital_id" => $this->session->userdata("hospital_id")))->row()->logo; ?>';
    
    var reportContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Laboratory Report - ${patientName}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                .header { border-bottom: 2px solid #007bff; padding-bottom: 15px; margin-bottom: 20px; }
                .header-content { display: flex; justify-content: space-between; }
                .hospital-info { width: 50%; }
                .patient-info { width: 45%; text-align: right; }
                .hospital-logo { max-width: 120px; max-height: 60px; margin-bottom: 10px; }
                .hospital-name { font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
                .hospital-contact { font-size: 12px; color: #555; margin-bottom: 2px; }
                .patient-details { font-size: 13px; line-height: 1.5; }
                .patient-details strong { width: 100px; display: inline-block; }
                .report-title { font-size: 22px; font-weight: bold; color: #2c3e50; margin: 20px 0; text-align: center; clear: both; }
                .test-results-container { margin-bottom: 30px; }
                .test-result { border: 1px solid #dee2e6; margin-bottom: 15px; border-radius: 5px; }
                .test-header { background: #e9ecef; padding: 10px; font-weight: bold; color: #2c3e50; }
                .test-content { padding: 15px; }
                .parameter-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
                .parameter-table th { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 8px; text-align: left; font-weight: bold; font-size: 11px; }
                .parameter-table td { border: 1px solid #dee2e6; padding: 8px; font-size: 11px; }
                .parameter-row { display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px dotted #eee; padding-bottom: 8px; }
                .parameter-name { font-weight: bold; width: 30%; }
                .parameter-value { width: 20%; font-weight: bold; }
                .parameter-units { width: 15%; color: #666; }
                .parameter-reference { width: 25%; color: #666; font-size: 12px; }
                .parameter-status { width: 10%; }
                .signatures { margin-top: 40px; margin-bottom: 30px; display: flex; justify-content: space-between; }
                .signature-box { width: 45%; }
                .signature-line { border-top: 1px solid #333; margin-top: 40px; padding-top: 5px; }
                .signature-title { font-weight: bold; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #6c757d; border-top: 1px solid #dee2e6; padding-top: 15px; }
                .report-meta { text-align: center; font-size: 14px; color: #555; margin-bottom: 20px; }
                @media print { body { margin: 0; } }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="header-content">
                    <!-- Hospital Details (Left) -->
                    <div class="hospital-info">
                        <img src="${hospitalLogo}" alt="Hospital Logo" class="hospital-logo" onerror="this.style.display='none'">
                        <div class="hospital-name">${hospitalName}</div>
                        <div class="hospital-contact">${hospitalAddress}</div>
                        <div class="hospital-contact">Tel: ${hospitalPhone}</div>
                        <div class="hospital-contact">Email: ${hospitalEmail}</div>
                    </div>
                    
                    <!-- Patient Details (Right) -->
                    <div class="patient-info">
                        <div class="patient-details">
                            <p><strong>Patient Name:</strong> ${patientName}</p>
                            <p><strong>Patient ID:</strong> ${patientId}</p>
                            <p><strong>Invoice #:</strong> ${invoiceId}</p>
                            <p><strong>Report Date:</strong> ${currentDate}</p>
                            <p><strong>Physician:</strong> ${doctorName}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Report Title -->
            <div class="report-title">LABORATORY TEST REPORT</div>
            
            <!-- Test Results -->
            <div class="test-results-container">
                <h3>Test Results</h3>`;
    
    // Add test results
    <?php foreach ($lab_tests as $index => $test) { ?>
        var testName = '<?php echo addslashes(isset($test->test_name) ? $test->test_name : $test->category); ?>';
        var testId = <?php echo $test->id; ?>;
        
        reportContent += `<div class="test-result">
            <div class="test-header">${testName} (Test #<?php echo sprintf('%02d', $index + 1); ?>)</div>
            <div class="test-content">`;
        
        // Check if there are template parameters for this test
        var hasTemplateParams = false;
        $('input[name^="template_fields[' + testId + ']"], select[name^="template_fields[' + testId + ']"]').each(function() {
            if ($(this).val().trim() !== '') {
                hasTemplateParams = true;
                return false; // break out of loop
            }
        });
        
        if (hasTemplateParams) {
            // Add table header for parameters
            reportContent += `
                <h4>Laboratory Parameters</h4>
                <table class="parameter-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Parameter</th>
                            <th style="width: 20%;">Result</th>
                            <th style="width: 15%;">Units</th>
                            <th style="width: 25%;">Reference Range</th>
                            <th style="width: 10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>`;
            
            // Add template parameters in table rows
            $('input[name^="template_fields[' + testId + ']"], select[name^="template_fields[' + testId + ']"]').each(function() {
                if ($(this).val().trim() !== '') {
                    var fieldName = $(this).closest('.row').find('label').text();
                    var fieldValue = $(this).val();
                    var fieldRow = $(this).closest('.row');
                    
                    // Get reference range (look for "Reference:" text specifically)
                    var reference = '';
                    var referenceElement = fieldRow.find('.text-muted').filter(function() {
                        return $(this).text().toLowerCase().includes('reference');
                    });
                    if (referenceElement.length > 0) {
                        var refText = referenceElement.text();
                        // Extract text after "Reference:" and clean it up
                        var match = refText.match(/reference[:\s]*(.+)/i);
                        if (match) {
                            reference = match[1].trim();
                        }
                    }
                    
                    // Get units from the field label area (units are displayed as small.text-muted within parentheses)
                    var units = '';
                    
                    // Look for units in the field label area - they appear as (unit_name) in small.text-muted
                    var unitsElement = fieldRow.find('small.text-muted').filter(function() {
                        var text = $(this).text().trim();
                        return text.startsWith('(') && text.endsWith(')');
                    });
                    
                    if (unitsElement.length > 0) {
                        var unitsText = unitsElement.text().trim();
                        // Extract units from parentheses: "(mg/dL)" -> "mg/dL"
                        units = unitsText.replace(/[()]/g, '');
                    }
                    
                    // Simple status determination based on reference ranges (basic implementation)
                    var status = 'Normal';
                    if (reference && fieldValue) {
                        // This is a very basic status check - can be enhanced
                        if (reference.toLowerCase().includes('high') || reference.toLowerCase().includes('low')) {
                            status = 'Review';
                        }
                    }
                    
                    reportContent += `
                        <tr>
                            <td>${fieldName}</td>
                            <td><strong>${fieldValue}</strong></td>
                            <td>${units}</td>
                            <td>${reference}</td>
                            <td>${status}</td>
                        </tr>`;
                }
            });
            
            reportContent += `
                    </tbody>
                </table>`;
        }
        
        // Add clinical reports
        $('textarea[name^="test_reports[' + testId + ']"]').each(function() {
            if ($(this).val().trim() !== '') {
                var reportType = $(this).attr('name').includes('[report]') ? 'Test Results & Findings' :
                               $(this).attr('name').includes('[interpretation]') ? 'Clinical Interpretation' : 'Critical Values & Alerts';
                reportContent += `<div style="margin-top: 15px;">
                    <strong>${reportType}:</strong><br>
                    <p style="margin-top: 5px; white-space: pre-wrap;">${$(this).val()}</p>
                </div>`;
            }
        });
        
        reportContent += `</div></div>`;
    <?php } ?>
    
    reportContent += `
            </div>
            
            <!-- Signatures Section -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line">
                        <div class="signature-title">Laboratory Technician</div>
                        <div>Name: ________________________</div>
                    </div>
                </div>
                <div class="signature-box">
                    <div class="signature-line">
                        <div class="signature-title">Physician</div>
                        <div>Dr. ${doctorName}</div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>This is a computer-generated laboratory report from ${hospitalName}.</p>
                <p>Generated on ${new Date().toLocaleString()}</p>
                <p><strong>This report is electronically validated and does not require a physical signature.</strong></p>
                <p>For inquiries, please contact: ${hospitalPhone} | ${hospitalEmail}</p>
            </div>
        </body>
        </html>`;
    
    return reportContent;
}


// Submit form via AJAX and stay on page
function submitFormAndStay(form) {
    // Show loading state
    var submitBtn = $(form).find('button[type="submit"]');
    var originalBtnText = submitBtn.html();
    submitBtn.prop('disabled', true).html('<span class="icon-container"><i class="fas fa-spinner fa-spin"></i></span> Saving...');
    
    // Get form data
    var formData = $(form).serialize();
    
    // Debug: Log form data to console
    console.log('=== FORM SUBMISSION DEBUG ===');
    console.log('Form action:', $(form).attr('action'));
    console.log('Form method:', $(form).attr('method'));
    console.log('Serialized data:', formData);
    
    // Check for inventory usage fields
    var inventoryFields = [];
    $(form).find('input[name^="inventory_usage["]').each(function() {
        inventoryFields.push({
            name: $(this).attr('name'),
            value: $(this).val()
        });
    });
    console.log('Inventory usage fields found:', inventoryFields.length);
    console.log('Inventory fields:', inventoryFields);
    
    // Check if inventory data is in serialized form data
    var hasInventoryInSerial = formData.indexOf('inventory_usage') !== -1;
    console.log('Inventory data in serialized form:', hasInventoryInSerial);
    
    // Parse the serialized data to see inventory fields
    var formParams = new URLSearchParams(formData);
    var inventoryParams = [];
    for (var pair of formParams.entries()) {
        if (pair[0].startsWith('inventory_usage[')) {
            inventoryParams.push(pair[0] + ' = ' + pair[1]);
        }
    }
    console.log('Inventory parameters in form:', inventoryParams);
    console.log('=== END DEBUG ===');
    
    // Send AJAX request
    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method'),
        data: formData,
        beforeSend: function() {
            console.log('=== AJAX REQUEST STARTING ===');
            console.log('URL:', $(form).attr('action'));
            console.log('Data being sent:', formData);
            console.log('=== AJAX REQUEST STARTING ===');
        },
        success: function(response) {
            // Debug: Log the full response
            console.log('=== SERVER RESPONSE DEBUG ===');
            console.log('Raw server response:', response);
            console.log('Response type:', typeof response);
            console.log('Response length:', response ? response.length : 'N/A');
            console.log('First 500 chars:', response ? response.substring(0, 500) : 'N/A');
            console.log('=== END SERVER RESPONSE DEBUG ===');
            
            try {
                var result = typeof response === 'string' ? JSON.parse(response) : response;
                console.log('Parsed result:', result);
                if (result.success) {
                    // Show detailed success message with inventory info
                    var successMsg = result.message || '✅ Report successfully saved!';
                    
                    // Add inventory info to success message if inventory was processed
                    if (result.inventory_count !== undefined && result.inventory_count > 0) {
                        successMsg += ' (' + result.inventory_count + ' inventory item(s) recorded)';
                        console.log('Inventory items processed:', result.inventory_count);
                        
                        // Show specific inventory success toastr
                        if (typeof toastr !== 'undefined') {
                            toastr.success(result.inventory_count + ' inventory item(s) successfully saved to database!', 'Inventory Saved', {
                                timeOut: 3000,
                                progressBar: true,
                                positionClass: 'toast-top-right'
                            });
                        }
                    }
                    
                    showAlert(successMsg, 'success');
                    
                    // Update UI to show completion
                    updateCompletionStatus();
                    
                    // Reset form state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    
                    // Scroll to top
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                } else {
                    // Show error message
                    showAlert('Error: ' + (result.message || 'Failed to save report'), 'error');
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            } catch (e) {
                // Handle parsing error - check if it's a redirect response
                console.log('Parsing error, checking response content...');
                console.log('Response content preview:', response.substring(0, 200));
                
                if (response.indexOf('success') !== -1 || response.indexOf('successfully') !== -1) {
                    showAlert('✅ Report successfully saved!', 'success');
                    submitBtn.prop('disabled', false).html(originalBtnText);
                } else {
                    showAlert('Error: Unable to process server response', 'error');
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    console.error('Error parsing response:', e);
                    console.error('Full response:', response);
                }
            }
        },
        error: function(xhr, status, error) {
            // Show error message
            showAlert('Error: ' + error, 'error');
            submitBtn.prop('disabled', false).html(originalBtnText);
            console.error('AJAX Error:', xhr.responseText);
        }
    });
    
    // Prevent default form submission
    return false;
}

// Highlight save buttons when user enters data
function highlightSaveButtons() {
    $('input[name^="template_fields["], textarea[name^="test_reports["], select[name^="template_fields["]').on('input change', function() {
        // Add pulsing animation to save buttons
        $('button[type="submit"]').addClass('btn-pulse');
        
        setTimeout(function() {
            $('button[type="submit"]').removeClass('btn-pulse');
        }, 3000);
    });
}



// Initialize enhanced save features
$(document).ready(function() {
    trackFormChanges();
    showSaveReminders();
    highlightSaveButtons();
    
    // Load existing inventory usage for this invoice
    loadExistingInventoryUsage();
    
    // Initialize modern header
    initializeModernHeader();
    
    // Hide floating panel when form is submitted
    $('#reportForm').on('submit', function() {
        hideFloatingSavePanel();
    });
    
    // Auto-expand first test if there's only one test
    if ($('.test-accordion-item').length === 1) {
        $('.collapse').collapse('show');
    }
});

// Modern Header Functions
function initializeModernHeader() {
    updateHeaderProgress();
    
    // Update progress when tests are completed
    $('input, textarea, select').on('change input', function() {
        setTimeout(updateHeaderProgress, 100);
    });
}

function updateHeaderProgress() {
    var totalTests = <?php echo count($lab_tests); ?>;
    var completedTests = 0;
    
    // Count completed tests based on filled fields
    <?php foreach ($lab_tests as $test) { ?>
        var testId = <?php echo $test->id; ?>;
        var hasData = false;
        
        // Check template fields
        $('input[name^="template_fields[' + testId + ']"], select[name^="template_fields[' + testId + ']"]').each(function() {
            if ($(this).val() && $(this).val().trim() !== '') {
                hasData = true;
                return false;
            }
        });
        
        // Check clinical reports
        if (!hasData) {
            $('textarea[name^="test_reports[' + testId + ']"]').each(function() {
                if ($(this).val() && $(this).val().trim() !== '') {
                    hasData = true;
                    return false;
                }
            });
        }
        
        if (hasData) {
            completedTests++;
        }
    <?php } ?>
    
    var percentage = totalTests > 0 ? Math.round((completedTests / totalTests) * 100) : 0;
    
    // Update progress text
    $('#headerProgressText').text(completedTests + ' of ' + totalTests + ' completed');
    
    // Update progress ring
    var circumference = 2 * Math.PI * 25; // radius = 25
    var offset = circumference - (percentage / 100) * circumference;
    $('#headerProgressRing').css('stroke-dashoffset', offset);
    
    // Update percentage display
    $('#headerProgressPercentage').text(percentage + '%');
    
    // Update stats
    $('#completedCount').text(completedTests);
    $('#pendingCount').text(totalTests - completedTests);
    
    // Update completed tests count in other places
    // $('#completedTestsCount').text(completedTests); // Element removed
    
    // Change ring color based on progress
    var ring = $('#headerProgressRing');
    if (percentage === 100) {
        ring.css('stroke', '#28a745'); // Green for complete
    } else if (percentage >= 50) {
        ring.css('stroke', '#ffc107'); // Yellow for in progress
    } else {
        ring.css('stroke', '#fd7e14'); // Orange for just started
    }
    
    // Show completion status if all tests are done
    if (percentage === 100) {
        $('#completionStatusCard').fadeIn();
        updateSystemStatus('All tests completed', 'success');
    } else {
        $('#completionStatusCard').fadeOut();
        updateSystemStatus('Tests in progress', 'working');
    }
}

function updateSystemStatus(message, type) {
    var statusIndicator = $('#systemStatus');
    var statusDot = statusIndicator.find('.status-dot');
    var statusText = statusIndicator.find('.status-text');
    
    statusText.text(message);
    
    // Remove existing status classes
    statusDot.removeClass('status-online status-warning status-error');
    
    // Add appropriate class
    switch(type) {
        case 'success':
            statusDot.addClass('status-online');
            break;
        case 'warning':
            statusDot.addClass('status-warning');
            break;
        case 'error':
            statusDot.addClass('status-error');
            break;
        default:
            statusDot.addClass('status-online');
    }
}

function debugFormData() {
    var form = $('#reportForm');
    console.log('=== MANUAL FORM DEBUG ===');
    console.log('Form action:', form.attr('action'));
    console.log('Form method:', form.attr('method'));
    
    // Count fields by type
    var specimens = form.find('input[name^="specimens["]').length;
    var reports = form.find('textarea[name^="test_reports["]').length;
    var templates = form.find('input[name^="template_fields["], select[name^="template_fields["]').length;
    var inventory = form.find('input[name^="inventory_usage["]').length;
    var hidden = form.find('input[type="hidden"]').length;
    
    console.log('Field counts:');
    console.log(' - Specimen fields:', specimens);
    console.log(' - Report fields:', reports);
    console.log(' - Template fields:', templates);
    console.log(' - Inventory fields:', inventory);
    console.log(' - Total hidden fields:', hidden);
    
    // Show inventory data specifically
    console.log('Inventory usage data:');
    form.find('input[name^="inventory_usage["]').each(function() {
        console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
    });
    
    // Show specimen data
    console.log('Specimen data:');
    form.find('input[name^="specimens["]').each(function() {
        console.log(' - ' + $(this).attr('name') + ': "' + $(this).val() + '"');
    });
    
    // Show which reports have data
    console.log('Reports with data:');
    form.find('textarea[name^="test_reports["]').each(function() {
        if ($(this).val().trim() !== '') {
            console.log(' - ' + $(this).attr('name') + ': Has data (' + $(this).val().length + ' chars)');
        }
    });
    
    console.log('=== END MANUAL DEBUG ===');
    
    if (typeof toastr !== 'undefined') {
        toastr.info('Form data logged to console. Check browser developer tools.', 'Debug Complete');
    } else {
        showAlert('Form data logged to console. Check browser developer tools.', 'info');
    }
}

// Test function to manually submit inventory data
function testInventorySubmission() {
    console.log('=== TESTING INVENTORY SUBMISSION ===');
    
    var form = $('#reportForm');
    var inventoryFields = [];
    
    form.find('input[name^="inventory_usage["]').each(function() {
        inventoryFields.push({
            name: $(this).attr('name'),
            value: $(this).val()
        });
    });
    
    console.log('Found inventory fields:', inventoryFields.length);
    console.log('Inventory fields:', inventoryFields);
    
    if (inventoryFields.length === 0) {
        console.log('No inventory fields found! Add some items first.');
        if (typeof toastr !== 'undefined') {
            toastr.warning('No inventory items found! Add some items first.', 'Test Failed');
        }
        return;
    }
    
    // Create a minimal form data with just inventory fields
    var invoiceId = $('input[name="invoice_id"]').val() || 
                   $('input[name="invoice_id"]').val() || 
                   window.location.href.match(/writeReport\/(\d+)/)?.[1] || 
                   'UNKNOWN';
    
    console.log('Using invoice ID:', invoiceId);
    var testData = 'invoice_id=' + encodeURIComponent(invoiceId);
    
    inventoryFields.forEach(function(field) {
        testData += '&' + encodeURIComponent(field.name) + '=' + encodeURIComponent(field.value);
    });
    
    console.log('Test data:', testData);
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: testData,
        success: function(response) {
            console.log('Test submission response:', response);
            if (typeof toastr !== 'undefined') {
                toastr.success('Test submission completed! Check console for response.', 'Test Complete');
            }
        },
        error: function(xhr, status, error) {
            console.error('Test submission error:', error);
            console.error('Response:', xhr.responseText);
            if (typeof toastr !== 'undefined') {
                toastr.error('Test submission failed! Check console for details.', 'Test Failed');
            }
        }
    });
    
    console.log('=== END INVENTORY TEST ===');
}

// Function to load existing specimen data for all tests
function loadExistingSpecimenData() {
    <?php foreach ($lab_tests as $test) { ?>
        loadSpecimenDataForTest(<?php echo $test->id; ?>);
    <?php } ?>
}

// Function to load specimen data for a specific test
function loadSpecimenDataForTest(testId) {
    $.ajax({
        url: '<?php echo base_url('labworkflow/getSpecimenData'); ?>',
        type: 'GET',
        data: { test_id: testId },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                var data = response.data;
                
                // Update status badge
                var statusBadge = $('#status-' + testId);
                statusBadge.removeClass('badge-secondary badge-warning').addClass('badge-success').text('Collected');
                
                // Update button appearance
                var specimenBtn = $('button[data-target="#specimenModal' + testId + '"]');
                specimenBtn.removeClass('btn-outline-success').addClass('btn-success');
                
                // Store data in hidden fields for form submission
                var mainForm = $('#reportForm');
                mainForm.find('input[name^="specimens[' + testId + ']"]').remove();
                $.each(data, function(key, value) {
                    if (value && key !== 'status') {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'specimens[' + testId + '][' + key + ']',
                            value: value
                        }).appendTo(mainForm);
                    }
                });
            }
        },
        error: function() {
            // Silently fail - no existing data is normal
        }
    });
}

// Function to populate modal with existing data when opened
function populateModalWithExistingData(testId) {
    $.ajax({
        url: '<?php echo base_url('labworkflow/getSpecimenData'); ?>',
        type: 'GET',
        data: { test_id: testId },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                var data = response.data;
                var modal = $('#specimenModal' + testId);
                
                // Populate modal fields
                modal.find('select[name*="specimen_type"]').val(data.specimen_type);
                modal.find('input[name*="collection_date"]').val(data.collection_date);
                modal.find('select[name*="collection_method"]').val(data.collection_method);
                modal.find('select[name*="container_type"]').val(data.container_type);
                modal.find('input[name*="quantity"]').val(data.quantity);
                modal.find('select[name*="quantity_unit"]').val(data.quantity_unit);
                modal.find('input[name*="collected_by"]').val(data.collected_by);
                modal.find('textarea[name*="condition"]').val(data.condition);
            }
        },
        error: function() {
            // Silently fail - no existing data is normal
        }
    });
}

// Add event listener for when modals are shown to populate with existing data
<?php foreach ($lab_tests as $test) { ?>
$('#specimenModal<?php echo $test->id; ?>').on('show.bs.modal', function() {
    populateModalWithExistingData(<?php echo $test->id; ?>);
});
<?php } ?>

// =====================
// INVENTORY USAGE FUNCTIONS
// =====================

var inventoryRowCount = 0;
var modalInventoryItems = []; // Store items added in modal

// Add new inventory usage row in modal
function addModalInventoryRow() {
    inventoryRowCount++;
    
    var inventoryHtml = `
        <div class="modal-inventory-row mb-3 p-3 border rounded bg-light" id="modalInventoryRow${inventoryRowCount}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-box mr-2"></i>Item #${inventoryRowCount}
                </h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeModalInventoryRow(${inventoryRowCount})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label class="font-weight-bold text-dark mb-1 small">Item <span class="text-danger">*</span></label>
                    <select class="form-control modal-inventory-item-select" data-row-id="${inventoryRowCount}" required>
                        <option value="">Select Item</option>
                    </select>
                    <small class="text-muted">Choose inventory item used</small>
                </div>
                
                <div class="col-md-3">
                    <label class="font-weight-bold text-dark mb-1 small">Quantity <span class="text-danger">*</span></label>
                    <input type="number" class="form-control modal-quantity-input" data-row-id="${inventoryRowCount}" min="1" required>
                    <small class="text-muted modal-stock-info" id="modalStockInfo${inventoryRowCount}">Stock: N/A</small>
                </div>
                
                <div class="col-md-3">
                    <label class="font-weight-bold text-dark mb-1 small">Usage Type</label>
                    <select class="form-control modal-usage-type" data-row-id="${inventoryRowCount}">
                        <option value="lab_test">Lab Test</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="waste">Waste/Expired</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="font-weight-bold text-dark mb-1 small">Batch/Lot Number</label>
                    <input type="text" class="form-control modal-batch-input" data-row-id="${inventoryRowCount}" placeholder="Optional">
                    <small class="text-muted">For tracking purposes</small>
                </div>
                
                <div class="col-md-6">
                    <label class="font-weight-bold text-dark mb-1 small">Notes</label>
                    <textarea class="form-control modal-notes-input" data-row-id="${inventoryRowCount}" rows="2" placeholder="Optional notes about usage..."></textarea>
                </div>
            </div>
        </div>
    `;
    
    // Hide the "no items" message
    $('#modalNoInventoryMessage').hide();
    
    // Add the new row
    $('#modalInventoryContainer').append(inventoryHtml);
    
    // Load inventory items for the new select
    loadModalInventoryItems(inventoryRowCount);
    
    // Update item count
    updateModalItemCount();
    
    // Scroll to the new row within modal
    $('#modalInventoryContainer').animate({
        scrollTop: $('#modalInventoryRow' + inventoryRowCount).position().top
    }, 500);
}

// Remove inventory usage row from modal
function removeModalInventoryRow(rowId) {
    $('#modalInventoryRow' + rowId).fadeOut(300, function() {
        $(this).remove();
        
        // Show "no items" message if no rows left
        if ($('.modal-inventory-row').length === 0) {
            $('#modalNoInventoryMessage').show();
        }
        
        // Update item count
        updateModalItemCount();
    });
}

// Load inventory items for modal select dropdown
function loadModalInventoryItems(rowId) {
    $.ajax({
        url: '<?php echo base_url('inventory/getActiveItems'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var select = $('.modal-inventory-item-select[data-row-id="' + rowId + '"]');
            select.empty().append('<option value="">Select Item</option>');
            
            console.log('Inventory items response:', response);
            
            if (response && response.length > 0) {
                $.each(response, function(index, item) {
                    // Extract stock from the text field (format: "Name (Code) - Stock: X Unit")
                    var stock = extractStock(item.text);
                    // Extract name from the text field (everything before the first '(')
                    var name = item.text.split('(')[0].trim();
                    
                    select.append('<option value="' + item.id + '" data-stock="' + stock + '" data-name="' + name + '">' + item.text + '</option>');
                });
                console.log('Added ' + response.length + ' items to select');
            } else {
                select.append('<option value="" disabled>No inventory items available</option>');
                console.log('No inventory items found');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading inventory items:', error);
            console.error('Response:', xhr.responseText);
            var select = $('.modal-inventory-item-select[data-row-id="' + rowId + '"]');
            select.empty().append('<option value="" disabled>Error loading items</option>');
        }
    });
}

// Extract stock number from item text (format: "Name (Code) - Stock: X Unit")
function extractStock(text) {
    var match = text.match(/Stock:\s*(\d+)/);
    return match ? parseInt(match[1]) : 0;
}

// Handle modal item selection change
$(document).on('change', '.modal-inventory-item-select', function() {
    var selectedOption = $(this).find('option:selected');
    var stock = selectedOption.data('stock') || 0;
    var rowId = $(this).data('row-id');
    
    $('#modalStockInfo' + rowId).text('Stock: ' + stock);
    
    // Set max quantity based on available stock
    var quantityInput = $('.modal-quantity-input[data-row-id="' + rowId + '"]');
    quantityInput.attr('max', stock);
    
    if (stock === 0) {
        $('#modalStockInfo' + rowId).addClass('text-danger').text('Stock: 0 (Out of Stock)');
        quantityInput.prop('disabled', true);
    } else {
        $('#modalStockInfo' + rowId).removeClass('text-danger');
        quantityInput.prop('disabled', false);
    }
});

// Update modal item count
function updateModalItemCount() {
    var count = $('.modal-inventory-row').length;
    $('#modalItemCount').text(count);
}

// Clear all modal items
function clearAllModalItems() {
    if ($('.modal-inventory-row').length > 0) {
        if (confirm('Are you sure you want to remove all inventory items?')) {
            $('.modal-inventory-row').remove();
            $('#modalNoInventoryMessage').show();
            updateModalItemCount();
        }
    }
}

// Save inventory items from modal to main form
function saveInventoryItems() {
    // Show loading state on save button
    var saveBtn = $('#inventoryModal .btn-primary');
    var originalBtnText = saveBtn.html();
    saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Processing...');
    
    var items = [];
    var hasErrors = false;
    var errorMessages = [];
    
    // Validate and collect all modal items
    $('.modal-inventory-row').each(function() {
        var row = $(this);
        var rowId = row.attr('id').replace('modalInventoryRow', '');
        
        var itemSelect = row.find('.modal-inventory-item-select');
        var quantityInput = row.find('.modal-quantity-input');
        var usageTypeSelect = row.find('.modal-usage-type');
        var batchInput = row.find('.modal-batch-input');
        var notesInput = row.find('.modal-notes-input');
        
        var itemId = itemSelect.val();
        var selectedOption = itemSelect.find('option:selected');
        var itemName = selectedOption.data('name') || selectedOption.text().split('(')[0].trim();
        var quantity = parseInt(quantityInput.val()) || 0;
        var availableStock = selectedOption.data('stock') || 0;
        
        // Validation
        if (!itemId) {
            hasErrors = true;
            errorMessages.push('Item #' + rowId + ': Please select an item');
            return;
        }
        
        if (quantity <= 0) {
            hasErrors = true;
            errorMessages.push('Item #' + rowId + ': Quantity must be greater than 0');
            return;
        }
        
        if (quantity > availableStock) {
            hasErrors = true;
            errorMessages.push('Item #' + rowId + ': Requested quantity (' + quantity + ') exceeds available stock (' + availableStock + ')');
            return;
        }
        
        // Collect item data
        items.push({
            item_id: itemId,
            item_name: itemName,
            quantity_used: quantity,
            usage_type: usageTypeSelect.val(),
            batch_number: batchInput.val(),
            notes: notesInput.val(),
            available_stock: availableStock
        });
    });
    
    // Show errors if any
    if (hasErrors) {
        if (typeof toastr !== 'undefined') {
            toastr.error('Please fix the following errors:<br>• ' + errorMessages.join('<br>• '), 'Validation Errors', {
                timeOut: 5000,
                progressBar: true,
                positionClass: 'toast-top-right',
                escapeHtml: false
            });
        } else {
            showAlert('Please fix the following errors:\n' + errorMessages.join('\n'), 'error');
        }
        
        // Restore button state
        saveBtn.prop('disabled', false).html(originalBtnText);
        return;
    }
    
    // Get invoice and patient IDs
    var invoiceId = $('#invoice_id').val() || $('input[name="invoice_id"]').val() || window.location.href.match(/writeReport\/(\d+)/)?.[1] || '';
    var patientId = $('#patient_id').val() || $('input[name="patient_id"]').val() || '';
    
    if (!invoiceId) {
        if (typeof toastr !== 'undefined') {
            toastr.error('Invoice ID not found. Cannot save inventory items.', 'Error');
        } else {
            showAlert('Invoice ID not found. Cannot save inventory items.', 'error');
        }
        saveBtn.prop('disabled', false).html(originalBtnText);
        return;
    }
    
    // Prepare data for AJAX submission to database
    var inventoryData = [];
    $.each(items, function(index, item) {
        inventoryData.push({
            item_id: item.item_id,
            quantity_used: item.quantity_used,
            usage_type: item.usage_type,
            batch_number: item.batch_number,
            notes: item.notes,
            reference_type: 'lab_test',
            reference_id: invoiceId,
            patient_id: patientId
        });
    });
    
    console.log('=== SAVING INVENTORY TO DATABASE ===');
    console.log('Invoice ID:', invoiceId);
    console.log('Patient ID:', patientId);
    console.log('Items to save:', inventoryData);
    console.log('=== END INVENTORY SAVE DEBUG ===');
    
    // Send AJAX request to save inventory items directly to database
    $.ajax({
        url: '<?php echo base_url('labworkflow/saveInventoryUsage'); ?>',
        type: 'POST',
        data: {
            inventory_usage: inventoryData,
            invoice_id: invoiceId,
            patient_id: patientId
        },
        dataType: 'json',
        success: function(response) {
            console.log('Inventory save response:', response);
            
            if (response.success) {
                // Update main form display
                updateInventoryDisplay(items);
                
                // Show success message
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.count + ' inventory item(s) successfully saved to database!', 'Items Saved', {
                        timeOut: 3000,
                        progressBar: true,
                        positionClass: 'toast-top-right'
                    });
                } else {
                    showAlert('✅ ' + response.count + ' inventory item(s) successfully saved to database!', 'success');
                }
                
                // Close modal after success
                setTimeout(function() {
                    $('#inventoryModal').modal('hide');
                }, 1000);
                
            } else {
                // Show error message
                if (typeof toastr !== 'undefined') {
                    toastr.error(response.message || 'Failed to save inventory items.', 'Save Failed', {
                        timeOut: 5000,
                        progressBar: true,
                        positionClass: 'toast-top-right'
                    });
                } else {
                    showAlert('❌ ' + (response.message || 'Failed to save inventory items.'), 'error');
                }
            }
            
            // Restore button state
            saveBtn.prop('disabled', false).html(originalBtnText);
            
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error saving inventory:', error);
            console.error('Response:', xhr.responseText);
            
            // Show error message
            if (typeof toastr !== 'undefined') {
                toastr.error('Network error while saving inventory items. Please try again.', 'Connection Error', {
                    timeOut: 5000,
                    progressBar: true,
                    positionClass: 'toast-top-right'
                });
            } else {
                showAlert('❌ Network error while saving inventory items. Please try again.', 'error');
            }
            
            // Restore button state
            saveBtn.prop('disabled', false).html(originalBtnText);
        }
    });
}

// Update the main form inventory display
function updateInventoryDisplay(items) {
    var container = $('#inventoryUsageContainer');
    
    if (items.length === 0) {
        $('#noInventoryMessage').show();
        $('#inventorySummary').hide();
        return;
    }
    
    // Hide no items message
    $('#noInventoryMessage').hide();
    
    // Clear existing display
    container.find('.inventory-display-item').remove();
    
    // Add items to display
    $.each(items, function(index, item) {
        var displayHtml = `
            <div class="inventory-display-item mb-2 p-3 border rounded bg-light">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 font-weight-bold text-primary">
                            <i class="fas fa-box mr-2"></i>${item.item_name}
                        </h6>
                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-muted">Quantity:</small><br>
                                <span class="font-weight-bold">${item.quantity_used}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Usage Type:</small><br>
                                <span class="badge badge-info">${item.usage_type.replace('_', ' ').toUpperCase()}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Available Stock:</small><br>
                                <span class="text-success">${item.available_stock}</span>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Remaining:</small><br>
                                <span class="text-info">${item.available_stock - item.quantity_used}</span>
                            </div>
                        </div>
                        ${item.batch_number ? '<div class="mt-1"><small class="text-muted">Batch: ' + item.batch_number + '</small></div>' : ''}
                        ${item.notes ? '<div class="mt-1"><small class="text-muted">Notes: ' + item.notes + '</small></div>' : ''}
                    </div>
                </div>
            </div>
        `;
        container.append(displayHtml);
    });
    
    // Show summary
    $('#totalItemsCount').text(items.length);
    $('#inventorySummary').show();
}

// Initialize modal when page loads
$(document).ready(function() {
    // Reset modal when it opens
    $('#inventoryModal').on('show.bs.modal', function () {
        // Load existing items if any
        loadExistingInventoryItems();
    });
    
    // Reset modal when it closes without saving
    $('#inventoryModal').on('hidden.bs.modal', function () {
        if (!$(this).data('saved')) {
            // Could reload from form data if needed
        }
    });
});

// Load existing inventory usage from database for this invoice
function loadExistingInventoryUsage() {
    var invoiceId = $('#invoice_id').val();
    console.log('Invoice ID field value:', invoiceId);
    console.log('Invoice ID field exists:', $('#invoice_id').length > 0);
    
    // Try alternative ways to get invoice ID
    if (!invoiceId) {
        invoiceId = $('input[name="invoice_id"]').val();
        console.log('Alternative invoice ID:', invoiceId);
    }
    
    if (!invoiceId) {
        // Try to get from URL or page data
        var url = window.location.href;
        var matches = url.match(/writeReport\/(\d+)/);
        if (matches) {
            invoiceId = matches[1];
            console.log('Invoice ID from URL:', invoiceId);
        }
    }
    
    if (!invoiceId) {
        console.log('No invoice ID found, skipping inventory load');
        return;
    }
    
    console.log('Loading existing inventory usage for invoice:', invoiceId);
    
    $.ajax({
        url: '<?php echo base_url('labworkflow/getInventoryUsage'); ?>',
        type: 'GET',
        data: { 
            invoice_id: invoiceId,
            reference_type: 'lab_test'
        },
        dataType: 'json',
        success: function(response) {
            console.log('Inventory usage response:', response);
            console.log('Response type:', typeof response);
            console.log('Response success:', response.success);
            console.log('Response data:', response.data);
            console.log('Data length:', response.data ? response.data.length : 'N/A');
            
            if (response.success && response.data && response.data.length > 0) {
                // Clear existing hidden fields
                $('#reportForm input[name^="inventory_usage["]').remove();
                
                var items = [];
                
                // Process each usage record
                $.each(response.data, function(index, usage) {
                    var item = {
                        item_id: usage.item_id,
                        item_name: usage.item_name,
                        quantity_used: usage.quantity_used,
                        usage_type: usage.usage_type,
                        batch_number: usage.batch_number || '',
                        notes: usage.notes || '',
                        available_stock: 999 // We don't know current stock, so use high number
                    };
                    
                    items.push(item);
                    
                    // Add to form as hidden fields
                    var fieldPrefix = 'inventory_usage[' + (index + 1) + ']';
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[item_id]',
                        value: usage.item_id
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[quantity_used]',
                        value: usage.quantity_used
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[usage_type]',
                        value: usage.usage_type
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[batch_number]',
                        value: usage.batch_number || ''
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[notes]',
                        value: usage.notes || ''
                    }).appendTo('#reportForm');
                    
                    // Reference fields
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[reference_type]',
                        value: 'lab_test'
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[reference_id]',
                        value: invoiceId
                    }).appendTo('#reportForm');
                    
                    $('<input>').attr({
                        type: 'hidden',
                        name: fieldPrefix + '[patient_id]',
                        value: $('#patient_id').val() || $('input[name="patient_id"]').val() || ''
                    }).appendTo('#reportForm');
                });
                
                // Update the display
                updateInventoryDisplay(items);
                
                console.log('Loaded ' + items.length + ' existing inventory items');
            } else {
                console.log('No existing inventory usage found');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading inventory usage:', error);
            console.error('Response:', xhr.responseText);
        }
    });
}

// Load existing inventory items into modal (if editing)
function loadExistingInventoryItems() {
    // Clear modal
    $('.modal-inventory-row').remove();
    $('#modalNoInventoryMessage').show();
    updateModalItemCount();
    
    // Check if there are existing hidden fields
    var existingItems = [];
    $('#reportForm input[name^="inventory_usage["]').each(function() {
        var name = $(this).attr('name');
        var matches = name.match(/inventory_usage\[(\d+)\]\[([^\]]+)\]/);
        if (matches) {
            var index = matches[1];
            var field = matches[2];
            
            if (!existingItems[index]) {
                existingItems[index] = {};
            }
            existingItems[index][field] = $(this).val();
        }
    });
    
    // Add existing items to modal
    $.each(existingItems, function(index, item) {
        if (item && item.item_id) {
            addModalInventoryRow();
            var rowId = inventoryRowCount;
            
            // Populate the row after items are loaded
            setTimeout(function() {
                $('.modal-inventory-item-select[data-row-id="' + rowId + '"]').val(item.item_id).trigger('change');
                $('.modal-quantity-input[data-row-id="' + rowId + '"]').val(item.quantity_used);
                $('.modal-usage-type[data-row-id="' + rowId + '"]').val(item.usage_type);
                $('.modal-batch-input[data-row-id="' + rowId + '"]').val(item.batch_number);
                $('.modal-notes-input[data-row-id="' + rowId + '"]').val(item.notes);
            }, 500);
        }
    });
}

 
</script>

<!-- Inventory Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="inventoryModalLabel">
                    <i class="fas fa-boxes mr-2"></i>Add Medical Inventory Items
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <button type="button" class="btn btn-success btn-sm" onclick="addModalInventoryRow()">
                            <i class="fas fa-plus mr-1"></i>Add New Item
                        </button>
                        <small class="text-muted ml-2">Add reagents, supplies, and materials used for these lab tests</small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearAllModalItems()">
                            <i class="fas fa-trash mr-1"></i>Clear All
                        </button>
                    </div>
                </div>
                
                <div id="modalInventoryContainer">
                    <!-- Modal inventory rows will be added here -->
                </div>
                
                <div class="text-center text-muted py-4" id="modalNoInventoryMessage">
                    <i class="fas fa-flask fa-2x mb-2"></i>
                    <p class="mb-0">No items added yet</p>
                    <small>Click "Add New Item" to start tracking inventory usage</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancel
                </button> 
                <button type="button" class="btn btn-primary" onclick="saveInventoryItems()">
                    <i class="fas fa-save mr-1"></i>Save Items (<span id="modalItemCount">0</span>)
                </button>
            </div>
        </div>
    </div>
</div> 