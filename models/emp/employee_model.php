<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Mr. Anup
 */
class employee_model extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function form_validation($POST) {
        $err_codes = '';
        if (isset($POST['Emp_Code']) && $POST['Emp_Code'] == "") {
            $err_codes .= 'E_CodeBlank' . ERR_DELIMETER;
        }
        if (isset($POST['Emp_Name']) && $POST['Emp_Name'] == "") {
            $err_codes .= 'E_NameBlank' . ERR_DELIMETER;
        }
        if (isset($POST['UserName']) && $POST['UserName'] == "") {
            $err_codes .= 'E_UserNameBlank' . ERR_DELIMETER;
        }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    function employee_save_update($employee_form_data) {
        //($this->util_model->printr($employee_form_data));
        $validates = $this->form_validation($employee_form_data); //validating the form
        die($this->util_model->printr($validates));
        if ($validates['_err_codes'] != "") {
            return array("succ" => false, "_err_codes" => $validates['_err_codes']);
        }
        $this->load->model("upload/file_upload");
        $this->load->helper('file');
        if ($employee_form_data["Add_Employee"] === "Save") {
            $pro_pic = $_FILES['Pro_Pic']['name'];
            $sign = $_FILES['Sign']['name'];
            $Emp_Code = strtoupper($employee_form_data['Emp_Code']);
            if ($pro_pic != "") {
                if (file_exists(EMP_UPLOAD_PATH . $pro_pic)) {
                    unlink(EMP_UPLOAD_PATH . $pro_pic);
                }
                if (move_uploaded_file($_FILES['Pro_Pic']['tmp_name'], EMP_UPLOAD_PATH . $pro_pic)) {
                    $this->file_upload->initial(EMP_UPLOAD_PATH . $pro_pic);
                    $this->file_upload->resizeImage(330, 426, 'auto');
                    if (file_exists(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif")) {
                        unlink(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif");
                    }
                    $this->file_upload->saveImage(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif", 100);
                    unlink(EMP_UPLOAD_PATH . $pro_pic);
                }
            }
            if ($sign != "") {
                if (file_exists(EMP_UPLOAD_PATH . $sign)) {
                    unlink(EMP_UPLOAD_PATH . $sign);
                }
                if (move_uploaded_file($_FILES['Sign']['tmp_name'], EMP_UPLOAD_PATH . $sign)) {
                    $this->file_upload->initial(EMP_UPLOAD_PATH . $sign);
                    $this->file_upload->resizeImage(330, 426, 'auto');
                    if (file_exists(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif")) {
                        unlink(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif");
                    }
                    $this->file_upload->saveImage(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif", 100);
                    unlink(EMP_UPLOAD_PATH . $sign);
                }
            }
            $employee_form_data['Pro_Pic'] = $Emp_Code . "Pro_Pic.gif";
            $employee_form_data['Sign'] = $Emp_Code . "Sign.gif";
//
            $data_to_insert = $this->util_model->unset_array($employee_form_data, array('Add_Employee', 'Password', 'send_on_mail', 'confirmPassword', 'Working_Days', 'Str_Time', 'End_Time'));
            $data_to_insert = $this->util_model->add_common_fields($data_to_insert);
//
            $employee_form_data['Quali'] = isset($employee_form_data['Quali']) ? $employee_form_data['Quali'] : array();
            $data_to_insert['Quali'] = serialize($employee_form_data['Quali']);
            die($this->util_model->printr($data_to_insert));
            //menual transaction started
            $this->db->trans_begin();
            $this->load->helper("array");
            $data_to_insert['Same_address'] = isset($data_to_insert['Same_address']);
            $data_to_insert = elements(array('BranchID', 'UTID', 'Emp_Code', 'P_Email', 'Emp_Pass', 'UserName', 'Emp_Name', 'P_Email_Verified', 'DOJ', 'DOB', 'Salary', 'DID', 'Last_Experi', 'Working_Days', 'Quali', 'Str_Time', 'End_Time', 'FatherName', 'MotherName', 'NID', 'Gender', 'Pro_Pic', 'Sign', 'P_Mob', 'S_Mob', 'P_Phone', 'S_Phone', 'S_Email', 'C_Add', 'C_Locality', 'C_Sub_Locality', 'C_City', 'C_State', 'C_Country', 'C_PinCode', 'Same_address', 'P_Add', 'P_Locality', 'P_Sub_Locality', 'P_City', 'P_State', 'P_Country', 'Add_User', 'Add_DateTime', 'Remarks'), $data_to_insert, NULL);
            $this->db->insert(DB_PREFIX . "employee", $data_to_insert);
            $employee_form_data['element_id'] = $this->db->insert_id();
            $this->load->model("time_manage/m_time_manage");
            $this->m_time_manage->insert_timing($employee_form_data);
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                return array("succ" => TRUE, "_err_codes" => "Emp_AddSucc");
            } else {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => "Emp_AddErr" . ERR_DELIMETER);
            }
        } else if ($employee_form_data["Add_Employee"] === "Update") {
            $pro_pic = $_FILES['Pro_Pic']['name'];
            $sign = $_FILES['Sign']['name'];
            $Emp_Code = strtoupper($employee_form_data['Emp_Code']);
//
            $old_emp_details = $this->get_emp_details_via_emp_id($employee_form_data['Emp_ID']);
            //print_r($old_emp_details);
            $old_Pro_Pic = $old_emp_details->Pro_Pic;
            $old_Sign = $old_emp_details->Sign;
            if ($pro_pic != "") {
                if (file_exists(EMP_UPLOAD_PATH . $old_Pro_Pic)) {
                    unlink(EMP_UPLOAD_PATH . $old_Pro_Pic);
                }
                if (move_uploaded_file($_FILES['Pro_Pic']['tmp_name'], EMP_UPLOAD_PATH . $pro_pic)) {
                    $this->file_upload->initial(EMP_UPLOAD_PATH . $pro_pic);
                    $this->file_upload->resizeImage(330, 426, 'auto');
                    if (file_exists(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif")) {
                        unlink(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif");
                    }
                    $this->file_upload->saveImage(EMP_UPLOAD_PATH . $Emp_Code . "Pro_Pic.gif", 100);
                    unlink(EMP_UPLOAD_PATH . $pro_pic);
                }
            }
            if ($sign != "") {
                if (file_exists(EMP_UPLOAD_PATH . $old_Sign)) {
                    unlink(EMP_UPLOAD_PATH . $old_Sign);
                }
                if (move_uploaded_file($_FILES['Sign']['tmp_name'], EMP_UPLOAD_PATH . $sign)) {
                    $this->file_upload->initial(EMP_UPLOAD_PATH . $sign);
                    $this->file_upload->resizeImage(330, 426, 'auto');
                    if (file_exists(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif")) {
                        unlink(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif");
                    }
                    $this->file_upload->saveImage(EMP_UPLOAD_PATH . $Emp_Code . "Sign.gif", 100);
                    unlink(EMP_UPLOAD_PATH . $sign);
                }
            }
            $employee_form_data['Pro_Pic'] = $Emp_Code . "Pro_Pic.gif";
            $employee_form_data['Sign'] = $Emp_Code . "Sign.gif";
            $this->load->helper("array");
//
            $employee_form_data['Same_address'] = isset($employee_form_data['Same_address']);
            $data_to_update = elements(array('BranchID', 'UTID', 'Emp_Code', 'P_Email', 'UserName', 'Emp_Name', 'DOJ', 'DOB', 'Salary', 'DID', 'Last_Experi', 'Working_Days', 'Quali', 'Str_Time', 'End_Time', 'FatherName', 'MotherName', 'NID', 'Gender', 'Pro_Pic', 'Sign', 'P_Mob', 'S_Mob', 'P_Phone', 'S_Phone', 'S_Email', 'C_Add', 'C_Locality', 'C_Sub_Locality', 'C_City', 'C_State', 'C_Country', 'C_PinCode', 'Same_address', 'P_Add', 'P_Locality', 'P_Sub_Locality', 'P_City', 'P_State', 'P_Country', 'Mode_User', 'Remarks'), $employee_form_data, NULL);
//                                         $this->util_model->printr($employee_form_data);
//                                                       die($this->util_model->printr($data_to_update));
//
            if ($this->db->update(DB_PREFIX . 'employee', $data_to_update, array('Emp_ID' => $employee_form_data['Emp_ID']))) {
                $employee_form_data['element_id'] = $employee_form_data['Emp_ID'];
//
                $this->load->model("time_manage/m_time_manage");
                $this->m_time_manage->insert_timing($employee_form_data);
                return array("succ" => TRUE, "Emp_Code" => $employee_form_data['Emp_Code']);
            } else {
                return array("succ" => TRUE, "Emp_Code" => $employee_form_data['Emp_Code']);
            }
        }
    }

//
    public function update_emp($Emp_Code, $data_to_update) {
        if ($this->db->update(DB_PREFIX . 'employee', $data_to_update, array('Emp_Code' => $Emp_Code))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_emp_via_id($Emp_ID, $data_to_update) {
        if ($this->db->update(DB_PREFIX . 'employee', $data_to_update, array('Emp_ID' => $Emp_ID))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function auth_details($user_data) {
        $sql = "SELECT emp.*,ut.UserTypeName FROM " . DB_PREFIX . "employee as emp LEFT JOIN " . DB_PREFIX . "usertypes as ut ON emp.UTID=ut.UTID WHERE  (emp.Emp_Code='{$user_data['Emp_Code']}' or emp.UserName='{$user_data['Emp_Code']}' or emp.P_Email='{$user_data['Emp_Code']}') and emp.Status=1";
        $query = $this->db->query($sql);
//                           die($this->db->last_query());
        $result = $query->result();
        if (count($result) > 0) {
             //          echo $this->util_model->decrypt_string($result[0]->Emp_Pass);
//           echo $user_data['Password'];
//           die();
            if ($user_data['Password'] == $this->util_model->decrypt_string($result[0]->Emp_Pass)) {
                return array("succ" => TRUE, "emp_details" => $result[0]);
            } else {
                return array("succ" => FALSE);
            }
        } else {
            return array("succ" => FALSE);
        }
//
////emp_details
    }

    public function get_emp_details_from_database($Emp_Code = '', $UTID = 0, $DID = 0) {
        $Emp_Code = trim($Emp_Code);
        $where = array();
        if ($Emp_Code != '')
            $where['emp.Emp_Code'] = $Emp_Code;
        if ($UTID != 0) {
            $where['emp.UTID'] = $UTID;
        }
        if ($DID != 0) {
            $where['emp.DID'] = $DID;
        }
        $this->db->select("emp.*,t3.Emp_Code as Add_UserCode,d.Name as Designation, n.Name as Nationality  from " . DB_PREFIX . "employee emp");
        $this->db->join(DB_PREFIX . "employee t3", "emp.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "designation d", "emp.DID=d.DID", 'LEFT');
        $this->db->join(DB_PREFIX . "nationality n", "emp.NID=n.NID", 'LEFT');
        $this->db->where($where);
        $query = $this->db->get();
//                           echo $this->db->last_query();
        if ($this->db->count_all_results() > 0) {
            if ($Emp_Code != '') {
                $emp_details = $query->first_row();
                return $emp_details; //sending first row
            } else {
                return $query->result();
            }
        } else {
            return FALSE;
        }
//       $Emp_Code = trim($Emp_Code);
//       if (!$only_faculty) {
//           $DesgType = $this->input->post('Type');
//           $query = $this->db->get_where('nexgen_employee', array("Emp_Code" => $Emp_Code, "DID" => $DesgType));
//           if ($this->db->count_all_results() > 0) {
//               $emp_details = $query->first_row();
//               return $emp_details; //sending first row
//           } else {
//               return FALSE;
//           }
//       } else {
//           $query = $this->db->get_where('nexgen_employee', array("Designation" => "Faculty"));
//           $result = $query->result();
//           $Emp_list_with_Emp_Cat = array("<-- Select Faculty Code -->" => "<-- Select Faculty Code -->");
//           foreach ($result as $value) {
//               $Emp_list_with_Emp_Cat[$value->Emp_Code] = $value->Emp_Code;
//           }
//           return $Emp_list_with_Emp_Cat;
//       }
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
        $this->db->where('P_Email', $Form_Data['reset_email']);
        $this->db->select('P_Email,UserName,Emp_ID')->from(DB_PREFIX . 'employee');
        $query = $this->db->get()->row_array();
        if (isset($query['P_Email'])) {
//
            $reset_password_code = $query['UserName'] . uniqid();
            $Reset_Data = array('reset_password_code' => $reset_password_code, "reset_time_limit" => date(ADD_DTF, time()));
//
            $this->db->where("P_Email", $Form_Data['reset_email']);
            $this->db->update(DB_PREFIX . 'employee', $Reset_Data);
            if ($this->db->affected_rows() > 0) {
//
                /* send mail confirmation email to user's mail
                 */
                $this->load->model("tms/mail/mailer", 'mailer');
                $mailData = array();
                $mailData['to'] = $Form_Data['reset_email'];
                $mailData['sender_email'] = $Form_Data['reset_email'];
                $mailData['from'] = NOTIFY_EMAIL;
                $mailData['subject'] = "Password reset link of " . EMAIL_FROM;
                $formdata['msg'] = "Dear " . $query['UserName'] . ",\n\nAs per your request to send new password for " . EMAIL_FROM . ", we are sending you same, Please click on the reset password link.\n\n"
                        . "below to generate new password. Also rembember you have only 24 hrs to reset your password, Atfer that this link will expire.\n"
                        . "<a style='font-family: verdana;color: blue;text-decoration: none;font-size: 13px;font-weight: 300;' href=" . base_url() . "tms/auth/change_pass" . "/" . $reset_password_code . ">Reset Password</a>"
                        . "<br>Thanks\n";
//               $formdata['heading'] = "Password Reset Link !!";
                $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
//               $code_sent = $this->mailer->send_html($mailData);
                if ($this->mailer->send_html($mailData)) {
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

    public function validate_new_pass($Form_Data) {
        $err_codes = array();
        if ($Form_Data['Emp_Pass'] == "") {
            $err_codes[] = "Password Cannot Be blank";
        }
        if ((strlen($Form_Data['Emp_Pass']) < 3)) {
            $err_codes[] = "Password cannot Be less than 3 Characters";
        }
        if (time() > strtotime('+24hour', strtotime($Form_Data['time_limit']))) {
            $err_codes[] = "Password reset time limit exceeded, Reset again to change Password!!";
        }
        if (empty($err_codes)) {
            return array("succ" => TRUE, "_err_codes" => "");
        } else {
            return array("succ" => FALSE, "_err_codes" => $err_codes);
        }
    }

    public function save_new_pass($filter_data) {
        $validate = $this->validate_new_pass($filter_data);
        if (!empty($validate['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
        } else {
            $encrypt_pass = $this->util_model->encrypt_string($filter_data['Emp_Pass']);

            $this->db->where(array("reset_password_code" => $filter_data['token']));
            $this->db->update(DB_PREFIX . 'employee', array("reset_password_code" => "", "Emp_Pass" => $encrypt_pass));

            if ($this->db->affected_rows() > 0) {
                /* send mail confirmation email to user's mail
                 */
                $this->load->model("tms/mail/mailer", 'mailer');
                $mailData = array();
                $mailData['to'] = $filter_data['P_Email'];
                $mailData['from'] = NOTIFY_EMAIL;
                $mailData['subject'] = "Password Change for NexIBMS Account!!";
                $formdata['msg'] = "Dear User,\n\nThe password for your NexIBMS was changed Recently. If this wasn't you report to admin. Keep Your password safe and secure.\n\n"
                        . "\n\n\nThanks\n";
                $formdata['heading'] = "Password Changed!!";
                $mailData['message'] = $this->load->view("tms/mail_template/template", $formdata, TRUE);
                $code_sent = $this->mailer->send_html($mailData);
                if ($code_sent) {
                    return array(
                        "succ" => TRUE,
                        "_err_codes" => "Password Changed. Login to proceed!"
                    );
                }
            } else {
                return array("succ" => FALSE, "_err_codes" => "Some Error Occured, Try Again!!");
            }
        }
    }

    public function update_user_data($filter_data) {
        $this->db->where(array("Emp_ID" => $this->util_model->get_uid()));
        $this->db->update(DB_PREFIX . 'employee', $filter_data);

        if ($this->db->affected_rows() > 0) {
            return array("succ" => TRUE, "_err_codes" => "Data Updated");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Error Occured while updating data");
        }
    }
    
    
    public function get_record($id){
       $this->db->where('tm_id', $id);
       $r1=$this->db->get('nexgen_task_mst')->row();
      
       $this->db->where('ttm_id',$r1->ttm_id);
       $r2=  $this->db->get('nexgen_task_type_mst')->row();
       
       $this->db->where('state_id',$r1->state_id);
       $r3=  $this->db->get('nexgen_cstates')->row();
       
       $this->db->where('Emp_ID',$r1->client_id);
       $r4=  $this->db->get('nexgen_employee')->row();
       
       $date1=$r1->year;
       $date2=$r1->year+1;

       $date3=$date1."-".$date2;

       $task_code=$r2->ttm_code;

       $state_name=$r3->name;
       $client_name=$r4->UserName;

       $data=array(
           'clint_name'=>$client_name,
           'task_code'=>$task_code,
           'year'=>$date3,
           'month'=> $r1->month,
           'state'=>$state_name,
       );
      // print_r($data); exit;
       return $data;
    }
    
    
       public function get__subtask_record($id,$cid){
       $this->db->where('tstm_id', $id);
       $r1=$this->db->get('nexgen_task_sub_task')->row();
      
       $this->db->where('tm_id',$r1->tm_id);
       $r2=  $this->db->get('nexgen_task_mst')->row();
       
       $this->db->where('ttm_id',$r2->ttm_id);
       $taskcode=  $this->db->get('nexgen_task_type_mst')->row();
       
       $this->db->where('state_id',$r2->state_id);
       $r3=  $this->db->get('nexgen_cstates')->row();
       
       $this->db->where('Emp_ID',$cid);
       $r4=  $this->db->get('nexgen_employee')->row();
       
       
      // $date2=$r1->year+1;

     //  $date3=$date1."-".$date2;

      // $task_code=$r2->tm_code;

       $state_name=$r3->name;
       $client_name=$r4->UserName;

       $data=array(
           'clint_name'=>$client_name,
           'task_code'=>$taskcode->ttm_code,
           'year'=>$r2->year,
           'month'=> $r2->month,
           'state'=>$state_name,
       );
       //print_r($id); exit;
       return $data;
    }


}
