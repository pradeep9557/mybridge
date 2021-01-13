<?php
 /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manage_bills
 * @Created on : 6 Jul, 2016, 5:27:34 PM
 * @author Deepak Singh
 * @Team Riding Solo
 * @copyright (c) year, Dee
 * @location
 * @Use
 * 
 */
class loginimg_library extends CI_Controller {

 
    /*public function __construct() { 
        parent::__construct();  
    } 

    public function index($task_id = "", $error = '', $_err_codes = '') {  
        global $data; 
        $data = $this->util_model->set_error($data, $error, $_err_codes); 
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/common_window_pop_up.php');
        $this->load->view('tms/manage_tasks/v_add_task.php', $data);
        $this->load->view('templates/footer.php');
    }*/ 

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_loginimg_library', 'files_model');
       // $this->load->database();
       // $this->load->helper('url');
    }
 
   /* public function index()
    {
        $this->load->view('tms/library/upload');
    }

    public function upload_file()
    {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';  
        if ($status != "error")
        {
            $config['upload_path'] = './login_image_library/';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;
     
            $this->load->library('upload', $config);
     
            if (!$this->upload->do_upload($file_element_name))
            {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            }
            else
            {
                $data = $this->upload->data();
                $file_id = $this->files_model->insert_file($data['file_name']);
                if($file_id)
                {
                    $status = "success";
                    $msg = "File successfully uploaded";
                }
                else
                {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function files()
    {
        $files = $this->files_model->get_files();
        $this->load->view('files', array('files' => $files));
    }*/
   public function index($id='',$type='') {
    global  $data;
    $this->load->view('templates/header.php', $data);
    $this->load->view('templates/common_window_pop_up.php');
    $this->load->view('tms/library/upload', $data);
    $this->load->view('templates/footer.php');
}

public function upload($id='',$type='') {
     
            if($_FILES['image']['error'] != 0) {
                $result['status'] = false;
                $result['message'] = array("image"=>"Select image to upload");
            } else {

                $config['upload_path']       = 'login_image_library';
                $config['allowed_types']     = 'gif|jpg|jpeg|png';
                $this->load->library('upload',$config);
                $this->upload->initialize($config); 
                if ($this->upload->do_upload('image'))
                { 
                    $data['upload_data'] = $this->upload->data('file_name');
                    $image_name = $data['upload_data']['file_name']; 
                }
                else
                {
                    $image_name = '';
                }
                $data = array( 
                    'filename'     => $image_name,
                    'image_series' => 1,
                    'is_show'      => 0,
                    'created_at'   => date('Y-m-d H:i:s')
                ); 
                $result['status'] = true;
                $this->db->insert('nexgen_image_library', $data);
               // $result['message'] = "Data inserted successfully.";
                $result['message'] = array("success"=>"Saved successfully."); 
            }
         
        echo json_encode($result);
}

 
    
}

