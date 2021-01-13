<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of expense
 *
 * 
 */
class c_expense extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('expense/m_expense');
        $this->load->library('excel');
    }

    public function index($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['ex_type'] = $this->util_model->get_list('ex_type_id', 'ex_type_code', DB_PREFIX . "expense_type_mst", $data['Session_Data']['IBMS_BRANCHID'], 'ex_type_id');
        $data['emp_list'] = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_Name');

        $this->load->view('templates/header.php', $data);
        $this->load->view('expense/v-manage-expense.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function insert_data() {
        global $data;
        $path = base_url() . "expense/c_expense/index/";
        $form_data = $this->input->post();
        $form_data = $this->util_model->add_common_fields($form_data);
        $form_data['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
        $form_data['ex_date'] = date(DB_DTF, strtotime($form_data['ex_date']));

        if ($this->m_expense->insert_data($form_data)) {
            redirect($path . "0/ExpAddSucc");
        } else {
            redirect($path . "1/ExpAddErr");
        }
    }

    public function list_all_expenses() {
        global $data;

        $filter_data = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID'], 'OrderCol' => 'emp.BranchID');
        $data['all_expenses'] = $this->m_expense->get_all_expenses($filter_data);
        $this->load->view('expense/v-all-expense', $data);
    }

    public function display_edit_expense($ex_id) {
        $this->ex_id = $ex_id;
        global $data;
        $data['ex_type'] = $this->util_model->get_list('ex_type_id', 'ex_type_code', DB_PREFIX . "expense_type_mst", $data['Session_Data']['IBMS_BRANCHID'], 'ex_type_id');
        $data['edit_data'] = $this->m_expense->expense_by_id($ex_id);
        $data['emp_list'] = $this->util_model->get_list('Emp_ID', 'Emp_Code', DB_PREFIX . "employee", $data['Session_Data']['IBMS_BRANCHID'], 'Emp_Name');

        $this->load->view('templates/header.php', $data);
        $this->load->view('expense/v-edit-expense', $data);
        $this->load->view('templates/footer.php');
    }

    public function update_expense($ex_id) {

        global $data;

        $path = base_url() . "expense/c_expense/index/";
        $new_data = $this->input->post();
        $new_data = $this->util_model->add_common_fields($new_data);
        $new_data['ex_date'] = date(DB_DTF, strtotime($new_data['ex_date']));
        $new_data = $this->util_model->add_mode_user($new_data);
        unset($new_data['Add_DateTime']);

        if ($this->m_expense->update_expense($new_data, $ex_id)) {
            redirect($path . "0/ExpUpdateSucc");
        } else {
            redirect($path . "1/ExpUpdateErr" . ERR_DELIMETER);
        }
    }

    public function delete_expense($ex_id) {

        $filter_del = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID'], 'ex_id' => $ex_id);
        $path = base_url() . "expense/c_expense/index/";

        if ($this->m_expense->delete_by_id($filter_del)) {
            redirect($path . "0/ExpDelSucc");
        } else {
            redirect($path . "1/ExpDelErr");
        }
    }

    public function exportxl() {
        global $data;
        $path = base_url() . "expense/c_expense/index/";
        $filter_data = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID'], 'OrderCol' => 'emp.BranchID');
        $exp_data = $this->m_expense->get_all_expenses($filter_data);

        if (!empty($exp_data)) {

            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->getStyle('A1:M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F5A316');
            $this->excel->getActiveSheet()->getColumnDimension('A1:M1')->setAutoSize(true);
            $this->excel->stream('expense.xls', $exp_data);
        }

        redirect($path);
    }

}
