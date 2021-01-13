
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Token</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#allfaqmenu">
                <h3 class="panel-title toggle_custom">Generated token List with advance filter
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allfaqmenu">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Token Msg</th>
                                <th>Notify to</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Sent at</th>
                                <th>Read</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($token_list as $List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td><?= $List->token_msg ?></td>
                                              <td><?= $List->Noti_User ?></td>
                                              <td><?= ($List->Nofi_user_status) ? "Actived" : "Deactived" ?></td>
                                              <td><?= $List->Remarks ?></td>
                                              <td>
                                                 <?php echo date(DTF, strtotime($List->Mode_DateTime)); ?>
                                              </td>
                                              <td>
                                                 <?php 
                                                 if(!$List->n_viewed){
                                                     echo "UnRead";
                                                 }else{
                                                 echo "at ".date(DTF, strtotime($List->ReadDateTime));              
                                                 }
                                                 
                                                               ?>
                                              </td>
                                              
                                              <td>
                                              
                                                  <form>
                                                      <button type="button"   class="btn-xs btn btn-success" onclick="open_page('<?= base_url() ?>Enquiry/c_country/vedit_country/<?= ($List->token_id) ?>', '')" title="Edit <?= mysql_real_escape_string($List->token_id) ?>">
                                                          <span class="glyphicon glyphicon-edit"></span>
                                                      </button>
                                                      <input type="hidden" name="_key" value="del_type"/>
                                                      <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->token_msg) ?>"/>
                                                      <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->token_msg) ?> Token ??" name="_msg"/>
                                                      <input type="hidden" value="<?= $this->util_model->url_encode($List->token_id) ?>" name="token_id"/>
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
