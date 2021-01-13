<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_tt_p_cat
 *
 * @author User
 */
class manage_tt_p_cat extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('tms/m_tt_manage', 'tms');
    }

    /*
     * It will load the view 
     */

    public function index($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes); 
        $filter_data = array("Status" => 1,"parent_ttmid"=>"0");
        $data['taskCatList'] = $this->tms->get_taskCat_list($filter_data); 
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_tt_cat/v-create-task-cat.php', $data);
        $this->load->view('templates/footer.php', $data);
    }
    
     public function get_task_code() {
        $formdata = $this->input->post();  
//        $this->util_model->printr($formdata);
        echo json_encode($this->tms->get_TCatcode($formdata));
    }
    
   

    /*

     * insert into task_type_mst
     * response in json     */

    public function insert_db() {
        $form_data = $this->input->post();
        $form_data['category'] = TRUE;
        $inserted = $this->tms->create_task_type($form_data);
        redirect(base_url() . "tms/manage_tt_p_cat/index/" . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
    }

    /*

     * it will recieve task type id and 
     * render update form
     */

    public function edit_tCat() {
        global $data;
        $formdata = $this->input->post();
        if (isset($formdata['id']) && $formdata['id'] != "") {
            $formdata['tt_Editdetail'] = $this->tms->get_task_data($formdata['id']);
            echo json_encode($formdata['tt_Editdetail']);
        }
    }

    public function update_tCat() {
        global $data;
        $form_data = $this->input->post();
        $form_data['category'] = TRUE;
        if (isset($form_data['ttm_id']) && $form_data['ttm_id'] != "") {
            $updated = $this->tms->update_task_type($form_data);
            echo json_encode($updated);
           
        }
    }

    

}
