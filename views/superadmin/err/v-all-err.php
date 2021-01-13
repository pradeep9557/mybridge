
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">All Error List</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Error List With Advance Filter
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Error ID</th>
                                            <th>Error Code</th>
                                            <th>Error Description </th>
                                            <th>Status</th>
                                            <th>Add User</th>
                                            <th>Mode User</th>
                                            <th>Remarks</th>
                                            <th>Modified</th>
                                         
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=0;
                                         foreach ($all_err_list as $List) {
                                          ?>
                                        <tr class="odd gradeX">
                                            <td><?=++$i?></td>
                                            <td><?=$List->ErrorCode?></td>
                                            <td><?=$List->Description?></td>
                                              <td><?=($List->Status)?"Actived":"Deactived"?></td>
                                            <td><?=$List->AddEmpCode?></td>
                                              <td><?=$List->ModeEmpCode?></td>
                                                <td><?=$List->Remarks?></td>
                                             <td><?php echo date(DTF,  strtotime($List->LastModified)); ?></td>
                                              <td>
                                                  <form>
                                                      <a href="<?= base_url() ?>superadmin/c_err_mst/vedit_err/<?= ($List->ID) ?>" target="_blank">
                                                       <button type="button"   class="btn-xs btn btn-success" title="Edit <?= mysql_real_escape_string($List->ErrorCode)?>">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                        </button>
                                                      </a>
                                                      <input type="hidden" name="_key" value="del_response"/>
                                                      <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->ErrorCode)?>"/>
                                                      <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->ErrorCode)?> ErrorCode !!" name="_msg"/>
                                                      <input type="hidden" value="<?=  $this->util_model->url_encode($List->ID)?>" name="UniqueKey"/>
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
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>