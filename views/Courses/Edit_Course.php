
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit Course

                <a href="<?= base_url() ?>courses" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-backward"></span> Back
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
    //for normal form
    //  echo form_open('/dashboard/new_admission',$attributes);
    echo form_open_multipart(base_url() . 'courses/course_upd', $attributes);
    ?>
    <!--String of Row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 col-sm-2 padding_top_label">Branch</div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">	
                <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), $Course_Data->BranchID, "class='form-control chosen-select'") ?>
            </div>
        </div><!-- /input-group -->
        <div class="col-lg-2 col-sm-2 padding_top_label">Course Code</div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">	

                <?php echo form_input("CourseCode", "{$Course_Data->CourseCode}", array("class" => "' form-control '", "placeholder" => "'Course Code'", "maxlength" => "15")) ?>
            </div>
        </div><!-- /input-group -->  
    </div>
    <div class="row bottom_gap">

        <!-- end of col-lg-4 -->
        <div class="col-lg-2  col-sm-2 padding_top_label">Course Name</div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <?php echo form_input("Course_Name", "{$Course_Data->Course_Name}", array("class" => "' form-control '", "placeholder" => "'Course Name'", "maxlength" => "43")) ?>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 padding_top_label">Duration</div>
        <div class="col-lg-4 col-sm-4">
            <div class="padding_left_0px col-lg-6 col-sm-6">
                <div class="form-group">
                    <?php echo form_input("Duration", "{$Course_Data->Duration}", array("class" => "' form-control '", "placeholder" => "'Duration 1,2..12'", "maxlength" => "20")) ?>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <?php
                echo form_dropdown("MonthDay", $MonthDay_list, $Course_Data->MonthDay, "class='form-control chosen-select'");
                ?>
            </div>
        </div><!-- /input-group -->    
    </div> <!--End of row-->


    <div class="row bottom_gap">
        <div class="col-lg-2 col-sm-2 padding_top_label">Parent</div>
        <div class="col-lg-10 col-sm-10">
            <div class="form-group">	
                <?php echo form_dropdown("parentID", $All_Course_List, $Course_Data->parentID, "class='form-control chosen-select'") ?>
            </div>
        </div><!-- /input-group -->               
        <!-- /input-group -->               
        <!-- end of col-lg-4 -->
    </div>
    <!--String of Row-->
    <div class="row bottom_gap">

        <!-- end of col-lg-4 -->
        <div class="col-lg-2 col-sm-2 padding_top_label">Course Category</div>
        <div class="col-lg-4 col-sm-4">
            <div class="form-group">
                <?php
                echo form_dropdown("C_CID", $CourseCategory, $Course_Data->C_CID, "class='form-control chosen-select'");
                ?>       

            </div>

        </div> 
        <div class="col-lg-2 col-sm-2  padding_top_label">Status</div>
        <div class="col-lg-4 col-sm-4">
            <?php
            echo form_checkbox("Status", 1, $Course_Data->Status, "class='bootswitches'");
            ?>    
        </div>
    </div>
    <!--End of row-->

    <div class="row bottom_gap">
        <div class="col-lg-2 col-sm-2 padding_top_label">Remarks</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php
                echo form_hidden('courseid', $Course_Data->CourseID);
                echo form_textarea("Remarks", $Course_Data->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3)
                ?>                               
            </div>
        </div>
        <div class="col-lg-2 padding_top_label">Update Course Fees</div>
        <div class="col-lg-4">
            <div class="col-lg-6">
                <div class="form-group">
                    <?php
                    echo form_checkbox("update_fee", 1, 0, "class='bootswitches pull-left'");
                    ?>  Update

                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <?php echo form_input("CourseFee", $Course_Data->CourseFee, array("class" => "'form-control'", "placeholder" => "'Course Fees'", "id" => "coursefees")) ?>                               
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button type="submit" name="Add_Course" value="Update" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-floppy-disk"></span> Update
            </button>
            <!-- <button type="reset" name="Add_Course" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>-->
        </div>

    </div>
    <?php
    echo form_close();
    ?>

    <?php
    $Curr_Obj = & get_instance();
    $Curr_Obj->all_Course_list();
    ?>
</div>
<?php
$this->load->view("Courses/course_validation");
?><link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>





<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>