<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_ip
 *
 * @author SMFARHAN
 */
class c_ip extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('ip/m_ip');
    }

    public function index() {
        global $data;
        $postData = $this->input->post();
        if (!empty($postData) && !isset($postData['type'])) {
            if (isset($postData['_action']) && $postData['_action'] == 'updateStatus') {
                if ($this->m_ip->updateSystemCode(array('status' => $postData['status']), $postData['id'])) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Action done successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_ip->get_err_codes()));
                }
                die();
            }
              if (isset($postData['_action']) && $postData['_action'] == 'del_ip') {
                if ($this->m_ip->del_ips_msg($postData['id'])) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Deleted successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_ip->get_err_codes()));
                }
                die();
            }
            $data['systemCodeList'] = $this->m_ip->getSystemCodeMstData($postData);
//            echo $this->db->last_query();
            echo json_encode(array('succ' => TRUE, 'html' => $this->load->view('ip_mst/result', $data, TRUE)));
            die();
        }else if(!empty($postData) && isset($postData['type']) && $postData['type']=='del'){
            if ($this->m_ip->bulkdel_ips_msg($postData['log_id'])) {
                    echo json_encode(array('succ' => TRUE, "_err_codes" => 'Deleted successfully!'));
                } else {
                    echo json_encode(array('succ' => FALSE, "_err_codes" => $this->m_ip->get_err_codes()));
                }
                die(); 
        }
        $data['emp_list']= $this->m_ip->getEmplist();
        $this->load->view('templates/header.php', $data);
        $this->load->view('ip_mst/index.php', $data);
        $this->load->view('templates/footer.php');
    }

}
