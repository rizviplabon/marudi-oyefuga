<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('holiday'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
                        &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item"><?php echo lang('schedule'); ?></li>
                                        <li class="breadcrumb-item active"><?php echo lang('holiday'); ?></li>
                                       
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <section class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('holiday'); ?></h4> 
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
                                <th> # </th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('date'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                    <th> <?php echo lang('options'); ?></th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>  
                      
                        <?php
                        $i = 0;
                        foreach ($holidays as $holiday) {
                            $i = $i + 1;
                            ?> 
                            <tr class="">
                                <td> <?php echo $i; ?></td>
                                <td> <?php echo $this->doctor_model->getDoctorById($holiday->doctor)->name; ?></td> 
                                <td> <?php echo date('d-m-Y', $holiday->date); ?></td> 
                                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                    <?php                 
        if($this->settings->dashboard_theme == 'main'){ ?>
                                        <td class="no-print">
                                            <div class="btn-group">
                                                <a class="hover-primary dropdown-toggle no-caret"
                                                    data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu">
                                                <a type="button" class="dropdown-item editbutton" data-toggle="modal" data-id="<?php echo $holiday->id; ?>"> <?php echo lang('edit'); ?></a>   
                                                    <a class="dropdown-item"
                                                    href="schedule/deleteHoliday?id=<?php echo $holiday->id; ?>&doctor=<?php echo $holiday->doctor; ?>&redirect=schedule/allHolidays" onclick="return confirm('Are you sure you want to delete this item?');"><?php echo lang('delete'); ?>
                                                        </a>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <?php }else{ ?>
                                    <td>
                                        <button type="button" class="btn btn-soft-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $holiday->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>   
                                        <a class="btn btn-soft-danger btn-xs btn_width delete_button" href="schedule/deleteHoliday?id=<?php echo $holiday->id; ?>&doctor=<?php echo $holiday->doctor; ?>&redirect=schedule/allHolidays" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"> </i> <?php echo lang('delete'); ?></a>
                                    </td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Holiday Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add'); ?> <?php echo lang('holiday'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
         
            <div class="modal-body">
                <form role="form" action="schedule/addHoliday" class="clearfix" method="post" enctype="multipart/form-data">
<div class="row">
                    <div class=" form-group col-md-6"> 
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?> &ast;</label>
                        <select class="form-control m-bot15" id="doctorchoose" name="doctor" value='' required="">

                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &ast;</label>
                        <input type="text" class="form-control default-date-picker" name="date"  value='' autocomplete="off" required="">
                    </div>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='schedule/allHolidays'>

                    <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>
</div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Holiday Modal-->





<!-- Edit Holiday Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('edit'); ?> <?php echo lang('holiday'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
          
            <div class="modal-body">
                <form role="form" id="editHolidayForm" class="clearfix" action="schedule/addHoliday" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?> &ast;</label>
                        <select class="form-control m-bot15" id="doctorchoose1" name="doctor" value='' required="">


                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &ast;</label>
                        <input type="text" class="form-control default-date-picker" name="date"  value='' autocomplete="off" required="">
                    </div>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='schedule/allHolidays'>

                    <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>
                                                            </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Holiday Modal-->



<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var select_doctor = "<?php echo lang('select_doctor'); ?>";</script>
<script type="text/javascript">var select_patient = "<?php echo lang('select_patient'); ?>";</script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>

<script src="common/extranal/js/schedule/all_holidays.js"></script>