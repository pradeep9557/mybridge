<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Create A New Job</h4>
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
                    <h3 class="panel-title toggle_custom">Create Jobs
                        <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>  

                <div class="panel-body collapse" id="collapseExample">
                    <?php
                    echo form_open(base_url() . "job_trkr/c_job_mst/insert_data", "id='job_mst'");
                    ?>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">job Code</div>
                        <div class="col-lg-4"><?php echo form_input('jobCode', "", "class='form-control' Placeholder='Job Code'") ?></div>
                        <div class="col-lg-2">Job Description</div>
                        <div class="col-lg-4"> <?php echo form_input('Job_Description', "", "class='form-control' Placeholder='Description'") ?></div>
                    </div>   
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Job Address</div>
                        <div class="col-lg-4"><?php echo form_input('JobAddress', "", "class='form-control' Placeholder='Address'") ?></div>
                        <div class="col-lg-2">Job Assigned to</div>
                        <div class="col-lg-4"><?php echo form_dropdown('Job_Assigned_to', $emp_list, '', "class='form-control chosen-select'") ?> </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Job Status ID</div>
                        <div class="col-lg-4"><?php echo form_dropdown('JobStatusID', $status_list, "", "class='form-control chosen-select' ") ?></div>
                        <div class="col-lg-2">Job Charge</div>
                        <div class="col-lg-4"> <?php echo form_input('JobCharge', "", "class='form-control 'Placeholder='Charges'") ?></div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-2">Remarks</div>
                        <div class="col-lg-4"><?php echo form_textarea('Remarks', "", "class='form-control' Placeholder='Remarks'") ?></div>

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
            $Curr_Obj->jobs_list();
            ?>  
        </div> 
    </div>
</div>
<?php
    $this->load->view("job_trkr/job_validation");
?>



