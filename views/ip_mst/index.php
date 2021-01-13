<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>

<div id="page-wrapper" style="min-height: 345px;">
    <!--ng-controller="manage_system_login">-->
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">All Systems</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div> 

    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#global_task_search">
            <h3 class="panel-title toggle_custom">Search System<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right"></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body " id="global_task_search">
            <div class="col-lg-12">

                <form action="<?php echo base_url() ?>ip_mst/c_ip/index" id="syscodeform" method="post" accept-charset="utf-8"> 
                    <input type="hidden" name="page" value="0">
                    <input type="hidden" name="limit" value="25">
                    <div class="row" id="global_adv_adm_search"> 
                        <div class="row bottom_gap">
                            <div class="col-lg-4">
                            </div>
                        </div>


                        <div class="row bottom_gap">
                            <div class="col-lg-12">
                                <div class="col-md-4">
                                    <div class="col-md-2"> Status </div>
                                    <div class="col-md-10">
                                    <select name="status" class="form-control">
                                        <option value="1">Enabled</option>
                                        <option value="0" selected="">Disabled</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-4"> Requested User </div>
                                    <div class="col-md-8">
                                    <?php
                            echo form_dropdown("requested_user",$emp_list, '', "class='form-control'");
                            ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success" type="button" name="Search" onclick="searchSysCode()">
                                        <span class="glyphicon glyphicon-search"></span>
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-12 ">
                                
                                <div class="col-lg-12 text-right">
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

                </form>        </div>
            <div class="col-lg-12" id="global_task_search_result">
                <!-- admuiry search ajax will rendered in this div -->         
            </div>
        </div>
    </div>

</div>
<script>
    function searchSysCode() {
        preloader.on();
        $(".pre_list, .next_list").addClass("hidden");
        $(".export_xls").addClass("hidden");
        $.ajax({
            type: "POST",
            url: $("#syscodeform").attr('action'),
            data: $("#syscodeform").serialize(),
            dataType: "json",
            success: function (search_data) {
                $("#global_task_search_result").html(search_data['html']);
                preloader.off();
//                                            $('#ajax_task_list').DataTable({
//                                                responsive: true
//                                            });
                $(".export_xls").removeClass("hidden");
                $(".pre_list, .next_list").removeClass("hidden");


            }
        });
    }


    function pre_list() {
        var page = $("#syscodeform").find("input[name=page]").val();
        if (page > 0) {
            page = parseInt(page) - 1;
            $("#syscodeform").find("input[name=page]").val(page);
        }
        searchSysCode();
    }
    function next_list() {
        var page = $("#syscodeform").find("input[name=page]").val();

        page = parseInt(page) + 1;
        $("#syscodeform").find("input[name=page]").val(page);

        searchSysCode();
    }

    function change_status(id, status) {
        $.ajax({
            type: "POST",
            url: $("#syscodeform").attr('action'),
            data: "_action=updateStatus&id="+id+"&status="+status,
            dataType: "json",
            success: function (search_data) {
                if (search_data.succ) {
                    searchSysCode();
                    swal("Awesome!!", search_data._err_codes, "success");
                } else {
                    swal("Oops!!", search_data._err_codes, "error");
                }

            }
        });
    }
       function del_ip(id) {
        $.ajax({
            type: "POST",
            url: $("#syscodeform").attr('action'),
            data: "_action=del_ip&id="+id,
            dataType: "json",
            success: function (search_data) {
                if (search_data.succ) {
                    searchSysCode();
                    swal("Awesome!!", search_data._err_codes, "success");
                } else {
                    swal("Oops!!", search_data._err_codes, "error");
                }

            }
        });
    }
    $(document).ready(function(){
        searchSysCode();
    });
</script>