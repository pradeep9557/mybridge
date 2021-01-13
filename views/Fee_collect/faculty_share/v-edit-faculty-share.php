<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Update Faculty Shares
            
                 <a href="<?php echo base_url(); ?>fees/faculty_share/index" class="pull-right">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Update Faculty Shares
                        <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>  

                <div class="panel-body collapse" id="collapseExample">
                    <?php
                    // $this->util_model->printr($records);
                    ?>
                    <?php
                    echo form_open(base_url() . "fees/faculty_share/update_data", "id='job_mst'");
                    ?>
                    <?php echo form_hidden('faculty_share_id', $value->faculty_share_id) ?>
                    <div class="row bottom_gap">
                        <div class="col-lg-4" id="SelectCourse">
                            <label>Faculty ID</label>    
                            <div class="form-group" id="coursecat">
                               <?php echo form_dropdown("FacultyID", $All_Faculty_Code, $value->FacultyID, "class='form-control chosen-select'") ?>
                            </div>
                        </div>
                        <div class="col-lg-2" id="SelectCourse">
                            <label>Course Category</label>    
                            <div class="form-group" id="coursecat">
                                 <?php echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)'") ?>
                            </div>
                        </div>
                        <div class="col-lg-6" id="SelectCourse">
                            <label>Course List<span class="Compulsory">*</span></label>    
                            <div class="form-group" id="courselist">
                                 <?php echo form_dropdown("CourseID", $All_Course_Code, $value->CourseID, "class='form-control chosen-select'") ?>

                            </div>
                        </div>
                    </div><br>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Share</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                      <?php echo form_input('Share', $value->Share, "class='form-control' Placeholder='Share'") ?>
                            </div>
                        </div>
                       <div class="col-lg-2 padding_top_label">Status</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php
                                echo form_dropdown("Status", $this->util_model->active_deactive(), $value->Status, "class='chosen-select form-control'");
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Remarks</div>
                        <div class="col-lg-4"><?php echo form_textarea('Remarks', $value->Remarks, "class='form-control' Placeholder='Remarks'") ?></div>

                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-12">
                            <button type="submit" value="Save" class="btn btn-success btn-md">
                                <span class="glyphicon glyphicon-floppy-disk"></span> update
                            </button>
                            <button type="reset" value="Save" class="btn btn-success btn-md">
                                <span class="glyphicon glyphicon-refresh"></span> Reset
                            </button>
                        </div>
                    </div>
                </div>
                <?php
// closing the form
                echo form_close();
                ?> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            $Curr_Obj = & get_instance();
            $Curr_Obj->faculty_list();
            ?>  
        </div> 
    </div>
</div>
<?php
$this->load->view("Fee_collect/faculty_share/faculty-share-validation");
?>
<script>


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
</script>
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
                                
                                <link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>





<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>