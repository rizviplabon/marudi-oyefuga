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
                        <h5 class="card-title mb-0">Lab Test Templates</h5>
                        <a href="labworkflow/addTestTemplate" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create Template</a>
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
                            <table id="templates-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Test Code</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Specimen Type</th>
                                        <th>Normal Range</th>
                                        <th>Units</th>
                                        <th>Cost</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($templates as $template) { ?>
                                        <tr>
                                            <td><?php echo $template->test_code; ?></td>
                                            <td><?php echo $template->name; ?></td>
                                            <td><?php echo $template->category_name; ?></td>
                                            <td><?php echo $template->specimen_type_name; ?></td>
                                            <td><?php echo $template->normal_range ?: 'N/A'; ?></td>
                                            <td><?php echo $template->units ?: 'N/A'; ?></td>
                                            <td><?php echo number_format($template->cost, 2); ?></td>
                                            <td>
                                                <?php if ($template->is_active) { ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="labworkflow/viewTestTemplate/<?php echo $template->id; ?>" class="btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                                    <a href="labworkflow/editTestTemplate/<?php echo $template->id; ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="labworkflow/deleteTestTemplate/<?php echo $template->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this template?');" title="Delete"><i class="fa fa-trash"></i></a>
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
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#templates-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Lab Test Templates', className: 'btn-sm'},
                {extend: 'excel', title: 'Lab Test Templates', className: 'btn-sm'},
                {extend: 'pdf', title: 'Lab Test Templates', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
    });
</script> 