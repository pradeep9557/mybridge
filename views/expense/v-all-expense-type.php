
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Expenses Types</h4>
        <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allexpense">
                <h3 class="panel-title toggle_custom">All Expense Types <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allexpenses">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Expense Type</th>
                              <!--  <th>Status</th>-->
                                <th>Add User</th>
                                <th>Modified</th>
                                <th>Description</th>
                                <th>Edit</th>

<!--<th>Last Modified</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($all_types as $list) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $list->ex_type_code ?></td>
                                    <td><?= $list->Add_User ?></td>
                                    <td><?= $list->Mode_User ?></td>
                                    <td><?= $list->Remarks ?></td>
                                    
                                    <td>
                                        <form>
                                            
                                                <a href='<?= base_url() ?>expense/c_ex_type/display_edit_type/<?= $list->ex_type_id ?>'>
                                                <button type="button" name="edit_exp" title="Edit Expenses Type Details" value="Edit" class="btn btn-success btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span> 
                                                </button>
                                                </a>
                                            </button>  
                                            
                                            <a href='<?= base_url() ?>expense/c_ex_type/delete_expense_type/<?= $list->ex_type_id ?>'>
                            <button type="button" value="Del"  class="btn btn-xs btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> 
                            </button>
                                                </a>
                                        </form>
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
