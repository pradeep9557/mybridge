<div id="page-wrapper" style="min-height: 345px;">
    <div class="col-lg-12">
        <h4 class="page-header">Faq Menus
            <a href="<?php echo base_url(); ?>faqs/manage_faq_qus" class="pull-right">
                <button type="button" name="link" class="btn btn-success btn-md margin_top-10px">
                    <span class="glyphicon glyphicon-edit"></span> Manage Faqs Question
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
                <h3 class="panel-title toggle_custom">New FAQ'S From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.col-lg-12 -->
            <div class="panel-body collapse" id="faq_menu_form">
                <div class="col-lg-12">
                    <?php
                     echo form_open(base_url() . "faqs/save_faq_menu","id='faq_menu_form_valid'");
                    ?>
                   
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">HTML ID</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uid" name="htmlid" placeholder="Html ID">
                                </div>   
                            </div>  
                            <div class="col-sm-2 padding_top_label">M Heading Text</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="uid" name="m_heading_text" placeholder="Meta Heading Text">
                                </div>   
                            </div>  
                        </div>

                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Div Heading Text</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo form_input("div_heading_text","",array("class"=>"form-control","Placeholder"=>"Div Heading text")); ?>
                                </div>   
                            </div>  
                            <div class="col-sm-2 padding_top_label">Status</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php echo form_dropdown("Status",$this->util_model->active_deactive(),1,"class='form-control chosen-select'"); ?>
                                </div>   
                            </div>  

                        </div>
                        <div class="row bottom_gap">
                            <div class="col-sm-2 padding_top_label">Remarks</div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                 <?php echo form_textarea("Remarks","","class='form-control'"); ?>    
                                </div>   
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="submit" name="save_faq_menu" class="btn btn-sm btn-success" value="save_faq">
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
    <div class="col-lg-12">
        <?php
        $Curr_Obj = & get_instance();
        $Curr_Obj->faq_menu_list();
        ?>  
    </div>
</div>
  <script>
         // Form Validation           
    $(document).ready(function () {
        $('#faq_menu_form_valid').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
                htmlid: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Html ID is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Menu ID can only consist of Alpha numeric Characters'
                        }
                    }
                },m_heading_text: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Meta Heading Text is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 50,
                            message: 'Length of Question must be more than 3 Characters'
                        }
                    }
                },div_heading_text: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Div Heading  is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Lenght of Answer must be more than 3 Characters'
                        }
                    }
                },Remarks: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Remark is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 5,
                            max: 100,
                            message: 'Lenght of Remark must be more than 5 Characters'
                        }
                    }
                }
               
            }

        });
    });
    

    
</script>
