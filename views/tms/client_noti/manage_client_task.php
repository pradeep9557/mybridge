<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<script src="//cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>

<div id="page-wrapper" style="min-height: 345px;">
    <div class="row"> 
        <div class="col-lg-12">
            <h4 class="page-header ">
                Single Task Summery
                <button onclick="print_summery()">Print</button>
            </h4>
            <?php
            if (isset($punched_res)) {
                $this->util_model->show_result_error(!$punched_res['succ'], "Log Punched Successfully");
            }
            ?> 
        </div>  
    </div>
    <?php echo form_open(); ?>
    <div class="row bottom_gap hide_while_printing"> 

        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">Select client</div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("client_id", $client_list, @$client_id, "class='form-control client_id chosen-select' onchange='loadtasks()' id='client_list'");
                    ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">Select Task</div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("tm_id", array(), @$tm_id, "class='form-control task_id chosen-select'");
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                Select Progress
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("p_id", $client_progress_status, 0, "class='form-control chosen-select client_status'");
                    ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                Notify to
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("notify_to", array(), 0, "class='form-control client_noti_list'");
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                Email Subject
            </div>
            <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <input type="text" name="subject_temp" placeholder="email subject" id="email_subject" class="form-control">
                   
                </div>
            </div>
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                Email Template <br><input type="checkbox" name="notify_email"> (Email Notification)
            </div>
            <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <textarea class="form-control" name="email_body" rows="16" id="email_template"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                SMS Template <br><input type="checkbox" name="notify_sms"> (SMS Notification)
            </div>
            <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <textarea class="form-control editor" rows="3" name="sms_body" id="sms_template"></textarea>
                    <span class="wordcount">Word Count 0</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row bottom_gap">
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">

            </div>
            <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <input type="hidden" name="_action" value="notify_action">
                    <button class="btn btn-primary" id="notify_action" type='button'>
                        <span class="glyphicon glyphicon-floppy-save"></span>
                        Notify
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>


<link href="<?php echo base_url() ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/multi_select/prism.js" type="text/javascript"></script>

<script>
                    function loadtasks() {
                        $.ajax({
                            url: "<?php echo base_url() . "tms/manage_task_logs/index" ?>",
                            type: 'POST',
                            data: "client_id=" + $(".client_id").val() + "&action=_load_task",
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                $(".task_id").html("");
                                $.each(data.task_list, function (tm_id, tm_name) {
                                    $(".task_id").append("<option value='" + tm_id + "'>" + tm_name + "</option>");
                                });

                                $(".task_id").val('').trigger("chosen:updated");
                                load_info_level();

                            }
                        });
                    }

                    $(document).ready(function () {
                        loadtasks();
                        CKEDITOR.replace('email_template');
                    });

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
                    //    $(document).ready(function () {
//        $(".task_templete").hide();
//
//        $(".subtask_templete").hide();
//
//
//    });

                    function print_summery() {

                        var printContents = $(".task_result").html();
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                    }
                    $(".editor").keyup(function () {
                        var textArea = $(this).val();
//        console.log(textArea);
                        if (textArea == "") {
                            $(this).siblings(".wordcount").text("Word Count 0");
                        } else {
                            var words = textArea;
                            //= textArea.split(' ');


                            $(this).siblings(".wordcount").text("Word Count " + words.length);
                        }

                    });
                    $(".client_status").on('change', function () {
                        var p_id = $(this).val();
                        $.ajax({
                            type: "post",
                            url: '<?php echo base_url('tms/progress_list/index') ?>',
                            data: {p_id: p_id, _action: 'get_data'},
                            dataType: "json",
                            success: function (data, response) {
                                console.log(data);
//                                $("#email_template").html(data.alldata.template)
                                CKEDITOR.instances['email_template'].setData(data.alldata.template);
                                $("#sms_template").text(data.alldata.sms_template);
                                $("#email_subject").val(data.alldata.subject_temp);
                            }
                        });
                    });

                    function load_info_level() {
                        var client_id = $('#client_list').val();
                        $.ajax({
                            type: "post",
                            url: '<?php echo base_url('tms/progress_list/index') ?>',
                            data: {client_id: client_id, _action: 'get_client_noti_data'},
                            dataType: "json",
                            success: function (data, response) {
                                console.log(data);
                                $(".client_noti_list").empty();
                                $(data.client_noti_list).each(function (index, obj) {
                                    console.log(obj);
                                    $(".client_noti_list").append("<option value=" + obj.noti_mst_id + ">" + obj.emails + "(" + obj.mobiles + ")</option>");
                                });
//                                $("#email_template").html(data.alldata.template)

                            }
                        });
                    }

                    $("#notify_action").on('click', function () {
                        var _this = $(this);
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                        $.ajax({
                            type: "post",
                            url: '<?php echo base_url('tms/client_noti/intraction') ?>',
                            data: _this.parents('form').serialize(),
                            dataType: "json",
                            success: function (data, response) {  
                                if(data.succ){
                                    swal('Noified',data._err_codes,'success');
                                }else{
                                    swal('Error',data._err_codes,'error');
                                }
                            }
                        });
                    });
</script>

