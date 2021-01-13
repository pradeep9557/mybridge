<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_log
 *
 * @author User
 */
class m_task_log extends CI_Model {

    //put your code here
    /*

     * function for validation task log data     */
    function create_validate($form_data) {
        $err_codes = array();
        if (isset($form_data['log_type']) && $form_data['log_type'] == "") {
            $err_codes[] = 'E_log_typeBlank';
        }
        if (isset($form_data['modified_id']) && $form_data['modified_id'] == "") {
            $err_codes[] = 'E_modified_idBlank';
        }
        if (isset($form_data['modifier_id']) && $form_data['modifier_id'] == "") {
            $err_codes[] = 'E_modifier_idBlank';
        }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

//    function for insert log
    /*

     * keys 
     * log_type 
     *  1. task type mst, 2. tt doc req mst, 3.tt sub task mst, 4. task master,5. t doc req, 6.t sub task, 7 comment_id
     * modified_id
     * modifier_id
     * remarks
     * 
     */
    public function punch_log($filter_data) {
        $validate = $this->create_validate($filter_data); // validating the  task log form
        if (!empty($validate['_err_codes'])) {
            return array("succ" => false, "_err_codes" => $validate['_err_codes']);
        }
        $this->db->insert(DB_PREFIX . "task_logs", $filter_data);
//        echo $this->db->last_query();
        if ($this->db->affected_rows()) {
            return array("succ" => TRUE, "insert_id" => $this->db->insert_id(), "_err_codes" => array("Log_Insert_Succ"));
        } else {
            return array("succ" => FALSE, "_err_codes" => array("Log_Insert_Err"));
        }
    }

    public function punch_batch_log($batch_logs) {
        $succ = TRUE;
        foreach ($batch_logs as $log) {
            $validate = $this->create_validate($log); // validating the  task log form
            if (!empty($validate['_err_codes'])) {
                $succ = FALSE;
                break;
            }
        }
        if ($succ) {
            $this->db->insert_batch(DB_PREFIX . "task_logs", $batch_logs);
            return array("succ" => TRUE, "affected_rows" => $this->db->affected_rows(), "_err_codes" => array("Log_Insert_Succ"));
        } else {
            return array("succ" => FALSE, "_err_codes" => array("Log_Insert_Err"));
        }
    }

//    public function update_task_log($filter_data){
//        $id=$filter_data['id'];
//        $this->db->where(array("t_log_id"=>$id));
//        if($this->db->update(DB_PREFIX.'task_logs',$filter_data)){
//            return array("succ"=>TRUE,  "insert_id"=>$id, "_err_codes" => "Updated Successfully");
//        }
//        else{
//            return array("succ"=>FALSE, "_err_codes" => "Error while updating");
//        }
//        
//        
//    }

    /*

     * get task data ...      */
    public function getTaskLog($filter_data = array()) {
        if (!empty($filter_data)) {
            if (isset($filter_data['log_type'])) {
                $this->db->where("t1.log_type", $filter_data['log_type']);
            }
            if (isset($filter_data['modified_id'])) {
                $this->db->where("t1.modified_id", $filter_data['modified_id']);
            }
            if (isset($filter_data['modifier_id'])) {
                $this->db->where("t1.modifier_id", $filter_data['modifier_id']);
            }
            if (isset($filter_data['OrderCol'])) {
                $this->db->order_by($filter_data['OrderCol'], "ASC");
            }
        }
        $this->db->select("t1.*,t2.UserName")->from(DB_PREFIX . "task_logs t1");
        $this->db->join(DB_PREFIX . "employee t2", "t1.modifier_id=t2.Emp_ID", "left");
        return $this->db->get()->result();
    }

}
