<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit Batch Details for BatchCode <?php echo $batch_details['BatchCode'] ?>
                <a href="<?php echo base_url(); ?>batch/batch_master" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-backward"></span> Back
                    </button></a>
            </h4>
            <div class="well well-sm text-danger">
                Please Check availability before save, in case if that faculty is busy in selected time then batch will be canceled.
            </div>
           
            <?php
            if (isset($error)) {
                          $this->util_model->show_result_error($error, SUCCESS_MSG, ERROR_MSG);
            }
            ?>


        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#add_new_batch">
            <h3 class="panel-title toggle_custom">Batch List with Advance Filter<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body"  id="add_new_batch">


            <?php
//for normal form
//  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'batch/batch_master/batch_save_update', $attributes);
            echo form_hidden("BatchID",$batch_details['BatchID']);
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Branch</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php 
                        echo form_hidden("BranchID",$Session_Data['IBMS_BRANCHID']);
                        echo $Branch_obj->BranchCode;
                        //echo form_dropdown("BranchID", $a_branches, $batch_details['BranchID'] , "class='form-control chosen-select'") ?>
                    </div>
                </div><!-- /input-group -->   
                <div class="col-lg-2 padding_top_label">Faculty Code</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php
// echo "<pre>".print_r($All_Faculty_Code)."</pre>";   
                        echo form_dropdown("FacultyID", $All_Faculty_Code, $batch_details['FacultyID'], "class='form-control chosen-select' id='faculty_id'");
                        ?>
                    </div>
                </div><!-- /input-group -->  
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2" id="SelectCourse">
                    Course Category
                </div>
                <div class="form-group col-lg-2" id="coursecat">
                    <?php echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)' id='course_cat_id'") ?>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2" id="SelectCourse">
                    Course List<span class="Compulsory">*</span>
                </div>
                <div class="form-group col-lg-10" id="courselist">
                    <?php echo form_dropdown("CourseID", $All_Course_Code,  $batch_details['CourseID'], "class='form-control chosen-select' id='course_id'") ?>

                </div>
            </div>



            <!--String of Row-->
            <div class="row bottom_gap">
                <?php
                echo $update_time_form;
                ?>
            </div>



            <!--String of Row-->
            <div class="row bottom_gap">
                <!-- end of col-lg-4 -->
                <div class="col-lg-2 padding_top_label">Batch Code(Suggested)</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("BatchCode", $batch_details['BatchCode'], array("class" => "'form-control'", "placeholder" => "'Batch Code'", "id" => "BatchCode")) ?>	
                        <span class="red">If batch code suggestion is not coming <span class="green" style="color: red;cursor: pointer" onclick="generate_and_place_batchcode()"> Click here </span></span>
                    </div>
                </div>
            </div>
            <!--End of row-->
            <div class="row bottom_gap">
                <div class="col-lg-2">Total Class</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("Total_Class", $batch_details['Total_Class'], array("class" => "'form-control'", "id" => "total_class", "placeholder" => "Total Classes")); ?>
                    </div>
                </div>
                <div class="col-lg-2">Max Student</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("Max_Std", $batch_details['Max_Std'], array("class" => "'form-control'", "id" => "total_class", "placeholder" => "Maximum Students")); ?>
                    </div>
                </div>
            </div>
            <div class="row bottom_gap">

                <div class="col-lg-2">Status</div>
                <div class="col-lg-4">
                    <?php echo form_dropdown("Status", $this->util_model->active_deactive(), $batch_details['Status'], "class='form-control'"); ?>
                </div>
                <div class="col-lg-2 padding_top_label">Batch Starting Date</div>
                <div class="col-lg-4">

                    <div class="form-group">
                        <div class='input-group date bdatepicker' >
                            <input type='text' class="form-control" name="Str_date" value="<?= date(DF, strtotime($batch_details['Str_date'])) ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Remarks</div>
                <div class="col-lg-4">
                    <?php echo form_textarea("Remarks", $batch_details['Remarks'], array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="Add_Batch" value="Update" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                   
                    <button type="button" class="btn btn-success btn-md" onclick="check_batch_aval('batch_validation_form')">
                        <span class="glyphicon glyphicon-refresh"></span> Check Availability
                    </button>
                </div>
            </div>

            <?php
            echo form_close();
            ?>
        </div>   
    </div>
    <!--all batches list-->

    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Batches List</h4>
            <?php
//                      if (isset($error)) {
//                      $this->util_model->show_result_error($error,DEL_SUCCESS_MSG,DEL_ERROR_MSG);
//                      
//                      }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
                  

                  function load_coursebycoursecat(C_CID, load_div)
                  {
                      $.ajax({
                          url: "<?= base_url() . "cajax/c_course_ajax/getCourseByCourseCat/" ?>" + C_CID + "/0",
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

    </script>

</div>

<script src="<?php echo base_url(); ?>js/custom_js/table_manipulation/mange_time_js.js" type="text/javascript"></script>

