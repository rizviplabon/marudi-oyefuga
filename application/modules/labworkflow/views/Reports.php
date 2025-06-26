<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo $page_title; ?></h4>
                    <div class="page-title-right"> 
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lab Workflow</a></li>
                            <li class="breadcrumb-item active"><?php echo $page; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Lab Workflow Reports</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="specimen-tab" data-toggle="tab" href="#specimen" role="tab" aria-controls="specimen" aria-selected="true">Specimen Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template" aria-selected="false">Template Usage</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="turnaround-tab" data-toggle="tab" href="#turnaround" role="tab" aria-controls="turnaround" aria-selected="false">Turnaround Time</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="qc-tab" data-toggle="tab" href="#qc" role="tab" aria-controls="qc" aria-selected="false">QC Summary</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="reportTabsContent">
                            <!-- Specimen Report Tab -->
                            <div class="tab-pane fade show active" id="specimen" role="tabpanel" aria-labelledby="specimen-tab">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <form method="get" action="labworkflow/reports" class="form-inline">
                                            <div class="form-group mr-2">
                                                <label for="from_date" class="mr-2">From:</label>
                                                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                            <div class="form-group mr-2">
                                                <label for="to_date" class="mr-2">To:</label>
                                                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                            <div class="form-group mr-2">
                                                <label for="specimen_type" class="mr-2">Specimen Type:</label>
                                                <select name="specimen_type" class="form-control">
                                                    <option value="">All Types</option>
                                                    <?php foreach ($specimen_types as $type) { ?>
                                                        <option value="<?php echo $type->id; ?>" <?php echo ($this->input->get('specimen_type') == $type->id) ? 'selected' : ''; ?>>
                                                            <?php echo $type->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="button" class="btn btn-success" id="exportSpecimenReport">
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="specimen-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Specimen ID</th>
                                                <th>Patient</th>
                                                <th>Type</th>
                                                <th>Collection Date</th>
                                                <th>Collection Method</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($specimen_report as $specimen) { ?>
                                                <tr>
                                                    <td><?php echo $specimen->specimen_id; ?></td>
                                                    <td><?php echo $specimen->patient_name; ?></td>
                                                    <td><?php echo $specimen->specimen_type_name; ?></td>
                                                    <td><?php echo date('Y-m-d H:i', strtotime($specimen->collection_date)); ?></td>
                                                    <td><?php echo $specimen->collection_method ?: 'Standard'; ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php 
                                                            echo $specimen->status == 'completed' ? 'success' : 
                                                                ($specimen->status == 'processing' ? 'warning' : 'info'); 
                                                        ?>">
                                                            <?php echo ucfirst($specimen->status); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Template Usage Report Tab -->
                            <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <form method="get" action="labworkflow/reports" class="form-inline">
                                            <div class="form-group mr-2">
                                                <label for="from_date" class="mr-2">From:</label>
                                                <input type="date" name="from_date" id="template_from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                            <div class="form-group mr-2">
                                                <label for="to_date" class="mr-2">To:</label>
                                                <input type="date" name="to_date" id="template_to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="button" class="btn btn-success" id="exportTemplateReport">
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="template-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Template Name</th>
                                                <th>Usage Count</th>
                                                <th>Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($test_template_usage as $usage) { ?>
                                                <tr>
                                                    <td><?php echo $usage->template_name; ?></td>
                                                    <td><?php echo $usage->usage_count; ?></td>
                                                    <td><?php echo number_format($usage->total_revenue, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Turnaround Time Report Tab -->
                            <div class="tab-pane fade" id="turnaround" role="tabpanel" aria-labelledby="turnaround-tab">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <form method="get" action="labworkflow/reports" class="form-inline">
                                            <div class="form-group mr-2">
                                                <label for="from_date" class="mr-2">From:</label>
                                                <input type="date" name="from_date" id="turnaround_from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                            <div class="form-group mr-2">
                                                <label for="to_date" class="mr-2">To:</label>
                                                <input type="date" name="to_date" id="turnaround_to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="button" class="btn btn-success" id="exportTurnaroundReport">
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="turnaround-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Expected TAT (hrs)</th>
                                                <th>Actual TAT (hrs)</th>
                                                <th>Difference</th>
                                                <th>Collection Date</th>
                                                <th>Verification Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($turnaround_time_report as $report) { ?>
                                                <tr>
                                                    <td><?php echo $report->template_name; ?></td>
                                                    <td><?php echo $report->expected_tat ?: 'N/A'; ?></td>
                                                    <td><?php echo $report->actual_tat; ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($report->expected_tat) {
                                                            $diff = $report->actual_tat - $report->expected_tat;
                                                            if ($diff > 0) {
                                                                echo '<span class="text-danger">+' . $diff . ' hrs</span>';
                                                            } else {
                                                                echo '<span class="text-success">' . $diff . ' hrs</span>';
                                                            }
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('Y-m-d H:i', strtotime($report->collection_date)); ?></td>
                                                    <td><?php echo date('Y-m-d H:i', strtotime($report->verification_date)); ?></td>
                                                    <td>
                                                        <?php if ($report->expected_tat && $report->actual_tat > $report->expected_tat) { ?>
                                                            <span class="badge badge-danger">Delayed</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-success">On Time</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- QC Summary Tab -->
                            <div class="tab-pane fade" id="qc" role="tabpanel" aria-labelledby="qc-tab">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <form method="get" action="labworkflow/reports" class="form-inline">
                                            <div class="form-group mr-2">
                                                <label for="from_date" class="mr-2">From:</label>
                                                <input type="date" name="from_date" id="qc_from_date" class="form-control" value="<?php echo $this->input->get('from_date'); ?>">
                                            </div>
                                            <div class="form-group mr-2">
                                                <label for="to_date" class="mr-2">To:</label>
                                                <input type="date" name="to_date" id="qc_to_date" class="form-control" value="<?php echo $this->input->get('to_date'); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button type="button" class="btn btn-success" id="exportQCReport">
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h4 class="mb-0">
                                                    <?php 
                                                    $pass_count = 0;
                                                    foreach ($qc_summary as $qc) {
                                                        if ($qc->status == 'pass') {
                                                            $pass_count++;
                                                        }
                                                    }
                                                    echo $pass_count;
                                                    ?>
                                                </h4>
                                                <p class="mt-2 mb-0">Passed QC Tests</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <h4 class="mb-0">
                                                    <?php 
                                                    $fail_count = 0;
                                                    foreach ($qc_summary as $qc) {
                                                        if ($qc->status == 'fail') {
                                                            $fail_count++;
                                                        }
                                                    }
                                                    echo $fail_count;
                                                    ?>
                                                </h4>
                                                <p class="mt-2 mb-0">Failed QC Tests</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h4 class="mb-0">
                                                    <?php 
                                                    $warning_count = 0;
                                                    foreach ($qc_summary as $qc) {
                                                        if ($qc->status == 'warning') {
                                                            $warning_count++;
                                                        }
                                                    }
                                                    echo $warning_count;
                                                    ?>
                                                </h4>
                                                <p class="mt-2 mb-0">Warning QC Tests</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="qc-summary-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Control Type</th>
                                                <th>Expected Value</th>
                                                <th>Actual Value</th>
                                                <th>Control Date</th>
                                                <th>Performed By</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($qc_summary as $qc) { ?>
                                                <tr>
                                                    <td><?php echo $qc->template_name; ?></td>
                                                    <td><?php echo $qc->control_type; ?></td>
                                                    <td><?php echo $qc->expected_value; ?></td>
                                                    <td><?php echo $qc->actual_value; ?></td>
                                                    <td><?php echo date('Y-m-d', strtotime($qc->control_date)); ?></td>
                                                    <td><?php echo $qc->first_name . ' ' . $qc->last_name; ?></td>
                                                    <td>
                                                        <?php if ($qc->status == 'pass') { ?>
                                                            <span class="badge badge-success">Pass</span>
                                                        <?php } elseif ($qc->status == 'fail') { ?>
                                                            <span class="badge badge-danger">Fail</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-warning">Warning</span>
                                                        <?php } ?>
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
</div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#specimen-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Specimen Report', className: 'btn-sm'},
                {extend: 'excel', title: 'Specimen Report', className: 'btn-sm'},
                {extend: 'pdf', title: 'Specimen Report', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
        
        $('#template-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Template Usage Report', className: 'btn-sm'},
                {extend: 'excel', title: 'Template Usage Report', className: 'btn-sm'},
                {extend: 'pdf', title: 'Template Usage Report', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
        
        $('#turnaround-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Turnaround Time Report', className: 'btn-sm'},
                {extend: 'excel', title: 'Turnaround Time Report', className: 'btn-sm'},
                {extend: 'pdf', title: 'Turnaround Time Report', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
        
        $('#qc-summary-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'QC Summary Report', className: 'btn-sm'},
                {extend: 'excel', title: 'QC Summary Report', className: 'btn-sm'},
                {extend: 'pdf', title: 'QC Summary Report', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
        
        // Export buttons
        $('#exportSpecimenReport').click(function() {
            $('#specimen-table').DataTable().button('.buttons-excel').trigger();
        });
        
        $('#exportTemplateReport').click(function() {
            $('#template-table').DataTable().button('.buttons-excel').trigger();
        });
        
        $('#exportTurnaroundReport').click(function() {
            $('#turnaround-table').DataTable().button('.buttons-excel').trigger();
        });
        
        $('#exportQCReport').click(function() {
            $('#qc-summary-table').DataTable().button('.buttons-excel').trigger();
        });
    });
</script> 