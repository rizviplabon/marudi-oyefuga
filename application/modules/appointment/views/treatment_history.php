<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
      <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('treatment_history'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item"><?php echo lang('appointment'); ?></li>
                                        <li class="breadcrumb-item active"><?php echo lang('treatment_history'); ?></li>
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <!-- <section class="panel"> -->
        <div class="card">
                                <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-12"><?php echo lang('treatment_history'); ?></h4> 
                                        
                                    </div>
          
            <!-- <div class="space15"></div> -->
            <div class="col-md-12">
                <div class="col-md-7 card-body">
                    <section>
                        <form role="form" class="f_report" action="appointment/treatmentReport" method="post" enctype="multipart/form-data">
                            <div class="form-group row">


                                <div class="col-md-6">
                                    <div class="input-group">
                                     <input type="text" class="form-control dpd1" name="date_from" autocomplete="off" value="<?php
                                                                                                                                if (!empty($from)) {
                                                                                                                                    echo $from;
                                                                                                                                }
                                                                                                                                ?>" placeholder=" <?php echo lang('date_from'); ?>">
                                                    <div class="input-group-text">@</div>
                                                    <input type="text" class="form-control dpd2" name="date_to" autocomplete="off" value="<?php
                                                                                                                                if (!empty($to)) {
                                                                                                                                    echo $to;
                                                                                                                                }
                                                                                                                                ?>" placeholder=" <?php echo lang('date_to'); ?>">
                                                  </div>
                                   
                                </div>
                                <div class="col-md-5 no-print">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"> <?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <div class="col-md-5">
                </div>
            </div>



            <div class="card-body">
           
                                        <div class="table-responsive adv-table">
                                        
               
                    
                    
                    <table class="table mb-0" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('doctor_id'); ?></th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('number_of_patient_treated'); ?></th>
                                <th class="no-print"> <?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>



                            <?php foreach ($doctors as $doctor) { ?>

                                <tr class="">
                                    <td><?php echo $doctor->id; ?></td>
                                    <td><?php echo $doctor->name; ?></td>
                                    <td>
                                        <?php
                                        foreach ($appointments as $appointment) {
                                            if ($appointment->doctor == $doctor->id) {

                                                $appointment_number[] = 1;
                                            }
                                        }
                                        if (!empty($appointment_number)) {
                                            $appointment_total = array_sum($appointment_number);
                                            echo $appointment_total;
                                        } else {
                                            $appointment_total = 0;
                                            echo $appointment_total;
                                        }
                                        ?>
                                    </td>
                                    <?php                 
        if($this->settings->dashboard_theme == 'main'){ ?>
                                        <td class="no-print">
                                            <div class="btn-group">
                                                <a class="hover-primary dropdown-toggle no-caret"
                                                    data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu">
                                                   
                                                   
                                                    <a class="dropdown-item"
                                                        href="appointment/getAppointmentByDoctorId?id=<?php echo $doctor->id; ?>"
                                                        ><?php echo lang('details'); ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <?php }else{ ?>
                                    <td class="no-print"> <a class="btn btn-info btn-xs btn_width add_payment_button" style="width: 100px;" href="appointment/getAppointmentByDoctorId?id=<?php echo $doctor->id; ?>"><i class="fa fa-money"></i> <?php echo lang('details'); ?></a></td>
<?php } ?>

                                </tr>
                                <?php $appointment_number = NULL; ?>
                                <?php $appointment_total = NULL; ?>
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
<!--main content end-->
<!--footer start-->