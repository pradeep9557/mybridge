<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @location :  model/batch/m_bstatus
 * @purpose :   used for batch status
 * 
 */

class m_bstatus extends CI_Model {

              public function __construct() {
                            parent::__construct();
              }

              public function get_batchstatus_data($rid) {
                            $query = $this->db->get_where(DB_PREFIX . "batchstatus", array("BatchStatusID" => $rid));
                            $result = $query->result();
                            return $result[0];
              }

              public function get_batchstatus_list($filter_data = array()) {
                            if (!empty($filter_data)) {
                                          if (!empty($filter_data['branch_ids'])) {
                                                        $this->db->where_in("t1.BranchID", $filter_data['branch_ids']);
                                          }
                            }
                            $this->db->select("t1.BatchStatusID as ID,t1.BranchID,t2.BranchCode,t1.BatchStatus,t1.Status,t1.Add_User,t1.Mode_User,t1.Mode_DateTime as LastModified,t1.Remarks, `t3`.`Emp_Code` as Add_UserCode,"
                                            . " `t4`.`Emp_Code` as Mode_UserCode")->from(DB_PREFIX . "batchstatus t1");
                            $this->db->join(DB_PREFIX . "branch_mst t2", "t1.BranchID=t2.BranchID", "left");
                             $this->db->join(DB_PREFIX . "employee t3", "t1.Add_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t4", "t1.Mode_User=t4.Emp_ID", 'LEFT');
                            $this->db->order_by("t1.Mode_DateTime", "DESC");

                            $query = $this->db->get();
                            //echo $this->db->last_query();
                            return $query->result();
              }

              /* It is being used for inserting batch */

              function insert_batchstatus($FormData) {
                            if ($this->db->insert(DB_PREFIX . "batchstatus", $FormData)) {
                                          return array("succ" => TRUE);
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

              function deletebatchstatus($rid) {
                            if ($this->db->delete(DB_PREFIX . "batchstatus", array('BatchStatusID' => $rid))) {
                                          return array(TRUE, "Deleted Successfully !!");
                            } else {
                                          return array(FALSE, "Error while Deleting !!");
                            }
              }

              /*
               * response_update to update the response
               * @param $FormData array to update
               * @param $rid BatchStatusID             */

              function batchstatus_update($FormData, $rid) {
                            $this->db->where(array("BatchStatusID" => $rid));
                            if ($this->db->update(DB_PREFIX . "batchstatus", $FormData)) {
                                          return array("succ" => TRUE);
                            } else {
                                          return array("succ" => FALSE);
                            }
              }

}
