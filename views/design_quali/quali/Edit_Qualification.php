
<div id="page-wrapper" style="margin: 0px">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit Qualification</h4>

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
    echo form_open_multipart(base_url() . 'qualification_controller/qualification_save_update', $attributes);
    ?>
    <!--String of Row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Code</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php
                echo form_input("Code", "{$qualification_Data->Code}", array("class" => "'form-control'", "placeholder" => "'qualification Code'", "maxlength" => "15"));
                echo form_hidden("Old_Code", $qualification_Data->Code);
                ?>
            </div>	
        </div><!-- /form-group -->               
        <!-- end of col-lg-4 -->
        <div class="col-lg-2 padding_top_label">Name</div>
        <div class="col-lg-4">
            <div class="form-group">
            <?php echo form_input("Name", "{$qualification_Data->Name}", array("class" => "'form-control'", "placeholder" => "'qualification Name'", "maxlength" => "43")) ?>
            </div>
        </div>
    </div> <!--End of row-->
    <!--String of Row-->
    <!--End of row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Status </div>
        <div class="col-lg-4">
            <?php
            echo form_dropdown("Status", $active_deactive, $qualification_Data->Status, "class= 'form-control'");
            ?>
        </div>
        <div class="col-lg-2 padding_top_label">Add User</div>
        <div class="col-lg-4">
            <?php
            echo form_input("Mode_User", "{$Session_Data['IBMS_USER_ID']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
            echo form_hidden("Add_User", "{$qualification_Data->Add_User}");
            echo form_hidden("Company", "NA");
            echo form_hidden("Branch", "NA");
            ?>
        </div>

    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Remarks</div>
        <div class="col-lg-4">
        <?php echo form_textarea("Remarks", "{$qualification_Data->Remarks}", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
        </div>
    </div>
    <div class="row">
        <button type="submit" name="Add_qualification" value="Update" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Update
        </button>
        <button type="reset" name="Add_qualification" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>

    </div>

</form>
</div>
<script>
    //      Form Validation           
    $(document).ready(function() {
        $('#qualification_validation_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Code: {
                    feedbackIcons: true,
                    validators: {
                        notEmpty: {
                            message: 'Code is required and cannot be empty'
                        }
                    }
                }, Name: {
                    feedbackIcons: true,
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                }
            }
        });
    });

</script>