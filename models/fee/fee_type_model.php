<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fee_Type
 *
 * @author Mr. Anup
 */
class fee_type_model extends CI_Model {

              function __construct() {
                            parent::__construct();
              }

              public function all_Fee_Type_list($filter_data) {
                            if (isset($filter_data['BranchID'])) {
                                          $this->db->where("ftm.BranchID", $filter_data['BranchID']);
                            }
                            // for all fee type list 
                            $query = $this->db->select("ftm.*, emp.Emp_Code as Add_UserCode")->from("nexgen_fee_type_mst ftm");
                            $this->db->join(DB_PREFIX . "employee emp", "ftm.Add_User=emp.Emp_ID", "left");

                            $this->db->order_by('Mode_DateTime', "DESC");
                            $result = $query->get()->result();
                            return $result;
              }

              public function all_Fee_Type_list_for_dropdown() {
                            // for dropdown result
                            $query = $this->db->select()->from("nexgen_fee_type_mst")->where(array("Status" => 1));
                            $result = $query->get()->result();
                            $fee_type_list = array();
                            foreach ($result as $value) {
                                          $fee_type_list["{$value->FeeType_Code}"] = $value->FeeType_Name;
                            }
                            return $fee_type_list;
              }

              function Fee_Types_save_update() {
                            global $data;
                            $Fee_Type_form_data = array();
                            try {

                                          $Fee_Type_form_data = $this->input->post();
                                          $Fee_Type_form_data['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
                                          if ($Fee_Type_form_data["Add_Fee_Type"] === "Save") {
                                                        $Fee_Type_form_data = $this->util_model->add_common_fields($Fee_Type_form_data);
                                                        $this->db->select('*')->from('nexgen_fee_type_mst')->where(array("FeeType_Code" => $Fee_Type_form_data['FeeType_Code'], "BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
                                                        if ($this->db->count_all_results()) {
                                                                      return array(FALSE, $Fee_Type_form_data['FeeType_Code'] . "  Fee Type Aready Exist");
                                                        }
                                                        $data_to_insert = $this->Fee_Type_query_string($Fee_Type_form_data);
                                                        if ($this->db->insert("nexgen_fee_type_mst", $data_to_insert)) {
                                                                      return array(TRUE);
                                                        } else {
                                                                      return array(FALSE);
                                                        }
                                          } else {
                                                        $Fee_Type_form_data = $this->util_model->add_mode_user($Fee_Type_form_data);
                                                        $data_to_update = $this->Fee_Type_query_string($Fee_Type_form_data);
                                                        $this->db->where('FeeTypeID', $Fee_Type_form_data['FeeTypeID']);
                                                        $this->db->update("nexgen_fee_type_mst", $data_to_update);
                                                        if ($this->db->affected_rows()) {
                                                                      return array(TRUE, $Fee_Type_form_data['FeeTypeID']);
                                                        } else {
                                                                      return array(FALSE, $Fee_Type_form_data['FeeTypeID']);
                                                        }
                                          }
                            } catch (Exception $ex) {
                                          return array(FALSE);
                            }
              }

              public function Fee_Type_query_string($Fee_Type_form_data) {
                            $data_to_insert_or_update = array(
                                "FeeType_Code" => $Fee_Type_form_data['FeeType_Code'],
                                "FeeType_Name" => $Fee_Type_form_data['FeeType_Name'],
                                "Late_Payment_Fee" => $Fee_Type_form_data['Late_Payment_Fee'],
                                "Fine_Day_Limit" => $Fee_Type_form_data['Fine_Day_Limit'],
                                "tax_enabled" => $Fee_Type_form_data['tax_enabled'],
                                "Sort" => $Fee_Type_form_data['Sort'],
                                "Status" => $Fee_Type_form_data['Status'],
                                "BranchID" => $Fee_Type_form_data['BranchID'],
                                "Remarks" => $Fee_Type_form_data['Remarks']);
                            if (isset($Fee_Type_form_data['Add_DateTime'])) {
                                          $data_to_insert_or_update['Add_DateTime'] = $Fee_Type_form_data['Add_DateTime'];
                            }
                            if (isset($Fee_Type_form_data['Add_User'])) {
                                          $data_to_insert_or_update['Add_User'] = $Fee_Type_form_data['Add_User'];
                            }
                            if (isset($Fee_Type_form_data['Mode_User'])) {
                                          $data_to_insert_or_update['Mode_User'] = $Fee_Type_form_data['Mode_User'];
                            }
                            return $data_to_insert_or_update;
              }

              public function get_feetype_details($filter_data) {
                            $query = $this->db->get_where(DB_PREFIX . 'fee_type_mst', $filter_data);
                            if ($this->db->count_all_results() > 0) {
                                          return $query->result();
                            } else {
                                          return FALSE;
                            }
              }

              public function Del_FeeType($FeeType_Code) {
                            if ($this->db->delete('nexgen_fee_type_mst', array('FeeType_Code' => $FeeType_Code))) {
                                          return TRUE;
                            } else {
                                          return FALSE;
                            }
              }

}
