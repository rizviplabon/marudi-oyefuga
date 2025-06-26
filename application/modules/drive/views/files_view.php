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
        .file-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .file-item {
            transition: all 0.2s ease;
        }
        .file-item:hover {
            background-color: #f1f1f1;
        }
        .alert {
            margin-bottom: 20px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }
        .empty-state i {
            font-size: 48px;
            color: #ccc;
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
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo site_url('drive/list_files'); ?>">Files</a>
                </li>
                <li class="nav-item">
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
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Google Drive Files</h4>
                <a href="<?php echo site_url('drive'); ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload New File
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($files)): ?>
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h4>No files found</h4>
                        <p>Upload files to see them listed here.</p>
                        <a href="<?php echo site_url('drive'); ?>" class="btn btn-primary">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Upload File
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $file): ?>
                                    <tr class="file-item">
                                        <td>
                                            <i class="fas <?php echo get_file_icon($file->getMimeType()); ?> file-icon"></i>
                                            <?php echo $file->getName(); ?>
                                        </td>
                                        <td><?php echo $file->getMimeType(); ?></td>
                                        <td>
                                            <?php 
                                            if ($file->getSize()) {
                                                echo format_file_size($file->getSize());
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo format_drive_date($file->getCreatedTime()); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <?php if ($file->getWebViewLink()): ?>
                                                    <a href="<?php echo $file->getWebViewLink(); ?>" target="_blank" class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <a href="<?php echo site_url('drive/download/' . $file->getId()); ?>" class="btn btn-sm btn-success" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                
                                                <a href="<?php echo site_url('drive/delete/' . $file->getId()); ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this file?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>