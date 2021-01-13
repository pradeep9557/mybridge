<?php

/*
 * This model will insert data into "nexgen_expense_mst" table from Manage Expense Panel
 * 
 */

class m_expense extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_data($form_data) {
        $this->db->insert(DB_PREFIX . 'expense_mst', $form_data);
        return $this->db->affected_rows();
    }

    public function insert_type($type_data) {


        $this->db->insert(DB_PREFIX . 'expense_type_mst', $type_data);
        return $this->db->affected_rows();
    }

    public function get_all_expenses($filter_data = array()) {

        if (!empty($filter_data)) {
            if (isset($filter_data['BranchID'])) {
                $this->db->where("exm.BranchID", $filter_data['BranchID']);
            }
            if (isset($filter_data['OrderCol'])) {
                $this->db->order_by($filter_data['OrderCol'], "ASC");
            }
        }
        $this->db->select('exm.*,ext.ex_type_code,ext.ex_type_id,emp.Emp_Code')->from(DB_PREFIX . 'expense_mst exm');
        $this->db->join(DB_PREFIX . 'expense_type_mst ext', 'exm.ex_type_id=ext.ex_type_id', 'left');
        $this->db->join(DB_PREFIX . 'employee emp', 'exm.ex_by=emp.Emp_ID', 'left');
        return $this->db->get()->result();
    }

    public function expense_by_id($ex_id) {

        $this->db->select('exm.*,ext.ex_type_code,emp.Emp_Code')->from(DB_PREFIX . 'expense_mst exm')->where('ex_id', $ex_id);
        $this->db->join(DB_PREFIX . 'expense_type_mst ext', 'exm.ex_type_id=ext.ex_type_id', 'left');
        $this->db->join(DB_PREFIX . 'employee emp', 'exm.ex_by=emp.Emp_ID', 'left');
        return $this->db->get()->first_row();
    }

    public function update_expense($new_data, $ex_id) {

        $this->db->where('ex_id', $ex_id);
        $this->db->update(DB_PREFIX . 'expense_mst', $new_data);
        return $this->db->affected_rows();
    }

    public function delete_by_id($filter_del = array()) {

        if(isset($filter_del['BranchID'])){
            $this->db->where('BranchID',$filter_del['BranchID']);   
        }
        if(isset($filter_del['ex_id'])){
            $this->db->where('ex_id',$filter_del['ex_id']);  
            
        }
        $this->db->delete(DB_PREFIX . 'expense_mst');
        return $this->db->affected_rows();
    }

    public function get_all_types($filter_data = array()) {
        if (!empty($filter_data)) {
            if (isset($filter_data['BranchID'])) {
                $this->db->where("BranchID", $filter_data['BranchID']);
            }
            if (isset($filter_data['OrderCol'])) {
                $this->db->order_by($filter_data['OrderCol'], "ASC");
            }
        }

        $this->db->select('*')->from(DB_PREFIX . 'expense_type_mst');
        return $this->db->get()->result();
    }

    public function type_by_id($ex_type_id) {

        $this->db->select('*')->from(DB_PREFIX . 'expense_type_mst')->where('ex_type_id', $ex_type_id);

        return $this->db->get()->first_row();
    }

    public function type_update($new_type, $ex_type_id) {

        $this->db->where('ex_type_id', $ex_type_id);
        $this->db->update(DB_PREFIX . 'expense_type_mst', $new_type);

        return $this->db->affected_rows();

        $this->db->where('ex_type_id', $ex_type_id);
        $this->db->update(DB_PREFIX . 'expense_mst', $new_type);
    }

    public function delete_type($filter_del = array()) {

        if (!empty($filter_del)) {
            if (isset($filter_del['BranchID'])) {
                $this->db->where('BranchID', $filter_del['BranchID']);
            }
            if (isset($filter_del['ex_type_id'])) {
                $this->db->where('ex_type_id', $filter_del['ex_type_id']);
            }
        }

        $this->db->delete(DB_PREFIX . 'expense_type_mst');
        return $this->db->affected_rows();
    }

}
