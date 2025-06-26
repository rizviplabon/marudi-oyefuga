<link href="common/extranal/css/finance/payment_category.css" rel="stylesheet">
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12 content-header">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Payment Procedure Templates</h4>&nbsp;&nbsp; &nbsp;&nbsp;
                &nbsp;&nbsp;
                <?php if ($this->ion_auth->in_group('admin')) {
                    if ($this->settings->dashboard_theme == 'main') { ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                <?php }
                } ?>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                        <li class="breadcrumb-item">Finance</li>
                        <li class="breadcrumb-item active">Templates</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- page start-->
    <section class="card">
        <div class="card-header table_header">
            <h4 class="card-title mb-0 col-lg-8">Payment Procedure Templates</h4> 
            <div class="col-lg-4 no-print pull-right"> 
                <a href="finance/addTemplateView" class="btn btn-primary waves-effect waves-light w-xs" ><i class="fa fa-plus-circle"></i> Create Template</a>
            </div>
        </div>
      
        <div class="card-body">
            <div class="adv-table editable-table">
                <table class="table mb-0" id="template-table">
                    <thead>
                        <tr>
                            <th>Template Name</th>
                            <th>Procedure Type</th>
                            <th>Description</th>
                            <th>Fields Count</th>
                            <th>Created</th>
                            <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                <th class="no-print">Options</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($templates)) { ?>
                            <?php foreach ($templates as $template) { ?>
                                <tr>
                                    <td><?php echo $template->template_name; ?></td>
                                    <td>
                                        <?php if ($template->procedure_type == 'diagnostic_test') { ?>
                                            <span class="badge badge-primary">Diagnostic Test</span>
                                        <?php } else { ?>
                                            <span class="badge badge-secondary"><?php echo ucfirst($template->procedure_type); ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $template->description; ?></td>
                                    <td>
                                        <?php 
                                        $field_count = count($this->finance_model->getPaymentProcedureTemplateFields($template->id));
                                        echo $field_count . ' fields';
                                        ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($template->created_at)); ?></td>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-soft-primary btn-xs" title="Edit" href="finance/editTemplate?id=<?php echo $template->id; ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a class="btn btn-soft-danger btn-xs" title="Delete" href="finance/deleteTemplate?id=<?php echo $template->id; ?>" onclick="return confirm('Are you sure you want to delete this template?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No templates found. <a href="finance/addTemplateView">Create your first template</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- page end-->
    </div>
</div>
</div>

<script>
$(document).ready(function() {
    $('#template-table').DataTable({
        "pageLength": 25,
        "responsive": true,
        "order": [[ 4, "desc" ]]
    });
});
</script> 