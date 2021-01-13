<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Manage Remarks</h4>
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
            <h3 class="panel-title toggle_custom">Remarks
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php 
           // $this->util_model->printr($records);
        ?>
         <?php
            echo form_open(base_url()."job_trkr/c_job_mst/save_remarks", "id='job_mst'");
            ?>
            <?php //echo form_hidden('JobID',"") ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Job Status</div>
                <div class="col-lg-4"><?php echo form_dropdown('Job_StatusID',$status_list,"","class='form-control chosen-select' Placeholder='Status'")  ?></div>
                <div class="col-lg-2">Job Remarks</div>
                <div class="col-lg-4"> <?php echo form_textarea('Job_Remarks',"","class='form-control' Placeholder='Remarks'")  ?></div>
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
            $Curr_Obj->remarks_list();
            ?>  
        </div> 
    </div>
</div>
<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#job_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Job_Remarks: {
                    feedbackIcons: true,
                    validators: {
                        notEmpty: {
                            message: 'Description is required and cannot be empty'
                        }
                    }
                }
            }
        });
    });

</script>