<?php

/**
 * Description of expense
 *
 * 
 */
class c_ex_type extends CI_Controller {

    private $flag = 1;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('expense/m_expense');
        $this->load->library('excel');
    }

    public function index($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->view('templates/header.php', $data);
        $this->load->view('expense/v-expense-type');
        $this->load->view('templates/footer.php');
    }

    public function insert_type() {
        global $data;
        $path = base_url() . "expense/c_ex_type/index/";
        $type_data = $this->input->post();
        $type_data['BranchID'] = $data['Session_Data']['IBMS_BRANCHID'];
        ;
        $type_data = $this->util_model->add_common_fields($type_data);

        if ($this->m_expense->insert_type($type_data)) {

            redirect($path . "0/ExptSaveSucc");
        } else {

            redirect($path . "1/ExptSaveErr");
        }
    }

    public function display_all_types() {

        global $data;
        $filter_data = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID'], 'OrderCol' => 'BranchID');
        $data['all_types'] = $this->m_expense->get_all_types($filter_data);

        $this->load->view('expense/v-all-expense-type', $data);
    }

    public function display_edit_type($ex_type_id) {

        global $data;

        $data['type_data'] = $this->m_expense->type_by_id($ex_type_id);

        $this->load->view('templates/header.php', $data);
        $this->load->view('expense/v-edit-type', $data);
        $this->load->view('templates/footer.php');
    }

    public function update_type($ex_type_id) {

        global $data;

        $path = base_url() . "expense/c_ex_type/index/";
        $new_type = $this->input->post();
        $new_type = $this->util_model->add_mode_user($new_type);

        if ($this->m_expense->type_update($new_type, $ex_type_id)) {
            redirect($path . "0/ExptUpSucc");
        } else {
            redirect($path . "1/ExptUpErr" . ERR_DELIMETER);
        }
    }

    public function delete_expense_type($ex_type_id) {

        $filter_del = array('BranchID' => $data['Session_Data']['IBMS_BRANCHID'], 'ex_type_id' => $ex_type_id);
        $path = base_url() . "expense/c_expense/index/";

        $chk_data = $this->m_expense->get_all_expenses();
        foreach ($chk_data as $row) {

            if ($row->ex_type_id === $ex_type_id) {
                $flag = 0;
            } else {
                $flag = 1;
            }
        }
//        echo $flag;
//            die(0);

        if ($flag == 0) {
            redirect($path . "1/ExptDelErr" . ERR_DELIMETER);
        } else {
            if ($this->m_expense->delete_type($filter_del)) {

                redirect($path . "0/ExptDelSucc");
            } else {
                redirect($path . "1/ExptDelErr");
            }
        }
    }

}
