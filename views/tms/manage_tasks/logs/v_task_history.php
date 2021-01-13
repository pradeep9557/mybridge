<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
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
    <div class="row bottom_gap hide_while_printing"> 
        <?php echo form_open(); ?>
        <div class="col-lg-12"> 
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">Select client</div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("client_id", $client_list, '', "class='form-control client_id chosen-select' onchange='loadtasks()'");
                    ?>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">Select Task </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("tm_id", $task_drowndown, $tm_id, "class='form-control task_id chosen-select' onchange='loadTaskHistory()'");
                    ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>

    <div class="col-md-9">
        <div class="task_result">

        </div>

    </div>
    <div class="task_templete hidden">
        <div class="panel panel-default" > 
            <div class="panel-heading"> 
                <h4 class="panel-title"> 
                    Task Name
                </h4> 
                <h4 class="pull-right status margintop15">status</h4>
            </div> 
            <div class="panel-body">
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label> Client:</label>
                        <p class="client"></p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>  Task Timeline:</label>
                        <p class="task_timeline"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>Task Efforts:</label>
                        <p class="taskEffortRatio"></p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label> Incharge:</label>
                        <p class="incharge"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>   Remarks:</label>
                        <p class="remark"></p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>  Closing remarks (If any):</label>
                        <p class="closing_remark"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>   Last Modified on:</label>
                        <p class="last_modified"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>   Billing Status:</label>
                        <p class="billing_status"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="fl">
                        <span class="attachments">No Files in this Task</span>
                    </div>
                    <div class="attach_files">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subtask_templete hidden">
        <div class="panel panel-default bottom_gap" > 
            <div class="panel-heading"> 
                <h4 class="panel-title"> 
                </h4> 
                <h4 class="pull-right status margintop15">status</h4>
            </div> 
            <div class="panel-body">

                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>   Assigned To:</label>
                        <p class="Assigned"></p>
                    </div>
                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>  Sub task timeline:</label>
                        <p class="stasktimeline"></p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>  Job:</label>
                        <p class="job"></p>
                    </div>

                </div>
                <div class="col-md-12 bottom_gap">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label>  Working hours (Assigned/Spent):</label>
                        <p class="tstm_wrkinghours_ratio"></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12"><h4>Work Done</h4></div></div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <table class="display table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Date</th>
                                    <th>Time </th>
                                    <th>Efforts </th>
                                    <th>Comment</th>
                                    <th>By</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="attachment_html hidden">
    <div class="cb"></div>
    <div class="fl">
        <span class="attachment_link">

        </span>
        <div class="fnt999 time_attach"></div>
    </div>
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

                            }
                        });
                    }
                    function loadTaskHistory() {
                        $.ajax({
                            url: "<?php echo base_url() . "tms/manage_task_logs/index" ?>",
                            type: 'POST',
                            data: "tm_id=" + $(".task_id").val(),
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                var main_sub_task_coutner = 1;
                                $(".task_result").html("");
                                //console.log(data);
                                var totalgivetime = 0;
                                var totalspendtime = 0;
                                $.each(data.task_details, function (index, taskdetail) {
                                    $(".task_templete").find(".panel-title").html(taskdetail.tm_name);
                                    $(".task_templete").find(".status").html(taskdetail.progress_flag_name);
                                    $(".task_templete").find(".client").html("<a href='" + get_base_url() + "my_sub_tasks?client_id=" + taskdetail.client_id + "'>" + taskdetail.client_name + "</a>");
                                    $(".task_templete").find(".task_timeline").html(taskdetail.start_date + ' - ' + taskdetail.end_date);
                                    $(".task_templete").find(".last_modified").html(taskdetail.Mode_DateTime);
                                    if (taskdetail.BillingDone) {
                                        $(".task_templete").find(".billing_status").html("Billing Done with Bill No. <a href='" + get_base_url() + "tms/manage_bills/print_bill/" + taskdetail.bill_mst_id + "' target='_blank'>" + taskdetail.bill_no + " (with amount : " + taskdetail.bill_amt + ")</a> with account " + taskdetail.billedFrom);
                                    } else {
                                        $(".task_templete").find(".billing_status").html('Billing Pending');
                                    }

                                    $(".attach_files").empty();
                                    console.log(taskdetail.attached_files);
                                    if (taskdetail.attached_files.length <= 0) {
                                        $(".attachments").html("Files in this Task");
                                    } else {
                                        console.log("coming here");
                                        $.each(taskdetail.attached_files, function (i, value) {
                                            console.log("index "+i);
                                            console.log(value);
                                            $(".attachment_html").find(".attachment_link").html("<a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_name + "</a>");
                                            $(".attachment_html").find(".time_attach").html(value.date);
                                            $(".attach_files").append($(".attachment_html").html());
                                        });
                                    }
                                    $(".task_templete").find(".incharge").html(taskdetail.Incharge_name);
                                    $(".task_templete").find(".remark").html(taskdetail.extra_note);
                                    $(".task_templete").find(".closing_remark").html(taskdetail.close_task_note);
                                    $(".task_result").append($(".task_templete").html());
                                    $.each(taskdetail['sub_task_data'], function (index, eachsubtask) {

                                        // doing blank to comment section
                                        $(".subtask_templete").find(".display > tbody").html("");
                                        $(".subtask_templete").find(".panel-title").html("<a href='" + get_base_url() + "tms/manage_sub_task/taskSingleView/" + eachsubtask.tstm_id + "'>" + "Sub task&nbsp;&nbsp;" + main_sub_task_coutner++ + "</a>");
                                        $(".subtask_templete").find(".status").html(eachsubtask.progress_sub_task);
                                        $(".subtask_templete").find(".Assigned").html(eachsubtask.Emp_Name);
                                        $(".subtask_templete").find(".stasktimeline").html(taskdetail.start_date + ' - ' + taskdetail.end_date);
//                        $(".subtask_templete").find(".edate").html();
                                        $(".subtask_templete").find(".job").html(eachsubtask.tstm_name);
                                        $(".subtask_templete").find(".tstm_wrkinghours_ratio").html(check_null(eachsubtask.tstm_efforts) + "/" + check_null(eachsubtask.total_efforts));
                                        totalspendtime = totalspendtime + eval(check_null(eachsubtask.total_efforts));
                                        //                        console.log(totalspendtime);

                                        totalgivetime = check_null(totalgivetime) + eval((check_null(eachsubtask.tstm_efforts)));
                                        //                        console.log(totalgivetime);



//                        console.log("this is commmnt");
//                        console.log(eachsubtask['comments']);

                                        $.each(eachsubtask['comments'], function (index, com) {
                                            //                            console.log("hi comment for "+eachsubtask.tstm_name);
                                            //                            console.log(com);
                                            s_no = 1;
                                            var starttime = com.Add_DateTime.split(" ");
                                            $(".subtask_templete").find(".display > tbody").append(
                                                    "<tr>\n\
                                                        <td>" + (s_no++) + "</td>\n\
                                                    <td>" + starttime[0] + "</td>\n\
                                                    <td>" + starttime[1] + "</td><td>" + check_null(com.efforts) + "</td><td>" + com.comment + "</td><td>" + com.Emp_Name + "< /td></tr>");
                                        });
                                        $(".task_result").append($(".subtask_templete").html());
                                    });
                                    $(".task_result").find(".taskEffortRatio").html(check_null(totalgivetime) + '/' + check_null(totalspendtime));
                                    //                    $(".task_result").find(".ttime").html(totalgivetime);

                                });
                            }
                        });
                    }


                    function check_null(val) {
                        return val != null ? val : 0;
                    }

                    $(document).ready(function () {
                        loadTaskHistory();
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
                    $(".task_id").on('change', function () {
                        $(".task_templete").show();
                        $(".subtask_templete").show();
                    });
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
</script>
