<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Mr. Anup
 */
class print_jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('emp/employee_model');
    }

}
