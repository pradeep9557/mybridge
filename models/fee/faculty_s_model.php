<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Faculty_S_Model extends CI_Model {

              public function __construct() {
                            $this->load->database();
              }

              /* set_data()
               * insert data into table
               * return if data is inserted in affected row form.
               */

              public function set_data($FormData) {
                            $this->db->insert(DB_PREFIX . 'fee_faculty_share', $FormData);
                            return $this->db->affected_rows();
              }

              public function list_all_faculty($filter_data) {
                            if (!empty($filter_data)) {
                                          if (isset($filter_data['BranchID'])) {
                                                        $this->db->where("t1.BranchID", $filter_data['BranchID']);
                                          }
                                          if (isset($filter_data['Status'])) {
                                                        $this->db->where("t1.Status", $filter_data['Status']);
                                          }
                                          if (isset($filter_data['OrderCol'])) {
                                                        $this->db->order_by($filter_data['OrderCol'], "ASC");
                                          }else{
                                               $this->db->order_by("t1.Mode_DateTime", "DESC");              
                                          }
                            }
                            $this->db->select('t1.*,t2.Emp_Code as AddUserCode,t3.Mode_User as ModeUserCode,t4.CourseCode,t5.Emp_Code as FacultyCode')->from(DB_PREFIX . 'fee_faculty_share t1');
                            $this->db->join(DB_PREFIX . "employee t2", "t1.Add_User=t2.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", "left");
                            $this->db->join(DB_PREFIX . "course_mst t4", "t1.CourseID=t4.CourseID", "left");
                            $this->db->join(DB_PREFIX . "employee t5", "t1.FacultyID=t5.Emp_ID", "left");
                            return $this->db->get()->result_array();
                            
              }

              function get_faculty_data($id = "") {
                            $this->db->select("*");
                            $this->db->from(DB_PREFIX . 'fee_faculty_share');
                            $this->db->where("faculty_share_id", $id);
                            $query = $this->db->get();
                            return $query->first_row();
              }

              function update_faculty($formdata, $fac_id) {                            
                            return $this->db->update(DB_PREFIX . 'fee_faculty_share', $formdata, array("faculty_share_id" => $fac_id));
              }

              function delete_faculty($fac_id) {
                            $this->db->delete(DB_PREFIX . 'fee_faculty_share', array('faculty_share_id' => $fac_id));
                            return $this->db->affected_rows();
              }
              
              function get_faculty_accounts_details($filter_data) {
                            $this->db->join(DB_PREFIX."fee_trn fee_trn","fs.ReceiptNo=fee_trn.ReceiptNo","left");
                            return $this->db->get(DB_PREFIX."fee_faculty_account fs")->result();
              }

}
