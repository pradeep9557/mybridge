<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_bills
 * @Created on : 6 Jul, 2016, 5:27:34 PM
 * @author Deepak Singh
 * @Team Riding Solo
 * @copyright (c) year, Dee
 * @location
 * @Use
 * 
 */
class manage_taxs extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_taxs_manage", 'm_tax');
    }

     
 
    public function index($id='',$type='') {
        global  $data;
        $data['type'] ='Add';
        $data['action'] ='add';
         $form_data = $this->input->post();
         if(empty($form_data)){
        if($id!='' && $type!='' && $type=='add'){
          $data['type'] ='Add';  
        }
        if($id!='' && $type!='' && $type=='edit'){
           $data['type'] ='Update'; 
           $data['action'] ='edit';
           $data['typedata'] = $this->db->where('id',$id)->get(DB_PREFIX . "tax")->row_array();
        }
        if($id!='' && $type!='' && $type=='del'){
                $this->db->where("id", $id);
        $this->db->delete(DB_PREFIX . "tax");
        }
         }else{
             if($form_data['_action']=='add'){
                  if ($this->m_tax->insertbilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Add successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_tax->get_err_codes()));
                }
                die();
             }else if($form_data['_action']=='edit'){
                  if ($this->m_tax->updatebilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Updated successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_tax->get_err_codes()));
                }
                die();
             }
             else if($form_data['_action']=='del'){
                  if ($this->m_tax->delbilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'deleted successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_tax->get_err_codes()));
                }
                die();
             }
         }
        $data['btypelist'] = $this->db->get(DB_PREFIX . "tax")->result_array();
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/v_manage_taxs.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function test(){
        echo 'hello';
    }

}
