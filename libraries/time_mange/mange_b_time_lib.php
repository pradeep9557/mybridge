<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mange_time_lib
 * @Created on : Oct 17, 2015, 12:51:54 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class mange_b_time_lib {

              // constructor
              private $super_object;

              public function __construct() {
                            // calling to parent constructor
                            $this->super_object = & get_instance();
              }

              /*

               * this is the global data */

              public function get_set_time_form() {
                            global $data;
                            $this->super_object->load->model("time_manage/m_time_manage");
                            $data['days_list'] = $this->super_object->m_time_manage->get_days();
                            $data['room_list'] = array("0" => "Select room Later") + $this->super_object->util_model->get_list("rid", "rcode", DB_PREFIX . "room_mst", $data['Session_Data']['IBMS_BRANCHID'], "rcode");
                            return $this->super_object->load->view("lib/batch_time_lib/set_batch_time_form", $data, TRUE);
              }

              // start you function from here
              public function get_timmings($e_id, $e_type) {
                            global $data;
                            $filter_data = array("element_id" => $e_id, "element_type" => $e_type);
                            $this->super_object->load->model("time_manage/m_time_manage");
                            $data['timings_details'] = $this->super_object->m_time_manage->get_batch_element_details($filter_data);
                            return $this->super_object->load->view("lib/batch_time_lib/show_batch_timings", $data, TRUE);
              }
              
                 /*

               * this is the global data */

              public function get_update_time_form($e_id, $e_type) {
                            global $data;
                            $this->super_object->load->model("time_manage/m_time_manage");
                            $data['days_list'] = $this->super_object->m_time_manage->get_days();
                            $data['room_list'] = array("0" => "Select room Later") + $this->super_object->util_model->get_list("rid", "rcode", DB_PREFIX . "room_mst", $data['Session_Data']['IBMS_BRANCHID'], "rcode");
                           
                            $filter_data = array("element_id" => $e_id, "element_type" => $e_type);
                            $data['timings_details'] = $this->super_object->m_time_manage->get_batch_element_details($filter_data);
                            return $this->super_object->load->view("lib/batch_time_lib/set_batch_time_form", $data, TRUE);
              }

}
