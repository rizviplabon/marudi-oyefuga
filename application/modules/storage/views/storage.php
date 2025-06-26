<div class="main-content content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 content-header">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><?php echo lang('storage_settings'); ?></h4>
                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                <li class="breadcrumb-item active"><?php echo lang('storage'); ?></li>
                                <!-- <li class="breadcrumb-item active"><?php echo lang('providers'); ?></li> -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"> 
                    <section class="card">
                        <div class="card-header table_header">
                            <h4 class="card-title mb-0 col-lg-8"><?php echo lang('storage_providers'); ?></h4>
                            <div class="col-lg-4 no-print pull-right">
                                <a href="<?php echo base_url('settings'); ?>" class="btn btn-info pull-right">
                                    <i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_settings'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo validation_errors(); ?>
                                    <?php echo $this->session->flashdata('feedback'); ?>
                                    <div class="alert alert-info">
                                        <p><?php echo lang('storage_providers_allow_you_to_store_files_in_different_locations'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Radio buttons to select default storage provider -->
                            <!-- <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="card-header">
                                            <h5 class="card-title"><?php echo lang('select_default_storage'); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url('storage/set_default_provider'); ?>" method="post" class="form-inline">
                                                <?php foreach ($providers as $provider): ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="default_provider" 
                                                        id="provider_<?php echo $provider->name; ?>" 
                                                        value="<?php echo $provider->name; ?>" 
                                                        <?php echo ($provider->is_default) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="provider_<?php echo $provider->name; ?>">
                                                        <?php echo $provider->display_name; ?>
                                                    </label>
                                                </div>
                                                <?php endforeach; ?>
                                                <button type="submit" class="btn btn-primary btn-sm ms-3"><?php echo lang('save'); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <!-- Storage Type Selection -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="card-header">
                                            <h5 class="card-title"><?php echo lang('storage_type'); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url('storage/set_storage_type'); ?>" method="post" class="form-inline">
                                                <div class="form-check form-check-inline">
                                                     <input class="form-check-input" type="radio" name="storage_type" 
                                                         id="storage_local" value="local" 
                                                         <?php echo (isset($current_storage_type) && $current_storage_type == 'local') ? 'checked' : ''; ?>>
                                                     <label class="form-check-label" for="storage_local">
                                                         Local Storage
                                                     </label>
                                                 </div>
                                                 <div class="form-check form-check-inline">
                                                     <input class="form-check-input" type="radio" name="storage_type" 
                                                         id="storage_drive" value="drive" 
                                                         <?php echo (isset($current_storage_type) && $current_storage_type == 'drive') ? 'checked' : ''; ?>>
                                                     <label class="form-check-label" for="storage_drive">
                                                         Google Drive
                                                     </label>
                                                 </div>
                                                 <button type="submit" class="btn btn-primary btn-sm ms-3"><?php echo lang('save'); ?></button>
                                             </form>
                                             <div class="mt-2">
                                                 <small class="text-muted">Current storage type: <strong><?php echo isset($current_storage_type) ? ucfirst($current_storage_type) : 'Local'; ?></strong></small>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Update Table Structure Button -->
                            <!-- <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="card-header">
                                            <h5 class="card-title">Database Update</h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted">Click the button below to update the database table structure for Google Drive support.</p>
                                            <a href="<?php echo base_url('storage/update_table_structure'); ?>" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to update the table structure?')">
                                                <i class="fa fa-database"></i> Update Table Structure
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="table-responsive adv-table">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('provider'); ?></th>
                                            <th><?php echo lang('description'); ?></th>
                                            <th><?php echo lang('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($providers) && !empty($providers)): ?>
                                            <?php foreach ($providers as $provider): ?>
                                                <tr>
                                                    <td><?php echo $provider->display_name; ?></td>
                                                    <td><?php echo $provider->description; ?></td>
                                                    <td>
                                                        <?php if ($provider->name == 'googledrive'): ?>
                                                            <button type="button" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#googleDriveSettingsModal">
                                                                <i class="fa fa-cog"></i> <?php echo lang('settings'); ?>
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <section class="card">
                        <div class="card-header table_header">
                            <h4 class="card-title mb-0"><?php echo lang('file_storage_statistics'); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if (isset($storage_stats)): ?>
                                    <?php foreach ($storage_stats as $provider => $stats): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title"><?php echo $stats['display_name']; ?></h5>
                                                    <div class="mt-4">
                                                        <h2 class="mb-1"><?php echo $stats['file_count']; ?></h2>
                                                        <p class="text-muted"><?php echo lang('files'); ?></p>
                                                    </div>
                                                    <div class="mt-3">
                                                        <h2 class="mb-1"><?php echo number_format($stats['total_size'] / (1024 * 1024), 2); ?> MB</h2>
                                                        <p class="text-muted"><?php echo lang('storage_used'); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Drive Settings Modal -->
<div class="modal fade" id="googleDriveSettingsModal" tabindex="-1" aria-labelledby="googleDriveSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="googleDriveSettingsModalLabel"><?php echo lang('google_drive_settings'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('storage/googledrive_save_settings'); ?>" method="post" id="googleDriveSettingsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="project_id"><?php echo lang('project_id'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="project_id" id="project_id" class="form-control" value="<?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->project_id : ''; ?>" required>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="client_id"><?php echo lang('client_id'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="client_id" id="client_id" class="form-control" value="<?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->client_id : ''; ?>" required>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="client_email"><?php echo lang('client_email'); ?> <span class="text-danger">*</span></label>
                                <input type="email" name="client_email" id="client_email" class="form-control" value="<?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->client_email : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="private_key_id"><?php echo lang('private_key_id'); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="private_key_id" id="private_key_id" class="form-control" value="<?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->private_key_id : ''; ?>" required>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="private_key"><?php echo lang('private_key'); ?> <span class="text-danger">*</span></label>
                                <textarea name="private_key" id="private_key" class="form-control" rows="5" required><?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->private_key : ''; ?></textarea>
                                <small class="text-muted"><?php echo lang('paste_your_private_key_here_including_begin_and_end_tags'); ?></small>
                            </div>
                            
                            <div class="form-group mt-3">
                                <label for="default_folder_id"><?php echo lang('default_folder_id'); ?></label>
                                <input type="text" name="default_folder_id" id="default_folder_id" class="form-control" value="<?php echo isset($googledrive_settings) && $googledrive_settings ? $googledrive_settings->default_folder_id : ''; ?>">
                                <small class="text-muted"><?php echo lang('optional_google_drive_folder_id_where_all_files_will_be_stored'); ?></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
                <button type="button" class="btn btn-primary" id="saveGoogleDriveSettings"><?php echo lang('save_settings'); ?></button>
                <button type="button" class="btn btn-info ms-2" id="testGoogleDriveConnection"><?php echo lang('test_connection'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle Google Drive settings form submission
        $('#saveGoogleDriveSettings').click(function() {
            $('#googleDriveSettingsForm').submit();
        });
        
        // Handle Google Drive test connection via AJAX
        $('#testGoogleDriveConnection').click(function() {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> ' + '<?php echo lang('testing'); ?>');
            
            $.ajax({
                url: '<?php echo base_url('storage/googledrive_test_connection_ajax'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert(response.message);
                    } else {
                        // Show error message
                        alert(response.message);
                    }
                },
                error: function() {
                    // Show generic error
                    alert('<?php echo lang('connection_failed'); ?>');
                },
                complete: function() {
                    // Re-enable button
                    $('#testGoogleDriveConnection').prop('disabled', false);
                    $('#testGoogleDriveConnection').html('<?php echo lang('test_connection'); ?>');
                }
            });
        });
    });
</script>