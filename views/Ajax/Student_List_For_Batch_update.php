<div class="col-lg-12" style="margin: 5px 0px;">
    <?php
    echo form_open(base_url() . 'batch_master/batch_save_update', $attributes);
    ?>
    <span class="add-on input-group-addon" onclick="hide_this('<?= $id_of_result ?>')"><i class="glyphicon glyphicon-minus fa fa-minus"></i></span>
    <div class="panel-body">
        <div class="table-responsive">

            <table class="table table-striped table-bordered table-hover capitalized_word" id="<?= $table_id ?>">
                <thead>
                    <tr>
                        <td>S.No</td>
                        <td>EnrollNo</td>
                        <td>Name</td>
                        <td>Course</td>
                        <td>Faculty</td>           
                        <td>Batch</td>      
                        <td>Status</td>      
                        <td>Add/Mode User</td>
                        <td><input type="checkbox" class="<?= $table_id ?>head_checkbox"/> Action
                        </td>
                    </tr>
                </thead>               
                <?php
                $i = 1;
                if (isset($Query_Result)) {
                    ?>

                    <?php
                    foreach ($Query_Result as $row) {
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row->EnrollNo ?></td>
                            <td><?= $row->StudentName ?></td>
                            <td><?= $row->CourseCode ?></td>
                            <td><?= $row->FacultyCode ?></td>
                            <td><?= $row->BatchCode ?></td>
                            <td><?= $row->Status ?></td>
                            <td><?= $row->Add_User . "/" . $row->Mode_User ?></td>
                            <td>
                                <input type="checkbox" value="<?= $row->EnrollNo ?>_____<?= $row->CourseCode ?>" name="has_to_update[]" class="<?= $table_id ?>_checkbox"/>check

                            </td>
                        </tr>
                        <?php
                    }
                } else { ?>
<!--                    <tr><td>S.No</td>
                        <td>EnrollNo</td>
                        <td>Name</td>
                        <td>Course</td>
                        <td>Faculty</td>           
                        <td>Batch</td>      
                        <td>Status</td>      
                        <td>Add/Mode User</td>
                        <td><input type="checkbox" class="<?= $table_id ?>checkbox"/> Action
                        </td></tr>-->
             <?php 
               }  ?>
            </table>
            <div class="row">

            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h5 class="page-header ">Update Students Batch</h5>    
        <div class="row">
            <div class="col-lg-2">Faculty Code</div>
            <div class="col-lg-4">
                <?php
                echo form_dropdown("FacultyCode", $All_Faculty_Code, '', "class='form-control Get_batches' result_cls='" . $table_id . "batchesresult" . "' id='FacultyCode'");
                ?> 
            </div>
            <div class="col-lg-2">Batch Code</div>
            <div class="col-lg-4">
                <?php
                echo form_dropdown("BatchCode", array("<-- Select Faculty Code -->"), '', "class='form-control " . $table_id . "batchesresult" . "' id='BatchCode'");
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">Batch Status</div>
            <div class="col-lg-4">
                <?php
                echo form_dropdown("scnb_status", $All_Batch_Status, 'RUNNING', "class='form-control' id='FacultyCode'");
                ?> 
            </div>
            <div class="col-lg-2">User</div>
            <div class="col-lg-4">
                <?php
                echo form_input("Mode_User", "{$Session_Data['IBMS_USER_ID']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
                echo form_hidden("Company", "NA");
                echo form_hidden("Branch", "NA");
                ?>  

            </div>
            <div class="col-lg-12 padding_top_label padding_left">
                <input type="hidden" name="_key" value="add_del_update_batch"/>
                <input  type="hidden" value="Are you Sure ??" name="_msg"/>
                <div class="row">
                    <button type="button" name="admission_submit" confrim_btn_value="Yes, Update Them !!" _action="Update" value="Are you Sure, Wanna Update Batches For " class="btn btn-info btn-md ajax_batch_update<?= $table_id ?>">
                        <span class="glyphicon glyphicon-subtitles"></span> Update
                    </button>
<!--                    <button type="button" name="admission_submit" confrim_btn_value="Yes, Add Them !!" _action="Add" value="Are you Sure, Wanna Add Batches For " class="btn btn-success btn-md ajax_batch_update<?= $table_id ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add
                    </button>
                    <button type="button" name="admission_submit" confrim_btn_value="Yes, Delete Them !!" _action="Delete" value="Are you Sure, Wanna Delete Batches For " class="btn btn-danger btn-md ajax_batch_update<?= $table_id ?>">
                        <span class="glyphicon glyphicon-trash"></span> Del
                    </button>-->
                    <button type="reset" name="Reset" value="Reset" class="btn btn-bitbucket btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>
            </div>
        </div>
        <?php
        form_close();
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#<?= $table_id ?>').dataTable({
            "aLengthMenu": [[15, 25, 50, 100], [15, 25, 50, 100]],
            "iDisplayLength": 50
        });
        $(".<?= $table_id ?>head_checkbox").click(function() {
            var checkboxes = $(".<?= $table_id ?>_checkbox");
            if ($(this).prop("checked")) {
                checkboxes.prop("checked", false);
            }
            checkboxes.prop("checked", !checkboxes.prop("checked")).parent().parent().children('td').css({
                "background": (!checkboxes.prop("checked") ? "white" : "rgb(66, 139, 202)"),
                "color": (!checkboxes.prop("checked") ? "black" : "white")
            }).parent().parent().toggleClass('table-striped');
        });
    });
    $(".<?= $table_id ?>_checkbox").click(function() {
        var checkbox = $(this);
        $(checkbox).parent().parent().children('td').css({
            "background": (!$(checkbox).prop("checked") ? "white" : "rgb(66, 139, 202)"),
            "color": (!$(checkbox).prop("checked") ? "black" : "white")
        });
    });

</script>

<script type="text/javascript">
    var form_data;
    $(function() {
        $(".ajax_batch_update<?= $table_id ?>").click(function() {
            form_data = $(".<?= $table_id ?>").serialize();
            //var _msg = (form_data.find('input[name="_msg"]')).val();
            var no_of_effected_students = $(".<?= $table_id ?>_checkbox:checked").length; // will come after counting selected students
            var _msg = $(this).val() + no_of_effected_students + " students ??";
            //var del_id = element.attr("id");
            //var info = 'faqid=' + del_id;
            var btn_title = $(this).attr("confrim_btn_value");
            var _action = $(this).attr("_action");
            swal({
                title: "Are you sure?",
                text: _msg,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: btn_title,
                cancelButtonText: "No, cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>Ajax/delete",
                        data: form_data + "&_action=" + _action,
                        dataType: "json",
                        success: function(result) {
                            if (result['success']) {
                                swal("Successfully Done!", "Action Successfully Done!", "success");
                                form_data.parents().parents('tr').animate({backgroundColor: "#fbc7c7"}, "slow", function() {
                                    $(this).remove();
                                });
                            } else {
                                var _err_msg = result['_err_msg'];
                                if (_err_msg != "")
                                    swal("Cancelled", _err_msg, "error");
                                else
                                    swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                            }
                            //                            .animate({opacity: "hide"}, "slow").remove();
                        }
                    });
                } else {
                    swal("Cancelled", "Your Students  are Safe :)", "error");
                }
            });
        });
    });

    $(".Get_batches").change(function() {
        var faculty_code = $(this).val();
        var curr_this = $(this);
        var page = "<?= base_url() ?>Ajax/Get_Batches_of_Faculty?Faculty_Code=" + faculty_code;
        $.ajax({
            type: "POST",
            url: page,
            //data: "Faculty_Code ="+faculty_code,
            datatype: "html",
            success: function(result) {
                $("." + $(curr_this).attr('result_cls')).html(result);
            }});
    });
</script>



