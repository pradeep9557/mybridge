

<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_adm_search">
        <h3 class="panel-title toggle_custom">Searching Filters<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body <?php echo isset($collapse) ? $collapse : '' ?>" id="global_adm_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='faculty_share_history'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Basic Search</div>
                <div class="col-lg-2">
                    <?php
                    echo form_dropdown("FacultyID", $fac_list, "", "class='form-control chosen-select' Placeholder='Select Field'");
                    ?>
                </div>
                    <div class="col-lg-6">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button class="btn btn-success" type="button" name="Search" onclick="search_share_history()">
                        <span class="glyphicon glyphicon-search"></span>
                        Search</button> 
                        <button type="button" class="btn btn-primary" onclick="export_csv()">Export CSV</button>
                        <button type="button" class="btn btn-primary" onclick="export_xls()">Export XLS</button>
                    </div>
                </div>
                <div class="col-lg-2">
                    <input class="bootswitches"   name="adv_search" type="checkbox" checked=""  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_adm_search">
                </div>
            </div>
            <!--            <div class="row bottom_gap">
                            <div class="col-lg-offset-5">
                                      <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_adm_search">
                            </div>
                        </div>-->
            <div class="row" id="global_adv_adm_search" > 
                  <div class="row">
                      <div class="col-lg-2">
                        Course Wise              
                      </div>
                    <div class="col-lg-2" id="SelectCourse">
                        <label>Course Category</label>    
                        <div class="form-group" id="coursecat">
                            <?php echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)'") ?>
                        </div>
                    </div>
                    <div class="col-lg-8" id="SelectCourse">
                        <label>Course List<span class="Compulsory">*</span></label>    
                        <div class="form-group" id="courselist">
                            <?php echo form_multiselect("CourseID[]", $All_Course_List, "", "class='form-control chosen-select'") ?>

                        </div>
                    </div>
                      
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        Receipt Date Wise
                    </div>
                    <div class="col-lg-10 row bottom_gap">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepickeradm6'>
                                    <span class="input-group-addon">
                                        From
                                    </span>
                                    <input type='text' class="form-control" name="From" value="<?= date("m/d/Y h:i:s", strtotime(Month . "/01/" . Year)) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>              
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class='input-group date'  id='datetimepickeradm7'>
                                    <span class="input-group-addon">
                                        To
                                    </span>
                                    <input type='text' class="form-control" name="To" value="<?= date("m/d/Y h:i:s") ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>              
                        </div>
                        <div class="col-lg-2">
                            <input class="bootswitches"   name="todays_adm" type="checkbox"  value="todays_adm"  data-label-text="Today">                                  
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        Share Given 
                    </div>   
                    <div class="col-lg-2">
                        <?php
                        echo form_dropdown("share_given", $share_options, "both", "class='chosen-select form-control'")
                        ?>
                    </div>
                     <div class="col-lg-2">
                    <?php
                    echo form_dropdown("search_via[]", $input_fields, "", "class='form-control' Placeholder='Select Field'");
                    ?>
                </div>

                <div class="col-lg-2">
                    <?php
                    echo form_input("search_via_value[]", "", "class='form-control' Placeholder='Mobile Number'");
                    ?>
                </div>

                </div>
            </div>
             
            <?php
            echo form_close();
            ?>
        </div>
        <div class="col-lg-12" id="global_faculty_share_search_result">
            <!-- admuiry search ajax will rendered in this div -->         
        </div>
    </div>
</div>
<script>
              $(function () {
                  $('#datetimepickeradm6').datetimepicker();
                  $('#datetimepickeradm7').datetimepicker();
                  $("#datetimepickeradm6").on("dp.change", function (e) {
                      $('#datetimepickeradm7').data("DateTimePicker").minDate(e.date);
                  });
                  $("#datetimepickeradm7").on("dp.change", function (e) {
                      $('#datetimepickeradm6').data("DateTimePicker").maxDate(e.date);
                  });
              });

              function search_share_history() {
                 
                  preloader.on();
                  $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>fee_share/c_share/search_share",
                      data: $("#faculty_share_history").serialize(),
                      dataType: "html",
                      success: function (search_data) {
                          $("#global_faculty_share_search_result").html(search_data);
                          preloader.off();
                          //blink();
                      }
                  });
              }
              function calculate_faculty_share() {
                  $("#faculty_share_history").attr("action", "<?php echo base_url(); ?>fee_share/c_share/search_share");
                  $("#faculty_share_history").submit();
              }
              function export_csv() {
                  $("#faculty_share_history").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_search_share");
                  $("#faculty_share_history").submit();
              }
              function export_xls() {
                  $("#faculty_share_history").attr("action", "<?php echo base_url(); ?>reports/xls_exporter/export_search_share");
                  $("#faculty_share_history").submit();
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


</script>
