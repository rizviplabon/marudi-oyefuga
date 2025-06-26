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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                            <li class="breadcrumb-item active"><?php echo $page; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->

        <!-- Custom CSS for enhanced UI -->
        <style>
            /* Medical-grade UI enhancements */
            :root {
                --primary: #2c7be5;
                --primary-dark: #1a68d1;
                --secondary: #95aac9;
                --success: #00cc8d;
                --info: #39afd1;
                --warning: #f6c343;
                --danger: #e63757;
                --light: #f9fbfd;
                --dark: #12263f;
                --white: #ffffff;
                --muted: #95aac9;
                --gray-100: #f9fbfd;
                --gray-200: #edf2f9;
                --gray-300: #e3ebf6;
                --gray-400: #d2ddec;
                --gray-500: #b1c2d9;
                --gray-600: #95aac9;
                --gray-700: #6e84a3;
                --gray-800: #3b506c;
                --gray-900: #12263f;
            }
            
            body {
                color: var(--gray-800);
                background-color: var(--gray-100);
            }
            
            .card {
                border: none;
                border-radius: 0.75rem;
                box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
                background-color: var(--white);
                margin-bottom: 1.5rem;
                transition: all 0.2s ease;
            }
            
            .card:hover {
                box-shadow: 0 1rem 2rem rgba(18, 38, 63, 0.06);
                transform: translateY(-2px);
            }
            
            .card-header {
                background-color: var(--white);
                border-bottom: 1px solid var(--gray-200);
                padding: 1.25rem 1.5rem;
                border-top-left-radius: 0.75rem !important;
                border-top-right-radius: 0.75rem !important;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .card-title {
                font-weight: 600;
                color: var(--gray-900);
                margin-bottom: 0;
                font-size: 1.1rem;
                display: flex;
                align-items: center;
            }
            
            .card-title i {
                color: var(--primary);
                margin-right: 0.5rem;
                font-size: 1rem;
            }
            
            .btn {
                font-weight: 500;
                letter-spacing: 0.025em;
                text-transform: none;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                transition: all 0.15s ease;
                box-shadow: 0 1px 2px rgba(18, 38, 63, 0.05);
            }
            
            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 6px rgba(18, 38, 63, 0.1);
            }
            
            .btn:active {
                transform: translateY(1px);
                box-shadow: none;
            }
            
            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
            }
            
            .btn-sm {
                padding: 0.25rem 0.75rem;
                font-size: 0.8125rem;
                border-radius: 0.25rem;
            }
            
            .btn-group .btn {
                box-shadow: none;
            }
            
            .btn-info {
                background-color: var(--info);
                border-color: var(--info);
            }
            
            .btn-success {
                background-color: var(--success);
                border-color: var(--success);
            }
            
            .btn-warning {
                background-color: var(--warning);
                border-color: var(--warning);
                color: var(--dark);
            }
            
            .btn-danger {
                background-color: var(--danger);
                border-color: var(--danger);
            }
            
            .btn-secondary {
                background-color: var(--secondary);
                border-color: var(--secondary);
            }
            
            .table {
                margin-bottom: 0;
            }
            
            .table thead th {
                background-color: var(--gray-100);
                border-bottom: 2px solid var(--gray-200);
                font-weight: 600;
                color: var(--gray-700);
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.08em;
                padding: 0.75rem 1rem;
                vertical-align: middle;
            }
            
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: var(--gray-100);
            }
            
            .table td, .table th {
                vertical-align: middle;
                padding: 1rem;
                border-top: 1px solid var(--gray-200);
            }
            
            .badge {
                font-weight: 500;
                padding: 0.33em 0.65em;
                font-size: 0.75em;
                border-radius: 0.375rem;
                letter-spacing: 0.025em;
            }
            
            .badge-success {
                background-color: rgba(0, 204, 141, 0.1);
                color: var(--success);
            }
            
            .badge-danger {
                background-color: rgba(230, 55, 87, 0.1);
                color: var(--danger);
            }
            
            .badge-secondary {
                background-color: rgba(149, 170, 201, 0.1);
                color: var(--secondary);
            }
            
            .form-control {
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                border: 1px solid var(--gray-300);
                font-size: 0.9375rem;
                height: calc(1.5em + 1rem + 2px);
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .form-control:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
            }
            
            textarea.form-control {
                height: auto;
            }
            
            .modal-content {
                border-radius: 0.75rem;
                border: none;
                box-shadow: 0 1.5rem 2rem rgba(18, 38, 63, 0.15);
            }
            
            .modal-header { 
                border-bottom: 1px solid var(--gray-200);
                background-color: var(--white);
                border-top-left-radius: 0.75rem;
                border-top-right-radius: 0.75rem;
                padding: 1.25rem 1.5rem;
            }
            
            .modal-footer {
                border-top: 1px solid var(--gray-200);
                background-color: var(--white);
                border-bottom-left-radius: 0.75rem;
                border-bottom-right-radius: 0.75rem;
                padding: 1.25rem 1.5rem;
            }
            
            /* Fix modal display issues */
            .modal {
                z-index: 1050;
                overflow-y: auto;
            }
            
            .modal-dialog {
                margin: 1.75rem auto;
                max-width: 600px;
                width: 100%;
            }
            
            .modal-backdrop {
                z-index: 1040;
            }
            
            .modal-open {
                overflow: hidden;
                padding-right: 0 !important;
            }
            
            .modal-body {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
                padding: 1.5rem;
            }
            
            .modal-title {
                font-weight: 600;
                color: var(--gray-900);
                display: flex;
                align-items: center;
            }
            
            .modal-title i {
                color: var(--primary);
                margin-right: 0.5rem;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: var(--primary) !important;
                color: var(--white) !important;
                border: none !important;
                border-radius: 0.375rem !important;
                box-shadow: 0 1px 3px rgba(18, 38, 63, 0.1);
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: var(--primary) !important;
                color: var(--white) !important;
                border: none !important;
            }
            
            .dataTables_wrapper .dataTables_filter input {
                border: 1px solid var(--gray-300);
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                margin-left: 0.5rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
                outline: none;
            }
            
            .dataTables_wrapper .dataTables_length select {
                border: 1px solid var(--gray-300);
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .dataTables_wrapper .dataTables_length select:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
                outline: none;
            }
            
            .table-responsive {
                border-radius: 0.75rem;
                box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            }
            
            /* Row hover effect */
            .table tbody tr {
                transition: all 0.15s ease;
            }
            
            .table tbody tr:hover {
                background-color: rgba(44, 123, 229, 0.03) !important;
                transform: translateY(-1px);
                box-shadow: 0 0.125rem 0.25rem rgba(18, 38, 63, 0.05);
            }
        </style>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-folder-open medical-icon"></i> Inventory Categories</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategoryModal"><i class="fa fa-plus"></i> Add Category</button>
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
                            <table id="categories-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Item Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body will be filled by DataTables -->
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
        // Initialize DataTable with server-side processing
        var table = $('#categories-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('inventory/getCategoriesData'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data": 0 },
                { "data": 1 },
                { "data": 2 },
                { "data": 3 },
                { "data": 4, "orderable": false }
            ],
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [ 
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'Inventory Categories', className: 'btn-sm'},
                {extend: 'excel', title: 'Inventory Categories', className: 'btn-sm'},
                {extend: 'pdf', title: 'Inventory Categories', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
            "language": {
                "search": "<span class='small text-muted'>Search:</span> _INPUT_",
                "searchPlaceholder": "Category name...",
                "lengthMenu": "<span class='small text-muted'>_MENU_</span>",
                "info": "<b>_START_</b> to <b>_END_</b> of <b>_TOTAL_</b>",
                "paginate": {
                    "first": "<i class='fa fa-angle-double-left'></i>",
                    "last": "<i class='fa fa-angle-double-right'></i>",
                    "next": "<i class='fa fa-angle-right'></i>",
                    "previous": "<i class='fa fa-angle-left'></i>"
                },
                "processing": "<div class='loading-spinner'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div>"
            },
            "drawCallback": function() {
                // Initialize edit buttons after table redraw
                $('.editCategoryBtn').on('click', function() {
                    var categoryId = $(this).data('id');
                    getCategoryData(categoryId);
                });
            }
        });
        
        // Function to get category data for editing
        function getCategoryData(categoryId) {
            $.ajax({
                url: "<?php echo base_url('inventory/getCategoryData/'); ?>" + categoryId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Populate the edit form
                        $('#edit_category_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_description').val(response.description);
                        
                        // Show the modal
                        $('#editCategoryModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        }
        
        // Handle add category form submission via AJAX
        $('#addCategoryForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert(response.message);
                        
                        // Close the modal
                        $('#addCategoryModal').modal('hide');
                        
                        // Reset the form
                        $('#addCategoryForm')[0].reset();
                        
                        // Reload the table
                        $('#categories-table').DataTable().ajax.reload();
                    } else {
                        // Show error message
                        var errorHtml = '';
                        $.each(response.errors, function(key, value) {
                            errorHtml += value + '<br>';
                        });
                        $('#categoryFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX submission error:', { 
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        responseJSON: xhr.responseJSON
                    });
                    
                    // Try to show more specific error message
                    var errorMessage = 'An error occurred while processing your request';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        // Check if it's an HTML error page
                        if (xhr.responseText.indexOf('<!DOCTYPE') > -1 || xhr.responseText.indexOf('<html') > -1) {
                            errorMessage = 'Server error occurred. Check console for details.';
                            console.error('HTML Error Response:', xhr.responseText);
                        } else {
                            errorMessage = xhr.responseText;
                        }
                    }
                    
                    alert(errorMessage);
                }
            });
        });
        
        // Handle edit category form submission via AJAX
        $('#editCategoryForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert(response.message);
                        
                        // Close the modal
                        $('#editCategoryModal').modal('hide');
                        
                        // Reload the table
                        $('#categories-table').DataTable().ajax.reload();
                    } else {
                        // Show error message
                        var errorHtml = '';
                        $.each(response.errors, function(key, value) {
                            errorHtml += value + '<br>';
                        });
                        $('#editCategoryFormErrors').html(errorHtml).show();
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Make sure modals are properly initialized
        $('.modal').modal({
            show: false,
            backdrop: true,
            keyboard: true
        });
        
        // Fix modal z-index issues
        $('.modal').appendTo('body');
        
        // Ensure Add Category button works
        $('[data-target="#addCategoryModal"]').on('click', function(e) {
            e.preventDefault();
            $('#addCategoryModal').modal('show');
        }); 
    });
</script>

<!-- Include common scripts for inventory modals -->
<?php $this->load->view('inventory/common_scripts'); ?>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel"><i class="fa fa-plus"></i> Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="categoryFormErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="addCategoryForm" action="<?php echo base_url(); ?>inventory/addCategory" method="post">
                    <div class="form-group">
                        <label><i class="fas fa-tag medical-icon"></i> Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-align-left medical-icon"></i> Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addCategoryForm" class="btn btn-primary">Add Category</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel"><i class="fa fa-edit"></i> Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editCategoryFormErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="editCategoryForm" action="<?php echo base_url(); ?>inventory/editCategory" method="post">
                    <input type="hidden" id="edit_category_id" name="id">
                    
                    <div class="form-group">
                        <label><i class="fas fa-tag medical-icon"></i> Category Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-align-left medical-icon"></i> Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editCategoryForm" class="btn btn-primary">Update Category</button>
            </div>
        </div>
    </div>
</div>