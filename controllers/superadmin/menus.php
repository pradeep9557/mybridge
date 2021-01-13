<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menus
 *
 * @author kuldeep
 */
class menus extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('super-admin/m_menu');
        $this->load->model('super-admin/usertypes_model');
    }

    public function index($error = '', $_err_codes = '') { //provide a view of menu form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['yes_no_list'] = $this->util_model->yes_no();
        $this->load->model('super-admin/m_module');
        $data['all_modules'] = $this->m_module->all_list_for_select();
        $data['MenuTable'] = $this->m_menu->MenuTale();
        $data['All_menu_list'] = $this->m_menu->menu_list();
        $data['all_UserTypes'] = $this->usertypes_model->AllUserTypeForSelect();
        $data['menu_location_list'] = $this->util_model->get_list("menu_location_id", "location", DB_PREFIX . "menus_location");
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php', $data);
        $this->load->view('superadmin/menu/v-menu', $data);
        $this->load->view('templates/footer.php');
    }

    public function AddMenu() {
        $FormData = $this->input->post();
        if ($FormData != NULL) {
            $inserted = $this->m_menu->AddMenu($FormData);
            redirect(base_url() . "sp-admin/m/menus/" . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
        }
    }

    public function ModeMenu() {

        $FormData = $this->input->post();
        $MID = $FormData['MID'];
        unset($FormData['MID']);
        if ($this->m_menu->ModeMenu($FormData, $MID)) {
            echo json_encode(array("success" => TRUE, "menu_title" => $FormData['menu_title']));
        } else {
            echo json_encode(array("success" => FALSE, "menu_title" => $FormData['menu_title']));
        }
    }

    public function ModeMenuForm($ExtraData = '') {
        $data = $this->my_controller->load_data_for_AdminPanel();
        $data['MenuTable'] = $this->m_menu->MenuTale(0, $data['BranchID']);

        $data['ExtraData'] = $ExtraData;
        $this->load->view('admin/menu/v-add-menu-form', $data);
    }

    public function DelMenu() {

        $FormData = $this->input->post();
        if ($this->m_menu->DelMenu($FormData)) {
            echo json_encode(array("success" => TRUE));
        } else {
            echo json_encode(array("success" => FALSE));
        }
    }

    public function ChangeStatus() {
        
    }

    public function MenuList() {//ajax response for type head menu listing....
        $FormData = $this->input->get();
        if (count($FormData) > 0) {
            echo json_encode($this->m_menu->MenuList($FormData['query']));
        }
    }

    // menu or module list to display authentication 
    public function displayMenuForAuth($BranchID, $UTID) {
        $data['MenuList'] = $this->util_model->ShowMenus(0, $BranchID, $UTID);
        $data['BranchID'] = $BranchID;
        $data['UTID'] = $UTID;
        $this->load->view('superadmin/menu/v-menu-display-auth', $data);
    }

    //update menu acces  table
    /*

     *  UpdateMenuAccess
     * @controller menus
     * function/working to update the access for user types according to branch
     * calling from : menu_auth view in super-admin/menu    */
    public function UpdateMenuAccess() {
        $FormData = $this->input->post();
        $BranchID = $FormData['BranchID'];
        $UTID = $FormData['UTID'];
        unset($FormData['BranchID']);
        unset($FormData['UTID']);
        if ($this->m_menu->UpdateMenuAccess($FormData['MID'], $BranchID, $UTID)) {
            echo $this->util_model->get_err_msg("AuthChangedSucc");
        } else {
            echo $this->util_model->get_err_msg("AuthChangedErr");
        }
    }

    public function icon_choose() {
        $FormData = $this->input->post();
        $data['ID'] = $FormData['ID'];
        $this->load->view('superadmin/menu/v-icons', $data);
    }

//    public function Menu_chose_for_Page($BranchID)
//    {
//        
//        $data['MenuTable']=  $this->m_menu->MenuTale(0,$BranchID);
//        
//        
//                $FormData= $this->input->get();
//               $data['PageID']=$FormData['PageID'];
//                $data['DivID']=$FormData['DivID'];
//        $this->load->view('admin/menu/v-menu-page-link',$data);
//    }
//    
//    public function MenuTOPageLink()
//    {
//        $FormData=  $this->input->get();
//        if($this->m_menu->MenuTOPageLink($FormData))
//        {
//            echo json_encode(array("success"=>TRUE)); 
//        }
//        else{
//             echo json_encode(array("success"=>FALSE));
//        }
//        
//    }

    public function MenuSorting() {
        $jsonPOST = json_decode(file_get_contents("php://input"));
        $sort = 0;

        foreach ($jsonPOST as $Menu) {

            $sort = $this->Extract_Menus($Menu, $sort);
        }

        echo json_encode(array("success" => TRUE));
    }

    public function Extract_Menus($Menu, $sort, $ParentID = 0) {
        $FormData = array("Sort" => $sort, "PID" => $ParentID, "MID" => $Menu->id);
        $this->m_menu->Menu_sort_and_update($FormData);
        $ParentID = $Menu->id;
        $sort++;
        if (!array_key_exists('children', $Menu)) {
            return $sort;
        }
        foreach ($Menu->children as $Men) {
            $sort = $this->Extract_Menus($Men, $sort, $ParentID);
        }
        return $sort;
    }

    public function MenuAllotToUserType() {
        $FormData = $this->input->post();


        $this->m_menu->MenuAllot($FormData);
        redirect(base_url() . "sp-admin/m/menu_auth/?UTID=" . $FormData['UTID']);
    }

    public function show_all_userTypeForAuth() {
        global $data;

        $data['UserType'] = $data['usertype_list'] = $this->util_model->get_list("UTID", "UserType", DB_PREFIX . "usertypes");
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/menu/v-select-user', $data);
        $this->load->view('templates/footer.php');
    }

    public function menu_auth($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $this->load->helper('form');
        $data['MenuTable'] = $this->m_menu->MenuTale(0);
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        
        $data['usertype_list'] = $this->usertypes_model->AllUserTypes(array("Status" => 1,"developer"=>0,"for_dropdown"=>1,"UserTypeGroup"=>1));
//                $this->util_model->get_list("UTID", "UserTypeName", DB_PREFIX . "usertypes");
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/menu/menu_auth', $data);
        $this->load->view('templates/footer.php');
    }

}
