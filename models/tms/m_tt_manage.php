<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_manage
 * @Created on : 24 May, 2016, 12:05:27 PM
 * @author Deepak Singh
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @Use MANAGE TASK TYPE
 * 
 */
class m_tt_manage extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    //validation
    function create_validate($form_data) {
        $_err_codes = array();
        if (isset($form_data['ttm_name']) && $form_data['ttm_name'] == "") {
            $_err_codes[] = "Task Name Cannot be left Empty";
        }
        if (isset($form_data['parent_ttmid']) && $form_data['parent_ttmid'] == STATUS_FALSE) {
            $_err_codes[] = "One Parent Needs to be selected";
        }
        if (isset($form_data['ttm_code']) && $form_data['ttm_code'] == "") {
            $_err_codes[] = "Task Category Code Can't Be Left Blank";
        }
        $valid = empty($_err_codes) ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $_err_codes);
    }

    function category_validate($form_data) {
        $_err_codes = "";
        if (isset($form_data['ttm_name']) && $form_data['ttm_name'] == "") {
            $_err_codes.= "T_CatNameBlank" . ERR_DELIMETER;
        }

        if ($form_data['ttm_code'] == "" || $this->util_model->get_column_value('status', DB_PREFIX . 'task_type_mst', array("ttm_code" => $form_data['ttm_code'])) != "") {
            $_err_codes.= "T_CatCodeBlank" . ERR_DELIMETER;
        }
        $valid = ($_err_codes == "") ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $_err_codes);
    }

    function category_update_validate($form_data) {
        // die($this->util_model->printr($form_data));
        $this->db->select('ttm_code')->from(DB_PREFIX . "task_type_mst");
        $this->db->where("ttm_id", $form_data['ttm_id']);
        $db_data = $this->db->get()->row_array();

        // die($this->util_model->printr($ttm_code));
        $_err_codes = "";
        if (isset($form_data['ttm_name']) && $form_data['ttm_name'] == "") {
            $_err_codes.= "T_CatNameBlank" . ERR_DELIMETER;
        }

        if (isset($form_data['ttm_code']) && $form_data['ttm_code'] == "") {
            $_err_codes.= "T_CatCodeBlank" . ERR_DELIMETER;
        }


        if ($form_data['ttm_code'] != $db_data['ttm_code']) {
            if ($this->util_model->get_column_value('status', DB_PREFIX . 'task_type_mst', array("ttm_code" => $form_data['ttm_code'])) != "") {
                $_err_codes.= "T_CatCodeBlank" . ERR_DELIMETER;
            }
        }
        $valid = ($_err_codes == "") ? TRUE : FALSE;
        return array("_err" => $valid, "_err_codes" => $_err_codes);
    }

    // start you function from here
    public function create_task_type($filter_data) {
        if (isset($filter_data['category']) && $filter_data['category'] == TRUE) {
            $validate = $this->category_validate($filter_data); // validating the  task type form
            if ($validate['_err_codes'] != "") {
                return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
            } else {
                unset($filter_data['category']);
                $filter_data = $this->util_model->add_common_fields($filter_data);
                $this->db->insert(DB_PREFIX . "task_type_mst", $filter_data);
                $id = $this->db->insert_id();
                if ($this->db->affected_rows()) {
                    return array("succ" => TRUE, "insert_id" => $id, "_err_codes" => "T_CatAddSucc");
                } else {
                    return array("succ" => FALSE, "_err_codes" => "T_CatAddErr" . ERR_DELIMETER);
                }
            }
        } else {
            $validate = $this->create_validate($filter_data); // validating the  task type form
            if (!empty($validate['_err_codes'])) {
                return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
            } else {
                $filter_data = $this->util_model->add_common_fields($filter_data);
                $this->db->insert(DB_PREFIX . "task_type_mst", $filter_data);
                $id = $this->db->insert_id();
                if ($this->db->affected_rows()) {
                    return array("succ" => TRUE, "insert_id" => $id, "_err_codes" => array("Task Category Created!!"));
                } else {
                    return array("succ" => FALSE, "_err_codes" => array("Error in Creating task Category!!"));
                }
            }
        }
    }

    public function update_task_type($filter_data) {
        $id = $filter_data['ttm_id'];
        // unset($filter_data['ttm_id']);
        if (isset($filter_data['category']) && $filter_data['category'] == TRUE) {
            $validate = $this->category_update_validate($filter_data); // validating the update task type form
            if ($validate['_err_codes'] != "") {
                return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
            } else {
                unset($filter_data['ttm_id']);
                unset($filter_data['category']);
                $filter_data = $this->util_model->add_mode_user($filter_data);
                $this->db->where(array("ttm_id" => $id, "status" => STATUS_TRUE));
                if ($this->db->update(DB_PREFIX . "task_type_mst", $filter_data)) {
                    return array("succ" => TRUE, "insert_id" => $id, "_err_codes" => "ExpUpdateSucc");
                } else {
                    return array("succ" => FALSE, "_err_codes" => "C_CatAddErr" . ERR_DELIMETER);
                }
            }
        } else {
            $validate = $this->create_validate($filter_data); // validating the update task type form
            if (!empty($validate['_err_codes'])) {
                return array("succ" => FALSE, "_err_codes" => $validate['_err_codes']);
            } else {
                $filter_data = $this->util_model->add_mode_user($filter_data);
                $this->db->where(array("ttm_id" => $id, "status" => STATUS_TRUE));
                if ($this->db->update(DB_PREFIX . "task_type_mst", $filter_data)) {
                    return array("succ" => TRUE, "insert_id" => $id, "_err_codes" => array("Task Category Updated!!"));
                } else {
                    return array("succ" => FALSE, "_err_codes" => array("Task Category Update Erorr!!"));
                }
            }
        }
    }

    public function create_sub_task_type($filter_data) {
        $this->db->insert_batch(DB_PREFIX . "task_type_sub_task_mst", $filter_data);
        if ($this->db->affected_rows()) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE, "_err_codes" => "SubTTInsErr" . ERR_DELIMETER);
        }
    }

    public function manage_sub_task_update($filter_data) {
        $this->db->where("ttm_id", $filter_data['ttm_id']);
        $this->db->where_not_in("ttstm_id", $filter_data['ttstm_id']);
        $this->db->update(DB_PREFIX . "task_type_sub_task_mst", $this->util_model->add_mode_user(array("status" => STATUS_FALSE)));
    }

    public function update_sub_task_type($filter_data) {
        $this->db->trans_start();
        $this->db->update_batch(DB_PREFIX . "task_type_sub_task_mst", $filter_data, "ttstm_id");
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? array("succ" => FALSE, "_err_codes" => "Data Save Error!!") : array("succ" => TRUE);
    }

    public function create_doc_for_task($filter_data) {
        $this->db->insert_batch(DB_PREFIX . "task_type_doc_req_mst", $filter_data);
        if ($this->db->affected_rows()) {
            return array("succ" => TRUE);
        } else {
            return array("succ" => FALSE);
        }
    }

    public function manage_doc_update($filter_data) {
        $this->db->where("ttm_id", $filter_data['ttm_id']);
        $this->db->where_not_in("ttmdoc_id", $filter_data['ttmdoc_id']);
        $this->db->update(DB_PREFIX . "task_type_doc_req_mst", $this->util_model->add_mode_user(array("status" => STATUS_FALSE)));
    }

    public function update_docs($filter_data) {
        $this->db->trans_start();
        $this->db->update_batch(DB_PREFIX . "task_type_doc_req_mst", $filter_data, "ttmdoc_id");
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? array("succ" => FALSE, "_err_codes" => "Data Save Error!!") : array("succ" => TRUE);
    }

    public function get_task_data($id) {

        $this->db->select("*")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("ttm_id" => $id, "status" => STATUS_TRUE));
        $result = $this->db->get()->row_array();
        if (!empty($result)) {
            $result['sub_task_data'] = $this->fetch_sub_task_data($result['ttm_id']);
            $result['docs_data'] = $this->fetch_doc_data($result['ttm_id']);
        }
        return $result;
    }

    public function fetch_sub_task_data($id = "") {
        $this->db->select("*")->from(DB_PREFIX . "task_type_sub_task_mst");
        $this->db->where(array("status" => STATUS_TRUE, "ttm_id" => $id));
        return $this->db->get()->result_array();
    }

    public function fetch_doc_data($id = "") {
        $this->db->select("*")->from(DB_PREFIX . "task_type_doc_req_mst");
        $this->db->where(array("status" => STATUS_TRUE, "ttm_id" => $id));
        return $this->db->get()->result_array();
    }

    public function get_task_code($filter_data) {
        $MainCat_Code = strtoupper(substr(trim($filter_data['task_name']), 0, 3));
        $like = $MainCat_Code . date("y", strtotime("+5 hours"));
        $query = $this->db->select('ttm_code')->from(DB_PREFIX . "task_type_mst")->where("ttm_code like '%$like%'")->order_by('ttm_id', 'DESC')->limit(1);
        $result = $query->get()->result();
        if (!empty($result)) {
            $code = substr($result[0]->ttm_code, 3) + 1;
            return array("succ" => TRUE, "code" => $MainCat_Code . $code);
        } else {
            return array("succ" => TRUE, "code" => $like . "0001");
        }
    }

    /*

     * function get_TCatcode
     * $filter_data :  array
     * task_name : varchar
     * return a unquie string from database.
     * @auther : anup
     * DateTime 9 June 2016 10:57 am
     * callers :
     * 1. create main task category view
     *      */

    public function get_TCatcode($filter_data) {
//        echo $filter_data['task_name'];die();
      //  echo substr(trim(str_replace(" ", "", $filter_data['task_name'])),0,5); die();
        $MainCat_Code = strtoupper(substr(trim(str_replace(" ", "", $filter_data['task_name'])), 0, 5));
        $query = $this->db->select('*')->from(DB_PREFIX . "task_type_mst")->where(array("ttm_code" => $MainCat_Code));
        $result = $query->get()->result();
        if (!empty($result)) {
            //echo substr($MainCat_Code, 0, 3);
            return $this->get_TCatcode(array("task_name" => substr($MainCat_Code, 0, 3). rand(0, 99)) );
        } else {
            return array("succ" => TRUE, "code" => $MainCat_Code);
        }
    }

    /*

     * display created task list
     * fun name get_taskCat_list
     * return array of object
     * 1. main task cat list
     * 2.      */

    public function get_taskCat_list($filter_data) {
        if (!empty($filter_data)) {
            if (isset($filter_data['Status'])) {
                $this->db->where("t1.Status", $filter_data['Status']);
            }
            if (isset($filter_data['parent_ttmid'])) {
                $this->db->where("t1.parent_ttmid", $filter_data['parent_ttmid']);
            }
            if (isset($filter_data['extra_where'])) {
                $this->db->where($filter_data['extra_where'], NULL, FALSE);
            }
            if (isset($filter_data['OrderCol'])) {
                $this->db->order_by($filter_data['OrderCol'], "ASC");
            }
            if (isset($filter_data['limit'])) {
                $this->db->limit(0, $filter_data['limit']);
            }
        }
        $this->db->select("t1.*,t2.UserName as AddUserCode,t4.ttm_name as PCatName,t3.UserName as ModeUserCode")->from(DB_PREFIX . "task_type_mst t1");
        $this->db->join(DB_PREFIX . "task_type_mst t4", "t4.ttm_id=t1.parent_ttmid", "left");
        $this->db->join(DB_PREFIX . "employee t2", "t1.Add_User=t2.Emp_ID", "left");
        $this->db->join(DB_PREFIX . "employee t3", "t1.Mode_User=t3.Emp_ID", "left");
        $this->db->order_by("t1.Mode_DateTime", "DESC");
        return $this->db->get()->result();
        // echo $this->db->last_query();
    }

    public function get_parent_code($filter_data) {
        $this->db->select("ttm_code")->from(DB_PREFIX . "task_type_mst");
        $this->db->where(array("ttm_id" => $filter_data['ttm_id']));
        $res = $this->db->get()->row_array();
        if (!empty($res)) {
            return array("succ" => TRUE, "code" => strtoupper($res['ttm_code']));
        } else {
            return array("succ" => FALSE);
        }
    }

}
