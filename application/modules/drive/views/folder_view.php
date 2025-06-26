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
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo site_url('drive/create_folder'); ?>">Create Folder</a>
                </li>
                <li class="nav-item">
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
                <h4 class="mb-0">Create Google Drive Folder</h4>
            </div>
            <div class="card-body">
                <?php echo form_open('drive/create_folder'); ?>
                    <div class="form-group">
                        <label for="folder_name">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" name="folder_name" placeholder="Enter folder name" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent Folder ID (Optional)</label>
                        <input type="text" class="form-control" id="parent_id" name="parent_id" placeholder="Enter parent folder ID">
                        <small class="form-text text-muted">Leave blank to create folder in the root directory</small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-folder-plus mr-2"></i> Create Folder
                    </button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Instructions</h4>
            </div>
            <div class="card-body">
                <p>To create a new folder in Google Drive:</p>
                <ol>
                    <li>Enter a name for the new folder.</li>
                    <li>Optionally, specify a parent folder ID if you want to create the folder inside another folder.</li>
                    <li>Click the "Create Folder" button.</li>
                </ol>
                <p>After creating the folder, you can upload files to it by specifying its ID in the upload form.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>