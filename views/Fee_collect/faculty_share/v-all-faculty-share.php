
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Jobs</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#allfaqmenu">
                <h3 class="panel-title toggle_custom">Faculty List with advance filter
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allfaqmenu">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Faculty</th>
                                <th>Course</th>
                                <th>Share</th>
                                <th>Status</th>
                                <th>Add User</th>
                                <th>Modified</th>
                                <th>Remarks</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($faculty_list as $List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td><?= $List['FacultyCode'] ?></td>
                                              <td><?= $List['CourseCode'] ?></td>
                                              <td><?= $List['Share']."%" ?></td>
                                              <td><?= $List['Status']?"Enabled" :"Disabled"?></td>
                                              <td><?= $List['AddUserCode'] ?></td>
                                              <td><?= date(DTF,  strtotime($List['Mode_DateTime'])) ?></td>
                                              <td><?= $List['Remarks'] ?></td>
                                              
                                              <td><a href="<?php echo base_url().'fees/faculty_share/update/'.$List['faculty_share_id']; ?>">
                                                  <button type="button"   class="btn-xs btn btn-success"  title="Edit <?= mysql_real_escape_string($List['faculty_share_id']) ?>">
                                                          <span class="glyphicon glyphicon-edit"></span>
                                                      </button>
                                                  </a>
                                                  <a href="<?php echo base_url()."fees/faculty_share/delete_row/".$List['faculty_share_id']; ?>" class="del_confirm">
                                                  <button type="button" value="Del"  class="btn btn-xs btn-danger ">
                                                          <span class="glyphicon glyphicon-trash"></span> 
                                                      </button>
                                                  </a>
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
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>