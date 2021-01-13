<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of invoice_msg
 *
 * @author User
 */
class invoice_mst extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("tms/m_invoices");
    }
    //put your code here
    public function index() {
        global $data;
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['client_list'] = $this->m_task->get_client_list(array("progress_flag" => COMPLETED_APPROVAL));
        $data['BillTypes'] = $this->m_invoices->get_bill_types();
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_invoice/index.php', $data);
        $this->load->view('templates/footer.php');
    }
    
    public function add_billing_servics($action='',$serCatCode='') {
        global $data;
        $formData = $this->input->post();
        $data['msg'] = "";
        if(!empty($formData)){
           if($this->m_invoices->insert_update_services($formData)){
               $data['msg'] = "Billing Services Modified successfully";
           }
        }
        if($action=="delete" && $serCatCode!=""){
            $data['msg'] = $this->m_invoices->delete_service($serCatCode);
        }else if($action=="edit" && $serCatCode!=""){
            $data['ser_details'] = $this->m_invoices->get_last_services(array("serCatCode"=>$serCatCode));
        }
        
        $data['last_ser'] = $this->m_invoices->get_last_services(array("group_by"=>"serCatCode"));
        $data['taskCatList'] = array("0" => "Select Type") + $this->util_model->get_list("ttm_id", "ttm_name", DB_PREFIX . "task_type_mst", 0, "ttm_name", TRUE, 1, " parent_ttmid=0");
        $data['ser_list'] = $this->util_model->get_list("serCatName", "serCatName", DB_PREFIX . "biling_services_mst", 0, "serCatName", TRUE, 1);
        $data['ser_Codelist'] = $this->util_model->get_list("serCatCode", "serCatCode", DB_PREFIX . "biling_services_mst", 0, "serCatCode", TRUE, 1);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_tt/v_add_edit_task_type_services.php', $data);
        $this->load->view('templates/footer.php');
    }
    
    public function filter_bills_by_client() {
        $formData = $this->input->post();
        echo json_encode($this->m_invoices->get_bills($formData));
    }
    
    public function generate_invoices() {
        $formData = $this->input->post();
        $result = $this->m_invoices->get_invoice_data($formData);    
//        $this->util_model->printr($formData);
//        $this->util_model->printr($result);
        $this->load->library("excel");
        $this->excel->print_bills($result);
    }
    
    

}
