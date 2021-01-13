
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Expenses</h4>

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allexpense">
                <h3 class="panel-title toggle_custom">Expenses List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allexpenses">
                
                  
    
        <?php

                echo form_open(base_url() . "expense/c_expense/exportxl", "id='export_excel'");
                ?>
                <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="Export" value="Export" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Export
                    </button>
                </div>
            </div>
    <?php

                echo form_close();
                ?>
                
                <br>
                
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Expense Type</th>
                                <th>DO Expense</th>
                                <th>Amount (Rs.)</th>
                                <th>Expense By</th>
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
                            foreach ($all_expenses as $list) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $list->ex_type_code ?></td>
                                    <td><?= date(DF, strtotime($list->ex_date)); ?></td>
                                    <td><?= $list->ex_amt ?></td>
                                    <td><?= $list->Emp_Code ?></td>
                                    <td><?= $list->Add_User ?></td>
                                    <td><?= $list->Mode_User ?></td>
                                    <td><?= $list->ex_des ?></td>
                                    <td>

                                        <form>

                                            <a href='<?= base_url() ?>expense/c_expense/display_edit_expense/<?= $list->ex_id ?>'>
                                                <button type="button" name="edit_exp" title="Edit Expenses Details" value="Edit" class="btn btn-success btn-xs">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>
                                            </a>
                                            
  

                                          <a href='<?= base_url() ?>expense/c_expense/delete_expense/<?= $list->ex_id ?>'>
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
