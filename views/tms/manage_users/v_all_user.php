<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All <?php echo $caller == USER ? "Users" : "Clients" ?></h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<style>
    .pre_list{
        padding: 4px 12px;
        font-size: 10px;
    }
    .next_list{
        padding: 4px 12px;
        font-size: 10px;
    }
    .pagin{
            margin-top: -14px;
    }
    .margin_btm{
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <form id="user_list">
            <div class="panel panel-primary">
                <div class="panel-heading"   data-target="#allemployee">
                    <h3 class="panel-title "><?php echo $caller == USER ? "User" : "Client" ?> List With Advance Filter
                        <div class="text-right pagin">
                            <button class="btn btn-info pre_list" type="button" name="Search" onclick="pre_list()">
                                <span class="glyphicon glyphicon-backward"></span>
                                Pre
                            </button>
                            <button class="btn btn-info next_list" type="button" name="Search" onclick="next_list()">
                                <span class="glyphicon glyphicon-forward"></span>
                                Next
                            </button>
                        </div>
                    </h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allemployee">
                    <div class="">
                    <div class="pull-right margin_btm">
                    <select name="limit" class="form-control" onchange="search_user_data()">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    </div>
                    <div class="pull-right margin_btm">
                        <?php
                        echo form_hidden("page", "0");
                        ?>
                         <?php
                        echo form_hidden("type", "ajax");
                        ?>
                        <input type="text" name="search" class="form-control" onkeypress="search_user_data()" placeholder="Search..."> 
                    </div>
                    </div>
                    <div id="user_list_table"></div>
                    


                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </form>  
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<!--<link href="<?= base_url() ?>css/plugins/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>-->
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!--<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.responsive.min.js" type="text/javascript"></script>-->
<script>
                            $(document).ready(function () {
                                $('#dataTables-example').DataTable({
                                    responsive: true
                                });
                                search_user_data();
                            });

                            $(".toggle_pass").on("click", function () {
                                $(this).attr("type", "text");
                            });
                            function pre_list() {
                                var page = $("#user_list").find("input[name=page]").val();
                                if (page > 0) {
                                    page = parseInt(page) - 1;
                                    $("#user_list").find("input[name=page]").val(page);
                                }
                                search_user_data();
                            }
                            function next_list() {
                                var page = $("#user_list").find("input[name=page]").val();

                                page = parseInt(page) + 1;
                                $("#user_list").find("input[name=page]").val(page);

                                        search_user_data();
                            }
                            function search_user_data() {
                                        preloader.on();
                                        $(".pre_list, .next_list").addClass("hidden");
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>tms/manage_users/index",
                                            data: $("#user_list").serialize(),
                                            dataType: "json",
                                            success: function (search_data) {
                                                $("#user_list_table").html(search_data['html']);
                                                preloader.off();
                                                $(".pre_list, .next_list").removeClass("hidden");
                                               

                                            }
                                        });
                                    }
</script>
