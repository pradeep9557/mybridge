<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">New User Type</h4>

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
            <h3 class="panel-title toggle_custom">User Type From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'sp-admin/a/AddUserType', "id='UserTypeForm'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">UserType<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("UserTypeName", "", array("class" => "'form-control  popover_element1'", "placeholder" => "'UserType'", "maxlength" => "50")) ?>
                    </div>
                </div>
                <div class="col-lg-2 padding_top_label">Status</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php
                        $options = array(
                            '1' => 'Enable',
                            '0' => 'Disable',
                        );
                        echo form_dropdown('Status', $options, '', 'class="form-control" placeholder="Status" ');
                        ?>
                    </div>	
                </div>
            </div> <!--End of row-->    
            <!--String of Row-->
            <div class="row bottom_gap">
                <!-- /form-group -->               
                <!-- end of col-lg-4 -->
                <div class="col-lg-2 padding_top_label">Sort</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_input("Sort", "", array("class" => "'form-control'", "placeholder" => "'Sort Order'", "maxlength" => "2")) ?>
                    </div>
                </div>
                <div class="col-lg-2 padding_top_label">Level</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php
                        $options = array();
                        for ($i = 0; $i <= 100; $i++) {
                            $options[] = "$i";
                        }
                         
                        echo form_dropdown('Level', $options, '', 'class="form-control" placeholder="" ');
                        ?>
                    </div>	
                </div>
				                <div class="col-lg-2 padding_top_label">Group</div>
                <div class="col-lg-4">
                    <div class="form-group">
<?php
                        echo form_dropdown('UserTypeGroup', $UserGroupList, '', 'class="form-control" placeholder="" ');
                        ?>
                    </div>	
                </div>
            </div> <!--End of row-->
            <div class="row">
                <div class="col-lg-offset-2 col-lg-3 form-group">
                    <button class="btn btn-sm btn-success" type="submit">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                    <button type="reset" value="Save" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>

    </div>

    <?php
    $this->load->view('superadmin/usertypes/all_usertypes');
	?>
</div>

<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<script>
    $('#UserTypeForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            UserTypeName: {// User Type Name
                validators: {
                    notEmpty: {
                        message: 'User Name is required and can\'t be left empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\s_-]+$/,
                        message: 'Name can only consist given alphabets a-zA-Z0-9_- or space'
                    },
                    stringLength: {
                        min: 3,
                        max: 150,
                        message: 'Name must be more than 3 characters long'
                    }
                }
            }
        }

    });

</script>
