<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('dashboard/m_dashboard'));
    }

    function view($path = 'pages', $page = 'v-dashboard') {
        global $data;
        $dashboard_weigets = array(
             "attachment"=>TRUE,
            "this_month_replica" => FALSE,
            "this_pending_task" => TRUE,
            "this_pending_sub_task" => TRUE,
            "this_free_hours" => TRUE,
            "this_assigned_task_approval" => TRUE,
            "this_upcoming_tasks" => TRUE,
            "this_billed_tasks" => TRUE,
            "this_completed_tasks" => TRUE,
            "this_approval_tasks" => TRUE,
            "this_daily_task_entry" => TRUE,
            "this_month_enq" => FALSE,
            "this_month_adm" => FALSE,
            "this_month_fee_coll" => FALSE,
            "this_month_follow_donut" => FALSE,
            "this_month_follow_tabular" => FALSE,
            "this_month_fee_pending" => FALSE,
            'last_7_day_working_hours' => FALSE,
            'last_7_days_entry_log' => FALSE,
            'team_monitering' => TRUE,
            'client_working_status' => TRUE,
            'task_monitering' => TRUE,
            'performance_chart' => TRUE,
            'pendingDailyTaskEntry' => TRUE,
            'SubTaskPendingForApproval' => TRUE,
            'pending_monthly_data'=>TRUE
        );
        
        
        
        if(!in_array($this->util_model->get_utype(), array(DIRECTOR,PARTNER))){
            $dashboard_weigets['this_billed_tasks'] = FALSE;
            $dashboard_weigets['this_completed_tasks'] = FALSE;
        }
        
        if (!file_exists(APPPATH . '/views/' . $path . '/' . $page . '.php')) {
            show_404();
        }
        
        
        $data['dashboard_weigets'] = $dashboard_weigets;
        $data['all_box'] = array();
        if ($dashboard_weigets['this_month_replica']) {

            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_replicas(),
                "title" => "Upcoming Replicas",
                "link" => base_url() . "tms/manage_tasks/All_replica_List",
                "link_title" => "View More Details",
                "extra_cls" => "yellow_panel"
            );
        }

        if ($dashboard_weigets['team_monitering']) {

            $data['team_monitering'] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_replicas(),
                "title" => "Upcoming Replicas",
                "link" => base_url() . "tms/manage_tasks/All_replica_List",
                "link_title" => "View More Details",
                "extra_cls" => "yellow_panel"
            );
            $data['team_monitering']['team_data'] = $this->m_dashboard->getTeamData();
        }

        if ($dashboard_weigets['client_working_status']) {
            $data['client_working_status']['clientTaskData'] = $this->m_dashboard->getClientWiseSubTaskStatus();
//            $this->util_model->printr($data['client_working_status']['clientTaskData']);
//            die();
        }
        
         if ($dashboard_weigets['task_monitering']) {
            $data['task_monitering']['TaskData'] = $this->m_dashboard->getTaskCatSubTaskStatus();
            $data['task_monitering']['AllTaskASPErCat'] = $this->m_dashboard->gettasktypemst();
//            $this->util_model->printr($data['task_monitering']);
//            die();
        } 

        if ($dashboard_weigets['performance_chart']) {
           // $data['performance_chart']['TaskData'] = $this->m_dashboard->getTaskCatSubTaskStatus();
            
            if(count($this->input->get('submit'))>0){ 
                 
               $data['performance_chart']['AllPerformanceChart'] = $this->m_dashboard->getPerformanceChartCurrentYear();
            }else{
                $data['performance_chart']['AllPerformanceChart'] = $this->m_dashboard->getPerformanceChart();
            } 


//            $this->util_model->printr($data['performance_chart']);
//            die();

             
        }

        if ($dashboard_weigets['last_7_day_working_hours']) {
            $json_data = $this->m_dashboard->get_last_7_days_working_hours();
//            $this->util_model->printr($json_data);
            $data['last_7_day_working_hours'] = array(
                "link" => base_url() . "tms/manage_users/free_users?startDate=" . date(DB_DF, strtotime("-7 days")) . "&endDate=" . date(DB_DF),
                "json_data" => $json_data
            );
        }

        if ($dashboard_weigets['last_7_days_entry_log']) {
            $json_data = $this->m_dashboard->last_7_days_entry_log();
//            $this->util_model->printr($json_data);
            $data['last_7_days_entry_log'] = array(
                "link" => base_url() . "tms/manage_users/free_users?startDate=" . date(DB_DF, strtotime("-7 days")) . "&endDate=" . date(DB_DF),
                "json_data" => $json_data
            );
        }
        
        if ($dashboard_weigets['this_pending_task']) {
            $result = $this->m_dashboard->count_pending_task();
            $self_pending = $this->m_dashboard->count_pending_task(1);
            $data['all_box'][] = array(
                "icon" => "fa fa-clock-o fa-4x",
                "value" => "<a href='" . base_url() . "tms/manage_tasks/my_tasks?Incharge=" . $this->util_model->get_uid() . "'>" . $self_pending['pending_task'] . "</a>/<a href='" . base_url() . "tms/manage_tasks/my_tasks'>" . $result['pending_task'] . "</a>",
                "title" => "My/All Pending Task, Respectively<br>&nbsp;&nbsp;&nbsp; Time Req. (" . $self_pending['total_hrs'] . ")/(" . $result['total_hrs'] . ")",
                "link" => base_url() . "tms/manage_tasks/my_tasks?Incharge=" . $this->util_model->get_uid(),
                "link_title" => "<a href='" . base_url() . "tms/manage_tasks/my_tasks?Incharge=" . $this->util_model->get_uid() . "'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        if ($dashboard_weigets['this_free_hours']) {
            $this->load->model("tms/m_task_manage");
            $result = $this->m_task_manage->fetch_users();
            $free_hours = 0;
            foreach ($result as $value) {
                if ($value['free_hours'] > 0)
                    $free_hours += $value['free_hours'];
            }
            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $free_hours,
                "title" => "Free Man Hours",
                "link" => base_url() . "tms/manage_users/free_users",
                "link_title" => "<a href='" . base_url() . "tms/manage_users/free_users'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        if ($dashboard_weigets['this_pending_sub_task']) {
            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => "<a href='" . base_url() . "my_sub_tasks?tab=pending_sub_task&assignTo=" . $this->util_model->get_uid() . "'>" . $this->m_dashboard->count_pending_sub_task(1) . "</a>/" . "<a href='" . base_url() . "my_sub_tasks?tab=pending_sub_task&assignTo=''>" . $this->m_dashboard->count_pending_sub_task() . "</a>",
                "title" => "Pending Sub Tasks",
                "link" => base_url() . "my_sub_tasks?tab=pending_sub_task&assignTo=" . $this->util_model->get_uid(),
                "link_title" => "<a href='" . base_url() . "my_sub_tasks?tab=pending_sub_task&assignTo=" . $this->util_model->get_uid() . "'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        
        // if ($dashboard_weigets['this_upcoming_tasks']) {
        //     $data['all_box'][] = array(
        //         "icon" => "fa fa-calendar-o fa-4x",
        //         "value" => $this->m_dashboard->count_upcoming_tasks(),
        //         "title" => "Upcoming Sub Tasks",
        //         "link" => base_url() . "my_sub_tasks?tab=upcoming_sub_task&assignTo=" . $this->util_model->get_uid(),
        //         "link_title" => "<a href='" . base_url() . "my_sub_tasks?tab=upcoming_sub_task&assignTo=" . $this->util_model->get_uid()."'>View More Details</a>",
        //         "extra_cls" => "light_blue"
        //     );
        // }

        if ($dashboard_weigets['this_completed_tasks']) {
            $data['all_box'][] = array(
                "icon" => "fa fa-check-square-o fa-4x",
                "value" => $this->m_dashboard->count_completed_tasks(),
                "title" => "Pending Billing of Completed Tasks",
                "link" => base_url() . "tms/manage_tasks/completed_tasks?BillingDone=0",
                "link_title" => "<a href='" . base_url() . "tms/manage_tasks/completed_tasks?BillingDone=0'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        if ($dashboard_weigets['this_billed_tasks']) {
            $data['all_box'][] = array(
                "icon" => "fa fa-check-square-o fa-4x",
                "value" => $this->m_dashboard->count_billed_tasks(),
                "title" => "Billed Tasks",
                "link" => base_url() . "tms/manage_tasks/billed_tasks",
                "link_title" => "<a href='" . base_url() . "tms/manage_tasks/billed_tasks'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        
         if($dashboard_weigets['attachment']){
            $this->load->model("tms/m_task_manage");
            $value = $this->m_task_manage->fetch_attachment();
            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $value['pending']."/".$value['approve'],
                "title" => "Task Documents Under Approval",
                "link" => base_url() . "tms/manage_tasks/view_file",
                "link_title" => "<a href='" . base_url() . "tms/manage_tasks/view_file'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
          
        }
        
        if ($dashboard_weigets['this_approval_tasks']) {
            $data['all_box'][] = array(
                "icon" => "fa fa-check-square-o fa-4x",
                "value" => $this->m_dashboard->count_approval_tasks(),
                "title" => "Tasks waiting for approval",
                "link" => base_url() . "tms/manage_tasks/approval_tasks",
                "link_title" => "<a href='" . base_url() . "tms/manage_tasks/approval_tasks'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        
        // if ($dashboard_weigets['this_daily_task_entry']) {
        //     $data['all_box'][] = array(
        //         "icon" => "fa fa-calendar fa-4x",
        //         "value" => $this->m_dashboard->count_daily_entries(),
        //         "title" => "Daily Task Entry (Entries Made Today)",
        //         "link" => base_url() . "tms/daily_task/daily_task_entry",
        //         "link_title" => "<a href='" . base_url() . "tms/daily_task/daily_task_entry'>View More Details</a>",
        //         "extra_cls" => "light_blue"
        //     );
        // }
        
        if ($dashboard_weigets['this_assigned_task_approval']) {

            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_assigned_t_approval(),
                "title" => "Unassigned Task Approval Request",
                "link" => base_url() . "tms/manage_sub_task/get_approve_pst",
                "link_title" => "<a href='" . base_url() . "tms/manage_sub_task/get_approve_pst'>View More Details</a>",
                "extra_cls" => "red_panel"
            );
        }
        
        if($dashboard_weigets['pending_monthly_data']){
             $data['noti_boxes'][] = array(
                "icon" => "fa fa-bell fa-fw",
                "value" => $this->m_dashboard->count_pending_upload_data(),
                "title" => "Pending Monthly Data",
                "link" => base_url() . "tms/manage_files/index?status=".CLIENT_FILE_PENDING_STATUS,
                "link_title" => "<a href='" . base_url() . "tms/manage_files/index'>View More Details</a>",
                "extra_cls" => "red_panel"
            );
        }
        
        $getPeriodsPendings = $this->m_dashboard->getPeriodsPendings();
        foreach($getPeriodsPendings as $eachRow){
            $data['noti_boxes'][] = array(
                "icon" => "fa fa-bell fa-fw",
                "value" => $eachRow['totalPending'],
                "title" => "For ".$eachRow['term_name'],
                "link" => base_url() . "tms/manage_tasks/my_tasks?task_period_id=".$eachRow['task_period_id'],
                "link_title" => "<a href='" . base_url() . "tms/manage_files/index'>View More Details</a>",
                "extra_cls" => "red_panel"
            );
        }

        if ($dashboard_weigets['this_month_enq']) {

            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_enq(),
                "title" => "Monthly Enquiries",
                "link" => base_url() . "Enquiry/enquiry/all_enq_list",
                "link_title" => "<a href='" . base_url() . "Enquiry/enquiry/all_enq_list'>View More Details</a>",
                "extra_cls" => "yellow_panel"
            );
        }
        if ($dashboard_weigets['this_month_adm']) {
            $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->get_total_adm(),
                "title" => "Monthly Admission",
                "link" => base_url() . "adm/cadm/all_adm",
                "link_title" => "<a href='" . base_url() . "adm/cadm/all_adm'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        if ($dashboard_weigets['this_month_fee_coll']) {
            $data['all_box'][] = array(
                "icon" => "glyphicon glyphicon-credit-card gi-4x",
                "value" => $this->m_dashboard->get_total_fee_collection(),
                "title" => "Monthly Fee Collection",
                "link" => base_url() . "fees/Fee_Master/all_fee_records",
                "link_title" => "View More Details",
                "extra_cls" => "red_panel"
            );
        }
        
        if ($dashboard_weigets['pendingDailyTaskEntry']) {
             $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_pending_daily_entries(),
                "title" => "Daily Entry (Pending for Approval)",
                "link" => base_url() . "tms/daily_task/approveDailyTaskEntry",
                "link_title" => "<a href='" . base_url() . "tms/daily_task/approveDailyTaskEntry'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        
        if ($dashboard_weigets['SubTaskPendingForApproval']) {
             $data['all_box'][] = array(
                "icon" => "fa fa-calendar fa-4x",
                "value" => $this->m_dashboard->count_pending_subTask_entries(),
                "title" => "All Sub Task Entry (Pending for Approval)",
                "link" => base_url() . "my_sub_tasks?progress_flag=3&filter_by=0",
                "link_title" => "<a href='" . base_url() . "my_sub_tasks?progress_flag=3&filter_by=0'>View More Details</a>",
                "extra_cls" => "light_blue"
            );
        }
        if ($dashboard_weigets['this_month_fee_pending']) {
            /* Followed or not donut creation */
            $this->load->model(array('enquiry/m_enquiry'));
            $pending = $this->m_dashboard->pending_fee(array("BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
            $data['pending_fees'] = $this->get_current_pending($pending);
        }

        if ($dashboard_weigets['this_month_follow_tabular']) {
            /* Followed or not donut creation */
            $this->load->model(array('enquiry/m_enquiry'));
            $data['todays_follow_up'] = $this->m_enquiry->todays_follow_list(array($data['Session_Data']['IBMS_BRANCHID']));
            //$this->util_model->printr($data['todays_follow_up']);
            $followed = 0;
            $unfolloed = 0;
            foreach ($data['todays_follow_up'] as $f) {
                if ($f->ViewNotification)
                    $followed++;
                else
                    $unfolloed++;
            }
            $data['followed'] = $followed;
            $data['unfollowed'] = $unfolloed;
            $total = $followed + $unfolloed;
        }
        if ($dashboard_weigets['this_month_follow_donut']) {
            /* Followed or not donut creation */
            $this->load->model(array('enquiry/m_enquiry'));
            $data['todays_follow_up'] = $this->m_enquiry->todays_follow_list(array($data['Session_Data']['IBMS_BRANCHID']));
            $followed = 0;
            $unfolloed = 0;
            foreach ($data['todays_follow_up'] as $f) {
                if ($f->ViewNotification)
                    $followed++;
                else
                    $unfolloed++;
            }
            $data['followed'] = $followed;
            $data['unfollowed'] = $unfolloed;
            $total = $followed + $unfolloed;
            $followed_per = 0;
            $unfolloed_per = 0;
            if ($total) {
                $followed_per = ($followed * 100) / $total;
                $unfolloed_per = ($unfolloed * 100) / $total;
            }
            $data['follow_up_details'] = "{value: $followed_per, label: 'Followed'},
                                  {value: $unfolloed_per, label: 'Remained'}";
            /* end of Followed or not donut creation */
        }

        
        
        

        $data['total_adm'] = 0; //$this->admission_model->this_month_admission();
//        echo "<pre>";
//        print_r($data);
        $this->load->view('templates/header.php', $data);
        $this->load->view("pages/v-dashboard.php", $data);
        $this->load->view('templates/footer_js.php');
    }

   /* public function performanceChartAjax(){
        echo "hello";
    }*/

    public function get_menu() {
        global $data;
        echo json_encode(array("Menu" => $data['MenuList']));
    }

    function sendDailyTaskMail(){
        $datetime2 = new DateTime();
        $datetime2->modify('-1 day');
        $weekday = $datetime2->format('w');
        if($weekday!=0 && $weekday!=6){
            $this->sendDailyMail($datetime2);
            echo json_encode(array("success" => true));
        }else{
            if($weekday==0){
                $datetime0 = new DateTime();
                $datetime0->modify('-2 day');
                $this->sendDailyMail($datetime0);
                echo json_encode(array("success" => true));
            }else if($weekday==6){
                $datetime1 = new DateTime();
                $datetime1->modify('-1 day');
                $this->sendDailyMail($datetime1);
                echo json_encode(array("success" => true));
            }else{
                echo json_encode(array("success" => false,"_err_msg" => "Some Error occured"));
            }
        }
    }
    function tendaysperiodemail(){
        $this->load->library('email');
        $newDate = $date->format('Y-m-d');
        $newDate .= " 00:00:00";
        $datetime2 = new DateTime();
        $current = $datetime2->format('Y-m-d');
        $current .= " 00:00:00";
        $sql = "SELECT t1.Emp_ID,t1.`P_Email`,t1.Emp_Name
            FROM nexgen_employee t1
            WHERE NOT EXISTS (SELECT t2.Add_User FROM nexgen_task_sub_task_comments t2 
            WHERE t1.Emp_ID = t2.Add_User AND
            t2.Add_DateTime > '".$newDate."' 
            AND t2.Add_DateTime < '".$current."') AND t1.UTID IN (9)";
        $query = $this->db->query($sql);
        $result = $query->result();
        $sql1 = "SELECT template FROM nexgen_email_templates
            INNER JOIN nexgen_menus ON nexgen_menus.MID = nexgen_email_templates.module_id
            WHERE nexgen_menus.`function` = 'tendaysperiodemail'";
        $result1 = $this->db->query($sql1)->row_array();
        if($result1){
            $template = $result1['template'];
            foreach ($result as $key => $value) {
                $template = str_replace("VAR.MONTH", date('m'), $template);
                $template = str_replace("VAR.YEAR", date('Y'), $template);
                $template = str_replace("VAR.CLIENT_NAME", $value->Emp_Name, $template);
                $this->email->from("info@kachhal.in");
                $this->email->to("{$value->P_Email}");
                $this->email->subject('Ten Days Report');
                $this->email->message($template);
                //$this->email->send();
            }
            echo json_encode(array("success" => true));
        }else{
            echo json_encode(array("success" => false,"_err_msg"=>"Template not Found"));
        }
        
    }
    function overduetaskemail(){
        $this->load->library('email');
        $newDate = $date->format('Y-m-d');
        $newDate .= " 00:00:00";
        $datetime2 = new DateTime();
        $current = $datetime2->format('Y-m-d');
        $current .= " 00:00:00";
        $sql = "SELECT t1.Emp_ID,t1.`P_Email`,t1.Emp_Name
            FROM nexgen_employee t1
            WHERE NOT EXISTS (SELECT t2.Add_User FROM nexgen_task_sub_task_comments t2 
            WHERE t1.Emp_ID = t2.Add_User AND
            t2.Add_DateTime > '".$newDate."' 
            AND t2.Add_DateTime < '".$current."') AND t1.UTID IN (9)";
        $query = $this->db->query($sql);
        $result = $query->result();
        $sql1 = "SELECT template FROM nexgen_email_templates
            INNER JOIN nexgen_menus ON nexgen_menus.MID = nexgen_email_templates.module_id
            WHERE nexgen_menus.`function` = 'overduetaskemail'";
        $result1 = $this->db->query($sql1)->row_array();
        if($result1){
            $template = $result1['template'];
            foreach ($result as $key => $value) {
                $template = str_replace("VAR.MONTH", date('m'), $template);
                $template = str_replace("VAR.YEAR", date('Y'), $template);
                $template = str_replace("VAR.CLIENT_NAME", $value->Emp_Name, $template);
                $this->email->from("info@kachhal.in");
                $this->email->to("{$value->P_Email}");
                $this->email->subject('OverDue Task Reminder');
                $this->email->message($template);
                //$this->email->send();
            }
            echo json_encode(array("success" => true));
        }else{
            echo json_encode(array("success" => false,"_err_msg"=>"Template not Found"));
        }
        
    }

    function sendDailyMail($date){
        $this->load->library('email');
        $newDate = $date->format('Y-m-d');
        $newDate .= " 00:00:00";
        $datetime2 = new DateTime();
        $current = $datetime2->format('Y-m-d');
        $current .= " 00:00:00";
        $sql = "SELECT t1.Emp_ID,t1.`P_Email`,t1.Emp_Name
            FROM nexgen_employee t1
            WHERE NOT EXISTS (SELECT t2.Add_User FROM nexgen_task_sub_task_comments t2 
            WHERE t1.Emp_ID = t2.Add_User AND
            t2.Add_DateTime > '".$newDate."' 
            AND t2.Add_DateTime < '".$current."') AND t1.UTID IN (9)";
        $query = $this->db->query($sql);
        $result = $query->result();
        $sql1 = "SELECT template FROM nexgen_email_templates
            INNER JOIN nexgen_menus ON nexgen_menus.MID = nexgen_email_templates.module_id
            WHERE nexgen_menus.`function` = 'sendDailyTaskMail'";
        $result1 = $this->db->query($sql1)->row_array();
        if($result1){
            $template = $result1['template'];
            foreach ($result as $key => $value) {
                $template = str_replace("VAR.MONTH", date('m'), $template);
                $template = str_replace("VAR.YEAR", date('Y'), $template);
                $template = str_replace("VAR.CLIENT_NAME", $value->Emp_Name, $template);
                $this->email->from("info@kachhal.in");
                $this->email->to("{$value->P_Email}");
                $this->email->subject('Daily Task Entry Reminder');
                $this->email->message($template);
                //$this->email->send();
            }
        }
    }

    function get_current_pending($pending) {

        $today = strtotime(date('Y-m-d', time()));
        $dates = array();
        $i = 0;
        foreach ($pending as $row) {
            preg_match('/(NextDueDate__)(.*?)\//', $row['last_fee_details'], $arr);
            if (empty($arr) || !isset($arr[2]) || strtotime($arr[2]) > $today) {
                unset($pending[$i]);
            } else {
                $pending[$i]['due_date'] = $arr[2];
                preg_match('/(NetPayableAmt__)(.*?)\//', $row['last_fee_details'], $arr);
                $pending[$i]['NetPayableAmt'] = !empty($arr) && isset($arr[2]) ? $arr[2] : "";
                preg_match('/(PaidAmt__)(.*?)\//', $row['last_fee_details'], $arr);
                $pending[$i]['PaidAmt'] = !empty($arr) && isset($arr[2]) ? $arr[2] : "";
                preg_match('/(BalanceAmt__)(.*?)\//', $row['last_fee_details'], $arr);
                $pending[$i]['BalanceAmt'] = !empty($arr) && isset($arr[2]) ? $arr[2] : "";
                preg_match('/(NextInstAmt__)(.*?)$/', $row['last_fee_details'], $arr);
                $pending[$i]['DueInstAmt'] = !empty($arr) && isset($arr[2]) ? $arr[2] : "";
            }
            $i++;
        }
        unset($arr);
        return array_values($pending);
    }

}
