<div class="row">
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs text-center">
        <?php if ($this->session->userdata['IBMS_USER_PRO_PIC'] != "") { ?>
            <img src="<?= base_url() . 'img/Employee_Data/Employee_pic_and_sign/' . $this->session->userdata['IBMS_USER_PRO_PIC'] ?>" class="circle_img" alt="Cinque Terre" style="float: left"> 
        <?php } else { ?>
            <img src="<?= base_url() . 'img/Employee_Data/Employee_pic_and_sign/default-avatar.png' ?>" class="circle_img" alt="Cinque Terre" style="float: left"> 
        <?php }
        ?>
<!--<img class="img-circle img-responsive" src="<?php echo base_url() ?>img/Employee_Data/Employee_pic_and_sign/">-->
    </div>
    <div class="col-lg-11 col-md-10 col-sm-10">
        <div class="row bottom_gap">
            <div class="col-lg-12 col-md-12 col-sm-12">Work Done Description(<span class="text-danger">*</span>)</div>
        </div> <!--End of row-->
        <div class="row bottom_gap"> 
            <div class="col-lg-12 col-md-12 col-sm-12">
                <textarea id="tinymce1" name="comment" rows="2" class="col-lg-12" aria-hidden="true">
                </textarea>
            </div>
        </div> <!--End of row--> 
        <div class="row bottom_gap"> 
            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Progress Flag</div>
            <div class="col-lg-4 col-md-4 col-sm-8">
                <div class="form-group">
                    <?php
                    echo form_dropdown("progress_flag", $all_progress_flags, 2, "class='form-control  pg_flag'");
                    ?>
                </div>
<!--                    <select name="progress_ag" class="form-control  pg_ag">
                    <option value="0" selected="">Select</option>
                    <option value="2">Hold</option>
                    <option value="3">In Progress</option>
                    <option value="5">Resolve</option>
                </select>-->
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Efforts</div>
            <div class="col-lg-4 col-md-4 col-sm-8">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">In Hours</span>
                        <input type="text" name="efforts" class="form-control" placeholder="e.g 3"  maxlength="3">
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
                        echo form_dropdown("completed", $all_completion_status, 0, "class='form-control  completed_val'");
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
            </div>
        </div> <!--End of row-->

        <div class="row bottom_gap"> 
            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Work Date & Time: </div>
            <div class="col-lg-4 col-md-4 col-sm-8">
                <div class='input-group date bdatetimepicker'>
                    <input type='text' class="form-control" id="work_datetime" name="work_datetime" value="<?php echo date("d-m-Y h:i A", time()) ?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
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
            <!--                <div class="cb"></div>
                            <div class="lbl-font16 "></div>
                            <div id="mem22"> -->
        </div> 

        <div class="row bottom_gap"> 
            <div class="col-lg-12">
                <button type="submit" class="btn btn-success btn-md action" id="action_sub">
                    <span class="glyphicon glyphicon-oppy-disk"></span> Save Work Description
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
                "advlist autolink autosave link  lists charmap spellchecker",
                "searchreplace wordcount      media ",
                " contextmenu directionality emoticons  textcolor paste textcolor colorpicker textpattern"
            ],
            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify  | searchreplace | bullist numlist | outdent indent blockquote | media | forecolor backcolor | subscript superscript | charmap emoticons",
            menubar: false,
            toolbar_items_size: 'small',
            spellchecker_rpc_url: 'spellchecker.php'
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