<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header group_title"><?= $title_window ?></h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            $enq_branchID = (isset($Enq_Details->BranchID)) ? $Enq_Details->BranchID : '';
            if (element($enq_branchID, array($Branch_obj->BranchID => $Branch_obj->BranchCode), FALSE)) {
                          ?>
                      </div>
                      <!-- /.col-lg-12 -->
                  </div>

                  <div class="panel panel-info">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                          <h3 class="panel-title toggle_custom">Basic Details of <?= ucfirst($Enq_Details->StudentName) ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span>

                          </h3>

                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="panel-body collapsed" id="collapseExample">
                          <?php $this->load->view('Enquiry/followups/basic_enq_details') ?>
                      </div>
                  </div>
                  <div class="panel panel-primary">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample1">
                          <h3 class="panel-title toggle_custom">Courses and Sources Details of <?= ucfirst($Enq_Details->StudentName) ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                      </div>
                      <!-- /.col-lg-12 -->

                      <div class="panel-body" id="collapseExample1">

                          <h5 class="group_title">Total Visits of Enquiry <?= count($Enq_Visit_Details) ?></h5>
                          <?php
                          foreach ($Enq_Visit_Details as $EnqV) {
                                        $E_Code = $EnqV->E_Code;
                                        $Visit = $EnqV->Visit;
                                        $All_Course_Code = $this->m_enquiry->all_ecourses_visit_wise($E_Code, $Visit);
                                        $e_courses = "";
                                        foreach ($All_Course_Code as $CList) {
                                                      $e_courses.="$CList->esCourseCode,";
                                        }
                                        $e_courses = substr($e_courses, 0, -1);
                                        ?>      
                                        <div class="panel panel-primary">
                                            <div class="panel-heading" data-toggle="collapse" data-target="#collapseExamplevisit<?= $Visit ?>">
                                                <h3 class="panel-title toggle_custom">Visit <?= $Visit ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                                            </div>
                                            <!-- /.col-lg-12 -->

                                            <div class="panel-body" id="collapseExamplevisit<?= $Visit ?>">
                                                <div class="table-responsive">
                                                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Branch</th>
                                                                <th>Courses</th>
                                                                <th>SrcCat</th>
                                                                <th>SrcID  </th>
                                                                <th>PRO</th>
                                                                <th>Last Modified</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <td>1</td>
                                                        <td><?= $Session_Data['IBMS_BRANCHID'] ?></td>
                                                        <td><?= $e_courses ?></td>
                                                        <td><?= $EnqV->Src_CatName ?></td>
                                                        <td><?= $EnqV->Src_IDName ?></td>
                                                        <td><?= $EnqV->PRO_CODE ?></td>
                                                        <td><?= date(DTF, strtotime($EnqV->Mode_DateTime)) ?></td>
                                                        <td><button class="btn btn-success btn-xs open_me" open_to="follow_form<?= $Visit ?>" title="Follow">
                                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                                            </button>
                                                            <!--                                                            <button class="btn btn-danger btn-xs" title="UnFollow">
                                                                                                                            <span class="glyphicon glyphicon-thumbs-down"></span>
                                                                                                                        </button>-->
                                                            <button class="btn btn-success btn-xs" title="Edit" onclick="edit_e_visit(<?= $EnqV->E_Code ?>,<?= $EnqV->Visit ?>)">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </button>
                                                            <!--<button class="btn btn-danger btn-xs" title="Delete">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </button>-->
                                                            <a href="<?php echo base_url()."adm/cadm/index/$E_Code/$Visit" ?>"><button class="btn btn-info btn-xs" title="Convert Admission">
                                                                <span class="glyphicon glyphicon-transfer"></span>
                                                            </button>
                                                            </a>
                                                            
                                                        </td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12 notification" id="follow_form<?= $Visit ?>">
                                                    <button class="btn btn-danger pull-right btn-xs close_my_parents" title="Close" style="position: relative;top: -22px;right: -9px;">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </button>   
                                                    <?php echo form_open(base_url() . 'Enquiry/followups/save_follow_ups'); ?>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-2">
                                                            <label>EnqCode</label>
                                                            <?php echo form_input('E_Code', $E_Code, "class='form-control' readonly='true'"); ?>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label>Call DateTime</label>
                                                            <div class="form-group">
                                                                <div class='input-group date bdatetimepicker' >
                                                                    <input type='text' class="form-control" name="CallDateTime" value="<?= date(DTF) ?>"/>
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>Visit</label>
                                                            <?php echo form_input('Visit', $Visit, "class='form-control' readonly='true'"); ?>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>Follower</label>   
                                                            <div class="form-group">
                                                                <?php
                                                                echo form_dropdown("FollowerID", $AllUsers, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <label>Response</label>   
                                                            <div class="form-group">
                                                                <?php
                                                                echo form_dropdown("ResponseID", $ResponseList, "", "class='form-control chosen-select'");
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <label>Description</label>   
                                                            <div class="form-group">
                                                                <?php
                                                                echo form_textarea("Description", "", "class='form-control'");
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-5">
                                                            <label>Remarks</label>   
                                                            <div class="form-group">
                                                                <?php
                                                                echo form_textarea("Remarks", "", "class='form-control'");
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-6">
                                                            <label>Notify Next Time</label>
                                                            <input class="bootswitches"   name="nofity_next_flag" type="checkbox"  value="1"  id="pass_toggle" data-label-text="Notify" toggle="yes" toggleid="password_box<?= $Visit ?>">
                                                        </div>
                                                        <span id="password_box<?= $Visit ?>" style="display: none">
                                                            <div class="col-lg-3">
                                                                <label>Next Notify DateTime</label>
                                                                <div class="form-group">
                                                                    <div class='input-group date bdatetimepicker' >
                                                                        <input type='text' class="form-control" name="NextNotifyDateTime" value="<?= date(DTF) ?>" />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!--                                                                <div class="input-group">
                                                                                                                                    <input type="text" name="NextNotifyDateTime" value="<?= date(DF, time()) ?>"  class="form-control" datepicker-popup="{{calendar.dateFormat}}" ng-model="record.NextNotifyDateTime<?= $Visit ?>" is-open="calendar.opened.NextNotifyDateTime<?= $Visit ?>" datepicker-options="calendar.dateOptions" close-text="Close" placeholder="Date of Enquiry" />
                                                                                                                                    <span class="input-group-btn">
                                                                                                                                        <button type="button" class="btn btn-default" ng-click="calendar.open($event, 'NextNotifyDateTime<?= $Visit ?>')"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                                                                                    </span>
                                                                                                                                </div>-->
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label>NextNotifyTo</label>   
                                                                <div class="form-group">
                                                                    <?php
                                                                    echo form_dropdown("NotifyToEmp_ID", $AllUsers, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            if($branch_setting->followup_emails): ?>
                                                            <div class="col-lg-3">
                                                                <label>Mail Notification</label>
                                                                <input class="bootswitches"   name="need_mail_noti_flag" type="checkbox"  value="0"  data-label-text="Mail Notification" toggle="yes">
                                                            </div>
                                                            <?php endif; ?>
                                                            <?php if($branch_setting->followup_sms): ?>
                                                            <div class="col-lg-3">
                                                                <label>Mail Notification</label>
                                                                <input class="bootswitches"   name="need_sms_noti_flag" type="checkbox"  value="0"  data-label-text="SMS Notification" toggle="yes">
                                                            </div>
                                                            <?php endif; ?>
                                                        </span>   

                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-3">
                                                            <button class="btn btn-success" title="Convert Admission">
                                                                <span class="glyphicon glyphicon-floppy-disk"></span> Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>

                                                <div>
                                                    <h5 class="group_title">Follow Up Details of Visit <?= $Visit ?></h5>
                                                    <div class="table-responsive">
                                                        <?php
                                                        $fdetails = $this->m_enquiry->follow_up_list_via_e_code($E_Code, $Visit);
                                                        if (empty($fdetails)) {
                                                                      echo "Not Followed Yet !!";
                                                        } else {
                                                                      //  $this->util_model->printr($fdetails);
                                                                      ?>
                                                                      <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
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
                                                                                  <th>Action</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody>
                                                                              <?php
                                                                              $s_no = 0;
                                                                              foreach ($fdetails as $f) {
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
                                                                                                <td>
                                                                                                    <form>
                                                                                                        <input type="hidden" name="_key" value="del_followup_record"/>
                                                                                                        <input type="hidden" name="_title" value="Follow up"/>
                                                                                                        <input  type="hidden" value="You want to delete this !!" name="_msg"/>
                                                                                                        <input type="hidden" value="<?=$f->FollowID ?>" name="ID"/>
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
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                          <?php }
                          ?> 
                      </div>

                  </div>
                  <?php
    } else {
                  echo "This enquiry doesn't exists or this enquiry belongs to other branch !!";
    }
    ?>
</div>
<style>
    .notification{
        box-shadow: 0 0 5px;
        /*border: thin solid;*/
        /*height: 270px;*/
        padding: 17px 0px;
        display: none;
    }
</style>
<script>
              $(document).ready(function () {
                  $(".close_my_parents").click(function () {
                      $(this).parent().slideUp(1000);
                  });
                  $(".open_me").click(function () {
                      var id = $(this).attr("open_to");
                      $("#" + id).slideToggle(1000);
                  });



              });


</script>
<!-- Model for edit visit -->
<div class="form-feed modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Enquiry Visit</h4>
            </div>
            <div class="modal-body" id="body_cls">
                <div class="col-lg-12">
                    <form id="MenuAccessForm" method="post" action="<?= base_url() . "sp-admin/m/UpdateMenuAccess/" ?>">

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="SaveChanges();">Save changes</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
              var $modal = $('#ajax-modal');
              function edit_e_visit(E_Code, Visit) {
                  window.location = "<?= base_url() . "Enquiry/enquiry/edit_e_visit/" ?>" + E_Code + "/" + Visit;
                  // create the backdrop and wait for next modal to be triggered
                  $('body').modalmanager('loading');
                  setTimeout(function () {
                      $modal.load('hii', '', function () {
                          $.ajax({
                              url: "<?= base_url() . "Enquiry/enquiry/edit_e_visit/" ?>" + E_Code + "/" + Visit,
                              dataType: 'html',
                              data: '',
                              type: 'POST',
                              success: function (data, textStatus, jqXHR) {
                                  $("#body_cls").children('div').children('form').html(data);
                              },
                              error: function (jqXHR, textStatus, errorThrown) {

                              },
                              complete: function (jqXHR, textStatus) {

                              }

                          });
                          $modal.modal();
                      });
                  }, 1500);
              }
</script>