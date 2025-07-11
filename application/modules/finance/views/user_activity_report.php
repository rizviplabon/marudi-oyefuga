<link href="common/extranal/css/finance/user_activity_report.css" rel="stylesheet">
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"> User Activities </h4>
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
                                        <li class="breadcrumb-item">Finance</li>
                                        <li class="breadcrumb-item active"> User Activities  </li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <div class="row">
        <div class="col-md-8">
        <section class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-6"> <?php echo lang('activities_by'); ?> <strong class="activities_by"><?php echo $user->name; ?></strong>
                    ( <?php
                    if (!empty($date_from)) {
                        echo lang('from') . ' ' . date('m/d/Y', $date_from) . ' ';
                    }

                    if (!empty($date_to)) {
                        echo lang('to') . ' ' . date('m/d/Y', $date_to);
                    }

                    if (!empty($day)) {
                        echo $day;
                    }
                    ?> )</h4> 


                <?php if ($this->ion_auth->in_group(array('admin')) || $this->ion_auth->get_user_id() == '341') { ?>
                            <section class="col-lg-4 no-print">
                            <a  href="finance/allUserActivityReport?user=<?php echo $user->ion_user_id; ?>" class="btn btn-soft-primary waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('today'); ?></a>

                            <a  href="finance/allUserActivityReport?user=<?php echo $user->ion_user_id; ?>&yesterday='all'" class="btn btn-soft-info waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('yesterday'); ?></a>
                            <a  href="finance/allUserActivityReport?user=<?php echo $user->ion_user_id; ?>&all='all'" class="btn btn-soft-success waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('all'); ?></a>

                       
                     
                            </section>

                            <section class="col-md-2 pull-right">
                                <div class="">
                                    <button class="btn btn-soft-info green no-print pull-right" onclick="javascript:window.print();"><?php echo lang('print'); ?></button>
                                </div>
                            </section> 

                <?php } ?>

                <?php if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) { ?>

                    <section class="col-lg-4 no-print">
                            <a  href="finance/UserActivityReport?user=<?php echo $user->ion_user_id; ?>" class="btn btn-soft-primary waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('today'); ?></a>

                            <a  href="finance/UserActivityReport?user=<?php echo $user->ion_user_id; ?>&yesterday='all'" class="btn btn-soft-info waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('yesterday'); ?></a>
                            <a  href="finance/UserActivityReport?user=<?php echo $user->ion_user_id; ?>&all='all'" class="btn btn-soft-success waves-effect waves-light w-xs"> <i class="fa fa-search"></i> <?php echo lang('all'); ?></a>

                       
                     
                            </section>

                            <section class="col-md-2 pull-right">
                                <div class="">
                                    <button class="btn btn-soft-info green no-print pull-right" onclick="javascript:window.print();"><?php echo lang('print'); ?></button>
                                </div>
                            </section>
                <?php } ?>
                                      
                                    </div>
         
           
            <div class="card-body">
                <?php if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) { ?>


                    <section class="col-md-6 no-print">
                        <form role="form" class="f_report" action="finance/userActivityReportDateWise" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                        if (!empty($date_from)) {
                                            echo date('m/d/Y', $date_from);
                                        }
                                        ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                        <span class="input-group-text"><?php echo lang('to'); ?></span>
                                        <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                        if (!empty($date_to)) {
                                            echo date('m/d/Y', $date_to);
                                        }
                                        ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                        <input type="hidden" class="form-control dpd2" name="user" value="<?php echo $user->ion_user_id; ?>">
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-5 no-print">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </section>

                <?php } ?>




                <?php if ($this->ion_auth->in_group(array('admin')) || $this->ion_auth->get_user_id() == '341') { ?>
                   
                    <section class="col-md-6 no-print">
                        <form role="form" class="f_report" action="finance/allUserActivityReportDateWise" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <!--     <label class="control-label col-md-3">Date Range</label> -->
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                        if (!empty($date_from)) {
                                            echo date('m/d/Y', $date_from);
                                        }
                                        ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                        <span class="input-group-text"><?php echo lang('to'); ?></span>
                                        <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                        if (!empty($date_to)) {
                                            echo date('m/d/Y', $date_to);
                                        }
                                        ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                        <input type="hidden" class="form-control dpd2" name="user" value="<?php echo $user->ion_user_id; ?>">
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-5 no-print">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </section>

                <?php } ?>



            
                <div class="adv-table editable-table ">
                <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-12"> <?php echo lang('all_bills'); ?> </h4> 
                                      
                                    </div>
                   
                    <table class="table mb-0" id="editable-samples">
                        <thead>
                            <tr>
                                <th class=""><?php echo lang('date'); ?></th>
                                <th class=""><?php echo lang('invoice'); ?> #</th>
                                <th class=""><?php echo lang('bill_amount'); ?></th>
                                <th class=""><?php echo lang('deposit'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $dates = array();
                            $datess = array();
                            foreach ($payments as $payment) {
                                $dates[] = $payment->date;
                            }
                            foreach ($deposits as $deposit) {
                                $datess[] = $deposit->date;
                            }
                            $dat = array_merge($dates, $datess);
                            $dattt = array_unique($dat);
                            asort($dattt);

                            $total_payment = array();

                            $total_deposit = array();
                            ?>

                            <?php
                            foreach ($dattt as $key => $value) {
                                foreach ($payments as $payment) {
                                    if ($payment->date == $value) {
                                        $total_payment[] = $payment->gross_total;
                                        ?>
                                        <tr class="">
                                            <td><?php echo date('d/m/y', $payment->date); ?></td>
                                            <td> <?php echo $payment->id; ?></td>
                                            <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                            <td><?php
                                                if (!empty($payment->amount_received)) {
                                                    echo $settings->currency;
                                                }
                                                ?> <?php echo $payment->amount_received; ?></td>

                                        </tr>

                                        <?php
                                    }
                                }
                                ?>

                                <?php
                                foreach ($deposits as $deposit) {
                                    if ($deposit->date == $value) {
                                        $total_deposit[] = $deposit->deposited_amount;
                                        if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                            ?>

                                            <tr class="">
                                                <td><?php echo date('d-m-y', $deposit->date); ?></td>
                                                <td><?php echo $deposit->payment_id; ?></td>
                                                <td></td>
                                                <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            <?php } ?>

                            <?php
                            if (!empty($total_payment)) {
                                $total_p = array_sum($total_payment);
                            } else {
                                $total_p = 0;
                            }

                            if (!empty($total_deposit)) {
                                $total_d = array_sum($total_deposit);
                            } else {
                                $total_d = 0;
                            }
                            ?>

                            <tr class="total">
                                <td></td>
                                <td> <strong> <?php echo lang('total'); ?> </strong></td>
                                <td> <strong> <?php echo $settings->currency; ?> <?php echo $total_p; ?> </strong></td>
                                <td> <strong> <?php echo $settings->currency; ?> <?php echo $total_d; ?> </strong></td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            </section>
        </div>
            <div class="col-md-4">


                <?php
                $total_bill = array();
                foreach ($payments as $payment) {
                    $total_bill[] = $payment->gross_total;
                }
                if (!empty($total_bill)) {
                    $total_bill = array_sum($total_bill);
                } else {
                    $total_bill = 0;
                }
                ?>

                <?php
                $total_bill_ot = array();
                if (!empty($total_bill_ot)) {
                    $total_bill_ot = array_sum($total_bill_ot);
                } else {
                    $total_bill_ot = 0;
                }
                ?>




<section class="card">
                    <div class="weather-bg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text_bar">
                                    <i class="fa fa-money-check"></i>
                                    <?php echo lang('total_bill_amount'); ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php echo $total_payable_bill = $total_bill; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="card">
                    <div class="weather-bg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text_bar">
                                    <i class="fa fa-money-check"></i>
                                    <?php echo lang('total_deposit_amount'); ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        $total_deposit = array();
                                        foreach ($deposits as $deposit) {
                                            $total_deposit[] = $deposit->deposited_amount;
                                        }
                                        echo array_sum($total_deposit);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <style>
    .personal-task{
        background-color: #F1F2F7;
    }
    .personal-task tbody tr td {
            padding: 11px 15px;
            border-color: #eeeff1;
        }
        .weather-bg .degree {
    font-size: 46px;
}
.weather-bg {
    background: #4BAFC8;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    color: #fff;
    text-align: center;
    font-size: 16px;
    font-weight: 300;
}
.text_bar{
    padding-top: 25px
}
    </style>
                <section class="card red due_amount_div">
                    <div class="weather-bg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text_bar">
                                    <i class="fa fa-money-check"></i>
                                    <?php echo lang('due_amount'); ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        echo $total_payable_bill - array_sum($total_deposit);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
    </div>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->




