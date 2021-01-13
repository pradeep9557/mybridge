<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of locality
 *
 * @author Anup kumar
 */
class locality extends CI_Model {

    //put your code here
    public function all_states($country_id) {
        $List = array();
        $this->db->select('state_id,name');
        $this->db->from(DB_PREFIX . 'cstates');
        $this->db->where(array('Status' => '1', "country_id" => $country_id));
        foreach ($this->db->get()->result_array() as $locality) {
            $List[$locality['state_id']] = $locality['name'];
        }
        return $List;
    }

    public function all_cities($state_id) {
        $List = array();
        $this->db->select('city_id,citycode');
        $this->db->from(DB_PREFIX . 'cities');
        $this->db->where(array('Status' => '1', "state_id" => $state_id));
        foreach ($this->db->get()->result_array() as $locality) {
            $List[$locality['city_id']] = $locality['citycode'];
        }
        return $List;
    }

    /* It is being used for inserting response */

    function insert_locality($FormData) {
        $FormData=$this->util_model->add_common_fields($FormData);
        if ($this->db->insert(DB_PREFIX . "locality", $FormData)) {
             $id=$this->db->insert_id();
            // die($this->util_model->printr($id));
            return array("succ" => TRUE,"data"=>$id);
        } else {
            return array("succ" => FALSE);
        }
    }

    public function AllLocality($parentid = 0, $cityid = '') {
        $List = array();
        $this->db->select('localityid,locality');
        $this->db->from(DB_PREFIX . 'locality');
        if ($cityid != '')
            $this->db->where(array('Status' => '1', "parentid" => $parentid, "city_id" => $cityid));
        else
            $this->db->where(array('Status' => '1', "parentid" => $parentid));
        foreach ($this->db->get()->result_array() as $locality) {

            $List[$locality['localityid']] = $locality['locality'];
        }
        return $List;
    }

    public function all_locality_list() {
        $this->db->select("t1.localityid as ID,t5.citycode,t1.lcode as localitycode,t1.locality as localityname,t6.lcode as parentcode,t6.Sort,t1.Status,t1.Add_User,t1.Mode_User,t1.Mode_DateTime as LastModified,t1.Remarks,`t4`.`Emp_Code` as AddEmpCode, `t3`.`Emp_Code` as ModeEmpCode")->from(DB_PREFIX . "locality t1");
        $this->db->join(DB_PREFIX . "cities t5", "t1.city_id=t5.city_id", 'LEFT');
        $this->db->join(DB_PREFIX . "locality t6", "t1.parentid=t6.localityid", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Add_User=t4.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", 'LEFT');
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        //$this->db->limit(10);
        $query = $this->db->get();
        return $query->result();
    }

    /* It is being used for deleteing locality */

    function deletelocality($id) {
        if ($this->db->delete(DB_PREFIX . "locality", array('localityid' => $id))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    public function get_locality_data($id) {
        $query = $this->db->get_where(DB_PREFIX . "locality", array("localityid" => $id));
        $result = $query->result();
        return $result[0];
    }

    /*
     *  country_update to update the response
     * @param $FormData array to update
     * @param $id country ID              */

    function locality_update($FormData, $id) {
        $FormData = $this->util_model->add_mode_user($FormData);
        $FormData['Mode_DateTime']=  date("Y-m-d h:m:s H",time());
        $this->db->where(array("localityid" => $id));
        if ($this->db->update(DB_PREFIX . "locality", $FormData)) {
            return array("succ" => FALSE, "_err_codes" => "EnqLocAddSucc" );
        } else {
            return array("succ" => TRUE, "_err_codes" => "EnqLocAddErr" . ERR_DELIMETER);
        }
    }

}
