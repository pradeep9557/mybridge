<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <?php
        if (isset($error)) {
            $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
        }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $task_search_view;
            ?>
        </div>
    </div>
    <div class="task_detail_container">
        <?php
        echo $task_html;
        ?>
    </div>
</div>

<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>
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
    
    $(document).ready(function(){
        search_task_data();
    });
</script>