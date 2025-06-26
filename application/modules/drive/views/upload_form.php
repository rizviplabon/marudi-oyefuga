<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File to Google Drive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upload-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .upload-btn {
            width: 100%;
            padding: 10px;
            font-weight: 500;
        }
        .progress {
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="upload-container bg-white">
            <h2 class="form-title">Upload File to Google Drive</h2>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <p><?php $account = $this->storage_model->get_googledrive_settings(); echo $account->private_key;  ?></p>
            <?php endif; ?>
            
            <form action="<?php echo site_url('drive/upload_form'); ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                <div class="mb-3">
                    <label for="fileInput" class="form-label">Select File</label>
                    <input class="form-control" type="file" id="fileInput" name="userfile" required>
                </div>
                
                <div class="mb-3">
                    <label for="fileName" class="form-label">Custom File Name (optional)</label>
                    <input type="text" class="form-control" id="fileName" name="custom_name" 
                           placeholder="Leave blank to use original name">
                </div>
                
                <button type="submit" class="btn btn-primary upload-btn">
                    <span id="uploadText">Upload to Google Drive</span>
                    <span id="uploadSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                </button>
                
                <div class="progress" id="progressBar">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function() {
            document.getElementById('uploadText').style.display = 'none';
            document.getElementById('uploadSpinner').style.display = 'inline-block';
            document.getElementById('progressBar').style.display = 'block';
            
            // Simulate progress (in real app, you'd use AJAX with actual progress)
            const progressBar = document.querySelector('.progress-bar');
            let progress = 0;
            const interval = setInterval(() => {
                progress += 5;
                progressBar.style.width = progress + '%';
                if (progress >= 95) clearInterval(interval);
            }, 200);
        });
    </script>
</body>
</html>