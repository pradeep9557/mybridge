<div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">My Task Detail<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            if (empty($my_tasks)) {
                echo "No More Tasks Found!!";
            } else {
                $i = $s_no;
                foreach ($my_tasks as $value) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;font-weight: bold;" colspan="8">Main Task</th>
                        </tr>
                        <tr>
                            <th>S.no</th>
                            <th>Task Name</th>
                            <th>Total Sub Tasks</th>
                            <th>Client Name</th>
                            <th>In charge</th>
                            <th>Progress/Completion</th>
                            <th>Target Date</th>
                            <th>Action</th>
                        </tr>
                        <tr class="<?php //echo $value['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : "" ?>">
                            <td><?= $i++ ?></td>
                            <td><?= $value['tm_name'] . $value['tm_id'] ?></td>
                            <td><?= $value['total_sub_task'] ?></td>
                            <td><?= $value['client_name'] ?></td>
                            <td><?= $value['Incharge_name'] ?></td>
                            <td><?php echo $this->util_model->get_progress_flag_string($value['progress_flag']) ?></td>
                            <td><?= date("F j, Y, g:i a",  strtotime($value['end_date'])) ?></td>
                            <td>
                                <a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index/" . $value['tm_id'] ?>" title="Edit Task"  class="btn btn-danger btn-xs" >
                                    <span class="glyphicon glyphicon-edit"></span> 
                                </a>
                                <button key="<?= $value['tm_id'] ?>" title="Close Task" type="button"  class="btn btn-danger btn-xs <?php echo $value['progress_flag'] == COMPLETED_REQUEST ? "" : "close_task" ?>" >
                                    <span class="glyphicon glyphicon-remove"></span> 
                                </button>
                                <?php
                                if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                    ?>
                                    <button key="<?php echo $value['tm_id'] ?>" type="button"  class="reopen_task btn btn-xs btn-primary"><span class="fa fa-level-up" title="Reopen Task"></span>
                                    </button>
                                <?php }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="8" style="text-align: center;font-weight: bold;">Remarks</th>
                        </tr>
                        <tr  class="<?php //echo $value['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : "" ?>">
                            <td></td>
                            <td style="font-style: italic;" colspan="6">
                                <?php echo $value['extra_note'] ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="8">
                                <table class="table sub_task_table">
                                    <tr class="sub_header">
                                        <th style="text-align: center;font-weight: bold;" colspan="8">Sub Tasks
                                            <span key="0" class="hide_show_sub_task">Show Sub Task Details</span>
                                        </th>
                                    </tr>
                                    <tr style="display: none">
                                        <th>S.no</th>
                                        <th>Sub Task Name</th>
                                        <th>Assigned to</th>
                                        <th>Progress/Completion</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                    $j = 1;
                                    foreach ($value['sub_task_data'] as $sub_task) {
                                        ?>
                                        <tr style="display: none" class="<?php // echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : "" ?>">
                                            <td><?= $j++ ?></td>
                                            <td><a href="<?php echo base_url("tms/manage_sub_task/taskSingleView/" . $sub_task['tstm_id']); ?>" target="_blank"><?= $sub_task['tstm_name'] ?></a></td>
                                            <td><?= $sub_task['Username'] ?></td>
                                            <td class="progress_flag"><?php echo $this->util_model->get_progress_flag_string($sub_task['progress_flag']); ?></td>
                                            <td><?php echo date("F j, Y, g:i a",  strtotime($sub_task['str_date_time'])) ?></td>
                                            <td><?php echo date("F j, Y, g:i a",  strtotime($sub_task['end_date_time'])) ?></td>
                                            <td>
                                                <button task_id="<?= $value['tm_id'] ?>" key="<?= $sub_task['tstm_id'] ?>" title="Close Sub Task" type="button"  class="btn btn-danger btn-xs <?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "" : "close_sub_task" ?>" >
                                                    <span class="glyphicon glyphicon-remove"></span> 
                                                </button>
                                                <button key="<?= $sub_task['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs <?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "" : "reassign_task" ?>" >
                                                    <span class="glyphicon glyphicon-refresh"></span> 
                                                </button>
                                                <?php
                                                if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                                    ?>
                                                    <button  task_id="<?= $value['tm_id'] ?>" key="<?php echo $sub_task['tstm_id'] ?>" type="button"  class="reopen_sub_task btn btn-xs btn-primary"><span class="fa fa-level-up" title="Reopen Sub Task"></span>
                                                    </button>
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                <?php }
                ?>
                <div class="col-lg-12 pagination_links">
                    <?php
                    if (isset($page_links)) {
                        foreach ($page_links as $value) {
                            echo "&nbsp;" . $value;
                        }
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
<!-- Button trigger modal -->

<!-- Modal -->
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