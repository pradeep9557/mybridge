<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_brouchure
 * @Created on : Jun 4, 2016, 4:15:56 PM
 * @author Ankit
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class m_task_brouchure extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    public function kuch_bhi($filter_data = "") {

        $this->db->select("*")->from(DB_PREFIX . "task_mst");
        $this->db->where(array("does_repeat" => STATUS_TRUE));
        if ($filter_data != "") {
            $this->db->where("repeated_from IS NULL and '{$filter_data['my_date']}' = '" . date(DB_DF, time()) . "'", NULL, FALSE);
           
        } else {
            $this->db->where("repeated_from IS NULL and start_date < '" . date(DB_DF, time()) . "'", NULL, FALSE);
        }
        return $this->db->get()->row_array();
        
    }

    // start you function from here
}
