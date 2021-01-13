<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 * used for manging the rooms using table is 
 * room */
class c_room extends CI_Controller {

              public function __construct() {
                            parent::__construct();
                            $this->load->model('rooms/room_model');
              }

              public function index($error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['emp_list'] = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_Name');

                            $this->load->library("time_mange/mange_time_lib");
                            $data['element_type'] = "3";
                            $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
                            $data['set_time_form'] = $this->mange_time_lib->get_set_time_form();

                            $this->load->view('templates/header.php', $data);
                            $this->load->view('rooms/v-manage-rooms.php', $data);
                            $this->load->view('templates/footer.php');
              }

              public function insert_data() {
                            global $data;
                            $this->load->helper("array");
                            $FormData = $this->input->post();
                            $path = base_url() . "rooms/c_room/index/";
                            $FormData['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
                            $FormData = $this->util_model->add_common_fields($FormData);
                            $room_data = elements(array("BranchID", "rcode", "max_students","Add_User","Add_DateTime"), $FormData);
                            $insert_room = $this->room_model->set_data($room_data);
                            if ($insert_room['succ']) {
                                          $FormData['element_id'] = $insert_room['room_id'];
                                          $this->load->model("time_manage/m_time_manage");
                                          $this->m_time_manage->insert_timing($FormData);
                                          redirect($path . "0/RmAddSucc");
                            } else {
                                          redirect($path . "1/RmAddErr");
                            }
              }

              // show current value in table fields..
              public function update($id = "", $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['emp_list'] = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_Name');
                            $data['records'] = $this->room_model->update_id($id);

                            $this->load->library("time_mange/mange_time_lib");

                            $data['element_type'] = "3";
                            $data['selected'] = array(1, 2, 3, 4, 5, 6, 7, 8);
                            $data['update_time_form'] = $this->mange_time_lib->get_update_time_form($id, 3);


                            $this->load->view('templates/header.php', $data);
                            $this->load->view('rooms/v-edit-rooms.php', $data);
                            $this->load->view('templates/footer.php');
              }

              // update data in table..
              public function update_data() {
                            $this->load->helper("array");
                            $FormData = $this->input->post();
                            $path = base_url() . "rooms/c_room/index/";
                            $r_id = $FormData['rid'];
                            $FormData['element_id'] = $r_id;
                            $FormData = $this->util_model->add_mode_user($FormData);
                            $room_data = elements(array("rcode", "max_students","Mode_User"), $FormData);            
                            if ($this->room_model->update_room($room_data, $r_id)) {
                                          $this->load->model("time_manage/m_time_manage");
                                          $this->m_time_manage->insert_timing($FormData);
                                          redirect($path . "0/RmUpdateSucc");
                            } else {
                                          redirect($path . "1/RmUpdateErr" . ERR_DELIMETER);
                            }
              }

              /*

               * function rooms_list()
               * to diaplay all the rooms menu list               */

              function rooms_list() {
                            global $data;
                            $filter_data = array(
                                "BranchID" => $data['Session_Data']['IBMS_BRANCHID'],
                                "OrderCol" => "t1.BranchID,t1.rcode"
                            );
                            $data['rooms_list'] = $this->room_model->get_rooms_list($filter_data);
                            //$this->util_model->printr($data['rooms_list']);
                            $this->load->view("templates/common_window_pop_up.php", $data);
                            $this->load->view("rooms/v-all-rooms.php", $data);
              }

              public function show_room_timmings($e_id, $e_type) {
                            $this->load->library("time_mange/mange_time_lib");
                            echo json_encode(array("succ" => TRUE, "html" => $this->mange_time_lib->get_timmings($e_id, $e_type)));
              }
              public function show_room_batch_timmings($e_id, $e_type) {
                            $this->load->library("time_mange/mange_b_time_lib");
                            echo json_encode(array("succ" => TRUE, "html" => $this->mange_b_time_lib->get_timmings($e_id, $e_type)));
              }

}
