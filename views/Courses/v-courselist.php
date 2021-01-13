<!--
<div class="form-group" >
<?php echo form_dropdown("CourseCode[]", $CourseList, "", "class='form-control chosen-select'") ?>
           
            </div>-->

<?php
$randno = rand(0, 5999999);
echo form_open("#","id='e_visit_course_edit" . $randno . "'");
?>
<div class="row">
    <div class="col-lg-10 bottom_gap">
        <?php
        echo form_hidden("E_Code", $E_Code);
        echo form_hidden("Visit", $Visit);
        echo form_dropdown("CourseID", $All_Course_List, '', "class='form-control chosen-select' ");
        ?>
    </div>
    <div class="col-lg-2 bottom_gap">
        <button class="btn btn-success" type="button" onclick="add_delete_update_e_course('e_visit_course_edit<?= $randno ?>','add','<?=base_url() . "Enquiry/enquiry/e_course_add"?>',this)">
            <span class="glyphicon glyphicon-floppy-save"></span>
        </button>
        <button class="btn btn-danger" type="button" onclick="add_delete_update_e_course('e_visit_course_edit<?= $randno ?>','delete','<?=base_url() . "Enquiry/enquiry/e_course_delete"?>',this)">
            <span class="glyphicon glyphicon-minus"></span>
        </button>
    </div>
</div>
<?php echo form_close(); ?>

<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>