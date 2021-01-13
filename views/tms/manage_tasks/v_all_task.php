<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Users</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                <h3 class="panel-title toggle_custom">User List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allemployee">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Sub task Name</th>
                                <th>In charge Name</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Edit</th>

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
                                        <td><?= $task_List['tm_name'] ?></td>
                                        <td><?= $task_List['Emp_Name'] ?></td>
                                        <td><?php echo date(DF, strtotime($task_List['start_date'])); ?></td>
                                        <td><?php echo date(DF, strtotime($task_List['end_date'])); ?></td>
                                        <td>
                                            <form>
                                                <a href="<?= base_url() ?>tms/manage_tasks/index/<?= $task_List['tm_id'] ?>"><button type="button" name="Edit_Employee" title="Edit task Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                        <span class="glyphicon glyphicon-edit"></span> 
                                                    </button>
                                                </a>
<!--                                                <input type="hidden" name="_key" value="del_Emp_Code"/>
                                                <input type="hidden" name="_title" value="Employee"/>
                                                <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($task_List['tm_name']) ?> Task !!" name="_msg"/>
                                                <input type="hidden" value="<?= $task_List['tm_id'] ?>" name="tm_id"/>
                                                <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                    <span class="glyphicon glyphicon-trash"></span> 
                                                </button>-->
                                            </form>
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
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
