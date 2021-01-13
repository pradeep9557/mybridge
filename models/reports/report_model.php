<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report_model
 *
 * @author Anup kumar

  select t1.ID,t1.`EnrollNo`,t1.`BalanceAmt` from nexgen_fee_trn t1 INNER JOIN (select ti.EnrollNo, ti.CourseCode, MAX(`ID`) as ID from  nexgen_fee_trn ti Group by ti.EnrollNo) t2 ON (t1.ID=t2.ID and t1.EnrollNo=t2.EnrollNo and t1.CourseCode=t2.CourseCode) and t1.`BalanceAmt`<>0
  select t1.ID,t1.`EnrollNo`,t1.`BalanceAmt`, t1.`ReceiptDate` from nexgen_fee_trn t1 INNER JOIN (select ti.EnrollNo, ti.CourseCode, MAX(`ID`) as ID from  nexgen_fee_trn ti Group by ti.EnrollNo) t2 ON (t1.ID=t2.ID and t1.EnrollNo=t2.EnrollNo and t1.CourseCode=t2.CourseCode) and t1.`BalanceAmt`<>0 and t1.`ReceiptDate`>'2014-12-24'

  join in four tables
  select t1.ID,t1.`EnrollNo`,t1.`BalanceAmt`, t1.`ReceiptDate`,t1.CourseCode,t4.Mobile1 from nexgen_fee_trn t1 INNER JOIN (select ti.EnrollNo, ti.CourseCode, MAX(`ID`) as ID from  nexgen_fee_trn ti Group by ti.EnrollNo) t2 ON (t1.ID=t2.ID and t1.EnrollNo=t2.EnrollNo and t1.CourseCode=t2.CourseCode) INNER JOIN  nexgen_scnb t3 ON (t1.EnrollNo=t3.EnrollNo  and t1.CourseCode=t3.CourseCode ) INNER JOIN nexgen_student_mst t4 ON (t1.EnrollNo=t4.EnrollNo   ) and t1.`BalanceAmt`<>0
 * 
 * SELECT t1.`ID`,t1.`FeeType_Code`,t1.`EnrollNo`,t1.`CourseCode`,t1.`BatchCode`,t1.Month,
  t1.`FacultyCode`, t1.`RegFeeAmt`,t1.`RegFeeAmt`, t1.`MonthlyChargeAmt`, t1.`LatePaymentAmt`, t1.`StudyMaterialCostAmt`, t1.`ExamFeeAmt`, t1.`ProspectusCostAmt`, t1.`OtherAmt`, t1.`TotalAmt`, t1.`DisAmt`, t1.`NetPayableAmt`, t1.`PaidAmt`, t1.`BalanceAmt`, t1.`BalDueDate`, t1.`BalanceDetail`, t1.`NextInstAmt`, t1.`AfterNextInstAmt`, t1.`NoOfInstallment`, t1.`NextDueDate`, t1.`AfterNextDueDate`, t1.`Remarks`, t1.`Add_User`, t1.`Mode_User`,t2.`Due_Date`,t3.Start_Time,t3.End_Time,t4.Duration,t4.MonthDay  FROM `nexgen_fee_trn` t1 INNER JOIN nexgen_scnb t2 ON(t1.`CourseCode`=t2.`CourseCode` and t1.`EnrollNo`=t2.`EnrollNo`) INNER JOIN  nexgen_batch_master t3 ON(t1.BatchCode=t3.BatchCode and t1.FacultyCode=t3.FacultyCode) INNER JOIN nexgen_course_mst t4 ON (t1.`CourseCode`=t4.`CourseCode`) WHERE t1.`ID`=206
 * 
 */
class report_model extends CI_Model {

              function __construct() {
                            parent::__construct();
              }
              private $_col_not_allowed = array("FeeTypeID","Stu_ID");
              public function get_col_names($data) {
                            $col_row = array();
                            foreach ($data[0] as $key => $val) {
                                          if(!array_search($key,$this->_col_not_allowed)){
                                              $col_row[] = $key;              
                                          }
                                          
                            }
                            return $col_row;
              }

}
