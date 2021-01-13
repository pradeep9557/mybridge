<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @location : model/super-admin/m_err_mst
 * @used to control the errors veriable
 */

class m_err_mst extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_err_list() {
        $this->db->select("t1.ERRID as ID,t1.ErrCode as ErrorCode,t1.ErrCodeDes as Description,t1.Status,t1.Mode_DateTime as LastModified,t1.Remarks,`t3`.`Emp_Code` as AddEmpCode, `t4`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "global_error t1");
        $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        $query = $this->db->get();
//        echo '<pre>';
//        print_r($query);
//        echo '</pre>';
//        die();
        return $query->result();
    }

    public function get_errors($id) {
        $this->db->select("t1.ERRID,t1.ErrCode,t1.ErrCodeDes,t1.Remarks,t1.Status")->from("nexgen_global_error t1")->where("t1.ERRID", $id);
        return $this->db->get()->result_array();
//        echo '<pre>';
//       print_r($errors);
//        echo '</pre>';
//        die();
    }

    /* It is being used for inserting err */

    function insert_err($FormData) {
        if ($this->db->insert(DB_PREFIX . "global_error", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    function err_update($FormData,$errid) {
        $this->db->update(DB_PREFIX . 'global_error', $FormData, array("ERRID" => $errid));
        //return $this->db-get()-result_array();
        return $this->db->affected_rows();
    }

}
