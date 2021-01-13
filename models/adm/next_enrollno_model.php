<?php 
 class next_enrollno_model extends CI_Model{
         function __construct() {
         parent::__construct();
     }
    public function Next_EnrollNo ($Branch_Code){
         $like = $Branch_Code.date("y",  strtotime("+5 hours"));
         $query = $this->db->select('EnrollNo')->from("nexgen_student_mst")->where("EnrollNo like '%$like%'")->order_by('Stu_ID','DESC')->limit(1);
         $result = $query->get()->result();
         if(!empty($result))
         {return substr($result[0]->EnrollNo,5)+1;
         
         }
         else
             return date('y',  time ())."0001";
    } 
 }
?>