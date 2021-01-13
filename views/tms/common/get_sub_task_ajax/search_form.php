<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_task_search">
        <h3 class="panel-title toggle_custom">Search <?php echo $task_search_for ?> Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body " id="global_task_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='search_sub_task_form'");
            ?> 
            <div class="row" id="global_adv_adm_search" > 
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Sub task Name
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_input("tstm_name", "", "class='form-control' placeholder='Name Of sub task'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Name
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("tm_id", $task_list, @$tm_id, "class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Result Limit
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_hidden("page", "0");
                            echo form_input("limit", 125, "class='form-control' placeholder='Result at one time in number'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Client Name
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("client_id[]", $client_list, @$client_id, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            In charge
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("incharge_id[]", $incharge, 0, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Job Locality
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("joblocalityid", $locality, 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Work Status
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("progress_flag", $work_type_list, (isset($formdata['progress_flag'])) ? $formdata['progress_flag'] : -1, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Date Wise Searching
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("date_wise", array("0" => "Disable", "1" => "Start Date Wise", "2" => "End Date Wise"), 0, "class='form-control date-wise'");
                            ?>
                        </div>
                    </div>
                </div>
                <!--here-->
                <div class="row bottom_gap hidden show_date">
                    <div class="col-lg-12 ">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">From</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control str_date_time" name="start_date" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">To</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control end_date_time" name="end_date" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Filter By
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("filter_by", array("0" => "Select filter", "1" => "Pending", "2" => "Upcoming", "3" => "All"), (isset($formdata['filter_by'])) ? $formdata['filter_by'] : 0, "class='form-control'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Sort By
                        </div>
                        <div class="col-lg-4">
                            <?php
                            $sort_option = array("1" => "Task Start Date",
                                "2" => "Task End Date",
                                "3" => "Sub Task Start Date",
                                "4" => "Sub Task End Date",
                                "6" => "Incharge",
                                "7" => "Job Locality",
                                "8" => "Client",
                                "9" => "Sub Task Name");
                            if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) {
                                $sort_option['5'] = "Assigned_to";
                            }
                            $sort_option['10'] = "Sub Task ID";
                            $sort_option['11'] = "Modifed Date Time";
                            sort($sort_option);

                            echo form_dropdown("sort_by", array("0" => "Select Sort") + $sort_option, (isset($formdata['sort_by'])) ? $formdata['sort_by'] : 11, "class='form-control'");
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Task Type 
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <?php echo form_dropdown("ttm_id[]", $ttm_list, @$ttm_id, "multiple='multiple' class='form-control chosen-select'"); ?>
                            
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Sub Task Type
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("ttstm_id", $sub_task_type_list, 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Order
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("OrderAscDsc", array("ASC" => "ASC", "DESC" => "DESC"), 'DESC', "class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>


                <?php //  if (in_array($this->util_model->get_utype(), array(DIRECTOR, PARTNER))) { ?>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Assigned to
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("assigned_to[]", $users_list, isset($assignTo) ? $assignTo : 0, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                <?php // } ?>
                <div class="row bottom_gap">
                    <div class="col-lg-12 ">
                        <div class="col-lg-4">
                            <button class="btn btn-success" type="button" name="Search" onclick="search_sub_task_data()">
                                <span class="glyphicon glyphicon-search"></span>
                                Search
                            </button>
                            <button class="btn btn-success export_xls hidden" type="button" name="Search" onclick="export_xls()">
                                <span class="glyphicon glyphicon-search"></span>
                                Export Excel
                            </button>
                        </div>
                        <div class="col-lg-8 text-right">
                            <button class="btn btn-info pre_list" type="button" name="Search" onclick="pre_list()">
                                <span class="glyphicon glyphicon-backward"></span>
                                Pre
                            </button>
                            <button class="btn btn-info next_list" type="button" name="Search" onclick="next_list()">
                                <span class="glyphicon glyphicon-forward"></span>
                                Next
                            </button>
                        </div>
                    </div>
                </div>


            </div>

            <?php
            echo form_close();
            ?>
        </div>
        <div class="col-lg-12" id="global_task_search_result">
            <!-- admuiry search ajax will rendered in this div -->         
        </div>
    </div>
</div>
<div id="reschedule" class="modal fade" role="dialog" style="padding-top: 150px">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Re Schedule</h4>
            </div>
            <div class="modal-body">
                <form id="reschedule_form">
                    <div class="row">
                        <div class="col-md-12"> <h4 id="reqmsg"></h4></div>
                        <input type="hidden" name="tstm_id" id="tstm_id">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-12 ">
                                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                                <div class="col-lg-4 col-md-4 col-sm-8">
                                    <div class='input-group date bdatetimepicker' >
                                        <input type='text' class="form-control str_date_time" name="start_date"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div> 
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End Date</div>
                                <div class="col-lg-4 col-md-4 col-sm-8">
                                    <div class='input-group date bdatetimepicker' >
                                        <input type='text' class="form-control end_date_time" name="end_date" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary" onclick="updateSubTask()">Update</button>
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
<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/chosen.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>

                                    $(function () {
                                        $('#datetimepickeradm6').datetimepicker();
                                        $('#datetimepickeradm7').datetimepicker();
                                        $("#datetimepickeradm6").on("dp.change", function (e) {
                                            $('#datetimepickeradm7').data("DateTimePicker").minDate(e.date);
                                        });
                                        $("#datetimepickeradm7").on("dp.change", function (e) {
                                            $('#datetimepickeradm6').data("DateTimePicker").maxDate(e.date);
                                        });
                                    });

                                    function search_sub_task_data() {
                                        preloader.on();
                                        $(".pre_list, .next_list").addClass("hidden");
                                        $(".export_xls").addClass("hidden");
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>tms/manage_sub_task/get_sub_task_result",
                                            data: $("#search_sub_task_form").serialize(),
                                            dataType: "json",
                                            success: function (search_data) {
                                                $("#global_task_search_result").html(search_data['html']);
                                                preloader.off();
//                                            $('#ajax_task_list').DataTable({
//                                                responsive: true
//                                            });
                                                $(".export_xls").removeClass("hidden");
                                                $(".pre_list, .next_list").removeClass("hidden");
                                                init();

                                            }
                                        });
                                    }


                                    function pre_list() {
                                        var page = $("#search_sub_task_form").find("input[name=page]").val();
                                        if (page > 0) {
                                            page = parseInt(page) - 1;
                                            $("#search_sub_task_form").find("input[name=page]").val(page);
                                        }
                                        search_sub_task_data();
                                    }
                                    function next_list() {
                                        var page = $("#search_sub_task_form").find("input[name=page]").val();

                                        page = parseInt(page) + 1;
                                        $("#search_sub_task_form").find("input[name=page]").val(page);

                                        search_sub_task_data();
                                    }
                                    function export_csv() {
                                        $("#search_sub_task_form").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_all_fee_records");
                                        $("#search_sub_task_form").submit();
                                    }
                                    function export_xls() {
                                        preloader.on();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>reports/xls_exporter/export_sub_task_filter_data",
                                            data: $("#search_sub_task_form").serialize(),
                                            dataType: "json",
                                            success: function (result) {
                                                if (result.succ) {
                                                    window.open(get_base_url() + "uploads/temp_reports/" + result.file_name, '_blank');
                                                } else {
                                                    swal("Oops!!", "Some Probelm Occured", "error");
                                                }
                                                preloader.off();
                                            }
                                        });
                                    }





                                    $('.bdatetimepicker').datetimepicker({
                                        format: 'DD-MM-YYYY',
                                        icons: {
                                            time: "fa fa-clock-o",
                                            date: "fa fa-calendar",
                                            up: "fa fa-arrow-up",
                                            down: "fa fa-arrow-down"
                                        }
                                    });
                                    $(".date-wise").change(function () {
                                        if ($(this).val() == 1 || $(this).val() == 2) {
                                            $(".show_date").removeClass("hidden");
                                        } else {
                                            $(".show_date").addClass("hidden");
                                        }
                                        // console.log($(this).val());
                                    });
                                    
       
</script>
<link href="<?= CDN1 ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/multi_select/prism.js" type="text/javascript"></script>
<script type="text/javascript">
                                    var config = {
                                        '.chosen-select': {},
                                        '.chosen-select-deselect': {allow_single_deselect: true},
                                        '.chosen-select-no-single': {disable_search_threshold: 10},
                                        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                                        '.chosen-select-width': {width: "95%"}
                                    }
                                    for (var selector in config) {
                                        $(selector).chosen(config[selector]);
                                    }

</script>
<?php if (isset($formdata) && !empty($formdata)) { ?>
    <script>

        $(document).on("ready", function () {
            preloader.on();
            $(".export_xls").addClass("hidden");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>tms/manage_sub_task/get_sub_task_result",
                data: $("#search_sub_task_form").serialize(),
                dataType: "json",
                success: function (search_data) {
                    $("#global_task_search_result").html(search_data['html']);
                    preloader.off();
                    $(".export_xls").removeClass("hidden");
                    init();
                }
            });
        });


        function reschedule(tstm_id,start_date_time,end_date_time) {
            $("#reschedule").find("#tstm_id").val(tstm_id);
            $("#reschedule").find("input[name=start_date]").val(start_date_time);
            $("#reschedule").find("input[name=end_date]").val(end_date_time);
            $("#reschedule").modal('show');
        }

        function updateSubTask() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>tms/manage_sub_task/UpdateSubTask",
                data: $("#reschedule_form").serialize(),
                dataType: "json",
                success: function (result) {                    
                    preloader.off();
                    if(result.succ){
                        swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                        
                        $("#reschedule").modal('hide');
                    }else{
                        swal("Oops!!", result._err_codes, "error");
                    }
                }
            });
        }
    </script>
<?php }
?>
