<script>
    var tstm_id = "";
</script>
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
                    var receiver = $("div.documents_attach");
                    // console.log(receiver);
                    receiver.append("<div class='fileUploaded' attach_id='" + data.attach_id + "' >" + data[0].attach_original_name + " <i class='fa fa-times' onclick='delme(this)' aria-hidden='true'></i> </div>");
                }
            };




            //    console.log(Dropzone.options);
        });



    </script>
</div>
<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">  
            <?php if (isset($error)) { ?>
                <?php
                show_404();
            } else {
                ?>
                <script>
                    tstm_id = '<?php echo $tstm_id; ?>'
                </script>
            <?php }
            ?>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-12">
                <h1 class="task_name page-header"></h1>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4 task_elements">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>Type:</td>
                                <td class="pro_type"></td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td>
                                    <span class="task_status"></span>
                                    <div class="hidden">
                                        <?php echo form_dropdown("updated_progress_flag", $all_progress_flags, 1); 
                                        echo form_input('reason_to_change','',"placeholder='reason to change the status?'");?>
                                        <button class="btn btn-xs" onclick="update_progress_flag()">Update</button>
                                    </div>
                                </td>  
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4 task_elements">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>Est. Hour(s): </td>
                                <td class="est_time"></td>
                            </tr>
                            <tr>
                                <td>Hour(s) Spent: </td>
                                <td class="hr_by_user">
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4 task_elements">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>Project:</td>
                                <td class="pro_name"></td>
                            </tr>
                            <tr>
                                <td>Task Progress:</td>
                                <td class="task_progress">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                             aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">

                    <!--                    <div class="col-lg-12 border_bottom_view">
                                        </div>-->

                    <div class="cb"></div>
                    <div class="col-lg-12">
                        <div class="details_task_block">
                            <div class="details_task_head">
                                <div class="fl"> 
                                    <img onerror="img_load_fail(this)" class="lazy round_profile_img incharge_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                                </div>
                                <div class="fl"> <span>Incharge Name <b class="task_creator"></b></span>
                                    <div class="create_date"></div>
                                </div>
                            </div>
                            <div class="details_task_desc wrapword">
                                <strong>
                                    Purpose
                                </strong>
                                <p class="purp"></p>
                                <br>
                                <strong>
                                    Control Points
                                </strong>
                                <p class="ctrl_pnts"></p>
                                <br>
                                <strong>
                                    Check_points
                                </strong>
                                <p class="chk_pnts"></p>
                                <br>
                                <strong>
                                    Background
                                </strong>
                                <p class="backgnd"></p>
                                <br>
                                <strong>
                                    Document Required
                                </strong>
                                <div class="doc_required">
                                    <ol>

                                    </ol>
                                </div>   
                                <br>
                                <strong>
                                    Sub Task Documents
                                </strong>
                                <div class="sub_task_doc">
                                    <div class="documents_attach" onload="download_my_files('<?php echo $tstm_id ?>')">


                                    </div>
<!--                                    <button type="button" value="Save" task_id="" sub_task_id="<?php echo $tstm_id ?>" onclick="show_upload_panel(this);" class="btn btn-success btn-md upload_sub_task_documents">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>-->


                                </div>


                                <div class="cb"></div>

                            </div>
                        </div>
                    </div>
                    <div class="reply_box">

                    </div>
                </div>
                <form id="reply_form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo base_url() . "tms/daily_task/punch_daily_entry" ?>">
                    <?php $this->load->view("tms/common/comment_box") ?>
                </form>
            </div>
            <div class="col-lg-3 fl">
                <div>
                    <div class="asign_block">
                        <div id="case_dtls_asgn22" class="fl asgn_actions  dropdown"> 
                            <span class="quick_action" data-toggle="dropdown">Assigned To</span>
                        </div>
                    </div>

                    <div class="cb"></div>
                    <div class="fl">
                        <img onerror="img_load_fail(this)" class="lazy round_profile_img rep_bdr assigned_user" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                    </div>
                    <div class="fl">
                        <span>
                            <b id="case_dtls_new22" class="assign_to"></b>
                        </span>
                        <div class="assigned_email"></div>
                    </div>
                </div>

                <div class="cb"></div>
                <hr>
                <h4 style="font-size: 18px">
                    Task Logs    
                    <button class="btn btn-sm btn-primary load_task_comment pull-right" tm_id="" onclick="get_task_logs()">
                        <span class='glyphicon glyphicon-eye-open'></span>
                    </button>
                </h4> 
                <div class="tm_clogs">
                    <span class='fa fa-refresh fa-spin fa-3x fa-fw'></span> Loading ....
                </div>
                <div class="cb"></div>
                <hr>
                <div class="task_due_dt">
                    <div class="cb"></div>
                    <div class="fl">
                        <span class="attachments">No Files in this Task</span>
                    </div>
                    <div class="attach_files">

                    </div>
                </div>
                <div class="cb"></div>
                <hr>
                <div class="task_due_dt">
                    <div class="cb"></div>
                    <div class="fl"> <span>People Involved</span>
                        <br>
                    </div>
                </div>
                <div class="cb"></div>
                <div class="fl involved_user">

                </div>

            </div>
        </div>

    </div>
</div>
<div class="involved_user_html hidden">
    <div class="per_name_div">
        <img onerror="img_load_fail(this)" class="lazy round_profile_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
        <span class="per_name"></span>
    </div>
</div>
<div class="attachment_html hidden">
    <div class="cb"></div>
    <div class="fl">
        <span class="attachment_link">

        </span>
        <div class="fnt999 time_attach"></div>
    </div>
</div>
<div class="comment_html hidden">
    <div class="col-lg-12">
        <div class="details_task_block">
            <div class="details_task_head">
                <div class="fl">
                    <img onerror="img_load_fail(this)" class="lazy round_profile_img comment_user_img rep_bdr" width="35" height="35" src="<?php echo base_url() ?>img/logo.png" style="display: inline;">
                </div>
                <div class="fl"> <span><b class="comment_username"></b></span>
                    <div class="comment_time"></div>
                </div>
                <div class="fr">
                    <table cellpadding="0" cellspacing="0" class="fr task_status">
                        <tbody>
                            <tr>
                                <td>Assigned To: <b class="task_creator"></b>
                                </td>
                            </tr>
                            <tr>
                                <td>Progress/Comp(%)/Eff: <b class="comment_pro"></b>/<b class="comment_comp"></b>/<b class="comment_eff"></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="details_task_desc wrapword">
                <div id="casereplytxt_id_23">
                    <span class="comment_data"></span>
                    <span class="comment_status text-danger"></span>
                </div>
                <div id="casereplyid_23"></div>
            </div>
            <div class="file_container hidden">
                <span class="comment_file_title">Files Attached With this comment</span>
                <ol class="comment_file_attached">

                </ol>
            </div>
        </div>
    </div>
</div>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>
<link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
                        function set_json_to_html(result) {
                            console.log(result);
                            console.log(result.data.progress_flag);
                            if (result.data.progress_flag == "Close & Completed") {
                                $("#reply_form").hide();
                            }

                            $("#reply_form").find("input[type='hidden'][name='tstm_id']").remove();
                            $("#reply_form").append("<input type='hidden' name='tstm_id' value='" + result.data.tstm_id + "'/>");
                            $(".task_name").html(result.data.tstm_name + " <span title='Task Name'>(" + result.data.tm_name + ")</span>");
                            $(".pro_type").html(result.data.ttm_name);
                            $(".est_time").html(result.data.tstm_efforts + " hours");
                            $(".pro_name").html(result.data.tm_name);
                            $(".incharge_img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + result.data.incharge_pic);
                            $(".task_creator").html(result.data.incharge_name);
                            $(".assign_to").html(result.data.Emp_Name);
                            $(".assigned_email").html(result.data.P_Email);
                            $(".assigned_user").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + result.data.Pro_Pic);
                            $(".create_date").html(result.data.start_date);
                            $(".chk_pnts").html(result.data.tstm_check_points);
                            $(".purp").html(result.data.purpose);

                            $("td > span.task_status").html(result.data.progress_flag + " <u class='cursor_pointer' onclick='change_task_status(" + result.data.tstm_id + ")'>Change</u>");
                            $("td.task_progress").find(".progress-bar").css("width", result.data.completed + "%");
                            $("td.task_progress").find(".progress-bar").html(result.data.completed);
                            $(".ctrl_pnts").html(result.data.tstm_control_points);
                            $(".chk_pnts").html(result.data.tstm_check_points);
                            $(".backgnd").html(result.data.background);
                            $(".upload_sub_task_documents").attr('task_id', result.data.tstm_code);
                            var hr_by_user = 0;
                            $.each(result.data.comment_data, function (i, value) {
                                $(".comment_html").find(".comment_user_img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + value.Pro_Pic);
                                $(".comment_html").find(".comment_username").html(value.Emp_Name);
                                $(".comment_html").find(".comment_time").html(value.work_datetime);
                                $(".comment_html").find(".comment_data").html(value.comment);
                                $(".comment_html").find(".comment_status").html(value.approved_flag);
                                $(".comment_html").find(".comment_pro").html(value.progress_flag);
                                $(".comment_html").find(".comment_comp").html(value.completed + "%");
                                $(".comment_html").find(".comment_eff").html(value.efforts + " Hours");


                                $(".comment_html").find(".comment_file_attached").empty();
                                if (value.comment_attachments.length > 0) {
                                    $(".comment_html").find(".file_container").removeClass("hidden");
                                    $.each(value.comment_attachments, function (i, value) {
                                        $(".comment_html").find(".comment_file_attached").append("<li class=''><a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_original_name + "</a></li>");
                                    });
                                } else {
                                    $(".comment_html").find(".file_container").addClass("hidden");
                                }

                                $(".reply_box").append($(".comment_html").html());
                                hr_by_user += parseInt(value.efforts);
                            });
                            if (result.data.doc_required.length > 0) {
                                $(".doc_required").find("ol").html("");
                                $.each(result.data.doc_required, function (i, value) {

                                    $(".doc_required").find("ol").append("<li>" + "" + "<a target='_blank' class='file_link' title=" + value.tmdoc_name + " href='" + get_base_url() + value.document_path + "' >" + value.tmdoc_name + "</a></li>");
                                });
                            } else {
                                $(".doc_required").find("ol").append("<li>No any required documents attached with this sub task</li>");
                            }

                            // sub task document
                            if (result.data.sub_task_doc.length > 0) {
                                $(".sub_task_doc > .documents_attach").html("");
                                $.each(result.data.sub_task_doc, function (i, value) {
                                    $(".sub_task_doc > .documents_attach").append("<div class='fileUploaded' attach_id='" + value.attach_id + "'><a href='" + get_base_url() + value.link + "' target='_blank'>" + value.attach_original_name + "</a></div>");
                                    //<i class='fa fa-times' onclick='delme(this)' aria-hidden='true'></i>
                                });
                            } else {
                                $(".sub_task_doc > .documents_attach").append("<li>No any required documents attached with this sub task</li>");
                            }

                            $(".load_task_comment").attr("tm_id", result.data.tm_id);
                            $(".tm_clogs").slideUp();

                            $(".hr_by_user").html(" " + hr_by_user + " hours");
                            $(".attach_files").empty();
                            if (result.data.attachments.length > 0) {
                                $(".attachments").html("Files in this Task");
                            } else {
                                $(".attachments").html("No Files in this Task");
                            }
                            $.each(result.data.attachments, function (i, value) {
                                $(".attachment_html").find(".attachment_link").html("<a target='_blank' class='file_link' title=" + value.attach_name + " href='" + get_base_url() + value.link + "' >" + value.attach_name + "</a>");
                                $(".attachment_html").find(".time_attach").html(value.date);
                                $(".attach_files").append($(".attachment_html").html());
                            });
                            $.each(result.data.involved_user_data, function (i, value) {
                                $(".involved_user_html").find("img").attr("src", get_base_url() + "img/Employee_Data/Employee_pic_and_sign/" + value.Pro_Pic);
                                $(".involved_user_html").find("img").attr("title", value.Emp_Name);
                                $(".involved_user_html").find(".per_name").text(value.Emp_Name);
                                $(".involved_user").append($(".involved_user_html").html());
                            });
                            $(".dashboard_win").addClass("hidden");
                            $(".single_task_window").removeClass("hidden");
                        }

                        function img_load_fail(that) {
                            $(that).attr("src", (get_base_url() + "img/logo.png"));
                        }

                        $(document).on("ready", function () {
                            preloader.on();
//                        $("#reply_form").trigger("reset");
                            $.ajax({
                                type: "POST",
                                url: get_base_url() + "tms/manage_sub_task/mySubTask",
                                data: "tstm_id=" + tstm_id,
                                dataType: "json",
                                success: function (result) {
                                    $(".involved_user").html("");
                                    if (result.succ) {

                                        set_json_to_html(result);

                                    } else {
                                        swal("oops!!", "Either you are not authorized to view this task or you need to refresh the page!!", "error");
                                    }
                                    preloader.off();
                                }
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

                            $("#reply_form").on("submit", function (e) {
                                e.preventDefault();
                                var $form = $(e.target);
                                preloader.on();
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
                                    url: $(this).attr("action"),
//                                data: $(this).serialize(),
                                    dataType: "json",
                                    contentType: false,
                                    enctype: 'multipart/form-data',
                                    cache: false,
                                    processData: false,
                                    success: function (result) {
                                        $("#reply_form").trigger("reset");
                                        $(".involved_user").html("");
                                        if (result.succ) {
                                            swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                                            $.ajax({
                                                type: "POST",
                                                url: get_base_url() + "tms/manage_sub_task/mySubTask",
                                                data: "tstm_id=" + tstm_id,
                                                dataType: "json",
                                                success: function (result) {
                                                    if (result.succ) {
                                                        set_json_to_html(result);
                                                    }
                                                }
                                            });
                                        } else {
                                            sweetAlert("Oops...", result._err_codes, "error");
                                        }
                                        preloader.off();
                                    }

                                });

                            });
                        });

//                    $('#reply_form').bootstrapValidator({
//                        feedbackIcons: {
//                            valid: 'glyphicon glyphicon-ok',
//                            invalid: 'glyphicon glyphicon-remove',
//                            validating: 'glyphicon glyphicon-refresh'
//                        },
//                        fields: {
//                            progress_flag: {
//                                validators: {
//                                    callback: {
//                                        message: 'Please choose the progress flag',
//                                        callback: function (value, validator, $field) {
//                                            // Get the selected options
//                                            var options = $(".pg_flag").val();
//                                            return (options != null && options != 0);
//                                        }
//                                    }
//                                }
//                            },
//                            completed: {
//                                validators: {
//                                    callback: {
//                                        message: 'Please choose the progress status of Task',
//                                        callback: function (value, validator, $field) {
//                                            // Get the selected options
//                                            var options = $(".completed_val").val();
//                                            return (options != null);
//                                        }
//                                    }
//                                }
//                            },
//                            efforts: {
//                                validators: {
//                                    regexp: {
//                                        regexp: /^[0-9]+$/,
//                                        message: 'Efforts can only consist consist given numerals 0-9'
//                                    },
//                                    stringLength: {
//                                        min: 1,
//                                        max: 3,
//                                        message: 'Maximum 3 digits alllowed in Efforts'
//                                    }
//                                }
//                            }
//                        }
//                    });

                        function delme(that)
                        {
                            var attach_id = $(that).parent("div").attr("attach_id");
                            console.log(attach_id);

                            if (attach_id != "")
                            {
                                $.ajax({
                                    url: "<?php echo base_url() . "tms/manage_sub_task/delete_subTask_document" ?>",
                                    type: 'POST',
                                    data: "attach_id=" + attach_id,
                                    dataType: 'json',
                                    success: function (data, textStatus, jqXHR) {
                                        if (data['success'])
                                        {
                                            $("div.fileUploaded[attach_id='" + attach_id + "']").remove();

                                        }


                                    }
                                });
                            }
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

                        function change_task_status() {
                            $("select[name=updated_progress_flag]").parent("div").toggleClass("hidden");
                        }

                        function update_progress_flag() {
                            var tstm_id = $("#reply_form").find("input[type='hidden'][name='tstm_id']").val();
                            var flag = $("select[name=updated_progress_flag]").val();
                            var reason = $("input[name=reason_to_change]").val();
                            $.ajax({
                                url: "<?php echo base_url() . "tms/manage_sub_task/updateSubTaskStatus" ?>",
                                type: 'POST',
                                data: "tstm_id=" + tstm_id + "&progress_flag="+flag+"&reason="+reason,
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {
                                     if(data.succ){
                                         alert("Thanks status has been updated successfully!");
                                         location.href = location.href; 
                                     }else{
                                         alert(data._err_codes);
                                     }
                                }
                            });
//                            console.log(tstm_id);
                        }
</script>