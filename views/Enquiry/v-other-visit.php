<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header group_title"><?=$title_window?></h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            $enq_branchID = (isset($Enq_Details->BranchID)) ? $Enq_Details->BranchID : '';
            if (element($enq_branchID, array($Branch_obj->BranchID=>$Branch_obj->BranchCode), FALSE)) {
                          ?>
                      </div>
                      <!-- /.col-lg-12 -->
                  </div>

                    <div class="panel panel-info">
                      <div class="panel-heading" data-toggle="collapse" data-target="#next_visit_form">
                          <h3 class="panel-title toggle_custom">Next Visit Form For <?= ucfirst($Enq_Details->StudentName) ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span>

                          </h3>

                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="panel-body" id="next_visit_form">
                          <?php
            echo form_open_multipart(base_url() . 'Enquiry/enquiry/saveothervisit', "id='new_enq_form'");
            ?>
            <!--String of Row-->
          
                     <div class="row bottom_gap col-lg-12">
                        <div class="col-lg-12"><h5 class="group_title">Course, Source & PRO Details</h5></div>
                        <div class="row bottom_gap col-lg-12">
                            <div class="row">
                                <div class="col-lg-2" id="SelectCourse">
                                    <label>Course Category</label>    
                                    <div class="form-group" id="coursecat">
                                        <?php
                                        echo form_hidden("E_Code",$Enq_Details->E_Code);
                                        echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)'") ?>
                                    </div>
                                </div>
                                <div class="col-lg-10" id="SelectCourse">
                                    <label>Course List<span class="Compulsory">*</span></label>    
                                    <div class="form-group" id="courselist">
                                        <?php echo form_multiselect("CourseID[]", $All_Course_List, "", "class='form-control chosen-select'") ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                            <label>Enquiry DateTime<span class="Compulsory">*</span></label>
                            <div class="form-group">
                                <div class='input-group date bdatetimepicker' >
                                    <input type='text' class="form-control" name="DOE" value="<?= date(DTF) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                                <div class="col-lg-2">
                                    <label>Source Category <span class="Compulsory">*</span></label>   
                                    <div class="form-group">
                                        <?php
                                        echo form_dropdown("Src_CatID", $SourceCatList, "", "class='form-control  chosen-select' onchange='load_parents(" . $Session_Data['IBMS_BRANCHID'] . ",this.value)'");
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Source<span class="Compulsory">*</span></label>   
                                    <div class="form-group" id="child_src">
                                        <?php
                                        echo form_dropdown("Src_ID", array(), "", "class='form-control chosen-select' ");
                                        ?>
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <label>PRO<span class="Compulsory">*</span></label>   
                                    <div class="form-group">
                                        <?php
                                        echo form_dropdown("PRO", $AllPRO, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <label>Visit</label>   
                                    <div class="form-group" >
                                        <?php
                                        $visit = count($Enq_Visit_Details)+1;
                                        echo form_dropdown("Visit", array($visit=>$visit), '', "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Remarks</div>
                        <div class="col-lg-4">
                            <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                        </div>
                    </div>
                  <div class="row bottom_gap col-lg-12">
                        <div class="col-lg-12 padding_top_label group_title">Preferred Timing</div>
                        <div class="row bottom_gap col-lg-12" id="append_timerpicker">
                            <div class="padding_left_0px col-lg-6 bottom_gap">
                                <div class="col-lg-4">
                                    <label>From</label>
                                    <div class="form-group">
                                        <div class='input-group date' id="Trang1">
                                            <input type='text' class="form-control" name="Str_Time[]" value="<?= date(DT) ?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>To</label>
                                    <div class="form-group">
                                        <div class='input-group date' id="Trang2">
                                            <input type='text' class="form-control" name="End_Time[]" value="<?= date(DT) ?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                              $(function () {
                                                  $('#Trang1').datetimepicker({
                                                      format: 'hh:mm A',
                                                      icons: {
                                                          up: "fa fa-arrow-up",
                                                          down: "fa fa-arrow-down"
                                                      }
                                                  });
                                                  $('#Trang2').datetimepicker({
                                                      format: 'hh:mm A',
                                                      icons: {
                                                          up: "fa fa-arrow-up",
                                                          down: "fa fa-arrow-down"
                                                      }
                                                  });
                                                  $("#Trang1").on("dp.change", function (e) {
                                                      $('#Trang2').data("DateTimePicker").minDate(e.date);
                                                  });
                                                  $("#Trang2").on("dp.change", function (e) {
                                                      $('#Trang1').data("DateTimePicker").maxDate(e.date);
                                                  });
                                              });
                                </script>
                                <div class="padding_left_0px col-lg-4 padding_top_label text-center">
                                    <label>More</label>
                                    <div class="row">
                                        <button class="btn btn-success add_prefer_time"  onclick="add_tr_picker(this)" id="1" style="padding: 8px 12px;margin-top: -7px;" type="button">
                                            <span class="glyphicon glyphicon-plus"></span>           
                                            <!--</button>
                                             <button class="btn btn-danger remove_prefer_time" onclick="removetrp(this)" id="1" style="padding: 8px 12px;margin-top: -7px;" type="button">
                                                 <span class="glyphicon glyphicon-minus"></span>           
                                             </button>-->
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                    
                <div class="row col-lg-12">
                <button type="submit" name="Addvisit" value="Add Visit" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Add Visit
                </button>
                <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-refresh"></span> Reset
                </button>

            </div>
            <?php echo form_close(); ?>
                      </div>
                  </div>
                  <div class="panel panel-info">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                          <h3 class="panel-title toggle_custom">Basic Details of <?= ucfirst($Enq_Details->StudentName) ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span>

                          </h3>

                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="panel-body" id="collapseExample">
                         <?php $this->load->view('Enquiry/followups/basic_enq_details') ?>
                      </div>
                  </div>
                  <div class="panel panel-primary">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample1">
                          <h3 class="panel-title toggle_custom">Previous Visits Details of <?= ucfirst($Enq_Details->StudentName) ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
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
                                                        <td><button class="btn btn-success btn-xs open_me" type="button" open_to="follow_form<?= $Visit ?>" title="Follow">
                                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                                            </button>
<!--                                                            <button class="btn btn-danger btn-xs" title="UnFollow">
                                                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                                            </button>-->
                                                            <button class="btn btn-success btn-xs" type="button" title="Edit" onclick="edit_e_visit(<?=$EnqV->E_Code?>,<?=$EnqV->Visit?>)">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </button>
                                                            <!--<button class="btn btn-danger btn-xs" title="Delete">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </button>-->
                                                            <button class="btn btn-info btn-xs" type="button" title="Convert Admission">
                                                                <span class="glyphicon glyphicon-transfer"></span>
                                                            </button>
                                                        </td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12 notification" id="follow_form<?= $Visit ?>">
                                                    <button type="button" class="btn btn-danger pull-right btn-xs close_my_parents" title="Close" style="position: relative;top: -22px;right: -9px;">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </button>   
                                                    <?php  echo form_open(base_url() . 'Enquiry/followups/save_follow_ups'); ?>
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
                                                                echo form_dropdown("FollowerID", $AllPRO, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
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
                                                                    echo form_dropdown("NotifyToEmp_ID", $AllPRO, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
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
                                                            <button type="submit" class="btn btn-success" title="Add Follow Ups">
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
        <button type="button" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Enquiry Visit</h4>
      </div>
      <div class="modal-body" id="body_cls">
          <div class="col-lg-12">
              <form id="MenuAccessForm" method="post" action="<?=  base_url()."sp-admin/m/UpdateMenuAccess/"?>">
              
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
function edit_e_visit(E_Code,Visit){
              window.location = "<?=  base_url()."Enquiry/enquiry/edit_e_visit/"?>"+E_Code+"/"+Visit;
  // create the backdrop and wait for next modal to be triggered
  $('body').modalmanager('loading');
  setTimeout(function(){
      $modal.load('hii', '', function(){
          $.ajax({
             url: "<?=  base_url()."Enquiry/enquiry/edit_e_visit/"?>"+E_Code+"/"+Visit,
             dataType: 'html',
             data: '',
             type: 'POST',
             success: function (data, textStatus, jqXHR) {
                        $("#body_cls").children('div').children('form').html(data);                       
                    },
             error: function (jqXHR, textStatus, errorThrown) {
                        
                    },
             complete: function (jqXHR, textStatus ) {
                        
                }       
                     
          });      
       $modal.modal();
    });
  }, 1500);
}

    function load_parents(BranchID, parent)
              {
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Enquiry/source/showParentList/" ?>" + BranchID + "/" + parent + "/Src_ID",
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#child_src").html('<?= AJAXPRELOADER ?>');
                          $("#child_src").html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
              }
 function load_coursebycoursecat(C_CID, load_div)
{
    $.ajax({
        url: "<?= base_url() . "cajax/c_course_ajax/getCourseByCourseCat/" ?>" + C_CID,
        type: 'POST',
        data: 'html',
        success: function (data, textStatus, jqXHR) {
            $("#courselist").html('<?= AJAXPRELOADER ?>');
            $("#courselist").html(data);
            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            };
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        },
        complete: function (jqXHR, textStatus) {

        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });
}
function add_tr_picker(that) {
    var index = $(that).attr("id");
    $.ajax({
        url: "<?= base_url() . "Ajax/get_duplicate_time_rand_picker/" ?>" + index,
        type: 'POST',
        data: 'html',
        success: function (data, textStatus, jqXHR) {
            $("#append_timerpicker").append(data);
            $(that).parent().parent().hide();

        },
        complete: function (jqXHR, textStatus) {
            //$(".add_prefer_time").click(add_tr_picker());
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });
 }
 //$(".add_prefer_time").click(add_tr_picker);

function removetrp(that) {
    var index_no = $(that).attr("id") - 1;
    $("#" + index_no).parent().parent().show();
    $(that).parent().parent().parent().hide(1000);
    $(that).parent().parent().remove();
}
</script>