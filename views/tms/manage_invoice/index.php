<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">Generate Invoices</h4>
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
            <h3 class="panel-title toggle_custom"><?php echo (isset($bill_data) && !empty($bill_data)) ? "Edit Bill Form" : "Generate Bill Form" ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/invoice_mst/generate_invoices', "id='generate_invoices'");
            ?>
            

            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bill Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
//                        $this->util_model->printr($client_list);
                        echo form_dropdown("billType", $BillTypes, (isset($bill_data) && $bill_data['client_id'] != "") ? $bill_data['client_id'] : 0, "class='form-control chosen-select client_list' ") ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
//                        $this->util_model->printr($client_list);
                        echo form_dropdown("client_id", $client_list, (isset($bill_data) && $bill_data['client_id'] != "") ? $bill_data['client_id'] : 0, "class='form-control chosen-select client_list' ") ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bills to Generate<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
//                        $this->util_model->printr($client_list);
                        echo form_multiselect("bills_ids[]", array(), (isset($bill_data) && $bill_data['bills_ids'] != "") ? $bill_data['bills_ids'] : 0, "class='form-control chosen-select bills_ids_list' ") ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">
                    <button class="btn btn-success">Generate Invoices</button>
                </div>
            </div>
        </div>

    </div>
 
</div>
<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
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


    $(".client_list").change(function () {
        if ($(this).val() != 0) {
            preloader.on();
            $.ajax({
                url: get_base_url() + "tms/invoice_mst/filter_bills_by_client",
                method: "POST",
                data: "client_id=" + $(this).val(),
                dataType: "json",
                success: function (result) {
                    $('.bills_ids_list').empty();
                    if (result.succ) {
                        $('.bills_ids_list').html($('<option>').text("Select Bills").attr('value', 0));
                        $.each(result.list_data, function (i, value) {
                            $('.bills_ids_list').append($('<option>').text(value.option_text).attr('value', value.bill_mst_id));
                        });
                    } else {
                        $('.bills_ids_list').html($('<option>').text("No any bill found againest this client").attr('value', 0));
                    }
                    $(".chosen-select").trigger("chosen:updated");
                    preloader.off();
                }
            });
        } else {
            $('.bills_ids_list').html($('<option>').text("Select Task").attr('value', 0));
        }
    });
    $(document).on("ready", function () {
//        t_init("textarea.tinymce");
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
                        window.location = (get_base_url() + "tms/manage_bills");
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
