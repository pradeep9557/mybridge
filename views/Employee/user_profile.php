<div id="page-wrapper" style="min-height: 345px;">

    <?php
    if (isset($employee_data)) {
                  if (!$employee_data) {
                                ?>
                                <div class="row">
                                    <button type="button" class="btn btn-danger btn-md">Sorry Employee Doesn't exits !!
                                        <span class="glyphicon glyphicon-trash"></span> 
                                    </button>
                                </div>
                                <?php
                  } else {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="page-header ">User Profile(UI Under Construction)</h4>
                                        <?php
                                        if (isset($error)) {
                                                      $this->util_model->show_result_error($error, "Document Uploaded Successfully", "Error while uploading Documents");
                                        }
                                        ?>
                                    </div>

                                </div>
                                <!--If Employee does exits-->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#FacultyWise" role="tab" data-toggle="tab">Profile Picture And Sign</a></li>
                                    <li role="presentation"><a href="#EnrollnoWise" role="tab" data-toggle="tab">Basic Details</a></li>
<!--                                    <li role="presentation"><a href="#Adv_Search" role="tab" data-toggle="tab">Contact Details</a></li>-->
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="FacultyWise">
                                        <div class="row col-lg-12 padding_top_label">
                                            <div class="col-lg-2">Profile Pic<br>
                                                <h6>Choose File to update</h6>
                                            </div> 
                                            <div class="col-lg-3">
                                                <img src="<?= base_url() . (file_exists(EMP_UPLOAD_PATH . $employee_data->Pro_Pic) ? EMP_UPLOAD_PATH . $employee_data->Pro_Pic : DEFAULT_EMP_PIC) ?>" class="img-responsive thumbnail"/>
                                                <?php
                                                echo form_open_multipart(base_url() . 'Ajax/upload_ajax_pics', array('id' => 'uploadform'));
                                                echo form_hidden("Uploading_path", EMP_UPLOAD_PATH);
                                                echo form_hidden("FileName", $employee_data->Pro_Pic);
                                                echo form_upload("Ajax_upload_pic", "", "class='form-control change_pic'");
                                                echo form_close();
                                                ?> 
                                            </div>
                                            <div class="col-lg-2">Signature<br>
                                                <h6>Choose File to update</h6></div> 
                                            <div class="col-lg-3">
                                                <img src="<?= base_url() . (file_exists(EMP_UPLOAD_PATH . $employee_data->Sign) ? EMP_UPLOAD_PATH . $employee_data->Sign : DEFAULT_EMP_SIGN) ?>" class="img-responsive thumbnail"/>
                                                <?php
                                                echo form_open_multipart(base_url() . 'Ajax/upload_ajax_pics', array('id' => 'uploadform1'));
                                                echo form_hidden("Uploading_path", EMP_UPLOAD_PATH);
                                                echo form_hidden("FileName", $employee_data->Sign);
                                                echo form_upload("Ajax_upload_pic", "", "class='form-control change_pic'");
                                                echo form_close();
                                                ?> 

                                            </div>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="EnrollnoWise">
                                        <div class="row padding_top_label">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4">
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Code</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Emp_Code; ?>
                                                        </div> 

                                                    </div>
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Name</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Emp_Name; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Father's Name</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->FatherName; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Mother's Name</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->MotherName; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Date of Joining</div>
                                                        <div class="col-lg-7">
                                                            <?php echo date(DF, strtotime($employee_data->DOJ)); ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Date of Birth</div>
                                                        <div class="col-lg-7">
                                                            <?php echo date(DF, strtotime($employee_data->DOB)); ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Gender</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Gender; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Designation</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Designation; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Qualification</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Quali; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Salary</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Salary; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Nationality</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Nationality; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                    <div class="row bottom_gap">
                                                        <div class="col-lg-5">Working Days</div>
                                                        <div class="col-lg-7">
                                                            <?php echo $employee_data->Working_Days; ?>
                                                        </div>
                                                    </div> <!--End of row-->
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="Adv_Search">
                                        <div class="row padding_top_label">
                                            <div class="col-lg-5">
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-5">Mobile Numbers</div>
                                                    <div class="col-lg-7">
                                                        <?php
                                                        echo $employee_data->P_Mob;
                                                        if ($employee_data->S_Mob != "") {
                                                                      echo ", " . $employee_data->S_Mob;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-5">Phone Numbers</div>
                                                    <div class="col-lg-7">
                                                        <?php
                                                        echo $employee_data->P_Phone;
                                                        if ($employee_data->S_Phone != "") {
                                                                      echo ", " . $employee_data->S_Phone;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-5">Emails</div>
                                                    <div class="col-lg-7">
                                                        <?php
                                                        echo $employee_data->P_Email;
                                                        if ($employee_data->S_Email != "") {
                                                                      echo ", " . $employee_data->S_Email;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-4">Current Address</div>
                                                    <div class="col-lg-8">
                                                        <?php
                                                        echo $employee_data->C_Add;
//                                 if($employee_data->C_Locality!=""){
//                                    echo ", Locality ".$employee_data->C_Locality;
//                                }
//                               
//                                 if($employee_data->C_City!=""){
//                                    echo ",  ".$employee_data->C_City;
//                                }
//                                 if($employee_data->C_State!=""){
//                                    echo ",  ".$employee_data->C_State;
//                                } if($employee_data->C_Other!=""){
//                                    echo ",  ".$employee_data->C_Other;
//                                }
//                                 if($employee_data->C_PinCode!=""){
//                                    echo ",  Pincode".$employee_data->C_PinCode;
//                                }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-4">Parmanent Address</div>
                                                    <div class="col-lg-8">
                                                        <?php
                                                        echo $employee_data->P_Add;
//                                 if($employee_data->P_Locality!=""){
//                                    echo ", Locality ".$employee_data->P_Locality;
//                                }
//                                
//                                 if($employee_data->P_City!=""){
//                                    echo ",  ".$employee_data->P_City;
//                                }
//                                 if($employee_data->P_State!=""){
//                                    echo ",  ".$employee_data->P_State;
//                                } if($employee_data->P_Other!=""){
//                                    echo ",  ".$employee_data->P_Other;
//                                }
//                                 if($employee_data->P_PinCode!=""){
//                                    echo ",  Pincode".$employee_data->P_PinCode;
//                                }
//                                
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-5">Remarks</div>
                                                    <div class="col-lg-7">
                                                        <?php echo $employee_data->Remarks;
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                  }
    }
    ?>
</div> 

<script type="text/javascript">
              $(document).ready(function (e) {
                  var id = "";
                  $(".change_pic").change(function () {
                      id = $(this).parent().attr('id');
                      // alert(id);
                      $("#" + id).submit();
                  });

                  $("#uploadform,#uploadform1").on('submit', (function (e) {
                      e.preventDefault();
                      $('.pre_loader').show();
                      var form = $(this);
                      $.ajax({
                          url: "<?= base_url() . "Ajax/upload_ajax_pics" ?>",
                          type: "POST",
                          data: new FormData(this),
                          contentType: false,
                          cache: false,
                          dataType: 'json',
                          processData: false,
                          success: function (data) {
                              $('.pre_loader').hide();
                              if (data['succ']) {
                                  $(form).parent('div').children('img').attr('src', '<?= base_url() . EMP_UPLOAD_PATH ?>' + data['New_Path']);
                                  swal("Uploaded !", "Your File has been Uploaded Successfully !!", "success");
                                  window.location.reload();
                              } else
                                  swal("Error !", "Error While Uploading !!", "error");
                          },
                          error: function () {
                                                        }
                      });
                  }));


              });


              $(".slider_imgs").hover(function () {

                  $(this).children('.slider_img_delte_btn').show("fade");

              }, function () {

                  $(this).children('.slider_img_delte_btn').hide("fade");
              });
</script>



