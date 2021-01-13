<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">Finalize Bills</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>

        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php echo 1 ? "Finalize Bill Form" : "Edit Bill Form" ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_bills/finalize_bill_save_update', "id='bill_save_update_form'");
            ?>
            <?php if (isset($bill_data) && !empty($bill_data)) { ?>
                <input type="hidden" name="action_performed" value="update" />
                <input type="hidden" name="bill_id" value="<?= $bill_data['bill_id'] ?>" />
            <?php } else { ?>
                <input type="hidden" name="action_performed" value="save" />
            <?php }
            ?>

            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_dropdown("client_id", $client_list, (isset($bill_data) && $bill_data['client_id'] != "") ? $bill_data['client_id'] : 0, "class='form-control chosen-select client_list' ") ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bills Generated<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_dropdown("bill_mst_id", (isset($bill_list) && !empty($bill_list)) ? $bill_list : array("0" => "Select a Client First"), (isset($bill_data) && $bill_data['bill_mst_id'] != "") ? $bill_data['bill_mst_id'] : 0, "class='form-control chosen-select bill_list' ") ?>   
                    </div> 
                </div>
                <!-- /input-group -->               

            </div> <!--End of row-->
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Status</div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_dropdown("status", array("1" => "Active", "2" => "Cancelled", "0" => "Deleted"), (isset($bill_data) && $bill_data['status'] != "") ? $bill_data['status'] : 1, "class='form-control' ") ?>   
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bill amount<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("amt_paid", (isset($bill_data['amt_paid']) && $bill_data['amt_paid'] != "") ? $bill_data['amt_paid'] : "", array("class" => "'form-control popover_element1'", "placeholder" => "'Bill Amount'")) ?>
                    </div> 
                </div>
            </div> <!--End of row-->

            <div class="row bottom_gap">
                <div class="col-lg-12 padding_top_label">Remarks</div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <?php echo form_textarea("remarks", (isset($bill_data['remarks']) && $bill_data['remarks'] != "") ? $bill_data['remarks'] : "", array("class" => "'form-control tinymce'", "placeholder" => "'Extra Notes for Bill'", "maxlength" => "500")) ?>
                    </div>
                </div>
            </div> <!--End of row-->

            <div class="row">
                <?php if (isset($bill_data) && !empty($bill_data)) { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Update", array("class" => "'btn btn-success update'")); ?>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Create", array("class" => "'btn btn-success save'")); ?>
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
    $Curr_Obj = & get_instance();
    $Curr_Obj->All_finalize_bill_List();
    ?>
</div>
<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/chosen.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/moment.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>
<script>
    function init() {
        $(document).unbind(".bdatetimepicker .assignedto .remove_sub_task");
        $('.bdatetimepicker').datetimepicker({
            format: 'DD-MM-YYYY hh:mm A',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
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
                "advlist autolink autosave link  lists charmap  spellchecker",
                "searchreplace wordcount      media ",
                " contextmenu directionality emoticons  textcolor paste textcolor colorpicker textpattern"
            ],
            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | searchreplace | bullist numlist | outdent indent blockquote | media | forecolor backcolor | subscript superscript | charmap emoticons",
            menubar: false,
            toolbar_items_size: 'small'
        });
    }

    $(".client_list").change(function () {
        if ($(this).val() != 0) {
            preloader.on();
            $.ajax({
                url: get_base_url() + "tms/manage_bills/filter_bill_by_client",
                method: "POST",
                data: "client_id=" + $(this).val(),
                dataType: "json",
                success: function (result) {
                    $('.bill_list').empty();
                    if (result.succ) {
                        $('.bill_list').html($('<option>').text("Select").attr('value', 0));
                        $.each(result.data, function (i, value) {
                            $('.bill_list').append($('<option>').text(value.bill_number).attr('value', value.bill_mst_id));
                        });
                    } else {
                        $('.bill_list').html($('<option>').text("Select a Client First").attr('value', 0));
                    }
                    $(".chosen-select").trigger("chosen:updated");
                    preloader.off();
                }
            });
        } else {
            $('.task_list').html($('<option>').text("Select a Client First").attr('value', 0));
        }
    });
    $(document).on("ready", function () {
        t_init("textarea.tinymce");
        init();
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
    });
    function display_msg($_data) {
        var err_msg = "";
        $.each($_data, function (i, value) {
            err_msg += value + "\n";
        });
        return err_msg;
    }

    $("#bill_save_update_form").on("submit", function (e) {
        e.preventDefault();
        preloader.on();
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function (result) {
                var msg = display_msg(result._err_codes);
                if (result.succ) {
                      swal({
                                        title: "Done!",
                                        text: msg,
                                        type: "success",
                                        timer: 1000
                                    });
                    setTimeout(function () {
                        window.location = (get_base_url() + "tms/manage_bills/finalize_bill/" + result.id);
                    }, 2000);
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
    });



</script>
