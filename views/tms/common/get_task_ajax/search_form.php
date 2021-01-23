<script src="//cdn.ckeditor.com/4.7.2/basic/ckeditor.js"></script>
<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_task_search">
        <h3 class="panel-title toggle_custom">Search <?php echo $task_search_for ?> Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body <?php echo isset($collapse) ? "collapse" : ""; ?>" id="global_task_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='search_task_form'");
            if (isset($replica_btn) && $replica_btn) {
                echo form_hidden("replica_btn", "1", "");
            }
            if (isset($view_change) && $view_change) {
                echo form_hidden("view_change", "1", "");
            }
            ?> 
            <div class="row" id="global_adv_adm_search" > 
                
                
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Category of Task
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("skill_dev_activity", array("-1" => "NA", "1" => "Skill Development", "0" => "Other"), -1, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            No of Pending Sub Task
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("no_of_subTask", $no_of_subTask, -1, "class='form-control'");
                            ?>
                        </div>
                    </div>

                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Repeat
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("does_repeat", array("0" => "Disable", "1" => "Enable", "2" => "N/A"), isset($replica_btn) ? 1 : (isset($filters['does_repeat']) ? $filters['does_repeat'] : 2), "class='form-control'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Result Limit
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_hidden("page", 0);
                            echo form_input("limit", 25, "class='form-control' placeholder='Result at one time in number'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Client
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("client_id[]", $client_list, @$client_id, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Date Wise Searching
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("date_wise", array("0" => "Disable","4"=>"Created On", "1" => "Start Date Wise", "2" => "End Date Wise",'3'=>'Last Modified Date',"5"=>"Closed On"), 0, "class='form-control date-wise'");
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row bottom_gap hidden show_date">
                    <div class="col-lg-12 ">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">From</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control str_date_time" name="start_date" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">To</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control end_date_time" name="end_date" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Name
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_input("tm_name", "", "class='form-control' placeholder='Name of task'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Code
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_input("tm_code", "", "class='form-control' placeholder='code of task'");
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            State
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("state_id", $list_state, @$state_id, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Year - Month
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <?php
                            echo form_dropdown("year", $list_year, @$year, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-md-2 col-sm-6">
                        <?php
                            echo form_dropdown("month", $list_month, @$month, "class='form-control'");
                            ?>
                        </div>
                    </div>

                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Incharge
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("user_id[]", $users_list, isset($incharge) ? $incharge : 0, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Work Status

                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("progress_flag", $work_type_list, isset($filters['progress_flag']) ? $filters['progress_flag'] : IN_PROGRESS, "class='form-control'");
                            ?>
                        </div>

                    </div>
                </div>

                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Pending Bill
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("BillingDone", array("0" => "Billing Not Done", "1" => "Billing Done", "2" => "Both"), isset($filters['BillingDone']) ? $filters['BillingDone'] : 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Type
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("ttm_id[]", $task_type_list, @$ttm_id, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Sort By
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("OrderCol", array("tm.tm_id" => "Task ID", "tm.tm_name" => "Task Name", "tm.Mode_DateTime" => "System Date Time", "tm.end_date" => "End Date", "tm.start_date" => "Start Date", "tm.BillingDone" => "Billing Wise", "tm.client_id" => "Client Wise"), 'tm.Mode_DateTime', "class='form-control chosen-select'");
                            ?>
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Order
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("OrderAscDsc", array("ASC" => "ASC", "DESC" => "DESC"), 'DESC', "class='form-control chosen-select'");
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            From Account
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("billing_acc_id", $billing_account_list, 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Period
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("task_period_id", $period_list, @$task_period_id, "class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>

                  <div class="row bottom_gap">

                    <div class="col-lg-12">

                        <div class="col-lg-2 col-md-2 col-sm-6">

                            Attachments 

                        </div>

                        <div class="col-lg-4">

                            <?php

                            echo form_dropdown("attachment", array("without_attach" => "Without Attachments", "with_attach" => "With Attachments"), 'Without Attachments', "class='form-control chosen-select'");

                            ?>

                        </div>

                         

                    </div>

                </div>

                 





                <div class="row bottom_gap">

                    <div class="col-lg-12 ">

                        <div class="col-lg-4">

                            <button class="btn btn-success" type="button" name="Search" onclick="search_task_data()">
                                <span class="glyphicon glyphicon-search"></span>
                                Search
                            </button>
                            <button class="btn btn-success export_xls hidden" type="button" name="Search" onclick="export_xls()">
                                <span class="glyphicon glyphicon-search"></span>
                                Export Excel
                            </button>

                        </div>
                        <div class="col-lg-8 text-right">
                            <button class="btn btn-info pre_list hidden" type="button" name="Search" onclick="pre_list()">
                                <span class="glyphicon glyphicon-backward"></span>
                                Pre
                            </button>
                            <button class="btn btn-info next_list hidden" type="button" name="Search" onclick="next_list()">
                                <span class="glyphicon glyphicon-forward"></span>
                                Next
                            </button>
                        </div>
                    </div>
                </div>


            </div>
            <?php
            echo form_close();
            ?>
        </div>


        <div class="col-lg-12" id="global_task_search_result">
            <!-- admuiry search ajax will rendered in this div -->         
        </div>
    </div>
</div> 

<!-- Modal -->
<!-- Button trigger modal -->

<div class="form-feed modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 117%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Reassign Task</h4>
            </div>
            <div class="modal-body" id="body_cls">
                <div class="col-lg-12">
                    <form id="MenuAccessForm" method="post" action="<?= base_url() . "sp-admin/m/UpdateMenuAccess/" ?>">
                        <div class="row bottom_gap">

                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Name</div>
                            <div class="col-lg-4 col-md-4 col-sm-8"> 
                                <div class="form-group">
                                    <input type="hidden" class="tstm_id" name="tstm_id" />
                                    <?php echo form_input("tstm_name", "", array("class" => "'form-control task_name'", "placeholder" => "'Name of the Sub Task'", "readonly" => "'readonly'")) ?>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Currently Assigned to</div>
                            <div class="col-lg-4 col-md-4 col-sm-8"> 
                                <div class="form-group">
                                    <input type="hidden" class="old_assigned_to" name="old_assignedto" />
                                    <?php echo form_input("assignedto", "", array("class" => "'form-control assigned_to'", "readonly" => "'readonly'")) ?>
                                </div> 
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Assigning To<span class="Compulsory">*</span></div>
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="form-group">
                                    <select class="form-control whom_instr" name="new_assignedto">
                                        <option value="0">Select User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="SaveChanges(this);">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div id="closeTask" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Remarks to close task</h4>
            </div>
            <div class="modal-body">
                <?php
                echo form_open();
                ?> 
                <div class="row bottom_gap">
                    <div class="col-lg-12"> 
                        <input type="hidden" name="task_id">
                        <textarea class="form-control" name="extra_note"></textarea>
                    </div>
                    <div class="col-md-12">
                        
                        <label>
                            Attachment(If Any):-
                        </label> 
                        <input type="file" name="attach_file">
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <button class="btn btn-success send_closetask_req" type="button">Send close request</button>
                        <button class="btn btn-danger close" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <?php echo form_close();
                ?>
            </div>

        </div>

    </div>
</div>
<div id="Send_req" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Final close this task</h4>
            </div>
            <div class="modal-body">
                <form id="send_close_req">
                    <div class="row">
                        <div class="col-md-12"> <h4 id="reqmsg"></h4></div>
                        <input type="hidden" name="task_id" id="taskid">

                    </div>

                    <div class="col-md-12 rejectclass">
                        <input type="checkbox" name="show_email" id="checked"> Do you want to notify?
                    </div>


                    <div class="row">
                        <div class="col-md-12 hidden" id="show_email">
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

                                </div>

                            </div>
                            <div class="row bottom_gap">

                                <div class="col-md-12 padding_top_label">
                                    Notify to
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group client_noti_email_list">
                                        <?php
//                                            echo form_dropdown("notify_to", array(), 0, "class='form-control client_noti_list'");
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group client_noti_mobiles_list">
                                        <?php
//                                            echo form_dropdown("notify_to", array(), 0, "class='form-control client_noti_list'");
                                        ?>
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
                                            <input type="text" name="email_subject" placeholder="email subject" id="email_subject" class="form-control">
                                            <input type="hidden" name="client_id" id="clientIDHidden" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Extra Email To
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" name="extra_email_to" placeholder="Extra Email To" id="email_subject" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Extra Email CC
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" name="extra_email_cc" placeholder="Extra Email CC" id="email_subject" class="form-control">
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
                                        File Attachment
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group attach_files">

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
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-xs btn-primary" onclick="send_cl_req()">Send</button>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="attachment_html hidden">
    <div class="attachment_link"></div>   

</div>
<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script> 
<script>
                                    var $modal = $('#ajax-modal');
                                    var global_reassign_val = "";

                                    $(function () {
                                        $('#datetimepickeradm6').datetimepicker();
                                        $('#datetimepickeradm7').datetimepicker();
                                        $("#datetimepickeradm6").on("dp.change", function (e) {
                                            $('#datetimepickeradm7').data("DateTimePicker").minDate(e.date);
                                        });
                                        $("#datetimepickeradm7").on("dp.change", function (e) {
                                            $('#datetimepickeradm6').data("DateTimePicker").maxDate(e.date);
                                        });
                                    });

                                    $('.bdatetimepicker').datetimepicker({
                                        format: 'DD-MM-YYYY',
                                        icons: {
                                            time: "fa fa-clock-o",
                                            date: "fa fa-calendar",
                                            up: "fa fa-arrow-up",
                                            down: "fa fa-arrow-down"
                                        }
                                    });
                                    $(".date-wise").change(function () {
                                        if ($(this).val() != 0) {
                                            $(".show_date").removeClass("hidden");
                                        } else {
                                            $(".show_date").addClass("hidden");
                                        }
                                        // console.log($(this).val());
                                    });


                                    function export_csv() {
                                        $("#search_task_form").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_all_fee_records");
                                        $("#search_task_form").submit();
                                    }
                                    function export_xls() {
                                        preloader.on();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>reports/xls_exporter/export_all_data",
                                            data: $("#search_task_form").serialize(),
                                            dataType: "json",
                                            success: function (result) {
                                                if (result.succ) {
                                                    window.open(get_base_url() + "uploads/temp_reports/" + result.file_name, '_blank');
                                                } else {
                                                    swal("Oops!!", "Some Probelm Occured", "error");
                                                }
                                                preloader.off();
                                            }
                                        });
                                    }
                                    function send_cl_req() {

                                        for (instance in CKEDITOR.instances) {
                                            CKEDITOR.instances[instance].updateElement();
                                        }
                                        $.ajax({
                                            type: "GET",
                                            url: get_base_url() + "tms/manage_tasks/final_close_task",
                                            data: $("#send_close_req").serialize(),
                                            dataType: "json",
                                            success: function (result) {
                                                if (result.succ) {

                                                    swal({
                                                        title: "Done!",
                                                        text: result._err_codes,
                                                        type: "success",
                                                        timer: 1000
                                                    });
                                                    $ref.siblings(".gen_bill").removeClass("hide");
                                                } else {
                                                    swal("Oops!..", result._err_codes, "error");
                                                }
                                                preloader.off();
                                            }
                                        });

                                    }

                                    function init_task_depend_fun() {
                                        $(document).unbind(".reopen_task .reopen_sub_task .hide_show_sub_task .reassign_task .send_closetask_req .close_task .final_close_task .close_sub_task");
                                        $(document).unbind(".del_task");
                                        $(".del_task").on("click", function () {
                                            var $_ref = $(this);
                                            swal({
                                                title: "Are you sure you want to delete this task?",
                                                text: "You will not be able to recover this task and related data!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, delete it!",
                                                closeOnConfirm: false
                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    preloader.on();
                                                    $.ajax({
                                                        url: get_base_url() + "tms/manage_tasks/del_task",
                                                        type: "POST",
                                                        dataType: "JSON",
                                                        data: "task_id=" + $_ref.attr("key"),
                                                        success: function (result) {
                                                            if (result.succ) {
                                                                $_ref.parents("table").remove();
                                                                swal({
                                                                    title: "Done!",
                                                                    text: result._err_codes,
                                                                    type: "success",
                                                                    timer: 1000
                                                                });
                                                            } else {
                                                                swal("Oops!", result._err_codes, "error");
                                                            }
                                                            preloader.off();
                                                        }
                                                    });
                                                } else {
                                                    swal("Cancelled", "Your task is safe", "error");
                                                }
                                            });
                                        });
                                        $(".reopen_task").on("click", function () {
                                            var $ref = $(this);
                                            swal({
                                                title: "Are you sure?",
                                                text: "This task will be Re-opened!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, Re-open it!",
                                                closeOnConfirm: false
                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    preloader.on();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: get_base_url() + "tms/manage_tasks/reopen_task",
                                                        data: "task_id=" + $ref.attr("key"),
                                                        dataType: "json",
                                                        success: function (result) {
                                                            preloader.off();
                                                            if (result.succ) {
                                                                swal({
                                                                    title: "Done!",
                                                                    text: result._err_codes,
                                                                    type: "success",
                                                                    timer: 1000
                                                                });
                                                                $ref.parents(".table").css({"background": "rgba(0, 128, 0, 0.32)"});
//                                                setTimeout(function () {
//                                                    location.reload();
//                                                }, 1500);
                                                            } else {
                                                                swal("Oops!..", result._err_codes, "error");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    swal("Cancelled", "No action Taken :)", "error");
                                                }
                                            });

                                        });


                                        $(".reopen_sub_task").on("click", function () {
                                            var $ref = $(this);
                                            swal({
                                                title: "Are you sure?",
                                                text: "This Sub-task and Subsequent Task  will be Re-opened!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, Re-open it!",
                                                closeOnConfirm: false
                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    preloader.on();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: get_base_url() + "tms/manage_tasks/reopen_sub_task",
                                                        data: "task_id=" + $ref.attr("task_id") + "&sub_task_id=" + $ref.attr("key"),
                                                        dataType: "json",
                                                        success: function (result) {
                                                            preloader.off();
                                                            if (result.succ) {
                                                                swal({
                                                                    title: "Done!",
                                                                    text: result._err_codes,
                                                                    type: "success",
                                                                    timer: 1000
                                                                });
                                                                setTimeout(function () {
                                                                    location.reload();
                                                                }, 1500);
                                                            } else {
                                                                swal("Oops!..", result._err_codes, "error");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    swal("Cancelled", "No action Taken :)", "error");
                                                }
                                            });

                                        });

                                        $(".hide_show_sub_task").on("click", function () {
                                            if ($(this).attr("key") == 1) {
                                                $(this).parents(".sub_task_table").find("tr").not(".sub_header").hide();
                                                $(this).parents(".sub_task_table").find(".hide_show_sub_task").html("Show Sub Task Details");
                                                $(this).parents(".sub_task_table").find(".hide_show_sub_task").attr("key", 0);
                                            } else {
                                                $(this).parents(".sub_task_table").find("tr").not(".sub_header").show();
                                                $(this).parents(".sub_task_table").find(".hide_show_sub_task").html("Hide Sub Task Details");
                                                $(this).parents(".sub_task_table").find(".hide_show_sub_task").attr("key", 1);
                                            }
                                        });


                                        $('.reassign_task').on('click', function () {
                                            var $ref = global_reassign_val = $(this);
                                            $('.whom_instr').empty();
                                            preloader.on();
                                            setTimeout(function () {
                                                $.ajax({
                                                    url: get_base_url() + "tms/manage_tasks/reassign_sub_task_data",
                                                    data: "sub_task_id=" + $ref.attr("key"),
                                                    type: 'POST',
                                                    dataType: 'JSON',
                                                    success: function (result) {
                                                        if (result.succ) {
                                                            $(".tstm_id").attr("value", result.data.sub_task_info.tstm_id);
                                                            $(".old_assigned_to").attr("value", result.data.sub_task_info.Emp_ID);
                                                            $(".task_name").attr("value", result.data.sub_task_info.tstm_name);
                                                            $(".assigned_to").attr("value", result.data.sub_task_info.Username);
                                                            $('.whom_instr').html($('<option>').text("Select Type").attr('value', 0));
                                                            $.each(result.data.free_users, function (i, value) {
                                                                var msg = "";
                                                                if (value.free_hours > 0 && value.free_hours != null) {
                                                                    msg = "Busy for " + value.free_hours + " Hours";
                                                                } else if (value.free_hours == null) {
                                                                    msg = "Free for day";
                                                                } else {
                                                                    msg = "Overloaded " + Math.abs(value.free_hours) + " Hours";
                                                                }
                                                                $('.whom_instr').append($('<option>').text(value.Emp_Name + " (" + msg + ")").attr('value', value.Emp_ID));

                                                            });
                                                            $modal.modal();
                                                        } else {
                                                            $('.whom_instr').html($('<option>').text("Select Type").attr('value', 0));
                                                        }
                                                    }
                                                });
                                                preloader.off();
                                            }, 1500);
                                        });

                                        $(".final_close_task").on("click", function () {
                                            var $ref = $(this);
                                            var msg = $ref.attr("req_msg");
                                            var task_id = $ref.attr("key");
                                            var client_id = $ref.attr("client_id");
                                            $("#reqmsg").html("Request Msg:-" + msg);
                                            $("#taskid").val(task_id);


                                            $("#Send_req").modal('show');

                                            $.ajax({
                                                url: "<?php echo base_url() . "tms/manage_task_logs/index" ?>",
                                                type: 'POST',
                                                data: "tm_id=" + $ref.attr("key"),
                                                dataType: 'json',
                                                success: function (data, textStatus, jqXHR) {
                                                    $(".attach_files").html('');
                                                    
                                                    $.each(data.task_details, function (index, taskdetail) {
                                                        $("#clientIDHidden").val(taskdetail.client_id);
                                                        if (taskdetail.attached_files.length != 0) {
                                                            $.each(taskdetail.attached_files, function (i, value) {
                                                                $(".attachment_html").find(".attachment_link").html("<input type='checkbox' name='attach_file[]' value='" + value.link + "'><a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_name + "</a>");
                                                                $(".attach_files").append($(".attachment_html").html());
                                                            });


                                                        }
                                                        $(".client_noti_email_list, .client_noti_mobiles_list").html("");
                                                        $(taskdetail.notify_to).each(function (i, eachnotify_to) {
                                                            $(".client_noti_email_list").append("<div><input type='checkbox' name='notify_to_emails[]' value='" + eachnotify_to.emails + "'>" + eachnotify_to.emails + "</div>");
                                                            $(".client_noti_mobiles_list").append("<div><input type='checkbox' name='notify_to_mobiles[]' value='" + eachnotify_to.mobiles + "'>" + eachnotify_to.mobiles + "</div>");
                                                        });
                                                    });
                                                }
                                            });

                                        });

                                        $(".close_task").on("click", function () {
                                            var $ref = $(this);
                                            $("#closeTask").find("form").find("input[name=task_id]").val($ref.attr("key"));
                                            $("#closeTask").modal("show");
                                        });

                                        $(".send_closetask_req").click(function () {
                                            $ref = $(this);
                                            var formData = new FormData($ref.parents("form")[0]);
                                            $.ajax({
                                                type: "POST",
                                                url: get_base_url() + "tms/manage_tasks/close_task",
                                                data: formData,
                                                dataType: "json",
                                                cache:false,
                                                contentType: false,
                                                processData: false,
                                                success: function (result) {
                                                    if (result.succ) {
                                                        swal({
                                                            title: "Done!",
                                                            text: result._err_codes,
                                                            type: "success",
                                                            timer: 1000
                                                        });
                                                        $("#closeTask").modal("hide");
                                                        //  $ref.parents("table").remove();
                                                    } else {
                                                        swal("Oops!..", result._err_codes, "error");
                                                    }
                                                    preloader.off();
                                                }
                                            });
                                        });


                                        $(".close_sub_task").on("click", function () {
                                            var $ref = $(this);
                                            swal({
                                                title: "Are you sure?",
                                                text: "This Sub-task will be closed!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, Close it!",
                                                closeOnConfirm: false
                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    preloader.on();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: get_base_url() + "tms/manage_tasks/close_sub_task",
                                                        data: "task_id=" + $ref.attr("task_id") + "&sub_task_id=" + $ref.attr("key"),
                                                        dataType: "json",
                                                        success: function (result) {
                                                            preloader.off();
                                                            if (result.succ) {
                                                                $ref.parent().parent().addClass("strikeout");
                                                                $ref.parent().parent().find(".progress_flag").html("Request sent to complete!!");
                                                                swal({
                                                                    title: "Done!",
                                                                    text: result._err_codes,
                                                                    type: "success",
                                                                    timer: 1000
                                                                });
                                                            } else {
                                                                swal("Oops!..", result._err_codes, "error");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    swal("Cancelled", "No action Taken :)", "error");
                                                }
                                            });
                                        });

                                    }

                                    function SaveChanges() {
                                        preloader.on();
                                        if ($(".whom_instr").val() != 0) {
                                            var new_assinged_to = $("#MenuAccessForm").find("select[name=new_assignedto] option:selected").text();
                                            new_assinged_to = new_assinged_to.substring(0, new_assinged_to.indexOf("("));
                                            // console.log($("#MenuAccessForm").serialize());
                                            preloader.on();
                                            $.ajax({
                                                data: $("#MenuAccessForm").serialize(),
                                                url: get_base_url() + "tms/manage_tasks/reassign_sub_task",
                                                dataType: "json",
                                                type: "POST",
                                                success: function (result) {
                                                    $("#MenuAccessForm").trigger('reset');
                                                    $('#ajax-modal').modal('toggle');
                                                    if (result.succ) {
                                                        swal({
                                                            title: "Done!",
                                                            text: result._err_codes,
                                                            type: "success",
                                                            timer: 1000
                                                        });

                                                        // console.log("New assign To"+new_assinged_to);
                                                        global_reassign_val.parent().parent().find(".sub_task_assigned_to").text(new_assinged_to);
                                                        global_reassign_val.parent().parent().find(".sub_task_assigned_to").animate({opacity: 0}, 400, "linear", function () {
                                                            $(this).css({color: 'red'});
                                                            $(this).animate({opacity: 1}, 400);
                                                        });
                                                        //  global_reassign_val.parent().parent().remove();
                                                    } else {
                                                        var msg = display_msg(result._err_codes);
                                                        swal("Oops!..", msg, "error");
                                                    }
                                                    preloader.off();
                                                }
                                            });
                                        } else {
                                            alert("Select a new user to whom you want to assign the task");
                                        }
                                    }

                                    function display_msg($_data) {
                                        var err_msg = "";
                                        $.each($_data, function (i, value) {
                                            err_msg += value + "\n";
                                        });
                                        return err_msg;
                                    }


//                    $(".edit_task").on("click", function () {
//                        redirect
//                        $.ajax({
//                            type: "POST",
//                            url: get_base_url() + "tms/manage_tasks/edit_task",
//                            data: "task_id=" + $(this).attr("key"),
//                            dataType: "json",
//                            success: function (result) {
//                                if (result.succ) {
//                                    redirect_to(result.link);
//                                } else {
//                                    swal("Oops!..", result._err_codes, "error");
//                                }
//                            }
//                        });
//                    });
                                    $(document).on("ready", function () {
                                        $("#collapseExample").addClass("in");
                                        init_task_depend_fun();
                                    });

</script> 
<?php if(isset($_GET['user_id']) && $_GET['user_id']){
    ?>
    <script>
    jQuery(document).ready(function(){
        var currId = '<?php echo $_GET['user_id'];?>';
        jQuery("select[name='user_id[]']").find("option[value='0']").attr("selected",false);
        jQuery("select[name='user_id[]']").find("option[value='"+currId+"']").attr("selected",true);
        var username = jQuery("select[name='user_id[]']").find("option[value='"+currId+"']").text();
        jQuery(".chosen-container-multi .chosen-choices li.search-choice span").text(username);
        search_task_data();
    });
    </script>
    <?php
}
?>
<script>
    function search_task_data() {
        preloader.on();
        $(".pre_list, .next_list").addClass("hidden");
        $(".export_xls").addClass("hidden");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>tms/manage_tasks/get_task_result",
            data: $("#search_task_form").serialize(),
            dataType: "json",
            success: function (search_data) {
                $("#global_task_search_result").html(search_data['html']);
                preloader.off();
                $(".export_xls").removeClass("hidden");
                //  init_del_task();
                init_task_depend_fun();
            }
        });
        $(".pre_list, .next_list").removeClass("hidden");
    }

    function pre_list() {
        var page = $("#search_task_form").find("input[name=page]").val();
        if (page > 0) {
            page = parseInt(page) - 1;
            $("#search_task_form").find("input[name=page]").val(page);
        }
        search_task_data();
    }
    function next_list() {
        var page = $("#search_task_form").find("input[name=page]").val();

        page = parseInt(page) + 1;
        $("#search_task_form").find("input[name=page]").val(page);

        search_task_data();
    }



    $('#checked').click(function () {
        if ($(this).prop("checked") == true) {
            $("#show_email").removeClass('hidden');
            $("#action").val('attach_file_with_notify_task');
        } else if ($(this).prop("checked") == false) {
            $("#show_email").addClass('hidden');
            $("#action").val('attach_file_with_task');
        }
    });
    $(document).ready(function () {
        //   loadtasks();
        CKEDITOR.replace('email_template');
        console.log('working');
//        load_info_level();
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
</script> 