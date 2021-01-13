<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_billing
 * @Created on : 6 Jul, 2016, 5:27:15 PM
 * @author Deepak Singh
 * @Team Riding Solo
 * @copyright (c) year, Dee
 * @location
 * @Use
 * 
 */
class m_taxs_manage extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    } 
    public function insertbilltype($formdata=array()) {
        $datalist = array(
          "name"=>$formdata['name'],
          "rate"=>$formdata['rate'],
           'created_at'=> isset($formdata['created_at'])?date(DB_DTF, strtotime($formdata['created_at'])):date(DB_DTF)
 
        );
         $this->db->insert(DB_PREFIX . "tax", $datalist);
      if (!$this->db->affected_rows()) {
          return FALSE;
            }else{
                return TRUE;
            }
    }
    public function updatebilltype($formdata) {
         $datalist = array(
          "name"=>$formdata['name'],
          "rate"=>$formdata['rate'],
        );
        $this->db->where("id", $formdata['id']);
        $this->db->update(DB_PREFIX . "tax", $datalist);
        if (!$this->db->affected_rows()) {
                return FALSE;
            }else{
                return TRUE;
            }
    }
    public function delbilltype($id) { 
       
        if($this->db->delete(DB_PREFIX. 'tax',array('id'=>$id['id']))){
            return TRUE;
        }
        $this->_err_codes = 'Error while deleting your request';
        return FALSE;
    }

  
}
