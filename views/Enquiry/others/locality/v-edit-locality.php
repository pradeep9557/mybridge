<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Locality
                <a href="<?php echo base_url() ?>Enquiry/c_locality/" class="pull-right margin_top-10px"> 
                    <button type="button" name="link" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-arrow-up"></span> Back
                    </button>
                </a>
            </h4>
            <?php
            if (isset($error)) {
              //  print_r($err_codes);
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Edit Locality From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  
        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "Enquiry/c_locality/update_locality", "id='edit_locality_form'");
            ?>
            <div class="col-lg-12 bottom_gap">
                <div class="row bottom_gap">
                    <div class="col-lg-2">Filter Parent Locality Via city </div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("", $city_list, $ldata->city_id, "class='form-control chosen-select'") ?>
                        </div>
                    </div>
                    <div class="col-lg-2">Parent Locality </div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("parentid", $locality_list, $ldata->parentid, "class='form-control chosen-select'") ?>
                        </div>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-2">City </div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("city_id", $city_list, $ldata->city_id, "class='form-control chosen-select'") ?>
                        </div>
                    </div>
                    <div class="col-lg-2">Locality Code</div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="form-group">
                                <?php echo form_input("lcode", $ldata->lcode, array("id" => "lcode", "class" => "'form-control popover_element1'", "data-content" => "'Locality required,   max 25 characters'", "placeholder" => "'Locality Name'", "maxlength" => "25")) ?>
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

                    <div class="col-lg-2">Locality Full Name </div>
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_input("locality", $ldata->locality, array("id" => "lcode", "class" => "'form-control popover_element1'", "data-content" => "'Locality required,   max 25 characters'", "placeholder" => "'Locality Name'", "maxlength" => "25")) ?>
                        </div>
                    </div>

                    <div class="col-lg-2">Status</div> 
                    <div class="col-lg-4">
                        <div class="form-group">	
                            <?php echo form_dropdown("Status", array("1"=>"Enable","0"=>"Disable"), $ldata->Status == STATUS_TRUE ? 1 : 0, "class='form-control chosen-select'") ?>
                        </div>
                        <!--<input type="checkbox" name="Status" <?php //echo  ? 'checked' : ''; ?> class="form-control bootswitches">-->
                    </div>
                </div>  
                <div class="row bottom_gap">
                    <div class="col-lg-2">Sort</div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <?php echo form_input("Sort", $ldata->Sort, array("id" => "Sort", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'Locality Name required,   max 50 characters'", "placeholder" => "'Locality Name'", "maxlength" => "2")) ?>
                        </div>

                    </div>
                    <div class="col-lg-2 padding_top_label">Remarks</div>
                    <div class="col-lg-4">
                        <?php
                        echo form_hidden("id", $ldata->localityid);
                        echo form_textarea("Remarks", $ldata->Remarks, array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3)
                        ?>                               
                    </div>
                </div>  

                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <button type="submit" value="Save" class="btn btn-success btn-md">
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

    <?php
    $this->load->view('Enquiry/others/locality/c-validation');
    ?>

</div>

<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>



<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
$('#edit_locality_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            lcode: {// Locality Code
                validators: {
                    notEmpty: {
                        message: 'Locality code is required and can\'t be left empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s_-]+$/,
                        message: 'Locality code can only consist given alphabets a-zA-Z0-9_- or space'
                    },
                    stringLength: {
                        min: 3,
                        max: 150,
                        message: 'Locality code must be more than 3 characters long'
                    }
                }
            },
            locality: {// Locality name
                validators: {
                    notEmpty: {
                        message: 'Locality Name is required and can\'t be left empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s]+$/,
                        message: 'Locality Name can only consist given alphabets a-zA-Z0-9 or space'
                    },
                    stringLength: {
                        min: 3,
                        max: 150,
                        message: 'Locality Name must be more than 3 characters long'
                    }
                }
            }
        }

    });
    </script>