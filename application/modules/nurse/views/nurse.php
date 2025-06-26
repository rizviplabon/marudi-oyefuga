<div class="main-content content-wrapper">
    <div class="page-content">
        <link href="common/extranal/css/nurse.css" rel="stylesheet">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 content-header">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><?php echo lang('nurse'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
                        &nbsp;&nbsp;
                        <?php if ($this->ion_auth->in_group('admin')) {
                            if ($this->settings->dashboard_theme == 'main') { ?>
                                <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }
                        } ?>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('human_resources'); ?></a></li>
                                <li class="breadcrumb-item active"><?php echo lang('nurse'); ?></li>

                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header table_header">
                    <h4 class="card-title mb-0 col-lg-8"><?php echo lang('nurse'); ?></h4>
                    <div class="col-lg-4 no-print pull-right">
                        <button type="button" class="btn btn-info waves-effect waves-light w-xs" data-bs-toggle="modal"
                            data-bs-target="#myModal"><i class="fa fa-plus-circle"></i> <?php echo lang('add_nurse'); ?></button>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive adv-table">
                        <table class="table mb-0" id="editable-sample">
                            <thead>
                                <tr>
                                    <th><?php echo lang('image'); ?></th>
                                    <th><?php echo lang('name'); ?></th>
                                    <th><?php echo lang('email'); ?></th>
                                    <th><?php echo lang('address'); ?></th>
                                    <th><?php echo lang('phone'); ?></th>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>



                                <?php foreach ($nurses as $nurse) { ?>
                                    <tr class="">
                                        <td class="img_td"><img class="img_url1" src="<?php echo $nurse->img_url; ?>"></td>
                                        <td> <?php echo $nurse->name; ?></td>
                                        <td><?php echo $nurse->email; ?></td>
                                        <td class="center"><?php echo $nurse->address; ?></td>
                                        <td><?php echo $nurse->phone; ?></td>
                                        <?php
                                        if ($this->settings->dashboard_theme == 'main') { ?>
                                            <td class="no-print">
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item editbutton" data-toggle="modal"
                                                            data-id="<?php echo $nurse->id; ?>">Edit</a>
                                                        <a class="dropdown-item"
                                                            href="nurse/delete?id=<?php echo $nurse->id; ?>"
                                                            onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php } else { ?>
                                            <td class="no-print">
                                                <button type="button" class="btn btn-info  waves-effect waves-light btn-xs editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $nurse->id; ?>"><i class="fa fa-edit"> </i></button>
                                                <a class="btn btn-info btn-xs  waves-effect waves-light delete_button" title="<?php echo lang('delete'); ?>" href="nurse/delete?id=<?php echo $nurse->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"> </i></a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"> <?php echo lang('add_nurse'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="nurse/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?> &#42;</label>
                        <input type="text" class="form-control" name="name" value='' required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?> &#42;</label>
                        <input type="email" class="form-control" name="email" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?> &#42;</label>
                        <input type="password" class="form-control" name="password" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?> &#42;</label>
                        <input type="text" class="form-control" name="address" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?> &#42;</label>
                        <input type="number" class="form-control" name="phone" value='' placeholder="" required="">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('signature'); ?> &ast; </label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail img_class">
                                        <img src="" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                    <div>
                                        <span class="btn btn-soft-primary btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Signature</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" name="signature" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group last col-md-6">
                            <label class="control-label"><?php echo lang('image'); ?> </label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail img_class">
                                        <img src="" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                    <div>
                                        <span class="btn btn-soft-primary btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" name="img_url" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('profile'); ?> &ast; </label>
                        <textarea class="form-control ckeditor" id="editor1" name="profile" value="" rows="50" cols="20"></textarea>
                        <!-- <input type="hidden" name="profile" id="profile" value=""> -->

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"> <?php echo lang('edit_nurse'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" id="editNurseForm" class="clearfix" action="nurse/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?> &#42;</label>
                        <input type="text" class="form-control" name="name" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?> &#42;</label>
                        <input type="email" class="form-control" name="email" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" placeholder="********">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?> &#42;</label>
                        <input type="text" class="form-control" name="address" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?> &#42;</label>
                        <input type="number" class="form-control" name="phone" value='' placeholder="" required="">
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label class="control-label"><?php echo lang('signature'); ?></label>
                            <div class="signature_class">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail img_class">
                                        <img src="" id="signature" alt="" />
                                    </div>
                                    <style>
                                        #img_url1 img {
                                            width: 201px !important;
                                            height: 150px !important;
                                        }
                                    </style>
                                    <div class="fileupload-preview fileupload-exists thumbnail img_url" id="img_url1"></div>
                                    <div>
                                        <span class="btn btn-soft-primary btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Signature</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" name="signature" />
                                        </span>
                                        <button class="btn btn-danger" id="remove_button_nurse_signature"> <?php echo lang('remove'); ?></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group last col-md-6">
                            <label class="control-label"><?php echo lang('image'); ?></label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail img_class">
                                        <img src="" id="img" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                    <div>
                                        <span class="btn btn-soft-primary btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" name="img_url" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('profile'); ?></label>
                        <textarea class="form-control ckeditor" id="editor3" name="profile" value="" rows="50" cols="20"></textarea>
                        <!-- <input type="hidden" name="profile" id="profile1" value=""> -->
                    </div>

                    <input type="hidden" name="id" id="id_value" value=''>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    var language = "<?php echo $this->language; ?>";
</script>
<script src="common/extranal/js/nurse.js"></script>