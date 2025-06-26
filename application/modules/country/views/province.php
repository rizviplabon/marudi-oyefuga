<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Province</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item active">Province</li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        
        <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header table_header">
                                    <h4 class="card-title mb-0 col-lg-8">List of Provinces</h4> 
                                        <div class="col-lg-4 no-print pull-right"> 
                                        <button type="button" class="btn btn-primary waves-effect waves-light w-xs" data-bs-toggle="modal"
                                                    data-bs-target="#myModal"><i class="fa fa-plus-circle"></i> <?php echo lang('add_new'); ?></button>
                                        </div>
                                    </div>
                                    <div class="card-body">  
                                        <div class="table-responsive adv-table">
                                            <table class="table mb-0" id="editable-sample">
        
                                                <thead>
                                                <tr>
                                                    <th><?php echo lang('country'); ?></th>
                                                    <th><?php echo lang('province'); ?></th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($provinces as $province) { ?>
                                                    <tr class="">
                                                        <td><?php echo $province->country_name; ?></td>
                                                        <td><?php echo $province->province; ?></td>
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $province->id; ?>"><i class="fa fa-edit"></i> </button>   
                                                            <a class="btn btn-soft-danger waves-effect waves-light delete_button" title="<?php echo lang('delete'); ?>" href="province/delete?id=<?php echo $province->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
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

<!-- Add Province Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Province</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form role="form" action="country/province/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="country"><?php echo lang('country'); ?> &ast;</label>
                        <select class="form-control" name="country" required>
                            <option value=""><?php echo lang('select_country'); ?></option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name"><?php echo lang('province'); ?> &ast;</label>
                        <input type="text" class="form-control" name="province" value='' required>
                    </div>
                    
                    <input type="hidden" name="id" value=''>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Province Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Province</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" id="provinceEditForm" class="clearfix" action="country/province/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="country"><?php echo lang('country'); ?></label>
                        <select class="form-control" name="country" required>
                            <option value=""><?php echo lang('select_country'); ?></option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="name"><?php echo lang('province'); ?></label>
                        <input type="text" class="form-control" name="province" value='' required>
                    </div>
                    
                    <input type="hidden" name="id" value=''>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/country/province.js"></script>