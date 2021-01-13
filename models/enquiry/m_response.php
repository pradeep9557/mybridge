<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_response extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_res_data($rid) {
        $query = $this->db->get_where(DB_PREFIX . "e_response_mst", array("ResponseID" => $rid));
        $result = $query->result();
        return $result[0];
    }

    public function get_res_list($branchIDs) {
        if (empty($branchIDs)) {
            return array();
        }
        $this->db->where_in("t1.BranchID", $branchIDs);
        $this->db->select("t1.ResponseID as ID,t1.Sort as Sorting,t1.ResponseText as Response,t1.Mode_DateTime as LastModified,t1.Remarks,t1.Status,t2.BranchCode as Branch,`t3`.`Emp_Code` as AddEmpCode, `t4`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "e_response_mst t1");
        $this->db->join(DB_PREFIX . "branch_mst t2", "t1.BranchID=t2.BranchID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Mode_User=t4.Emp_ID", 'LEFT');
        // $this->db->where(array("t1.Status" => 1));
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    function deleteResponse($rid) {
        $result = $this->db->get_where(DB_PREFIX . "e_followup", array("ResponseID" => $rid));
        if ($result->num_rows == 0) {
            if ($this->db->delete(DB_PREFIX . "e_response_mst", array('ResponseID' => $rid))) {
                return array(TRUE, "Deleted Successfully !!");
            } else {
                return array(FALSE, "Error while Deleting !!");
            }
        } else {
            return array(FALSE, "This Response has been used in $result->num_rows followups !!");
        }
    }

    /*It is being used for inserting response */
    function insert_response($FormData) {
        if ($this->db->insert(DB_PREFIX . "e_response_mst", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    /*
     *  response_update to update the response
     * @param $FormData array to update
     * @param $rid response ID              */

    function response_update($FormData, $rid) {
        $this->db->where(array("ResponseID" => $rid));
        if ($this->db->update(DB_PREFIX . "e_response_mst", $FormData)) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

}
