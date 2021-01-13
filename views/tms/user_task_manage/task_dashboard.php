<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">  
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="dashboard_win">
        <div class="row margin_top_20px">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li id="all_table" class="watch_click <?php echo (isset($active_tab) && $active_tab == "all_task") ? "active" : "" ?>"><a data-toggle="tab" href="#all">All Task</a></li>
                    <li id="my_table" class="watch_click <?php echo (isset($active_tab) && $active_tab == "my_task") ? "active" : "" ?>"><a data-toggle="tab" href="#my">My Tasks</a></li>
                    <li id="upcoming_table" class="watch_click <?php echo (isset($active_tab) && $active_tab == "upcoming_task") ? "active" : "" ?>"><a data-toggle="tab" href="#u_cum">Upcoming</a></li>
                    <li id="due_table" class="watch_click <?php echo (isset($active_tab) && $active_tab == "pending_task") ? "active" : "" ?>"><a data-toggle="tab" href="#due">Overdue</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="all" class="tab-pane fade <?php echo (isset($active_tab) && $active_tab == "all_task") ? "in active" : "" ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-target="#CollapseAllTask">
                        <h3 class="panel-title toggle_custom">All Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <div class="panel-body collapse in" id="CollapseAllTask">   
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="all_table table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Client Name</th>
                                                <td>Task Status</td>
                                                <th>Task Name</th>
                                                <th>Assigned to</th>
                                                <!--<th>Progress</th>-->
                                                <th>Completion</th>
                                                <th>Due Date</th>
                                                <th>Reassign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            //  $this->util_model->printr($task_data);
                                            foreach ($task_data as $List) {
                                                ?>
                                                <tr class="odd gradeX <?php //echo $List['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : ""  ?>">
                                                    <td><?= ++$i ?></td>
                                                    <td><?= $List['client_name'] ?></td>
                                                    <td><?php echo $this->util_model->get_progress_flag_string($List['progress_flag']); ?></td>
                                                    <td key="<?php echo $List['tstm_id'] ?>" class="single_task" ><?= $List['tstm_name'] ?></td>
                                                    <td><?= $List['Emp_Name'] ?></td>
                                                    <td><?php echo $List['completed'] != "" ? $List['completed'] : "0" ?><span>%</span></td><td><?= $List['overdue_date'] ?></td>
                                                    <td>
                                                        <button key="<?= $List['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs reassign_task" >
                                                            <span class="glyphicon glyphicon-refresh"></span> 
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="my" class="tab-pane fade <?php echo (isset($active_tab) && $active_tab == "my_task") ? "in active" : "" ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-target="#CollapseMyTask">
                        <h3 class="panel-title toggle_custom">My Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <div class="panel-body collapse in" id="CollapseMyTask">   
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table my_table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Client Name</th>
                                                <td>Task Status</td>
                                                <th>Task Name</th>
                                                <th>Assigned to</th>
                                                <!--<th>Progress</th>-->
                                                <th>Completion</th>
                                                <th>Due Date</th>
                                                <th>Reassign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($task_data as $List) {
                                                ?>
                                                <tr class="odd gradeX <?php //echo $List['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : ""  ?>">
                                                    <td><?= ++$i ?></td>
                                                    <td><?= $List['client_name'] ?></td>
                                                    <td><?php echo $this->util_model->get_progress_flag_string($List['progress_flag']); ?></td>
                                                    <td key="<?php echo $List['tstm_id'] ?>" class="single_task" ><?= $List['tstm_name'] ?></td>
                                                    <td><?= $List['Emp_Name'] ?></td>
                                                    <td><?php echo $List['completed'] != "" ? $List['completed'] : "0" ?><span>%</span></td><td><?= $List['overdue_date'] ?></td>
                                                    <td>
                                                        <button key="<?= $List['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs reassign_task" >
                                                            <span class="glyphicon glyphicon-refresh"></span> 
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="u_cum" class="tab-pane fade <?php echo (isset($active_tab) && $active_tab == "upcoming_task") ? "in active" : "" ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-target="#CollapseUpcomingTask">
                        <h3 class="panel-title toggle_custom">Overdue Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <div class="panel-body collapse in" id="CollapseUpcomingTask">   
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table upcoming_table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Client Name</th>
                                                <td>Task Status</td>
                                                <th>Task Name</th>
                                                <th>Assigned to</th>
                                                <!--<th>Progress</th>-->
                                                <th>Completion</th>
                                                <th>Due Date</th>
                                                <th>Reassign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($task_data as $List) {
                                                if ($List['progress_flag'] == COMPLETED_REQUEST || date(DB_DTF, time()) > date(DB_DF, strtotime($List['overdue_date']))) {
                                                    continue;
                                                }
                                                ?>
                                                <tr class="odd gradeX <?php //echo $List['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : ""  ?>">
                                                    <td><?= ++$i ?></td>
                                                    <td><?= $List['client_name'] ?></td>
                                                    <td><?php echo $this->util_model->get_progress_flag_string($List['progress_flag']); ?></td>
                                                    <td key="<?php echo $List['tstm_id'] ?>" class="single_task" ><?= $List['tstm_name'] ?></td>
                                                    <td><?= $List['Emp_Name'] ?></td>
                                                    <td><?php echo $List['completed'] != "" ? $List['completed'] : "0" ?><span>%</span></td><td><?= $List['overdue_date'] ?></td>
                                                    <td>
                                                        <button key="<?= $List['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs reassign_task" >
                                                            <span class="glyphicon glyphicon-refresh"></span> 
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="due" class="tab-pane fade <?php echo (isset($active_tab) && $active_tab == "pending_task") ? "in active" : "" ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-target="#CollapseDueTask">
                        <h3 class="panel-title toggle_custom">Overdue Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <div class="panel-body collapse in" id="CollapseDueTask">   
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table due_table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Client Name</th>
                                                <td>Task Status</td>
                                                <th>Task Name</th>
                                                <th>Assigned to</th>
                                                <!--<th>Progress</th>-->
                                                <th>Completion</th>
                                                <th>Due Date</th>
                                                <th>Reassign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($task_data as $List) {
                                                if (date(DB_DF, strtotime(time())) < date(DB_DF, strtotime($List['overdue_date']))) {
                                                    continue;
                                                }
                                                ?>
                                                <tr class="odd gradeX <?php //echo $List['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : ""  ?>">
                                                    <td><?= ++$i ?></td>
                                                    <td><?= $List['client_name'] ?></td>
                                                    <td><?php echo $this->util_model->get_progress_flag_string($List['progress_flag']); ?></td>
                                                    <td key="<?php echo $List['tstm_id'] ?>" class="single_task" ><?= $List['tstm_name'] ?></td>
                                                    <td><?= $List['Emp_Name'] ?></td>
                                                    <td><?php echo $List['completed'] != "" ? $List['completed'] : "0" ?><span>%</span></td><td><?= $List['overdue_date'] ?></td>
                                                    <td>
                                                        <button key="<?= $List['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs reassign_task" >
                                                            <span class="glyphicon glyphicon-refresh"></span> 
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                        <?php echo form_input("assignedto", "", array("class" => "'form-control assigned_to'")) ?>
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
    <div class="single_task_window hidden">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary back_btn">Go back</button>
                        </div>
                        <div class="col-lg-12">
                            <h1 class="task_name"></h1>
                        </div>
                        <div class="col-lg-12 border_bottom_view">
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-4 task_elements">
                                <table cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>Type:</td>
                                            <td class="pro_type"></td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td class="task_status"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4 task_elements">
                                <table cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>Est. Hour(s): </td>
                                            <td class="est_time"></td>
                                        </tr>
                                        <tr>
                                            <td>Hour(s) Spent: </td>
                                            <td class="hr_by_user">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4 task_elements">
                                <table cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>Project:</td>
                                            <td class="pro_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Task Progress:</td>
                                            <td class="task_progress"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="cb"></div>
                        <div class="col-lg-12">
                            <div class="details_task_block">
                                <div class="details_task_head">
                                    <div class="fl"> 
                                        <img onerror="img_load_fail(this)" class="lazy round_profile_img incharge_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                                    </div>
                                    <div class="fl"> <span>Created by <b class="task_creator"></b></span>
                                        <div class="create_date"></div>
                                    </div>
                                </div>
                                <div class="details_task_desc wrapword">
                                    <strong>
                                        Purpose
                                    </strong>
                                    <p class="purp"></p>
                                    <br>
                                    <strong>
                                        Control Points
                                    </strong>
                                    <p class="ctrl_pnts"></p>
                                    <br>
                                    <strong>
                                        Check_points
                                    </strong>
                                    <p class="chk_pnts"></p>
                                    <br>
                                    <strong>
                                        BackGround
                                    </strong>
                                    <p class="backgnd"></p>
                                    <br>
                                    <strong>
                                        Document Required
                                    </strong>
                                    <div class="doc_required">
                                        <ol>

                                        </ol>
                                    </div>  
                                    <div class="cb"></div>
                                </div>
                            </div>
                        </div>
                        <div class="reply_box">

                        </div>
                    </div>
                    <div class="reply_task_block" id="reply_box22">
<!--                        <form id="reply_form" method="post" action="<?php echo base_url() . "tms/manage_sub_task/add_comment" ?>">-->
                        <form id="reply_form" method="post" action="<?php echo base_url() . "tms/daily_task/punch_daily_entry" ?>">
                            <?php $this->load->view("tms/common/comment_box"); ?>
                            <div class="cb"></div>
                        </form>
                    </div>    
                </div>
                <div class="col-lg-3 fl col_task case_det_rt">
                    <div class="cb"></div>
                    <hr>
                    <div>
                        <div class="asign_block">

                            <div id="case_dtls_asgn22" class="fl asgn_actions  dropdown"> <span class="quick_action" data-toggle="dropdown" >Assigned To</span>

                            </div>
                        </div>
                        <div class="cb"></div>
                        <div class="fl">
                            <img onerror="img_load_fail(this)" class="lazy round_profile_img rep_bdr assigned_user" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                        </div>
                        <div class="fl">
                            <span>
                                <b id="case_dtls_new22" class="assign_to"></b>
                            </span>
                            <div class="assigned_email"></div>
                        </div>
                    </div>
                    <div class="cb"></div>
                    <hr>
                    <div class="task_due_dt">
                        <div class="cb"></div>
                        <div class="fl">
                            <span class="attachments">No Files in this Task</span>
                        </div>
                        <div class="attach_files">

                        </div>
                    </div>
                    <div class="cb"></div>
                    <hr>
                    <div class="task_due_dt">
                        <div class="cb"></div>
                        <div class="fl"> <span>Activities</span>
                            <br>
                        </div>
                        <div class="cb"></div>
                        <div class="activ_listing">
                            <div>Created: <span class="create_date"></span></div>
                            <div><span>Last Updated:</span> Y'day 7:04 pm</div>
                        </div>
                    </div>
                    <div class="cb"></div>
                    <hr>
                    <div class="task_due_dt">
                        <div class="cb"></div>
                        <div class="fl"> <span>People Involved</span>
                            <br>
                        </div>
                    </div>
                    <div class="cb"></div>
                    <div class="fl involved_user">

                    </div>
                </div>
            </div>
        </div>
        <div class="involved_user_html hidden">
            <img onerror="img_load_fail(this)" class="lazy round_profile_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
        </div>
        <div class="attachment_html hidden">
            <div class="cb"></div>
            <div class="fl">
                <span class="attachment_link">

                </span>
                <div class="fnt999 time_attach"></div>
            </div>
        </div>
        <div class="comment_html hidden">
            <div class="col-lg-12">
                <div class="details_task_block">
                    <div class="details_task_head">
                        <div class="fl">
                            <img onerror="img_load_fail(this)" class="lazy round_profile_img comment_user_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                        </div>
                        <div class="fl"> <span><b class="comment_username"></b></span>
                            <div class="comment_time"></div>
                        </div>
                        <div class="fr">
                            <table cellpadding="0" cellspacing="0" class="fr task_status">
                                <tbody>
                                    <tr>
                                        <td>Assigned To: <b class="task_creator"></b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="details_task_desc wrapword">
                        <div id="casereplytxt_id_23">
                            <span class="comment_data"></span>
                        </div>
                        <div id="casereplyid_23"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>
                        var global_id = "";
                        var active_tab = "all_table";
                        var global_reassign_val = "";

                        $(".watch_click").on("click", function () {
                            active_tab = $(this).attr("id");
                        });

                        function set_json_to_html(result) {
//                            console.log(result);
                            $("input[type='hidden'][name='tstm_id']").remove();
                            $("#reply_form").append("<input type='hidden' name='tstm_id' value='" + result.data.tstm_id + "'/>");
                            $(".task_name").html(result.data.tstm_name + " <span title='Task Name'>(" + result.data.tm_name + ")</span>");
                            $(".pro_type").html(result.data.ttm_name);
                            $(".est_time").html(result.data.tstm_efforts + " hours");
                            $(".pro_name").html(result.data.tm_name);
                            $(".incharge_img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + result.data.incharge_pic);
                            $(".task_creator").html(result.data.incharge_name);
                            $(".assign_to").html(result.data.Emp_Name);
                            $(".assigned_email").html(result.data.P_Email);
                            $(".assigned_user").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + result.data.Pro_Pic);
                            $(".create_date").html(result.data.start_date);
                            $(".chk_pnts").html(result.data.tstm_check_points);
                            $(".purp").html(result.data.purpose);
                            $("td.task_status").html(result.data.progress_flag);
                            $("td.task_progress").find(".progress-bar").css({"width": result.data.completed});
                            $("td.task_progress").find(".progress-bar").html(result.data.completed);
                            $(".ctrl_pnts").html(result.data.tstm_control_points);
                            $(".chk_pnts").html(result.data.tstm_check_points);
                            $(".backgnd").html(result.data.background);
                            var hr_by_user = 0;
                            $.each(result.data.comment_data, function (i, value) {
                                $(".comment_html").find(".comment_user_img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + value.Pro_Pic);
                                $(".comment_html").find(".comment_username").html(value.Emp_Name);
                                $(".comment_html").find(".comment_time").html(value.Add_DateTime);
                                $(".comment_html").find(".comment_data").html(value.comment);
                                $(".comment_html").find(".comment_pro").html(value.progress_flag);
                                $(".comment_html").find(".comment_comp").html(value.completed + "%");
                                $(".comment_html").find(".comment_eff").html(value.efforts + " Hours");


                                $(".comment_html").find(".comment_file_attached").empty();
                                if (value.comment_attachments.length > 0) {
                                    $(".comment_html").find(".file_container").removeClass("hidden");
                                    $.each(value.comment_attachments, function (i, value) {
                                        $(".comment_html").find(".comment_file_attached").append("<li class=''><a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_original_name + "</a></li>");
                                    });
                                } else {
                                    $(".comment_html").find(".file_container").addClass("hidden");
                                }

                                $(".reply_box").append($(".comment_html").html());
                                hr_by_user += parseInt(value.efforts);
                            });
                            if (result.data.doc_required.length > 0) {
                                $(".doc_required").find("ol").html("");
                                $.each(result.data.doc_required, function (i, value) {

                                    $(".doc_required").find("ol").append("<li>" + "" + "<a target='_blank' class='file_link' title=" + value.tmdoc_name + " href='" + get_base_url() + value.document_path + "' >" + value.tmdoc_name + "</a></li>");
                                });
                            } else {
                                $(".doc_required").find("ol").append("<li>No any required documents attached with this sub task</li>");
                            }


                            $(".hr_by_user").html(" " + hr_by_user + " hours");
                            $(".attach_files").empty();
                            if (result.data.attachments.length > 0) {
                                $.each(result.data.attachments, function (i, value) {
                                    $(".attachment_html").find(".attachment_link").html("<a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_name + "</a>");
                                    $(".attachment_html").find(".time_attach").html(value.date);
                                    $(".attach_files").append($(".attachment_html").html());
                                });

                            } else {
                                $(".attachments").html("No Files in this Task");
                            }
                            $.each(result.data.involved_user_data, function (i, value) {
                                $(".involved_user_html").find("img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + value.Pro_Pic);
                                $(".involved_user_html").find("img").attr("title", value.Emp_Name);
                                $(".involved_user").append($(".involved_user_html").html());
                            });
                            $(".dashboard_win").addClass("hidden");
                            $(".single_task_window").removeClass("hidden");
                        }

                        function img_load_fail(that) {
                            $(that).attr("src", (get_base_url() + "img/logo.png"));
                        }
                        function SaveChanges() {
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
                                        global_reassign_val.parent().parent().remove();
                                    } else {
                                        swal("Oops!..", result._err_codes, "error");
                                    }
                                    preloader.off();
                                }
                            });
                        }
                        function init() {
                            var $modal = $('#ajax-modal');
                            $(document).unbind('reassign_task');
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
                                                swal("Oops!!", result._err_codes, "error");
                                                $('.whom_instr').html($('<option>').text("Select Type").attr('value', 0));
                                            }
                                        }
                                    });
                                    preloader.off();
                                }, 1500);
                            });

                            $(".single_task").on("click", function () {
                                preloader.on();
                                global_id = $(this).attr("key");
                                $.ajax({
                                    type: "POST",
                                    url: get_base_url() + "tms/manage_sub_task/mySubTask",
                                    data: "tstm_id=" + global_id,
                                    dataType: "json",
                                    success: function (result) {

                                        $(".reply_box").html("");
                                        $(".involved_user").html("");
                                        if (result.succ) {
                                            window.history.pushState('obj', 'newtitle', get_base_url() + 'tms/manage_sub_task/taskSingleView/' + global_id);
                                            set_json_to_html(result);
                                        } else {
                                            swal("oops!!", "Either you are not authorized to view this task or you need to refresh the page!!", "error");
                                        }
                                        preloader.off();
                                    }
                                });
                            });
                        }

                        $(".back_btn").on("click", function () {
                            preloader.on();
                            $.ajax({
                                type: "POST",
                                url: get_base_url() + "tms/manage_sub_task/singleTab",
                                data: "curr_page=" + active_tab,
                                dataType: "json",
                                success: function (result) {
                                    preloader.off();
//                                    console.log(result);
                                    $("#reply_form").trigger("reset");
                                    if (result.succ) {
                                        var oTable = $('.' + active_tab).dataTable();
                                        oTable.fnClearTable();
                                        var $k = 0;
                                        for (var i = 0; i < result.data.length; i++) {
                                            oTable.fnAddData([++$k, result.data[i]['client_name'], result.data[i]['progress_flag'] == 2 ? "In Progress" : "Completed", result.data[i]['tstm_name'], result.data[i]['Emp_Name'], result.data[i]['completed'] != "" ? (result.data[i]['completed'] + " %") : "0%", result.data[i]['overdue_date'], reassign_btn(result.data[i]['tstm_id'])]);
                                        }
                                        $.each($("." + active_tab).find("tr td:nth-child(4)"), function (i, value) {
                                            $(this).addClass("single_task");
                                            $(this).attr("key", result.data[i]['tstm_id']);
                                            if (result.data[i]['progress_flag'] == 3) {
                                                $(this).parent().addClass("strikeout");
                                            }
                                        });
                                        $(".dashboard_win").removeClass("hidden");
                                        $(".single_task_window").addClass("hidden");
                                        window.history.pushState('obj', 'newtitle', get_base_url() + 'tms/manage_sub_task/subTaskDashboard');
                                        init();
                                    } else {
                                        sweetAlert({
                                            title: "Oops...",
                                            text: ">__< Unexpected Error Error Code #07092016_0227",
                                            type: "error",
                                            timer: 2500,
                                            html: true
                                        });
                                    }
                                }
                            });
                        });

                        function reassign_btn(tstm_id) {
                            return "<button key=" + tstm_id + " data-toggle='modal' data-target='#myModal' title='Reassign Task' type='button'  class='btn btn-danger btn-xs reassign_task'>\n\
                                        <span class='glyphicon glyphicon-refresh'>\n\
                                        </span>\n\
                                    </button>";
                        }

                        $(document).on("ready", function () {
                            init();
                            $("#reply_form").trigger("reset");

                            $("#reply_form").on("submit", function (e) {
                                preloader.on();
                                e.preventDefault();
                                var $form = $(e.target);
                                $form.ajaxSubmit({
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
                                    type: "POST",
                                    url: $(this).attr("action"),
//                data: $(this).serialize(),
                                    dataType: "json",
                                    contentType: false,
                                    enctype: 'multipart/form-data',
                                    cache: false,
                                    processData: false,
                                    success: function (result) {
                                        $("#reply_form").trigger("reset");
                                        if (result.succ) {
                                            $.ajax({
                                                type: "POST",
                                                url: get_base_url() + "tms/manage_sub_task/mySubTask",
                                                data: "tstm_id=" + global_id,
                                                dataType: "json",
                                                success: function (result) {
                                                    $(".reply_box").html("");
                                                    $(".involved_user").html("");
                                                    if (result.succ) {
                                                        set_json_to_html(result);
                                                    }
                                                }
                                            });
                                        } else {
                                            swal("Oops!!", result._err_code, "error");
                                        }
                                        preloader.off();
                                    }
                                });
                            });

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