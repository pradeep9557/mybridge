<div id="page-wrapper" style="min-height: 345px;">
    <div class="col-lg-12">
        <h4 class="page-header">Edit Faq Menus</h4>
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
                <h3 class="panel-title toggle_custom">New FAQ'S From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.col-lg-12 -->
            <div class="panel-body" id="faq_menu_form">
                <div class="col-lg-12">
                    <?php
                     echo form_open(base_url() . "faqs/update_faq_menu","id='faq_menu_form_valid'");
                    echo form_hidden("menuid",$faq_menu_data[0]->menuid);
                    ?>
                   
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">HTML ID</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uid" name="htmlid" placeholder="Html ID" value="<?php echo $faq_menu_data[0]->htmlid ?>">
                                </div>   
                            </div>  
                            <div class="col-sm-2 padding_top_label">M Heading Text</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uid" name="m_heading_text" placeholder="Meta Heading Text" value="<?php echo $faq_menu_data[0]->m_heading_text ?>">
                                </div>   
                            </div>  
                        </div>

                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Div Heading Text</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo form_input("div_heading_text",$faq_menu_data[0]->div_heading_text,array("class"=>"form-control","Placeholder"=>"Div Heading text" )); ?>
                                </div>   
                            </div>  
                            <div class="col-sm-2 padding_top_label">Status</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo form_dropdown("Status",$this->util_model->active_deactive(),$faq_menu_data[0]->Status,"class='form-control chosen-select'"); ?>
                                </div>   
                            </div>  

                        </div>
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Remarks</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                 <?php echo form_textarea("Remarks",$faq_menu_data[0]->Remarks,"class='form-control'"); ?>    
                                </div>   
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="submit" name="Update_faq_menu" class="btn btn-sm btn-success" value="Update_faq_menu">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                Update
                            </button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  $this->load->view("faqs/menu/faq_menu_valid");
?>  
