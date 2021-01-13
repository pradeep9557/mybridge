<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Unassigned Task</h4>
            <?php
            // print_r($this->session->userdata('IBMS_USER_TYPE'));
            //die($this->util_model->printr($unassign_form_data)); 
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New Task From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_sub_task/save_unassign_tasks', "id='unassign_task_form' class='check_valid'");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Select Client<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">


                    <div class="form-group">
                        <?php echo form_dropdown("client", $unassign_form_data, "", "class='form-control chosen-select ut_client'  ") ?>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Pending Sub-Tasks<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="form-group">
                        <?php echo form_dropdown("tstm_id", array("0" => "Select Client First"), "", "class='form-control pend_sub_task'  ", "id='tstm_id'") ?>
                    </div>

                </div><!-- /input-group -->               

            </div> <!--End of row-->

            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">At whom Instruction<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="form-group">
<!--                        remove + operator -->
                        <?php
                        //$whom_instruction
                        
                        echo form_dropdown("whom_instruction",  $whom_instruction, "" , "class='form-control whom_instruct '  ", "id='whom_instruct'") ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">


                <?php $this->load->view("tms/common/comment_box"); ?>
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-12">

                    <!--                    <button type="button" value="Save" class="btn btn-success btn-md action">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Save
                                        </button>-->

                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>

    <link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
    <link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
    <script>
        $(".ut_client").change(function () {
            if ($(this).val() != 0) {
                preloader.on();
                $.ajax({
                    url: "<?php echo base_url() . 'tms/manage_sub_task/get_pending_tasks' ?>",
                    method: "POST",
                    data: "Emp_ID=" + $(this).val(),
                    dataType: "json",
                    success: function (result) {
                        $('.pend_sub_task').empty();
                        if (result.succ) {
                            // $('.pend_sub_task').html($('<input>').attr('value', 0));
                            $('.pend_sub_task').html($('<option>').text("Select Sub Task").attr('value', 0));
                            $.each(result.data, function (i, value) {
                                $('.pend_sub_task').append($('<option>').text(value.tstm_name + '(' + value.tm_name + ')(' + value.client_name + ')').attr('value', value.tstm_id));
                            });
                        } else {
                            $('.pend_sub_task').html($('<option>').text("Select Type").attr('value', 0));
                        }
                        preloader.off();
                    }
                });
            }
        });

        //    $(document).ready(function () {
        //        $(".chosen-select").chosen();
        //    });
//        $(".pend_sub_task").change(function () {
//            //  console.log($(this).val());
//            $.ajax({
//                url: "<?php echo base_url() . 'tms/manage_sub_task/whom_instruction' ?>",
//                method: "POST",
//                data: "tstm_id=" + $(this).val(),
//                dataType: "json",
//                success: function (result) {
//                    $('.whom_instruct').empty();
//                    if (result.succ) {
//                        // $('.pend_sub_task').html($('<input>').attr('value', 0));
//                        $('.whom_instruct').html($('<option>').text("Select Instructed By").attr('value', 0));
//                        $('.tstm_id_val').html($('<input>').attr('value', result.data_whom.Emp_ID));
//                        $.each(result.data_whom, function (i, value) {
//                            $('.whom_instruct').append($('<option>').text(value.Emp_Name).attr('value', value.Emp_ID));
//                        });
//                    } else {
//                        $('.whom_instruct').html($('<option>').text("Select Instructed By").attr('value', 0));
//                    }
//                }
//            });
//
//        });

        $("#unassign_task_form").on("submit", function (e) {
            var $ref = $(this);
            preloader.on();
            e.preventDefault();
            $.ajax({
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                url: $(this).attr("action"),
                method: "POST",
//                url: $ref.attr("action"),
//                        method: "POST",
//                        data: $ref.serialize(),
//                        dataType: "json",
                        success: function (result) {
                            if (result.succ) {
                                $ref.trigger('reset');
                                swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                                setTimeout(function () {
//                            location.reload();
                                }, 2000);
                            } else {
                                $("button").removeAttr("disabled");
                                sweetAlert("Oops...", result._err_codes, "error");
                            }
                            preloader.off();
                        }
            });
        });

//        $('.check_valid').bootstrapValidator({
//            feedbackIcons: {
//                valid: 'glyphicon glyphicon-ok',
//                invalid: 'glyphicon glyphicon-remove',
//                validating: 'glyphicon glyphicon-refresh'
//            },
//            fields: {
//                client: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose at least one Client',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".ut_client").val();
//                                return (options != null && options != 0);
//                            }
//                        }
//                    }
//                },
//                tstm_id: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose at least one Sub-Task',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".pend_sub_task").val();
//                                return (options != null && options != 0);
//                            }
//                        }
//                    }
//                },
//                whom_instruction: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose whom instruction (Instruted By)',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".whom_instruct").val();
//                                return (options != null && options != 0);
//                            }
//                        }
//                    }
//                },
//                progress_flag: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose the progress flag',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".pg_flag").val();
//                                return (options != null && options != 0);
//                            }
//                        }
//                    }
//                },
//                completed: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose the progress status of Task',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".completed_val").val();
//                                return (options != null);
//                            }
//                        }
//                    }
//                },
//                efforts: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Efforts Field is required and can\'t be empty'
//                        },
//                        regexp: {
//                            regexp: /^[0-9]+$/,
//                            message: 'Efforts can only consist consist given numerals 0-9'
//                        },
//                        stringLength: {
//                            min: 1,
//                            max: 3,
//                            message: 'Maximum 3 digits alllowed in Efforts'
//                        }
//                    }
//                }
//            }
//
//        });

    </script>
    <link href="<?= CDN1 ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>js/multi_select/prism.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

    </script>
    <?php
    //$Curr_Obj = & get_instance();
    //$Curr_Obj->fetch_recent_unassign_entry();
    ?>
</div>

