<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Lab Workflow Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Lab Workflow</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="avatar">
                            <span class="avatar-title bg-soft-info rounded">
                                <i class="fa fa-vial text-info font-size-24"></i>
                            </span>
                        </div>
                        <p class="text-muted">Total Specimens</p>
                        <h5 class="mt-1"><?php echo count($specimens); ?></h5>
                        <div class="mt-3">
                            <a href="labworkflow/specimens" class="btn btn-info btn-sm">Manage Specimens</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fa fa-file-medical text-primary font-size-24"></i>
                            </span>
                        </div>
                        <p class="text-muted">Test Templates</p>
                        <h5 class="mt-1"><?php echo count($templates); ?></h5>
                        <div class="mt-3">
                            <a href="labworkflow/testTemplates" class="btn btn-primary btn-sm">Manage Templates</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="avatar">
                            <span class="avatar-title bg-soft-success rounded">
                                <i class="fa fa-flask text-success font-size-24"></i>
                            </span>
                        </div>
                        <p class="text-muted">Lab Tests</p>
                        <h5 class="mt-1">Available</h5>
                        <div class="mt-3">
                            <a href="labworkflow/labTests" class="btn btn-success btn-sm">Manage Tests</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="avatar">
                            <span class="avatar-title bg-soft-warning rounded">
                                <i class="fa fa-check-circle text-warning font-size-24"></i>
                            </span>
                        </div>
                        <p class="text-muted">Quality Control</p>
                        <h5 class="mt-1">Monitor</h5>
                        <div class="mt-3">
                            <a href="labworkflow/qualityControl" class="btn btn-warning btn-sm">View QC</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Quick Actions</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="labworkflow/addSpecimen" class="btn btn-primary btn-block">
                                    <i class="fa fa-plus"></i> Collect Specimen
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="labworkflow/addTestTemplate" class="btn btn-success btn-block">
                                    <i class="fa fa-file-medical"></i> Create Template
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="labworkflow/addLabTest" class="btn btn-info btn-block">
                                    <i class="fa fa-flask"></i> Order Lab Test
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="labworkflow/addQCRecord" class="btn btn-warning btn-block">
                                    <i class="fa fa-check"></i> Add QC Record
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Recent Specimens</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Specimen ID</th>
                                        <th>Patient</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $recent_specimens = array_slice($specimens, 0, 5);
                                    if(!empty($recent_specimens)):
                                        foreach($recent_specimens as $specimen): 
                                    ?>
                                        <tr>
                                            <td><?php echo $specimen->specimen_id; ?></td>
                                            <td><?php echo $specimen->patient_name; ?></td>
                                            <td><?php echo $specimen->specimen_type_name; ?></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $specimen->status == 'completed' ? 'success' : 
                                                        ($specimen->status == 'processing' ? 'warning' : 'info'); 
                                                ?>">
                                                    <?php echo ucfirst($specimen->status); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No specimens collected yet</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Lab Workflow Features</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fa fa-vial fa-3x text-info mb-3"></i>
                                    <h6>Specimen Management</h6>
                                    <p class="text-muted">Track specimens from collection to completion with unique IDs and status monitoring.</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fa fa-file-medical fa-3x text-primary mb-3"></i>
                                    <h6>Test Templates</h6>
                                    <p class="text-muted">Standardized test templates with normal ranges and methodology for consistent results.</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                                    <h6>Quality Control</h6>
                                    <p class="text-muted">Comprehensive quality control monitoring and reporting for lab accuracy.</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="labworkflow/reports" class="btn btn-outline-primary">View Detailed Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 