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

    <!-- Style-->
    <link rel="stylesheet" href="doclinic/main/css/style.css">
    <link rel="stylesheet" href="doclinic/main/css/skin_color.css">
    <link rel="stylesheet" href="doclinic/main/css/custom.css">
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
       .dt-buttons .dt-button{
        color: black !important;
    }
    .content-header{
        margin-left: 15px !important;
    margin-top: -80px !important;
        margin-bottom:15px !important;
    }
 
</style>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

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
                   
                    <div class="logo-mini w-50">
                        <span class="light-logo"><img src="uploads/test-removebg-preview.png" alt="logo" height="30"></span>
                        <!-- <span class="dark-logo"><img src="doclinic/images/logo-letter.png" alt="logo"></span> -->
                    </div>
                    <div class="logo-lg">
                        <!-- <span class="light-logo"><img src="uploads/test-removebg-preview.png" alt="logo"></span> -->
                        <!-- <span class="dark-logo"><img src="doclinic/images/logo-light-text.png" alt="logo"></span> -->
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
                            <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light"
                                data-toggle="push-menu" role="button">
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
                                                <button class="btn" type="submit" id="button-addon3"><i
                                                        class="icon-Search"><span class="path1"></span><span
                                                            class="path2"></span></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <!-- User Account-->
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
                        <li class="dropdown user user-menu">
                            <a href="#"
                                class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow"
                                data-bs-toggle="dropdown" title="User">
                                <div class="d-flex pt-1">
                                    <div class=" me-10">
                                        <p class="fs-14 mb-0 fw-700"><?php echo $this->ion_auth->get_users_groups()->row()->name ?></p>
                                        <small class="fs-10 mb-0 text-uppercase">Patient</small>
                                    </div>
                                    <img src="<?php echo $img_url; ?>"
                                        class="avatar rounded-10 bg-lightgreen h-40 w-40" alt="" />
                                </div>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="profile"><i
                                            class="ti-user text-muted me-2"></i> Profile</a>
                                    <a class="dropdown-item" href="auth/logout"><i
                                            class="ti-lock text-muted me-2"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen"
                                class="waves-effect waves-light nav-link full-screen btn-warning-light"
                                title="Full Screen">
                                <i class="icon-Position"></i>
                            </a>
                        </li>
                       
                        

                    </ul>
                </div>
            </nav>
        </header>

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
                                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="header">Applications</li>
                            <li>
                                <a href="appointment/myTodays">
                                    <i class="icon-Barcode-read"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Todays Appointment</span>
                                </a>
                            </li>
                            <li>
                                <a href="notice">
                                    <i class="icon-Compiling"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Notice</span>
                                </a>
                            </li>
                            <li class="header">My Applications</li>
                            <li>
                                <a href="lab/myLab">
                                    <i class="icon-Settings-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Diagnosis Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/calendar">
                                    <i class="icon-Diagnostics"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Appointment Calendar</span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myCaseList">
                                    <i class="icon-Library"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Cases</span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myPrescription">
                                    <i class="icon-Commit"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Prescription</span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myDocuments">
                                    <i class="icon-Box2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Documents</span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myPaymentHistory">
                                    <i class="icon-Money"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Payment</span>
                                </a>
                            </li>
                            <li>
                                <a href="report/myReports">
                                    <i class="icon-Lock-overturning"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Other Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="donor">
                                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Donor</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="javascript: void(0);">
                                    <i class="icon-Compiling"><span class="path1"></span><span class="path2"></span></i>
                                    <span>Enhanced Features</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Real-Time Health Monitoring'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Personalized Health Insights'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Telemedicine Integration'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Medication Management'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Appointment Scheduling'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Health Records Access'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Symptom Checker'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Health Goals and Tracking'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Patient Education'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Secure Messaging'); ?></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="javascript: void(0);">
                                    <i class="icon-Diagnostics"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>
                                    <span><?php echo lang('Unique Features'); ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Interactive Health Timeline'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Family Health Management'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Community Support'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Virtual Health Assistant'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Wellness Programs'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Emergency Alerts'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Patient Feedback'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Integration with Health Apps'); ?></a>
                                    </li>
                                    <li><a href="patient/RealTimeHealthMonitoring"><i class="icon-Commit"><span
                                                    class="path1"></span><span
                                                    class="path2"></span></i><?php echo lang('Predictive Analytics'); ?></a>
                                    </li>

                                </ul>
                            </li>
                            <li class="header">Profile</li>
                            <li>
                                <a href="profile">
                                    <i class="icon-Settings-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span>Profile</span>
                                </a>
                            </li>

                        </ul>

                       
                    </div>
                </div>
            </section>
        </aside>