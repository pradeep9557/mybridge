<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_cdoing extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_cdoing_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "current_doing", array("CDID" => $id));
        $result = $query->result();
        return $result[0];
    }

    public function get_cdoing_list() {
        $this->db->select("t1.CDID as ID,t1.Code,t1.Sort,t1.Name,t1.Status,t1.Remarks,t1.Mode_DateTime as LastModified,`t3`.`Emp_Code` as AddEmpCode, `t4`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "current_doing t1");
        $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    /* It is being used for deleteing current doing */

    function deletecdoing($id) {
        if ($this->db->delete(DB_PREFIX ."current_doing", array('CDID' => $id))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /* It is being used for inserting current doing */

    function insert_cdoing($FormData) {
        if ($this->db->insert(DB_PREFIX ."current_doing", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    /*
     *  cdoing_update to update the current doing
     * @param $FormData array to update
     * @param $id CDID              */

    function cdoing_update($FormData, $id) {
        $this->db->where(array("CDID" => $id));
        if ($this->db->update(DB_PREFIX ."current_doing", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

}
