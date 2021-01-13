<?php

class m_dashboard extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getPeriodsPendings(){
        $sql = "SELECT count(*) as totalPending, tm.task_period_id, t.term_name FROM `nexgen_task_mst` tm left join nexgen_term_mst t on (t.term_id = tm.task_period_id) WHERE tm.task_period_id is not null and tm.progress_flag <> ".COMPLETED_APPROVAL."  group by tm.task_period_id";
        $q = $this->db->query($sql);
        return $q->result_array();
    }

    /*
     * get_total_fee_collection()
     * return total fee collection
     */

    function get_total_fee_collection($whr = array()) {
        global $data;
        if (empty($whr)) {
            $this->db->where("fee_trn.ReceiptDate>='" . Year . "-" . Month . "-01' AND fee_trn.ReceiptDate<='" . Year . "-" . Month . "-" . date("d") . "'", NULL, FALSE);
            $this->db->where(array("fee_trn.Status" => TRUE, "stu_mst.BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
        }

        $this->db->select_sum("PaidAmt")->from(DB_PREFIX . "fee_trn fee_trn");
        $this->db->join(DB_PREFIX . "stu_mst stu_mst", "fee_trn.Stu_ID=stu_mst.Stu_ID", "left");
        $result = $this->db->get()->result();
//                           echo $this->db->last_query();
//                           die($this->util_model->printr($result));
        if (!empty($result[0])) {
            return $result[0]->PaidAmt != "" ? $result[0]->PaidAmt : 0;
        } else {
            return 0;
        }
    }

    /*

     * it will just count the no of enquiry between two dates
     *                */

    public function count_enq($whr = array()) {
        global $data;
        // branch id
        if (empty($whr)) {
            $this->db->where("es.DOE>='" . Year . "-" . Month . "-01' AND es.DOE<='" . Year . "-" . Month . "-" . date("d", strtotime("+1 day")) . "'", NULL, FALSE);
            $this->db->where(array("es.Status" => TRUE, "et.Status" => TRUE, "et.BranchID" => $data['Session_Data']['IBMS_BRANCHID']));
        }
        $this->db->select('ec.E_Code')->from(DB_PREFIX . "e_courses ec");
        $this->db->join(DB_PREFIX . "e_tab et", ("ec.E_Code=et.E_Code"), "left");
        $this->db->join(DB_PREFIX . "e_sources es", ("ec.E_Code=es.E_Code and ec.Visit=es.Visit"), "left");
        $qry = $this->db->get();
        // echo $this->db->last_query();
        // die($this->util_model->printr($result));

        return $qry->num_rows();
    }
    public function getPerformanceChartCurrentYear(){ 
        $this->db->select("tst.tstm_id,tst.tstm_name,tm.tm_name, tm.end_date, e.Emp_Name as entryBy,client.Emp_Name as client_name, tstc.comment_id, SUM(ROUND(tstc.efforts)) as count_hours, tstc.approved,tstc.completed,DATE_FORMAT(tstc.work_datetime, '%d-%m-%Y') as work_date,tstc.comment,DATE_FORMAT(tstc.Add_DateTime, '%d-%m-%Y @ %h:%i %p') as EntryTime", FALSE)->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee `client`", "client.Emp_ID = tm.client_id", "left");
        $this->db->join(DB_PREFIX . "employee e", "tstc.Add_User = e.Emp_ID", "left"); 
        $this->db->like("tstc.work_datetime",2020);
        $this->db->group_by("entryBy");
        $this->db->order_by("count_hours", "DESC");
         
        
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }
    public function getPerformanceChart(){ 
        $this->db->select("tst.tstm_id,tst.tstm_name,tm.tm_name, tm.end_date, e.Emp_Name as entryBy,client.Emp_Name as client_name, tstc.comment_id,SUM(ROUND(tstc.efforts)) as count_hours,tstc.approved,tstc.completed,DATE_FORMAT(tstc.work_datetime, '%d-%m-%Y') as work_date,tstc.comment,DATE_FORMAT(tstc.Add_DateTime, '%d-%m-%Y @ %h:%i %p') as EntryTime", FALSE)->from(DB_PREFIX . "task_sub_task_comments as tstc");
        $this->db->join(DB_PREFIX . "task_sub_task as tst", "tstc.tstm_id=tst.tstm_id", 'left');
        $this->db->join(DB_PREFIX . "task_mst as tm", "tst.tm_id=tm.tm_id", 'left');
        $this->db->join(DB_PREFIX . "employee `client`", "client.Emp_ID = tm.client_id", "left");
        $this->db->join(DB_PREFIX . "employee e", "tstc.Add_User = e.Emp_ID", "left"); 
        $this->db->like("tstc.work_datetime",@$_GET['duration']);
        $this->db->group_by("entryBy");
        $this->db->order_by("count_hours", "DESC");
         
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $result;
    }

    public function get_total_adm() {
        $this->load->model("adm/admission_model", "adm_model");
        $filter_data = array(
            "search_via_value" => array(),
            "adv_search" => "Adv_search",
            "DOE_DOR" => "DOR",
            "From" => Year . '-' . Month . '-' . "01",
            "To" => Year . '-' . Month . '-' . date('d', strtotime("+1 day")));
        $result = $this->adm_model->msearch_adm($filter_data);
        return count($result);
    }

    public function pending_fee($filter_data) {
        if (!isset($filter_data['BatchStatusIDs'])) {
            $this->load->model('branch/branch_model');
            $branch_settings = $this->branch_model->get_branch_setting($filter_data['BranchID']);
            $this->db->where_in("sb.BatchStatusID", $branch_settings->stu_batch_statusIDs);
        }

        if (isset($filter_data['BranchID'])) {
            $this->db->where_in("stu_mst.BranchID", array($filter_data['BranchID']));
        }

        $this->db->select("sc.Stu_ID,(select CONCAT('NetPayableAmt__',fee_trn1.NetPayableAmt,'/PaidAmt__',fee_trn1.PaidAmt,'/BalanceAmt__',fee_trn1.BalanceAmt,'/NextDueDate__',fee_trn1.NextDueDate,'/NextInstAmt__',fee_trn1.NextInstAmt)  from nexgen_fee_trn fee_trn1 where "
                . "fee_trn1.Stu_ID= sc.Stu_ID and fee_trn1.CourseID=sc.CourseID ORDER BY fee_trn1.ReceiptNo DESC 
LIMIT 1) as last_fee_details,sc.DOR,sc.due_day,sc.E_Code,sc.Visit,sc.CourseID as admCourseID,"
                . "sc.Remarks, stu_mst.EnrollNo,stu_mst.StudentName,stu_mst.FatherName,"
                . "stu_mst.C_Locality,stu_mst.Mobile1,stu_mst.Email1", FALSE)->from(DB_PREFIX . "stu_courses sc");
        $this->db->join(DB_PREFIX . "stu_mst stu_mst", "sc.Stu_ID = stu_mst.Stu_ID", "left");
        $this->db->join(DB_PREFIX . "stu_batches sb", "sc.Stu_ID = sb.Stu_ID and sc.CourseID = sb.CourseID", "left");

        //$this->db->where("",NULL,FALSE);
        $this->db->where(array("sc.Status" => TRUE));
        $query = $this->db->get();
//                            echo $this->db->last_query();
//                            die();
        return $query->result_array();
    }

    public function count_replicas() {
        $this->db->select("count(tm.does_repeat) as replica_count")->from(DB_PREFIX . "task_mst as tm");
        $this->db->where("tm.does_repeat = " . STATUS_TRUE . " and tm.repeated_from IS NOT NULL and tm.start_date ", NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['replica_count'];
    }

    public function count_pending_sub_task($self = 0) {
        $this->db->select("count(tst.progress_flag) as pending_task")->from(DB_PREFIX . "task_sub_task as tst");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER)) || $self) {
            $this->db->where("tst.assignedto=" . $this->util_model->get_uid(), NULL, FALSE);
        }
        $this->db->where("tst.status=1 and tst.progress_flag <>" . COMPLETED_APPROVAL, NULL, FALSE);
        $res = $this->db->get()->row_array();
//        echo $this->db->last_qeu
        return $res['pending_task'];
    }

    public function count_upcoming_tasks() {
        $this->db->select("count(tst.tstm_id) as upcoming_task")->from(DB_PREFIX . "task_sub_task as tst");
        $this->db->where("tst.str_date_time > '" . date(DB_DTF, time()) . "' and tst.status = " . STATUS_TRUE . " and tst.assignedto=" . $this->util_model->get_uid() . " and tst.progress_flag<>" . COMPLETED_APPROVAL, NULL, FALSE);
        $res = $this->db->get()->row_array();
//        echo $this->db->last_query();
        return $res['upcoming_task'];
    }

    public function count_completed_tasks() {
        $this->db->select("count(tm.progress_flag) as completed_task")->from(DB_PREFIX . "task_mst as tm");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_id = " . $this->util_model->get_uid() . " and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        } else {
            $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        }
        $this->db->where("tm.BillingDone=0 and tu.user_type= " . INCHARGE . " and tu.status = " . STATUS_TRUE . " and tm.progress_flag =" . COMPLETED_APPROVAL, NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['completed_task'];
    }

    public function count_billed_tasks() {
        $this->db->select("count(tm.progress_flag) as completed_task")->from(DB_PREFIX . "task_mst as tm");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_id = " . $this->util_model->get_uid() . " and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        } else {
            $this->db->join(DB_PREFIX . "task_users as tu", "tu.tm_id=tm.tm_id and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE, 'left');
        }
        $this->db->where("tu.user_type= " . INCHARGE . " and tu.status = " . STATUS_TRUE . " and tm.BillingDone=1 and tm.progress_flag =" . COMPLETED_APPROVAL, NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['completed_task'];
    }

    public function count_approval_tasks() {
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            return 0;
        }
        $this->db->select("count(tm.progress_flag) as completed_task")->from(DB_PREFIX . "task_mst as tm");
        $this->db->where("tm.status = " . STATUS_TRUE . " and tm.progress_flag =" . COMPLETED_REQUEST, NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['completed_task'];
    }

    public function count_pending_task($self = 0) {
        $this->db->select("count(DISTINCT(tm.tm_id)) as pending_task,(select SUM(tst.tstm_efforts)  from " . DB_PREFIX . "task_sub_task as tst where tst.tm_id=tm.tm_id and tst.progress_flag =" . IN_PROGRESS . ") as total_hours")->from(DB_PREFIX . "task_mst as tm");
        $this->db->join(DB_PREFIX . "employee as emp1", "emp1.Emp_ID=tm.client_id", 'left');
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER)) || $self) {
            $this->db->where("(select count(*) from " . DB_PREFIX . "task_users as tu where tu.tm_id=tm.tm_id and tu.user_id=" . $this->util_model->get_uid() . "  and tu.user_type = " . INCHARGE . " and tu.status=" . STATUS_TRUE . ")>0", NULL, FALSE);
        }

        $this->db->where("tm.status = " . STATUS_TRUE . " and tm.progress_flag <> " . COMPLETED_APPROVAL, NULL, FALSE);
        $res = $this->db->get()->row_array();
//         echo $this->db->last_query();
        if ($res['pending_task']) {
            $hours = round($res['total_hours']);
            $zero = new DateTime('@0');
            $offset = new DateTime('@' . $hours * 3600);
            $diff = $zero->diff($offset);
            return array("pending_task" => $res['pending_task'], "total_hrs" => $diff->format('%d Days, %h Hours'));
        } else {
            return array("pending_task" => $res['pending_task'], "total_hrs" => $res['total_hours'] . ' Hours');
        }
    }

    public function count_daily_entries() {
        $this->db->select("count(comment_id) as today_entries")->from(DB_PREFIX . "task_sub_task_comments");
        $this->db->where(array("Add_User" => $this->util_model->get_uid(), "status" => STATUS_TRUE));
        $this->db->where("work_datetime > '" . date("Y-m-d", time()) . " 00:00:00'", NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['today_entries'];
    }

    public function count_pending_daily_entries() {
        $this->db->select("count(comment_id) as today_entries")->from(DB_PREFIX . "task_sub_task_comments");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->where(array("Add_User" => $this->util_model->get_uid()));
        }
        $this->db->where("approved=0", NULL, FALSE);
        $res = $this->db->get()->row_array();
//        echo $this->db->last_query();
        return $res['today_entries'];
    }
     public function count_pending_subTask_entries() {
        $this->db->select("count(tstm_id) as today_entries")->from(DB_PREFIX . "task_sub_task");
        if (!in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
            $this->db->where(array("Add_User" => $this->util_model->get_uid()));
        }
        $this->db->where("progress_flag=".COMPLETED_REQUEST, NULL, FALSE);
        $res = $this->db->get()->row_array();
        return $res['today_entries'];
    }

    public function count_assigned_t_approval() {
        $this->load->model("tms/m_manage_sub_task", "m_sub_task");
        return count($this->m_sub_task->get_approve_pst());
    }

    public function get_last_7_days_working_hours() {
        $sql = "SELECT (SELECT count(*) FROM nexgen_employee WHERE UTID in (select UTID from nexgen_usertypes where status=1 and UserTypeGroup=1))*'" . PER_DAY_HOURS . "'  as total_working_hours,sum(efforts) as efforts,date(work_datetime) as work_datetime FROM nexgen_task_sub_task_comments
WHERE date(work_datetime) >= curdate() - INTERVAL DAYOFWEEK(curdate())+8 DAY
AND date(work_datetime) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY group by date(work_datetime)";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function last_7_days_entry_log() {
        $sql = "SELECT count(distinct(Add_User)) as wrkDonePunched,count(Add_User) as total_entry,(SELECT count(*) FROM nexgen_employee WHERE UTID in (select UTID from nexgen_usertypes where status=1 and UserTypeGroup=1))  as total_users,date(work_datetime) as work_datetime FROM nexgen_task_sub_task_comments
WHERE date(work_datetime) >= curdate() - INTERVAL DAYOFWEEK(curdate())+8 DAY
AND date(work_datetime) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY group by date(work_datetime)";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function getTeamData() {
        $userType = $this->util_model->get_utype();
        if ($userType == PARTNER || $userType == DIRECTOR) {
        $sql = "SELECT count(*)  as total_subTask,emp.UTID, "
                    . "emp.Emp_ID as assignedTo,emp.Emp_Name as assignedPer,"
                    . "sum(tst.tstm_efforts) as time_given, "
                    . "(SELECT sum(efforts) FROM nexgen_task_sub_task_comments "
                    . "comment WHERE comment.tstm_id in "
                    . "(select tst2.tstm_id from nexgen_task_sub_task "
                    . "tst2 where tst2.assignedto = tst.assignedto "
                    . "and tst2.progress_flag <> ".COMPLETED_APPROVAL.") and " 
                    . "comment.Add_User = tst.assignedto) "
                    . "as time_spent,(SELECT count(*) FROM `nexgen_task_sub_task` WHERE `assignedto` = tst.assignedto and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task FROM nexgen_task_sub_task "
                    . "tst left join nexgen_employee emp on  (emp.Emp_ID = tst.assignedto) "
                    . " where tst.status=1 and emp.status=1 group by tst.assignedto order by emp.Emp_Name";
        } else {
            $sql = "SELECT count(*)  as total_subTask,emp.UTID,emp.Emp_ID as assignedTo,emp.Emp_Name as assignedPer,sum(tst.tstm_efforts) as time_given, (SELECT sum(efforts) FROM nexgen_task_sub_task_comments comment WHERE comment.tstm_id in (select tst2.tstm_id from nexgen_task_sub_task tst2 where tst2.assignedto = tst.assignedto and tst2.progress_flag <> 4) and comment.Add_User = tst.assignedto) as time_spent,"
                    . " (SELECT count(*) FROM `nexgen_task_sub_task` WHERE `assignedto` = tst.assignedto and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task FROM nexgen_task_sub_task tst left join nexgen_employee emp on  (emp.Emp_ID = tst.assignedto)  WHERE (tst.assignedto in (SELECT distinct tst3.assignedto FROM nexgen_task_sub_task tst3 WHERE tst3.tm_id in (SELECT tuser.tm_id FROM nexgen_task_users tuser WHERE user_type=1 and status=1 and user_id=" . $this->util_model->get_uid() . "))) and progress_flag <> 4 and tst.status=1  group by tst.assignedto order by emp.Emp_Name";
        }
        
        $result = $this->db->query($sql)->result_array();
        foreach ($result as $key => $val) {
            $sql1="SELECT COUNT(*) AS totaltask FROM (nexgen_task_mst AS tm) LEFT JOIN nexgen_task_type_mst AS ttm ON ttm.ttm_id = tm.ttm_id AND ttm.status=1 
            LEFT JOIN nexgen_employee AS emp1 ON emp1.Emp_ID=tm.client_id 
            LEFT JOIN nexgen_task_users AS tu ON tu.tm_id=tm.tm_id AND tu.user_type = 1 AND tu.status=1 
            LEFT JOIN nexgen_employee AS emp2 ON emp2.Emp_ID=tu.user_id 
            LEFT JOIN nexgen_task_billing_mst AS bmst ON bmst.bill_mst_id=(SELECT bill_mst_id FROM nexgen_task_billnos bn WHERE bn.tm_id=tm.tm_id AND bn.status=1 LIMIT 1) 
            LEFT JOIN nexgen_task_bill_account AS tbacc ON tbacc.bill_account_id=bmst.bill_account_id 
            WHERE tm.BillingDone = 0 AND tm.progress_flag = '2' AND tu.user_id IN (".$val['assignedTo'].") AND tm.status = 1 ";
            $result1 = $this->db->query($sql1)->result_array();
            if(count($result1)>0){
                $result[$key]['total_subTask']=$result1[0]['totaltask'];
            }
        }
        $allowed_utids = $this->util_model->get_lower_utids();
        foreach ($result as $index => $row) {
            if (!in_array($row['UTID'], $allowed_utids))
                unset($result[$index]);
        }
        return $result;
    }

    public function getClientWiseSubTaskStatus() {
        $userType = $this->util_model->get_utype();
        if ($userType == PARTNER || $userType == DIRECTOR) {
            $sql = "SELECT 
                tm.tm_id, tm.progress_flag,emp.UTID,(SELECT count(*) FROM `nexgen_task_mst` WHERE `client_id` = emp.Emp_ID and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task,emp.Emp_ID as client_id,emp.Emp_Name as client_name, 
                (select count(*) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as total_pending_sub_task, 
                    (SELECT sum(efforts) FROM nexgen_task_sub_task_comments comment WHERE comment.status=1 and comment.approved=1 and comment.tstm_id in 
                    (select tst.tstm_id from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1)) as time_spent,
                    (select sum(tst.tstm_efforts) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as time_given 
                    FROM nexgen_task_mst tm left join nexgen_employee emp on (emp.Emp_ID=tm.client_id) WHERE  tm.progress_flag <> " . COMPLETED_APPROVAL . " and tm.status=1 order by emp.Emp_Name";
        } else {
            $sql = "SELECT 
                tm.tm_id, tm.progress_flag,(SELECT count(*) FROM `nexgen_task_mst` WHERE `client_id` = emp.Emp_ID and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task,emp.UTID,emp.Emp_ID as client_id,emp.Emp_Name as client_name, 
                (select count(*) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1 and (tst.assignedto = " . $this->util_model->get_uid() . " or tm.tm_id in (SELECT tuser.tm_id FROM nexgen_task_users tuser WHERE user_type=1 and status=1 and user_id = " . $this->util_model->get_uid() . "))) as total_pending_sub_task, 
                    (SELECT sum(efforts) FROM nexgen_task_sub_task_comments comment WHERE comment.status=1 and comment.approved=1 and comment.tstm_id in 
                    (select tst.tstm_id from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1)) as time_spent,
                    (select sum(tst.tstm_efforts) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as time_given 
                    FROM nexgen_task_mst tm left join nexgen_employee emp on (emp.Emp_ID=tm.client_id) WHERE  (tm.tm_id in (SELECT tst1.tm_id  FROM nexgen_task_sub_task tst1 WHERE tst1.progress_flag<>".COMPLETED_APPROVAL." and  tst1.assignedto = " . $this->util_model->get_uid() . " and tst1.status=1) or tm.tm_id in (SELECT tuser.tm_id FROM nexgen_task_users tuser WHERE user_type=1 and status=1 and user_id = " . $this->util_model->get_uid() . ")) and tm.progress_flag <> " . COMPLETED_APPROVAL . " order by emp.Emp_Name ";
        }
        //2450
        //echo $sql;die;
        $result = $this->db->query($sql)->result_array();
//        $this->util_model->printr($result);

        $allowed_utids = $this->util_model->get_lower_utids();


        $list = array();
        foreach ($result as $index => $eachValue) {
//            if($eachValue['client_id']==202){
//                $this->util_model->printr($list);
//            }else{
//                unset($result[$index]);
//                continue;
//            }

            if (!in_array($eachValue['UTID'], $allowed_utids)) {
                unset($result[$index]);
                continue;
            }

            if (!isset($list[$eachValue['client_id']])) {
                $list[$eachValue['client_id']] = $eachValue;
                continue;
            }
            $list[$eachValue['client_id']]['total_pending_sub_task'] += $eachValue['total_pending_sub_task'];
            $list[$eachValue['client_id']]['time_given'] += $eachValue['time_given'];
            $list[$eachValue['client_id']]['time_spent'] += $eachValue['time_spent'];
        }
        return $list;
    }

    public function getTaskCatSubTaskStatus() {
        $userType = $this->util_model->get_utype();
        if ($userType == PARTNER || $userType == DIRECTOR) {
            $sql = "SELECT tm.task_period_id,tm.tm_id,(SELECT count(*) FROM `nexgen_task_mst` WHERE `ttm_id` = tm.ttm_id and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task,tm.ttm_id,
                (SELECT ttm_name FROM nexgen_task_type_mst WHERE ttm_id = tm.ttm_id) as cat_name,
                tm.tm_name, tm.progress_flag
                ,emp.UTID,emp.Emp_ID as client_id,
                emp.Emp_Name as client_name, 
                (select count(*) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as total_pending_sub_task,
                    
                    (SELECT sum(efforts) FROM nexgen_task_sub_task_comments comment WHERE 
                    comment.approved=1 
                    and comment.status=1 
                    and comment.tstm_id in 
                    (select tst.tstm_id from nexgen_task_sub_task tst 
                    where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1)) as time_spent,
                    (select sum(tst.tstm_efforts) from nexgen_task_sub_task tst where 
                    tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as time_given 
                    FROM nexgen_task_mst tm left join nexgen_employee emp on (emp.Emp_ID=tm.client_id) WHERE  tm.progress_flag <> " . COMPLETED_APPROVAL . " order by cat_name";
        } else {
            $sql = "SELECT tm.task_period_id,tm.tm_id,(SELECT count(*) FROM `nexgen_task_mst` WHERE `ttm_id` = tm.ttm_id and `progress_flag` <>" . COMPLETED_APPROVAL . ") as pending_task,tm.ttm_id,
                (SELECT ttm_name FROM nexgen_task_type_mst WHERE ttm_id = tm.ttm_id) as cat_name,
                tm.tm_name, tm.progress_flag
                ,emp.UTID,emp.Emp_ID as client_id,
                emp.Emp_Name as client_name, 
                (select count(*) from nexgen_task_sub_task tst where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as total_pending_sub_task,
                    
                    (SELECT sum(efforts) FROM nexgen_task_sub_task_comments comment WHERE 
                    comment.approved=1 
                    and comment.status=1 
                    and comment.tstm_id in 
                    (select tst.tstm_id from nexgen_task_sub_task tst 
                    where tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1)) as time_spent,
                    (select sum(tst.tstm_efforts) from nexgen_task_sub_task tst where 
                    tst.tm_id = tm.tm_id and tst.progress_flag<>" . COMPLETED_APPROVAL . " and tst.status=1) as time_given 
                    FROM nexgen_task_mst tm left join nexgen_employee emp on 
                    (emp.Emp_ID=tm.client_id) WHERE  
                    (tm.tm_id in (SELECT tst1.tm_id  FROM nexgen_task_sub_task tst1 WHERE tst1.progress_flag<>".COMPLETED_APPROVAL." and tst1.assignedto = " . $this->util_model->get_uid() . " and status=1) or tm.tm_id in (SELECT tuser.tm_id FROM nexgen_task_users tuser WHERE user_type=1 and status=1 and user_id = " . $this->util_model->get_uid() . ")) and tm.progress_flag <> " . COMPLETED_APPROVAL . " and tm.status=1 order by cat_name ";
        }
        $result = $this->db->query($sql)->result_array();
        
        $allowed_utids = $this->util_model->get_lower_utids();
        $list = array();
        foreach ($result as $index => $eachValue) {
            if (!in_array($eachValue['UTID'], $allowed_utids)) {
                unset($result[$index]);
                continue;
            }
            if (!isset($list[$eachValue['ttm_id']])) {
                $list[$eachValue['ttm_id']] = $eachValue;
                continue;
            }
            $list[$eachValue['ttm_id']]['total_pending_sub_task'] += $eachValue['total_pending_sub_task'];
            $list[$eachValue['ttm_id']]['time_given'] += $eachValue['time_given'];
            $list[$eachValue['ttm_id']]['time_spent'] += $eachValue['time_spent'];
        }
        return $list;
    }
    
    public function count_pending_upload_data() {
        $res = $this->db->select('count(*) as total')->from(DB_PREFIX.'client_files')->where(array('status'=>CLIENT_FILE_PENDING_STATUS))->get()->row_array();
        return isset($res['total'])?$res['total']:0; 
    }
    
    public function gettasktypemst() { 
      $sql="select ttm.ttm_id,ttm.ttm_name ,

      (select count(*) from nexgen_task_mst tm where tm.progress_flag<>4 AND tm.ttm_id in (select sub_ttm.ttm_id from nexgen_task_type_mst sub_ttm where sub_ttm.parent_ttmid=ttm.ttm_id)) as pending_task, 

      (select count(*) from nexgen_task_sub_task tst where tst.tm_id in 
            (select tm.tm_id from nexgen_task_mst tm where tm.progress_flag<>4 AND tm.ttm_id in 

                (select sub_ttm.ttm_id from nexgen_task_type_mst sub_ttm where sub_ttm.parent_ttmid=ttm.ttm_id)
                )
            ) as pending_sub_task 

        from nexgen_task_type_mst ttm where ttm.parent_ttmid=0 and ttm.status=1 order by ttm_name"; 
     
     
       $result = $this->db->query($sql)->result_array();
       return $result;
    }

}
