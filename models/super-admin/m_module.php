<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_module
 *
 * @author Anup kumar
 */
class m_module extends CI_Model {
    //put your code here
    public function all_list_for_select(){
        $query = $this->db->select()->from(DB_PREFIX."modules")->where(array("Status"=>1))->order_by('Sort,module_name');   
        $result = $query->get()->result();
        $all_design_list=array(""=>"Select a Modules List"); // if table will be empty than null array will be pass
        foreach ($result as $value) {
            $all_design_list["{$value->module_id}"] = $value->module_name;
        }
        return $all_design_list;
    }
}
