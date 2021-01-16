
<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">
                <?php
                  echo $title;
                ?>

            </h4>
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
            <?php
            if (isset($task_search_view))
                echo $task_search_view;
// $this->util_model->printr($task_list);
            ?>
        </div>
    </div>

    <div class="document_uploader" style="display: none">
        <button class="btn btn-sm btn-danger" onclick="$('div.document_uploader').hide()"><span class="fa fa-times"></span></button>
        <link href="<?= CDN1 ?>/css/dropzone/dropzone.css" rel="stylesheet" type="text/css"/>
        <script src="<?= CDN1 ?>/css/dropzone/dropzone.js" type="text/javascript"></script>
        <!--       file upload box-->
        <form action="<?php echo CDN1 . "/tms/manage_sub_task/sub_task_document_attact" ?>" class="dropzone" id="documentuploadingzone">
            <div class="fallback">

                <input name="file" type="file" multiple />

            </div>
            <input id="subtastid" type="hidden" name="tstm_id"  />
            <input id="taskid"  name="tm_code" type="hidden"  />
        </form>

        <script>
            $(document).ready(function () {

                Dropzone.options.documentuploadingzone = {
                    paramName: "file",
                    // The name that will be used to transfer the file
                    maxFilesize: 2, // MB
                    accept: function (file, done) {
                        if (file.name == "justinbieber.jpg") {
                            done("Naha, you don't.");
                        }
                        else {
                            console.log("hi");
                            done();
                        }
                    },
                    complete: function (file) {
                        //alert("complete");
                        // console.log(file.xhr.response);

                        var response = $.parseJSON(file.xhr.response);
                        var data = response.data;
                        // var data = response.data;

                        //var data =response.data;
                        //  alert(data);
                        console.log(response);
                        var receiver = $("button[sub_task_id='" + data[0]['table_id'] + "']").parent("div").children("div.documents_attach");
                        // console.log(receiver);
                        receiver.append("<div class='fileUploaded' attach_id='" + data.attach_id + "' >" + data[0].attach_original_name + " <i class='fa fa-times' onclick='delme(this)' aria-hidden='true'></i> </div>");
                    }
                };




                //    console.log(Dropzone.options);
            });



        </script>
    </div>


    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php
                if (isset($active_tab) && $active_tab == 'create_replica') {
                    echo "Replica Form";
                } else if (isset($active_tab) && $active_tab == 'copy_task') {
                    echo "Duplicate Task Form";
                } else if ($tm_id != "" && !empty($task_data)) {
                    echo "Edit Task";
                } else {
                    echo "New Task From";
                }
                ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_tasks/task_save_update', "id='task_save_update_form'");
            ?>
            <?php if (isset($task_data) && !empty($task_data)) { ?>
                <input type="hidden" name="action_performed" value="update" />
            <?php } else { ?>
                <input type="hidden" name="action_performed" value="save" />
            <?php }
            ?>
            <div class="row bottom_gap">
<div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Client<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_dropdown("client_id", $client_list, (isset($task_data['client_id']) && !empty($task_data['client_id'])) ? $task_data['client_id'] : $this->input->get('client_id'), "class='form-control client_id chosen-select' onchange='clientChanged(this)' ") ?>
                    </div>        
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">State <span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                        <?php echo form_dropdown("state_id", $list_state, @$task_data['state_id'], "class='form-control state_id' ") ?>
                </div>
            </div>
                <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Month<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                        <?php echo form_dropdown("month", $list_month, @$task_data['month'], "class='form-control month'") ?>
                </div> 
                 <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Year <span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                        <?php echo form_dropdown("year", $list_year, @$task_data['year'], "class='form-control year' ") ?>
                </div> 
            </div>
            <!--String of Row-->
            <div class="row bottom_gap">
                
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Task Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php echo form_dropdown("helper_task_list", $under, (isset($helper_task_list) && $helper_task_list != "") ? $helper_task_list : "", "class='form-control get_task_types' ") ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>
                    </div><!-- /input-group -->               
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php
//                        $this->util_model->printr($task_data);
                        if ((isset($task_data['ttm_id']) && $task_data['ttm_id'] != '')) {
                            echo form_dropdown("ttm_id", $ttm_ids, (isset($task_data['ttm_id']) && $task_data['ttm_id'] != "") ? $task_data['ttm_id'] : "", "class='form-control sub-task db_sub_task' readonly id='sub_task'");
                        } else {
                            ?>
                            <select class="form-control" name="ttm_id" class="db_sub_task" id="sub_task">
                                <option value="0">Select Type</option>
                            </select>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="file_id" value="<?php echo @$task_data['file_id'] ?>">
                </div>
            </div>


            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("tm_name", (isset($task_data['tm_name']) && $task_data['tm_name'] != "") ? $task_data['tm_name'] : "", array("class" => "'form-control popover_element1 task_name'", "placeholder" => "'Name of the Task'", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 3 characters'", "data-original-title" => "'Remember'")) ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Code<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("tm_code", (isset($task_data['tm_code']) && $task_data['tm_code'] != "") ? $task_data['tm_code'] : "", array("class" => "'form-control popover_element1 task_code'", "placeholder" => "'Task Code'", "data-content" => "'Code for task'")) ?>
                    </div> 
                </div><!-- /input-group -->               

            </div> <!--End of row-->

            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">In charge<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_dropdown("incharge_id", $incharge, (isset($task_data['incharge_data']) && !empty($task_data['incharge_data'])) ? $task_data['incharge_data']['user_id'] : "", "class='form-control incharge-id' ") ?>
                        <?php if (isset($task_data['incharge_data']) && !empty($task_data['incharge_data'])) { ?>
                            <input type="hidden" name="tuid" value="<?php echo $task_data['incharge_data']['tuid'] ?>" />
                            <input type="hidden" name="db_incharge_id" value="<?php echo $task_data['incharge_data']['user_id'] ?>" />
                        <?php }
                        ?>
                    </div>        
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Skill Dev Activity</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                        <?php echo form_dropdown("skill_dev_activity", array("0"=>"No","1"=>"Yes"), (isset($task_data['skill_dev_activity']) && $task_data['skill_dev_activity'] != "") ? $task_data['skill_dev_activity'] : "", "class='form-control' ") ?>
                </div>
                
            </div> <!--End of row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Expenditure</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="col-md-6 padding_0px">
                        <div class="form-group">
                            <?php echo form_input("approx_exp", (isset($task_data['approx_exp']) && $task_data['approx_exp'] != "") ? $task_data['approx_exp'] : 0, array("class" => "'form-control popover_element1'", "placeholder" => "'Total Expenditure for Task'")) ?>
                        </div> 
                    </div>
                    <div class="col-md-6 padding_0px">
                        <div class="form-group">
                            <?php echo form_dropdown("visibility", array(0 => "Private Visibility", 1 => "Public Visibility"), (isset($task_data['visibility']) && !empty($task_data['visibility'])) ? $task_data['visibility'] : 1, "class='form-control does_repeat' ") ?>
                        </div>
                    </div>
                </div><!-- /input-group --> 

                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Repeat</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="col-md-4 padding_0px">
                        <div class="form-group">
                            <?php echo form_dropdown("does_repeat", array(0 => "Disable", 1 => "Enable"), (isset($task_data['does_repeat']) && !empty($task_data['does_repeat'])) ? $task_data['does_repeat'] : "", "class='form-control does_repeat' ") ?>
                        </div>        
                    </div>
                    <div class="col-md-8">
                        <div class="row bottom_gap repeat_true <?php echo (isset($task_data['does_repeat']) && !empty($task_data['does_repeat'])) ? "" : "hidden" ?>">
                            <!--<div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Duration</div>-->
                            <div class="col-lg-6 col-md-6 col-sm-12 padding_0px">
                                <div class="form-group">
                                    <?php
//                        $days = 0;
//                        $days = $task_data['repeat_gap']=="year"?365:($task_data['repeat_gap']=="month"?30:7);
                                    echo form_input("repeat_unit", floor((isset($task_data['repeat_unit']) && !empty($task_data['repeat_unit'])) ? $task_data['repeat_unit'] / ($task_data['repeat_gap'] == "year" ? 365 : ($task_data['repeat_gap'] == "month" ? 30 : 7)) : "1"), array("class" => "'form-control popover_element1 repeat_unit'", "placeholder" => "'Interval in Numbers. e.g 1,2'"))
                                    ?>
                                </div>        
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 padding_0px">
                                <div class="form-group">
                                    <?php echo form_dropdown("repeat_gap", array("month" => "Month", "week" => "Week", "year" => "Year"), (isset($task_data['repeat_gap']) && !empty($task_data['repeat_gap'])) ? $task_data['repeat_gap'] : "", "class='form-control repeat_gap' ") ?>
                                </div>        
                            </div>
                            


                        </div> <!--End of row-->
                    </div>
                </div>

            </div> 
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Show to Client<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                     
                    <div class="col-md-6 padding_0px">
                        <div class="form-group">
                            <?php echo form_dropdown("client_visiblity", array(0 => "No", 1 => "Yes"), (isset($task_data['client_visiblity'])) ? $task_data['client_visiblity'] : 1, "class='form-control' ") ?>
                        </div>
                    </div>
                </div><!-- /input-group --> 
                
                 <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Period</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                     
                    <div class="col-md-6 padding_0px">
                        <div class="form-group">
                            <?php echo form_dropdown("task_period_id", $period_list, (isset($task_data['task_period_id'])) ? $task_data['task_period_id'] : 1, "class='form-control' ") ?>
                        </div>
                    </div>
                </div><!-- /input-group --> 

                
            </div> 


            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bdatetimepicker task_start_date' >
                        <input type='text' class="form-control" name="start_date" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bdatetimepicker task_end_date' >
                        <input type='text' class="form-control" name="end_date" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Extra Notes</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <?php echo form_textarea("extra_note", (isset($task_data['extra_note']) && $task_data['extra_note'] != "") ? $task_data['extra_note'] : "", array("class" => "'form-control tinymce'", "placeholder" => "'Extra Notes for Task'")) ?>
                    </div>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Notify Client</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <?php echo form_checkbox('notify_client', 'accept', FALSE); ?>
                    </div>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Attachment</div>
                <div class="col-lg-10">
                    <div class="form-group">

                        <input type="file" name="attach_file" value="" required="required">

                     </div>
                </div>
            </div>
            <!--End of row-->
            <div class="row sub_tasks_container <?php echo (isset($task_data['sub_task_data']) && !empty($task_data['sub_task_data'])) ? "" : "hidden" ?>">
                <div class="col-lg-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title toggle_custom">Sub Tasks<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body collapse in main_sub_task_data">
                            <?php if (isset($task_data['sub_task_data']) && !empty($task_data['sub_task_data'])) { ?>
                                <input type="hidden" name="tm_id" value="<?php echo $task_data['tm_id'] ?>"/>
                                <?php
                                $i = 1;
                                foreach ($task_data['sub_task_data'] as $value) {
                                    ?>
                                    <div class="single_sub_task">
                                        <input type="hidden" name="tstm_id[]" value="<?php echo $value['tstm_id'] ?>" />
                                        <input type="hidden" class="sort_sub_task" name="sort[]" value="<?php echo $value['sort'] ?>" />
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <h6>
                                                        <button type="button" class="btn btn-primary btn-md" title="Sub Task Sequence">
                                                            <span class="heading_title"># Sub Task <?= $i ?></span>
                                                        </button>


                                                        <button type="button" class="btn btn-danger btn-md remove_sub_task pull-right" title="Remove This Subtask">
                                                            <span class="glyphicon glyphicon-minus"></span>
                                                        </button> 
                                                        <button type="button" class="btn btn-success btn-md add_sub_task pull-right" title="Add Blank Subtask">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                        </button> 
                                                        <button type="button" class="btn btn-info btn-md show_details pull-right" title="Click here to show the extra details">
                                                            <span class="glyphicon glyphicon-eye-open"></span> Show Details
                                                        </button> 

                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row bottom_gap">
                                            <div class="col-lg-12">
                                                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Name</div>
                                                <div class="col-lg-4 col-md-4 col-sm-8">
                                                    <div class="form-group">
                                                        <input class="form-control ttstm_name" name="ttstm_name[]" type="text" value="<?php echo (isset($value['tstm_name']) && $value['tstm_name'] != "") ? $value['tstm_name'] : "" ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Code</div>
                                                <div class="col-lg-4 col-md-4 col-sm-8">
                                                    <div class="form-group">
                                                        <input class="form-control ttstm_code" name="ttstm_code[]" type="text" value="<?php echo (isset($value['tstm_code']) && $value['tstm_code'] != "") ? $value['tstm_code'] : "" ?>" />
                                                    </div>
                                                </div><!-- /input-group -->  
                                            </div>
                                        </div>
                                        <div class="row bottom_gap sub_task_details">
                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title toggle_custom sub_task_name">Check Points<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                                                        </div>
                                                        <div class="panel-body collapse in ttstm_check_points">
                                                            <?php
                                                            echo (isset($value['tstm_check_points']) && $value['tstm_check_points'] != "") ? $value['tstm_check_points'] : ""
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title toggle_custom sub_task_name">Control Points<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                                                        </div>
                                                        <div class="panel-body collapse in ttstm_control_points">
                                                            <?php
                                                            echo (isset($value['tstm_control_points']) && $value['tstm_control_points'] != "") ? $value['tstm_control_points'] : ""
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title toggle_custom sub_task_name">Faqs<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                                                        </div>
                                                        <div class="panel-body collapse in ttstm_faqs">
                                                            <?php
                                                            echo (isset($value['tstm_faqs']) && $value['tstm_faqs'] != "") ? $value['tstm_faqs'] : ""
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title toggle_custom sub_task_name">Documents<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                                                        </div>
                                                        <div class="panel-body collapse in ttstm_control_points">

                                                            <div class="documents_attach" onload="download_my_files('<?php echo $value['tstm_id'] ?>')">
                                                                <?php
                                                                if (isset($value['documents'])) {
                                                                    foreach ($value['documents'] as $doc) {
                                                                        ?>
                                                                        <div class='fileUploaded' attach_id='<?php echo $doc['attach_id'] ?>' > <a href="<?php echo base_url($doc['link']) ?>" target="_blank"><?php echo $doc['attach_original_name'] ?></a><i class='fa fa-times' onclick='delme(this)' aria-hidden='true'></i> </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>

                                                            <button type="button" value="Save" task_id="<?php echo $task_data['tm_code'] ?>" sub_task_id="<?php echo $value['tstm_id'] ?>" onclick="show_upload_panel(this);" class="btn btn-success btn-md">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="selection_container">
                                            <div class="row bottom_gap">
                                                <div class="col-lg-12">  
                                                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                                        <div class='input-group date bdatetimepicker' >
                                                            <input type='text' class="form-control str_date_time" name="str_date_time[]" value="<?php echo ($value['str_date_time'] != "") ? date(DTF, strtotime($value['str_date_time'])) : date(DTF) ?>"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                                                    <div class="col-lg-4 col-md-4 col-sm-8">
                                                        <div class='input-group date bdatetimepicker' >
                                                            <input type='text' class="form-control end_date_time" name="end_date_time[]" value="<?php echo ($value['end_date_time'] != "") ? date(DTF, strtotime($value['end_date_time'])) : date(DTF) ?>"/>
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--End of row-->
                                            <!--String of Row-->
                                            <div class="row bottom_gap">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Assigned To<span class="Compulsory">*</span></div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Job locality<span class="Compulsory">*</span></div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Efforts<span class="Compulsory">*</span></div>
                                                </div>
                                            </div>

                                            <div class="row bottom_gap">
                                                <div class="col-lg-12">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <?php echo form_dropdown("assignedto[]", $incharge, $value['assignedto'], "class='form-control assignedto' ") ?>
                                                    </div>        
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <?php echo form_dropdown("joblocalityid[]", $locality, $value['joblocalityid'], "class='form-control joblocalityid' ") ?>
                                                    </div>        
                                                </div>  
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <input class="form-control ttstm_efforts" type="text" name="ttstm_efforts[]" value="<?php echo $value['tstm_efforts'] ?>" />
                                                    </div>        
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row bottom_gap">
                                                <div class="col-md-12 _err_msg hidden">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--End of row-->

                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($task_data['sub_task_data']) && !empty($task_data['sub_task_data'])) { ?>
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title toggle_custom">Sub Tasks Info<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                            </div>
                            <div class="panel-body collapse in">
                                <div class="col-lg-12">
                                    <span class="heading_title"># Purpose</span>
                                    <div class="col-lg-12 purp">
                                        <ol>
                                            <?php foreach ($task_data['task_type_data'] as $task_type_data) { ?>
                                                <li><?php echo $task_type_data['purpose'] ?></li>
                                            <?php }
                                            ?>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <span class="heading_title"># Background</span>
                                    <div class="col-lg-12 bg">
                                        <ol>
                                            <?php foreach ($task_data['task_type_data'] as $task_type_data) { ?>
                                                <li><?php echo $task_type_data['background'] ?></li>
                                            <?php }
                                            ?>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <span class="heading_title"># Documents Required</span>
                                    <div class="col-lg-12 docs">
                                        <ol>
                                            <?php foreach ($task_data['task_doc_data'] as $task_doc_data) { ?>
                                                <li><a target="_blank" href="<?php echo base_url() . $task_doc_data['document_path'] ?>"><?php echo $task_doc_data['ttmdoc_name'] ?></a></li>
                                            <?php }
                                            ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title toggle_custom">Sub Tasks Info<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                            </div>
                            <div class="panel-body collapse in">
                                <div class="col-lg-12">
                                    <span class="heading_title"># Purpose</span>
                                    <div class="col-lg-12 purp"></div>
                                </div>
                                <div class="col-lg-12">
                                    <span class="heading_title"># Background</span>
                                    <div class="col-lg-12 bg"></div>
                                </div>
                                <div class="col-lg-12">
                                    <span class="heading_title"># Documents Required</span>
                                    <div class="col-lg-12 docs"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <?php if (isset($task_data) && !empty($task_data) && !isset($active_tab)) { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Update", array("class" => "'btn btn-success update'")); ?>
                    </div>
                <?php } else if (!isset($active_tab)) { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Create", array("class" => "'btn btn-success save'")); ?>
                    </div>
                <?php }
                ?>
                <?php if (isset($active_tab) && $active_tab == "create_replica") { ?>
                    <div class="col-lg-2">
                        <!--<div class="input-group">-->
                        <?php echo form_submit("", "Create Replica", array("class" => "'btn btn-success replica'"));
                        ?>
                    </div>
                <?php } if (isset($active_tab) && $active_tab == "copy_task") { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Copy Task", array("class" => "'btn btn-success copy_task'")); ?>
                    </div>
                <?php }
                ?>
                <div class="col-lg-1">
                    <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-success'")) ?>
                </div>
            </div>
        </div>

    </div>

    <?php
    echo form_close();
//    $Curr_Obj = & get_instance();
//    $Curr_Obj->All_tasks_List();
    ?>
</div>
<div class="item hidden">
    <div class="single_sub_task">
        <input type="hidden" class="sort_sub_task" name="sort[]" value="5" />
        <input type="hidden" class="sub_task_id" name="ttstm_id[]" value="" />
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <h6>
                        <button type="button" class="btn btn-primary btn-md" title="Sub Task Sequence">
                            <span class="heading_title"># Sub Task 1</span>
                        </button> 
                        <button type="button" class="btn btn-danger btn-md remove_sub_task pull-right" title="Remove This Subtask">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button> 
                        <button type="button" class="btn btn-success btn-md add_sub_task pull-right" title="Add Blank Subtask">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button> 
                        <button type="button" class="btn btn-info btn-md show_details pull-right" title="Click here to show the extra details">
                            <span class="glyphicon glyphicon-eye-open"></span> Show Details
                        </button>   
                    </h6>
                </div>
            </div>
        </div>
        <div class="row bottom_gap">
            <div class="col-lg-12">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Name</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <input class="form-control ttstm_name" name="ttstm_name[]" type="text" value="" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Code</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <input class="form-control ttstm_code" name="ttstm_code[]" type="text" value="" />
                    </div>
                </div><!-- /input-group -->  
            </div>
        </div>
        <div class="row bottom_gap sub_task_details ">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title toggle_custom sub_task_name">Check Points<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body collapse in ttstm_check_points">

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title toggle_custom sub_task_name">Control Points<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body collapse in ttstm_control_points">

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title toggle_custom sub_task_name">Faqs<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                        </div>
                        <div class="panel-body collapse in ttstm_faqs">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="selection_container">
            <div class="row bottom_gap"> 
                <div class="col-lg-12">   
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class='input-group date bdatetimepicker' >
                            <input type='text' class="form-control str_date_time" name="str_date_time[]" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                    <div class="col-lg-4 col-md-4 col-sm-8">
                        <div class='input-group date bdatetimepicker' >
                            <input type='text' class="form-control end_date_time" name="end_date_time[]" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Assigned To<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Job locality<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Efforts<span class="Compulsory">*</span></div>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <?php echo form_dropdown("assignedto[]", $incharge, '', "class='form-control assignedto customAsign' ") ?>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <?php echo form_dropdown("joblocalityid[]", $locality, '', "class='form-control joblocalityid' ") ?>
                    </div>        
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group">
                        <input class="form-control ttstm_efforts" type="text" name="ttstm_efforts[]" value="" />
                    </div>        
                </div>

            </div>
            <div class="row bottom_gap">
                <div class="col-md-12 _err_msg hidden">
                    <table style="width:100%">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> <!--End of row-->
    </div>
</div>
<div class="sub_task_html hidden">
    <div class="single_sub_task custom_added margin_top_20px"> 
        <div class="col-md-12">
            <input type="hidden" class="sort_sub_task" name="_custom_sort[]" value="5" />
            <input type="hidden" name="_custom_sub_task[]" value="_custom_sub_task"/>  
            <div class="row">
                <div class="col-lg-12 col-sm-12 margin_bottom_10px">
                    <button type="button" class="btn btn-primary btn-md" title="Sub Task Sequence">
                        <span class="heading_title"># Sub Task 1</span>
                    </button>

                    <button type="button" class="btn btn-danger btn-md remove_sub_task pull-right" title="Remove This Subtask">
                        <span class="glyphicon glyphicon-minus"></span>
                    </button> 
                    <button type="button" class="btn btn-success btn-md add_sub_task pull-right" title="Add Blank Subtask">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("_custom_ttstm_name[]", "", array("class" => "'ttstm_name form-control  '", "placeholder" => "'Sub Task Name'")) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task Code<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("_custom_ttstm_code[]", "", array("class" => "'ttstm_code form-control  '", "placeholder" => "'Sub Task Code'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->    
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Efforts</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <?php echo form_input("_custom_ttstm_efforts[]", '', "class='form-control'  placeholder='In hours e.g 4 '") ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>
                    </div><!-- /input-group -->               
                </div> 

                <!-- end of col-lg-4 -->
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Check points</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <?php echo form_textarea("_custom_ttstm_check_points[]", "", array("class" => "'form-control init_tinymce '", "placeholder" => "'Purpose of Task'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Control Points</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <?php echo form_textarea("_custom_ttstm_control_points[]", "", array("class" => "'form-control init_tinymce'", "placeholder" => "'Background of Task'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Working Note</div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <?php echo form_textarea("_custom_ttstm_faqs[]", "", array("class" => "'form-control init_tinymce'", "placeholder" => "'Background of Task'")) ?>
                    </div>
                </div>
            </div> <!--End of row-->

            <div class="row bottom_gap">
                <div class="selection_container">
                    <div class="row bottom_gap"> 
                        <div class="col-lg-12">   
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Start Date</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">
                                <div class='input-group date bdatetimepicker' >
                                    <input type='text' class="form-control str_date_time" name="_custom_str_date_time[]" value="<?php echo (isset($task_data['start_date']) && $task_data['start_date'] != "") ? date(DTF, strtotime($task_data['start_date'])) : date(DTF) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">End date</div>
                            <div class="col-lg-4 col-md-4 col-sm-8">
                                <div class='input-group date bdatetimepicker' >
                                    <input type='text' class="form-control end_date_time" name="_custom_end_date_time[]" value="<?php echo (isset($task_data['end_date']) && $task_data['end_date'] != "") ? date(DTF, strtotime($task_data['end_date'])) : date(DTF, strtotime("+7 days")) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> <!--End of row-->
                    <!--String of Row-->
                    <!--String of Row-->
                    <div class="row bottom_gap">
                        <div class="col-lg-12">
                            <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Assigned To<span class="Compulsory">*</span></div>
                            <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Job locality<span class="Compulsory">*</span></div>
                            <div class="col-lg-4 col-md-4 col-sm-4  padding_top_label">Efforts<span class="Compulsory">*</span></div>
                        </div>
                    </div>
                    <div class="row bottom_gap">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?php echo form_dropdown("_custom_assignedto[]", $incharge, '', "class='form-control assignedto customAsign' ") ?>
                                </div>
                            </div>        
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <?php echo form_dropdown("_custom_joblocalityid[]", $locality, '', "class='form-control joblocalityid' ") ?>
                            </div>        
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <input class="form-control ttstm_efforts" type="text" name="_custom_ttstm_efforts[]" value="" />
                            </div>        
                        </div>

                    </div>
                    <div class="row bottom_gap">
                        <div class="col-md-12 _err_msg hidden">
                            <table style="width:100%">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> <!--End of row-->
            </div>
        </div>
    </div>
</div>
</div>
<div class="bottom_gap">&nbsp;&nbsp;</div>
<?php
//$this->load->view("Employee/emp_form_validation");
?> 
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/moment.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>

<link href="<?= CDN1 ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/multi_select/prism.js" type="text/javascript"></script>
<script>
                                                                var tiny_init = 1;
                                                                var config = {
                                                                    '.chosen-select': {},
                                                                    '.chosen-select-deselect': {allow_single_deselect: true},
                                                                    '.chosen-select-no-single': {disable_search_threshold: 10},
                                                                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                                                                    '.chosen-select-width': {width: "95%"}
                                                                }
                                                                for (var selector in config) {
                                                                    $(selector).chosen(config[selector]);
                                                                }

                                                                function init() {
                                                                    $(document).unbind(".bdatetimepicker, .assignedto, .joblocalityid, .remove_sub_task, .add_sub_task, .show_details");

                                                                    $('.bdatetimepicker').datetimepicker({
                                                                        format: 'DD-MM-YYYY hh:mm A',
                                                                        icons: {
                                                                            time: "fa fa-clock-o",
                                                                            date: "fa fa-calendar",
                                                                            up: "fa fa-arrow-up",
                                                                            down: "fa fa-arrow-down"
                                                                        }
                                                                    });

                                                                    $(".task_start_date").on("dp.change", function (e) {
                                                                        $.each($(".main_sub_task_data").find(".str_date_time"), function (i, value) {
                                                                            $(this).attr("value", $(".task_start_date").children("input[type='text'][name='start_date']").val());
                                                                            $(this).val($(".task_start_date").children("input[type='text'][name='start_date']").val());
                                                                        });
                                                                    });

                                                                    $(".task_end_date").on("dp.change", function (e) {
                                                                        $.each($(".main_sub_task_data").find(".end_date_time"), function (i, value) {
                                                                            $(this).attr("value", $(".task_end_date").children("input[type='text'][name='end_date']").val());
                                                                            $(this).val($(".task_end_date").children("input[type='text'][name='end_date']").val());
                                                                        });
                                                                    });

                                                                    $(".remove_sub_task").click(function () {
                                                                        var _this = $(this);
                                                                        swal({
                                                                            title: "Are you sure?",
                                                                            text: "Once Removed, Can't be recovered",
                                                                            type: "warning",
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#DD6B55',
                                                                            confirmButtonText: 'Yes',
                                                                            cancelButtonText: "No, Cancel Please!",
                                                                            closeOnConfirm: false,
                                                                            closeOnCancel: false
                                                                        }, function (isConfirm) {
                                                                            if (isConfirm) {
                                                                                swal({
                                                                                    title: "Removed Successfully !!",
                                                                                    type: "success",
                                                                                    timer: 100});
                                                                                $(_this).parents(".single_sub_task").remove();
                                                                            } else {
                                                                                swal({
                                                                                    title: "Action Cancelled !!",
                                                                                    type: "success",
                                                                                    timer: 100});
                                                                            }
                                                                        });
                                                                    });



                                                                    // anup
                                                                    $(".add_sub_task").on("click", function () {
                                                                        var _this = $(this);
                                                                        swal({
                                                                            title: "Are you sure?",
                                                                            text: "This action will add a blank sub-task just after this",
                                                                            type: "warning",
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#DD6B55',
                                                                            confirmButtonText: 'Yes',
                                                                            cancelButtonText: "No, Cancel Please!",
                                                                            closeOnConfirm: false,
                                                                            closeOnCancel: false
                                                                        }, function (isConfirm) {
                                                                            if (isConfirm) {
                                                                                swal({
                                                                                    title: "Removed Successfully !!",
                                                                                    type: "success",
                                                                                    timer: 100});

                                                                                $(_this).parents(".single_sub_task").after($(".sub_task_html").html());

                                                                                //$(this).attr("id", ++tiny_init + "tms");
                                                                                $(".sub_tasks_container").find(".custom_added").find(".heading_title").html("#Custom Added Sub Task " + tiny_init);
                                                                                $(".sub_tasks_container").find(".custom_added").removeClass("custom_added");
                                                                                // t_init("#" + tiny_init + "tms");
                                                                                tiny_init++;
                                                                                m_sorting();
                                                                                init();
//                                                                                $(".sub_task_html").children(".single_sub_task").css("border", "2px solid green");
//                                                                                var no = $(".single_sub_task").length;
//                                                                                $(".sub_task_html").find(".heading_title").html("#Custom Added Sub Task " + no);
//                                                                                $(_this).parents(".single_sub_task").after($(".sub_task_html").html());
//                                                                                init();
                                                                            } else {
                                                                                swal({
                                                                                    title: "Action Cancelled !!",
                                                                                    type: "success",
                                                                                    timer: 100});
                                                                            }
                                                                        });

                                                                    });

                                                                    //    sub_task_details show_details
                                                                    $(".show_details").click(function () {
                                                                        $(this).parents(".single_sub_task").find(".sub_task_details").slideToggle();
                                                                    });
                                                                    // anup end

                                                                    $(".user_availabilty_table").find("span").on("click", function () {
                                                                        if ($(this).attr("key") == 1) {
                                                                            $(".user_availabilty_table").find("tbody").fadeOut();
                                                                            $(".user_availabilty_table").find("span").html("Show Me");
                                                                            $(".user_availabilty_table").find("span").attr("key", 0);
                                                                        } else {
                                                                            $(".user_availabilty_table").find("tbody").fadeIn();
                                                                            $(".user_availabilty_table").find("span").html("Hide Me");
                                                                            $(".user_availabilty_table").find("span").attr("key", 1);
                                                                        }
                                                                    });
                                                                    
                                                                     $(".joblocalityid").change(function () {
                                                                        
                                                                        var $_ref = $(this);
                                                                        var assigned = $_ref.val();
                                                                        console.log(assigned);
                                                                        $(".joblocalityid").each(function(){
                                                                             if($(this).val()=="0"){
                                                                                 $(this).val(assigned);
                                                                             } 
                                                                        });
                                                                    });

                                                                    $(".assignedto").change(function () {
                                                                        
                                                                        var $_ref = $(this);
                                                                        var assigned = $_ref.val();
                                                                        console.log(assigned);
                                                                        $(".assignedto").each(function(){
                                                                             if($(this).val()=="0"){
                                                                                 $(this).val(assigned);
                                                                             } 
                                                                        });
                                                                        $_ref.parents(".selection_container").find("._err_msg").html("");
                                                                        $_ref.parents(".selection_container").find("._err_msg").addClass("hidden");
                                                                        if (assigned != 0) {
                                                                            preloader.on();
                                                                            var start_date = $_ref.parents(".selection_container").find(".str_date_time").val();
                                                                            var end_date = $_ref.parents(".selection_container").find(".end_date_time").val();
                                                                            $.ajax({
                                                                                url: "<?php echo base_url() . 'tms/manage_tasks/get_user_availability' ?>",
                                                                                method: "POST",
                                                                                data: "assigned_to=" + assigned + "&start_date=" + start_date + "&end_date=" + end_date,
                                                                                dataType: "json",
                                                                                success: function (result) {
                                                                                    if (result.succ) {
                                                                                        var $table = $('<table/>');
                                                                                        $table.append("<caption>Selected User is Busy With Following tasks<span key='1'>Hide Me</span></caption>");
                                                                                        $table.append('<tr><th>Sub Task Name (Task Name)</th><th>Start Date</th><th>End Date</th></tr>');
                                                                                        $.each(result.data, function (i, value) {
                                                                                            $table.append('<tr><td><a href="'+get_base_url()+'tms/manage_sub_task/taskSingleView/'+value.tstm_id+'">' + value.tstm_name + '(' + value.tm_name + ')</a></td><td>' + value.start_date + '</td><td>' + value.end_date + '</td></tr>');
                                                                                        });
                                                                                        $table.addClass("table table-bordered table-hover user_availabilty_table");
                                                                                        $_ref.parents(".selection_container").find("._err_msg").removeClass("hidden");
                                                                                        $_ref.parents(".selection_container").find("._err_msg").html($table);
                                                                                        init();
                                                                                    }
                                                                                    // false will come when user will be free
                                                                                    preloader.off();
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                }

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

                                                                $("#sub_task").change(function () {
                                                                    tiny_init = 1;
                                                                    if ($(this).val() != 0) {
                                                                        setupSubTask($(this).val());
                                                                    }
                                                                });
                                                                
                                                                function setupSubTask(subTaskID){
                                                                    preloader.on();
                                                                        $.ajax({
                                                                            url: "<?php echo base_url() . 'tms/manage_tasks/fetch_all_task_types' ?>",
                                                                            method: "POST",
                                                                            data: "ttm_id=" + subTaskID,
                                                                            dataType: "json",
                                                                            success: function (result) {
                                                                                $(".main_sub_task_data").html("");
                                                                                $(".bg").html("");
                                                                                $(".purp").html("");
                                                                                $(".docs").html("");
                                                                                if (result.succ) {
                                                                                    $("input[type='hidden'][name='action_performed']").attr("value", "save");
                                                                                    $(".bg").append($('<ol>').html("<li>" + result.data.background + "</li>"));
                                                                                    $(".purp").append($('<ol>').html("<li>" + result.data.purpose + "</li>"));
                                                                                    $.each(result.data.docs_data, function (i, value) {
                                                                                        $('.docs').append($('<ol>').html("<li><a href=" + get_base_url() + value.document_path + ">" + value.ttmdoc_name + "</a></li>"));
                                                                                    });
                                                                                    $.each(result.data.sub_task_data, function (i, value) {
                                                                                        $(".item").find(".heading_title").text("# Sub Task " + (i + 1));
                                                                                        $(".item").find(".sub_task_id").attr("value", value.ttstm_id);
                                                                                        $(".item").find(".ttstm_name").attr("value", value.ttstm_name);
                                                                                        $(".item").find(".ttstm_code").attr("value", value.ttstm_code);
                                                                                        $(".item").find(".sort_sub_task").attr("value", value.sort);
                                                                                        $(".item").find(".ttstm_check_points").html(value.ttstm_check_points);
                                                                                        $(".item").find(".ttstm_control_points").html(value.ttstm_control_points);
                                                                                        $(".item").find(".ttstm_faqs").html(value.ttstm_faqs);
                                                                                        $(".item").find(".ttstm_efforts").attr("value", value.ttstm_efforts);
                                                                                        $(".main_sub_task_data").append($(".item").html());
                                                                                    });
                                                                                    $(".sub_tasks_container").removeClass("hidden");
                                                                                    init();
                                                                                    load_validator();
                                                                                    
                                                                                } else {
                                                                                    $(".sub_tasks_container").addClass("hidden");
                                                                                }

                                                                                $(".sub_task_details").slideUp();
                                                                                preloader.off();
                                                                            }
                                                                        });
                                                                }
                                                                $(".does_repeat").change(function () {
                                                                    if ($(this).val() != 0) {
                                                                        $(".repeat_true").removeClass("hidden");
                                                                    } else {
                                                                        $(".repeat_true").addClass("hidden");
                                                                    }
                                                                });
                                                                function gen_task_code() {
                                                                    var task_cat = $(".get_task_types").val();
                                                                    if (task_cat != "" && task_cat != 0) {
                                                                        preloader.on();
                                                                        $.ajax({
                                                                            url: "<?php echo base_url() . 'tms/manage_tasks/get_task_code' ?>",
                                                                            method: "POST",
                                                                            data: "taskMCatID=" + task_cat,
                                                                            dataType: "json",
                                                                            success: function (result) {
                                                                                if (result.succ) {
                                                                                    $(".task_code").val(result.code);
                                                                                    $(".task_code").attr("value", result.code);
                                                                                } else {
                                                                                    sweetAlert({
                                                                                        title: "Oops...",
                                                                                        text: "Error while loading >__<",
                                                                                        type: "error",
                                                                                        timer: 2500,
                                                                                        html: true
                                                                                    });
                                                                                }

                                                                                preloader.off();
                                                                            }
                                                                        });
                                                                    }
                                                                }

                                                                $(".get_task_types").change(function () {
                                                                    if ($(this).val() != 0) {
                                                                        gen_task_code();
                                                                        preloader.on();
                                                                        $.ajax({
                                                                            url: "<?php echo base_url() . 'tms/manage_tasks/get_task_types' ?>",
                                                                            method: "POST",
                                                                            data: "ttm_id=" + $(this).val(),
                                                                            dataType: "json",
                                                                            success: function (result) {
                                                                                if (result.succ) {
                                                                                    $('#sub_task').empty();
                                                                                    $.each(result.data, function (i, value) {
                                                                                        $('#sub_task').append($('<option>').text(value).attr('value', i));
                                                                                    });
                                                                                } else {
                                                                                    $('#sub_task').html($('<option>').text("Select Type").attr('value', 0));
                                                                                }
                                                                                preloader.off();
                                                                            }
                                                                        });
                                                                    } else {
                                                                        $('#sub_task').html($('<option>').text("Select Type").attr('value', 0));
                                                                    }
                                                                });
                                                                $(document).on("ready", function () {
                                                                    t_init("textarea.tinymce");
                                                                    $(".sub_task_details").slideUp();
                                                                    init();
                                                                    $(".save").on("click", function () {
                                                                        // console.log("hi");
                                                                        $(this).parents("form").find("input[type='hidden'][name='action']").remove();
                                                                        $(this).parents("form").append("<input type='hidden' name='action' value='save'/>");
//                $(this).parents("form").submit();
                                                                    });
                                                                    $(".update").on("click", function () {
                                                                        //  console.log("bye");
                                                                        $(this).parents("form").find("input[type='hidden'][name='action']").remove();
                                                                        $(this).parents("form").append("<input type='hidden' name='action' value='update'/>");
//                $(this).parents("form").submit();
                                                                    });
                                                                    $(".replica").on("click", function () {
                                                                        console.log("Weeee");
                                                                        $(this).parents("form").find("input[type='hidden'][name='action']").remove();
                                                                        $(this).parents("form").append("<input type='hidden' name='action' value='replica'/>")
//                $(this).parents("form").submit();
                                                                    });
                                                                    $(".copy_task").on("click", function () {
                                                                        console.log("Weeee");
                                                                        $(this).parents("form").find("input[type='hidden'][name='action']").remove();
                                                                        $(this).parents("form").append("<input type='hidden' name='action' value='copy'/>")
//                $(this).parents("form").submit();
                                                                    });
                                                                });</script>
<script>
    function download_my_files(subTask_id)
    {
        console.log(subTask_id);
    }

    function show_upload_panel(that)
    {
        //alert($(that).attr("sub_task_id")+ " "+$(that).attr("task_id") );
        $("div.document_uploader").find("div.dz-preview").remove();

        $("div.document_uploader").show();
        $("div.document_uploader").find("#subtastid").val($(that).attr("sub_task_id"));
        $("div.document_uploader").find("#taskid").val($(that).attr("task_id"));
        // alert( $("div.document_uploader").find("#taskid").val());
    }
    $(document).ready(function () {

    <?php 
      if(isset($task_data['ttm_id']) && isset($task_data['file_id'])  && $task_data['file_id']!= ""){
          echo "setupSubTask({$task_data['ttm_id']}); gen_task_code();";
      }
    ?>


//$('#bdatetimepicker')
//        .datetimepicker({
//            format: 'dd-mm-yyyy'
//        })
//        .on('changeDate', function(e) {
//            // Revalidate the start date field
//            $('#task_save_update_form').formValidation('revalidateField', 'start_date');
//        });
//
//    $('#bdatetimepicker')
//        .datetimepicker({
//            format: 'dd-mm-yyyy'
//        })
//        .on('changeDate', function(e) {
//            $('#task_save_update_form').formValidation('revalidateField', 'end_date');
//        });
        load_validator();
        
    });
    function load_validator()
    {
        
        // bootstrapValidator.destroy();
        $('#task_save_update_form').data('bootstrapValidator', null);
        $('#task_save_update_form').bootstrapValidator({
            live: 'disabled',
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                tm_name: {// task name
                    validators: {
                        notEmpty: {
                            message: 'Task Name is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9()/-\s]+$/,
                            message: 'Task Name can only consist given alphabets a-zA-Z0-9 or space'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Name must be more than 3 characters long'
                        }
                    }
                },
                tm_code: {// task code
                    validators: {
                        notEmpty: {
                            message: 'Task code is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_-\s]+$/,
                            message: 'Task code can only consist given alphabets a-zA-Z0-9_- or space'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Task Code must be more than 3 characters long'
                        }
                    }
                },
                incharge_id: {//incharge
                    validators: {
                        callback: {
                            message: 'Please choose at least one Client',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".incharge-id").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                client_id: {//client
                    validators: {
                        callback: {
                            message: 'Please choose at least one Client',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".client_id").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                   month: {//client
                    validators: {
                        callback: {
                            message: 'Please choose at least one Client',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".month").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                year: {//client
                    validators: {
                        callback: {
                            message: 'Please choose at least one Year',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".year").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                 state_id: {//client
                    validators: {
                        callback: {
                            message: 'Please choose at least one State',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".state_id").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                start_date: {//start date
                    validators: {
                        notEmpty: {
                            message: 'The start date is required'
                        },
                        date: {
                            format: 'DD-MM-YYYY hh:mm A',
                            max: 'end_date',
                            message: 'The Start date is not a valid Date'
                        }
//                        callback: {
//                            message: "Start Date Need to be Smaller than End Date",
//                            callback: {
//                                message: 'Start Date Needs to be greater than End Date',
//                                callback: function (value, validator, $field) {
//                                    // Check if the start is earlier then the end one
//                                    if (value) {
//                                        var startDate = $("input[name='start_date']").val();
//                                        var endDate = $("input[name='end_date']").val();
//                                        var only_str_date = startDate.substr(0, startDate.indexOf(' '));
//                                        var only_end_date = endDate.substr(0, endDate.indexOf(' '));
//                                        var str_date_Arr = only_str_date.split('-');
//                                        var final_str_date = str_date_Arr[1] + '-' + str_date_Arr + '-' + str_date_Arr[2].slice(-2);
//                                        var end_date_Arr = only_end_date.split('-');
//                                        var final_end_date = end_date_Arr[1] + '-' + end_date_Arr + '-' + end_date_Arr[2].slice(-2);
//                                        if (new Date(final_str_date).getTime() < new Date(final_end_date).getTime()) {
//                                            return false;
//                                        } else {
//                                            return true;
//                                        }
//                                    }
//                                }
//                            }
//                        }
                    }
                },
                end_date: {//end date
                    validators: {
                        notEmpty: {
                            message: 'The end date is required'
                        },
                        date: {
                            format: 'DD-MM-YYYY hh:mm A',
                            min: 'start_date',
                            message: 'The End date is not a valid Date'
                        }
//                        ,
//                        callback: {
//                            message: 'difference between dates should be maximum of 1 days',
//                            callback: function (value, validator, $field) {
//                                // Check if the start is earlier then the end one
//                                if (value) {
//
//                                    var oneDay = 1 * 60 * 60 * 1000;
//                                    var startDate = $("input[name='start_date']").val();
//                                    var endDate = $("input[name='end_date']").val();
//                                    var only_str_date = startDate.substr(0, startDate.indexOf(' '));
//                                    var only_end_date = endDate.substr(0, endDate.indexOf(' '));
//                                    var str_date_Arr = only_str_date.split('-');
//                                    var final_str_date = str_date_Arr[1] + '-' + str_date_Arr + '-' + str_date_Arr[2].slice(-2);
//                                    var end_date_Arr = only_end_date.split('-');
//                                    var final_end_date = end_date_Arr[1] + '-' + end_date_Arr + '-' + end_date_Arr[2].slice(-2);
//                                    var days = Math.round(Math.abs((new Date(final_str_date).getTime() - new Date(final_end_date).getTime()) / (oneDay)));
//                                    console.log(startDate);
//                                    if (days < 30) {
//                                        return true;
//                                    } else {
//                                        return false;
//                                    }
//                                }
//                            }
//                        }
                    }
                },
                helper_task_list: {
                    validators: {
                        callback: {
                            message: 'Please choose option from helper task list',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                var options = $(".get_task_types").val();
                                return (options != null && options != 0);
                            }
                        }
                    }
                },
                ttm_id: {
                    validators: {
                        callback: {
                            message: 'Please choose option from sub-task list',
                            callback: function (value, validator, $field) {
                                // Get the selected options
                                //var options = $(".db_sub_task").val();
                                // alert(value);
                                if (value != null && value != 0)
                                {
                                    return true;
                                }
                                return false;
                            }
                        }
                    }
                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
//                var $form = $(e.target);
var formData = new FormData($('#task_save_update_form')[0]);
            if (ValidateOtherss() && formSub === 1) {
                formSub = 0;
                preloader.on();
                $.ajax({
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
//                    
                    type: "POST",
                    data: formData,
                    url: $("#task_save_update_form").attr("action"),
                    dataType: "json",
                     cache:false,
            contentType: false,
            processData: false,
                    success: function (result) {

//                        console.log(result);
                        var msg = display_msg(result._err_codes);
                        if (result.succ) {
                            sweetAlert({
                                title: "Nice..",
                                text: msg,
                                type: "success",
                                html: true
                            });
                            setTimeout(function () {
                                window.location = (get_base_url() + "tms/manage_tasks/index/" + result.id);
                                console.log((get_base_url() + "tms/manage_tasks/index/" + result.id));
                            }, 2000);
                            //window.location = get_base_url() + "tms/manage_tasks/index/";
                        } else {
                            formSub = 1;
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
            } else {
                 console.log("cominmg");
            }
        });
    }

    function display_msg($_data) {
        var err_msg = "";
        $.each($_data, function (i, value) {
            err_msg += value + "\n";
        });
        return err_msg;
    }
    var ForvValidate = 0;
    var formSub = 1;
    function ValidateOtherss()
    {

//            alert("hiii");
        console.log("Validating   other");
        $("#task_save_update_form select.assignedto").each(function (index, item) {
            console.log($(item).val());
            if ($(item).val() === '0')
            {

                ForvValidate = 0;
                // $(item).parent().remove("<span style='color:red;'>Please Fill It</span>");

                $(item).parent().children("span").remove();
                $(item).parent().append("<span class='small' style='color:red;'>Please Fill It</span>");
                // alert("SOrry assignedto Plese fill form");
            }
            else
            {
                $(item).parent().children("span").remove();
                ForvValidate = 1;
            }
            
            // 
        });
//        $("#task_save_update_form select.joblocalityid").each(function (index, item) {
//            console.log($(item).val());
//            if ($(item).val() === '0')
//            {
//                ForvValidate = 0;
//
//                // $(item).parent().remove("<span style='color:red;'>Please Fill It</span>");
//
//                $(item).parent().children("span").remove();
//
//                $(item).parent().append("<span class='small' style='color:red;'>Please Fill It</span>");
//                // alert("SOrry assignedto Plese fill form");
//            }
//            else
//            {
//                ForvValidate = 1;
//                $(item).parent().children("span").remove();
//            }
//            // alert("SOrry Plese fill form");
//        });

        $("#task_save_update_form input.ttstm_efforts").each(function (index, item) {
            console.log($(item).val());
            if ($(item).val() === '0')
            {
                ForvValidate = 0;
                // $(item).parent().remove("<span style='color:red;'>Please Fill It</span>");

                $(item).parent().children("span").remove();
                $(item).parent().append("<span class='small' style='color:red;'>Please Fill It</span>");
                // alert("SOrry assignedto Plese fill form");
            }
            else
            {
                ForvValidate = 1;
                $(item).parent().children("span").remove();
            }
            //   alert("SOrry Plese fill form");
        });
        if (ForvValidate === 0)
        {
            return false;
        }
        return true;
    }


<?php
if (isset($active_tab) && ($active_tab == 'copy_task' || $active_tab == 'copy_task')) {
    ?>
        gen_task_code();
    <?php
}
?>


    function delme(that)
    {
        var attach_id = $(that).parent("div").attr("attach_id");
        console.log(attach_id);

        if (attach_id != "")
        {
            preloader.on();
            $.ajax({
                url: "<?php echo base_url() . "tms/manage_sub_task/delete_subTask_document" ?>",
                type: 'POST',
                data: "attach_id=" + attach_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("div.fileUploaded[attach_id='" + attach_id + "']").remove();

                    } else {
                        sweetAlert({
                            title: "Oops...",
                            text: "Error while uploading file, please try again .. >__<",
                            type: "error",
                            timer: 2500,
                            html: true
                        });
                    }
                }
            });
        }
    }
    
    function m_sorting(){
        var sort = 5;
        $(".sub_tasks_container").find(".sort_sub_task").each(function(){
             console.log($(this).clone());
             $(this).attr("value",sort);
             sort+=5;
        });
    }
    
    function clientChanged(that){
        client_id = $(that).val();
        //
    }
    
    
</script>
