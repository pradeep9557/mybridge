
<div id="page-wrapper" style="margin: 0px">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit Fee Type</h4>

            <?php
            if (isset($error)) {
                          $this->util_model->show_result_error($error, SUCCESS_MSG, ERROR_MSG);
            }
            ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //for normal form
    //  echo form_open('/dashboard/new_admission',$attributes);
    echo form_open_multipart(base_url() . 'fees/fee_type/Fee_Type_save_update', "id='Fee_Type_validation_form'");
    ?>
    <!--String of Row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Fee Type Code</div>
        <div class="col-lg-4">
            <div class="form-group">	
                <?php
                echo form_input("FeeType_Code", "{$FeeType_Data->FeeType_Code}", array("class" => "' form-control '", "placeholder" => "'Fee Type Code'", "maxlength" => "15"));

                echo form_hidden("FeeTypeID", "$FeeType_Data->FeeTypeID");
                ?>
            </div>
        </div><!-- /input-group -->               
        <!-- end of col-lg-4 -->
        <div class="col-lg-2 padding_top_label">Fee Type Name</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("FeeType_Name", "$FeeType_Data->FeeType_Name", array("class" => "' form-control '", "placeholder" => "'Fee Type Name'", "maxlength" => "43")) ?>
            </div>
        </div>
    </div> <!--End of row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Late Payment Fee</div>
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_input("Late_Payment_Fee", $FeeType_Data->Late_Payment_Fee, array("class" => "' form-control '", "placeholder" => "'Per Day late payment'")) ?>
            </div>
        </div><!-- /input-group -->               
        <!-- end of col-lg-4 -->
        <div class="col-lg-2 padding_top_label">Days relaxation in late payment fee</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Fine_Day_Limit", $FeeType_Data->Fine_Day_Limit, array("class" => "' form-control '", "placeholder" => "'Days relaxation in late payment fee'")) ?>
            </div>
        </div>
    </div> <!--End of row-->
    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">Status </div>
        <div class="col-lg-4">
            <?php
            echo form_dropdown("Status", $active_deactive, $FeeType_Data->Status, "class= 'form-control chosen-select'");
            ?>
        </div>

        <div class="col-lg-2 padding_top_label">Tax Enable</div>
        <div class="col-lg-4">
            <?php
            echo form_dropdown("tax_enabled", $active_deactive, $FeeType_Data->tax_enabled, "class= 'form-control chosen-select'");
            ?>                               
        </div> 

    </div>

    <!--String of Row-->
    <!--End of row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Sort</div>
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_input("Sort", $FeeType_Data->Sort, array("class" => "' form-control '", "placeholder" => "'Sorting Order'")) ?>
            </div>
        </div><!-- /input-group --> 
        <div class="col-lg-2 padding_top_label">Remarks</div>
        <div class="col-lg-4">
            <?php echo form_textarea("Remarks", "{$FeeType_Data->Remarks}", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
        </div>
    </div>
    <div class="row">
        <button type="submit" name="Add_Fee_Type" value="Update" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Update
        </button>


    </div>
    <?php ?>


</div>
<?php 
   $this->load->view("Fee_Type/fee_type_valid");
 ?>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>