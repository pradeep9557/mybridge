
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">New Fee Type</h4>

            <?php
            if (isset($error)) {
                          $this->util_model->show_result_error($error, SUCCESS_MSG, ERROR_MSG);
            }
            ?>

        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#feetypeform">
            <h3 class="panel-title toggle_custom">Fee Type Form<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="feetypeform">

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
                        <?php echo form_input("FeeType_Code", "", array("class" => "' form-control '", "placeholder" => "'Fee Type Code'", "maxlength" => "15")) ?>
                    </div>
                </div><!-- /input-group -->               
                <!-- end of col-lg-4 -->
                <div class="col-lg-2 padding_top_label">Fee Type Name</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("FeeType_Name", "", array("class" => "' form-control '", "placeholder" => "'Fee Type Name'", "maxlength" => "43")) ?>
                    </div>
                </div>
            </div> <!--End of row-->

            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Late Payment Fee</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_input("Late_Payment_Fee", 0, array("class" => "' form-control '", "placeholder" => "'Per Day late payment'")) ?>
                    </div>
                </div><!-- /input-group -->               
                <!-- end of col-lg-4 -->
                <div class="col-lg-2 padding_top_label">Days relaxation in late payment fee</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("Fine_Day_Limit", 0, array("class" => "' form-control '", "placeholder" => "'Days relaxation in late payment fee'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            <!--End of row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 padding_top_label">Status </div>
                <div class="col-lg-4">
                    <?php
                    echo form_dropdown("Status", $active_deactive, 1, "class= 'form-control chosen-select'");
                    ?>
                </div>

                <div class="col-lg-2 padding_top_label">Tax Enable</div>
                <div class="col-lg-4">
                    <?php
                    echo form_dropdown("tax_enabled", $active_deactive, 0, "class= 'form-control chosen-select'");
                    ?>                               
                </div> 

            </div>

            <div class="row padding_top_label">
                <div class="col-lg-2 padding_top_label">Sort</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_input("Sort", 0, array("class" => "' form-control '", "placeholder" => "'Sorting Order'")) ?>
                    </div>
                </div><!-- /input-group --> 
                <div class="col-lg-2 padding_top_label">Remarks</div>
                <div class="col-lg-4">
                    <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                </div> 
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="Add_Fee_Type" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset" name="Add_Fee_Type" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>

            </div>
        </div>
    </div>
    <?php
    echo form_close();
    $Curr_Obj = & get_instance();
    $Curr_Obj->all_Fee_Type_list();
    ?>


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