<!--sidebar end-->
<!--main content start-->
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('account_balance'); ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item"><?php echo lang('finance'); ?></li>
                                        <li class="breadcrumb-item active"><?php echo lang('account_balance'); ?></li>
                                       
                                        
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <div class="col-md-7">
        <section class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-12"> <?php
                if (!empty($account->id))
                    echo '<i class="fa fa-edit"></i> ' . lang('edit_account_balance');
                else
                    echo '<i class="fa fa-plus-circle"></i> ' . lang('add_account_balance');
                ?></h4> 
                                     
                                    </div>
            
            <div class="card-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>
                                            <?php echo $this->session->flashdata('feedback'); ?>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="account/addNew" method="post" enctype="multipart/form-data">
                                        <div class="form-group">    
                                            <label for="exampleInputEmail1">  <?php echo lang('patient'); ?></label> 
                                            <select class="form-control m-bot15 patient" id="apatients" name="patient" value='' required="">  

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('date');
                                            }
                                            if (!empty($account->date)) {
                                                echo $account->date;
                                            }
                                            ?>' placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                                            <input type="number" min="1" class="form-control" name="deposit_amount" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('deposit_amount');
                                            }
                                            if (!empty($account->deposit_amount)) {
                                                echo $account->deposit_amount;
                                            }
                                            ?>' placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('balance_amount'); ?></label>
                                            <input type="number" min="0" class="form-control" name="balance_amount" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('balance_amount');
                                            }
                                            if (!empty($account->balance_amount)) {
                                                echo $account->balance_amount;
                                            }
                                            ?>' placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                                            <select class="form-control js-example-basic-single" name="deposit_type">
                                                <option value="Cash" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('deposit_type') == 'Cash') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($account->deposit_type)) {
                                                    if ($account->deposit_type == 'Cash') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>><?php echo lang('cash'); ?></option>
                                                <option value="Card" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('deposit_type') == 'Card') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($account->deposit_type)) {
                                                    if ($account->deposit_type == 'Card') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>><?php echo lang('card'); ?></option>
                                                <option value="Cheque" <?php
                                                if (!empty($setval)) {
                                                    if (set_value('deposit_type') == 'Cheque') {
                                                        echo 'selected';
                                                    }
                                                }
                                                if (!empty($account->deposit_type)) {
                                                    if ($account->deposit_type == 'Cheque') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>><?php echo lang('cheque'); ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('account_no'); ?></label>
                                            <input type="text" class="form-control" name="account_no" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('account_no');
                                            }
                                            if (!empty($account->account_no)) {
                                                echo $account->account_no;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('transaction_id'); ?></label>
                                            <input type="text" class="form-control" name="transaction_id" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('transaction_id');
                                            }
                                            if (!empty($account->transaction_id)) {
                                                echo $account->transaction_id;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($account->id)) {
                                            echo $account->id;
                                        }
                                        ?>'>
<div class="pull-right">
                                        <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
</div>
                                    </form>
                                </div>
                            </section>
                        </div>  
                    </div> 
                </div>
            </div>
        </section>
        <!-- page end-->
    </div>
</div>
</div>
</div>
<!--main content end-->
<!--footer start-->
<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script type="text/javascript">var select_patient = "<?php echo lang('select_patient'); ?>";</script>
<script src="common/extranal/js/account/account_balance.js"></script>