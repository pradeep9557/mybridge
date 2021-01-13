
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Designation</h4>
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
                Designation List With Advance Filter
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

                            foreach ($All_Designation_List as $Designation_List) {
                              //  die(print_r($Designation_List));
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $Designation_List->Code ?></td>
                                    <td><?= $Designation_List->Name ?></td>
                                    <td><?= $Designation_List->Status ?></td>
                                    <td><?= $Designation_List->Add_User ?></td>
                                    <td><?php echo date(DF, strtotime($Designation_List->Mode_DateTime)); ?></td>
                                    <td>
                                        <form>
                                            <button type="button" name="Edit_Designation" id="" value="Edit" class="btn btn-success btn-xs edit_designation" _id="<?= $Designation_List->DID?>">
                                                <span class="glyphicon glyphicon-edit"></span> 
                                            </button>
                                            <input type="hidden" name="_key" value="del_designation"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Designation_List->Code) ?> Designation !!" name="_msg"/>
                                            <input type="hidden" value="<?=$Designation_List->DID?>" name="Designation_ID"/>
                                            <input type="hidden" value="<?=$Designation_List->Code?>" name="_title"/>
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
<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    
    
    
</script>
