<!--Tag input files-->
<link href="<?= base_url() ?>css/taginput/jquery.tagsinput.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.min.js" type="text/javascript"></script>
<!--End of tag input files-->


<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">New Employee</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    if (isset($employee_data) && empty($employee_data)) {
        ?>
        <div class="row">
            <button type="button" class="btn btn-danger btn-md">Sorry Employee Doesn't exits !!
                <span class="glyphicon glyphicon-trash"></span> 
            </button>
        </div>
        <?php
    } else {
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                <h3 class="panel-title toggle_custom">New Employee From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <div class="panel-body collapse" id="collapseExample">   
                <?php
                //for normal form
                //  echo form_open('/dashboard/new_admission',$attributes);
                echo form_open_multipart(base_url() . 'employee/update_user_data', "id='validation_form'");
                ?>

                <div class="row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Your Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("Emp_Name", isset($employee_data->Emp_Name) ? $employee_data->Emp_Name : "", array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Name'")) ?>
                        </div>
                    </div>
                    <!--                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Image</div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">-->
                    <div class="form-group">
                        <div class="col-lg-2">Profile Pic<br>
                            <h6>Choose File to update/change</h6>
                        </div> 
                        <div class="col-lg-4">
                            <img src="<?= base_url() . ($employee_data->Pro_Pic != "" && file_exists(EMP_UPLOAD_PATH . $employee_data->Pro_Pic) ? (EMP_UPLOAD_PATH . $employee_data->Pro_Pic) : DEFAULT_EMP_PIC) ?>" class="img-responsive thumbnail"/>
                            <?php
                            echo form_upload("Pro_Pic", "", "class='form-control change_pic'");
                            ?> 
                        </div>
                    </div>
                    <?php //echo form_upload("Pro_Pic", "", "class='form-control'");  ?>         
                    <!--                </div>
                                </div>-->
                </div> <!--End of row-->      
                <div class="row">
                    <div class="col-lg-1">
                        <!--<div class="input-group">-->
                        <?php echo form_submit("update_user_data", "Update Data", array("class" => "'btn btn-success'")) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    $('#validation_form').on("submit", (function (e) {
        e.preventDefault();
        var action_url = $(this).attr("action");
        preloader.on();
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $(".pre_loader").show();
                        $(".pre_loader").find(".progress-bar").css({"width": percentComplete + '%'});
                        $(".pre_loader").find(".sr-only-focusable").html(percentComplete + '% Complete (success)');
                        if (percentComplete === 100) {
                            $(".pre_loader").hide();
                            $(".pre_loader").find(".progress-bar").css({"width": "60%"});
                            $(".pre_loader").find(".sr-only-focusable").html("60% Complete (success)");
                        }

                    }
                }, false);
                return xhr;
            },
            url: action_url,
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result.succ) {
                    swal("Congrats!!", result._err_codes, "success");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    swal("Oops!!", result._err_codes, "errro");
                }
            }
        });
    }));</script>

</script>
