<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of qualification
 *
 * @author Mr. Anup
 */
class qualification extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function all_qualification_list() {
        $query = $this->db->select()->from("nexgen_qualification")->where(array("Status" => 1));
        $result = $query->get()->result();
        $list = array();
        foreach ($result as $value) {
            $list["{$value->Code}"] = $value->Name;
        }
        return $list;
    }

    public function Qualification_query_string($Qualification_form_data) {
        $data_to_insert_or_update = array(
            "Code" => $Qualification_form_data['Code'],
            "Name" => $Qualification_form_data['Name'],
            "Add_User" => $Qualification_form_data['Add_User'],
            "Mode_User" => $Qualification_form_data['Mode_User'],
            "Status" => $Qualification_form_data['Status'],
            "Company" => $Qualification_form_data['Company'],
            "Branch" => $Qualification_form_data['Branch'],
            "Remarks" => $Qualification_form_data['Remarks']);
        return $data_to_insert_or_update;
    }

    function qualification_save_update() {
        $Qualification_form_data = array();
        try {
            foreach ($_POST as $key => $value) {
                $Qualification_form_data["$key"] = "";
                $Qualification_form_data["$key"] = $this->db->escape_str($value);
            }
            if ($Qualification_form_data["Add_qualification"] === "Save") {
                $data_to_insert = $this->Qualification_query_string($Qualification_form_data);
                if ($this->db->insert("nexgen_qualification", $data_to_insert)) {
                    return array(TRUE);
                } else {
                    return array(FALSE);
                }
            } else {
                $data_to_update = $this->Qualification_query_string($Qualification_form_data);
                $this->db->where('Code', $Qualification_form_data['Old_Code']);
                if ($this->db->update("nexgen_qualification", $data_to_update)) {
                    return array(TRUE, course_encode($data_to_update['Code']));
                } else {
                    return array(FALSE, course_encode($Qualification_form_data['Old_Code']));
                }
            }
        } catch (Exception $ex) {
            return array(FALSE);
        }
    }

//    public function all_qualification_list_from_db($for_selection = FALSE,$UserType, $branchid = '') {
//        if($branchid!=""){
//            $this->db->where(array("BranchID"=>$branchid));
//        }
//        $query = $this->db->select()->from("nexgen_qualification");
//        $result = $query->get()->result();
//        if (!$for_selection)
//            return $result;
//        else {
//            $return_list = array();
//            foreach ($result as $value) {
//                $return_list[$value->Code] = $value->Name;
//            }
//            return $return_list;
//        }
//    }

    public function get_details_from_database($Code = '') {
        $query = $this->db->get_where('nexgen_qualification', array("Code" => $Code));
        if ($this->db->count_all_results() > 0) {
            $Designation_details = $query->first_row();
            return $Designation_details; //sending first row
        } else {
            return FALSE;
        }
    }

}
