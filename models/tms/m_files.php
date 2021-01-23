<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_files
 *
 * @author anup
 */
class m_files extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function attach_files_with_task($tm_id, $file_id) {
        try {
            $file_details = $this->get_files(array('file_id' => $file_id));
            if (!empty($file_details)) {
//                $this->util_model->printr($file_details);
                $files = @unserialize($file_details['files']);
//                $this->util_model->printr($files);
//                die();
                if (is_array($files) && !empty($files)) {
                    
                    if($file_details['status'] != CLIENT_FILE_PENDING_STATUS){
                        throw new Exception('Only actions are allowed on pending entries');
                    }
                    
                    
                    $attchments = array();
                    foreach ($files as $each_file) {
                        $attchments[] = $this->util_model->add_common_fields(array(
                           'attach_original_name' =>  basename($each_file),
                           'attach_name' =>  basename($each_file),
                           'link'=>$each_file,
                           'table_id'=>$tm_id,
                           'attach_type'=>TASK_ATT_TYPE,
                           'status'=>TRUE
                        ));
                    }
                    $this->db->insert_batch(DB_PREFIX."task_attachments",$attchments); 
                    foreach ($attchments as $k => $value) {
                        $arr = array(
                            'user_id' => $value['Add_User'],
                            'tm_id' => $value['table_id'],
                            'file_name' => $value['attach_name'],
                            'link' => $value['link'],
                            'state_name' => '',
                            'date' => $value['Add_DateTime'],
                            'status' => 0,
                            'attachment_id' => 0,
                        );
                        $this->db->insert('nexgen_attach_file', $arr);
                    }
//                    $this->util_model->printr($attchments);
                    
                    if(!$this->db->affected_rows())
                        throw new Exception('Error while attaching file with task');
                    
                    return array("succ" => TRUE, '_err_code' => 'file attached successfully !');
                    
                } else {
                    throw new Exception('No file found to be attach !');
                }
            } else {
                throw new Exception('Invalid file id passed !');
            }
        } catch (Exception $ex) {
            return array("succ" => FALSE, '_err_code' => $ex->getMessage());
        }
        
    }

    public function get_files($filter = array()) {
        $this->db->select('f.*')->from(DB_PREFIX . "client_files f");
        if (isset($filter['file_id']) && $filter['file_id'] != '') {
            $this->db->where('f.file_id', $filter['file_id']);
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

    public function markAsApproved($file_id) {
        $this->db->where(array('file_id'=>$file_id));
//        print_r($this->input->get());
        $this->db->update(DB_PREFIX."client_files",array('status'=>($this->input->get('status')?$this->input->get('status'):'Approved')));
    }
}
