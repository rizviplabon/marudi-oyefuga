<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper rounded-0">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('notice'); ?></h4>
                                    &nbsp;&nbsp; &nbsp;&nbsp;
                &nbsp;&nbsp;
                <?php if ($this->ion_auth->in_group('admin')) {
                    if ($this->settings->dashboard_theme == 'main') { ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                <?php }
                } ?>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo lang('notice'); ?></li>
                                       
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <!-- page start-->
         <link href="common/extranal/css/notice/notice.css" rel="stylesheet">
        <section class="card">
        <div class="card-header table_header">
        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('notice'); ?></h4> 
                                        <div class="col-lg-4 no-print pull-right"> 
                                        <button type="button" class="btn btn-primary waves-effect waves-light w-xs" data-bs-toggle="modal"
                                                    data-bs-target="#myModal"> <i class="fa fa-plus-circle"></i> <?php echo lang('add_notice'); ?></button>
                                                    </div>
                                                    <?php }else{ ?>
                                                        
                                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('notice'); ?></h4> 
                                                        <?php } ?>

                                           
                                       
                                    </div>

            <div class="card-body">
            <div class="table-responsive adv-table">
                                            <table class="table mb-0" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('title'); ?></th>
                                <th> <?php echo lang('description'); ?></th>
                                <th> <?php echo lang('notice'); ?> <?php echo lang('for'); ?> </th>
                                <th> <?php echo lang('date'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <th> <?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach ($notices as $notice) { ?>
                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <tr class="">
                                <td> <?php echo $notice->title; ?></td>
                                <td> <?php echo $notice->description; ?></td>
                                <td class="center"><?php echo $notice->type; ?></td>
                                <td> <?php
                                    if (!empty($notice->date)) {
                                        echo date('d-m-Y', $notice->date);
                                    }
                                    ?>
                                </td>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <?php                 
        if($this->settings->dashboard_theme == 'main'){ ?>
                                        <td class="no-print">
                                            <div class="btn-group">
                                                <a class="hover-primary dropdown-toggle no-caret"
                                                    data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu">
                                                    
                                                    <a class="dropdown-item editbutton" data-toggle="modal" data-id="<?php echo $notice->id; ?>">Edit</a>
                                                    <a class="dropdown-item"
                                                        href="notice/delete?id=<?php echo $notice->id; ?>"
                                                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <?php }else{ ?>
                                    <td>
                                        <button type="button" class="btn btn-soft-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $notice->id; ?>"><i class="fa fa-edit"> <?php echo lang('edit'); ?></i></button>   
                                        <a class="btn btn-soft-danger btn-xs btn_width delete_button" href="notice/delete?id=<?php echo $notice->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> <?php echo lang('delete'); ?></i></a>
                                    </td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                        <?php }  elseif ($this->ion_auth->in_group(array('Patient'))) { 
                                if($notice->type == 'patient') {?>
                            <tr class="">
                                <td> <?php echo $notice->title; ?></td>
                                <td> <?php echo $notice->description; ?></td>
                                <td class="center"><?php echo $notice->type; ?></td>
                                <td> <?php
                                    if (!empty($notice->date)) {
                                        echo date('d-m-Y', $notice->date);
                                    }
                                    ?>
                                </td>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <td>
                                        <button type="button" class="btn btn-soft-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $notice->id; ?>"><i class="fa fa-edit"> <?php echo lang('edit'); ?></i></button>   
                                        <a class="btn btn-soft-danger btn-xs btn_width delete_button" href="notice/delete?id=<?php echo $notice->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> <?php echo lang('delete'); ?></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php } } else { 
                                if($notice->type == 'staff') { ?>
                                <tr class="">
                                <td> <?php echo $notice->title; ?></td>
                                <td> <?php echo $notice->description; ?></td>
                                <td class="center"><?php echo $notice->type; ?></td>
                                <td> <?php
                                    if (!empty($notice->date)) {
                                        echo date('d-m-Y', $notice->date);
                                    }
                                    ?>
                                </td>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <td>
                                        <button type="button" class="btn btn-soft-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $notice->id; ?>"><i class="fa fa-edit"> <?php echo lang('edit'); ?></i></button>   
                                        <a class="btn btn-soft-danger btn-xs btn_width delete_button" href="notice/delete?id=<?php echo $notice->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> <?php echo lang('delete'); ?></i></a>
                                    </td>
                                <?php } ?>
                            </tr>
                                <?php } } ?>
                            
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->




<!-- Add Notice Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add_notice') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            
            <div class="modal-body">
                <form role="form" action="notice/addNew" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?> &ast;</label>
                        <input type="text" class="form-control" name="title"  value='<?php
                        if (!empty($notice->name)) {
                            echo $notice->name;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('notice_for'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="patient" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'patient') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('patient'); ?></option>
                            <option value="staff" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'staff') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('staff'); ?></option>

                        </select>
                    </div>

                    <div class="form-group col-md-12 des">
                        <label class=""><?php echo lang('description'); ?> &ast;</label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10" required=""> </textarea>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &ast;</label>
                        <input type="text" class="form-control default-date-picker readonly" name="date"  value='' placeholder="" required="">
                    </div>


                    <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>


                    <!-- <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div> -->

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('edit_notice') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            
            <div class="modal-body">
                <form role="form" id="editNoticeForm" class="clearfix row" action="notice/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?> &ast;</label>
                        <input type="text" class="form-control" name="title"  value='<?php
                        if (!empty($notice->name)) {
                            echo $notice->name;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('notice_for'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="patient" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'patient') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('patient'); ?></option>
                            <option value="staff" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'staff') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('staff'); ?></option>

                        </select>
                    </div>  
                    <div class="form-group col-md-12 des">
                        <label class=""><?php echo lang('description'); ?> &ast;</label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor1" name="description" value="" rows="10" required=""> </textarea>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &ast;</label>
                        <input type="text" class="form-control default-date-picker" onkeypress="return false;" name="date"  value='' placeholder="" required="">
                    </div>
                    <input type="hidden" name="id" value='<?php
                    if (!empty($notice->id)) {
                        echo $notice->id;
                    }
                    ?>'>
                     <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/notice.js"></script>
