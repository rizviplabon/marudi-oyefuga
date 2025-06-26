<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
                <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo lang('account_balance'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>


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
       
        <section class="card">
        <div class="card-header table_header">
        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('account_balance'); ?></h4> 

                                        <div class="col-lg-4 no-print pull-right"> 
                                        <button type="button" class="btn btn-primary waves-effect waves-light w-xs" data-bs-toggle="modal"
                                                    data-bs-target="#myModal"><i class="fa fa-plus-circle"></i> <?php echo lang('add_account_balance'); ?></button>
                                           
                                        </div>
                                        <?php } else { ?>
                                            <h4 class="card-title mb-0 col-lg-12"><?php echo lang('account_balance'); ?></h4> 
                                            <?php } ?>
                                    </div>
          
            <div class="card-body">
            <div class="table-responsive adv-table">
                                            <table class="table mb-0" id="editable-sample">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('deposit_amount'); ?></th>
                                <th><?php echo lang('balance_amount'); ?></th>
                                <th><?php echo lang('deposit_type'); ?></th>
                                <th><?php echo lang('account_no'); ?></th>
                                <th><?php echo lang('transaction_id'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->




<!-- Add Account Modal-->
<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('add_account_balance') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
           
            <div class="modal-body">
                <form role="form" action="account/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">  <?php echo lang('patient'); ?></label> 
                        <select class="form-control patient" id="apatients" name="patient" value='' required="">  

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="number" min="1" class="form-control" name="deposit_amount" id="exampleInputEmail1"  placeholder="<?php echo $settings->currency; ?>"  required="">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        <select class="form-control js-example-basic-single" name="deposit_type">
                            <option value="Cash"><?php echo lang('cash'); ?></option>
                            <option value="Card"><?php echo lang('card'); ?></option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('account_no'); ?></label>
                        <input type="text" class="form-control" name="account_no" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('transaction_id'); ?></label>
                        <input type="text" class="form-control" name="transaction_id" id="exampleInputEmail1" value='' placeholder="">
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
<!-- Add Account Modal-->







<!-- Edit Account Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title"> <?php echo lang('edit_account_balance') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
           
            <div class="modal-body">
                <form role="form" id="editAccountForm" class="clearfix" action="account/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">  <?php echo lang('patient'); ?></label> 
                        <select class="form-control m-bot15 patient" id="apatients1" name="patient" value='' required="">  

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="number" min="1" class="form-control" name="deposit_amount" id="exampleInputEmail1" placeholder="<?php echo $settings->currency; ?>" required="">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        <select class="form-control js-example-basic-single" name="deposit_type">
                            <option value="Cash"><?php echo lang('cash'); ?></option>
                            <option value="Card"><?php echo lang('card'); ?></option>
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('account_no'); ?></label>
                        <input type="text" class="form-control" name="account_no" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('transaction_id'); ?></label>
                        <input type="text" class="form-control" name="transaction_id" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-info submit_button"><?php echo lang('submit') ?></button>
                                                            </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Account Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script type="text/javascript">var select_patient = "<?php echo lang('select_patient'); ?>";</script>
<script src="common/extranal/js/account/account_balance.js"></script>