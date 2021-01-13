<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_task_billing
 * @Created on : 6 Jul, 2016, 5:27:15 PM
 * @author Deepak Singh
 * @Team Riding Solo
 * @copyright (c) year, Dee
 * @location
 * @Use
 * 
 */
class m_task_billing extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    // start you function from here
    public function m_task_list($filter_data = array()) {
        $this->db->select("tm.tm_id,tm.tm_name")->from(DB_PREFIX . "task_mst as tm");

        $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type=" . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        //"tu.user_id" => $this->util_model->get_uid(),
        $this->db->where(array("tm.status" => STATUS_TRUE));
        $this->db->where("(SELECT count('bm.*') FROM `nexgen_task_billing_mst` bm WHERE bm.`status`=1 and bm.`tm_id` =tu.tm_id)=0", NULL, FALSE);
        if (!empty($filter_data) && $filter_data['client_id'] != "" && $filter_data['client_id'] != STATUS_FALSE) {
            $this->db->where("tm.client_id", $filter_data['client_id']);
        }

        if (isset($filter_data['progress_flag']) && $filter_data['progress_flag'])
            $this->db->where("tm.progress_flag", $filter_data['progress_flag']);

        $task_list = $this->db->get()->result_array();

        //echo $this->db->last_query();
        return $task_list;
    }

    public function m_tax_list(){
        $this->db->select("*")->from(DB_PREFIX. "tax");
        return $this->db->get()->result_array();
    }

    public function m_bill_list($filter_data = array()) {
        $this->db->select("tbm.bill_mst_id,CONCAT(tbm.bill_no,' (',tm.tm_name,')') as bill_number", FALSE)->from(DB_PREFIX . "task_billing_mst as tbm");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tbm.tm_id", 'left');
        $this->db->where(array("tm.status" => STATUS_TRUE));
        if (!empty($filter_data) && $filter_data['client_id'] != "" && $filter_data['client_id'] != STATUS_FALSE) {
            $this->db->where("tm.client_id", $filter_data['client_id']);
        }
        return $this->db->get()->result_array();
    }

    public function fetch_bill_data($filter_data = array()) {
//        echo "Hii";
//        $this->util_model->printr($filter_data);
//        die();
        $filter_data['page'] = isset($filter_data['page']) ? $filter_data['page'] : 0;
        if (isset($filter_data['limit']) && $filter_data['limit'] != "") {
            $this->db->limit($filter_data['limit'], $filter_data['page']);
        }
        if (isset($filter_data['client_id']) && $filter_data['client_id'] != STATUS_FALSE && $filter_data['client_id'] != 'all') {
            $this->db->where("tbm.client_id", $filter_data['client_id']);
        }
        if (isset($filter_data['tm_id']) && $filter_data['tm_id'] != STATUS_FALSE) {
            $this->db->where("tbm.tm_id", $filter_data['tm_id']);
        }
        if (isset($filter_data['bill_account_id']) && !in_array(STATUS_FALSE,$filter_data['bill_account_id'])) {
            $bill_account_id = implode(",", $filter_data['bill_account_id']);
            $this->db->where("tbm.bill_account_id in ($bill_account_id)");
        }
        
        if(isset($filter_data['start_date']) && $filter_data['end_date']){
            $filter_data['start_date'] = date(DB_DF, strtotime($filter_data['start_date']));
            $filter_data['end_date'] = date(DB_DF, strtotime($filter_data['end_date']));
            $this->db->where("(tbm.bill_due_date <='{$filter_data['end_date']}' and tbm.bill_due_date>='{$filter_data['start_date']}')",NULL,FALSE);
        }
        
        if (isset($filter_data['status']) && $filter_data['status'] != STATUS_FALSE) {
            $this->db->where("tbm.status", $filter_data['status']);
        } else {
            $this->db->where("tbm.status", STATUS_TRUE);
        }
        
        
        
        if (isset($filter_data['bill_mst_id']) && $filter_data['bill_mst_id'] != STATUS_FALSE) {
            $this->db->where(array("tbm.bill_mst_id" => $filter_data['bill_mst_id']));
        }
        $this->db->order_by("tbm.Mode_DateTime", "DESC");
        $this->db->select("bill_acc.account_title as from_acc,(select GROUP_CONCAT(tm_name SEPARATOR ',') from nexgen_task_mst where tm_id in (SELECT tbills.tm_id from nexgen_task_billnos tbills where tbills.status = 1 and tbills.bill_mst_id = tbm.bill_mst_id)) as tm_name,tm.tm_name as tm_name_old,e.Emp_Name,tbm.*,(Select IFNULL(SUM(amt_paid),0) from nexgen_task_billings where bill_mst_id = tbm.bill_mst_id and status=1) as Paid_amt", FALSE)->from(DB_PREFIX . "task_billing_mst as tbm");
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tbm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tbm.client_id=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_bill_account as bill_acc", "bill_acc.bill_account_id=tbm.bill_account_id", 'left');
        $this->db->order_by("tbm.Mode_DateTime", "DESC");
        $res = $this->db->get()->result_array();
//        echo $this->db->last_query();
//        die();
        return $res;
    }

    public function fetch_final_bill_data($filter_data = "") {
        $this->db->select("tb.*,tbm.client_id,tm.tm_name,e.Emp_Name,bill_acc.account_title as from_acc")->from(DB_PREFIX . "task_billings as tb");
        $this->db->join(DB_PREFIX . "task_billing_mst as tbm", "tb.bill_mst_id=tbm.bill_mst_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tm.tm_id=tbm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee as e", "tm.client_id=e.Emp_ID", 'left');
        $this->db->join(DB_PREFIX . "task_bill_account as bill_acc", "bill_acc.bill_account_id=tb.bill_account_id", 'left');
        if (!empty($filter_data)) {
            $this->db->where(array("tb.bill_id" => $filter_data['bill_id']));
        }
        return $this->db->get()->result_array();
    }

    public function validate_bill_data($filter_data) {
        $_err_codes = array();
        if (isset($filter_data['bill_mst_id']) && $this->util_model->get_column_value("status", DB_PREFIX . "task_billing_mst", array("bill_mst_id" => $filter_data['bill_mst_id'])) == "") {
            $_err_codes[] = "Invalid Bill Id passed!!";
        }
        if (!isset($filter_data['tm_id'])) {
            $_err_codes[] = "Invalid Task passed!!";
        }
        if (isset($filter_data['bill_amt']) && !is_numeric($filter_data['bill_amt'])) {
            $_err_codes[] = "Bill Amount to be passed In Numbers!!";
        }
        if (isset($filter_data['amt_paid']) && !is_numeric($filter_data['amt_paid'])) {
            $_err_codes[] = "Bill Amount to be passed In Numbers!!";
        }
        if (isset($filter_data['bill_no']) && $filter_data['bill_no'] == "") {
            $_err_codes[] = "Billno required without space!!";
        }
        if (isset($filter_data['ser_tax']) && $filter_data['ser_tax'] == "") {
            $_err_codes[] = "Service tax is required !!";
        }
        if (isset($filter_data['etax']) && $filter_data['etax'] == "") {
            $_err_codes[] = "Education tax is required !!";
        }
        if (isset($filter_data['ktax']) && $filter_data['ktax'] == "") {
            $_err_codes[] = "Krishi tax is required !!";
        }
        if (isset($filter_data['sort']) && $filter_data['sort'] == "") {
            $_err_codes[] = "Sort is required !!";
        }

        return array("_err_codes" => $_err_codes);
    }

    public function save_bill_master($filter_data) {

        $validation = $this->validate_bill_data($filter_data);
        if (!empty($validation['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validation['_err_codes']);
        } else {
            $this->db->trans_begin();

            $bill_master_data = array(
                "bill_account_id" => $filter_data['bill_account_id'],
                "bill_amt" => round($filter_data['bill_amt']),
                "bill_due_date" => date(DB_DF, strtotime($filter_data['bill_due_date'])),
                "bill_no" => $filter_data['bill_no'],
                "client_id" => $filter_data['client_id'],
                "serCatCode" => $filter_data['serCatCode'],
                "ser_tax" => $filter_data['ser_tax'],
                "etax" => $filter_data['etax'],
                "ktax" => $filter_data['ktax'],
                "CGST" => $filter_data['CGST'],
                "IGST" => $filter_data['IGST'],
                "SGST" => $filter_data['SGST'],
                "UTGST" => $filter_data['UTGST'],
                "billtype"=>$filter_data['billtype'],
                "place_supply"=>$filter_data['place_supply'],
                "msme_no"=>$filter_data['msme_no'],
                "ser_data" => $filter_data['ser_data'],
                "remarks" => $filter_data['remarks'],
                "company_details" => $filter_data['company_details'],
                "client_details" => $filter_data['client_details']);
            if (isset($filter_data['clients'])) {
                $bill_master_data['clients'] = implode(",", $filter_data['clients']);
            }
            $bill_master_data = $this->util_model->add_common_fields($bill_master_data);
            $this->db->insert(DB_PREFIX . "task_billing_mst", $bill_master_data);
            $inserted_id = $this->db->insert_id();
            if ($inserted_id) {
                $this->task_master_billing_done($filter_data['tm_id']);
                $this->add_into_task_bill_table($inserted_id, $filter_data['tm_id']);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
            } else {
                $this->db->trans_commit();
                return array("succ" => TRUE, "id" => $inserted_id, "_err_codes" => array("Bill saved Successfully!!"));
            }
        }
    }

    public function task_master_billing_done($tm_id = array()) {
        $this->db->where_in("tm_id", $tm_id);
        $this->db->update(DB_PREFIX . "task_mst", array("BillingDone" => 1));
        return $this->db->affected_rows();
    }

    public function update_bill_master($filter_data) {
        $this->load->model("tms/m_task_log", "m_log");
        $validation = $this->validate_bill_data($filter_data);
        if (!empty($validation['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validation['_err_codes']);
        } else {

            $this->db->trans_begin();

            $bill_data = array("bill_account_id" => $filter_data['bill_account_id'],
                "bill_no" => $filter_data['bill_no'],
                "bill_amt" => round($filter_data['bill_amt']),
                "bill_due_date" => date(DB_DF, strtotime($filter_data['bill_due_date'])),
                "bill_no" => $filter_data['bill_no'],
                "client_id" => $filter_data['client_id'],
                "serCatCode" => $filter_data['serCatCode'],
                "ser_tax" => $filter_data['ser_tax'],
                "etax" => $filter_data['etax'],
                "ktax" => $filter_data['ktax'],
                "CGST" => $filter_data['CGST'],
                "IGST" => $filter_data['IGST'],
                "SGST" => $filter_data['SGST'],
                "UTGST" => $filter_data['UTGST'],
                 "billtype"=>$filter_data['billtype'],
                "place_supply"=>$filter_data['place_supply'],
                "msme_no"=>$filter_data['msme_no'],
                "status" => $filter_data['status'],
                "ser_data" => $filter_data['ser_data'],
                "remarks" => $filter_data['remarks'],
                "company_details" => $filter_data['company_details'],
                "client_details" => $filter_data['client_details']);

            if (isset($filter_data['clients'])) {
                $bill_data['clients'] = implode(",", $filter_data['clients']);
            }
            $this->db->where(array("bill_mst_id" => $filter_data['bill_mst_id']));
            $this->db->update(DB_PREFIX . "task_billing_mst", $bill_data);

            $log_data = array("log_type" => 8, "modified_id" => serialize($filter_data['tm_id']), "modifier_id" => $this->util_model->get_uid(), "Remarks" => "Bill Data of task id in the modified_id column was modified by the user in adjecent modifier_id column!!");

            $this->m_log->punch_log($log_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
            } else {
                $this->db->trans_commit();
                return array("succ" => TRUE, "id" => $filter_data['bill_mst_id'], "_err_codes" => array("Bill Updated Successfully!!"));
            }
        }
    }

    /*

     * amoutn receving     */

    public function save_bill_final($filter_data) {
        $validation = $this->validate_bill_data($filter_data);
        if (!empty($validation['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validation['_err_codes']);
        } else {

            $this->db->trans_begin();

            $bill_data = array("bill_mst_id" => $filter_data['bill_mst_id'], "amt_paid" => $filter_data['amt_paid'], "Add_User" => $this->util_model->get_uid(), "status" => $filter_data['status'], "remarks" => $filter_data['remarks']);
            $this->db->insert(DB_PREFIX . "task_billings", $bill_data);

            $inserted_id = $this->db->insert_id();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
            } else {
                $this->db->trans_commit();
                return array("succ" => TRUE, "id" => $inserted_id, "_err_codes" => array("Bill saved Successfully!!"));
            }
        }
    }

    public function update_bill_final($filter_data) {
        $this->load->model("tms/m_task_log", "m_log");
        $validation = $this->validate_bill_data($filter_data);
        if (!empty($validation['_err_codes'])) {
            return array("succ" => FALSE, "_err_codes" => $validation['_err_codes']);
        } else {

            $this->db->trans_begin();

            $bill_data = array("status" => $filter_data['status'], "remarks" => $filter_data['remarks'], "amt_paid" => $filter_data['amt_paid'], "Mode_User" => $this->util_model->get_uid());

            $this->db->where(array("bill_id" => $filter_data['bill_id']));
            $this->db->update(DB_PREFIX . "task_billings", $bill_data);

            $log_data = array("log_type" => 8, "modified_id" => $filter_data['bill_mst_id'], "modifier_id" => $this->util_model->get_uid(), "Remarks" => "Bill Data of task id from the bill_id_mst in the modified_id column was modified by the user in adjecent modifier_id column!!");

            $this->m_log->punch_log($log_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => array("Some Error Occured,Try again!!"));
            } else {
                $this->db->trans_commit();
                return array("succ" => TRUE, "id" => $filter_data['bill_id'], "_err_codes" => array("Bill Updated Successfully!!"));
            }
        }
    }

    public function getAccount() {

        $this->db->select("bill_account_id,account_title")->from(DB_PREFIX . "task_bill_account");
        $accouts = $this->db->where("status", STATUS_TRUE)->get()->result_array();
        $list = array();
        if (!empty($accouts)) {
            foreach ($accouts as $acc) {
                $list[$acc['bill_account_id']] = $acc['account_title'];
            }
        }


        return $list;
    }

    //master start
    public function bill_account_add($billAccount) {

        $this->db->insert(DB_PREFIX . "task_bill_account", $billAccount);
        return $this->db->insert_id();
    }
    public function insertbilltype($formdata=array()) {
        $datalist = array(
          "name"=>$formdata['name'],
           'Add_DateTime'=> isset($formdata['Add_DateTime'])?date(DB_DTF, strtotime($formdata['Add_DateTime'])):date(DB_DTF)
 
        );
         $this->db->insert(DB_PREFIX . "bill_type", $datalist);
      if (!$this->db->affected_rows()) {
          return FALSE;
            }else{
                return TRUE;
            }
    }
    public function updatebilltype($formdata) {
         $datalist = array(
          "name"=>$formdata['name'],
        
        );
          $this->db->where("id", $formdata['id']);
        $this->db->update(DB_PREFIX . "bill_type", $datalist);
        if (!$this->db->affected_rows()) {
          return FALSE;
            }else{
                return TRUE;
            }
    }

    public function bill_account_dele($bill_account_id) {
        $this->db->where("bill_account_id", $bill_account_id);
        $this->db->delete(DB_PREFIX . "task_bill_account");
        return $this->db->affected_rows();
    }

    public function bill_account_update($billAccount, $bill_account_id) {
        $this->db->where("bill_account_id", $bill_account_id);
        $this->db->update(DB_PREFIX . "task_bill_account", $billAccount);
        return $this->db->affected_rows();
    }

    public function get_bill_accounts($filter = array()) {
        if (isset($filter['bill_account_id'])) {
            $this->db->where("bill_account_id", $filter['bill_account_id']);
        }
        $this->db->select("*");
        $this->db->from(DB_PREFIX . "task_bill_account");
        return $this->db->get()->result_array();
    }

    /*

     * it used in search filter     */

    public function get_from_list() {
        $this->db->select("*");
        $this->db->from(DB_PREFIX . "task_bill_account")->where(array("status" => 1));
        $list = $this->db->get()->result_array();
        $return_list = array();
        foreach ($list as $eachRow) {
            $return_list[$eachRow['bill_account_id']] = $eachRow['account_title'];
        }
        return $return_list;
    }

    public function add_into_task_bill_table($inserted_id, $task_ids) {
        $data_to_insert = array();
        foreach ($task_ids as $eachID) {
            $data_to_insert[] = array(
                "tm_id" => $eachID,
                "bill_mst_id" => $inserted_id,
                "Add_User" => $this->util_model->get_uid()
            );
        }
        $this->db->insert_batch(DB_PREFIX . "task_billnos", $data_to_insert);
    }

    public function get_unbilled_task_list($filter = array()) {
        $this->db->select("tm.tm_id,tm.tm_name")->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "employee as emp", "emp.Emp_ID=tm.client_id", 'left');
//        $this->db->group_by("tm.client_id");
        $this->db->where(array("tm.progress_flag" => COMPLETED_APPROVAL, "tm.BillingDone" => 0));
        if (isset($filter['client_id'])) {
            $this->db->where("tm.client_id", $filter['client_id']);
        }
        if (isset($filter['client_ids'])) {
            if (is_string($filter['client_ids'])) {
                $filter['client_ids'] = explode(',', $filter['client_ids']);
            }
            $this->db->where_in("tm.client_id", $filter['client_ids']);
        }
        $result = $this->db->get()->result_array();
        return $result;
//        echo $this->db->last_query();
//        $final_data = array(); 
//        if (!empty($result)) {
//            foreach ($result as $value) {
//                $final_data[$value['tm_id']] = $value['tm_name'];
//            }
//        }
//        return $final_data;
    }

    public function m_bill_get_tasks($bill_mst_id) {
        $result = $this->db->where(array("bill_mst_id" => $bill_mst_id))->get(DB_PREFIX . "task_billnos")->result_array();
        $t_ids = array();
        foreach ($result as $eachOne) {
            $t_ids[] = $eachOne['tm_id'];
        }
        return $t_ids;
    }

    public function delete_bill($filter) {
        $bill_mst_id = $filter['bill_mst_id'];
        $this->db->trans_begin();
        $this->db->query("update nexgen_task_mst set billingDone = 0 
            where tm_id in (SELECT tm_id FROM  `nexgen_task_billnos` WHERE  `bill_mst_id` =$bill_mst_id)");
        $this->db->query("DELETE FROM `nexgen_task_billnos` WHERE `bill_mst_id` = $bill_mst_id");
        $this->db->query("DELETE FROM `nexgen_task_billing_mst` WHERE `bill_mst_id` = $bill_mst_id");
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("succ" => FALSE, "_err_codes" => "Some Error Occured,Try again!!");
        } else {
            $this->db->trans_commit();
            return array("succ" => TRUE, "_err_codes" => "Bill deleted Successfully!!");
        }
    }
  public function get_err_codes() {
        return $this->_err_codes;
    }
     public function delbilltype($id) { 
       
        if($this->db->delete(DB_PREFIX. 'bill_type',array('id'=>$id['id']))){
            return TRUE;
        }
        $this->_err_codes = 'Error while deleting your request';
        return FALSE;
    }
    public function getbilltype() {
       $res = $this->db->get(DB_PREFIX . "bill_type")->result_array();
       $list = array("0"=>"--select--");
       foreach ($res as $key => $value) {
           $list[$value['id']]=$value['name'];
       }
       return $list;
    }
}
