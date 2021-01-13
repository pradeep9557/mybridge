<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_template
 *
 * @author intern
 */
class m_template extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function fetch_menu() {
        return $this->db->select("menuid,htmlid,m_heading_text,div_heading_text")->from("nexgen_faqs_menus")->get()->result_array();
//         echo '<pre>';
//         print_r($result);
//        echo '</pre>';
    }

//    public function fetch_ques() {
//        $this->db->select("question,fqid,ans,fm.menuid,fm.div_heading_text");
//        $this->db->from("nexgen_faq_questions");
//        $this->db->join("nexgen_faqs_menus fm","nexgen_faq_questions.menuid = fm.menuid");
//        $query = $this->db->get()->result_array();
//        return $query;
//        echo '<pre>';
//        echo $this->db->last_query();
//        echo '</pre>';
//    }

    public function ques_menuid($menuid) {
        $this->db->select("menuid,question,ans");
        $this->db->from("nexgen_faq_questions");
        $this->db->where("nexgen_faq_questions.menuid", $menuid);
        $ques = $this->db->get()->result_array();
        return $ques;
    }

}
