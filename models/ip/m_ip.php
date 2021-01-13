<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_ip
 *
 * @author SMFARHAN
 */
class m_ip extends CI_Model {

    private $_err_codes;

    public function __construct() {
        parent::__construct();
        $this->_err_codes = '';
    }

    /*
     * required parameters
     * system_code : unquie code string
     * Emp_Code : username or email string
     * succ : boolean
     * ip : optional
     * return array parameters
     *  succ : boolean
     *  insert_id : last primary key if succ true
     *  _err_codes  : in case succ false
     */

    public function punch_login_history($filters = array()) {
        // get ip address
        //echo $ip;     exit;
        try {

            if (!isset($filters['system_code'])) {
                throw new Exception('System code is required');
            }

            if (!isset($filters['Emp_Code'])) {
                throw new Exception('Username is required');
            }

            $data_to_insert = array(
                "ip" => isset($filters['ip']) ? $filters['ip'] : $this->getIp(),
                "system_code" => $filters['system_code'],
                "username" => $filters['Emp_Code'],
                "succ" => isset($filters['succ']) ? $filters['succ'] : -1,
                'Add_DateTime'=> isset($filters['Add_DateTime'])?date(DB_DTF, strtotime($filters['Add_DateTime'])):date(DB_DTF));

            $this->db->insert(DB_PREFIX . "login_ips_logs", $data_to_insert);
            if (!$this->db->affected_rows()) {
                throw new Exception('Error while punching login history, errorCode #170517445');
            }
            return array('succ' => FALSE, "insert_id" => $this->db->insert_id());
        } catch (Exception $ex) {
            return array('succ' => FALSE, "_err_codes" => $ex->getMessage());
        }
    }

    /*
     * return IP of client
     */

    public function getIp() {

        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            return $ip;
        }
        // There might not be any data
        return false;
    }

    /*
     * get login master ip
     * filter
     * system_code
     */

    public function getSystemCodeMstData($filter = array()) {
        $this->db->select("im.*,a_user.Emp_Name as approved_by_name")->from(DB_PREFIX . "login_ips_mst im");
        $this->db->join(DB_PREFIX.'employee a_user','im.approved_by = a_user.Emp_ID','left');
        if (isset($filter['system_code'])) {
            $this->db->where("im.system_code", $filter['system_code']); //, "requested_user", $filters['Emp_Code']);
            return $this->db->get()->row_array();
        }
        
        if(isset($filter['status'])){
            $this->db->where('im.status',$filter['status']);
        }
        if(isset($filter['requested_user']) && $filter['requested_user']!=''){
            $this->db->where('im.requested_user',$filter['requested_user']);
        }
        if(isset($filter['page']) && isset($filter['limit'])){
            $this->db->limit($filter['limit'],$filter['page']*$filter['limit']);
        }
        $this->db->order_by('im.Add_DateTime','DESC');
        return $this->db->get()->result_array();
        
    }

    /*
     * validate system codde
     * if doesn't exist then send request to admin
     * return 
     *  boolean
     * _err_code if false
     */

    public function validateSystemCode($filter = array()) {

        $SystemCodeDetails = $this->getSystemCodeMstData(array('system_code' => $filter['system_code']));
        if (!empty($SystemCodeDetails)) {
            if (!$SystemCodeDetails['status']) {
                $this->_err_codes = 'Contact admin to approve your account with system code = ' . $filter['system_code'];
                return FALSE;
            }
            return TRUE;
        } else {
            $data_to_insert = array(
                "system_code" => $filter['system_code'], 
                "requested_user" => $filter['Emp_Code'],
                "Add_DateTime" => date(DB_DTF));
            $this->_err_codes = 'Contact admin to approve your account with system code = ' . $filter['system_code'];
            $this->insertSystemCode($data_to_insert);
            return FALSE;
        }
    }
    
    /*

     * insert update system code     */

    public function insertSystemCode($data_to_insert) {
        $this->db->insert(DB_PREFIX. 'login_ips_mst',$data_to_insert);
        if($this->db->affected_rows()){
            return $this->db->insert_id();
        }
        $this->_err_codes = 'Error while sending request to admin to approve this system';
        return FALSE;
    }
    
    /*

     * update ips_msg     */
    
    public function updateSystemCode($data_to_update,$id) { 
        if(!isset($data_to_update['approved_by'])){
            $data_to_update['approved_by'] = $this->util_model->get_uid();
        }
        if($this->db->update(DB_PREFIX. 'login_ips_mst',$data_to_update,array('id'=>$id))){
            return TRUE;
        }
        $this->_err_codes = 'Error while updating your request';
        return FALSE;
    }
    
    /*

     * delete ips_msg 
         */
     public function del_ips_msg($id) { 
       
        if($this->db->delete(DB_PREFIX. 'login_ips_mst',array('id'=>$id))){
            return TRUE;
        }
        $this->_err_codes = 'Error while deleting your request';
        return FALSE;
    }
    public function bulkdel_ips_msg($id) { 
        $this->db->where_in('id',$id);
        if($this->db->delete(DB_PREFIX. 'login_ips_mst')){
            return TRUE;
        }
        $this->_err_codes = 'Error while deleting your request';
        return FALSE;
    }
    

    
    /*
     * return err_codes
     */
    public function get_err_codes() {
        return $this->_err_codes;
    }
    public function getEmplist() {
        $this->db->select("im.requested_user")->from(DB_PREFIX . "login_ips_mst im");
        $res = $this->db->get()->result_array();
        $list = array(""=>"--select--");
        foreach ($res as $key => $value) :
            $list[$value['requested_user']]= $value['requested_user'];
        endforeach;
        return $list;
        
        
        
    }
}
