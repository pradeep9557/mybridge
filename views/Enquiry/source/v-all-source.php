<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Source List
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Branch</th>
                            <th>SID</th>
                            <th>Category</th>
                             <th>Code</th>
                            <th>Name</th>

                            <th>Action  </th>

<!--<th>Last Modified</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($SourceList as $Source) {
                                      ?>
                                      <tr class="odd gradeX">
                                          <td><?= ++$i ?></td>
                                          <td><?= $Source['BranchCode'] ?></td>
                                          <td><?=$Source['SrcId']?></td>
                                          <td><?= $Source['pparent']==""?"Parent":$Source['pparent']; ?></td>
                                           <td><?= $Source['Src_Code'] ?></td>
                                          <td><?= $Source['Src_Name'] ?></td>

                                          <td>
                                              <form>
                                                  <button type="button"   class="btn-xs btn btn-success" onclick="open_page('<?= base_url() ?>Enquiry/source/getDataForUpdate/<?= $Source['SrcId'] ?>', '')" title="Edit">
                                                      <span class="glyphicon glyphicon-edit"></span>
                                                  </button>
                                                  <input type="hidden" name="_key" value="del_source"/>
                                                  <input type="hidden" name="_title" value="<?= $Source['Src_Name'] ?>"/>
                                                  <input  type="hidden" value="You want to delete <?= $Source['Src_Name'] ?> Source !!" name="_msg"/>
                                                  <input type="hidden" value="<?=$Source['SrcId'] ?>" name="src_id"/>
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

<!-- Modal -->
<div class="form-feed modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Source</h4>
            </div>
            <div class="modal-body" id="body_cls">
                <div class="col-lg-12">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="SaveChanges();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
              $(document).ready(function () {
                  $('#dataTables-example').dataTable();
              });

</script>
<script>
              var $modal = $('#ajax-modal');

              $('.ajax').on('click', function (e) {
                  // create the backdrop and wait for next modal to be triggered
                  e.preventDefault();
                  $('body').modalmanager('loading');
                  var RowID = $(this).attr('data-row');


                  setTimeout(function () {
                      $modal.load('hii', '', function () {
                          $.ajax({
                              url: "<?= base_url() . "source/getDataForUpdate/" ?>" + RowID,
                              dataType: 'html',
                              data: '',
                              type: 'POST',
                              success: function (data, textStatus, jqXHR) {
                                  $("#body_cls").children('div').html(data);
                              },
                              error: function (jqXHR, textStatus, errorThrown) {

                              },
                              complete: function (jqXHR, textStatus) {

                              }

                          });

                          $modal.modal();
                      });
                  }, 1500);
              });


              function SaveChanges()
              {
                  var postData = $("#MenuAccessForm").serializeArray();
                      var formURL = $("#MenuAccessForm").attr("action");
                      $.ajax(
                              {
                                      url: formURL,
                                      type: "POST",
                                      data: postData,
                                      success: function (data, textStatus, jqXHR)
                                      {
                                              alert(data);
                                      },
                                      error: function (jqXHR, textStatus, errorThrown)
                                      {
                                              //if fails      
                                      }
                              });
              }

              function DeleteSource(SrcID, that)
              {
                  $.ajax({
                      url: "<?= base_url() . "source/deleteSource/" ?>" + SrcID,
                      type: 'POST',
                      success: function (data, textStatus, jqXHR) {
                          if (data['success'] === true)
                          {
                              $(that).parent('td').parent('tr').remove();
                              //alert(data['success']);
                          }
                      },
                      complete: function (jqXHR, textStatus) {

                      }
                  });
              }
</script>


<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>