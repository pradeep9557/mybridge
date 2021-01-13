<div class="row">  <div class="col-lg-12">
        <h5> Search Result</h5>
        <hr>
    </div>

    <div class="col-lg-12">

        <div class="table-responsive">
            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="ajax_task_list">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Task Category</th> 
                        <th>Task Name(Code)</th> 
                        <th>In-Charge Name</th>
                        <th>Client Name</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Start date</th> 
                        <th>End date</th>
                        <?php
                        if (isset($_POST['does_repeat']) && $_POST['does_repeat'])
                            echo "<th>Replica Date</th>"
                            ?> 
                        <th style="width: 100px;">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($task_list as $each_task) {
                      
                        ?>
                        <tr class="odd gradeX">
                            <td><?= ++$i ?></td>
                            <td><?php echo $each_task['skill_dev_activity']?"Skill Development":"Other" ?></td>
                            <td><?php echo $each_task['tm_name'] ?></td>
                            <td><?= $each_task['InchargeName'] ?></td>
                            <td><?= $each_task['client_name'] ?></td>
                            <td><?= ($each_task['status']) ? "Enable" : "Disabled" ?></td>
                            <th><?= $this->util_model->get_progress_flag_string($each_task['progress_flag']) ?></th>
                            <td><?php echo date(DF, strtotime($each_task['start_date'])); ?></td>
                            <td><?php echo date(DF, strtotime($each_task['start_date'])); ?></td>
                            <?php
                            if (isset($_POST['does_repeat']) && $_POST['does_repeat'] && 
                                    isset($_POST['progress_flag']) && $_POST['progress_flag']!=3)
                                echo "<td>" . date(DF, strtotime($each_task['replicate_date'])) . "</td>"
                                ?> 

                            <td>
                                <form>
                                    <?php if (isset($replica_btn) && $replica_btn) { ?>
                                        <a href="<?php echo base_url() . "tms/manage_tasks/index" . "/" . $each_task['tm_id'] . "?tab=create_replica" ?>">
                                            <button type="button" value=""  class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-repeat" title="Recreate Replica"></span>
                                            </button>
                                        </a>
                                    <?php } else if(isset($_POST['progress_flag']) && $_POST['progress_flag']!=3) { ?>
                                        <a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index" . "/" . $each_task['tm_id'] ?>">
                                            <button type="button" value=""  class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit" title="Edit Task"></span>
                                            </button>
                                        </a>
                                        <?php
                                    }
                                    if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                        ?>
                                        <button key="<?php echo $each_task['tm_id'] ?>" type="button"  class="del_task btn btn-xs btn-primary"><span class="glyphicon glyphicon-trash" title="Delete Task"></span>
                                        </button>
                                    <?php }
                                    ?>
    <!--                                                    <button type="button"   class="btn-xs btn btn-success edit_btn_ttc" id="edit_btn_ttc" title="<?= htmlentities($each_task['tm_name']) ?>">
    <span class="glyphicon glyphicon-edit"></span>
    </button>-->
                                    <input type="hidden" name="_key" value="del_task_master"/>
                                    <input type="hidden" name="_title" value="task-type-category"/>
                                    <input  type="hidden" value="You want to delete this Task-Type Category !!" name="_msg"/>
                                    <input type="hidden" value="<?= $this->util_model->url_encode($each_task['tm_id']) ?>" name="ID"/>
                                    <!--                                                    <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_tt_update">
                                                                                            <span class="glyphicon glyphicon-trash"></span> 
                                                                                        </button>-->
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
