<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Inventory Categories
    function insertInventoryCategory($data) {
        $hospital_id = $this->session->userdata('hospital_id');
        
        // Fallback to 1 if hospital_id is not set
        if (!$hospital_id) { 
            $hospital_id = 1;
            log_message('warning', 'Hospital ID not found in session, using default: 1');
        }
        
        $data1 = array('hospital_id' => $hospital_id);
        $data2 = array_merge($data, $data1);
        $this->db->insert('inventory_categories', $data2);
        
        // Log the result
        if ($this->db->affected_rows() > 0) {
            log_message('debug', 'Category inserted successfully with ID: ' . $this->db->insert_id());
        } else {
            $error = $this->db->error();
            log_message('error', 'Failed to insert category: ' . json_encode($error));
        }
        
        return $this->db->insert_id();
    }

    function getInventoryCategories() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('inventory_categories');
        return $query->result();
    }

    function getInventoryCategoryById($id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('id', $id);
        $query = $this->db->get('inventory_categories');
        return $query->row();
    }

    function updateInventoryCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('inventory_categories', $data);
    }

    function deleteInventoryCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('inventory_categories');
    }

    // Inventory Items
    function insertInventoryItem($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('inventory_items', $data2);
        return $this->db->insert_id(); 
    }

    function getInventoryItems() {
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('inventory_items.status', 'active');
        $this->db->order_by('inventory_items.name', 'asc');
        $this->db->limit(100);
        $query = $this->db->get();
        return $query->result();
    }

    function getInventoryItemById($id) {
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('inventory_items.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getInventoryItemsByCategory($category_id) {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('inventory_items');
        return $query->result();
    }

    function updateInventoryItem($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('inventory_items', $data);
    }

    function deleteInventoryItem($id) {
        $this->db->where('id', $id);
        $this->db->delete('inventory_items');
    }

    function updateItemStock($item_id, $quantity, $operation) {
        $item = $this->getInventoryItemById($item_id);
        if ($item) {
            if ($operation == 'add') {
                $new_stock = $item->current_stock + $quantity;
            } else if ($operation == 'subtract') {
                $new_stock = $item->current_stock - $quantity;
            }
            
            $this->db->where('id', $item_id);
            $this->db->update('inventory_items', array('current_stock' => $new_stock));
            
            $this->checkStockAlerts($item_id);
        }
    }

    // Inventory Purchases
    function insertInventoryPurchase($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('inventory_purchases', $data2);
        return $this->db->insert_id();
    }

    function getInventoryPurchases() {
        $this->db->select('inventory_purchases.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_purchases');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_purchases.item_id');
        $this->db->where('inventory_purchases.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('inventory_purchases.purchase_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getInventoryPurchaseById($id) {
        $this->db->select('inventory_purchases.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_purchases');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_purchases.item_id');
        $this->db->where('inventory_purchases.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('inventory_purchases.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateInventoryPurchase($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('inventory_purchases', $data);
    }

    // Inventory Usage
    function insertInventoryUsage($data) {
        $data1 = array('hospital_id' => $this->session->userdata('hospital_id'));
        $data2 = array_merge($data, $data1);
        $this->db->insert('inventory_usage', $data2);
        return $this->db->insert_id();
    }

    function getInventoryUsage() {
        $this->db->select('inventory_usage.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_usage');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_usage.item_id');
        $this->db->where('inventory_usage.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->order_by('inventory_usage.usage_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getInventoryUsageByItem($item_id) {
        $this->db->select('inventory_usage.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_usage');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_usage.item_id');
        $this->db->where('inventory_usage.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('inventory_usage.item_id', $item_id);
        $this->db->order_by('inventory_usage.usage_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getInventoryUsageByReference($reference_id, $reference_type) {
        $this->db->select('inventory_usage.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_usage');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_usage.item_id');
        $this->db->where('inventory_usage.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('inventory_usage.reference_id', $reference_id);
        $this->db->where('inventory_usage.reference_type', $reference_type);
        $this->db->order_by('inventory_usage.usage_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // Stock Alerts
    function checkStockAlerts($item_id) {
        $item = $this->getInventoryItemById($item_id);
        if ($item) {
            $this->db->where('item_id', $item_id);
            $this->db->delete('inventory_alerts');
            
            if ($item->current_stock <= $item->minimum_stock_level) {
                $alert_level = 'high';
                if ($item->current_stock == 0) {
                    $alert_type = 'out_of_stock';
                    $alert_level = 'critical';
                    $message = "Item '{$item->name}' is out of stock.";
                } else {
                    $alert_type = 'low_stock';
                    $message = "Item '{$item->name}' is running low. Current stock: {$item->current_stock}";
                }
                
                $alert_data = array(
                    'item_id' => $item_id,
                    'alert_type' => $alert_type,
                    'alert_level' => $alert_level,
                    'message' => $message,
                    'hospital_id' => $this->session->userdata('hospital_id')
                );
                
                $this->db->insert('inventory_alerts', $alert_data);
            }
        }
    }

    function getStockAlerts($is_read = null) {
        $this->db->select('inventory_alerts.*, inventory_items.name as item_name, inventory_items.item_code');
        $this->db->from('inventory_alerts');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_alerts.item_id');
        $this->db->where('inventory_alerts.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($is_read !== null) {
            $this->db->where('inventory_alerts.is_read', $is_read);
        }
        
        $this->db->order_by('inventory_alerts.alert_level', 'desc');
        $this->db->order_by('inventory_alerts.created_at', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function markAlertAsRead($id) {
        $this->db->where('id', $id);
        $this->db->update('inventory_alerts', array('is_read' => 1));
    }

    // Reports
    function getStockReport($category = null) {
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($category) {
            $this->db->where('inventory_items.category_id', $category);
        }
        
        $this->db->order_by('inventory_items.name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function getUsageReport($from_date = null, $to_date = null, $category = null) {
        // Load encryption helper
        $this->load->helper('db_encrypt');
        
        $this->db->select('inventory_usage.*, inventory_items.name as item_name, inventory_items.item_code, inventory_categories.name as category_name, patient.name as patient_name, users.username as user_name');
        $this->db->from('inventory_usage');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_usage.item_id');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->join('patient', 'patient.id = inventory_usage.patient_id', 'left');
        $this->db->join('users', 'users.id = inventory_usage.used_by', 'left');
        $this->db->where('inventory_usage.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('DATE(inventory_usage.usage_date) >=', $from_date);
        }
        
        if ($to_date) {
            $this->db->where('DATE(inventory_usage.usage_date) <=', $to_date);
        }
        
        if ($category) {
            $this->db->where('inventory_items.category_id', $category);
        }
        
        $this->db->order_by('inventory_usage.usage_date', 'desc');
        $query = $this->db->get();
        $results = $query->result();
        
        // Decrypt patient names
        foreach ($results as $result) {
            if ($result->patient_name) {
                $result->patient_name = db_decrypt($result->patient_name);
            }
        }
        
        return $results;
    }

    function getPurchaseReport($from_date = null, $to_date = null, $category = null) {
        $this->db->select('inventory_purchases.*, inventory_items.name as item_name');
        $this->db->from('inventory_purchases');
        $this->db->join('inventory_items', 'inventory_items.id = inventory_purchases.item_id');
        $this->db->where('inventory_purchases.hospital_id', $this->session->userdata('hospital_id'));
        
        if ($from_date) {
            $this->db->where('inventory_purchases.purchase_date >=', $from_date);
        }
        
        if ($to_date) {
            $this->db->where('inventory_purchases.purchase_date <=', $to_date);
        }
        
        if ($category) {
            $this->db->where('inventory_items.category_id', $category);
        }
        
        $this->db->order_by('inventory_purchases.purchase_date', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // Helper methods
    function getItemInfo($searchTerm) {
        // Start building the query
        $this->db->select('id, name, item_code, current_stock, unit_of_measure');
        $this->db->from('inventory_items');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'active');
        
        // Add search condition if search term is provided
        if (!empty($searchTerm)) {
            $this->db->like('name', $searchTerm);
            $this->db->or_like('item_code', $searchTerm);
        }
        
        // Order and limit results
        $this->db->order_by('name', 'asc');
        $this->db->limit(50);
        
        // Execute query
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            return array();
        }
        
        // Format results for Select2
        $items = $query->result_array();
        $data = array();
        
        foreach ($items as $item) {
            $data[] = array(
                "id" => $item['id'],
                "text" => $item['name'] . ' (' . $item['item_code'] . ') - Stock: ' . $item['current_stock'] . ' ' . $item['unit_of_measure']
            );
        }
        
        return $data;
    }

    function getTotalStockValue() {
        $this->db->select('SUM(current_stock * unit_cost) as total_value');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $query = $this->db->get('inventory_items');
        $result = $query->row();
        return $result ? $result->total_value : 0;
    }

    function getLowStockCount() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('current_stock <= minimum_stock_level');
        $this->db->where('status', 'active');
        return $this->db->count_all_results('inventory_items');
    }

    // Server-side DataTables methods
    function getTotalInventoryItems() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        return $this->db->count_all_results('inventory_items');
    }
    
    function getTotalCategories() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        return $this->db->count_all_results('inventory_categories');
    }
    
    function getActiveItemsCount() {
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'active');
        return $this->db->count_all_results('inventory_items');
    }
    
    function getInventoryItemsBySearch($search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where("(inventory_items.item_code LIKE '%" . $search . "%' OR inventory_items.name LIKE '%" . $search . "%' OR inventory_categories.name LIKE '%" . $search . "%' OR inventory_items.status LIKE '%" . $search . "%')", NULL, FALSE);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function getInventoryItemsWithoutSearch($order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function getInventoryItemsByLimitBySearch($limit, $start, $search, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where("(inventory_items.item_code LIKE '%" . $search . "%' OR inventory_items.name LIKE '%" . $search . "%' OR inventory_categories.name LIKE '%" . $search . "%' OR inventory_items.status LIKE '%" . $search . "%')", NULL, FALSE);
        $this->db->limit($limit, $start);
        
        $query = $this->db->get();
        return $query->result();
    }
    
    function getInventoryItemsByLimit($limit, $start, $order, $dir) {
        if ($order != null) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('name', 'asc');
        }
        
        $this->db->select('inventory_items.*, inventory_categories.name as category_name');
        $this->db->from('inventory_items');
        $this->db->join('inventory_categories', 'inventory_categories.id = inventory_items.category_id', 'left');
        $this->db->where('inventory_items.hospital_id', $this->session->userdata('hospital_id'));
        $this->db->limit($limit, $start);
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get active items for dropdown
    function getActiveItems($searchTerm = '') {
        $this->db->select('id, name, item_code, current_stock, unit_of_measure');
        $this->db->from('inventory_items');
        $this->db->where('hospital_id', $this->session->userdata('hospital_id'));
        $this->db->where('status', 'active');
        
        // Add search condition if search term is provided
        if (!empty($searchTerm)) {
            $this->db->like('name', $searchTerm);
            $this->db->or_like('item_code', $searchTerm);
        }
        
        $this->db->order_by('name', 'asc');
        $this->db->limit(100);
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            return array();
        }
        
        $items = $query->result_array();
        $data = array();
        
        foreach ($items as $item) {
            $data[] = array(
                "id" => $item['id'],
                "text" => $item['name'] . ' (' . $item['item_code'] . ') - Stock: ' . $item['current_stock'] . ' ' . $item['unit_of_measure']
            );
        }
        
        return $data;
    }
} 