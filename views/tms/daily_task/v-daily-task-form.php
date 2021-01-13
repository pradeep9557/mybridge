<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Daily Task From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse" id="collapseExample">   
                    <!--String of Row-->
                    <?php
                    //for normal form
                    //  echo form_open('/dashboard/new_admission',$attributes);
                    echo form_open_multipart(base_url() . 'tms/daily_task/punch_daily_entry', "id='daily_task_form'");
                    ?>
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client List</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("client_id", $client_list, "", "class='form-control chosen-select client_list ajax_react'") ?>
                            </div>
                        </div>
                        
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("tstm_id", $progress_task, "", "class='form-control chosen-select sub_task ajax_react'") ?>
                            </div>
                        </div>
                    </div> <!--End of row-->

                    <div class="row bottom_gap">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                        <?php echo $comment_box; ?>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<!--    <link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>-->
    <script src="<?= CDN1 ?>js/custom_js/daily_task_entry.js" type="text/javascript"></script>
    <script>
        
        $(document).on("ready", function () {
            $("#daily_task_form").on("submit", function (e) {
                e.preventDefault();
                preloader.on();
                $.ajax({
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: $(this).attr("action"),
                    method: "POST",
    //                data: $(this).serialize(),
    //                dataType: "json",
                    success: function (result) {
                        $("button").removeAttr("disabled");
                        if (result.succ) {
                           // console.log("hihi");
                            $("#daily_task_form").trigger("reset");
                           // $("#daily_task_form").find(".sub_task ").removeClass("chosen-select");
                              swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                           
                        } else {
                           // console.log("hibye");
                            sweetAlert("Oops...", result._err_codes, "error");
                        }
                        
                         preloader.off();
                    }
                });
            });
        });
//        $('#daily_task_form').bootstrapValidator({
//            feedbackIcons: {
//                valid: 'glyphicon glyphicon-ok',
//                invalid: 'glyphicon glyphicon-remove',
//                validating: 'glyphicon glyphicon-refresh'
//            },
//            fields: {
//                client_id: {
//                    validators: {
//                        callback: {
//                            message: 'Please choose at least one Client',
//                            callback: function (value, validator, $field) {
//                                // Get the selected options
//                                var options = $(".client_list").val();
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
//                                var options = $(".sub_task").val();
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
//
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