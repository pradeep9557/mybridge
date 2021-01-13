<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of progress_list
 *
 * @author anshu
 */
class progress_list extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tms/m_progress_list');
    }

    public function index() {
        global $data;

        $request = $this->input->post();
//          print_r($request);
//          die();
        if (!empty($request)) {


            if (isset($request['_action']) && $request['_action'] == 'get_client_noti_data') {
                $response = array();
                $this->load->model('tms/m_client_noti', 'm_noti');
                $response['client_noti_list'] = $this->m_noti->get_client_noti(array('client_id' => $request['client_id']));
                $response['success'] = true;
                echo json_encode($response);
                die();
            }

            if (isset($request['_action']) && $request['_action'] == 'notify_action') {
                $this->notify_action();
            }



            if (isset($request['_action']) && $request['_action'] == 'get_data') {
                $response = array();
                $response['alldata'] = $this->m_progress_list->getdata($request);
                $response['alltempdata'] = $this->m_progress_list->gettemp();
                $response['success'] = true;
                echo json_encode($response);
                die();
            }

            if (isset($request['_action']) && $request['_action'] == 'del_data') {
                $response = array();
                $response['success'] = $this->m_progress_list->deletedata($request['p_id']);
                echo json_encode($response);
                die();
            }


            $data_to_insert = array(
                'p_id' => isset($request['p_id']) && $request['p_id'] != '' ? $request['p_id'] : 0,
                "p_name" => $request['p_name'],
                "p_desc" => $request['p_desc'],
//                "p_type" => $request['p_type'],
                "template_id" => $request['template_id'],
            );

//                print_r($data_to_insert);
//                die();
            if ($request['p_id'] == '') {
                $res = $this->m_progress_list->createdata($data_to_insert);
                if ($res) {
                    $json['success'] = TRUE;
                    $json['msg'] = "data inserted!!";
                } else {
                    $json['success'] = TRUE;
                    $json['msg'] = "error";
                }
            } else {
                $res = $this->m_progress_list->Updatedata($request['p_id'], $data_to_insert);
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

        $this->load->view('templates/header.php', $data);
        $this->load->view("tms/client_progress/v_progress_list", $data);
        $this->load->view('templates/footer.php', $data);
    }
    

}
