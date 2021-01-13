<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class manage_task_logs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("tms/m_task_log", 'mt_log');
    }

    public function index($tm_id = 0) {
        global $data;
        if ($tm_id == 0) {
            $tm_id = $this->input->get('tm_id');
        }
        $this->load->model("tms/m_task_manage");
        if ($this->input->post('action') == "_load_task") {
            $list = array();
            $task = $this->m_task_manage->getTasks(array('Emp_ID' => $this->input->post('client_id')));
            foreach ($task as $each_task) {
                $list[$each_task['tm_id']] = "{$each_task['tm_name']} ({$each_task['tm_code']})";
            }
            echo json_encode(array(
                'succ' => TRUE,
                'task_list' => $list
            ));
            die();
        }
        //use in json
        if ($this->input->post('tm_id') != "") {
            $this->load->model("tms/m_task_manage");
            $tm_id = $this->input->post('tm_id');
            // if valid id comes .. it will fetch the data
            if ($tm_id != 0) {
                $filter = array("tm_id" => $tm_id);
                $task_details = $this->m_task_manage->get_single_history($filter);
                $logs_html = $this->get_logs_html($tm_id);
                echo json_encode(array("succ" => TRUE, "task_details" => $task_details, "logs_html" => $logs_html));
                die();
            }
        }



//        $filter  = array("extra_where" => "t1.progress_flag<>" . COMPLETED_APPROVAL); 
        $filter = array();
        $this->load->model('tms/m_manage_users');
        $data['client_list'] = $this->m_manage_users->get_all_clients(array('min_one_task' => 1));
        $data['task_list'] = $this->m_task_manage->getTasks($filter);
        $data['task_drowndown'] = array();
        foreach ($data['task_list'] as $each_task) {
            $data['task_drowndown'][$each_task['tm_id']] = "{$each_task['tm_name']} ({$each_task['tm_code']})";
        }
        $data['tm_id'] = $tm_id;
        $data['title'] = "Task History";
        $formData = $this->input->post();
        // if tm id passed from form
        // if punch log form submitted
        if (isset($formData['punchTaskLog'])) {
            $data_to_insert = array(
                "remarks" => $formData['comment'],
                "log_type" => TASK_MASTER,
                "modified_id" => $formData['tm_id'],
                "modifier_id" => $this->util_model->get_uid()
            );
            $data['punched_res'] = $this->mt_log->punch_log($data_to_insert);
        }


        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_tasks/logs/v_task_history.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    /*

     * only used to display logs     */

    public function display_logs($tm_id) {
        echo json_encode(array(
            "succ" => TRUE,
            "html" => $this->get_logs_html($tm_id)
        ));
    }

    public function get_logs_html($tm_id) {
        $filter_log = array("modified_id" => $tm_id, "log_type" => TASK_CATEGORY_MASTER);
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $filter_log['modifier_id'] = $this->util_model->get_uid();
        }
        $data['task_history'] = $this->mt_log->getTaskLog($filter_log);
        return $this->load->view('tms/manage_tasks/logs/task_logs.php', $data, TRUE);
    }

}
