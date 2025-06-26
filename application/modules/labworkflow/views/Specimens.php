<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header"> 
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Lab Specimens</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lab Workflow</a></li>
                            <li class="breadcrumb-item active">Specimens</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Manage Specimens</h5>
                        <a href="<?php echo base_url('labworkflow/addSpecimen'); ?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Collect Specimen
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="specimens-table">
                                <thead>
                                    <tr>
                                        <th>Specimen ID</th>
                                        <th>Patient</th>
                                        <th>Specimen Type</th>
                                        <th>Collection Date</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($specimens)) : ?>
                                        <?php foreach ($specimens as $specimen) : ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo $specimen->specimen_id; ?></strong>
                                                </td>
                                                <td>
                                                    <?php echo $specimen->patient_name; ?><br>
                                                    <small class="text-muted">ID: <?php echo $specimen->patient_id; ?></small>
                                                </td>
                                                <td><?php echo $specimen->specimen_type_name; ?></td>
                                                <td>
                                                    <?php echo date('d/m/Y H:i', strtotime($specimen->collection_date)); ?><br>
                                                    <small class="text-muted">by User ID: <?php echo $specimen->collected_by; ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge <?php 
                                                        switch($specimen->condition_on_receipt) {
                                                            case 'good': echo 'badge-success'; break;
                                                            case 'hemolyzed': echo 'badge-warning'; break;
                                                            case 'clotted': echo 'badge-warning'; break;
                                                            case 'insufficient': echo 'badge-danger'; break;
                                                            case 'contaminated': echo 'badge-danger'; break;
                                                            default: echo 'badge-secondary';
                                                        }
                                                    ?>">
                                                        <?php echo ucfirst($specimen->condition_on_receipt); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?php 
                                                        switch($specimen->status) {
                                                            case 'collected': echo 'badge-info'; break;
                                                            case 'received': echo 'badge-primary'; break;
                                                            case 'processing': echo 'badge-warning'; break;
                                                            case 'completed': echo 'badge-success'; break;
                                                            case 'rejected': echo 'badge-danger'; break;
                                                            default: echo 'badge-secondary';
                                                        }
                                                    ?>">
                                                        <?php echo ucfirst($specimen->status); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <?php if ($specimen->status == 'collected') : ?>
                                                            <a href="<?php echo base_url('labworkflow/receiveSpecimen/'.$specimen->id); ?>" 
                                                               class="btn btn-success btn-sm" title="Receive Specimen">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <a href="<?php echo base_url('labworkflow/addLabTest?specimen_id='.$specimen->id); ?>" 
                                                           class="btn btn-primary btn-sm" title="Order Test">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        
                                                        <button class="btn btn-info btn-sm" title="View Details" 
                                                                onclick="viewSpecimenDetails(<?php echo $specimen->id; ?>)">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No specimens found.</td>
                                        </tr>
                                    <?php endif; ?>
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

<!-- Specimen Details Modal -->
<div class="modal fade" id="specimenModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Specimen Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="specimenModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#specimens-table').DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: [
            {extend: 'copy', className: 'btn-sm'},
            {extend: 'csv', title: 'Lab Specimens', className: 'btn-sm'},
            {extend: 'excel', title: 'Lab Specimens', className: 'btn-sm'},
            {extend: 'pdf', title: 'Lab Specimens', className: 'btn-sm'},
            {extend: 'print', className: 'btn-sm'}
        ],
        "order": [[ 3, "desc" ]],
        "columnDefs": [
            { "targets": [6], "orderable": false }
        ]
    });
});

function viewSpecimenDetails(specimenId) {
    $.ajax({
        url: '<?php echo base_url('labworkflow/getSpecimenDetails/'); ?>' + specimenId,
        type: 'GET',
        success: function(response) {
            $('#specimenModalBody').html(response);
            $('#specimenModal').modal('show');
        },
        error: function() {
            alert('Error loading specimen details');
        }
    });
}
</script> 