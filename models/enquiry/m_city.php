<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_city extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_city_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "cities", array("city_id" => $id));
        $result = $query->result();
        return $result[0];
    }

    public function get_cities_list() {
        $this->db->select("t1.city_id as ID,t6.name as country,t5.code as statecode,t1.Sort,t1.citycode as citycode,t1.Status,t1.Mode_DateTime as LastModified,t1.Remarks,`t4`.`Emp_Code` as AddEmpCode, `t3`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "cities t1");
        $this->db->join(DB_PREFIX . "countries t6", "t1.country_id=t6.country_id", 'LEFT');
        $this->db->join(DB_PREFIX . "cstates t5", "t1.state_id=t5.state_id", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    /* It is being used for deleteing response */

    function deletecity($id) {
        if ($this->db->delete(DB_PREFIX ."cities", array('city_id' => $id))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /* It is being used for inserting response */

    function insert_city($FormData) {
        if ($this->db->insert(DB_PREFIX ."cities", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    /*
     *  city_update to update the response
     * @param $FormData array to update
     * @param $id city ID              */

    function city_update($FormData, $id) {
        $this->db->where(array("city_id" => $id));
        $FormData['state_id'] = $FormData['C_State'];
        unset($FormData['C_State']);
        if ($this->db->update(DB_PREFIX ."cities", $FormData)) {
            return array("succ" => TRUE, "_err_codes" => "EnqCityUpSucc" . ERR_DELIMETER);
        } else {
            return array("succ" => TRUE, "_err_codes" => "EnqCityUpErr" . ERR_DELIMETER);
            
        }
    }

}
