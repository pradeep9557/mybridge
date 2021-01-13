<!--<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>-->
<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Sub-Task Approval Report</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <?php 
         if(isset($pending_instructor_ids)){
        ?>
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allpst">
                    <h3 class="panel-title toggle_custom">Punched Pending Sub-Task  <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allpst">
                    <form>
                        <div class="row">
                            <div class="col-md-2">Filter Instructor</div>
                            <div class="col-md-4">
                                <?php
                                 echo form_dropdown('instructor_id', $pending_instructor_ids,$this->input->get('instructor_id'),"class='form-control'");
                                ?>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
         <?php } ?>
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allpst">
                    <h3 class="panel-title toggle_custom">Punched Pending Sub-Task  <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allpst">
                    <div class="SelectAllAction">
                        <button class="btn btn-danger" onclick="approveAll(0)">DisCard All</button>
                        <button class="btn btn-primary" onclick="approveAll(1)">Approve All</button>
                    </div>
                    <div class="table-responsive">
                        <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="selectAll">S.No</th>
                                    <th>
                                        Task Name (Sub task Name) 
                                        <br/>
                                        <strong>Client's Name</strong>
                                    </th>
                                    <th>Add User</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Progress Flag</th>
                                    <th>Completed</th>
                                    <th>Efforts Made</th>
                                    <th>Current Status</th>
                                    <th>Comment</th>
                                    <th>Approve/Discard</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
//                                $this->util_model->printr($st_approval_list);
                                if(empty($st_approval_list)){
                                    echo '<tr class="odd gradeX"><td colspan=50>No Entry for Approve</td></tr>';
                                }else{
                                foreach ($st_approval_list as $task_List) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" class="check_box" value="<?php echo $task_List['comment_id'] ?>"><?= ++$i ?></td>
                                        <td><?= $task_List['tm_name']."({$task_List['tstm_name']})<br/><strong>{$task_List['client_name']}</strong>" ?></td>
                                        <td><?= $task_List['Emp_Name'] ?></td>
                                        <td><?= $task_List['start_date'] ?></td>
                                        <td><?= $task_List['end_date'] ?></td>
                                        <td><?= $this->util_model->get_progress_flag_string($task_List['progress_flag']); ?></td>
                                        <td><?= $task_List['completed'] . " %" ?></td>
                                        <td><?= $task_List['efforts'] . " Hour" ?></td>
                                        <td><span><?php echo ($task_List['approved'] == STATUS_TRUE) ? "Approved" : "Not Approved" ?></span></td>

                                        <td><?= $task_List['comment'] ?></td>
                                        <td>
                                            <form class="approve_data_form">

                                                <input type="hidden" name="comment_id" value="<?php echo $task_List['comment_id'] ?>"/>
                                                <input type="hidden" name="tstm_id" value="<?php echo $task_List['tstm_id'] ?>"/>
                                                <?php if ($task_List['approved'] == 2) { ?>
                                                    <button type="button" class="btn btn-xs btn-success approve_st">
                                                        <span class="glyphicon glyphicon-ok"></span> 
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger discard_st">
                                                        <span class="glyphicon glyphicon-remove"></span> 
                                                    </button>  
                                                <?php } ?>
                                            </form>
                                        </td>

                                    </tr>
                                    <?php
                                }}
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
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $(".SelectAllAction").hide();
    });

    $(".approve_st").click(function () {
        var $ref = $(this);
        preloader.on();
        $.ajax({
            url: "<?php echo base_url() . 'tms/manage_sub_task/approve_pst_list' ?>",
            method: "POST",
            data: $(this).parents(".approve_data_form").serialize(),
            dataType: "json",
            success: function (result) {
                if (result.succ) {
                      swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                    $ref.parent().parent().empty();
                } else {
                    sweetAlert("Oops...", result._err_codes, "error");
                }
                preloader.off();
            }

        });
    });

    $(".discard_st").click(function () {
        var $ref = $(this);
        preloader.on();
        $.ajax({
            url: "<?php echo base_url() . 'tms/manage_sub_task/discard_pst_list' ?>",
            method: "POST",
            data: $(this).parents(".approve_data_form").serialize(),
            dataType: "json",
            success: function (result) {
                if (result.succ) {
                   swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                    $ref.parent().parent().empty();
                } else {
                    sweetAlert("Oops...", result._err_codes, "error");
                }
                preloader.off();
            }
        });
    });
    
    $(".selectAll").on('click',function(){
        $(".check_box").prop('checked',$(this).prop('checked'));
        checkBulkAction();
    });
    
    $(".check_box").on('click',function(){
        checkBulkAction();
    });
    
    function checkBulkAction(){
        if($(".check_box:checked").length>1){
            $(".SelectAllAction").show();
        }else{
            $(".SelectAllAction").hide();
        }}
    
    function approveAll(action){
        if(confirm('Sure to '+(action===1?'Approve All':'Reject All'))){
         var form_data = {'comment_id':[]};
        $(".check_box").each(function () {
            if ($(this).prop('checked')) {
                form_data.comment_id.push($(this).val());
            }
        });
        
        preloader.on();
        $.ajax({
            url: "<?php echo base_url() . 'tms/manage_sub_task/' ?>"+(action===1?'approve_pst_list':'discard_pst_list'),
            method: "POST",
            data: form_data,
            dataType: "json",
            success: function (result) {
                if (result.succ) {
                    sweetAlert("Good Job!!", result._err_codes, "success",3000, false);
                    
                } else {
                    sweetAlert("Oops...", result._err_codes, "error");
                }
                preloader.off();
            }
        });}
    }
</script>


