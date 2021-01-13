<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_menu
 *
 * @author kuldeep
 */
class usertypes_model extends CI_Model {

    //put your code here
    public $dev_id = 1; // ID of devloper usertype
    public function __construct() {
        parent::__construct();
    }

    function add_form_validation($POST) {
        $err_codes = '';
        if (isset($POST['UserTypeName']) && $POST['UserTypeName'] == "") {
            $err_codes.='U_TypeBlank' . ERR_DELIMETER;
        } else {
            if ($this->util_model->get_column_value("Status", DB_PREFIX . 'usertypes', array("UserTypeName" => $POST['UserTypeName']))) {
                $err_codes.='U_TypeDuplicate' . ERR_DELIMETER;
            }
        }

        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }
    function update_form_validation($POST) {
        $err_codes = '';
        if (isset($POST['UserTypeName']) && $POST['UserTypeName'] == "") {
            $err_codes.='U_TypeBlank' . ERR_DELIMETER;
        } 
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    public function AddUserType($FormData) {
        global $data;


        $this->load->helper('array');
        $this->load->model('super-admin/m_menu');
        $validates = $this->add_form_validation($FormData);
        if (!$validates['_err']) {
            return array("succ" => false, "_err_codes" => $validates['_err_codes']);
        }
        $data_to_insert = $FormData;

        // trnx start
        $this->db->trans_begin();

        $this->db->insert(DB_PREFIX . 'usertypes', $data_to_insert);
        $UTID = $this->db->insert_id();
        $all_menu_list = $this->m_menu->all_menu();
        $menu_access_to_insert = array();
        foreach ($all_menu_list as $menu_obj) {
            $menu_access_to_insert[] = array(
                "BranchID" => $this->util_model->get_ubid(),
                "UTID" => $UTID,
                "Add_User" => $FormData['Add_User'],
                "MID" => $menu_obj->MID
            );
        }

        $this->db->insert_batch(DB_PREFIX . "menu_access", $menu_access_to_insert);


        $branch_access = array(
            "UTID" => $UTID,
            "BranchID" => $this->util_model->get_ubid(),
            "AccessBranchID" => $this->util_model->get_ubid()
        );

        $branch_access = array($this->util_model->add_common_fields($branch_access));
        $this->db->insert_batch(DB_PREFIX . "branch_access", $branch_access);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("succ" => false, "_err_codes" => "MAddErr" . ERR_DELIMETER);
        } else {
            $this->db->trans_commit();
            return array("succ" => TRUE, "_err_codes" => "UTAddedSucc");
        }
    }

    public function AllUserTypes($filter_data = array()) {
        if (!isset($filter_data['Status'])) {
            $this->db->where("t1.Status", 1);
        }if (isset($filter_data['Status']) && $filter_data['Status'] == 2) {
            // $this->db->where("t1.Status", $filter_data['Status']);
        } else {
            $this->db->where("t1.Status", 1);
        }
        if(isset($filter_data['developer']) && !$filter_data['developer']){
            $this->db->where("t1.UTID<>".$this->dev_id,NULL,FALSE);
        }
         if(isset($filter_data['UserTypeGroup'])){
            $this->db->where("t1.UserTypeGroup",$filter_data['UserTypeGroup']);
        }
        $this->db->select("t1.UTID,t1.UserTypeName,t1.Status,t1.Sort,t3.Emp_Code as Add_User,t4.Emp_Code as Mode_User,t1.Add_DateTime,t1.Mode_DateTime")->from(DB_PREFIX . "usertypes as t1");
        $this->db->join(DB_PREFIX . "employee t3", "t1.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Mode_User=t4.Emp_ID", 'LEFT');
        $this->db->order_by('Mode_DateTime', "DESC");
        if(isset($filter_data['for_dropdown'])){
            $list  = array();
            $all_ut = $this->db->get()->result();
            foreach ($all_ut as $each_ut) {
                $list[$each_ut->UTID] = $each_ut->UserTypeName;
            }
            return $list;
        }
        return $this->db->get()->result();
    }

    public function AllUserTypeForSelect($filter_data=array()) {
        /*

         * used by 
         * auth/login
         *          */
        if(!empty($filter_data)){
            if(isset($filter_data['UserTypeGroup'])){
                $this->db->where("UserTypeGroup",$filter_data['UserTypeGroup']);
            }
        }
        $this->db->select("UTID,UserTypeName");
        $this->db->from(DB_PREFIX . 'usertypes')->where(array("Status" => 1))->order_by("Sort");
        $UserTypeList = array();
        foreach ($this->db->get()->result_array() as $UT_row) {
            $UserTypeList[$UT_row['UTID']] = $UT_row['UserTypeName'];
        }
        return $UserTypeList;
    }

    public function AllUsers($BranchID = 1, $UTID = 0) {
        $List = array();
        $this->db->select('Emp_ID,Emp_Code,Emp_Name');
        $this->db->from(DB_PREFIX . 'employee');
        $this->db->where(array('Status' => '1'));
        if ($UTID != 0) {
            $this->db->where(array("UTID" => $UTID));
        }
        if ($BranchID != 0) {
            $this->db->where(array('BranchID' => $BranchID));
        }
        foreach ($this->db->get()->result_array() as $User) {

            $List[$User['Emp_ID']] = $User['Emp_Name'] . "({$User['Emp_Code']})";
        }
        return $List;
    }

    public function getImgLibrary() { 
        $this->db->select('filename');
        $this->db->from(DB_PREFIX . 'image_library');
        $this->db->where(array('is_show' => '1')); 
        return $this->db->get()->result_array();
    }

    /*

     *  @model : usertypes_model
     *  @function : get_UserDetail
     *  @param1 utypeid int required
     *  @working: this will fetch detail for edit usertype
     *  @auther: Ankit
     *  @link /      */

    public function get_UserDetail($editUtype) {
        $this->db->select('*');
        $this->db->from(DB_PREFIX . 'usertypes');
        $this->db->where('UTID', $editUtype);
        return $this->db->get()->row_array();
    }

    public function updateUtype($filtered_data) {
        $this->load->helper('array');
        $this->load->model('super-admin/m_menu');
        $validates = $this->update_form_validation($filtered_data);
        if (!$validates['_err']) {
            return array("succ" => false, "_err_codes" => $validates['_err_codes']);
        } else {
            $Update_data = array(
                'UserTypeName' => $filtered_data['UserTypeName'],
                'Status' => $filtered_data['Status'],
                'Sort' => $filtered_data['Sort'],
                'Level' => $filtered_data['Level'],
				'UserTypeGroup' => $filtered_data['UserTypeGroup'],
                'Mode_User' => $filtered_data['Mode_User']
            );
            $this->db->where('UTID', $filtered_data['utid']);
            if ($this->db->update(DB_PREFIX . 'usertypes', $Update_data)) {
                return array("succ" => STATUS_TRUE, "_err_codes" => "UTupdatedSucc");
            } else {
                return array("succ" => STATUS_FALSE, "_err_codes" => "UTUpdateErr" . ERR_DELIMETER);
            }
        }
    }

    public function del_Utype($utype_id) {
        $this->db->where('UTID', $utype_id);
        $succ_res = $this->db->delete(DB_PREFIX . 'usertypes');
        if ($succ_res == 1) {
            return array("succ" => TRUE, "_err_codes" => "UTDeletedSucc" . ERR_DELIMETER);
        } else {
            return array("succ" => FALSE, "_err_codes" => "MDelErr" . ERR_DELIMETER);
        }
    }

	    public function get_group_list() {
        $this->db->select('group_id,group_name');
        $this->db->from(DB_PREFIX .'usertypes_group');
           $res= $this->db->get()->result_array();
		   $arr=array();
foreach($res as $val){
$arr[$val['group_id']]=$val['group_name'];
    }//end foreach

return $arr;


}
}