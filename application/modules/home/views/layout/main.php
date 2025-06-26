

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xxxl-9 col-xl-8 col-12">
					<!-- <div class="box">
						<div class="box-body">
							<div class="d-md-flex align-items-center text-md-start text-center">
								<div class="me-md-30">
									<img src="doclinic/images/svg-icon/color-svg/custom-21.svg" alt="" class="w-150" />
								</div>
								<div class="d-lg-flex w-p100 align-items-center justify-content-between">
									<div class="me-lg-10 mb-lg-0 mb-10">
										<h3 class="mb-0">Today - 20% Discount on Lung Examinations</h3>
										<p class="mb-0 fs-16">The Package price includes: consultoin of a pulmonolgist, spirogrphy, cardiogram</p>									
									</div>
									<div>
										<a href="#" class="waves-effect waves-light btn btn-primary text-nowrap">Know More</a>								
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<div class="row">
						<div class="col-lg-4 col-12">
							<div class="box">
								<div class="box-body">
									<div class="d-flex align-items-center">
										<div class="me-15">
											<img src="doclinic/images/svg-icon/color-svg/custom-20.svg" alt="" class="w-120" />
										</div>
										<div>
											<h4 class="mb-0">Total Patients</h4>
											<h3 class="mb-0"><?php 
                $total_patient = $this->db->get_where('patient', array('hospital_id' => $this->session->userdata('hospital_id')))->num_rows();
                echo $total_patient;
                ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="box">
								<div class="box-body">
									<div class="d-flex align-items-center">
										<div class="me-15">
											<img src="doclinic/images/svg-icon/color-svg/custom-18.svg" alt="" class="w-120" />
										</div>
										<div>
											<h4 class="mb-0">Total Doctors</h4>
											<h3 class="mb-0"><?php 
                $total_doctor = $this->db->get_where('doctor', array('hospital_id' => $this->session->userdata('hospital_id')))->num_rows();
                echo $total_doctor;
                ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="box">
								<div class="box-body">
									<div class="d-flex align-items-center">
										<div class="me-15">
											<img src="doclinic/images/svg-icon/color-svg/custom-19.svg" alt="" class="w-120" />
										</div>
										<div>
											<h4 class="mb-0">Total Invoice</h4>
											<h3 class="mb-0"><?php 
                $total_invoice = $this->db->get_where('payment', array('hospital_id' => $this->session->userdata('hospital_id')))->num_rows();
                echo $total_invoice;
                ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-12">						
							<div class="box">
								<div class="box-header">
									<h4 class="box-title">Patient Statistics</h4>
								</div>
								<div class="box-body">							
									<div id="patient_statistics"></div>							
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-12">						
							<div class="box">
								<div class="box-header">
									<h4 class="box-title">Income and Expense Statistics</h4>
								</div>
								<div class="box-body">
									<div id="recovery_statistics"></div>						
								</div>
							</div>	
						</div>
						<div class="col-12">
						  <div class="box">
							<div class="box-header with-border">
							  <h4 class="box-title">All Admissions</h4>
							  <div class="box-controls pull-right">
								<div class="lookup lookup-circle lookup-right">
								  <input type="text" name="s">
								</div>
							  </div>
							</div>
							<div class="box-body no-padding">
								<div class="table-responsive">
								  	<table class="table mb-0">
										<tbody>
											<tr class="bg-info-light">
											
                                <th><?php echo lang('bed_id'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('doctor'); ?></th>
                                <th><?php echo lang('admission_time'); ?></th>
                                <th><?php echo lang('discharge_time'); ?></th>
                                <th><?php echo lang('due'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
											<?php  $alloted_beds = $this->bed_model->getAllotment(); 
											foreach ($alloted_beds as $bed) {
												$patientdetails = $this->patient_model->getPatientById($bed->patient);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $bed->patientname;
            }

            $doctorDetails = $this->doctor_model->getDoctorById($bed->doctor);
            if (!empty($doctorDetails)) {
                $doctorname = $doctorDetails->name;
            } else {
                $doctortname = '';
            }
			$bed_display_id = $bed->bed_display_id;
            if (empty($bed_display_id)) {
                $bed_display_id = $bed_details->category . '-' . $bed_details->number;
            }

            $due = $this->bed_model->getAllBedPaymentsSummary($bed->id)['due'];
            $due_formated = number_format($due, 2);
											?>
											<tr>
											  <td><?php echo $bed_display_id; ?></td>
											  <td><strong><?php echo $patientname; ?></strong></td>
											  <td><?php echo $doctorname; ?></td>
											  <td><?php echo $bed->a_time; ?></td>
											  <td><?php echo $bed->d_time; ?></td>
											  <td><?php echo $settings->currency . $due_formated; ?></td>
											  
											  <td>
												  <div class="d-flex">
												  	  <a href="bed/billDetails?id=<?php echo $bed->id; ?>" class="waves-effect waves-circle btn btn-circle btn-success btn-xs me-5"><i class="fa fa-eye"></i></a>
													  
												  </div>
											  </td>
											</tr>
											<?php } ?>
											
										</tbody>
									</table>
								</div>
							</div>							
							<div class="box-footer bg-light py-10 with-border">
							    <div class="d-flex align-items-center justify-content-between">
									
									<a type="button" href="bed/bedAllotment" class="waves-effect waves-light btn btn-primary">View All</a>
								</div>
							</div>
						  </div>
						</div>
						
						
					</div>
				</div>
				<div class="col-xxxl-3 col-xl-4 col-12">
					<div class="box">
						<div class="box-header">
							<h4 class="box-title">Total Patient</h4>
						</div>
						<div class="box-body">							
							<div id="total_patient"></div>							
						</div>
					</div>
					
					<div class="box">
						<div class="box-header with-border">
							<h4 class="box-title">Doctor List</h4>
							
						</div>
						<div class="box-body">
							<div class="inner-user-div3">
								<?php $doctors = $this->doctor_model->getDoctor();
								foreach ($doctors as $doctor) { ?>
								  
								
								<div class="d-flex align-items-center mb-30">
									<div class="me-15">
										<img src="<?php echo $doctor->img_url; ?>" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
									</div>
									<div class="d-flex flex-column flex-grow-1 fw-500">
										<a href="#" class="text-dark hover-primary mb-1 fs-16"><?php echo $doctor->name; ?></a>
										<span class="text-fade"><?php echo $doctor->department_name; ?></span>
									</div>
									
								</div>
								<?php } ?>
					
								
							</div>
						</div>
					</div>
				</div>
			</div>			
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
  <!-- <script src="doclinic/main/js/vendors.min.js"></script> -->
	
  <script>
	//[Dashboard Javascript]

//Project:	Doclinic - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

'use strict';
  
  
var options = {
  series: [{
    name: 'OPD',
    data: [
      <?php
      $year = date('Y');
      for($i = 1; $i <= 12; $i++) {
        $start_date = strtotime("$year-$i-01");
        $end_date = strtotime(date('Y-m-t', strtotime("$year-$i-01")));
        
        // Get total patients for this month
        $total = $this->db->query("SELECT COUNT(*) as total FROM patient 
                                  WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                  AND registration_time BETWEEN $start_date AND $end_date")->row()->total;
        
        // Get admitted patients for this month
        $admitted = $this->db->query("SELECT COUNT(*) as total FROM alloted_bed 
                                    WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                    AND a_time IS NOT NULL 
                                    AND d_time IS NULL 
                                    AND UNIX_TIMESTAMP(STR_TO_DATE(a_time, '%d %M %Y - %h:%i %p')) 
                                    BETWEEN $start_date AND $end_date")->row()->total;
        
        // OPD = Total - Admitted
        $opd = $total - $admitted;
        echo $opd . ($i < 12 ? "," : "");
      }
      ?>
    ]
  }, {
    name: 'Admitted',
    data: [
      <?php
      $year = date('Y');
      for($i = 1; $i <= 12; $i++) {
        $start_date = strtotime("$year-$i-01");
        $end_date = strtotime(date('Y-m-t', strtotime("$year-$i-01")));
        
        $admitted = $this->db->query("SELECT COUNT(*) as total FROM alloted_bed 
                                    WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                    AND a_time IS NOT NULL 
                                    AND d_time IS NULL 
                                    AND UNIX_TIMESTAMP(STR_TO_DATE(a_time, '%d %M %Y - %h:%i %p')) 
                                    BETWEEN $start_date AND $end_date")->row()->total;
        echo $admitted . ($i < 12 ? "," : "");
      }
      ?>
    ]
  }],
  chart: {
    type: 'bar',
    foreColor:"#bac0c7",
    height: 260,
    stacked: true,
    toolbar: {
      show: false,
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '30%',
    },
  },
  dataLabels: {
    enabled: false,
  },
  grid: {
    show: true,			
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  colors: ['#5156be', '#ffa800'],
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  yaxis: {
    title: {
      text: 'Number of Patients'
    }
  },
  legend: {
    show: true,
    position: 'top',
  },
  fill: {
    opacity: 1
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + " patients"
      }
    },
    marker: {
      show: false,
    },
  }
};

var chart = new ApexCharts(document.querySelector("#patient_statistics"), options);
chart.render();
  
  
	  
	  
  
var options = {
  series: [
    {
      name: "Income",
      data: [
        <?php
        $year = date('Y');
        for($i = 1; $i <= 12; $i++) {
          $start_date = strtotime("$year-$i-01");
          $end_date = strtotime(date('Y-m-t', strtotime("$year-$i-01")));
          
          $income = $this->db->query("SELECT COALESCE(SUM(gross_total), 0) as total FROM payment 
                                    WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                    AND date BETWEEN $start_date AND $end_date")->row()->total;
          echo $income . ($i < 12 ? "," : "");
        }
        ?>
      ]
    },
    {
      name: "Expense",            
      data: [
        <?php
        for($i = 1; $i <= 12; $i++) {
          $start_date = strtotime("$year-$i-01");
          $end_date = strtotime(date('Y-m-t', strtotime("$year-$i-01")));
          
          $expense = $this->db->query("SELECT COALESCE(SUM(amount), 0) as total FROM expense 
                                     WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                     AND date BETWEEN $start_date AND $end_date")->row()->total;
          echo $expense . ($i < 12 ? "," : "");
        }
        ?>
      ]
    }
  ],
  chart: {
    height: 260,
    type: 'line',
    foreColor:"#bac0c7",
    dropShadow: {
      enabled: true,
      color: '#000',
      top: 18,
      left: 7,
      blur: 10,
      opacity: 0.2
    },
    toolbar: {
      show: false
    }
  },
  colors: ['#5156be', '#da123b'],
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: 'smooth'
  },
  grid: {
    borderColor: '#e7e7e7',
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  yaxis: {
    title: {
      text: 'Amount'
    },
    labels: {
      formatter: function(val) {
        return val.toFixed(2)
      }
    }
  },
  legend: {
    show: true,
    position: 'top',
  },
  tooltip: {
    y: {
      formatter: function(val) {
        return val.toFixed(2)
      }
    }
  }
};

var chart = new ApexCharts(document.querySelector("#recovery_statistics"), options);
chart.render();
  
  
  
// ... existing code ...

var options = {
  series: [{
    name: 'Total Patient',
    type: 'column',
    data: [
      <?php
      $year = date('Y');
      for($i = 1; $i <= 12; $i++) {
        $start_date = strtotime("$year-$i-01");
        $end_date = strtotime(date('Y-m-t', strtotime("$year-$i-01")));
        
        $total = $this->db->query("SELECT COUNT(*) as total FROM patient 
                                  WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                  AND registration_time BETWEEN $start_date AND $end_date")->row()->total;
        echo $total . ($i < 12 ? "," : "");
      }
      ?>
    ]
  }, {
    name: 'Discharge Patient', 
    type: 'line',
    data: [
      <?php
      $year = date('Y');
      for($i = 1; $i <= 12; $i++) {
        $start_date = "$year-$i-01";
        $end_date = date('Y-m-t', strtotime("$year-$i-01"));
        
        $discharged = $this->db->query("SELECT COUNT(*) as total FROM alloted_bed 
                                       WHERE hospital_id = ".$this->session->userdata('hospital_id')." 
                                       AND STR_TO_DATE(d_time, '%d %M %Y - %h:%i %p') 
                                       BETWEEN '$start_date' AND '$end_date'")->row()->total;
        echo $discharged . ($i < 12 ? "," : "");
      }
      ?>
    ]
  }],
  chart: {
    height: 350,
    type: 'line',
    toolbar: {
      show: false,
    }
  },
  stroke: {
    width: [0, 4],
    curve: 'smooth'
  },
  colors: ['#E7E4FF', '#5156be'],
  dataLabels: {
    enabled: false,
  },
  labels: [
    <?php
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
               'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    foreach($months as $i => $month) {
      echo "'" . $month . "'" . ($i < 11 ? "," : "");
    }
    ?>
  ],
  xaxis: {
    type: 'category'
  },
  legend: {
    show: true,
    position: 'top',
  }
};

var chart = new ApexCharts(document.querySelector("#total_patient"), options);
chart.render();

// ... rest of the code ...
  
	  $('.inner-user-div3').slimScroll({
		  height: '310px'
	  });
  
	  $('.inner-user-div4').slimScroll({
		  height: '127px'
	  });
  
	  $('.owl-carousel').owlCarousel({
		  loop: true,
		  margin: 0,
		  responsiveClass: true,
		  autoplay: true,
		  dots: false,
		  nav: true,
		  responsive: {
			0: {
			  items: 1,
			},
			600: {
			  items: 1,
			},
			1000: {
			  items: 1,
			}
		  }
		});
  
}); // End of use strict

  </script>
 