<div id="page-wrapper" style="min-height: 345px;">
     <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit New Response</h4>
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
            <h3 class="panel-title toggle_custom">Edit Response From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="collapseExample">
            <?php 
             echo form_open(base_url()."Enquiry/c_response/update_response","id='response_form'");
            ?>
             <div class="row bottom_gap">
                <div class="col-lg-2">Branch</div>
                <div class="col-lg-4">
                     <div class="form-group">	
                        <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID=>$Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                    </div>
                </div>
            </div>  
            
            <div class="row bottom_gap">               
              <div class="col-lg-2">Response Text</div>
                <div class="col-lg-4">
                  <?php echo form_textarea("ResponseText", $res_data->ResponseText, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?> 
                </div>
                <div class="col-lg-2 padding_top_label">Remarks</div>
                <div class="col-lg-4">
                    <div class="form-group">
                    <?php echo form_textarea("Remarks", $res_data->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                 </div>
                     </div>
            
            </div>
            <div class="row bottom_gap">
                 <div class="col-lg-2">Response Status</div> 
                <div class="col-lg-4">
                    <input name="Status" type="checkbox" <?php 
                      echo $res_data->Status==1?"checked":'';
                    ?> value="1" class="form-control bootswitches">
                </div>
                <div class="col-lg-2">Sort</div> 
                <div class="col-lg-4">
                   <div class="form-group"> 
                    <?php echo form_input("Sort", $res_data->Sort, array("class" => "'form-control popover_element'", "placeholder" => "'Sorting of Response'", "maxlength" => "2", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only 0-99 are allowed, It will help to sort the response.'", "data-original-title" => "'Remember'"));
                     echo form_hidden("rid",$res_data->ResponseID);
                    ?>
                </div>
                </div>
            </div> 
            <!--<div class="panel-footer">-->
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                    <button type="reset" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>
            </div>
            <!--</div>-->
        </div>
 </div>   
</div>

 <?php 
       $this->load->view('Enquiry/others/response/res-validation');
       
       ?>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>