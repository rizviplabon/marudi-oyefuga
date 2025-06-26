<!DOCTYPE html>
<html lang="en">
  <head>
  <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="uploads/fav_icon.jpeg">

    <?php
    $class_name = $this->router->fetch_class();
    $class_name_lang = lang($class_name);
    if (empty($class_name_lang)) {
        $class_name_lang = $class_name;
    }
    ?>
    <title><?php echo $class_name_lang; ?> |
        <?php
        // if ($this->ion_auth->in_group(array('superadmin'))) {
        //     $this->db->where('hospital_id', 'superadmin');
        // } else {
        //     $this->db->where('hospital_id', $this->hospital_id);
        // }
        $this->db->where('hospital_id', 'superadmin');
        ?>
        <?php
        echo $this->db->get('settings')->row()->system_vendor;
        ?></title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="doclinic/main/css/vendors_css.css">
	<link rel="stylesheet" href="doclinic/main/css/style.css">
	<link rel="stylesheet" href="doclinic/main/css/skin_color.css">
    <link rel="stylesheet" href="common/css/dark-mode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <link rel="stylesheet" href="doclinic/assets/vendor_components/datatable/datatables.min.css" /> -->
	<!-- Style-->  
	
	<link href="public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
    <link href="common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">

    <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-timepicker/compiled/timepicker.css">
    <link rel="stylesheet" type="text/css" href="common/assets/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/select2/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="common/css/lightbox.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" href="common/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="common/extranal/toast.css">
    <link href="common/assets/DataTables/datatables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="common/css/bootstrap-select-country.min.css" type='text/css' media='all' />
    <link href="common/assets/DataTables/Responsive/css/responsive.dataTables.min.css" rel="stylesheet" />
    
    <link href="common/assets/DataTables/Responsive/css/responsive.dataTables.css" rel="stylesheet" />
    <link href="public/assets/css/style.css" id="app-style" rel="stylesheet" type="text/css" />
  </head>
  <style>
    .theme-primary .dataTables_wrapper .dataTables_paginate .paginate_button.current{
        background: #5156be!important;
        color: #fff!important;
        border-color: #5156be!important;
    }
    .no-print{
        margin:0px!important;
    }
thead{
    background-color: #fff!important;
    color: #000 !important;
}
th{
    border-bottom: 1px solid #EFEFFD!important;
    font-size: 14px!important;
}
tbody{
    /* font-size: 13px!important; */
    color: black;
}
    .dt-buttons .dt-button{
        color: black !important;
    }
	.pull-right {
		color:gray!important;
    margin-left: 0px !important;
    float: right !important;
}
.content-header{
        margin-left: 15px !important;
    margin-top: -80px !important;
        margin-bottom:15px !important;
    }
body.light-skin .page-content{
	background-color: #fff !important;
}
body.dark-skin .page-content {
    background-color: #15243e !important;
}
body.dark-skin .adv-table table tr td{
    background-color: #15243e !important;
}

body.dark-skin.ck.ck-editor__main>.ck-editor__editable{
    background-color: #15243e !important;
}

.bg-light {
    --bs-bg-opacity: 1;
    background-color: rgb(201 185 155) !important;
}
.price{
    font-size:14px!important;
}
.card{
    box-shadow: 0 3px 5px 1px rgba(0, 0, 0, 0.05) !important;
    border: 1px solid #EFEFFD !important;
    margin-left: 15px !important;
    border-radius: 10px !important;
    margin-top: -30px !important;
}
.page-title-box{
    margin-top: -15px!important;
}
.page-title-right{
    font-size: 14px!important;
}
.justify-content-between {
    justify-content: left !important;
}
.mdi-home-outline{
    font-size: 17px!important;
}
.main-footer{
    background: #fff !important;
}

/* Dark Mode Toggle Styles */
.dark-mode-toggle {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.dark-mode-toggle i {
    margin-right: 5px;
    transition: all 0.3s ease;
}

.dark-mode-label {
    font-size: 12px;
    transition: all 0.3s ease;
    color: #333;
}

body.dark-skin .dark-mode-label {
    color: #fff;
}
</style>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
	
<div class="wrapper">
	<!-- <div id="loader"></div> -->
	
  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">	
		<!-- Logo -->
		<?php
                            if (!$this->ion_auth->in_group(array('superadmin'))) {
                                $this->db->where('hospital_id', $this->hospital_id);
                                $settings_title = $this->db->get('settings')->row()->title;
                                $settings_title = explode(' ', $settings_title);
                            ?>
		<a href="#" class="logo">
		  <!-- logo-->
		  <div class="logo-mini w-50">
			  <span class="light-logo"><img src="uploads/test-removebg-preview.png" alt="logo" height="30"></span>
			  <!-- <span class="dark-logo"><img src="uploads/test-removebg-preview.png" alt="logo" height="30"></span> -->
		  </div>
		  <div class="logo-lg">
			  <!-- <span class="light-logo"><img src="uploads/test-removebg-preview.png" alt="logo" height="30"></span> -->
			  <!-- <span class="dark-logo"><img src="uploads/test-removebg-preview.png" alt="logo" height="30"></span> -->
			  <span class="logo-txt">
                                    <?php echo $settings_title[0]; ?>

                                    <?php
                                            if (!empty($settings_title[1])) {
                                                echo $settings_title[1];
                                            }
                                            ?>

                                    <?php
                                            if (!empty($settings_title[2])) {
                                                echo $settings_title[2];
                                            }
                                            ?>
                                </span>
		  </div>
		</a>	
		<?php } ?>
	</div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
			<li class="btn-group nav-item">
				<a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light" data-toggle="push-menu" role="button">
					<i class="icon-Menu"><span class="path1"></span><span class="path2"></span></i>
			    </a>
			</li>
			<li class="btn-group d-lg-inline-flex d-none">
				<div class="app-menu">
					<div class="search-bx mx-5">
						<form>
							<div class="input-group">
							  <input type="search" class="form-control" placeholder="Search">
							  <div class="input-group-append">
								<button class="btn" type="submit" id="button-addon3"><i class="icon-Search"><span class="path1"></span><span class="path2"></span></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</li>
		</ul> 
	  </div>
	  <?php
                            $user = $this->ion_auth->get_user_id();

                            $users_details = $this->db->get_where('users', array('id' => $user))->row();

                            if ($this->ion_auth->in_group(array('Patient'))) {
                                $img_url = $this->db->get_where('patient', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Doctor'))) {
                                $img_url = $this->db->get_where('doctor', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Receptionist'))) {
                                $img_url = $this->db->get_where('receptionist', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Nurse'))) {
                                $img_url = $this->db->get_where('nurse', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Accountant'))) {
                                $img_url = $this->db->get_where('accountant', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Pharmacist'))) {
                                $img_url = $this->db->get_where('pharmacist', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('Laboratorist'))) {
                                $img_url = $this->db->get_where('laboratorist', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } elseif ($this->ion_auth->in_group(array('superadmin'))) {
                                $img_url = $this->db->get_where('superadmin', array('ion_user_id' => $users_details->id))->row()->img_url;
                            } else {
                                $img_url = 'public/assets/images/users/profile.png';
                            }

                            if (empty($img_url)) {
                                $img_url = 'public/assets/images/users/profile.png';
                            }

                            ?>
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">	
			
			<!-- User Account-->
			<li class="nav-item dropdown" id="userDropdown">
    <a href="#" class="dropdown-toggle waves-effect waves-light w-auto l-h-12 bg-transparent p-0 no-shadow"
       onclick="toggleUserDropdown()"
       aria-haspopup="true" 
       aria-expanded="false">
        <div class="d-flex pt-1">
            <div class="text-end me-10">
                <p class="fs-14 mb-0 fw-700 text-primary"><?php echo $this->ion_auth->get_users_groups()->row()->name ?></p>
                <small class="fs-10 mb-0 text-uppercase text-mute">Admin</small>
            </div>
            <img src="<?php echo $img_url; ?>" class="avatar rounded-10 bg-primary-light h-40 w-40" alt="User" />
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-right animated flipInX">
        <li class="user-body">
            <a class="dropdown-item" href="profile"><i class="ti-user text-muted me-2"></i> Profile</a>
            <a class="dropdown-item" href="auth/logout"><i class="ti-lock text-muted me-2"></i> Logout</a>
        </li>
    </ul>
</li>

<script>
// Vanilla JS dropdown toggle
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    const isOpen = dropdown.classList.contains('show');
    
    // Close all other dropdowns first
    document.querySelectorAll('.dropdown').forEach(d => {
        d.classList.remove('show');
        d.querySelector('.dropdown-menu').classList.remove('show');
    });
    
    // Toggle this dropdown
    if (!isOpen) {
        dropdown.classList.add('show');
        dropdown.querySelector('.dropdown-menu').classList.add('show');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('#userDropdown')) {
        document.querySelectorAll('.dropdown').forEach(d => {
            d.classList.remove('show');
            d.querySelector('.dropdown-menu').classList.remove('show');
        });
    }
});
</script>
			<li class="btn-group nav-item d-lg-inline-flex d-none">
				<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen btn-warning-light" title="Full Screen">
					<i class="icon-Position"></i>
			    </a>
			</li>
			
			<!-- Dark Mode Switcher -->
			<li class="btn-group nav-item d-lg-inline-flex d-none">
				<a href="#" onclick="toggleDarkMode(); return false;" class="waves-effect waves-light nav-link btn-info-light" title="Toggle Dark/Light Mode">
					<div class="dark-mode-toggle">
						<i id="darkModeIcon" class="fa fa-moon"></i>
						
					</div>
			    </a>
			</li>
		 
			
        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Dark Mode Switcher Script -->
  <script src="common/js/dark-mode-switcher.js"></script>
  
  <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 100%;">	
			  <!-- sidebar menu-->
			  <ul class="sidebar-menu" data-widget="tree">	
			  <li class="header">Menu</li>
			  <li>
				  <a href="home">
					<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
					<span>Dashboard</span>
				  </a>
				</li>	
				<li class="header">Applications</li>
				<?php if (in_array('department', $this->modules)) { ?>
				<li>
				  <a href="department">
					<i class="icon-Compiling"><span class="path1"></span><span class="path2"></span></i>
					<span><?php echo lang('departments'); ?></span>
				  </a>
				</li>	
				<?php } ?>
				<?php if (in_array('doctor', $this->modules)) { ?>
				<li class="treeview">
				  <a href="javascript: void(0);">
					<i class="icon-Diagnostics"><span class="path1"></span><span class="path2"></span></i>
					<span><?php echo lang('doctor'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="doctor"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('list_of_doctors'); ?></a></li>
					<li><a href="appointment/treatmentReport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('treatment_history'); ?> </a></li>
					<li><a href="doctorvisit"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('doctor_visit'); ?></a></li>
				
				  </ul>
				</li>
					<?php } ?>		
					<?php if (in_array('patient', $this->modules)) { ?>
				<li class="treeview">
				  <a href="javascript: void(0);">
					<i class="icon-Compiling"><span class="path1"></span><span class="path2"></span></i>
					<span><?php echo lang('patient'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="patient"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('patient_list'); ?></a></li>
					<li><a href="patient/patientPayments"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payments'); ?></a></li>
					<li><a href="patient/caseList"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('case'); ?>
					<?php echo lang('manager'); ?></a></li>
					<li><a href="patient/documents"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('documents'); ?></a></li>
				  </ul>
				</li>
				<?php } ?>
				<?php if (in_array('appointment', $this->modules)) { ?>			
				<li class="treeview">
				  <a href="#">
					<i class="icon-Library"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
					<span><?php echo lang('schedule'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="schedule"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('all'); ?>
					<?php echo lang('schedule'); ?></a></li>
					<li><a href="schedule/allHolidays"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('holidays'); ?></a></li>
				  </ul>
				</li>
				<?php } ?>
				<?php if (in_array('appointment', $this->modules)) { ?>
					<li class="treeview">
				  <a href="#">
					<i class="icon-Box2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
					<span><?php echo lang('appointment'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="appointment"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('all'); ?>
					</a></li>
					<li><a href="appointment/addNewView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add'); ?></a></li>
					<li><a href="appointment/todays"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('todays'); ?></a></li>
					<li><a href="appointment/upcoming"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('upcoming'); ?></a></li>
					<li><a href="appointment/calendar"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('calendar'); ?></a></li>
					<li><a href="appointment/request"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('request'); ?></a></li>
				  </ul>
				</li>
					<?php } ?>

					<?php if (in_array('nurse', $this->modules)) { ?>
					<li class="treeview">
				  <a href="#">
					<i class="icon-User"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
					<span><?php echo lang('human_resources'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="nurse"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('nurse'); ?>
					</a></li>
					<li><a href="pharmacist"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('pharmacist'); ?></a></li>
					<li><a href="laboratorist"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('laboratorist'); ?></a></li>
					<li><a href="accountant"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('accountant'); ?></a></li>
					<li><a href="receptionist"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('receptionist'); ?></a></li>
					</ul>
				</li>
					<?php } ?>
					<?php if (in_array('finance', $this->modules)) { ?>
					<li class="treeview">
				  <a href="#">
					<i class="icon-Money"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
					<span><?php echo lang('financial_activities'); ?></span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="finance/addPaymentView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_payment'); ?>
					</a></li>
					<li><a href="finance/payment"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payments'); ?></a></li>
					<li><a href="finance/draftPayment"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('draft_payments'); ?></a></li>
					<li><a href="finance/dueCollection"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('due_collection'); ?></a></li>
					<li><a href="finance/paymentCategory"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payment_procedures'); ?></a></li>
					<li><a href="finance/category"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payment_categories'); ?>
					</a></li>
					<li><a href="finance/expense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expense'); ?></a></li>
					<li><a href="finance/addExpenseView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_expense'); ?></a></li>
					<li><a href="finance/expenseCategory"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expense_categories'); ?></a></li>
					</ul>
				</li>
					<?php } ?>
					<?php if (in_array('prescription', $this->modules)) { ?>
						<li>
				  <a href="prescription/all">
					<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
					<span><?php echo lang('prescription'); ?></span>
				  </a>
				</li>
						<?php } ?>
<?php if (in_array('lab', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Diagnostics"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('labs'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="lab/testStatus"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('lab_tests'); ?></a></li>
        <li><a href="lab/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('lab_reports'); ?></a></li>
        <li><a href="lab/reportDelivery"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('report') . " " . lang('delivery'); ?></a></li>
        <li><a href="lab/template"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('template'); ?></a></li>
        <!-- <li><a href="macro"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('macro'); ?></a></li> -->
    </ul>
</li>
<?php } ?>
<?php if (in_array('bed', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Bed"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('bed_and_admission'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="bed/bedAllotment"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('all_admissions'); ?></a></li>
        <li><a href="bed/addAllotmentView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_admission'); ?></a></li>
        <li><a href="bed/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('bed_list'); ?></a></li>
        <li><a href="bed/addBedView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_bed'); ?></a></li>
        <li><a href="bed/bedCategory"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('bed_category'); ?></a></li>
        <li><a href="pservice"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('patient'); ?> <?php echo lang('service'); ?></a></li>
    </ul>
</li>
						<?php } ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Box "><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('Enhanced Bed Management'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Real-Time Bed Availability Tracking'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Predictive Analytics'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Automated Patient Assignment'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Integration with Hospital Systems'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Discharge Planning Tools'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Emergency Bed Allocation'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Centralized Communication Platform'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Data Security Features'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Customizable Dashboards'); ?>
        </a></li>
        <li><a href="bed/ReaTimeBedAvailabilityTracking">
            <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
            <?php echo lang('Mobile Accessibility'); ?>
        </a></li>
    </ul>
</li>

<?php if (in_array('pharmacy', $this->modules)) { ?>
<li class="treeview view">
    <a href="#">
        <i class="icon-Home"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('pharmacy'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <?php if (!$this->ion_auth->in_group(array('Pharmacist'))) { ?>
        <li><a href="finance/pharmacy/home"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('dashboard'); ?></a></li>
        <?php } ?>
        <li><a href="finance/pharmacy/payment"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('sales'); ?></a></li>
        <li><a href="finance/pharmacy/addPaymentView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_new_sale'); ?></a></li>
        <li><a href="finance/pharmacy/expense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expense'); ?></a></li>
        <li><a href="finance/pharmacy/addExpenseView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_expense'); ?></a></li>
        <li><a href="finance/pharmacy/expenseCategory"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expense_categories'); ?></a></li>
        <li class="treeview">
            <a href="#">
                <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('report'); ?>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="finance/pharmacy/financialReport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('pharmacy'); ?> <?php echo lang('report'); ?></a></li>
                <li><a href="finance/pharmacy/monthly"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('monthly_sales'); ?></a></li>
                <li><a href="finance/pharmacy/daily"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('daily_sales'); ?></a></li>
                <li><a href="finance/pharmacy/monthlyExpense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('monthly_expense'); ?></a></li>
                <li><a href="finance/pharmacy/dailyExpense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('daily_expense'); ?></a></li>
            </ul>
        </li>
    </ul>
</li>
<?php } ?>

<?php if ($this->ion_auth->in_group(array('admin'))) { ?>
<?php if (in_array('medicine', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Settings-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('medicine'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="medicine/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('medicine_list'); ?></a></li>
        <li><a href="medicine/addMedicineView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_medicine'); ?></a></li>
        <li><a href="medicine/medicineCategory"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('medicine_category'); ?></a></li>
        <li><a href="medicine/addCategoryView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_medicine_category'); ?></a></li>
        <li><a href="medicine/medicineStockAlert"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('medicine_stock_alert'); ?></a></li>
    </ul>
</li>
<?php } ?>
<?php } ?>


<?php if (in_array('donor', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-User"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('donor'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="donor/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('donor_list'); ?></a></li>
        <li><a href="donor/addDonorView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_donor'); ?></a></li>
        <li><a href="donor/bloodBank"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('blood_bank'); ?></a></li>
    </ul>
</li>
<?php } ?>
<li class="header">File & Report</li>
<?php if (in_array('file', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('file_manager'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="file/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('all'); ?> <?php echo lang('file'); ?></a></li>
        <li><a href="file/addNewView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_file'); ?></a></li>
    </ul>
</li>
<?php } ?>

<li class="treeview">
    <a href="#">
        <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('report'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
        <?php if (in_array('finance', $this->modules)) { ?>
        <li><a href="finance/financialReport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('financial_report'); ?></a></li>
        <li><a href="finance/accountBalanceReport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('account_balance_report'); ?></a></li>
        <li><a href="finance/AllUserActivityReport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('user_activity_report'); ?></a></li>
        <li><a href="finance/doctorsCommission"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('doctors_commission'); ?></a></li>
        <li><a href="finance/monthly"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('monthly_sales'); ?></a></li>
        <li><a href="finance/daily"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('daily_sales'); ?></a></li>
        <li><a href="finance/monthlyExpense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('monthly_expense'); ?></a></li>
        <li><a href="finance/dailyExpense"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('daily_expense'); ?></a></li>
        <li><a href="finance/expenseVsIncome"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expense_vs_income'); ?></a></li>
        <?php } ?>
        <?php } ?>
        <?php if (in_array('report', $this->modules)) { ?>
        <li><a href="report/birth"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('birth_report'); ?></a></li>
        <li><a href="report/operation"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('operation_report'); ?></a></li>
        <li><a href="report/expire"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('expire_report'); ?></a></li>
        <?php } ?>
    </ul>
</li>

<?php if (in_array('notice', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Notification"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('notice'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="notice/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('notice'); ?></a></li>
        <li><a href="notice/addNewView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('add_new'); ?></a></li>
    </ul>
</li>
<?php } ?>
<li class="header">E-mail & SMS</li>
<?php if (in_array('email', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Settings-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('email'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="email/autoEmailTemplate"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('autoemailtemplate'); ?></a></li>
        <li><a href="email/sendView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('new'); ?></a></li>
        <li><a href="email/sent"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('sent'); ?></a></li>
        <?php if ($this->ion_auth->in_group(array('admin'))) {
            $mail_setting = $this->email_model->getHospitalEmailSettings();
            foreach ($mail_setting as $email_set) {
                if ($email_set->type == 'Smtp') {
                    $email_id = $email_set->id;
                }
            }
        ?>
        <li><a href="email/settings?id=<?php echo $email_id; ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('settings'); ?></a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>

<?php if (in_array('sms', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Settings"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('sms'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="sms/autoSMSTemplate"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('autosmstemplate'); ?></a></li>
        <li><a href="sms/sendView"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('write_message'); ?></a></li>
        <li><a href="sms/sent"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('sent_messages'); ?></a></li>
        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
        <li><a href="sms/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('sms_settings'); ?></a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>

<li class="header">E-mail & SMS</li>

<?php if ($this->ion_auth->in_group(array('admin'))) { ?>
<?php if (in_array('payroll', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-Money"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('payroll'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <?php if (in_array('payroll', $this->modules)) { ?>
        <li><a href="payroll/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payroll'); ?></a></li>
        <?php } ?>
        <?php if (in_array('payroll', $this->modules)) { ?>
        <li><a href="payroll/salary"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('salary'); ?></a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>
<?php } ?>

<?php if ($this->ion_auth->in_group(array('admin'))) { ?>
<?php if (in_array('attendance', $this->modules)) { ?>
<li>
    <a href="attendance">
        <i class="icon-Diagnostics"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('attendance'); ?></span>
    </a>
</li>
<?php } ?>
<?php } ?>

<?php if ($this->ion_auth->in_group(array('admin'))) { ?>
<?php if (in_array('leave', $this->modules)) { ?>
<li class="treeview">
    <a href="#">
        <i class="icon-File"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <span><?php echo lang('leave'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <?php if (in_array('leave', $this->modules)) { ?>
        <li><a href="leave/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('leave'); ?></a></li>
        <?php } ?>
        <?php if (in_array('leave', $this->modules)) { ?>
        <li><a href="leave/leaveType"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('leave_type'); ?></a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>
<?php } ?>
<li class="header">Chat</li>
<?php if (in_array('chat', $this->modules)) { ?>

<li>
				  <a href="chat">
					<i class="icon-Chat"><span class="path1"></span><span class="path2"></span></i>
					<span><?php echo lang('chat'); ?></span>
        <span class="badge badge-pill badge-danger" id="chatCount">0</span>
				  </a>
				</li>
<script src="common/js/jquery.js"></script>
<script src="common/extranal/js/chat.js"></script>
<?php } ?>

<li class="header">Website & Settings</li>
<li class="treeview">
    <a href="#">
        <i class="icon-Globe"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('website'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <?php
    $hospital_username = $this->db->get_where('hospital', array('id' => $this->session->userdata('hospital_id')))->row()->username;
    if (empty($hospital_username)) {
        $hospital_username = '';
    }
    ?>
    <ul class="treeview-menu">
        <li><a href='site/<?php echo $hospital_username ?>' target="_blank"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('visit_site'); ?></a></li>
        <li><a href="site/settings"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('website_settings'); ?></a></li>
        <li><a href="site/review"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('reviews'); ?></a></li>
        <li><a href="site/gridsection"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('gridsections'); ?></a></li>
        <li><a href="site/gallery"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('gallery'); ?></a></li>
        <li><a href="site/slide"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('slides'); ?></a></li>
        <li><a href="site/service"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('services'); ?></a></li>
        <li><a href="site/featured"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('featured_doctors'); ?></a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="icon-Settings"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('settings'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="settings/index"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('system_settings'); ?></a></li>
        <li><a href="settings/chatgpt"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('chatgpt_settings'); ?></a></li>
        <li><a href="pgateway"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('payment_gateway'); ?></a></li>
        <li><a href="settings/language"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('language'); ?></a></li>
        <li><a href="storage/settings"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('storage_settings'); ?></a></li>
        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
        <li><a href="import"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('bulk'); ?> <?php echo lang('import'); ?></a></li>
        <?php } ?>
    </ul>
</li>

<!-- <li class="treeview">
    <a href="#">
        <i class="icon-Flag"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('country'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="country"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('country'); ?></a></li>
        <li><a href="country/province"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('province'); ?></a></li>
        <li><a href="country/city"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('city'); ?></a></li>
       
    </ul>
</li> -->

<li class="header">Log</li>
<li class="treeview">
    <a href="#">
        <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('logs'); ?></span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="transactionLogs"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('transaction_logs'); ?></a></li>
        <li><a href="logs"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i><?php echo lang('user'); ?> <?php echo lang('login_logs'); ?></a></li>
    </ul>
</li>

<li class="header">Subscription</li>
<li>
    <a href="settings/subscription">
        <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('subscription'); ?></span>
    </a>
</li>

<li>
    <a href="feedback">
        <i class="icon-Clipboard"><span class="path1"></span><span class="path2"></span></i>
        <span>Feedback</span>
    </a>
</li>

<li>
    <a href="feedback/comments">
        <i class="icon-Chat2"><span class="path1"></span><span class="path2"></span></i>
        <span>Feedback Comments</span>
    </a>
</li>

<li class="header">Profile</li>
<li>
    <a href="profile">
        <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
        <span><?php echo lang('profile'); ?></span>
    </a>
</li>
				 	     
			  </ul>
			  
		
		  </div>
		</div>
    </section>
  </aside>
  <script>
$(document).ready(function() {
    // Get current path from URL
    var fullPath = window.location.pathname;
    var baseUrl = $('base').attr('href').replace(window.location.origin, '');
    var currentPath = fullPath.replace(baseUrl, '').split('/').filter(Boolean);
    var activePath = currentPath.join('/') || 'home';
    console.log(activePath);
    // Add 'active' class to menu item based on href match
    $('.sidebar-menu li a').each(function() {
        var href = $(this).attr('href');
        if (href && href !== '#') {
            // Clean up href by removing base URL if present
            href = href.replace(baseUrl, '');
            console.log(href);
            if (href === activePath || 
                activePath.startsWith(href + '/') || 
                (activePath === '' && href === 'home')) {
                $(this).closest('li').addClass('active');
                $(this).closest('.treeview').addClass('active');
                $(this).closest('.view').addClass('active');
                $(this).closest('.treeview-menu').css('display', 'block');
            }
        }
    });
});
</script>

<style>
/* Add these styles */
.sidebar-menu li.active > a {
    background-color: rgba(255,255,255,.1) !important;
    color: #5156be !important;
}

.sidebar-menu .treeview.active > a {
    background-color: rgba(255,255,255,.1) !important;
    color: #5156be !important;
}

.treeview-menu li.active > a {
    color: #5156be !important;
}
</style>