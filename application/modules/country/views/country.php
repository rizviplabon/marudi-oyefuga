<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"><?php echo lang('country'); ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo lang('country'); ?></li>
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        
        <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header table_header">
                                    <h4 class="card-title mb-0 col-lg-8">List of Countries</h4> 
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
                                                    <th><?php echo lang('country') ?> Name</th>
                                                   
                                                    <th class="no-print"><?php echo lang('options') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($countries as $country) { ?>
                                                    <tr class="">
                                                        <td><?php echo $country->country; ?></td>
                                                       
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $country->id; ?>"><i class="fa fa-edit"></i> </button>   
                                                            <a class="btn btn-soft-danger waves-effect waves-light delete_button" title="<?php echo lang('delete'); ?>" href="country/delete?id=<?php echo $country->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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

<!-- Add Country Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form role="form" action="country/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name"><?php echo lang('country') ?> <?php echo lang('name') ?> &ast;</label>
                        <input type="text" class="form-control" name="country" value='' required>
                    </div>
                    
                    <input type="hidden" name="id" value=''>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Country Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Edit Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" id="countryEditForm" class="clearfix" action="country/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label for="name"><?php echo lang('country') ?> <?php echo lang('name') ?></label>
                        <input type="text" class="form-control" name="country" value='' required>
                    </div>
                    
                    <input type="hidden" name="id" value=''>
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
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/country.js"></script>
