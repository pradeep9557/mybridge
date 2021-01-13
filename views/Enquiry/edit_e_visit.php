<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Enquiry ( Visit: <?= $e_source->Visit ?> and ECode: <?= $e_source->E_Code ?>) </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="col-lg-12">
        <?php
        echo form_open(base_url() . "Enquiry/enquiry/e_source_update", "id='e_visit_edit'");
        ?>

        <div class="col-lg-3">
            <label>PRO<span class="Compulsory">*</span></label>   
            <div class="form-group">
                <?php
                echo form_dropdown("PRO", $AllPRO, $e_source->PRO, "class='form-control chosen-select'");
                ?>
            </div>
        </div>

        <div class="col-lg-3">
            <label>Source Category <span class="Compulsory">*</span></label>   
            <div class="form-group">
                <?php
                echo form_dropdown("Src_CatID", $SourceCatList, $e_source->Src_CatID, "class='form-control chosen-select' onchange='load_parents(" . $Session_Data['IBMS_BRANCHID'] . ",this.value)'");
                ?>
            </div>
        </div>
        <div class="col-lg-3">
            <label>Source<span class="Compulsory">*</span></label>   
            <div class="form-group" id="child_src">
                <?php
                echo form_dropdown("Src_ID", $SourceList, $e_source->Src_ID, "class='form-control chosen-select' ");
                ?>
            </div>
        </div>
        <div class="col-lg-2">
            <label>Remarks<span class="Compulsory">*</span></label>   
            <div class="form-group">
                <?php
                echo form_hidden("E_Code", $e_source->E_Code, "class='form-control' readonly");
                echo form_hidden("Visit", $e_source->Visit, "class='form-control' readonly");
                echo form_textarea("Remarks", $e_source->Remarks, "class='form-control'");
                ?>
            </div>
        </div>

        <div class="col-lg-1">
            <label>Update</label>
            <button class="btn btn-success" type="button" onclick="save_form('e_visit_edit')">
                <span class="glyphicon glyphicon-refresh"></span>
            </button>
        </div>

        <?php
        echo form_close();
//            $this->util_model->printr($e_source);
//            $this->util_model->printr($e_course);
        ?>   

        <script>
                      function load_parents(BranchID, parent)
                      {
                          //  alert(result_in);
                          $.ajax({
                              url: "<?= base_url() . "Enquiry/source/showParentList/" ?>" + BranchID + "/" + parent + "/Src_ID",
                              type: 'POST',
                              data: 'html',
                              success: function (data, textStatus, jqXHR) {

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



                      //      Form Validation           

                      $(document).ready(function () {
                          $('#e_visit_edit').bootstrapValidator({
                              feedbackIcons: {
                                  valid: 'glyphicon glyphicon-ok',
                                  invalid: 'glyphicon glyphicon-remove',
                                  validating: 'glyphicon glyphicon-refresh'
                              },
                              fields: {
                                  Remarks: {
                                      message: 'Remakrs is Compulsory, Write Reason to edit !!',
                                      validators: {
                                          notEmpty: {
                                              message: 'Remakrs is required and can\'t be empty'
                                          },
                                          regexp: {
                                              regexp: /^[a-zA-Z\s]+$/,
                                              message: 'Remakrs can only consist alphabets'
                                          }
                                      }
                                  }
                              }

                          });

                      });


        </script>

    </div>
    <div class="col-lg-12">
        <h5 class="group_title">Selected Course List</h5>
        <div class="row" id="e_course_list">
            <?php
            // $this->util_model->printr($e_course);
            foreach ($e_course as $ec) {
             echo form_open("#", "id='e_visit_course_edit{$ec->ECID}'");
                          ?>
            <div class="row">
                          <div class="col-lg-10 bottom_gap">
                              <?php
                              
                              echo form_hidden("E_Code", $ec->E_Code);
                              echo form_hidden("Visit", $ec->Visit);
                              echo form_hidden("OldCourseID",$ec->CourseID);
                              echo form_dropdown("CourseID", $All_Course_List, $ec->CourseID, "class='form-control chosen-select' ");
                              ?>
                          </div>
                          <div class="col-lg-2 bottom_gap">
                              <button class="btn btn-success" type="button" onclick="add_delete_update_e_course('e_visit_course_edit<?= $ec->ECID ?>','update','<?=base_url() . "Enquiry/enquiry/e_course_update"?>',this)">
                                  <span class="glyphicon glyphicon-refresh"></span>
                              </button>
                              <button class="btn btn-danger" type="button" disabled="">
                                              <span class="glyphicon glyphicon-minus"></span>
                              </button>
                          </div>
            </div>
             <?php echo form_close();
             
} ?>

        </div>
        <div class="row text-center bottom_gap">
            <button class="btn btn-success" type="button" onclick="addNewCourse(<?= $Session_Data['IBMS_BRANCHID'] ?>,<?=$e_source->E_Code?>,<?=$e_source->Visit?>)">
                <span class="glyphicon glyphicon-plus"></span> Add More
            </button>
        </div> 
    </div>
</div>

<script>
              function addNewCourse(BranchID,E_Code,Visit)
              {
                  $.ajax({
                      url: "<?= base_url() . "courses/AllCourseListForEnquiry/" ?>" + BranchID +"/"+E_Code+"/"+Visit,
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {

                          $("#e_course_list").append(data);
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

                      }

                  });
              }
</script>

<script src="<?= base_url() ?>js/custom_js/ajax/add_delete_update_e_course.js" type="text/javascript"></script>
