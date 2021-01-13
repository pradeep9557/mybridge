<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Error</h4>
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
            <h3 class="panel-title toggle_custom">New Error From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body collapse" id="collapseExample">
            <?php foreach ($err_data as $value) {
           }
        ?>
            <?php
            echo form_open(base_url() . "superadmin/c_err_mst/update_err", "id='err_form'");
             echo form_hidden('ERRID',$value['ERRID']);
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Error Code</div> 
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="form-group">
                            <?php echo form_input("ErrCode", $value['ErrCode'], array("class" => "'form-control popover_element'", "placeholder" => "'Error Code'", "maxlength" => "25", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "' It will help to identify error.'", "data-original-title" => "'Remember'")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="CountryName">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2">Error </div> 
                <div class="col-lg-4">
                    <div class="form-group"> 
                        <?php echo form_input("ErrCodeDes", $value['ErrCodeDes'], array("class" => "'form-control popover_element'", "placeholder" => "'Error'", "maxlength" => "150", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'It will help to discribe Error.'", "data-original-title" => "'Remember'")) ?>
                    </div>
                </div>
            </div> 
            <div class="row bottom_gap"> 
                <div class="col-lg-2">Error Remarks</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_textarea("Remarks", $value['Remarks'], array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?> 
                   </div>
                </div>
                <div class="col-lg-2">Status</div>
                <div class="col-lg-4"> <?php echo form_dropdown('status',$this->util_model->active_deactive(),1,"class='form-control chosen-select'")  ?></div>     
            
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
        </div>
        <script>
            // validation of   response_form 
            $(document).ready(function () {
            $('#err_form').bootstrapValidator({
            feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
            },
                    fields: {
                    ErrCode: {
                    message: 'Enquirer Code is not valid',
                            validators: {
                            notEmpty: {
                            message: 'Error code is required and can\'t be empty'
                            },
                                    regexp: {
                                    regexp: /^[a-zA-Z0-9_\s!]+$/,
                                            message: 'Error can only consist numbers and alphabets'
                                    }, stringLength: {
                            min: 3,
                                    max: 25,
                                    message: 'Error code Should be 3 to 25 characters long'
                            }
                            }
                    },
                    ErrCodeDes: {
                    message: 'Enquirer Name is not valid',
                            validators: {
                            notEmpty: {
                            message: 'Error Text is required and can\'t be empty'
                            },
                                    regexp: {
                                    regexp: /^[a-zA-Z0-9_\s]+$/,
                                            message: 'Error Text can only consist numbers and alphabets'
                                    }, stringLength: {
                            min: 10,
                                    max: 150,
                                    message: 'Error Text Should be 10 to 150 characters long'
                            }
                            }
                    }
                    }

            });
            });

        </script>
    </div>
    <?php
    $Curr_Obj = & get_instance();
    $Curr_Obj->all_err_list();
    ?>

</div>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>