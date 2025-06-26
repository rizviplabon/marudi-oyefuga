<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="row">
            <div class="col-12 content-header"> 
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="page-icon me-3">
                            <i class="fas fa-boxes text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-primary"><?php echo $page_title; ?></h4>
                            <p class="text-muted mb-0">Manage your medical inventory and supplies</p>
                        </div>
                    </div>
                    <div class="page-title-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 bg-transparent">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('home'); ?>" class="text-primary">
                                        <i class="fas fa-home"></i> Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo base_url('inventory'); ?>" class="text-primary">
                                        <i class="fas fa-warehouse"></i> Inventory
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-dark fw-medium">
                                    <i class="fas fa-boxes"></i> <?php echo $page; ?>
                                </li>
                        </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->

        <!-- Enhanced Custom CSS for Modern Inventory UI -->
        <style>
            /* Medical-grade UI enhancements */
            :root {
                --primary: #2c7be5;
                --primary-dark: #1a68d1;
                --secondary: #95aac9;
                --success: #00cc8d;
                --info: #39afd1;
                --warning: #f6c343;
                --danger: #e63757;
                --light: #f9fbfd;
                --dark: #12263f;
                --white: #ffffff;
                --muted: #95aac9;
                --gray-100: #f9fbfd;
                --gray-200: #edf2f9;
                --gray-300: #e3ebf6;
                --gray-400: #d2ddec;
                --gray-500: #b1c2d9;
                --gray-600: #95aac9;
                --gray-700: #6e84a3;
                --gray-800: #3b506c;
                --gray-900: #12263f;
            }
            :root {
                --primary: #2c7be5;
                --primary-dark: #1a68d1;
                --secondary: #95aac9;
                --success: #00cc8d;
                --info: #39afd1;
                --warning: #f6c343;
                --danger: #e63757;
                --light: #f9fbfd;
                --dark: #12263f;
                --white: #ffffff;
                --muted: #95aac9;
                --gray-100: #f9fbfd;
                --gray-200: #edf2f9;
                --gray-300: #e3ebf6;
                --gray-400: #d2ddec;
                --gray-500: #b1c2d9;
                --gray-600: #95aac9;
                --gray-700: #6e84a3;
                --gray-800: #3b506c;
                --gray-900: #12263f;
            }
            
            body {
                color: var(--gray-800);
                background-color: var(--gray-100);
            }
            
            .card {
                border: none;
                border-radius: 0.75rem;
                box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
                background-color: var(--white);
                margin-bottom: 1.5rem;
                transition: all 0.2s ease;
            }
            
            .card:hover {
                box-shadow: 0 1rem 2rem rgba(18, 38, 63, 0.06);
                transform: translateY(-2px);
            }
            
            .card-header {
                background-color: var(--white);
                border-bottom: 1px solid var(--gray-200);
                padding: 1.25rem 1.5rem;
                border-top-left-radius: 0.75rem !important;
                border-top-right-radius: 0.75rem !important;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .card-title {
                font-weight: 600;
                color: var(--gray-900);
                margin-bottom: 0;
                font-size: 1.1rem;
                display: flex;
                align-items: center;
            }
            
            .card-title i {
                color: var(--primary);
                margin-right: 0.5rem;
                font-size: 1rem;
            }
            
            .btn {
                font-weight: 500;
                letter-spacing: 0.025em;
                text-transform: none;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                transition: all 0.15s ease;
                box-shadow: 0 1px 2px rgba(18, 38, 63, 0.05);
            }
            
            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 6px rgba(18, 38, 63, 0.1);
            }
            
            .btn:active {
                transform: translateY(1px);
                box-shadow: none;
            }
            
            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
            }
            
            .btn-sm {
                padding: 0.25rem 0.75rem;
                font-size: 0.8125rem;
                border-radius: 0.25rem;
            }
            
            .btn-group .btn {
                box-shadow: none;
            }
            
            .btn-info {
                background-color: var(--info);
                border-color: var(--info);
            }
            
            .btn-success {
                background-color: var(--success);
                border-color: var(--success);
            }
            
            .btn-warning {
                background-color: var(--warning);
                border-color: var(--warning);
                color: var(--dark);
            }
            
            .btn-danger {
                background-color: var(--danger);
                border-color: var(--danger);
            }
            
            .btn-secondary {
                background-color: var(--secondary);
                border-color: var(--secondary);
            }
            
            .table {
                margin-bottom: 0;
            }
            
            .table thead th {
                background-color: var(--gray-100);
                border-bottom: 2px solid var(--gray-200);
                font-weight: 600;
                color: var(--gray-700);
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.08em;
                padding: 0.75rem 1rem;
                vertical-align: middle;
            }
            
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: var(--gray-100);
            }
            
            .table td, .table th {
                vertical-align: middle;
                padding: 1rem;
                border-top: 1px solid var(--gray-200);
            }
            
            .badge {
                font-weight: 500;
                padding: 0.33em 0.65em;
                font-size: 0.75em;
                border-radius: 0.375rem;
                letter-spacing: 0.025em;
            }
            
            .badge-success {
                background-color: rgba(0, 204, 141, 0.1);
                color: var(--success);
            }
            
            .badge-danger {
                background-color: rgba(230, 55, 87, 0.1);
                color: var(--danger);
            }
            
            .badge-secondary {
                background-color: rgba(149, 170, 201, 0.1);
                color: var(--secondary);
            }
            
            .form-control {
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                border: 1px solid var(--gray-300);
                font-size: 0.9375rem;
                height: calc(1.5em + 1rem + 2px);
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .form-control:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
            }
            
            textarea.form-control {
                height: auto;
            }
            
            .modal-content {
                border-radius: 0.75rem;
                border: none;
                box-shadow: 0 1.5rem 2rem rgba(18, 38, 63, 0.15);
            }
            
            .modal-header { 
                border-bottom: 1px solid var(--gray-200);
                background-color: var(--white);
                border-top-left-radius: 0.75rem;
                border-top-right-radius: 0.75rem;
                padding: 1.25rem 1.5rem;
            }
            
            .modal-footer {
                border-top: 1px solid var(--gray-200);
                background-color: var(--white);
                border-bottom-left-radius: 0.75rem;
                border-bottom-right-radius: 0.75rem;
                padding: 1.25rem 1.5rem;
            }
            
            /* Fix modal display issues */
            .modal {
                z-index: 1050;
                overflow-y: auto;
            }
            
            .modal-dialog {
                margin: 1.75rem auto;
                max-width: 800px;
                width: 100%;
            }
            
            .modal-backdrop {
                z-index: 1040;
            }
            
            .modal-open {
                overflow: hidden;
                padding-right: 0 !important;
            }
            
            .modal-body {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
                padding: 1.5rem;
            }
            
            .modal-title {
                font-weight: 600;
                color: var(--gray-900);
                display: flex;
                align-items: center;
            }
            
            .modal-title i {
                color: var(--primary);
                margin-right: 0.5rem;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: var(--primary) !important;
                color: var(--white) !important;
                border: none !important;
                border-radius: 0.375rem !important;
                box-shadow: 0 1px 3px rgba(18, 38, 63, 0.1);
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: var(--primary) !important;
                color: var(--white) !important;
                border: none !important;
            }
            
            .dataTables_wrapper .dataTables_filter input {
                border: 1px solid var(--gray-300);
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                margin-left: 0.5rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
                outline: none;
            }
            
            .dataTables_wrapper .dataTables_length select {
                border: 1px solid var(--gray-300);
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .dataTables_wrapper .dataTables_length select:focus {
                border-color: rgba(44, 123, 229, 0.5);
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
                outline: none;
            }
            
            .table-responsive {
                border-radius: 0.75rem;
                box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            }
            
            /* Row hover effect */
            .table tbody tr {
                transition: all 0.15s ease;
            }
            
            .table tbody tr:hover {
                background-color: rgba(44, 123, 229, 0.03) !important;
                transform: translateY(-1px);
                box-shadow: 0 0.125rem 0.25rem rgba(18, 38, 63, 0.05);
            }
            
            /* Animation for alerts */
            .alert {
                animation: fadeIn 0.5s;
                border: none;
                border-radius: 0.375rem;
                padding: 1rem 1.5rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(18, 38, 63, 0.075);
            }
            
            .alert-success {
                color: var(--success);
                background-color: rgba(0, 204, 141, 0.1);
            }
            
            .alert-danger {
                color: var(--danger);
                background-color: rgba(230, 55, 87, 0.1);
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Tooltip styling */
            .tooltip-inner {
                background-color: var(--dark);
                border-radius: 0.375rem;
                box-shadow: 0 0.5rem 1rem rgba(18, 38, 63, 0.1);
                padding: 0.5rem 1rem;
                font-size: 0.8125rem;
            }
            
            .tooltip.bs-tooltip-top .arrow::before {
                border-top-color: var(--dark);
            }
            
            /* Button icon animation */
            .btn i {
                margin-right: 0.25rem;
                transition: transform 0.15s ease;
            }
            
            .btn:hover i { 
                transform: scale(1.1);
            }
            
            /* Summary Cards */
            .border-left-primary {
                border-left: 4px solid var(--primary);
            }
            
            .border-left-success {
                border-left: 4px solid var(--success);
            }
            
            .border-left-warning {
                border-left: 4px solid var(--warning);
            }
            
            .border-left-info {
                border-left: 4px solid var(--info);
            }
            
            .text-gray-300 {
                color: var(--gray-300) !important;
            }
            
            .text-gray-800 {
                color: var(--gray-800) !important;
            }
            
            .text-xs {
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.08em;
            }
            
            .h5 {
                font-size: 1.25rem;
                font-weight: 600;
            }
            
            .shadow {
                box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03) !important;
            }
            
            .py-2 {
                padding-top: 0.75rem !important;
                padding-bottom: 0.75rem !important;
            }
            
            .card-body {
                position: relative;
                overflow: hidden;
            }
            
            .card-body::after {
                content: '';
                position: absolute;
                bottom: 0;
                right: 0;
                width: 100px;
                height: 100px;
                background: linear-gradient(135deg, transparent 50%, rgba(44, 123, 229, 0.03) 50%);
                border-radius: 100% 0 0 0;
                z-index: 1;
                pointer-events: none;
            }
            
            .col-auto i {
                opacity: 0.8;
                transition: all 0.2s ease;
            }
            
            .card:hover .col-auto i {
                transform: scale(1.1);
                opacity: 1;
            }
            
            /* Medical-grade UI specific styles */
            .medical-icon {
                color: var(--primary);
                margin-right: 0.5rem;
            }
            
            .status-indicator {
                display: inline-block;
                width: 0.5rem;
                height: 0.5rem;
                border-radius: 50%;
                margin-right: 0.5rem;
            }
            
            .status-indicator.active {
                background-color: var(--success);
                box-shadow: 0 0 0 2px rgba(0, 204, 141, 0.2);
            }
            
            .status-indicator.inactive {
                background-color: var(--secondary);
                box-shadow: 0 0 0 2px rgba(149, 170, 201, 0.2);
            }
            
            .status-indicator.warning {
                background-color: var(--warning);
                box-shadow: 0 0 0 2px rgba(246, 195, 67, 0.2);
            }
            
            .progress {
                height: 0.5rem;
                border-radius: 0.25rem;
                background-color: var(--gray-200);
                margin-top: 0.5rem;
                overflow: hidden;
            }
            
            .progress-bar {
                background-color: var(--primary);
                transition: width 0.6s ease;
            }
            
            .progress-bar-success {
                background-color: var(--success);
            }
            
            .progress-bar-warning {
                background-color: var(--warning);
            }
            
            .progress-bar-danger {
                background-color: var(--danger);
            }
            
            /* Improved form styling */
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-group label {
                font-weight: 500;
                color: var(--gray-700);
                margin-bottom: 0.5rem;
            }
            
            .form-group .text-danger {
                color: var(--danger) !important;
            }
            
            .form-control::placeholder {
                color: var(--gray-500);
                opacity: 0.75;
            }
            
            /* DataTables enhancements */
            div.dataTables_wrapper div.dataTables_info {
                padding-top: 1rem;
                color: var(--gray-600);
                font-size: 0.875rem;
            }
            
            .dataTables_paginate .pagination {
                margin: 1rem 0 0 0;
            }
            
            .dataTables_paginate .page-item.active .page-link {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .dataTables_paginate .page-link {
                padding: 0.375rem 0.75rem;
                color: var(--primary);
                background-color: var(--white);
                border: 1px solid var(--gray-300);
            }
            
            .dataTables_paginate .page-link:hover {
                color: var(--primary-dark);
                background-color: var(--gray-100);
                border-color: var(--gray-300);
            }
            
            /* Loading indicator */
            .loading-spinner {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 2rem;
                color: var(--primary);
            }

            /* Enhanced Inventory Summary Cards */
            .inventory-summary-card {
                transition: all 0.3s ease;
                border-radius: 15px;
            }

            .inventory-summary-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
            }

            .inventory-icon-wrapper {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, #2c7be5, #1a68d1);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #00cc8d, #28a745);
            }

            .bg-gradient-warning {
                background: linear-gradient(135deg, #f6c343, #fd7e14);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #39afd1, #17a2b8);
            }

            /* Counter Animation */
            .counter {
                display: inline-block;
                transition: all 0.5s ease;
            }

            /* Filter Cards */
            .filter-card {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 10px;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
            }

            .filter-card:hover {
                border-color: #2c7be5;
                box-shadow: 0 2px 10px rgba(44, 123, 229, 0.1);
            }

            /* Enhanced Table Styles */
            .table-primary {
                background: linear-gradient(135deg, #d4edda, #c3e6cb);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(44, 123, 229, 0.05);
                transform: scale(1.01);
                transition: all 0.2s ease;
            }

            /* Status Badges */
            .badge-status {
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-weight: 500;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.5px;
            }

            .badge-active {
                background: linear-gradient(135deg, #28a745, #20c997);
                color: #fff;
            }

            .badge-inactive {
                background: linear-gradient(135deg, #6c757d, #5a6268);
                color: #fff;
            }

            .badge-low-stock {
                background: linear-gradient(135deg, #ffc107, #fd7e14);
                color: #fff;
            }

            /* Stock Level Indicators */
            .stock-indicator {
                display: inline-flex;
                align-items: center;
                font-weight: 500;
            }

            .stock-indicator.low {
                color: #dc3545;
            }

            .stock-indicator.medium {
                color: #ffc107;
            }

            .stock-indicator.high {
                color: #28a745;
            }

            .stock-indicator i {
                margin-right: 0.25rem;
            }

            /* Action Buttons */
            .btn-action {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: 0 2px;
                transition: all 0.3s ease;
            }

            .btn-action:hover {
                transform: scale(1.1);
            }

            /* Enhanced Modal Styles */
            .modal-content {
                border-radius: 20px;
                overflow: hidden;
            }

            .modal-header.bg-gradient-primary {
                background: linear-gradient(135deg, #2c7be5, #1a68d1) !important;
            }

            .form-control:focus {
                border-color: #2c7be5;
                box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
            }

            /* Animation Classes */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.5s ease-out;
            }

            /* Custom Scrollbar */
            .table-responsive::-webkit-scrollbar {
                height: 8px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #2c7be5;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background: #1a68d1;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .inventory-summary-card {
                    margin-bottom: 1rem;
                }
                
                .btn-group {
                    flex-direction: column;
                }
                
                .btn-group .btn {
                    margin-bottom: 0.5rem;
                }
            }
        </style>

        <!-- Enhanced Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card inventory-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="inventory-icon-wrapper bg-gradient-primary">
                                    <i class="fas fa-boxes text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Items</h6>
                                <h4 class="mb-0" id="total-items-count">
                                    <span class="counter">0</span>
                                </h4>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-chart-line me-1"></i>Tracking active
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card inventory-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="inventory-icon-wrapper bg-gradient-success">
                                    <i class="fas fa-layer-group text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Categories</h6>
                                <h4 class="mb-0" id="total-categories-count">
                                    <span class="counter">0</span>
                                </h4>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-sitemap me-1"></i>Well organized
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card inventory-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="inventory-icon-wrapper bg-gradient-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Low Stock Items</h6>
                                <h4 class="mb-0" id="low-stock-count">
                                    <span class="counter">0</span>
                                </h4>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-bell me-1"></i>Need attention
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card inventory-summary-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="inventory-icon-wrapper bg-gradient-info">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                                </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Active Items</h6>
                                <h4 class="mb-0" id="active-items-count">
                                    <span class="counter">0</span>
                                </h4>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-heartbeat me-1"></i>In rotation
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-filter me-2"></i>Quick Filters & Search
                            </h6>
                            <button class="btn btn-sm btn-outline-secondary" id="toggleFilters">
                                <i class="fas fa-chevron-down"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body" id="filtersContent">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-search text-primary me-1"></i>Quick Search
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-search text-primary"></i>
                                        </span>
                                        <input type="text" id="quick-search" class="form-control" placeholder="Search items, codes, or categories...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-layer-group text-success me-1"></i>Category
                                    </label>
                                    <select class="form-select" id="filterCategory">
                                        <option value="">All Categories</option>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            <div class="col-md-3">
                                <div class="filter-card">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-toggle-on text-info me-1"></i>Status Filter
                                    </label>
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-outline-primary active btn-sm" data-filter="all">All</button>
                                        <button type="button" class="btn btn-outline-success btn-sm" data-filter="active">Active</button>
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-filter="low-stock">Low Stock</button>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Items Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-1 fw-bold text-primary">
                                    <i class="fas fa-boxes me-2"></i>Inventory Items
                                </h5>
                                <p class="text-muted mb-0 small">Manage your medical supplies and equipment</p>
                                        </div>
                            <div class="d-flex gap-2">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Export Data">
                                        <i class="fas fa-download me-1"></i>Export
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Print Report">
                                        <i class="fas fa-print me-1"></i>Print
                                    </button>
                                    </div>
                                <button type="button" class="btn btn-primary btn-sm shadow-sm" id="addNewItemBtn" data-toggle="modal" data-target="#addItemModal">
                                    <i class="fas fa-plus me-1"></i>Add Item
                                </button>
                                </div>
                                    </div>
                                </div>
                    <div class="card-body p-0">
                        <?php if ($this->session->flashdata('success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="inventory-table">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-barcode me-1"></i>Item Code
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-tag me-1"></i>Name
                                        </th>
                                        <th class="border-0 fw-bold">
                                            <i class="fas fa-layer-group me-1"></i>Category
                                        </th>
                                        <th class="border-0 fw-bold text-center">
                                            <i class="fas fa-cubes me-1"></i>Current Stock
                                        </th>
                                        <th class="border-0 fw-bold text-center">
                                            <i class="fas fa-level-down-alt me-1"></i>Min Level
                                        </th>
                                        <th class="border-0 fw-bold text-end">
                                            <i class="fas fa-dollar-sign me-1"></i>Unit Cost
                                        </th>
                                        <th class="border-0 fw-bold text-center">
                                            <i class="fas fa-toggle-on me-1"></i>Status
                                        </th>
                                        <th class="border-0 fw-bold text-center">
                                            <i class="fas fa-cogs me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body will be filled by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function() {
    console.log("Document ready - initializing inventory page");
    
    // Load summary data with animation
    loadSummaryData();
    
    // Initialize filter functionality
    initializeFilters();
    
    // Check jQuery and Bootstrap versions
    console.log("jQuery version:", $.fn.jquery);
    if ($.fn.modal) {
        console.log("Bootstrap modal plugin is available");
    } else {
        console.error("Bootstrap modal plugin is NOT available");
    }
    
    // Enhanced Quick search functionality
    $('#quick-search').on('keyup', function() {
        var searchTerm = $(this).val();
        $('#inventory-table').DataTable().search(searchTerm).draw();
        
        // Update search highlight
        if (searchTerm.length > 0) {
            $(this).addClass('search-active');
        } else {
            $(this).removeClass('search-active');
        }
    });
    
    // Category filter
    $('#filterCategory').on('change', function() {
        var category = $(this).val();
        var table = $('#inventory-table').DataTable();
        
        if (category === '') {
            table.columns(2).search('').draw();
        } else {
            table.columns(2).search(category, true, false).draw();
        }
    });
    
    // Enhanced Filter buttons
    $('.btn-group[role="group"] button').on('click', function() {
        $('.btn-group[role="group"] button').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        var table = $('#inventory-table').DataTable();
        
        if (filter === 'all') {
            table.search('').columns(6).search('').draw();
        } else if (filter === 'active') {
            table.columns(6).search('active', true, false).draw();
        } else if (filter === 'low-stock') {
            // This is a custom filter that will be handled in the drawCallback
            table.draw();
        }
    });
    
    // Debug the Add New Item button
    $('#addNewItemBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default action
        console.log("Add New Item button clicked");
        // Try to open the modal programmatically
        $('#addItemModal').modal('show');
    });
    
    // Fix modal close buttons
    $('.modal .close, .modal .btn-secondary').on('click', function() {
        console.log("Close button clicked");
        $(this).closest('.modal').modal('hide');
    });
    
    // Function to handle edit button click
    function handleEditButtonClick(itemId, button) {
        console.log("Edit button clicked for item ID:", itemId);
        
        // Clear previous errors
        $('#editFormErrors').hide().html('');
        
        // Show loading indicator
        button.html('<i class="fa fa-spinner fa-spin"></i>');
        
        // Fetch item data via AJAX
        $.ajax({
            url: BASE_URL + 'inventory/getItemData/' + itemId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Item data received:", response);
                
                if (response && response.id) {
                    // Populate the edit form
                    $('#edit_item_id').val(response.id);
                    $('#edit_name').val(response.name);
                    $('#edit_item_code').val(response.item_code);
                    $('#edit_category_id').val(response.category_id);
                    $('#edit_description').val(response.description);
                    $('#edit_unit_of_measure').val(response.unit_of_measure);
                    $('#edit_current_stock').val(response.current_stock);
                    $('#edit_minimum_stock_level').val(response.minimum_stock_level);
                    $('#edit_maximum_stock_level').val(response.maximum_stock_level);
                    $('#edit_unit_cost').val(response.unit_cost);
                    $('#edit_supplier_name').val(response.supplier_name);
                    $('#edit_supplier_contact').val(response.supplier_contact);
                    $('#edit_status').val(response.status);
                    
                    // Update form action
                    $('#editItemForm').attr('action', BASE_URL + 'inventory/editItem/' + response.id);
                    
                    // Show the modal
                    $('#editItemModal').modal('show');
                } else {
                    showNotification('error', 'Failed to load item data. Please try again.');
                }
                
                // Restore button text
                button.html('<i class="fa fa-edit"></i>');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching item data:", error);
                showNotification('error', 'Failed to load item data. Please try again.');
                
                // Restore button text
                button.html('<i class="fa fa-edit"></i>');
            }
        });
    }
    
    // Initialize edit button click handler for static buttons
    $('.editBtn').on('click', function() {
        handleEditButtonClick($(this).data('id'), $(this));
    });
    
    // Edit form submission is now handled in common_scripts.php
    
    // Check if modal exists
    console.log("Modal exists: ", $('#addItemModal').length > 0);
    
    // Initialize modal manually
    $('#addItemModal').modal({
        show: false,
        backdrop: true,
        keyboard: true
    });
    console.log("Add Item Modal initialized:", $('#addItemModal').length);
    
    $('#editItemModal').modal({
        show: false,
        backdrop: true,
        keyboard: true
    });
    console.log("Edit Item Modal initialized:", $('#editItemModal').length);
    
    // Initialize Enhanced DataTables
    var table = $('#inventory-table').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "searchable": true,
        "ajax": {
            url: "inventory/getItems",
            type: 'POST',
        },
        "columns": [
            { "data": 0, "className": "text-center" },
            { "data": 1 },
            { "data": 2 },
            { "data": 3, "className": "text-center" },
            { "data": 4, "className": "text-center" },
            { "data": 5, "className": "text-end" },
            { "data": 6, "className": "text-center" },
            { "data": 7, "orderable": false, "className": "text-center" }
        ],
        "order": [[ 1, "asc" ]],
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search items, codes, categories...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ items",
            "infoEmpty": "No items found",
            "infoFiltered": "(filtered from _MAX_ total items)",
            "paginate": {
                "first": "<i class='fas fa-angle-double-left'></i>",
                "last": "<i class='fas fa-angle-double-right'></i>",
                "next": "<i class='fas fa-angle-right'></i>",
                "previous": "<i class='fas fa-angle-left'></i>"
            },
            "processing": "<div class='loading-spinner'><i class='fas fa-spinner fa-spin fa-3x'></i><br><span class='mt-2'>Loading items...</span></div>",
            "emptyTable": "<div class='text-center p-4'><i class='fas fa-boxes fa-3x text-muted mb-3'></i><br><h5>No items found</h5><p class='text-muted'>Start by adding your first inventory item.</p></div>"
        },
        "drawCallback": function(settings) {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Re-initialize edit buttons after table redraw
            $('.editBtn').off('click').on('click', function() {
                var itemId = $(this).data('id');
                handleEditButtonClick(itemId, $(this));
            });
            
            // Apply custom filter for low stock
            if ($('.btn-group[role="group"] button[data-filter="low-stock"]').hasClass('active')) {
                var api = this.api();
                
                // For each row
                api.rows().every(function() {
                    var data = this.data();
                    var currentStock = parseInt($(data[3]).text());
                    var minLevel = parseInt(data[4]);
                    
                    // If current stock is not less than or equal to min level, hide the row
                    if (currentStock > minLevel) {
                        $(this.node()).hide();
                    } else {
                        $(this.node()).show();
                    }
                });
            }
            
            // Add hover effects to action buttons
            $('.btn-group .btn').hover(
                function() {
                    $(this).find('i').addClass('fa-beat');
                },
                function() {
                    $(this).find('i').removeClass('fa-beat');
                }
            );
        }
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip(); 
    
    // Fix modal z-index issues
    $('.modal').appendTo('body');
    $('.modal-backdrop').appendTo('body');
    
    // Show notifications function
    function showNotification(type, message) {
        var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        var title = type === 'success' ? 'Success!' : 'Error!';
        var alertClass = 'alert-' + type;
        
        var alert = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                      '<div class="d-flex align-items-center">' +
                      '<i class="fas ' + icon + ' mr-2"></i>' +
                      '<div><strong>' + title + '</strong> ' + message + '</div>' +
                      '</div>' +
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                      '<span aria-hidden="true">&times;</span>' +
                      '</button>' +
                      '</div>');
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add the new alert
        $('.card-body').prepend(alert);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});

// Enhanced Function to load summary data with animations
function loadSummaryData() {
    $.ajax({
        url: BASE_URL + 'inventory/getSummaryData',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Animate counters
            animateCounter('#total-items-count .counter', response.total_items || 0);
            animateCounter('#total-categories-count .counter', response.total_categories || 0);
            animateCounter('#low-stock-count .counter', response.low_stock_count || 0);
            animateCounter('#active-items-count .counter', response.active_items || 0);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching summary data:", error);
            $('#total-items-count .counter').text('N/A');
            $('#total-categories-count .counter').text('N/A');
            $('#low-stock-count .counter').text('N/A');
            $('#active-items-count .counter').text('N/A');
        }
    });
}

// Animate Counter Function
function animateCounter(selector, endValue) {
    var $counter = $(selector);
    var startValue = 0;
    var duration = 1500;
    var increment = endValue / (duration / 16);
    
    function updateCounter() {
        startValue += increment;
        if (startValue >= endValue) {
            $counter.text(Math.floor(endValue));
        } else {
            $counter.text(Math.floor(startValue));
            requestAnimationFrame(updateCounter);
        }
    }
    
    updateCounter();
}

// Initialize Filters Function
function initializeFilters() {
    // Toggle filters visibility
    $('#toggleFilters').on('click', function() {
        var $content = $('#filtersContent');
        var $icon = $(this).find('i');
        
        $content.slideToggle(300);
        $icon.toggleClass('fa-chevron-down fa-chevron-up');
    });
    
    // Initially show filters
    $('#filtersContent').show();
    $('#toggleFilters i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
}

// Enhanced Show Notification Function
function showNotification(type, message) {
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var alertClass = 'alert-' + type;
    
    var notification = $('<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
        '<i class="fas ' + icon + ' me-2"></i>' + message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>');
    
    $('body').append(notification);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        notification.alert('close');
    }, 5000);
}

// Initialize tooltips globally
function initializeTooltips() {
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
}

// Call initialize tooltips
initializeTooltips();

// Reinitialize tooltips after AJAX calls
$(document).ajaxComplete(function() {
    initializeTooltips();
});
</script>

<!-- Include common scripts for inventory modals -->
<?php $this->load->view('inventory/common_scripts'); ?>

<!-- Enhanced Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="addItemModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add New Inventory Item
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="formErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="addItemForm" action="<?php echo base_url(); ?>inventory/addItem" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-tag medical-icon"></i> Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="item_code"><i class="fas fa-barcode medical-icon"></i> Item Code</label>
                                <input type="text" name="item_code" id="item_code" class="form-control" placeholder="Leave blank for auto-generation">
                                <small class="form-text text-muted">A unique identifier will be generated automatically if left blank.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="category_id"><i class="fas fa-folder medical-icon"></i> Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="unit_of_measure"><i class="fas fa-balance-scale medical-icon"></i> Unit of Measure <span class="text-danger">*</span></label>
                                <input type="text" name="unit_of_measure" id="unit_of_measure" class="form-control" placeholder="e.g., pieces, ml, kg" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="minimum_stock_level"><i class="fas fa-level-down-alt medical-icon"></i> Minimum Stock Level</label>
                                <input type="number" name="minimum_stock_level" id="minimum_stock_level" class="form-control" value="0" min="0">
                                <small class="form-text text-muted">System will alert when stock falls below this level.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="maximum_stock_level"><i class="fas fa-level-up-alt medical-icon"></i> Maximum Stock Level</label>
                                <input type="number" name="maximum_stock_level" id="maximum_stock_level" class="form-control" value="0" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label for="unit_cost"><i class="fas fa-dollar-sign medical-icon"></i> Unit Cost</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="unit_cost" id="unit_cost" class="form-control" value="0.00" step="0.01" min="0">
                        </div>
                    </div>

                            <div class="form-group">
                                <label for="supplier_name"><i class="fas fa-truck medical-icon"></i> Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"><i class="fas fa-align-left medical-icon"></i> Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="supplier_contact"><i class="fas fa-address-card medical-icon"></i> Supplier Contact</label>
                        <input type="text" name="supplier_contact" id="supplier_contact" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" form="addItemForm" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Add Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="editItemModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Inventory Item
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editFormErrors" class="alert alert-danger" style="display: none;"></div>
                
                <form id="editItemForm" action="<?php echo base_url(); ?>inventory/editItem" method="post">
                    <input type="hidden" name="id" id="edit_item_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name"><i class="fas fa-tag medical-icon"></i> Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_item_code"><i class="fas fa-barcode medical-icon"></i> Item Code</label>
                                <input type="text" name="item_code" id="edit_item_code" class="form-control" readonly>
                                <small class="form-text text-muted">Item code cannot be changed after creation.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_category_id"><i class="fas fa-folder medical-icon"></i> Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="edit_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                            
                            <div class="form-group">
                                <label for="edit_unit_of_measure"><i class="fas fa-balance-scale medical-icon"></i> Unit of Measure <span class="text-danger">*</span></label>
                                <input type="text" name="unit_of_measure" id="edit_unit_of_measure" class="form-control" required>
                    </div>

                            <div class="form-group">
                                <label for="edit_status"><i class="fas fa-toggle-on medical-icon"></i> Status</label>
                                <select name="status" id="edit_status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <small class="form-text text-muted">Inactive items will not appear in regular searches.</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_current_stock"><i class="fas fa-boxes medical-icon"></i> Current Stock</label>
                                <input type="number" name="current_stock" id="edit_current_stock" class="form-control" readonly>
                                <small class="form-text text-muted">Use Purchase or Usage records to adjust stock levels.</small>
                    </div>

                            <div class="form-group">
                                <label for="edit_minimum_stock_level"><i class="fas fa-level-down-alt medical-icon"></i> Minimum Stock Level</label>
                                <input type="number" name="minimum_stock_level" id="edit_minimum_stock_level" class="form-control" min="0">
                                <small class="form-text text-muted">System will alert when stock falls below this level.</small>
                        </div>
                            
                            <div class="form-group">
                                <label for="edit_maximum_stock_level"><i class="fas fa-level-up-alt medical-icon"></i> Maximum Stock Level</label>
                                <input type="number" name="maximum_stock_level" id="edit_maximum_stock_level" class="form-control" min="0">
                    </div>

                            <div class="form-group">
                                <label for="edit_unit_cost"><i class="fas fa-dollar-sign medical-icon"></i> Unit Cost</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="unit_cost" id="edit_unit_cost" class="form-control" step="0.01" min="0">
                        </div>
                    </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description"><i class="fas fa-align-left medical-icon"></i> Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_supplier_name"><i class="fas fa-truck medical-icon"></i> Supplier Name</label>
                                <input type="text" name="supplier_name" id="edit_supplier_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_supplier_contact"><i class="fas fa-address-card medical-icon"></i> Supplier Contact</label>
                                <input type="text" name="supplier_contact" id="edit_supplier_contact" class="form-control">
                    </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" form="editItemForm" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Item
                </button>
            </div>
        </div>
    </div>
</div>
