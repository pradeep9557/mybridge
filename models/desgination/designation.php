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
class designation extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    /*

     * Using by employee/add_employee passing usertype, to control a user can see the custome users type
     *     all_designation_list($UserType)
     * @parms $UserType : String from session type  */
    public function all_designation_list($UserType){
        $query = $this->db->select()->from("nexgen_designation")->where(array("Status"=>1))->order_by('Sort');
        $result = $query->get()->result();
        $all_design_list=array(); // if table will be empty than null array will be pass
        foreach ($result as $value) {
            $all_design_list["{$value->DID}"] = $value->Name;
        }
        return $all_design_list;
    }
     public function all_designation_list_from_db(){
        $query = $this->db->select()->from("nexgen_designation");
        $result = $query->get()->result();
        return $result;
       }
         function Designations_save_update() {
        $Designation_form_data = array();
        try {
            foreach ($_POST as $key => $value) {
                $Designation_form_data["$key"] = "";
                $Designation_form_data["$key"] = $this->db->escape_str($value);
            }
            if ($Designation_form_data["Add_Designation"] === "Save") {
                $data_to_insert = $this->Designation_query_string($Designation_form_data);
                if ($this->db->insert("nexgen_designation", $data_to_insert)) {
                    return array(TRUE);
                } else {
                    return array(FALSE);
                }
            } else {
                $data_to_update = $this->Designation_query_string($Designation_form_data);
                $this->db->where('Code', $Designation_form_data['Old_Code']);
                if ($this->db->update("nexgen_designation", $data_to_update)) {
                    return array(TRUE,course_encode($data_to_update['Code']));
                } else {
                    return array(FALSE,course_encode($Designation_form_data['Old_Code']));
                }
            }
        } catch (Exception $ex) {
            return array(FALSE);
        }
    }

    public function Designation_query_string($Designation_form_data) {
        $data_to_insert_or_update = array(
            "Code" =>$Designation_form_data['Code'],
            "Name"=>$Designation_form_data['Name'],
            "Add_User" => $Designation_form_data['Add_User'],
            "Mode_User" => $Designation_form_data['Mode_User'],
            "Status" => $Designation_form_data['Status'],
            "Company" => $Designation_form_data['Company'],
            "Branch" => $Designation_form_data['Branch'],
            "Remarks" => $Designation_form_data['Remarks']);
        return $data_to_insert_or_update;
    }
    public function get_details_from_database($Code=''){
          $query = $this->db->get_where('nexgen_designation',array("Code"=>$Code));
          if($this->db->count_all_results()>0){
          $Designation_details =$query->first_row();
          return $Designation_details; //sending first row
          }else{
              return FALSE;
          }
    }
      public function Del_Designation($Code){
        if($this->db->delete('nexgen_designation', array('Code' => $Code))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
