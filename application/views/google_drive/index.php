<!--
Google Drive File Manager View
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/css/bootstrap-reset.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/css/style-responsive.css">
    <style>
        .file-item {
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .file-icon {
            font-size: 36px;
            text-align: center;
        }
        .file-actions {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<section id="container">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <?php include APPPATH . 'views/include/sidebar.php'; ?>
    
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <h3><?php echo $title; ?></h3>
                            <?php if (isset($module) && isset($reference_id)): ?>
                                <p>Module: <?php echo $module; ?> | Reference ID: <?php echo $reference_id; ?></p>
                            <?php endif; ?>
                        </header>
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Upload Form -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4>Upload to Google Drive</h4>
                                        </div>
                                        <div class="panel-body">
                                            <?php echo form_open_multipart('GoogleDriveFile/upload', array('class' => 'form-horizontal')); ?>
                                                
                                                <?php if (isset($module) && isset($reference_id)): ?>
                                                    <input type="hidden" name="module" value="<?php echo $module; ?>">
                                                    <input type="hidden" name="reference_id" value="<?php echo $reference_id; ?>">
                                                <?php else: ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Module</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="module" class="form-control" placeholder="Module Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Reference ID</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="reference_id" class="form-control" placeholder="Reference ID">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">File</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" name="file" class="form-control">
                                                        <span class="help-block">Max size: 20MB</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-primary">Upload to Google Drive</button>
                                                    </div>
                                                </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Files List -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Files (<?php echo count($files); ?>)</h4>
                                    
                                    <?php if (empty($files)): ?>
                                        <div class="alert alert-info">No files found.</div>
                                    <?php else: ?>
                                        <div class="row">
                                            <?php foreach ($files as $file): ?>
                                                <div class="col-md-3">
                                                    <div class="file-item">
                                                        <div class="file-icon">
                                                            <?php
                                                            $ext = pathinfo($file->original_filename, PATHINFO_EXTENSION);
                                                            switch(strtolower($ext)) {
                                                                case 'pdf':
                                                                    echo '<i class="fa fa-file-pdf-o text-danger"></i>';
                                                                    break;
                                                                case 'doc':
                                                                case 'docx':
                                                                    echo '<i class="fa fa-file-word-o text-primary"></i>';
                                                                    break;
                                                                case 'xls':
                                                                case 'xlsx':
                                                                    echo '<i class="fa fa-file-excel-o text-success"></i>';
                                                                    break;
                                                                case 'jpg':
                                                                case 'jpeg':
                                                                case 'png':
                                                                case 'gif':
                                                                    echo '<i class="fa fa-file-image-o text-warning"></i>';
                                                                    break;
                                                                case 'zip':
                                                                    echo '<i class="fa fa-file-archive-o text-muted"></i>';
                                                                    break;
                                                                default:
                                                                    echo '<i class="fa fa-file-o"></i>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="text-center">
                                                            <h5 title="<?php echo $file->original_filename; ?>"><?php echo (strlen($file->original_filename) > 20) ? substr($file->original_filename, 0, 17) . '...' : $file->original_filename; ?></h5>
                                                            <p class="text-muted small">
                                                                Size: <?php echo round($file->file_size / 1024, 2); ?> KB<br>
                                                                <?php echo date('M d, Y', strtotime($file->created_at)); ?>
                                                            </p>
                                                            <div class="file-actions">
                                                                <a href="<?php echo site_url('GoogleDriveFile/view/' . $file->id); ?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-eye"></i> View</a>
                                                                <a href="<?php echo site_url('GoogleDriveFile/download/' . $file->id); ?>" class="btn btn-xs btn-success"><i class="fa fa-download"></i> Download</a>
                                                                <a href="<?php echo site_url('GoogleDriveFile/delete/' . $file->id . (isset($module) && isset($reference_id) ? "?module={$module}&reference_id={$reference_id}" : '')); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this file?');"><i class="fa fa-trash"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    
    <?php include APPPATH . 'views/include/footer.php'; ?>
</section>

<script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/common-scripts.js"></script>

</body>
</html> 