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

<form role="form" id="templateForm" class="clearfix" method="post" enctype="multipart/form-data">
    <?php if (isset($template)) { ?>
        <input type="hidden" name="id" value="<?php echo $template->id; ?>">
    <?php } ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Template Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="template_name" 
                       value="<?php echo isset($template) ? $template->template_name : ''; ?>" 
                       placeholder="Enter template name" required>
                <small class="text-muted">This template will be used for Diagnostic Test procedures only.</small>
            </div>
            <!-- Hidden field for procedure type - always diagnostic_test -->
            <input type="hidden" name="procedure_type" value="diagnostic_test">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Description</label>
                <textarea class="form-control" name="description" rows="3" 
                          placeholder="Enter template description"><?php echo isset($template) ? $template->description : ''; ?></textarea>
            </div>
        </div>
    </div>

    <hr>

    <div class="field-builder">
        <h6>Template Fields</h6>
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
                                <i class="fa fa-times remove-field" title="Remove Field" onclick="removeField(this)"></i>
                                
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
                                            <select class="form-control field-type-select" name="fields[<?php echo $index; ?>][field_type]" onchange="toggleFieldOptions(this)" required>
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
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Reference Value <small class="text-muted">(Normal ranges, expected values, etc.)</small></label>
                                            <input type="text" class="form-control" name="fields[<?php echo $index; ?>][reference_value]" 
                                                   value="<?php echo isset($field->reference_value) ? $field->reference_value : ''; ?>" 
                                                   placeholder="e.g. Normal range: 12-16 g/dL (Female), 14-18 g/dL (Male)">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Units <small class="text-muted">(Measurement units)</small></label>
                                            <input type="text" class="form-control" name="fields[<?php echo $index; ?>][units]" 
                                                   value="<?php echo isset($field->units) ? $field->units : ''; ?>" 
                                                   placeholder="e.g. mg/dL, g/L, %">
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
        
        <button type="button" class="btn btn-secondary btn-sm" id="add-field-btn" onclick="addNewField()">
            <i class="fa fa-plus"></i> Add Field
        </button>
    </div>

    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary" onclick="$('#createTemplateModal').modal('hide');">
            <i class="fa fa-times"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> <?php echo isset($template) ? 'Update Template' : 'Create Template'; ?>
        </button>
    </div>
</form>

<script>
var templateFieldIndex = <?php echo isset($template_fields) ? count($template_fields) : 0; ?>;

// Initialize sortable when modal content loads
function initializeTemplateForm() {
    console.log('Initializing template form...');
    
    // Make fields sortable
    if (typeof $.fn.sortable !== 'undefined') {
        $("#template-fields").sortable({
            handle: ".sortable-handle",
            axis: "y"
        });
    }
}

// Add new field function
function addNewField() {
    console.log('Adding new field, current index:', templateFieldIndex);
    var fieldHtml = `
        <div class="field-item" data-index="${templateFieldIndex}">
            <div class="row">
                <div class="col-md-1">
                    <i class="fa fa-bars sortable-handle"></i>
                </div>
                <div class="col-md-11">
                    <i class="fa fa-times remove-field" title="Remove Field" onclick="removeField(this)"></i>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Field Name</label>
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][field_name]" placeholder="field_name" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Field Label</label>
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][field_label]" placeholder="Field Label" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Field Type</label>
                                <select class="form-control field-type-select" name="fields[${templateFieldIndex}][field_type]" onchange="toggleFieldOptions(this)" required>
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
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][placeholder]" placeholder="Enter placeholder text">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Default Value</label>
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][default_value]" placeholder="Default value">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Field Width</label>
                                <select class="form-control" name="fields[${templateFieldIndex}][field_width]">
                                    <option value="col-md-6">Half Width</option>
                                    <option value="col-md-12">Full Width</option>
                                    <option value="col-md-4">One Third</option>
                                    <option value="col-md-8">Two Thirds</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Reference Value <small class="text-muted">(Normal ranges, expected values, etc.)</small></label>
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][reference_value]" 
                                       placeholder="e.g. Normal range: 12-16 g/dL (Female), 14-18 g/dL (Male)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Units <small class="text-muted">(Measurement units)</small></label>
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][units]" 
                                       placeholder="e.g. mg/dL, g/L, %">
                            </div>
                        </div>
                    </div>
                    
                    <div class="field-options-container" style="display: none;">
                        <div class="form-group">
                            <label>Options (comma separated)</label>
                            <input type="text" class="form-control" name="fields[${templateFieldIndex}][field_options]" placeholder="Option 1, Option 2, Option 3">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="fields[${templateFieldIndex}][is_required]">
                                <label class="form-check-label">Required Field</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="fields[${templateFieldIndex}][help_text]" placeholder="Help text (optional)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $("#template-fields").append(fieldHtml);
    templateFieldIndex++;
}

// Remove field function
function removeField(element) {
    console.log('Removing field...');
    $(element).closest('.field-item').remove();
}

// Toggle field options visibility
function toggleFieldOptions(selectElement) {
    var fieldType = $(selectElement).val();
    var optionsContainer = $(selectElement).closest('.field-item').find('.field-options-container');
    
    console.log('Field type changed to:', fieldType);
    
    if (['select', 'radio', 'checkbox'].includes(fieldType)) {
        optionsContainer.show();
    } else {
        optionsContainer.hide();
    }
}

// Initialize form when content is loaded
$(document).ready(function() {
    initializeTemplateForm();
});
</script> 