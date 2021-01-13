<style>
    .nav-tabs > li > a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        padding: 10px;
        margin-top: 12px;
    }
    .profile_img{

        max-width:50px;
        max-height:50px;
        width: auto;
        height: auto;
    }
    .pic_frame{
        width:60px;
        height:60px;
        border: 2px solid #999999;
        text-align: center;
        line-height: 53px;
    }
</style>
<div id="page-wrapper" style="min-height: 345px;">
    <?php
    if (isset($error)) {
        $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
    }

    if (isset($basic_details->Status)) {
        if (!$basic_details->Status) {
            echo "Registration Cancelled !!";
        } else {
            ?>
            <div class="row" style="  padding: 8px;  background: rgb(244, 244, 244);  margin-top: 4px;  color: black;  box-shadow: 0 0 1px;">
                <div class="col-lg-2">EnrollNo</div>
                <div class="col-lg-2"><?php echo $basic_details->EnrollNo; ?></div>
                <div class="col-lg-2">Student Name</div>
                <div class="col-lg-4"><?php echo $basic_details->StudentName ?></div>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#sectionA">Basic Details</a></li>
                <li><a data-toggle="tab" href="#sectionB">Course Details</a></li>
                <li><a data-toggle="tab" href="#sectionC">Batch Details</a></li>
                <li><a data-toggle="tab" href="#sectionD">Course & Faculty Share</a></li>
                <!--                                    <li class="dropdown">
                                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Other Settings <b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-toggle="tab" href="#dropdown1">Change Password</a></li>
                                                            <li><a data-toggle="tab" href="#dropdown2">Change Photo & Sign</a></li>
                                                        </ul>
                                                    </li>-->
            </ul>
            <div class="tab-content">
                <div id="sectionA" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="page-header">Edit Admission Form</h4>

                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!--String of Row-->
                    <?php
                    echo form_open_multipart(base_url() . "adm/cadm/update_basic_details", " id ='adm_form'");
                    ?>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Branch</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">Enrollment No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" id="Enroll_Code" value="<?= $Branch_obj->BranchCode ?>"/>
                                <?php
                                echo form_hidden("Stu_ID", $basic_details->Stu_ID);
                                echo form_input("EnrollNo", $basic_details->EnrollNo, array("id" => "Enrollno", "class" => "'form-control'", "placeholder" => "'Enroll No'", "maxlength" => "15", "Readonly" => "true"))
                                ?>
                            </div>
                        </div>
                    </div> <!--End of row-->

                    <!--String of Row-->
                    <div class="row bottom_gap">

                        <div class="col-lg-2 padding_top_label">Other Branch Enroll No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("OtherBranchEnroll", $basic_details->OtherBranchEnroll, array("class" => "'form-control'", "placeholder" => "'Other Branch EnrollNo'", "maxlength" => "20")) ?>
                            </div>
                        </div>

                        <div class="col-lg-2 padding_top_label">Student Name</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("StudentName", $basic_details->StudentName, array("class" => "'form-control'", "placeholder" => "Student Name", "maxlength" => "50")) ?>
                                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                                ?></div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Father's Name</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("FatherName", $basic_details->FatherName, array("class" => "'form-control'", "placeholder" => "'Father's Name'", "maxlength" => "50")) ?>
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Mother's Name</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("MotherName", $basic_details->MotherName, array("class" => "'form-control'", "placeholder" => "'Mother's Name'", "maxlength" => "50")) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Date of Birth</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class='input-group date bdatepicker' >
                                    <input type='text' class="form-control" name="DOB" value="<?= date(DTF, strtotime($basic_details->DOB)) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Nationality</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("NID", $n_list, $basic_details->NID, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <!--        <div class="col-lg-2 padding_top_label">Date of Registration</div>
                                <div class="col-lg-4">
                                   <div class="form-group">
                                        <div class='input-group date bdatepicker' >
                                            <input type='text' class="form-control" name="DOR" value="<?= date(DTF) ?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>-->
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Gender</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("Gender", array("Male" => "Male", "Female" => "Female", "Other" => "Other"), $basic_details->Gender, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">Qualification</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("Quali", $Q_list, $basic_details->Quali, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>
                    </div>
                    <div class="row" id="cam" style="display:none">
                        <div class="webcam col-lg-4 col-lg-offset-2" id="cemera">
                            <div id="my_camera" style="width: 100%;height: 100%;"></div>
                            <input type="button" value="Snap It" onClick="take_snapshot()" style="border-radius: 0px;position: relative;top: -27px;">
                        </div>  
                        <div class="webcam col-lg-4 col-lg-offset-2" id="pre">
                            <div id="preview_pane"></div>
                            <div id="cam_done" style="display:none"><input type="button" value="Done"   onClick="off_webcam(this)" style="border-radius: 0px;position: relative;top: -27px;"></div>
                            <input type="hidden" name="webcam" id="webcam">
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Image</div>
                        <div class="col-lg-4">
                            <div class="pic_frame">
                                <?php if ($basic_details->Pro_pic != "") { ?>
                                <img src="<?= base_url() . "img/Students_Data/student_pic_and_sign/" . $basic_details->Pro_pic ?>" alt="" class="profile_img"/>
                                <?php } else{ ?>
                                <img src="<?= base_url() . "img/default_pic_and_sign/default.png" ?>" alt="" class="profile_img"/>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Signature</div>
                        <div class="col-lg-4">
                            <div class="pic_frame">
                                <?php if ($basic_details->Sign != "") { ?>
                                    <img src="<?= base_url() . "img/Students_Data/student_pic_and_sign/" . $basic_details->Sign ?>" alt="" class="profile_img"/>
                                <?php } else{ ?>
                                <img src="<?= base_url() . "img/default_pic_and_sign/signature_scan.gif" ?>" alt="" class="profile_img"/>
                               <?php }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row bottom_gap">

                        <div class="col-lg-offset-2 col-lg-1">
                            <img src="<?= base_url() ?>img/web_cam.jpg" alt="" width="30px" onclick="ShowCam()"/></div>
                        <div class="col-lg-3">
                            <?php echo form_upload("Pro_pic", "", "class='form-control' id='pro_img'"); ?>         
                        </div>


                        <div class="col-lg-4 col-lg-offset-2">
                            <?php echo form_upload("Sign", "", "class='form-control'"); ?>         

                        </div>                
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Can Login</div> 
                        <div class="col-lg-4">
                            <input name="Can_Login" type="checkbox" checked="true" value="1" data-label-text="Yes" class="form-control bootswitches">
                            <input name="send_password_on_mail" type="checkbox" value="1" data-label-text="Send Password On Mail" class="form-control bootswitches">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="input-group">
                                <input class="bootswitches" name="gernerate_password" type="checkbox"  value="gernerate" checked="true" data-label-text="Auto Gernerate" toggle="yes" toggleid="password_box">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-md popover_element1" tabindex="-1" data-content="On Means You want to send password on mail, in this case password will be auto generate">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>




                    <!--     <div class="row bottom_gap">
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Allocate Batch</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">
                                    <input class="bootswitches"   name="allot_batch" type="checkbox"  value="allot" checked="" id="pass_toggle" data-label-text="Yes" toggle="yes" toggleid="allot_batch"> (You can allot batch later as well)
                            </div>
                        </div>-->
                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Contact Details</h5></div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Primary Mobile No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Mobile1", $basic_details->Mobile1, array("class" => "'form-control'", "placeholder" => "'783585****'")) ?>	              
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Secondary Mobile No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Mobile2", "", array("class" => "'form-control'", "placeholder" => "'783585****'")) ?>	              
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Primary Phone No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Phone1", $basic_details->Phone1, array("class" => "'form-control'", "placeholder" => "'011-6581****, 011-2547****'")) ?>	              
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Secondary Phone No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Phone2", "", array("class" => "'form-control'", "placeholder" => "'011-6581****, 011-2547****'")) ?>	              
                            </div>
                        </div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Primary Email ID</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Email1", $basic_details->Email1, array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Secondary Email ID</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("Email2", "", array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                            </div>
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Address Details</h5></div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label"></div>
                        <div class="col-lg-4"></div>

                        <div class="col-lg-2 padding_top_label">Same as current</div>
                        <div class="col-lg-4">
                            <input type="checkbox" data-label-text="Yes" value="1" class="form-control bootswitches">
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label"></div>
                        <div class="col-lg-4 padding_top_label">------------------------Current Address------------------------</div>
                        <div class="col-lg-2 padding_top_label"></div>
                        <div class="col-lg-4 padding_top_label">-------------------------Parm Address-------------------------</div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Address Line 1</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_textarea("C_Add", $basic_details->C_Add, array("class" => "'form-control'", "placeholder" => "'Current Address'", "id" => "C_Add"), 3, 3) ?>                               
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Address Line 1</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_textarea("P_Add", $basic_details->P_Add, array("class" => "'form-control'", "placeholder" => "'Parmanent Address'", "id" => "P_Add"), 3, 3) ?>                               
                            </div>
                        </div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Country</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("C_Country", $country_list, $basic_details->C_Country, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">Country</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("P_Country", $country_list, $basic_details->P_Country, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">State</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("C_State", $state_list, $basic_details->C_State, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">State</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("P_State", $state_list, $basic_details->P_State, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">City</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("C_City", $City_list, $basic_details->C_City, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">City</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("P_City", $City_list, $basic_details->P_City, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Locality</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("C_Locality", $locality_list, $basic_details->C_Locality, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">Locality</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("P_Locality", $locality_list, $basic_details->P_Locality, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Sub Locality</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("C_SubLocality", array(), $basic_details->P_Locality, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                        <div class="col-lg-2 padding_top_label">Sub Locality</div>
                        <div class="col-lg-4">
                            <div class="form-group">	
                                <?php echo form_dropdown("P_SubLocality", array(), $basic_details->P_Locality, "class='form-control chosen-select'") ?>
                            </div><!-- /input-group -->               
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">PinCode</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("C_Pincode", $basic_details->C_Pincode, array("class" => "'form-control'", "placeholder" => "'Current block'")) ?>	                                             
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">PinCode</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("P_Pincode", $basic_details->C_Pincode, array("class" => "'form-control'", "placeholder" => "'Parma block'")) ?>	                                             
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Block</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("C_Block", $basic_details->C_Block, array("class" => "'form-control'", "placeholder" => "'Current block'")) ?>	                                             
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Block</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("P_Block", $basic_details->P_Block, array("class" => "'form-control'", "placeholder" => "'Parma block'")) ?>	                                             
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">House No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("C_Houseno", $basic_details->C_Houseno, array("class" => "'form-control'", "placeholder" => "'Current House no'")) ?>	                                             
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">House No</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("P_Houseno", $basic_details->P_Houseno, array("class" => "'form-control'", "placeholder" => "'Parma House no'")) ?>	                                             
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Remarks</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_textarea("Remarks", $basic_details->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "C_village_and_post"), 3, 3) ?>                               
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label"></div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row bottom_gap">
                        <button type="submit" name="save_adm" value="Save" class="btn btn-success btn-md">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Update
                        </button>


                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div id="sectionB" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="page-header">Update Course Details</h4>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class='responsive'>
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>CourseCode</th>
                                    <th>DOR(DueDay)</th>
                                    <th><span title="Enquiry Code" class='cursor_pointer'>EC</span>/<span class='cursor_pointer' title="Enquiry visit">Vi</span></th>
                                    <th>Status</th>
                                    <th>Last Modified</th>
                                    <!--<th>Remarks</th>-->
                                    <th>Action With Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $s_no = 1;
                                foreach ($all_courses as $Course) {
                                    ?>

                                    <tr>
                                        <td><?php echo $s_no++ ?></td>
                                        <td><?php echo $Course->CourseCode ?></td>
                                        <td><?php echo date(DF, strtotime($Course->DOR)) . "(" . $Course->due_day . ")" ?></td>
                                        <td><?php echo $Course->E_Code . "/" . $Course->Visit; ?></td>
                                        <td><?php echo $Course->Status ? "Running" : "<span class='blink' style='color:red'>Cancelled</span>" ?></td>
                                        <td><?php echo date(DTF, strtotime($Course->Mode_DateTime)) ?></td>
                                        <td>

                                            <form action="<?php echo base_url() . "adm/cadm/cancel_course" ?>" method="POST">
                                                <input type="hidden" value='#sectionB' name='section'>
                                                <input type="text"   name="remarks"  placeholder="remark to add" value="<?php echo $Course->Remarks ?>"/>
                                                <input type="hidden" name="_key" value="cancel_stu_course"/>
                                                <input type="hidden" name="CourseID" value="<?php echo $Course->CourseID ?>"/>
                                                <input type="hidden" name="_title" value="<?= $Course->CourseCode ?>"/>
                                                <input type="hidden" name="act_dea" value="<?php echo $Course->Status ? 0 : 1; ?>"/>
                                                <input type="hidden" value="You want to cancel <?= $Course->Course_Name ?> Course !!" name="_msg"/>
                                                <input type="hidden" value="<?= $Course->Stu_ID ?>" name="ID"/>
                                                <?php
                                                if ($Course->Status) {
                                                    ?>
                                                    <button type="submit" value="Del"  class="btn btn-xs btn-danger" title="Cancel Course">
                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                    </button>
                                                    <?php
                                                } else {
//                                                                          $now = strtotime(date(DB_DTF));
//                                                                          $diff = $now - strtotime($Course->Mode_DateTime);
//                                                                          $last_modified = round(abs($diff) / 60, 2);
//                                                                          if ($last_modified <= 10) {
                                                    ?>
                                                    <button type="submit" value="Del"  class="btn btn-xs btn-success" title="Activate">
                                                        <span class="glyphicon glyphicon-send"></span> 
                                                    </button>
                                                    <?php
                                                    // }
                                                }
                                                ?>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <?php
                        echo form_open(base_url() . "adm/cadm/add_course", "id='new_course_form'");
                        echo form_hidden("Stu_ID", $basic_details->Stu_ID);
                        ?>
                        <input type="hidden" value='#sectionB' name='section'>
                        <h4 class="page-header">Add New Course</h4>
                        <h5 style='color: red'>(Already Added Course Will not Add and if you add, soft will show added successfully !!)</h5>
                        <div class="row">
                            <div class="col-lg-2" id="SelectCourse">
                                <label>Course Category</label>    
                                <div class="form-group" id="coursecat">
                                    <?php
                                    echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)'")
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-10" id="SelectCourse">
                                <label>Course List<span class="Compulsory">*</span></label>    
                                <div class="form-group" id="courselist">
                                    <?php echo form_multiselect("CourseID[]", $All_Course_List, "", "class='form-control chosen-select'") ?>

                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-2 padding_top_label">Date of Registration</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class='input-group date bdatepicker' >
                                        <input type='text' class="form-control" name="DOR" value="<?= date(DTF) ?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-lg-2'>Remarks</div>
                            <div class='col-lg-4'>
                                <?php echo form_textarea("Remarks", "", "class='form-control'"); ?>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-2">
                                <button type="submit" name="add_new_course" value="Save" class="btn btn-success btn-md">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Add Course
                                </button>         
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>

                </div>
                <div id="sectionC" class="tab-pane fade">
                    <h4 class='page-header'>All Batch List</h4>
                    <div class='responsive'>
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="batch_listeditadm">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Fac.Code</th>
                                    <th>BatchCode</th>
                                    <th>CourseCode</th>
                                    <th>BatchStatus</th>
                                    <th>Last Modified</th>
                                    <!--<th>Remarks</th>-->
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $s_no = 1;
                                foreach ($all_batches as $batche) {
                                    ?>

                                    <tr>
                                        <td><?php echo $s_no++ ?></td>
                                        <td><?php echo $batche['FacultyCode'] ?></td>
                                        <td><?php echo $batche['BatchCode'] ?></td>
                                        <td><?php echo $batche['CourseCode'] ?></td>
                                        <td><?php echo $batche['BatchStatus'] ?></td>
                                        <td><?php echo date(DTF, strtotime($batche['Mode_DateTime'])) ?></td>
                                        <td><?php echo $batche['Remarks'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="sectionD" class="tab-pane fade">
                    <div class="row">
                        <?php echo $update_faculty_course_share; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "Sorry there is an Error Please Try Again !!";
        }
        ?>
    </div>   

    <?php
    form_close();
    echo $form_validation;
    ?>
</div>   
<script>

    // for selection of tab on page refresh
    $(document).ready(function () {
        if (location.hash) {
            $('a[href=' + location.hash + ']').tab('show');
        }
        $(document.body).on("click", "a[data-toggle]", function (event) {
            location.hash = this.getAttribute("href");
        });
    });
    $(window).on('popstate', function () {
        var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
        $('a[href=' + anchor + ']').tab('show');
    });
    // end for selection of tab on page refresh

    // for show courses via course category
    function load_coursebycoursecat(C_CID, load_div)
    {
        $.ajax({
            url: "<?= base_url() . "cajax/c_course_ajax/getCourseByCourseCat/" ?>" + C_CID,
            type: 'POST',
            data: 'html',
            success: function (data, textStatus, jqXHR) {
                $("#courselist").html('<?= AJAXPRELOADER ?>');
                $("#courselist").html(data);
                var config = {
                    '.chosen-select': {},
                    '.chosen-select-deselect': {allow_single_deselect: true},
                    '.chosen-select-no-single': {disable_search_threshold: 10},
                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                    '.chosen-select-width': {width: "95%"}
                };
                for (var selector in config) {
                    $(selector).chosen(config[selector]);
                }

            },
            complete: function (jqXHR, textStatus) {

            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    // end of course category filter

    // data table to show all batches
    $(document).ready(function () {
        $("#batch_listeditadm").DataTable();
    });
</script>

<script src="<?php echo base_url() ?>js/webcam.js" type="text/javascript"></script>

<script language="JavaScript">
    function take_snapshot() {
        $("#cam_done").show();
        Webcam.snap(function (data_uri) {
            if (data_uri !== '') {
                document.getElementById('preview_pane').innerHTML = '<img id="base64image" src="' + data_uri + '"/>';
                $("#webcam").val(data_uri);
            } else {
                document.getElementById('preview_pane').innerHTML = '';
            }
        });
    }
    function ShowCam() {
        $("#cam").show();
        $("#cemera").show();
        $("#pre").find("input").show();
        Webcam.set({
            width: 187,
            height: 143,
            image_format: 'jpeg',
            jpeg_quality: 100,
        });
        Webcam.attach('#my_camera');
    }

    function uploadcomplete(event) {
        document.getElementById("loading").innerHTML = "";
        var image_return = event.target.responseText;
        var showup = document.getElementById("uploaded").src = image_return;
    }
    function cam_err() {
        $("#cam").hide();
        $("#cemera").hide();
        $("#pre").find("input").hide();
        alert("Can Not Access Webcam!!! Please Upload Image Manually");
    }

    function off_webcam(that) {
        Webcam.reset();
        $(that).hide();
        $("#cemera").hide();

    }
//   window.onload = ShowCam;
</script>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>



<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>