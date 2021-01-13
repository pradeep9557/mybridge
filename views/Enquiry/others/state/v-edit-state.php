<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New State
                <a href="<?php echo base_url() ?>Enquiry/c_state/" class="pull-right margin_top-10px"> 
                    <button type="button" name="link" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-arrow-up"></span> Back
                    </button>
                </a>
            </h4>
            <?php
            if (isset($error)) {
                ($this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes));
            }
            ?>
        </div>
       
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New State From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  
        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "Enquiry/c_state/update_state", "id='state_form'");
            ?>
            <div class="col-lg-12 bottom_gap">
                <div class="row bottom_gap">
                    <div class="col-lg-2">Country </div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("country_id", $country_list, $sdata->country_id, "class='form-control chosen-select'") ?>
                        </div>
                    </div>
                    <div class="col-lg-2">Code</div> 
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("code", $sdata->code, array("id" => "StateCode", "checking_id" => "'4'", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'State Code required,  3-32 characters'", "placeholder" => "'State Code'", "maxlength" => "32")) ?>
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
                    <div class="col-lg-2">Name</div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("name", $sdata->name, array("id" => "StateName", "checking_id" => "'4'", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'State Name required, 3-128 characters'", "placeholder" => "'State Name'", "maxlength" => "128")) ?>
                            </div>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="CountryName">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2">Status</div> 
                    <div class="col-lg-4">
                        <input type="checkbox" name="Status" <?php echo $sdata->Status ? 'checked' : ''; ?> class="form-control bootswitches">
                    </div>
                </div>  

                <div class="row bottom_gap ">
                    <div class="col-lg-2 padding_top_label">Remarks</div>
                    <div class="col-lg-4">
                        <?php
                        echo form_hidden("id", $sdata->state_id);
                        echo form_textarea("Remarks", $sdata->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3)
                        ?>                               
                    </div>
                </div>  

                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <button type="submit" value="Save" class="btn btn-success btn-sm " >
                            <span class="glyphicon glyphicon-floppy-disk"></span> Update
                        </button>

                    </div>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>

</div>

<?php
$this->load->view('Enquiry/others/state/state-validation');
//   $this->load->view('Enquiry/others/state/v-all-state')
?>
<script>
//  $("#state_form").trigger('reset');
</script>


<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>