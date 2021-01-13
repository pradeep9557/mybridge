<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">New User</h4>
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
            <h3 class="panel-title toggle_custom">New User From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php if (empty($user_types)) { ?>
                <div class="col-lg-12">
                    <h6><p class="alert alert-danger">Note :Not authorize to add a new user.</p></h6>
                </div> 
                <?php
            } else {
                //for normal form
                //  echo form_open('/dashboard/new_admission',$attributes);
                echo form_open_multipart(base_url() . 'tms/manage_users/users_save_update', "id='add_user_form'");
                ?>
                <!--String of Row-->
                <div class="row bottom_gap">

                    <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">User Type<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="input-group">
                            <?php echo form_dropdown("UTID", $user_types, '', "class='form-control utid_select chosen-select' ") ?>
                            <span class="input-group-addon popover_branch"  id="basic-addon1" >
                                <span class="glyphicon glyphicon-question-sign"></span>
                            </span>
                        </div><!-- /input-group -->               
                    </div> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">User Full Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("Emp_Name", "", array("class" => "'form-control form-control check_valid popover_element1'", "placeholder" => "'Full name of user'")) ?>
                        </div>
                    </div>
                </div>   

                <!--String of Row-->
                <div class="row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Primary Email<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("P_Email", "", array("class" => "'form-control check_valid popover_element1'", "placeholder" => "'Primary Email'")) ?>
                        </div>        
                    </div> 

                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">User Login<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">

                        <div class="input-group"> <div class="form-group">
                                <?php echo form_input("UserName", "", array("id" => "UserName", "class" => "'form-control check_valid check_already_exits popover_element1'", "checking_id" => "2", "placeholder" => "'Username to login'", "data-content" => "'Using Username you can login, it is for just easy login.'")) ?>
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

                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password On Mail<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_dropdown("send_on_mail", array("1" => "Enable", "0" => "Disable"), 0, "class='form-control check_valid send_on_mail' ") ?>
                        </div>
                    </div>
                </div> <!--End of row-->     
                <!--String of Row-->
                <div class="row bottom_gap" id="password_box">
                    <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Password<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">

                        <div class="form-group">
                            <?php echo form_password("Password", "", array("class" => "'form-control password_toogle  check_valid popover_element1'", "data-content" => "'Please try a strong password'", "placeholder" => "'Password'")) ?>
                        </div>        

                    </div> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Re-Type Password<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_password("confirmPassword", "", array("class" => "'form-control  check_valid password_toogle  popover_element1'", "data-content" => "'It Should be same as previous one, for help you can view !!'", "placeholder" => "'Same as Password'")) ?>
                        </div>
                    </div>
                </div> <!--End of row-->
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
    }
    $Curr_Obj = & get_instance();
    $Curr_Obj->All_users_List(USER);
    ?>


</div>
<?php
//$this->load->view("Employee/emp_form_validation");
?> 
<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
    $(".send_on_mail").change(function () {
        if ($(this).val() == "1") {
            $("#password_box").hide();
        } else {
            $("#password_box").show();
        }
    });


    $('#add_user_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            Emp_Name: {// Employee name
                validators: {
                    notEmpty: {
                        message: 'employee Name is required and can\'t be left empty'
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
                            return (options != null);
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
            },
            Password: {//password
                validators: {
                    notEmpty: {
                        message: 'Password is required and can\'t be left empty'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    identical: {
                        field: 'Password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }

        }
    });


</script>