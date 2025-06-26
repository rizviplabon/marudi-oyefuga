
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
    


<!-- Invoice 11 start -->
<div class="invoice-11 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner" id="invoice_wrapper">
                    <div class="invoice-info">
                        <div class="invoice-top">
                            <div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="logo-name">
                                            <div class="info">
                                                <a class="logo" href="#">
                                                    <img class="logo" src="<?php echo $settings->logo; ?>" alt="logo">
                                                </a>
                                                <h5><?php echo $settings->title; ?></h5>
                                                <p><a href="mailto:<?php echo $settings->email; ?>"><?php echo $settings->email; ?></a>
                                                <p class="mb-0"><a href="tel:<?php echo $settings->phone; ?>"><?php echo $settings->phone; ?></a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="invoice-name text-end">
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
                                            <h4 class="name color-white inv-header-1"><?php echo lang('invoice'); ?> #<?php echo $invoice_id; ?></h4>
                                            <p class="mb-0"><?php echo lang('invoice'); ?> <?php echo lang('date'); ?>: <?php echo date('M d, Y', $payment->date); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="client-name mb-30">
                                        <div class="info">
                                            <p class="inv-title-1"><?php echo lang('client'); ?> <?php echo lang('information'); ?></p>
                                            <?php 
                                        // Use the decrypted patient data from the payment
                                        $patient_info = null;
                                        if (!empty($payment->patient)) {
                                            $this->load->model('patient/patient_model');
                                            $patient_info = $this->patient_model->getDecryptedPatientById($payment->patient);
                                        }
                                        ?>
                                                                                          <p class="invo-addr-1">
                                                  <?php 
                                                  if (!empty($patient_info)) {
                                                      echo $patient_info->name . '<br/>';
                                                      if (!empty($patient_info->email)) {
                                                          echo $patient_info->email . '<br/>';
                                                      }
                                                      if (!empty($patient_info->address)) {
                                                          echo $patient_info->address . '<br/>';
                                                      }
                                                      if (!empty($patient_info->phone)) {
                                                          echo $patient_info->phone . '<br/>';
                                                      }
                                                  } else {
                                                      if (!empty($payment->patient_name)) {
                                                          echo $payment->patient_name . '<br/>';
                                                      }
                                                      if (!empty($payment->patient_email)) {
                                                          echo $payment->patient_email . '<br/>';
                                                      }
                                                      if (!empty($payment->patient_address)) {
                                                          echo $payment->patient_address . '<br/>';
                                                      }
                                                      if (!empty($payment->patient_phone)) {
                                                          echo $payment->patient_phone . '<br/>';
                                                      }
                                                  }
                                                  ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="project-description mb-30 text-end">
                                        <h5 class="inv-title-1"><?php echo lang('payment'); ?> <?php echo lang('status'); ?></h5>
                                        <p class="mb-0">
                                            <?php if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) { ?>
                                                <span class="badge bg-success"><?php echo lang('paid'); ?></span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger"><?php echo lang('due'); ?></span> 
                                                <?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-section clearfix">
                                    <div class="table-responsive">
                                        <table class="table invoice-table">
                                            <thead class="bg-active">
                                            <tr>
                                                <th><?php echo lang('item'); ?></th>
                                                <th class="text-center"><?php echo lang('price'); ?></th>
                                                <th class="text-center"><?php echo lang('qty'); ?></th>
                                                <th class="text-right"><?php echo lang('amount'); ?></th>
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
                                                    <tr>
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span>AP-<?php echo $appointment_details->id; ?></span>
                                                                <small><?php echo $payment->category_name; ?></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right"><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
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
                                                    <tr>
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span>MED-<?php echo $i; ?></span>
                                                                <small><?php echo $cat_new[1]; ?></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?php echo $settings->currency; ?> <?php echo $cat_new[2]; ?></td>
                                                        <td class="text-center"><?php echo $cat_new[3]; ?></td>
                                                        <td class="text-right"><?php echo $settings->currency; ?> <?php echo $cat_new[4]; ?></td>
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
                                                    <tr>
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span>SRV-<?php echo $cat_new[0]; ?></span>
                                                                <small><?php echo $service->name; ?></small>
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?></td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right"><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?></td>
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
                                                            <tr>
                                                                <td>
                                                                    <div class="item-desc-1">
                                                                        <span>CAT-<?php echo $category_name3[0]; ?></span>
                                                                        <small><?php echo $category_item->category; ?></small>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center"><?php echo $settings->currency; ?> <?php echo $category_name3[1]; ?></td>
                                                                <td class="text-center"><?php echo $category_name3[3]; ?></td>
                                                                <td class="text-right"><?php echo $settings->currency; ?> <?php echo $category_name3[1] * $category_name3[3]; ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3" class="text-end"><?php echo lang('sub_total'); ?></td>
                                                <td class="text-right"><?php echo $settings->currency; ?> <?php echo number_format($payment->amount, 2, ".", ""); ?></td>
                                            </tr>
                                            <?php if (!empty($payment->vat)) { ?>
                                            <tr>
                                                <td colspan="3" class="text-end"><?php echo lang('vat'); ?> (<?php echo $payment->vat_amount_percent; ?>%)</td>
                                                <td class="text-right"><?php echo $settings->currency; ?> <?php echo number_format($payment->vat, 2, ".", ""); ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if (!empty($payment->discount)) { ?>
                                            <tr>
                                                <td colspan="3" class="text-end"><?php echo lang('discount'); ?> (<?php echo $payment->percent_discount; ?>%)</td>
                                                <td class="text-right"><?php echo $settings->currency; ?> <?php echo number_format($payment->discount, 2, ".", ""); ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold"><?php echo lang('grand_total'); ?></td>
                                                <td class="text-right fw-bold"><?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total, 2, ".", ""); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center ic2">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="lorem mb-30">
                                        <h3 class="inv-title-1"><?php echo lang('payment'); ?> <?php echo lang('information'); ?></h3>
                                        <ul class="mb-0 important-notes-list-1">
                                            <li><strong><?php echo lang('payment_amount'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                            <li><strong><?php echo lang('due'); ?>:</strong> <?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id), 2, ".", ""); ?></li>
                                            <li><?php echo $settings->footer_invoice_message; ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-offsite">
                                    <div class="payment-info text-end mb-30">
                                        <h3 class="inv-title-1"><?php echo lang('contact'); ?> <?php echo lang('information'); ?></h3>
                                        <p class="mb-0">
                                            <?php echo $settings->title; ?><br>
                                            <?php echo $settings->address; ?><br>
                                            <?php echo lang('phone'); ?>: <?php echo $settings->phone; ?><br>
                                            <?php echo lang('email'); ?>: <?php echo $settings->email; ?>
                                        </p>
                                    </div>
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
                    <!-- <a href="finance/download?id=<?php echo $payment->id; ?>" class="btn btn-lg btn-download">
                        <i class="fa fa-download"></i> <?php echo lang('download'); ?> <?php echo lang('invoice'); ?>
                    </a> -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 11 end -->

<script src="<?php echo base_url(); ?>common/assets/invoice_templates/js/jquery.min.js"></script>

</div>
</div>
</div>
</div>


