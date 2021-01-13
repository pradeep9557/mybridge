<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">  
            <h4 class="page-header ">Sub-Task Manger</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $sub_task_search_view;
            ?>
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
    
    <div class="form-feed modal fade" id="re-schedulepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 117%">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Re Schedule</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <form id="schedule" method="post">
                            
                            <div class="row bottom_gap  show_date">
                    <div class="col-lg-12 ">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">From</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker2' >
                                 <input type="hidden" class="tm_id" name="tstm_id" />
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
</div>
<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>
                        var global_id = "";
                        var global_reassign_val = "";



                        function SaveChanges() {
                            preloader.on();
                            var new_assinged_to = $("#MenuAccessForm").find("select[name=new_assignedto] option:selected").text();
                            new_assinged_to = new_assinged_to.substring(0, new_assinged_to.indexOf("("));
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
                                        global_reassign_val.parent().parent().find(".sub_task_assigned_to").text(new_assinged_to);
                                        global_reassign_val.parent().parent().find(".sub_task_assigned_to").animate({opacity: 0}, 400, "linear", function () {
                                            $(this).css({color: 'red'});
                                            $(this).animate({opacity: 1}, 400);
                                        });
//                                        global_reassign_val.parent().parent().remove();
                                    } else {
                                        swal("Oops!..", result._err_codes, "error");
                                    }
                                    preloader.off();
                                }
                            });
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
                                url: get_base_url() + "tms/manage_tasks/reassign_sub_task",
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
                                      
//                                        global_reassign_val.parent().parent().remove();
                                    } else {
                                        swal("Oops!..", result._err_codes, "error");
                                    }
                                    preloader.off();
                                }
                            });
                        }

                        function init() {
                            var $modal = $('#ajax-modal');
                            $(document).unbind('.reassign_task .del_sub_task .close_sub_task');

                            $('.del_sub_task').on('click', function () {
                                var $ref = $(this);
                                swal({
                                    title: "Are you sure you want to delete this sub task?",
                                    text: "You will not be able to recover this sub task and related data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                }, function (isConfirm) {
                                    if (isConfirm) {
                                        preloader.on();
                                        $.ajax({
                                            url: get_base_url() + "tms/manage_tasks/del_sub_task",
                                            data: "tstm_id=" + $ref.attr("key"),
                                            type: 'POST',
                                            dataType: 'JSON',
                                            success: function (result) {
                                                if (result.succ) {
                                                    sweetAlert({
                                                        title: "Sub Task Deleted successfully",
                                                        text: '',
                                                        type: "success",
                                                        html: true
                                                    });
                                                } else {
                                                    sweetAlert({
                                                        title: "Error while deletion",
                                                        text: '',
                                                        type: "error",
                                                        html: true
                                                    });
                                                }
                                                preloader.off();
                                            }
                                        });
                                    } else {
                                        swal("Cancelled", "Your Sub task is safe", "error");
                                    }
                                });
                            });
                            
                            $('.close_sub_task').on('click', function () {
                                var $ref = $(this);
                                swal({
                                    title: "Are you sure you want to Close this sub task?",
                                    text: "status will be mark as done!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Yes, close it!",
                                    closeOnConfirm: false
                                }, function (isConfirm) {
                                    if (isConfirm) {
                                        preloader.on();
                                        $.ajax({
                                            url: get_base_url() + "tms/manage_sub_task/close_sub_task",
                                            data: "tstm_id=" + $ref.attr("key"),
                                            type: 'POST',
                                            dataType: 'JSON',
                                            success: function (result) {
                                                if (result.succ) {
                                                    sweetAlert({
                                                        title: "Sub Task closed successfully",
                                                        text: '',   
                                                        type: "success",
                                                        html: true
                                                    });
                                                } else {
                                                    sweetAlert({
                                                        title: "Error while closing your sub task",
                                                        text: result._err_codes,
                                                        type: "error",
                                                        html: true
                                                    });
                                                }
                                                preloader.off();
                                            }
                                        });
                                    } else {
                                        swal("Cancelled", "Your Sub task is safe", "error");
                                    }
                                });
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
                                                swal("Oops!!", result._err_codes, "error");
                                                $('.whom_instr').html($('<option>').text("Select Type").attr('value', 0));
                                            } 
                                            preloader.off();
                                        }
                                    });
                                   
                                }, 1500);
                            });
                        }
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