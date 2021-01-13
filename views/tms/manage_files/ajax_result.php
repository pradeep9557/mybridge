<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
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
                        <th>Client <br><strong> Uploaded by</strong></th> 
                        <th>State</th> 
                        <th>Month - Year</th>
                        <th>Task Type</th> 
                        <th>Remark</th>                         
                        <th>Status</th>
                        <th>Files</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($upload_data as $each_row) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?= ++$i ?></td>
                            <td><?php echo $each_row->client_name."<br><strong>Uploaded by {$each_row->uploaded_by}</strong>" ?>
                                <input type="hidden" name="client_id" id="client_list" value="<?php echo $each_row->client_id ?>">
                                <input type="hidden" name="reject_value" id="reject_value" value="0">
                            </td> 
                            <td><?= $each_row->state_name ?></td>
                          
                            <td><?= date("M 'Y", strtotime($each_row->year.'-'.$each_row->month.'-'.date('d'))) ?></td>
                            <td><?= $each_row->ttm_name ?>
                                <a href="<?php echo base_url() . "tms/manage_tasks/my_tasks?year={$each_row->year}&month={$each_row->month}&state_id={$each_row->state}&client_id={$each_row->client_id}&ttm_id={$each_row->ttm_id}";?>">
                                   <?php echo "<strong>{$each_row->totalTaskMatched} Active Task Matched</strong>"; ?>
                                </a>
                            </td>
                            <td><?= $each_row->remarks ?></td>
                            <td><?= $each_row->status_name ?></td>
                            <td> <button data-toggle="collapse"  class="btn btn-xs btn-primary" data-target="#files<?php echo $each_row->file_id ?>">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                    View Files
                                </button>

                                <div id="files<?php echo $each_row->file_id ?>" class="collapse">
                                    <?php
                                    $files = @unserialize($each_row->files);
                                    if (!empty($files)) {
                                        echo "<div class='files_details'>";
                                        foreach ($files as $eachFile) {
                                            echo "<br><a href='" . CLIENT_URL . ($eachFile) . "'>{$eachFile}</a>";
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div></td>
                            <td>
                                <?php
                                 if($each_row->status==CLIENT_FILE_PENDING_STATUS){
                                     
//                                     $this->util_model->printr($each_row);
                                ?>
                                <form>
                                    <button type="button" file_id="<?php echo $each_row->file_id ?>" 
                                            client_id="<?php echo $each_row->client_id ?>" class="btn btn-success btn-xs attach" >
                                        <span class="glyphicon glyphicon-send"></span> Attach
                                    </button>
                                    <button type="button" onclick="rejecteddata()" class="btn btn-danger btn-xs " >
                                        <span class="glyphicon glyphicon-send"></span> Reject
                                    </button> 
                                    <a href="<?php echo base_url() . "tms/manage_tasks/index?parent_ttmid={$each_row->parent_ttmid}&year={$each_row->year}&month={$each_row->month}&state_id={$each_row->state}&client_id={$each_row->client_id}&ttm_id={$each_row->ttm_id}&file_id=" . $each_row->file_id ?>">
                                        <button type="button" client_id="<?php echo $each_row->client_id ?>" class="btn btn-primary btn-xs attach" >
                                            <span class="glyphicon glyphicon-plus"></span> Create & Attach
                                        </button>
                                    </a>
                                </form>
                                 <?php } ?>
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
    $(".attach").on("click", function () {
        $(".rejectclass").show();
        $("#action").val('attach_file_with_task');
        $("#show_email").addClass('hidden');
        $("#reject_value").val(0);
        preloader.on();
        var file_id = $(this).attr('file_id');
        $("#task_attach").find('input[name=file_id]').val(file_id);
        // console.log($("#client_data_form").serialize());
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>tms/manage_files/index",
            data: "action=get_pending_task&client_id=" + $(this).attr('client_id'),
            dataType: "json",
            success: function (search_data) {
                console.log(search_data);
                $(".pending_task_list").empty();
                $(search_data.task_list).each(function (index, eachRow) {
//                     console.log(value); 
                    $("#pending_task_list").append('<option value=' + eachRow.tm_id + '>' + eachRow.tm_name + '(' + eachRow.ttm_name + ')</option>');
                });
                $("#task_attach").modal('show');
                preloader.off();

            }
        });
    });
    function rejecteddata() {
        $("#action").val('notify_task');
        $("#show_email").removeClass('hidden');
        $("#task_attach").modal('show');
        $(".rejectclass").hide();
        $("#reject_value").val(1);
        // $("#checked").hide();
    }
    $("#attach_with_task").on("click", function () {
        preloader.on();

 for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
//        var file_id = $(this).attr('file_id');
//        $("#task_attach").find('input[name=file_id]').val(file_id);
        // console.log($("#client_data_form").serialize());
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>tms/manage_files/index",
            data: $(this).parents('form').serialize(),
            dataType: "json",
            success: function (search_data) {
                if (search_data.succ) {
                    
                      swal({
                                        title: "Done!",
                                        text: search_data._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
//                    search_data();
                } else {
                    swal("Error!", search_data._err_codes, "error");
                }
                $("#task_attach").modal('hide');
                preloader.off();
            }
        });
    });
</script>


<div id="task_attach" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Attach Files with Task</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <input type="hidden" name="file_id">
                        <input type="hidden" name="action" id="action" value="attach_file_with_task">
                        <div class="col-md-12 rejectclass">
                            <div class="col-md-4">Select Task</div>
                            <div class="col-md-8">
                                <select id="pending_task_list" name="tm_id" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">Select Client status</div>
                            <div class="col-md-8">
                                <?php
                            echo form_dropdown("status", $status_list,@$status, "class='form-control'");
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 rejectclass">
                        <input type="checkbox" name="show_email" id="checked"> Do you want to notify?
                    </div>


                    <div class="row">
                        <div class="col-md-12 hidden" id="show_email">
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Select Progress 
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <?php
                                            echo form_dropdown("p_id", $client_progress_status, 0, "class='form-control chosen-select client_status'");
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Notify to
                                    </div>
                                    <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <?php
                                            echo form_dropdown("notify_to", array(), 0, "class='form-control client_noti_list'");
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Email Subject
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" name="email_subject" placeholder="email subject" id="email_subject" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Extra Email To
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" name="extra_email_to" placeholder="Extra Email to" id="email_subject" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Extra Email CC
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="text" name="extra_email_cc" placeholder="Extra Email CC" id="email_subject" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        Email Template <br><input type="checkbox" name="notify_email"> (Email Notification)
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <textarea class="form-control" name="email_body" rows="16" id="email_template"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom_gap">
                                <div class="col-lg-12"> 
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                                        SMS Template <br><input type="checkbox" name="notify_sms"> (SMS Notification)
                                    </div>
                                    <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                        <div class="form-group">
                                            <textarea class="form-control editor" rows="3" name="sms_body" id="sms_template"></textarea>
                                            <span class="wordcount">Word Count 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-xs btn-primary" id="attach_with_task">Attach</button>
                            </div>                  
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function load_info_level() {
        var client_id = $('#client_list').val();
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
    $('#checked').click(function () {
        if ($(this).prop("checked") == true) {
            $("#show_email").removeClass('hidden');
            $("#action").val('attach_file_with_notify_task');
        } else if ($(this).prop("checked") == false) {
            $("#show_email").addClass('hidden');
            $("#action").val('attach_file_with_task');
        }
    });
    $(document).ready(function () {
        //   loadtasks();
        CKEDITOR.replace('email_template');
        console.log('working');
        load_info_level();
    });

    $(".client_status").on('change', function () {
        var p_id = $(this).val();
        $.ajax({
            type: "post",
            url: '<?php echo base_url('tms/progress_list/index') ?>',
            data: {p_id: p_id, _action: 'get_data'},
            dataType: "json",
            success: function (data, response) {
                console.log(data);
//                                $("#email_template").html(data.alldata.template)
                CKEDITOR.instances['email_template'].setData(data.alldata.template);
                $("#sms_template").text(data.alldata.sms_template);
                $("#email_subject").val(data.alldata.subject_temp);
            }
        });
    });





</script>

