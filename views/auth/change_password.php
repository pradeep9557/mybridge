<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Change Your Password !!</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //echo form_open('/dashboard/new_admission',$attributes);
    echo form_open(base_url() . 'employee/update_password_process', "id='change_password_form'");
    ?>

    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">Old Password</div>
        <div class="col-lg-4">
              <div class="form-group">
            <?php echo form_password("Old_Pass", "", array("class" => "'form-control password_toogle'", "placeholder" => "'Old Password'")) ?>
              </div>
        </div>
        <div class="col-lg-2 padding_top_label">New Password</div>
        <div class="col-lg-4">
              <div class="form-group">
            <?php echo form_password("New_Password", "", array("class" => "'form-control password_toogle'", "placeholder" => "'New Password'")) ?>	
              </div>
        </div>
    </div> <!--End of row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Confirm Password</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_password("confirm_Password", "", array("class" => "'form-control password_toogle'", "placeholder" => "'New Password'")) ?>	
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-1">
            <?php echo form_submit("Update_Password", "Save", array("class" => "'btn btn-success'")) ?>
        </div>
        <div class="col-lg-1">
            <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-success'")) ?>
        </div>

    </div>

</form>
</div>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/js/show_password/bootstrap-show-password.js" type="text/javascript"></script>
<script>
    $('.password_toogle').password();
    $(document).ready(function () {
        $('#change_password_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Old_Pass: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Password is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Password must be more 3-25 characters long'
                        },
                    }
                }, New_Password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'New Password is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'New Password must be more 3-25 characters long'
                        }, different: {
                            field: 'Old_Pass',
                            message: 'The New Password and old password can\'t be the same'
                        }, identical: {
                            field: 'confirm_Password',
                            message: 'The Confirm password and password must be the same'
                        }
                    }
                }, confirm_Password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Confirm Password is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Confirm Password must be more 3-25 characters long'
                        }, identical: {
                            field: 'New_Password',
                            message: 'The password and its confirm must be the same'
                        }
                    }
                }
            }

        });
    });
</script>

