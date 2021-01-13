<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Country</h4>
           
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
            <h3 class="panel-title toggle_custom">New Country From
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "Enquiry/c_country/save_country", "id='country_form'");
            ?>

            <div class="row bottom_gap">
                <div class="col-lg-2">Country Name</div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="form-group">
                            <?php echo form_input("name", "", array("id" => "CountryName", "checking_id" => "'11'", "class" => "'form-control   popover_element1'", "data-content" => "'Country Name required,   max 50 characters'", "placeholder" => "'Country Name'", "maxlength" => "50")) ?>
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
                    <input type="checkbox" name="Status" checked="" value="1" class="form-control bootswitches">
                </div>
            </div>

            <div class="row bottom_gap">               

                <div class="col-lg-2 padding_top_label">Remarks</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                    </div>
                </div>

            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset"  class="btn btn-success btn-md">
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
    
    <?php 
    $this->load->view('Enquiry/others/country/c-validation');
    ?>

<?php
$Curr_Obj = & get_instance();
$Curr_Obj->all_country_list();
?>
</div>



<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>