<!--main content-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"> <?php echo lang('account_balance_report'); ?> </h4>
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
                                        <li class="breadcrumb-item active"> <?php echo lang('account_balance_report'); ?>  </li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <link href="common/extranal/css/finance/financial_report.css" rel="stylesheet">
        <section class="card">
            <div class="card-header table_header">
                <h4 class="card-title mb-0 col-lg-8"> <?php echo lang('account_balance_report'); ?></h4> 
                <div class="col-lg-4 no-print pull-right"> 
                    <a class="btn btn-soft-info no-print pull-right" onclick="javascript:window.print();"> <i class="fa fa-print"></i> </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" class="f_report" action="finance/accountBalanceReport" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-5">
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
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control m-bot15 js-example-basic-single" name="patient" id="patient">
                                        <option value=""><?php echo lang('select_patient'); ?></option>
                                        <?php foreach ($patients as $patient) { ?>
                                            <option value="<?php echo $patient->id; ?>" <?php
                                            if (!empty($patient_id)) {
                                                if ($patient_id == $patient->id) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?php echo $patient->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 no-print">
                                    <button type="submit" name="submit" class="btn btn-info btn-xs range_submit"><?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-header table_header">
                    <h4 class="card-title mb-0 col-lg-12"> <?php echo lang('account_balance'); ?></h4> 
                </div>
                <table class="table mb-0" id="editable-samples">
                    <thead>
                        <tr>
                            <th class=""><?php echo lang('date'); ?></th>
                            <th class=""><?php echo lang('invoice'); ?> #</th>
                            <th class=""><?php echo lang('deposit'); ?></th>
                            <th class=""><?php echo lang('deposit_type'); ?></th>
                            <th class=""><?php echo lang('from'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($deposits)) {
                            foreach ($deposits as $deposit) {
                                if (!empty($deposit->deposited_amount) && $deposit->deposit_type == 'Account Balance') {
                        ?>
                                    <tr class="">
                                        <td><?php echo date('d-m-y', $deposit->date); ?></td>
                                        <td><?php echo $deposit->payment_id; ?></td>
                                        <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                        <td><?php echo $deposit->deposit_type; ?></td>
                                        <td>
                                            <?php
                                            if ($deposit->payment_from == 'appointment') {
                                               echo '<span class="badge bg-primary">' . lang('appointment') . '</span>';
                                            } elseif ($deposit->payment_from == 'admitted_patient_bed_medicine') {
                                                echo '<span class="badge bg-warning">' . lang('ipd_medicine') . '</span>';
                                            } elseif ($deposit->payment_from == 'case') {
                                                echo '<span class="badge bg-primary">' . lang('case') . '</span>';
                                            } elseif ($deposit->payment_from == 'admitted_patient_bed_service') {
                                                echo '<span class="badge bg-success">' . lang('ipd_service') . '</span>';
                                            } elseif ($deposit->payment_from == 'admitted_patient_bed_diagnostic') {
                                                echo '<span class="badge bg-info">' . lang('ipd_diagnostic') . '</span>';
                                            } elseif ($deposit->payment_from == 'payment' || empty($deposit->payment_from)) {
                                                echo '<span class="badge bg-primary">' . lang('opd') . '</span>';
                                            } elseif ($deposit->payment_from == 'pre_service') {
                                                echo lang('pre_surgery') . ' ' . lang('service');
                                            } elseif ($deposit->payment_from == 'post_service') {
                                                echo lang('post_surgery') . ' ' . lang('service');
                                            } elseif ($deposit->payment_from == 'surgery') {
                                                echo lang('surgery');
                                            } elseif ($deposit->payment_from == 'pre_surgery_medical_analysis') {
                                                echo lang('pre_surgery') . ' ' . lang('medical_analysis');
                                            } elseif ($deposit->payment_from == 'post_surgery_medical_analysis') {
                                                echo lang('post_surgery') . ' ' . lang('medical_analysis');
                                            } elseif ($deposit->payment_from == 'pre_surgery_medicine') {
                                                echo lang('pre_surgery') . ' ' . lang('medicine');
                                            } elseif ($deposit->payment_from == 'post_surgery_medicine') {
                                                echo lang('post_surgery') . ' ' . lang('medicine');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
</div>
<!--main content end-->

<!-- Add Deposit Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add_deposit'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/deposit" id="deposit-form" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> &ast;</label>
                            <select class="form-control m-bot15 js-example-basic-single pos_select" id="pos_select" name="patient" value=''>
                                <option value=""> Select Patient</option>
                                <?php foreach ($patients as $patient) { ?>
                                    <option value="<?php echo $patient->id; ?>" <?php
                                    if (!empty($deposit->patient)) {
                                        if ($deposit->patient == $patient->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?>><?php echo $patient->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('deposit_amount'); ?> &ast;</label>
                            <input type="text" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('deposit_type'); ?></label>
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card"> <?php echo lang('card'); ?> </option>
                                <?php } ?>
                                <option value="Cheque"> <?php echo lang('cheque'); ?> </option>
                            </select>
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('invoice'); ?> &ast;</label>
                            <select class="form-control m-bot15 js-example-basic-single" id="invoice_id" name="payment_id" value=''>
                                <option value=""> Select Invoice</option>
                                <?php foreach ($payments as $payment) { ?>
                                    <option value="<?php echo $payment->id; ?>" <?php
                                    if (!empty($deposit->payment_id)) {
                                        if ($deposit->payment_id == $payment->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?>><?php echo $payment->id; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                                <input type="text" class="form-control" name="remarks" id="remarks" value='' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12 panel">
                            <input type="checkbox" name="deposit_type_checkbox" id="deposit_type_checkbox" value="Card">
                            <label for="exampleInputEmail1"> <?php echo lang('payment_gateway'); ?></label>
                        </div>
                        <?php
                        $payment_gateway = $settings->payment_gateway;
                        ?>
                        <div class="card" id="card">
                            <div class="col-md-12 payment_label">
                                <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?> </label>
                                <div class="payment pad_bot">
                                    <label class="payment_label">
                                        <?php echo lang('card'); ?> <?php echo lang('number'); ?> &ast;
                                        <input type="text" id="card_1" name="card_number" class="form-control pay_in" placeholder="Card Number" autocomplete="off">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8 payment_label">
                                <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?> &ast;</label>
                                <div class="payment pad_bot">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="payment_label">
                                                <?php echo lang('expire'); ?> <?php echo lang('month'); ?> &ast;
                                                <input type="text" id="expire_month" name="expire_month" class="form-control pay_in" placeholder="MM" autocomplete="off" maxlength="2">
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="payment_label">
                                                <?php echo lang('expire'); ?> <?php echo lang('year'); ?> &ast;
                                                <input type="text" id="expire_year" name="expire_year" class="form-control pay_in" placeholder="YY" autocomplete="off" maxlength="2">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 payment_label">
                                <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> &ast; </label>
                                <div class="payment pad_bot">
                                    <label class="payment_label">
                                        <?php echo lang('cvv'); ?> &ast;
                                        <input type="text" id="cvv" name="cvv" class="form-control pay_in" placeholder="CVV" autocomplete="off" maxlength="4">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" name="submit" id="submit_deposit" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Deposit Modal-->

<!-- Edit Deposit Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('edit_deposit'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" id="editDepositform" class="clearfix" action="finance/deposit" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> &ast;</label>
                            <select class="form-control m-bot15 js-example-basic-single pos_select patient" id="pos_select" name="patient" value=''>
                                <option value=""> Select Patient</option>
                                <?php foreach ($patients as $patient) { ?>
                                    <option value="<?php echo $patient->id; ?>" <?php
                                    if (!empty($deposit->patient)) {
                                        if ($deposit->patient == $patient->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?>><?php echo $patient->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('deposit_amount'); ?> &ast;</label>
                            <input type="text" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('deposit_type'); ?></label>
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card"> <?php echo lang('card'); ?> </option>
                                <?php } ?>
                                <option value="Cheque"> <?php echo lang('cheque'); ?> </option>
                            </select>
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('invoice'); ?> &ast;</label>
                            <select class="form-control m-bot15 js-example-basic-single" id="invoice_id" name="payment_id" value=''>
                                <option value=""> Select Invoice</option>
                                <?php foreach ($payments as $payment) { ?>
                                    <option value="<?php echo $payment->id; ?>" <?php
                                    if (!empty($deposit->payment_id)) {
                                        if ($deposit->payment_id == $payment->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?>><?php echo $payment->id; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                                <input type="text" class="form-control" name="remarks" id="remarks" value='' placeholder="">
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value=''>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Deposit Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/finance/patient_deposit.js"></script>