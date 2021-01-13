<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-4">
            <h4 class="page-header ">Your Admission Details</h4>
       </div>
                <!-- /.col-lg-12 -->
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">
            <a href="#last_fee_record" class="page-scroll"><button type="button" class="btn btn-primary btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-arrow-down">  Fee Records</span>
                </button></a>
            
        </div>
        <div class="col-lg-2">
            <a href="#Pre_Fee_Plans" class="page-scroll"><button type="button" class="btn btn-primary btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-arrow-down">  Fee Plans</span>
                </button></a>
            
        </div>
        <div class="col-lg-2">
            <a href="#Pre_Fee_Plans" class="page-scroll"><button type="button" class="btn btn-primary btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-arrow-down">  Batch Details</span>
                </button></a>
            
        </div>
 
    </div> 
    
    <?php
    //for normal form

    echo form_open(base_url() . 'admission/all_admission_form/0/1', $attributes);

    //echo form_open_multipart('/dashboard/admission_save_update',$attributes);
    ?>

    <!--String of Row-->

    <div class="row bottom_gap">

        <div class="col-lg-2">Enrollment Number</div>

        <div class="col-lg-4">
            <?php echo $admission_data->EnrollNo; ?>
            <?php echo form_hidden("Stu_ID", "$admission_data->Stu_ID"); ?>
        </div> <!-- end of col-lg-4 -->

        <div class="col-lg-2">Student Name</div>

        <div class="col-lg-4">

            <?php echo $admission_data->StudentName; ?>

        </div>

    </div> <!--End of row-->

    <!--String of Row-->

    <div class="row bottom_gap">
        <div class="col-lg-2">Date of Reg.(DOR)</div>
        <div class="col-lg-4">
            <?php
            if ($admission_data->DOR == "") {
                echo "Not Mentioned";
            } else {
                echo date(DF, strtotime($admission_data->DOR));
            }
            ?>    
        </div>
        <div class="col-lg-2">Courses</div>
        <div class="col-lg-4"><?php
            foreach ($all_stu_scnb_details as $scnb) {
                echo $scnb->CourseCode;
            }
            ?></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"><h5 class="group_title">Personal Details</h5></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Father's Name</div>
        <div class="col-lg-4">
            <?php echo $admission_data->FatherName; ?>          
        </div>
        <div class="col-lg-2">Mother's Name</div>
        <div class="col-lg-4">
            <?php echo $admission_data->MotherName; ?>                         
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Date of Birth</div>
        <div class="col-lg-4">
            <div class="input-group">

                <?php
                if ($admission_data->DOB == "") {
                    echo "Not Mentioned";
                } else {
                    echo date(DF, strtotime($admission_data->DOB));
                }
                ?>         
            </div>

        </div>

        <div class="col-lg-2">Gender</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Gender; ?>       

        </div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">qualification</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Quali; ?>       



        </div>

        <div class="col-lg-2">Nationality</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Nationality; ?>       

        </div>



    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Image</div>

        <div class="col-lg-4">



            <?php
            if (file_exists(STU_UPLOAD_PATH . $admission_data->Pro_pic)) {
                echo "<img src='" . base_url() . STU_UPLOAD_PATH . $admission_data->Pro_pic . "' width='75px'/>";
            } else {
                echo "<img src='" . base_url() . DEFAULT_STU_PIC . "' width='75px'/>";
            }
            ?>
        </div>
        <div class="col-lg-2">Signature</div>
        <div class="col-lg-4">
            <?php
            if (file_exists(STU_UPLOAD_PATH . $admission_data->Sign)) {
                echo "<img src='" . base_url() . STU_UPLOAD_PATH . $admission_data->Sign . "' width='75px'/>";
            } else {
                echo "<img src='" . base_url() . DEFAULT_STU_SIGN . "' width='75px'/>";
            }
            ?>          
        </div>                
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"><h5 class="group_title">Contact Details</h5></div>
    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Primary Mobile No</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Mobile1; ?>       

        </div>
        <div class="col-lg-2">Primary Phone No</div>
        <div class="col-lg-4">

            <?php echo $admission_data->Phone1; ?>          
        </div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Primary Email ID</div>

        <div class="col-lg-4">
            <?php echo $admission_data->Email1; ?>     
        </div>



    </div>

    <div class="row bottom_gap">

        <div class="col-lg-12"><h5 class="group_title">Address Details</h5></div>

    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2">House No.</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_houseno; ?>    
        </div>

        <div class="col-lg-2">Street</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_street; ?>    
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">City</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_city; ?>    
        </div>
        <div class="col-lg-2">State</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_state; ?>    
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">village and post</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_village_and_post; ?>    
        </div>
        <div class="col-lg-2">Pin</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_pincode; ?>    
        </div>
    </div>
    <div class="row bottom_gap">

        <div class="col-lg-12"><h5 class="group_title">Office Work</h5></div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">PRO</div>

        <div class="col-lg-4"><?php echo $admission_data->Add_User; ?></div>
        <div class="col-lg-2">Remarks</div>
        <div class="col-lg-4"><?php echo $admission_data->Remarks; ?></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Password</div>
        <div class="col-lg-4"><?php echo $pass; ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="<?= base_url() . "admission/print_admission/" . $admission_data->EnrollNo ?>" target="_blank"><button type="Button" name="Print" value="Print" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-print"></span> Print
                </button>
            </a>
        </div>
    </div>
    <?php echo form_close(); ?>       
<div class="row">
    
        <h4 class="page-header"> 
            
            <button type="button" class="btn btn-primary btn-md" id="last_fee_record">
                <span class="glyphicon glyphicon-hand-right">  Last Fee Records</span>
            </button>
            <a class="page-scroll" href="#wrapper"><button type="button" class="btn btn-success btn-md" id="Go_to_top">
                <span class="glyphicon glyphicon-arrow-up">  Go To Top</span>
                </button></a>
            <a href="#Pre_Fee_Plans" class="page-scroll">
                <button type="button" class="btn btn-primary btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-arrow-down">  Fee Plans</span>
                </button></a>
            <?php 
              if($all_stu_scnb_details[0]->Total_Paid_Amt==$all_stu_scnb_details[0]->Minimum_Total){
                  ?>
            <button type="button" class="btn btn-success btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-thumbs-up"> You are Fully Paid</span>
                </button>
            <?php } ?>
            </h4>
            <?php
             if(isset($error_del)){
                 $this->util_model->show_result_error($error,DEL_SUCCESS_MSG, DEL_ERROR_MSG);
             }
            ?>
        
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Students List With Advance Filter
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Fee Type</th>
                                    <th>EnrollNo</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Fee Details</th>
                                    <th>Bal</th>
                                    <th>Due Date</th>
                                    <th>Add/Mode User</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if(isset($fee_record)){
                                foreach ($fee_record as $stu) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= ++$i ?></td>
                                        <td><?= $stu->FeeType_Code?></td>
                                        <td><?= $stu->EnrollNo?></td>
                                        <td><?= $stu->CourseCode?></td>
                                        <td><?php echo date(DF, strtotime($stu->ReceiptDate)); ?></td>
                                        <td><?= $stu->ID."/".$stu->PaidAmt?></td>
                                        <td><?= $stu->BalanceAmt ?></td>
                                        <td><?php echo date(DF, strtotime($stu->BalDueDate)); ?></td>
                                        <td><?php echo $stu->Add_User."/".$stu->Mode_User; ?></td>
                                        <td>
                                            <a href="<?=base_url()?>Fee_Master/Print_Fee/<?=$stu->ID?>" target="_blank">Print</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
   <div class="row bottom_gap">
        <h4 class="page-header"> 
            
            <button type="button" class="btn btn-primary btn-md" id="Pre_Fee_Plans">
                <span class="glyphicon glyphicon-hand-right">  Previous Fee Plans</span>
            </button>
            <a href="#last_fee_record" class="page-scroll"><button type="button" class="btn btn-primary btn-md" id="all_fee_record">
                <span class="glyphicon glyphicon-arrow-up">  Fee Records</span>
                </button></a>
            <a class="page-scroll" href="#wrapper"><button type="button" class="btn btn-success btn-md" id="Go_to_top">
                <span class="glyphicon glyphicon-arrow-up">  Go To Top</span>
            </button></a>
            
            
            
        </h4>
        
    </div>
     <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Students List With Advance Filter
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="fee_plan">
            <thead>
            <tr>
               <td>S.No.</td>
               <td>EnrollNo</td>
               <td>CourseCode</td>
                <td>Inst Amt.</td>
                <td>Total Inst.</td>
                <td>Remarks</td>
                </tr>
    </thead>
   <?php   
   $i=1;
     foreach ($Fee_Plan as $fee_plan_data) {
         ?><tr>
             <td><?=$i++?></td>
               <td><?=$fee_plan_data->EnrollNo?></td>
               <td><?=$fee_plan_data->CourseCode?></td>
                <td><?=$fee_plan_data->Inst_amt?></td>
                <td><?=$fee_plan_data->Total_Inst?></td>
                <td><?=$fee_plan_data->Remarks?></td>
            </tr>
     <?php } ?>
        </table>
                        </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
     </div>
<script>
 $(document).ready(function() {
     $('#fee_plan').dataTable();
 });
 
</script>
</div>
