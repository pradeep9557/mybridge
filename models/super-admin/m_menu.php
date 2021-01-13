<?php

/**
 * IBMS
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		models
 * @author		NexGen Innovators Dev Team
 * @copyright           Copyright (c) 2015 - 2020, NexGen Innovators IT Services Pvt.
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * menu Model
 *
 * This is the platform-independent base Active Record implementation class.
 *
 * @package		Model
 * @subpackage	        Application
 * @category            Menu list
 * @author		NexGen Innovators Dev Team
 * 
 */
class m_menu extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function form_validation($POST) {
        $err_codes = '';
        if (isset($POST['menu_title']) && $POST['menu_title'] == "") {
            $err_codes.='M_TitleBlank' . ERR_DELIMETER;
        }

        if (isset($POST['menu_link']) && $POST['menu_link'] == "" && $POST['controller'] != "") {
            $err_codes.="M_LinkBlank" . ERR_DELIMETER;
        }
        if (isset($POST['menu_icon']) && $POST['menu_icon'] == "") {
            $err_codes.="M_IconBlank" . ERR_DELIMETER;
        }
        if (isset($POST['module_id']) && $POST['module_id'] == "") {
            $err_codes.="M_ModuleBlank" . ERR_DELIMETER;
        }
        if (isset($POST['controller']) && $POST['controller'] == "" && $POST['menu_link'] != "") {
            $err_codes.="M_ControllerBlank" . ERR_DELIMETER;
        }
        if (isset($POST['function']) && $POST['function'] == "" && $POST['menu_link'] != "") {
            $err_codes.="M_FunctionBlank" . ERR_DELIMETER;
        }
        $valid = $err_codes == '' ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $err_codes);
    }

    public function AddMenu($FormData) {
        $validates = $this->form_validation($FormData);
        if (!$validates['_err']) {
            return array("succ" => false, "_err_codes" => $validates['_err_codes']);
        }
        /* Inserted in menu master table */
        $FormData = $this->util_model->add_common_fields($FormData);  // inserting common fields Add_User and Add_date
        if (!$this->db->insert(DB_PREFIX . 'menus', $FormData)) {
            return array("succ" => false, "_err_codes" => "MAddErr");
        }
        /* Getting MID from last inserted Record */
        $MID = $this->db->insert_id();
        
        
        $cnfs = array("MID"=>$MID,"controller"=>$FormData['controller'],"function"=>$FormData['function']);
//        $this->util_model->printr($cnfs);
//        $this->util_model->printr($FormData);
        $this->db->insert(DB_PREFIX."menu_cnfs",$cnfs);
        
        $FormData = array(); // doing blank to existing array !!
        $FormData['MID'] = $MID;
        $FormData = $this->util_model->add_common_fields($FormData);  // inserting common fields Add_User and Add_date
        $data_to_insert = array();
        $this->load->model('super-admin/usertypes_model');  //loading model
        $usertypes = $this->usertypes_model->AllUserTypeForSelect(); //calling function of model
        $this->load->model('branch/branch_model');
        $branches = $this->branch_model->branch_list_with_branch_Cat();
        foreach ($branches as $BranchID => $BranchCode) {
            $FormData['BranchID'] = $BranchID;
            foreach ($usertypes as $UTID => $UsertypeName) {
                $FormData['UTID'] = $UTID;
                if ($UTID == 1) {
                    $FormData['Allowed'] = 1;
                } else {
                    $FormData['Allowed'] = 0;
                }
                $data_to_insert[] = $FormData;
            }
        }
        
        if (!$this->db->insert_batch(DB_PREFIX . 'menu_access', $data_to_insert)) {
            return array("succ" => false, "_err_codes" => "MAddAccErr");
        }
//        die();
        return array("succ" => TRUE, "_err_codes" => "MAddedSucc");
    }

    public function ModeMenu($FormData, $MID) {
        if (!isset($FormData['Status'])) {
            $FormData['Status'] = FALSE;
        }
        return $this->db->update(DB_PREFIX . 'menus', $FormData, array("MID" => $MID));
    }

    public function DelMenu($FormData) {
        // trnx start
        $this->db->trans_begin();
        
        $tables = array(DB_PREFIX . 'menus', DB_PREFIX . 'menu_access');
        $this->db->delete(DB_PREFIX . 'menus', array("parent_id" => $FormData['MID']));
        $this->db->where("MID", $FormData['MID']);
        $this->db->delete($tables);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function ChangeStatus() {
        
    }

    public function MenuList($MenuName) {
        //for selecting parent menu ajax call
        $this->db->select('MID,MenuName');
        $this->db->from('mainmenu');
        //$this->db->where('MenuName');
        $this->db->like('MenuName', $MenuName);
        $result = $this->db->get();
        return $List = $result->result_array();
    }

    public function MenuAllot($FormData) {
        $UTID = $FormData['UTID'];
        $this->db->delete(DB_PREFIX . "menu_access", array('UTID' => $UTID));
        foreach ($FormData['menu'] as $key => $menu) {
            $Data = array("MID" => $menu, "UTID" => $UTID);
            $this->db->insert(DB_PREFIX . "menu_access", $Data);
        }
    }

    public function MenuTale($PID = 0) {
        $List = NULL;

//        $this->db->select(array(DB_PREFIX . 'menus.*', DB_PREFIX . 'menu_access.UTID'));
//        $this->db->from(DB_PREFIX . 'menus');
//        $this->db->join(DB_PREFIX . "menu_access", DB_PREFIX . 'menus.MID' . "=" . DB_PREFIX . 'menu_access.MID', "LEFT");
//        $this->db->where(array(DB_PREFIX . "menus.parent_id" => $PID, DB_PREFIX . 'menu_access.UTID' => $UTID));
//        $this->db->order_by(DB_PREFIX . 'menus.sort_order', 'ASC');
//        $this->db->group_by(DB_PREFIX . 'menus.MID');
//        $result = $this->db->get();
        // echo  $this->db->last_query();

        $this->db->select('m.*')->from(DB_PREFIX . "menus m")->where(array('m.parent_id' => $PID,'m.Status' => 1));
        $this->db->join(DB_PREFIX."modules mdl","m.module_id=mdl.module_id and mdl.Status=1","inner");
        $this->db->order_by('sort_order');
        $result = $this->db->get();
//        echo $this->db->last_query();
        foreach ($result->result_array() as $mrow) {
            $List[] = array('Parent' => $mrow, 'Child' => $this->MenuTale($mrow['MID']));
        }
        return $List;
    }

    public function MenuTOPageLink($FormData) {
        return $this->db->update('mainmenu', array("PageID" => $FormData['PageID']), array("MID" => $FormData['MID']));
    }

    public function Menu_sort_and_update($FormData) {
        return $this->db->update(DB_PREFIX . 'menus', array("sort_order" => $FormData['Sort'], "parent_id" => $FormData['PID']), array("MID" => $FormData['MID']));
    }

    public function menu_list() {
        $this->db->select("t1.*,t2.module_name,t3.Emp_Code as Add_User,t4.Emp_Code as Mode_User,t1.Add_DateTime,t1.Mode_DateTime")->from(DB_PREFIX . "menus as t1");
        $this->db->join(DB_PREFIX . "modules as t2", "t1.module_id=t2.module_id", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t3", "t1.Add_User=t3.Emp_ID", 'LEFT');
        $this->db->join(DB_PREFIX . "employee t4", "t1.Mode_User=t4.Emp_ID", 'LEFT');
       // print_r($this->db->last_query());
        $result = $this->db->get()->result();
        //$query = $this->db->get(DB_PREFIX.'menus');
        // $result = $query->result();
        return $result;
    }

    public function UpdateMenuAccess($MID, $BranchID, $UTID) {
        if ($this->db->update(DB_PREFIX . "menu_access", array("Allowed" => "0"), array('BranchID' => $BranchID, 'UTID' => $UTID))) {
            foreach ($MID as $key => $value) {
                $this->db->update(DB_PREFIX . "menu_access", array("Allowed" => "1"), array('MID' => $value, 'BranchID' => $BranchID, 'UTID' => $UTID));
            }
            return TRUE;
        }
    }

    // --------------------------------------------------------------------

    /*
     * all_menu
     * Compiles an update string and runs the query
     * @return	Array object
     * calling from
     * usertype_model/AddUserType
     */
    public function all_menu() {
        return $this->db->get(DB_PREFIX . 'menus')->result();
    }

}
