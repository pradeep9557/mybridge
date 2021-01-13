<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
      <div class="col-lg-12">
            <h4 class="page-header ">New Designation</h4>
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
                                    <div class="form-group">
                           <?php echo form_input("Code", "", array("class"=>"'form-control'","placeholder"=>"'Designation Code'","maxlength"=>"15"))?>
                             </div>	
                        </div><!-- /form-group -->               
                  <!-- end of col-lg-4 -->
				<div class="col-lg-2 padding_top_label">Name</div>
				<div class="col-lg-4">
                                     <div class="form-group">
                                    <?php echo form_input("Name", "", array("class"=>"'form-control'","placeholder"=>"'Designation Name'","maxlength"=>"43"))?>
                                </div>
                                </div>
            </div> <!--End of row-->
    <!--String of Row-->
    <!--End of row-->
    <div class="row bottom_gap">

         <div class="col-lg-2 padding_top_label">Status </div>
        <div class="col-lg-4">
            <?php
            echo form_dropdown("Status", $active_deactive, "Active","class= 'form-control'");   
            ?>
        </div>
       
        <div class="col-lg-2 padding_top_label">Add User</div>
        <div class="col-lg-4">
            <?php
            echo form_input("Add_User", "{$Session_Data['IBMS_USER_ID']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
            echo form_hidden("Mode_User", "NA");
            echo form_hidden("Company", "NA");
            echo form_hidden("Branch", "NA");
            ?>
        </div>
       
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Remarks</div>
        <div class="col-lg-4">
            <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
        </div> 
    </div>
    <div class="row col-lg-12">
        <button type="submit" name="Add_Designation" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Save
        </button>
        <button type="submit" name="Add_Designation" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>

    </div>
 <?php
    echo form_close();
    $Curr_Obj =& get_instance();
    $Curr_Obj->All_Designation_List();
   ?>
</form>
</div>
<script>
    //      Form Validation           
    $(document).ready(function() {
        $('#new_designation_form').bootstrapValidator({
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