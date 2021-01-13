<?php
//die($this->util_model->printr($email));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="NexGen Innovators Development Team">
        <link href='https://fonts.googleapis.com/css?family=Work+Sans' rel='stylesheet' type='text/css'>
        <title>Password Reset Panel | <?php echo SITE_NAME ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url() ?>css/animate.css" rel="stylesheet" type="text/css"/>
        <!-- only for login -->
        <link href="<?= base_url() ?>css/style_login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="nexgi_body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-3 col-md-9 col-md-offset-2 login_form_container">
                    <div class="col-lg-5 col-md-6 col-sm-6 hidden-xs company_info">

                        <div class="col-md-12 margin_top_20px margin_bottom_10px">
                            <img src="<?= base_url() . LOGO ?>" width="100%"/>
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <h5 class="text_center">Collect. Visualize. Monitor</h5>
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <h5 class="multi-branch">Muti branch management</h5>
                            <h5 class="manage-enquiries">Manage Enquires</h5>
                            <h5 class="reporting">Reporting and Dashboards</h5>
                            <h5 class="fee-tracking">Fee Tracking</h5>
                        </div>

                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 login_panel">
                        <?php if (isset($token_mismatch) && $token_mismatch) { ?>
                            <div class="col-md-12 margin_top_20px margin_bottom_20px">
                                <h5 class="text_center heading_text">Invalid Token Passed</h5>
                            </div>
                            <img class="sad_face_art" src="<?php echo base_url() ?>img/default_pic_and_sign/sad_face.png" alt=""/>
                        <?php } else {
                            ?>
                            <?php
                            echo form_open(base_url() . "auth/reset_pass", "id='reset_pass_form' role='form'");
                            ?>
                            <div class="col-md-12 margin_top_20px margin_bottom_20px">
                                <h5 class="text_center heading_text">Change Password</h5>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">
                                <div class="form-group">
                                    <input readonly="readonly" value="<?php echo (isset($email) && $email != "") ? $email : "" ?>" autocomplete="off" class="form-control user_class" placeholder="Email" name="P_Email" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">
                                <div class="form-group">
                                    <input autocomplete="off" class="form-control pass_class" placeholder="Password" name="Emp_Pass" type="password">
                                </div>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">
                                <?php
                                // echo form_dropdown("Type", $usertypes, $type, "class='form-control u_type_class text_center custom_drop' required");
                                ?>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">
                                <div class="col-md-6 padding_0px login_btn_holder">
                                    <button type="submit" name="Login" class="login_btn btn btn-md" style="width: 100%;margin-bottom: 3px">
                                        Reset Password
                                    </button>
                                </div>
                                <div class="col-md-6 hidden">
                                    <h6 class="cursor_pointer text_center forgot_pass">Forgot Password?</h6>
                                </div>
                            </div>
                            <?php
                            echo form_close();
                        }
                        ?>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 forgot_panel hide">
                        <form id="reset-form" >
                            <div class="col-md-12 margin_top_20px margin_bottom_20px">
                                <h5 class="text_center heading_text">
                                    Reset Password
                                    <span class="close_reset hidden" style="float: right">X</span>
                                </h5>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">
                                <div class="form-group">
                                    <input autocomplete="off" class="form-control email_class" placeholder="Enter your Email" name="reset_email" type="text">
                                </div>
                            </div>
                            <div class="col-md-12 margin_bottom_20px">

                                <button type="submit" name="Login" value="Login" class="reset_btn btn btn-md">
                                    Reset
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#reset_pass_form').bootstrapValidator({feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Emp_Pass: {
                    validators: {
                        notEmpty: {
                            message: 'The Password is required and can\'t be empty'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            preloader.on();
            $.ajax({
                type: "POST",
                url: get_base_url() + "auth/save_new_pass",
                data: $("#reset_pass_form").serialize() + "&time_limit=" + "<?php echo isset($time_limit) ? $time_limit : "" ?>" + "&token=" + "<?php echo isset($token) ? $token : "" ?>",
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        sweetAlert("Congrats!!", result._err_codes, "success");
                        redirect_to(get_base_url());
                    } else {
                        sweetAlert("Oops...", result._err_codes, "error");
                    }
                }
            });
            preloader.off();
        });
        $('#reset-form').bootstrapValidator({feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                reset_email: {
                    message: 'The email is not valid',
                    validators: {
                        notEmpty: {message: 'The email is required and can\'t be empty'
                        }, emailAddress: {
                            message: 'The value is not a valid email address'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            preloader.on();
            var $ref = $("#reset-form");
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('auth/reset_password'); ?>",
                data: $("#reset-form").serialize(),
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        $ref.trigger("reset");
                        swal("Congratulations!..", result._err_codes, "success");
                    }
                    else {
                        sweetAlert("Oops...", result._err_codes, "error");
                    }

                }
            });
            preloader.off();
        });
        $(".forgot_pass").on("click", function () {
            $(".forgot_panel").removeClass("animated bounceOut");
            $(".login_panel").addClass("animated bounceOut");
            $(".login_panel").addClass("hide");
            $(".forgot_panel").removeClass("hide");
            $(".forgot_panel").addClass("animated bounceIn");
        });
//        $(".close_reset").on("click", function () {
//            $(".login_panel").removeClass("animated bounceOut");
//            $(".forgot_panel").addClass("animated bounceOut");
//            $(".forgot_panel").addClass("hide");
//            $(".login_panel").removeClass("hide");
//            $(".login_panel").addClass("animated bounceIn");
//        });
<?php if (isset($Invaild_gateway) && $Invaild_gateway) { ?>

            $(".forgot_pass").trigger("click");

<?php }
?>
    });
</script>