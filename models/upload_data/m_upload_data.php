<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_upload_data
 *
 * @author anup
 */
class m_upload_data extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function getClientNotUploadedData($filter = array()) {
        $sql = " SELECT noti.*,client.Emp_Name as client_name FROM ".DB_PREFIX."client_notification_level "
                . " noti left join ".DB_PREFIX."employee client on "
                . " (noti.client_id=client.Emp_ID) WHERE "
                . " day={$filter['day']} "
                . " and time = {$filter['time']} and "
                . " (noti.monthly=1 or noti.custom_months like '%{$filter['month_in_words']}%')  and "
                . " (select count(*) from ".DB_PREFIX."client_files f "
                . " where  noti.state_id = f.state and f.client_id=noti.client_id and f.month={$filter['month']}"
                . " and year = {$filter['year']} and status<>".CLIENT_FILE_PENDING_STATUS.") = 0";
        return $this->db->query($sql)->result_array();        
    }
    
    
}
