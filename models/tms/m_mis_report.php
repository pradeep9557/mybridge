<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_mis_report
 *
 * @author NexGen
 */
class m_mis_report extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getOverDueTask($filter = array()) {
        $this->db->query("SET time_zone='+05:30'");
        $query = " (SELECT Emp_Name from  nexgen_employee where Emp_ID = inch.user_id  ) as Incharge";
        $this->db->select("t.tm_id, t.tm_name, t.tm_code, t.progress_flag, t.start_date, t.end_date, em.Emp_Name as client_name,$query ");
        $this->db->from("nexgen_task_mst t");
        $this->db->join("nexgen_task_users inch", "t.tm_id = inch.tm_id", "LEFT");
        $this->db->join("nexgen_employee em ", "em.Emp_ID=t.client_id  or em.Emp_ID=inch.user_id", "LEFT");
        if (isset($filter['endDate']) && $filter['endDate'] != '')
            $this->db->where("CAST('{$filter['endDate']}' AS DATE) > t.end_date", NULL, FALSE);
        $this->db->group_by("t.tm_id");
        $result = $this->db->get()->result_array();
        echo $this->db->last_query();
        return $result;
    }

    public function completedTask($filter = array()) {
        $this->db->query("SET time_zone='+05:30'");
        $query = " (SELECT Emp_Name from  nexgen_employee where Emp_ID = inch.user_id  ) as Incharge";

        $this->db->select("t.tm_id, t.tm_name, t.tm_code, t.progress_flag, t.start_date, t.end_date, em.Emp_Name as client_name ");
        $this->db->from("nexgen_task_mst t");
        $this->db->join("nexgen_task_users inch", "t.tm_id = inch.tm_id", "LEFT");
        $this->db->join("nexgen_employee em ", "em.Emp_ID=t.client_id  or em.Emp_ID=inch.user_id", "LEFT");
        if (isset($filter['endDate']) && $filter['endDate'] != '')
            $this->db->where("t.end_date <", $filter['endDate']);
        $this->db->where("t.progress_flag", COMPLETED_APPROVAL);
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        return $result;
    }

    public function DailyTaskEntryByTeam($filters = array()) {
        $this->db->query("SET time_zone='+05:30'");
        $query = " (SELECT Emp_Name from  nexgen_employee where Emp_ID = inch.user_id  ) as TaskIncharge";
        $query2 = "(SELECT Emp_Name from  nexgen_employee where Emp_ID = st.assignedto  ) as AssigntoUser ";
        $select = "t.tm_id, t.tm_name, t.tm_code, t.progress_flag, t.start_date, t.end_date, em.Emp_Name as client_name , st.tstm_name as subtaskname,";
        $select.="stc.work_datetime,add_user.Emp_Name as CommentBy,stc.comment,st.tstm_name,st.tstm_code, st.tstm_efforts,st.str_date_time,st.end_date_time,stc.progress_flag as stcprogressflag, stc.completed, stc.efforts,$query,$query2";
        $this->db->select($select);
        $this->db->from("(nexgen_task_mst t) ");
        $this->db->join("nexgen_task_users inch", "t.tm_id = inch.tm_id", "LEFT");
        $this->db->join("nexgen_task_sub_task  st", "st.tm_id = t.tm_id", "LEFT");
        $this->db->join("nexgen_task_sub_task_comments   stc", "stc.tstm_id = st.tstm_id", "LEFT");
        $this->db->join(DB_PREFIX . "employee as add_user", "add_user.Emp_Id = stc.Add_User  and add_user.status=1", 'left');
        $this->db->join("nexgen_employee em ", "em.Emp_ID=t.client_id", "LEFT");
        if (isset($filters['endDate']) && $filters['endDate'] != '')
            $this->db->where("t.end_date <=", $filters['endDate']);
        if (isset($filters['Add_DateTime']) && $filters['Add_DateTime'] != '')
            $this->db->where("'{$filters['Add_DateTime']}' = CAST(stc.work_datetime AS DATE)", NULL, FALSE);

        if (isset($filters['work_datetime']) && $filters['work_datetime'] != '')
            $this->db->where("'{$filters['work_datetime']}' = CAST(stc.work_datetime AS DATE)", NULL, FALSE);


//        $this->db->where("st.progress_flag <", COMPLETED_APPROVAL);
        $this->db->group_by("st.tstm_id");

        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();
        return $result;
    }

    public function getTaskLog($filters = array()) {
        $query = " (SELECT Emp_Name from  nexgen_employee where Emp_ID = inch.user_id  ) as TaskIncharge,";
        $query.= " (SELECT Emp_Name from  nexgen_employee where Emp_ID = tl.modifier_id  ) as loggedBy";
        $this->db->select("tl.*,tm.tm_id,tm.tm_name,$query")->from("nexgen_task_logs tl");
        $this->db->join("nexgen_task_mst tm", "tm.tm_id=tl.modified_id");
        $this->db->join("nexgen_task_users inch", "tm.tm_id = inch.tm_id", "LEFT");

        if (isset($filters['Add_DateTime']) && $filters['Add_DateTime'] != '') {
            $this->db->where("DATE(tl.modified_datetime) = '{$filters['Add_DateTime']}'", null, FALSE);
        }
        if (isset($filters['log_type']) && $filters['log_type'] != '') {
            $this->db->where("tl.log_type", $filters['log_type']);
        }
        $report = $this->db->get()->result_array();
//echo $this->db->last_query();
        return $report;
    }

}
