<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script> 
<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_task_search">
        <h3 class="panel-title toggle_custom">Search <?php echo $search_for ?> Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body " id="global_task_search">
        <div class="col-lg-12">

            <?php
            //die($this->util_model->printr($user_types));
            echo form_open("", "id='search_client_form'");
            
            ?> 
            <div class="row" id="global_adv_adm_search" > 
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            User Type
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_dropdown("usertype[]", $user_types,  array_keys($user_types), "multiple='multiple' class='form-control chosen-select'");
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Result Limit
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <?php
                            echo form_input("limit", 25, "class='form-control' placeholder='Result at one time in number'");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            Order By
                        </div>
                        <div class="col-lg-4">
                            <?php
                            $order_list=array("0"=>"Select",
                                              "ASC"=>"ASC",
                                              "DESC"=>"DESC");
                            echo form_dropdown("order_by", $order_list, $ASC, "class='form-control chosen-select'");
                            ?>
                        </div>
                    </div>
                </div>

                
                <div class="row bottom_gap">
                    <div class="col-lg-12 ">
                        <div class="col-lg-4">
                            <button class="btn btn-success" type="button" name="Search" onclick="search_client_data()">
                                <span class="glyphicon glyphicon-search"></span>
                                Search</button>
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
<script>
$(document).ready(search_client_data());
                               
                                function search_client_data() {
                                    preloader.on();
                                  // console.log($("#search_client_form").serialize());
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>tms/manage_users/get_client_result",
                                        data: $("#search_client_form").serialize(),
                                        dataType: "json",
                                        success: function (search_data) {
                                            console.log(search_data);
                                            $("#global_task_search_result").html(search_data['html']);
                                            preloader.off();
                                            $('#ajax_task_list').DataTable({
                                                responsive: true
                                            });
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