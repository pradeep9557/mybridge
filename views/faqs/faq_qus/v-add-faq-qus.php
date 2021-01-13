<div id="page-wrapper" style="min-height: 345px;">
    <div class="col-lg-12">
        <h4 class="page-header">Faq  Questions
            <a href="<?php echo base_url(); ?>faqs/manage_manu" class="pull-right">
                <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                    <span class="glyphicon glyphicon-edit"></span> Manage Faqs Menu
                </button></a>
        </h4>
        <?php
        if (isset($error)) {
                      $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
        }
        ?>
    </div>
    <div class="col-lg-12">
        <!-- /.col-lg-12 -->
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#faq_menu_form">
                <h3 class="panel-title toggle_custom">Add Questions FAQ'S From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.col-lg-12 -->
            <div class="panel-body collapse" id="faq_menu_form">
                <div class="col-lg-12">
                    <?php
                     echo form_open(base_url() . "faqs/save_faq_qus","id='faq_ques_form'");
                    ?>
                   
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Menu ID</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                     <?php echo form_dropdown("menuid",$faq_m_list,1,"class='form-control chosen-select'"); ?>
                                   
                                </div>   
                            </div>  
                            <div class="col-sm-2 padding_top_label">Questions</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uid" name="question" placeholder="Questions">
                                </div>   
                            </div>  
                        </div>
                              <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Status</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo form_dropdown("Status",$this->util_model->active_deactive(),1,"class='form-control chosen-select'"); ?>
                                </div>   
                            </div>  

                        </div>
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Answers</div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <?php echo form_textarea("ans","",array("class"=>"form-control","Placeholder"=>"Answers"),12,6); ?>
                                </div>   
                            </div>
                        </div>

                       
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="submit" name="save_faq_qus" class="btn btn-sm btn-success" value="save_faq_qus">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                Save
                            </button>

                            <button type="reset" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                Reset
                            </button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->load->view("faqs/faq_qus/faq_q_valid");
    ?>
    <div class="col-lg-12">
        <?php
        $Curr_Obj = & get_instance();
        $Curr_Obj->faq_qus_list();
        ?>  
    </div>
</div>

