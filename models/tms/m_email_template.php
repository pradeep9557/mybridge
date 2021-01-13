<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_add_data
 *
 * @author anshu
 */
class m_email_template extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function createdata($data = array()) {
        $this->db->insert('nexgen_email_templates', $data);
        return $this->db->insert_id();
    }

    public function deletedata($template_id = 0) {
        $this->db->where('template_id', $template_id);
        return $this->db->delete("nexgen_email_templates");
//        return $this->db->affected_rows();
    }

    public function getdata($data = array()) {

        $this->db->select("*");
        $this->db->from("nexgen_email_templates");
        if (isset($data['template_id']) && $data['template_id'] != '') {
            $this->db->where("template_id", $data['template_id']);
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

    public function Updatedata($template_id = 0, $data = array()) {
        $this->db->where('template_id', $template_id);
        $this->db->update('nexgen_email_templates', $data);
        return $this->db->affected_rows();
    }

}
