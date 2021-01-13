<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author Anup kumar
 */
class auth_hook extends CI_Controller {

    public function check() {
        
        global $data;
        $this->load->model('emp/employee_model');
        $data['title'] = "";
        date_default_timezone_set('Asia/Kolkata');
        $data['Session_Data'] = $this->session->all_userdata();
        $data['cnf'] = array($this->router->fetch_class(), $this->router->fetch_method());

        if ($data['cnf'][0] != "auth") { 
            $allowed_cont = array("manage_users","mis_report","manage_sub_task",'upload_data');
            $allowed_fun = array("OverDueTask","DailyTaskEntryByTeam","DailyTaskReport","get_pending_sub_task",'track');
            if (in_array($data['cnf'][0], $allowed_cont) && in_array($data['cnf'][1], $allowed_fun)) {
                // safe
            } else {
                $data['Session_Data']['LOGIN_STATUS'] = isset($data['Session_Data']['LOGIN_STATUS']) ? $data['Session_Data']['LOGIN_STATUS'] : FALSE;
                if (!$data['Session_Data']['LOGIN_STATUS']) {
                    redirect(base_url() . 'auth/login/1');
                } else {
                    if (!$this->employee_model->get_emp_details_via_emp_id($data['Session_Data']['IBMS_USER_ID']))
                        redirect(base_url() . "auth/Logout");
                    /* check whether this module accessible or not */
                    $auth = $this->util_model->is_auth_for_this();

//          print_r($data['cnf']);
//          print_r($auth);
//          die();
                    if (!$auth['auth']) {
//             echo "sorry Not Auth";
//             die();
                        echo json_encode(array("succ" => FALSE, "_err_codes" => "You don't have the access this!!"));
                        die();
//             $this->util_model->printr($data['cnf']);
//               header("HTTP/1.1 404 Not Found");
//            redirect(base_url("auth/access_forbidden"), "refresh", "404");
//              show_404("auth/access_forbidden.php");
                    } else {
                        // echo "authrized";
                        $data['title'] = isset($auth['title']) ? $auth['title'] : '';
                    }
                    /* end of module accessiblity */
                    /* Allowed Branches */

                    $data['a_branches'] = $this->util_model->branch_list_with_branch_Cat($data['Session_Data']);
                    /* end of allowed branches */
                    /* allowed menues */

                    $data['MenuList'] = $this->util_model->ShowMenus(0, $data['Session_Data']['IBMS_BRANCHID'], $data['Session_Data']['IBMS_USER_TYPE'], 1, 1);
                    /* end of allowed Menu */

                    $data['bread_crum'] = $this->util_model->get_breadcrum();
                    //$this->util_model->printr($data['cnf']);
                    /* current branch details */
                    $data['Branch_obj'] = $this->util_model->get_branch_details($data['Session_Data']['IBMS_BRANCHID']);
                    /* End of current branch details */
                }
            }
        }
        // $data['MenuTable']=  $this->m_menu->ShowMenus(0,$data['Session_Data']['IBMS_BRANCHID'],$data['Session_Data']['IBMS_USER_TYPE']);            
        //$this->util_model->printr($data['Branch_obj']);
        // $this->util_model->printr($data);
    }

}
