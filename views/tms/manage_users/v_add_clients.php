<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">New Client</h4>
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
            <h3 class="panel-title toggle_custom">New Client From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_users/users_save_update', "id='add_clients_form'");
            echo form_hidden("client_entry", "1");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">
                  
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">User Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php echo form_dropdown("UTID", $user_types, CLIENT, "class='form-control form-control utid_select chosen-select'"); 
                                
                                ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>
                    </div><!-- /input-group -->               
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Name", "", array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Client Name'")) ?>
                    </div>
                </div>
            </div> 
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client User Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("UserName", "", array("class" => "'form-control form-control check_already_exits popover_element1'", "placeholder" => "'Client User Name'","checking_id"=>13)) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Primary Email<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("P_Email", "", array("class" => "'form-control  popover_element1'", "placeholder" => "'Primary Email'")) ?>
                    </div>        
                </div>
            </div> <!--End of row-->
             <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Billing name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_name", "", array("class" => "'form-control form-control check_already_exits popover_element1'", "placeholder" => "'Billing name'","checking_id"=>13)) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Billing Address 1<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_add1", "", array("class" => "'form-control  popover_element1'", "placeholder" => "'Client Billing address line 1'")) ?>
                    </div>        
                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Address 2<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("client_billing_add2", "", array("class" => "'form-control form-control check_already_exits popover_element1'", "placeholder" => "'Client Billing address line 2'","checking_id"=>13)) ?>
                    </div>
                </div>
                 
            </div> <!--End of row-->
             <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">GST No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("gst_no", "", array("class" => "'form-control form-control'", "placeholder" => "'GST No'")) ?>
                    </div>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">PO No.<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("po_no", "", array("class" => "'form-control form-control'", "placeholder" => "'PO Number'")) ?>
                    </div>
                </div>
                 
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Pass", '', array("class" => "'form-control form-control'", "placeholder" => "'Pasword'")) ?>
                    </div>
                </div>  
            </div> <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Remarks</div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="form-group">
                        <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'")) ?>
                    </div>        
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1">
                    <!--<div class="input-group">-->
                    <?php echo form_submit("Add_Employee", "Create", array("class" => "'btn btn-success'")) ?>
                </div>
                <div class="col-lg-1">
                    <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-success'")) ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo form_close();
    echo $client_search_view;
//    $Curr_Obj = & get_instance();
//    $Curr_Obj->All_users_List($client = STATUS_TRUE);
    ?>
</div>
<script src="<?= CDN1 ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
    
    $('#add_clients_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            Emp_Name: {// Employee name
                validators: {
                    notEmpty: {
                        message: 'Client Name is required and can\'t be left empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s]+$/,
                        message: 'Name can only consist given alphabets a-zA-Z0-9 or space'
                    },
                    stringLength: {
                        min: 3,
                        max: 150,
                        message: 'Name must be more 3 characters long'
                    }
                }
            },
            UTID: {
                validators: {
                    callback: {
                        message: 'Please choose at least one User Type',
                        callback: function (value, validator, $field) {
                            // Get the selected options
                            var options = $(".utid_select").val();
                            return (options != null );
                        }
                    }
                }
            },
            P_Email: {//Primary Email
                validators: {
                    notEmpty: {
                        message: 'Primary Mail is required and can\'t be left empty'
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    }
                }
            },
            UserName: {// User name
                validators: {
                    notEmpty: {
                        message: 'User Name is required and can\'t be left empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s_-]+$/,
                        message: 'Name can only consist given alphabets a-zA-Z0-9_- or space'
                    },
                    stringLength: {
                        min: 3,
                        max: 150,
                        message: 'Name must be more 3 characters long'
                    }
                }
            }
        }
    });


</script>
<script>

</script>