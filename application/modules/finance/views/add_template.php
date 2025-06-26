<link href="common/extranal/css/finance/payment_category.css" rel="stylesheet">
<style>
.field-builder {
    border: 1px solid #e9ecef;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
}

.field-item {
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 10px;
    background-color: white;
    position: relative;
}

.field-item .remove-field {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #dc3545;
    cursor: pointer;
}

.field-options-container {
    display: none;
}

.sortable-handle {
    cursor: move;
    color: #6c757d;
}
</style>

<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12 content-header">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <?php echo isset($template) ? 'Edit Template' : 'Create New Template'; ?>
                </h4>&nbsp;&nbsp; &nbsp;&nbsp;
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
                        <li class="breadcrumb-item"><a href="finance/templateManagement">Templates</a></li>
                        <li class="breadcrumb-item active"><?php echo isset($template) ? 'Edit' : 'Create'; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- page start-->
    <section class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">
                <?php echo isset($template) ? 'Edit Template: ' . $template->template_name : 'Create New Template'; ?>
            </h4>
        </div>
      
        <div class="card-body">
            <form role="form" action="finance/addTemplate" class="clearfix" method="post" enctype="multipart/form-data">
                <?php if (isset($template)) { ?>
                    <input type="hidden" name="id" value="<?php echo $template->id; ?>">
                <?php } ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Template Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="template_name" 
                                   value="<?php echo isset($template) ? $template->template_name : set_value('template_name'); ?>" 
                                   placeholder="Enter template name" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Procedure Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="procedure_type" required>
                                <option value="">Select Procedure Type</option>
                                <option value="diagnostic_test" <?php echo (isset($template) && $template->procedure_type == 'diagnostic_test') ? 'selected' : ''; ?>>
                                    Diagnostic Test
                                </option>
                                <option value="others" <?php echo (isset($template) && $template->procedure_type == 'others') ? 'selected' : ''; ?>>
                                    Others
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" 
                                      placeholder="Enter template description"><?php echo isset($template) ? $template->description : set_value('description'); ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="field-builder">
                    <h5>Template Fields</h5>
                    <p class="text-muted">Create custom fields for this template. Fields can be reordered by dragging.</p>
                    
                    <div id="template-fields">
                        <?php if (isset($template_fields) && !empty($template_fields)) { ?>
                            <?php foreach ($template_fields as $index => $field) { ?>
                                <div class="field-item" data-index="<?php echo $index; ?>">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <i class="fa fa-bars sortable-handle"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <i class="fa fa-times remove-field" title="Remove Field"></i>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Field Name</label>
                                                        <input type="text" class="form-control" name="fields[<?php echo $index; ?>][field_name]" 
                                                               value="<?php echo $field->field_name; ?>" placeholder="field_name" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Field Label</label>
                                                        <input type="text" class="form-control" name="fields[<?php echo $index; ?>][field_label]" 
                                                               value="<?php echo $field->field_label; ?>" placeholder="Field Label" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Field Type</label>
                                                        <select class="form-control field-type-select" name="fields[<?php echo $index; ?>][field_type]" required>
                                                            <option value="">Select Type</option>
                                                            <option value="text" <?php echo ($field->field_type == 'text') ? 'selected' : ''; ?>>Text Input</option>
                                                            <option value="textarea" <?php echo ($field->field_type == 'textarea') ? 'selected' : ''; ?>>Textarea</option>
                                                            <option value="select" <?php echo ($field->field_type == 'select') ? 'selected' : ''; ?>>Dropdown</option>
                                                            <option value="radio" <?php echo ($field->field_type == 'radio') ? 'selected' : ''; ?>>Radio Button</option>
                                                            <option value="checkbox" <?php echo ($field->field_type == 'checkbox') ? 'selected' : ''; ?>>Checkbox</option>
                                                            <option value="number" <?php echo ($field->field_type == 'number') ? 'selected' : ''; ?>>Number</option>
                                                            <option value="date" <?php echo ($field->field_type == 'date') ? 'selected' : ''; ?>>Date</option>
                                                            <option value="email" <?php echo ($field->field_type == 'email') ? 'selected' : ''; ?>>Email</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Placeholder</label>
                                                        <input type="text" class="form-control" name="fields[<?php echo $index; ?>][placeholder]" 
                                                               value="<?php echo $field->placeholder; ?>" placeholder="Enter placeholder text">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Default Value</label>
                                                        <input type="text" class="form-control" name="fields[<?php echo $index; ?>][default_value]" 
                                                               value="<?php echo $field->default_value; ?>" placeholder="Default value">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Field Width</label>
                                                        <select class="form-control" name="fields[<?php echo $index; ?>][field_width]">
                                                            <option value="col-md-6" <?php echo ($field->field_width == 'col-md-6') ? 'selected' : ''; ?>>Half Width</option>
                                                            <option value="col-md-12" <?php echo ($field->field_width == 'col-md-12') ? 'selected' : ''; ?>>Full Width</option>
                                                            <option value="col-md-4" <?php echo ($field->field_width == 'col-md-4') ? 'selected' : ''; ?>>One Third</option>
                                                            <option value="col-md-8" <?php echo ($field->field_width == 'col-md-8') ? 'selected' : ''; ?>>Two Thirds</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="field-options-container" style="display: <?php echo in_array($field->field_type, ['select', 'radio', 'checkbox']) ? 'block' : 'none'; ?>;">
                                                <div class="form-group">
                                                    <label>Options (comma separated)</label>
                                                    <input type="text" class="form-control" name="fields[<?php echo $index; ?>][field_options]" 
                                                           value="<?php echo $field->field_options; ?>" placeholder="Option 1, Option 2, Option 3">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="fields[<?php echo $index; ?>][is_required]" 
                                                               <?php echo $field->is_required ? 'checked' : ''; ?>>
                                                        <label class="form-check-label">Required Field</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="fields[<?php echo $index; ?>][help_text]" 
                                                               value="<?php echo $field->help_text; ?>" placeholder="Help text (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    
                    <button type="button" class="btn btn-secondary" id="add-field">
                        <i class="fa fa-plus"></i> Add Field
                    </button>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> <?php echo isset($template) ? 'Update Template' : 'Create Template'; ?>
                    </button>
                    <a href="finance/templateManagement" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Templates
                    </a>
                </div>
            </form>
        </div>
    </section>
    <!-- page end-->
    </div>
</div>
</div>

<script>
let fieldIndex = <?php echo isset($template_fields) ? count($template_fields) : 0; ?>;

$(document).ready(function() {
    // Make fields sortable
    $("#template-fields").sortable({
        handle: ".sortable-handle",
        axis: "y"
    });

    // Add new field
    $("#add-field").click(function() {
        let fieldHtml = `
            <div class="field-item" data-index="${fieldIndex}">
                <div class="row">
                    <div class="col-md-1">
                        <i class="fa fa-bars sortable-handle"></i>
                    </div>
                    <div class="col-md-11">
                        <i class="fa fa-times remove-field" title="Remove Field"></i>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Field Name</label>
                                    <input type="text" class="form-control" name="fields[${fieldIndex}][field_name]" placeholder="field_name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Field Label</label>
                                    <input type="text" class="form-control" name="fields[${fieldIndex}][field_label]" placeholder="Field Label" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Field Type</label>
                                    <select class="form-control field-type-select" name="fields[${fieldIndex}][field_type]" required>
                                        <option value="">Select Type</option>
                                        <option value="text">Text Input</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="select">Dropdown</option>
                                        <option value="radio">Radio Button</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Placeholder</label>
                                    <input type="text" class="form-control" name="fields[${fieldIndex}][placeholder]" placeholder="Enter placeholder text">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Default Value</label>
                                    <input type="text" class="form-control" name="fields[${fieldIndex}][default_value]" placeholder="Default value">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Field Width</label>
                                    <select class="form-control" name="fields[${fieldIndex}][field_width]">
                                        <option value="col-md-6">Half Width</option>
                                        <option value="col-md-12">Full Width</option>
                                        <option value="col-md-4">One Third</option>
                                        <option value="col-md-8">Two Thirds</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field-options-container" style="display: none;">
                            <div class="form-group">
                                <label>Options (comma separated)</label>
                                <input type="text" class="form-control" name="fields[${fieldIndex}][field_options]" placeholder="Option 1, Option 2, Option 3">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="fields[${fieldIndex}][is_required]">
                                    <label class="form-check-label">Required Field</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="fields[${fieldIndex}][help_text]" placeholder="Help text (optional)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $("#template-fields").append(fieldHtml);
        fieldIndex++;
    });

    // Remove field
    $(document).on('click', '.remove-field', function() {
        $(this).closest('.field-item').remove();
    });

    // Show/hide options field based on field type
    $(document).on('change', '.field-type-select', function() {
        let fieldType = $(this).val();
        let optionsContainer = $(this).closest('.field-item').find('.field-options-container');
        
        if (['select', 'radio', 'checkbox'].includes(fieldType)) {
            optionsContainer.show();
        } else {
            optionsContainer.hide();
        }
    });
});
</script> 