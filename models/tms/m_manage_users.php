<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_manage_users
 *
 * @author Mr. Anup
 */
class m_manage_users extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function add_emp_form_validation($POST) {
        $err_codes = '';
        if (isset($POST['Emp_Name']) && $POST['Emp_Name'] == "") {
            $err_codes.='E_NameBlank' . ERR_DELIMETER;
        }
        if (isset($POST['P_Email']) && $POST['P_Email'] == "") {
            $err_codes.='P_emailBlank' . ERR_DELIMETER;
        }
        if (isset($POST['UserName']) && $POST['UserName'] == "") {
            $err_codes.='E_UserNameBlank' . ERR_DELIMETER;
        }
        if (isset($POST['UserName'])) {
            $whr = array("UserName" => $POST['UserName']);
            $st = $this->util_model->get_column_value('Status', DB_PREFIX . 'employee', $whr);
            if ($st == 1) {
                $err_codes.='dublicate_UName' . ERR_DELIMETER;
            }
        }
        if (isset($POST['send_on_mail']) && !$POST['send_on_mail']) {
            if (isset($POST['Password']) && $POST['Password'] == "") {
                $err_codes.='E_PassBlank' . ERR_DELIMETER;
            }
            if (isset($POST['confirmPassword']) && $POST['confirmPassword'] == "") {
                $err_codes.='E_CnfPassBlank' . ERR_DELIMETER;
            }
        }
        //  die($this->util_model->printr($err_codes));
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    function user_save_update($filter_data) {
//       die($this->util_model->printr($filter_data));
        if(isset($filter_data['Emp_Pass'])){
            $filter_data['Emp_Pass'] = $this->util_model->encrypt_string($filter_data['Emp_Pass']);
        }
        if ($filter_data["Add_Employee"] === "Create") {
            $validates = $this->add_emp_form_validation($filter_data); // validating the form
            // die($this->util_model->printr($validates));
            if ($validates['_err_codes'] != "") {
                return array("succ" => false, "_err_codes" => $validates['_err_codes']);
            }
            $data_to_insert = $this->util_model->add_common_fields($filter_data);
            $this->load->helper("array");
            $data_to_insert = elements(array('Emp_Pass','gst_no','po_no','BranchID', 'UTID', 'Emp_Code', 'P_Email', 'Emp_Pass', 'UserName', 'Emp_Name', 'P_Email_Verified', 'DOJ', 'DOB', 'Salary', 'DID', 'Last_Experi', 'Working_Days', 'Quali', 'Str_Time', 'End_Time', 'FatherName', 'MotherName', 'NID', 'Gender', 'Pro_Pic', 'Sign', 'P_Mob', 'S_Mob', 'P_Phone', 'S_Phone', 'S_Email', 'C_Add', 'C_Locality', 'C_Sub_Locality', 'C_City', 'C_State', 'C_Country', 'C_PinCode', 'Same_address', 'P_Add', 'P_Locality', 'P_Sub_Locality', 'P_City', 'P_State', 'P_Country', 'Add_User', 'Add_DateTime', 'Remarks','client_billing_add1','client_billing_add2','client_billing_name'), $data_to_insert, NULL);
            $this->db->insert(DB_PREFIX . "employee", $data_to_insert);
            if ($this->db->affected_rows()) {
                return array("succ" => TRUE, "_err_codes" => "Emp_AddSucc");
            } else {
                return array("succ" => FALSE, "_err_codes" => "Emp_AddErr" . ERR_DELIMETER);
            }
        } else if ($filter_data["Add_Employee"] === "Update") {
            //    $this->util_model->printr($filter_data);
//            $old_emp_details = $this->get_emp_details_via_emp_id($filter_data['Emp_ID']);
            $this->load->helper("array");
            $data_to_update = $this->util_model->add_mode_user($filter_data);
            $data_to_update = elements(array('Emp_Pass','gst_no','po_no',"UserName","Status",'BranchID', 'UTID', 'Emp_Code', 'P_Email', 'UserName', 'Emp_Name', 'DOJ', 'DOB', 'Salary', 'DID', 'Last_Experi', 'Working_Days', 'Quali', 'Str_Time', 'End_Time', 'FatherName', 'MotherName', 'NID', 'Gender', 'Pro_Pic', 'Sign', 'P_Mob', 'S_Mob', 'P_Phone', 'S_Phone', 'S_Email', 'C_Add', 'C_Locality', 'C_Sub_Locality', 'C_City', 'C_State', 'C_Country', 'C_PinCode', 'Same_address', 'P_Add', 'P_Locality', 'P_Sub_Locality', 'P_City', 'P_State', 'P_Country', 'Mode_User', 'Remarks','client_billing_add1','client_billing_add2','client_billing_name'), $filter_data, NULL);
            //   $this->util_model->printr($data_to_update);                           
            if ($this->db->update(DB_PREFIX . 'employee', $data_to_update, array('Emp_ID' => $filter_data['Emp_ID']))) {
                return array("succ" => TRUE, "UserName" => $filter_data['UserName']);
            } else {
                return array("succ" => FALSE, "UserName" => $filter_data['UserName']);
            }
        }
    }

    public function update_emp($UserName, $data_to_update) {
        if ($this->db->update(DB_PREFIX . 'employee', $data_to_update, array('UserName' => $UserName))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function auth_details($user_data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "employee WHERE  (Emp_Code='{$user_data['Emp_Code']}' or UserName='{$user_data['Emp_Code']}' or P_Email='{$user_data['Emp_Code']}') and UTID={$user_data['Type']} and Status=1";
        $query = $this->db->query($sql);
//                            die($this->db->last_query());
        $result = $query->result();
        if (count($result) > 0) {
            if ($user_data['Password'] == $this->util_model->decrypt_string($result[0]->Emp_Pass))
                return array("succ" => TRUE, "emp_details" => $result[0]);
        }else {
            return array("succ" => FALSE);
        }

//emp_details
    }

    public function getUsers($filter_data = "") {

        if (!empty($filter_data)) {

            if (isset($filter_data['usertype']) && $filter_data['usertype'] && !is_array($filter_data['usertype'])) {
                $this->db->where("ut.UTID={$filter_data['usertype']} ", NULL, FALSE);
            } else {
                $this->db->where_in("ut.UTID", $filter_data['usertype']);
            }

            if (isset($filter_data['limit'])) {
                $this->db->limit($filter_data['limit'], 0);
            }
            if (isset($filter_data['order_by'])) {
                $this->db->order_by("emp.Mode_DateTime", $filter_data['order_by']);
            }
        }



        $this->db->select("emp.*,ut.UserTypeName,t3.UserName as Add_UserCode,d.Name as Designation, n.Name as Nationality  from " . DB_PREFIX . "employee emp");
        $this->db->join(DB_PREFIX . "employee t3", "emp.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "designation d", "emp.DID=d.DID", 'LEFT');
        $this->db->join(DB_PREFIX . "usertypes ut", "ut.UTID=emp.UTID", 'LEFT');
        $this->db->join(DB_PREFIX . "nationality n", "emp.NID=n.NID", 'LEFT');
//        $this->db->join(DB_PREFIX . "nationality n", "emp.NID=n.NID", 'LEFT');
    
        $Clientlist = $this->db->get()->result();

        // echo $this->db->last_query();
        return $Clientlist;
    }

    public function get_emp_details_from_database($Emp_ID = '', $UTID = 0, $DID = 0, $extra_whr = "") {
        $where = array();
        if ($Emp_ID != '')
            $where['emp.Emp_ID'] = $Emp_ID;
        if ($UTID != 0) {
            $where ['emp.UTID'] = $UTID;
        }

        //  die($this->util_model->printr($UTID));
        if ($DID != 0) {
            $where['emp.DID'] = $DID;
        }
        $this->db->select("emp.*,ut.UserTypeName,t3.UserName as Add_UserCode,d.Name as Designation, n.Name as Nationality  from " . DB_PREFIX . "employee emp");
        $this->db->join(DB_PREFIX . "employee t3", "emp.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "designation d", "emp.DID=d.DID", 'LEFT');
        $this->db->join(DB_PREFIX . "usertypes ut", "ut.UTID=emp.UTID", 'LEFT');
        $this->db->join(DB_PREFIX . "nationality n", "emp.NID=n.NID", 'LEFT');
        $this->db->where($where);
        //if ($UTID != 0) {
        $utype_id = $this->util_model->get_utype();
        // die($this->util_model->printr($utype_id));
        $this->db->where("ut.level >=(select level from " . DB_PREFIX . "usertypes where UTID=$utype_id)", NULL, FALSE);
        //}
        if ($extra_whr != "") {
            $this->db->where($extra_whr, NULL, FALSE);
            //    
        }
        $this->db->order_by("emp.Mode_DateTime", "DESC");
        $query = $this->db->get();
        //  echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            if ($Emp_ID != '') {
                $emp_details = $query->first_row();
                return $emp_details; //sending first row
            } else {
                return $query->result();
            }
        } else {
            return FALSE;
        }
    }
    public function getEmplist($filter_data) {
        $filter_data['page'] = isset($filter_data['page']) ? $filter_data['page'] : 0;
        if (isset($filter_data['limit']) && $filter_data['limit'] != 0) {
            $this->db->limit($filter_data['limit'], $filter_data['page']);
        }
        if (isset($filter_data['search']) && $filter_data['search'] != "") {
            $this->db->where("emp.Emp_Name LIKE '%" . $filter_data['search'] . "%'", NULL, FALSE);
        }
      
        $this->db->select("emp.*,ut.UserTypeName,t3.UserName as Add_UserCode,d.Name as Designation, n.Name as Nationality  from " . DB_PREFIX . "employee emp");
        $this->db->join(DB_PREFIX . "employee t3", "emp.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "designation d", "emp.DID=d.DID", 'LEFT');
        $this->db->join(DB_PREFIX . "usertypes ut", "ut.UTID=emp.UTID", 'LEFT');
        $this->db->join(DB_PREFIX . "nationality n", "emp.NID=n.NID", 'LEFT');
      
        //if ($UTID != 0) {
        $utype_id = $this->util_model->get_utype();
        // die($this->util_model->printr($utype_id));
        $this->db->where("ut.level >=(select level from " . DB_PREFIX . "usertypes where UTID=$utype_id)", NULL, FALSE);
        //}
     
            $this->db->where("ut.UserTypeGroup = 1", NULL, FALSE);
            //    
    
        $this->db->order_by("emp.Mode_DateTime", "DESC");
        $query = $this->db->get();
        //  echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
          
                return $query->result();
            
        } else {
            return FALSE;
        }
    }
    public function deactiveuser($formdata) {
        $this->db->where_in('Emp_ID',$formdata['emp_id']);
         if ($this->db->update(DB_PREFIX . 'employee', array('status' => 0))) {
                return array("succ" => TRUE);
            } else {
                return array("succ" => FALSE);
            }
    }

    public function pass_on_mail($filter_data, $password) {
        $this->load->model("tms/mail/mailer", 'mailer');
        $mailData = array();
        $mailData['to'] = $filter_data['P_Email'];
        $mailData['from'] = NOTIFY_EMAIL;
        $mailData['from_name'] = EMAIL_FROM;
        $mailData['subject'] = "Password for your " . EMAIL_FROM . " Account. ";
        $formdata['sender_email'] = $filter_data['P_Email'];
        $formdata['msg'] = "Dear  " . ucfirst($filter_data["Emp_Name"]) . "," . "<br>Please use following details for login"
                . "<br>Username : {$filter_data["UserName"]} <br>Password: " . $password . ""
                . "<br>"
                . "<a href='" . base_url() . "'>Click here to login</a><br><br>Thanks " . EMAIL_FROM;
        $formdata['heading'] = "Welcome {$filter_data["UserName"]} in " . EMAIL_FROM;
        $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
        return $this->mailer->send_html($mailData);
    }

    public function get_emp_details_via_emp_id($Emp_ID) {
        $query = $this->db->get_where(DB_PREFIX . 'employee', array("Emp_ID" => $Emp_ID));
        $result = $query->result();
        if (!empty($result))
            return $result[0];
        else
            return FALSE;
    }

    public function get_all_details_from_database() {
        $query = $this->db->select('emp.*')->from(DB_PREFIX . "employee emp");
        $this->db->join(DB_PREFIX . "employee t3", "emp.Add_User=t3.Emp_ID", 'LEFT');
        $all_emp_details = $query->result();
        return $all_emp_details; //sending first row
    }

    public function reset_password($Form_Data) {
        $this->load->model('mail/mailer');
        $this->db->where('P_Email', $Form_Data['reset_email']);
        $this->db->select('P_Email,UserName,Emp_ID')->from(DB_PREFIX . 'employee');
        $query = $this->db->get()->row_array();
        if (isset($query['P_Email'])) {

            $new_pass = mt_rand(100000, 999999);
            $Reset_Data = array('Emp_Pass' => $this->util_model->encrypt_string($new_pass));

            $this->db->where("P_Email", $Form_Data['reset_email']);
            $this->db->update(DB_PREFIX . 'employee', $Reset_Data);
            if ($this->db->affected_rows()) {

                /* send mail confirmation email to user's mail
                 */
                $mailData = array();
                $mailData['to'] = $Form_Data['reset_email'];
                $mailData['from'] = 'account@nexibms.in';
                $mailData['subject'] = "New Password for Login of NexIBMS";
                $mailData['message'] = "Dear " . $query['UserName'] . ",\n\nAs per your request to send new password for NexIBMS, we are sending you same, please login with this new password to get access to your account.\n\n"
                        . "Username: " . $query['UserName'] . "\nNew Password: " . $new_pass . "\n\n\nThanks\n";

                if ($this->mailer->send_mail($mailData)) {

                    return array(
                        "succ" => TRUE,
                        "_err_codes" => "Password Reset. Check Mail!"
                    );
                }
            }
        } else {
            return array(
                "succ" => FALSE,
                "_err_codes" => "Error, Specified User doesn't exist");
        }
    }

    public function get_usertype() {
        $data['user_types'] = $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes", 0, "UserTypeName", TRUE, 1, " UserTypeGroup=2");
        unset($data['user_types'][1]);
        //die($this->util_model->printr($r));
    }

    public function get_all_clients($filter_data = array()) {
        if (!empty($filter_data)) {
            
        }
        $this->db->where(array("status" => 1));
        $query = $this->db->select('emp.Emp_ID,emp.Emp_Name')->from(DB_PREFIX . "employee emp")->order_by("emp.Emp_Name");
        $this->db->where("UTID in (select u.UTID  from " . DB_PREFIX . "usertypes u where u.UserTypeGroup=2)", NULL, FALSE);
        if(isset($filter_data['min_one_task'])){
            $this->db->where('(select count(*) from nexgen_task_mst tm where tm.client_id=emp.Emp_ID)',NULL,FALSE);
        }
        $result = $query->get()->result();
//        echo $this->db->last_query();
        $return_list = array(""=>"--Select--");
        foreach ($result as $value) {
            $return_list[$value->Emp_ID] = $value->Emp_Name;
        }
        return $return_list;
    }

    /*

     * user for create task     
     */

    public function get_users_for_create_task($filter_data = array()) {
        //$this->util_model->get_list("Emp_ID", "Emp_Name", DB_PREFIX . "employee", 0, "Emp_Name", TRUE, 1, " UTID not in(".DEVELOPER.")"); 
        /*

         * UserTypeGroup 
         * 1 normal uesrs
         * 2 client
         * 3 develoer         */
//        $this->db->where("emp.UTID not in(".DEVELOPER.")",NULL,FALSE); 
        $this->db->where(array("emp.status" => 1));
        $query = $this->db->select('emp.Emp_ID,emp.P_Email,emp.Emp_Name, u.UserTypeName')->from(DB_PREFIX . "employee emp")->order_by("emp.Emp_Name");
        $this->db->join(DB_PREFIX . "usertypes u", "u.UTID=emp.UTID", "inner");
        $this->db->where("u.UserTypeGroup", 1);
//        $this->db->where("UTID in (select u.UTID  from ".DB_PREFIX."usertypes u where u.UserTypeGroup=1)", NULL, FALSE);
        $result = $query->get()->result();
//        echo $this->db->last_query();
        $return_list = array();
        foreach ($result as $value) {
            $return_list[$value->Emp_ID] = $value->Emp_Name . "({$value->P_Email})";
        }
        return $return_list;
    }

    /*

     * it will return the client list those task has been completed and bill is pending to create */

    public function get_unbilled_clients() {
        $this->db->select("emp.Emp_ID,emp.Emp_Name")->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "employee as emp", "emp.Emp_ID=tm.client_id", 'left');
        $this->db->group_by("tm.client_id");
        $this->db->where(array("progress_flag" => COMPLETED_APPROVAL, "BillingDone" => 0));
        $result = $this->db->get()->result_array();
       
        $final_data = array("0" => "Select Client");
        if (!empty($result)) {
            foreach ($result as $value) {
                $final_data[$value['Emp_ID']] = $value['Emp_Name'];
            }
        }
        return $final_data;
        
    }

}
