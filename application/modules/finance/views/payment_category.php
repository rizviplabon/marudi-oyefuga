  <link href="common/extranal/css/finance/payment_category.css" rel="stylesheet">
  <div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"><?php echo lang('payment_procedures'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
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
                                        <li class="breadcrumb-item active"><?php echo lang('payment_procedures'); ?></li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <section class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-8">  <?php echo lang('payment_procedures'); ?></h4> 
                                        <div class="col-lg-4 no-print pull-right"> 
                                        <a href="finance/addPaymentCategoryView" class="btn btn-primary waves-effect waves-light w-xs" ><i class="fa fa-plus-circle"></i> <?php echo lang('create_payment_procedure'); ?></a>
                                           
                                        </div>
                                    </div>
          
            <div class="card-body">
                <div class="adv-table editable-table "> 
                <div class="row" style="margin-top: 10px;">
                     
                        <div class="col-md-4">
                            <select class="form-control category js-example-basic-single">
                                <option value="all"><?php echo lang('all'); ?></option>
                                <?php foreach ($paycategories as $paycategory) { ?>
                                <option value="<?php echo $paycategory->id; ?>"><?php echo $paycategory->category; ?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        <div class="col-md-8 text-right">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="manageTemplatesBtn" onclick="openTemplateManagement()">
                                <i class="fa fa-cogs"></i> Manage Templates
                            </button>
                        </div>
                    </div>
                 
                    <table class="table mb-0" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('code'); ?></th>
                               
                                <th>Payment procedure name</th>
                                <th>Lab test location</th>
                                <th><?php echo lang('category'); ?>
                                <th><?php echo lang('category'); ?> <?php echo lang('price'); ?> ( <?php echo $settings->currency; ?> )</th>
                                <th><?php echo lang('doctors_commission'); ?></th>
                                <th><?php echo lang('type'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>

                        
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->
<!-- Add Patient Modal-->
<style>
    .ck-editor__editable:not(.ck-editor__nested-editable) { 
    min-height: 400px !important;
}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
                
                <h5 class="modal-title"><?php echo lang('add_template'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
         
            <div class="modal-body row">
                <form role="form" id="addTemplate" action="finance/addPaymentProccedureTemplate" class="clearfix" method="post" enctype="multipart/form-data">
              
                <div class="form-group">
                    <label class="control-label"><?php echo lang('template'); ?></label>
                    <textarea class="form-control ckeditor" id="editor1" name="report" value="" rows="50" cols="20"></textarea>
                </div>
                  
                <input type="hidden" name="id">

                <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Enhanced Template Modal for Diagnostic Tests -->
<div class="modal fade" id="enhancedTemplateModal" tabindex="-1" role="dialog" aria-labelledby="enhancedTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enhancedTemplateModalLabel">Payment Procedure Template</h5>
                <button type="button" class="close" onclick="$('#enhancedTemplateModal').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div id="template-content">
                    <!-- Template assignment/view content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Management Modal -->
<div class="modal fade" id="templateManagementModal" tabindex="-1" role="dialog" aria-labelledby="templateManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateManagementModalLabel">Template Management</h5>
                <button type="button" class="close" onclick="$('#templateManagementModal').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div id="template-management-content">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin"></i> Loading templates...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Template Modal -->
<div class="modal fade" id="createTemplateModal" tabindex="-1" role="dialog" aria-labelledby="createTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTemplateModalLabel">Create Template</h5>
                <button type="button" class="close" onclick="$('#createTemplateModal').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div id="create-template-content">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin"></i> Loading form...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Patient Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script defer type="text/javascript" src="common/assets/DataTables/datatables.min.js"></script>
<script src="common/extranal/js/finance/payment_category.js"></script>

<script>
$(document).ready(function() {
    // Handle manage templates button click
    $('#manageTemplatesBtn').click(function() {
        console.log('Manage Templates button clicked');
        $('#templateManagementModal').modal('show');
        loadTemplateManagementContent();
    });
    
    // Test if jQuery and modal are working
    console.log('Payment category page scripts loaded');
    console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'Not loaded');
    console.log('Bootstrap modal available:', typeof $.fn.modal !== 'undefined');
    
    // Check if required elements exist
    console.log('Manage Templates button exists:', $('#manageTemplatesBtn').length > 0);
    console.log('Template Management Modal exists:', $('#templateManagementModal').length > 0);
    console.log('Enhanced Template Modal exists:', $('#enhancedTemplateModal').length > 0);
    
    // Add fallback click handler using different method
    $(document).on('click', '#manageTemplatesBtn', function() {
        console.log('Fallback click handler triggered');
        openTemplateManagement();
    });

    // Handle enhanced template modal - both click events for different scenarios
    $(document).on('click', '.enhanced-template', function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');
        console.log('Enhanced template button clicked for category:', categoryId);
        
        // Show the modal first
        $('#enhancedTemplateModal').modal('show');
        
        // Load template content via AJAX
        $('#template-content').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        
        $.get('finance/getTemplateModal', {id: categoryId}, function(response) {
            var data = JSON.parse(response);
            var category = data.payment_category;
            var templates = data.templates;
            
            var modalContent = '';
            
            if (category.template_id) {
                // Show assigned template
                modalContent = `
                    <div class="alert alert-success">
                        <h4><i class="fa fa-check-circle"></i> Template Assigned</h4>
                        <h5><strong>Template Name:</strong> ${category.template_name || 'Template #' + category.template_id}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Category Details:</h6>
                            <p><strong>Name:</strong> ${category.category}</p>
                            <p><strong>Type:</strong> ${category.type}</p>
                            <p><strong>Price:</strong> ${category.c_price}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Template Actions:</h6>
                            <button class="btn btn-primary btn-sm" onclick="viewTemplateFields(${category.template_id})">
                                <i class="fa fa-eye"></i> View Template Fields
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="showChangeTemplateForm(${category.id})">
                                <i class="fa fa-edit"></i> Change Template
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="removeTemplate(${category.id})">
                                <i class="fa fa-times"></i> Remove Template
                            </button>
                        </div>
                    </div>
                    <div id="template-fields-container" style="display: none;">
                        <!-- Template fields will be loaded here -->
                    </div>
                `;
            } else {
                // Show template assignment interface
                modalContent = `
                    <div class="alert alert-info">
                        <h6>Assign a Template to: ${category.category}</h6>
                        <p>Select a template for this diagnostic test to enable custom field collection.</p>
                    </div>
                    <form id="assignTemplateForm">
                        <input type="hidden" name="category_id" value="${category.id}">
                        <div class="form-group">
                            <label>Select Template:</label>
                            <select class="form-control" name="template_id" required>
                                <option value="">Choose a template...</option>`;
                
                templates.forEach(function(template) {
                    modalContent += `<option value="${template.id}">${template.template_name}</option>`;
                });
                
                modalContent += `
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i> Assign Template
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="openCreateTemplateModal()">
                                <i class="fa fa-plus"></i> Create New Template
                            </button>
                        </div>
                    </form>
                `;
            }
            
            $('#template-content').html(modalContent);
        }).fail(function(xhr, status, error) {
            console.error('Error loading template modal content:', error);
            $('#template-content').html('<div class="alert alert-danger">Error loading template content: ' + error + '</div>');
        });
    });
    
    // Handle template assignment
    $(document).on('submit', '#assignTemplateForm', function(e) {
        e.preventDefault();
        console.log('Template assignment form submitted');
        
        var formData = $(this).serialize();
        console.log('Form data:', formData);
        
        $.post('finance/assignTemplate', formData, function(response) {
            console.log('Assignment response:', response);
            $('#enhancedTemplateModal').modal('hide');
            
            // Show success message
            alert('Template assigned successfully!');
            
            // Refresh the page to show updated data
            location.reload();
        }).fail(function(xhr, status, error) {
            console.error('Assignment failed:', error);
            alert('Error assigning template: ' + error);
        });
    });
});

function viewTemplateFields(templateId) {
    $.get('finance/getTemplateFields', {template_id: templateId}, function(response) {
        var fields = JSON.parse(response);
        var fieldsHtml = '<h6>Template Fields:</h6><div class="row">';
        
        fields.forEach(function(field) {
            var requiredBadge = field.is_required == '1' ? '<span class="badge badge-danger">Required</span>' : '';
            fieldsHtml += `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>${field.field_label} ${requiredBadge}</h6>
                            <p><strong>Type:</strong> ${field.field_type}</p>
                            <p><strong>Name:</strong> ${field.field_name}</p>
                            ${field.field_options ? '<p><strong>Options:</strong> ' + field.field_options + '</p>' : ''}
                            ${field.help_text ? '<p><strong>Help:</strong> ' + field.help_text + '</p>' : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        fieldsHtml += '</div>';
        $('#template-fields-container').html(fieldsHtml).show();
    });
}

function showChangeTemplateForm(categoryId) {
    // Load template selection interface for changing template
    $.get('finance/getTemplateModal', {id: categoryId}, function(response) {
        var data = JSON.parse(response);
        var category = data.payment_category;
        var templates = data.templates;
        
        var modalContent = `
            <div class="alert alert-warning">
                <h6>Change Template for: ${category.category}</h6>
                <p>Select a new template to replace the current one.</p>
            </div>
            <form id="assignTemplateForm">
                <input type="hidden" name="category_id" value="${category.id}">
                <div class="form-group">
                    <label>Select New Template:</label>
                    <select class="form-control" name="template_id" required>
                        <option value="">Choose a template...</option>`;
        
        templates.forEach(function(template) {
            var selected = template.id == category.template_id ? 'selected' : '';
            modalContent += `<option value="${template.id}" ${selected}>${template.template_name}</option>`;
        });
        
        modalContent += `
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Change Template
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="openCreateTemplateModal()">
                        <i class="fa fa-plus"></i> Create New Template
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="$('.enhanced-template[data-id=\\'' + categoryId + '\\']').click()">
                        <i class="fa fa-arrow-left"></i> Back to Template View
                    </button>
                </div>
            </form>
        `;
        
        $('#template-content').html(modalContent);
    });
}

function changeTemplate(categoryId) {
    // Reload modal to show template selection
    $('.enhanced-template[data-id="' + categoryId + '"]').click();
}

function removeTemplate(categoryId) {
    if (confirm('Are you sure you want to remove the template from this category?')) {
        $.post('finance/assignTemplate', {
            category_id: categoryId,
            template_id: ''
        }, function(response) {
            $('#enhancedTemplateModal').modal('hide');
            location.reload();
        });
    }
}

// Load template management content
function loadTemplateManagementContent() {
    console.log('Loading template management content...');
    $.get('finance/getTemplateManagementContent', function(response) {
        console.log('Template management content loaded');
        $('#template-management-content').html(response);
    }).fail(function(xhr, status, error) {
        console.error('Error loading template management content:', error);
        $('#template-management-content').html('<div class="alert alert-danger">Error loading template management content: ' + error + '</div>');
    });
}

// Open create template modal
function openCreateTemplateModal(templateId = null) {
    var title = templateId ? 'Edit Template' : 'Create New Template';
    $('#createTemplateModalLabel').text(title);
    
    var url = templateId ? 'finance/getTemplateFormContent?id=' + templateId : 'finance/getTemplateFormContent';
    
    $.get(url, function(response) {
        $('#create-template-content').html(response);
        $('#createTemplateModal').modal('show');
        
        // Initialize the template form after content is loaded
        if (typeof initializeTemplateForm === 'function') {
            initializeTemplateForm();
        }
    }).fail(function() {
        $('#create-template-content').html('<div class="alert alert-danger">Error loading template form.</div>');
    });
}

// Edit template from management modal
function editTemplate(templateId) {
    openCreateTemplateModal(templateId);
}

// Delete template from management modal
function deleteTemplate(templateId) {
    if (confirm('Are you sure you want to delete this template? This action cannot be undone.')) {
        $.post('finance/deleteTemplateAjax', {id: templateId}, function(response) {
            var result = JSON.parse(response);
            if (result.success) {
                loadTemplateManagementContent(); // Reload the management content
                alert('Template deleted successfully');
            } else {
                alert('Error deleting template: ' + result.message);
            }
        }).fail(function() {
            alert('Error deleting template');
        });
    }
}

// Handle template form submission
$(document).on('submit', '#templateForm', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
        url: 'finance/saveTemplateAjax',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.success) {
                $('#createTemplateModal').modal('hide');
                loadTemplateManagementContent(); // Reload the management content
                alert('Template saved successfully');
            } else {
                alert('Error saving template: ' + result.message);
            }
        },
        error: function() {
            alert('Error saving template');
        }
    });
});

// Refresh template list in assignment modal after creating new template
function refreshTemplateAssignment() {
    $('#createTemplateModal').modal('hide');
    loadTemplateManagementContent();
    // Also refresh the assignment modal if it's open
    if ($('#enhancedTemplateModal').hasClass('show')) {
        $('.enhanced-template[data-id]:first').click();
    }
}

// Test modal function for debugging
function testModal() {
    console.log('Test modal function called');
    alert('Test button clicked! If you see this, JavaScript is working.');
    $('#templateManagementModal').modal('show');
    $('#template-management-content').html('<div class="alert alert-success">Test content loaded successfully!</div>');
}

// Alternative method to open template management modal
function openTemplateManagement() {
    console.log('Opening template management modal...');
    try {
        $('#templateManagementModal').modal('show');
        loadTemplateManagementContent();
    } catch (error) {
        console.error('Error opening template management modal:', error);
        alert('Error opening modal: ' + error.message);
    }
}
</script>
