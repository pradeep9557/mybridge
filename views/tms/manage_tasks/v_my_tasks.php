<script type="text/javascript">
    $( "#clickBill" ).click(function() {
    $( "#billList" ).toggle();
});
function new_search_task_data(clientId) {
        var cId = clientId;
        var data = { 
                view_change: 1,
                skill_dev_activity: -1,
                no_of_subTask: -1,
                does_repeat: 2,
                page: 0,
                limit: 100,
                client_id: [cId],
                date_wise: 0,
                start_date: '',
                end_date: '',
                tm_name: '',
                tm_code: '',
                state_id: 0,
                year: 0,
                month: 0,
                user_id: [0],
                progress_flag: 4, 
                BillingDone: 0,
                OrderCol: 'tm.Mode_DateTime',
                OrderAscDsc:'DESC',
                billing_acc_id:0,
                task_period_id: '',
                attachment: 'without_attach'
            }  
        preloader.on(); 
        $(".pre_list, .next_list").addClass("hidden"); 
        $(".export_xls").addClass("hidden"); 
        $.ajax({ 
            type: "POST", 
            url: "<?php echo base_url(); ?>tms/manage_tasks/get_task_result",  
            //data: $("#search_task_form").serialize(),
            data:data,
            dataType: "json", 
            success: function (search_data) { 
                $("#global_task_search_result").html(search_data['html']); 
                preloader.off(); 
                $(".export_xls").removeClass("hidden"); 
                init_task_depend_fun(); 
            } 
        }); 
        $(".pre_list, .next_list").removeClass("hidden"); 
    }
</script>
 
<button id ="clickBill">Pending Bill</button>
<div id="billList" style="display: none;">
    <div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Task Category  
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <td>S.No.</td>
                        <td>Client Name</td>
                        <td>Task Type</td>
                        <td>No of Task</td> 
                        <td>Action</td> 
                    </tr>
                </thead>
                <tbody>
                <?php 
                   // print_r($my_new_tasks);
                    $i=1; 
                    foreach ($my_new_tasks as $val) {
                ?>
                    <tr>
                        <td><?=$i;?></td> 
                        <td><?= $val['client_name'] ?></td> 
                        <td><?= $val['ttm_name']  ?></td> 
                        <td><?=$val['total_count'] ?></td>
                        <td>
                             <button class="btn btn-success" type="button" name="View" onclick="new_search_task_data('<?= $val['client_id'] ?>')">View</button>
                        </td>
                    </tr>
                <?php $i++;} ?>                               
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
        <h3 class="panel-title toggle_custom">My Task Detail

            <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>

        <?php
//          echo $pagination;
        ?>
    </div>
    <div class="panel-body collapse in" id="collapseExample">   
        <div class="row bottom_gap">

            <label><input type="checkbox" class="checkAll selectAll" onclick="toggleAll()"> Select All</label> 
            <?php //echo $this->uri->segment(3);?>
    <div class="SelectAllAction">       
        <button class="btn btn-primary" onclick="approveAll()">Approve All</button>

        <button class="btn btn-primary" onclick="showpopup('reassign')">Re-assign</button>

        <button class="btn btn-primary" onclick="showpopup('re-schedule')">Re-schedule</button>
    </div>

            <button class="btn btn-success pull-right" type="button" onclick="redirect_to_bulk_task_replication()">Click to bulk copy tasks</button>
        </div>
        <?php
//        $this->util_model->printr($my_tasks);
        if (empty($my_tasks)) {
            echo "No More Tasks Found!!";
        } else {

            $i = $s_no;
            foreach ($my_tasks as $value) {
                //  $this->util_model->printr($value);
                // die();
                ?>
                <table class="table table-bordered">
                    <tr>
<!--                        <th style="font-weight: bold;" colspan="8" class="text-center"><?php //echo "#Task Name: {$value['tm_name']}({$value['tm_code']})"; ?> </th>-->
                        <th style="font-weight: bold;" colspan="8" class="text-center">Task Name: &nbsp;<?php echo $value['tm_name'];?> <strong>&nbsp;&nbsp;&nbsp;State</strong> :<?php echo $this->util_model->get_state($value['state_id']);?> &nbsp;&nbsp;&nbsp; <strong>Period&nbsp;:</strong> <?php echo $value['month'];?> &nbsp;&nbsp;&nbsp;<strong>Year&nbsp; :</strong> <?php echo $value['year'];?>-<?php echo $value['year']+1;?> </th>
                    </tr>
                    <tr>
                        <th>S.no</th>
                        <th>Task Category</th>
                        <th>Task Type</th>
                        <?php
                        if ($value['billedFrom'] != '' && $this->util_model->get_authStatus('manage_bills', 'print_bill')) {
                            echo "<th><b class='text-success'>BilledFrom</b></th>";
                        }
                        ?>
                        <th>Total Sub Tasks</th>
                        <th>Client Name</th>
                        <th>In charge</th>
                        <th>Progress/Completion</th>
                        <th>Target Date</th>
                        <th style="width: 100px;">Action</th>
                    </tr>
                    <tr class="<?php //echo $value['progress_flag'] == COMPLETED_APPROVAL ? "strikeout" : ""       ?>">
                        <td><?= $i++; ?>
                            
                            <input type="hidden" name="client_id" id="client_id" value="<?php echo $value['client_id'] ?>">

                            <input type="checkbox" name="tm_id[]" value="<?php echo $value['tm_id']; ?>" class="tm_id_checkbox check_box"></td>

                        <td><?php echo $value['skill_dev_activity'] ? "Skill Development" : "Other" ?></td>
                        <td><a href="<?php echo base_url("tms/manage_task_logs/index/" . $value['tm_id']); ?>" title="click here to get task history"><?= $value['ttm_name'] . "(:{$value['tm_id']})"; ?></a></td>
                        <?php
                        if ($value['billedFrom'] != '' && $this->util_model->get_authStatus('manage_bills', 'print_bill')) {
                            echo "<td><b class='text-success'>{$value['billedFrom']}</b><br><a href='" . base_url("tms/manage_bills/print_bill/{$value['bill_mst_id']}") . "'>PrintBill</a></td>";
                        }
                        ?>
                        <td><?= $value['total_sub_task'] ?></td>

                        <td><?= $value['client_name'] ?></td>
                        <td><?= $value['Incharge_name'] ?></td>
                        <td><?php
                            echo $this->util_model->get_progress_flag_string($value['progress_flag']);
                            if ($value['progress_flag'] == COMPLETED_APPROVAL) {
                                echo "<br><strong> at " . date(DF, strtotime($value['Mode_DateTime'])) . "</strong> with comments <br> <strong>{$value['close_task_note']}</strong>";
                            }
                            ?></td>
                        <td><?= date(DF, strtotime($value['end_date'])) ?></td>
                        <td><?php
                            if (isset($_POST['does_repeat']) && $_POST['does_repeat']) {
                                ?>
                                <a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index/" . $value['tm_id'] . "?tab=create_replica" ?>" title="Create Replica or repeat this task"  class="btn btn-danger btn-xs" >
                                    <span class="glyphicon glyphicon-repeat"></span> 
                                </a>
                                <?php
                            }
                            if ($value['progress_flag'] != COMPLETED_REQUEST && $value['progress_flag'] != COMPLETED_APPROVAL) {
                                ?>
                                <a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index/" . $value['tm_id'] ?>" title="Edit Task"  class="btn btn-danger btn-xs" >
                                    <span class="glyphicon glyphicon-edit"></span> 
                                </a>
                                <a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index/" . $value['tm_id'] . "?tab=copy_task" ?>" title="Copy Task"  class="btn btn-danger btn-xs" >
                                    <span class="glyphicon glyphicon-file"></span> 
                                </a>
                                <button key="<?= $value['tm_id'] ?>" title="Request to close task" type="button"  class="btn btn-danger btn-xs <?php echo $value['progress_flag'] == COMPLETED_REQUEST ? "" : "close_task" ?>" >
                                    <span class="glyphicon glyphicon-send"></span> 
                                </button>
                                <?php
                            }
                            if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                ?>
                                <button key="<?php echo $value['tm_id'] ?>" type="button"  class="del_task btn btn-xs btn-primary"><span class="glyphicon glyphicon-trash" title="Delete Task"></span>
                                </button>
                                <?php if ($value['progress_flag'] == COMPLETED_REQUEST || $value['progress_flag'] == COMPLETED_APPROVAL) { ?> 
                                    <button key="<?php echo $value['tm_id'] ?>" type="button"  class="reopen_task btn btn-xs btn-primary"><span class="fa fa-level-up" title="Reopen Task"></span>
                                    </button>

                                    <?php
                                }
                                if ($value['progress_flag'] == COMPLETED_REQUEST) {
                                    ?> 
                                    <button key="<?php echo $value['tm_id'] ?>" client_id="<?php echo $value['client_id'] ?>"  type="button" req_msg ="<?php echo $value['close_task_note']; ?>"  class="final_close_task btn btn-xs btn-danger"><span class="fa fa-check" title="Final close this Task"></span>
                                    </button>
                                    <a href="<?php echo base_url("tms/manage_bills/index/") . $value['tm_id']; ?>"  target="_blank"  class="hide gen_bill">
                                        <button key="<?php echo $value['tm_id'] ?>" type="button" class="btn btn-xs btn-info"><span class="fa fa-send-o" title="Generate Bill"></span>
                                        </button>
                                    </a>

                                    <?php
                                }
                                if ($value['progress_flag'] == COMPLETED_APPROVAL && $value['BillingDone'] == 0) {
                                    ?> 

                                    <a href="<?php echo base_url("tms/manage_bills/index/?tm_id=" . $value['tm_id']); ?>" class="gen_bill" target="_blank" >
                                        <button key="<?php echo $value['tm_id'] ?>" type="button"  class="btn btn-xs btn-info"><span  class="fa fa-send-o" title="Generate Bill"></span>
                                        </button>
                                    </a>

                                    <?php
                                }
//                                else{
//                                      echo $value['billedFrom'];
//                                }
                            }
                            ?>
                            
                       <button data-id="<?php echo $value['tm_id'] ?>" class="clickattach btn btn-xs btn-danger"><span style="font-size:16px;" class="fa fa-paperclip" title="Attach file"></span>
                                    </button>
                            
                                <!--<button data-id="<?php //echo $value['tm_id'] ?>" class="clickattach">Attach File</button>-->
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8" style="text-align: center;font-weight: bold;">Remarks</th>
                    </tr>
                    <tr  class="<?php //echo $value['progress_flag'] == COMPLETED_APPROVAL ? "strikeout" : ""      ?>">
                        <td></td>
                        <td style="font-style: italic;" colspan="5">
                            <?php echo $value['extra_note'] ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="7">
                            <table class="table sub_task_table">
                                <tr class="sub_header">
                                    <th style="text-align: center;font-weight: bold;" colspan="7">Sub Tasks
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
                                    <th style="width: 70px;">Action</th>
                                </tr>
                                <?php
                                $j = 1;
                                foreach ($value['sub_task_data'] as $sub_task) {
                                    ?>
                                    <tr style="display: none" class="<?php //echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "strikeout" : ""      ?>">
                                        <td><?= $j++ ?>

                                        </td>
                                        <td><a href="<?php echo base_url("tms/manage_sub_task/taskSingleView/" . $sub_task['tstm_id']); ?>" target="_blank"><?= $sub_task['tstm_name'] . "(ID:{$sub_task['tstm_id']})" ?></a></td>
                                        <td class="sub_task_assigned_to"><?= $sub_task['Emp_Name'] ?></td>
                                        <td class="progress_flag"><?php echo $this->util_model->get_progress_flag_string($sub_task['progress_flag']); ?></td>
                                        <td><?php echo date("F j, Y, g:i a", strtotime($sub_task['str_date_time'])) ?></td>
                                        <td><?php echo date("F j, Y, g:i a", strtotime($sub_task['end_date_time'])) ?></td>
                                        <td>
                                            <?php
                                            if ($value['progress_flag'] == COMPLETED_APPROVAL || $value['progress_flag'] == COMPLETED_REQUEST) {
                                                ?>
                                                <button task_id="<?= $value['tm_id'] ?>" key="<?= $sub_task['tstm_id'] ?>" title="Close Sub Task" type="button"  class="btn btn-danger btn-xs <?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "" : "close_sub_task" ?>" >
                                                    <span class="glyphicon glyphicon-remove"></span> 
                                                </button>
                                                <button key="<?= $sub_task['tstm_id'] ?>" data-toggle="modal" data-target="#myModal" title="Reassign Task" type="button"  class="btn btn-danger btn-xs <?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "" : "reassign_task" ?>" >
                                                    <span class="glyphicon glyphicon-refresh"></span> 
                                                </button>
                                            <?php } ?>

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






            <div class="row bottom_gap">
                <button class="btn btn-success pull-right" type="button" onclick="redirect_to_bulk_task_replication()">Click to bulk copy tasks</button>
            </div>
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


<div class="modal" tabindex="-1" role="dialog" id="myattach"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group m-b">
                        <label>Attach New File</label>
                        <input type="file" class="form-control is_require" id="exampleInputFile" name="Upload_file" />
                    </div>
                </div>
                <div class="loading" style="display: none;">                             
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


            <div class="row link">
                <div class="col-md-6">
                    <ul class="list-group linkItem">
                       

                    </ul>
                </div>
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary upload">Save changes</button>
                        </div>-->
        </div>
    </div>
</div>

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
        if(confirm('Sure to Approve All')){
         var form_data = {'tm_id':[]}; 
        $(".check_box").each(function () {
            if ($(this).prop('checked')) {
                form_data.tm_id.push($(this).val());
            }
        }); 
        preloader.on();
        $.ajax({
            url: "<?php echo base_url() . 'tms/manage_tasks/approveAll' ?>",
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
            alert('reassign');
         }else{
            $("#re-schedulepopup").modal('show');
        }                          
        
    }

    function updateretask() { 
        preloader.on(); 
        var type = $(".type").val(); 
        console.log(type); 
            if(type=='reassign'){ 
            var FormData = $("#reassign").serialize(); 
        }else if(type=='re-schedule'){ 
            var FormData = $("#schedule").serialize(); 
        } 
            $.ajax({ 
            data: FormData, 
            url: "<?php echo base_url() .'tms/manage_tasks/reassign_task' ?>", 
            dataType: "json", 
            type: "POST", 
            success: function (result) { 
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
    }      

    function toggleAll(){
        $(".tm_id_checkbox").prop('checked',$(".checkAll").prop('checked'));
    }
    
    function redirect_to_bulk_task_replication() {
        var form_data = {'tm_id': []};
        $(".tm_id_checkbox").each(function () {
            if ($(this).prop('checked')) {
                form_data.tm_id.push($(this).val());
            }
        });
        redirect_to(get_base_url() + "tms/manage_tasks/start_repllication?tm_id=" + form_data.tm_id.join());
    }
    
    function load_info_level() {
        var client_id = $('#client_id').val();
        console.log(client_id);
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
    
      $(document).ready(function () {
 
        load_info_level();
    });
    
    
    $('.clickattach').on("click", function () {
    id = $(this).data().id;
    console.log(id);
     $.ajax({
        type: "post",
        url: '<?php echo base_url('auth/getfile') ?>',
        data: {"id":id},
        dataType: "json",
        success: function (data) {
             $('.link').show();
             $('.linkItem').html(" ");
          for(i in data){
              console.log(data);
              $('<li class="list-group-item active " style="margin-top:10px">'+
                        '<a href="' + data[i].link + '" style="color:#fff;">'+data[i].file_name+'</a>'+
                        '<button type="button" class="close" data-id="' + data[i].id + '" >'+
                          '<span aria-hidden="true">&times;</span>'+
                        '</button></li>').appendTo('.linkItem'); 
          }
        }
    });
//        $.post("<?php echo base_url('auth/getfile') ?>",{"id":id},function(d){
////            if(d.status==200){
//                 $('.link').show();
//                 var data=d.data;
//               for(i in data){
//                   $('<li class="list-group-item active " style="margin-top:10px">'+
//                            '<a href="' + da[i].link + '" style="color:#fff;">View File</a>'+
//                            '<button type="button" class="close" data-id="4" >'+
//                              '<span aria-hidden="true">&times;</span>'+
//                            '</button></li>').appendTo('.linkItem');
//               } 
////            }
//        });
    $('#myattach').modal('show');
});
$("#exampleInputFile").on("change", function () {
    show_loading();
    var file = document.getElementById("exampleInputFile").files[0];
    var formData = new FormData();
    formData.append('myFile', file);
    formData.append('id', id);
    console.log(formData);
    $.ajax({
        type: "post",
        url: '<?php echo base_url('auth/upload') ?>',
        data: formData,
        dataType: "json",
        async: false,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status == 200) {
                $('.link').show();
//                    $('<a href="' + data.link + '" class="list-group-item list-group-item-action active">View</a>').appendTo('.linkItem');
                $('<li class="list-group-item active " style="margin-top:10px">'+
                        '<a href="' + data.link + '" style="color:#fff;">'+data.upload_data.file_name+'</a>'+
                        '<button type="button" class="close" data-id="'+data.lid+'" >'+
                          '<span aria-hidden="true">&times;</span>'+
                        '</button></li>').appendTo('.linkItem');
                hide_loading();
            } else if (data.status == 500) {
                hide_loading();
                alert(data.error);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
         hide_loading();
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                  //  window.location.href="";
                } 
        
    });

});

function show_loading() {
    $('.loading').show();
}

function hide_loading() {
    $('.loading').hide();
}

$(document).on("click",".close",function(){
    var id=$(this).data().id;
     var li=$(this).closest('li');
      $.ajax({
        type: "post",
        url: '<?php echo base_url('auth/remove') ?>',
        data: {"id":id},
        dataType: "json",
        success: function (data) {
           console.log(data);
          if(data.status==200){
              li.hide();
          }
        }
    });
});

$('.bdatetimepicker2').datetimepicker({

                                        format: 'DD-MM-YYYY',

                                        icons: {

                                            time: "fa fa-clock-o",

                                            date: "fa fa-calendar",

                                            up: "fa fa-arrow-up",

                                            down: "fa fa-arrow-down"

                                        }

                                    });

</script>


<div class="form-feed modal fade" id="re-schedulepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
        <div class="modal-dialog"> 
            <div class="modal-content" style="width: 117%"> 
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                    <h4 class="modal-title" >Re Schedule1</h4> 
                </div> 
                <div class="modal-body"> 
                    <div class="col-lg-12"> 
                        <form id="schedule" method="post"> 
                            <div class="row bottom_gap  show_date"> 
                    <div class="col-lg-12 "> 
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">From</div> 
                        <div class="col-lg-4 col-md-4 col-sm-8"> 
                            <div class='input-group date bdatetimepicker2' > 
                                 <input type="hidden" class="tm_id" name="tm_id" /> 
                                        <input type="hidden" class="type"  name="form_type" /> 
                                <input type='text' class="form-control str_date_time" name="start_date" value="<?php echo  date('d-m-Y') ?>"/> 
                                <span class="input-group-addon"> 
                                    <span class="glyphicon glyphicon-calendar"></span> 
                                </span> 
                            </div>  
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">To</div> 
                        <div class="col-lg-4 col-md-4 col-sm-8"> 
                            <div class='input-group date bdatetimepicker2' > 
                                <input type='text' class="form-control end_date_time" name="end_date" value="<?php echo date(DTF, strtotime("+7 days")) ?>"/> 
                                <span class="input-group-addon"> 
                                    <span class="glyphicon glyphicon-calendar"></span> 
                                </span> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
                        </form> 
                    </div> 
                </div> 
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    <button type="button" class="btn btn-primary" onclick="updateretask();">Save changes</button> 
                </div> 
            </div> 
        </div> 
    </div>

    <div class="form-feed modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content" style="width: 117%">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Reassign Task</h4>

                </div>

                <div class="modal-body" id="body_cls">

                    <div class="col-lg-12">

                        <form id="reassign" method="post">

                            

                            <div class="row bottom_gap">

                                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Assigning To<span class="Compulsory">*</span></div>

                                <div class="col-lg-8 col-md-8 col-sm-8">

                                    <div class="form-group">

                                        <input type="hidden" class="tm_id" name="tstm_id" />

                                        <input type="hidden" class="type"  name="form_type" />

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

                    <button type="button" class="btn btn-primary" onclick="updateretask();">Save changes</button>

                </div>

            </div>

        </div>

    </div>