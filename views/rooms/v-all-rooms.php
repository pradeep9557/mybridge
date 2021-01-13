<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Rooms</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#allfaqmenu">
                <h3 class="panel-title toggle_custom">Rooms List with advance filter
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allfaqmenu">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Room Code</th>
                                <th>Max.Stu</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Last Modified</th>
                                <th>Get Timings</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($rooms_list as $List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td onclick="get_timings(this,<?php echo $List->rid; ?>, 3)"><?= $List->rcode ?></td>
                                              <td><?= $List->max_students ?></td>
                                              <td><?= ($List->Status) ? "Actived" : "Deactived" ?></td>
                                              <td><?= $List->Remarks ?></td>
                                              <td>
                                                  <?php echo date(DTF, strtotime($List->Mode_DateTime)); ?>
                                              </td>
                                              <td>
                                                  <button onclick="get_timings(this,<?php echo $List->rid; ?>, 3)" class="btn" >get timings</button>
                                                  <div class="element_details">
                                                  </div>
                                              </td>

                                              <td>

                                                  <form>
                                                      <a href="<?= base_url() ?>rooms/c_room/update/<?= ($List->rid) ?>">
                                                          <button type="button"   class="btn-xs btn btn-success"  title="Edit <?= mysql_real_escape_string($List->rid) ?>">
                                                              <span class="glyphicon glyphicon-edit"></span>
                                                          </button>
                                                      </a>
                                                      <input type="hidden" name="_key" value="del_room"/>
                                                      <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->rcode) ?>"/>
                                                      <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->rcode) ?> Room ??" name="_msg"/>
                                                      <input type="hidden" value="<?= $this->util_model->url_encode($List->rid) ?>" name="rid"/>
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
              $(document).ready(function () {
                  $('#dataTables-faq-menu').dataTable();
              });
              
              
</script>
