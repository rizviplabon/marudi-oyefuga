<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper rounded-0">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">File Upload</h4>
                                    &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                       
                                        <li class="breadcrumb-item active"><?php echo lang('manage_profile'); ?></li>
                                        
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->

        <div class="col-md-8 row">
        <div class="card">
                                <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-12"><?php echo lang('manage_profile'); ?></h4> 
                                        
                                    </div>
               
                <style type="text/css">
                    .img_thumb,
                    .img_class {
                        height: 150px;
                        width: 150px;
                    }
                </style>
                <div class="card-body">
                <div class="table-responsive adv-table">
                        <div class="clearfix">
                            <?php echo validation_errors(); ?>
                           
                                <form role="form" action="storage/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo lang('name'); ?> &ast;</label>
                                        <input type="text" class="form-control" name="title" value='' placeholder="" required="">
                                    </div>

                                    
                                    
                                    
                                       
                                        <div class="form-group ">
                                            <label class="control-label">Image Upload</label>
                                            <div class="">

                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail img_class">
                                                        <img src="" id="img" alt="" />

                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail img_thumb"></div>
                                                    <div>
                                                        <span class="btn btn-white btn-file">
                                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                            <input type="file" class="default" name="file" />
                                                        </span>
                                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                   
                                   
                                    <div class="form-group pull-right" style="margin-top: 10px;">
                                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                                    </div>
                                </form>
                         
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h4 class="mb-3"><?php echo lang('uploaded_files'); ?></h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo lang('id'); ?></th>
                                                        <th><?php echo lang('title'); ?></th>
                                                        <th><?php echo lang('file'); ?></th>
                                                        <th><?php echo lang('date'); ?></th>
                                                        <th><?php echo lang('actions'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($files)): ?>
                                                        <?php foreach ($files as $file): ?>
                                                            <tr>
                                                                <td><?php echo $file->id; ?></td>
                                                                <td><?php echo $file->title; ?></td>
                                                                <td>
                                                                    <a href="<?php echo base_url('uploads/' . $file->file); ?>" target="_blank">
                                                                        <?php echo $file->file; ?>
                                                                    </a>
                                                                </td>
                                                                <td><?php echo date('Y-m-d H:i', strtotime($file->created_at)); ?></td>
                                                                <td>
                                                                    <a href="<?php echo base_url('uploads/' . $file->file); ?>" class="btn btn-info btn-xs" download>
                                                                        <i class="fa fa-download"></i> <?php echo lang('download'); ?>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center"><?php echo lang('no_files_found'); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->

<script src="common/js/codearistos.min.js"></script>
<script src="common/extranal/js/profile.js"></script>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?php echo lang('file_uploads'); ?></h4>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFileModal">
                <i class="fa fa-plus"></i> <?php echo lang('add_new'); ?>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="fileTable">
                <thead>
                    <tr>
                        <th><?php echo lang('id'); ?></th>
                        <th><?php echo lang('title'); ?></th>
                        <th><?php echo lang('file'); ?></th>
                        <th><?php echo lang('options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) { ?>
                        <tr>
                            <td><?php echo $file->id; ?></td>
                            <td><?php echo $file->title; ?></td>
                            <td>
                                <a href="<?php echo base_url('uploads/' . $file->file); ?>" target="_blank">
                                    <?php echo $file->file; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url('storage/downloadFile/' . $file->id); ?>" class="btn btn-sm btn-info">
                                    <i class="fa fa-download"></i> <?php echo lang('download'); ?>
                                </a>
                                <a href="<?php echo base_url('storage/deleteFile/' . $file->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?php echo lang('are_you_sure'); ?>');">
                                    <i class="fa fa-trash"></i> <?php echo lang('delete'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add File Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFileModalLabel"><?php echo lang('add_new_file'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('storage/addNew'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title"><?php echo lang('title'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="file"><?php echo lang('file'); ?> <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#fileTable').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>