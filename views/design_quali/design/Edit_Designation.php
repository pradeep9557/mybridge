
<div id="page-wrapper" style="margin-left: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Edit Designation</h4>

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
    echo form_open_multipart(base_url() . 'designation_controller/Designation_save_update', $attributes);
    ?>
    <!--String of Row-->
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Code</div>
        <div class="col-lg-4">

            <?php echo form_input("Code", "{$Designation_Data->Code}", array("class" => "'form-control'", "placeholder" => "'Designation Code'", "maxlength" => "15"));
             echo form_hidden("Old_Code", "$Designation_Data->Code");
            ?>

        </div><!-- /input-group -->               
        <!-- end of col-lg-4 -->
        <div class="col-lg-2 padding_top_label">Name</div>
        <div class="col-lg-4">
            <?php echo form_input("Name", "{$Designation_Data->Name}", array("class" => "'form-control'", "placeholder" => "'Designation Name'", "maxlength" => "43")) ?>
        </div>
    </div> <!--End of row-->
    <!--String of Row-->
    <!--End of row-->
    
    <div class="row bottom_gap">
        
         <div class="col-lg-2 padding_top_label">Status </div>
        <div class="col-lg-4">
            <?php
            echo form_dropdown("Status", $active_deactive, $Designation_Data->Status,"class= 'form-control'");   
            ?>
        </div>
       
        <div class="col-lg-2 padding_top_label">Add User</div>
        <div class="col-lg-4">
            <?php
            echo form_input("Mode_User", "{$Session_Data['IBMS_USER_ID']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
            echo form_hidden("Add_User", "{$Designation_Data->Add_User}");
            echo form_hidden("Company", "NA");
            echo form_hidden("Branch", "NA");
            ?>
        </div>
        
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Remarks</div>
        <div class="col-lg-4">
            <?php echo form_textarea("Remarks", "{$Designation_Data->Remarks}", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
        </div>
    </div>
    <div class="row">
        <button type="submit" name="Add_Designation" value="Update" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Save
        </button>
        <button type="submit" name="Add_Designation" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>

    </div>

</form>
</div>
