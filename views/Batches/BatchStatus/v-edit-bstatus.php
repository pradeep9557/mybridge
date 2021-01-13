<div id="page-wrapper" style="min-height: 345px;">
     <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Batch Status</h4>
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
            <h3 class="panel-title toggle_custom">Edit Batch Status From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="collapseExample">
            <?php 
             echo form_open(base_url()."batch/c_bstatus/update_batchstatus","id='batchedit_form'");
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
                            <?php
                           echo form_hidden("rid", $bth_data->BatchStatusID);
                            echo form_input("BatchStatus", $bth_data->BatchStatus, array("class" => "'form-control popover_element'", "placeholder" => "'Status of Batch'", "maxlength" => "20", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Enter tha staus of batch.'", "data-original-title" => "'Remember'")) ?>
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
                        <?php echo form_textarea("Remarks", $bth_data->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?> 
                    </div>
                </div>
         
            <div class="col-lg-2">Status</div> 
            <div class="col-lg-4">
                <input name="Status" type="checkbox" <?=$bth_data->Status == '1' ? 'checked=""' :''?> value="1" class="form-control bootswitches">
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
            <?php echo form_close(); ?>
        </div>
 </div>   
</div>