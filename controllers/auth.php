<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  Controller class for authentication purpose
 *  It'll handle all login process, session control, logout..
 *  */

class auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("custom");
    }

    public function Login($error = '') {
//        die("Thanks for visit!");
//        print_r(func_get_args());
        global $data;
        $data['error'] = $error == 1 ? TRUE : FALSE;
        /* Remeber me working */
        $data['Emp_Code'] = $this->util_model->_get_decrypted_cookie('logo');
        $data['Pass'] = $this->util_model->_get_decrypted_cookie('site_name');
        $data['type'] = $this->util_model->_get_decrypted_cookie('site_t');
        $data['login_page_alt'] = $this->util_model->login_page_alt();
        /* End of remember me */
        // To list all the qualification from the database
        $this->load->model('super-admin/usertypes_model');  //loading model
        $data['usertypes'] = $this->usertypes_model->AllUserTypeForSelect(array("UserTypeGroup" => 1)); //calling function of model
        unset($data['usertypes'][1]);
        $data['imgLibrary'] = $this->usertypes_model->getImgLibrary();


        if (!$this->session->userdata('LOGIN_STATUS')) {
            $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
            $this->load->view('auth/login_1', $data);
            $this->load->view('templates/footer_login_page.php', $data);
        } else {
            if (!$this->session->userdata('LOGIN_STATUS') == "Student")
                redirect(base_url() . 'student_dashboard');
            else
                redirect(base_url() . "dashboard");
        }
    }

    public function LoginAuthProcess1() {
        $json = array("succ" => FALSE, "_err_codes" => "Username Passsword Not matched!!", "path" => 'auth/Login/1'); // default path

        $formData = $this->input->get();
        $user_data = array(
            "Emp_Code" => decryptor($formData['salt']),
            "Password" => decryptor($formData['key']),
            "date" => decryptor($formData['token'])
        );

//        $this->util_model->printr($formData);
//        $this->util_model->printr($user_data);
        if ($user_data['date'] != date(DF)) {
            die("Invalid token, please generate again to login");
        }
//        die();
        // If remember me is checked then set cookie
//        if (isset($user_data['remember'])) {
//            $cookie_data = array(array(
//                    'cname' => 'logo',
//                    'cvalue' => $user_data['Emp_Code']
//                ), array(
//                    'cname' => 'site_name',
//                    'cvalue' => $user_data['Password']
//                ), array(
//                    'cname' => 'site_t',
//                    'cvalue' => @$user_data['Type']
//            ));
//            $this->util_model->_set_encrypt_cookie($cookie_data);
//        }
        /*
          If Type is student
         */
//        if ($user_data['Type'] == "Student") {
//            $this->load->model('adm/admission_model');
//            $student_data = $this->admission_model->get_details_from_database_via_enroll($user_data['Emp_Code']);
//            if (!empty($student_data[0])) {
//                $decoded_pass = $this->util_model->decrypt_string($student_data[0]->Pass);
//                if (!$student_data[0]->Can_Login == 1) {
//                    echo "<script>alert('Sorry Please first Activate your account From Admin Department!!')</script>";
//                    echo "<script> location.replace('" . base_url() . $path . "'); </script>";
//                }
//                if ($decoded_pass == $user_data['Password']) {
//                    $this->SessionEstablish_for_student($student_data[0]);
//                    $path = 'student_dashboard/view';
//                }
//            }
//        } else {  // if type is not student
        $this->load->model("emp/employee_model");
        $result = $this->employee_model->auth_details($user_data);

        if ($result['succ']) {
            $this->SessionEstablish($result['emp_details']);
            redirect(base_url());
        } else {
            echo "Invalid Request";
            die();
        }
//        }
        echo json_encode($json);
    }

    public function LoginAuthProcess() {
        $json = array("succ" => FALSE, "_err_codes" => "Username Passsword Not matched!!", "path" => 'auth/Login/1'); // default path
        $user_data = $this->input->post();

//        echo "<pre>";
//        print_r($user_data);
//        exit;
        // If remember me is checked then set cookie
        if (isset($user_data['remember'])) {
            $cookie_data = array(array(
                    'cname' => 'logo',
                    'cvalue' => $user_data['Emp_Code']
                ), array(
                    'cname' => 'site_name',
                    'cvalue' => $user_data['Password']
                ), array(
                    'cname' => 'site_t',
                    'cvalue' => @$user_data['Type']
            ));
            $this->util_model->_set_encrypt_cookie($cookie_data);
        }
        /*
          If Type is student
         */
//        if ($user_data['Type'] == "Student") {
//            $this->load->model('adm/admission_model');
//            $student_data = $this->admission_model->get_details_from_database_via_enroll($user_data['Emp_Code']);
//            if (!empty($student_data[0])) {
//                $decoded_pass = $this->util_model->decrypt_string($student_data[0]->Pass);
//                if (!$student_data[0]->Can_Login == 1) {
//                    echo "<script>alert('Sorry Please first Activate your account From Admin Department!!')</script>";
//                    echo "<script> location.replace('" . base_url() . $path . "'); </script>";
//                }
//                if ($decoded_pass == $user_data['Password']) {
//                    $this->SessionEstablish_for_student($student_data[0]);
//                    $path = 'student_dashboard/view';
//                }
//            }
//        } else {  // if type is not student
        $this->load->model("emp/employee_model");
        $result = $this->employee_model->auth_details($user_data);
        // login log will be punched 
        // in nexgen_login_ips_logs with username

        $this->load->model("ip/m_ip");
        $this->m_ip->punch_login_history(array(
            'Emp_Code' => $user_data['Emp_Code'],
            'system_code' => $user_data['system_code'],
            'succ' => $result['succ']
        ));
        if ($user_data['Emp_Code'] != 'skachhal') {
            if ($result['succ']) {
                //   print_r($user_data['Emp_Code']);die();

                if ($this->m_ip->validateSystemCode($user_data)) {
                    $this->SessionEstablish($result['emp_details']);
                    $json = array("succ" => TRUE, "path" => '');
                } else {
                    // request to admin
                    $json['_err_codes'] = $this->m_ip->get_err_codes();
                }
            }
        } else {
            if ($result['succ']) {
                $this->SessionEstablish($result['emp_details']);
                $json = array("succ" => TRUE, "path" => '');
            }
        }
        echo json_encode($json);
    }

    public function Logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'auth/login');
//Destory the session and call to login function to redirect user on login module !!
    }

    public function SessionEstablish($USER_DATA) {
        try {
            $SESSION_DATA = array(
                "IBMS_USER_ID" => $USER_DATA->Emp_ID,
                "IBMS_USER_ID_NAME" => $USER_DATA->Emp_Name,
                "IBMS_BRANCHID" => $USER_DATA->BranchID,
                "IBMS_USER_TYPE" => $USER_DATA->UTID,
                "IBMS_USER_TYPE_NAME" => $USER_DATA->UserTypeName,
                "IBMS_USER_PRO_PIC" => $USER_DATA->Pro_Pic,
                "LOGIN_STATUS" => TRUE
            );
            $this->session->set_userdata($SESSION_DATA);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo "Error in SessionEstablish !!";
        }
    }

    public function reset_password() {
        $Form_Data = $this->input->post();
        $this->load->model("emp/employee_model");
        echo json_encode($this->employee_model->reset_password($Form_Data));
    }

    public function change_pass($reset_password_code = "") {
        global $data;
        if ($reset_password_code != "") {
            $result = $this->db->select("emp.*")->from(DB_PREFIX . 'employee as emp')->where(array("emp.reset_password_code" => $reset_password_code))->get()->row_array();
            if (!empty($result)) {
                $data['email'] = $result['P_Email'];
                $data['time_limit'] = $result['reset_time_limit'];
                $data['token_mismatch'] = FALSE;
                $data['Invaild_gateway'] = FALSE;
                $data['token'] = $reset_password_code;
            } else {
                $data['token_mismatch'] = TRUE;
            }
        } else {
            $data['Invaild_gateway'] = TRUE;
        }
        $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
        $this->load->view('auth/chnage_pass', $data);
        $this->load->view('templates/footer_login_page.php', $data);
    }

    public function save_new_pass() {
        $Form_Data = $this->input->post();
        if ($Form_Data['token'] != "") {
            $this->load->model("emp/employee_model");
            echo json_encode($this->employee_model->save_new_pass($Form_Data));
        } else {
            echo json_encode(array("succ" => FALSE, "_err_codes" => "Invalid Token passed!!"));
        }
    }

    public function access_forbidden() {
        global $data;
//        $this->load->view("templates/header.php", $data);
        $this->load->view("auth/access_forbidden.php");
//        $this->load->view("templates/footer.php");
    }

    private function SessionEstablish_for_student($USER_DATA) {
        try {
            $SESSION_DATA = array(
                "IBMS_USER_ID" => $USER_DATA->EnrollNo,
                "IBMS_USER_ID_Stu_ID" => $USER_DATA->Stu_ID,
                "IBMS_USER_ID_NAME" => $USER_DATA->StudentName,
                "IBMS_USER_TYPE" => 'Student',
                "LOGIN_STATUS" => TRUE
            );
            $this->session->set_userdata($SESSION_DATA);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo "Error in SessionEstablish !!";
        }
    }

//    public function check_auth() {
//        $data['Session_Data'] = $this->session->all_userdata();
//        if (!$this->session->userdata('LOGIN_STATUS')) {
//            redirect('/auth/login/1/1');
//        }
//    }

    public function checkMachExists() {
        try {


            $user_data = $this->input->get();
            if (!isset($user_data['Emp_Code']) || !isset($user_data['Password']) || !isset($user_data['mac_address'])) {
                throw new Exception("Required parameters are missing!");
            }


//            $this->util_model->printr($result);
            $this->load->model("emp/employee_model");
            $emp_details = $this->employee_model->auth_details($user_data);
//            $this->util_model->printr($emp_details);
            if (isset($emp_details['succ']) && $emp_details['succ'] && isset($emp_details['emp_details'])) {
//                $this->util_model->printr($result['emp_details']);
//                die(); 
                $macAddress = $user_data['mac_address'];
                // checking status
                $sql = "SELECT *  FROM `" . DB_PREFIX . "mac_list` WHERE  mac_address='$macAddress'";
                //`status` = 1 and `approved` = 1 and
                $result = $this->db->query($sql)->row_array();
                if (empty($result)) {
                    $this->db->insert(DB_PREFIX . "mac_list", array(
                        "mac_address" => $user_data['mac_address'],
                        "Add_User" => $emp_details['emp_details']->Emp_ID,
                        "Add_DateTime" => date(DB_DTF)
                    ));
                    if ($this->db->affected_rows()) {
                        throw new Exception("Your server is blacklisted and approval request has been sent to admin!");
                    } else {
                        throw new Exception("Your server is blacklisted and Error while sending approval request to admin!");
                    }
                } else {
                    if ($result['status'] == 0) {
                        throw new Exception("This System has been blacklisted by server!");
                    }
                    if ($result['approved'] == 0) {
                        throw new Exception("This System has been request is pending, please contact to admin to approve it!");
                    }
                }

                // if mac validation crossed then it will happen
                //$this->SessionEstablish($result['emp_details']);

                $json = array("succ" => TRUE, "_err_codes" => "Login Successfully", "login_link" => base_url("auth/LoginAuthProcess?salt=" . encryptor($user_data['Emp_Code']) . "&key=" . encryptor($user_data['Password']) . "&token=" . encryptor(date(DF))));
                echo json_encode($json);
            } else {
                throw new Exception("Sorry username and password incorrect!");
            }
        } catch (Exception $ex) {
            echo json_encode(array("succ" => FALSE, "_err_codes" => $ex->getMessage()));
        }
    }
    
    
     public function upload() {
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model("emp/employee_model");
        $id = $this->input->post('id');
        $time=date('Y-m-d H:i:s');
        $tm=  explode(" ", $time);
        $tm=  explode(":", $tm[1]);
        $filename =  date("Y-m-d")."_".$tm[0]."-".$tm[1]."-".$_FILES['myFile']['name'];
       // $filename =  date("Y-m-d")."_".$_FILES['myFile']['name'];
       // echo $filename; exit;
        $this->load->helper(array('form', 'url'));
        $data = $this->employee_model->get_record($id);
        // print_r($data); exit;
        if (!file_exists(SITE_ROOT_PATH . "/uploads/" . $data['clint_name']."/".$data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'])) {

            // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
            mkdir(SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'], 0777, true);
        }

        $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $data['clint_name']. "/" . $data['state'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] ;
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
        $config['max_size'] = '5120'; // 5MB allowed
        //   //  $config['max_width'] = 1500;
        //   //  $config['max_height'] = 1500;

        $this->load->library('upload', $config);
        $_FILES['temp_document_path']['name'] = $filename;
        $_FILES['temp_document_path']['type'] = $_FILES['myFile']['type'];
        $_FILES['temp_document_path']['tmp_name'] = $_FILES['myFile']['tmp_name'];
        $_FILES['temp_document_path']['error'] = $_FILES['myFile']['error'];
        $_FILES['temp_document_path']['size'] = $_FILES['myFile']['size'];

        if (!$this->upload->do_upload('temp_document_path')) {
            $array = array('error' => $this->upload->display_errors(), 'status' => 500);
        } else {
            $arr = array(
                'user_id' => $this->session->userdata('IBMS_USER_ID'),
                'tm_id' => $id,
                'file_name' => $filename,
                'link' => "/uploads/" . $data['clint_name'] . "/" . $data['state']. "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month']  . "/" . $filename,
                'state_name' => $data['state'],
                'date' => date('Y-m-d H:i:s'),
                'status' => 0
            );

            $this->db->insert('nexgen_attach_file', $arr);

            $array = array('upload_data' => $this->upload->data(), 'status' => 200, 'link' => $arr['link'], 'lid' => $this->db->insert_id());
        }

        echo json_encode($array);
    }

    public function getfile() {
        $id = $this->input->post('id');
        $this->db->where('tm_id', $id);
        $result = $this->db->get('nexgen_attach_file');
        if ($result->num_rows > 0) {
            foreach ($result->result() as $row) {
                $data[] = array(
                    'id' => $row->id,
                    'file_name' => $row->file_name,
                    'link' => $row->link
                );
            }
        } else {
            $data = [];
        }
        echo json_encode($data);
    }

    public function approve() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $data = array(
            'id' => $id,
            'status' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('nexgen_attach_file', $data);
        if ($this->db->affected_rows() > 0) {
            $res = array('status' => 200, 'msg' => 'Update Record Succesfully !');
        } else {
            $res = array('status' => 500, 'msg' => 'Update Record Succesfully');
        }
        echo json_encode($data);
    }

    public function remove() {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('nexgen_attach_file')->row();
        //echo $link = $query->link; exit;
       // $link = explode("/Api/mybridge_code", $link);
        if(file_exists(SITE_ROOT_PATH.$query->link)){
          unlink(SITE_ROOT_PATH . $query->link);
          $this->db->where('id', $id);
           $this->db->delete('nexgen_attach_file');
            if ($this->db->affected_rows() > 0) {
                $res = array('status' => 200, 'msg' => 'Remove Record Succesfully !');
            } else {
                $res = array('status' => 500, 'msg' => 'Record is not remove');
            }  
        }else{
            $res = array('status' => 500, 'msg' => 'File not Exits'); 
        }
        echo json_encode($res);
    }
    
    public function update_file(){
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model("emp/employee_model");
        $id = $this->input->post('id');
        $tmid=$this->input->post('tmid');
        $time=date('Y-m-d H:i:s');
        $tm=  explode(" ", $time);
        $tm=  explode(":", $tm[1]);
        $filename =  date("Y-m-d")."_".$tm[0]."-".$tm[1]."-".$_FILES['myFile']['name'];
        $this->load->helper(array('form', 'url'));
        $data = $this->employee_model->get_record($tmid);
        if (!file_exists(SITE_ROOT_PATH . "'/uploads/" . $data['clint_name'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] . "/" . $data['state'])) {

            // echo "/uploads/" . $formdata['tm_code']."/".$formdata['ttm_id']."/".$formdata['year']."/".$formdata['month']; exit;
            mkdir(SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] . "/" . $data['state'], 0777, true);
        }

        $config['upload_path'] = SITE_ROOT_PATH . "/uploads/" . $data['clint_name'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] . "/" . $data['state'];
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx|xlsx|xls';
        $config['max_size'] = '15360'; // 15MB allowed
        //   //  $config['max_width'] = 1500;
        //   //  $config['max_height'] = 1500;

        $this->load->library('upload', $config);
        $_FILES['temp_document_path']['name'] = trim($filename);
        $_FILES['temp_document_path']['type'] = $_FILES['myFile']['type'];
        $_FILES['temp_document_path']['tmp_name'] = $_FILES['myFile']['tmp_name'];
        $_FILES['temp_document_path']['error'] = $_FILES['myFile']['error'];
        $_FILES['temp_document_path']['size'] = $_FILES['myFile']['size'];

        if (!$this->upload->do_upload('temp_document_path')) {
            $array = array('error' => $this->upload->display_errors(), 'status' => 500);
        } else {
            $arr = array(
                'file_name' => trim($filename),
                'link' => "/Api/mybridge_code/images/" . $data['clint_name'] . "/" . $data['task_code'] . "/" . $data['year'] . "/" . $data['month'] . "/" . $data['state'] . "/" . trim($filename),
            );
            $this->db->where('id', $id);
            $this->db->update('nexgen_attach_file', $arr);
            $array = array('upload_data' => $this->upload->data(), 'status' => 200, 'link' => $arr['link']);
        }

        echo json_encode($array);  
    }


}
