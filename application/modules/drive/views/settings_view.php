<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar {
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .alert {
            margin-bottom: 20px;
        }
        .form-group.required .control-label:after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
        .credentials-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="<?php echo site_url('drive'); ?>">Google Drive Integration</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('drive'); ?>">Upload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('drive/list_files'); ?>">Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('drive/create_folder'); ?>">Create Folder</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo site_url('drive/settings'); ?>">Settings</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Google Drive Settings</h4>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart('drive/save_settings'); ?>
                    <div class="form-group required">
                        <label for="client_id" class="control-label">Client ID</label>
                        <input type="text" class="form-control" id="client_id" name="client_id" value="<?php echo isset($settings) ? $settings->client_id : ''; ?>" required>
                    </div>
                    <div class="form-group required">
                        <label for="client_secret" class="control-label">Client Secret</label>
                        <input type="text" class="form-control" id="client_secret" name="client_secret" value="<?php echo isset($settings) ? $settings->client_secret : ''; ?>" required>
                    </div>
                    <div class="form-group required">
                        <label for="project_id" class="control-label">Project ID</label>
                        <input type="text" class="form-control" id="project_id" name="project_id" value="<?php echo isset($settings) ? $settings->project_id : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="credentials_file">Service Account Credentials JSON File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="credentials_file" name="credentials_file">
                            <label class="custom-file-label" for="credentials_file">Choose file</label>
                        </div>
                        <small class="form-text text-muted">Upload your Google service account credentials JSON file</small>
                    </div>
                    
                    <?php if (isset($settings) && !empty($settings->credentials_json)): ?>
                    <div class="credentials-info">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Current Credentials</h5>
                            <span class="badge badge-success">Configured</span>
                        </div>
                        <p class="mb-0">Service account credentials are configured. Upload a new file to replace them.</p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="root_folder_id">Root Folder ID (Optional)</label>
                        <input type="text" class="form-control" id="root_folder_id" name="root_folder_id" value="<?php echo isset($settings) ? $settings->root_folder_id : ''; ?>">
                        <small class="form-text text-muted">Specify a folder ID to use as the root folder for all uploads</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Instructions</h4>
            </div>
            <div class="card-body">
                <h5>How to set up Google Drive API:</h5>
                <ol>
                    <li>Go to the <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                    <li>Create a new project or select an existing one</li>
                    <li>Enable the Google Drive API for your project</li>
                    <li>Create a service account and download the JSON credentials file</li>
                    <li>Upload the credentials file using the form above</li>
                    <li>Share any Google Drive folders you want to access with the service account email</li>
                </ol>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Keep your credentials secure and never share them publicly.
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Display filename when file is selected
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
</body>
</html>