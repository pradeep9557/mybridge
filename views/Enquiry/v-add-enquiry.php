<div id="page-wrapper" style="min-height: 345px;">
    <?php
    if (isset($Enq_Details)) {
                  ?>
                  <div class="row col-lg-12">

                      <h5 class="group_title">Last Added Enquiry</h5>
                      <table class="table table-bordered">
                          <thead>
                                  <tr>
                                  <th>S.No</th>
                                  <th>EC/V/EFN/TF</th>
                                  <th>DOE</th>
                                  <th>ECourse</th>
                                  <th>EnrollNo</th>
                                  <th>DOR</th>
                                  <th>AdmCourse</th>
                                  <th>SName</th>
                                  <th>FName</th>
                                  <th>Mobile</th>
                                  <th>SourceCat</th>
                                  <th>Source</th>
                                  <th>Received By</th>               
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              
                              <?php
                              $i = 0;
                              foreach ($Enq_Details as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td><?php echo $row['E_Code'] . "/" . $row['Visit'] . "/" . $row['EFormNo'] . "/" . $row['total_followups'] ?></td>
                                                <td><?php echo date(DF, strtotime($row['DOE'])); ?></td>
                                                <td><?php echo $row['enqCourseCode']; ?></td>
                                                <td><?php echo $row['EnrollNo']; ?></td>
                                                <td><?php echo $row['EnrollNo'] != "NA" ? date(DF, strtotime($row['DOR'])) : ''; ?></td>
                                                <td><?php echo $row['admCourseCode']; ?></td>
                                                <td><?php echo $row['StudentName']; ?></td>
                                                <td><?php echo $row['FatherName']; ?></td>
                                                <td><?php echo $row['Mobile1']; ?></td>
                                                <td><?php echo $row['Src_CatCode']; ?></td>
                                                <td><?php echo $row['Src_Code']; ?></td>
                                                <td><?php echo $row['PROCode']; ?></td>
                                                <td>
                                                    <form>
                                                        <a href="<?= base_url() ?>Enquiry/enquiry/edit_enquiry/<?= $row['E_Code'] ?>" target="_blank">
                                                            <button type="button" name="Edit_Enquiry" title="Edit Enquiry Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                                <span class="glyphicon glyphicon-edit"></span> 
                                                            </button>
                                                        </a>
                                                        <a href="<?= base_url() ?>Enquiry/followups/index/<?= $row['E_Code'] ?>" title="Follow Up" target="_blank">
                                                            <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                                            </button>
                                                        </a>
                                                        <a href="<?php echo base_url() . "adm/cadm/index/{$row['E_Code']}/{$row['Visit']}" ?>">
                                                            <button type="button" class="btn btn-info btn-xs" title="Convert Admission">
                                                                <span class="glyphicon glyphicon-transfer"></span>
                                                            </button>
                                                        </a>
                                                        <input type="hidden" name="_key" value="del_Enq"/>
                                                        <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($row['StudentName']) ?> Enquiry !!" name="_msg"/>
                                                        <input type="hidden" value="<?= $row['E_Code'] ?>" name="E_Code"/>
                                                        <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                            <span class="glyphicon glyphicon-trash"></span> 
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                              <?php } ?>
                          </tbody>
                      </table>


                  </div>
                  <?php
    }
    ?>
    <div class="row">
    <div class="col-lg-12 hidden" id="SearchDiv" style="padding-top: 20px;">
        <div>
            <div class="loader" id="loader">
                <div class="progress progress-striped active" style="width: 40%;margin: 5px auto;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only"></span></div></div>  
            </div>
            <div class="row" id="SearchResult">

            </div>
        </div>
    </div>
        <h4></h4>
    </div>
    
    <?php
    echo $enq_search_template;
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header group_title">Enquiry <a href="<?php echo base_url(); ?>Enquiry/source" class="pull-right">
                    <button type="button" name="source" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-plus"></span> Manage Source
                    </button></a></h4>

            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New Enquiry<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open_multipart(base_url() . 'Enquiry/enquiry/AddEnquiry', "id='new_enq_form'");
            ?>
            <!--String of Row-->
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#enquiryone">
                    <h3 class="panel-title toggle_custom">Official work<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body" id="enquiryone">
                    <div class="row bottom_gap col-lg-12">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>Form No<span class="Compulsory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown" name="rollcode">
                                        <?= $Branch_obj->BranchCode ?>&nbsp;
                                        <!--<span class="caret"></span>-->
                                    </button>
                                    <input type="hidden" value="<?= $Session_Data['IBMS_BRANCHID'] ?>" name="BranchID" id="BranchID">
                                </div><!-- /btn-group -->
                                <?php echo form_input("EFormNo", "", array("class" => "'form-control'", "placeholder" => "'Form Number'", "id" => "EFormNo", "readonly" => "true")) ?>

                            </div><!-- /input-group -->               
                            <script>
                                          fun = function get_enroll()
                                          {
                                              var branch_code = $("#BranchID").val();
                                              var page = "<?= base_url() ?>Enquiry/enquiry/gen_eformno/" + branch_code;
                                              $.ajax({
                                                  type: "POST",
                                                  url: page,
                                                  success: function (result) {
                                                      $("#EFormNo").val(result);
                                                  }});
                                          };
                                          fun();




                                          setInterval(fun, 15000);

                            </script>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Enquirer's Name<span class="Compulsory">*</span></label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" >
                                        <i class="glyphicon glyphicon-user icon_extra_padding"></i>
                                    </button>
                                </span>
                                <div class="form-group">
                                    <?php echo form_input("StudentName", "", array("class" => "'form-control'", "placeholder" => "'Enquirer s Name'", "maxlength" => "25", "id" => "StudentName")) ?>
                                </div>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="searchEnquiry('StudentName', 'StudentName', 'SearchResult', 'loader', this)">
                                        <i class="glyphicon glyphicon-search icon_extra_padding"></i>
                                    </button>
                                </span>
                            </div>
                            <script>
                                          function searchEnquiry(search, searchby, showon, loader, that)
                                          {

                                              var searchfor = $("#" + search).val();
                                              if (searchfor != "") {
                                                  $("#SearchDiv").removeClass('hidden');
                                                  $("#" + loader).show(100);
                                                  $.ajax({
                                                      url: "<?= base_url() . "Ajax/searchEnquiry/" ?>" + searchfor + "/" + searchby,
                                                      type: 'POST',
                                                      data: '',
                                                      dataType: 'html',
                                                      success: function (data, textStatus, jqXHR) {
                                                          $("#" + loader).hide(100);
                                                          $("#" + showon).html(data);
                                                          $('#data_div').collapse('toogle');
                                                      },
                                                      complete: function (jqXHR, textStatus) {
                                                          $("#" + loader).hide(100);
                                                      },
                                                      error: function (jqXHR, textStatus, errorThrown) {

                                                      }
                                                  });
                                              }

                                          }
                            </script>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Mobile No<span class="Compulsory">*</span></label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default">
                                        <i class="fa fa-mobile-phone icon_extra_padding"></i>
                                    </button>
                                </span>
                                <div class="form-group">
                                    <?php echo form_input("Mobile1", "", array("class" => "'form-control'", "placeholder" => "'783585****'", "id" => "Mobile1")) ?>	              
                                </div>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="searchEnquiry('Mobile1', 'Mobile1', 'SearchResult', 'loader', this)">
                                        <i class="glyphicon glyphicon-search icon_extra_padding"></i>
                                    </button>
                                </span>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
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




                    </div>

                    <div class="row bottom_gap col-lg-12">
                        <div class="col-lg-12"><h5 class="group_title">Course, Source & PRO Details</h5></div>
                        <div class="row bottom_gap col-lg-12">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" id="SelectCourse">
                                    <label>Course Category</label>    
                                    <div class="form-group" id="coursecat">
                                        <?php echo form_dropdown("course_cat_list", $course_cat_list, "", "class='form-control chosen-select' onchange='load_coursebycoursecat(this.value)'") ?>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="SelectCourse">
                                    <label>Course List<span class="Compulsory">*</span></label>    
                                    <div class="form-group" id="courselist">
                                        <?php echo form_multiselect("CourseID[]", $All_Course_List, "", "class='form-control chosen-select'") ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Source Category <span class="Compulsory">*</span></label>   
                                    <div class="form-group">
                                        <?php
                                        echo form_dropdown("Src_CatID", $SourceList, "", "class='form-control  chosen-select' onchange='load_parents(" . $Session_Data['IBMS_BRANCHID'] . ",this.value)'");
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label>Source<span class="Compulsory">*</span></label>   
                                    <div class="form-group" id="child_src">
                                        <?php
                                        echo form_dropdown("Src_ID", array(), "", "class='form-control chosen-select' ");
                                        ?>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label>Received by<span class="Compulsory">*</span></label>   
                                    <div class="form-group">
                                        <?php
                                        echo form_dropdown("PRO", $AllUsers, $Session_Data['IBMS_USER_ID'], "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                    <label>Visit</label>   
                                    <div class="form-group" >
                                        <?php
                                        echo form_dropdown("Visit", array(1), '', "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                                  function addNewCourse(BranchID)
                                  {
                                      $.ajax({
                                          url: "<?= base_url() . "courses/AllCourseListForEnquiry/" ?>" + BranchID,
                                          type: 'POST',
                                          data: 'html',
                                          success: function (data, textStatus, jqXHR) {

                                              $("#SelectCourse").append(data);
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
                </div> <!--End of row-->

            </div>

            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#enquiryThree">
                    <h3 class="panel-title toggle_custom">Basic Info<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body " id="enquiryThree">
                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Personal Details</h5></div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Father's Name<span class="Compulsory">*</span></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("FatherName", "", array("class" => "'form-control'", "placeholder" => "'Father's Name'", "maxlength" => "25")) ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Mother's Name</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("MotherName", "", array("class" => "'form-control'", "placeholder" => "'Mother's Name'", "maxlength" => "25")) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Date of Birth</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class='input-group date bdatepicker' >
                                    <input type='text' class="form-control" name="DOB" value="<?= date(DTF) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Gender<span class="Compulsory">*</span></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="radio">
                                <label>
                                    <?php echo form_radio("Gender", "Male", 'checked'); ?>	
                                    Male
                                </label>
                                <label>
                                    <?php echo form_radio("Gender", "Female"); ?>
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Qualification</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php
                                echo form_dropdown("Quali", $Quali_list, '', "class='form-control chosen-select'");
                                ?>

                            </div>
                <!--                  <select class="form-control">
                   <option value="10th">10th</option>
                   <option value="12th">12th</option>
                   <option value="Under-Graduated">Under-Graduated</option>
                   <option value="Graduated">Graduated</option>  
                                       <option value="Under-Post-Graduated">Under-Post-Graduated</option>
                   <option value="Post-Graduated">Post-Graduated</option>                                                               
                </select>-->
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Nationality</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php
                                echo form_dropdown("Nationality", $nationality_list, '', "class='form-control chosen-select'");
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Current Doing</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php echo form_dropdown("CurrentDoing", $c_doing, "", "class='form-control chosen-select'"); ?>

                        </div>

                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Contact Details</h5></div>
                    </div>
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Primary Phone No</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("Phone1", "", array("class" => "'form-control'", "placeholder" => "'011-6581****, 011-2547****'")) ?>	              
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Primary Email ID</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("Email1", "", array("class" => "'form-control'", "placeholder" => "'kumaranup594****'")) ?>	                                             
                            </div>
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Address Details</h5></div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Enquirer Address</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_textarea("C_Add", "", array("class" => "'form-control'", "placeholder" => "'Complete Address'"), 3, 3) ?>                               
                            </div></div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Country</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_dropdown("C_Country", $country_list, $Branch_obj->Country, "class='form-control chosen-select' onchange=load_states(this.value,'c_state')") ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Gali No</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("C_Galino", "", "class='form-control' placeholder='Gali No Only'") ?>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Block/Pocket/Khasara</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group" id="city_id">
                                <?php echo form_input("Block", "", "class='form-control' placeholder='Block, Pocket, Khasra no'") ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">State</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group" id="c_state">
                                <?php echo form_dropdown("C_State", $state_list, $Branch_obj->state_id, "class='form-control chosen-select' onchange=load_cities(this.value,'city_id')") ?>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">City</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group" id="city_id">
                                <?php echo form_dropdown("C_City", $City_list, $Branch_obj->cityid, "class='form-control chosen-select' onchange=load_locality(this.value,'locality')") ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Locality</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group" id="locality">
                                <?php echo form_dropdown("C_Locality", $locality_list, '', "class='form-control chosen-select' onchange=load_sub_locality(this.value,'sublocality')") ?>
                            </div>

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Sub Locality</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group" id="sublocality">
                                <?php echo form_dropdown("C_SubLocality", array(), '', "class='form-control chosen-select'") ?>
                            </div>
                        </div>
                    </div>
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Pin</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php echo form_input("C_Pincode", "", array("class" => "'form-control'", "placeholder" => "'1100**'", "id" => "C_pincode")) ?>                               
                            </div>
                        </div>

                    </div>

                </div>
            </div>






            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#enquiryFour">
                    <h3 class="panel-title toggle_custom">Remarks & Preffered Time <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.col-lg-12 -->
                <div class="panel-body" id="enquiryFour">
                    <div class="row bottom_gap">
                        <div class="col-lg-12"><h5 class="group_title">Office Work</h5></div>
                    </div> 
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padding_top_label">Remarks</div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                        </div>
                    </div>
                    <div class="row bottom_gap col-lg-12">
                        <div class="col-lg-12 padding_top_label group_title">Preferred Timing</div>
                        <div class="row bottom_gap col-lg-12" id="append_timerpicker">
                            <div class="padding_left_0px col-lg-6 bottom_gap">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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

                </div>
            </div>

            <!--String of Row-->

            <div class="row col-lg-12">
                <button type="submit" name="AddEnquiry" value="Save" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
                <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-refresh"></span> Reset
                </button>

            </div>
            <?php form_close(); ?>
        </div>
    </div>  
    <!--    
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header group_title">Last Five Enquiries</h4>
            </div>
        </div>-->
    <?php
    $this->load->view('Enquiry/others/area_locality_ajax_func');
    ?>
</div>

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

              /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#new_enq_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          StudentName: {
                              message: 'Enquirer Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Enquirer Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Enquirer Name can only consist alphabets'
                                  }
                              }
                          }, FatherName: {
                              message: 'Father Name is not valid',
                              validators: {
//                                  notEmpty: {
//                                      message: 'Father Name is required and can\'t be empty'
//                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Father Name can only consist alphabets'
                                  }
                              }
                          }, MotherName: {
                              message: 'Mother Name is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Mother Name can only consist alphabets'
                                  }
                              }
                          }, Email1: {
                              validators: {
                                  emailAddress: {
                                      message: 'Invalid Email address'
                                  }
                              }
                          }, Mobile1: {
                              validators: {
                                  notEmpty: {
                                      message: 'Mobile is required and can\'t be empty'
                                  },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^[0-9\,]+$/,
                                      message: 'Invalid Mobile number'
                                  },
                                  stringLength: {
                                      min: 10,
                                      max: 10,
                                      message: 'Mobile no. should be 10 characters long'
                                  }
                              }
                          }, Phone1: {
                              validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^[0-9\,]+$/,
                                      message: 'Invalid Phone number'
                                  }
                              }
                          }, C_Add: {
                              validators: {
//                                  notEmpty: {
//                                      message: 'Address is required and can\'t be empty'
//                                  }
                              }
                          }, C_Pincode: {
                              validators: {
//                                  notEmpty: {
//                                      message: 'Pincode is required and can\'t be empty'
//                                  },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^(\d{6})+$/,
                                      message: 'Invalid PinCode'
                                  }
                              }
                          }
                      }

                  });
              });

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