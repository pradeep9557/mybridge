<?php

class auth_model extends CI_Model {

    private $Access_auth = array();

    /*
      For accessiblity .. @auther : Anup kumar | Nexgen Innovators IT Services Pvt Ltd
     * Three Level of users are here
     * 1. Admin
     * 2. Faculty
     * 3. Student
     */
    function __construct() {
        parent::__construct();
    }

        /*
      End Of accessiblity
     */

//    public function check_authencation($data) {
//        // it will allow user to access modules 
//        // echo  $controller = $data[0]; // it will be implementat
//        // $model = $data[1];
//        return $this->session->all_userdata();
//    }

    function module_list() {
        $query = $this->db->select()->from("nexgen_course_mst")->order_by('Category,Course_Name');
        $result = $query->get()->result();
        return $result;
    }

//    public function check_session($module_to_access) {
//        $Session_Data = $this->session->all_userdata();
//        if (!$this->session->userdata('LOGIN_STATUS')) {
//            redirect(base_url() . 'auth/login/1/1');
//        } else {
//            if ($this->check_authencation($Session_Data, $module_to_access)) {
//                return $Session_Data;
//            } else {
//                die("Sorry you are not authorised to open it !!");
//            }
//        }
//    }

}
