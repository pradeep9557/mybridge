<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="NexGen Innovators Development Team">

        <title>Login Panel | <?php echo SITE_NAME ?></title>
    </head>
    <body class="nexgi_body">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="margin-top: 100px">
                    <img src="<?= base_url() . LOGO ?>" width="100%"/>
                    <div class="shake login-panel panel panel-primary " style="overflow: visible">
                        <div class="panel-heading" style="padding: 0px">
                            <button type="button" class="btn btn-success btn-md" style="width: 100%">
                                <span class="glyphicon glyphicon-lock"></span> Login Panel
                            </button>
                        </div>
                        <div class="panel-body">
                            <?php
                            echo form_open(base_url() . "auth/LoginAuthProcess", "id='Login' role='form'");
                            ?>
                            <!--<form role="form" action="<?= base_url() ?>auth/LoginAuthProcess" method="POST" id="validation_form">-->
                            <fieldset>
                                <div class="padding_top_label form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">
                                            <span class="glyphicon glyphicon-user"></span>
                                        </span>
                                        <input class="form-control" value="<?= $Emp_Code ?>" placeholder="User Name" name="Emp_Code" type="text" autofocus >
                                        <span class="input-group-addon popover_element" id="basic-addon1" data-toggle="popover" data-placement="right" data-content="Registered Emp Code,Email, UserName etc.." title="" data-original-title="User Name">
                                            <span class="glyphicon glyphicon-question-sign"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="padding_top_label form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">
                                            <span class="fa fa-key"></span>
                                        </span>
                                        <input class="form-control" placeholder="Password" name="Password" type="password" value="<?= $Pass ?>">
                                        <span class="input-group-addon popover_element" id="basic-addon1" data-toggle="popover" data-placement="right" data-content="Your Secret Password, which you assigned at registration time.." title="" data-original-title="Password">
                                            <span class="glyphicon glyphicon-question-sign"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="padding_top_label form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">
                                            <span class="fa fa-users"></span>
                                        </span>
                                        <?php
                                        echo form_dropdown("Type", $usertypes, $type, "class='form-control chosen-select' required");
                                        ?>
                                        <span class="input-group-addon popover_element" id="basic-addon1" data-toggle="popover" data-placement="right" data-content="Your user type, as provide from administration." title="" data-original-title="User Type">
                                            <span class="glyphicon glyphicon-question-sign"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->



                                <button type="submit" name="Login" value="Login" class="btn btn-success btn-md" style="width: 100%;margin-bottom: 3px">
                                    <span class="fa fa-unlock"></span> Login
                                </button>
                                <button type="button" data-toggle="modal" data-target="#myModal" name="Login" value="Forget Password" class="btn btn-success btn-md" style="width: 100%;margin-bottom: 3px" >
                                    <span class="glyphicon glyphicon-question-sign"></span> Forget Password
                                </button>
                                <?php
                                if ($error) {
                                    ?>
                                    <button type="button" name="Login" value="Error" class="btn btn-danger btn-md" style="width: 100%;margin-bottom: 3px">
                                        Sorry, Not Authentic !!
                                    </button>
                                <?php } ?> 


                            </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        <!--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Launch demo modal
        </button>-->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="reset-form" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
                        </div>
                        <div class="modal-body">
                            <label for="email">Input Your Valid Email :</label>
                            <input type="email" id="reset_email" name="reset_email" class="form-control" >
                            <h5 id="msg" class="text-danger"></h5>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="reset_password()">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- End of Model -->
    </body>

</html>

<script>
    function reset_password() {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('auth/reset_password'); ?>",
            data: $("#reset-form").serialize(),
            dataType: "json",
            success: function (result) {
                if (result["succ"]) {
                    $("#msg").text("New Password has been sent to your registered email");
                }

                else {
                    $("#msg").text("Sorry this email is not registered");
                }
            }
        });
    }

</script>
<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#Login').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Emp_Code: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username is required and can\'t be empty'
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
        });


    });
</script>
<?php
if ($error) {
    ?>
    <script>
        $(document).ready(function () {
            $(".shake").hide();
            $('.shake').show("shake", {}, 500);
        });</script>
<?php }
?>