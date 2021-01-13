<?php

if (!defined('BASEPATH'))
              exit('No direct script access allowed');

class report extends CI_Controller {

              function __construct() {
                            parent::__construct();
              }

              function bal_report() {
                              
              }

              function export_report() {
                            global $data;
                            $this->load->dbutil();
                            $this->load->helper('file');
                            /* get the object   */
                            $POST = $this->input->post();
                            $this->util_model->printr($POST);
                           // $module =$POST['get_report'];
                            $report = array();
                            $report_name = "";
                           // if ($module == "all_enq_adm_list") {
                                          $this->load->model('enquiry/m_enquiry');
                                          $report = $this->m_enquiry->search_enq($POST);
                                          $report_name = "all_enq_adm_list" . date(DF) . ".csv";
                          //  }
                            /*  pass it to db utility function  */
                            $new_report = $this->dbutil->csv_from_result($report);
                            /*  Now use it to write file. write_file helper function will do it */
                            write_file($report_name, $new_report);
                            $this->load->helper('download');
                            force_download($report_name, $new_report);

                            // delete_files($report_name);
                            /*  Done    */
              }

               

}
