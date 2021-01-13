<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Job_Model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
           /* set_data()
         * insert data into table
         * return if data is inserted in affected row form.
         */    
        public function set_data($formdata){
             $this->db->insert(DB_PREFIX.'job_master', $formdata);
             return $this->db->affected_rows();
        }      
        
        /* list_all_jobs()
         * @param1 int id of job_mst
         * return all new job list in tabler form. 
         */
        public function list_all_jobs($filter_data=  array()){
            if(!empty($filter_data)){
                            if(isset($filter_data['BranchID'])){
                                          $this->db->where("jm.BranchID",$filter_data['BranchID']);           
                            }  
                            if(isset($filter_data['OrderCol'])){
                                          $this->db->order_by($filter_data['OrderCol'],"ASC");
                            }
                            if(isset($filter_data['current_user'])){
                                          $this->db->where("jm.Job_Assigned_to",$filter_data['current_user']);           
                            }
                      }
            $this->db->select('jm.*,em.Emp_Name,jsm.JobStatus');
            $this->db->from(DB_PREFIX.'job_master jm'); 
            $this->db->join(DB_PREFIX.'employee em', 'em.Emp_id=jm.Job_Assigned_to', 'left');
            $this->db->join(DB_PREFIX.'job_status_mst jsm', 'jsm.Status_ID=jm.JobStatusID', 'left');
            $query = $this->db->get(); 
//            $query =$this->db->last_query();
//            $this->util_model->printr($query);
//            die();
            if($query->num_rows() != 0)
            {
                return $query->result_array();
              
            }
            else {
                return false;
            }           
        }
        /*
         * get_job_data()
         * @param1 int id of job_mst
         * return first row field current value in the form.
         */
        function get_job_data($id=""){
            $this->db->select("jm.*");
            $this->db->from(DB_PREFIX.'job_master jm'); 
            $this->db->where("JobID",$id);
            $query = $this->db->get(); 
            return $query->first_row();

        }
        /*
         * update_job()
         * function is used to update the data
         * return updated data to controller.
         */
        function update_job($formdata,$job_id){
           return $this->db->update(DB_PREFIX.'job_master', $formdata, array("JobID"=>$job_id));

        }
        /*
         * delete_job()
         * function is used to delete row
         * return if row is deleted.
         */
        function delete_job($r_id){
           $this->db->delete(DB_PREFIX.'job_master', array('JobID' => $r_id)); 
           return $this->db->affected_rows();
        }
         function set_remarks($formdata){
             $this->db->insert(DB_PREFIX.'job_remarks', $formdata);
             return $this->db->affected_rows();
        } 
        
        function list_all_remarks($filter_data=  array()){
            if(!empty($filter_data)){
                            if(isset($filter_data['current_user'])){
                                          $this->db->where("jr.Add_User",$filter_data['current_user']);           
                            } 
                            if(isset($filter_data['OrderCol'])){
                                          $this->db->order_by($filter_data['OrderCol'],"ASC");
                            }
                            
                      }
            $this->db->select('jr.*,em.Emp_Name,jsm.JobStatus');
            $this->db->from(DB_PREFIX.'job_remarks jr'); 
            $this->db->join(DB_PREFIX.'employee em', 'em.Emp_id=jr.Add_User', 'left');
            $this->db->join(DB_PREFIX.'job_status_mst jsm', 'jsm.Status_ID=jr.Job_StatusID', 'left');
            $query = $this->db->get();
            if($query->num_rows() != 0){
                return $query->result_array();
              }
            else {
                return false;
            } 
        }
}
