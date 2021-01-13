
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Employee</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                <h3 class="panel-title toggle_custom">Employee List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allemployee">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Code</th>
                                <th>DOJ</th>
                                <th>Name</th>
                                <th>Father's Name</th>
                                <th>Contact No.</th>
                              <!--  <th>Status</th>-->
                                <th>Add User</th>
                                <th>Modified</th>
                                <th>Get days</th>
                                <th>Edit</th>

<!--<th>Last Modified</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($all_emp_details as $Emp_List) {
                                          if ($Emp_List->Emp_Code != "anp") {
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td><?= ++$i ?></td>
                                                            <td><?= $Emp_List->Emp_Code ?></td>
                                                            <td><?php echo date(DF, strtotime($Emp_List->DOJ)); ?></td>
                                                            <td><?= $Emp_List->Emp_Name ?></td>
                                                            <td><?= $Emp_List->FatherName ?></td>

                                                  <!--                                             <td>FacultyCode</td>
                                                  <td>BatchCode</td>-->
                                                            <td><?php
                                                                if ($Emp_List->P_Mob != "")
                                                                              echo $Emp_List->P_Mob;
                                                                else
                                                                              echo $Emp_List->S_Mob;
                                                                ?></td>
                                                            <!--<td><?php //$Emp_List->Status    ?></td>-->
                                                            <td><?= $Emp_List->Add_UserCode ?></td>
                                                            <td><?php echo date(DF, strtotime($Emp_List->Mode_DateTime)); ?></td>
                                                            <td>
                                                                <button onclick="get_timings(this,<?php echo $Emp_List->Emp_ID; ?>, 2)" class="btn" >get timings</button>
                                                                <div class="element_details">
                                                                </div>
                                                            </td>
                                                            <td><form>
                                                                    <a href="<?= base_url() ?>employee/Emp_Edit/<?= $Emp_List->Emp_Code ?>"><button type="button" name="Edit_Employee" title="Edit Employee Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                                            <span class="glyphicon glyphicon-edit"></span> 
                                                                        </button>
                                                                    </a>
                                                                    <a href="<?= base_url() ?>employee/document_attach/<?= $Emp_List->Emp_Code ?>" title="Edit or View Documents and other details" target="_blank">
                                                                        <button type="button" name="Edit_Employee" value="Edit" class="btn btn-info btn-xs">
                                                                            <span class="glyphicon glyphicon-paperclip"></span>
                                                                        </button>
                                                                    </a>
                                                                    <input type="hidden" name="_key" value="del_Emp_Code"/>
                                                                    <input type="hidden" name="_title" value="Employee"/>
                                                                    <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Emp_List->Emp_Code) ?> Employee !!" name="_msg"/>
                                                                    <input type="hidden" value="<?= $Emp_List->Emp_ID ?>" name="Emp_ID"/>
                                                                    <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                                    </button>
                                                                </form>
                                                            </td>

                                                        </tr>
                                                        <?php
                                          }
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