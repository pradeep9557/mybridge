<?php



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_tasks
 * @Created on : 27 May, 2016, 2:03:06 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class manage_tasks extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_task_manage", 'm_task');
        $this->load->model('tms/m_client_noti', 'm_noti');
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
    }

    // start you function from here
    public function index($task_id = "", $error = '', $_err_codes = '') { //provide a view of new Employee form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        unset($data['user_types'][1]);
        //To list all the nationality from the database 
        $data['days_list'] = $this->util_model->days_list();
        if (!file_exists(APPPATH . '/views/tms/manage_tasks/v_add_task.php')) {
            show_404();
        }
        $data['tm_id'] = $task_id;

        if ($task_id != "" && $task_id != STATUS_FALSE && $this->util_model->get_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $data['tm_id'])) != "") {
            $data['task_data'] = $this->m_task->fetch_task_data($task_id);
//            $this->util_model->printr($data['task_data']);
            $data['helper_task_list'] = $this->util_model->get_column_value("parent_ttmid", DB_PREFIX . "task_type_mst", array("ttm_id" => $data['task_data']['ttm_id']));
            $data['ttm_ids'] = $this->m_task->fetch_ttm_id($data['helper_task_list']);
        } else {
            $data['task_search_view'] = $this->tms_ajax->task_search(array("collapse" => 1));
        }

        $data['under'] = array("0" => "Parent Category") + $this->util_model->get_list("ttm_id", "ttm_name", DB_PREFIX . "task_type_mst", 0, "ttm_name", TRUE, 1, " parent_ttmid=0");
        $this->load->model('tms/m_manage_users');
        $data['incharge'] = array("0" => "Select Incharge") + $this->m_manage_users->get_users_for_create_task();
        $data['client_list'] = $this->m_manage_users->get_all_clients();
//        $this->util_model->printr($data['client_list']);
        $data['locality'] = array("0" => "Select Locality") + $this->util_model->get_list("localityid", "locality", DB_PREFIX . "locality", 0, "locality", TRUE, 1);

        if (isset($_GET['tab']) && ($_GET['tab'] == "create_replica" || $_GET['tab'] == "copy_task")) {
            $data['active_tab'] = $_GET['tab'];
        }
        if (isset($data['active_tab']) && $data['active_tab'] == 'create_replica') {
            $data['title'] = "Replica Form";
        } else if (isset($data['active_tab']) && $data['active_tab'] == 'copy_task') {
            $data['title'] = "Duplicate Task Form";
        } else if ($data['tm_id'] != "" && !empty($data['task_data'])) {
            $data['title'] = "Edit Task";
        } else {
            $data['title'] = "New Task From";
        }
        $this->load->model('tms/m_term');
        $data['period_list'] = $this->m_term->getTaskPeriod();
        if (!isset($data['task_data']) && $this->input->get('parent_ttmid')!='') {
            $data['task_data'] = array();
            $data['task_data'] = array_merge($data['task_data'], $this->input->get());
            $data['helper_task_list'] = $this->input->get('parent_ttmid');
            $data['ttm_ids'] = $this->m_task->fetch_ttm_id($this->input->get('parent_ttmid'));
        }
//        if($this->put)
//        $this->util_model->printr($data);
        $data['list_month'] = $this->m_task->list_month();
        $data['list_year'] = $this->m_task->list_year();
        $data['list_state'] = $this->m_task->list_state();
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_tasks/v_add_task.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function get_task_types() {
        $formdata = $this->input->post();
        
        $result = array("0" => "Select Type") + $this->util_model->get_list("ttm_id", "ttm_name", DB_PREFIX . "task_type_mst", 0, "ttm_name", TRUE, 1, " parent_ttmid=" . $formdata['ttm_id']);
        if (!empty($result)) {
            echo json_encode(array("succ" => TRUE, "data" => $result));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function fetch_all_task_types() {
        $formdata = $this->input->post();
        $result = $this->m_task->get_task_data($formdata);
        if (!empty($result)) {
            echo json_encode(array("succ" => TRUE, "data" => $result));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function convert_into_days($FormData) {
        if (isset($FormData['does_repeat']) &&
                $FormData['does_repeat'] &&
                isset($FormData['repeat_gap']) &&
                isset($FormData['repeat_unit'])) {
//            $FormData['repeat_unit'] = floor((strtotime("+{$FormData['repeat_unit']} {$FormData['repeat_gap']}") - strtotime(time())) / (60 * 60 * 24));
            $date1 = date_create(date("Y-m-d", strtotime("+{$FormData['repeat_unit']} {$FormData['repeat_gap']}")));
            $date2 = date_create(date("Y-m-d", strtotime("now")));
            $diff = date_diff($date1, $date2);
            $FormData['repeat_unit'] = $diff->format("%a");
        }
        return $FormData;
    }

    public function task_save_update() {
//        print_r($_FILES['attach_file']);die();
        $FormData = $this->input->post();
        // $this->util_model->printr($FormData);
        // die();
        $action = $FormData['action'];
        unset($FormData['action']);
        $result = array("succ" => FALSE);
        $FormData = $this->convert_into_days($FormData);
        $task_master_data = array(
            "skill_dev_activity" => $FormData['skill_dev_activity'],
            "ttm_id" => $FormData['ttm_id'],
            "tm_name" => $FormData['tm_name'],
            "tm_code" => $FormData['tm_code'],
            "start_date" => date(DB_DTF, strtotime($FormData['start_date'])),
            "end_date" => date(DB_DTF, strtotime($FormData['end_date'])),
            'client_visiblity' => $FormData['client_visiblity'],
            "extra_note" => $FormData['extra_note'],
            'task_period_id' => $FormData['task_period_id'],
            'state_id' => $FormData['state_id'],
            'month' => $FormData['month'],
            'year' => $FormData['year'],
            "does_repeat" => $FormData['does_repeat'],
            "approx_exp" => $FormData['approx_exp'],
            "client_id" => $FormData['client_id'],
            "repeat_gap" => $FormData['repeat_gap'],
            "repeat_unit" => $FormData['repeat_unit'],
            "progress_flag" => IN_PROGRESS,
            "client_p_id" => FILE_UPLOAD_DEFAULT);

        if (!empty($FormData['tstm_id']) && $action == "update" && $FormData['action_performed'] == "update") {
            $result = $this->m_task->update_sub_task($task_master_data, $FormData);
        } else if (!empty($FormData['tstm_id']) && $action == "replica" && $FormData['action_performed'] == "update") {
            $this->replicate_task($task_master_data, $FormData);
        } else if (!empty($FormData['tstm_id']) && $action == "copy") {
            $this->copy_task($task_master_data, $FormData);
        } else {
//            echo "coming";
            $result = $this->m_task->create_sub_task($task_master_data, $FormData);
            
            if ($result['succ'] && $action != "update" && $action != "replica") {
                $this->db->select("DISTINCT(e.Emp_ID), e.Emp_Name,e.P_Email", null, FALSE)->from(DB_PREFIX . "task_mst as tm");
                $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tst.assignedto or e.Emp_ID=tu.user_id", 'left');
                $this->db->where(array("tm.tm_id" => $result['id'], "tu.mail_notification" => STATUS_TRUE));
                $mail_result = $this->db->get()->result_array();
                //$this->m_task->send_new_task_create_mail($mail_result, $result['id']);
                if($FormData['notify_client']=='accept'){
                    $this->send_new_task_create_mail_client($FormData['client_id'], $result['id']);
                }
            }
        }
        
        
        
      $subtask =  $this->m_task->get_first_sub_task($result['id']);
      
       $this->db->where('Emp_id',$FormData['client_id']);
         $ClintName=  $this->db->get('nexgen_employee')->row();
         $clint_code=$ClintName->UserName;
        
         $taskCode=  $this->m_task->get_tasks_code($FormData['ttm_id'],$FormData['state_id']);
      
       $date1=$FormData['year'];
     $date2=$FormData['year']+1;

     $year=$date1."-".$date2;
      
      if($subtask['tstm_id']!=''){
      $formdata=$task_master_data;
        // if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'])) {
        //     mkdir(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'], 0777, true);
        // }
        if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'])) {
             mkdir(SITE_ROOT_PATH . "/uploads/" . $clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'], 0777, true);
        }
        if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'])) {
            mkdir(SITE_ROOT_PATH . "/tempuploads/" . $clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'], 0777, true);
       }
      // $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'];
        $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" .$clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'];
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
        $config['max_size'] = '15360'; // 15MB allowed
        $this->load->library('upload', $config);
        $upload_details['tm_code'] = $formdata['tm_code'];
        $upload_details['tstm_id'] = $subtask['tstm_id'];


        if (!empty($_FILES['attach_file'])) {

            $cpt = count($_FILES['attach_file']['name']);
            for ($i = 0; $i < $cpt; $i++) {

                if (!$_FILES['attach_file']['size'] || $_FILES['attach_file']['tmp_name'] == "") {
                    continue;
                }
                $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_file']['name'];
                $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $subtask['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_file']['name'], PATHINFO_EXTENSION);
                $source = SITE_ROOT_PATH . "/uploads/" . $clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'].'/'.$file_name;
                $destination = SITE_ROOT_PATH . "/tempuploads/" .$clint_code."/".$taskCode['state_name']."/".$taskCode['task_code']."/".$year."/".$formdata['month'].'/'.$file_name;
                $_FILES['temp_document_path']['name'] = $file_name;
                $_FILES['temp_document_path']['type'] = $_FILES['attach_file']['type'];
                $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_file']['tmp_name'];
                $_FILES['temp_document_path']['error'] = $_FILES['attach_file']['error'];
                $_FILES['temp_document_path']['size'] = $_FILES['attach_file']['size'];
                if (!$this->upload->do_upload('temp_document_path')) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("1.Error in uploading Files!")));

                    echo $this->upload->display_errors();
                    die();
                }
                copy($source, $destination);    
                $uploaded_data[$i]['attach_name'] = $file_name;
                $uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
                $uploaded_data[$i]['table_id'] = $subtask['tstm_id'];
                $uploaded_data[$i]['attach_type'] = 2;
                $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
            }
            if (!empty($uploaded_data['upload_errors'])) {

                echo json_encode(array("succ" => FALSE, "_err_codes" => array("2.Error in uploading Files!")));
                die();
            }
//                $this->util_model->printr($uploaded_data);
            if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                $result2 = $this->m_sub_task->attach_comment_docs($uploaded_data);

                if ($result2['succ'] != TRUE) {
                    //     $this->db->trans_rollback();
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                    die();
                }
//                $uploaded_data['attach_id'] = $result['attach_id'];
            }
        }
      }
        
        echo json_encode($result);
//  redirect(base_url() . "tms/manage_tasks/index/" . $result['id'] . "/" . ($result['succ'] ? "0/" . $result['_err_codes'] : "1/" . $result['_err_codes']));
    }
    
    public function send_new_task_create_mail_client($clientid, $task_id) {
        $this->load->model("tms/mail/mailer", 'mailer');
        /*if(!isset($clientid)){
            $clientid='205';
        }
        if(!isset($task_id)){
            $task_id='20874';
        }*/
        $url = base_url() . "tms/manage_tasks/client_landing_page/?".base64_encode('id='.$task_id.'&client_id='.$clientid);
        $data['my_tasks'] = $this->m_task->get_my_tasks(array("tm_id" => $task_id));
        $data['landingPage'] = false;
        $formdata['tm_id'] = $task_id;
        $this->load->model("tms/mail/mailer", 'mailer');
        $table_data_html = $this->load->view("tms/manage_tasks/table_for_mail", $data, TRUE);
        $sql = "SELECT P_Email FROM nexgen_employee where Emp_ID='".$clientid."'";
        $query = $this->db->query($sql);
        $res = $query->result('array');
        $mailData = array();
        $mailData['to'][] = 'pradeep@yopmail.com';//$res[0]['P_Email'];
        $mailData['from'] = NOTIFY_EMAIL; 
        $mailData['subject'] = "New Task has been Created!!";
        $formdata['msg'] = "Dear Client, " . "\n\nA new task has been Created by " . $this->util_model->get_uname() . " and you are a part of that task!!"
                . "Below is the detail for the same!!<br><br>" . $table_data_html . " <br><br>Please Click on Below Link to Upload Documents<br><br><a href='".$url."'>".$url."</a><br><br>\n\n\nThanks NexIBMS Team";
        $formdata['heading'] = "New Task Created!!";
        $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
        echo $mailData['message'];
    }

    public function client_landing_page(){
        $this->load->model("tms/mail/mailer", 'mailer');
        $argv = $_SERVER['argv'];
        $idString=base64_decode($argv[0]); 
        parse_str($idString, $output);
        $clientid = $output['client_id'];
        $task_id = $output['id'];
        $url = base_url() . "tms/manage_tasks/client_landing_page/?".base64_encode('id='.$task_id.'&client_id='.$clientid);
        $data['my_tasks'] = $this->m_task->get_my_tasks(array("tm_id" => $task_id));
        $data['landingPage'] = true;
        $this->load->model("tms/mail/mailer", 'mailer');
        $table_data_html = $this->load->view("tms/manage_tasks/table_for_mail", $data, TRUE);
        $sql = "SELECT P_Email FROM nexgen_employee where Emp_ID='".$clientid."'";
        $query = $this->db->query($sql);
        $res = $query->result('array');
        $mailData = array();
        $mailData['to'][] = $res[0]['P_Email'];//$clientid;
        $mailData['from'] = NOTIFY_EMAIL;
        $mailData['subject'] = "New Task has been Created!!";
        $formdata['msg'] = "Dear Client, " . "\n\nA new task has been Created by " . $this->util_model->get_uname() . " and you are a part of that task!!"
                . "Below is the detail for the same!!<br><br>" . $table_data_html . " <br><br>";
        $formdata['tm_id'] = $task_id;
        $formdata['heading'] = "New Task Created!!";
        $mailData['message'] = $this->load->view("tms/mail_template/emailtemplate", $formdata, TRUE);
        echo $mailData['message'];
    }

    public function upload_files(){
        $this->load->model("emp/employee_model");
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
        $formdata = $this->input->post(); 
        //echo "FormData: ";
        //print_r($formdata);
        //echo "FILES: ";
        //print_r($_FILES);
        if(!empty($_FILES)){
            $uploaded_data = array();
            $files = $_FILES['attach_name']['name'];
            $j=0;
            foreach ($files as $tstm_id => $value) {
                //echo $tstm_id.'/';
                $data = $this->employee_model->get__subtask_record($tstm_id, $formdata['client_id']);
                $upload_details = $this->m_sub_task->get_upload_detail_data($tstm_id);
                if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] )) {

                    // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
                    mkdir(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] , 0777, true);
                }
                if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] )) {
    
                    // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
                    mkdir(SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name'] . "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] , 0777, true);
                }
                $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'];
                $config['allowed_types'] = 'pdf|png|jpg|gif|jpeg|xls|docs|doc|txt|xlsx|docx';
                $config['max_size'] = '20480'; // 20MB allowed
                $this->load->library('upload', $config);
                $cpt = count($_FILES['attach_name']['name']["$tstm_id"]);
                for ($i = 0; $i < $cpt; $i++) {
                    
                    if (!$_FILES['attach_name']['size']["$tstm_id"][$i] || $_FILES['attach_name']['tmp_name']["$tstm_id"][$i] == "") {
                        continue;
                    }
                    $uploaded_data[$j]['attach_original_name'] = $_FILES['attach_name']['name']["$tstm_id"][$i];
                    $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $upload_details['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_name']['name']["$tstm_id"][$i], PATHINFO_EXTENSION);
                    $source = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $destination = SITE_ROOT_PATH . "/tempuploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $_FILES['temp_document_path']['name'] = $file_name;
                    $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type']["$tstm_id"][$i];
                    $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name']["$tstm_id"][$i];
                    $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error']["$tstm_id"][$i];
                    $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size']["$tstm_id"][$i];
//                    $this->util_model->printr($_FILES);
                    if (!$this->upload->do_upload('temp_document_path')) {
                        $this->db->trans_rollback();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => array($this->upload->display_errors("", ""))));
                        die();
                    }
                    copy($source, $destination);
                    $uploaded_data[$j]['attach_name'] = $file_name;
                    $uploaded_data[$j]['link'] = "tempuploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']."/".$file_name;
                    $uploaded_data[$j]['table_id'] = $tstm_id;
                    $uploaded_data[$j]['file_type'] = $formdata['fileType']["$tstm_id"][0];
                    $uploaded_data[$j] = $this->util_model->add_common_fields($uploaded_data[$j]); 
                    $j=$j+1;
                }
                if (!empty($uploaded_data['upload_errors'])) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("ErrorCode #10092016_1202")));
                    die();
                }
            }
            if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                //print_r($uploaded_data);
                //$result = $this->m_sub_task->attach_comment_docs($uploaded_data); 
                foreach ($uploaded_data as $k => $value) {
                    $arr1 = array(
                        'attach_original_name' => $value['attach_original_name'],
                        'attach_name' => $value['attach_name'],
                        'link' => $value['link'],
                        'table_id' => $value['table_id'],
                        'file_type' => $value['file_type'],
                        'Add_User' => $value['Add_User'],
                        'Add_DateTime' => $value['Add_DateTime'],
                    );
                    $this->db->insert('nexgen_task_attachments', $arr1);
                    if ($this->db->affected_rows() > 0) {
                        $arr = array(
                        'user_id' => $value['Add_User'],
                        'tm_id' => $formdata['tm_code'],
                        'file_name' => $value['attach_name'],
                        'link' => $value['link'],
                        'state_name' => $data['state'],
                        'date' => $value['Add_DateTime'],
                        'status' => 0,
                        'attachment_id' => $this->db->insert_id(),
                        );
                        $this->db->insert('nexgen_attach_file', $arr);
                    }
                }
                echo json_encode(array("succ" => TRUE, "_err_codes" => array('Data Uploaded Success')));
                die();
                
            }else{
                $this->db->trans_rollback();
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                die();
            }

        }
        /*$data['my_tasks'] = $this->m_task->get_my_tasks(array("tm_id" => $formdata['tm_code']));
        $state_id = $data['my_tasks'][0]['state_id'];
        $sql = "SELECT `name` FROM nexgen_cstates where state_id='".$state_id."'";
        $query = $this->db->query($sql);
        $res = $query->result('array');
        $data['state'] = $res[0]['name'];
        if (!empty($_FILES)) {
            $uploaded_data = array();
            if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'])) {
                mkdir(SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'], 0777, true);
            }
            if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $formdata['tm_code'])) {
                mkdir(SITE_ROOT_PATH . "/tempuploads/" . $formdata['tm_code'], 0777, true);
            }
            $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'];
            $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
            $config['max_size'] = '5120'; // 5MB allowed
            $this->load->library('upload', $config);
            $cpt = count($_FILES['attach_name']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                $j=$i+1;
                if (!$_FILES['attach_name']['size'][$i] || $_FILES['attach_name']['tmp_name'][$i] == "") {
                    continue;
                }
                $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_name']['name'][$i];
                $file_name = str_replace(" ", "", $formdata['tm_code']) . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_name']['name'][$i], PATHINFO_EXTENSION);
                $source = SITE_ROOT_PATH . "/uploads/" . $formdata['tm_code'].'/'.$file_name;
                $destination = SITE_ROOT_PATH . "/tempuploads/" . $formdata['tm_code'].'/'.$file_name;
                $_FILES['temp_document_path']['name'] = $file_name;
                $_FILES['temp_document_path']['type'] = $_FILES['attach_name']['type'][$i];
                $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_name']['tmp_name'][$i];
                $_FILES['temp_document_path']['error'] = $_FILES['attach_name']['error'][$i];
                $_FILES['temp_document_path']['size'] = $_FILES['attach_name']['size'][$i];
//                    $this->util_model->printr($_FILES);
                if (!$this->upload->do_upload('temp_document_path')) {
                    $this->db->trans_rollback();
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array($this->upload->display_errors("", ""))));
                    die();
                }
                copy($source, $destination);   
                $uploaded_data[$i]['attach_name'] = $file_name;
                $uploaded_data[$i]['link'] = "tempuploads/" . $formdata['tm_code'] . "/" . $file_name;
                $uploaded_data[$i]['table_id'] = 0;
                $uploaded_data[$i]['file_type'] = $formdata['fileType'][$i];
                $uploaded_data[$i]['description'] = $formdata['attach_desc'][$i];
                $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]); 
            }
            //$this->util_model->printr($uploaded_data);
            //die();
            if (!empty($uploaded_data['upload_errors'])) {
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("ErrorCode #10092016_1202")));
                die();
            }
            if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                //$result = $this->m_sub_task->attach_comment_docs($uploaded_data); 
                foreach ($uploaded_data as $k => $value) {
                    $arr = array(
                        'user_id' => $value['Add_User'],
                        'tm_id' => $formdata['tm_code'],
                        'file_name' => $value['attach_name'],
                        'link' => $value['link'],
                        'state_name' => $data['state'],
                        'date' => $value['Add_DateTime'],
                        'status' => 0,
                        'attachment_id' => 0,
                        //'description'=>$value['description'],
                    );
                    $this->db->insert('nexgen_attach_file', $arr);
                }
                echo json_encode(array("succ" => TRUE, "_err_codes" => array('Data Uploaded Success')));
                die();
            }else{
                $this->db->trans_rollback();
                echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                die();
            }
        }*/
    }

    public function replicate_task($task_master_data, $filter_data) {
        if (isset($filter_data['tm_id']) && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $filter_data['tm_id'])) != "") {
            $tm_code = $this->m_task->get_task_code(array("task_name" => $filter_data['tm_code']));
            $task_master_data["tm_code"] = $tm_code['code'];
//            $this->util_model->printr($task_master_data);
//            die($this->util_model->printr($filter_data));
            $result = $this->m_task->replicate_sub_task($task_master_data, $filter_data);

            if ($result['succ']) {
                $this->db->select("DISTINCT(e.Emp_ID), e.Emp_Name,e.P_Email", null, FALSE)->from(DB_PREFIX . "task_mst as tm");
                $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tst.assignedto or e.Emp_ID=tu.user_id", 'left');
                $this->db->where(array("tm.tm_id" => $result['id'], "tu.mail_notification" => STATUS_TRUE));
                $mail_result = $this->db->get()->result_array();
                $this->m_task->send_new_task_create_mail($mail_result, $result['id']);
            }
            echo json_encode($result);
            die();
//            redirect(base_url() . "tms/manage_tasks/index/" . $result['id'] . "/" . ($result['succ'] ? "0/" . $result['_err_codes'] : "1/" . $result['_err_codes']));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Code passed")));
            die();
//            redirect(base_url() . "tms/manage_tasks/index/" . $filter_data['tm_id'] . "/0/" . "TTIdError" . ERR_DELIMETER);
        }
    }

    public function copy_task($task_master_data, $filter_data) {
        if (isset($filter_data['tm_id']) && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $filter_data['tm_id'])) != "") {
            $tm_code = $this->m_task->get_task_code(array("task_name" => $filter_data['tm_code']));
            $task_master_data["tm_code"] = $tm_code['code'];
//            $this->util_model->printr($task_master_data);
//            die($this->util_model->printr($filter_data));
            $result = $this->m_task->replicate_sub_task($task_master_data, $filter_data, TRUE);

            if ($result['succ']) {
                $this->db->select("DISTINCT(e.Emp_ID), e.Emp_Name,e.P_Email", null, FALSE)->from(DB_PREFIX . "task_mst as tm");
                $this->db->join(DB_PREFIX . "task_sub_task as tst", "tst.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id", 'left');
                $this->db->join(DB_PREFIX . "employee as e", "e.Emp_ID=tst.assignedto or e.Emp_ID=tu.user_id", 'left');
                $this->db->where(array("tm.tm_id" => $result['id'], "tu.mail_notification" => STATUS_TRUE));
                $mail_result = $this->db->get()->result_array();
                $this->m_task->send_new_task_create_mail($mail_result, $result['id']);

                $result['_err_codes'] = array("Task Copied Successfully!!");
            } else {
                $result['_err_codes'] = array("Error while Copying Task!!");
            }

            echo json_encode($result);
            die();
//            redirect(base_url() . "tms/manage_tasks/index/" . $result['id'] . "/" . ($result['succ'] ? "0/" . $result['_err_codes'] : "1/" . $result['_err_codes']));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => array("Invalid Task Code passed")));
            die();
//            redirect(base_url() . "tms/manage_tasks/index/" . $filter_data['tm_id'] . "/0/" . "TTIdError" . ERR_DELIMETER);
        }
    }

    public function All_replica_List() {
        global $data;
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Replica tasks";
        $data['replica_btn'] = 1;
        $data['task_search_view'] = $this->tms_ajax->task_search();
        if (!file_exists(APPPATH . '/views/tms/user_task_manage/v_all_tasks.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Upcoming Replica Task List | " . SITE_NAME); //capitalizing the first character of string for header.
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/user_task_manage/v_all_tasks.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function get_user_availability() {
        $formdata = $this->input->post();
        echo json_encode($this->m_task->get_user_availability($formdata));
    }

    public function get_task_code() {
        $formdata = $this->input->post();
        echo json_encode($this->m_task->get_task_code($formdata));
    }

    /*

     * give result of task __ calling from ajax     */

    public function get_task_new_result($form_data = array()) {
    }
    public function get_task_result($form_data = array()) { 
        if (empty($form_data)) {
            $form_data = $this->input->post();
        }
        if (isset($form_data['view_change']) && $form_data['view_change']) {
            $data['s_no'] = ($form_data['page'] ? $form_data['page'] : 0) * $form_data['limit'];
            $data['s_no'] ++;
            //call the model function to get the department data
            $form_data['page'] = $form_data['page'] * $form_data['limit'];
            $data['my_tasks'] = $this->m_task->get_my_tasks($form_data);
            $data['my_new_tasks'] = $this->m_task->get_my_new_tasks($form_data);
            echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/manage_tasks/v_my_tasks.php', $data, TRUE)));
        } else {
            $data['s_no'] = ($form_data['page'] ? $form_data['page'] : 1) * $form_data['limit'];
            $data['s_no'] ++;
            $form_data['page'] = $data['s_no'] - 1;
            $data['my_tasks'] = $this->m_task->get_my_tasks($form_data);
            $data['my_new_tasks'] = $this->m_task->get_my_new_tasks($form_data);

//            $data['task_list'] = $this->m_task->getTasks($form_data);
            if (isset($form_data['replica_btn']) && $form_data['replica_btn'] == TRUE) {
                $data['replica_btn'] = TRUE;
            }

            echo json_encode(array("succ" => TRUE, "html" => $this->load->view('tms/manage_tasks/v_my_tasks.php', $data, TRUE)));
        }
    }

    public function my_tasks($upper_limit = 0) {
        global $data;
//        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['incharge'] = $this->input->get("Incharge");
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['view_change'] = TRUE;
        $data['client_id'] = $this->input->get('client_id');
        $data['ttm_id'] = $this->input->get('ttm_id');
        $existing_data = array("progress_flag" => 2);
        $existing_data['task_period_id'] = $this->input->get('task_period_id');
        $data['task_search_view'] = $this->tms_ajax->task_search($existing_data);
        $limits = "";
        if (!is_numeric($upper_limit)) {
            $limits = array("end_limit" => 5, "start_limit" => 0);
        } else {
            $limits = array("end_limit" => 5, "start_limit" => 5 * $upper_limit);
        }
        $data['s_no'] = 5 * $upper_limit + 1;
        $data['my_tasks'] = $this->m_task->get_my_tasks($limits);

        if (!empty($data['my_tasks'])) {
            $config['total_rows'] = ceil($this->m_task->count_my_task() / 5);

            for ($i = 0, $j = 0; $i < $config['total_rows']; $i++) {
                $data['page_links'][] = "<a href=" . base_url('tms/manage_tasks/my_tasks') . "/" . $i . " >" . ++$j . "</a>";
            }
        }
//        die($this->util_model->printr($data['my_tasks']));
        if (!file_exists(APPPATH . '/views/tms/manage_tasks/v_my_tasks.php')) {
            show_404();
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
//        $data['task_html'] = $this->load->view('tms/manage_tasks/v_my_tasks.php', $data, TRUE);
        $data['task_html'] = "";
        $this->load->view('tms/manage_tasks/v_template.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function completed_tasks($upper_limit = 0) {
        global $data;
//        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['view_change'] = TRUE;
        $existing_data = array("progress_flag" => COMPLETED_APPROVAL);
        $existing_data['BillingDone'] = $this->input->get('BillingDone');

        $data['task_search_view'] = $this->tms_ajax->task_search($existing_data);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
//        $data['task_html'] = $this->load->view('tms/manage_tasks/v_my_comp_tasks.php', $data, TRUE);
        $data['task_html'] = "";
        $this->load->view('tms/manage_tasks/v_template.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function billed_tasks($upper_limit = 0) {
        global $data;
//        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['view_change'] = TRUE;
        $existing_data = array("progress_flag" => COMPLETED_APPROVAL, "BillingDone" => 1);
        $data['task_search_view'] = $this->tms_ajax->task_search($existing_data);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
//        $data['task_html'] = $this->load->view('tms/manage_tasks/v_my_comp_tasks.php', $data, TRUE);
        $data['task_html'] = "";
        $this->load->view('tms/manage_tasks/v_template.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function approval_tasks($upper_limit = 0) {
        global $data;
//        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->library("ajax/tms_ajax.php");
        $data['task_search_for'] = "Tasks";
        $data['view_change'] = TRUE;
        $existing_data = array("progress_flag" => COMPLETED_REQUEST);
        $data['task_search_view'] = $this->tms_ajax->task_search($existing_data);
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
//        $data['task_html'] = $this->load->view('tms/manage_tasks/v_my_comp_tasks.php', $data, TRUE);
        $data['task_html'] = "";
        $this->load->view('tms/manage_tasks/v_template.php', $data);
        $this->load->view('templates/footer.php');
    }

    public function edit_task() {
        $formdata = $this->input->post();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
            echo json_encode(array("succ" => TRUE, "link" => base_url() . "tms/manage_tasks/index/" . $formdata['task_id']));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task id passed!!"));
        }
    }

    /*

     * request to close task
     * name has been given by deepak, so I 
     * haven't changed ..      */

    public function close_task() {
        $formdata = $this->input->post();
//        print_r($_FILES);die();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
          $subtask =  $this->m_task->get_first_sub_task($formdata['task_id']);
          $task =  $this->m_task->get_task($formdata['task_id']);
      
      if($subtask['tstm_id']!=''){
         if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $task['tm_code'])) {
            mkdir(SITE_ROOT_PATH . "/uploads/" . $task['tm_code'], 0777, true);
        }
        if (!file_exists(SITE_ROOT_PATH . "/tempuploads/" . $task['tm_code'])) {
            mkdir(SITE_ROOT_PATH . "/tempuploads/" . $task['tm_code'], 0777, true);
        }
        $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $task['tm_code'];
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
        $config['max_size'] = '5120'; // 5MB allowed
        $this->load->library('upload', $config);
        $upload_details['tm_code'] = $task['tm_code'];
        $upload_details['tstm_id'] = $subtask['tstm_id'];


        if (!empty($_FILES['attach_file'])) {

            $cpt = count($_FILES['attach_file']['name']);
            for ($i = 0; $i < $cpt; $i++) {

                if (!$_FILES['attach_file']['size'] || $_FILES['attach_file']['tmp_name'] == "") {
                    continue;
                }
                $uploaded_data[$i]['attach_original_name'] = $_FILES['attach_file']['name'];
                $file_name = str_replace(" ", "", $upload_details['tm_code']) . "_" . $subtask['tstm_id'] . "_" . rand(100, 99999) . "." . pathinfo($_FILES['attach_file']['name'], PATHINFO_EXTENSION);
                $source = SITE_ROOT_PATH . "/uploads/" . $task['tm_code']."/".$file_name;
                $destination = SITE_ROOT_PATH . "/tempuploads/" . $task['tm_code']."/".$file_name;
                $_FILES['temp_document_path']['name'] = $file_name;
                $_FILES['temp_document_path']['type'] = $_FILES['attach_file']['type'];
                $_FILES['temp_document_path']['tmp_name'] = $_FILES['attach_file']['tmp_name'];
                $_FILES['temp_document_path']['error'] = $_FILES['attach_file']['error'];
                $_FILES['temp_document_path']['size'] = $_FILES['attach_file']['size'];
                if (!$this->upload->do_upload('temp_document_path')) {
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("1.Error in uploading Files!")));

                    echo $this->upload->display_errors();
                    die();
                }
                copy($source, $destination);    
                $uploaded_data[$i]['attach_name'] = $file_name;
                $uploaded_data[$i]['link'] = "uploads/" . $upload_details['tm_code'] . "/" . $file_name;
                $uploaded_data[$i]['table_id'] = $subtask['tstm_id'];
                $uploaded_data[$i]['attach_type'] = 2;
                $uploaded_data[$i] = $this->util_model->add_common_fields($uploaded_data[$i]);
            }
            if (!empty($uploaded_data['upload_errors'])) {

                echo json_encode(array("succ" => FALSE, "_err_codes" => array("2.Error in uploading Files!")));
                die();
            }
//                $this->util_model->printr($uploaded_data);
            if (empty($uploaded_data['upload_errors']) && !empty($uploaded_data)) {
                $result2 = $this->m_sub_task->attach_comment_docs($uploaded_data);

                if ($result2['succ'] != TRUE) {
                    //     $this->db->trans_rollback();
                    echo json_encode(array("succ" => FALSE, "_err_codes" => array("Some Error Occured!!")));
                    die();
                }
//                $uploaded_data['attach_id'] = $result['attach_id'];
            }
        }
      }
            echo json_encode($this->m_task->close_task($formdata));
            // mail to director and partner that someone request to close this task
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task passed or it already closed or deleted, ErrorCode #08092016_1226!!"));
        }
    }

    public function notify_action() {
        $form_data = $this->input->get();

        try {
            $client_details = $this->m_task->getClientDetails($form_data['client_id']);
//                $this->util_model->printr($client_details);
            $this->load->model('tms/sms_mail');
            $toEmails = "";
            $taskData = array();

            if (isset($form_data['notify_to_emails']) && !empty($form_data['notify_to_emails'])) {
                $toEmails = implode(",", $form_data['notify_to_emails']);
            }

            if ((isset($form_data['extra_email_to']) && $form_data['extra_email_to'] != '')) {
                $toEmails = $toEmails == "" ? $form_data['extra_email_to'] : $toEmails . "," . $form_data['extra_email_to'];
            }
            $ccEmails = "";
            if ((isset($form_data['extra_email_cc']) && $form_data['extra_email_cc'] != '')) {
                $ccEmails = $form_data['extra_email_cc'];
            }



            $mail_data = array(
                'to' => $toEmails,
                'cc' => CC_MAILS . ", " . $ccEmails,
                'mail_from' => NOTIFY_EMAIL,
                'subject' => $this->filter_variable($form_data['email_subject'], $client_details),
                'message' => $this->filter_variable($form_data['email_body'], $client_details)
            );
            if (isset($form_data['attach_file'])) {
                $mail_data['attach_file'] = $form_data['attach_file'];
            }
//                    $this->util_model->printr($mail_data);
            $this->sms_mail->sendHtmlEmail($mail_data);


            if (isset($form_data['notify_to_mobiles']) && !empty($form_data['notify_to_mobiles'])) {
                $mail_data = array(
                    'mobiles' => implode(",", $form_data['notify_to_mobiles']),
                    'msg' => $this->filter_variable($form_data['sms_body'], $client_details),
                    'client_id' => $client_noti_level['client_id']
                );
//                    $this->util_model->printr($mail_data);
                $this->sms_mail->doSMS($mail_data, 1);
            }

            echo json_encode(array('succ' => TRUE, '_err_codes' => 'Client notified successfully !'));
        } catch (Exception $ex) {
            echo json_encode(array('succ' => FALSE, '_err_codes' => $ex->getMessage()));
        }
        die();
    }

    public function filter_variable($string, $each_client) {
        $string = str_replace("VAR.MONTH", date('m'), $string);
        $string = str_replace("VAR.YEAR", date('Y'), $string);
        $string = str_replace("VAR.CLIENT_NAME", $each_client['Emp_Name'], $string);
        return $string;
    }

    /*

     * it iwll final completed this
     * only director or patner can do this     /
     */

    public function final_close_task() {
        $formdata = $this->input->get();
        // print_r($formdata);die();
        if (isset($formdata['show_email'])) {
            $this->m_task->final_complete_task($formdata);
            $this->notify_action();
        } elseif ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
            echo json_encode($this->m_task->final_complete_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task passed or it already closed or deleted, ErrorCode #08092016_1226!!"));
        }
    }

    /*

     * In case complete request discarded this function will work
     *      */

    public function reopen_task() {
        $formdata = $this->input->post();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
            echo json_encode($this->m_task->reopen_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task id passed!!"));
        }
    }

    public function del_task() {
        $formdata = $this->input->post();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
            echo json_encode($this->m_task->del_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task id passed!!"));
        }
    }

    public function close_sub_task() {
        $formdata = $this->input->post();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_sub_task", array("tstm_id" => $formdata['sub_task_id'])) != "") {
            echo json_encode($this->m_task->close_sub_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid sub task id passed!!"));
        }
    }

    public function del_sub_task() {
        $formdata = $this->input->post();
        if (is_array($formdata['tstm_id']) && in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))) {
            echo json_encode($this->m_task->del_sub_task($formdata));
        } else if ($formdata['tstm_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_sub_task", array("tstm_id" => $formdata['tstm_id'])) != "") {
            echo json_encode($this->m_task->del_sub_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid sub task id passed!!"));
        }
    }

    public function reopen_sub_task() {
        $formdata = $this->input->post();
        if ($formdata['task_id'] != "" && $this->util_model->get_a_column_value("status", DB_PREFIX . "task_mst", array("tm_id" => $formdata['task_id'])) != "") {
            echo json_encode($this->m_task->reopen_sub_task($formdata));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid task id passed!!"));
        }
    }

    public function reassign_sub_task_data() {
        $formdata = $this->input->post();
        echo json_encode($this->m_task->fetch_data_for_reassign_sub_task($formdata));
    }

    public function reassign_sub_task() {
        $formdata = $this->input->post();
//        echo '<pre>';        print_r($formdata);die();
        $result = $this->m_task->reassign_sub_task($formdata);
        if(!isset($formdata['form_type']) && ($formdata['form_type']!='reassign'||$formdata['form_type']!='re-schedule')){
        if ($result['succ']) {
            $this->load->model("tms/m_task_log", 'm_log');
            // from free user i m not sending these two argments
            if (!isset($formdata['old_assignedto'])) {
                $task_data = $this->db->get_where(DB_PREFIX . "task_sub_task", array("tstm_id" => $formdata['tstm_id']))->row_array();
                $formdata['old_assignedto'] = $task_data['assignedto'];
                $formdata['tstm_name'] = $task_data['tstm_name'];
            }
            if (!isset($formdata['assignedto'])) {
                $formdata['assignedto'] = $this->util_model->get_a_column_value("UserName", DB_PREFIX . "employee", array("Emp_ID" => $formdata['old_assignedto']));
            }
            $this->m_log->punch_log(array("log_type" => SUB_TASK_REASSIGNED, "modifier_id" => $this->util_model->get_uid(), "remarks" => "Task Reasssigned from User with user name {$formdata['old_assignedto']} to user id of user {$formdata['assignedto']}!!"));
            $filter_data = array();
            $filter_data['heading'] = array('S.no', 'Task Name', 'Incharge Name', 'Sub-task Name', 'Efforts', 'Work Date', 'Task Start Date', 'Task End Date');
            $filter_data['table_data'] = $this->m_task->info_after_reassign_for_mail_data($formdata);
            $this->load->model("tms/mail/mailer", 'mailer');

            $mailData = array();

            $mailData['to'] = $this->util_model->get_a_column_value("P_Email", DB_PREFIX . "employee", array("Emp_ID" => $formdata['new_assignedto']));
            $mailData['from'] = NOTIFY_EMAIL;
            $mailData['subject'] = "Alert for sub-task reassignment with name " . strtoupper($formdata['tstm_name']) . " by " . $this->util_model->get_uname();
            $formdata['msg'] = "Dear User," . "\n\nA  Sub-task re-assign Alert with named " . strtoupper($formdata['tstm_name']) . " has been assigned to you by " . $this->util_model->get_uname() . "!!"
                    . "<br>Find details below<br>Thanks " . EMAIL_FROM . "<br><br>" . $this->mailer->table_data($filter_data);
            $formdata['heading'] = "";

            $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
            $code_sent = $this->mailer->send_html($mailData);
        }
        }else{
            $gettaskname = $this->gettaskname($filter_data['tstm_id']);
            $arr = array();
            foreach ($gettaskname as $key => $value) :
              $arr[] = $value['tstm_name'];  
            endforeach;
                $tname = implode(",", $arr);
            

            $mailData['to'] = $this->util_model->get_a_column_value("P_Email", DB_PREFIX . "employee", array("Emp_ID" => $formdata['new_assignedto']));
            $mailData['from'] = NOTIFY_EMAIL;
            $mailData['subject'] = "Alert for sub-task reassignment with name " . strtoupper($tname) . " by " . $this->util_model->get_uname();
            $formdata['msg'] = "Dear User," . "\n\nA  Sub-task re-assign Alert with named " . strtoupper($tname) . " has been assigned to you by " . $this->util_model->get_uname() . "!!";
             
            $formdata['heading'] = "";

            $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
            $code_sent = $this->mailer->send_html($mailData);
        }
        echo json_encode($result);
    }

    public function reassign_task() { 
        $formdata = $this->input->post(); 
        // echo '<pre>'; print_r($formdata);die(); 
        $result = $this->m_task->reassign_task($formdata); 
        echo json_encode($result); 
    }



    public function start_repllication() {
        global $data;
        $data['tm_id'] = explode(",", $this->input->get('tm_id'));
        $data['task_list'] = $this->m_task->get_tasks_to_list($data['tm_id']);

        if ($this->input->post()) {

            $form_data = $this->input->post();
//            print_r($form_data);die();
            try {
                $res = $this->m_task->replicate_single_task($form_data);
                if (!$res['succ']) {
                    throw new Exception($res['_err_codes']);
                }
                $res['tm_id'] = $form_data['tm_id'];
                echo json_encode($res);
            } catch (Exception $ex) {
                echo json_encode(array('succ' => FALSE, '_err_codes' => $ex->getMessage(), 'tm_id' => $form_data['tm_id']));
            }

            die();

        }

         $data['list_month'] = $this->m_task->list_month();
        $data['list_year'] = $this->m_task->list_year();
        $data['list_state'] = $this->m_task->list_state();

        $this->load->model('tms/m_manage_users');
        $data['incharge'] = array("0" => "Select Incharge") + $this->m_manage_users->get_users_for_create_task();
//        $this->util_model->printr($form_data);
        $this->load->view('templates/header.php', $data);
        $this->load->view('tms/manage_tasks/start_bulk_replication.php', $data);
        $this->load->view('templates/footer.php');
    }
    public function update_re_task() {
        $formdata = $this->input->post();
        echo '<pre>';        print_r($formdata);die();
    }

    public function send_attachment_mails() {
        $formdata = $this->input->post();
        echo '<pre>';        print_r($formdata['selectattach']);die();
    }

        public function view_file(){
        global $data;
        $record = array();
        if(empty($_GET)){
            $this->db->where(array("status" => 0));
            $query=  $this->db->get('nexgen_attach_file');
        }else{
            $status=$_GET['status'];
            $this->db->where(array("status" => $status));
            $query=  $this->db->get('nexgen_attach_file');
        }
        
        foreach ($query->result() as $row){
            //print_r($row); exit;
            $record[]=array(
                 'id'=>$row->id,
                 'tm_id'=>$row->tm_id,
                 'Emp_Name'=>$this->getemp($row->user_id),
                 'Task'=>$this->gettaskname($row->tm_id),
                 'file'=>$row->file_name,
                 'link'=>$row->link,
                 'state_name'=>$row->state_name,
                 'date'=>$row->date,
                 'status'=>$row->status,
                 'attachment_id'=>$row->attachment_id
            );       
        }
        
//       $query=  $this->db->select('*')
//        ->from('nexgen_attach_file')
//        //->where('nexgen_attach_file.user_id',$data['id'])
//        ->join('nexgen_employee', 'nexgen_employee.Emp_ID = nexgen_attach_file.user_id')
//        ->join('nexgen_task_mst', 'nexgen_task_mst.tm_id = nexgen_attach_file.tm_id')
//        ->get();
        $stts = array();
        $stts[] = 'Unapproved';
        $stts[] = 'Approved';
        $data['locality_list']=$record;
        $data['astatus']=$stts;
        $sql = "SELECT nexgen_task_sub_task.tstm_id,nexgen_task_sub_task.`tstm_name`,nexgen_task_mst.`tm_name` FROM nexgen_task_sub_task INNER JOIN nexgen_task_mst ON nexgen_task_mst.tm_id=nexgen_task_sub_task.`tm_id`";
        $query = $this->db->query($sql);
        $data['clientlist'] = $query->result('array');
        //print_r($data['email_template']); exit;
       // return $query->result_array();
        $this->load->view('templates/header.php',$data);
        $this->load->view('tms/manage_tasks/view_file.php',$data);
        $this->load->view('templates/footer.php');
    }
    
     public function getemp($id){
        $this->db->where('Emp_Id',$id);
        $query=  $this->db->get('nexgen_employee')->row();
        return $query->Emp_Name;
    }
    
     public function gettaskname($id){
        $this->db->where('tm_id',$id);
        $query=  $this->db->get('nexgen_task_mst')->row();
       // print_r($query); exit;
        return $query=array(
            'ttm_name'=>$query->tm_name,
            'month'=>$query->month,
            'year'=>$query->year,
        );
    }

    

    public function approveAll() {

        $formData = $this->input->post();
        //print_r($formData);die();
        if(is_array($formData['tm_id'])){
        if(in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))){
            echo json_encode(array("succ" => $this->m_task->approveAll($formData['tm_id']), "_err_codes" => ''));
        }else{
            echo json_encode(array("succ" => FALSE, "_err_codes" => 'To Close this in bulk, you have to be Director!'));
        }
            
        }
    }





}
