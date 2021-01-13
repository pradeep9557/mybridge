<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <!--<h4 class="page-header ">Free Users</h4>-->
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Free Users<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <style>
            div.freeTime
            {
                width: 100px;
                height: 10px;
                background: #fc1b1b;    
            }
            div.allotedTime
            {
                float: left;
                width: 89%;
                background: #3faf3f;
                height: 10px;
            }
            div.sybmols
            {

            }
            div.sybmols label 
            {

            }
            div.sybmols label span
            {

            }

            .get_wrk_details:hover, .re_assignWrk:hover{
                text-decoration: underline;
            }
        </style>
        <div class="panel-body collapse" id="collapseExample"> 

            <div>

                <form>

                    <div class="row bottom_gap">
                        <div class="col-lg-12">
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                            <div class="col-lg-3 col-md-4 col-sm-8">
                                <div class="input-group date bdatetimepicker task_start_date">
                                    <input type="text" class="form-control" name="startDate" value="<?php echo $startDate ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End Date</div>
                            <div class="col-lg-3 col-md-4 col-sm-8">
                                <div class="input-group date bdatetimepicker task_start_date">
                                    <input type="text" class="form-control" name="endDate" value="<?php echo $endDate ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-8">
                                <div class="input-group date  task_start_date">
                                    <button type="submit" class="btn btn-sm btn-success" >Filter</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <span class="box"> FR -> Free (In hours)</span>
                <span class="box"> OV -> Overload (In hours)</span>
                <span class="box"> NT -> No Task Assign (In hours)</span>
                <span class="box"> WD -> Work Done (In hours)</span>
            </div>
            <table class="table table-responsive">


                <thead>
                    <tr>
                        <th>Employee</th>
                        <?php
                        foreach ($dates as $k => $date) {
                            ?>
                            <th class="" ><?php echo date("M-d", strtotime($date)); ?> </th>
                            <?php
                        };
                        ?> 
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($free_users as $user) {
                        ?>
                        <tr class="freeUsers">
                            <td class="text-capitalize" > <?php echo $user['Emp_Name'] ?></td>
                            <?php
                            foreach ($dates as $k => $date) {
                                ?>
                                <td   id="<?php echo $user['Emp_ID'] . $date; ?>" empID="<?php echo $user['Emp_ID']; ?>" Date="<?php echo $date ?>" class="cursor_pointer" title="Click to re-sechdule work" ><span class="fa fa-spin fa-refresh"></span></td>
                                <?php
                            }
                            ?>
                        </tr>

                        <?php
                    }
                    ?>




                </tbody>
            </table>

        </div>        
    </div>
</div>
<link href="<?php echo base_url(); ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/multi_select/prism.js" type="text/javascript"></script>

<script>

    var free = "F";

<?php
foreach ($dates as $k => $date) {
    ?>
        $(function () {
            var date = "<?php echo $date ?>";
            preloader.on();
            $.ajax({
                url: "<?php echo base_url() . "tms/manage_users/free_users/" ?>",
                type: 'POST',
                data: 'ajaxcall=true&date=' + date,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    // console.log(data.length);
                    for (var i = 0; i < data.length; i++)
                    {
                        var id = data[i].Emp_ID + date;
                        //  console.log(id);
                        var hoursFree = data[i].free_hours;
                        var workHour = data[i].workHour;
                        var x = hoursFree;

                        if (workHour == null || workHour == '')
                        {
                            workHour = 0;
                        }
                        else
                        {

                            workHour = Math.round(workHour * 100) / 100;
                        }

                        if (hoursFree == null || hoursFree == '')
                        {
                            hoursFree = "NT";
                            x = 0;
                        }
                        else if (hoursFree < 0)
                        {
                            hoursFree = Math.abs(hoursFree) + " OV";

                        }
                        else
                        {
                            hoursFree = Math.abs(hoursFree) + " FR";
                        }

                        var width = (100 / 7) * x;

                        //var html = "<div class='freeTime'><div style ='width:"+width+"%' class='allotedTime'></div></div>"+hoursFree;
                        $("#" + id).html("<span onclick='re_assignWrk(this)' class='re_assignWrk'>" + hoursFree + "</span> / <span class='get_wrk_details' onclick='get_wrk_details(this)'>" + workHour + " WD</span>");
                    }
                    preloader.off();
                }
            });

        });

        function rebind_chosen() {
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
        }
    <?php
}
?>

</script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


<div id="re_assignWork" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"> 
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <?php
                echo form_open(base_url("tms/manage_tasks/reassign_sub_task"));
                ?>
                <div class="row bottom_gap">
                    <div class="col-lg-12"> 
                        <select name="tstm_id" class="subTaskreassign form-control chosen-select"> 
                        </select>  
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12"> 
                        <select name="new_assignedto" class="re_assign_users form-control chosen-select"> 
                        </select> 
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <button class="btn btn-success re_assign_users_save_form" type="button">Assign</button>
                        <button class="btn btn-danger close" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<div id="DailyTaskDetails" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg"> 
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Daily Task Details</h4>
            </div>
            <div class="modal-body"> 
                <div class="row bottom_gap">
                    <div class="col-lg-12"> 
                        <table class="table table-bordered table-hover table-striped" id="dwrkd_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Client Name</th>
                                    <th>Task Name</th>
                                    <th>Sub Task Name</th>
                                    <th>Efforts</th>
                                    <th>Completed</th>
                                    <th>EntryDateTime</th>
                                    <th>WorkDate</th>
                                    <th>Work Desc</th> 
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
<script>
    $(function () {
        $('.bdatetimepicker').datetimepicker({
            format: 'YYYY-MM-DD hh:mm A',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

    });

    function re_assignWrk(that) {
        var _this = $(that);
        $("#re_assignWork").find(".modal-title").html("Reassign work for " + _this.parents(".freeUsers").find(".text-capitalize").text());
        preloader.on();
        $.ajax({
            url: get_base_url() + "tms/manage_sub_task/get_pending_sub_task",
            data: "date=" + _this.parents("td").attr("date") + "&assigned_to=" + _this.parents("td").attr("empid"),
            type: 'POST',
            dataType: 'JSON',
            success: function (result) {
                if ($(".chosen-select").siblings(".chosen-container").length) {
                    $(".chosen-select").chosen('destroy');
                }
//                console.log(result);
                $('.subTaskreassign').html("");
                $('.re_assign_users').html("");
                $.each(result.sub_tasks, function (tstm_id, tstm_name) {
                    $('.subTaskreassign').append($('<option>').text(tstm_name).attr('value', tstm_id));
                });
                $.each(result.free_users, function (i, value) {
                    var msg = "";
                    if (value.free_hours > 0 && value.free_hours != null) {
                        msg = "Busy for " + value.free_hours + " Hours";
                    } else if (value.free_hours == null) {
                        msg = "Free for day";
                    } else {
                        msg = "Overloaded " + Math.abs(value.free_hours) + " Hours";
                    }
                    $('.re_assign_users').append($('<option>').text(value.Emp_Name + " (" + msg + ")").attr('value', value.Emp_ID));
                });
//                console.log(_this.attr("empid"));
                $('.re_assign_users option[value=' + _this.attr("empid") + ']').attr('selected', 'selected');
                $("#re_assignWork").modal("show");
                rebind_chosen();
                preloader.off();
            }
        });
    }


    function get_wrk_details(that) {
        var _this = $(that);
        $("#DailyTaskDetails").find(".modal-title").html("Daily Task Details " + _this.parents(".freeUsers").find(".text-capitalize").text());
        preloader.on();
        $.ajax({
            url: get_base_url() + "tms/daily_task/fetch_recent_daily_data/1/1",
            data: "work_date=" + _this.parents("td").attr("date") + "&Add_User=" + _this.parents("td").attr("empid"),
            type: 'POST',
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                var s_no = 1;
                $("#DailyTaskDetails").find("#dwrkd_table > tbody").html("");
                $.each(result, function (index, DailyTaskRowObj) {
                    $("#DailyTaskDetails").find("#dwrkd_table > tbody").append("<tr>\n\
                                                  <td>" + s_no + "</td>\n\
                                                  <td>" + DailyTaskRowObj.client_name + "</td>\n\
                                                  <td>" + DailyTaskRowObj.tm_name + "</td>\n\
                                                  <td>" + DailyTaskRowObj.tstm_name  +"</td>\n\
                                                  <td>" + DailyTaskRowObj.efforts + " (In Hrs)</td>\n\
                                                  <td>" + DailyTaskRowObj.completed + "%</td>\n\
                                                  <td>" + DailyTaskRowObj.EntryTime + "</td>\n\
                                                  <td>" + DailyTaskRowObj.work_date + "</td>\n\
                                                  <td>" + DailyTaskRowObj.comment + "</td>\n\
                                                  </tr>");
                    s_no++;
                });
//                $.each(result.free_users, function (i, value) {
//                    var msg = "";
//                    if (value.free_hours > 0 && value.free_hours != null) {
//                        msg = "Busy for " + value.free_hours + " Hours";
//                    } else if (value.free_hours == null) {
//                        msg = "Free for day";
//                    } else {
//                        msg = "Overloaded " + Math.abs(value.free_hours) + " Hours";
//                    }
//                    $('.re_assign_users').append($('<option>').text(value.Emp_Name + " (" + msg + ")").attr('value', value.Emp_ID));
//                });
//                console.log(_this.attr("empid"));
//                $('.re_assign_users option[value=' + _this.attr("empid") + ']').attr('selected', 'selected');
                $("#DailyTaskDetails").modal("show");
//                rebind_chosen();
                preloader.off();
            }
        });
    }

    $(".re_assign_users_save_form").click(function () {
        preloader.on();
        var _this = $(this);
        $.ajax({
            data: _this.parents("form").serialize(),
            url: get_base_url() + "tms/manage_tasks/reassign_sub_task",
            dataType: "json",
            type: "POST",
            success: function (result) {
                _this.parents("form").trigger('reset');
                $("#re_assignWork").modal("hide");
                if (result.succ) {
                    
                      swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                } else {
                    swal("Oops!..", result._err_codes, "error");
                }
                preloader.off();
            }
        });
    });

</script>
