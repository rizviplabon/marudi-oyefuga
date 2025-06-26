<div class="main-content">
    <div class="page-content">
        <div class="container-fluid content-wrapper">
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
                                <li class="breadcrumb-item active"><?php echo lang('settings'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section class="card">
                        <div class="card-header table_header">
                            <h4 class="card-title mb-0 col-lg-8"><?php echo lang('storage_settings'); ?></h4>
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
                                        <p><?php echo lang('choose_your_default_storage_provider'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <form action="<?php echo base_url('storage/save_api_settings'); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title"><?php echo lang('default_storage_provider'); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label><?php echo lang('select_default_provider'); ?></label>
                                                    <div class="mt-2">
                                                        <?php foreach ($providers as $provider): ?>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="default_provider" 
                                                                    id="provider_<?php echo $provider->name; ?>" 
                                                                    value="<?php echo $provider->name; ?>" 
                                                                    <?php echo ($default_provider == $provider->name) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="provider_<?php echo $provider->name; ?>">
                                                                    <?php echo $provider->display_name; ?>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title"><?php echo lang('storage_providers'); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive adv-table">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo lang('provider'); ?></th>
                                                                <th><?php echo lang('description'); ?></th>
                                                                <th><?php echo lang('status'); ?></th>
                                                                <th><?php echo lang('default'); ?></th>
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
                                                                            <?php if ($provider->is_active): ?>
                                                                                <span class="badge bg-success"><?php echo lang('active'); ?></span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger"><?php echo lang('inactive'); ?></span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($provider->is_default): ?>
                                                                                <span class="badge bg-primary"><?php echo lang('default'); ?></span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?php echo base_url('storage/' . $provider->name . '/settings'); ?>" class="btn btn-info btn-xs">
                                                                                <i class="fa fa-cog"></i> <?php echo lang('settings'); ?>
                                                                            </a>
                                                                            <?php if ($provider->is_active): ?>
                                                                                <a href="<?php echo base_url('storage/disable_provider/' . $provider->name); ?>" class="btn btn-warning btn-xs">
                                                                                    <i class="fa fa-times-circle"></i> <?php echo lang('disable'); ?>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                <a href="<?php echo base_url('storage/enable_provider/' . $provider->name); ?>" class="btn btn-success btn-xs">
                                                                                    <i class="fa fa-check-circle"></i> <?php echo lang('enable'); ?>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                            <?php if (!$provider->is_default): ?>
                                                                                <a href="<?php echo base_url('storage/set_default_provider/' . $provider->name); ?>" class="btn btn-primary btn-xs">
                                                                                    <i class="fa fa-star"></i> <?php echo lang('set_as_default'); ?>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4" id="googledrive_settings" style="<?php echo ($default_provider == 'googledrive') ? '' : 'display: none;'; ?>">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title"><?php echo lang('google_drive_settings'); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="project_id"><?php echo lang('project_id'); ?> <span class="text-danger">*</span></label>
                                                            <input type="text" name="project_id" id="project_id" class="form-control" value="<?php echo $googledrive_settings ? $googledrive_settings->project_id : ''; ?>">
                                                        </div>
                                                        
                                                        <div class="form-group mt-3">
                                                            <label for="client_id"><?php echo lang('client_id'); ?> <span class="text-danger">*</span></label>
                                                            <input type="text" name="client_id" id="client_id" class="form-control" value="<?php echo $googledrive_settings ? $googledrive_settings->client_id : ''; ?>">
                                                        </div>
                                                        
                                                        <div class="form-group mt-3">
                                                            <label for="client_email"><?php echo lang('client_email'); ?> <span class="text-danger">*</span></label>
                                                            <input type="email" name="client_email" id="client_email" class="form-control" value="<?php echo $googledrive_settings ? $googledrive_settings->client_email : ''; ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="private_key_id"><?php echo lang('private_key_id'); ?> <span class="text-danger">*</span></label>
                                                            <input type="text" name="private_key_id" id="private_key_id" class="form-control" value="<?php echo $googledrive_settings ? $googledrive_settings->private_key_id : ''; ?>">
                                                        </div>
                                                        
                                                        <div class="form-group mt-3">
                                                            <label for="private_key"><?php echo lang('private_key'); ?> <span class="text-danger">*</span></label>
                                                            <textarea name="private_key" id="private_key" class="form-control" rows="5"><?php echo $googledrive_settings ? $googledrive_settings->private_key : ''; ?></textarea>
                                                            <small class="text-muted"><?php echo lang('paste_your_private_key_here_including_begin_and_end_tags'); ?></small>
                                                        </div>
                                                        
                                                        <div class="form-group mt-3">
                                                            <label for="default_folder_id"><?php echo lang('default_folder_id'); ?></label>
                                                            <input type="text" name="default_folder_id" id="default_folder_id" class="form-control" value="<?php echo $googledrive_settings ? $googledrive_settings->default_folder_id : ''; ?>">
                                                            <small class="text-muted"><?php echo lang('optional_google_drive_folder_id_where_all_files_will_be_stored'); ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn btn-primary"><?php echo lang('save_settings'); ?></button>
                                        <?php if ($default_provider == 'googledrive' && $googledrive_settings): ?>
                                            <a href="<?php echo base_url('storage/googledrive/test_connection'); ?>" class="btn btn-info ms-2"><?php echo lang('test_connection'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
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
                                            <div class="card">
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
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <section class="card">
                        <div class="card-header table_header">
                            <h4 class="card-title mb-0"><?php echo lang('how_to_setup_google_drive_integration'); ?></h4>
                        </div>
                        <div class="card-body">
                            <ol>
                                <li><?php echo lang('go_to_google_cloud_console'); ?> <a href="https://console.cloud.google.com/" target="_blank">https://console.cloud.google.com/</a></li>
                                <li><?php echo lang('create_a_new_project_or_select_an_existing_one'); ?></li>
                                <li><?php echo lang('enable_google_drive_api_for_your_project'); ?></li>
                                <li><?php echo lang('create_a_service_account'); ?></li>
                                <li><?php echo lang('download_the_json_key_file'); ?></li>
                                <li><?php echo lang('copy_the_details_from_the_json_file_to_the_form_above'); ?></li>
                                <li><?php echo lang('optionally_create_a_folder_in_your_google_drive_and_copy_its_id_from_the_url'); ?></li>
                            </ol>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show/hide Google Drive settings based on provider selection
        $('input[name="default_provider"]').change(function() {
            if ($(this).val() === 'googledrive') {
                $('#googledrive_settings').show();
            } else {
                $('#googledrive_settings').hide();
            }
        });
    });
</script> 