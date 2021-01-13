<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <?php
        if (isset($last_admission)) {
            echo "<h4>Last Admission</h4>";
            echo $last_admission;
        }
        ?>
        <h4 class="page-header">Search Admission</h4>
        <?php
        echo $adm_search_template;
        ?>
        <h4 class="page-header">Search Enquiry</h4>
        <?php
        echo $enq_search_template;
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">New Admission Form</h4>
                <?php
                if (isset($error)) {
                    $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
                }
                ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!--String of Row-->
        <?php
        echo form_open_multipart(base_url() . "adm/cadm/save_adm", " id ='adm_form'");
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
                    <?php echo form_input("EnrollNo", "", array("id" => "Enrollno", "class" => "'form-control'", "placeholder" => "'Enroll No'", "maxlength" => "15")) ?>
                </div>
            </div>
        </div> <!--End of row-->
        <script>
            function get_enroll()
            {
                var branch_code = $("#Enroll_Code").val();
                var page = "<?= base_url() ?>adm/cadm/next_enroll/" + branch_code;
                $.ajax({
                    type: "POST",
                    url: page,
                    success: function (result) {
                        $("#Enrollno").val(result);
                    }});
            }
            function check_blank() {
                if ($("#Enrollno").val() == "") {
                    get_enroll();
                }
            }
            setInterval(check_blank, 1000);
            $(document).ready(function () {
                get_enroll();
            });
        </script>
        <!--String of Row-->
        <div class="row bottom_gap">

            <div class="col-lg-2 padding_top_label">Other Branch Enroll No</div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo form_input("OtherBranchEnroll", "", array("class" => "'form-control'", "placeholder" => "'Other Branch EnrollNo'", "maxlength" => "20")) ?>
                </div>
            </div>

            <div class="col-lg-2 padding_top_label">Student Name</div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo form_input("StudentName", isset($e_basic_details->StudentName) ? $e_basic_details->StudentName : '', array("class" => "'form-control'", "placeholder" => "Student Name", "maxlength" => "50")) ?>
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
                    <?php echo form_input("FatherName", isset($e_basic_details->FatherName) ? $e_basic_details->FatherName : '', array("class" => "'form-control'", "placeholder" => "'Father's Name'", "maxlength" => "50")) ?>
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">Mother's Name</div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo form_input("MotherName", isset($e_basic_details->MotherName) ? $e_basic_details->MotherName : '', array("class" => "'form-control'", "placeholder" => "'Mother's Name'", "maxlength" => "50")) ?>
                </div>
            </div>
        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Date of Birth</div>
            <div class="col-lg-4">

                <div class='input-group date bdatepicker' >
                    <div class="form-group">
                        <input type='text' class="form-control" name="DOB" value="<?= date(DTF, strtotime(isset($e_basic_details->DOB) ? $e_basic_details->DOB : date(DTF))) ?>"/>
                    </div>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>

                </div>
            </div>
            <div class="col-lg-2 padding_top_label">Nationality</div>
            <div class="col-lg-4">
                <div class="form-group">	
                    <?php echo form_dropdown("NID", $n_list, isset($e_basic_details->NID) ? $e_basic_details->NID : '', "class='form-control chosen-select'") ?>
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
                    <?php echo form_dropdown("Gender", array("Male" => "Male", "Female" => "Female", "Other" => "Other"), isset($e_basic_details->Gender) ? $e_basic_details->Gender : '', "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">Qualification</div>
            <div class="col-lg-4">
                <div class="form-group">	
                    <?php echo form_dropdown("Quali", $Q_list, isset($e_basic_details->Quali) ? $e_basic_details->Quali : '', "class='form-control chosen-select'") ?>
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
            <div class="col-lg-1">
                <img src="<?= base_url() ?>img/web_cam.jpg" alt="" width="30px" onclick="ShowCam()"/></div>
            <div class="col-lg-3">
                <?php echo form_upload("Pro_pic", "", "class='form-control'"); ?>         
            </div>

            <div class="col-lg-2 padding_top_label">Signature</div>
            <div class="col-lg-4">
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
                    <input class="bootswitches"   name="gernerate_password" type="checkbox"  value="gernerate" checked="true" data-label-text="Auto Gernerate" toggle="yes" toggleid="password_box">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-md popover_element1" tabindex="-1" data-content="On Means You want to send password on mail, in this case password will be auto generate">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <!--String of Row-->
        <div class="row bottom_gap" id="password_box" style="display: none">
            <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Password</div>
            <div class="col-lg-4 col-md-4 col-sm-8">
                <div class="form-group">
                    <?php echo form_password("Password", "", array("class" => "'form-control password_toogle  popover_element1'", "data-content" => "'Please try a strong password'", "placeholder" => "'Password'")) ?>
                </div>        
            </div> 
            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Re-Type Password</div>
            <div class="col-lg-4 col-md-4 col-sm-8">
                <div class="form-group">
                    <?php echo form_password("confirmPassword", "", array("class" => "'form-control  password_toogle  popover_element1'", "data-content" => "'It Should be same as previous one, for help you can view !!'", "placeholder" => "'Same as above'")) ?>
                </div>
            </div>
        </div> <!--End of row--> 

        <div class="row bottom_gap">
            <div class="col-lg-12"><h5 class="group_title">Course and Batch Details</h5></div>
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
        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Courses</div>
            <div class="col-lg-10">
                <div class="form-group">
                    <?php
                    echo form_hidden("E_Code", $e_sources->E_Code);
                    echo form_hidden("Visit", $e_sources->Visit);
                    $enquired_courses = array();
                    foreach ($e_courses as $course) {
                        $enquired_courses[$course->CourseID] = $course->CourseID;
                    }

                    echo form_multiselect("CourseID[]", $All_Course_List, $enquired_courses, "class='form-control chosen-select'")
                    ?>
                </div>
            </div>
        </div>
        <!-- <div class="row bottom_gap">
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
                    <?php echo form_input("Mobile1", isset($e_basic_details->Mobile1) ? $e_basic_details->Mobile1 : '', array("class" => "'form-control'", "placeholder" => "'783585****'")) ?>	              
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
            <div class="col-lg-2 padding_top_label">Parent Primary No</div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo form_input("Phone1", isset($e_basic_details->Phone1) ? $e_basic_details->Phone1 : '', array("class" => "'form-control'", "placeholder" => "'011-6581****, 011-2547****'")) ?>	              
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">Parent Secondary No</div>
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
                    <?php echo form_input("Email1", isset($e_basic_details->Email1) ? $e_basic_details->Email1 : '', array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                </div>
            </div>

            <!--        <div class="col-lg-2 padding_top_label">Secondary Email ID</div>
                    <div class="col-lg-4">
                        <div class="form-group">-->
            <?php // echo form_hidden("Email2", "") ?>                                             
            <!--    </div>
            </div>-->

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
                    <?php echo form_textarea("C_Add", $e_basic_details->C_Galino . " " . $e_basic_details->Block, array("class" => "'form-control'", "placeholder" => "'Current Address'", "id" => "C_Add"), 3, 3) ?>                               
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">Address Line 1</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_textarea("P_Add", $e_basic_details->C_Galino . " " . $e_basic_details->Block, array("class" => "'form-control'", "placeholder" => "'Parmanent Address'", "id" => "P_Add"), 3, 3) ?>                               
                </div>
            </div>
        </div>

        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Country</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("C_Country", $country_list, $e_basic_details->C_Country, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">Country</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("P_Country", $country_list, $e_basic_details->C_Country, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">State</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("C_State", $state_list, $e_basic_details->C_State, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">State</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("P_State", $state_list, $e_basic_details->C_State, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">City</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("C_City", $City_list, $e_basic_details->C_City, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">City</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("P_City", $City_list, $e_basic_details->C_City, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Locality</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("C_Locality", $locality_list, $e_basic_details->C_Locality, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">Locality</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("P_Locality", $locality_list, $e_basic_details->C_Locality, "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Sub Locality</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("C_SubLocality", array(), "", "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

            <div class="col-lg-2 padding_top_label">Sub Locality</div>
            <div class="col-lg-4">
                <div class="form-group">	
<?php echo form_dropdown("P_SubLocality", array(), "", "class='form-control chosen-select'") ?>
                </div><!-- /input-group -->               
            </div>

        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">PinCode</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("C_Pincode", $e_basic_details->C_Pincode, array("class" => "'form-control'", "placeholder" => "'Current PinCode'")) ?>	                                             
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">PinCode</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("P_Pincode", $e_basic_details->C_Pincode, array("class" => "'form-control'", "placeholder" => "'Parma PinCode'")) ?>	                                             
                </div>
            </div>
        </div>

        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Block</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("C_Block", "", array("class" => "'form-control'", "placeholder" => "'Current block'")) ?>	                                             
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">Block</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("P_Block", "", array("class" => "'form-control'", "placeholder" => "'Parma block'")) ?>	                                             
                </div>
            </div>
        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">House No</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("C_Houseno", "", array("class" => "'form-control'", "placeholder" => "'Current House no'")) ?>	                                             
                </div>
            </div>
            <div class="col-lg-2 padding_top_label">House No</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_input("P_Houseno", "", array("class" => "'form-control'", "placeholder" => "'Parma House no'")) ?>	                                             
                </div>
            </div>
        </div>
        <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Remarks</div>
            <div class="col-lg-4">
                <div class="form-group">
<?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "C_village_and_post"), 3, 3) ?>                               
                </div>
            </div>
            <div class="col-lg-2 padding_top_label"></div>
            <div class="col-lg-4"></div>
        </div>
        <div class="col-lg-12 bottom_gap">
            <button type="submit" name="save_adm" value="Save" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-floppy-disk"></span> Admission
            </button>
            <!--        <button type="submit" name="save_adm" value="Save_and_fee" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Admission & Fee
                    </button>-->
            <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-refresh"></span> Reset
            </button>

        </div>
<?php
echo form_close();
echo $form_validation;
?>
    </div>   
</div>
<?php ?>
</div>   

<script src="<?php echo base_url() ?>js/webcam.js" type="text/javascript"></script>

<script language="JavaScript">
              function take_snapshot() {
                  $("#cam_done").show();
                  Webcam.snap(function (data_uri) {
                      if (data_uri !== '') {
                          document.getElementById('preview_pane').innerHTML = '<img id="base64image" src="' + data_uri + '"/>';
                          $("#webcam").val(data_uri);
                      }
                      else {
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
              function cam_err(){
                  $("#cam").hide();
                  $("#cemera").hide();
                  $("#pre").find("input").hide();
                  alert("Can not access Webcam!!! Please Upload Image Manually.");
              }
              function off_webcam(that) {
                Webcam.reset();
                     $(that).hide();       
                     $("#cemera").hide();
                     
              }
//   window.onload = ShowCam;
</script>

<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>


<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
