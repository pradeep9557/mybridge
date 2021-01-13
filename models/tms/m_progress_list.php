<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_progress_list
 *
 * @author anshu
 */
class m_progress_list extends CI_Model {

    //put your code here
    public function getdata($data = array()) {
//       $this->db->select("np.*");
//        $this->util_model->printr($data);
        $this->db->select("np.*,nm.title,nm.template,nm.sms_template,nm.subject_temp");
        $this->db->from(DB_PREFIX."progress_list_mst np");
        $this->db->join(DB_PREFIX.'email_templates nm', 'np.template_id = nm.template_id', 'left');
        if (isset($data['p_id']) && $data['p_id'] != '') {
            $this->db->where("p_id", $data['p_id']);
            return $this->db->get()->row_array();
        }
       
        $this->db->where('np.p_type','Email_Template');
        return $this->db->get()->result_array();
    }

    public function gettemp($data = array()) {
        $this->db->select("nm.*");
        $this->db->from(DB_PREFIX."email_templates nm");
        return $this->db->get()->result_array();
    }

    public function createdata($data = array()) {
        $this->db->insert(DB_PREFIX.'progress_list_mst', $data);
        return $this->db->insert_id();
    }

    public function Updatedata($p_id = 0, $data = array()) {
        $this->db->where('p_id', $p_id);
        $this->db->update(DB_PREFIX.'progress_list_mst', $data);
        return $this->db->affected_rows();
    }

    public function deletedata($p_id = 0) {
        $this->db->where('p_id', $p_id);
        return $this->db->delete(DB_PREFIX."progress_list_mst");
//        return $this->db->affected_rows();
    }

}
