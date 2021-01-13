<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="NexGen Innovators Development Team">
        <link href='https://fonts.googleapis.com/css?family=Work+Sans' rel='stylesheet' type='text/css'>
        <title>Login Panel | <?php echo SITE_NAME ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url() ?>css/animate.css" rel="stylesheet" type="text/css"/>
        <!-- only for login -->
        <link href="<?= base_url() ?>css/style_login.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/1.5.0/fingerprint2.min.js"></script>
    </head>
     
        <style>
#slideshow {
    position:relative;
    height:350px;
    z-index:-1;
}
  
#slideshow IMG {
    position:absolute;
    top:0;
    left:0;
    z-index:8;
    opacity:0.0;
}
  
#slideshow IMG.active {
    z-index:10;
    opacity:1.0;
}
  
#slideshow IMG.last-active {
    z-index:9;
}
  
#slideshow img {
    /* Set rules to fill background */
    min-height: 100%;
    min-width: 1024px;
  
    /* Set up proportionate scaling */
    width: 100%;
    height: auto;
  
    /* Set up positioning */
    position: fixed;
    top: 0;
    left: 0;
}
  
@media screen and (max-width: 1024px){
    img.bg {
    left: 50%;
    margin-left: -512px;
}
}
 

#content {
    width: 920px;
    margin: 0 auto;
    background: rgba(11,11,11, 0.5);
    padding: 20px;
}
</style> 
    
    <body>
        <div id="slideshow">
            <?php //print_r($imgLibrary);?>
        <img class="active" src="<?php echo base_url()?>login_image_library/<?php echo $imgLibrary[0]['filename']; ?>" alt="Slideshow Image 1" /> 
    </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-3 col-md-9 col-md-offset-2 login_form_container">
                    <div class="col-lg-5 col-md-6 col-sm-6 hidden-xs company_info">
                        <?php
                        //die($this->util_model->printr($login_page_alt));
                        if (isset($login_page_alt) && $login_page_alt['login_page'] != 1) {
                            ?>
                            <!--                        <h1 style="background: red;color:white">
                                                        Testing Mode On . please don't work
                                                    </h1>-->
                            <h1 style="color:white;margin-top: 50px;" class="text-center"><?php
                                echo SITE_NAME . "<br><hr>" . TAGLINE;
                                ?></h1>
                        <?php } ?>
                        <?php
                        //die($this->util_model->printr($login_page_alt));
                        if (isset($login_page_alt) && $login_page_alt['login_page'] == 1) {
                            ?>
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
                        <?php }
                        ?>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 login_panel">
                        <?php
                        echo form_open(base_url() . "auth/LoginAuthProcess", "id='Login_form' role='form'");
                        ?>

                        <div class="col-md-12 margin_top_20px margin_bottom_20px">
                            <h5 class="text_center heading_text">Sign In to your account</h5>
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <div class="form-group">
                                <input autocomplete="off" class="form-control user_class" placeholder="Username" name="Emp_Code" type="text">
                            </div>
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <div class="form-group">
                                <input autocomplete="off" class="form-control pass_class" placeholder="Password" name="Password" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="system_code" id="syscode">
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <?php
                            // echo form_dropdown("Type", $usertypes, $type, "class='form-control u_type_class text_center custom_drop' required");
                            ?>
                        </div>
                        <div class="col-md-12 margin_bottom_20px">
                            <div class="col-md-6 padding_0px login_btn_holder">
                                <button type="submit" name="Login" value="Login" class="login_btn btn btn-md" style="width: 100%;margin-bottom: 3px">
                                    Sign in
                                </button>
                            </div>
                            <div class="col-md-6">
                                <h6 class="cursor_pointer text_center forgot_pass">Forgot Password?</h6>
                            </div>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 forgot_panel hide">
                        <form id="reset-form" >
                            <div class="col-md-12 margin_top_20px margin_bottom_20px">
                                <h5 class="text_center heading_text">
                                    Reset Password
                                    <span class="close_reset" style="float: right">X</span>
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
//    $("#reset-form").on("submit", function (e) {
//        var $ref = $(this);
//        e.preventDefault();
//        $.ajax({
//            type: "POST",
//            url: "<?php echo base_url('auth/reset_password'); ?>",
//            data: $("#reset-form").serialize(),
//            dataType: "json",
//            success: function (result) {
//                sweetAlert("Oops...", result._err_codes, "error");
//                $ref.trigger("reset");
//            }
//        });
//    });

//    $("#Login_form").on("submit", function (e) {
//        e.preventDefault();
//        $.ajax({
//            type: "POST",
//            url: $(this).attr("action"),
//            data: $(this).serialize(),
//            dataType: "json",
//            success: function (result) {
//                if (result.succ) {
//                    redirect_to(get_base_url() + result.path);
//                } else {
//                    sweetAlert("Oops...", result._err_codes, "error");
//                }
//            }
//        });
//    });
</script>
<script type="text/javascript">
    function sys_code()
    {
        new Fingerprint2().get(function (result, components) {
            document.getElementById("syscode").value = result;
            //console.log(components);
        });
    }
</script>
<script>

    //      Form Validation
    $(document).ready(function () {
        // generate system code
        sys_code();

        $('#Login_form').bootstrapValidator({feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Emp_Code: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {message: 'The username is required and can\'t be empty'
                        }
                    }
                }, Password: {
                    validators: {
                        notEmpty: {
                            message: 'The Password is required and can\'t be empty'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();

            // generate system code
            //sys_code();        

            preloader.on();
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: $(this).serialize(),
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        redirect_to(get_base_url() + result.path);
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
                    } else {
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
        $(".close_reset").on("click", function () {
            $(".login_panel").removeClass("animated bounceOut");
            $(".forgot_panel").addClass("animated bounceOut");
            $(".forgot_panel").addClass("hide");
            $(".login_panel").removeClass("hide");
            $(".login_panel").addClass("animated bounceIn");
        });
    });</script>
<?php
if ($error) {
    ?>
    <script>
        $(document).ready(function () {
            $(".shake").hide();
            $('.shake').show("shake", {}, 500);
        });
    </script>
<?php }
?>