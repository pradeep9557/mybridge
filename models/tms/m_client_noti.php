<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_client_noti
 *
 * @author Harsh
 */
class m_client_noti extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    public function get_client_state_list($client_id){
    $this->db->select("cs.*")->from(DB_PREFIX.'client_states c_cs');
    $this->db->join(DB_PREFIX.'cstates cs','c_cs.state_id=cs.state_id','left');
    $this->db->where("(c_cs.client_id=$client_id)",NULL,FALSE);
    $res=$this->db->get()->result_array();
   
     $state_list = array('0'=>'Select State - NA');
     foreach ($res as $value) {
       $state_list[$value['state_id']] = $value['name'];
       # code...
     }
      return $state_list;
   }
    
     public function get_month_list() {
        $month_list = array();
        $month_list[strtoupper(date("M"))] = date('F');
        for ($i = 1; $i < 13; $i++) {
            $value = date("F", strtotime("+$i months"));
            $month_list[strtoupper(date("M", strtotime($value)))] = $value;
        }

        return $month_list;
    }
 public function list_month() {

       $month_list = array('0'=>'Select Month');
       for ($m = 1; $m <= 12; $m++) {
           $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
           $month_list[$m] = $month;
       }
       return $month_list;
   }

  public function list_year() {

       $year = array(
           '0'=>'Select Year',
           date('Y', strtotime('-1 year'))=>date('Y', strtotime('-1 year')),
           date('Y')=>date('Y')
       );

       return $year;
   }
   
   public function get_ttm_list(){
       $res = $this->db->get_where(DB_PREFIX."task_type_mst",array('status'=>1))->result_array();
       $list = array('0'=>'Select Task Type');
       foreach ($res as $eachttm) {
           $list[$eachttm['ttm_id']] = $eachttm['ttm_name'];
       }
       return $list;
   }
   
   public function get_state_list(){
       $res = $this->db->get_where(DB_PREFIX."cstates",array('country_id'=>99))->result_array();
       $list = array('0'=>'Select State');
       foreach ($res as $eachttm) {
           $list[$eachttm['state_id']] = $eachttm['name'];
       }
       return $list;
   }
    public function get_status_list(){
       $res = $this->db->get_where(DB_PREFIX."progress_list_mst",array('p_type'=>'upload_file'))->result_array();
       $list = array('0'=>'Select Status');
       foreach ($res as $eachttm) {
           $list[$eachttm['p_id']] = $eachttm['p_name'];
       }
       return $list;
   }
    function save_client_noti($filter_data) {

        //   $this->db->delete(DB_PREFIX. 'client_notification_level',array('client_id'=>$client_id));
        $this->db->insert(DB_PREFIX . 'client_notification_level', $filter_data);
        if ($this->db->affected_rows() > 0) {

            return array(
                "succ" => TRUE,
                "_err_codes" => "Save Successfully!"
            );
        } else {

            return array(
                "succ" => FALSE,
                "_err_codes" => "Error while saving!"
            );
        }
    }

    function update_client_noti($filter_data, $id) {

        if ($this->db->update(DB_PREFIX . 'client_notification_level', $filter_data, array('noti_mst_id' => $id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_client_noti($filter = array()) {
 
        //   $this->db->delete(DB_PREFIX. 'client_notification_level',array('client_id'=>$client_id));
        $this->db->select('cnl.*,cs.name as state_name')->from(DB_PREFIX . 'client_notification_level cnl');
        $this->db->join(DB_PREFIX.'cstates cs','cnl.state_id=cs.state_id','left');
        if (isset($filter['client_id']) && $filter['client_id'] != '') {
            $this->db->where('client_id', $filter['client_id']);
        }
//             $result = $this->db->get()->row_array();
//        }else{
            $result = $this->db->get()->result_array();
//        }
//        $clint_details = $this->db->get_where(DB_PREFIX."employee",array('Emp_ID'=>$filter['client_id']))->row();     
//        $result[] = array(
//            'emails'=>$clint_details['P_Email'],
//            'mobiles'=>''
//        );
        return $result;
    }

    function get_client_noti_by_id($filter = array()) {

        //   $this->db->delete(DB_PREFIX. 'client_notification_level',array('client_id'=>$client_id));
        $this->db->select('lvl.*,emp.Emp_Name as client_name')->from(DB_PREFIX . 'client_notification_level lvl');
        $this->db->join(DB_PREFIX . "employee emp", "emp.Emp_ID=lvl.client_id", 'left');
        if (isset($filter['id']) && $filter['id'] != '') {
            $this->db->where('lvl.noti_mst_id', $filter['id']);
        }
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    function get_client_by_task_id($task_id){
        $this->db->select('emp.Emp_name as client_name')->from(DB_PREFIX."task_mst tm");
        $this->db->join(DB_PREFIX . "employee emp", "emp.Emp_ID=tm.client_id", 'left');
        $this->db->where('tm.tm_id',$task_id);
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    //  function get_custom_month($filter = array()) {
       
    //     $this->db->select('custom_months')->from(DB_PREFIX . 'client_notification_level');
    //     if (isset($filter['client_id']) && $filter['client_id'] != '') {
    //         $this->db->where('client_id', $filter['client_id']);
    //     }

    //     $result = $this->db->get()->result_array();

    //     return $result;
    // }

    public function update_task_status($tm_id,$p_id){
        return $this->db->update(DB_PREFIX."task_mst",array('client_p_id'=>$p_id),array('tm_id'=>$tm_id));
    }
    function get_task($client_id) {

        $this->db->select("ts.*,(select tcs.ttm_id  from nexgen_client_task_types tcs where tcs.client_id=$client_id and tcs.ttm_id=ts.ttm_id) as task_id ", NULL, false)->from(DB_PREFIX . 'task_type_mst ts');
        $this->db->where('ts.status', 1);
        $result = $this->db->get()->result_array();
//       echo $this->db->last_query();
//       die();
//       
        return $result;
    }

     function get_client_state($client_id) {

        $this->db->select("ts.*,(select tcs.state_id  from nexgen_client_states tcs where tcs.client_id=$client_id and tcs.state_id=ts.state_id) as task_id ", NULL, false)->from(DB_PREFIX . 'cstates ts');
//        $this->db->where('ts.status', 1);
        $result = $this->db->get()->result_array();
//       echo $this->db->last_query();
//       die();
//       
        return $result;
    }

    function save_client_task($filter_data, $client_id) {
        //print_r($client_id);die();
        $this->db->delete(DB_PREFIX . 'client_task_types', array('client_id' => $client_id));
        $this->db->insert_batch(DB_PREFIX . 'client_task_types', $filter_data);

        if ($this->db->affected_rows() > 0) {

            return array(
                "succ" => TRUE,
                "_err_codes" => "Save Successfully!"
            );
        } else {

            return array(
                "succ" => FALSE,
                "_err_codes" => "Error while saving!"
            );
        }
    }
    function save_client_state($filter_data, $client_id) {
        //print_r($client_id);die();
        $this->db->delete(DB_PREFIX . 'client_states', array('client_id' => $client_id));
        $this->db->insert_batch(DB_PREFIX . 'client_states', $filter_data);

        if ($this->db->affected_rows() > 0) {

            return array(
                "succ" => TRUE,
                "_err_codes" => "Save Successfully!"
            );
        } else {

            return array(
                "succ" => FALSE,
                "_err_codes" => "Error while saving!"
            );
        }
    }

    function get_client_task_by_id($client_id) {
        $this->db->select('*')->from(DB_PREFIX . 'client_task_types');
        $this->db->where('status', 1);
        $result = $this->db->get()->result_array();


        return $result;
    }

    public function get_client_progress_status() {
        $this->load->model('tms/m_progress_list');
        $result = $this->m_progress_list->getdata();
        $list = array(0 => 'Select Progress Status');
        foreach ($result as $eachValue) {
            $list[$eachValue['p_id']] = $eachValue['p_name'];
        }
        return $list;
    }
   
    
   

}
