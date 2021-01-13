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
                <h3 class="panel-title toggle_custom">Jobs List with advance filter
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allfaqmenu">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Branch Id</th>
                                <th>JOB CODE</th>
                                <th>Job Descr.</th>
                                <th>Job Address</th>
                                <th>Assigned To</th>
                                <th>Job Status</th>
                                <th>Last Modify</th>
                                <th>Charge</th>
                              
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($jobs_list as $List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td><?= $List['BranchID'] ?></td>
                                              <td><?= $List['jobCode'] ?></td>
                                              <td><?= $List['Job_Description'] ?></td>
                                              <td><?= $List['JobAddress'] ?></td>
                                              <td><?= $List['Emp_Name'] ?></td>
                                              <td><?= $List['JobStatus'] ?></td>
                                              <td><?= $List['Mode_DateTime'] ?></td>
                                              <td><?= $List['JobCharge'] ?></td>
                                              
                                              <td><a href="<?php echo base_url()."job_trkr/c_job_mst/update/".$List['JobID']; ?>">
                                                  <button type="button"   class="btn-xs btn btn-success"  title="Edit <?= mysql_real_escape_string($List['JobID']) ?>">
                                                          <span class="glyphicon glyphicon-edit"></span>
                                                      </button>
                                                  </a>
                                                  <a href="<?php echo base_url()."job_trkr/c_job_mst/delete_row/".$List['JobID']; ?>">
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
