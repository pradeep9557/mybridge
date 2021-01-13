<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_term
 *
 * @author anup
 */
class m_term extends CI_Model {

    //put your code here
    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    public function getTaskPeriod() {

        $this->db->select("term_id,term_name")->from(DB_PREFIX . "term_mst");
        $this->db->order_by('term_id','DESC');
        $accouts = $this->db->where(array("status"=>STATUS_TRUE,'term_type'=>'create_task_period'))->get()->result_array();
        $list = array(''=>'Select Month Period');
        if (!empty($accouts)) {
            foreach ($accouts as $acc) {
                $list[$acc['term_id']] = $acc['term_name'];
            }
        }


        return $list;
    }

    //master start
    public function term_add($billAccount = array()) {
        if(isset($billAccount['term_id']) && $billAccount['term_id']!=''){
            return $this->db->update(DB_PREFIX . "term_mst", $billAccount,array('term_id'=>$billAccount['term_id']));    
            
        }else{
            $this->db->insert(DB_PREFIX . "term_mst", $billAccount);
            return $this->db->insert_id();
        }        
        
    }

    public function term_dele($term_id) {
        $this->db->where("term_id", $term_id);
        return $this->db->delete(DB_PREFIX . "term_mst");
        
    }

    public function term_update($billAccount, $term_id) {
        $this->db->where("term_id", $term_id);
        $this->db->update(DB_PREFIX . "term_mst", $billAccount);
        return $this->db->affected_rows();
    }

    public function get_terms($filter = array()) {
        if (isset($filter['term_id'])) {
            $this->db->where("term_id", $filter['term_id']);
        }
        $this->db->select("*");
        $this->db->from(DB_PREFIX . "term_mst");
        return $this->db->get()->result_array();
    }

}
