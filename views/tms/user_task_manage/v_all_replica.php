<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Replicate Tasks</h4>
        </div>
        
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                    <h3 class="panel-title toggle_custom">Replica Tasks List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allemployee">
                    <h6>Note : Click On the Sub Task name</h6>
                    <div class="table-responsive">
                        <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Sub task Name</th>
                                    <th>In charge Name</th>
                                    <th>Start date</th>
                                    <th>End date</th>
    <!--<th>Last Modified</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($all_task_details as $task_List) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= ++$i ?></td>
                                        <td><a target="_blank" href="<?php echo base_url() . "tms/manage_tasks/index" . "/" . $task_List['tm_id'] . "?tab=create_replica" ?>"><?php echo $task_List['tm_name'] ?></a></td>
                                        <td><?= $task_List['Emp_Name'] ?></td>
                                        <td><?php echo date(DF, strtotime($task_List['start_date'])); ?></td>
                                        <td><?php echo date(DF, strtotime($task_List['end_date'])); ?></td>
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
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
