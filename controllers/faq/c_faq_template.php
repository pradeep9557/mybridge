<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of template
 *
 * @author intern
 */
class c_faq_template extends CI_Controller {

              public function __construct() {
                            parent::__construct();
                            $this->load->model("faq/m_template");
              }

              /* Fetching following things
               * 1. Calling fetch_menu model to get menuid,div_heading_text,htmlid and m_heading_text
               * 2. Creating an array named $menu_que
               * 3. Calling ques_menuid model and passing menuid to it received from the fetch_menu model
               * 4. Saved all the info in $menu_que array which is now multi-dimensional with data from step 1 at
               *    1st index and data from step 3 at 2nd index.
               * 5. saved this whole $menu_que in another array at result index of a data array "$data['result']"
               * 6. Call to load the view and also passed the array data. 
               */

              public function index() {
                            //step 1
                            global $data;
                            $data['faq_title_text'] = "NexGen Institutional Business Management System | NexIBMS";
                            $data['faq_data'] = $this->m_template->fetch_menu();

                            //step 2

                            $menu_que = array();
//        echo '<pre>';
//        print_r($data['faq_data']);
//        echo '</pre>';
// die();

                            foreach ($data['faq_data'] as $d) {
                                          //step 4                                     //step 3
                                          $menu_que[] = array("Menu" => $d, "ques" => $this->m_template->ques_menuid($d['menuid']));
                            }

                            //stpe 6
                            $data['result'] = $menu_que;
//        echo '<pre>';
//        print_r($menu_que);
//        echo '</pre>';
//        die();
                            //step 7
                            $this->load->view('faqs/faq_template/faq_header', $data);
                            $this->load->view('faqs/faq_template/v_template', $data);
                            $this->load->view('faqs/faq_template/faq_footer', $data);
              }

}
