

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper rounded-0">
            <div class="container-full ">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xxxl-9 col-xl-12 col-12">
                            <div class="row">
                                <div class="col-xxxl-3 col-xl-4 col-lg-12  col-12">
                                    <div class="box-body">
                                        <div class="media-list">
                                            <?php foreach ($patient_materials as $patient_material) { 
										
										$extension_url = explode(".", $patient_material->url);

										$length = count($extension_url);
										$extension = $extension_url[$length - 1];
										if (strtolower($extension) == 'pdf') {
											$files = '<a class="align-self-start ms-0" href="' . $patient_material->url . '" data-title="' . $patient_material->title . '" target="_blank">' . '<img class="avatar avatar-xl bg-white shadow rounded-circle pull-up" src="uploads/image/pdf.png" width="100px" height="100px"alt="image-1">' . '</a>';
										} elseif (strtolower($extension) == 'docx') {
											$files = '<a class="align-self-start ms-0" href="' . $patient_material->url . '" data-title="' . $patient_material->title . '">' . '<img class="avatar avatar-xl bg-white shadow rounded-circle pull-up" src="uploads/image/docx.png" width="100px" height="100px"alt="image-1">' . '</a>';
										} elseif (strtolower($extension) == 'doc') {
											$files = '<a class="align-self-start ms-0" href="' . $patient_material->url . '" data-title="' . $patient_material->title . '">' . '<img class="avatar avatar-xl bg-white shadow rounded-circle pull-up" src="uploads/image/doc.png" width="100px" height="100px"alt="image-1">' . '</a>';
										} elseif (strtolower($extension) == 'odt') {
											$files = '<a class="align-self-start ms-0" href="' . $patient_material->url . '" data-title="' . $patient_material->title . '">' . '<img class="avatar avatar-xl bg-white shadow rounded-circle pull-up" src="uploads/image/odt.png" width="100px" height="100px"alt="image-1">' . '</a>';
										} else {
											$files = '<a class="align-self-start ms-0" href="' . $patient_material->url . '" data-lightbox="example-1" data-title="' . $patient_material->title . '">' . '<img class="avatar avatar-xl bg-white shadow rounded-circle pull-up" src="' . $patient_material->url . '" width="100px" height="100px"alt="image-1">' . '</a>';
										}
										     
										
										?>
                                            <div class="media p-0 bar-0 mb-30">
                                                <?php echo $files; ?>
                                                <div class="media-body align-self-center">
                                                    <p class="mb-0">
                                                        <a
                                                            class="hover-success fs-16"><?php echo $patient_material->title; ?></a>
                                                        <a class="btn btn-soft-info btn-xs btn_width float-end text-fade"
                                                            href="<?php echo $patient_material->url; ?>" download><i
                                                                class="fa fa-download"></i> </a>
                                                    </p>
                                                    <div class="w-p100">
                                                        <div class="progress progress-sm mb-0 mt-5">
                                                            <div class="progress-bar bg-lightgreen" role="progressbar"
                                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>






                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxxl-5 col-xl-4 col-lg-6 col-12">
                                    <div class="box">
                                        <div class="box-body d-flex p-0">
                                            <div
                                                class="flex-grow-1 px-30 pt-20 pb-20 flex-grow-1 bg-img min-h-350 back-body">
                                                <h1 class="fw-400">Body <br>Vitals</h1>
                                                <div class="w-p50">
                                                    <div id="donut-chart" style="max-height: 180px;"></div>
                                                </div>
                                                <div>
                                                    <div class="row mt-20">
                                                        <div class="col-xxxl-5 col-xl-6 col-lg-5 col-md-5 col-sm-5">
                                                            <div class="align-items-start mb-20">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-lightgreen p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0"><?php echo $vitals->heart_rate; ?> <span
                                                                        class="text-fade ms-10">
                                                                        <?php echo lang('heart_rate'); ?>(bpm)</span>
                                                                </p>
                                                            </div>
                                                            <div class="align-items-start mb-20">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-lightorange p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <?php echo $vitals->systolic_blood_pressure; ?>/<?php echo $vitals->diastolic_blood_pressure; ?>
                                                                    <span class="text-fade ms-10">
                                                                        <?php echo lang('blood_pressure'); ?>(mmHg)</span>
                                                                </p>
                                                            </div>
                                                            <div class="align-items-start mb-5">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-lilac p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0"><?php echo $vitals->temperature; ?>
                                                                    <span class="text-fade ms-0 ms-xl-10">
                                                                        <?php echo lang('temp'); ?>(&deg;C)</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-5">
                                                            <div class="align-items-start mb-20">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-Tacha p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <?php echo $vitals->oxygen_saturation; ?> <span
                                                                        class="text-fade ms-10">
                                                                        <?php echo lang('oxygen_saturation'); ?>(%)</span>
                                                                </p>
                                                            </div>
                                                            <div class="align-items-start mb-20">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-purple p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0"><?php echo $vitals->respiratory_rate; ?>
                                                                    <span class="text-fade ms-10">
                                                                        <?php echo lang('respiratory_rate'); ?>(bpm)</span>
                                                                </p>
                                                            </div>
                                                            <div class="align-items-start mb-5">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-shadow-green p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0"><?php echo $vitals->bmi_weight; ?> <span
                                                                        class="text-fade ms-10">
                                                                        <?php echo lang('bmi_weight'); ?>(Kg)</span></p>
                                                            </div>
                                                            <div class="align-items-start mb-5">
                                                                <p class="m-0"><span
                                                                        class="badge badge-sm bg-shadow-green p-1 w-20"></span>
                                                                </p>
                                                                <p class="mb-0"><?php echo $vitals->bmi_height; ?> <span
                                                                        class="text-fade ms-10">
                                                                        <?php echo lang('bmi_height'); ?>(Cm)</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxxl-4 col-xl-4 col-lg-6 col-12 ">
                                    <div class="box pull-up">
                                        <div class="flexbox align-items-center px-20 pt-20">
                                            <label class="toggler toggler-danger fs-16">
                                                <input type="checkbox" checked="">
                                            </label>
                                            <div class="dropdown">
                                                <a data-bs-toggle="dropdown" href="#" aria-expanded="false" class=""><i
                                                        class="ti-settings text-fade"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    <a class="dropdown-item" href="profile"><i class="fa fa-user"></i>
                                                        Profile</a>
                                                    <a class="dropdown-item" href="home"><i class="fa fa-picture-o"></i>
                                                        Dashboard</a>
                                                    <a class="dropdown-item" href="auth/logout"><i class="ti-check"></i>
                                                        Logout</a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body px-0 pt-0 bb-1 text-center">
                                            <div class="avatar avatar-xl">
                                                <img src="<?php echo $patient->img_url; ?>"
                                                    class="rounded-circle bg-lightgreen" alt="">
                                            </div>
                                            <h4 class="mt-20 mb-0"><?php echo $patient->name; ?></h4>
                                            <p class="mb-0 text-light"><?php echo lang('address'); ?> :
                                                <?php echo $patient->address; ?></p>
                                            <div class="mt-20">
                                                <div class="row justify-content-center text-start">
                                                    <label
                                                        class="col-xxxl-3 col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3  text-light"><?php echo lang('gender'); ?></label>
                                                    <div class="col-xxxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <p class="mb-0">: <?php echo $patient->sex; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center text-start mt-10">
                                                    <label
                                                        class="col-xxxl-3 col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3  text-light"><?php echo lang('birth_date'); ?></label>
                                                    <div class="col-xxxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <p class="mb-0">: <?php echo $patient->birthdate; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center text-start mt-10">
                                                    <label
                                                        class="col-xxxl-3 col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3 text-light"><?php echo lang('phone'); ?></label>
                                                    <div class="col-xxxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                                        <p class="mb-0">: <?php echo $patient->phone; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-12">
                                        <div class="box" style="height: 300px; overflow: auto;">
                                            <div class="box-header">
                                                <h4 class="box-title">Upcoming Appointments</h4>
                                            </div>
                                            
                                            <div class="box-body">
                                                <div class="inner-user-div4">
												<?php foreach ($appointments as $appointment) { ?>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-10">
                                                            <div class="me-15">
                                                                <img src="doclinic/images/avatar/4.jpg"
                                                                    class="avatar avatar-lg rounded10 bg-primary-light"
                                                                    alt="" />
                                                            </div>
                                                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                                                <p class="hover-primary text-fade mb-1 fs-14"><?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $appointment_doctor = $doctor_details->name;
                                                        } else {
                                                            $appointment_doctor = '';
                                                        }
                                                        echo $appointment_doctor;
                                                        ?></p>
                                                                <span class="text-dark fs-16"><?php
                                                        if ($appointment->status == 'Pending Confirmation') {
                                                            $appointment_status = lang('pending');
                                                        } elseif ($appointment->status == 'Confirmed') {
                                                            $appointment_status = lang('confirmed');
                                                        } elseif ($appointment->status == 'Treated') {
                                                            $appointment_status = lang('treated');
                                                        } elseif ($appointment->status == 'Cancelled') {
                                                            $appointment_status = lang('cancelled');
                                                        } elseif ($appointment->status == 'Requested') {
                                                            $appointment_status = lang('requested');
                                                        }
                                                        echo $appointment_status;
                                                        ?></span>
                                                            </div>
                                                            <div>
                                                                <a href="javascript:void(0);"
                                                                    class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm"><i
                                                                        class="fa fa-phone"></i></a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                                            <div>
                                                                <p class="mb-0 text-muted"><i
                                                                        class="fa fa-clock-o me-5"></i> <?php echo date('d-m-Y', $appointment->date); ?> <?php echo $appointment->time_slot; ?> <span
                                                                        class="mx-20"><?php echo $settings->currency . $appointment->visit_charges; ?></span></p>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
													<?php } ?>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="col-xl-4 col-12">
                                        <div class="box" style="height: 300px; overflow: auto;">
                                            <div class="box-header">
                                                <h4 class="box-title">Case History</h4>
                                            </div>
                                            
                                            <div class="box-body">
                                                <div class="inner-user-div4">
												<?php foreach ($medical_histories as $medical_history) { ?>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-10">
                                                            <div class="me-15">
                                                                <img src="doclinic/images/avatar/4.jpg"
                                                                    class="avatar avatar-lg rounded10 bg-primary-light"
                                                                    alt="" />
                                                            </div>
                                                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                                                <p class="hover-primary text-fade mb-1 fs-14"><?php echo $medical_history->title; ?></p>
                                                                <span class="text-dark fs-16"><?php echo $medical_history->description; ?></span>
                                                            </div>
                                                            <div>
                                                                <a href="javascript:void(0);"
                                                                    class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm"><i
                                                                        class="fa fa-phone"></i></a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                                            <div>
                                                                <p class="mb-0 text-muted"><i
                                                                        class="fa fa-clock-o me-5"></i>  <?php echo date('d-m-Y', $medical_history->date); ?> </p>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
													<?php } ?>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                


									<div class="col-xl-4 col-12">
                                        <div class="box" style="height: 300px; overflow: auto;">
                                            <div class="box-header">
                                                <h4 class="box-title">Prescriptions</h4>
                                            </div>
                                            
                                            <div class="box-body">
                                                <div class="inner-user-div4">
												<?php foreach ($prescriptions as $prescription) { ?>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-10">
                                                            <div class="me-15">
                                                                <img src="doclinic/images/avatar/4.jpg"
                                                                    class="avatar avatar-lg rounded10 bg-primary-light"
                                                                    alt="" />
                                                            </div>
                                                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                                                <p class="hover-primary text-fade mb-1 fs-14"><?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $prescription_doctor = $doctor_details->name;
                                                        } else {
                                                            $prescription_doctor = '';
                                                        }
                                                        echo $prescription_doctor;
                                                        ?></p>
                                                                <span class="text-dark fs-16"><?php
                                                        if (!empty($prescription->medicine)) {
                                                            $medicine = explode('###', $prescription->medicine);

                                                            foreach ($medicine as $key => $value) {
                                                                $medicine_id = explode('***', $value);
                                                                $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                                                                if (!empty($medicine_details)) {
                                                                    $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                                                                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                                                                    rtrim($medicine_name_with_dosage, ',');
                                                                    echo '<p>' . $medicine_name_with_dosage . '</p>';
                                                                }
                                                            }
                                                        }
                                                        ?></span>
                                                            </div>
                                                            <div>
                                                                <a href="prescription/viewPrescription?id=<?php echo $prescription->id; ?>"
                                                                    class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                                            <div>
                                                                <p class="mb-0 text-muted"><i
                                                                        class="fa fa-clock-o me-5"></i>  <?php echo date('m/d/Y', $prescription->date); ?> </p>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
													<?php } ?>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>



									<div class="col-xl-4 col-12">
                                        <div class="box" style="height: 300px; overflow: auto;">
                                            <div class="box-header">
                                                <h4 class="box-title">Lab Report</h4>
                                            </div>
                                            
                                            <div class="box-body">
                                                <div class="inner-user-div4">
												<?php foreach ($labs as $lab) {
                                                if ($lab->status == 'completed') {
                                            ?>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-10">
                                                            <div class="me-15">
                                                                <img src="doclinic/images/avatar/4.jpg"
                                                                    class="avatar avatar-lg rounded10 bg-primary-light"
                                                                    alt="" />
                                                            </div>
                                                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                                                <p class="hover-primary text-fade mb-1 fs-14"><?php
                                                            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
                                                            if (!empty($doctor_details)) {
                                                                $lab_doctor = $doctor_details->name;
                                                            } else {
                                                                $lab_doctor = '';
                                                            }
                                                            echo $lab_doctor;
                                                            ?></p>
                                                               
                                                            </div>
                                                            <div>
                                                                <a href="lab/invoice?id=<?php echo $lab->id; ?>"
                                                                    class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                                            <div>
                                                                <p class="mb-0 text-muted"><i
                                                                        class="fa fa-clock-o me-5"></i>  <?php echo date('m/d/Y', $lab->date); ?> </p>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
													<?php } } ?>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            </div>
                        </div>
                        <div class="col-xxxl-3 col-xl-12 col-12">
                            <div class="row">
                                <div class="col-xxxl-12 col-xl-8 col-lg-6">
                                    <div class="box mb-20 calendar-box">
                                        <div class="box-body">
                                            <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxxl-12 col-xl-4 col-lg-6">
                                    <div class="box box-solid  bg-lightgreen mb-15 pull-up">
                                        <div class="box-header with-border bg-temple-dark">
                                            <div>
                                                <h3 class="box-title">Bed Details</h3>
                                                
                                            </div>
                                            
                                        </div>
										<?php foreach ($beds as $bed) { ?>
                                        <div class="box-body">
                                            <h4 class="mt-0 text-dark mb-10"><?php echo lang('bed_id'); ?> : <?php echo $bed->bed_id; ?></h4>
                                            </h4>
                                            <p class="mb-5"><?php echo lang('alloted_time'); ?> : <?php echo $bed->a_time; ?></p>
											<p class="mb-5"><?php echo lang('discharge_time'); ?> : <?php echo $bed->d_time; ?></p>
											<?php if (!empty($bed->d_time)) { ?>
                                            <a href="bed/dischargeReport?id=<?php echo $bed->id; ?>" class="fw-500 text-light hover-primary "><i
                                                    class="mdi mdi-attachment text-lightgreen rotate-90 fs-18"></i>
													<?php echo lang('discharge_report'); ?></a>
												<?php } ?>
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
       