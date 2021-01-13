
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">Faq Question List</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#allfaqmenu">
                <h3 class="panel-title toggle_custom">Faq Questions List
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allfaqmenu">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Menu</th>
                                <th>Question</th>
                                <th>Answer</th>
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
                            $i = 0;
                            foreach ($faq_qus_list as $List) {
                                          ?>
                                          <tr class="odd gradeX">
                                              <td><?= ++$i ?></td>
                                              <td><?= $List->menu_heading ?></td>
                                               <td><?= $List->question ?></td>
                                                <td><?= $List->ans ?></td>
                                              <td><?= ($List->Status) ? "Enabled" : "Disabled" ?></td>
                                              <td><?= $List->AddEmpCode ?></td>
                                              <td><?= $List->ModeEmpCode ?></td>
                                               <td><?= $List->Remarks ?></td>
                                             <td>
                                                            <?php echo date(DTF, strtotime($List->Mode_DateTime)); ?>
                                             </td>       
                                               <td>
                                                  <form>
                                                      <a href="<?php echo base_url()."faqs/faq_edit_ques/".$List->fqid ?>"><button type="button"   class="btn-xs btn btn-success"title="Edit <?= mysql_real_escape_string($List->fqid) ?>">
                                                          <span class="glyphicon glyphicon-edit"></span>
                                                      </button>
                                                      </a>
                                                      <input type="hidden" name="_key" value="del_faq_ques"/>
                                                      <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->question) ?>"/>
                                                      <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->question) ?> Faq Quesiton ??" name="_msg"/>
                                                      <input type="hidden" value="<?= $this->util_model->url_encode($List->fqid) ?>" name="fqid"/>
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
