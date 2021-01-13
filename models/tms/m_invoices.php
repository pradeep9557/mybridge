<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_invoices
 *
 * @author User
 */
class m_invoices extends CI_Model {

    //put your code here
    public function get_bill_types() {
        return array("0" => "Fresh Bills", "1" => "Invoice Generated", "2" => "Both");
    }

    /*

     * calling by ajax when we send client and type of bill from invoice generate form     */

    public function get_bills($formData) {
        if (isset($formData['client_id']) && $formData['client_id'] != "") {
            $this->db->where("bm.client_id", $formData['client_id']);
        }
        if (isset($formData['billType']) && $formData['billType'] != "" && ($formData['billType'] == 0 || $formData['billType'] == 1)) {
            $this->db->where("bm.invoice_gen", $formData['billType']);
        }


        $this->db->select("bm.bill_mst_id,bm.bill_no,bm.invoice_gen")->from(DB_PREFIX . "task_billing_mst bm");
        $result = $this->db->get()->result_array();
        foreach ($result as $key => $eachRow) {
            $eachRow['option_text'] = $eachRow['bill_no'] . ($eachRow['invoice_gen'] ? "(Generated)" : "(Fresh)");
            $result[$key] = $eachRow;
        }
        return array("succ" => TRUE, "list_data" => $result);
    }

    /*

     * invoice data     */

    public function get_invoice_data($formData) {
        if (isset($formData['client_id']) && $formData['client_id'] != "") {
            $this->db->where("bm.client_id", $formData['client_id']);
        }
        if (isset($formData['billType']) && $formData['billType'] != "" && ($formData['billType'] == 0 || $formData['billType'] == 1)) {
            $this->db->where("bm.invoice_gen", $formData['billType']);
        }
        if (isset($formData['bills_ids']) && !empty($formData['bills_ids'])) {
            $this->db->where_in("bm.bill_mst_id", $formData['bills_ids']);
        }
        $this->db->select("bm.*,b_acc.*,e_client.client_billing_name,e_client.client_billing_add1,e_client.client_billing_add2")->from(DB_PREFIX . "task_billing_mst bm");
        $this->db->join(DB_PREFIX . "task_bill_account b_acc", "bm.bill_account_id = b_acc.bill_account_id");
        $this->db->join(DB_PREFIX . "employee e_client", "bm.client_id = e_client.Emp_ID");

        $result = $this->db->get()->result_array();
        foreach ($result as $key => $eachBill) {
            $eachBill['billing_task_details'] = $this->get_billing_task_details(array("bill_mst_id" => $eachBill['bill_mst_id']));
            $result[$key] = $eachBill;
        }
        return $result;
    }

    /*

     * it will retur nthe details of billing_task table details     */

    public function get_billing_task_details($formData = array()) {
        if (isset($formData['bill_mst_id']) && $formData['bill_mst_id'] != "") {
            $this->db->where("bnos.bill_mst_id", $formData['bill_mst_id']);
        }
        $this->db->select("bnos.*,tm.tm_name,tm.ttm_id")->from(DB_PREFIX . "task_billnos bnos");
        $this->db->join(DB_PREFIX . "task_mst tm", "tm.tm_id = bnos.tm_id");
        $b_result = $this->db->get()->result_array();
        foreach ($b_result as $key => $eachRow) {
            $eachRow['services'] = $this->get_services(array("ttm_id" => $eachRow['ttm_id']));
            $b_result[$key] = $eachRow;
        }
        return $b_result;
    }

    /*

     * we will pass ttm it will return the ttm of that     */

    public function get_services($filter) {
        if (isset($filter['ttm_id']) && $filter['ttm_id'] != "") {
            $this->db->where("ser_mst.ttm_id", $filter['ttm_id']);
        }

        $this->db->select("ser_mst.*")->from(DB_PREFIX . "biling_services_mst ser_mst");
        $this->db->where(array("status" => 1));
        $ser_result = $this->db->get()->result_array();
        return $ser_result;
    }

    public function delete_service($serCatCode) {
        if ($this->db->delete(DB_PREFIX . "biling_services_mst", array("serCatCode" => $serCatCode))) {
            return "Service Deleted successfully";
        }
    }

    public function insert_update_services($formData) {
        //str_replace(" ", "_", trim($formData['serCatCode']))
        $this->delete_service(str_replace(" ", "_", trim($formData['serCatCode'])));

        $data_to_insert = array();
        $i = 0;
        foreach ($formData['service_name'] as $eachSerName) {
            if (isset($formData['amt'][$i]) && $formData['amt'][$i] != "") {
                $data_to_insert[] = $this->util_model->add_common_fields(array(
                    "serCatCode" => str_replace(" ", "_", trim($formData['serCatCode'])),
                    "serCatName" => trim($formData['serCatName']),
                    "ttm_id" => $formData['ttm_id'],
                    "service_name" => $eachSerName,
                    "amt" => $formData['amt'][$i],
                    "sort" => isset($formData['sort'][$i]) ? $formData['sort'][$i] : 15,
                    "status" => $formData['status']
                ));
            }
        }
//        $this->util_model->printr($formData);
//        $this->util_model->printr($data_to_insert);
        $this->db->insert_batch(DB_PREFIX . "biling_services_mst", $data_to_insert);
        return $this->db->affected_rows();
    }

    public function get_last_services($filter = array()) {
        if (isset($filter['bill_ser_id'])) {
            $this->db->where("bill_ser_id", $filter['bill_ser_id']);
        }
        if (isset($filter['group_by'])) {
            $this->db->group_by($filter['group_by']);
        }
        if (isset($filter['serCatCode'])) {
            $this->db->where("serCatCode", $filter['serCatCode']);
        }

        return $this->db->get(DB_PREFIX . "biling_services_mst")->result_array();
    }

}
