
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Course List

        </h4>
        <?php
//                      if (isset($error)) {
//                      $this->util_model->show_result_error($error,DEL_SUCCESS_MSG,DEL_ERROR_MSG);
//                      
//                      }
        ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Course List With Advance Filter
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
                                <th>Fees</th>
                                <th>Duration</th>
                                <th>Category</th>
                                
                                <th>Status</th>
                                <th>Add User</th>
                                <th>Remarks</th>
                                <th>Modified</th>
                                <th>Edit</th>
                                <!--<th>Last Modified</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($All_Course_List as $Course_List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td><?= $Course_List->CourseCode ?></td>
                                              
                                              <td><?= wordwrap($Course_List->Course_Name, 15) ?></td>
                                              <td><?php echo $Course_List->CourseFee ?></td>
                                              <td><?= $Course_List->Duration . $Course_List->MonthDay ?></td>
                                              <td><?= $Course_List->C_CatName ?></td>

                                              <td><?= ($Course_List->Status) ? "Actived" : "Deactived" ?></td>
                                              <td><?= $Course_List->Add_User ?></td>
                                              <td><?= $Course_List->Remarks ?></td>
              <!--                                                <td><?php // echo date(DF,  strtotime($Course_List->Add_DateTime));  ?></td>-->
                                              <td><?php echo date(DF, strtotime($Course_List->Mode_DateTime)); ?></td>
                                              <td style="min-width: 90px">
                                                  <form>
                                                      <a class="" href="<?= base_url() ?>courses/Edit_Course/<?= ($Course_List->CourseID) ?>">
                                                      <button type="button"   class="btn-xs btn btn-success"  title="Edit <?= mysql_real_escape_string($Course_List->CourseCode) ?>">
                                                          <span class="glyphicon glyphicon-edit"></span>
                                                      </button>
                                                      </a>
                                                      <input type="hidden" name="_key" value="del_course"/>
                                                      <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Course_List->CourseCode) ?> Course !!" name="_msg"/>
                                                      <input type="hidden" value="<?= $this->util_model->url_encode($Course_List->CourseID) ?>" name="ID"/>
                                                      <button  type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                          <span class="glyphicon glyphicon-trash"></span> 
                                                      </button>
                                                      <a class="" href="<?php echo base_url() . "fees/Fee_Master/scfp/" . $Course_List->CourseID ?>">
                                                          <button type="button"   class="btn-xs btn btn-info" title="Set Fee Plan">
                                                              <span class="glyphicon glyphicon-briefcase"></span>
                                                          </button>
                                                      </a>
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
                  $('#dataTables-example').dataTable();
              });
</script>
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>