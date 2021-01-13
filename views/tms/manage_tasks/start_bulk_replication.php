<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">

    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Please Fill Additional Details</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                    <h3 class="panel-title toggle_custom">Additional details form<span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allemployee">
                    <form id="bulk_replica_common_data">
                        <div class="row bottom_gap">
                            <?php foreach ($task_list as $eachRow) { ?>
                                <div class='col-md-12'>
                                    <input checked class="task_replicate" type="checkbox" value="<?php echo $eachRow['tm_id']; ?>"> <?php echo "{$eachRow['tm_id']} - ".$eachRow['tm_name'] . "(<strong>{$eachRow['client_name']}</strong>)"; ?>
                                    <div class="message text-bold text-danger"></div>
                                </div>
                            <?php } ?>
                        </div> 
                        <div class="row bottom_gap">

                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">
                                <div class='input-group date bdatepicker task_start_date' >
                                    <input type='text' class="form-control" name="start_date" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">
                                <div class='input-group date bdatepicker task_end_date' >
                                    <input type='text' class="form-control" name="end_date" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> <!--End of row-->
                        <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Show to Client</div>
                             
                                    <div class="form-group col-md-4 col-sm-6">
                                        <?php echo form_dropdown("client_visiblity", array(0 => "No", 1 => "Yes"), (isset($task_data['client_visiblity'])) ? $task_data['client_visiblity'] : 1, "class='form-control client_visiblity' ") ?>
                                    </div>
                                 
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label"> Year - Month</div>
                            
                        <div class="col-md-2 col-sm-6">
                            <?php
                            echo form_dropdown("year", $list_year, @$year, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-md-2 col-sm-6">
                        <?php
                            echo form_dropdown("month", $list_month, @$month, "class='form-control'");
                            ?>
                        </div>
                            
                        </div>

                        <div class="row bottom_gap">

                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Incharge(or <input type="checkbox" name="old_incharge">get from old task)</div>
                             
                                    <div class="form-group col-md-4 col-sm-6">
                                         <?php echo form_dropdown("incharge_id", $incharge, $this->util_model->get_uid(), "class='form-control' ") ?>
                                    </div>
                                  
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label"> State</div>
                            
                        <div class="col-md-4 col-sm-6">
                            <?php
                             echo form_dropdown("state_id", $list_state, @$state_id, "class='form-control state'");

                            ?>
                        </div>
                         
                            
                        </div>







<!-- <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Incharge (or <input type="checkbox" name="old_incharge">get from old task)</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">

                                <div class="col-md-6 padding_0px">
                                    <div class="form-group">
                                        <?php //echo form_dropdown("incharge_id", $incharge, $this->util_model->get_uid(), "class='form-control' ") ?>
                                    </div>
                                </div>
                            </div>  -->




                        <div class="row bottom_gap">

                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">
                                <button type="button" onclick="find_next()">Bulk replicate</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo base_url(); ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script>



    function find_next() {
        var state = $('.state').val();
        var client_visiblity = $('.client_visiblity').val();
        if (state==0) {
            alert('Please choose state.');
        }else if(client_visiblity==0){
            alert('Please choose client visiblity.');
        }else{
            $(".task_replicate").each(function () {
            console.log($(this).prop('checked'));
            if ($(this).prop('checked')) {
                var msg = $(this).siblings(".message").html();
                if (msg == "") {
                    console.log("from loop : " + $(this).val());
                    replicate_task($(this).val(), this);
                }
            }
        });
        } 
    }

    function replicate_task(tm_id, _this) {
        console.log("I m here " + tm_id);
        $(this).siblings(".message").html("Creating replica .... ");
        var form_data = $("#bulk_replica_common_data").serialize();

        form_data = form_data + "&tm_id=" + tm_id;
        console.log(form_data);
        $.ajax({
            url: "<?php echo base_url() . 'tms/manage_tasks/start_repllication' ?>",
            method: "POST",
            data: form_data,
            dataType: "json",
            success: function (result) {
                $(".task_replicate[value=" + result.tm_id + "]").siblings(".message").html(result._err_codes);
                $(".task_replicate[value=" + result.tm_id + "]").attr('checked',false);
                console.log(result);
                preloader.off();
            }
        });
    }

    $('.bdatepicker').datetimepicker({
        format: 'DD-MM-YYYY'
    });
</script>