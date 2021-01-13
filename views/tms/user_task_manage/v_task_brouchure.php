<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Travel Brouchure</h4>
            <?php
             // die($this->util_model->printr($assignedto)); 
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New Task From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/task_brouchure/create_brouchure', "id='travel_bruochure_form'");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Pending Sub-Task ID<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">


                    <div class="form-group">
                        <?php echo form_dropdown("p_st_id", "", "", "class='form-control chosen-select ' tabindex=1 ") ?>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">By<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">

                    <div class="form-group">
                        <?php echo form_dropdown("by", array("0" => "Select"), "", "class='form-control ' tabindex=1 ", "id=''") ?>
                    </div>

                </div><!-- /input-group -->               

            </div> <!--End of row-->

            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">From<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    
                     <div class="form-group">
                        <?php echo form_dropdown("from","", "", "class='form-control ' tabindex=1 ", "id=''") ?>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">To</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("to", "", array("class" => "'form-control popover_element1'", "placeholder" => "''", "data-content" => "''")) ?>
                    </div> 
                </div>
            </div> <!--End of row-->
            <div class="row bottom_gap">


                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Remarks</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_textarea("comments", "", array("class" => "'form-control tinymce'", "placeholder" => "'Notes for Tarvel-Brouchure'", "maxlength" => "500")) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Amount</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                       <?php echo form_input("amt", "", array("class" => "'form-control popover_element1'", "placeholder" => "'Enter the Amount'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            
            <div class="col-lg-12">
                <button type="button" value="Save" class="btn btn-success btn-md " id="save_pend_task">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
<!--                <input type="hidden" value="" id="p_ttm_id"></inpput>-->
            </div>
            <?php echo form_close() ?>
        </div>
    </div>

</div>
<div class="bottom_gap">&nbsp;&nbsp;</div>
