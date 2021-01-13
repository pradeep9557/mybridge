<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->model('ajax/ajax_model');
    }
    function get_duplicate_time_rand_picker($index){
                  $data['index_no'] = $index+1;
                  $this->load->view('Ajax/time_rand_picker',$data);
    }
    function get_states($country_id,$field_name){
         $data['field_name'] = $field_name;
         $this->load->model('enquiry/locality');
         $data['Parent'] = $this->locality->all_states($country_id);
         $this->load->view('Enquiry/source/parent_select',$data);
    }
     function get_cities($state_id,$field_name){
         $data['field_name'] = $field_name;
         $this->load->model('enquiry/locality');
         $data['Parent'] = $this->locality->all_cities($state_id);
         $this->load->view('Enquiry/source/parent_select',$data);
    }
    function get_locality($city_id,$field_name){
         $data['field_name'] = $field_name;
         $this->load->model('enquiry/locality');
         $data['Parent'] = $this->locality-> AllLocality(0,$city_id);
         $this->load->view('Enquiry/source/parent_select',$data);
    }
    function get_sub_locality($city_id,$field_name){
         $data['field_name'] = $field_name;
         $this->load->model('enquiry/locality');
         $data['Parent'] = $this->locality-> AllLocality($city_id,'');
         $this->load->view('Enquiry/source/parent_select',$data);
    }
    
    function Get_Balance_Report() {
        $this->load->model('reports/report_model');
        $data['All_Fee_report'] = $this->report_model->bal_report();
        $this->load->view('reports/Balance_table_for_bal_report.php', $data);
    }

    public function check_aready_exits($json = TRUE) {
        $checking_id = $this->input->post('checkingid');
        $val = $this->input->post('val');
        $return_data = $this->ajax_model->check_aready_exits(array($checking_id, $val));
        if($json){
            echo json_encode(array("succ"=>$return_data->num_rows));
        }else{
            return $return_data;
        }
    }

    public function upload_ajax_pics() {
        $path = $_REQUEST['Uploading_path'];
        $File_Name = $_REQUEST['FileName'];
        $FILE = $_FILES['Ajax_upload_pic'];
        $rs = $this->ajax_model->upload_pic($path, $File_Name, $FILE);
        if ($rs[0]) {
            echo json_encode(array('succ' => TRUE, "New_Path" => $rs[1]));
        } else {
            echo json_encode(array('succ' => FALSE, "New_Path" => $rs[1]));
        }
    }

    public function Get_Batches_of_Faculty() {
        $FacultyID = $this->input->get('FacultyID', TRUE);
        $field_name = $this->input->get('name', TRUE);
            echo "<select name='$field_name' class='form-control chosen-select'>"; 
            echo "<option value=''>Select Batch</option>";
        
            $this->load->model('batch/batch_model');
            $all_Batches = $this->batch_model->Get_Batches_of_Faculty($FacultyID);
           // print_r($all_Batches);
            if (!empty($all_Batches)) {
                foreach ($all_Batches as $batches) {
                    echo "<option value='{$batches->BatchID}'>{$batches->BatchCode}</option>";
                }
             echo "</select>";
            
        }
    }
    
    //notification donut
    public function get_notification($BranchID,$EMpcode)
    {
        $this->load->model('enquiry/m_enquiry');
        $List=$this->m_enquiry->get_notification($BranchID,$EmpCode);
        echo json_encode($List);
    }

    public function Search_Student() {
       global $data;
        $all_form_data = array();
        foreach ($_POST as $key => $value) {
            $all_form_data[$key] = $value;
        }

        $path = "";

        $result = $this->ajax_model->Search_Student($all_form_data);
        if (!empty($result))
            $data['Query_Result'] = $result;
        if (!file_exists(APPPATH . '/views/Ajax/Record_Search.php')) {
            show_404();
        }
//               $this->load->view('templates/Common_Css_Js_Others_files.php');
        $this->load->view('Ajax/Record_Search.php', $data);
    }

  

    // will be use to dp all delete operations
    Public function delete() {
//       echo $_POST['_action'];
       // die($this->util_model->printr($_POST));
        $result = $this->ajax_model->delete($_POST);
     //   $this->util_model->printr($result);
        echo json_encode(array('success' => $result[0], '_err_msg' => mysql_real_escape_string(isset($result[1])) ? $result[1] : ''));
    }

    public function late_payment($Stu_ID,$CourseID,$FeeTypeID, $ReceiptDate) {
       $filter_data = array("Stu_ID"=>$Stu_ID,"CourseID"=>$CourseID,"FeeTypeID"=>$FeeTypeID,"ReceiptDate"=>$ReceiptDate);           
        $fine = $this->ajax_model->late_payment($filter_data);
        echo json_encode(array('success' => TRUE, 'fine' => $fine));
    }
    
    //function for enquiry searching
    public function searchEnquiry($SearchFor,$Searchby)
    {   
       global  $data;
       $like=array('enq.'.$Searchby=>$SearchFor);
       $this->load->model('enquiry/m_enquiry');
       $data['all_enq_list'] = $this->m_enquiry->all_enq_list($data['Session_Data']['IBMS_BRANCHID'],0,'enq.Add_DateTime','DESC',$like);
       $this->load->view('Ajax/v-enquiry-search',$data);
       
    }
    public function get_stu_course_list(){
            global $data;
            $enrollno  = $this->input->get('enrollno');
            $data['field_name'] = $this->input->get('fname');
            $Stu_ID =  $this->util_model->get_a_column_value("Stu_ID",DB_PREFIX."stu_mst",array("EnrollNo"=>$enrollno));
            $this->load->model('adm/admission_model');
            $courses_result = $this->admission_model->get_student_courses($Stu_ID,1);
            $final_course_list = array();
            if(!empty($courses_result)){
                          foreach ($courses_result as $c_row) {
                                   $final_course_list[$c_row->CourseID] = $c_row->CourseCode;     
                          }       
            }
            $data['list'] = $final_course_list;
            $data['selected'] = "";
            $this->load->view("Ajax/drop_down_view",$data);
            echo " <input type='hidden' name='Stu_ID' value='$Stu_ID'/>";
            //$this->util_model->printr($final_course_list);\
            
    }

}

?>