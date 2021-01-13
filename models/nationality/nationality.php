<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nationality
 *
 * @author Mr. Anup
 */
class nationality extends CI_Model {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function all_nationality_list(){
        
        $query = $this->db->select()->from("nexgen_nationality");
        $result = $query->get()->result();
        $list=array();
        foreach ($result as $value) {
            $list["{$value->Code}"] = $value->Name;
        }
        return $list;
    }
   

}
