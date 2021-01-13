<?php

/*

 * faqs class will help to manage
 * faqs menu and its questions
 * faqs/funciton_name is the url after base_url */

class c_faqs extends CI_Controller {

              public function __construct() {
                            parent::__construct();
                            $this->load->model('faq/m_faq', "faq_model");
              }

              /*

               * manage_menu()
               * used to mange menu 
               * */

              public function manage_manu($error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);

                            $this->load->view("templates/header.php", $data);

                            $this->load->view("faqs/menu/v-add-menu", $data);
                            $this->load->view("templates/footer.php");
              }

              /*

               * faq_menu_validation
               * calling from save_faq_menu               */

              public function faq_menu_validation($POST) {
                            $err_codes = '';
                            if ($POST['htmlid'] == "") {
                                          $err_codes.='FaqMenuHTMLID_BLANK' . ERR_DELIMETER;
                            }
                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              /*

               * public function push_faq_data()
               * this funciton called by manage_menu funtion to insert the data
               * into faqs_menus and calling to push_faq_menu function               */

              public function save_faq_menu() {
                            $FormData = $this->input->post();
                            $FormData = $this->util_model->add_common_fields($FormData);

                            $path = base_url() . "faqs/manage_manu/";
                            // validation
                            $validates = $this->faq_menu_validation($FormData); // validating the form
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData["save_faq_menu"] == "save_faq") {
                                          $FormData = $this->util_model->unset_array($FormData, array('save_faq_menu'));
                                          $succ = $this->faq_model->push_faq_menu($FormData);
                                          if ($succ) {
                                                        redirect($path . "0/faqMAddSucc");
                                          } else {
                                                        redirect($path . "1/faqMAddErr" . ERR_DELIMETER);
                                          }
                            }
              }

              /*

               * function faq_menu_list()
               * to diaplay all the faq menu list               */

              function faq_menu_list() {
                            global $data;
                            $data['faq_menu_list'] = $this->faq_model->get_faq_menu_list();
                            //$this->util_model->printr($data['faq_menu_list']);
                            $this->load->view("faqs/menu/v-all-menu", $data);
              }

              /*

               * function faq_edit_manu
               * working : used to edit faq menu details
               * @param1 : Id of faq menu int
               * return to manage_menu function              /
               */

              function faq_edit_manu($faq_menu_id, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);

                            $filter_data = array("faq_menu_id" => $faq_menu_id);
                            $data['faq_menu_data'] = $this->faq_model->get_faq_menu_list($filter_data);
                            //  $this->util_model->printr($data['faq_menu_data']);
                            $this->load->view("templates/header.php", $data);
                            $this->load->view("faqs/menu/v-menu-edit", $data);
                            $this->load->view("templates/footer.php");
              }

              /*

               * function update_faq_menu()
               * calling from faq edit menu
               * working: used to update the data
               * return: to manage_menu               */

              function update_faq_menu() {

                            $FormData = $this->input->post();
                            $path = base_url() . "faqs/manage_manu/";
                            $path_update = base_url() . "faqs/faq_edit_manu/";
                            if (!isset($FormData['menuid'])) {
                                          redirect($path . "1/FaqmenuIDNotDef" . ERR_DELIMETER);
                            }

                            $FormData = $this->util_model->add_mode_user($FormData);


                            // validation
                            $validates = $this->faq_menu_validation($FormData); // validating the form
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData["Update_faq_menu"] == "Update_faq_menu") {
                                          $FormData = $this->util_model->unset_array($FormData, array('Update_faq_menu'));
                                          //  die($this->util_model->printr($FormData));
                                          $succ = $this->faq_model->update_faq_menu($FormData);
                                          if ($succ) {
                                                        redirect($path . "0/faqMUpSucc");
                                          } else {
                                                        redirect($path_update . $FormData['menuid'] . "/" . "1/faqMUpdErr" . ERR_DELIMETER);
                                          }
                            }
              }

              /*

               * ***************************************************************
               * Faq Quesiton started from here
               * 
               *                */

              /*

               * manage_menu()
               * used to mange menu 
               * */

              public function manage_faq_qus($error = '', $_err_codes = '') {
                            global $data;
                            $data['faq_m_list'] = $this->util_model->get_list('menuid', 'm_heading_text', DB_PREFIX . "faqs_menus", 0, 'm_heading_text');
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $this->load->view("templates/header.php", $data);
                            $this->load->view("templates/common_window_pop_up.php");
                            $this->load->view("faqs/faq_qus/v-add-faq-qus", $data);
                            $this->load->view("templates/footer.php");
              }

              /*

               * faq_menu_validation
               * calling from save_faq_menu               */

              public function faq_qus_validation($POST) {
                            $err_codes = '';
                            if (!isset($POST['question'])) {
                                          $err_codes.='faq_qusBlank' . ERR_DELIMETER;
                            }
                            if (!isset($POST['ans'])) {
                                          $err_codes.='faq_ansBlank' . ERR_DELIMETER;
                            }
                            $valid = $err_codes == '' ? TRUE : FALSE;
                            return array("_err" => $valid, "_err_codes" => $err_codes);
              }

              /*

               * public function push_faq_data()
               * this funciton called by manage_menu funtion to insert the data
               * into faqs_menus and calling to push_faq_menu function               */

              public function save_faq_qus() {
                            $FormData = $this->input->post();
                            $path = base_url() . "faqs/manage_faq_qus/";
                            // validation
                            $validates = $this->faq_qus_validation($FormData); // validating the form
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData["save_faq_qus"] == "save_faq_qus") {
                                          $FormData = $this->util_model->unset_array($FormData, array('save_faq_qus'));
                                          $succ = $this->faq_model->push_faq_ques($FormData);
                                          if ($succ) {
                                                        redirect($path . "0/faq_qusAddSucc");
                                          } else {
                                                        redirect($path . "1/faq_qusAddErr" . ERR_DELIMETER);
                                          }
                            }
              }

              /*

               * function faq_menu_list()
               * to diaplay all the faq menu list               */

              function faq_qus_list() {
                            global $data;
                            $data['faq_qus_list'] = $this->faq_model->get_faq_qus_list();
                          //  $this->util_model->printr($data['faq_qus_list']);
                            $this->load->view("faqs/faq_qus/v-all-faq-qus", $data);
              }
              
              
              /*

               * function faq_edit_manu
               * working : used to edit faq menu details
               * @param1 : Id of faq menu int
               * return to manage_menu function              /
               */

              function faq_edit_ques($faq_ques_id, $error = '', $_err_codes = '') {
                            global $data;
                            $data = $this->util_model->set_error($data, $error, $_err_codes);
                            $data['faq_m_list'] = $this->util_model->get_list('menuid', 'm_heading_text', DB_PREFIX . "faqs_menus", 0, 'm_heading_text');
                            $filter_data = array("faq_qus_id" => $faq_ques_id);
                            $data['fq_data'] = $this->faq_model->get_faq_qus_list($filter_data);
                            //  $this->util_model->printr($data['faq_menu_data']);
                            $this->load->view("templates/header.php", $data);
                            $this->load->view("faqs/faq_qus/v-edit-faq-qus", $data);
                            $this->load->view("templates/footer.php");
              }

              /*

               * function update_faq_menu()
               * calling from faq edit menu
               * working: used to update the data
               * return: to manage_menu               */

              function update_faq_qus() {

                            $FormData = $this->input->post();
                            $path = base_url() . "faqs/manage_faq_qus/";
                            $path_update = base_url() . "faqs/faq_edit_ques/";
                            if (!isset($FormData['menuid'])) {
                                          redirect($path . "1/FaqquestionIDNotDef" . ERR_DELIMETER);
                            }

                            $FormData = $this->util_model->add_mode_user($FormData);


                            // validation
                            $validates = $this->faq_qus_validation($FormData); // validating the form
                            if (!$validates['_err']) {
                                          redirect($path . "1/{$validates['_err_codes']}");
                            }

                            if ($FormData["update_faq_qus"] == "update_faq_qus") {
                                          $FormData = $this->util_model->unset_array($FormData, array('update_faq_qus'));
                                          //  die($this->util_model->printr($FormData));
                                          $succ = $this->faq_model->update_faq_ques($FormData);
                                          if ($succ) {
                                                        redirect($path . "0/faqQUpSucc");
                                          } else {
                                                        redirect($path_update . $FormData['fqid'] . "/" . "1/faqQUpdErr" . ERR_DELIMETER);
                                          }
                            }
              }
              
              


}
