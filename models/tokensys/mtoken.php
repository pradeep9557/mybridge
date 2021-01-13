<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mtoken
 *
 * @author NexGen Development Team
 */
class mtoken extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function insert_token($FormData) {
        if ($this->db->insert(DB_PREFIX . "tokening_sys", $FormData)) {
            return array("succ" => TRUE,"token_id"=>$this->db->insert_id());
        } else {
            return array("succ" => FALSE);
        }
    }
    function insert_notify_users($FormData){
               $insert_notify_users = array();
                            foreach ($FormData['nuserid'] as $nuserid) {
                                          $insert_notify_users[] = array(
                                              "token_id" => $FormData['token_id'],
                                              "nuserid" => $nuserid,
                                              "Add_User" => $FormData['Add_User'],
                                              "Add_DateTime" => $FormData['Add_DateTime']);
                            }
                            //   die($this->util_model->printr($insert_notify_users));
                            if ($this->db->insert_batch(DB_PREFIX . 'tokening_noti_users', $insert_notify_users)) {
                                          return array("succ" => TRUE);
                            } else {
                                          return array("succ" => FALSE);
                            }   
    }
     public function get_token_list($filter_data) {
                            // $filter_data['Add_User'] will contain array of user id
                            if(isset($filter_data['Add_User']) && !empty($filter_data['Add_User'])){
                                          $this->db->where_in("t1.Add_User",$filter_data['Add_User']);        
                            }
                            // $filter_data['status'] will have boolean
                            if(isset($filter_data['status'])){
                                          $this->db->where_in("t1.status",$filter_data['status']);        
                            }
                            $this->db->select("t5.*,t4.Emp_Code as AddEmpCode, t3.Emp_Code as ModeEmpCode,t4.Emp_Name as SenderName"
                                    . ",t1.nnui,t1.n_viewed,t1.Status as Nofi_user_status,t1.Mode_DateTime as ReadDateTime,t1.Remarks as Noti_Remarks"
                                    . ", concat(t6.Emp_Code,'(',t6.Emp_Name,')') as Noti_User",false)->from(DB_PREFIX . "tokening_noti_users t1");
                            $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
                            $this->db->join(DB_PREFIX . "tokening_sys t5", "t1.token_id=t5.token_id", 'LEFT');
                            $this->db->join(DB_PREFIX . "employee t6", "t1.nuserid=t6.Emp_ID", 'LEFT');
                            $this->db->order_by("t1.Mode_DateTime", "DESC");
                            $query = $this->db->get();
                            return $query->result();
              }

}
