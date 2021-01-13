<div id="page-wrapper" style="min-height: 345px;">
    <?php
//    $this->util_model->printr($branch_settings);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">New Notification setting</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    echo form_open(base_url() . "sp-admin/bm/save_notify_setting", "id='branch_form'");
    
//$this->util_model->printr($branch_settings);
    ?>

    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Branch</div>
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("BranchID", array($branch_settings->BranchID => $branch_settings->BranchCode), "", "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>


        <div class="col-lg-2">Follow up sms</div> 
        <div class="col-lg-4">
            <input name="followup_sms" type="checkbox" checked="true" value="1" class="form-control bootswitches">
        </div>


    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">SMS mobile no</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("followup_sms_no", $branch_settings->followup_sms_no, array("class" => "'form-control'", "placeholder" => "Sms mobile no", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div>

        <div class="col-lg-2">Email</div> 
        <div class="col-lg-4">
            <input name="followup_emails" type="checkbox" checked="true" value="1" class="form-control bootswitches">
        </div>





    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">Sending Mail</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("follow_up_send_email", $branch_settings->follow_up_send_email, array("class" => "'form-control'", "placeholder" => "Sending Mail", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div>


        <div class="col-lg-2 padding_top_label">Receiving Email</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("follow_up_recieve_emailids", $branch_settings->follow_up_recieve_emailids, array("class" => "'form-control'", "placeholder" => "Receiving Email", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div>       




    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">SMS Sender ID</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("sms_sender_id", $branch_settings->sms_sender_id, array("class" => "'form-control'", "placeholder" => "SMS Sender ID", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div>  



        <div class="col-lg-2 padding_top_label">SMS User ID</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("sms_user_id", $branch_settings->sms_user_id, array("class" => "'form-control'", "placeholder" => "SMS User ID", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div>  





    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">SMS Password</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("sms_password", $branch_settings->sms_password, array("class" => "'form-control'", "placeholder" => "SMS Password", "maxlength" => "21")) ?>
                <?php
//                
//                     $Course_list = array("Java"=>"Java");
//                     echo form_dropdown("Courses", $Course_list,'',"class='form-control'");
                ?></div>
        </div> 
        <div class="col-lg-2">Add allowed Without Enquiry </div> 
        <div class="col-lg-4">
            <input name="Adm_allowed_without_enq" type="checkbox" <?php  echo ($branch_settings->Adm_allowed_without_enq=1? 'checked' : '')?> value="1" class="form-control bootswitches">
        </div>
    </div>
    <div class="row bottom_gap">   
        <div class="col-lg-2 padding_top_label">SMS Templete</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <textarea rows="5" placeholder="SMS Templete" name="sms_template" class="form-control"><?php echo $branch_settings->sms_template ?></textarea>

            </div>
        </div> 
    </div>
<div class="row bottom_gap">
    <button type="submit" name="save_adm" value="Update" class="btn btn-success btn-md">
        <span class="glyphicon glyphicon-floppy-disk"></span> Save
    </button>
    <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
        <span class="glyphicon glyphicon-refresh"></span> Reset
    </button>
</div>
</div>




<?php form_close(); ?>
<script>
    /* 
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
    //      Form Validation           
    $(document).ready(function () {
        $('#new_addmission_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                StudentName: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Student Name is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Student Name can only consist alphabets'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Student Name must be more 3 characters long'
                        }
                    }
                }, FatherName: {
                    message: 'Father Name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Father Name is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Father Name can only consist alphabets'
                        }
                    }
                }, MotherName: {
                    message: 'Mother Name is not valid',
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Mother Name can only consist alphabets'
                        }
                    }
                }, Email1: {
                    validators: {
                        emailAddress: {
                            message: 'Invalid Email address'
                        }
                    }
                }, Email2: {
                    validators: {
                        emailAddress: {
                            message: 'Invalid Email address'
                        }
                    }
                }, Mobile1: {
                    validators: {
                        notEmpty: {
                            message: 'Mobile is required and can\'t be empty'
                        },
                        regexp: {
                            //regexp: /^[a-zA-Z]+$/,
                            regexp: /^[0-9\,]+$/,
                            message: 'Invalid Mobile number'
                        },
                        stringLength: {
                            min: 10,
                            max: 21,
                            message: 'Mobile no. should be 10 characters long'
                        }
                    }
                }, Phone1: {
                    validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                        regexp: {
                            //regexp: /^[a-zA-Z]+$/,
                            regexp: /^[0-9\,]+$/,
                            message: 'Invalid Phone number'
                        }
                    }
                }, C_city: {
                    validators: {
                        notEmpty: {
                            message: 'City is required and can\'t be empty'
                        }
                    }
                }, C_state: {
                    validators: {
                        notEmpty: {
                            message: 'State and is required and can\'t be empty'
                        }, regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Invalid State name'
                        }
                    }
                }, Quali: {
                    validators: {
                        notEmpty: {
                            message: 'Qualification is required and can\'t be empty'
                        }
                    }
                }, Nationality: {
                    validators: {
                        notEmpty: {
                            message: 'Nationality is required and can\'t be empty'
                        }
                    }
                }, C_village_and_post: {
                    validators: {
                        notEmpty: {
                            message: 'Village and Post is required and can\'t be empty'
                        }
                    }
                },
                DOB: {
                    validators: {
                        notEmpty: {
                            message: 'Date is required and can\'t be empty'
                        },
                        date: {
                            format: 'DD-MM-YYYY'
                        }
                    }
                }, C_pincode: {
                    validators: {
                        notEmpty: {
                            message: 'Pincode is required and can\'t be empty'
                        },
                        regexp: {
                            //regexp: /^[a-zA-Z]+$/,
                            regexp: /^(\d{6})+$/,
                            message: 'Invalid PinCode'
                        }
                    }
                }, P_pincode: {
                    validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                        regexp: {
                            //regexp: /^[a-zA-Z]+$/,
                            regexp: /^(\d{6})+$/,
                            message: 'Invalid PinCode'
                        }
                    }
                }
            }

        });
    });



</script>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>





<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
