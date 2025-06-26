<div class="row mb-3">
    <div class="col-md-8">
        <h6>Payment Procedure Templates</h6>
        <p class="text-muted">Manage templates for diagnostic test procedures</p>
    </div>
    <div class="col-md-4 text-right">
        <button type="button" class="btn btn-primary btn-sm" onclick="openCreateTemplateModal()">
            <i class="fa fa-plus"></i> Create New Template
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Template Name</th>
                <th>Type</th>
                <th>Fields</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($templates)) { ?>
                <?php foreach ($templates as $template) { ?>
                    <tr>
                        <td>
                            <strong><?php echo $template->template_name; ?></strong>
                            <?php if (!empty($template->description)) { ?>
                                <br><small class="text-muted"><?php echo $template->description; ?></small>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($template->procedure_type == 'diagnostic_test') { ?>
                                <span class="badge badge-primary">Diagnostic Test</span>
                            <?php } else { ?>
                                <span class="badge badge-secondary"><?php echo ucfirst($template->procedure_type); ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php 
                            $field_count = count($this->finance_model->getPaymentProcedureTemplateFields($template->id));
                            ?>
                            <span class="badge badge-info"><?php echo $field_count; ?> fields</span>
                        </td>
                        <td>
                            <small><?php echo date('M j, Y', strtotime($template->created_at)); ?></small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" onclick="editTemplate(<?php echo $template->id; ?>)" title="Edit Template">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="viewTemplateFields(<?php echo $template->id; ?>)" title="View Fields">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteTemplate(<?php echo $template->id; ?>)" title="Delete Template">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="fa fa-info-circle"></i> No templates found. 
                        <a href="#" onclick="openCreateTemplateModal()">Create your first template</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="template-fields-preview" style="display: none;">
    <hr>
    <h6>Template Fields Preview</h6>
    <div id="fields-preview-content">
        <!-- Template fields preview will be loaded here -->
    </div>
</div>

<script>
// View template fields in management modal
function viewTemplateFields(templateId) {
    $.get('finance/getTemplateFields', {template_id: templateId}, function(response) {
        var fields = JSON.parse(response);
        var fieldsHtml = '<div class="row">';
        
        if (fields.length === 0) {
            fieldsHtml += '<div class="col-12"><div class="alert alert-info">No fields defined for this template.</div></div>';
        } else {
            fields.forEach(function(field) {
                var requiredBadge = field.is_required == '1' ? '<span class="badge badge-danger ml-2">Required</span>' : '';
                fieldsHtml += `
                    <div class="col-md-6 mb-3">
                        <div class="card card-sm">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2">${field.field_label} ${requiredBadge}</h6>
                                <p class="card-text">
                                    <strong>Type:</strong> ${field.field_type}<br>
                                    <strong>Name:</strong> ${field.field_name}
                                    ${field.field_options ? '<br><strong>Options:</strong> ' + field.field_options : ''}
                                    ${field.help_text ? '<br><strong>Help:</strong> ' + field.help_text : ''}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
        
        fieldsHtml += '</div>';
        fieldsHtml += '<button type="button" class="btn btn-secondary btn-sm" onclick="hideTemplateFieldsPreview()">Hide Fields</button>';
        
        $('#fields-preview-content').html(fieldsHtml);
        $('#template-fields-preview').show();
        
        // Scroll to preview
        $('#template-fields-preview')[0].scrollIntoView({ behavior: 'smooth' });
    });
}

function hideTemplateFieldsPreview() {
    $('#template-fields-preview').hide();
}
</script> 