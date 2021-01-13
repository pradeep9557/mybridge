
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Course
                <a href="<?php echo base_url(); ?>courses/add_course_cat" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-plus"></span> Manage Course Category
                    </button></a>
            </h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    if (!empty($CourseCategory)) {
                  ?>
                  <div class="panel panel-primary">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                          <h3 class="panel-title toggle_custom">New Course From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="panel-body collapse" id="collapseExample">
                          <?php
                          //for normal form
                          //  echo form_open('/dashboard/new_admission',$attributes);
                          echo form_open_multipart(base_url() . 'courses/course_save', $attributes);
                          ?>
                          <!--String of Row-->
                          <div class="row bottom_gap">
                              <div class="col-lg-2 padding_top_label">Branch</div>
                              <div class="col-lg-4">
                                  <div class="form-group">	
                                      <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                                  </div>
                              </div><!-- /input-group -->               
                              <div class="col-lg-2 padding_top_label">Course Code</div>
                              <div class="col-lg-4">
                                  <div class='input-group'>
                                      <div class="form-group">
                                          <?php echo form_input("CourseCode", set_value("CourseCode", ""), array("id" => "UnquieCourseCode", "checking_id" => "'3'", "class" => "'form-control check_already_exits popover_element1'", "data-content" => "'Course Code required,  space is not allowed and max 15 characters'", "placeholder" => "'Course Code'", "maxlength" => "15")) ?>
                                      </div>
                                      <span class="input-group-btn">
                                          <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="UnquieCourseCode">
                                              <span class="glyphicon glyphicon-search"></span>
                                          </button>
                                      </span>
                                  </div>
                              </div><!-- /input-group -->               
                              <!-- end of col-lg-4 -->
                          </div>
                          <!--String of Row-->
                          <div class="row bottom_gap">
                              <div class="col-lg-2 padding_top_label">Course Name</div>
                              <div class="col-lg-4">
                                  <div class="input-group">
                                      <div class="form-group">
                                          <?php echo form_input("Course_Name", "", array("id" => "CourseName", "checking_id" => "'4'", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'Course Name required,   max 50 characters'", "placeholder" => "'Course Name'", "maxlength" => "50")) ?>
                                      </div>
                                      <span class="input-group-btn">
                                          <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="CourseName">
                                              <span class="glyphicon glyphicon-search"></span>
                                          </button>
                                      </span>
                                  </div>
                              </div>

                              <div class="col-lg-2 padding_top_label">Duration</div>
                              <div class="col-lg-4">
                                  <div class="padding_left_0px col-lg-6">
                                      <div class="form-group">
                                          <?php echo form_input("Duration", "", array("class" => "' form-control  popover_element1'", "data-content" => "'Course Duration is required,  Only Digits are allowed'", "placeholder" => "'Duration 1,2..12'", "maxlength" => "20")) ?>
                                      </div>
                                  </div>
                                  <div class="padding_left_0px .padding_right_0px col-lg-6">

                                      <?php
                                      echo form_dropdown("MonthDay", $MonthDay_list, '', "class='form-control chosen-select'");
                                      ?>

                                  </div>


                              </div><!-- /input-group -->               
                              <!-- end of col-lg-4 -->
                          </div> <!--End of row-->

                          <div class="row bottom_gap">
                              <div class="col-lg-2 padding_top_label">Parent</div>
                              <div class="col-lg-10">
                                  <div class="form-group">	
                                      <?php echo form_dropdown("parentID", $All_Course_List, "", "class='form-control chosen-select'") ?>
                                  </div>
                              </div><!-- /input-group -->               
                              <!-- /input-group -->               
                              <!-- end of col-lg-4 -->
                          </div>
                          <!--String of Row-->
                          <div class="row bottom_gap">
                              <div class="col-lg-2 padding_top_label">Course Category</div>
                              <div class="col-lg-4">
                                  <div class="input-group">
                                      <?php
                                      echo form_dropdown("C_CID", $CourseCategory, '', "class='form-control chosen-select'");
                                      ?>       
                                      <span class="input-group-btn popover_element" data-content="Quick Category Creation" data-placement="right" onclick="show_this('New_Category')">
                                          <button type="button" class="btn btn-default btn-md">
                                              <span class="glyphicon glyphicon-plus"></span>
                                          </button>
                                      </span>
                                  </div>
                                  <div class="input-group hidden" id="New_Category">
                                      <div  class="form-group">
                                          <input type="text" placeholder="New Category" class="form-control" checking_id="5"  name="New_Category" />    
                                      </div>
                                      <span class="input-group-btn" onclick="hide_this('New_Category')">
                                          <button type="button" class="btn btn-default btn-md" tabindex="-1">
                                              <span class="glyphicon glyphicon-minus"></span>
                                          </button>
                                      </span>

                                  </div>
                              </div>
                              <div class="col-lg-2 padding_top_label">Status</div>
                              <div class="col-lg-4">
              <!--                    <input class="bootswitches"  name="Status" type="checkbox" value="1" checked="">-->
                                  <?php
                                  echo form_checkbox("Status", 1, TRUE, "class='bootswitches'");
                                  ?>
                              </div>
                          </div>
                          <!--End of row-->
<!--                          <div class="row bottom_gap">

                              <div class="col-lg-2 padding_top_label">PRO</div>
                              <div class="col-lg-4">
                                  <?php
//                                  echo form_input("Add_User", "{$Session_Data['IBMS_USER_ID_NAME']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
                                  ?>
                              </div>
                          </div>-->
                          <div class="row bottom_gap">
                              <div class="col-lg-2 padding_top_label">Remarks</div>
                              <div class="col-lg-4">
                                  <div class="form-group">
                                  <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                                  </div>
                                  
                              </div>
                              <div class="col-lg-2 padding_top_label">Course Fees</div>
                              <div class="col-lg-4">
                                  <div class="form-group">
                                  <?php echo form_input("CourseFee", "0", array("class" => "'form-control'", "placeholder" => "'Course Fees'", "id" => "coursefees")) ?>                               
                                  </div>
                                  
                              </div>
                          </div>

                          <!--<div class="panel-footer">-->
                          <div class="row">
                              <div class="col-lg-12">
                                  <button type="submit" name="Add_Course" value="Save" class="btn btn-success btn-md">
                                      <span class="glyphicon glyphicon-floppy-disk"></span> Save
                                  </button>
                                  <button type="reset" name="Add_Course" value="Save" class="btn btn-success btn-md">
                                      <span class="glyphicon glyphicon-refresh"></span> Reset
                                  </button>
                              </div>
                          </div>
                          <!--</div>-->
                          <?php echo form_close(); ?>
                      </div>
                  </div>

    <?php } else {
                  ?>
                  <div class="well well-sm bg-danger">
                      Sorry you need to create course category first !! <a href="<?php echo base_url(); ?>courses/add_course_cat">Create Course Category</a>
                  </div>
    <?php }
    ?> 
    <?php
    $Curr_Obj = & get_instance();
    $Curr_Obj->all_Course_list();
    ?>


</div>
<?php 
  $this->load->view("Courses/course_validation");
?>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>





<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>