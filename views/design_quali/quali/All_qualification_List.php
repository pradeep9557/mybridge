<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Qualification</h4>
        <?php
//        if (isset($error)) {
//            $this->util_model->show_result_error($error, DEL_SUCCESS_MSG, DEL_ERROR_MSG);
//        }
        ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Qualification List With Advance Filter
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Add User</th>
                                <th>Modified</th>
                                <th>Edit</th>
                                <!--<th>Last Modified</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            foreach ($All_qualification_List as $qualification_List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $qualification_List->Code ?></td>
                                    <td><?= $qualification_List->Name ?></td>
                                    <td><?= $qualification_List->Status ?></td>
                                    <td><?= $qualification_List->Add_User ?></td>
                                    <td><?php echo date(DF, strtotime($qualification_List->Mode_DateTime)); ?></td>
                                    <td><form>
                                            <button type="button" name="Edit_Qualification" value="Edit" class="btn btn-success btn-xs" onclick="open_page('<?= base_url() ?>qualification_controller/Edit_qualification/0/0/<?= $this->util_model->url_encode($qualification_List->Code) ?>', '')">
                                                <span class="glyphicon glyphicon-edit"></span> 
                                            </button>
                                            <input type="hidden" name="_key" value="del_qualification"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($qualification_List->Code) ?> Qualification !!" name="_msg"/>
                                            <input type="hidden" value="<?= $qualification_List->Code ?>" name="Qualification_Code"/>
                                            <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
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
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
</script>
