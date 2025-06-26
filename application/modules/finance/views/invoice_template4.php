
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">


<?php
// Check if it's a download request
$isDownload = ($redirect == 'download');
?>


    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>common/assets/invoice_templates/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>common/assets/invoice_templates/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>common/assets/invoice_templates/css/style.css">
    
    <style>
        /* Override any conflicting styles from the main system */
        body.invoice-body {
            font-family: 'Poppins', sans-serif !important;
            color: #333 !important;
            background: #f5f5f5 !important;
            font-size: 14px !important;
            position: relative !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }
        
        .invoice-4 {
            margin-top: 50px !important; /* Add margin to avoid header overlap */
            z-index: 1 !important;
            position: relative !important;
        }
        
        .invoice-4 .invoice-info {
            background: white !important;
            border: 1px solid #eee !important;
            color: #535353 !important;
        }
        
        .invoice-4 .text-end {
            text-align: right !important;
        }
        
        .invoice-4 .text-center {
            text-align: center !important;
        }
        
        .invoice-4 .text-right {
            text-align: right !important;
        }
        
        @media print {
            .invoice-btn-section {
                display: none !important;
            }
            
            body.invoice-body {
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background: #fff !important;
            }
            
            .invoice-4 {
                margin-top: 0 !important;
                padding-top: 20px !important;
            }
            
            .invoice-inner {
                padding-top: 30px !important;
            }
            
            .invoice-4 .bg-active {
                background-color: #f9f9f9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .invoice-4 .invoice-headar {
                padding-top: 20px !important;
            }
            
            .invoice-4 .inv-header-1 {
                margin-top: 10px !important;
            }
            
            .invoice-4 .invoice-logo {
                margin-top: 15px !important;
            }
            
            /* Hide any unwanted elements that might appear during print */
            #header, nav, footer, .right-bar, .navi, .sidebar, .hide-on-print, .top-header, .main-header, .header-area {
                display: none !important;
                height: 0 !important;
                visibility: hidden !important;
            }
            
            /* Ensure texts remain visible */
            .invoice-4 .table td, 
            .invoice-4 .table th,
            .invoice-4 p, 
            .invoice-4 h1, 
            .invoice-4 h2, 
            .invoice-4 h3, 
            .invoice-4 h4, 
            .invoice-4 h5, 
            .invoice-4 h6, 
            .invoice-4 span, 
            .invoice-4 div, 
            .invoice-4 li, 
            .invoice-4 a {
                color: inherit !important;
            }
            
            /* Force text alignment */
            .invoice-4 .text-end {
                text-align: right !important;
            }
            
            .invoice-4 .text-center {
                text-align: center !important;
            }
            
            .invoice-4 .text-right {
                text-align: right !important;
            }
        } 
    </style>


<!-- Invoice 4 start -->
<div class="invoice-4 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <img src="<?php echo $settings->logo; ?>" alt="logo">
                                        </div>
                                        <!-- logo ended -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-id">
                                        <div class="info">
                                            <h1 class="inv-header-1"><?php echo lang('invoice'); ?></h1>
                                            <?php
                                            $numlength = strlen((string)$payment->id);
                                            $remaining = 10 - $numlength;
                                            $invoice_id = '';
                                            if ($remaining < 10) {
                                                for ($i = 0; $i < $remaining; $i++) {
                                                    $invoice_id .= '0';
                                                }
                                                $invoice_id .= $payment->id;
                                            } else {
                                                $invoice_id = $payment->id;
                                            }
                                            ?>
                                            <p class="mb-1"><?php echo lang('invoice'); ?> <?php echo lang('number'); ?>: <span>#<?php echo $invoice_id; ?></span></p>
                                            <p class="mb-0"><?php echo lang('invoice'); ?> <?php echo lang('date'); ?>: <span><?php echo date('d M Y', $payment->date); ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <h4 class="inv-title-1"><?php echo lang('invoice'); ?> <?php echo lang('to'); ?></h4>
                                        <?php 
                                        // Use the decrypted patient data from the payment
                                        $patient_info = null;
                                        if (!empty($payment->patient)) {
                                            $this->load->model('patient/patient_model');
                                            $patient_info = $this->patient_model->getDecryptedPatientById($payment->patient);
                                        }
                                        ?>
                                                                                  <h2 class="name">
                                              <?php 
                                              if (!empty($patient_info)) {
                                                  echo $patient_info->name;
                                              } else if (!empty($payment->patient_name)) {
                                                  echo $payment->patient_name;
                                              }
                                              ?>
                                          </h2>
                                          <p class="invo-addr-1">
                                              <?php
                                              if (!empty($patient_info)) {
                                                  if (!empty($patient_info->address)) {
                                                      echo $patient_info->address . '<br>';
                                                  }
                                                  if (!empty($patient_info->phone)) {
                                                      echo $patient_info->phone . '<br>';
                                                  }
                                                  if (!empty($patient_info->email)) {
                                                      echo $patient_info->email;
                                                  }
                                              } else {
                                                  if (!empty($payment->patient_address)) {
                                                      echo $payment->patient_address . '<br>';
                                                  }
                                                  if (!empty($payment->patient_phone)) {
                                                      echo $payment->patient_phone . '<br>';
                                                  }
                                                  if (!empty($payment->patient_email)) {
                                                      echo $payment->patient_email;
                                                  }
                                              }
                                              ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <div class="invoice-number-inner">
                                            <h4 class="inv-title-1"><?php echo lang('invoice'); ?> <?php echo lang('from'); ?></h4>
                                            <h2 class="name"><?php echo $settings->title; ?></h2>
                                            <p class="invo-addr-1">
                                                <?php echo $settings->address; ?><br/>
                                                <?php echo $settings->phone; ?><br/>
                                                <?php echo $settings->email; ?><br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr class="tr">
                                        <th><?php echo lang('no'); ?>.</th>
                                        <th class="pl0 text-start"><?php echo lang('description'); ?></th>
                                        <th class="text-center"><?php echo lang('price'); ?></th>
                                        <th class="text-center"><?php echo lang('qty'); ?></th>
                                        <th class="text-end"><?php echo lang('amount'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    $total = 0;
                                    
                                    if ($payment->payment_from == 'appointment') {
                                        if (!empty($payment->category_name)) {
                                            $appointment_details = $this->db->get_where('appointment', array('id' => $payment->appointment_id))->row();
                                            $i = $i + 1;
                                            $total = $total + $payment->gross_total;
                                            ?>
                                            <tr class="tr">
                                                <td>
                                                    <div class="item-desc-1">
                                                        <span><?php echo $i; ?></span>
                                                    </div>
                                                </td>
                                                <td class="pl0"><?php echo $payment->category_name; ?></td>
                                                <td class="text-center"><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                                <td class="text-center">1</td>
                                                <td class="text-end"><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($payment->payment_from == 'admitted_patient_bed_medicine') {
                                        if (!empty($payment->category_name)) {
                                            $category = explode('#', $payment->category_name);
                                            foreach ($category as $cat) {
                                                $i = $i + 1;
                                                $cat_new = array();
                                                $cat_new = explode('*', $cat);
                                                if (!empty($cat_new[0]) && !empty($cat_new[1]) && !empty($cat_new[2]) && !empty($cat_new[3]) && !empty($cat_new[4])) {
                                                    $total = $total + $cat_new[4];
                                            ?>
                                            <tr class="tr <?php if($i % 2 == 0) echo 'bg-grea'; ?>">
                                                <td>
                                                    <div class="item-desc-1">
                                                        <span><?php echo $i; ?></span>
                                                    </div>
                                                </td>
                                                <td class="pl0"><?php echo $cat_new[1]; ?></td>
                                                <td class="text-center"><?php echo $settings->currency; ?> <?php echo $cat_new[2]; ?></td>
                                                <td class="text-center"><?php echo $cat_new[3]; ?></td>
                                                <td class="text-end"><?php echo $settings->currency; ?> <?php echo $cat_new[4]; ?></td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                        }
                                    } elseif ($payment->payment_from == 'admitted_patient_bed_service') {
                                        if (!empty($payment->category_name)) {
                                            $category = explode('#', $payment->category_name);
                                            foreach ($category as $cat) {
                                                $i = $i + 1;
                                                $cat_new = array();
                                                $cat_new = explode('*', $cat);
                                                if (!empty($cat_new[0]) && !empty($cat_new[1])) {
                                                    $service = $this->db->get_where('pservice', array('id' => $cat_new[0]))->row();
                                                    $total = $total + $cat_new[1];
                                            ?>
                                            <tr class="tr <?php if($i % 2 == 0) echo 'bg-grea'; ?>">
                                                <td>
                                                    <div class="item-desc-1">
                                                        <span><?php echo $i; ?></span>
                                                    </div>
                                                </td>
                                                <td class="pl0"><?php echo $service->name; ?></td>
                                                <td class="text-center"><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?></td>
                                                <td class="text-center">1</td>
                                                <td class="text-end"><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?></td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                        }
                                    } else {
                                        if (!empty($payment->category_name)) {
                                            $category_name = $payment->category_name;
                                            $category_name1 = explode(',', $category_name);
                                            foreach ($category_name1 as $category_name2) {
                                                $category_name3 = explode('*', $category_name2);
                                                if ($category_name3[3] > 0) {
                                                    $i = $i + 1;
                                                    $total = $total + $category_name3[1] * $category_name3[3];
                                                    $category_item = $this->finance_model->getPaymentcategoryById($category_name3[0]);
                                                    ?>
                                                    <tr class="tr <?php if($i % 2 == 0) echo 'bg-grea'; ?>">
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span><?php echo $i; ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="pl0"><?php echo $category_item->category; ?></td>
                                                        <td class="text-center"><?php echo $settings->currency; ?> <?php echo $category_name3[1]; ?></td>
                                                        <td class="text-center"><?php echo $category_name3[3]; ?></td>
                                                        <td class="text-end"><?php echo $settings->currency; ?> <?php echo $category_name3[1] * $category_name3[3]; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><?php echo lang('sub_total'); ?></td>
                                        <td class="text-end"><?php echo $settings->currency; ?> <?php echo number_format($payment->amount, 2, ".", ""); ?></td>
                                    </tr>
                                    <?php if (!empty($payment->vat)) { ?>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><?php echo lang('vat'); ?> (<?php echo $payment->vat_amount_percent; ?>%)</td>
                                        <td class="text-end"><?php echo $settings->currency; ?> <?php echo number_format($payment->vat, 2, ".", ""); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if (!empty($payment->discount)) { ?>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><?php echo lang('discount'); ?> (<?php echo $payment->percent_discount; ?>%)</td>
                                        <td class="text-end"><?php echo $settings->currency; ?> <?php echo number_format($payment->discount, 2, ".", ""); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center f-w-600 active-color"><?php echo lang('grand_total'); ?></td>
                                        <td class="f-w-600 text-end active-color"><?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total, 2, ".", ""); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-lg-6 col-md-5 col-sm-5">
                                    <div class="payment-method mb-30">
                                        <h3 class="inv-title-1"><?php echo lang('payment_details'); ?></h3>
                                        <ul class="payment-method-list-1 text-14">
                                            <li><strong><?php echo lang('payment_status'); ?>:</strong> 
                                                <?php if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) { ?>
                                                    <span class="paid"><?php echo lang('paid'); ?></span>
                                                <?php } else { ?>
                                                    <span class="due"><?php echo lang('due'); ?></span>
                                                <?php } ?>
                                            </li>
                                            <li><strong><?php echo lang('payment_amount'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                            <li><strong><?php echo lang('due'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-7">
                                    <div class="terms-conditions mb-30">
                                        <h3 class="inv-title-1"><?php echo lang('terms_conditions'); ?></h3>
                                        <p><?php echo $settings->footer_invoice_message; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-sm-12">
                                    <div class="contact-info clearfix">
                                        <a href="tel:<?php echo $settings->phone; ?>" class="d-flex"><i class="fa fa-phone"></i> <?php echo $settings->phone; ?></a>
                                        <a href="mailto:<?php echo $settings->email; ?>" class="d-flex"><i class="fa fa-envelope"></i> <?php echo $settings->email; ?></a>
                                        <a href="#" class="mr-0 d-flex d-none-580"><i class="fa fa-map-marker"></i> <?php echo $settings->address; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> <?php echo lang('print'); ?> <?php echo lang('invoice'); ?>
                        </a>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                        <!-- <a href="finance/download?id=<?php echo $payment->id; ?>" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> <?php echo lang('download'); ?> <?php echo lang('invoice'); ?>
                        </a> -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 4 end -->

<script src="<?php echo base_url(); ?>common/assets/invoice_templates/js/jquery.min.js"></script>

</div>
</div>
</div>
</div>

