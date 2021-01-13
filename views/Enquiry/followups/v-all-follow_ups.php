<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Follow up notifications</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#followuplist">
                    <h3 class="panel-title toggle_custom">Follow up notification With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!--/.panel-heading--> 
                <div class="panel-body" id="followuplist">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>ECode</th>
                                    <th>Visit</th>
                                    <th>CallDateTime</th>
                                    <th>Response</th>
                                    <th>Description</th>
                                    <th>Follower</th>
                                    <th>Add User</th>
                                    <th>Modified</th>
                                    <th>Remarks</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($todays_follow_up as $f_details) {
                                              ?>
                                              <tr class="odd gradeX" 
                                                  <?php
                                                    if($f_details->ViewNotification){
                                                            echo "style='background:#4A4A4A;color:white'";     
                                                    }
                                                  ?>
                                                  >
                                                  <td><?= ++$i ?></td>
                                                  <td><?= $f_details->E_Code ?></td>
                                                  <td><?= $f_details->Visit ?></td>
                                                  <td><?= date(DTF, strtotime($f_details->CallDateTime)) ?></td>
                                                  <td><?= $f_details->ResponseText ?></td>
                                                  <td><?= $f_details->Description ?></td>
                                                  <td><?= $f_details->FollowerName ?></td>
                                                  <td><?= $f_details->Add_UserCode ?></td>
                                                  <td><?php echo date(DTF, strtotime($f_details->Mode_DateTime)); ?></td>
                                                  <td><?= $f_details->Remarks ?></td>
                                                  <td><form>
                                                          <?php
                                                           if(!$f_details->ViewNotification){
                                                          ?>
                                                          <a onclick="change_me(this, '<?= $f_details->FollowID ?>')" href="javascript:void(0)" url="<?= base_url() ?>Enquiry/followups/index/<?= $f_details->E_Code ?>" title="Follow Up" target="_blank">
                                                              <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                                  <span class="glyphicon glyphicon-thumbs-up"></span>
                                                              </button>
                                                          </a>
                                                           <?php } else{?>
                                                          <a onclick="change_me(this, '')" href="<?= base_url() ?>Enquiry/followups/index/<?= $f_details->E_Code ?>" title="Follow Up" target="_blank">
                                                              <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                                  <span class="glyphicon glyphicon-eye-open"></span>
                                                              </button>
                                                          </a>
                                                          <?php }?>
              <!--                                            <input type="hidden" name="_key" value="del_Enq"/>
                                                          <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Enq_Details->StudentName) ?> Enquiry !!" name="_msg"/>
                                                          <input type="hidden" value="<?= $Enq_Details->E_Code ?>" name="E_Code"/>
                                                          <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                              <span class="glyphicon glyphicon-trash"></span> 
                                                          </button>-->
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
                <!--/.panel-body--> 
            </div>
            <!--         /.panel -->
        </div>
        <!--/.col-lg-12--> 
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Last <?= count($latest_enquiry) ?> Fresh Unfollowed Enquiry List</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                    <h3 class="panel-title toggle_custom">Latest Enquiry List With Advance Filter(EC: Enquiry Code, EFN Enquiry From No) <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!--/.panel-heading--> 
                <div class="panel-body" id="allemployee">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover capitalized_word" id="dataTables-example1">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>EC/EFN</th>
                                    <th>DOE</th>
                                 
                                    <th>Name</th>
                                    <th>FName</th>
                                    <th>Contact No.</th>
                                    <th>SrcCat</th>
                                    <th>SrcCode</th>
                                    <th>PRO</th>
                                   
                                    <th>Add User</th>
                                    <th>Modified</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($latest_enquiry as $Enq_Details) {
                                              ?>
                                              <tr class="odd gradeX">
                                                  <td><?= ++$i ?></td>
                                                  <td><?= $Enq_Details->E_Code ?>/<?= $Enq_Details->EFormNo ?></td>
                                                  <td><?php echo date(DTF, strtotime($Enq_Details->DOE)); ?></td>
                                                 
                                                  <td><?= $Enq_Details->StudentName ?></td>
                                                  <td><?= $Enq_Details->FatherName ?></td>
                                                  <td><?php
                                                      echo $Enq_Details->Mobile1;
                                                      ?></td>
                                                  <td><?= $Enq_Details->SrcCatCode ?></td>
                                                  <td><?= $Enq_Details->SrcCode ?></td>
                                                  <td><?= $Enq_Details->PROCode ?></td>
                                                  <td><?= $Enq_Details->Add_UserCode ?></td>
                                                  <td><?php echo date(DTF, strtotime($Enq_Details->Mode_DateTime)); ?></td>
                                                  <td><form>
                                                          <a href="<?= base_url() ?>Enquiry/enquiry/edit_enquiry/<?= $Enq_Details->E_Code ?>" target="_blank">
                                                              <button type="button" name="Edit_Enquiry" title="Edit Enquiry Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                                  <span class="glyphicon glyphicon-edit"></span> 
                                                              </button>
                                                          </a>
                                                          <a onclick="change_me(this, '')" href="<?= base_url() ?>Enquiry/followups/index/<?= $Enq_Details->E_Code ?>" title="Follow Up" target="_blank">
                                                              <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                                  <span class="glyphicon glyphicon-thumbs-up"></span>
                                                              </button>
                                                          </a>
<!--                                                          <input type="hidden" name="_key" value="del_Enq"/>
                                                          <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Enq_Details->StudentName) ?> Enquiry !!" name="_msg"/>
                                                          <input type="hidden" value="<?= $Enq_Details->E_Code ?>" name="E_Code"/>
                                                          <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                              <span class="glyphicon glyphicon-trash"></span> 
                                                          </button>-->
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
                <!--/.panel-body--> 
            </div>
            <!--         /.panel -->
        </div>
        <!--/.col-lg-12--> 
    </div>
    <?php
//    $this->load->view('Ajax/v-enquiry-search');
    ?>                                       


<!-- Page-Level Demo Scripts - Tables - Use for reference -->

   <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Last <?= count($last_followed_enquiry) ?> Fresh followed Record List</h4>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#lastfollowups">
                    <h3 class="panel-title toggle_custom">Latest Enquiry List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!--/.panel-heading--> 
                    <div class="panel-body" id="lastfollowups">
                              <div class="table-responsive">
                                                        <?php
                                                        if (empty($last_followed_enquiry)) {
                                                                      echo "Not Followed Yet !!";
                                                        } else {
                                                                      //  $this->util_model->printr($fdetails);
                                                                      ?>
                                                                      <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example2">
                                                                          <thead>
                                                                              <tr>
                                                                                  <th>S.No</th>
                                                                                  <th>FollowID</th>
                                                                                  <th>ECode</th>
                                                                                  <th>CallDateTime</th>
                                                                                  <th>ResponseID</th>
                                                                                  <th>Description</th>
                                                                                  <th>Follower</th>
                                                                                  <th>NextNotify</th>
                                                                                  <th>To</th>
                                                                                  <th>Remarks</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody>
                                                                              <?php
                                                                              $s_no = 0;
                                                                              foreach ($last_followed_enquiry as $f) {
                                                                                            ?>
                                                                                            <tr>    
                                                                                                <td><?= ++$s_no ?></td>
                                                                                                <td><?= $f->FollowID ?></td>
                                                                                                <td><?= $f->E_Code ?></td>
                                                                                                <td><?= date(DTF, strtotime($f->CallDateTime)) ?></td>
                                                                                                <td><?= $f->ResponseText ?></td>
                                                                                                <td><?= $f->Description ?></td>
                                                                                                <td><?= $f->FollowerName ?></td>
                                                                                                <td><?= $f->nofity_next_flag ? date(DTF, strtotime($f->NextNotifyDateTime)) : 'None' ?></td>
                                                                                                <td><?= $f->nofity_next_flag ? $f->NextFollowerName : 'None' ?></td>                                        
                                                                                                <td><?= $f->Remarks ?></td>
                                                                                            </tr>

                                                                                            <?php
                                                                              }
                                                                              ?>
                                                                          </tbody>
                                                                      </table>
                                                        <?php } ?>
                                                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
<script>
              $(document).ready(function () {
                  $('#dataTables-example').DataTable({
                      responsive: true
                  });
                   $('#dataTables-example1').DataTable({
                      responsive: true
                  });
                   $('#dataTables-example2').DataTable({
                      responsive: true
                  });
                  $('#data_div').collapse('toogle');
              });
              function change_me(that, Follow_ID) {

                  $(that).parent().parent().parent().css({'background': '#4A4A4A', 'color': 'white'});
                  if (Follow_ID != '') {
                      var url = $(that).attr("url");
                      $.ajax({
                          type: "POST",
                          url: "<?= base_url() ?>Enquiry/followups/set_view_notification/" + Follow_ID,
                          dataType: "json",
                          success: function (result) {
                              if (result['success']) {
                                            window.open(url+'?type=individual','_blank'); // <- This is what makes it open in a new window.
                                 
                              } else {
                                  swal("Cancelled", result['_err_msg'], "error");          
                              }
                              //.animate({opacity: "hide"}, "slow").remove();
                          }
                      });
                  }


              }
</script>