<?php if ($this->ion_auth->in_group(array('superadmin'))) {  ?>

<script type="text/javascript" src="common/js/google-loader.js"></script>
<link href="common/css/bootstrap-reset.css" rel="stylesheet">
<link href="common/extranal/css/home.css" rel="stylesheet">
<?php } ?>


             
    <div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
    <?php if (isset($laboratorist_dashboard) && $laboratorist_dashboard) { ?>
        <!-- Advanced Laboratorist Dashboard -->
        <style>
            .lab-dashboard {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 20px;
                overflow: hidden;
                position: relative;
            }
            .lab-dashboard::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
                opacity: 0.3;
            }
            .lab-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 15px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .lab-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            .lab-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
                background-size: 400% 400%;
                animation: gradientShift 3s ease infinite;
            }
            @keyframes gradientShift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                margin-bottom: 15px;
                position: relative;
                overflow: hidden;
            }
            .stat-icon::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                transition: left 0.5s;
            }
            .lab-card:hover .stat-icon::before {
                left: 100%;
            }
            .progress-ring {
                width: 80px;
                height: 80px;
                position: relative;
            }
            .progress-ring svg {
                width: 100%;
                height: 100%;
                transform: rotate(-90deg);
            }
            .progress-ring circle {
                fill: none;
                stroke-width: 6;
                stroke-linecap: round;
            }
            .progress-bg {
                stroke: rgba(0,0,0,0.1);
            }
            .progress-bar {
                stroke-dasharray: 251.2;
                stroke-dashoffset: 251.2;
                animation: progressAnimation 2s ease-out forwards;
            }
            @keyframes progressAnimation {
                to { stroke-dashoffset: calc(251.2 - (251.2 * var(--progress)) / 100); }
            }
            .floating-elements {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }
            .floating-element {
                position: absolute;
                opacity: 0.1;
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }
            .activity-timeline {
                position: relative;
                padding-left: 30px;
            }
            .activity-timeline::before {
                content: '';
                position: absolute;
                left: 15px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: linear-gradient(to bottom, #4ecdc4, #44a08d);
            }
            .activity-item {
                position: relative;
                margin-bottom: 20px;
                background: rgba(255,255,255,0.8);
                padding: 15px;
                border-radius: 10px;
                border-left: 3px solid #4ecdc4;
            }
            .activity-item::before {
                content: '';
                position: absolute;
                left: -23px;
                top: 20px;
                width: 12px;
                height: 12px;
                background: #4ecdc4;
                border-radius: 50%;
                border: 3px solid white;
            }
            .quick-action-btn {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 12px;
                color: white;
                padding: 12px 20px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .quick-action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
                color: white;
            }
            .quick-action-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }
            .quick-action-btn:hover::before {
                left: 100%;
            }
            .alert-card {
                background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
                border: none;
                border-radius: 15px;
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.02); }
            }
            .data-visualization {
                background: rgba(255,255,255,0.9);
                border-radius: 15px;
                padding: 20px;
                position: relative;
                overflow: hidden;
            }
            .chart-container {
                position: relative;
                height: 200px;
            }
        </style>

        <!-- Hero Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card lab-dashboard">
                    <div class="floating-elements">
                        <i class="fas fa-flask floating-element" style="top: 10%; left: 10%; font-size: 30px; animation-delay: 0s;"></i>
                        <i class="fas fa-microscope floating-element" style="top: 20%; right: 15%; font-size: 25px; animation-delay: 1s;"></i>
                        <i class="fas fa-vial floating-element" style="bottom: 20%; left: 20%; font-size: 20px; animation-delay: 2s;"></i>
                        <i class="fas fa-dna floating-element" style="bottom: 10%; right: 10%; font-size: 35px; animation-delay: 3s;"></i>
                    </div>
                    <div class="card-body text-center position-relative" style="z-index: 2;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="text-white mb-3">
                                    <i class="fas fa-atom me-3"></i>
                                    Advanced Laboratory Control Center
                                </h2>
                                <p class="text-white-50 mb-4 fs-5">
                                    Precision diagnostics, intelligent inventory management, and seamless workflow automation
                                </p>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <a href="lab" class="quick-action-btn">
                                        <i class="fas fa-flask me-2"></i>Lab Tests
                                    </a>
                                    <a href="inventory" class="quick-action-btn">
                                        <i class="fas fa-cubes me-2"></i>Inventory
                                    </a>
                                    <a href="labworkflow" class="quick-action-btn">
                                        <i class="fas fa-project-diagram me-2"></i>Workflow
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="progress-ring mx-auto">
                                    <svg>
                                        <circle class="progress-bg" cx="40" cy="40" r="35"></circle>
                                        <circle class="progress-bar" cx="40" cy="40" r="35" 
                                                style="--progress: 85; stroke: #4ecdc4;"></circle>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <div class="text-white fw-bold fs-4">85%</div>
                                        <div class="text-white-50 small">Efficiency</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card lab-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #ff6b6b, #ee5a52);">
                            <i class="fas fa-flask text-white"></i>
                        </div>
                        <h3 class="fw-bold text-danger mb-1"><?php echo isset($lab_stats['pending_tests']) ? $lab_stats['pending_tests'] : '12'; ?></h3>
                        <p class="text-muted mb-3">Pending Tests</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: 65%"></div>
                        </div>
                        <a href="lab/testStatus" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-eye me-1"></i>View Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card lab-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #4ecdc4, #44a08d);">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1"><?php echo isset($lab_stats['completed_today']) ? $lab_stats['completed_today'] : '28'; ?></h3>
                        <p class="text-muted mb-3">Completed Today</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                        <a href="lab" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-chart-line me-1"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card lab-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #feca57, #ff9ff3);">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1"><?php echo isset($inventory_stats['low_stock_count']) ? $inventory_stats['low_stock_count'] : '5'; ?></h3>
                        <p class="text-muted mb-3">Low Stock Items</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 35%"></div>
                        </div>
                        <a href="inventory/alerts" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-bell me-1"></i>View Alerts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card lab-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #45b7d1, #96c93d);">
                            <i class="fas fa-vial text-white"></i>
                        </div>
                        <h3 class="fw-bold text-info mb-1"><?php echo isset($lab_stats['specimens_today']) ? $lab_stats['specimens_today'] : '15'; ?></h3>
                        <p class="text-muted mb-3">Specimens Today</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 75%"></div>
                        </div>
                        <a href="labworkflow/specimens" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-microscope me-1"></i>View Specimens
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Activity Timeline -->
            <div class="col-lg-4 mb-4">
                <div class="card lab-card h-100">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock text-primary me-2"></i>
                            Recent Activity
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">Blood Test Completed</h6>
                                        <p class="text-muted small mb-0">Patient ID: #12345</p>
                                    </div>
                                    <span class="badge bg-success">2 min ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">Inventory Updated</h6>
                                        <p class="text-muted small mb-0">Reagent restocked</p>
                                    </div>
                                    <span class="badge bg-info">15 min ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">New Specimen Received</h6>
                                        <p class="text-muted small mb-0">Urine sample - Lab #789</p>
                                    </div>
                                    <span class="badge bg-warning">1 hour ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">View All Activities</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Data Visualization -->
            <div class="col-lg-8 mb-4">
                <div class="row">
                    <!-- Quick Actions -->
                    <div class="col-12 mb-4">
                        <div class="card lab-card">
                            <div class="card-header bg-transparent border-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-bolt text-warning me-2"></i>
                                    Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3 col-sm-6">
                                        <a href="lab/addTest" class="btn quick-action-btn w-100">
                                            <i class="fas fa-plus-circle mb-2 d-block"></i>
                                            New Test
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="inventory/addItem" class="btn quick-action-btn w-100">
                                            <i class="fas fa-cube mb-2 d-block"></i>
                                            Add Item
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="labworkflow/addSpecimen" class="btn quick-action-btn w-100">
                                            <i class="fas fa-vial mb-2 d-block"></i>
                                            Log Specimen
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <a href="inventory/reports" class="btn quick-action-btn w-100">
                                            <i class="fas fa-chart-bar mb-2 d-block"></i>
                                            Reports
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Visualization -->
                    <div class="col-12">
                        <div class="card lab-card">
                            <div class="card-header bg-transparent border-0">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-line text-success me-2"></i>
                                    Performance Analytics
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="data-visualization">
                                            <h6 class="text-center mb-3">Test Completion Rate</h6>
                                            <div class="chart-container">
                                                <canvas id="testCompletionChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="data-visualization">
                                            <h6 class="text-center mb-3">Inventory Status</h6>
                                            <div class="chart-container">
                                                <canvas id="inventoryChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts Section -->
        <?php if (isset($inventory_stats['alerts']) && !empty($inventory_stats['alerts'])) : ?>
        <div class="row">
            <div class="col-12">
                <div class="card alert-card">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Critical Inventory Alerts
                        </h5>
                        <div class="row">
                            <?php foreach ($inventory_stats['alerts'] as $alert) : ?>
                                <div class="col-md-6 mb-3">
                                    <div class="alert alert-light border-0 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $alert->item_name; ?></strong>
                                                <p class="mb-0 small"><?php echo $alert->message; ?></p>
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger" onclick="markAlertRead(<?php echo $alert->id; ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Chart.js Integration -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Test Completion Chart
            const testCtx = document.getElementById('testCompletionChart').getContext('2d');
            new Chart(testCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending', 'In Progress'],
                    datasets: [{
                        data: [65, 20, 15],
                        backgroundColor: ['#4ecdc4', '#ff6b6b', '#feca57'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Inventory Chart
            const invCtx = document.getElementById('inventoryChart').getContext('2d');
            new Chart(invCtx, {
                type: 'bar',
                data: {
                    labels: ['Reagents', 'Consumables', 'Equipment'],
                    datasets: [{
                        label: 'Stock Level',
                        data: [85, 45, 92],
                        backgroundColor: ['#45b7d1', '#96c93d', '#667eea'],
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Alert management
            function markAlertRead(alertId) {
                $.ajax({
                    url: 'inventory/markAlertRead/' + alertId,
                    type: 'POST',
                    success: function(response) {
                        location.reload();
                    }
                });
            }

            // Add some interactive animations
            document.addEventListener('DOMContentLoaded', function() {
                // Animate progress bars
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.transition = 'width 1.5s ease-in-out';
                        bar.style.width = width;
                    }, 500);
                });

                // Add hover effects to cards
                const labCards = document.querySelectorAll('.lab-card');
                labCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-5px)';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
        
    <?php } elseif ($this->ion_auth->in_group(array('admin'))) { ?> 
        <!-- start page title -->
        
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="text-center">
                            <ul class="bg-bubbles ps-0">
                                <li><i class="bx bx-grid-alt font-size-24"></i></li>
                                <li><i class="bx bx-tachometer font-size-24"></i></li>
                                <li><i class="bx bx-store font-size-24"></i></li>
                                <li><i class="bx bx-cube font-size-24"></i></li>
                                <li><i class="bx bx-cylinder font-size-24"></i></li>
                                <li><i class="bx bx-command font-size-24"></i></li>
                                <li><i class="bx bx-hourglass font-size-24"></i></li>
                                <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                                <li><i class="bx bx-coffee font-size-24"></i></li>
                                <li><i class="bx bx-polygon font-size-24"></i></li>
                            </ul>
                           <div class="main-wid position-relative">
                                <h4 class="text-white"><?php echo $this->db->get_where('hospital',array('id'=> $this->session->userdata('hospital_id')))->row()->name;?> Dashboard</h4>

                                <h4 class="text-white mb-0"> Welcome Back, <?php echo $this->ion_auth->get_users_groups()->row()->name ?>!</h4>
                                <!-- margin-top:1rem !important; -->
                                <p class="text-white-50 px-4" style="margin-bottom:1px !important; ">  
This is a complete solution for your hospital management system.</p>
                                <h5 style="color:#fff;">Hospital ID : <?php echo $this->db->get_where('hospital',array('id'=> $this->session->userdata('hospital_id')))->row()->new_hospital_id;?></h5>
                                <div class="pt-2"  style="margin-top:1rem !important;">
                                    <a href="profile" class="btn btn-success btn-xs" style="margin-top: 1px !important;">View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-lg-2_5 col-md-6">
                        <div class="card">
                            <div class="card-body" style="padding: 11px !important;">
                                <div class="avatar">
                                    <span class="avatar-title bg-soft-primary rounded">
                                        <i class="mdi mdi-shopping-outline text-primary font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted">Today orders</p>
                                <h5 class="mt-1">
                                    
                                <?php if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))])){
                                          $amount1 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))];
                                          echo number_format($amount1, 2, '.', ',');

                                }else{
                                     $amount1= '0';
                                     echo number_format($amount1, 2, '.', ',');
                                } ?>
                                 
                                 <?php
                                     if(date('d')=='01'){
                                        if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t'), date('y')))])){
                                              $amount2 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t')-1, date('y')))];
                                        }else{
                                            $amount2= '0';
                                        }
                                     }else{
                                        if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))])){
                                              $amount2 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))];
    
                                        }else{
                                         $amount2= '0';
                                    }
                                     }
                                     if(($amount1-$amount2) >'0'){ ?>
                                        <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                        if($amount2=='0'){
                                            echo number_format($amount1, 2, '.', ',');
                                        }else{
                                            echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                        } ?> %</sup>  
                                  <?php   }elseif(($amount1-$amount2) =='0'){ ?>
                                    <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                         echo number_format('0', 2, '.', ','); ?> %</sup>
                         <?php         }else{ ?>
                            <sup class="text-danger fw-medium font-size-10"><i class="mdi mdi-arrow-down"></i><?php 
                                       if($amount2=='0'){
                                        echo number_format($amount1, 2, '.', ',');
                                    }else{
                                        echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                    } ?> %</sup>
                         
                         <?php }
                                    
                                 ?>
                                 
                                 </h5>
                                <div>
                                    <div class="">
                                        <div id="mini-1" data-colors='["#3980c0"]'></div>
                                    </div>

                                    <!-- <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                    <li class="list-inline-item"><a href="" style="pointer-events: none;" class="text-muted">This Month</a></li>
                                    </ul> -->
                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                        <li class="list-inline-item"><a href="" class="text-muted"  style="pointer-events: none;" >Day</a></li>
                                        <!-- <li class="list-inline-item"><a href="finance/monthly" class="text-muted">Week</a></li> -->
                                        <li class="list-inline-item"><a href="finance/daily" class="text-muted">Month</a></li>
                                        <li class="list-inline-item"><a href="finance/monthly" class="text-muted">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2_5 col-md-6">
                        <div class="card">
                            <div class="card-body" style="padding: 11px !important;">
                                <div class="avatar">
                                    <span class="avatar-title bg-soft-success rounded">
                                        <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted">Today Visitor</p>
                                <h5 class="mt-1"><?php 
                                        echo $logs_useraccess[sprintf('%d',date('d'))];
                                ?> <sup class="text-danger fw-medium font-size-10"><i class="mdi mdi-arrow-down"></i> <?php 
                                if($logs_useraccess[sprintf('%d',date('d'))-1] !=0){
                                    echo $logs_useraccess[sprintf('%d',date('d'))]-$logs_useraccess[sprintf('%d',date('d'))-1]*100/$logs_useraccess[sprintf('%d',date('d'))-1];

                                }else{
                                    echo ($logs_useraccess[sprintf('%d',date('d'))]-$logs_useraccess[sprintf('%d',date('d'))-1])*100;
                                }
                                
                                
                                ?>%</sup></h5>
                                <div>
                                    <div class="">
                                        <div id="mini-2" data-colors='["#33a186"]'></div>
                                    </div>
                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                        <li class="list-inline-item"><a href="" class="text-muted" style="pointer-events: none;">Day</a></li>
                                        <!-- <li class="list-inline-item"><a href="logs" class="text-muted">Week</a></li> -->
                                        <li class="list-inline-item"><a href="logs" class="text-muted">Month</a></li>
                                        <li class="list-inline-item"><a href="logs" class="text-muted">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2_5 col-md-6">
                        <div class="card">
                            <div class="card-body" style="padding: 11px !important;">
                                <div class="avatar">
                                    <span class="avatar-title bg-soft-primary rounded">
                                        <i class="mdi mdi-rocket-outline text-primary font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted">Total Expense</p>
                                <h5 class="mt-1">
                                    
                                <?php if(!empty($expenseda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))])){
                                         $amount1 = $expenseda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))];
                                        echo number_format($amount1, 2, '.', ',');

                                }else{
                                    $amount1= '0';
                                    echo number_format($amount1, 2, '.', ',');
                                } ?>
                                 
                                 <?php
                                     if(date('d')=='01'){
                                        if(!empty($expenseda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t'), date('y')))])){
                                              $amount2 = $expenseda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t')-1, date('y')))];
                                        }else{
                                            $amount2= '0';
                                        }
                                     }else{
                                        if(!empty($expenseda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))])){
                                              $amount2 = $expenseda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))];
    
                                        }else{
                                         $amount2= '0';
                                    }
                                     }
                                     if(($amount1-$amount2) >'0'){ ?>
                                        <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                        if($amount2=='0'){
                                            echo number_format($amount1, 2, '.', ',');
                                        }else{
                                            echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                        } ?> %</sup>  
                                  <?php   }elseif(($amount1-$amount2) =='0'){ ?>
                                    <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                         echo number_format('0', 2, '.', ','); ?> %</sup>
                         <?php         }else{ ?>
                            <sup class="text-danger fw-medium font-size-10"><i class="mdi mdi-arrow-down"></i><?php 
                                       if($amount2=='0'){
                                        echo number_format($amount1, 2, '.', ',');
                                    }else{
                                        echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                      
                                    } ?> %</sup>
                         
                         <?php }
                                    
                                 ?>
                                </h5>
                                <div>
                                    <div class="">
                                        <div id="mini-3" data-colors='["#3980c0"]'></div>
                                    </div>
                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                        <li class="list-inline-item"><a href="" class="text-muted" style="pointer-events: none;">Day</a></li>
                                        <!-- <li class="list-inline-item"><a href="" class="text-muted">Week</a></li> -->
                                        <li class="list-inline-item"><a href="finance/dailyExpense" class="text-muted">Month</a></li>
                                        <li class="list-inline-item"><a href="finance/monthlyExpense" class="text-muted">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2_5 col-md-6">
                        <div class="card">
                            <div class="card-body" style="padding: 11px !important;">
                                <div class="avatar">
                                    <span class="avatar-title bg-soft-success rounded">
                                        <i class="mdi mdi-alert-circle text-success font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted">Due Collection</p>
                                <h5 class="mt-1">
                                <?php if(!empty($due_collection[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))])){
                                        $amount1 = $due_collection[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))];
                                        echo number_format($amount1, 2, '.', ',');

                                }else{
                                    $amount1= '0';
                                    echo number_format($amount1, 2, '.', ',');
                                } ?>
                                 
                                 <?php
                                     if(date('d')=='01'){
                                        if(!empty($due_collection[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t'), date('y')))])){
                                              $amount2 = $due_collection[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t')-1, date('y')))];
                                        }else{
                                            $amount2= '0';
                                        }
                                     }else{
                                        if(!empty($due_collection[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))])){
                                              $amount2 = $due_collection[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))];
    
                                        }else{
                                         $amount2= '0';
                                    }
                                     }
                                     if(($amount1-$amount2) >'0'){ ?>
                                        <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                        if($amount2=='0'){
                                            echo number_format($amount1, 2, '.', ',');
                                        }else{
                                             echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                        } ?> %</sup>  
                                  <?php   }elseif(($amount1-$amount2) =='0'){ ?>
                                    <sup class="text-success fw-medium font-size-10"><i class="mdi mdi-arrow-up"></i><?php 
                                         echo number_format('0', 2, '.', ','); ?> %</sup>
                         <?php         }else{ ?>
                            <sup class="text-danger fw-medium font-size-10"><i class="mdi mdi-arrow-down"></i><?php 
                                       if($amount2=='0'){
                                        echo number_format($amount1, 2, '.', ',');
                                        
                                    }else{
                                        echo number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                        
                                    } ?> %</sup>
                         
                         <?php }
                                    
                                 ?>
                                </h5>
                                <div>
                                    <div class="">
                                        <div id="mini-4" data-colors='["#33a186"]'></div>
                                    </div>
                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                        <li class="list-inline-item"><a href="" class="text-muted" style="pointer-events: none;">Day</a></li>
                                        <!-- <li class="list-inline-item"><a href="" class="text-muted">Week</a></li> -->
                                        <li class="list-inline-item"><a href="finance/dueCollection" class="text-muted">Month</a></li>
                                        <li class="list-inline-item"><a href="finance/dueCollection" class="text-muted">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-2_5 col-md-6">
                        <div class="card">
                            <div class="card-body" style="padding: 11px !important;">
                                <div class="avatar">
                                    <span class="avatar-title bg-soft-success rounded">
                                        <i class="mdi mdi-account-multiple-outline text-success font-size-24"></i>
                                    </span>
                                </div>
                                <p class="text-muted">New Registered</p>
                                <h5 class="mt-1"><?php 
                                        echo $registered_users[sprintf('%d',date('d'))]>0 ?$registered_users[sprintf('%d',date('d'))]:'0' ;
                                ?> <sup class="text-danger fw-medium font-size-10"><i class="mdi mdi-arrow-down"></i> <?php 
                                if($registered_users[sprintf('%d',date('d'))-1] !=0){
                                    echo $registered_users[sprintf('%d',date('d'))]-$registered_users[sprintf('%d',date('d'))-1]*100/$registered_users[sprintf('%d',date('d'))-1];

                                }else{
                                    echo ($registered_users[sprintf('%d',date('d'))]-$registered_users[sprintf('%d',date('d'))-1])*100>0?($registered_users[sprintf('%d',date('d'))]-$registered_users[sprintf('%d',date('d'))-1])*100:'0.00';
                                }
                                
                                
                                ?>%</sup></h5>
                                <div>
                                    <div class="">
                                        <div id="mini-5" data-colors='["#33a186"]'></div>
                                    </div>
                                    <ul class="list-inline d-flex justify-content-between justify-content-center mb-0">
                                        <li class="list-inline-item"><a href="" class="text-muted" style="pointer-events: none;">Day</a></li>
                                        <!-- <li class="list-inline-item"><a href="" class="text-muted">Week</a></li> -->
                                        <li class="list-inline-item"><a href="finance/AllUserActivityReport" class="text-muted">Month</a></li>
                                        <li class="list-inline-item"><a href="finance/AllUserActivityReport" class="text-muted">Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <h5 class="card-title mb-0">Sales Statistics</h5>
                            <!-- <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                       <div class="row align-items-center">
                        <div class="col-xl-8">
                            <div>
                                 <div id="sales-statistics" data-colors='["#eff1f3","#eff1f3","#eff1f3","#eff1f3","#33a186","#3980c0","#eff1f3","#eff1f3","#eff1f3", "#eff1f3"]' class="apex-chart"></div>
                            </div>
                          </div>
                           <div class="col-xl-4">
                               <div class="">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                <div class="flex-1 ms-2">
                                                    <p class="mb-0"><?php echo lang('this_year').' '.lang('income'); ?></p>
                                                    <h5 class="mt-1 mb-0 font-size-16"><?php echo $settings->currency; ?><?php echo number_format($this_year['payment'], 2, '.', ','); ?></h5>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-primary"><?php echo number_format((($this_year['payment']-$previous['payment']))/($previous['payment']>0?$previous['payment']:1), 2, '.', ',');?>%<i class="mdi mdi-arrow-down ms-2"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                <div class="flex-1 ms-2">
                                                    <p class="mb-0"><?php echo lang('this_month').' '.lang('income'); ?></p>
                                                    <h5 class="mt-1 mb-0 font-size-16"><?php echo $settings->currency; ?><?php echo number_format($this_month['payment'], 2, '.', ','); ?></h5>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-primary"><?php echo number_format((($this_month['payment']-$previous_month['payment']))/($previous_month['payment']>0?$previous_month['payment']:1)*100, 2, '.', ',');?>%<i class="mdi mdi-arrow-down ms-2"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="mdi mdi-circle font-size-10 mt-1 text-success"></i>
                                                <div class="flex-1 ms-2">
                                                    <p class="mb-0"><?php echo lang('today').' '.lang('income'); ?></p>
                                                    <h5 class="mt-1 mb-0 font-size-16"> <?php if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))])){
                                                         $amount1 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d'), date('y')))];
                                                         echo  $settings->currency.''. number_format($amount1, 2, '.', ',');

                                }else{
                                     $amount1= '0';
                                    echo  $settings->currency; ?><?php echo number_format($amount1, 2, '.', ',');
                                } ?></h5>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-success">
                                                    
                                                <?php
                                     if(date('d')=='01'){
                                        if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t'), date('y')))])){
                                              $amount2 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m')-1, date('t')-1, date('y')))];
                                        }else{
                                            $amount2= '0';
                                        }
                                     }else{
                                        if(!empty($paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))])){
                                              $amount2 = $paymentda[date('D d-m-y', mktime(12, 0, 0, date('m'), date('d')-1, date('y')))];
    
                                        }else{
                                         $amount2= '0';
                                    }
                                     }
                                     if(($amount1-$amount2) >'0'){ ?>
                                       <?php 
                                        if($amount2=='0'){
                                            echo $settings->currency.''. number_format($amount1, 2, '.', ',');
                                           
                                        }else{
                                            echo $settings->currency.''. number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                           
                                        } ?> 
                                  <?php   }elseif(($amount1-$amount2) =='0'){ ?>
                                    <?php 
                                         echo $settings->currency.''. number_format('0', 2, '.', ','); ?> 
                         <?php         }else{ ?>
                          <?php 
                                       if($amount2=='0'){
                                          echo $settings->currency.''. number_format($amount1, 2, '.', ',');
                                    }else{
                                        echo $settings->currency.''. number_format(($amount1-$amount2)*100/$amount2, 2, '.', ',');
                                           
                                    } ?>
                         
                         <?php }
                                    
                                 ?>
                                                
                                                
                                                
                                                %<i class="mdi mdi-arrow-up ms-1"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="mt-3 border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                                <div class="flex-1 ms-2">
                                                    <p class="mb-0">Product Delivered</p>
                                                    <h5 class="mt-1 mb-0 font-size-16">67,356.24</h5>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge badge-soft-primary">65.7%<i class="mdi mdi-arrow-up ms-1"></i></span>
                                            </div>
                                        </div>
                                    </div> -->
                               </div>
                           </div>
                           
                       </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <h5 class="card-title mb-0"><?php echo date('Y'); ?> sales By Category</h5>
                            <!-- <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="text-center mt-4">
                            <canvas class="mx-auto" id="sales-category" height="281" data-colors='["#3980c0","#51af98", "#4bafe1", "#8066DB"]'></canvas>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col">
                                <div class="px-2">
                                    <div class="d-flex align-items-center mt-sm-0 mt-2">
                                        <i class="mdi mdi-circle font-size-10 mt-1 text-primary"></i>
                                        <div class="flex-grow-1 ms-2">
                                            <p class="mb-0 text-truncate">Appointment</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="fw-bold"><?php echo $salesbycategory['total']>0? number_format($salesbycategory['appointment']/$salesbycategory['total']*100, 2, '.', ','):'0'; ?>%</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <i class="mdi mdi-circle font-size-10 mt-1 text-success"></i>
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0 text-truncate">Admitted Patient</p>
                                            </div>
                                        <div class="flex-shrink-0">
                                            <span class="fw-bold"><?php echo $salesbycategory['total']>0? number_format($salesbycategory['bed']/$salesbycategory['total']*100, 2, '.', ','):'0'; ?>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                               <div class="px-2">
                                    <div class="d-flex align-items-center mt-sm-0 mt-2">
                                            <i class="mdi mdi-circle font-size-10 mt-1 text-info"></i>
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0 text-truncate">Medical Test</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="fw-bold"><?php echo $salesbycategory['total']>0? number_format($salesbycategory['payment']/$salesbycategory['total']*100, 2, '.', ','):'0'; ?>%</span>
                                            </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                            <i class="mdi mdi-circle font-size-10 mt-1" style="color: #8066DB;"></i>
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0 text-truncate" >Pharmacy</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="fw-bold"><?php echo $salesbycategory['total']>0? number_format($salesbycategory['pharmacy']/$salesbycategory['total']*100, 2, '.', ','):'0'; ?>%</span>
                                            </div>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
           <div class="col-xl-8">
                    <div class="row">
                        <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <h5 class="card-title mb-0">Order Activity</h5>
                                            <!-- <div class="ms-auto">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                                        <ol class="activity-feed mb-0 px-4" data-simplebar style="max-height: 377px;">
                                                   <?php echo $options_log;?>
                                                        
                                        
                                                        </ol>
                    
                                                    </div>
                                </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <div class="align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Frequent Users</h4>
                                        <!-- <div class="flex-shrink-0">
                                            <div class="dropdown">
                                                <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">All Members<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>
                        
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                                    <a class="dropdown-item" href="#">Members</a>
                                                    <a class="dropdown-item" href="#">New Members</a>
                                                    <a class="dropdown-item" href="#">Old Members</a>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="card-body px-0 pt-2">
                                    <div class="table-responsive px-3" data-simplebar style="max-height: 393px;">
                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead>
                            <tr>
                                
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('info'); ?></th>
                              
                                <th><?php echo lang('ip_address'); ?></th>
                               
                               
                              
                            </tr>
                        </thead>
                                            <tbody>
                                                <?php $i=0; foreach($login_logs as $log){
                                                    if($i<=7){
                                                    ?>
                                                    <tr>
                                                    <td><?php echo  $log->name; ?></td>
                                                    <td>
                                                        <h6 class="font-size-15 mb-1"><?php echo   $log->email;?></h6>
                                                        <p class="text-muted font-size-13 mb-0"> <?php echo  $log->role;?></p>
                                                    </td>
                                                    <td><span class="badge badge-soft-danger font-size-12"><?php echo  $log->ip_address;?></span></td>
                                                   
                                                </tr>

                                              <?php } $i++;  } ?>
                                               
                                              
                                               
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div>
                            </div>
                        </div>
               </div>
           </div>
           <div class="col-xl-4">

               <div class="card">
                   <div class="card-header">
                        <div class="align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Doctors Commission
</h4>
                            <!-- <div class="flex-shrink-0">
                                <div class="dropdown">
                                    <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">View All<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
            
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item" href="#">Members</a>
                                        <a class="dropdown-item" href="#">New Members</a>
                                        <a class="dropdown-item" href="#">Old Members</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                   </div>
                   <div class="card-body pt-1">

                        <div class="table-responsive">
                            <table class="table table-centered align-middle table-nowrap mb-0">
                            <thead>
                            <tr>
                            <th><?php echo lang('doctor_id'); ?></th>
                                <th><?php echo lang('doctor'); ?></th>
                                <th><?php echo lang('commission'); ?></th>
                                <th><?php echo lang('total'); ?></th>
                                                    </tr>
                                                    </thead>
                                <tbody>
                                    <?php 
                                $doctor_intotal[]=array();
                                $i=0;
                                 foreach ($doctors as $doctor) { 
                                    if($i<=7){
                                    ?>
                                    <tr class="">
                                        <td><?php echo $doctor->id; ?></td>
                                        <td><?php echo $doctor->name; ?></td>
                                        <td><?php echo $settings->currency; ?>
                                    <?php
                                    foreach ($payments as $payment) {
                                        if ($payment->doctor == $doctor->id) {    
                                                $doctor_amount[] = $payment->doctor_amount;            
                                        }
                                    }
                                    if (!empty($doctor_amount)) {
                                        $doctor_total = array_sum($doctor_amount);
                                        $doctor_intotal[]=$doctor_total;
                                        echo $settings->currency.''.number_format($doctor_total,2,'.',',');
                                    } else {
                                        $doctor_total = 0;
                                        $doctor_intotal[]=0;
                                        echo $settings->currency.''.number_format($doctor_total,2,'.',',');
                                    }
                                    ?>
                                </td>
                                <td><?php echo $settings->currency; ?>
                                    <?php

                                    $doctor_gross = $doctor_total;
                                    if (!empty($doctor_gross)) {
                                        echo number_format($doctor_gross,2,'.',',');
                                    } else {
                                        echo'0.00';
                                    }
                                    ?>
                                </td>
                                <td>
                                            <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
        
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="finance/docComDetails?id=<?php echo $doctor->id; ?>"><?php echo lang('details'); ?></a>
                                                    <!-- <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Separated link</a> -->
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                                        <?php } } ?>
                                      
                
                                </tbody>
                                <tfoot>
                              <tr>  <td></td>
                              <td></td>
                              <td></td>
                              <td><a class="btn btn-soft-info" href="finance/doctorsCommission">More</a></td></tr>
                                </tfoot>
                            </table>   
                        </div> 

                   </div>
               </div>

               <div class="card best-product">
                <div class="card-body">
                 <div class="row align-items-center justify-content-start">
                     <div class="col-lg-12">
                         <h5 class="card-title best-product-title">Best Selling Services</h5>
                         <div class="row align-items-end mt-4">
                             <div class="col-4">
                                 <div class="mt-1">
                                     <h4 class="font-size-13 best-product-title"><?php 
                                     $max=max($salesbycategory['appointment'],$salesbycategory['bed'],$salesbycategory['payment'],$salesbycategory['pharmacy']);
                                        echo $settings->currency.' '.number_format($max,2, '.', ',');
                                    
                                    ?></h4>
                                     <p class="text-muted mb-0"><?php 
                                     
                                     $max_key = -1;
                                     $max_val = -1;
                                   
                                     foreach ($salesbycategory as $key => $value) {
                                        if($key != 'total'){
                                       if ($value > $max_val) {
                                         $max_key = $key;
                                         $max_val = $value;
                                       }
                                    }
                                     }
                                     echo $max_key;

                                     ?>
                                     </p>
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="mt-1">
                                     <h4 class="font-size-13 best-product-title">
<?php
                $max = -1;
                $secondMax = -1;
              $second_key=-1;
                foreach($salesbycategory as $key=>$number) {
                    //If it's greater than the value of max
                    if($key != 'total'){
                    if($number > $max) {
                    $secondMax = $max;
                    $max = $number;
                    }
                    //If array number is greater than secondMax and less than max
                    if($number > $secondMax && $number < $max) {
                    $secondMax = $number;
                    $second_key=$key;
                    }
                    }
                }
                    echo $settings->currency.' '. number_format($secondMax,2, '.', ',');
                    
                    
               
?>

                                     </h4>
                                     <p class="text-muted mb-0"><?php echo $second_key; ?></p>
                                 </div>
                             </div>

                             <div class="col-4">
                                 <div class="mt-1">
                                     <a href="finance/financialReport" class="btn btn-primary btn-sm">View Report</a>
                                 </div>
                             </div>
                            </div>
                     </div>
                   
                 </div>
                </div>
            </div>
           </div>
        </div>

        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center">
                            <h5 class="card-title mb-0">Earnings By Service ( <?php echo date('M'); ?>)</h5>
                            <!-- <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted font-size-12">Sort By:</span> <span class="fw-medium">Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                    </div> 
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body py-xl-0">
                        <div id="earning-item" data-colors='["#33a186","#3980c0"]' class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center">
                            <h5 class="card-title mb-0">Due Collection</h5>
                            <!-- <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted font-size-12">Sort By: </span> <span class="fw-medium"> Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body pt-xl-1">
                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                                <thead >
                                    <tr>
                                    <th><?php echo lang('patient_id'); ?></th>                        
                                    <th><?php echo lang('name'); ?></th>
                                    <th><?php echo lang('phone'); ?></th>
                                    <th><?php echo lang('due_balance'); ?></th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($patients as $patient){ ?>
                                    <tr>
                                    <td><?php echo  $patient->id; ?></td>
                                    <td><?php echo $patient->name; ?></td>
                                    <td><?php echo  $patient->phone; ?></td>
                                    <td><?php echo $settings->currency.''. number_format($this->patient_model->getDueBalanceByPatientId($patient->id),2, '.', ','); ?></td>
                                    <td> <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
        
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="patient/patientPayments">Payment History</a>
                                                    <!-- <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div class="dropdown-divider"></div> -->
                                                    <a class="dropdown-item" href="finance/patientPaymentHistory?patient=<?php echo $patient->id;?>">Payment</a>
                                                </div>
                                            </div></td>

                                </tr>
                                    
                                    <?php } ?>
                                   
                                   
                                   
                                  
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>
            <style>
                .state-overview  i {
                        color: #fff;
                        font-size: 50px;
                        padding: 25px;
                }
                    .claendar_div {
                    padding-right: 0px;
                }

                .fc-state-active, .fc-state-active .fc-button-inner, .fc-state-hover, .fc-state-hover .fc-button-inner {
                    background: #ff6c60 !important;
                    color: #fff !important;
                }
                .claendar_div{
                    margin-top: 20px;
                }
            </style>
        <div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
                    <div class="modal-dialog modal-xl header_modal" role="document">
                        <div class="modal-content">
                            <div id='medical_history'>
                                <div class="col-md-12">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
            <?php if (in_array('appointment', $this->modules)) { ?>
                <div class="state-overview col-md-5 state_overview_design">

                             <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"> <i class="fa fa-user"></i> <?php echo lang('todays_appointments'); ?></h4>
                                        
                                    </div>
                                    <div class="card-body">
                                             <div class="table-responsive">
                                                <table class="table mb-0" id="editable-samplee">
                                                <thead>
                                                    <tr>
                                                        <th> <?php echo lang('patient_id'); ?></th>
                                                        <th> <?php echo lang('name'); ?></th>
                                                        <th> <?php echo lang('date-time'); ?></th>
                                                        <th> <?php echo lang('status'); ?></th>
                                                        <th> <?php echo lang('options'); ?></th>
                                                    </tr>   
                                                </thead>
                                                <tbody>



                                                    <?php
                                                    foreach ($appointments as $appointment) {
                                                        if ($appointment->date == strtotime(date('Y-m-d'))) {
                                                    ?>
                                                            <tr class="">
                                                                <td> <?php echo $this->db->get_where('patient', array('id' => $appointment->patient))->row()->id; ?></td>
                                                                <td> <?php echo $this->db->get_where('patient', array('id' => $appointment->patient))->row()->name; ?></td>

                                                                <td class="center"> <strong> <?php echo $appointment->s_time; ?> </strong></td>
                                                                <td>
                                                                    <?php echo $appointment->status; ?>
                                                                </td>
                                                                <td>

                                                                    <a class="btn detailsbutton" title="<?php lang('history') ?>" href="patient/medicalHistory?id=<?php echo $appointment->patient ?>"><i class="fa fa-stethoscope"></i> <?php echo lang('history'); ?></a>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table> 
                                             </div>    
                                    </div>
                             </div>
                  
                </div>
            <?php } ?>

        <?php } ?>
        <?php if (!$this->ion_auth->in_group('superadmin')) { ?>
            <?php if (!$this->ion_auth->in_group('Doctor')) { ?>

                <div class="state-overview col-md-12 state_overview_design">
                    <div class="clearfix row">
                        <?php if (in_array('doctor', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="doctor">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 green">
                                            <i class="fa fa-user-md"></i> 
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('doctor');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('doctor'); ?></p> 
                                        </div>
                                </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('patient', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="patient">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-users-medical" style="padding-left: 16px;"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('patient');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('patient'); ?></p>
                                        </div>
                                </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('appointment', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="appointment">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 green">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('appointment');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('appointment'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('prescription', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="prescription/all">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-file-medical"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('prescription');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('prescription'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('patient', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="patient/caseList">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-medkit"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('medical_history');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('case_history'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('lab', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="lab/testStatus">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 green">
                                            <i class="fa fa-flask"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('lab');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('lab_tests'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>



                        <?php if (in_array('patient', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="patient/documents">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('patient_material');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('documents'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <?php if (in_array('finance', $this->modules)) { ?>
                            <div class="col-lg-3 col-sm-6">
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <a href="finance/payment">
                                    <?php } ?>
                                    <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 green">
                                            <i class="fa fa-money-check" style="padding-left: 16px;"></i>
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
                                                $this->db->from('payment');
                                                $count = $this->db->count_all_results();
                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('payment'); ?> <?php echo lang('invoice'); ?></p>
                                        </div>
                                        </div>
                                    </section>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                      
                    </div>



                    <?php if ($this->ion_auth->in_group(array('Nurse'))) { ?>
                        <?php if (in_array('notice', $this->modules)) { ?>
                            <div class="col-md-7 col-sm-12">
                                <section class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"><?php echo lang('notice'); ?></h4> 
                                    </div>
                                    <div class="card-body col-md-12">
                                        <div class="table-responsive">
                                            <!-- <ul class="task-list"> -->
                                                <table class="table mb-0" id="editable-sample78">
                                                    <thead>
                                                        <tr>
                                                            <th> <?php echo lang('title'); ?></th>
                                                            <th> <?php echo lang('description'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($notices as $notice) { ?>
                                                            <tr class="">
                                                                <td> <?php echo $notice->title; ?></td>
                                                                <td> <?php echo $notice->description; ?></td>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <!-- </ul> -->

                                            <div class="panel col-md-12 add-task-row">
                                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                    <a class="btn btn-success btn-sm pull-left" href="notice/addNewView"><?php echo lang('add'); ?> <?php echo lang('notice'); ?></a>
                                                <?php } ?>
                                                <a class="btn btn-default btn-sm pull-right" href="notice"><?php echo lang('all'); ?> <?php echo lang('notice'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                    <?php }
                    } ?>



                  



                </div>



            <?php } ?>

        <?php } else { ?>
            <?php if (in_array('home', $this->super_modules)) { ?>

                <div class="state-overview col-md-12 state_overview_design">
                    <div class="clearfix row">
                        <div class="col-lg-3 col-sm-6">

                        <a href="hospital">
                        <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-hospital" style="padding-left: 24px;"></i>
                           
                                        </div>
                                        <div class="col-md-8 value card-body">
                                            <h3 class="">
                                                <?php
                                                $count = 0;
                                                $hospitalList = $this->db->get('hospital')->result();
                                                foreach ($hospitalList as $hospitalList) {
                                                    $count = $count + 1;
                                                }

                                                echo $count;
                                                ?>
                                            </h3>
                                            <p class="card-text"><?php echo lang('total'); ?> <?php echo lang('hospitals'); ?></p>
                                        </div>
                                    </div>
                            </section>

                        </a>

                        </div>


                        <div class="col-lg-3 col-sm-6">

                        <a href="hospital/active">

                        <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-toggle-on" style="padding-left: 16px;"></i>
                                </div>
                                <div class="col-md-8 value card-body">
                                    <h3 class="">
                                        <?php
                                        $count = 0;
                                        $hospitalList = $this->db->get('hospital')->result();
                                        foreach ($hospitalList as $hospitalList) {
                                            $this->db->where('id', $hospitalList->ion_user_id);
                                            $status = $this->db->get('users')->row();
                                            if ($status->active == "1") {
                                                $count = $count + 1;
                                            }
                                        }

                                        echo $count;
                                        ?>
                                    </h3>
                                    <p class="card-text"><?php echo lang('active'); ?> <?php echo lang('hospitals'); ?></p>
                                </div>
                                </div>
                            </section>

                        </a>

                        </div>
                        <div class="col-lg-3 col-sm-6">

                        <a href="hospital/disable">

                        <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-toggle-off" style="padding-left: 16px;"></i>
                                </div>
                                <div class="col-md-8 value card-body">
                                    <h3 class="">
                                        <?php
                                        $count = 0;
                                        $hospitalList = $this->db->get('hospital')->result();
                                        foreach ($hospitalList as $hospitalList) {
                                            $this->db->where('id', $hospitalList->ion_user_id);
                                            $status = $this->db->get('users')->row();
                                            if ($status->active == "0") {
                                                $count = $count + 1;
                                            }
                                        }

                                        echo $count;
                                        ?>
                                    </h3>
                                    <p class="card-text"><?php echo lang('inactive'); ?> <?php echo lang('hospitals'); ?></p>
                                </div>
                                    </div>
                            </section>

                        </a>

                        </div>
                        <div class="col-lg-3 col-sm-6">

                        <a href="systems/expiredHospitals">

                        <section class="card">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-4 blue">
                                            <i class="fa fa-exclamation-triangle" style="padding-left: 16px;"></i>
                                    
                                </div>
                                <div class="col-md-8 value card-body">
                                    <h3 class="">

                                        <?php
                                        $count = 0;
                                        $hospitalRequestList = $this->db->get('hospital_payment')->result();

                                        foreach ($hospitalRequestList as $hospitalRequestList) {

                                            if ($hospitalRequestList->next_due_date_stamp < time()) {
                                                $hospital_details = $this->db->get_where('hospital', array('id' => $hospitalRequestList->hospital_user_id))->row();
                                                if (!empty($hospital_details)) {
                                                    $count = $count + 1;
                                                }
                                            }
                                        }


                                        echo $count;

                                        ?>

                                    </h3>
                                    <p class="card-text"><?php echo lang('lisence_expired'); ?></p>
                                </div>
                                </div>
                            </section>

                        </a>

                        </div>
                
                
                         <div class="col-lg-8 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0"><?php echo date('Y') ." " .lang('per_month_income');?></h4>
                                        </div><!-- end card header --> 
                                        <div class="card-body">                                        
                                            <div id="chart_div_superadmin" data-colors='["#fa6374", "#3980c0"]' class="apex-charts" dir="ltr"></div>                                      
                                        </div>
                                    </div>
                            <!-- <div id="chart_div_superadmin" class="panel"></div> -->

                         </div>

                        <div class="col-lg-4 col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0"><? echo date('F Y'); ?></h4>
                                            </div><!-- end card header --> 
                                            <div class="card-body">                                        
                                                <div id="piechart_3d_superadmin" data-colors='["#fc931d", "#f34e4e"]' class="apex-charts" dir="ltr"></div> 
                                            </div>
                                        </div><!--end card-->
                            <!-- <div id="piechart_3d_superadmin" class="panel"></div> -->
                        </div>
                    </div>
                 </div>
                 <div class="clearfix row">
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo date('D d F, Y'); ?>
                        </header>
                        <div class="panel-body">

                            <div class="home_section">
                                <?php echo lang('monthly'); ?> <?php echo lang('subscription'); ?>: <?php echo $settings->currency; ?> <?php echo number_format($this_day['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('yearly'); ?> <?php echo lang('subscription'); ?>: <?php echo $settings->currency; ?> <?php echo number_format($this_day['payment_yearly'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('total'); ?> <?php echo lang('income'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_day['payment'] + $this_day['payment_yearly'], 2, '.', ','); ?>
                                <hr>
                            </div>



                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo date('F, Y'); ?>
                        </header>
                        <div class="panel-body">

                            <div class="home_section">
                                <?php echo lang('monthly'); ?> <?php echo lang('subscription'); ?>: <?php echo $settings->currency; ?> <?php echo number_format($this_monthly['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('yearly'); ?> <?php echo lang('subscription'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_year['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('total'); ?> <?php echo lang('income'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_year['payment'] + $this_monthly['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>



                        </div>
                    </section>

                </div>
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo date('Y'); ?>
                        </header>
                        <div class="panel-body">

                            <div class="home_section">
                                <?php echo lang('monthly'); ?> <?php echo lang('subscription'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_month_payment['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('yearly'); ?> <?php echo lang('subscription'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_year_payment['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>
                            <div class="home_section">
                                <?php echo lang('total'); ?> <?php echo lang('income'); ?> : <?php echo $settings->currency; ?> <?php echo number_format($this_year_payment['payment'] + $this_month_payment['payment'], 2, '.', ','); ?>
                                <hr>
                            </div>


                        </div>
                    </section>
                </div>
                </div>

                <!-- <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center">
                            <h5 class="card-title mb-0">Manage Orders</h5>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted font-size-12">Sort By: </span> <span class="fw-medium"> Weekly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-body pt-xl-1">
                        <div class="table-responsive">
                            <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead> 
                            <tr>
                                <th> <?php echo lang('package'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> <?php echo lang('country'); ?></th>
                                <th> <?php echo lang('next_renewal_date'); ?></th>
                                <th> <?php echo lang('package'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <th class="no-print"> <?php echo lang('edit'); ?></th>
                            </tr>
                        </thead>
                                <tbody>

                                <?php foreach($patients as $patient){ ?>
                                    <tr>
                                    <td><?php echo  $patient->id; ?></td>
                                    <td><?php echo $patient->name; ?></td>
                                    <td><?php echo  $patient->phone; ?></td>
                                    <td><?php echo $settings->currency.''. number_format($this->patient_model->getDueBalanceByPatientId($patient->id),2, '.', ','); ?></td>
                                    <td> <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-24" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
        
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="patient/patientPayments">Payment History</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item" href="finance/patientPaymentHistory?patient=<?php echo $patient->id;?>">Payment</a>
                                                </div>
                                            </div></td>

                                </tr>
                                    
                                    <?php } ?>
                                   
                                   
                                   
                                  
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
                 </div>
            <?php } ?>
        <?php } ?>

<?php        } ?>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

                                    <!-- </div> -->

<?php
if (!$this->ion_auth->in_group(array('superadmin'))) {
    if (!empty($this_month['payment'])) {
        $payment_this = $this_month['payment'];
    } else {
        $payment_this = 0;
    }
    if (!empty($this_month['expense'])) {
        $expense_this = $this_month['expense'];
    } else {
        $expense_this = 0;
    }
    if (!empty($this_month['appointment_treated'])) {
        $appointment_treated = $this_month['appointment_treated'];
    } else {
        $appointment_treated = 0;
    }


    if (!empty($this_month['appointment_cancelled'])) {
        $appointment_cancelled = $this_month['appointment_cancelled'];
    } else {
        $appointment_cancelled = 0;
    }
    $superadmin_login = 'no';
} else {
    if (!empty($this_month['payment'])) {
        $superadmin_month_payment = $this_month['payment'];
    } else {
        $superadmin_month_payment = '0';
    }
    if (!empty($this_yearly['payment'])) {
        $superadmin_year_payment = $this_yearly['payment'];
    } else {
        $superadmin_year_payment = '0';
    }
    $superadmin_login = 'yes';
}
?>


<script type="text/javascript">
    var per_month_income_expense = "<?php echo lang('per_month_income_expense') ?>";
</script>
<script type="text/javascript">
    var currency = "<?php echo $settings->currency ?>";
</script>
<script type="text/javascript">
    var months_lang = "<?php echo lang('months') ?>";
</script>
<script type="text/javascript">
    var superadmin_login = "<?php echo $superadmin_login; ?>";
</script>
<?php if (!$this->ion_auth->in_group(array('superadmin'))) { ?>
    <script type="text/javascript">
        var payment_this = <?php echo $payment_this ?>;
    </script>
    <script type="text/javascript">
        var expense_this = <?php echo $expense_this ?>;
    </script>
    <script type="text/javascript">
        var appointment_treated = <?php echo $appointment_treated ?>;
        var appointment_lang =" <?php echo lang('appointment') ?>";
    </script>
    <script type="text/javascript">
        var appointment_cancelled = <?php echo $appointment_cancelled ?>;
    </script>
    <script type="text/javascript">
        <?php 
        $this_expense_n=array();
        foreach($this_year['expense_per_month'] as $expense){
            $this_expense_n[]=$expense;
        }
          
        ?>
         var this_year_expenses_n = <?php echo json_encode($this_expense_n); ?>;
        var this_year_expenses = <?php echo json_encode($this_year['expense_per_month']); ?>;
    </script>
<?php } else { ?>
    <script type="text/javascript">
        var superadmin_month_payment = <?php echo $superadmin_month_payment ?>;
    </script>
    <script type="text/javascript">
        var superadmin_year_payment = <?php echo $superadmin_year_payment ?>;
    </script>
<?php } ?>
<?php if ($this->ion_auth->in_group(array('admin'))) { 
    
    for ($d = 1; $d <= date('d'); $d++) {
        $time = mktime(12, 0, 0, date('m'), $d, date('y'));
       
        if (!empty($paymentda[date('D d-m-y', $time)])) {
            if (date('m', $time) == date('m')) {  
                // $day = date('D d-m-y', $time);
                $amount = $paymentda[date('D d-m-y', $time)];
            }
        } else {
            if (date('m', $time) == date('m')) {
                // $day = date('D d-m-y', $time);
                $amount = 0;
            }
        }
        $total_amount[] = $amount;
       
        ?>
           

        <?php
    }
    
    
    
     for ($d = 1; $d <= date('d'); $d++) {
        $time = mktime(12, 0, 0, date('m'), $d, date('y'));
       
        if (!empty($expenseda[date('D d-m-y', $time)])) {
            if (date('m', $time) == date('m')) {  
                // $day = date('D d-m-y', $time);
                $amount_ex = $expenseda[date('D d-m-y', $time)];
            }
        } else {
            if (date('m', $time) == date('m')) {
                // $day = date('D d-m-y', $time);
                $amount_ex = 0;
            }
        }
        $total_amount_ex[] = $amount_ex;
       
        ?>
           

        <?php
    }
    
    
   
    for ($d = 1; $d <= date('d'); $d++) {
        $time = mktime(12, 0, 0, date('m'), $d, date('y'));
       
        if (!empty($due_collection[date('D d-m-y', $time)])) {
            if (date('m', $time) == date('m')) {  
                // $day = date('D d-m-y', $time);
                $amount_due = $due_collection[date('D d-m-y', $time)];
            }
        } else {
            if (date('m', $time) == date('m')) {
                // $day = date('D d-m-y', $time);
                $amount_due = 0;
            }
        }
        $total_amount_due[] = $amount_due;
       
        ?>
           

        <?php
    }
    
    
    ?>
    <script type="text/javascript">
        var all_payments_da = <?php echo json_encode($total_amount); ?>;
    </script>
    <script type="text/javascript">
        var all_expense_da = <?php echo json_encode($total_amount_ex); ?>;
    </script>
     <script type="text/javascript">
        var total_amount_due = <?php echo json_encode($total_amount_due); ?>;
    </script>
    <?php for($d = 1; $d <= date('d'); $d++){
      
              $logs[] = $logs_useraccess[$d];
    }
   
    ?>
     <?php for($d = 1; $d <= date('d'); $d++){
      if(empty($registered_users[$d])){
        $users[] =0;
      }else{
      $users[] = $registered_users[$d];
      }
}
$earning_key=[];
$earning_item=[];
foreach($sub as $key=>$subs){ ?>
     <script type="text/javascript">
        var earning_key<?php echo $key?> = '<?php echo $key ?>';
        var earning_item<?php echo $key?> = <?php echo $subs; ?>;
    </script>

<?php }
foreach($this_year['payment_per_month'] as $nmonth){
   
    $this_year_new[]=$nmonth;
}
$service_category=[$salesbycategory['appointment']>0?$salesbycategory['appointment']:0,$salesbycategory['bed']>0?$salesbycategory['bed']:0,$salesbycategory['payment']>0?$salesbycategory['payment']:0,$salesbycategory['pharmacy']>0?$salesbycategory['pharmacy']:0]
?>
      <script type="text/javascript">
        var access_user = <?php echo json_encode( $logs); ?>;
    </script>
     <script type="text/javascript">
        var earning_key = <?php echo json_encode( $earning_key); ?>;
        var earning_item = <?php echo json_encode( $earning_item); ?>;
    </script>
    <script type="text/javascript">
        var register_user = <?php echo json_encode( $users); ?>;
    </script>
     <script type="text/javascript">
        var service_category = <?php echo json_encode( $service_category); ?>;
    </script>
<?php } ?>

<script type="text/javascript">
    var this_year_sale = <?php echo json_encode($this_year_new); ?>;
    var this_year = <?php echo json_encode($this_year['payment_per_month']); ?>;
    var monthly_subscription_lang = '<?php echo lang('monthly'); ?> <?php echo lang('subscription'); ?>';
    var yearly_subscription_lang = '<?php echo lang('yearly'); ?> <?php echo lang('subscription'); ?>';
    var income_lang = '<?php echo lang('income'); ?>';
    var expense_lang = '<?php echo lang('expense'); ?>';
    var treated_lang = '<?php echo lang('treated'); ?>';
    var cancelled_lang = '<?php echo lang('cancelled'); ?>';
    var jan = '<?php echo lang('jan'); ?>';
    var feb = '<?php echo lang('feb'); ?>';
    var mar = '<?php echo lang('mar'); ?>';
    var apr = '<?php echo lang('apr'); ?>';
    var may = '<?php echo lang('may'); ?>';
    var june = '<?php echo lang('june'); ?>';
    var july = '<?php echo lang('july'); ?>';
    var aug = '<?php echo lang('aug'); ?>';
    var sep = '<?php echo lang('sep'); ?>';
    var oct = '<?php echo lang('oct'); ?>';
    var nov = '<?php echo lang('nov'); ?>';
    var dec = '<?php echo lang('dec'); ?>';

</script>
<script src="common/js/jquery.js"></script>
<script src="common/extranal/js/home.js"></script>