<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of delete_controller
 *
 * @author Anup kumar
 */
class delete_controller  extends CI_Controller{
    //put your code here
     function cdel_enq($E_Code){
         global $data;
         $this->util_model->printr($data['cnf']);
         $this->load->model('m_enquiry');
         return $this->m_enquiry->del_enq($E_Code);
    }
}
