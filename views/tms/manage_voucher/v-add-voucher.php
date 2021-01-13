<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Voucher  Manage</h4>
            <?php
            if (isset($voucher_data)) {
                $voucher_data = isset($voucher_data[0]) ? $voucher_data[0] : NULL;
            }
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom"><?php echo $VoucherForm ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse" id="collapseExample">  
                    <div class="text-danger" id="mymsg"></div>
                    <!--String of Row-->
                    <?php
//for normal form
//  echo form_open('/dashboard/new_admission',$attributes);
//$this->util_model->printr($voucher_data);
                    $v_id = isset($v_id) ? $v_id : 0;
                    echo form_open(base_url() . "tms/manage_voucher/index/$v_id", array("id" => "voucher_form"));
                    ?> 
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Voucher Date</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker task_start_date' >
                                <input type='text' class="form-control" name="vDate" value="<?php echo (isset($voucher_data['vDate']) && $voucher_data['vDate'] != "") ? date(DTF, strtotime($voucher_data['vDate'])) : date(DTF) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                         
                    </div> <!--End of row-->
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client List</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("client_id", $client_list, isset($voucher_data['client_id']) ? $voucher_data['client_id'] : '', "class='form-control chosen-select client_list ajax_react'") ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("tstm_id", $progress_task, isset($voucher_data['tstm_id']) ? $voucher_data['tstm_id'] : '', "class='form-control chosen-select sub_task ajax_react'") ?>
                            </div>
                        </div>
                    </div> <!--End of row-->

                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">User(Amt will allot to this user)</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("Emp_ID", $users, isset($voucher_data['Emp_ID']) ? $voucher_data['Emp_ID'] : $this->util_model->get_uid(), "class='form-control chosen-select  '") ?>
                            </div>
                        </div>


                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Amount</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <input type="text" name="v_amt" value="<?php echo isset($voucher_data['v_amt']) ? $voucher_data['v_amt'] : '' ?>" class="form-control" placeholder="Voucher Amt">
                            </div>
                        </div>



                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">From Place</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("from_place", $from_place, isset($voucher_data['from_place']) ? $voucher_data['from_place'] : 'other', "class='form-control chosen-select  '") ?>
                            </div>
                        </div>


                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">To Place</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("to_place", $to_place, isset($voucher_data['to_place']) ? $voucher_data['to_place'] : 'other', "class='form-control chosen-select  '") ?>
                            </div>
                        </div>



                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row bottom_gap">
                                <div class="col-lg-12 col-md-12 col-sm-12">Description(<span class="text-danger">*</span>)</div>
                            </div> <!--End of row-->
                            <div class="row bottom_gap"> 
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea id="tinymce1" name="remarks" class="col-lg-12" aria-hidden="true"><?php echo isset($voucher_data['remarks']) ? $voucher_data['remarks'] : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row bottom_gap">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row bottom_gap">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-success btn-sm"><?php echo $VoucherFormSubmit ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <?php
            if (isset($voucherList))
                echo $voucherList;
            ?>
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
        var send_ajax = 0;
        $(document).on("ready", function () {
            $("#voucher_form").on("submit", function (e) {
                preloader.on();
                var url = $(this).attr("action");
                e.preventDefault(); 
                send_ajax = 0;
                $(this).find("select.form-control,input.form-control").each(function (index, item) {
                    // console.log($(item).val());
                    if ($(item).val() == "" || $(item).val() == 0)
                    {

                        $("#mymsg").html("Please Fill All Fields..");
                        // alert($(item).attr("name"));
                        send_ajax = 1;
                        //alert("Please Fill all fileds");


                    }

                });


                if (send_ajax === 1)
                {
                    //alert(send_ajax);
                    return 0;
                }

                $("#mymsg").html("");
                $.ajax({
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: url,
                    method: "POST",
                    //                data: $(this).serialize(),
                    //                dataType: "json",
                    success: function (result) {
                        $("button").removeAttr("disabled");
                        if (result.success) {
                            // console.log("hihi");
                            <?php
                             if($v_id==0){
                                 echo '$("#voucher_form").trigger("reset");';
                             }
                            ?>
                            $(".chosen-select").val('').trigger("chosen:updated");
                            // $("#daily_task_form").find(".sub_task ").removeClass("chosen-select");
                            
                              swal({
                                        title: "Done!",
                                        text: result.msg,
                                        type: "success",
                                        timer: 1000
                                    });
                        } else {
                            // console.log("hibye");
                            sweetAlert("Oops...", result.msg, "error");
                        }
                    }
                });
                preloader.off();
            });
        });
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
    if (isset($daily_punched_data))
        echo $daily_punched_data;
    ?> 
</div>
<script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script>
        function t_init(selector) {
            tinymce.init({
                selector: selector,
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                },
                height: 150,
                plugins: [
                    "advlist autolink autosave link  lists charmap spellchecker",
                    "searchreplace wordcount      media ",
                    " contextmenu directionality emoticons  textcolor paste textcolor colorpicker textpattern"
                ],
                toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify  | searchreplace | bullist numlist | outdent indent blockquote | media | forecolor backcolor | subscript superscript | charmap emoticons",
                menubar: false,
                toolbar_items_size: 'small',
                spellchecker_rpc_url: 'spellchecker.php'
            });
        }



        $(document).on("ready", function () {
            var d = new Date();
            d.setDate(d.getDate() - 2);
            $('.bdatetimepicker').datetimepicker({
                minDate: d,
                format: 'DD-MM-YYYY hh:mm A',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });

            t_init("#tinymce1");

            <?php  if($v_id==0){ ?>
            $(".reset_btn").click(function () {
                $(this).parents("form").trigger("reset");
            });
            <?php  } ?>

            $(".mail_to_all").click(function () {
                if ($(this).is(':checked')) {
                    $.each($(".tbl_check_name").find("input[type='checkbox']"), function () {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($(".tbl_check_name").find("input[type='checkbox']"), function () {
                        $(this).prop('checked', false);
                    });
                }
            });
        });


</script>
