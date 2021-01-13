<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of add_data
 *
 * @author anshu
 */
class email_template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tms/m_email_template');
    }

    public function adddata() {
        global $data;

        $request = $this->input->post();
        
        if (!empty($request)) {
            if (isset($request['_action']) && $request['_action'] == 'get_data') { 
                $response = array();
                $response["alldata"] = $this->m_email_template->getdata($request);
                $response['success'] = true;
                echo json_encode($response);
                die();
            }

            if (isset($request['_action']) && $request['_action'] == 'del_data') {
                $response = array();
                $response['success'] = $this->m_email_template->deletedata($request['template_id']);
                echo json_encode($response);
                die();
            }
            $users=implode(",",$request['email_users']);
            $data_to_insert = array(
                'template_id' => isset($request['template_id']) && $request['template_id'] != '' ? $request['template_id'] : 0,
                "title" => $request['title'],
                "subject_temp"=>$request['subject_temp'],
                "template" => $request['template'],
                'sms_template'=>$request['sms_template'],
                'email_users'=>$users,
                'module_id'=>$request['module_id']
            );

            if ($request['template_id'] == '') {
                $res = $this->m_email_template->createdata($data_to_insert);
                if ($res) {
                    $json['success'] = TRUE;
                    $json['msg'] = "data inserted!!";
                } else {
                    $json['success'] = TRUE;
                    $json['msg'] = "error";
                }
            } else {
                $res = $this->m_email_template->Updatedata($request['template_id'], $data_to_insert);
                if ($res) {
                    $json['success'] = TRUE;
                    $json['msg'] = "data update!!";
                } else {
                    $json['success'] = TRUE;
                    $json['msg'] = "error";
                }
            }
            echo json_encode($json);
            die();
        }
        $this->db->select("*")->from(DB_PREFIX . "menus");
        $ser_result = $this->db->get()->result_array();
        $data['email_template']=$ser_result;
        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/email_template/v_adddata", $data);
        $this->load->view('templates/footer.php', $data);
    }

}
