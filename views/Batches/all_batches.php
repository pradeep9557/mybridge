  <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#batch_list">
                    <h3 class="panel-title toggle_custom">Batch List with Advance Filter<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body"  id="batch_list">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="all_batches">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Faculty</th>
                                    <th>Code</th>
                                    <th>Course</th>
                                    <th>Timing</th>
                                    <th>Tot. Cls</th>
                                    <th>Max</th>
                                    <th>Status</th>
                                    <th>Add/Mode</th>
                                    <th>Modified</th>
                                    <th>Edit</th>
                                    <!--<th>Last Modified</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($All_batch_list as $batch_List) {
                                              ?>
                                              <tr class="odd gradeX">
                                                  <td><?= ++$i ?></td>
                                                  <td><?= $batch_List->FacultyCode ?></td>
                                                  <td><?= $batch_List->BatchCode ?></td>
                                                 

                                                  <td><?= $batch_List->CourseCode ?></td>
                                                   <td>
                                                      <button onclick="get_batch_timings(this,<?php echo $batch_List->BatchID; ?>, 1)" class="btn" >get timings</button>
                                                      <div class="element_details">
                                                      </div>
                                                  </td>
                                                  <td><?= $batch_List->Total_Class ?></td>
                                                  <td><?= $batch_List->Max_Std ?></td>
                                                  <td><?= $batch_List->Status ?></td>
                                                  <td><?= $batch_List->Add_UserCode ?>/<?= $batch_List->Mode_UserCode ?></td>
                                                  <td><?php echo date(DF, strtotime($batch_List->Mode_DateTime)); ?></td>
                                                  <td>
                                                      <form>
                                                          <a href="<?= base_url() ?>batch/batch_master/edit_batches/<?= $batch_List->BatchID?>"><button type="button"   class="btn-xs btn btn-success" title="Edit <?= mysql_real_escape_string($batch_List->BatchCode) ?>">
                                                              <span class="glyphicon glyphicon-edit"></span>
                                                          </button>
                                                          </a>
                                                          <input type="hidden" name="_key" value="del_batch"/>
                                                          <input type="hidden" name="_title" value="Batch Code"/>
                                                          <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($batch_List->BatchCode) ?> Batch !!" name="_msg"/>
                                                          <input type="hidden" value="<?= $this->util_model->url_encode($batch_List->BatchID) ?>" name="BatchID"/>
                                                          <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
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
<script>
         
           $(document).ready(function () {
                      $('#all_batches').dataTable();
                  });
</script>