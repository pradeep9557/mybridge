<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mis_report
 *
 * @author NexGen
 */
class mis_report extends CI_controller {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->helper("array");
        $this->load->model('tms/m_mis_report');
    }

    function get_report_data() {
        global $data;
        $this->load->model('tms/m_task_manage');
        // new task
        // where AddDateTime == Today
        $filter = array("extra_where" => "t1.start_date='" . date(DB_DF, time()) . "'");
        $data['NewTask'] = $this->m_task_manage->getTasks($filter);
        // close & completed task
        // Where ModeDateTime == today and Closed & Complete = 1
        $filter = array("extra_where" => "t1.Mode_DateTime='" . date(DB_DF, time()) . "' and t1.progress_flag=" . COMPLETED_APPROVAL . "");
        $data['CloseCompleteTask'] = $this->m_task_manage->getTasks($filter);
        // pending Task
        // Where StartDate<today and close & complete != 4
        //t1.start_date<'" . date(DB_DF, time()) . "' and t1.end_date>='" . date(DB_DF, time()) . "' and 
        $filter = array("extra_where" => "t1.progress_flag<>" . COMPLETED_APPROVAL);
//        $this->util_model->printr($filter);
        
        $data['PendingTask'] = $this->m_task_manage->getTasks($filter);
//        $this->util_model->printr(count($data['PendingTask']));
//die();        
// over due task
        // EndDate<Today
        $filter = array("extra_where" => "t1.end_date<'" . date(DB_DF, time()) . "' and t1.progress_flag<>" . COMPLETED_APPROVAL . "");
        $data['OverDueTask'] = $this->m_task_manage->getTasks($filter);

        // Unbilled task
        // EndDate<Today
        $filter = array("extra_where" => "t1.progress_flag=" . COMPLETED_APPROVAL . " and t1.BillingDone=0");
        $data['Unbilled'] = $this->m_task_manage->getTasks($filter);

        // daily Task Entry
        $filter['Add_DateTime'] = date(DB_DF, time());
//        $filter['work_datetime'] = date(DB_DF, time());
        $data['DailyTaskEntry'] = $this->m_mis_report->DailyTaskEntryByTeam($filter);
//        $this->util_model->printr($data['DailyTaskEntry']);
        // TaskLogEntry Entry
        $filter['Add_DateTime'] = date(DB_DF, time());
        $filter['log_type'] = TASK_MASTER; // for task master 
//        $filter['work_datetime'] = date(DB_DF, time());
        $data['TaskLogEntry'] = $this->m_mis_report->getTaskLog($filter);
            
//        die($this->util_model->printr($data['TaskLogEntry']));
        $data['r_report'] = array(
            array("Summery Report"),
            array("New Task Created Today", count($data['NewTask'])),
            array("Today Completed Task ", count($data['CloseCompleteTask'])),
            array("Pending Task", count($data['PendingTask'])),
            array("OverDue Task", count($data['OverDueTask'])),
            array("Unbilled Task", count($data['Unbilled'])),
            array("Total Today Punched Entries", count($data['DailyTaskEntry'])),
            array("Total Today Task Edit Log Entries", count($data['TaskLogEntry'])),
            array(),
            array("Detailed Report"),
            array()
        );
        $data['r_report'][] = array("New Task Detailed Report");
        $this->formate_task_array($data['NewTask']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("Today Closed Task Detailed Report");
        $this->formate_task_array($data['CloseCompleteTask']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("Pending Task Detailed Report");
        $this->formate_task_array($data['PendingTask']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("OverDue Task Detailed Report");
        $this->formate_task_array($data['OverDueTask']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("Unbilled Task Detailed Report");
        $this->formate_task_array($data['Unbilled']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("Daily Task Entry Detailed Report");
        $this->formate_DailyTask_array($data['DailyTaskEntry']);
        $data['r_report'][] = array();
        $data['r_report'][] = array();
        $data['r_report'][] = array("Task Logs Entry Detailed Report");
        $this->formate_TaskLog_array($data['TaskLogEntry']);
    }

    function exportDailyTaskReport() {
        global $data;
        ob_start();
        $this->get_report_data();
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_report.xls";
        $this->excel->dailyTaskReporting($file_name, $data, TRUE); // true to export
        $path = base_url() . "/uploads/temp_reports/" . $file_name;
        ob_clean();
    }

    public function DailyTaskReport() {
        //OverDueTask report

        global $data;
        ob_start();
        $this->get_report_data();
        $this->load->library("reports/excel");
        $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "user_report.xls";
        $this->excel->dailyTaskReporting($file_name, $data);
        $path = base_url() . "/uploads/temp_reports/" . $file_name;
        ob_clean();

        
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'UTF-8';
        $config['dsn'] = TRUE;
        $config['wordwrap'] = TRUE;
        $config['validate'] = TRUE;
        $config['mailtype'] = "html";

        $this->email->initialize($config);

        $this->email->from(NOTIFY_EMAIL, 'TMS Reporting System');
        $this->email->to("sanjeev@kachhal.com");
        $this->email->cc("kumaranup594@gmail.com");
        $this->email->subject("Daily Progress Report for " . date(DF, time()));
        $this->email->message("Report mail sent @ " . date(DTF, time()));
        $this->email->attach(SITE_ROOT_PATH . "/uploads/temp_reports/$file_name");
        if ($this->email->send()) {
            echo "Mail sent";
        } else {
            echo "Error while sending";
        }
    }

    function formate_TaskLog_array($TaskLogEntry) {
        global $data;
        if (empty($TaskLogEntry)) {
            $data['r_report'][] = array("No Entry Found !!");
            return;
        }
        $data['r_report'][] = array(
            "S.No",
            "Task ID",
            "Task Name",
            "Task Incharge",
            "Log Desc",
            "Logged By",
            "Logged Date");

        $s_no = 1;
        foreach ($TaskLogEntry as $each_record) {
            $data['r_report'][] = array(
                $s_no++,
                $each_record['tm_id'],
                $each_record['tm_name'],
                $each_record['TaskIncharge'],
                $each_record['remarks'],
                $each_record['loggedBy'],
                $each_record['modified_datetime'],
            );
        }
    }

    function formate_DailyTask_array($DailytaskEntry_data) {
        global $data;
        if (empty($DailytaskEntry_data)) {
            $data['r_report'][] = array("No Entry Found !!");
            return;
        }
        $data['r_report'][] = array(
            "S.No",
            "Task ID",
            "Task Name",
            "Task Code",
            "Client Name",
            "Start Date",
            "End Date",
            "Incharge Name",
            "Sub task Name",
            "Sub Task Code",
            "sub task start Date",
            "sub task end Date",
            "Sub task Progress Flag",
            "Comment Progress Flag",
            "Comment Completed",
            "Assigned To",
            "Work_dateTiime",
            "Work efforts",
            "sub task efforts",
            "WorkDesc",
            "WorkEntryBy");

        $s_no = 1;
        
        foreach ($DailytaskEntry_data as $each_record) {
            $data['r_report'][] = array(
                $s_no++,
                $each_record['tm_id'],
                $each_record['tm_name'],
                $each_record['tm_code'],
                $each_record['client_name'],
                date(DF, strtotime($each_record['start_date'])),
                date(DF, strtotime($each_record['end_date'])),
                $each_record['TaskIncharge'],
                $each_record['tstm_name'],
                $each_record['tstm_code'],
                date(DF, strtotime($each_record['str_date_time'])),
                date(DF, strtotime($each_record['end_date_time'])),
                $this->util_model->get_progress_flag_string($each_record['progress_flag']),
                $this->util_model->get_progress_flag_string($each_record['stcprogressflag']),
                ($each_record['completed'] != '' ? $each_record['completed'] : "0") . "%",
                $each_record['AssigntoUser'],
                date(DF, strtotime($each_record['work_datetime'])),
                $each_record['efforts'],
                $each_record['tstm_efforts'],
                'comment' => strip_tags($each_record['comment']),
                'CommentBy' => $each_record['CommentBy'],
            );
        }
    }

    /*
     * it will formate the all task reprots     */

    function formate_task_array($task_data) {
        global $data;
        if (empty($task_data)) {
            $data['r_report'][] = array("No Entry Found !!");
            return;
        }
        $data['r_report'][] = array(
            "S.No",
            "Task ID",
            "Task Name",
            "Task Code",
            "Progress Flag",
            "BillingStatus",
            "Start Date",
            "End Date",
            "InchargeName",
            "Client Name",
            "Task Creater"
        );
        $s_no = 1;
        foreach ($task_data as $each_record) {
            $data['r_report'][] = array(
                $s_no++,
                $each_record['tm_id'],
                $each_record['tm_name'],
                $each_record['tm_code'],
                $this->util_model->get_progress_flag_string($each_record['progress_flag']),
                $each_record['BillingDone'] ? ("Billing Done From {$each_record['billedFrom']}") : ("Not Done"),
                date(DF, strtotime($each_record['start_date'])),
                date(DF, strtotime($each_record['end_date'])),
                $each_record['InchargeName'],
                $each_record['client_name'],
                $each_record['TaskCreater']
            );
        }
    }

}
  