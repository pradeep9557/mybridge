<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit  Detials of <?php echo $employee_data->UserName ?>
                <a href="<?php echo base_url('tms/manage_users/add_clients'); ?>" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-backward"></span> Back
                    </button></a>
            </h4>
            <?php
            //die($this->util_model->printr($employee_data));
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Edit Client<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_users/users_save_update', "id='validation_form'");
            echo form_hidden("UserName", $employee_data->UserName);
            echo form_hidden("Emp_ID", $employee_data->Emp_ID);
            echo form_hidden("client_entry", "1");
            ?>

            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">User Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php
                        echo form_dropdown("UTID", $user_types, CLIENT, "class='form-control form-control chosen-select' tabindex=1 disabled");
                        echo form_hidden("UTID", CLIENT);
                        ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>
                    </div><!-- /input-group -->               
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Client Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Name", $employee_data->Emp_Name, array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Name'")) ?>
                    </div>        
                </div> 
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client User Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("UserName", $employee_data->UserName, array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Client User Name'")) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Primary Email<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("P_Email", $employee_data->P_Email, array("class" => "'form-control  popover_element1'", "placeholder" => "'Primary Email'")) ?>
                    </div>        
                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Billing name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_name", $employee_data->client_billing_name, array("class" => "'form-control form-control check_already_exits popover_element1'", "placeholder" => "'Billing name'","checking_id"=>13)) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Billing Address 1<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_add1", $employee_data->client_billing_add1, array("class" => "'form-control  popover_element1'", "placeholder" => "'Client Billing address line 1'")) ?>
                    </div>        
                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Address 2<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_add2", $employee_data->client_billing_add2, array("class" => "'form-control form-control check_already_exits popover_element1'", "placeholder" => "'Client Billing address line 2'","checking_id"=>13)) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Status<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_dropdown("Status", array('1'=>'Enable','0'=>'Disable'),$employee_data->Status, "class='form-control'") ?>
                    </div>
                </div> 
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">GST No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("gst_no", $employee_data->gst_no, array("class" => "'form-control form-control'", "placeholder" => "'GST No'")) ?>
                    </div>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">PO No.<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">  
                        <?php echo form_input("po_no", $employee_data->po_no, array("class" => "'form-control form-control'", "placeholder" => "'PO Number'")) ?>
                    </div>
                </div>
                 
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Pass", $this->util_model->decrypt_string($employee_data->Emp_Pass), array("class" => "'form-control form-control'", "placeholder" => "'Pasword'")) ?>
                    </div>
                </div>  
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Remarks<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_textarea("Remarks", $employee_data->Remarks, array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Name'")) ?>
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
                    <a href="<?php  echo base_url("tms/manage_users/add_clients"); ?>" class="btn btn-danger">Cancel</a>
                </div>

            </div>
        </div>
    </div>
</div>
