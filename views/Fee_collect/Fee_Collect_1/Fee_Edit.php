<style>
    .table > thead > tr > th, .table > tbody > tr > th, 
    .table > tfoot > tr > th, .table > thead > tr > td, 
    .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 2px;
        line-height: 1;
        vertical-align: top;
        border-top: none;
        font-size: 13px;
    }
    .fix_td_width{
        width: 36%;
    }
</style>
<div id="page-wrapper" style="min-height: 345px;">
<div class="row">
    <h4 class="page-header">
        <strong>Edit Fees</strong>
        <a href="<?php echo base_url(); ?>fees/Fee_Master_1/index/<?php echo $Stu_ID; ?>/<?php echo $FeeTypeID ?>" class="pull-right">
            <button type="button" name="link" value="Save" class="btn btn-primary btn-md margin_top-10px">
                <span class="glyphicon glyphicon-backward"></span> Back
            </button></a>
    </h4>
    <div class="row padding_left_0px">

        <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
      
    </div>
   
    <?php

    echo form_open_multipart(base_url() . 'fees/Fee_Master_1/fee_update', "id='fee_collect_form'");
              ?>
                  <div class="row bottom_gap">
                      <div class="col-lg-12"><h5 class="group_title">Personal Details</h5></div>
                  </div>
                  <div class="row bottom_gap">
                      <div class="col-lg-4">
                          <table class="table">
                              <tbody>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Branch Code</td>
                                      <td><?php echo form_input("BranchCode", $Form_Field_Value['BranchCode'], array("placeholder" => "'BranchCode'", "class" => "'form-control'", "readonly" => "")) ?></td>
                                  </tr>
                                  <tr> 
                                      <td  class="padding_top_label fix_td_width">EnrollNo</td>
                                      <td><?php echo form_input("EnrollNo", $Form_Field_Value['EnrollNo'], array("placeholder" => "'EnrollNo'", "class" => "'form-control'", "readonly" => "")) ?></td>
                                  </tr>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Course Code</td>
                                      <td><?php
                                          echo form_input("CourseCode", $Form_Field_Value['CourseCode'], array("placeholder" => "'CourseCode'", "class" => "'form-control'", "readonly" => ""));
                                          //echo form_hidden("CourseID", $CourseID);
                                          ?>
                                          <input type="hidden" name="CourseID" value="<?php echo $CourseID ?>" id="CourseID">
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="col-lg-4">
                          <table class="table">
                              <tbody>
                                  <tr>
                                      <td class="padding_top_label fix_td_width">Name</td>
                                      <td><?php echo form_input("StudentName", $Form_Field_Value['StudentName'], array("placeholder" => "'Name of Student'", "class" => "'form-control'", "readonly" => "")) ?></td>
                                  </tr>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Father</td>
                                      <td><?php echo form_input("FatherName", $Form_Field_Value['FatherName'], array("class" => "'form-control'", "placeholder" => "'Name of Father'", "readonly" => "True")) ?></td>
                                  </tr>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Gender</td>
                                      <td><?php echo form_input("Gender", $Form_Field_Value['Gender'], array("class" => "'form-control'", "placeholder" => "'Gender'", "readonly" => "True")) ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="col-lg-4">
                          <table class="table">
                              <tbody>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Date </td>
                                      <td><?php echo form_input("DOB", date(DF, strtotime($Form_Field_Value['DOB'])), array("placeholder" => "'Date of Birth'", "class" => "'form-control'", "readonly" => "")) ?></td>
                                  </tr>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">DOR</td>
                                      <td><?php echo form_input("DOR", date(DF, strtotime($Form_Field_Value['DOR'])), array("placeholder" => "'Date of Registration'", "class" => "'form-control'", "readonly" => "")) ?></td>
                                  </tr>
                                  <tr>
                                      <td  class="padding_top_label fix_td_width">Age</td>
                                      <td><?php
                                          echo form_input("age", $Form_Field_Value['age'], array("placeholder" => "'Age of Student'", "class" => "'form-control'", "readonly" => ""))
                                          ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="row bottom_gap">
                      <div class="col-lg-12"><h5 class="group_title">Receipt Details</h5></div>
                  </div>
                  <div class="row bottom_gap">
                      <div class="col-lg-8">
                          <div class="row bottom_gap">
                              <div class="col-lg-6">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td colspan="2"><h5 class="group_title">Payment Details</h5></td>
                                          </tr>

                                          <tr>
                                              <td class="padding_top_label fix_td_width">Month</td>
                                              <td><?php echo form_dropdown("Month", $Month_list, $c_month, "class='form-control chosen-select'"); ?></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Receipt No.<span class="Compulsory">*</span></span></td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php
                                                      echo form_hidden("ReceiptNo",$Form_Field_Value['ReceiptNo']);
                                                      echo form_input("OtherReceiptNo", $Form_Field_Value['ReceiptNo'], array("class" => "'form-control '", "placeholder" => "'Leave blank for auto generate'", "id" => "OtherReceiptNo"));
                                                      echo form_hidden("Individual_fee_plan_id", isset($Form_Field_Value['Individual_fee_plan_id']) ? $Form_Field_Value['Individual_fee_plan_id'] : 0);
                                                     // echo form_hidden("Stu_ID", $Stu_ID);
                                                      ?>
                                                      <input type="hidden" name="Stu_ID" value="<?php echo $Stu_ID ?>" id="Stu_ID">
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width fix_td_width">Receipt Date</td>
                                              <td> 
                                                  <div class="form-group">
                                                      <div class='input-group date bdatepicker' >
                                                          <input type='text' class="form-control" name="ReceiptDate" value="<?= date(DF,  strtotime($Form_Field_Value['ReceiptDate'])) ?>" id="ReceiptDate" onfocus="Get_Late_Payment()" onblur="Get_Late_Payment()" onchange="Get_Late_Payment()" />
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                      </div>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Fee Type</td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php
                                                      if ($FeeTypeID == "") {
                                                                    $FeeTypeID = key($FeeTypeID_list);
                                                      }
                                                      //$this->util_model->printr($FeeTypeID_list);

                                                      echo form_input("FeeTypeIDshow", $FeeTypeID_list[$FeeTypeID], "class='form-control' readonly");
                                                      //echo form_hidden("FeeTypeID", $FeeTypeID);
                                                      ?>
                                                      <input type="hidden" name="FeeTypeID" value="<?php echo $FeeTypeID ?>" id="FeeTypeID">
                                                  </div>
                                              </td>

                                          </tr>

                                          <tr>
                                              <td class="padding_top_label fix_td_width">Reg. Fees<span class="Compulsory">*</span></span></td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("RegFeeAmt", $Form_Field_Value['RegFeeAmt'], array("class" => "'form-control '", "id" => "reg_fee")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Monthly Charge<span class="Compulsory">*</span></span></td>
                                              <td><div class="form-group">
                                                      <?php echo form_input("MonthlyChargeAmt", $Form_Field_Value['MonthlyChargeAmt'], array("class" => "'form-control'", "id" => "maint_charge", "readonly" => "True")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Late Payment<span class="Compulsory">*</span></span></td>
                                              <td><div class="form-group">
                                                      <?php echo form_input("LatePaymentAmt", $Form_Field_Value['LatePaymentAmt'], array("class" => "'form-control'", "id" => "late_payment", "readonly" => "True")) ?> 
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Study Material Cost<span class="Compulsory">*</td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("StudyMaterialCostAmt", $Form_Field_Value['StudyMaterialCostAmt'], array("class" => "'form-control'", "id" => "std_charge")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Prospectus Cost<span class="Compulsory">*</td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("ProspectusCostAmt", $Form_Field_Value['ProspectusCostAmt'], array("class" => "'form-control'", "id" => "p_cost")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Others</td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("OtherAmt", $Form_Field_Value['OtherAmt'], array("class" => "'form-control'", "id" => "other")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Pre Bal<span class="Compulsory">*</td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("PreBalAmt", $Form_Field_Value['PreBalAmt'], array("class" => "'form-control'", "id" => "PreBalAmt", "readonly" => "true")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Total Amount<span class="Compulsory">*</td>
                                              <td> <div class="form-group">
                                                      <?php echo form_input("TotalAmt", $Form_Field_Value['TotalAmt'], array("class" => "'form-control'", "placeholder" => "'Total Amount'", "readonly" => "True", "id" => "total_amount")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Discount<span class="Compulsory">*</td>
                                              <td> <div class="form-group">
                                                      <?php echo form_input("DisAmt", $Form_Field_Value['DisAmt'], array("class" => "'form-control'", "id" => "discount")) ?> 
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Net Payable<span class="Compulsory">*</td>
                                              <td> <div class="form-group">
                                                      <?php echo form_input("NetPayableAmt", $Form_Field_Value['NetPayableAmt'], array("class" => "'form-control'", "id" => "net_payable", "readonly" => "TRUE")) ?> 
                                                  </div>
                                                  <input type="hidden" name="service_tax" value="<?= $Form_Field_Value['service_tax'] ?>" id="service_tax"> 
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Paid<span class="Compulsory">*</span></td>
                                              <td>
                                                  <div class="form-group">
                                                      <?php echo form_input("PaidAmt", $Form_Field_Value['PaidAmt'], array("class" => "'form-control'", "placeholder" => "'Paid Amount'", "id" => "'paid'")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Balance<span class="Compulsory">*</span></td>
                                              <td>  <div class="form-group">
                                                            <?php echo form_input("BalanceAmt", 0, array("class" => "'form-control'", "placeholder" => "Balance Amount", "Readonly" => "True", "id" => "fee_type18")); ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Balance Details<span class="Compulsory">*</span></td>
                                              <td>
                                                   <div class="form-group">
                                                            <?php echo form_input("BalanceDetails", $Form_Field_Value['BalanceDetails'], array("class" => "'form-control'", "placeholder" => "'Reason of Balance'")) ?>
                                                   </div>
                                                   </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Balance Due Date<span class="Compulsory">*</span></td>
                                              <td> <div class="form-group">
                                                      <div class='input-group date bdatepicker' >
                                                          <input type='text' class="form-control" name="BalDueDate" value="<?= date(DF) ?>"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                      </div>
                                                  </div></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                              <div class="col-lg-6">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td colspan="2"><h5 class="group_title">&nbsp;</h5></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Fee Mode</td>
                                              <td><?php echo form_dropdown("Paid_ModeID", $paid_mode, $Form_Field_Value['Paid_ModeID'], "class='form-control chosen-select' onchange='on_change_fee_mode(this)' show_form_id='cheque_form'"); ?></td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <table class="table" id="cheque_form" <?php
                                     if($Form_Field_Value['Paid_ModeID']==1){
                                        echo "style='display: none'";               
                                     }
                                  ?>>
                                      <tbody>
                                          <tr>
                                              <td colspan="2"><h5 class="group_title">Cheque/Draft Details</h5></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Bank Name</td>
                                              <td>
                                                             <div class="form-group">
                                                            <?php echo form_input("BankName", $Form_Field_Value['BankName'], array("class" => "'form-control'", "placeholder" => "'Bank Name'")); ?>
                                                             </div>
                                                             </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Branch Name</td>
                                              <td>
                                                             <div class="form-group">
                                                            <?php echo form_input("BranchName", $Form_Field_Value['BranchName'], array("class" => "'form-control'", "placeholder" => "'Branch Name'")); ?>
                                                             </div>
                                                             </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width" id="cheque_draft">Check/Draft No.</td>
                                              <td>
                                                             <div class="form-group">
                                                            <?php echo form_input("ChNumber", $Form_Field_Value['ChNumber'], array("class" => "'form-control'", "placeholder" => "'Check or Draft Name'")); ?>
                                                             </div>
                                                             </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Date</td>
                                              <td>
                                                  <div class="form-group">
                                                      <div class='input-group date bdatepicker' >
                                                          <input type='text' class="form-control" name="ChDate" value="<?= date(DF,  strtotime($Form_Field_Value['ChDate'])) ?>"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                      </div>
                                                  </div>

                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Amount</td>
                                              <td>
                                                             <div class="form-group">
                                                            <?php echo form_input("ChAmount", $Form_Field_Value['ChAmount'], array("class" => "'form-control'", "placeholder" => "'Check or Draft Amount' id='ChAmount' onkeyup='change_check_amount()'")); ?>
                                                             </div>
                                                             </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Remarks</td>
                                              <td> <div class="form-group">
                                                            <?php echo form_textarea("ChequeRemarks", $Form_Field_Value['ChequeRemarks'], array("class" => "'form-control'", "placeholder" => "'Check or Draft Remarks'")); ?>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td colspan="2"><h5 class="group_title">Subject & topic details</h5></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Subject</td>
                                              <td><?php echo form_dropdown("SubjectID", array("0" => "Default"), 0, "class='form-control chosen-select' onclick='get_faculty(this)' result_id='faculty_batches' bname='BatchID'"); ?></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Topic</td>
                                              <td><?php echo form_dropdown("CurrTopicID", array("0" => "Default"), 0, "class='form-control chosen-select' onclick='get_faculty(this)' result_id='faculty_batches' bname='BatchID'"); ?></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Curr Faculty</td>
                                              <td><?php echo form_dropdown("FacultyID", $fac_list, $Form_Field_Value['FacultyID'], "class='form-control chosen-select' onclick='get_faculty(this)' result_id='faculty_batches' bname='BatchID'"); ?></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Curr Batch</td>
                                              <td id="faculty_batches"><?php echo form_dropdown("BatchID", $fac_batch_list, $Form_Field_Value['BatchID'], "class='form-control chosen-select'"); ?></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                          <div class="col-lg-12"><h5 class="group_title">Next Inst Amt and Due Dates</h5></div>
                          <div class="row bottom_gap">
                              <div class="col-lg-6">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Next Inst Fee<span class="Compulsory">*</span></td>
                                              <td> <div class="form-group">
                                                            <?php echo form_input("NextInstAmt", $Form_Field_Value['NextInstAmt'], array("class" => "'form-control'")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Next Due Date<span class="Compulsory">*</span></td>
                                              <td>
                                                  <div class="form-group">
                                                      <div class='input-group date bdatepicker' >
                                                          <input type='text' class="form-control" name="NextDueDate" value="<?= date(DF, strtotime($Form_Field_Value['NextDueDate'])) ?>"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                      </div>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Installment No</td>
                                              <td><span class="form-group"><?php echo form_input("NoOfInstallment", $Form_Field_Value['NoOfInstallment'], array("class" => "'form-control'", "readonly" => "True")) ?></span></td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Remarks</td>
                                              <td> <div class="form-group">
                                                            <?php echo form_textarea("Remarks", $Form_Field_Value['Remarks'], array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                  
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>             
                                  </table>
                              </div>
                              <div class="col-lg-6">
                                  <table class="table">
                                      <tbody>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">After Next Amount Fee<span class="Compulsory">*</span></td>
                                              <td> <div class="form-group">
                                                            <?php echo form_input("AfterNextInstAmt", $Form_Field_Value['AfterNextInstAmt'], array("class" => "'form-control'")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">After Next Due Date<span class="Compulsory">*</span></td>
                                              <td>
                                                  <div class="form-group">
                                                      <div class='input-group date bdatepicker' >
                                                          <input type='text' class="form-control" name="AfterNextDueDate" value="<?= date(DF, strtotime($Form_Field_Value['AfterNextDueDate'])) ?>"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar"></span>
                                                          </span>
                                                      </div>
                                                  </div>

                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="padding_top_label fix_td_width">Total Installment Amount<span class="Compulsory">*</span></td>
                                              <td> <div class="form-group">
                                                        <?php echo form_input("Total_Paid_Amt", $Form_Field_Value['Total_Paid_Amt'], array("class" => "'form-control'", "readonly" => "True")) ?>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>             
                                  </table>
                              </div>


                          </div>
                          <div class="col-lg-12 bottom_gap">
                              <button type="submit" name="Fee_Collect" value="Update" class="btn btn-success btn-md">
                                  <span class="glyphicon glyphicon-floppy-disk"></span> Update Fees Details
                              </button> 
                          </div>
                      </div>
                      <div class="col-lg-4"></div>
                  </div>
    <?php

    echo form_close();
    ?>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>




              $(document).ready(function () {
                  $('#dataTables-example').dataTable();
              });
              $(document).ready(function () {
                //  Get_Late_Payment();
                  total_amount();
              });
              function total_amount() {
                  check_blank_field();
                  $("#total_amount").val(parseFloat($("#reg_fee").val()) + parseFloat($("#maint_charge").val()) + parseFloat($("#late_payment").val()) + parseFloat($("#std_charge").val()) + parseFloat($("#p_cost").val()) + parseFloat($("#other").val()) + parseFloat($("#PreBalAmt").val()));
                  calculate_tax();
                  discount();
                  //$("#paid").val($("#total_amount").val());
              }
              function discount() {
                  check_blank_field();
                  var tot = parseFloat($("#total_amount").val());
                  var dis = parseFloat($("#discount").val());
                  //var payable = tot - (tot * dis) / 100;
                  var payable = tot - dis;
                  $("#net_payable").val(payable.toString());
                 // $("#paid").val($("#net_payable").val());
                  if ($("#paid").val() !== 0)
                      net_payable_fee();

              }

              /*
               * 
               * @returns return tax
               * 
               */
              function calculate_tax() {
                  var tax_per = parseFloat($("#service_tax").val());
                  var tax = (parseFloat($("#total_amount").val()) * tax_per) / 100;
                  var total_amount = parseFloat($("#total_amount").val()) + tax;
                  $("#total_amount").val(total_amount);
              }


              function net_payable_fee() {
                  check_blank_field();
                  $("#fee_type18").val(parseFloat($("#net_payable").val()) - parseFloat($("#paid").val()));
              }
              // late payment triggers
//              $("#ReceiptDate").change(function () {
//                  Get_Late_Payment();
//              });
//    $("#FeeType_Code").change(function() {
//        Get_Late_Payment();
//    });
              function Get_Late_Payment()
              {
                  $("#late_payment").val(0);
                  var FeeTypeID = $("#FeeTypeID").val();
                  //var ReceiptDate_arr = $("#ReceiptDate").val().split('-');
                  var ReceiptDate_arr = $("#ReceiptDate").val();
                  //alert(ReceiptDate_arr[0]);
                  var Stu_ID = $("#Stu_ID").val();
                  var CourseID = $("#CourseID").val();
                  var page = "<?= base_url() ?>Ajax/late_payment/" + Stu_ID + "/" + CourseID + "/" + FeeTypeID + "/" + ReceiptDate_arr;
                  $.ajax({
                      type: "POST",
                      url: page,
                      dataType: 'json',
                      success: function (result) {
                          $("#late_payment").val(result['fine']);
                          total_amount();
                      }});
              }

</script>




<script src="<?php echo base_url() ?>js/custom_js/ajax/common_ajax.js" type="text/javascript"></script>


</div>
</div>


