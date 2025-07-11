<!--sidebar end-->
<!--main content start-->
<!-- <link href="common/extranal/css/appointment/appointment.css" rel="stylesheet"> -->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('upcoming'); ?> <?php echo lang('appointments'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
                        &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item"><?php echo lang('appointment'); ?></li>
                                        <li class="breadcrumb-item active"><?php echo lang('upcoming'); ?></li>
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
       
        <div class="card">
                                <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('upcoming'); ?> <?php echo lang('appointments'); ?></h4> 
                                        <div class="col-lg-4 no-print pull-right"> 
                                        <button type="button" class="btn btn-primary waves-effect waves-light w-xs" data-bs-toggle="modal"
                                                    data-bs-target="#myModal"><i class="fa fa-plus-circle"></i> <?php echo lang('add_appointment'); ?></button>
                                           
                                        </div>
                                    </div>
         
                        <div class="card-body">  
                                        <div class="table-responsive adv-table">
                                            <table class="table mb-0" id="editable-sample1">
            
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('patient'); ?></th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('date-time'); ?></th>
                                <th> <?php echo lang('remarks'); ?></th>
                                <th> <?php echo lang('status'); ?></th> 
                                <th> <?php echo lang('description'); ?></th>
                                <th> <?php echo lang('invoice_id'); ?></th>
                                <th> <?php echo lang('amount'); ?></th>
                                <th> <?php echo lang('bill'); ?> <?php echo lang('status'); ?></th>
                                <th> <?php echo lang('options'); ?></th>
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

<div class="modal fade" role="dialog" id="cmodal">
    <div class="modal-dialog modal-xl med_his" role="document">
        <div class="modal-content">
        <!-- <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('patient').' '.lang('history'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div> -->
            <div class="modal-body row">
            <div id='medical_history'>
                <div class="col-md-12">

                </div>
            </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 pull-right">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Add Appointment Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add_appointment') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body row">
                <form role="form" action="appointment/addNew" id="addAppointmentForm" method="post" class="clearfix" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6 panel patient_div">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?>&#42;</label>
                        <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value='' required>


                        </select> 
                    </div>
                    <input type="hidden" name="redirectlink" value="upcoming">
                    <div class="pos_client clearfix row">
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                            <select class="form-control" name="p_gender" value=''>

                                <option value="Male" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Male') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                                <option value="Female" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Female') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('female'); ?> </option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 doctor_div">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?>&#42;</label>
                        <select class="form-control m-bot15" id="adoctors" name="doctor" value='' required>

                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?>&#42;</label>
                        <input type="text" class="form-control default-date-picker" id="date" required="" onkeypress="return false;" name="date" id="exampleInputEmail1" value='' placeholder=""autocomplete="off">
                    </div>
                    <div class="col-md-6 aslots">
                        <label for="exampleInputEmail1"><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots" value=''>

                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation" <?php ?>> <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php
                                                        ?>> <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" <?php
                                                    ?>> <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled" <?php
                                                        ?>> <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    </div>
                    <div class="col-md-12">

                        <label class=""><?php echo lang('visit'); ?> <?php echo lang('description'); ?>&#42;</label>

                        <select class="form-control m-bot15" name="visit_description" id="visit_description" value='' required>

                        </select>

                    </div>
                    <div class="row">
                    <div class="form-group col-md-4 form_data">
                        <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                        <input type="number" class="form-control" name="visit_charges" id="visit_charges" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4 form_data">
                        <label for="exampleInputEmail1"><?php echo lang('discount'); ?></label>
                        <input type="number" class="form-control" name="discount" id="discount" value='0' placeholder="">
                    </div>
                    <div class="form-group col-md-4 form_data">
                        <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                        <input type="number" class="form-control" name="grand_total" id="grand_total" value='0' placeholder="" readonly="">
                    </div>
                    </div>
                    <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?>
                        <div class="col-md-12">
                            <input type="checkbox" id="pay_now_appointment" name="pay_now_appointment" value="pay_now_appointment">
                            <label for=""> <?php echo lang('pay_now'); ?></label><br>
                            <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                <span class="info_message"><?php echo lang('if_pay_now_checked_please_select_status_to_confirmed') ?></span>
                            <?php } ?>
                        </div>

                        <div class="payment_label col-md-12 hidden deposit_type">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>

                            <div class="">
                                <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                        <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                        <option value="Card"> <?php echo lang('card'); ?> </option>
                                        <option value="Account Balance"> <?php echo lang('account_balance'); ?> </option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?php
                            $payment_gateway = $settings->payment_gateway;
                            ?>



                            <div class="card2">

                                <hr>
                                <?php if ($payment_gateway != 'Paymob') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                        <div class="payment pad_bot">
                                            <img src="uploads/card.png" width="100%">
                                        </div>
                                    </div>
                                <?php }
                                ?>

                                <?php
                                if ($payment_gateway == 'PayPal') {
                                ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('type'); ?></label>
                                        <select class="form-control m-bot15" name="card_type" value=''>

                                            <option value="Mastercard"> <?php echo lang('mastercard'); ?> </option>
                                            <option value="Visa"> <?php echo lang('visa'); ?> </option>
                                            <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                        </select>
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway == '2Checkout' || $payment_gateway == 'PayPal') {
                                ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                        <input type="text" id="cardholder" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                        <input type="text" id="card" class="form-control pay_in" name="card_number" value='' placeholder="">
                                    </div>


                                    <div class="row">
                                    <div class="col-md-8 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                        <input type="text" class="form-control pay_in" id="expire" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                    </div>
                                    <div class="col-md-4 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                        <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv" value='' placeholder="">
                                    </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>


                        </div>
                        <div class="modal-footer">
                                                               
                                                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                <div class="form-group cashsubmit payment  right-six col-md-12 pull-right">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                                </div>
                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                <div class="form-group cardsubmit  right-six col-md-12 hidden pull-right">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info submit_button" <?php if ($settings->payment_gateway == 'Stripe') {
                                                                                                                                ?>onClick="stripePay(event);" <?php }
                                                                                                                                                                ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                                                        ?>onClick="twoCheckoutPay(event);" <?php }
                                                                        ?>> <?php echo lang('submit'); ?></button>
                                </div>
                                                            </div>
                       
                    <?php } else { ?>
                        <div class="modal-footer">
                        <div class="form-group  payment  right-six col-md-12 pull-right">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                                </div>
                        </div>
                       
                    <?php } ?>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->




 
 

<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title"> <?php echo lang('edit_appointment') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <form role="form" id="editAppointmentForm" action="appointment/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6 patient_div">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?>&#42;</label>
                        <select class="form-control m-bot15  pos_select1 patient" id="pos_select1" name="patient" value=''>

                        </select>
                    </div>
                    <div class="pos_client1 clearfix row">
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                            <select class="form-control" name="p_gender" value=''>

                                <option value="Male" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Male') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                                <option value="Female" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Female') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('female'); ?> </option>
                              
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 doctor_div1">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?>&#42;</label>
                        <select class="form-control m-bot15 doctor" id="adoctors1" name="doctor" value='' required>

                        </select>
                    </div>
                    </div>
                    <input type="hidden" name="redirectlink" value="upcoming">
                    <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?>&#42;</label>
                        <input type="text" class="form-control default-date-picker" id="date1" required="" onkeypress="return false;" name="date" id="exampleInputEmail1" value='' placeholder="" autocomplete="off">
                    </div>
                    <div class="col-md-6 aslots">
                        <label for="exampleInputEmail1"><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots1" value=''>

                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation" <?php ?>> <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php ?>> <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" <?php ?>> <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled" <?php ?>> <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    </div>
                    <div class="col-md-12 panel">

                        <label class=""><?php echo lang('visit'); ?> <?php echo lang('description'); ?>&#42;</label>

                        <select class="form-control m-bot15" name="visit_description" id="visit_description1" value='' required>

                        </select>

                    </div>

                    <input type="hidden" name="id" id="appointment_id" value=''>
                    <div class="row">
                    <div class="form-group col-md-4 hidden consultant_fee_div">
                        <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                        <input type="number" class="form-control" name="visit_charges" id="visit_charges1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4 hidden consultant_fee_div">
                        <label for="exampleInputEmail1"><?php echo lang('discount'); ?></label>
                        <input type="number" class="form-control" name="discount" id="discount1" value='0' placeholder="">
                    </div>
                    <div class="form-group col-md-4 hidden consultant_fee_div">
                        <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                        <input type="number" class="form-control" name="grand_total" id="grand_total1" value='0' placeholder="" readonly="">
                    </div>
                    </div>
                    <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?>
                        <div class="col-md-12 hidden pay_now">
                            <input type="checkbox" id="pay_now_appointment1" name="pay_now_appointment" value="pay_now_appointment">
                            <label for=""> <?php echo lang('pay_now'); ?></label><br>
                            <span class="info_message"><?php echo lang('if_pay_now_checked_please_select_status_to_confirmed') ?></span>
                        </div>
                        <div class="col-md-12 hidden payment_status form-group">
                            <label for=""> <?php echo lang('payment'); ?> <?php echo lang('status'); ?></label><br>
                            <input type="text" class="form-control" id="pay_now_appointment" name="payment_status_appointment" value="paid" readonly="">


                        </div>
                        <div class="payment_label col-md-12 hidden deposit_type1">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>

                            <div class="">
                                <select class="form-control m-bot15 js-example-basic-single selecttype1" id="selecttype1" name="deposit_type" value=''>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                        <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                        <option value="Card"> <?php echo lang('card'); ?> </option>
                                        <option value="Account Balance"> <?php echo lang('account_balance'); ?> </option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?php
                            $payment_gateway = $settings->payment_gateway;
                            ?>



                            <div class="card1">

                                <hr>
                                <?php if ($payment_gateway != 'Paymob') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                        <div class="payment pad_bot">
                                            <img src="uploads/card.png" width="100%">
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($payment_gateway == 'PayPal') {
                                ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('type'); ?></label>
                                        <select class="form-control m-bot15" name="card_type" value=''>

                                            <option value="Mastercard"> <?php echo lang('mastercard'); ?> </option>
                                            <option value="Visa"> <?php echo lang('visa'); ?> </option>
                                            <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                        </select>
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway == '2Checkout' || $payment_gateway == 'PayPal') {
                                ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                        <input type="text" id="cardholder1" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                        <input type="text" id="card1" class="form-control pay_in" name="card_number" value='' placeholder="">
                                    </div>


                                    <div class="row">
                                    <div class="col-md-8 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                        <input type="text" class="form-control pay_in" id="expire1" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                    </div>
                                    <div class="col-md-4 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                        <input type="text" class="form-control pay_in" id="cvv1" maxlength="3" name="cvv" value='' placeholder="">
                                    </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>


                        </div>
                        <div class="modal-footer">
                       

                        <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                <div class="form-group cashsubmit1 payment  right-six col-md-12 pull-right">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                                </div>
                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                <div class="form-group cardsubmit1  right-six col-md-12 hidden pull-right">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="pay_now" id="submit-btn1" class="btn btn-info submit_button" <?php if ($settings->payment_gateway == 'Stripe') {
                                                                                                                                ?>onClick="stripePay1(event);" <?php }
                                                                                                                                                                ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                                                        ?>onClick="twoCheckoutPay1(event);" <?php }
                                                                        ?>> <?php echo lang('submit'); ?></button>
                                </div>
                              
                                   
                                
                        </div>
                      
                    <?php } else { ?>
                        <div class="modal-footer">
                        <div class="form-group  payment  right-six col-md-12 pull-right">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info submit_button"> <?php echo lang('submit'); ?></button>
                                </div>
                        </div>
                       
                    <?php } ?>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<div class="modal fade" id="myModal4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-location-arrow"></i> <?php echo lang('send_sms_to_patient'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="sendSmsToVolunteer" action="sms/appointmentReminder" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <p><?php echo lang('reminder_message'); ?></p>
                    </div>
                    <input type="hidden" id="id" value="" name="id">
                    <button type="submit" name="submit" class="btn btn-info submit_button"><?php echo lang('yes'); ?></button>
                    <button type="submit" name="submit" class="btn btn-info invoicebutton" data-dismiss="modal" aria-hidden="true"><?php echo lang('cancel'); ?></button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<script src="common/js/codearistos.min.js"></script>
<script src="common/js/moment.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script> -->
<script type="text/javascript">
    var publish = "<?php echo $gateway->publish; ?>";
</script>
<script type="text/javascript">
    var payment_gateway = "<?php echo $settings->payment_gateway; ?>";
</script>

<script type="text/javascript">
    var select_doctor = "<?php echo lang('select_doctor'); ?>";
</script>
<script type="text/javascript">
    var select_patient = "<?php echo lang('select_patient'); ?>";
</script>
<script type="text/javascript">
    var language = "<?php echo $this->language; ?>";
</script>

<script src="common/extranal/js/appointment/upcoming.js"></script>
<script src="common/extranal/js/appointment/appointment_select2.js"></script>