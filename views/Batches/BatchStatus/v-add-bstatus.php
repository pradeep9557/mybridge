
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Batch</h4>
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
            <h3 class="panel-title toggle_custom">New Batch From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "batch/c_bstatus/save_batchstatus", "id='response_form'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Branch</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                    </div>

                </div>
                <div class="col-lg-2">Bath Status</div> 
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="form-group"> 
                            <?php echo form_input("BatchStatus", "", array("class" => "'form-control popover_element'", "placeholder" => "'Status of Batch'", "maxlength" => "20", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Enter tha staus of batch.'", "data-original-title" => "'Remember'")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="CountryName">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>  

            <div class="row bottom_gap">               
                <div class="col-lg-2">Remarks</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?> 
                    </div>
                </div>
         
            <div class="col-lg-2">Status</div> 
            <div class="col-lg-4">
                <input name="Status" type="checkbox" checked="" value="1" class="form-control bootswitches">
            </div>
        </div>
        <div class="row bottom_gap">


        </div> 
        <!--<div class="panel-footer">-->
        <div class="row bottom_gap">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
                <button type="reset" class="btn btn-success btn-md">
                    <span class="glyphicon glyphicon-refresh"></span> Reset
                </button>
            </div>
        </div>
        <!--</div>-->
        <?php echo form_close(); ?>
    </div>
    <script>
        // validation of   Batch_form 
        $(document).ready(function () {
                  $('#response_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          BatchStatus: {
                              message: 'Batch Status is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Batch status is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Batch status can only consist alphabets'
                                  },stringLength: {
                                      min: 2,
                                      max: 20,
                                      message: 'Batch Status Should be 10 to 20 characters long'
                                  }
                              }
                          },
                          Remarks: {
                              message: 'Remark is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s]+$/,
                                      message: 'Remark can only consist alphabets and numbers'
                                  },
                              }
                          }
                          
                      }

                  });
              });

    </script>
</div>
<?php
$Curr_Obj = & get_instance();
$Curr_Obj->all_batchstatus_list();
?>

</div>
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>