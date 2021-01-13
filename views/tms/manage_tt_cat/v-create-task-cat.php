
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Main Task Category Form</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row " id="add_all_tt_cat">
        <div class="col-lg-4">
            <div class="panel panel-primary margin_top_20px">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Task Category Form<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <div class="panel-body collapse" id="collapseExample">   
                    <?php
                    echo form_open(base_url() . "tms/manage_tt_p_cat/insert_db", "id='create_task_cat_form' class='check_valid'");
                    ?>
                    <div class="col-lg-12 bottom_gap">
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Name </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <?php echo form_input("ttm_name", "", array("id" => "category_name", "class" => "'form-control insert_category_name popover_element1'", "data-content" => "'Category Name required,   max 150 characters'", "placeholder" => "'Name'", "maxlength" => "150")) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Category Code </div>
                            <div class="col-lg-8">
                                <div class="form-group" id="c_state">
                                    <?php echo form_input("ttm_code", "", array("id" => "category_code", "class" => "'check_already_exits db_category_code form-control'", "placeholder" => "'Category Code'", "maxlength" => "15", "checking_id" => 12)) ?>

                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Status</div> 
                            <div class="col-lg-8">
                                <?php
                                $options = array(
                                    '1' => 'Enable',
                                    '0' => 'Disable',
                                );
                                echo form_dropdown('Status', $options, '', 'class="form-control" placeholder="Status" ');
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-12">
                            <button type="submit" value="Save" class="btn btn-success btn-md tt_cat">
                                <span class="glyphicon glyphicon-floppy-disk"></span> Save
                            </button>
                            <button type="reset" value="Save" class="btn btn-success btn-md" onclick="$('.check_valid').data('bootstrapValidator').resetForm();">
                                <span class="glyphicon glyphicon-refresh"></span> Reset
                            </button>
                        </div>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div> 


        <div class="col-lg-8">  
            <div class="panel panel-primary margin_top_20px">
                <div class="panel-heading">
                    <h3 class="panel-title">Main Task Category List</h3>
                </div>
                <div class="panel-body " id=""> 
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-tt-cat">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($taskCatList as $List) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= ++$i ?></td>
                                            <td><?= $List->ttm_name ?></td>
                                            <td><?= $List->ttm_code ?></td>
                                            <td><?= ($List->status) ? "Enable" : "Disabled" ?></td>

                                            <td>
                                                <form>
                                                    <button type="button"   class="btn-xs btn btn-success edit_btn_ttc" id="edit_btn_ttc" title="<?= mysql_real_escape_string($List->ttm_id) ?>">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </button>
                                                    <input type="hidden" name="_key" value="del_tt_id"/>
                                                    <input type="hidden" name="_title" value="task-type-category"/>
                                                    <input  type="hidden" value="You want to delete this Task-Type Category !!" name="_msg"/>
                                                    <input type="hidden" value="<?= $this->util_model->url_encode($List->ttm_id) ?>" name="ID"/>
                                                    <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_tt_update">
                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div><!--
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <!-- /.col-lg-12 -->
    </div>
    <!--edit form-->
    <div class="row">
        <div class="col-lg-4 hidden" id="edit_form">
            <div class="panel panel-primary margin_top_20px">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Edit Category Form</h3>
                </div>
                <div class="panel-body" id="">   
                    <?php
                    echo form_open("", "id='edit_task_cat_form' class='check_valid'");
                    ?>
                    <div class="col-lg-12 bottom_gap">
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Name </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <?php echo form_input("ttm_name", "", array("id" => "category_name", "class" => "'form-control  popover_element1'", "data-content" => "'Category Name required,   max 150 characters'", "placeholder" => "'Name'", "maxlength" => "150")) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Category Code </div>
                            <div class="col-lg-8">
                                <div class="form-group" id="c_state">
                                    <?php echo form_input("ttm_code", "", array("id" => "category_code", "class" => "'form-control  popover_element1'", "data-content" => "'Category Code required,   max 15 characters'", "placeholder" => "'Category Code'", "maxlength" => "15")) ?>

                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-4">Status</div> 
                            <div class="col-lg-8">
                                <?php
                                $options = array(
                                    '1' => 'Enable',
                                    '0' => 'Disable',
                                );
                                echo form_dropdown('Status', $options, '', 'class="form-control" placeholder="Status" ');
                                ?>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-offset-4 col-lg-8">
                                <button type="button" value="Save" class="btn btn-success btn-md" name="update_btn_ttc" id="update_btn_ttc" _id="">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Update
                                </button>

                                <button type="button" class="btn btn-danger btn-md" name="update_btn_ttc" onclick="$('#edit_form').addClass('hidden');
                                        $('#add_all_tt_cat').removeClass('hidden')">
                                    <span class="glyphicon glyphicon-remove"></span> Cancel
                                </button>
                            </div>
                        </div>
                    </div> 


                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div> 
    </div>
</div>

<script src="<?= CDN1 ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
                                    $('.check_valid').bootstrapValidator({
                                        feedbackIcons: {
                                            valid: 'glyphicon glyphicon-ok',
                                            invalid: 'glyphicon glyphicon-remove',
                                            validating: 'glyphicon glyphicon-refresh'
                                        },
                                        fields: {
                                            ttm_name: {// field name
                                                validators: {
                                                    notEmpty: {
                                                        message: 'Name is required and can\'t be left empty'
                                                    },
                                                    regexp: {
                                                        regexp: /^[a-zA-Z0-9()\s_-]+$/,
                                                        message: 'Name can only consist given alphabets a-zA-Z0-9_- or space'
                                                    },
                                                    stringLength: {
                                                        min: 3,
                                                        max: 150,
                                                        message: 'Name must be more than 3 characters long'
                                                    }
                                                }
                                            }, ttm_code: {
                                                validators: {
                                                    notEmpty: {
                                                        message: 'Category Code is required and can\'t be empty'
                                                    },
                                                    regexp: {
                                                        regexp: /^[a-zA-Z0-9_]+$/,
                                                        message: 'Task Code can only consist consist given alphabets a-zA-Z0-9_-'
                                                    },
                                                    stringLength: {
                                                        min: 3,
                                                        max: 5,
                                                        message: 'Task Code must be more than 3-5 characters long'
                                                    }
                                                }
                                            }
                                        }

                                    });


                                    $('.edit_btn_ttc').click(function () {
                                        $("#add_all_tt_cat").addClass("hidden");
                                        $("#edit_form").removeClass("hidden");
                                    });

                                    $(".edit_btn_ttc").click(function () {
                                        var id = $(this).attr("title");
                                        preloader.on();
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo CDN1; ?>' + "tms/manage_tt_p_cat/edit_tCat",
                                            data: {'id': id},
                                            dataType: "json",
                                            success: function (result) {
                                                // console.log(result);
                                                $("#edit_task_cat_form").find("input[name=ttm_name]").attr("value", result.ttm_name);
                                                $("#edit_task_cat_form").find("input[name=ttm_code]").attr("value", result.ttm_code);
                                                $("#edit_task_cat_form").find("input[name=Status]").attr("value", result.ttm_status);
                                                $("#edit_task_cat_form").find("button[name=update_btn_ttc]").attr("_id", result.ttm_id);
                                                preloader.off();
                                            }
                                        });
                                    });

                                    $(".insert_category_name").on("blur", function () {
                                        var $_ref = $(this);
                                        preloader.on();
                                        if ($_ref.val() != "") {
                                            $.ajax({
                                                type: "POST",
                                                url: get_base_url() + 'tms/manage_tt_p_cat/get_task_code',
                                                data: 'task_name=' + $_ref.val(),
                                                dataType: "json",
                                                success: function (result) {
                                                    if (result.succ) {
                                                        $(".db_category_code").val(result.code);
                                                        $(".db_category_code").attr("value", result.code);
                                                    } else {
                                                        sweetAlert({
                                                            title: "Oops...",
                                                            text: ">__< Unexpected Error Error Code #07092016_0220",
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

                                    $("#update_btn_ttc").click(function () {
//                                        console.log($("#edit_task_cat_form").serialize());
                                        preloader.on();
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo base_url('tms/manage_tt_p_cat/update_tCat'); ?>',
                                            data: $(this).parents("#edit_task_cat_form").serialize() + '&ttm_id=' + $(this).attr("_id"),
                                            dataType: "json",
                                            success: function (result) { 
                                                if(result.succ){
                                                window.location = '<?php echo CDN1; ?>' + "tms/manage_tt_p_cat/index/" + (result.succ ? "0/" + result._err_codes : "1/" + result._err_codes);
                                            }else{
                                                 sweetAlert({
                                                            title: "Oops...",
                                                            text: ">__< Unexpected Error Error Code #07092016_0221",
                                                            type: "error",
                                                            timer: 2500,
                                                            html: true
                                                        });
                                            }
                                                preloader.off();
                                            }
                                        });
                                    });


                                    $(".ajax_tt_update").click(function () {
                                   
                                        // var action = $(this).val();//Delete
                                        form_data = $(this).parent();
                                        var _msg = form_data.find('input[name="_msg"]').val();
                                        var title = form_data.find('input[name="_title"]').val();
                                        //var del_id = element.attr("id");
                                        //var info = 'faqid=' + del_id;
                                        swal({
                                            title: "Are you sure?",
                                            text: _msg,
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#DD6B55',
                                            confirmButtonText: 'Yes, Delete it!',
                                            cancelButtonText: "No, cancel Please!",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                preloader.on();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo CDN1 ?>Ajax/delete",
                                                    data: form_data.serialize(),
                                                    dataType: "json",
                                                    success: function (result) {
//                        console.log(result);
                                                       
                                                        if (result['success']) {
                                                            
                                                            swal({
                                        title: "Done!",
                                        text: "Your " + title + " has been deleted!",
                                        type: "success",
                                        timer: 1000
                                    });
                                                            form_data.parents().parents('tr').animate({backgroundColor: "#fbc7c7"}, "slow", function () {
                                                                $(this).remove();
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

                                    $(document).ready(function () {
                                        $('#dataTables-tt-cat').DataTable({
                                            responsive: true
                                        });
                                    });
</script>