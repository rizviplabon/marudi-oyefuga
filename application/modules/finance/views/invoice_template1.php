



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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>common/assets/invoice_templates/css/style.css">
    
  



<!-- Invoice 1 start -->
<div class="invoice-1 invoice-content">
    <div class="container">
        <div class="row py-5">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row g-0">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <img src="<?php echo $settings->logo; ?>" alt="logo" style="height: 80px; width: auto;">
                                        </div>
                                        <!-- logo ended -->
                                    </div>
                                </div>
                                <div class="col-sm-6 invoice-id">
                                    <div class="info">
                                        <h1 class="color-white inv-header-1"><?php echo lang('invoice'); ?></h1>
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
                                        <p class="color-white mb-1"><?php echo lang('invoice'); ?> <?php echo lang('number'); ?> <span>#<?php echo $invoice_id; ?></span></p>
                                        <p class="color-white mb-0"><?php echo lang('invoice'); ?> <?php echo lang('date'); ?> <span><?php echo date('d M Y', $payment->date); ?></span></p>
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
                                        <h2 class="name mb-10">
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
                                            <h2 class="name mb-10"><?php echo $settings->title; ?></h2>
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
                                                    ?>
                                                    <tr class="tr <?php if($i % 2 == 0) echo 'bg-grea'; ?>">
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span><?php echo $i; ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="pl0"><?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->category; ?></td>
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
                                <div class="col-lg-6 col-md-8 col-sm-7">
                                    <div class="mb-30 dear-client">
                                        <h3 class="inv-title-1"><?php echo lang('terms_conditions'); ?></h3>
                                        <p><?php echo $settings->footer_invoice_message; ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-5">
                                    <div class="mb-30 payment-method">
                                        <h3 class="inv-title-1"><?php echo lang('payment_details'); ?></h3>
                                        <ul class="payment-method-list-1 text-14">
                                            <li><strong><?php echo lang('payment_amount'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                            <li><strong><?php echo lang('due'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                            <?php if ($payment->payment_from != 'appointment') { ?>
                                            <li><strong><?php echo lang('status'); ?>:</strong> 
                                                <?php if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) { ?>
                                                    <span class="paid"><?php echo lang('paid'); ?></span>
                                                <?php } else { ?>
                                                    <span class="due"><?php echo lang('due'); ?></span>
                                                <?php } ?>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-lg-9 col-md-11 col-sm-12">
                                    <div class="contact-info">
                                        <a href="tel:<?php echo $settings->phone; ?>"><i class="fa fa-phone"></i> <?php echo $settings->phone; ?></a>
                                        <a href="mailto:<?php echo $settings->email; ?>"><i class="fa fa-envelope"></i> <?php echo $settings->email; ?></a>
                                        <a href="#" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> <?php echo $settings->address; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-md btn-print">
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
<!-- Invoice 1 end -->

<script src="<?php echo base_url(); ?>common/assets/invoice_templates/js/jquery.min.js"></script>
<script>
    // Add a print-specific class to the body when printing
    window.onbeforeprint = function() {
        document.body.classList.add('printing');
    };
    window.onafterprint = function() {
        document.body.classList.remove('printing');
    };
</script>


</div>
</div>
</div>
</div>
