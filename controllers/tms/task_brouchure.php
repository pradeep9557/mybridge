<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of task_brouchure
 * @Created on : Jun 4, 2016, 4:08:45 PM
 * @author Ankit
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use
 * 
 */
class task_brouchure extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->model("tms/m_task_brouchure", "m_task_bro");
        $this->load->model("tms/m_task_manage", "m_task_manage");
    }

    public function create_brouchure() {
        global $data;
        // $this->load->model('emp/employee_model');
        //die($this->util_model->printr($data['assigned_to']));
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/user_task_manage/v_task_brouchure", $data);
        $this->load->view('templates/footer.php');
    }

    public function kuch_bhi() {
        global $data;
        $res = $this->m_task_bro->kuch_bhi();
        if ($res['repeat_gap'] == 0) {
            $my_date = ($res['repeat_unit'] * 7);
        } elseif ($res['repeat_gap'] == 1) {
            $my_date = ($res['repeat_unit'] * 30);
        } else {
            $my_date = ($res['repeat_unit'] * 365);
        }
        $res_data = array();
        $res_data['my_date'] = date(DB_DF, strtotime("+" . $my_date . " day", time()));
        $res = $this->m_task_bro->kuch_bhi($res_data);
        if($res!="")
        {
            $this->m_task_manage->replicate_task();
        }
        die($this->util_model->printr($res));
//        $this->util_model->printr($res['tm_']);
    }

    // start you function from here
}
