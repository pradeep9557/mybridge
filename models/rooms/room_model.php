<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Room_Model extends CI_Model {

              public function __construct() {
                            $this->load->database();
              }

              function set_data($frmdata) {
                            $this->db->insert(DB_PREFIX . 'room_mst', $frmdata);
                            if ($this->db->affected_rows()) {
                                          return array("succ" => TRUE, "room_id" => $this->db->insert_id());
                            } else {
                                          return array("succ" => TRUE);
                            }
              }

              function fetch_data() {
                            return $this->db->select("*")->from(DB_PREFIX . "room_mst")->get()->result_array();
              }

              // show the current data in the fields..
              function update_id($id = "") {
                            return $this->db->select("*")->from(DB_PREFIX . "room_mst")->where("rid = $id")->get()->result_array();
//            echo"<pre>";
//            print_r($result);
              }

              //update data in table...
              function update_room($data, $r_id) {
                           return $this->db->update(DB_PREFIX . 'room_mst', $data, array("rid" => $r_id));
                             
              }

              function delete_room($filter_to_delete) {
                            $this->db->delete(DB_PREFIX . 'room_mst', array('rid' => $filter_to_delete['rid']));
                            if ($this->db->affected_rows()) {
                                          return array(TRUE, "Deleted Successfully !!");
                            } else {
                                          return array(FALSE, "Error While Deleting !!");
                            }
              }

              /*

               * function get_rooms_list($filter_data)
               * @param1 $filter_data is an associative array         /
               */

              function get_rooms_list($filter_data = array()) {
                            if (!empty($filter_data)) {
                                          if (isset($filter_data['BranchID'])) {
                                                        $this->db->where("t1.BranchID", $filter_data['BranchID']);
                                          }
                                          if (isset($filter_data['Status'])) {
                                                        $this->db->where("t1.Status", $filter_data['Status']);
                                          }
                                          if (isset($filter_data['OrderCol'])) {
                                                        $this->db->order_by($filter_data['OrderCol'], "ASC");
                                          }
                            }
                            $this->db->select("t1.*,t2.Emp_Code as AddUserCode,t3.Mode_User as ModeUserCode")->from(DB_PREFIX . "room_mst t1");
                            $this->db->join(DB_PREFIX . "employee t2", "t1.Add_User=t2.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", "left");
                            return $this->db->get()->result();
              }

}
