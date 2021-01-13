<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * IBMS
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		superadmin
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
 * @package		superadmin
 * @subpackage	        controllers
 * @category            UserTypes
 * @author		NexGen Innovators Dev Team
 * 
 */
class usertypes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('super-admin/usertypes_model');
    }

    /*
     * AddUserType
     * @controller usertypes
     * It used to show add usertype form
     * @param	boolean true, false
     * @param	string error codes with ERR_DELIMETER Seperated
     * @return	nothing
     * calling from
     * usertype/index form view
     */

    public function index($error = '', $_err_codes = '') { //provide a view of new usertype form
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['all_UserTypes'] = $this->usertypes_model->AllUserTypes(array("Status" => 1,"developer"=>0));
//           $this->util_model->printr($data['all_UserTypes']);
        $data['UserGroupList'] = $this->usertypes_model->get_group_list();
        $data['all_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
        $this->load->view('templates/header.php', $data);
        $this->load->view('superadmin/usertypes/add_user', $data);
        $this->load->view('templates/footer.php');
    }

    // --------------------------------------------------------------------

    /*
     * AddUserType
     * @controller usertypes
     * It used to insert usertype into db
     * @return	redirect to add_user page
     * calling from
     * usertype/index form view
     */
    public function AddUserType() {
        $FormData = $this->input->post();
        if ($FormData != NULL) {
            $FormData = $this->util_model->add_common_fields($FormData);
            $inserted = $this->usertypes_model->AddUserType($FormData);
         
            redirect(base_url() . "sp-admin/a/usertypes/" . ($inserted['succ'] ? "0/" . $inserted['_err_codes'] : "1/" . $inserted['_err_codes']));
        }
    }

    //put your code here
    /*

     *  @controller : 
     *  @function :
     *  @param1 utypeid int required
     *  @working: this form will help to load view to edit usertype
     *  @auther
     *  @link /sp-admin/a/editUtype/{user_type_id}      */
    public function editUtype($utypeid, $error = '', $_err_codes = '') { //provide a view of new usertype form) {
        global $data;
		        $data['UserGroupList'] = $this->usertypes_model->get_group_list();
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $data['utypeid'] = $utypeid;
        $this->load->view('templates/header.php', $data);
        if (isset($data['utypeid']) && $data['utypeid'] != "") {
            $data['uEditdetail'] = $this->usertypes_model->get_UserDetail($data['utypeid']);
            $this->load->view('superadmin/usertypes/edit_user', $data);
        }
        $this->load->view('templates/footer.php', $data);
    }

    /*

     *  @controller : 
     *  @function :
     *  @param1 null 
     *  @working: it will recive form data and update it in db table usertypes
     *  data is coming from editutype function
     *  @auther
     *        */

    public function updateUtype($error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        $FormData = $this->input->post();
        if ($FormData['utid'] != NULL) {
            $FormData = $this->util_model->add_mode_user($FormData);
            $updated = $this->usertypes_model->updateUtype($FormData);
            redirect(base_url() . "sp-admin/a/usertypes/" . (($updated['succ'] == FALSE) ? "1/" . $updated['_err_codes'] : "0/" . $updated['_err_codes']));
        }
    }

    public function delUtype($utypeid, $error = '', $_err_codes = '') {
        global $data;
        $data = $this->util_model->set_error($data, $error, $_err_codes);
        if ($utypeid != NULL) {
            $deleted = $this->usertypes_model->del_Utype($utypeid);

            redirect(base_url() . "sp-admin/a/usertypes/delUtype" . ($deleted['succ']==TRUE ? "1/" . $deleted['_err_codes'] : "0/" . $deleted['_err_codes']));
        }
    }

}
