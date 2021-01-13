<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of course
 *
 * @author Mr. Anup
 */
class branch_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * branch_list_with_branch_Cat($head_branch)
     * used by menu/add_menu
     */
    public function branch_list_with_branch_Cat($head_branch=0) {
        if($head_branch){
            $this->db->where("HeadB",1);
        }
        $query = $this->db->select('*')->from("nexgen_branch_mst")->order_by('BranchCode,Bname');
        $result = $query->get()->result();
        $branch_list_with_branch_Cat =array();
        foreach ($result as $value) {
            $branch_list_with_branch_Cat[$value->BranchID] = $value->BranchCode;
        }
        return $branch_list_with_branch_Cat;
    }
//    public function accessed_branches($UTID,$BranchID){
//        $this->db->select("bm.BranchCode,bm.BranchID from ".DB_PREFIX."branch_mst bm");
//        $this->db->join(DB_PREFIX."branch_access ba", "bm.BranchID=ba.BranchID","INNER");
//        $this->db->where(array("ba.BranchID" => $BranchID, "ba.UTID" => $UTID, "ba.Status" => 1, "bm.Status" => 1))->order_by('bm.BranchCode');
//        $result = $this->db->get()->result();
//        
//        
//    }
    
    /*get branch setting

     * @param : BranchID
     * @return : return the all branch setting     */
    function get_branch_setting($BranchID){
//                  $query = $this->db->get_where(DB_PREFIX."branch_settings",array("BranchID"=>$BranchID));
        $this->db->select("bs.*,bm.BranchCode")->from(DB_PREFIX."branch_settings bs");
        $this->db->join(DB_PREFIX."branch_mst bm","bm.BranchID = bs.BranchID");
        $this->db->where("bs.BranchID",$BranchID);
                  $result = $this->db->get()->result();
                  return $result[0];
//                  $this->util_model->printr($result[0]);
    }
    /*get branch details
     * @function get_branch_details($Branch Id) 
     * @param : BranchID
     * @return : return the all branch details 
     * already defined in util_model, that's why commentted over here    */
//     function get_branch_details($BranchID){
//                  $query = $this->db->get_where(DB_PREFIX."branch_mst",array("BranchID"=>$BranchID));
//                  $result = $query->result();
//                  return $result[0];
//    }
    //Get branch data from database(By Prabhu)
    public function get_branch_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "branch_mst", array("bsid" => $id));
        $result = $query->result();
        return $result[0];
    }
   function branch_update($FormData, $id) {
//                 echo $id;
//               die($this->util_model->printr($FormData));
        $this->db->where(array("BranchID" => $id));
        $this->db->update(DB_PREFIX ."branch_mst", $FormData);
        if ($this->db->affected_rows()) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
   }
    //insert new branch details in database(By Prabhu)
    function insert_branch($FormData) {
        $this->load->helper("array");
        $this->db->trans_start();
        $this->db->insert(DB_PREFIX ."branch_mst", $FormData);
        $FormData['BranchID']= $this->db->insert_id();
        $FormData['followup_sms_no']=9467544943;
        $FormData['followup_sms']=1;
        $FormData['followup_emails']=$FormData['Email1'];
        $FormData['Adm_allowed_without_enq']=1;
        $FormData['Service_tax_flag']=1;
        $FormData['Service_tax']=10;
        $FormData['default_fee_type']=4;
        $FormData['agent_joining_fees']=100;
        
        $Formdata = elements(array('BranchID', 'followup_sms', 'followup_sms_no', 'followup_emails', 'follow_up_send_email', 'follow_up_recieve_emailids','sms_sender_id','sms_user_id','sms_password','sms_template','Adm_allowed_without_enq','stu_batch_statusIDs','default_batch_status','Service_tax_flag','Service_tax','default_fee_type','agent_joining_fees'), $FormData, NULL);
        $this->db->insert(DB_PREFIX ."branch_settings", $Formdata);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            
        }
    }
    function get_all_branch(){
        $this->db->select("*")->from(DB_PREFIX."branch_mst");
        return $this->db->get()->result_array();
    }
    function save_notify_setting($formdata){
        $this->db->where("BranchID",$formdata['BranchID']);
        $this->db->update(DB_PREFIX ."branch_settings", $formdata);
//        echo $this->db->last_query();
//        die();
        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}