<!--Tag input files-->
<link href="<?= base_url() ?>css/taginput/jquery.tagsinput.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.min.js" type="text/javascript"></script>
<!--End of tag input files-->


<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit  Detials of <?php  echo $employee_data->Emp_Code ?>
             <a href="<?php echo base_url(); ?>employee" class="pull-right">
                <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                    <span class="glyphicon glyphicon-backward"></span> Back
                </button></a>
            </h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Edit Employee<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'employee/employee_save_update', "id='validation_form'");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Branch<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php
                        echo form_hidden("Emp_ID",$employee_data->Emp_ID);
                        echo form_dropdown("BranchID", $a_branches, $employee_data->BranchID, "class='form-control form-control chosen-select' tabindex=1") ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>
                        </button>

                    </div><!-- /input-group -->               
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">User Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php echo form_dropdown("UTID", $user_types, $employee_data->UTID, "class='form-control form-control chosen-select' tabindex=1") ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>


                    </div><!-- /input-group -->               
                </div> 
            </div>
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Employee Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Name", $employee_data->Emp_Name, array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Name'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->      

            <!--String of Row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Employee Code<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class='input-group'>
                        <div class="form-group">
                            <?php echo form_input("Emp_Code", $employee_data->Emp_Code, array("id" => "Emp_Code", "class" => "'form-control check_already_exits popover_element'", "checking_id" => "'1'", "placeholder" => "'Employee Code'", "maxlength" => "10", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 3 characters'", "data-original-title" => "'Remember'")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="Emp_Code">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>

                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">User Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="input-group"> <div class="form-group">
                            <?php echo form_input("UserName", $employee_data->UserName, array("id" => "UserName", "class" => "'form-control check_already_exits popover_element1'", "checking_id" => "2", "placeholder" => "'User Name'", "data-content" => "'Using Username you can login, it is for just easy login.'")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="UserName">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>

                    </div><!-- /input-group -->               
                </div> 
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Primary Email<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("P_Email", $employee_data->P_Email, array("class" => "'form-control  popover_element1'", "placeholder" => "'Primary Email'")) ?>
                    </div>        
                </div> 
<!--                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <input class="bootswitches"   name="update_pass" type="checkbox"  value="mail"   id="pass_toggle" data-label-text="Update Password" toggle="yes" toggleid="password_box">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md popover_element1" tabindex="-1" data-content="Make yes if you wanna to update password !!">
                                <span class="glyphicon glyphicon-question-sign"></span>
                            </button>
                        </span>
                    </div>
                </div>-->
            </div> <!--End of row-->     
            <!--String of Row-->
<!--            <div class="row bottom_gap" id="password_box"  >
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="form-group">
                        <?php // echo form_password("Password", "", array("class" => "'form-control password_toogle  popover_element1'", "data-content" => "'Please try a strong password'", "placeholder" => "'Password'")) ?>
                    </div>        

                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Re-Type Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php // echo form_password("confirmPassword", "", array("class" => "'form-control  password_toogle  popover_element1'", "data-content" => "'It Should be same as previous one, for help you can view !!'", "placeholder" => "'Same as above'")) ?>
                    </div>
                </div>
            </div> End of row     -->
            <!--String of Row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Date of Joining(DOJ)</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bdatepicker' >
                        <input type='text' class="form-control" name="DOJ" value="<?= date(DTF,  strtotime($employee_data->DOJ)) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <!--                    <div class="input-group">
                                            <input type="text" name="DOJ"   class="form-control" datepicker-popup="{{calendar.dateFormat}}" ng-model="record.DOJ" is-open="calendar.opened.DOJ" datepicker-options="calendar.dateOptions" close-text="Close" placeholder="Date of Joining" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="calendar.open($event, 'DOJ')"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </div>-->

                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Date of Birth</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bdatepicker' >
                        <input type='text' class="form-control" name="DOB" value="<?= date(DTF, strtotime($employee_data->DOB)) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                    <!--                    <div class="input-group">
                                            
                                            <input type="text"  name="DOB" class="form-control" datepicker-popup="{{calendar.dateFormat}}" ng-model="record.DOB" is-open="calendar.opened.DOB" datepicker-options="calendar.dateOptions" close-text="Close" placeholder="Date of Joining" />
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="calendar.open($event, 'DOB')"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </div>-->

                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Designation</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php
                    echo form_dropdown("DID", $Designation, $employee_data->DID, "class='form-control chosen-select'");
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Salary</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("Salary", $employee_data->Salary, array("class" => "'form-control'", "placeholder" => "'Salary'")) ?>
                </div>


            </div>
            <div class="row bottom_gap">
<!--                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Qualification</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_multiselect("Quali[]", $all_qualification_list, $employee_data->Quali, "class ='form-control' style='display:none'") ?>                               
                </div>-->
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Last Experience</div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <?php echo form_textarea("Last_Experi", $employee_data->Last_Experi, array("class" => "'form-control taginput'", "placeholder" => "'Last Experience'", "id" => "last_exp"), 3, 3) ?>                               
                </div>
            </div>
            <?php
             echo $update_time_form;
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-12"><h5 class="group_title page-header">Personal Details</h5></div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Father's Name</div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <?php echo form_input("FatherName", $employee_data->FatherName, array("class" => "'form-control'", "placeholder" => "'Father Name'", "maxlength" => "25")) ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Mother's Name</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("MotherName", $employee_data->MotherName, array("class" => "'form-control'", "placeholder" => "'Mother Name'", "maxlength" => "25")) ?>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Nationality</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php
                    echo form_dropdown("NID", $nationality_list, $employee_data->NID, "class='form-control chosen-select'");
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Gender</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="radio">
                        <label>
                            <?php echo form_radio("Gender", "male", $employee_data->Gender=="male"?"checked":""); ?>	
                            Male
                        </label>
                        <label>
                            <?php echo form_radio("Gender", "Female",$employee_data->Gender=="Female"?"checked":""); ?>
                            Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="row bottom_gap" style="display:none">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Image</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_upload("Pro_Pic", "", "class='form-control'"); ?>         
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Signature</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_upload("Sign", "", "class='form-control'"); ?>         
                    </div>
                </div>                
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12"><h5 class="group_title page-header">Contact Details</h5></div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Primary Mobile No</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("P_Mob", $employee_data->P_Mob, array("class" => "'form-control'", "placeholder" => "'783585****'")) ?>	              
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Secondary Mobile No</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("S_Mob", $employee_data->S_Mob, array("class" => "'form-control'", "placeholder" => "'783585****'")) ?>	              
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Primary Phone No</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("P_Phone", $employee_data->P_Phone, array("class" => "'form-control'", "placeholder" => "'011-658****'")) ?>	              
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Secondary Phone	 No</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("S_Phone", $employee_data->S_Phone, array("class" => "'form-control'", "placeholder" => "'011-658****'")) ?>	              
                </div>
            </div>
            <div class="row bottom_gap">
                <!--                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Primary Email ID</div>
                                <div class="col-lg-4 col-md-4 col-sm-8">
                <?php // echo form_input("P_Email", "", array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                                </div>-->
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Secondary Email ID</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <?php echo form_input("S_Email", $employee_data->S_Email, array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12"><h5 class="group_title page-header">Address Details</h5></div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding_top_label">
                    <div class="panel panel-primary">
                        <div class="panel-heading" data-toggle="collapse" data-target="#cadd">
                            <h3 class="panel-title">Current Address<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body">


                            <div class="col-lg-12 col-md-12 col-sm-12 padding_top_label">
                                <?php echo form_textarea("C_Add",$employee_data->C_Add, array("class" => "'form-control'", "placeholder" => "'Full Current Address'", "id" => "C_Add"), 3, 3) ?>                               
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Locality</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("C_Locality", $employee_data->C_Locality, array("class" => "'form-control'", "placeholder" => "'Localilty'", "id" => "C_localilty")) ?>                                    
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Sub-Locality</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label ">
                                <?php echo form_input("C_Sub_Locality", $employee_data->C_Sub_Locality, array("class" => "'form-control'", "placeholder" => "'Sub-localilty'", "id" => "C_sub_Locality")) ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">City</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("C_City",$employee_data->C_City, array("class" => "'form-control'", "placeholder" => "'City'", "id" => "C_city")) ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">State</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("C_State",$employee_data->C_State, array("class" => "'form-control'", "placeholder" => "'State'", "id" => "C_state")) ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Pin</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("C_PinCode",$employee_data->C_PinCode, array("class" => "'form-control'", "placeholder" => "'1100**'", "id" => "C_pincode")) ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding_top_label">
                    <div class="panel panel-primary">
                        <div class="panel-heading" data-toggle="collapse" data-target="#padd">
                            <h3 class="panel-title">Permanent Address Details
                                (<label class="checkbox-inline">
                                    <?php echo form_checkbox("Same_address", "", $employee_data->Same_address, "id='Same_add_check_box'"); ?>   
                                    Same as Current Address
                                </label>)<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <?php echo form_textarea("P_Add", $employee_data->P_Add, array("class" => "'form-control'", "placeholder" => "'Full Parmanent Address'", "id" => "P_Add"), 3, 3) ?>                                              
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Locality</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("P_Locality", $employee_data->P_Locality, array("class" => "'form-control'", "placeholder" => "'Localilty'", "id" => "P_localilty")) ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Sub-Locality</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("P_Sub_Locality", $employee_data->P_Sub_Locality, array("class" => "'form-control'", "placeholder" => "'Sub-localilty'", "id" => "P_sub_Locality")) ?>                                               
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">City</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("P_City", $employee_data->P_City, array("class" => "'form-control'", "placeholder" => "'City'", "id" => "P_city")) ?>                                               
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">State</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("P_State", $employee_data->P_State, array("class" => "'form-control'", "placeholder" => "'State'", "id" => "P_state")) ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding_top_label">Pin</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 padding_top_label">
                                <?php echo form_input("P_PinCode", $employee_data->P_PinCode, array("class" => "'form-control'", "placeholder" => "'1100**'", "id" => "P_pincode")) ?>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-lg-1">
                    <!--<div class="input-group">-->

                    <?php echo form_submit("Add_Employee", "Update", array("class" => "'btn btn-success'")) ?>
                    <!--                   
                                       <button   type="button"  class="btn btn-success  btn-md">   
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                        </button>
                    -->
                    <!--</div>-->
                </div>
                <div class="col-lg-1">
                    <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-success'")) ?>
                </div>

            </div>
        </div>
    </div>

  
    <?php
    echo form_close();
    $Curr_Obj = & get_instance();
    $Curr_Obj->All_Emp_List();
    ?>


</div>
<?php
  $this->load->view("Employee/emp_form_validation");
?> 
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>