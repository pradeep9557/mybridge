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
                                        <h4 class="page-header ">Please attach Supported Documents</h4><h6 style="color:red">Only PDF Allowed, Less then 300 kb.</h6>
                                        <?php
                                        if (isset($error)) {
                                                      $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
                                        }
                                        ?>
                                    </div>

                                </div>
                                <?php
                                //for normal form
                                //  echo form_open('/dashboard/new_admission',$attributes);
                                echo form_open_multipart('/employee/upload_supported_document', "id='validation_form'");
                                ?>
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 ">Address Proof</div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <div class="form-group">
                                                <?php
                                                echo form_hidden("Emp_Code", "$Emp_Code");
                                                echo form_hidden("Mode_User", "AMD");
//                       print_r($employee_data->Address_Proof);

                                                echo form_upload("Address_Proof", "", "class='form-control'");
                                                echo "</div>";
                                                //print_r($employee_data);
                                                if ($employee_data->Address_Proof != "" && file_exists(EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Address_Proof)) {
                                                              ?>         
                                                              <span class="input-group-btn">
                                                                  <button   type="button"  class="btn btn-default btn-md">
                                                                      <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Address_Proof ?>" target="_blank"><span class="glyphicon glyphicon-ok"></span></a>
                                                                      <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Address_Proof ?>"><span class="glyphicon glyphicon-download"></span></a>
                                                                  </button>
                                                              </span>
                                                <?php } else { ?> 
                                                              <span class="input-group-btn">
                                                                  <button   type="button"  class="btn btn-default btn-md">
                                                                      <span class="glyphicon glyphicon-trash"></span>
                                                                  </button>
                                                              </span>
                                                <?php } ?>    
                                            </div>
                                        </div>
                                        <div class="col-lg-2 ">ID Proof</div>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <div class="form-group">
                                                    <?php
                                                    echo form_upload("ID_Proof", "", "class='form-control'");
                                                    echo "</div>";
                                                    if ($employee_data->ID_Proof != "" && file_exists(EMP_DOCUMENT_UPLOAD_PATH . $employee_data->ID_Proof)) {
                                                                  ?>         
                                                                  <span class="input-group-btn">
                                                                      <button   type="button"  class="btn btn-default btn-md">
                                                                          <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->ID_Proof ?>" target="_blank"><span class="glyphicon glyphicon-ok"></span></a>
                                                                          <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->ID_Proof ?>"><span class="glyphicon glyphicon-download"></span></a>
                                                                      </button>
                                                                  </span>
                                                    <?php } else { ?> 
                                                                  <span class="input-group-btn">
                                                                      <button   type="button"  class="btn btn-default btn-md">
                                                                          <span class="glyphicon glyphicon-trash"></span>
                                                                      </button>
                                                                  </span>
                                                    <?php } ?>    
                                                </div>
                                            </div>                
                                        </div>
                                        <div class="row bottom_gap">
                                            <div class="col-lg-2 ">Highest Qualification</div>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <div class="form-group">
                                                        <?php
                                                        echo form_upload("Police_verification", "", "class='form-control'");
                                                        echo "</div>";
                                                        if ($employee_data->Police_verification != "" && file_exists(EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Police_verification)) {
                                                                      ?>         
                                                                      <span class="input-group-btn">
                                                                          <button   type="button"  class="btn btn-default btn-md">
                                                                              <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Police_verification ?>" target="_blank"><span class="glyphicon glyphicon-ok"></span></a>
                                                                              <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Police_verification ?>"><span class="glyphicon glyphicon-download"></span></a>
                                                                          </button>
                                                                      </span>
                                                        <?php } else { ?> 
                                                                      <span class="input-group-btn">
                                                                          <button   type="button"  class="btn btn-default btn-md">
                                                                              <span class="glyphicon glyphicon-trash"></span>
                                                                          </button>
                                                                      </span>
                                                        <?php } ?>    
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 ">Resume</div>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <div class="form-group">
                                                            <?php
                                                            echo form_upload("Resume", "", "class='form-control'");
                                                            echo "</div>";
                                                            if ($employee_data->Resume != "" && file_exists(EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Resume)) {
                                                                          ?>         
                                                                          <span class="input-group-btn">
                                                                              <button   type="button"  class="btn btn-default btn-md">
                                                                                  <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Resume ?>" target="_blank"><span class="glyphicon glyphicon-ok"></span></a>       
                                                                                  <a href="<?= base_url() . EMP_DOCUMENT_UPLOAD_PATH . $employee_data->Resume ?>"><span class="glyphicon glyphicon-download"></span></a>
                                                                              </button>
                                                                          </span>
                                                            <?php } else { ?> 
                                                                          <span class="input-group-btn">
                                                                              <button   type="button"  class="btn btn-default btn-md">
                                                                                  <span class="glyphicon glyphicon-trash"></span>
                                                                              </button>
                                                                          </span>
                                                            <?php } ?>    
                                                        </div>
                                                    </div>                
                                                </div>

                                                <script>
                                                              /* 
                                                               * To change this license header, choose License Headers in Project Properties.
                                                               * To change this template file, choose Tools | Templates
                                                               * and open the template in the editor.
                                                               * @auther Anup kumar
                                                               * @Date of Creation : 11 march 2015
                                                               * @purpose : validation of add Employee
                                                               */


                                                              //      Form Validation         

                                                              $(document).ready(function () {
                                                                  $('#validation_form').bootstrapValidator({
                                                                      feedbackIcons: {
                                                                          valid: 'glyphicon glyphicon-ok',
                                                                          invalid: 'glyphicon glyphicon-remove',
                                                                          validating: 'glyphicon glyphicon-refresh'
                                                                      },
                                                                      fields: {
                                                                          Address_Proof: {// field name
                                                                              validators: {
                                                                                  file: {
                                                                                      extension: 'pdf',
                                                                                      type: 'application/pdf',
                                                                                      maxSize: 307200, // 300 * 1024
                                                                                      message: 'The selected file is not valid, or exceed to 300 kb'
                                                                                  }
                                                                              }
                                                                          }, ID_Proof: {// field name
                                                                              validators: {
                                                                                  file: {
                                                                                      extension: 'pdf',
                                                                                      type: 'application/pdf',
                                                                                      maxSize: 307200, // 300 * 1024
                                                                                      message: 'The selected file is not valid, or exceed to 300 kb'
                                                                                  }
                                                                              }
                                                                          }, Police_verification: {// field name
                                                                              validators: {
                                                                                  file: {
                                                                                      extension: 'pdf',
                                                                                      type: 'application/pdf',
                                                                                      maxSize: 307200, // 300 * 1024
                                                                                      message: 'The selected file is not valid, or exceed to 300 kb'
                                                                                  }
                                                                              }
                                                                          }, Resume: {// field name
                                                                              validators: {
                                                                                  file: {
                                                                                      extension: 'pdf',
                                                                                      type: 'application/pdf',
                                                                                      maxSize: 307200, // 300 * 1024
                                                                                      message: 'The selected file is not valid, or exceed to 300 kb'
                                                                                  }
                                                                              }
                                                                          }
                                                                      }

                                                                  });
                                                              });

                                                </script>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <?php echo form_submit("upload_supported_documents", "Upload & Finish", array("class" => "'btn btn-primary green_color'", "style" => "'background:#1abc9c'")) ?>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <?php
                                                        echo form_reset("Reset", "Reset", array("class" => "'btn btn-primary green_color reset'", "style" => "'background:#1abc9c'"));
                                                        echo form_hidden("Mode_User", "NA");
                                                        form_close();
                                                        ?>

                                                    </div>
                                                    <div class="col-lg-1">
                                                        <a href="<?= base_url() . "employee/add_employee/0/1" ?>">
                                                            <button type="button" name="Edit_Employee" value="Confirm" class="btn btn-success">
                                                                <span class="glyphicon glyphicon-ok"></span> Confirm and go back
                                                            </button>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h4 class="page-header">Other Filled Details of Employee</h4>
                                                    </div>
                                                </div>
                                                <?php
                                                //for normal form
                                                //  echo form_open('/dashboard/new_admission',$attributes);
                                                echo form_open_multipart('/employee/Emp_Edit', "");
                                                ?>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Employee Code</div>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <?php echo $employee_data->Emp_Code; ?>
                                                        </div><!-- /input-group -->               
                                                    </div> 
                                                    <div class="col-lg-2 ">Employee Name</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->Emp_Name; ?>
                                                    </div>
                                                </div> <!--End of row-->
                                                <!--String of Row-->
                                                <div class="row bottom_gap">

                                                    <div class="col-lg-2 ">Date of Joining(DOJ)</div>
                                                    <div class="col-lg-4">
                                                        <div class="input-group" id="date_btn">

                                                            <?php echo date(DF, strtotime($employee_data->DOJ)); ?>

                                                        </div>

                                                    </div>
                                                    <div class="col-lg-2 ">Date of Birth</div>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <?php echo date(DF, strtotime($employee_data->DOB)); ?>	

                                                        </div>
                                                    </div>
                                                </div> <!--End of row-->
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Designation</div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        echo $employee_data->DID;
                                                        ?>
                                                    </div>
                                                    <div class="col-lg-2 ">Salary</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->Salary; ?>
                                                    </div>


                                                </div>
                                                <div class="row bottom_gap">
                                                    <!--                <div class="col-lg-2 ">Qualification</div>
                                                                    <div class="col-lg-4">
                                                    
                                                    <?php // print_r(unserialize($employee_data->Quali)); ?>                               
                                                                    </div>-->
                                                    <div class="col-lg-2 ">Last Experience</div>
                                                    <div class="col-lg-4">

                                                        <?php echo $employee_data->Last_Experi; ?>                               
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-8 ">Working Days</div>
                                                    <div class="col-lg-4">
                                                        <button onclick="get_timings(this,<?php echo $employee_data->Emp_ID; ?>, 2)" class="btn" >get timings</button>
                                                        <div class="element_details">
                                                        </div>
                                                    </div>
                                                    <!--      <div class="col-lg-2 ">Timing</div>
                                                          <div class="padding_left_0px col-lg-4">
                                                    <?php // echo date(DT, strtotime($employee_data->Str_Time)) . " to " . date(DT, strtotime($employee_data->End_Time)); ?>
                                                          </div>-->
                                                </div>

                                                <div class="row bottom_gap">
                                                    <div class="col-lg-12"><h5 class="group_title page-header">Personal Details</h5></div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Father's Name</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->FatherName; ?>
                                                    </div>
                                                    <div class="col-lg-2 ">Mother's Name</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->MotherName; ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Nationality</div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        $employee_data->NID;
                                                        ?>
                                                    </div>
                                                    <div class="col-lg-2 ">Gender</div>
                                                    <div class="col-lg-4">
                                                        <div class="radio">
                                                            <label>
                                                                <?php $employee_data->Gender; ?>	

                                                            </label>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Image</div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        if (file_exists(EMP_UPLOAD_PATH . $employee_data->Pro_Pic)) {
                                                                      echo "<img src='" . base_url() . EMP_UPLOAD_PATH . $employee_data->Pro_Pic . "' width='100px;'/>";
                                                        } else {
                                                                      echo "<img src='" . base_url() . DEFAULT_EMP_PIC . "' width='100px;'/>";
                                                        }
                                                        ?>         
                                                    </div>
                                                    <div class="col-lg-2 ">Signature</div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        if (file_exists(EMP_UPLOAD_PATH . $employee_data->Sign)) {
                                                                      echo "<img src='" . base_url() . EMP_UPLOAD_PATH . $employee_data->Sign . "' width='100px;'/>";
                                                        } else {
                                                                      echo "<img src='" . base_url() . DEFAULT_EMP_SIGN . "' width='100px;'/>";
                                                        }
                                                        ?> 

                                                    </div>                
                                                </div>

                                                <div class="row bottom_gap">
                                                    <div class="col-lg-12"><h5 class="group_title page-header">Contact Details</h5></div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Primary Mobile No</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Mob; ?>	              
                                                    </div>
                                                    <div class="col-lg-2 ">Secondary Mobile No</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->S_Mob; ?>	              
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Primary Phone No</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Phone; ?>	              
                                                    </div>
                                                    <div class="col-lg-2 ">Secondary Phone	 No</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->S_Phone; ?>	              
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Primary Email ID</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Email; ?>	                                             
                                                    </div>
                                                    <div class="col-lg-2 ">Secondary Email ID</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->S_Email; ?>	                                             
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-12"><h5 class="group_title page-header">Address Details</h5></div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Current Address</div>
                                                    <div class="col-lg-4">
                                                        <!-- It is just Place holder for gap--->
                                                    </div>
                                                    <div class="col-lg-4 ">
                                                        Parmanent Address

                                                    </div>
                                                </div>

                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Locality</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_Locality; ?>                                               

                                                    </div>
                                                    <div class="col-lg-2 ">Localilty</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Locality; ?>                                               

                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Sub-Locality</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_Sub_Locality; ?>                                               
                                                    </div>
                                                    <div class="col-lg-2 ">Sub-Locality</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Sub_Locality; ?>                  
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">City</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_City; ?>                                               
                                                    </div>
                                                    <div class="col-lg-2 ">City</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_City; ?>                                               

                                                    </div>
                                                </div>

                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">State</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_State; ?>
                                                    </div>
                                                    <div class="col-lg-2 ">State</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_State; ?>
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Full Address</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_Add; ?>                               
                                                    </div>
                                                    <div class="col-lg-2 ">Full Address</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_Add; ?>                                              
                                                    </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Pin</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->C_PinCode; ?>                               
                                                    </div>
                                                    <div class="col-lg-2 ">Pin</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->P_PinCode; ?>                </div>
                                                </div>
                                                <div class="row bottom_gap">
                                                    <div class="col-lg-12"><h5 class="group_title page-header">Office Work</h5></div>
                                                </div>

                                                <div class="row bottom_gap">
                                                    <div class="col-lg-2 ">Add User</div>
                                                    <div class="col-lg-4">
                                                        <?php
                                                        echo $employee_data->Add_UserCode;
                                                        ?>
                                                    </div>
                                                    <div class="col-lg-2 ">Remarks</div>
                                                    <div class="col-lg-4">
                                                        <?php echo $employee_data->Remarks; ?>                               
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-1">
                                                        <button class="btn btn-success" onclick="open_page('<?= base_url() ?>employee/Emp_Edit/0/0/<?= $employee_data->Emp_Code ?>', '')">
                                                            <span class="glyphicon glyphicon-edit"></span> Edit
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <a href="<?= base_url() . "employee/add_employee/0/1" ?>">
                                                            <button type="button" name="Edit_Employee" value="Confirm" class="btn btn-success">
                                                                <span class="glyphicon glyphicon-ok"></span> Confirm and go back
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                form_close();
                                                ?>
                                                <?php
                                  }
                    }
                    ?>
                </div> 
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>js/custom_js/table_manipulation/mange_time_js.js" type="text/javascript"></script>