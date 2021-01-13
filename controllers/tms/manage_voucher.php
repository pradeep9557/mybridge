<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_voucher
 *
 * @author NexGen
 */
class manage_voucher extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model("tms/m_daily_task", 'daily_task');
        $this->load->model("tms/m_manage_voucher", 'm_voucher');
    }

    public function index($v_id = 0, $action = '') {

        //echo "hi";
        global $data;
//        $this->util_model->printr($data['Session_Data']);
        $this->load->model("tms/m_task_manage", 'm_task');
        $data['from_place'] = $this->util_model->get_list("locality", "locality", DB_PREFIX . "locality", 0, "locality", TRUE, 1)+array("other"=>"Other");
        $data['to_place'] = array("0" => "to Place") + $data['from_place'];
        $data['from_place'] = array("0" => "From Place") + $data['from_place'];
        //  $v_id = $this->input->get("v_id");
        $request = $this->input->post();
        if ($request) {
            if ($v_id == 0 && $action == '') {
                echo $this->addVoucher($request);
                return;
            } else if ($v_id != 0 && $action != 'del') {
                echo $this->update_voucher($request, $v_id);
                return;
            }
        }


        //delete code
        if ($v_id != 0 && $action == 'del') {
            echo $this->deleteVoucher($v_id);
            return;
        }

        //get request for edit

        $data['VoucherForm'] = "Voucher Add Form";
        $data['VoucherFormSubmit'] = "Voucher Save";
        if ($v_id != 0) {
            $filters['v_id'] = $v_id;
            $data['voucher_data'] = $this->m_voucher->getVouchers($filters);
            $data['VoucherForm'] = "Voucher Update Form";
            $data['VoucherFormSubmit'] = "Voucher Update";
        }
        $data['v_id'] = $v_id;
        $data['client_list'] = $this->m_task->get_client_list();
//        $data['client_list'] = array("0" => "Select Client") + $this->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", "", $sort_col = 'Emp_Name', $for_selection = TRUE, $status = 1, $whr = " UTID=" . CLIENT);
        // $filter = array();
        //$filter['assignedto'] =$this->util_model->get_uid();
        $result = $this->daily_task->get_curr_user_task();
        $temp = array();
        foreach ($result as $value) {
            $temp[$value['tstm_id']] = $value['tstm_name'];
        }
        $data['users'] = array("0" => "Select User") + $this->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", 0, "Emp_Name", TRUE, 1, " UTID not in(9,14)");
        $data['progress_task'] = array("0" => "Select Sub task") + $temp;
        $data['voucherList'] = $this->my_vouchers();
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_voucher/v-add-voucher', $data);
        $this->load->view('templates/footer.php');
    }

    public function my_vouchers() {

        $filters = array();
        $filters['Add_User'] = $this->util_model->get_uid();
        $data['voucherList'] = $this->m_voucher->getVouchers($filters);

        return $this->load->view('tms/manage_voucher/v-all-voucher', $data, true);
    }

    public function update_voucher($request, $v_id) {
        $request['tm_id'] = $this->util_model->get_a_column_value("tm_id", DB_PREFIX . "task_sub_task", array("tstm_id" => $request['tstm_id']));
        
        $status = $this->util_model->get_a_column_value("status", DB_PREFIX . "task_voucher_trn", array("v_id" =>$v_id));

        $json = array();
        $request = $this->util_model->add_mode_user($request);
        if ($this->m_voucher->update_voucher($request, $v_id) && $status==0) {
            $json['msg'] = "Voucher Updated. ";
            $json['success'] = TRUE;
        } else {
            $json['msg'] = "Error or no changes made in voucher !! ";
            $json['success'] = FALSE;
        }


        return json_encode($json);
        
    }

    public function addVoucher($request) {
        $json = array();
        $request['tm_id'] = $this->util_model->get_a_column_value("tm_id", DB_PREFIX . "task_sub_task", array("tstm_id" => $request['tstm_id']));

        $request = $this->util_model->add_common_fields($request);
        if ($this->m_voucher->save_voucher($request)) {
            $json['msg'] = "Voucher added. ";
            $json['success'] = TRUE;
        } else {
            $json['msg'] = "Voucher Not added. ";
            $json['success'] = FALSE;
        }

        return json_encode($json);
    }

    public function deleteVoucher($v_id) {
        $json = array();

        $AddDate = $this->util_model->get_a_column_value("Add_DateTime", DB_PREFIX . "task_voucher_trn", array("v_id" => $v_id));

        $deldate = date('m/d/Y h:i:s a', time());

        $diff = abs(strtotime($AddDate) - strtotime($deldate)) / 3600;


        if ($this->m_voucher->delete_voucher($v_id) && $diff <= 1) {
            $json['msg'] = "Voucher deleted. ";
            $json['success'] = TRUE;
        } else {
            $json['msg'] = "Voucher Not deleted. ";
            $json['success'] = FALSE;
        }

        return json_encode($json);
    }

}
