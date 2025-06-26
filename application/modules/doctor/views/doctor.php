<link href="common/extranal/css/doctor/doctor.css" rel="stylesheet">
 <div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"><?php echo lang('doctors'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item active"><?php echo lang('doctors'); ?></li>
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <div class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('doctors') ?></h4> 
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
                                <th><?php echo lang('doctor'); ?> <?php echo lang('id'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('email'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('department'); ?></th>
                                <th><?php echo lang('profile'); ?></th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
</div>
        <!-- page end-->
</div>
</div>
</div>
<!--main content end-->
<!--footer start-->






<!-- Add Doctor Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title">  <?php echo lang('add_new_doctor'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form role="form" action="doctor/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?> &ast; </label>
                        <input type="text" class="form-control" name="name"  value='' placeholder="" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?> &ast; </label>
                        <input type="text" class="form-control" name="email"  value='' placeholder="" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?> &ast; </label>
                        <input type="password" class="form-control" name="password"  placeholder="********" required="">
                    </div>
                    <div class="form-group col-md-6">
                                            <label class="col-form-label"><?php echo lang('country'); ?></label>
                                            <select class="form-control select2" name="country" id="country_select">
                                                <option value=""><?php echo lang('select_country'); ?></option>
                                                <?php foreach ($countries as $country): ?>
                                                <?php
        $selected = '';
        if (!empty($hospital->id) && $hospital->country == $country->id) {
            $selected = 'selected';
        }
        ?>
                                                <option value="<?php echo $country->id; ?>" <?php echo $selected; ?>>
                                                    <?php echo $country->country; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label"><?php echo lang('province'); ?></label>
                                            <select class="form-control select2" name="province" id="province_select"
                                                disabled>
                                                <option value=""><?php echo lang('select_province'); ?></option>
                                                <?php foreach ($provinces as $country): ?>
                                                <?php
        $selected = '';
        if (!empty($hospital->id) && $hospital->province == $country->id) {
            $selected = 'selected';
        }
        ?>
                                                <option value="<?php echo $country->id; ?>" <?php echo $selected; ?>>
                                                    <?php echo $country->province; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label"><?php echo lang('city'); ?></label>
                                            <select class="form-control select2" name="city" id="city_select" disabled>
                                                <option value="">Select City</option>
                                                <?php foreach ($cities as $country): ?>
                                                <?php
        $selected = '';
        if (!empty($hospital->id) && $hospital->city == $country->id) {
            $selected = 'selected';
        }
        ?>
                                                <option value="<?php echo $country->id; ?>" <?php echo $selected; ?>>
                                                    <?php echo $country->city; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?> &ast; </label>
                        <input type="text" class="form-control" name="address"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?> &ast; </label>
                        <input type="text" class="form-control" name="phone"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->id; ?>"> <?php echo $department->name; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('signature'); ?> &ast; </label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail img_class">
                                    <img src="" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Signature</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="signature"/>
                                    </span>
                                  
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                       
                    </div>
                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
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
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-md-12 profile">
                        <label for="exampleInputEmail1"><?php echo lang('profile'); ?></label>
                        <textarea class="form-control ckeditor" id="editor1" name="profile" value="" rows="50" cols="20"></textarea>
                        <!-- <input type="hidden" name="profile" id="profile" value=""> -->
                    </div>
                </div>
                <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Doctor Modal-->







<!-- Edit Doctor Modal-->
<div class="modal fade" id="myModal2"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">  <?php echo lang('edit_doctor'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <form role="form" id="editDoctorForm" class="clearfix" action="doctor/addNew" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?> &ast;</label>
                        <input type="text" class="form-control" name="name"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?> &ast;</label>
                        <input type="text" class="form-control" name="email"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password"  placeholder="********">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label"><?php echo lang('country'); ?></label>
                        <select class="form-control select2" name="country" id="country_select2">
                            <option value=""><?php echo lang('select_country'); ?></option>
                            <?php foreach ($countries as $country): ?>
                            <?php
                            $selected = '';
                            if (!empty($doctor->country) && $doctor->country == $country->id) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $country->id; ?>" <?php echo $selected; ?>>
                                <?php echo $country->country; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label"><?php echo lang('province'); ?></label>
                        <select class="form-control select2" name="province" id="province_select2" disabled>
                            <option value=""><?php echo lang('select_province'); ?></option>
                            <?php foreach ($provinces as $province): ?>
                            <?php
                            $selected = '';
                            if (!empty($doctor->province) && $doctor->province == $province->id) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $province->id; ?>" <?php echo $selected; ?>>
                                <?php echo $province->province; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label"><?php echo lang('city'); ?></label>
                        <select class="form-control select2" name="city" id="city_select2" disabled>
                            <option value=""><?php echo lang('select_city'); ?></option>
                            <?php foreach ($cities as $city): ?>
                            <?php
                            $selected = '';
                            if (!empty($doctor->city) && $doctor->city == $city->id) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?php echo $city->id; ?>" <?php echo $selected; ?>>
                                <?php echo $city->city; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?> &ast;</label>
                        <input type="text" class="form-control" name="address"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?> &ast;</label>
                        <input type="text" class="form-control" name="phone"  value='' placeholder="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single department" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->id; ?>" <?php
                                if (!empty($doctor->department)) {
                                    if ($department->id == $doctor->department) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $department->name; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group  col-md-6">
                        <label class="control-label"><?php echo lang('signature');?></label>
                        <div class="signature_class">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail img_class">
                                    <img src="" id="signature" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Signature</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="signature"/>
                                    </span>
                                    <button class="btn btn-danger" id="remove_button_doctor_signature"> <?php echo lang('remove');?></button>
                                    <!-- <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a> -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail img_class">
                                    <img src="" id="img" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                   
                    <div class="form-group col-md-12 profile1">
                        <label for="exampleInputEmail1"><?php echo lang('profile'); ?></label>
                        <textarea class="form-control ckeditor" id="editor3" name="profile" value="" rows="50" cols="20"></textarea>
                        <!-- <input type="hidden" name="profile" id="profile1" value=""> -->
                    </div>
                </div>
                    <input type="hidden" name="id" id="id_value" value=''>
                    <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Doctor Modal-->



<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">  <?php echo lang('doctor'); ?> <?php echo lang('info'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <form role="form" class="clearfix" action="doctor/addNew" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group last col-md-6">
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail img_class">
                                    <img src="" id="img1" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail img_url"></div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <div class="nameClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <div class="emailClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <div class="addressClass"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <div class="phoneClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <div class="departmentClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('profile'); ?></label>
                        <div class="profileClass"></div>
                    </div>

                </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>






<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>

<script src="common/extranal/js/doctor/doctor.js"></script>
<script>
    $(document).ready(function() {
    $('#country_select').change(function() {
        var countryId = $(this).val();
        var provinceSelect = $('#province_select');

        if (countryId) {
            // provinceSelect.prop('disabled', true);
            $.ajax({
                url: 'country/province/getProvincesByCountry',
                type: 'GET',
                data: {
                    country_id: countryId
                },
                dataType: 'json',
                success: function(response) {
                    provinceSelect.empty();
                    provinceSelect.append('<option value="">' + 'Select Province' +
                        '</option>');

                    $.each(response, function(key, value) {
                        provinceSelect.append('<option value="' + value.id + '">' +
                            value.province + '</option>');
                    });

                    provinceSelect.prop('disabled', false);
                },
                error: function() {
                    provinceSelect.prop('disabled', true);
                    toastr.error('Error loading provinces');
                }
            });
        } else {
            provinceSelect.empty();
            provinceSelect.append('<option value="">' + 'Select Province' + '</option>');
            provinceSelect.prop('disabled', true);
        }
    });

    $('#province_select').on('change', function() {
        var provinceId = $(this).val();
        if (provinceId) {
            $('#city_select').prop('disabled', false);
            $.ajax({
                url: 'country/getCityByProvinceIdByJason?id=' + provinceId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#city_select').empty().append(
                        '<option value="">Select City</option>');
                    if (response.cities) {
                        $.each(response.cities, function(key, value) {
                            $('#city_select').append('<option value="' + value.id +
                                '">' + value.city + '</option>');
                        });
                    }
                }
            });
        } else {
            $('#city_select').prop('disabled', true).empty().append(
                '<option value=""><?php echo lang('select_city'); ?></option>');
        }
    });
});
</script>