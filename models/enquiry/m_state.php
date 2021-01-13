<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_state extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_states_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "cstates", array('state_id' => $id));
        $result = $query->result();
        return $result[0];
    }

    public function get_states_list() {
        $this->db->select("t5.name as country_name,t1.state_id as ID,t1.country_id,t1.code as StateCode,t1.name as StateName,t1.code,t1.Status,t1.Add_User,t1.Mode_User,t1.Add_DateTime,t1.Mode_DateTime,`t3`.`Emp_Code` as AddEmpCode, `t4`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "cstates t1");
        $this->db->join(DB_PREFIX . "countries t5", "t1.country_id=t5.country_id", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Mode_User=t4.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Add_DateTime","DESC");
        $query = $this->db->get();
        return $query->result();
    }

    /* It is being used for inserting States */

    function insert_states($FormData) {
        if ($this->db->insert(DB_PREFIX . "cstates", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    /* It is being used for deleteing State */

    function deletestate($id) {
        if ($this->db->delete(DB_PREFIX . "cstates", array('state_id' => $id))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /*
     *  country_update to update the States
     * @param $FormData array to update
     * @param $id state_id */

    function state_update($FormData, $id) {
        $this->db->where(array("state_id" => $id));
        if ($this->db->update(DB_PREFIX . "cstates", $FormData)) {
           return array("succ" => TRUE, "_err_codes" => "EnqStaAddSucc" . ERR_DELIMETER);
        } else {
            return array("succ" => TRUE, "_err_codes" => "EnqStaAddErr" . ERR_DELIMETER);
            
        }
    }

}
