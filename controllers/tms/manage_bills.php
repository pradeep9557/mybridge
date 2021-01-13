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
class manage_bills extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_task_billing", 'm_bill');
    }

    // start you function from here
    public function index($bill_id = "", $error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
 
        if($this->input->get('delete_bill_id')!=''){
            echo json_encode($this->m_bill->delete_bill(array('bill_mst_id'=>$this->input->get('delete_bill_id'))));    
            die();
        }
        
        $data['bill_mst_id'] = $bill_id;
        if ($bill_id != "" && $bill_id != STATUS_FALSE && $this->util_model->get_column_value("status", DB_PREFIX . "task_billing_mst", array("bill_mst_id" => $bill_id)) != "") {
            $data['bill_data'] = $this->m_bill->fetch_bill_data(array("bill_mst_id" => $bill_id));
            $data['bill_data'] = $data['bill_data'][0];

            $data['bill_data']['tm_id'] = $this->m_bill->m_bill_get_tasks($bill_id); 

            $data['bill_data']['ser_data'] = unserialize($data['bill_data']['ser_data']);
            $company_details = unserialize($data['bill_data']['company_details']);
            foreach ($company_details as $key => $value) {
                $data['bill_data'][$key] = $value;
            }
            $client_details = unserialize($data['bill_data']['client_details']);
            foreach ($client_details as $key => $value) {
                $data['bill_data'][$key] = $value;
            }
//            $this->util_model->printr($data['bill_data']);
        }

        $request = $this->input->get();
        $data['tm_id'] = '';
        if ($request) {
            //tm_id gettting

            $data['tm_id'] = $request['tm_id'];
        }
//account list
        $data['accountList'] = $this->m_bill->getAccount();
        //end accoiunt List
//        die($this->util_model->printr($data));
        $this->load->model("tms/m_manage_users", 'm_user');
        $data['unbilled_client_list'] = $this->m_user->get_unbilled_clients();
        $data['all_cilents'] = $this->m_user->get_all_clients();
//        $this->util_model->printr($data['client_list']);
        $filter = array();
        $filter['progress_flag'] = COMPLETED_APPROVAL;
        $data['task_list'] = array("0" => "Select Tasks");
        if($bill_id!=""){
        $result = $this->m_bill->m_task_list();
        if (!empty($result)) { 
            foreach ($result as $value) {
                $data['task_list'][$value['tm_id']] = $value['tm_name'];
            }
        }}

        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Bills"; 

        $data['bill_search_view'] = $this->tms_ajax->bill_search();
        $data['service_list'] = array("0" => "Select Service") + $this->tms_ajax->get_ser_list();
        $data['btypelist'] = $this->m_bill->getbilltype();
        $data['get_tax_rate'] = $this->m_bill->m_tax_list();
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_bills/v_add_bill.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function All_bill_List() {
        
        $data['all_bill_details'] = $this->m_bill->fetch_bill_data(array("limit" => 5));
        $data['title'] = ucfirst("All Bill List | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('tms/manage_bills/v_all_bills.php', $data);
    }

    public function finalize_bill($bill_id = "", $error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);

        $data['bill_mst_id'] = $bill_id;
        if ($bill_id != "" && $bill_id != STATUS_FALSE && $this->util_model->get_column_value("status", DB_PREFIX . "task_billings", array("bill_id" => $bill_id)) != "") {
            $data['bill_data'] = $this->m_bill->fetch_final_bill_data(array("bill_id" => $bill_id));
            $data['bill_data'] = $data['bill_data'][0];
            $result = $this->m_bill->m_bill_list((array("client_id" => $data['bill_data']['client_id'])));
            $data['task_list'] = array("0" => "Select Client");
            if (!empty($result)) {
                foreach ($result as $value) {
                    $data['bill_list'][$value['bill_mst_id']] = $value['bill_number'];
                }
            }
        }
//        $this->util_model->printr($data['bill_list']);
//        die($this->util_model->printr($data['bill_data']));
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['client_list'] = $this->m_task->get_client_list(array("progress_flag" => COMPLETED_REQUEST));

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_bills/v_finalize_bill.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function All_finalize_bill_List() {
        $data['all_bill_details'] = $this->m_bill->fetch_final_bill_data();
//        $this->util_model->printr($data['all_bill_details']);
        $data['title'] = ucfirst("All Bill List | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('tms/manage_bills/v_finalize_all_bills.php', $data);
    }

    public function bill_master_save_update() {
        $formdata = $this->input->post();
//        $this->util_model->printr($formdata);
//        die();
        sort($formdata['sort']);
        $formdata['ser_data'] = array();
        foreach ($formdata['sort'] as $index => $sort) {
            if (isset($formdata['service_name'][$index]) && $formdata['amt'][$index]) {
                $formdata['ser_data'][] = array(
                    "ser_name" => $formdata['service_name'][$index],
                    "amt" => $formdata['amt'][$index],
                    "sort" => $sort
                );
            }
        }
        $formdata['bill_due_date'] = date(DB_DF, strtotime($formdata['bill_due_date']));
        $formdata['ser_data'] = serialize($formdata['ser_data']);
        unset($formdata['sort']);
        unset($formdata['amt']);
        unset($formdata['final_bill']);
        unset($formdata['service_name']);

        $formdata['company_details'] = array(
            "bill_account_id" => $formdata['bill_account_id'],
            "billing_com_name" => $formdata['billing_com_name'],
            "billing_add" => $formdata['billing_add'],
            "bill_phone" => $formdata['bill_phone'],
            "bill_email" => $formdata['bill_email'],
            "pan_no" => $formdata['pan_no'],
            "st_reg_no" => $formdata['st_reg_no'],
            "bank_name" => $formdata['bank_name'],
            "bank_acc_no" => $formdata['bank_acc_no'],
            "bank_ifsc_code" => $formdata['bank_ifsc_code'],
            "bank_address" => $formdata['bank_address'],
            "gst_no" => $formdata['gst_no'],
            'hsn_scn' => $formdata['hsn_scn']
        );
        $formdata['company_details'] = serialize($formdata['company_details']);

        $formdata['client_details'] = array(
            "client_billing_name" => $formdata['client_billing_name'],
            "client_billing_add1" => $formdata['client_billing_add1'],
            "client_billing_add2" => $formdata['client_billing_add2'],
            "client_gst_no" => $formdata['client_gst_no'],
            "client_po" => $formdata['client_po']
        );
        $formdata['client_details'] = serialize($formdata['client_details']);



        unset($formdata['billing_com_name']);
//        unset($formdata['bill_account_id']);
        unset($formdata['billing_add']);
        unset($formdata['bill_phone']);
        unset($formdata['bill_email']);
        unset($formdata['pan_no']);
        unset($formdata['st_reg_no']);
        unset($formdata['bank_name']);
        unset($formdata['bank_acc_no']);
        unset($formdata['bank_ifsc_code']);
        unset($formdata['bank_address']);


//        $this->util_model->printr($formdata);
//        die();
        $action = $formdata['action_performed'];
        unset($formdata['action_performed']);
        $result = "";
        if ($action == "save") {
            $result = $this->m_bill->save_bill_master($formdata);
        } else {
            $result = $this->m_bill->update_bill_master($formdata);
        }
        if ($result['succ']) {
            //mail bhejo
        }
        echo json_encode($result);
    }

    public function finalize_bill_save_update() {
        $formdata = $this->input->post();
        $action = $formdata['action_performed'];
        unset($formdata['action_performed']);
        $result = "";
        if ($action == "save") {
            $result = $this->m_bill->save_bill_final($formdata);
        } else {
            $result = $this->m_bill->update_bill_final($formdata);
        }
        if ($result['succ']) {
            //mail bhejo
        }
        echo json_encode($result);
    }

    public function get_client_address() {
        $formdata = $this->input->post();
        $client_res = $this->db->select("client_billing_name,client_billing_add1,client_billing_add2,gst_no,po_no")->where(array("Emp_ID" => $formdata['client_id']))->get(DB_PREFIX . "employee")->row();
        echo json_encode(array("succ" => TRUE, "client_details" => $client_res));
    }
    public function filter_task_by_client() {
        $formdata = $this->input->post();
//        $this->util_model->printr($formdata);
        $res = $this->m_bill->get_unbilled_task_list($formdata);
//        $this->util_model->printr($res);
        if (!empty($res)) {
            $list = array();
            foreach ($res as $each_row) {
                $list[] = array("tm_id" => $each_row['tm_id'], "tm_name" => ($each_row['tm_name'] . " (#{$each_row['tm_id']})"));
            }
           
            echo json_encode(array("succ" => TRUE, "data" => $list));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function filter_bill_by_client($formdata = array()) {
        if (empty($formdata)) {
            $formdata = $this->input->post();
        }
        $res = $this->m_bill->m_bill_list($formdata);
        if (!empty($res)) {
            echo json_encode(array("succ" => TRUE, "data" => $res));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function get_bill_result($form_data = array()) {
        if (empty($form_data)) {
            $form_data = $this->input->post();
        }
        $form_data['page'] = $data['s_no'] = $form_data['page'] * $form_data['limit'];

        $data['bill_list'] = $this->m_bill->fetch_bill_data($form_data);
        echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/common/get_bill_ajax/ajax_result.php', $data, TRUE)));
    }

    public function bill_account_add() {

        global $data;
        // error_reporting(0);

        $request = $this->input->post();
        if ($request) {
            $json = array();
            unset($request['bill_account_id']);
            if ($this->m_bill->bill_account_add($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "New Account is Added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "New Account is not Added.";
            }
            echo json_encode($json);
            return;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_bills/bill_account_master/v-add-account', $data);
        $this->load->view('templates/footer.php');
    }

    public function bill_account_dele() {
        ///manage nexgen_task_bill_account   delete ...
        ///manage nexgen_task_bill_account insert   ...
        global $data;
        // error_reporting(0);

        $request = $this->input->post();
        if ($request) {
            $json = array();
            //  unset($request['bill_account_id']);
            if ($this->m_bill->bill_account_dele($request['bill_account_id'])) {
                $json['success'] = TRUE;
                $json['msg'] = "New Account is Deleted.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "New Account is not Deleted.";
            }
            echo json_encode($json);
            return;
        }
    }

    public function bill_account_update() {
        ///manage nexgen_task_bill_account  update  ...

        global $data;
        // error_reporting(0);

        $request = $this->input->post();
        if ($request) {
            $json = array();

            $request['status'] = isset($request['status']) ? 1 : 0;
            //  unset($request['bill_account_id']);
            if ($this->m_bill->bill_account_update($request, $request['bill_account_id'])) {
                $json['success'] = TRUE;
                $json['msg'] = "New Account is Updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "New Account is not Updated.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function get_bill_account($id = 0, $type = 0) {
        $filter = array();
        if ($id != "") {
            $filter['bill_account_id'] = $id;
        }
        $data = $this->m_bill->get_bill_accounts($filter);
        if ($type)
            return $data;
        echo json_encode($data);
    }

    public function get_serCatList($serCatCode) {
        $this->db->where("ser_mst.serCatCode", $serCatCode);
        $this->db->select("ser_mst.*")->from(DB_PREFIX . "biling_services_mst ser_mst");
        $res = $this->db->get()->result_array();
        echo json_encode(array("succ" => 1, "serCatData" => $res));
    }

    public function print_bill($bill_mst_id) {
        $bill_details = $this->db->where(array("bill_mst_id" => $bill_mst_id))->get(DB_PREFIX . "task_billing_mst")->row_array();
        $bill_details['ser_data'] = unserialize($bill_details['ser_data']);
        $bill_details['company_details'] = unserialize($bill_details['company_details']);
        $bill_details['client_details'] = unserialize($bill_details['client_details']);
        $billtype = $this->db->where('id',$bill_details['billtype'])->get(DB_PREFIX . "bill_type")->row_array();
//        $this->util_model->printr($billtype);
//        die();
        if(empty($billtype)){
            $bill_details['billtype']="Invoice";
        }else{
            $bill_details['billtype']=$billtype['name'];
        }
        $this->load->library('numbertowords');
        $bill_details['total_amt'] = $bill_details['bill_amt'] + $bill_details['ser_tax'] + $bill_details['etax'] + $bill_details['ktax'] + $bill_details['CGST'] + $bill_details['IGST'] + $bill_details['SGST'] + $bill_details['UTGST'];
        $bill_details['total_amt_in_wrds'] = $this->numbertowords->convert_number($bill_details['total_amt']);
//        $data['bill_details'] = $bill_details;
        $this->load->library("pdf");
        $this->pdf->print_bill($bill_details);
//        $this->load->view("fpdf/print_bill",$data);
    }

    public function check_bill_no($bill_no) {
        $res = $this->db->where(array("bill_no" => $bill_no))->get(DB_PREFIX . "task_billing_mst")->result_array();
        if (!empty($res)) {
            echo json_encode(array("succ" => FALSE));
        } else {
            echo json_encode(array("succ" => TRUE));
        }
    }
    public function add_bill_type($id='',$type='') {
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
           $data['typedata'] = $this->db->where('id',$id)->get(DB_PREFIX . "bill_type")->row_array();
        }
        if($id!='' && $type!='' && $type=='del'){
                $this->db->where("id", $id);
        $this->db->delete(DB_PREFIX . "bill_type");
        }
         }else{
             if($form_data['_action']=='add'){
                  if ($this->m_bill->insertbilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Add successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_bill->get_err_codes()));
                }
                die();
             }else if($form_data['_action']=='edit'){
                  if ($this->m_bill->updatebilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Updated successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_bill->get_err_codes()));
                }
                die();
             }
             else if($form_data['_action']=='del'){
                  if ($this->m_bill->delbilltype($form_data)) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'deleted successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_bill->get_err_codes()));
                }
                die();
             }
         }
        $data['btypelist'] = $this->db->get(DB_PREFIX . "bill_type")->result_array();
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_bills/v_bill_type.php', $data);
        $this->load->view('templates/footer.php');
    }

}
