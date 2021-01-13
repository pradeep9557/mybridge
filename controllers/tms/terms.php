<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of terms
 *
 * @author anup
 */
class terms  extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_term");
    }

     public function addPeriods() {

        global $data;
        // error_reporting(0);

        $request = $this->input->post();
        if(isset($request['_action']) && $request['_action']=="getAll"){
            echo json_encode($this->m_term->get_terms());
            die();
        }else if(isset($request['_action']) && $request['_action']=="delete"){
            echo json_encode(array('success'=>$this->m_term->term_dele($request['term_id'])));
            die();
        }else if ($request) {
            $json = array();
            if(isset($request['_action']) && $request['_action']!='update'){
                unset($request['term_id']);
            }
            unset($request['_action']);    
            $request['term_type'] = 'create_task_period';
            if ($this->m_term->term_add($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "New Period is Added/Updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "New Period is not Added/Updated.";
            }
            echo json_encode($json);
            return;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/term/v-add-period', $data);
        $this->load->view('templates/footer.php');
    }
}
