<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of qualification
 * @author Mr. Anup
 */
class fee_collect_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*

     * Inserting Course Fee Plan               */

    public function insert_cpf($FormData) {
        global $data;
        $data_to_insert = array();
        $trow = $FormData['total_row'];
        for ($i = 0; $i < $trow; $i++) {
            $BRANCHID = $data['Session_Data']['IBMS_BRANCHID'];
            $CourseID = $FormData['CourseID'][$i];
            $PackageID = $FormData['PackageID'][$i];
            if (!$this->util_model->check_aready_exits(DB_PREFIX . "fee_course_plan", array("BranchID" => $BRANCHID, "PackageID" => $PackageID, "CourseID" => $CourseID,))) {
                if ($BRANCHID != "" && $PackageID != "" && $CourseID != "" && $FormData['FeeTypeID'][$i] != "" && $FormData['Inst_amt'][$i] != "" && $FormData['Total_Inst'][$i] != "") {
                    $row = array();
                    $row = array(
                        "BranchID" => $BRANCHID,
                        "PackageID" => $PackageID,
                        "CourseID" => $CourseID,
                        "FeeTypeID" => $FormData['FeeTypeID'][$i],
                        "Inst_amt" => $FormData['Inst_amt'][$i],
                        "Total_Inst" => $FormData['Total_Inst'][$i],
                        "Sort" => $FormData['Sort'][$i],
                        "Remarks" => $FormData['Remarks'][$i]);
                    $row = $this->util_model->add_common_fields($row);
                    $data_to_insert[] = $row;
                }
            }
        }
        //die($this->util_model->printr($data_to_insert));
        if (empty($data_to_insert)) {
            return array("succ" => FALSE, "_err_codes" => "CouFeePlanalready_exits" . ERR_DELIMETER);
        }
        if ($this->db->insert_batch(DB_PREFIX . "fee_course_plan", $data_to_insert)) {
            return array("succ" => TRUE, "_err_codes" => "SuccCouFeePlanAdd");
        } else {
            return array("succ" => FALSE, "_err_codes" => "ErrCouFeePlanAdd" . ERR_DELIMETER);
        }
    }

    /*

     * to get all fee plan
     * $filter_data is an associative array
     * ['BranchID'] = > required indexive array of BranchID
     * ['CourseID'] = > optional indexive array of courseid
     * ['PackageID'] = > optional indexive array of packageID
     * ['status']=>optional string
     * ['orderby']= column name string 
     * ['sort'] = DESC       /
     */

    public function get_all_course_fee_plan($filter_data) {
        //$this->util_model->printr($filter_data);
        $this->db->where_in("cfp.BranchID", $filter_data['BranchID']);

        if (isset($filter_data['CourseID']) && is_array($filter_data['CourseID']))
            $this->db->where_in("cfp.CourseID", $filter_data['CourseID']);

        if (isset($filter_data['PackageID']) && is_array($filter_data['PackageID']))
            $this->db->where_in("cfp.PackageID", $filter_data['PackageID']);

        if (isset($filter_data['Status'])) {
            $this->db->where("cfp.Status", 1);
        }

        if (isset($filter_data['orderby'])) {
            $sort = isset($filter_data['sort']) ? $filter_data['sort'] : "DESC";
            $this->db->order_by($filter_data['orderby'], $sort);
        }

        $this->db->select("cfp.BranchID, cfp.PackageID, cfp.CourseID, cfp.FeeTypeID, cfp.Status, cfp.Sort, cfp.Inst_amt, cfp.Total_Inst,cfp.Remarks,"
                . "bm.BranchCode,"
                . "fpp.PackageCode,"
                . "ftm.FeeType_Code,"
                . "cm.CourseCode")->from(DB_PREFIX . "fee_course_plan cfp");
        $this->db->join(DB_PREFIX . "branch_mst bm", "cfp.BranchID=bm.BranchID", "left");
        $this->db->join(DB_PREFIX . "fee_planpackages fpp", "cfp.PackageID=fpp.PackageID", "left");
        $this->db->join(DB_PREFIX . "fee_type_mst ftm", "cfp.FeeTypeID=ftm.FeeTypeID", "left");
        $this->db->join(DB_PREFIX . "course_mst cm", "cfp.CourseID=cm.CourseID", "left");
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    /*
      del_cpf
     * required array 
     *  $filter_to_delete = array("CourseID" => $data_to_delete['CID'],
      "PackageID" => $data_to_delete['PackageID'],
      "BranchID" => $data_to_delete['BranchID']);
     */

    function del_cfp($filter_to_delete) {

        if ($this->db->delete(DB_PREFIX . "fee_course_plan", array("CourseID" => $filter_to_delete['CourseID'],
                    "PackageID" => $filter_to_delete['PackageID'],
                    "BranchID" => $filter_to_delete['BranchID']))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /*
      del_scpf
     * required array 
     *  $filter_to_delete = array("scfpID" => $data_to_delete['CID']);
     */

    function del_scfp($filter_to_delete) {

        if ($this->db->delete(DB_PREFIX . "fee_individual_plan", array("ID" => $filter_to_delete['scfpID']))) {
            return array(TRUE, "Deleted Successfully !!");
        } else {
            return array(FALSE, "Error while Deleting !!");
        }
    }

    /*

     * It would find fee plan has been setting or not */

    public function is_record_exits_in_fee_plan_table($Stu_ID, $CourseID) {
        global $data;
        $branchID = $data['Session_Data']['IBMS_BRANCHID'];
        $custom_plan = $price = $this->db->select('custom_fee_plan_4_stu')
                ->get_where(DB_PREFIX . 'branch_settings', array('BranchID' => $branchID))
                ->row_array();

        $custom_plan = empty($custom_plan) ? 0:$custom_plan['custom_fee_plan_4_stu'];


        $this->db->select('*')->from(DB_PREFIX . 'fee_individual_plan')->where(array("Stu_ID" => $Stu_ID, "CourseID" => $CourseID));
//                            $this->db->get();
//                            echo $this->db->last_query();
//                            die();
        if ($this->db->count_all_results()) {
            return TRUE;
        } else {
            // branch setting 1
            if ($custom_plan) {
                return FALSE;
            } else {
                if ($this->insert_default_fees_plan($Stu_ID, $CourseID)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }// code to insert default plan on the go
        }
    }

    function insert_default_fees_plan($Stu_ID, $CourseID) {
        global $data;

        $this->db->select('*');
        $this->db->where('CourseID', $CourseID);
        $query = $this->db->get('nexgen_fee_course_plan');

        if ($query->num_rows() > 0) {

            $add_user = $data['Session_Data']['IBMS_USER_ID'];
                        
            $ndata = array();
            foreach ($query->result() as $row) {
                $feetype = $row->FeeTypeID;
                $status = $row->Status;
                $inst_amt = $row->Inst_amt;
                $tot_inst = $row->Total_Inst;

                $ndata[] = array(
                    'Stu_ID' => $Stu_ID,
                    'CourseID' => $CourseID,
                    'FeeTypeID' => $feetype,
                    'Sort' => '1',
                    'Inst_amt' => $inst_amt,
                    'Total_Inst' => $tot_inst,
                    'Total_paid' => '0',
                    'Add_User' => $add_user,
                    'Add_DateTime' => date('Y-m-d H:i:s',time()),
                    'Remarks' => "Default Plan Set"
                );
                }
                
                if ($this->db->insert_batch(DB_PREFIX . "fee_individual_plan", $ndata)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            
        }
    }

    /*

     * for getting fee plan               */

    public function get_stu_fee_plan($filter_data) {
        // for giving the flexiblity if you dont pass course then it will show all courses fee plan
        if (isset($filter_data['CourseID']) && $filter_data['CourseID'] != "") {
            $this->db->where_in("sfp.CourseID", $filter_data['CourseID']);
        }
        // if you will dont pass student id then it will  return you all course fee plan
        if (isset($filter_data['Stu_ID']) && $filter_data['Stu_ID'] != '') {
            $this->db->where_in("sfp.Stu_ID", $filter_data['Stu_ID']);
        }

        // if you will dont pass student id then it will  return you all course fee plan
        if (isset($filter_data['FeeTypeID']) && $filter_data['FeeTypeID'] != '') {
            $this->db->where_in("sfp.FeeTypeID", $filter_data['FeeTypeID']);
        }

        $this->db->select("sfp.*,cm.CourseCode")->from(DB_PREFIX . "fee_individual_plan sfp");
        $this->db->join(DB_PREFIX . "course_mst cm", "sfp.CourseID=cm.CourseID", "left");
        $this->db->order_by("sfp.Stu_ID,sfp.CourseID,sfp.ID");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $all_stu_scnb_details = $query->result();
        return $all_stu_scnb_details;
    }

    /*

     * Inserting student Course Fee Plan               */

    public function insert_scpf($FormData) {
        global $data;
        //$this->util_model->printr($FormData);
        $data_to_insert = array();
        $trow = $FormData['total_row'];
        for ($i = 0; $i < $trow; $i++) {
            $CourseID = $FormData['CourseID'][$i];
            if ($CourseID != "" && $FormData['FeeTypeID'][$i] != "" && $FormData['Inst_amt'][$i] != "" && $FormData['Total_Inst'][$i] != "") {

                $row = array();
                $row = array(
                    "CourseID" => $CourseID,
                    "Stu_ID" => $FormData['Stu_ID'][$i],
                    "FeeTypeID" => $FormData['FeeTypeID'][$i],
                    "Inst_amt" => $FormData['Inst_amt'][$i],
                    "Total_Inst" => $FormData['Total_Inst'][$i],
                    "Sort" => isset($FormData['Sort'][$i]) ? $FormData['Sort'][$i] : 0,
                    "Remarks" => $FormData['Remarks'][$i]);
                $row = $this->util_model->add_common_fields($row);
                $data_to_insert[] = $row;
            }
        }
        //die($this->util_model->printr($data_to_insert));
        if ($this->db->insert_batch(DB_PREFIX . "fee_individual_plan", $data_to_insert)) {
            return array("succ" => TRUE, "_err_codes" => "SuccStuFeePlanAdd");
        } else {
            return array("succ" => FALSE, "_err_codes" => "ErrStuFeePlanAdd" . ERR_DELIMETER);
        }
    }

    /*
     * get_fee_records returns the fees
     */

    public function get_fee_records($filter_data) {
        if (isset($filter_data['Stu_ID'])) {
            $this->db->where("fee_trn.Stu_ID", $filter_data['Stu_ID']);
        }
        if (isset($filter_data['CourseID'])) {
            $this->db->where("ftrn.CourseID", $filter_data['CourseID']);
        }
        if (isset($filter_data['BranchID'])) {
            $this->db->where("stu_mst.BranchID", $filter_data['BranchID']);
            $this->db->where("stu_mst.Status", 1);
        }
        if (isset($filter_data['orderby'])) {
            $order = "ASC";
            if (isset($filter_data['order'])) {
                $order = "DESC";
            }
            $this->db->order_by($filter_data['orderby'], $order);
        }

        if (isset($filter_data['Status'])) {
            $this->db->where("fee_trn.Status", $filter_data['Status']);
        }

        $this->db->select('fee_trn.ReceiptDate,fee_trn.FeeTypeID,fee_trn.ReceiptNo,fee_trn.CourseID,fee_trn.PreBalAmt,fee_trn.TotalAmt,fee_trn.DisAmt,fee_trn.PaidAmt,fee_trn.BalanceAmt,'
                . 'fee_type.FeeType_Code,'
                . 'stu_mst.Stu_ID,stu_mst.EnrollNo,'
                . 'cm.CourseCode,'
                . 'emp.Emp_Code Add_UserCode')->from(DB_PREFIX . "fee_trn fee_trn");
        $this->db->join(DB_PREFIX . "fee_type_mst fee_type", "fee_type.FeeTypeID = fee_trn.FeeTypeID", "left");
        $this->db->join(DB_PREFIX . "stu_mst stu_mst", "stu_mst.Stu_ID = fee_trn.Stu_ID", "left");
        $this->db->join(DB_PREFIX . "course_mst cm", "cm.CourseID = fee_trn.CourseID", "left");
        $this->db->join(DB_PREFIX . "employee emp", "emp.Emp_ID = fee_trn.Add_User", "left");


        $query = $this->db->get();
        $all_fee_records = $query->result();
        return $all_fee_records;
    }

    /*

     * get_balance_details
     * this table is related to bal_trn
     * it will return the balance details of a student
     * @param1 $Stu_ID
     * return balance details.               */

    public function get_balance_details($filter_data) {
        if (isset($filter_data['Stu_ID'])) {
            $this->db->where("fee_bal.Stu_ID", $filter_data['Stu_ID']);
        }
        $query = $this->db->get(DB_PREFIX . "fee_bal fee_bal");
        //echo $this->db->last_query();
        return $query->result();
    }

    /*
     * 

     * fee_insert function used to insert the fee records
     *                */

    function fee_insert() {
        $FormData = $this->input->post();
        $FormData = $this->util_model->add_common_fields($FormData);
        // setting all dates in database formate
        $FormData = $this->util_model->set_db_date_formate($FormData, array('ReceiptDate', 'BalDueDate', 'NextDueDate', 'AfterNextDueDate', 'ChDate'));
        //die($this->util_model->printr($FormData));
        if ($FormData['Fee_Collect'] == "Save") {
            // transaction started !!
            $this->db->trans_begin();
            // insert fee record
            $this->load->helper('array');
            $fee_data = elements(array('OtherReceiptNo', 'FeeTypeID', 'Paid_ModeID', 'Individual_fee_plan_id', 'Stu_ID', 'ReceiptDate', 'CourseID', 'BatchID', 'Month', 'SubjectID', 'CurrTopicID', 'FacultyID', 'RegFeeAmt', 'MonthlyChargeAmt', 'LatePaymentAmt', 'StudyMaterialCostAmt', 'ProspectusCostAmt', 'OtherAmt', 'PreBalAmt', 'service_tax', 'DisAmt', 'TotalAmt', 'NetPayableAmt', 'PaidAmt', 'BalanceAmt', 'BalDueDate', 'BalanceDetails', 'NextInstAmt', 'AfterNextInstAmt', 'NoOfInstallment', 'NextDueDate', 'AfterNextDueDate', 'Remarks', 'Add_User', 'Add_DateTime'), $FormData);
            $this->db->insert(DB_PREFIX . "fee_trn", $fee_data);
            if (!$this->db->affected_rows()) {
                $this->db->trans_rollback();
                return array("Succ" => FALSE, "_err_codes" => "ErrInFeeCollect" . ERR_DELIMETER);
            }
            // getting receiptno from last entry
            $FormData['ReceiptNo'] = $this->db->insert_id();

            // update Individual_fee_plan_id
            if ($FormData['Individual_fee_plan_id'] != 0) {
                $sql = "update " . DB_PREFIX . "fee_individual_plan set Total_paid  = Total_paid+1 where Stu_ID={$FormData['Stu_ID']} and CourseID={$FormData['CourseID']} and ID = " . $FormData['Individual_fee_plan_id'];
                $this->db->query($sql);
                if (!$this->db->affected_rows()) {
                    $this->db->trans_rollback();
                    return array("succ" => FALSE, "_err_codes" => "ErrInFeePlanUpdate" . ERR_DELIMETER);
                }
            }
            // balance updatation in nexgen_fee_bal
            //if ($FormData['BalanceAmt'] != 0) {
            $fee_bal = $this->util_model->check_aready_exits(DB_PREFIX . "fee_bal", array("Stu_ID" => $FormData['Stu_ID']), TRUE);
            if (!empty($fee_bal)) {
                // in case if updated amount is same as last amount then it showes zero rows effected that's why below condition given
                if ($fee_bal[0]->BalanceAmt != $FormData['BalanceAmt']) {
                    $sql = "update " . DB_PREFIX . "fee_bal set BalanceAmt = {$FormData['BalanceAmt']},BalanceDetails='{$FormData['BalanceDetails']}',BalDueDate='{$FormData['BalDueDate']}' where Stu_ID = {$FormData['Stu_ID']}";
                    $this->db->query($sql);
                    if (!$this->db->affected_rows()) {
                        $this->db->trans_rollback();
                        die();
                        return array("succ" => FALSE, "_err_codes" => "ErrInFeebalupdate" . ERR_DELIMETER);
                    }
                }
            } else {
                $bal_data = array(
                    "Stu_ID" => $FormData['Stu_ID'],
                    "BalanceAmt" => $FormData['BalanceAmt'],
                    "BalanceDetails" => $FormData['BalanceDetails'],
                    "BalDueDate" => $FormData['BalDueDate']
                );
                $this->db->insert(DB_PREFIX . "fee_bal", $bal_data);
                if (!$this->db->affected_rows()) {
                    $this->db->trans_rollback();
                    return array("succ" => FALSE, "_err_codes" => "ErrInFeebalinsert" . ERR_DELIMETER);
                }
            }

            // cheque entry 
            if ($FormData['Paid_ModeID'] != 1) { // 1 represent cash     
                $FormData['Cleared'] = 0;
                $cheque_data = elements(array('ReceiptNo', 'Stu_ID', 'BankName', 'BranchName', 'ChNumber', 'ChDate', 'ChAmount', 'Cleared', 'Add_User', 'Add_DateTime'), $FormData);
                $cheque_data['Remarks'] = $FormData['ChequeRemarks'];
                $this->db->insert(DB_PREFIX . "fee_cheque_details", $cheque_data);
                if (!$this->db->affected_rows()) {
                    $this->db->trans_rollback();
                    return array("succ" => FALSE, "_err_codes" => "ErrInchequeinsert" . ERR_DELIMETER);
                }
            }

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                return array("succ" => TRUE, "_err_codes" => "FeeSavedSucc");
            } else {
                // if this function will find any error so it will simply rollback
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => "ErrFeeSavedSucc" . ERR_DELIMETER);
            }
        }
        return false;
    }

    /*
     * fee_update() function
     * it will update the fee update form data
     * effecting tables are fee_trn, fee_bal, fee_cheque_details
     */

    public function fee_update() {
        $FormData = $this->input->post();
        $FormData = $this->util_model->add_mode_user($FormData);
        // setting all dates in database formate
        $FormData = $this->util_model->set_db_date_formate($FormData, array('ReceiptDate', 'BalDueDate', 'NextDueDate', 'AfterNextDueDate', 'ChDate'));
        //die($this->util_model->printr($FormData));
        if ($FormData['Fee_Collect'] == "Update") {
            // transaction started !!
            $this->db->trans_begin();
            // insert fee record
            $this->load->helper('array');
            $fee_data = elements(array('OtherReceiptNo', 'FeeTypeID', 'Paid_ModeID', 'Individual_fee_plan_id', 'Stu_ID', 'ReceiptDate', 'CourseID', 'BatchID', 'Month', 'SubjectID', 'CurrTopicID', 'FacultyID', 'RegFeeAmt', 'MonthlyChargeAmt', 'LatePaymentAmt', 'StudyMaterialCostAmt', 'ProspectusCostAmt', 'OtherAmt', 'PreBalAmt', 'service_tax', 'DisAmt', 'TotalAmt', 'NetPayableAmt', 'PaidAmt', 'BalanceAmt', 'BalDueDate', 'BalanceDetails', 'NextInstAmt', 'AfterNextInstAmt', 'NoOfInstallment', 'NextDueDate', 'AfterNextDueDate', 'Remarks', 'Mode_User'), $FormData);

            $this->db->update(DB_PREFIX . "fee_trn", $fee_data, array("ReceiptNo" => $FormData['ReceiptNo']));
            if (!$this->db->affected_rows()) {
                $this->db->trans_rollback();
                return array("Succ" => FALSE, "_err_codes" => "ErrInFeeUpdate" . ERR_DELIMETER);
            }


            //balance updatation in nexgen_fee_bal
            //if ($FormData['BalanceAmt'] != 0) {
            $fee_bal = $this->util_model->check_aready_exits(DB_PREFIX . "fee_bal", array("Stu_ID" => $FormData['Stu_ID']), TRUE);
            if (!empty($fee_bal)) {
                // in case if updated amount is same as last amount then it showes zero rows effected that's why below condition given
                if ($fee_bal[0]->BalanceAmt != $FormData['BalanceAmt']) {
                    $sql = "update " . DB_PREFIX . "fee_bal set BalanceAmt = {$FormData['BalanceAmt']},BalanceDetails='{$FormData['BalanceDetails']}',BalDueDate='{$FormData['BalDueDate']}' where Stu_ID = {$FormData['Stu_ID']}";
                    $this->db->query($sql);
                    if (!$this->db->affected_rows()) {
                        $this->db->trans_rollback();
                        die();
                        return array("succ" => FALSE, "_err_codes" => "ErrInFeebalupdate" . ERR_DELIMETER);
                    }
                }
            } else {
                $bal_data = array(
                    "Stu_ID" => $FormData['Stu_ID'],
                    "BalanceAmt" => $FormData['BalanceAmt'],
                    "BalanceDetails" => $FormData['BalanceDetails'],
                    "BalDueDate" => $FormData['BalDueDate']
                );
                $this->db->insert(DB_PREFIX . "fee_bal", $bal_data);
                if (!$this->db->affected_rows()) {
                    $this->db->trans_rollback();
                    return array("succ" => FALSE, "_err_codes" => "ErrInFeebalinsert" . ERR_DELIMETER);
                }
            }

            // cheque entry 
            if ($FormData['Paid_ModeID'] != 1) { // 1 represent cash   
                // check check exits
                $cheque_fiter_data = array(
                    "ReceiptNo" => $FormData['ReceiptNo'],
                    "Status" => TRUE);
                $cheque_details = $this->util_model->check_aready_exits(DB_PREFIX . "fee_cheque_details", $cheque_fiter_data, TRUE);

                if (empty($cheque_details[0])) {
                    // insert cheque details
                    $cheque_data = elements(array('ReceiptNo', 'Stu_ID', 'BankName', 'BranchName', 'ChNumber', 'ChDate', 'ChAmount', 'Mode_User'), $FormData);
                    $cheque_data['Remarks'] = $FormData['ChequeRemarks'];
                    $this->db->insert(DB_PREFIX . "fee_cheque_details", $cheque_data);
                    if (!$this->db->affected_rows()) {
                        $this->db->trans_rollback();
                        return array("succ" => FALSE, "_err_codes" => "ErrInchequeinsert" . ERR_DELIMETER);
                    }
                } else {
                    // update last cheque details
                    $cheque_data = elements(array('ReceiptNo', 'Stu_ID', 'BankName', 'BranchName', 'ChNumber', 'ChDate', 'ChAmount', 'Mode_User'), $FormData);
                    $cheque_data['Remarks'] = $FormData['ChequeRemarks'];
                    $this->db->update(DB_PREFIX . "fee_cheque_details", $cheque_data, array("ChequeID" => $cheque_details[0]->ChequeID));
                    if (!$this->db->affected_rows()) {
                        $this->db->trans_rollback();
                        return array("succ" => FALSE, "_err_codes" => "ErrInchequeUpdate" . ERR_DELIMETER);
                    }
                }
            } else {
                // if there was already cheque insertion and user will select cash .. then 
                // that cheque will be cancelled automatically
                // check check exits
                $cheque_fiter_data = array(
                    "ReceiptNo" => $FormData['ReceiptNo'],
                    "Status" => TRUE);
                $cheque_details = $this->util_model->check_aready_exits(DB_PREFIX . "fee_cheque_details", $cheque_fiter_data, TRUE);
                // if exists 
                if (!empty($cheque_details[0])) {
                    $this->util_model->update_data(DB_PREFIX . "fee_cheque_details", array("Status" => FALSE), array("ChequeID" => $cheque_details[0]->ChequeID));
                }
            }
            // if trnx is successfull
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                return array("succ" => TRUE, "_err_codes" => "FeeUpdateSucc");
            } else {
                // if this function will find any error so it will simply rollback
                $this->db->trans_rollback();
                return array("succ" => FALSE, "_err_codes" => "ErrFeeUpdateSucc" . ERR_DELIMETER);
            }
        }
        return false;
    }

    public function total_installments_amount($Stu_ID, $CourseID) {
        $this->db->select_sum('PaidAmt')->where(array("Stu_ID" => $Stu_ID, "CourseID" => $CourseID));
        $q = $this->db->get(DB_PREFIX . 'fee_trn');
        $result = $q->result();
        return $result[0]->PaidAmt;
    }

    /*

     * cancel_fee_receipt() used to cancel the fee receipt
     * effected table fee_trn and fee_bal individual_fee_plan
     *                /
     */

    function cancel_fee_receipt($FormData) {
        $this->db->trans_begin();

        // cancel receipt
        $this->db->update(DB_PREFIX . "fee_trn", array("Status" => FALSE), array("ReceiptNo" => $FormData['ReceiptNo']));
        if (!$this->db->affected_rows()) {
            $this->db->trans_rollback();
            return array(FALSE, "Error in updating fee status");
        }

        // cancel cheque if exists
        $this->db->update(DB_PREFIX . "fee_cheque_details", array("Status" => FALSE), array("ReceiptNo" => $FormData['ReceiptNo']));

        // drecrement fee plan installment if exists
        $sql = "update " . DB_PREFIX . "fee_individual_plan set Total_paid = Total_paid-1 where Stu_ID={$FormData['ReceiptNo']} and CourseID={$FormData['CourseID']} and FeeTypeID={$FormData['FeeTypeID']}";
        $this->db->query($sql);



        $filter_data = array("ReceiptNo" => $FormData['ReceiptNo']);
        $ReceiptData = $this->util_model->check_aready_exits(DB_PREFIX . "fee_trn", $filter_data, TRUE);

        // setting prebal amount in fee_bal table
        $this->db->update(DB_PREFIX . "fee_bal", array("BalanceAmt" => $ReceiptData[0]->PreBalAmt), array("Stu_ID" => $ReceiptData[0]->Stu_ID));

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return array(TRUE, "Updated Successfully !!");
        } else {
            // if this function will find any error so it will simply rollback
            $this->db->trans_rollback();
            return array(FALSE, "Error while Updating !!");
        }
    }

    public function save_update_fee_plan($all_Fee_plan_form_data) {
        $insert_update_flag = FALSE;
        $minimum_total = 0;
        if ($all_Fee_plan_form_data['Add_indi_fee_paln'] == "Save") {
            for ($index = 1; $index <= $all_Fee_plan_form_data['total_row']; $index++) {
                $data_to_insert = $this->fee_plan_query($all_Fee_plan_form_data, $index);
                if ($this->db->insert("nexgen_individual_fee_plan", $data_to_insert)) {
                    $insert_update_flag = TRUE;
                    // $minimum_total += $data_to_insert['Inst_amt'] * $data_to_insert['Total_Inst'];
                } else {
                    $insert_update_flag = FALSE;
                }
            }
//            if ($insert_update_flag) {
//                $sql = "update nexgen_scnb set Fee_Plan_Setted=1,Minimum_Total = Minimum_Total+$minimum_total where EnrollNo='{$all_Fee_plan_form_data['EnrollNo1']}' and CourseCode='{$all_Fee_plan_form_data['CourseCode1']}'";
//                if (!$this->db->query($sql))
//                    $insert_update_flag = FALSE;
//            }
        } else if ($all_Fee_plan_form_data['Add_indi_fee_paln'] == "Update") {
            $Fee_Plan_ID = $_POST['Fee_Plan_ID'];
            $Fee_Plan_Details = $this->Get_Fee_Plan_Details_via_ID($Fee_Plan_ID);
            $old_Total_Inst = $Fee_Plan_Details[0]->Total_Inst;
            $Total_paid = $Fee_Plan_Details[0]->Total_paid;
            $old_Inst_amt = $Fee_Plan_Details[0]->Inst_amt;
            $EnrollNo = $Fee_Plan_Details[0]->EnrollNo;
            $CourseCode = $Fee_Plan_Details[0]->CourseCode;
            /*
             * It will find the changes, might be user can increase the installment amount or descrase
             * on that behalf we will fetch the last receipt no and and increaes the balance amount.             * 
             */
            $new_Inst_amt = $_POST['Inst_amt1'];
            $new_Total_Inst = $_POST['Total_Inst1'];
            if ($new_Total_Inst < $Total_paid) {
                return FALSE;
            }
            if ($old_Inst_amt == $new_Inst_amt && $old_Total_Inst == $new_Total_Inst) {
                return TRUE;
            } else if ($Total_paid == 0) {
                $data_to_update = array("Inst_amt" => $new_Inst_amt, "Total_Inst" => $new_Total_Inst);
                if ($this->db->update("nexgen_individual_fee_plan", $data_to_update, array("ID" => $Fee_Plan_ID))) {
                    $insert_update_flag = TRUE;
                }
            } else if ($Total_paid != 0 && $old_Inst_amt == $new_Inst_amt) {
                $data_to_update = array("Total_Inst" => $new_Total_Inst);
                if ($this->db->update("nexgen_individual_fee_plan", $data_to_update, array("ID" => $Fee_Plan_ID))) {
                    $insert_update_flag = TRUE;
                }
            } else {
                $this->db->order_by('ID', 'ASC');
                $q = $this->db->get_where("nexgen_fee_trn", array("Individual_fee_plan_id" => $Fee_Plan_ID));
                $Fee_taken_from_this_Fee_plan = $q->result();
                $Receipt_no_taken = array();
                $index = 0;
                $First_Receipt_from_this_plan = 0;
                foreach ($Fee_taken_from_this_Fee_plan as $Fee_trn_Row) {
                    if ($First_Receipt_from_this_plan == 0) {
                        $First_Receipt_from_this_plan = $Receipt_no_taken[$index++] = $Fee_trn_Row->ID;
                    } else {
                        $Receipt_no_taken[$index++] = $Fee_trn_Row->ID;
                    }
                }
                $bal_to_increase_descrase = 0;
                $change_in_monthly_fee = $new_Inst_amt - $old_Inst_amt;
                // it will update in all receipt which taken after this fee plan or with this fee plan ..
                // to remove abnormal data

                $this->db->select('*')->from('nexgen_fee_trn');
                $this->db->where("ID>=$First_Receipt_from_this_plan", NULL, FALSE);
                $this->db->where(array("EnrollNo" => $EnrollNo, "CourseCode" => $CourseCode));
                $this->db->order_by('ID', 'ASC');
                $q2 = $this->db->get();
                $All_abnormal_fee_receipt = $q2->result();
                $i = 0; // for change the monthly fee with taken form above fee plan
                $BalanceAmt = 0;
                foreach ($All_abnormal_fee_receipt as $Receipt) {
                    if ($Receipt_no_taken[$i] == $Receipt->ID) {
                        $i++;
                        $bal_to_increase_descrase += $change_in_monthly_fee;
                        $MonthlyChargeAmt = $Receipt->MonthlyChargeAmt + ($change_in_monthly_fee);
                        $TotalAmt = $Receipt->TotalAmt + $bal_to_increase_descrase;
                        $BalanceAmt = $Receipt->BalanceAmt + $bal_to_increase_descrase;

                        $data_to_update = array(
                            "MonthlyChargeAmt" => $MonthlyChargeAmt,
                            "BalanceAmt" => $BalanceAmt,
                            "TotalAmt" => $TotalAmt
                        );
                        if (!$this->db->update('nexgen_fee_trn', $data_to_update, array("ID" => $Receipt->ID))) {
                            $insert_update_flag = FALSE;
                        }
                    } else {
                        $BalanceAmt = $Receipt->BalanceAmt + ($bal_to_increase_descrase);
                        $TotalAmt = $Receipt->TotalAmt + $bal_to_increase_descrase;
                        //       $bal_to_increase_descrase += $BalanceAmt;
                        $data_to_update = array(
                            "BalanceAmt" => $BalanceAmt,
                            "TotalAmt" => $TotalAmt);
                        if (!$this->db->update('nexgen_fee_trn', $data_to_update, array("ID" => $Receipt->ID))) {
                            $insert_update_flag = FALSE;
                        }
                    }
                }

                $data_to_update = array("Inst_amt" => $new_Inst_amt, "Total_Inst" => $new_Total_Inst);
                if ($this->db->update("nexgen_individual_fee_plan", $data_to_update, array("ID" => $Fee_Plan_ID))) {
                    $insert_update_flag = TRUE;
                }
            }
        }
        return $insert_update_flag;
    }

    public function fee_plan_query($all_Fee_plan_form_data, $index) {
        $data_to_insert_or_update = array(
            "EnrollNo" => strtoupper($all_Fee_plan_form_data['EnrollNo' . $index]),
            "CourseCode" => $all_Fee_plan_form_data['CourseCode' . $index],
            "Inst_amt" => $all_Fee_plan_form_data['Inst_amt' . $index],
            "Total_Inst" => $all_Fee_plan_form_data['Total_Inst' . $index],
            "Remarks" => $all_Fee_plan_form_data['Remarks' . $index],
            "Add_User" => $all_Fee_plan_form_data['Add_User'],
            "Mode_User" => $all_Fee_plan_form_data['Mode_User']
        );
        return $data_to_insert_or_update;
    }

    function data_to_print_fee($ReceiptNo) {
        $this->db->select("fee_trn.*,"
                . "ftm.FeeType_Code,"
                . "stu_mst.EnrollNo,stu_mst.StudentName,stu_mst.FatherName,stu_mst.C_Add,stu_mst.Mobile1,stu_mst.Mobile2,"
                . "cm.CourseCode,cm.Duration,cm.MonthDay,"
                . "sc.DOR,"
                . "(select Emp_Code from " . DB_PREFIX . "employee where Emp_ID=sb.FacultyID) as FacultyCode,"
                . "bm.BatchCode,bm.Start_Time,bm.End_Time ")->from(DB_PREFIX . "fee_trn fee_trn");
        $this->db->join(DB_PREFIX . "fee_type_mst ftm", "fee_trn.FeeTypeID=ftm.FeeTypeID", "left");
        $this->db->join(DB_PREFIX . "stu_mst stu_mst", "fee_trn.Stu_ID=stu_mst.Stu_ID", "left");
        $this->db->join(DB_PREFIX . "course_mst cm", "fee_trn.CourseID=cm.CourseID", "left");
        $this->db->join(DB_PREFIX . "stu_courses sc", "fee_trn.Stu_ID=sc.Stu_ID and fee_trn.CourseID=sc.CourseID", "left");
        $this->db->join(DB_PREFIX . "stu_batches sb", "fee_trn.Stu_ID=sb.Stu_ID and fee_trn.CourseID=sb.CourseID", "left");
        $this->db->join(DB_PREFIX . "batch_master bm", "fee_trn.BatchID=bm.BatchID", "left");
        $this->db->where("fee_trn.ReceiptNo", $ReceiptNo);


//                            
//                            $sql = "SELECT t1.'ReceiptNo',t1.'ReceiptDate',t1.'FeeType_Code',t1.'EnrollNo',t1.'CourseCode',t1.'BatchCode',t1.Month,
//                            t1.'FacultyCode', t1.'RegFeeAmt',t1.'RegFeeAmt', t1.'MonthlyChargeAmt', t1.'LatePaymentAmt', t1.'StudyMaterialCostAmt',
//                            t1.'ExamFeeAmt', t1.'ProspectusCostAmt', t1.'OtherAmt', t1.'TotalAmt', t1.'DisAmt', t1.'NetPayableAmt',
//                            t1.'PaidAmt', t1.'BalanceAmt', t1.'BalDueDate', t1.'BalanceDetails', t1.'NextInstAmt', 
//                            t1.'AfterNextInstAmt', t1.'NoOfInstallment', t1.'NextDueDate', t1.'AfterNextDueDate', 
//                            t1.'Remarks', t1.'Add_User', t1.'Mode_User',t2.'Due_Date',t3.Start_Time,t3.End_Time,t4.Duration,
//                            t4.MonthDay, lf.Late_Payment_Fee,lf.Website,lf.Address1,lf.Email,t5.DOR,t5.StudentName,t5.FatherName
//                            ,t5.C_houseno,t5.C_street,t5.C_city,t5.C_village_and_post,t5.Mobile1
//                            FROM nexgen_late_fine lf,  'nexgen_fee_trn' t1 INNER JOIN nexgen_scnb t2 
//                            ON(t1.'CourseCode'=t2.'CourseCode' and t1.'EnrollNo'=t2.'EnrollNo') INNER 
//                            JOIN  nexgen_batch_master t3 ON(t1.BatchCode=t3.BatchCode and t1.FacultyCode=t3.FacultyCode) INNER JOIN nexgen_course_mst t4 ON (t1.'CourseCode'=t4.'CourseCode') INNER JOIN nexgen_student_mst t5 ON (t1.EnrollNo=t5.EnrollNo) WHERE t1.'ID'=$Receipt_NO";
        $q = $this->db->get();
        return $q->result();
    }

    public function Get_Fee_Plan_Details_via_ID($ID) {
        $query = $this->db->get_where("nexgen_individual_fee_plan", array('ID' => $ID));
        return $query->result();
    }

    public function Del_Fee_plan($ID) {
        $result = $this->Get_Fee_Plan_Details_via_ID($ID);
        if ($result[0]->Total_paid > 0) {
            return FALSE;
        } else {
//        $amount_to_less = $result[0]->Inst_amt * $result[0]->Total_Inst;
//        $sql = "update nexgen_scnb set Minimum_Total = Minimum_Total- $amount_to_less where EnrollNo='{$result[0]->EnrollNo}' and CourseCode='{$result[0]->CourseCode}'";
            // if ($this->db->query($sql)) {
            if ($this->db->delete('nexgen_individual_fee_plan', array('ID' => $ID))) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function Del_Fee_record($ID) {
        $del_flag = FALSE;
        $query = $this->db->get_where("nexgen_fee_trn", array('ID' => $ID));
        $result = $query->result();
        $individual_fee_plan_id = "";
        $amount_to_less = $result[0]->PaidAmt;
        $MonthlyChargeAmt = $result[0]->MonthlyChargeAmt;
        $sql = "update nexgen_scnb set Total_Paid_Amt = Total_Paid_Amt- $amount_to_less  where EnrollNo='{$result[0]->EnrollNo}' and CourseCode='{$result[0]->CourseCode}'";
        if ($this->db->query($sql)) {
            // // to reduce the paid amount .. becuase deleting the wrong receipt so total paid should be --
            // and number of paid installments .. 
            if ($result[0]->FeeType_Code != "Bal") {
                $query = $this->db->get_where('nexgen_individual_fee_plan', array('Inst_amt' => $MonthlyChargeAmt));
                $result_fee_plan = $query->result();
                if (!empty($result_fee_plan[0])) {
                    $individual_fee_plan_id = $result_fee_plan[0]->ID;
                } else {
                    $query = $this->db->get_where('nexgen_individual_fee_plan', array('EnrollNo' => $result[0]->EnrollNo, "CourseCode" => $result[0]->CourseCode));
                    $this->db->order_by('ID');
                    $last = $query->last_row();
                    $individual_fee_plan_id = $last->ID;
                }
                $sql = "update nexgen_individual_fee_plan set Total_Paid = Total_Paid-1  where ID='$individual_fee_plan_id'";
                if ($this->db->query($sql)) {
                    $this->db->where(array('ID' => $ID));
                    if ($this->db->delete('nexgen_fee_trn'))
                        $del_flag = TRUE;
                }
                if ($result[0]->BalanceAmt != 0) {
                    if (!$this->db->query("update nexgen_scnb set 'Total_Bal'=Total_Bal-{$result[0]->BalanceAmt} where 'EnrollNo'='" . $result[0]->EnrollNo . "' and  'CourseCode'='" . $result[0]->CourseCode . "'"))
                        $del_flag = FALSE;
                }
            }else {
                if ($this->db->query("update nexgen_scnb set 'Total_Bal'=Total_Bal+{$result[0]->PaidAmt} where 'EnrollNo'='" . $result[0]->EnrollNo . "' and  'CourseCode'='" . $result[0]->CourseCode . "'")) {
                    $del_flag = TRUE;
                } else {
                    $del_flag = FALSE;
                }
            }
        }
        if (!$this->db->delete('nexgen_fee_trn', array('ID' => $ID)))
            $del_flag = FALSE;
        return $del_flag;
    }

    /*

     * get_no_of_installment($Stu_ID, $CourseID,$FeeTypeID)
     * returns int no of installment according to fee type  
     * you can get no of installment
     * via students wise
     * student and course wise
     * student and course wise and fee type wise
     * 
     */

    public function get_no_of_installment($Stu_ID, $CourseID = "", $FeeTypeID = "") {
        if ($CourseID != "") {
            $this->db->where("CourseID", $CourseID);
        }
        if ($FeeTypeID != "") {
            $this->db->where("FeeTypeID", $FeeTypeID);
        }
        $this->db->select('*')->from('nexgen_fee_trn')->where(array('Stu_ID' => $Stu_ID));
        return $this->db->count_all_results() + 1;
    }

    public function all_fee_records_from_receipt_number($receipt_number) {
        $this->db->select('*')->from("nexgen_fee_trn")->where(array("ID" => $receipt_number));
        $query = $this->db->get();
        $fee_records = $query->result();
        return $fee_records;
    }

    /*

     *   last_fee_record
     * returning the last receipt details              /
     */

    public function last_fee_record($Stu_ID, $CourseID, $FeeTypeID = "") {
        if ($FeeTypeID != "") {
            $this->db->where(array("FeeTypeID" => $FeeTypeID));
        }

        $this->db->order_by('ReceiptNo', 'DESC');
        $query = $this->db->get_where(DB_PREFIX . "fee_trn", array("Stu_ID" => $Stu_ID, "CourseID" => $CourseID));
        $all_stu_scnb_details = $query->result();
        return $all_stu_scnb_details;
    }

    public function this_month_collection() {
        $start_date = date("Y", time()) . "-" . date("m", time()) . "-01";
        $today = date("Y-m-d", time());
        $this->db->select_sum("PaidAmt", "total_Paid_amount")->from("nexgen_fee_trn");
        $where = "ReceiptDate<= '$today' AND ReceiptDate>= '$start_date'";
        $this->db->where($where, NULL, FALSE);
        $query = $this->db->get();
        $result = $query->result();
//        if ($this->db->count_all_results() == 1) {
//            return 0;
//        } else {
        return $result[0]->total_Paid_amount;
//        }
    }

    /*
     * check_fully_paid($Stu_ID,$CourseID)
     * CourseID is optional
     * return bolean
     * true : if student is fully paid
     * false : vice versa
     * check data from fee_plan table of student
     */

    function check_fully_paid($Stu_ID, $CourseID = '') {
        if ($CourseID != '') {
            $this->db->where("CourseID", $CourseID);
        }
        $this->db->where("Total_Inst!=", "Total_paid", FALSE);
        $query = $this->db->get_where(DB_PREFIX . "fee_individual_plan fip", array("Stu_ID" => $Stu_ID));
        $result = $query->result();
        $Fully_paid = FALSE;
        if (empty($result)) {
            $Fully_paid = TRUE;
        }
        return $Fully_paid;
    }

}
