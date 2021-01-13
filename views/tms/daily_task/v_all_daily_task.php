 
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#dailyTaskEntries">
                <h3 class="panel-title toggle_custom">Result <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="dailyTaskEntries">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="table_data">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="checkAll(this)">S.No</th>
                                <th>Client Name</th>
                                <th>Task Name</th>
                                <th>Sub task Name</th>
                                <th>Attachment</th>
                                <th style="width: 100px">Date</th>
                                <th>Efforts Made</th>
                                <th>Work Desc</th>
                                <th>Completed</th>
                                <th>End Date</th>
                                <th>Approved</th>
                                <th>Entry Done By</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $s_no = isset($s_no) ? $s_no : 0;


                            foreach ($all_daily_data as $task_List) {
//                                $this->util_model->printr($task_List);
                                ?>
                                <?php ?>
                                <tr class="odd gradeX">
                                    <td><input name="approve[]" type="checkbox" value="<?= $task_List['comment_id'] ?>" class="check_box"><?= ++$s_no ?></td>
                                    <td><?php echo $task_List['client_name']; ?></td>
                                    <td><?php echo $task_List['tm_name']; ?></td>
                                    <td><a href="<?php echo base_url("tms/manage_sub_task/taskSingleView/" . $task_List['tstm_id']); ?>" target="_blank"><?= $task_List['tstm_name'] ?></a></td>
                                    <td><?= $task_List['attach_original_name'] ?></td>
                                    <td><?= date(DF, strtotime($task_List['work_date'])) ?></td>
                                    <td><?= $task_List['efforts'] . " Hour" ?></td>
                                    <td><?= strip_tags($task_List['comment']) ?></td>
                                    <td><?= $task_List['completed'] . " %" ?></td>
                                    <td><?= $task_List['end_date']; ?></td>
                                    <td><?php echo $task_List['approved'] == 0 ? "Pending for Approval" : ($task_List['approved'] == 1 ? "Approved" : "Rejected") ?></td>
                                    <td><?php echo ucfirst($task_List['entryBy']); ?></td>
                                    <td>
                                        <form>
                                            <a href="<?= base_url() ?>tms/daily_task/edit_daily_task/<?= $task_List['comment_id'] ?>"> <button type="button" name="edit_daily_task" id="" title="" value="Edit" class="btn btn-success btn-xs edit_daily_task">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>
                                            </a>
                                            <input type="hidden" name="_key" value="del_Daily_task"/>
                                            <input type="hidden" name="_title" value="Daily Task"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($task_List['tstm_name']) ?> Sub-Task !!" name="_msg"/>
                                            <input type="hidden" value="<?= mysql_real_escape_string($task_List['comment_id']) ?>" name="comment_id"/>
                                            <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                <span class="glyphicon glyphicon-trash"></span> 
                                            </button>
                                            <?php
                                            if ($task_List['approved'] == 0) {
                                                ?>
                                                <button type="button" title="click here to approve"  value="approve_it" class="btn btn-primary btn-xs" onclick="approve_it(<?= mysql_real_escape_string($task_List['comment_id']) ?>, 1)">
                                                    <span class="glyphicon glyphicon-check"></span> 
                                                </button>
                                            <?php } ?>

                                        </form>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>


                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div> 