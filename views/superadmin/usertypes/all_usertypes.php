<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All User Type</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                <h3 class="panel-title toggle_custom">User Type List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allemployee">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>

                                <th>User Type</th>
                                <th>Status</th>
                                <th>Sort Order</th>
                                <th>Add User</th>
                                <th>Mode User</th>
                                <th>Added</th>
                                <th>Modified</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            foreach ($all_UserTypes as $ut_List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $ut_List->UserTypeName ?></td>
                                    <?php
                                    if ($ut_List->Status == 1) {
                                        $status = "Enable";
                                    } else {
                                        $status = "Disble";
                                    }
                                    ?>
                                    <td><p><?php echo $status ?></p></td>
                                    <td><?= $ut_List->Sort ?></td>
                                    <td><?= $ut_List->Add_User ?></td>
                                    <td><?= $ut_List->Mode_User ?></td>
                                    <td><?php echo date(DTF, strtotime($ut_List->Add_DateTime)); ?></td>
                                    <td><?php echo date(DTF, strtotime($ut_List->Mode_DateTime)); ?></td>
                                    <td><form>
                                            <button type="button" name="Edit_User Type" title="Edit User Type Basic Details" value="Edit" class="btn btn-success btn-xs" onclick='location.href = "<?php echo base_url() ?>sp-admin/a/editUtype/<?= $ut_List->UTID ?>"'>
                                                <span class="glyphicon glyphicon-edit"></span> 
                                            </button>

                                            <input type="hidden" name="_key" value="del_UID"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($ut_List->UTID) ?> User Type !!" name="_msg"/>
                                            <input  type="hidden" value="Delete" name="_title"/>
                                            <input type="hidden" value="<?= mysql_real_escape_string($ut_List->UTID) ?>" name="UTID"/>
                                            <button type="button"  value="Delete" class="btn btn-danger btn-xs ajax_submit" >
                                                <span class="glyphicon glyphicon-trash"></span> 
                                            </button>
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


<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

