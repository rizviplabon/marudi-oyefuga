<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laboratory Report - <?php echo $patient->name; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
         
        .patient-info {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .patient-info td {
            padding: 5px;
            border: none;
            vertical-align: top;
        }
        
        .patient-info .label {
            font-weight: bold;
            width: 120px;
            color: #495057;
        }
        
        .test-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .test-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .specimen-info {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #6c757d;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .results-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .results-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            font-size: 11px;
        }
        
        .status-normal { color: #28a745; font-weight: bold; }
        .status-abnormal { color: #ffc107; font-weight: bold; }
        .status-critical { color: #dc3545; font-weight: bold; }
        
        .report-text {
            background-color: #f8f9fa;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            margin-bottom: 10px;
            white-space: pre-wrap;
        }
        
        .section-title {
            font-weight: bold;
            color: #495057;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .no-data {
            color: #6c757d;
            font-style: italic;
            text-align: center;
            padding: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .signature-section {
            margin-top: 40px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        
        .signature-box {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            margin-right: 5%;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Patient Information Section -->
    <div class="patient-info">
        <table>
            <tr>
                <td class="label">Patient Name:</td>
                <td><?php echo $patient->name; ?></td>
                <td class="label">Patient ID:</td>
                <td><?php echo $patient->patient_id ?: 'P-' . $patient->id; ?></td>
            </tr>
            <tr>
                <td class="label">Age/Gender:</td>
                <td><?php 
                    $age_parts = explode('-', $patient->age);
                    if (count($age_parts) == 3) {
                        echo $age_parts[0] . 'Y ' . $age_parts[1] . 'M ' . $age_parts[2] . 'D';
                    } else {
                        echo $patient->age;
                    }
                    echo ' / ' . $patient->sex; 
                ?></td>
                <td class="label">Phone:</td>
                <td><?php echo $patient->phone; ?></td>
            </tr>
            <tr>
                <td class="label">Address:</td>
                <td colspan="3"><?php echo $patient->address; ?></td>
            </tr>
            <?php if ($doctor): ?>
            <tr>
                <td class="label">Referring Doctor:</td>
                <td><?php echo $doctor->name; ?></td>
                <td class="label">Specialization:</td>
                <td><?php echo $doctor->specialist; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="label">Invoice ID:</td>
                <td><?php echo $invoice_id; ?></td>
                <td class="label">Report Date:</td>
                <td><?php echo date('d-m-Y H:i', strtotime($generated_date)); ?></td>
            </tr>
        </table>
    </div>

    <!-- Test Results Sections -->
    <?php foreach ($lab_tests as $index => $test): ?>
        <?php if ($index > 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>
        
        <div class="test-section">
            <div class="test-header">
                <?php echo $test->category_name; ?> 
                <span style="float: right; font-size: 12px;">
                    Test #<?php echo sprintf('%02d', $index + 1); ?> | 
                    Status: <?php echo ucfirst($test->test_status ?: $test->status); ?>
                </span>
            </div>

            <!-- Specimen Information -->
            <?php if (!empty($test->specimen_info)): ?>
            <div class="specimen-info">
                <div class="section-title">Specimen Information</div>
                <table style="width: 100%; font-size: 11px;">
                    <tr>
                        <td><strong>Specimen ID:</strong> <?php echo $test->specimen_info->specimen_id; ?></td>
                        <td><strong>Collection Date:</strong> <?php echo date('d-m-Y H:i', strtotime($test->specimen_info->collection_date)); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Collection Method:</strong> <?php echo $test->specimen_info->collection_method ?: 'N/A'; ?></td>
                        <td><strong>Volume:</strong> <?php echo $test->specimen_info->volume_amount ?: 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Container:</strong> <?php echo $test->specimen_info->container_type ?: 'N/A'; ?></td>
                        <td><strong>Collected By:</strong> <?php echo $test->specimen_info->collected_by ?: 'N/A'; ?></td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>

            <!-- Template Results -->
            <?php if (!empty($test->template_results)): ?>
            <div class="section-title">Laboratory Parameters</div>
            <table class="results-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Parameter</th>
                        <th style="width: 20%;">Result</th>
                        <th style="width: 15%;">Units</th>
                        <th style="width: 25%;">Reference Range</th>
                        <th style="width: 10%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($test->template_results as $result): ?>
                    <tr>
                        <td><?php echo $result->parameter_name; ?></td>
                        <td><strong><?php echo $result->result_value; ?></strong></td>
                        <td><?php echo $result->units; ?></td>
                        <td><?php echo $result->reference_range; ?></td>
                        <td class="status-<?php echo $result->status; ?>">
                            <?php echo ucfirst($result->status); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Clinical Reports -->
            <?php if (!empty($test->report)): ?>
            <div class="section-title">Test Results & Findings</div>
            <div class="report-text"><?php echo nl2br($test->report); ?></div>
            <?php endif; ?>

            <?php if (!empty($test->interpretation)): ?>
            <div class="section-title">Clinical Interpretation</div>
            <div class="report-text"><?php echo nl2br($test->interpretation); ?></div>
            <?php endif; ?>

            <?php if (!empty($test->critical_values)): ?>
            <div class="section-title">Critical Values & Alerts</div>
            <div class="report-text" style="border-left: 4px solid #dc3545; background-color: #f8d7da;">
                <?php echo nl2br($test->critical_values); ?>
            </div>
            <?php endif; ?>

            <!-- Test completed information -->
            <?php if ($test->test_status == 'done' && $test->updated_on): ?>
            <div style="margin-top: 15px; padding: 8px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 3px; font-size: 11px;">
                <strong>Test Completed:</strong> <?php echo date('d-m-Y H:i', $test->updated_on); ?>
                <?php if ($test->reported_by): ?>
                    | <strong>Reported By:</strong> Lab Team Member ID: <?php echo $test->reported_by; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <!-- Summary Section -->
    <div style="margin-top: 30px; padding: 15px; background-color: #e9ecef; border-radius: 5px;">
        <div class="section-title">Report Summary</div>
        <table style="width: 100%; font-size: 11px;">
            <tr>
                <td><strong>Total Tests:</strong> <?php echo count($lab_tests); ?></td>
                <td><strong>Completed Tests:</strong> 
                    <?php 
                    $completed = 0;
                    foreach ($lab_tests as $test) {
                        if ($test->test_status == 'done') $completed++;
                    }
                    echo $completed;
                    ?>
                </td>
            </tr>
            <tr>
                <td><strong>Report Generated:</strong> <?php echo date('d-m-Y H:i', strtotime($generated_date)); ?></td>
                <td><strong>Generated By:</strong> <?php echo $generated_by; ?></td>
            </tr>
        </table>
    </div>

    <!-- Signatures Section -->
    <div class="signature-section">
        <table style="width: 100%; margin-top: 40px;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <div style="border-top: 1px solid #333; margin-top: 40px; padding-top: 5px; text-align: center;">
                        <div style="font-weight: bold;">Laboratory Technician</div>
                        <div style="margin-top: 5px;">Name: _______________________</div>
                        <div style="margin-top: 5px;">Date: _______________________</div>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
                    <div style="border-top: 1px solid #333; margin-top: 40px; padding-top: 5px; text-align: center;">
                        <div style="font-weight: bold;">Pathologist/Physician</div>
                        <div style="margin-top: 5px;">
                            <?php if ($doctor): ?>
                                Dr. <?php echo $doctor->name; ?>
                            <?php else: ?>
                                Name: _______________________
                            <?php endif; ?>
                        </div>
                        <div style="margin-top: 5px;">Date: _______________________</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer Note -->
    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #6c757d; border-top: 1px solid #dee2e6; padding-top: 15px;">
        <p><strong>Important Notes:</strong></p>
        <p>• This report is computer-generated and electronically validated</p>
        <p>• All results have been reviewed and approved by qualified laboratory personnel</p>
        <p>• For any queries regarding this report, please contact the laboratory at <?php echo $settings->phone; ?></p>
        <p>• Reference ranges may vary based on methodology and patient population</p>
    </div>
</body>
</html> 