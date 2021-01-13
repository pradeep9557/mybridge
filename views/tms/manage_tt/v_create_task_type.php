<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Manage Task Category
                <?php
                if (isset($error)) {
                    $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
                }
                ?>

                <?php
                foreach ($extra_link as $each_link) {
                    ?>
                    <a href="<?php echo $each_link['link'] ?>" class="pull-right">
                        <button type="submit" class="btn btn-success btn-md margin_top-10px">
                            <span class="<?php echo $each_link['icon'] ?>"></span> <?php echo $each_link['name'] ?>
                        </button></a>
                <?php } ?>


            </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row ">
        <div class="col-lg-12">
            <ul class="nav nav-tabs">
                <li key="create" class="watch_click create_tab <?php echo $tab == "create" ? "active" : "" ?>"><a data-toggle="tab" href="#create">Create Task Category Form</a></li>
                <li key="docs_required" class="watch_click doc_tab <?php echo (isset($id) && $id != "") ? "" : "disabled" ?> <?php echo $tab == "docs_required" ? "active" : "" ?>"><a data-toggle="tab" href="#docs_required">Manage Required Docs</a></li>
                <li key="sub_task" class="watch_click sub_tab <?php echo (isset($id) && $id != "") ? "" : "disabled" ?> <?php echo $tab == "sub_task" ? "active" : "" ?>"><a data-toggle="tab" href="#sub_task">Manage Sub Tasks</a></li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div id="create" class="create_tab_body tab-pane fade <?php echo $tab == "create" ? "in active" : "" ?>">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title">Task Category Form<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body"> 

                    <?php
                    //for normal form
                    //  echo form_open('/dashboard/new_admission',$attributes);
                    echo form_open_multipart(base_url() . 'tms/manage_tt/add_basic_details', "id='basic_details_form'");
                    if (isset($task_data) && $task_data['ttm_id'] != "") {
                        ?>
                        <input type="hidden" name="ttm_id" value="<?php echo $task_data['ttm_id']; ?>"/>
                    <?php }
                    ?>
                    <input type="hidden" name="action" value="1">
                    <div class="row bottom_gap">
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Category Name<span class="Compulsory">*</span></div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_input("ttm_name", (isset($task_data) && !empty($task_data)) ? $task_data['ttm_name'] : "", array("class" => "'form-control  '", "placeholder" => "'Task Category Name'")) ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Under</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="input-group">
                                <?php echo form_dropdown("parent_ttmid", $under, (isset($task_data) && !empty($task_data)) ? $task_data['parent_ttmid'] : "", "class='form-control parent_ttm'") ?>
                                <span class="input-group-addon popover_under"  id="basic-addon1" >
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </span>
                            </div><!-- /input-group -->               
                        </div> 
                    </div> <!--End of row-->    
                    <!--String of Row-->
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Task Category Code</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_input("ttm_code", (isset($task_data) && !empty($task_data)) ? $task_data['ttm_code'] : "", array("class" => "'form-control db_ttm_code'", "placeholder" => "'Task Category Code'")) ?>
                            </div>
                        </div>
                        <div class="col-lg-2 padding_top_label">Status</div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo form_dropdown("status", array("1" => "Enable", "0" => "Disable"), 1, "class='form-control'") ?>
                            </div>	
                        </div><!-- /form-group -->               
                        <!-- end of col-lg-4 -->
                    </div> <!--End of row-->
                    <!--String of Row-->
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Purpose</div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <?php echo form_textarea("purpose", (isset($task_data) && !empty($task_data)) ? $task_data['purpose'] : "", array("class" => "'form-control tinymce'", "placeholder" => "'Purpose of Task'")) ?>
                            </div>
                        </div>
                    </div> <!--End of row-->

                    <!--String of Row-->
                    <div class="row bottom_gap">
                        <div class="col-lg-2 padding_top_label">Background</div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <?php echo form_textarea("background", (isset($task_data) && !empty($task_data)) ? $task_data['background'] : "", array("class" => "'form-control tinymce'", "placeholder" => "'Background of Task'")) ?>
                            </div>
                        </div>
                    </div> <!--End of row-->
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <button class="btn btn-sm btn-success" type="submit">
                                <span class="glyphicon glyphicon-floppy-disk" ></span> Save and Stay</button>
                        </div>
                        <div class="col-lg-2 form-group ">
                            <button class="btn btn-sm btn-danger cancelBtn snn" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span>Save and Next</button>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>

            </div>
        </div>
        <div id="sub_task" class="sub_task_body tab-pane fade <?php echo $tab == "sub_task" ? "in active" : "" ?>">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapsesub_task">
                    <h3 class="panel-title">Manage Sub Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse in" id="collapsesub_task">
                    <?php
                    //for normal form
                    //  echo form_open('/dashboard/new_admission',$attributes);
                    echo form_open_multipart(base_url() . 'tms/manage_tt/sub_task_details', "id='sub_task_form'");
                    if (isset($id) && $id != "") {
                        ?>
                        <input type="hidden" name="ttm_id" value="<?php echo $id; ?>"/>
                    <?php }
                    ?>
                    <input type="hidden" name="action" value="1">
                    <div class="sub_task_container">
                        <?php
                        if (isset($task_data) && !empty($task_data['sub_task_data'])) {
                            foreach ($task_data['sub_task_data'] as $value) {
                                ?>
                                <div class="single_sub_task">
                                    <input type="hidden" name="ttstm_id[]" value="<?php echo $value['ttstm_id']; ?>"/>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <h6>
                                                <span class="sub_task_num"></span>
                                                <button type="button" value="Save" class="remove_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                                <button type="button" value="Save" class="add_new_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Name<span class="Compulsory">*</span></div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group">
                                                <?php echo form_input("ttstm_name[]", $value['ttstm_name'], array("class" => "'ttstm_name form-control  '", "placeholder" => "'Sub Task Name'")) ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Code<span class="Compulsory">*</span></div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group">
                                                <?php echo form_input("ttstm_code[]", $value['ttstm_code'], array("class" => "'ttstm_code form-control  '", "placeholder" => "'Sub Task Code'")) ?>
                                            </div>
                                        </div>
                                    </div> <!--End of row-->    
                                    <!--String of Row-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Efforts</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="input-group">
                                                <?php echo form_input("ttstm_efforts[]", $value['ttstm_efforts'], "class='form-control'  placeholder='In hours e.g 4 '") ?>
                                                <span class="input-group-addon popover_branch"  id="basic-addon1" >
                                                    <span class="glyphicon glyphicon-question-sign"></span>
                                                </span>
                                            </div><!-- /input-group -->               
                                        </div> 
                                        <div class="col-lg-2 padding_top_label">Status</div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <?php echo form_dropdown("status[]", array("1" => "Enable", "0" => "Disable"), $value['status'], "class='form-control'") ?>
                                            </div>	
                                        </div><!-- /form-group -->               
                                        <!-- end of col-lg-4 -->
                                    </div> <!--End of row-->
                                    <!--String of Row-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 padding_top_label">Check Points</div>
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <?php echo form_textarea("ttstm_check_points[]", $value['ttstm_check_points'], array("class" => "'form-control tinymce'", "placeholder" => "'Purpose of Task'")) ?>
                                            </div>
                                        </div>
                                    </div> <!--End of row-->
                                    <!--String of Row-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 padding_top_label">Control Points</div>
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <?php echo form_textarea("ttstm_control_points[]", $value['ttstm_control_points'], array("class" => "'form-control tinymce'", "placeholder" => "'Background of Task'")) ?>
                                            </div>
                                        </div>
                                    </div> <!--End of row-->
                                    <!--String of Row-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 padding_top_label">Working Note/FAQ</div>
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <?php echo form_textarea("ttstm_faqs[]", $value['ttstm_faqs'], array("class" => "'form-control tinymce'", "placeholder" => "'Background of Task'")) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="single_sub_task">
                                <input type="hidden" name="ttstm_id[]" value="0"/>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h6>
                                            <span class="sub_task_num"></span>
                                            <button type="button" value="Save" class="remove_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                            <button type="button" value="Save" class="add_new_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </h6>
                                    </div>
                                </div>
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Name<span class="Compulsory">*</span></div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                        <div class="form-group">
                                            <?php echo form_input("ttstm_name[]", "", array("class" => "'ttstm_name form-control  '", "placeholder" => "'Sub Task Name'")) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Code<span class="Compulsory">*</span></div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                        <div class="form-group">
                                            <?php echo form_input("ttstm_code[]", "", array("class" => "'ttstm_code form-control  '", "placeholder" => "'Sub Task Code'")) ?>
                                        </div>
                                    </div>
                                </div> <!--End of row-->    
                                <!--String of Row-->
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Efforts</div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                        <div class="input-group">
                                            <?php echo form_input("ttstm_efforts[]", '', "class='form-control'  placeholder='In hours e.g 4'") ?>
                                            <span class="input-group-addon popover_branch"  id="basic-addon1" >
                                                <span class="glyphicon glyphicon-question-sign"></span>
                                            </span>
                                        </div><!-- /input-group -->               
                                    </div> 
                                    <div class="col-lg-2 padding_top_label">Status</div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo form_dropdown("status[]", array("1" => "Enable", "0" => "Disable"), 1, "class='form-control'") ?>
                                        </div>	
                                    </div><!-- /form-group -->               
                                    <!-- end of col-lg-4 -->
                                </div> <!--End of row-->
                                <!--String of Row-->
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 padding_top_label">Check points</div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <?php echo form_textarea("ttstm_check_points[]", "", array("class" => "'form-control tinymce'", "placeholder" => "'Purpose of Task'")) ?>
                                        </div>
                                    </div>
                                </div> <!--End of row-->
                                <!--String of Row-->
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 padding_top_label">Control Points</div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <?php echo form_textarea("ttstm_control_points[]", "", array("class" => "'form-control tinymce'", "placeholder" => "'Background of Task'")) ?>
                                        </div>
                                    </div>
                                </div> <!--End of row-->
                                <!--String of Row-->
                                <div class="row bottom_gap">
                                    <div class="col-lg-2 padding_top_label">Working Note</div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <?php echo form_textarea("ttstm_faqs[]", "", array("class" => "'form-control tinymce'", "placeholder" => "'Background of Task'")) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <!--End of row-->
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <button class="btn btn-sm btn-success" type="submit">
                                <span class="glyphicon glyphicon-floppy-disk"></span> Save and Finish</button>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>

            </div>
        </div>
        <div id="docs_required" class="doc_tab_body tab-pane fade <?php echo $tab == "docs_required" ? "in active" : "" ?>">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapsedoc_task">
                    <h3 class="panel-title">Manage Sub Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse in" id="collapsedoc_task">
                    <?php
                    //for normal form
                    //  echo form_open('/dashboard/new_admission',$attributes);
                    echo form_open_multipart(base_url() . 'tms/manage_tt/doc_details', "id='doc_details_form'");
                    if (isset($id) && $id != "") {
                        ?>
                        <input type="hidden" name="ttm_id" value="<?php echo $id; ?>"/>
                    <?php }
                    ?>
                    <input type="hidden" name="action" value="1">
                    <div class="doc_container">
                        <?php
                        if (isset($task_data) && !empty($task_data['docs_data'])) {
                            foreach ($task_data['docs_data'] as $value) {
                                ?>
                                <div class="single_doc_panel">
                                    <input type="hidden" key="ttmdoc_id" name="ttmdoc_id[]" value="<?php echo $value['ttmdoc_id']; ?>"/>
                                    <!--                                    <div class="row">
                                                                            <div class="col-lg-12 col-sm-12">
                                                                                <h6>
                                                                                   
                                                                                </h6>
                                                                            </div>
                                                                        </div>-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">Name<span class="Compulsory">*</span></div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group">
                                                <?php echo form_input("ttmdoc_name[]", $value['ttmdoc_name'], array("class" => "'form-control  ttmdoc_name'", "key" => "ttmdoc_name", "placeholder" => "'Document Name'")) ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">File</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group doc_link_selector">
                                                <?php
                                                $file_index = 1;
                                                if ($value['document_path'] != "uploads/" && $value['document_path'] != NULL && $value['document_path'] != "") {
                                                    ?>
                                                    <a title="<?php echo $value['ttmdoc_name'] ?>" target="_blank" href="<?php echo base_url() . $value['document_path'] ?>"><?php echo substr($value['document_path'], 0, 8) . "***" . (substr($value['document_path'], strrpos($value['document_path'], "."))) ?></a>
                                                <?php } else {
                                                    ?>
                                                    <input type="file" key="document_path" name="document_path[<?php echo $file_index ?>]" class="doc_file">
                                                    <?php
                                                }

                                                $file_index++;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 text-right">
                                            <button type="button" value="Save" class="remove_doc btn btn-danger btn-md margin_top-10px">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                            <button type="button" value="Save" class="add_new_doc btn btn-success btn-md margin_top-10px">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                    </div> <!--End of row-->
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="single_doc_panel">
                                <input type="hidden" key="ttmdoc_id" name="ttmdoc_id" value="0"/> 
                                <div class="row bottom_gap">
                                    <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">Name<span class="Compulsory">*</span></div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                        <div class="form-group">
                                            <?php echo form_input("ttmdoc_name", "", array("class" => "'form-control  ttmdoc_name'", "key" => "ttmdoc_name", "placeholder" => "'Document Name'")) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">File</div>
                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                        <div class="form-group">
                                            <input type="file" key="document_path" name="document_path"  class="doc_file"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-right">
                                        <button type="button" value="Save" class="remove_doc btn btn-danger btn-md margin_top-10px">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                        <button type="button" value="Save" class="add_new_doc btn btn-success btn-md margin_top-10px">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </div>
                                </div> <!--End of row-->
                            </div>
                        <?php }
                        ?>

                    </div>
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <button class="btn btn-sm btn-success sns" type="submit">
                                <span class="glyphicon glyphicon-floppy-disk"></span> Save and Stay</button>
                        </div>
                        <div class="col-lg-2 form-group ">
                            <button class="btn btn-sm btn-danger cancelBtn snn" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span>Save and Next</button>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="dummy_content hidden">
        <div class="sub_task_html">
            <div class="single_sub_task">
                <?php if (isset($task_data) && !empty($task_data['sub_task_data'])) { ?>
                    <input type="hidden" name="ttstm_id[]" value="0"/>
                <?php }
                ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <h6>
                            <span class="sub_task_num"></span>
                            <button type="button" value="Save" class="remove_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                            <button type="button" value="Save" class="add_new_sub_task pull-right btn btn-success btn-md margin_top-10px">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </h6>
                    </div>
                </div>
                <div class="row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("ttstm_name[]", "", array("class" => "'ttstm_name form-control  '", "placeholder" => "'Sub Task Name'")) ?>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Code<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("ttstm_code[]", "", array("class" => "'ttstm_code form-control  '", "placeholder" => "'Sub Task Code'")) ?>
                        </div>
                    </div>
                </div> <!--End of row-->    
                <!--String of Row-->
                <div class="row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Efforts</div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="input-group">
                            <?php echo form_input("ttstm_efforts[]", '', "class='form-control'  placeholder='In hours e.g 4 '") ?>
                            <span class="input-group-addon popover_branch"  id="basic-addon1" >
                                <span class="glyphicon glyphicon-question-sign"></span>
                            </span>
                        </div><!-- /input-group -->               
                    </div> 
                    <div class="col-lg-2 padding_top_label">Status</div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo form_dropdown("status[]", array("1" => "Enable", "0" => "Disable"), '', "class='form-control'") ?>
                        </div>	
                    </div><!-- /form-group -->               
                    <!-- end of col-lg-4 -->
                </div> <!--End of row-->
                <!--String of Row-->
                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Check points</div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            <?php echo form_textarea("ttstm_check_points[]", "", array("class" => "'form-control init_tinymce '", "placeholder" => "'Purpose of Task'")) ?>
                        </div>
                    </div>
                </div> <!--End of row-->
                <!--String of Row-->
                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Control Points</div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            <?php echo form_textarea("ttstm_control_points[]", "", array("class" => "'form-control init_tinymce'", "placeholder" => "'Background of Task'")) ?>
                        </div>
                    </div>
                </div> <!--End of row-->
                <!--String of Row-->
                <div class="row bottom_gap">
                    <div class="col-lg-2 padding_top_label">Working Note</div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            <?php echo form_textarea("ttstm_faqs[]", "", array("class" => "'form-control init_tinymce'", "placeholder" => "'Background of Task'")) ?>
                        </div>
                    </div>
                </div> <!--End of row-->
            </div>
        </div>
        <div class="doc_html">
            <div class="single_doc_panel">
                <?php if (isset($task_data) && !empty($task_data['sub_task_data'])) { ?>
                    <input type="hidden" key="ttmdoc_id" name="ttmdoc_id[]" value="0"/>
                <?php }
                ?> 
                <!--                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        
                                    </div>
                                </div>-->
                <div class="row bottom_gap">  
                    <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group">
                            <?php echo form_input("ttmdoc_name", "", array("class" => "'form-control ttmdoc_name '", "key" => "ttmdoc_name", "placeholder" => "'Document Name'")) ?>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-4 padding_top_label">File</div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class="form-group doc_link_selector">
                            <input type="file" key="document_path" name="document_path" class="doc_file"/>
                        </div>
                    </div>
                    <div class='col-lg-2 text-right'>
                        <button type="button" value="Save" class="remove_doc  btn btn-danger btn-md margin_top-10px">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                        <button type="button" value="Save" class="add_new_doc  btn btn-success btn-md margin_top-10px">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button> 
                    </div>
                </div> <!--End of row-->
            </div>
        </div>
    </div>
    <?php
//    $this->load->view('superadmin/usertypes/all_usertypes');
    ?>
</div>

<script src="<?= CDN1 ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script>

    var tiny_init = 0;

    function t_init(selector) {

        tinymce.init({
            selector: selector,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            },
            height: 150,
            plugins: [
                "advlist autolink autosave link  lists charmap     spellchecker",
                "searchreplace wordcount      media ",
                " contextmenu directionality emoticons  textcolor paste textcolor colorpicker textpattern"
            ],
            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | searchreplace | bullist numlist | outdent indent blockquote | media | forecolor backcolor | subscript superscript | charmap emoticons",
            menubar: false,
            toolbar_items_size: 'small'
        });
    }


    function individual_docu_check(that) {
        if ($(that).val() == "" || $(that).val().length > 250) {
            $(that).parents("#doc_details_form .form-group").find(".cs").remove();
            $(that).parents("#doc_details_form .form-group").removeClass("has-feedback has-success");
            $(that).parents("#doc_details_form .form-group").addClass("has-feedback has-error");
            $(that).parents("#doc_details_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-remove'></i><small class='cs help-block text-danger'>Document Name is required</small>");

        } else {
            $(that).parents("#doc_details_form .form-group").find(".cs").remove();
            $(that).parents("#doc_details_form .form-group").removeClass("has-feedback has-error");
            $(that).parents("#doc_details_form .form-group").addClass("has-feedback has-success");
            $(that).parents("#doc_details_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-ok'></i>");
        }
    }

    function doc_error_check() {
        var succ = true;
        $("#doc_details_form .form-group").each(function () {
            if ($(this).hasClass("has-error")) {
                succ = false;
            }
        });
//        console.log(succ);
        if (!succ) {
            $("#doc_details_form").find("button[type=submit]").addClass("disabled");
        } else {
            $("#doc_details_form").find("button[type=submit]").removeClass("disabled");
        }
        return succ;
    }

    function individual_ttstm_code_check(that) {
        if ($(that).val() == "" || $(that).val().length > 250) {
            $(that).parents("#sub_task_form .form-group").find(".cs").remove();
            $(that).parents("#sub_task_form .form-group").removeClass("has-feedback has-success");
            $(that).parents("#sub_task_form .form-group").addClass("has-feedback has-error");
            $(that).parents("#sub_task_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-remove'></i><small class='cs help-block text-danger'>Sub Task Code is required</small>");

        } else {
            $(that).parents("#sub_task_form .form-group").find(".cs").remove();
            $(that).parents("#sub_task_form .form-group").removeClass("has-feedback has-error");
            $(that).parents("#sub_task_form .form-group").addClass("has-feedback has-success");
            $(that).parents("#sub_task_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-ok'></i>");
        }
    }

    function individual_ttstm_name_check(that) {
        if ($(that).val() == "" || $(that).val().length > 250) {
            $(that).parents("#sub_task_form .form-group").find(".cs").remove();
            $(that).parents("#sub_task_form .form-group").removeClass("has-feedback has-success");
            $(that).parents("#sub_task_form .form-group").addClass("has-feedback has-error");
            $(that).parents("#sub_task_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-remove'></i><small class='cs help-block text-danger'>Sub task Name is required</small>");

        } else {
            $(that).parents("#sub_task_form .form-group").find(".cs").remove();
            $(that).parents("#sub_task_form .form-group").removeClass("has-feedback has-error");
            $(that).parents("#sub_task_form .form-group").addClass("has-feedback has-success");
            $(that).parents("#sub_task_form .form-group").append("<i style='top: 0px; display: block;' data-bv-icon-for='ttm_name' class='cs form-control-feedback glyphicon glyphicon-ok'></i>");
        }
    }



    function init() {
        var count = 0;
        $.each($('.sub_task_container').find(".single_sub_task"), function () {
            $(this).find(".sub_task_num").html("# Sub Task " + ++count);
            $(this).find(".sub_task_num").attr("id", "subtask" + count);

        });
        $("#doc_details_form .ttmdoc_name").keyup(function () {
            individual_docu_check(this);
            doc_error_check();
        });
        $("#sub_task_form .ttstm_name").keyup(function () {
            individual_ttstm_name_check(this);
            doc_error_check();
        });
        $("#sub_task_form .ttstm_code").keyup(function () {
            individual_ttstm_code_check(this);
            doc_error_check();
        });
        $('html, body').animate({
            scrollTop: $('#subtask' + count).offset().top - 50
        }, 500);
//        $.scrollTo($('#subtask'+count), 500);
        $.each($(document).find(".add_new_sub_task"), function () {
            $(this).unbind();
        });

        $.each($(document).find(".add_new_doc"), function () {
            $(this).unbind();
        });

        $.each($(document).find(".remove_sub_task"), function () {
            $(this).unbind();
        });

        $.each($(document).find(".remove_doc"), function () {
            $(this).unbind();
        });

        var index = 0;
        $.each($(document).find(".single_doc_panel"), function () {
            index++;
            $.each($(this).find("input"), function () {
                var new_name = $(this).attr("key");
                $(this).attr("name", new_name + "[" + index + "]");
            });
        });

        $(".add_new_sub_task").on("click", function () {
            $(this).parents(".single_sub_task").after($(".dummy_content").find(".sub_task_html").html());
            $.each($(this).parents(".sub_task_container").find(".init_tinymce"), function () {
                $(this).attr("id", ++tiny_init + "dee");
                $(this).removeClass("init_tinymce");
                t_init("#" + tiny_init + "dee");
            });
            init();
        });

        $(".remove_sub_task").on("click", function () {
            console.log($('.sub_task_container').find(".single_sub_task").length);
            if ($('.sub_task_container').find(".single_sub_task").length <= 1) {
                alert("This Can't be deleted!!");
            } else {
                $(this).parents(".single_sub_task").remove();
                init();
            }
        });

        $(".add_new_doc").on("click", function () {
            $(this).parents(".single_doc_panel").after($(".dummy_content").find(".doc_html").html());
            init();
        });

        $(".remove_doc").on("click", function () {
            if ($('.doc_container').find(".single_doc_panel").length <= 1) {
                alert("This Can't be deleted!!");
                return true;
            } else {
                $(this).parents(".single_doc_panel").remove();
                init();
            }
        });
    }

</script>

<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>


<script>

    $(function () {
        $('.bdatetimepicker').datetimepicker({
            format: 'DD-MM-YYYY hh:mm A',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

    });
    /* 
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
    //      Form Validation
    var global_ttm_id = "";
    $(document).ready(function () {

        $(".watch_click").on("click", function () {
            var $_ref = $(this);
            if (global_ttm_id != "") {
                switch ($_ref.attr("key")) {
                    case 'create':
                        change_url(get_base_url() + 'tms/manage_tt/index/create/' + global_ttm_id);
                        break;
                    case 'docs_required':
                        change_url(get_base_url() + 'tms/manage_tt/index/docs_required/' + global_ttm_id);
                        break;
                    case 'sub_task':
                        change_url(get_base_url() + 'tms/manage_tt/index/sub_task/' + global_ttm_id);
                        break;
                    default:
                }
            }
            var switch_tab = false;
            $.each($_ref.parent().find("li"), function (i, value) {
                if ($(this).hasClass("disabled")) {
                    switch_tab = false;
                } else {
                    switch_tab = true;
                }
            });
            if (switch_tab) {
                switch ($_ref.attr("key")) {
                    case 'create':
                        $("#create").addClass("active in");
                        $("#sub_task").removeClass("active in");
                        $("#docs_required").removeClass("active in");
                        break;
                    case 'docs_required':
                        $("#docs_required").addClass("active in");
                        $("#sub_task").removeClass("active in");
                        $("#create").removeClass("active in");
                        break;
                    case 'sub_task':
                        $("#sub_task").addClass("active in");
                        $("#create").removeClass("active in");
                        $("#docs_required").removeClass("active in");
                        break;
                    default:
                }
            }
        });
        t_init("textarea.tinymce");
        init();

        $(".disabled").click(function (e) {
            e.preventDefault();
            return false;
        });

        $(".parent_ttm").on("change", function () {
            var $_ref = $(this);
            if ($_ref.val() != 0) {
                preloader.on();
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url('tms/manage_tt/get_parent_code'); ?>',
                    data: 'ttm_id=' + $_ref.val(),
                    dataType: "json",
                    success: function (result) {
                        preloader.off();
                        if (result.succ) {
                            $(".db_ttm_code").attr("value", result.code);
                            $(".db_ttm_code").val(result.code);
                        } else {
                            sweetAlert({
                                title: "Oops...",
                                text: ">__< unexpected error with Error code #06092016_0206",
                                type: "error",
                                timer: 2500,
                                html: true
                            });
                        }
                    }
                });
            }
        });

        var action = 0;
        $(".sns").on("click", function () {
            action = 0;
        });

        $(".snn").on("click", function () {
            action = 1;
        });

        $('#basic_details_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ttm_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Task Category Name is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z-_0-9()\s]+$/,
                            message: 'Task Category Name can only consist given alphabets a-z A-Z underscore(_) hypen(-)'
                        },
                        stringLength: {
                            min: 3,
                            max: 250,
                            message: 'Task Category Name must be more 3 characters long'
                        }
                    }
                },
                parent_ttmid: {
                    validators: {
                        callback: {
                            message: 'Please choose at least one User Type',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".parent_ttm").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                }, ttm_code: {
                    validators: {
                        notEmpty: {
                            message: 'Task Category code is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_-]+$/,
                            message: 'Task Category Code can only consist given alphabets, a-z,A-Z,_,- and 0-9'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Task Category Code must be minimum 3 characters long'
                        }
                    }
                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
            $("#basic_details_form").find("input[type='hidden'][name='action']").remove();
            $("#basic_details_form").append("<input type='hidden' name='action' value='" + action + "'/>");
            preloader.on();
            $.ajax({
                type: "POST",
                url: $("#basic_details_form").attr("action"),
                data: $("#basic_details_form").serialize(),
                dataType: "json",
                success: function (result) {
                    preloader.off();
                    var msg = display_msg(result._err_codes);
                    if (result.succ) {
                        sweetAlert({
                            title: "Nice..",
                            text: msg,
                            type: "success",
                            timer: 2500,
                            html: true
                        });
                        global_ttm_id = result.insert_id;
                        $("#basic_details_form").find("input[name='ttm_id']").remove();
                        $("#basic_details_form").append("<input type='hidden' name='ttm_id' value=" + result.insert_id + " />");
                        $("#doc_details_form").find("input[name='ttm_id']").remove();
                        $("#doc_details_form").append("<input type='hidden' name='ttm_id' value=" + result.insert_id + " />");
                        $("#sub_task_form").find("input[name='ttm_id']").remove();
                        $("#sub_task_form").append("<input type='hidden' name='ttm_id' value=" + result.insert_id + " />");
                        $(".doc_tab").removeClass("disabled");

                        if (action) {
                            $(".create_tab").removeClass("active");
                            $(".doc_tab").addClass("active");
                            $(".create_tab_body").removeClass("in active");
                            $(".doc_tab_body").addClass("in active");
                            change_url($("#base_url").val() + "tms/manage_tt/index/docs_required/" + result.insert_id);
//                            location.replace($("#base_url").val()+"tms/manage_tt/index/docs_required/"+result.insert_id);
                        } else {
                            change_url($("#base_url").val() + "tms/manage_tt/index/create/" + result.insert_id);
//                            window.history.pushState('Manage Sub Category', 'Manage Sub Category', $("#base_url").val() + "tms/manage_tt/index/create/" + result.insert_id);
//                            location.replace($("#base_url").val()+"tms/manage_tt/index/create/"+result.insert_id);
                        }
                    } else {
                        sweetAlert({
                            title: "Oops...",
                            text: msg + " ErrorCode #06092016_0208",
                            type: "error",
                            timer: 2500,
                            html: true
                        });
                    }
                }
            });
        });

        function change_url(url) {
            window.history.pushState('Manage Sub Category', 'Manage Sub Category', url);
        }
        function display_msg($_data) {
            var err_msg = "";
            $.each($_data, function (i, value) {
                err_msg += value + "\n";
            });
            return err_msg;
        }


        function sub_task_validate() {
            $("#sub_task_form .ttstm_code").each(function () {
                individual_ttstm_code_check(this);
            });
            $("#sub_task_form .ttstm_name").each(function () {
                individual_ttstm_name_check(this);
            });
            return doc_error_check();
        }

        $(document).on('submit', '#sub_task_form', function (e) {
            e.preventDefault();
            preloader.on();
            if (!sub_task_validate()) {
                sweetAlert({
                    title: "Opps ... Error ",
                    text: "You forgot something .. please check .. red alerts",
                    type: "error",
                    timer: 2500,
                    html: true
                });
            } else {
                $("#sub_task_form").find("input[type='hidden'][name='action']").remove();
                $("#sub_task_form").append("<input type='hidden' name='action' value='" + action + "'/>");
                var $form = $(e.target);

                $form.ajaxSubmit({
                    type: "POST",
                    url: $("#sub_task_form").attr("action"),
                    dataType: "json",
                    success: function (result) {

                        var msg = display_msg(result._err_codes);
                        if (result.succ) {
                            sweetAlert({
                                title: "Nice..",
                                text: msg,
                                type: "success",
                                timer: 2500,
                                html: true
                            });
                        } else {
                            sweetAlert({
                                title: "Oops...",
                                text: msg,
                                type: "error",
                                timer: 2500,
                                html: true
                            });
                        }
                    }
                });
            }
            preloader.off();
        });



        function docu_menual_validate() {
            $("#doc_details_form .ttmdoc_name").each(function () {
                individual_docu_check(this);
            });
            return doc_error_check();
        }
        $(document).on('submit', '#doc_details_form', function (e) {
            e.preventDefault();
            preloader.on();
            if (!docu_menual_validate()) {
                sweetAlert({
                    title: "Opps ... Error ",
                    text: "You forgot something .. please check .. red alerts",
                    type: "error",
                    timer: 2500,
                    html: true
                });
            } else {
                $("#doc_details_form").find("input[type='hidden'][name='action']").remove();
                $("#doc_details_form").append("<input type='hidden' name='action' value='" + action + "'/>");
                var $form = $(e.target);
                $form.ajaxSubmit({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $(".pre_loader").show();
                                $(".pre_loader").find(".progress-bar").css({"width": percentComplete + '%'});
                                $(".pre_loader").find(".sr-only-focusable").html(percentComplete + '% Complete (success)');
                                if (percentComplete === 100) {
                                    $(".pre_loader").hide();
                                    $(".pre_loader").find(".progress-bar").css({"width": "60%"});
                                    $(".pre_loader").find(".sr-only-focusable").html("60% Complete (success)");
                                }

                            }
                        }, false);
                        return xhr;
                    },
                    type: "POST",
                    url: $("#doc_details_form").attr("action"),
                    //data: formData,
                    dataType: "json",
                    contentType: false,
                    enctype: 'multipart/form-data',
                    cache: false,
                    processData: false,
                    success: function (result) {

                        var msg = display_msg(result._err_codes);
                        if (result.succ) {
                            sweetAlert({
                                title: "Nice..",
                                text: msg,
                                type: "success",
                                timer: 2500,
                                html: true
                            });

                            $.each(result.links, function (i, value) {
                                var id = i + 1;
                                console.log(value);
                                if (value['link'] != "") {
                                    $(".doc_container .single_doc_panel:nth-child(" + id + ")").find(".doc_link_selector").html(value['link']);
                                }
                                $(".doc_container .single_doc_panel:nth-child(" + id + ")").find("input[type='hidden']").remove();
                                $(".doc_container .single_doc_panel:nth-child(" + id + ")").append("<input type='hidden' name='ttmdoc_id[" + id + "]' value='" + value['ttmdoc_id'] + "' />");
                            });
                            $(".doc_tab").removeClass("disabled");

                            if (action) {
                                $(".doc_tab").removeClass("active");
                                $(".sub_tab").addClass("active");
                                $(".doc_tab_body").removeClass("in active");
                                $(".sub_task_body").addClass("in active");
                                change_url($("#base_url").val() + "tms/manage_tt/index/sub_task/" + $("#doc_details_form").find("input[name=ttm_id]").val());
                            } else {
//                            $(".doc_tab").removeClass("active");

                            }
                        } else {
                            sweetAlert({
                                title: "Oops...",
                                text: msg,
                                type: "error",
                                timer: 2500,
                                html: true
                            });
                        }
                        preloader.off();
                    }
                });
            }
        });
    });


</script>
<?php if (isset($task_data) && $task_data['ttm_id'] != "") { ?>
    <script>
        global_ttm_id = '<?php echo $task_data['ttm_id']; ?>'
    </script>
<?php }
?>