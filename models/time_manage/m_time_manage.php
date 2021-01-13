<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of time_tracker
 * @Created on : Oct 17, 2015, 12:31:51 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class m_time_manage extends CI_Model {

              // constructor
              public function __construct() {
                            // calling to parent constructor
                            parent::__construct();
              }

              /*

               * element_id (primary key of that table like Emp_ID or Batch_ID
               * day[] array 2D array contain number of days
               * time single array contain timings.
               *            */

              public function insert_timing($FormData) {
                            unset($FormData['save_scfp']);
                            $FormData = $this->util_model->add_common_fields($FormData);
//                             $this->util_model->printr($FormData);
//                             die();
                            $element_id = $FormData['element_id'];
                            $element_type = $FormData['element_type'];

                            //delete the preivouse data
                            $this->db->delete(DB_PREFIX . 'time_mst', array("element_id" => $element_id, "element_type" => $element_type));

                            $add_user = $FormData['Add_User'];
                            $add_date = $FormData['Add_DateTime'];
//                          $this->util_model->printr($days);

                            $strt_time = array();
                            foreach ($FormData['str_time'] as $val) {
                                          $strt_time[] = $val;
                            }
//                            $this->util_model->printr($strt_time);

                            $end_time = array();
                            foreach ($FormData['end_time'] as $end) {
                                          $end_time[] = $end;
                            }

                            $days = array();
                            foreach ($FormData['day'] as $daykey => $key) {
                                          foreach ($key as $day) {
                                                        $days[] = array("element_id" => $element_id, "element_type" => $element_type, "day" => $day, "str_time" => $strt_time[$daykey], "end_time" => $end_time[$daykey], "Add_User" => $add_user, "Add_DateTime" => $add_date);
                                          }
                            }
                            $this->db->insert_batch(DB_PREFIX . 'time_mst', $days);
                            if ($this->db->affected_rows()) {

                                          return TRUE;
                            }
              }

              public function get_days($day = "") {
                            $all_days = array("1" => "Sunday",
                                "2" => "Monday",
                                "3" => "Tuesday",
                                "4" => "Webnesday",
                                "5" => "Thursday",
                                "6" => "Friday",
                                "7" => "Saturday");
                            if ($day == "") {
                                          return $all_days;
                            } else {
                                          return $all_days[$day];
                            }
              }

              public function get_element_details($filter_data) {
//                            $this->db->select("tm.* ,group_concat(tm.day separator ',') as days_list")->from(DB_PREFIX . "time_mst tm");
                            $whr = "";
                            if (isset($filter_data['element_id']) && $filter_data['element_id'] != "") {
                                          $whr.=" and tm.element_id={$filter_data['element_id']}";
//                                          $this->db->where("tm.element_id", $filter_data['element_id']);
                            }
                            if (isset($filter_data['element_type']) && $filter_data['element_type'] != "") {
//                                          $whr.=" and tm.element_type={$filter_data['element_type']}";
                                          $whr.=" and tm.element_type={$filter_data['element_type']}";
//                                          $this->db->where("tm.element_type", $filter_data['element_type']);
                            }
                            $sql = "SELECT tm.* ,group_concat(tm.day separator ',') as days_list  FROM `".DB_PREFIX."time_mst` tm where 1 $whr  group by tm.element_id,tm.element_type, tm.str_time,tm.end_time";
//                            die();
                            $q = $this->db->query($sql);
//                            $this->db->group_by(array("tm.element_id","tm.element_type", "tm.str_time","tm.end_time"));

                            $result = $q->result_array();

                            $all_result = array();
                            foreach ($result as $each_row) {
                                          $each_row['days_name'] = array();
                                          $all_days = explode(",", $each_row['days_list']);
                                          foreach ($all_days as $day) {
                                                        $each_row['days_name'][] = $this->get_days($day);
                                          }
                                          $each_row['days_name'] = implode(",", $each_row['days_name']);
                                          $all_result[] = $each_row;
                            }
                            return $all_result;
              }

              public function get_batch_element_details($filter_data) {
//                            $this->db->select("tm.* ,group_concat(tm.day separator ',') as days_list")->from(DB_PREFIX . "time_mst tm");
                            $whr = "";
                            if (isset($filter_data['element_id']) && $filter_data['element_id'] != "") {
                                          $whr.=" and tm.element_id={$filter_data['element_id']}";
//                                          $this->db->where("tm.element_id", $filter_data['element_id']);
                            }
                            if (isset($filter_data['element_type']) && $filter_data['element_type'] != "") {
//                                          $whr.=" and tm.element_type={$filter_data['element_type']}";
                                          $whr.=" and tm.element_type={$filter_data['element_type']}";
//                                          $this->db->where("tm.element_type", $filter_data['element_type']);
                            }
                            $join = " left join ".DB_PREFIX."room_mst rm on (tm.room_id = rm.rid)";
                            $sql = "SELECT tm.* ,group_concat(tm.day separator ',') as days_list,rm.rcode   FROM `".DB_PREFIX."batch_time_mst` tm $join where 1 $whr  group by tm.element_id,tm.element_type, tm.str_time,tm.end_time,tm.room_id";
//                            die();
                            $q = $this->db->query($sql);
//                            $this->db->group_by(array("tm.element_id","tm.element_type", "tm.str_time","tm.end_time"));
                            //echo $this->db->last_query();
                            $result = $q->result_array();

                            $all_result = array();
                            foreach ($result as $each_row) {
                                          $each_row['days_name'] = array();
                                          $all_days = explode(",", $each_row['days_list']);
                                          foreach ($all_days as $day) {
                                                        $each_row['days_name'][] = $this->get_days($day);
                                          }
                                          $each_row['days_name'] = implode(",", $each_row['days_name']);
                                          $all_result[] = $each_row;
                            }
                            return $all_result;
              }

              public function insert_batch_timing($FormData) {
                            $FormData = $this->util_model->add_common_fields($FormData);
//                             $this->util_model->printr($FormData);
//                             die();
                            $element_id = $FormData['element_id'];
                            $element_type = $FormData['element_type'];

                            //delete the preivouse data
                            $this->db->delete(DB_PREFIX . 'batch_time_mst', array("element_id" => $element_id, "element_type" => $element_type));

                            $add_user = $FormData['Add_User'];
                            $add_date = $FormData['Add_DateTime'];
//                          $this->util_model->printr($days);

                            $strt_time = array();
                            foreach ($FormData['str_time'] as $val) {
                                          $strt_time[] = $val;
                            }
//                            $this->util_model->printr($strt_time);

                            $end_time = array();
                            foreach ($FormData['end_time'] as $end) {
                                          $end_time[] = $end;
                            }
                            $rooms = array();
                            foreach ($FormData['room_id'] as $roomid) {
                                          $rooms[] = $roomid;
                            }
                            $days = array();
                            foreach ($FormData['day'] as $daykey => $key) {
                                          foreach ($key as $day) {
                                                        $days[] = array("element_id" => $element_id, "element_type" => $element_type, "day" => $day, "str_time" => $strt_time[$daykey], "end_time" => $end_time[$daykey], "Add_User" => $add_user, "Add_DateTime" => $add_date, "room_id" => $rooms[$daykey]);
                                          }
                            }
//                            $this->util_model->printr($rooms);
//                            die($this->util_model->printr($days));
                            $this->db->insert_batch(DB_PREFIX . 'batch_time_mst', $days);
                            if ($this->db->affected_rows()) {
                                          return TRUE;
                            } else {
                                          return FALSE;
                            }
              }

}
