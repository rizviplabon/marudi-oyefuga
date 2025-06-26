<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 content-header">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo $title; ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo $title; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Encryption Migration Tool</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-info-circle"></i> This tool will encrypt sensitive patient data in the database for compliance purposes.
                            <br> 
                            <strong>Important:</strong> Please make a database backup before proceeding.
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <button id="test-encryption" class="btn btn-info waves-effect waves-light">
                                    <i class="fa fa-key"></i> Test Encryption
                                </button>
                                <button id="run-migration" class="btn btn-primary waves-effect waves-light">
                                    <i class="fa fa-lock"></i> Encrypt All Data
                                </button>
                            </div>
                        </div>
                        
                        <div id="test-results" class="d-none mb-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">Encryption Test Results</h5>
                                </div>
                                <div class="card-body" id="test-results-content">
                                </div>
                            </div>
                        </div>
                        
                        <div id="migration-progress" class="d-none">
                            <h5>Migration Progress</h5>
                            <div class="progress mb-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div id="migration-status"></div>
                        </div>
                        
                        <div id="migration-results" class="d-none">
                            <h5>Migration Results</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Table</th>
                                            <th>Fields</th>
                                            <th>Total Records</th>
                                            <th>Encrypted</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="results-table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Encrypt Individual Tables</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php 
                            // Load the encrypted fields configuration
                            $CI =& get_instance();
                            $CI->load->config('encrypted_fields', TRUE);
                            $encrypted_fields = $CI->config->item('encrypted_fields', 'encrypted_fields');
                            ?>
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Table</th>
                                        <th>Fields to Encrypt</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($encrypted_fields as $table => $fields): ?>
                                    <tr>
                                        <td><?php echo $table; ?></td>
                                        <td><?php echo implode(', ', $fields); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary encrypt-table" data-table="<?php echo $table; ?>">
                                                <i class="fa fa-lock"></i> Encrypt
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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
        // Test encryption
        $('#test-encryption').on('click', function() {
            $.ajax({
                url: '<?php echo site_url('migrate_encryption/test'); ?>',
                type: 'GET',
                dataType: 'html',
                beforeSend: function() {
                    $('#test-results').removeClass('d-none');
                    $('#test-results-content').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Testing encryption...</div>');
                },
                success: function(response) {
                    $('#test-results-content').html(response);
                },
                error: function() {
                    $('#test-results-content').html('<div class="alert alert-danger">Error during encryption test!</div>');
                }
            });
        });
        
        // Run full migration
        $('#run-migration').on('click', function() {
            if (confirm('Are you sure you want to encrypt all data? This process cannot be undone.')) {
                $('#migration-progress').removeClass('d-none');
                $('#migration-results').addClass('d-none');
                $('.progress-bar').css('width', '0%');
                $('#migration-status').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Starting encryption migration...</div>');
                
                $.ajax({
                    url: '<?php echo site_url('migrate_encryption/run_migration'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#migration-status').html('<div class="alert alert-success">Migration completed!</div>');
                        $('.progress-bar').css('width', '100%');
                        
                        $('#migration-results').removeClass('d-none');
                        $('#results-table').empty();
                        
                        $.each(response.results, function(table, result) {
                            var row = '<tr>' +
                                '<td>' + table + '</td>' +
                                '<td>' + result.fields.join(', ') + '</td>' +
                                '<td>' + result.total + '</td>' +
                                '<td>' + result.encrypted + '</td>' +
                                '<td>' + (result.status === 'success' ? '<span class="badge bg-success">Success</span>' : '<span class="badge bg-danger">Error</span>') + '</td>' +
                                '</tr>';
                            $('#results-table').append(row);
                        });
                    },
                    error: function() {
                        $('#migration-status').html('<div class="alert alert-danger">Error during migration!</div>');
                    }
                });
            }
        });
        
        // Encrypt individual table
        $('.encrypt-table').on('click', function() {
            var table = $(this).data('table');
            var button = $(this);
            
            if (confirm('Are you sure you want to encrypt data in the "' + table + '" table?')) {
                button.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                button.attr('disabled', true);
                
                $.ajax({
                    url: '<?php echo site_url('migrate_encryption/encrypt_table/'); ?>' + table,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            button.html('<i class="fa fa-check"></i> Done');
                            button.removeClass('btn-primary').addClass('btn-success');
                        } else {
                            button.html('<i class="fa fa-times"></i> Error');
                            button.removeClass('btn-primary').addClass('btn-danger');
                        }
                    },
                    error: function() {
                        button.html('<i class="fa fa-times"></i> Error');
                        button.removeClass('btn-primary').addClass('btn-danger');
                    }
                });
            }
        });
    });
</script> 