<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('inventory_model');
        $this->load->model('patient/patient_model');
        $this->load->model('settings/settings_model');
        $this->load->library('pagination');
        
        // Load settings
        $this->settings = $this->settings_model->getSettings();
        
        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'Pharmacist', 'Laboratorist', 'super admin'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        redirect('inventory/dashboard');
    }
    
    public function dashboard() {
        $data = [];
        $data['page'] = 'Dashboard';
        $data['page_title'] = 'Inventory Dashboard';
        $data['inventory_items'] = $this->inventory_model->getInventoryItems();
        $data['categories'] = $this->inventory_model->getInventoryCategories();
        $data['total_stock_value'] = $this->inventory_model->getTotalStockValue();
        $data['low_stock_count'] = $this->inventory_model->getLowStockCount();
        $data['recent_purchases'] = $this->db->order_by('purchase_date', 'desc')->limit(5)->get_where('inventory_purchases', array('hospital_id' => $this->session->userdata('hospital_id')))->result();
        $data['recent_usage'] = $this->db->order_by('usage_date', 'desc')->limit(5)->get_where('inventory_usage', array('hospital_id' => $this->session->userdata('hospital_id')))->result();
        
        // Get category-wise stock distribution
        $data['category_distribution'] = [];
        foreach ($data['categories'] as $category) {
            $this->db->select('SUM(current_stock) as total_stock, SUM(current_stock * unit_cost) as total_value');
            $this->db->where('category_id', $category->id);
            $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
            $result = $this->db->get('inventory_items')->row();
            
            $data['category_distribution'][] = [
                'category' => $category->name,
                'total_stock' => $result->total_stock ?: 0,
                'total_value' => $result->total_value ?: 0
            ];
        }
        
        if($this->ion_auth->in_group('admin')){                
            if(isset($this->settings->dashboard_theme) && $this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('dashboard', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('dashboard', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('dashboard', $data);
            $this->load->view('home/footer'); 
        }
    }

    public function items() {
        $data = [];
        $data['page'] = 'Items';
        $data['page_title'] = 'Inventory Items';
        $data['inventory_items'] = $this->inventory_model->getInventoryItems();
        $data['categories'] = $this->inventory_model->getInventoryCategories();
        
        if($this->ion_auth->in_group('admin')){                
            if($this->settings->dashboard_theme == 'main'){
                $this->load->view('home/layout/header'); 
                $this->load->view('Items', $data);
                $this->load->view('home/layout/footer'); 
            }else{
                $this->load->view('home/dashboard'); 
                $this->load->view('Items', $data);
                $this->load->view('home/footer'); 
            }
        } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('Items', $data);
            $this->load->view('home/footer'); 
        }
    }

    public function addItem() {
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('name', 'Item Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('unit_of_measure', 'Unit of Measure', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            // Check if it's an AJAX request
            if ($this->input->is_ajax_request()) {
                $response = [
                    'success' => false,
                    'errors' => [
                        'name' => form_error('name'),
                        'category_id' => form_error('category_id'),
                        'unit_of_measure' => form_error('unit_of_measure')
                    ]
                ];
                echo json_encode($response);
                return;
            } else {
                // Regular form submission
                $data = [];
                $data['page'] = 'Add Item';
                $data['page_title'] = 'Add Inventory Item';
                $data['categories'] = $this->inventory_model->getInventoryCategories();
                $this->load->view('home/dashboard'); 
                $this->load->view('add_item', $data);
                $this->load->view('home/footer');
            }
        } else {
            $item_code = $this->input->post('item_code');
            if (empty($item_code)) {
                $item_code = 'INV-' . strtoupper(substr(md5(uniqid()), 0, 8));
            }

            $data = array(
                'name' => $this->input->post('name'),
                'item_code' => $item_code,
                'category_id' => $this->input->post('category_id'),
                'description' => $this->input->post('description'),
                'unit_of_measure' => $this->input->post('unit_of_measure'),
                'minimum_stock_level' => $this->input->post('minimum_stock_level') ?: 0,
                'maximum_stock_level' => $this->input->post('maximum_stock_level') ?: 0,
                'unit_cost' => $this->input->post('unit_cost') ?: 0.00,
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_contact' => $this->input->post('supplier_contact'),
                'storage_location' => $this->input->post('storage_location'),
                'expiry_tracking' => $this->input->post('expiry_tracking') ? 1 : 0,
                'status' => 'active',
                'created_by' => $this->session->userdata('user_id')
            );

            $item_id = $this->inventory_model->insertInventoryItem($data);
            
            // Check if it's an AJAX request
            if ($this->input->is_ajax_request()) {
                $response = [
                    'success' => true,
                    'message' => 'Item added successfully',
                    'item_id' => $item_id
                ];
                echo json_encode($response);
                return;
            } else {
                // Regular form submission
                $this->session->set_flashdata('success', 'Item added successfully');
                redirect('inventory/items');
            }
        }
    }

    public function editItem($id = null) {
        if (!$id && $this->input->post('id')) {
            $id = $this->input->post('id');
        }
        
        if (!$id) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Item ID is required']);
                return;
            } else {
                $this->session->set_flashdata('error', 'Item ID is required');
                redirect('inventory/items');
            }
        }
        
        $data = [];
        $data['page'] = 'Edit Item';
        $data['page_title'] = 'Edit Inventory Item';
        $data['item'] = $this->inventory_model->getInventoryItemById($id);
        $data['categories'] = $this->inventory_model->getInventoryCategories();
        
        if (!$data['item']) {
            if ($this->input->is_ajax_request()) {  
                echo json_encode(['success' => false, 'message' => 'Item not found']);
                return;
            } else {
            $this->session->set_flashdata('error', 'Item not found');
            redirect('inventory/items');
            }
        }

        $this->form_validation->set_rules('name', 'Item Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('unit_of_measure', 'Unit of Measure', 'required');

        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {
                $response = [
                    'success' => false,
                    'errors' => [
                        'name' => form_error('name'),
                        'category_id' => form_error('category_id'),
                        'unit_of_measure' => form_error('unit_of_measure')
                    ]
                ];
                echo json_encode($response);
                return;
            } else {
            $this->load->view('home/dashboard'); 
            $this->load->view('edit_item', $data);
            $this->load->view('home/footer');
            }
        } else {
            $update_data = array(
                'name' => $this->input->post('name'),
                'category_id' => $this->input->post('category_id'),
                'description' => $this->input->post('description'),
                'unit_of_measure' => $this->input->post('unit_of_measure'),
                'minimum_stock_level' => $this->input->post('minimum_stock_level') ?: 0,
                'maximum_stock_level' => $this->input->post('maximum_stock_level') ?: 0,
                'unit_cost' => $this->input->post('unit_cost') ?: 0.00,
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_contact' => $this->input->post('supplier_contact'),
                'status' => $this->input->post('status')
            );

            $this->inventory_model->updateInventoryItem($id, $update_data);
            
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
                return;
            } else {
            $this->session->set_flashdata('success', 'Item updated successfully');
            redirect('inventory/items');
            }
        }
    }

    // Get item data for edit modal
    public function getItemData($id) {
        $item = $this->inventory_model->getInventoryItemById($id);
        if ($item) {
            echo json_encode($item);
        } else {
            echo json_encode(['error' => 'Item not found']);
        }
    }

    public function purchases() {
        $data = [];
        $data['page'] = 'Purchases';
        $data['page_title'] = 'Inventory Purchases';
        $data['purchases'] = $this->inventory_model->getInventoryPurchases();
        
        $this->load->view('home/dashboard'); 
        $this->load->view('Purchases', $data);
        $this->load->view('home/footer');
    }

    public function addPurchase() {
        // Check if the request is AJAX
        if (!$this->input->is_ajax_request()) {
            redirect('inventory/purchases');
        }
        
        // Form validation
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('item_id', 'Item', 'required|trim|numeric');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required|trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
                $response = [
                    'success' => false,
                'errors' => $this->form_validation->error_array()
                ];
                echo json_encode($response);
                return;
        } else {
            $quantity = $this->input->post('quantity');
            $unit_cost = $this->input->post('unit_cost');
            
            // Get user ID, fallback to 1 if not set
            $user_id = $this->session->userdata('user_id');
            if (!$user_id && $this->ion_auth->logged_in()) {
                $user = $this->ion_auth->user()->row();
                $user_id = $user->id;
            }
            if (!$user_id) {
                $user_id = 1; // Default admin user
            }
            
            $data = array(
                'purchase_order_no' => $this->input->post('purchase_order_no'),
                'item_id' => $this->input->post('item_id'),
                'quantity' => $quantity,
                'unit_cost' => $unit_cost,
                'total_cost' => $quantity * $unit_cost,
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_invoice_no' => $this->input->post('supplier_invoice_no'),
                'purchase_date' => $this->input->post('purchase_date'),
                'expiry_date' => $this->input->post('expiry_date') ?: null,
                'batch_number' => $this->input->post('batch_number'),
                'received_by' => $user_id,
                'notes' => $this->input->post('notes'),
                'status' => 'received',
                'created_at' => date('Y-m-d H:i:s')
            );

            $purchase_id = $this->inventory_model->insertInventoryPurchase($data);
            
            if ($purchase_id) {
            // Update item stock
            $this->inventory_model->updateItemStock($this->input->post('item_id'), $quantity, 'add');
            
                $response = [
                    'success' => true,
                    'message' => 'Purchase recorded successfully',
                    'purchase_id' => $purchase_id
                ];
            } else {
                // Log the database error
                $db_error = $this->db->error();
                log_message('error', 'Failed to insert purchase: ' . json_encode($db_error));
                log_message('error', 'Purchase data: ' . json_encode($data));
                
                $response = [
                    'success' => false,
                    'message' => 'Failed to record purchase. Please try again.'
                ];
            }
            
                echo json_encode($response);
                return;
        }
    }

    public function usage() {
        $data = [];
        $data['page'] = 'Usage';
        $data['page_title'] = 'Inventory Usage';
        $data['usage_records'] = $this->inventory_model->getInventoryUsage();
        
        $this->load->view('home/dashboard'); 
        $this->load->view('Usage', $data); 
        $this->load->view('home/footer');   
    }

    public function addUsage() {
        // Check if the request is AJAX
        if (!$this->input->is_ajax_request()) {
            redirect('inventory/usage'); 
        }
        
        // Form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item_id', 'Item', 'required|trim|numeric');
        $this->form_validation->set_rules('quantity_used', 'Quantity Used', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('usage_type', 'Usage Type', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
                $response = [
                    'success' => false,
                'errors' => $this->form_validation->error_array()
            ];
            } else {
            // Check if there is enough stock
            $item_id = $this->input->post('item_id');
            $quantity_used = $this->input->post('quantity_used');
            
            $item = $this->db->get_where('inventory_items', ['id' => $item_id])->row();
            
            if (!$item || $item->current_stock < $quantity_used) {
                    $response = [
                        'success' => false,
                    'message' => 'Not enough stock available'
                    ];
                } else {
                // Get user ID, fallback if not available
                $user_id = $this->session->userdata('user_id');
                if (!$user_id && $this->ion_auth->logged_in()) {
                    $user = $this->ion_auth->user()->row();
                    $user_id = $user->id;
                }
                if (!$user_id) {
                    $user_id = 1; // Default admin user
                }
                
                // Prepare data for insertion
                $data = [
                'item_id' => $item_id,
                'quantity_used' => $quantity_used,
                'usage_type' => $this->input->post('usage_type'),
                'patient_id' => $this->input->post('patient_id'),
                    'reference_type' => $this->input->post('reference_type'),
                    'reference_id' => $this->input->post('reference_id'),
                    'batch_number' => $this->input->post('batch_number'),
                'notes' => $this->input->post('notes'),
                    'used_by' => $user_id,
                    'usage_date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s') 
                ]; 
                
                // Insert usage record using model method
                $usage_id = $this->inventory_model->insertInventoryUsage($data);
                
                if ($usage_id) {
            // Update item stock using model method
                    $this->inventory_model->updateItemStock($item_id, $quantity_used, 'subtract');
            
                $response = [
                    'success' => true,
                        'message' => 'Usage recorded successfully',
                        'usage_id' => $usage_id
                ];
            } else {
                    $response = [
                        'success' => false,
                        'message' => 'Failed to record usage'
                    ];
                }
            }
        }
        
        echo json_encode($response);
    }

    public function alerts() {
        $data = [];
        $data['page'] = 'Alerts';
        $data['page_title'] = 'Stock Alerts';
        $data['alerts'] = $this->inventory_model->getStockAlerts();
        
        $this->load->view('home/dashboard'); 
        $this->load->view('Alerts', $data);
        $this->load->view('home/footer');
    }

    public function categories() {
        $data = [];
        $data['page'] = 'Categories';
        $data['page_title'] = 'Inventory Categories';
        $data['categories'] = $this->inventory_model->getInventoryCategories();
        $data['inventory_items'] = $this->inventory_model->getInventoryItems();
        
        $this->load->view('home/dashboard'); 
        $this->load->view('Categories', $data);
        $this->load->view('home/footer');
    }

    public function addCategory() {
        // Check if the request is AJAX
        if (!$this->input->is_ajax_request()) {
            redirect('inventory/categories');
        }
        
        // Form validation
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
                $response = [
                    'success' => false,
                'errors' => $this->form_validation->error_array()
                ];
            } else {
            // Prepare data for insertion
            $data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            ];
            
            // Debug hospital_id
            $hospital_id = $this->session->userdata('hospital_id');
            log_message('debug', 'Adding category with hospital_id: ' . $hospital_id);
            log_message('debug', 'Session data: ' . json_encode($this->session->userdata()));
            
            // Insert using model method which adds hospital_id
            $category_id = $this->inventory_model->insertInventoryCategory($data);
            
            if ($category_id) {
                $response = [
                    'success' => true,
                    'message' => 'Category added successfully',
                    'category_id' => $category_id
                ];
            } else {
                // Log the error
                $db_error = $this->db->error();
                log_message('error', 'Failed to insert category: ' . json_encode($db_error));
                log_message('error', 'Category data: ' . json_encode($data));
                log_message('error', 'Hospital ID: ' . $this->session->userdata('hospital_id'));
                
                $response = [
                    'success' => false,
                    'message' => 'Failed to add category. Please try again.'
                ];
            }
        }
        
        echo json_encode($response);
    }

    public function reports() {
        $data = [];
        $data['page'] = 'Reports';
        $data['page_title'] = 'Inventory Reports';
        
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $category = $this->input->get('category');
        
        $data['stock_report'] = $this->inventory_model->getStockReport($category);
        $data['usage_report'] = $this->inventory_model->getUsageReport($from_date, $to_date, $category);
        $data['purchase_report'] = $this->inventory_model->getPurchaseReport($from_date, $to_date, $category);
        $data['categories'] = $this->inventory_model->getInventoryCategories();
        
        $this->load->view('home/dashboard'); 
        $this->load->view('Reports', $data);
        $this->load->view('home/footer');
    }

    // AJAX methods for getting item info
    public function getItemInfo() {
        // Get search term from GET or POST
        $searchTerm = '';
        if ($this->input->get('searchTerm') !== null) {
            $searchTerm = $this->input->get('searchTerm');
        } elseif ($this->input->post('searchTerm') !== null) {
            $searchTerm = $this->input->post('searchTerm');
        }
        
        // Log request details
        log_message('debug', 'getItemInfo called with searchTerm: ' . $searchTerm);
        
        // Get items from model
        $items = $this->inventory_model->getItemInfo($searchTerm);
        
        // Debug info
        if (empty($items)) {
            log_message('debug', 'No items found for searchTerm: ' . $searchTerm);
        } else {
            log_message('debug', 'Found ' . count($items) . ' items for searchTerm: ' . $searchTerm);
            log_message('debug', 'First item: ' . json_encode(reset($items)));
        }
        
        echo json_encode($items);
    }

    public function deleteItem($id) {
        $this->inventory_model->deleteInventoryItem($id);
        $this->session->set_flashdata('success', 'Item deleted successfully');
        redirect('inventory/items');
    }

    public function markAlertRead($id) {
        $this->inventory_model->markAlertAsRead($id);
        
        // Check if it's an AJAX request (from dashboard)
        if ($this->input->is_ajax_request()) {
            echo json_encode(['success' => true, 'message' => 'Alert marked as read']);
            return;
        } else {
            redirect('inventory/alerts');
        }
    }

    public function deleteCategory($id) {
        // Check if category has items
        $item_count = $this->db->where('category_id', $id)
                           ->where('hospital_id', $this->session->userdata('hospital_id'))
                           ->count_all_results('inventory_items');
        
        if ($item_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete category with existing items. Please move or delete all items first.');
            redirect('inventory/categories');
            return;
        }
        
        // Delete the category
        $this->inventory_model->deleteInventoryCategory($id);
        $this->session->set_flashdata('success', 'Category deleted successfully');
        redirect('inventory/categories');
    }

    public function deletePurchase($id) {
        // Get purchase details before deletion
        $purchase = $this->db->get_where('inventory_purchases', ['id' => $id])->row();
        
        if (!$purchase) {
            $this->session->set_flashdata('error', 'Purchase record not found');
            redirect('inventory/purchases');
            return;
        }
        
        // If purchase was received, we need to adjust the stock
        if ($purchase->status == 'received') {
            $this->inventory_model->updateItemStock($purchase->item_id, $purchase->quantity, 'subtract');
        }
        
        // Delete the purchase record
        $this->db->delete('inventory_purchases', ['id' => $id]);
        $this->session->set_flashdata('success', 'Purchase record deleted successfully');
        redirect('inventory/purchases');
    }
    
    public function deleteUsage($id) {
        // Get usage details before deletion
        $usage = $this->db->get_where('inventory_usage', ['id' => $id])->row();
        
        if (!$usage) {
            $this->session->set_flashdata('error', 'Usage record not found');
            redirect('inventory/usage');
            return;
        }
        
        // Return the used quantity back to stock
        $this->inventory_model->updateItemStock($usage->item_id, $usage->quantity_used, 'add');
        
        // Delete the usage record
        $this->db->delete('inventory_usage', ['id' => $id]);
        $this->session->set_flashdata('success', 'Usage record deleted successfully');
        redirect('inventory/usage');
    }

    // Server-side processing for inventory items
    public function getItems() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        
        $order = $this->input->post("order");
        $columns_valid = array(
            "0" => "item_code",
            "1" => "name",
            "2" => "category_name",
            "3" => "current_stock",
            "4" => "minimum_stock_level",
            "5" => "unit_cost",
            "6" => "status"
        );
        
        $values = $this->settings_model->getColumnOrder($order, $columns_valid);
        $dir = $values[0];
        $order = $values[1];
        
        if ($limit == -1) {
            if (!empty($search)) {
                $data['items'] = $this->inventory_model->getInventoryItemsBySearch($search, $order, $dir);
            } else {
                $data['items'] = $this->inventory_model->getInventoryItemsWithoutSearch($order, $dir);
            }
        } else {
            if (!empty($search)) {
                $data['items'] = $this->inventory_model->getInventoryItemsByLimitBySearch($limit, $start, $search, $order, $dir);
            } else {
                $data['items'] = $this->inventory_model->getInventoryItemsByLimit($limit, $start, $order, $dir);
            }
        }
        
        $totalFiltered = count($data['items']);
        $totalData = $this->inventory_model->getTotalInventoryItems();
        
        $output = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => array()
        );
        
        foreach ($data['items'] as $item) {
            $stockClass = ($item->current_stock <= $item->minimum_stock_level) ? 'badge-danger' : 'badge-success';
            $statusClass = ($item->status == 'active') ? 'badge-success' : 'badge-secondary';
            
            $options = '<div class="btn-group">';
            $options .= '<button type="button" data-id="' . $item->id . '" class="btn btn-info btn-sm editBtn" title="Edit"><i class="fa fa-edit"></i></button>';
            $options .= '<a href="' . base_url('inventory/addUsage?item_id=' . $item->id) . '" class="btn btn-warning btn-sm" title="Record Usage"><i class="fa fa-minus"></i></a>';
            $options .= '<a href="' . base_url('inventory/addPurchase?item_id=' . $item->id) . '" class="btn btn-success btn-sm" title="Add Stock"><i class="fa fa-plus"></i></a>';
            $options .= '<a href="' . base_url('inventory/deleteItem/' . $item->id) . '" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this item?\')"><i class="fa fa-trash"></i></a>';
            $options .= '</div>';
            
            $row = array();
            $row[] = $item->item_code;
            $row[] = '<strong>' . $item->name . '</strong>' . ($item->description ? '<br><small class="text-muted">' . $item->description . '</small>' : '');
            $row[] = $item->category_name;
            $row[] = '<span class="badge ' . $stockClass . '">' . $item->current_stock . ' ' . $item->unit_of_measure . '</span>';
            $row[] = $item->minimum_stock_level;
            $row[] = number_format($item->unit_cost, 2);
            $row[] = '<span class="badge ' . $statusClass . '">' . ucfirst($item->status) . '</span>';
            $row[] = $options;
            
            $output['data'][] = $row;
        }
        
        echo json_encode($output);
    }

    // Get inventory summary data for dashboard cards
    public function getSummaryData() {
        $data = [
            'total_items' => $this->db->count_all_results('inventory_items'),
            'total_categories' => $this->db->count_all_results('inventory_categories'),
            'low_stock_count' => $this->inventory_model->getLowStockCount(),
            'active_items' => $this->db->where('status', 'active')->count_all_results('inventory_items')
        ];
        
        echo json_encode($data);
    }
    
    public function getCategoriesData() {
        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        
        $col = 0;
        $dir = "";
        
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
        
        $valid_columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'description'
        );
        
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        
        // Get categories
        $this->db->select('inventory_categories.*');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->group_end();
        }
        
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        
        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        
        $categories = $this->db->get('inventory_categories')->result();
        
        $data = array();
        
        foreach ($categories as $category) {
            // Get item count for this category
            $item_count = $this->db->where('category_id', $category->id)
                               ->where('hospital_id', $this->session->userdata('hospital_id'))
                               ->count_all_results('inventory_items');
            
            $nestedData = array();
            $nestedData[] = $category->id;
            $nestedData[] = $category->name;
            $nestedData[] = $category->description ?: 'N/A';
            $nestedData[] = $item_count;
            
            // Actions
            $actions = '<div class="btn-group">';
            $actions .= '<button type="button" class="btn btn-info btn-sm editCategoryBtn" data-id="' . $category->id . '"><i class="fa fa-edit"></i></button>';
            $actions .= '<a href="' . base_url('inventory/deleteCategory/' . $category->id) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this category?\');"><i class="fa fa-trash"></i></a>';
            $actions .= '</div>';
            
            $nestedData[] = $actions;
            
            $data[] = $nestedData;
        }
        
        $total_categories = $this->db->where('hospital_id', $this->session->userdata('hospital_id'))->count_all_results('inventory_categories');
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_categories,
            "recordsFiltered" => $total_categories,
            "data" => $data
        );
        
        echo json_encode($output);
        exit();
    }
    
    public function getCategoryData($id) {
        $category = $this->inventory_model->getInventoryCategoryById($id);
        if ($category) {
            echo json_encode($category);
        } else {
            echo json_encode(['error' => 'Category not found']);
        }
    }
    
    public function editCategory() {
        $id = $this->input->post('id');
        
        if (!$id) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Category ID is required']);
                return;
            } else {
                $this->session->set_flashdata('error', 'Category ID is required');
                redirect('inventory/categories');
            }
        }
        
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {
                $response = [
                    'success' => false,
                    'errors' => [
                        'name' => form_error('name')
                    ]
                ];
                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('inventory/categories');
            }
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            
            $this->inventory_model->updateInventoryCategory($id, $data);
            
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
                return;
            } else {
                $this->session->set_flashdata('success', 'Category updated successfully');
                redirect('inventory/categories');
            }
        }
    }

    public function getPurchasesData() {
        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        
        $col = 0;
        $dir = "";
        
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
        
        $valid_columns = array(
            0 => 'purchase_order_no',
            1 => 'i.name',
            2 => 'p.quantity',
            3 => 'p.unit_cost',
            4 => 'p.total_cost',
            5 => 'p.supplier_name',
            6 => 'p.purchase_date',
            7 => 'p.expiry_date',
            8 => 'p.status'
        );
        
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        
        // Get purchases
        $this->db->select('p.*, i.name as item_name');
        $this->db->from('inventory_purchases p');
        $this->db->join('inventory_items i', 'i.id = p.item_id', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('p.purchase_order_no', $search);
            $this->db->or_like('i.name', $search);
            $this->db->or_like('p.supplier_name', $search);
            $this->db->or_like('p.status', $search);
            $this->db->group_end();
        }
        
        $this->db->where('p.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('p.purchase_date', 'desc');
        }
        
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        
        $purchases = $this->db->get()->result();
        
        $data = array();
        
        foreach ($purchases as $purchase) {
            $nestedData = array();
            $nestedData[] = $purchase->purchase_order_no ?: 'N/A';
            $nestedData[] = $purchase->item_name;
            $nestedData[] = $purchase->quantity;
            $nestedData[] = number_format($purchase->unit_cost, 2);
            $nestedData[] = number_format($purchase->total_cost, 2);
            $nestedData[] = $purchase->supplier_name ?: 'N/A';
            $nestedData[] = date('Y-m-d', strtotime($purchase->purchase_date));
            
            // Expiry date with badge if close to expiry
            $expiry_html = '';
            if ($purchase->expiry_date) {
                $expiry_html = date('Y-m-d', strtotime($purchase->expiry_date));
                
                // Check if expiry date is within 30 days
                $expiry = new DateTime($purchase->expiry_date);
                $now = new DateTime();
                $days_remaining = $now->diff($expiry)->days;
                
                if ($expiry < $now) {
                    $expiry_html .= ' <span class="badge badge-danger">Expired</span>';
                } elseif ($days_remaining <= 30) {
                    $expiry_html .= ' <span class="badge badge-warning">Expires in ' . $days_remaining . ' days</span>';
                }
            } else {
                $expiry_html = 'N/A';
            }
            $nestedData[] = $expiry_html;
            
            // Status with badge
            $status_badge = '<span class="badge badge-';
            $status_badge .= $purchase->status == 'received' ? 'success' : 
                            ($purchase->status == 'pending' ? 'warning' : 'info');
            $status_badge .= '">' . ucfirst($purchase->status) . '</span>';
            $nestedData[] = $status_badge;
            
            // Actions
            $actions = '<div class="btn-group">';
            $actions .= '<button type="button" class="btn btn-info btn-sm viewPurchaseBtn" data-id="' . $purchase->id . '"><i class="fa fa-eye"></i></button>';
            $actions .= '<button type="button" class="btn btn-primary btn-sm editPurchaseBtn" data-id="' . $purchase->id . '"><i class="fa fa-edit"></i></button>';
            $actions .= '<a href="' . base_url('inventory/deletePurchase/' . $purchase->id) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this purchase record?\');"><i class="fa fa-trash"></i></a>';
            $actions .= '</div>';
            
            $nestedData[] = $actions;
            
            $data[] = $nestedData;
        }
        
        $total_purchases = $this->db->where('hospital_id', $this->session->userdata('hospital_id'))->count_all_results('inventory_purchases');
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_purchases,
            "recordsFiltered" => $total_purchases,
            "data" => $data
        );
        
        echo json_encode($output);
        exit();
    }
    
    public function getPurchaseData($id) {
        $this->db->select('p.*, i.name as item_name');
        $this->db->from('inventory_purchases p');
        $this->db->join('inventory_items i', 'i.id = p.item_id', 'left');
        $this->db->where('p.id', $id);
        $purchase = $this->db->get()->row();
        
        if ($purchase) {
            echo json_encode($purchase);
        } else {
            echo json_encode(['error' => 'Purchase record not found']);
        }
    }
    
    public function editPurchase() {
        $id = $this->input->post('id');
        
        if (!$id) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Purchase ID is required']);
                return;
            } else {
                $this->session->set_flashdata('error', 'Purchase ID is required');
                redirect('inventory/purchases');
            }
        }
        
        // Get the current purchase data to calculate stock adjustment
        $current_purchase = $this->db->get_where('inventory_purchases', ['id' => $id])->row();
        
        if (!$current_purchase) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Purchase record not found']);
                return;
            } else {
                $this->session->set_flashdata('error', 'Purchase record not found');
                redirect('inventory/purchases');
            }
        }
        
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('item_id', 'Item', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required|numeric');
        $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {
                $response = [
                    'success' => false,
                    'errors' => [
                        'item_id' => form_error('item_id'),
                        'quantity' => form_error('quantity'),
                        'unit_cost' => form_error('unit_cost'),
                        'purchase_date' => form_error('purchase_date')
                    ]
                ];
                echo json_encode($response);
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('inventory/purchases');
            }
        } else {
            $quantity = $this->input->post('quantity');
            $unit_cost = $this->input->post('unit_cost');
            $item_id = $this->input->post('item_id');
            
            $data = array(
                'purchase_order_no' => $this->input->post('purchase_order_no'),
                'item_id' => $item_id,
                'quantity' => $quantity,
                'unit_cost' => $unit_cost,
                'total_cost' => $quantity * $unit_cost,
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_invoice_no' => $this->input->post('supplier_invoice_no'),
                'purchase_date' => $this->input->post('purchase_date'),
                'expiry_date' => $this->input->post('expiry_date') ?: null,
                'batch_number' => $this->input->post('batch_number'),
                'notes' => $this->input->post('notes'),
                'status' => $this->input->post('status'),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->where('id', $id);
            $this->db->update('inventory_purchases', $data);
            
            // Adjust inventory stock if quantity changed and status is received
            if ($current_purchase->quantity != $quantity && $this->input->post('status') == 'received') {
                // First, revert the old quantity
                $this->inventory_model->updateItemStock($item_id, $current_purchase->quantity, 'subtract');
                
                // Then add the new quantity
                $this->inventory_model->updateItemStock($item_id, $quantity, 'add');
            }
            
            // If status changed from pending to received, update stock
            if ($current_purchase->status != 'received' && $this->input->post('status') == 'received') {
                $this->inventory_model->updateItemStock($item_id, $quantity, 'add');
            }
            
            // If status changed from received to cancelled/pending, revert stock
            if ($current_purchase->status == 'received' && $this->input->post('status') != 'received') {
                $this->inventory_model->updateItemStock($item_id, $quantity, 'subtract');
            }
            
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true, 'message' => 'Purchase updated successfully']);
                return;
            } else {
                $this->session->set_flashdata('success', 'Purchase updated successfully');
                redirect('inventory/purchases');
            }
        }
    }
    
    public function getUsageData() {
        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        
        $col = 0;
        $dir = "";
        
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
        
        $valid_columns = array(
            0 => 'i.name',
            1 => 'u.quantity_used',
            2 => 'u.usage_type',
            3 => 'p.name',
            4 => 'u.reference_type',
            5 => 'u.batch_number',
            6 => 'u.usage_date',
            7 => 'users.username'
        );
        
        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        
        // Load encryption helper
        $this->load->helper('db_encrypt');
        
        // Get usage records
        $this->db->select('u.*, i.name as item_name, users.username as user_name, p.name as patient_name');
        $this->db->from('inventory_usage u');
        $this->db->join('inventory_items i', 'i.id = u.item_id', 'left');
        $this->db->join('users', 'users.id = u.used_by', 'left');
        $this->db->join('patient p', 'p.id = u.patient_id', 'left');
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('i.name', $search);
            $this->db->or_like('u.usage_type', $search);
            $this->db->or_like('p.name', $search);
            $this->db->or_like('u.batch_number', $search);
            $this->db->or_like('users.username', $search);
            $this->db->group_end();
        }
        
        $this->db->where('u.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('u.usage_date', 'desc');
        }
        
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        
        $usage_records = $this->db->get()->result();
        
        $data = array();
        
        foreach ($usage_records as $record) {
            $nestedData = array();
            $nestedData[] = $record->item_name;
            $nestedData[] = $record->quantity_used;
            $nestedData[] = ucfirst($record->usage_type);
            
            // Decrypt patient name before displaying
            $patient_name = 'N/A';
            if ($record->patient_name) {
                $patient_name = db_decrypt($record->patient_name);
            }
            $nestedData[] = $patient_name;
            
            // Reference
            $reference = 'N/A';
            if ($record->reference_id && $record->reference_type) {
                $reference = ucfirst($record->reference_type) . ' #' . $record->reference_id;
            }
            $nestedData[] = $reference;
            
            $nestedData[] = $record->batch_number ?: 'N/A';
            $nestedData[] = date('Y-m-d H:i', strtotime($record->usage_date));
            $nestedData[] = $record->user_name ?: 'N/A';
            
            // Actions
            $actions = '<div class="btn-group">';
            $actions .= '<button type="button" class="btn btn-info btn-sm viewUsageBtn" data-id="' . $record->id . '"><i class="fa fa-eye"></i></button>';
            $actions .= '<a href="' . base_url('inventory/deleteUsage/' . $record->id) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this usage record?\');"><i class="fa fa-trash"></i></a>';
            $actions .= '</div>';
            
            $nestedData[] = $actions;
            
            $data[] = $nestedData;
        }
        
        $total_records = $this->db->where('hospital_id', $this->session->userdata('hospital_id'))->count_all_results('inventory_usage');
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_records,
            "recordsFiltered" => $total_records,
            "data" => $data
        );
        
        echo json_encode($output);
        exit();
    }
    
    public function getUsageRecordData($id) {
        // Load encryption helper
        $this->load->helper('db_encrypt');
        
        $this->db->select('u.*, i.name as item_name, users.username as user_name, p.name as patient_name');
        $this->db->from('inventory_usage u');
        $this->db->join('inventory_items i', 'i.id = u.item_id', 'left');
        $this->db->join('users', 'users.id = u.used_by', 'left');
        $this->db->join('patient p', 'p.id = u.patient_id', 'left');
        $this->db->where('u.id', $id);
        $usage = $this->db->get()->row();
        
        if ($usage) {
            // Decrypt patient name before returning
            if ($usage->patient_name) {
                $usage->patient_name = db_decrypt($usage->patient_name);
            }
            echo json_encode($usage);
        } else {
            echo json_encode(['error' => 'Usage record not found']);
        }
    }

    // Get all active items for dropdown
    public function getActiveItems() {
        // Log request details
        $searchTerm = '';
        if ($this->input->get('searchTerm') !== null) {
            $searchTerm = $this->input->get('searchTerm');
        } elseif ($this->input->post('searchTerm') !== null) {
            $searchTerm = $this->input->post('searchTerm');
        }
        log_message('debug', 'getActiveItems called with searchTerm: ' . $searchTerm);
        
        $items = $this->inventory_model->getActiveItems($searchTerm);
        
        // Debug info
        if (empty($items)) {
            log_message('debug', 'No active items found');
        } else {
            log_message('debug', 'Found ' . count($items) . ' active items');
            log_message('debug', 'First item: ' . json_encode(reset($items)));
        }
        
        echo json_encode($items);
    }
} 