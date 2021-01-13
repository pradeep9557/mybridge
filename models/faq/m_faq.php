<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_faq
 *
 * @author NexGen Team
 */
class m_faq extends CI_Model {

              //put your code here
              /*

               * public function push_faq_menu($FormData)
               * Getting Assocative array to insert in faq menu table               */
              public function push_faq_menu($FormData) {
                            $this->db->insert(DB_PREFIX . "faqs_menus", $FormData);
                            return $this->db->affected_rows();
              }

              /*

               * used to update               */

              public function update_faq_menu($FormData) {
                            $this->db->where("menuid", $FormData['menuid']);
                            $this->db->update(DB_PREFIX . "faqs_menus", $FormData);
                            return $this->db->affected_rows();
              }

              public function get_faq_menu_list($filter_data = array()) {

                            if (isset($filter_data['faq_menu_id'])) {
                                          $this->db->where("menuid", $filter_data['faq_menu_id']);
                            }

                            $this->db->select("t1.*,`t4`.`Emp_Code` as AddEmpCode, `t3`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "faqs_menus t1");
                            $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
                            $this->db->order_by("t1.Mode_DateTime", "DESC");
                            $query = $this->db->get();
                            return $query->result(); 
              }

              public function del_faq_menu($filter_to_delete) {
                            $already_alloated = $this->util_model->check_aready_exits(DB_PREFIX . "faq_questions", array("menuid" => $filter_to_delete['menuid']), TRUE);
                            if (!count($already_alloated)) {
                                          $this->db->where("menuid", $filter_to_delete['menuid']);
                                          if ($this->db->delete(DB_PREFIX . "faqs_menus", array("menuid" => $filter_to_delete['menuid']))) {
                                                        return array(TRUE, "Deleted Successfully !!");
                                          } else {
                                                        return array(FALSE, "Error while Deleting !!");
                                          }
                            } else {
//                                  $alloated_dis = array();
//                                  foreach ($already_alloated as $dis) {
//                                           $alloated_dis[] = $dis->     
//                                  }
                                          return array(FALSE, "Error while Deleting !! This Menu is being used in " . count($already_alloated) . " Faq questions");
                            }
              }

              /**

               * ****************************8
               * 
               * Faq quesitons
               *                */
              //put your code here
              /*

               * public function push_faq_ques($FormData)
               * Getting Assocative array to insert in faq_questions table               */
              public function push_faq_ques($FormData) {
                            $this->db->insert(DB_PREFIX . "faq_questions", $FormData);
                            return $this->db->affected_rows();
              }

              /*

               * used to update               */

              public function update_faq_ques($FormData) {
                            $this->db->where("fqid", $FormData['fqid']);
                            $this->db->update(DB_PREFIX . "faq_questions", $FormData);
                            return $this->db->affected_rows();
              }

              public function get_faq_qus_list($filter_data = array()) {

                            if (isset($filter_data['faq_qus_id'])) {
                                          $this->db->where("t1.fqid", $filter_data['faq_qus_id']);
                            }

                            $this->db->select("t1.*,`t4`.`Emp_Code` as AddEmpCode, `t3`.`Emp_Code` as ModeEmpCode,t5.m_heading_text as menu_heading")->from(DB_PREFIX . "faq_questions t1");
                            $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "faqs_menus t5", "t1.menuid=t5.menuid", 'LEFT');
                            $this->db->order_by("t1.Mode_DateTime", "DESC");
                            $query = $this->db->get();
                            return $query->result();
              }

              public function del_faq_qus($filter_to_delete) {

                            if ($this->db->delete(DB_PREFIX . "faq_questions", array("fqid" => $filter_to_delete['fqid']))) {
                                          return array(TRUE, "Deleted Successfully !!");
                            } else {
                                          return array(FALSE, "Error while Deleting !!");
                            }
              }

}
