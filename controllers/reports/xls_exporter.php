<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xls_exporter
 * @Created on : Sep 17, 2015, 4:17:40 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class xls_exporter extends CI_Controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->helper("array");
    }

    public function export_all_data() {
        $this->load->model('tms/m_task_manage');
        global $data;
        $POST = $this->input->post();
        ob_start();
        $data['result'] = $this->m_task_manage->get_my_tasks($POST);
//        $this->util_model->printr($data['result']);
//        die();
        $final_result[] = array(
            "S.No",
            "Client Name",  
            "Task Type",
            "Task Name",
            "State",
            "Month",
            "Year",
            "Task Code",
            "Progress Flag",
            "Start Date",
            "End Date",
            "InchargeName",
            "BillAmount (If Generated)",
            "GSTIN No",
            "PO No");
        $s_no = 1;
//        $this->util_model->printr($data['result']); 
//        die();
        foreach ($data['result'] as $each_record) {
//            $this->util_model->printr($each_record); 
            $row = array();

            $row = array(
                's_no' => $s_no++,
                'client_name' => $each_record['client_name'],
                'ttm_name' => $each_record['ttm_name'],
                'tm_name' => $each_record['tm_name'],
                'state'=>$this->util_model->get_state($each_record['state_id']),
                'month'=>$each_record['month'],
                'year'=>$each_record['year'],
                "tm_code" => $each_record['tm_code'],
                $row['progress_flag'] = $this->util_model->get_progress_flag_string($each_record['progress_flag']),
                'start_date' => date(DF, strtotime($each_record['start_date'])),
                'end_date' => date(DF, strtotime($each_record['end_date'])),
                'Incharge_name' => $each_record['Incharge_name'],
                'bill_amt' => $each_record['bill_amt'],
                'gst_no' => $each_record['gst_no'],
                'po_no' => $each_record['po_no']
            );
//            $each_record = $this->util_model->unset_array($each_record, array("tm_id", "ttm_id", "visibility", "BillingDone", "status", "client_id", "does_repeat", "repeat_unit", "repeat_gap", "approx_exp", "extra_note", "Add_User", "Add_DateTime", "Mode_DateTime", "Mode_User", "repeated_from", "replicate_date"));
//            $each_record['progress_flag'] = ($each_record['progress_flag'] == COMPLETED_REQUEST) ? "Completed" : "In Progress";
            $final_result[] = $row;
        }
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_report.xls";
        $this->excel->stream_for_tms($file_name, $final_result);
        ob_clean();
//        ob_flush();
        echo json_encode(array("succ" => TRUE, "file_name" => $file_name));
    }

    public function export_bill_data() {
        $this->load->model("tms/m_task_billing", 'm_bill');
        global $data;
        $POST = $this->input->post();
        ob_start();
        $data['result'] = $this->m_bill->fetch_bill_data($POST);
//      print_r($data['result']); exit;
        $final_result[] = array("Task Name","Billed From","Client Name","GSTIN No","Bill Number","Bill Date", "Fees Amount","Service Tax","Education Cess","Krishi Kal.Cess","IGST","CGST","SGST","UTGST","Invoice Value","Remarks", "Total Paid");
        foreach ($data['result'] as $each_record) {
//            $this->util_model->printr($each_record);
//            die();
            $each_record = array(
              'tm_name'=>$each_record['tm_name'],
              'Billed From'=>$each_record['from_acc'],
              'client_name'=>$each_record['Emp_Name'],
              'gst_no' => $each_record['gst_no'],
              'bill_no'=>$each_record['bill_no'],
               'Bill_date'=>$each_record['bill_due_date'],
              'Fees_amt'=>$each_record['bill_amt'],
              'ser_tax' =>$each_record['ser_tax'],
              'etax' =>$each_record['etax'],
              'ktax' =>$each_record['ktax'],
               'IGST' =>$each_record['IGST'],
               'CGST' =>$each_record['CGST'],
              'SGST' =>$each_record['SGST'],
              'UTGST' =>$each_record['UTGST'],
               'Invoice _Value' =>0,
              'remarks'=>$each_record['remarks'],
              'Paid_amt'=>$each_record['Paid_amt'],
            );
            $final_result[] = $each_record;
        }
//        die();
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_bill_report.xls";
        $this->excel->stream_for_tms($file_name, $final_result);
        ob_clean();
//        ob_flush();
        echo json_encode(array("succ" => TRUE, "file_name" => $file_name));
    }

    public function export_dailyTask() {
        global $data;
        $filter_data = $this->input->post();
        unset($filter_data['page']);
        unset($filter_data['limit']);
        $this->load->model("tms/m_daily_task", 'daily_task');
        $data['result'] = $this->daily_task->fetch_recent_daily_data($filter_data);
//        $this->util_model->printr($data['result']);
//        die();
        ob_start();

        $final_result[] = array("Sub Task Name", "Date", "Effort Made", "Work Desc", "Completed", "Approved", "Entry Done By");
        foreach ($data['result'] as $each_record) {

            $final_result[] = array(
                $each_record['client_name'],
                $each_record['tm_name'],
                $each_record['tstm_name'],
                $each_record['work_date'],
                $each_record['efforts'],
                strip_tags($each_record['comment']),
                $each_record['completed'],
                strip_tags($each_record['approved']),
                $each_record['entryBy']
            );
            //$this->util_model->unset_array($each_record, array("tstm_name", 
            //"bill_mst_id", "work_date", "efforts", "comment","completed","approved"));
        }
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_dailyTask_report.xls";
        $this->excel->stream_for_tms($file_name, $final_result);
        ob_clean();
//        ob_flush();
        echo json_encode(array("succ" => TRUE, "file_name" => $file_name));
    }

    public function export_sub_task_filter_data() {
        $this->load->model('tms/m_manage_sub_task');
        global $data;
        $POST = $this->input->post();
        ob_start();

        $data['result'] = $this->m_manage_sub_task->getSubTaskData($POST);
        $final_result[] = array("S.No", "Client Name","Task Name","Sub Task Name","State","Month","Year", "In Charge Name", "Assigned To", "Work Status", "Progress", "Start Date", "End Date");
        $s_no = 1;
//        $this->util_model->printr($POST);
//        $this->util_model->printr($data['result']);
//        die();
        foreach ($data['result'] as $each_record) {
//            $this->util_model->printr($each_record);
//            die();
            $final_result[] = array(
                $s_no++,
                $each_record['client_name'],
                $each_record['tm_name'],
                $each_record['tstm_name'],
                $this->util_model->get_state($each_record['state_id']),
                $each_record['month'],
                $each_record['year'],
                $each_record['incharge_name'],
                $each_record['Emp_Name'],
                $each_record['completed'] = ($each_record['completed'] != "") ? ($each_record['completed'] . "%") : ("0%"),
                $this->util_model->get_progress_flag_string($each_record['progress_flag']),
                date(DTF, strtotime($each_record['str_date_time'])),
                date(DTF, strtotime($each_record['end_date_time']))
            );
//            $each_record = $this->util_model->unset_array($each_record, array("tstm_id,Emp_Name"));
//            $each_record['progress_flag'] = ($each_record['progress_flag'] == COMPLETED_REQUEST) ? "Completed" : "In Progress";
//            $final_result[] = $each_record;
        }
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_sub_task_report.xls";
        $this->excel->stream_for_tms($file_name, $final_result);
        ob_clean();
//        ob_flush();
        echo json_encode(array("succ" => TRUE, "file_name" => $file_name));
    }

    public function export_all_fee_records() {

        $this->load->model('fee/fee_collect_model_1');
        global $data;
        $POST = $this->input->post();
        $POST['orderby'] = "fee_trn.ReceiptDate";
        $POST['order'] = "DESC";
        $POST["BranchID"] = $data['Session_Data']['IBMS_BRANCHID'];
        $POST['result_in'] = "array";
        //$this->util_model->printr($POST);
        $final_result = array();
        $data['fees_record'] = $this->fee_collect_model_1->get_fee_records($POST);
        foreach ($data['fees_record'] as $each_record) {
            $each_record = $this->util_model->unset_array($each_record, array("FeeTypeID", "Stu_ID"));
            $final_result[] = $each_record;
        }

        $this->load->library("reports/excel");
        $this->excel->stream("fee_report.xls", $final_result);
    }

    public function export_search_share() {
        $this->load->model('fee_share/get_share');
        global $data;
        $POST = $this->input->post();
        $POST['Status'] = TRUE;
        $data['record'] = $this->get_share->get_faculty_share($POST);
        $final_result = array();
        foreach ($data['record'] as $each_record) {
            $each_record = $this->util_model->unset_array($each_record, array("ffaID"));
            $final_result[] = $each_record;
        }

        $this->load->library("reports/excel");
        $this->excel->stream("faculty_share_report.xls", $final_result);
    }

    public function export_search_enq() {

        global $data;
        $this->load->model('enquiry/m_enquiry');
        $POST = $this->input->post();
        $data['enq_record'] = $this->m_enquiry->search_enq($POST);



        foreach ($data['enq_record'] as $each_record) {

            $each_record['DOE'] = date(DF, strtotime($each_record['DOE']));
            $each_record['DOR'] = date(DF, strtotime($each_record['DOR']));
            $final_result[] = elements(array('E_Code', 'Visit', 'EFormNo', 'total_followups', 'DOE', 'enqCourseCode', 'EnrollNo', 'DOR', 'admCourseCode', 'StudentName', 'FatherName', 'Mobile1', 'Src_CatCode', 'Src_Code', 'PROCode'), $each_record);
        }
        //die($this->util_model->printr($final_result));
        $this->load->library("reports/excel");
        $this->excel->stream("Fee_report.xls", $final_result);
    }

    public function export_search_adm() {

        $this->load->model('adm/admission_model', "adm_model");
        global $data;
        $POST = $this->input->post();
        $data['record'] = $this->adm_model->msearch_adm($POST);
        $final_result = array();

        foreach ($data['record'] as $each_record) {
            $each_record['DOR'] = date(DF, strtotime($each_record['DOR']));
            $final_result[] = elements(array("EnrollNo", "DOR", "admCourseCode", "StudentName", "FatherName", "Mobile1"), $each_record);
        }
        //die($this->util_model->printr($final_result));
        $this->load->library("reports/excel");
        $this->excel->stream("admission_report.xls", $final_result);
    }

    // start you function from here
}
