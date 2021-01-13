<div id="page-wrapper" style="min-height: 345px;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header group_title ">Source Master
                 <a href="<?php echo base_url(); ?>Enquiry/enquiry" class="pull-right">
                    <button type="button" name="new_enquiry" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-plus"></span> New Enquiry
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
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                <h3 class="panel-title toggle_custom">New Source From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.col-lg-12 -->
            <div class="panel-body collapse" id="collapseExample">

                <?php
                //for normal form
                //  echo form_open('/dashboard/new_admission',$attributes);
                echo form_open_multipart(base_url() . 'Enquiry/source/AddSource', array('id' => 'addSourceForm'));
                ?>
                <!--String of Row-->
                <div class="row bottom_gap">

                    <div class="col-lg-2 padding_top_label">Branch<span class="Compulsory">*</span ></div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), '', "class='form-control chosen-select' subid='ParentSelectList' onchange='load_parents(this)'") ?>
                        </div>
                    </div>
                    <div class="col-lg-2 padding_top_label">Source Code<span class="Compulsory">*</span></div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("Src_Code", "", array("checking_id" => "7", "id" => "Src_Code", "class" => "'form-control'", "placeholder" => "'Source Code'", "maxlength" => "20")) ?>
                            </div>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default search_already_exits" tabindex="-1"  search_for="Src_Code">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div> <!-- /input-group -->               
                    </div> <!-- end of col-lg-4 -->

                </div> 


                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Source Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("Src_Name", "", array("checking_id" => "8", "id" => "Src_CatCode", "class" => "'form-control'", "placeholder" => "'Source Name'", "maxlength" => "20")) ?>
                            </div>
                            <div class="input-group-btn">
                                <button  type="button" class="btn btn-default search_already_exits" tabindex="-1" search_for="Src_CatCode">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div><!-- /input-group -->               

                    </div> <!-- end of col-lg-4 -->
                    <div class="col-lg-2 padding_top_label">Parent<span class="Compulsory">*</span></div>
                    <div class="col-lg-4">
                        <div class="form-group" id="ParentSelectList">
                            <?php echo form_dropdown("Parent", $Parent, '', "class='form-control chosen-select'") ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Status<span class="Compulsory">*</span></div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input class="bootswitches"  name="Status" type="checkbox" value="1" checked="">
                        </div>
                    </div>
                </div>


                <!--End of row-->
                <!--String of Row-->

                <div class="row col-lg-12">
                    <button type="submit" name="source_submit" value="Save"  class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>

                </div>
                <?php echo form_close();
                ?>
            </div>
        </div>
    </div>

    <?php
    $this->load->view('Enquiry/source/v-all-source');
    ?>


</div>   
<script>

              function load_parents(that, ParentSelectList)
              {
                  var BranchID = $(that).val();
                  var dataLoadder = $(that).attr('subid');

                  //alert(BranchID);
                  $.ajax({
                      url: "<?= base_url() . "Enquiry/source/showParentList/" ?>" + BranchID + "/0/Parent",
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {

                          $("#" + dataLoadder).html(data);
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
                  $('#addSourceForm').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          Src_Code: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Source Code is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z_0-9]+$/,
                                      message: 'Source Codee can only consist alphanumeric and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 15,
                                      message: 'Source Code must be more 3-15 characters long'
                                  }
                              }
                          }, Src_Name: {
                              message: 'Source Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Source Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Source Name can only consist alphanumeric,space and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 50,
                                      message: 'Source Name must be more 3-50 characters long'
                                  }
                              }
                          }
                      }

                  });
              });



</script>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>