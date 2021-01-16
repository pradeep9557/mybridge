<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Update Daily Task Report</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
           // $this->util_model->printr($edit_daily_data);
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
    <style>
                                                .container1 {
                                                    width: 100%;
                                                    height: 100%;
                                                    position: absolute;
                                                    visibility:hidden;
                                                    display:none;
                                                    /*background-color: rgba(22,22,22,0.5);*/
                                                }

                                                .container1:target {
                                                    visibility: visible;
                                                    display: block;
                                                }
                                                .reveal-modal select {
                                                    max-width: 900px;
                                                    margin-bottom: 23px;
                                                }
                                                .reveal-modal { 
                                                    background:#fff; 
                                                    margin: 0 auto;
                                                    width:1000px; 
                                                    position:relative; 
                                                    z-index:41;
                                                    top: 25%;
                                                    padding:30px; 
                                                    -webkit-box-shadow:0 0 10px rgba(0,0,0,0.4);
                                                    -moz-box-shadow:0 0 10px rgba(0,0,0,0.4); 
                                                    box-shadow:0 0 10px rgba(0,0,0,0.4);
                                                }
                                                </style>
                                                
                                                    <?php 
                                                    //print_r($clientlist);
                                                        foreach ($edit_daily_data['doc'] as $each_doc) { 
                                                            ?>
                                                            <form name="form<?php echo $each_doc['attach_id'];?>">
                                                            <div id="container<?php echo $each_doc['attach_id'];?>" class="container1">
                                                                <div id="exampleModal<?php echo $each_doc['attach_id'];?>" class="reveal-modal">
                                                                    <h2>Change Task</h2>
                                                                    <input type="hidden" id="attachid<?php echo $each_doc['attach_id'];?>" name="attachid<?php echo $each_doc['attach_id'];?>" value="<?php echo $each_doc['attach_id'];?>">
                                                                    <select id="clientlist<?php echo $each_doc['attach_id'];?>" name="clientlist<?php echo $each_doc['attach_id'];?>">
                                                                    <?php 
                                                                    foreach ($clientlist as $key1 => $value1) {
                                                                        ?>
                                                                        <option value="<?php echo $value1['tstm_id'];?>"><?php echo $value1['tstm_name'];?>(<?php echo $value1['tm_name'];?>)</option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <button name="submit1" class="changeattach" value="<?php echo $each_doc['attach_id'];?>">Submit</button>
                                                                    <a href="#" class="close-reveal-modal" style="
    position: absolute;
    top: 6px;
    right: 10px;
">×</a>
                                                                </div>
                                                            </div>
                                                            </form>
                                                            <?php
                                                        }
                                                    ?>
                                                    <script>
                                                    $('.changeattach').click(function(e){
                                                        e.preventDefault();
                                                        var id=$(this).val();
                                                        var clientlist=$('#clientlist'+id).val();
                                                        var attachid=$('#attachid'+id).val();
                                                        $.ajax({
                                                            type: "POST",
                                                            url: get_base_url() + "tms/daily_task/update_attachment",
                                                            data: "clientid=" + clientlist + "&attachid=" + attachid,
                                                            dataType: "json",
                                                            success: function (result) {
                                                                if (result['success']) {
                                                                    swal("Updated!", result['_err_msg'], "success");
                                                                } else {
                                                                    swal("Cancelled", result['_err_msg'], "error");

                                                                }
                                                                //                            .animate({opacity: "hide"}, "slow").remove();
                                                            }
                                                        });
                                                    });
                                                    </script>
        <div class="col-lg-12">
            <?php if(!isset($edit_daily_data['comment_id'])){ 
                 echo "Sorry, this entry has been locked, You can edit entry upto One hour of punching !!";
            }else{?>
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Update Daily Task From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse" id="collapseExample">   
                    <!--String of Row-->
                    <?php
                    //for normal form
                    //  echo form_open('/dashboard/new_admission',$attributes);
                    echo form_open_multipart(base_url() . 'tms/daily_task/update_daily_task', "id='daily_task_form'");
                    ?>
                    <input type="hidden" name="comment_id" value="<?php echo $edit_daily_data['comment_id']; ?>">
                    <input type="hidden" name="tstm_id" value="<?php echo $edit_daily_data['tstm_id']; ?>">
                    <div class="row bottom_gap hidden">

                        <div class="col-lg-1 col-md-1 col-sm-4 padding_top_label">Client List</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("client_id", $client_list, $edit_daily_data['tstm_id'], "class='form-control client_list ajax_react'") ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Sub Task</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class="form-group">
                                <?php echo form_dropdown("tstm_id_2", $progress_task, $edit_daily_data['tstm_id'], "class='form-control sub_task ajax_react'") ?>
                            </div>
                        </div>
                    </div> <!--End of row-->
                    
                    <div class="row bottom_gap">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <!--<div class="reply_task_block" id="reply_box22">-->
                            <div class="row">
                                <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs text-center">
                                    <img class="img-circle img-responsive" src="<?php echo base_url() ?>img/Employee_Data/Employee_pic_and_sign/default-avatar.png">
                                </div>
                                <div class="col-lg-11 col-md-10 col-sm-10">
                                    <div class="row bottom_gap">
                                        <div class="col-lg-12 col-md-12 col-sm-12">Work Done Description(<span class="text-danger">*</span>)</div>
                                    </div> <!--End of row-->
                                    <div class="row bottom_gap"> 
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <textarea id="tinymce1" name="comment" rows="2" class="col-lg-12" aria-hidden="true"><?php echo $edit_daily_data['comment'] ?></textarea>
                                        </div>
                                    </div> <!--End of row--> 
                                    <div class="row bottom_gap"> 
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Progress Flag</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group">
                                                <?php
                                                echo form_dropdown("progress_flag", $all_progress_flags, $edit_daily_data['progress_flag'], "class='form-control  pg_flag'");
                                                ?>
                                            </div> 
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Efforts</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">In Hours</span>
                                                    <input type="text" name="efforts" class="form-control" placeholder="e.g 3"  maxlength="3" value="<?php echo $edit_daily_data['efforts'] ?>">
                                                </div>
                                            </div>

                                        </div><!-- /input-group -->               

                                    </div> <!--End of row-->
                                    <div class="row bottom_gap">
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Completed</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8"> 
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <?php
                                                    echo form_dropdown("completed", $all_completion_status, $edit_daily_data['completed'], "class='form-control  completed_val'");
                                                    ?> 
                                                    <span class="input-group-addon" id="basic-addon2">%</span>
                                                </div> 
                                            </div>
                                        </div> 

                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Attachment(If any)</div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class="form-group" id="attachment">
                                                <input type="file" multiple name="attach_name[]"/>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h5>Already Attached Files</h5>
                                                <ol>
						<?php foreach ($edit_daily_data['doc'] as $each_doc) { ?>
                                                        <li><a target='_blank' href="<?php echo base_url() . $each_doc['link'] ?>"><?php echo $each_doc['attach_original_name'] ?></a>
                                                            <button type="button" class='ajax_del_doc' value="<?php echo $each_doc['attach_id'] ?>" _msg="You want to delete <?php echo $each_doc['attach_original_name'] ?> file" _key="del_attachment" _title="<?php echo $each_doc['attach_original_name'] ?>">
                                                                <span class='glyphicon glyphicon-trash del_attachment  text-danger' key="<?php echo $each_doc['attach_id'] ?>" doc_link="<?php echo $each_doc['link'] ?>"></span>
                                                            </button>
                                                            <a href="#container<?php echo $each_doc['attach_id']; ?>" data-reveal-id="exampleModal<?php echo $each_doc['attach_id']; ?>"><span class='glyphicon glyphicon-pencil del_attachment  text-danger' key="<?php echo $each_doc['attach_id'] ?>" doc_link="<?php echo $each_doc['link'] ?>"></span></a>
                                                            </li>
                                                    <?php }
                                                    ?>

                                                </ol>
                                                
                                            </div>
                                        </div>
                                    </div> <!--End of row-->

                                    <div class="row bottom_gap"> 
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Work Date & Time: </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <div class='input-group date bdatetimepicker'>
                                                <input type='text' class="form-control" id="work_datetime" name="work_datetime" value="<?php echo date("d-m-Y h:i A", strtotime($edit_daily_data['work_datetime'])) ?>"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Work Date & Time: </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8">
                                            <?php 
                                             echo form_dropdown("approved",array("0"=>"Pending for approval","1"=>"Approved","-1"=>"Rejected"),$edit_daily_data['approved'],"class='form-control'");
                                            ?>
                                            
                                        </div>
                                        
                                    </div> <!--End of row--> 

                                    <div class="row bottom_gap"> 
                                        <div class="row bottom_gap">

                                            <?php if (isset($show_comment_box) && $show_comment_box == TRUE) { ?>
                                                <div class="notify_box">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">
                                                        <div class="col-lg-12">Notify Via-Email</div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10"> 
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                                <input type="checkbox" style="cursor:pointer;" class="mail_to_all">
                                                                <span class="user_name" title="">All</span>
                                                            </div>
                                                        </div> 
                                                        <div class="tbl_check_name col-lg-12"> 
                                                        </div> 
                                                    </div><!-- /input-group -->      
                                                </div>
                                            <?php }
                                            ?>
                                        </div> <!--End of row--> 

                                    </div>
                                    <div class="row bottom_gap"> 
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success btn-md action" id="action_sub">
                                                <span class="glyphicon glyphicon-oppy-disk"></span> Update Work Description
                                            </button> 
                                        </div>
                                    </div>
                                </div> 
                            </div>  
                            <!--</div>-->

                            <div class="dummy_checkboxes hidden">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="checkbox" name="email[]" value="" style="cursor:pointer;" class="chk_fl">
                                    <span class="user_name" title=""></span>
                                </div>
                            </div>
                            <script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
                            <script>
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



                                $(document).on("ready", function () {
                                    var d = new Date();
                                    d.setDate(d.getDate() - 2);
                                    $('.bdatetimepicker').datetimepicker({
                                        minDate: d,
                                        format: 'DD-MM-YYYY hh:mm A',
                                        icons: {
                                            time: "fa fa-clock-o",
                                            date: "fa fa-calendar",
                                            up: "fa fa-arrow-up",
                                            down: "fa fa-arrow-down"
                                        }
                                    });

                                    t_init("#tinymce1");

                                    $(".reset_btn").click(function () {
                                        $(this).parents("form").trigger("reset");
                                    });

                                    $(".mail_to_all").click(function () {
                                        if ($(this).is(':checked')) {
                                            $.each($(".tbl_check_name").find("input[type='checkbox']"), function () {
                                                $(this).prop('checked', true);
                                            });
                                        } else {
                                            $.each($(".tbl_check_name").find("input[type='checkbox']"), function () {
                                                $(this).prop('checked', false);
                                            });
                                        }
                                    });
                                });


                            </script>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<!--    <link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>-->
    <script src="<?= CDN1 ?>js/custom_js/daily_task_entry.js" type="text/javascript"></script>
    <script>

                                $(document).on("ready", function () {
                                    get_notify_users(<?php echo $edit_daily_data['tstm_id'] ?>);
                                    $("#daily_task_form").on("submit", function (e) {
                                        e.preventDefault();
                                        preloader.on();
                                        $.ajax({
                                            data: new FormData(this),
                                            dataType: 'json',
                                            contentType: false,
                                            cache: false,
                                            processData: false,
                                            url: $(this).attr("action"),
                                            method: "POST",
                                            success: function (result) {
                                                if (result.succ) {
                                                    $("#daily_task_form").trigger("reset");
                                                    $("button").removeAttr("disabled");
                                                      swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                                                    setTimeout(function () {
                                                        location.href=location.href;
                                                    }, 2000);

                                                } else {
                                                    $("button").removeAttr("disabled");
                                                    sweetAlert("Oops...", result._err_codes, "error");
                                                }
                                                 preloader.off();
                                            }
                                        });
                                    });

                                    $(".ajax_del_doc").click(function () {
                                        var docfile_link = $(this).find(".del_attachment").attr("doc_link");
                                        var doc_id = $(this).val();//Delete
                                        var key = $(this).attr("_key");//Delete
                                        var _msg = $(this).attr("_msg");
                                        var title = $(this).attr("_title");
                                        var action = "Delete";
                                        var _this = $(this);
                                        swal({
                                            title: "Are you sure?",
                                            text: _msg,
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#DD6B55',
                                            confirmButtonText: 'Yes, ' + action + ' it!',
                                            cancelButtonText: "No, cancel Please!",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                preloader.on();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url() ?>Ajax/delete",
                                                    data: "_key=" + key + "&ID=" + doc_id + "&link=" + docfile_link,
                                                    dataType: "json",
                                                    success: function (result) {
                                                        //console.log(result);
                                                       
                                                        if (result['success']) {

                                                            
                                                              swal({
                                        title: "Done!",
                                        text: "Your " + title + " has been deleted!",
                                        type: "success",
                                        timer: 1000
                                    });
                                                            _this.parent("li").animate({backgroundColor: "#fbc7c7"}, "slow", function () {
                                                                _this.parent("li").remove();
                                                            });

                                                        } else {
                                                            var _err_msg = result['_err_msg'];
                                                            if (_err_msg != "")
                                                                swal("Cancelled", _err_msg, "error");
                                                            else
                                                                swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                                                        }
                                                         preloader.off();
                                                        //                            .animate({opacity: "hide"}, "slow").remove();
                                                    }
                                                });
                                            } else {
                                                swal("Cancelled", "Your " + title + " is safe :)", "error");
                                            }
                                        });
                                    });


                                });

    </script>
    <link href="<?= CDN1 ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
    <script src="<?= CDN1 ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?= CDN1 ?>js/multi_select/prism.js" type="text/javascript"></script>
    <script type="text/javascript">
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

    </script> 
</div>
