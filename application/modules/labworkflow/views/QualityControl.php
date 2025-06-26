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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Quality Control Records</h5>
                        <a href="labworkflow/addQCRecord" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add QC Record</a>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error')) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>

                        <div class="table-responsive">
                            <table id="qc-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                        <th>Control Type</th>
                                        <th>Control Lot</th>
                                        <th>Expected Value</th>
                                        <th>Actual Value</th>
                                        <th>Acceptable Range</th>
                                        <th>Control Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($qc_records as $record) { ?>
                                        <tr>
                                            <td><?php echo $record->test_name; ?></td>
                                            <td><?php echo $record->control_type; ?></td>
                                            <td><?php echo $record->control_lot ?: 'N/A'; ?></td>
                                            <td><?php echo $record->expected_value; ?></td>
                                            <td><?php echo $record->actual_value; ?></td>
                                            <td><?php echo $record->acceptable_range ?: 'N/A'; ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($record->control_date)); ?></td>
                                            <td>
                                                <?php if ($record->status == 'pass') { ?>
                                                    <span class="badge badge-success">Pass</span>
                                                <?php } elseif ($record->status == 'fail') { ?>
                                                    <span class="badge badge-danger">Fail</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-warning">Warning</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="labworkflow/viewQCRecord/<?php echo $record->id; ?>" class="btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                    <a href="labworkflow/editQCRecord/<?php echo $record->id; ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="labworkflow/deleteQCRecord/<?php echo $record->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this QC record?');" title="Delete"><i class="fa fa-trash"></i></a>
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

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quality Control Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4 class="mb-0">
                                            <?php 
                                            $pass_count = 0;
                                            foreach ($qc_records as $record) {
                                                if ($record->status == 'pass') {
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
                                            foreach ($qc_records as $record) {
                                                if ($record->status == 'fail') {
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
                                            foreach ($qc_records as $record) {
                                                if ($record->status == 'warning') {
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#qc-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Quality Control Records', className: 'btn-sm'},
                {extend: 'excel', title: 'Quality Control Records', className: 'btn-sm'},
                {extend: 'pdf', title: 'Quality Control Records', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
    });
</script> 