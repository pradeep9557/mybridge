<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Current Doing</h4>
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
            <h3 class="panel-title toggle_custom">Edit Current Doing From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  
        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "Enquiry/c_cdoing/update_cdoing", "id='cdoing_form'");
            ?>
            <div class="col-lg-12 bottom_gap">
                <div class="row bottom_gap">
                    <div class="col-lg-2">Branch</div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                        </div>
                    </div>                
                    <div class="col-lg-2">Code</div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("Code", $cdata->Code, array("id" => "Code", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'Code required,   max 20 characters'", "placeholder" => "'Code'", "maxlength" => "20")) ?>
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
                                <?php echo form_input("Name", $cdata->Name, array("id" => "Name", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "Name required,   max 25 characters'", "placeholder" => "'Name'", "maxlength" => "25")) ?>
                            </div>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="CountryName">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2">Sort</div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo form_input("Sort", $cdata->Sort, array("id" => "Sort", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'Sort Cdoing,   max 2 characters'", "placeholder" => "'Sort By'", "maxlength" => "2")) ?>
                        </div>
                    </div>
                </div>  
                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Remarks</div>
                    <div class="col-lg-4">
                        <?php 
                        echo form_hidden("id",$cdata->CDID);
                        echo form_textarea("Remarks", $cdata->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                    </div>
                    <div class="col-lg-2">Status</div> 
                    <div class="col-lg-4">
                        <input type="checkbox" name="Status" <?php echo $cdata->Status==1?"checked":""; ?>  class="form-control bootswitches">
                    </div>
                </div> 
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <button type="submit" value="Save" class="btn btn-success btn-md">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Update
                        </button>
                        <button type="reset" value="Save" class="btn btn-success btn-md">
                            <span class="glyphicon glyphicon-refresh"></span> Reset
                        </button>
                    </div>
                </div>



            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
  <?php 
     $this->load->view('Enquiry/others/cdoing/c-doing-validation');
    ?>
</div>

<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>