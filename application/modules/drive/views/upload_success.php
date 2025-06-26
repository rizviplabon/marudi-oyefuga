<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success-icon {
            font-size: 72px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .file-info {
            text-align: left;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .drive-link {
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-container bg-white">
            <div class="success-icon">✓</div>
            <h2>File Uploaded Successfully!</h2>
            <?php if ($storage_type == "drive"): ?>
    <p>File stored in Google Drive</p>
    <a href="https://drive.google.com/file/d/<?php echo $file_id; ?>/view" target="_blank">
        Download from Google Drive
    </a>
<?php else: ?>
    <p>File stored locally</p>
    <a href="<?php echo base_url('uploads/' . $unique_name); ?>" download>
        Download Local File
    </a>
<?php endif; ?>
            <div class="file-info">
                <p><strong>Original Name:</strong> <?php echo $original_name; ?></p>
                <p><strong>Stored As:</strong> <?php echo $unique_name; ?></p>
                <p><strong>Google Drive ID:</strong> <?php echo $file_id; ?></p>
            </div>
            
            <a href="https://drive.google.com/file/d/<?php echo $file_id; ?>/view" 
               class="btn btn-primary mb-3" target="_blank">
               Open in Google Drive
            </a>
            
            <div class="drive-link">
                <small>Direct link: </small><br>
                <code>https://drive.google.com/file/d/<?php echo $file_id; ?>/view</code>
            </div>
            
            <div class="mt-4">
                <a href="<?php echo site_url('drive/upload_form'); ?>" class="btn btn-outline-secondary">
                    Upload Another File
                </a>
            </div>
        </div>
    </div>
</body>
</html>