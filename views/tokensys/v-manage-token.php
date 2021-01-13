<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Massage Token </h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
     <div class="row">
        <div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New Token Form
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "tokensys/ct/save_token", "id='token_sys'");
            ?>

          
            <div class="row bottom_gap">
                <div class="col-lg-6">
                    <label>Token Message</label>
                    <div class="form-group">	
                        <?php echo form_textarea("token_msg", "", array("class" => "'form-control'", "Type ypur massage" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                    </div>
                </div> 
                <div class="col-lg-6">
                     <label>Remarks(It will not show to other users)</label>
                    <div class="form-group">	
                        <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "Type ypur massage" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                    </div>
                </div> 
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12">Notify To</div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <div class="form-group">                    
                        <?php echo form_multiselect("nuserid[]", $emp_list, "", "class='form-control chosen-select'") ?>
                    </div>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset" value="Save" class="btn btn-success btn-md">
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
        </div>
     </div>
    
  <div class="row">
        <div class="col-lg-12">
        <?php
        $Curr_Obj = & get_instance();
        $Curr_Obj->token_list();
        ?>  
    </div> 
  </div>
</div>

  <script>
         // Form Validation           
    $(document).ready(function () {
        $('#token_sys').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
                token_msg: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Token Message is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Token Message can only consist of Alpha numeric Characters'
                        },stringLength: {
                            min: 5,
                            max: 50,
                            message: 'Token Message of Question must be more than 5 Characters and less than 50 Characters'
                        }
                    }
                },Remarks: {// field name
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Remakrs can only consist of Alpha numeric Characters'
                        },
                        stringLength: {
                            min: 5,
                            max: 80,
                            message: 'Remarks of Question must be more than 5 Characters and less than 80 Characters'
                        }
                    }
                },nuserid: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Pass at Least One value'
                        }
                    }
                }
               
            }

        });
    });
    

    
</script>

