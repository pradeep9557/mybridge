<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_manage_voucher
 *
 * @author NexGen
 */
class m_manage_voucher extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function save_voucher($voucher = array()) {
        if(isset($voucher['vDate'])){
            $voucher['vDate'] = date(DB_DTF,  strtotime($voucher['vDate']));
        }
        $this->db->insert(DB_PREFIX . "task_voucher_trn", $voucher);
        return $this->db->insert_id();
    }

    public function update_voucher($voucher = array(), $v_id) {
        $this->db->where("v_id", $v_id);
        if(isset($voucher['vDate'])){
            $voucher['vDate'] = date(DB_DTF,  strtotime($voucher['vDate']));
        }
        $this->db->update(DB_PREFIX . "task_voucher_trn", $voucher);
        return $this->db->affected_rows();
    }
    
    public function delete_voucher($v_id) {
         $this->db->where("v_id", $v_id);
        $this->db->delete(DB_PREFIX . "task_voucher_trn");
        return $this->db->affected_rows();
    }

    public function getVouchers($filter = array()) {
        $this->db->select("st.tstm_name,tm.tm_name,emp.Emp_Name,v.*");
        $this->db->from(DB_PREFIX . "task_voucher_trn v");
        $this->db->join(DB_PREFIX . "task_sub_task st", "v.tstm_id=st.tstm_id");
        $this->db->join(DB_PREFIX . "task_mst tm", "v.tm_id=tm.tm_id");
        $this->db->join(DB_PREFIX . "employee emp", "emp.Emp_ID=tm.client_id and emp.UTID=9");
        if (isset($filter['Emp_ID'])) {
            $this->db->where("emp.Emp_ID", $filter['Emp_ID']);
        }

        if (isset($filter['v_id'])) {
            $this->db->where("v.v_id", $filter['v_id']);
        }

        if (isset($filter['tm_id'])) {
            $this->db->where("v.tm_id", $filter['tm_id']);
        }


        if (isset($filter['client_id'])) {
            $this->db->where("v.client_id", $filter['client_id']);
        }

        if (isset($filter['status'])) {
            $this->db->where("v.status", $filter['status']);
        }
        
         if (isset($filter['Add_User'])) {
            $this->db->where("v.Add_User", $filter['Add_User']);
        }
        

        $this->db->group_by("v.v_id");
        $this->db->order_by('v.vDate','DESC');
        $list = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $list;
    }

}
