<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_task_search">
        <h3 class="panel-title toggle_custom">Search <?php echo $task_search_for ?> Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body " id="global_task_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='searchBillForm'");
            ?> 
            <div class="row" id="global_adv_adm_search" >
                <div class="row bottom_gap">
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
                            Result Limit
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_hidden("page", 0);
                            echo form_input("limit", 25, "class='form-control' placeholder='Result at one time in number'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Bill Status
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("status", array("0" => "Select Bill status", "1" => "Completed", "2" => "Cancelled"), 0, "class='form-control'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Client
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("client_id", $client_list, 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            From Account
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo form_dropdown("bill_account_id[]", $account_list, 0, "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Billing Type
                        </div>
                        <div class="col-lg-4">
                            <?php
                             echo form_dropdown("bill_type", $btypelist, 0, "class='form-control chosen-select'");
                            ?>
                        </div>
                         
                    </div>
                </div>
               
                

                <!--                <div class="row bottom_gap">
                                    <div class="col-lg-12">
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            Date Wise Searching
                                        </div>
                                        <div class="col-lg-4">
                <?php
                echo form_dropdown("date_wise", array("0" => "Disable", "1" => "Enable"), 0, "class='form-control date-wise'");
                ?>
                                        </div>
                                        
                
                                    </div>
                                </div>-->

                <div class="row bottom_gap">
                    <div class="col-lg-12 hidden show_date">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control str_date_time" name="str_date_time[]" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control end_date_time" name="end_date_time[]" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12 ">
                        <div class="col-lg-4">
                            <button class="btn btn-success" type="button" name="Search" onclick="search_task_data()">
                                <span class="glyphicon glyphicon-search"></span>
                                Search
                            </button>
                            <button class="btn btn-success export_xls hidden" type="button" name="Search" onclick="export_xls()">
                                <span class="glyphicon glyphicon-search"></span>
                                Export Excel
                            </button>
                        </div>
                        <div class="col-lg-8 text-right">
                            <button class="btn btn-info pre_list hidden" type="button" name="Search" onclick="pre_list()">
                                <span class="glyphicon glyphicon-backward"></span>
                                Pre
                            </button>
                            <button class="btn btn-info next_list hidden" type="button" name="Search" onclick="next_list()">
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
<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/chosen.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>
                                function search_task_data() {
                                    preloader.on();
                                    $(".pre_list, .next_list").addClass("hidden");
                                    $(".export_xls").addClass("hidden");
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>tms/manage_bills/get_bill_result",
                                        data: $("#searchBillForm").serialize(),
                                        dataType: "json",
                                        success: function (search_data) {
                                            $("#global_task_search_result").html(search_data['html']);
                                            preloader.off();
                                            $(".export_xls").removeClass("hidden");
                                            $(".pre_list, .next_list").removeClass("hidden");
                                        }
                                    });
                                }

                                function pre_list() {
                                    var page = $("#searchBillForm").find("input[name=page]").val();
                                    if (page > 0) {
                                        page = parseInt(page) - 1;
                                        $("#searchBillForm").find("input[name=page]").val(page);
                                    }
                                    search_task_data();
                                }
                                function next_list() {
                                    var page = $("#searchBillForm").find("input[name=page]").val();

                                    page = parseInt(page) + 1;
                                    $("#searchBillForm").find("input[name=page]").val(page);

                                    search_task_data();
                                }


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

                                function export_csv() {
                                    $("#searchBillForm").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_all_fee_records");
                                    $("#searchBillForm").submit();
                                }
                                function export_xls() {
                                    preloader.on();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>reports/xls_exporter/export_bill_data",
                                        data: $("#searchBillForm").serialize(),
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




</script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>
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
                                    if ($(this).val() == 1) {
                                        $(".show_date").removeClass("hidden");
                                    }
                                    else {
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