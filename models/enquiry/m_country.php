<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_country extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_con_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "countries", array("country_id" => $id));
        $result = $query->result();
        return $result[0];
    }

    public function all_country_list() {
        $this->db->select("t1.country_id as ID,t1.name as countryname,t1.Status,t1.Mode_DateTime as LastModified,t1.Remarks,`t4`.`Emp_Code` as AddEmpCode, `t3`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "countries t1");
        $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    /* It is being used for deleteing response */

    function deletecountry($id) {
        if ($this->db->delete(DB_PREFIX ."countries", array('country_id' => $id))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /* It is being used for inserting response */

    function insert_country($FormData) {
        if ($this->db->insert(DB_PREFIX ."countries", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    /*
     *  country_update to update the response
     * @param $FormData array to update
     * @param $id country ID              */

    function country_update($FormData, $id) {
        $this->db->where(array("country_id" => $id));
        if ($this->db->update(DB_PREFIX ."countries", $FormData)) {
            return array("succ" => TRUE, "_err_codes" => "EnqConAddSucc" . ERR_DELIMETER);
        } else {
            return array("succ" => TRUE, "_err_codes" => "EnqConAddErr" . ERR_DELIMETER);
            
        }
    }

}
