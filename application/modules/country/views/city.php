<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">City</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item active">City</li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        
        <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header table_header">
                                    <h4 class="card-title mb-0 col-lg-8">List of Cities</h4> 
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
                                                    <th><?php echo lang('city'); ?></th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($cities as $city) { ?>
                                                    <tr class="">
                                                        <td><?php echo $this->country_model->getCountryById($city->country)->country; ?></td>
                                                        <td><?php echo $city->province_name; ?></td>
                                                        <td><?php echo $city->city; ?></td>
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light editbutton" 
                                                                data-bs-toggle="modal" data-bs-target="#myModal2" 
                                                                title="<?php echo lang('edit'); ?>" 
                                                                data-id="<?php echo $city->id; ?>"><i class="fa fa-edit"></i></button>
                                                            <a class="btn btn-soft-danger waves-effect waves-light delete_button" title="<?php echo lang('delete'); ?>" href="country/city/delete?id=<?php echo $city->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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
                <h5 class="modal-title">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form role="form" action="country/city/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="country"><?php echo lang('country'); ?> &ast;</label>
                        <select class="form-control select2" name="country" id="country_select" value=''>
                                        <option value=""><?php echo lang('select_country'); ?></option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                                        <?php } ?>
                                    </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="province"><?php echo lang('province'); ?> &ast;</label>
                        <select class="form-control select2" name="province" id="province_select" value=''>
                                        <option value=""><?php echo lang('select_province'); ?></option>
                                    </select>
                    </div>
                    <div class="form-group">
                        <label for="name"><?php echo lang('city'); ?> &ast;</label>
                        <input type="text" class="form-control" name="city" value='' required>
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
                <h5 class="modal-title">Edit City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" id="editCityForm" class="clearfix" action="country/city/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="country"><?php echo lang('country'); ?></label>
                        <select class="form-control select2" name="country" id="edit_country_select" required>
                            <option value=""><?php echo lang('select_country'); ?></option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="province"><?php echo lang('province'); ?> &ast;</label>
                        <select class="form-control select2" name="province" id="edit_province_select">
                            <option value=""><?php echo lang('select_province'); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="name"><?php echo lang('city'); ?></label>
                        <input type="text" class="form-control" id="city" name="city" value='' required>
                    </div>
                    
                    <input type="hidden" id="id" name="id" value=''>
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
<script src="common/extranal/js/country/city.js"></script>