<div class="row">  <div class="col-lg-12">
        <h5> Search Result</h5>
        <hr>
    </div>

    <div class="col-lg-12">
       <?php 
        if(in_array($this->util_model->get_utype(), array(PARTNER, DIRECTOR))){
       ?> 
        <div class="SelectAllAction">
            <button class="btn btn-danger" onclick="approveAll(0)">Delete All</button>
            <button class="btn btn-primary" onclick="approveAll(1)">Approve All</button>
            <button class="btn btn-primary" onclick="showpopup('reassign')">Re-assign</button>
            <button class="btn btn-primary" onclick="showpopup('re-schedule')">Re-schedule</button>
        </div>
        <?php } ?>
        <div class="table-responsive">
            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="ajax_task_list">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="selectAll">S.No</th>
                        <th>Client Name</th>
                        <th>Task Name</th> 
                        <th>Sub Task Name</th> 
                        <th>In-Charge Name</th>
                        <th>Assigned To</th>
                        <th>Work Status</th>
                        <th>Progress</th>
                        <th>Start date</th> 
                        <th>End date</th>
                        <th style="width: 170px;">Action</th>
<!--<th>Last Modified</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($task_list as $each_task) {
//                        $this->util_model->printr($each_task);
                        ?>
                        <tr class="odd gradeX">
                            <td><input type="checkbox" class="check_box" value="<?php echo $each_task['tstm_id'] ?>"><?= ++$s_no ?></td>
                            <td><?= $each_task['client_name'] ?></td>
                            <td><?php echo $each_task['tm_name']; ?></td>
                            <td class="single_task">
                                <a target="_blank" href="<?php echo base_url() . "tms/manage_sub_task/taskSingleView/" . $each_task['tstm_id'] ?>">
                                    <?php echo $each_task['tstm_name'] . "({$each_task['tstm_id']}))" ?>
                                </a>
                            </td>
                            <td><?= $each_task['incharge_name'] ?></td>
                            <td class="sub_task_assigned_to"><?= $each_task['Emp_Name'] ?></td>
                            <th><?= $this->util_model->get_progress_flag_string($each_task['progress_flag']) ?></th>
                            <td><?php echo $each_task['completed'] != "" ? $each_task['completed'] : "0" ?><span>%</span></td>
                            <td><?php echo date(DF, strtotime($each_task['str_date_time'])); ?></td>
                            <td><?php echo date(DF, strtotime($each_task['end_date_time'])); ?></td>
                            <td>
                                <button key="<?= $each_task['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs reassign_task" >
                                    <span class="glyphicon glyphicon-refresh"></span> 
                                </button>
                                <button key="<?= $each_task['tstm_id'] ?>"  title="Mark completed and close sub task" type="button"  class="btn btn-success btn-xs close_sub_task" >
                                    <span class="glyphicon glyphicon-check"></span> 
                                </button>
                                <?php
                                if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                    ?>
                                    <button class="btn btn-info btn-xs" type="button" onclick="reschedule(<?php echo $each_task['tstm_id'] ?>, '<?php echo date(DF, strtotime($each_task['str_date_time'])) ?>', '<?php echo date(DF, strtotime($each_task['end_date_time'])) ?>')" title="Re-Schedule Sub Task Dates">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                    <button key="<?php echo $each_task['tstm_id'] ?>" type="button"  class="del_sub_task btn btn-xs btn-primary"><span class="glyphicon glyphicon-trash" title="Delete Task"></span></button>
                                    <?php }
                                    ?> 

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
<script>
    $(document).ready(function () {
        $(".SelectAllAction").hide();
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
        if(confirm('Sure to '+(action===1?'Approve All':'Delete All'))){
         var form_data = {'tstm_id':[]};
        $(".check_box").each(function () {
            if ($(this).prop('checked')) {
                form_data.tstm_id.push($(this).val());
            }
        });
        
        preloader.on();
        $.ajax({
            url: "<?php echo base_url() . 'tms/' ?>"+(action===1?'manage_sub_task/close_sub_task':'manage_task/del_sub_task'),
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
    function showpopup(type){
     var form_data = [];
        $(".check_box").each(function () {
            if ($(this).prop('checked')) {
                form_data.push($(this).val());
            }
        });
        $(".tm_id").val(form_data);
        $(".type").val(type);
         if(type=='reassign'){
                                $('.whom_instr').empty();
                                preloader.on();
                                setTimeout(function () {
                                    $.ajax({
                                        url: get_base_url() + "tms/manage_tasks/reassign_sub_task_data",
                                        data: "",
                                        type: 'POST',
                                        dataType: 'JSON',
                                        success: function (result) {
                                            if (result.succ) {
                                                
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
                                                $("#popup").modal('show');
                                            } else {
                                                swal("Oops!!", result._err_codes, "error");
                                                $('.whom_instr').html($('<option>').text("Select Type").attr('value', 0));
                                            } 
                                            preloader.off();
                                        }
                                    });
                                   
                                }, 1500);
                            }else{
                                $("#re-schedulepopup").modal('show');
                            }                          
        
    }
</script>