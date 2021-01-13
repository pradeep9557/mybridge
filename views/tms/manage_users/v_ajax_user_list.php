<br>
<div class="SelectAllAction pull-left">
    <button class="btn btn-danger" type="button" onclick="deactiveAll(0)">De-Activate All</button>

</div>
<div class="table-responsive">
    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
        <thead>
            <tr>
                <th><input type="checkbox" class="selectAll">S.No</th> 
                <th>Name</th>
                <th>Username</th>
                <?php if ($this->util_model->get_utype() == PARTNER || $this->util_model->get_utype() == DIRECTOR) { ?>
                    <th>Password</th>
                <?php }
                ?>
                <th>User Type</th>
                <th>Status</th>
                <th>Add User</th>
                <th>Modified</th>
                <th>Edit</th> 
            </tr> 
        </thead>
        <tbody>
            <?php
            $i = 0;
//                            $this->util_model->printr($all_emp_details);
            foreach ($all_emp_details as $Emp_List) {
                if ($Emp_List->UTID != 10) {
                    ?>
                    <tr class="odd gradeX">
                        <td><input type="checkbox" class="check_box" value="<?php echo $Emp_List->Emp_ID ?>"><?= ++$i ?></td>

                        <td><?= $Emp_List->Emp_Name ?></td>
                        <td><?= $Emp_List->UserName ?></td>
                        <?php if ($this->util_model->get_utype() == PARTNER || $this->util_model->get_utype() == DIRECTOR) { ?>
                            <th title="Click to toggle Password">
                                <input type="password" value="<?php echo $this->util_model->decrypt_string($Emp_List->Emp_Pass) ?>" class="toggle_pass" readonly/>
                            </th>   
                        <?php }
                        ?>
                        <td><?= $Emp_List->UserTypeName ?></td>
                        <td><?= $Emp_List->Status ? "Enable" : "Disable" ?></td>
                        <td><?= $Emp_List->Add_UserCode ?></td>
                        <td><?php echo date(DF, strtotime($Emp_List->Mode_DateTime)); ?></td>
                        <td><form>
                                <a href="<?= base_url() ?>tms/manage_users/<?php echo $addr . "/" . $Emp_List->Emp_ID ?>"><button type="button" name="Edit_Employee" title="Edit Basic Details" value="Edit" class="btn btn-success btn-xs">
                                        <span class="glyphicon glyphicon-edit"></span> 
                                    </button>
                                </a>
        <!--                                                <a href="<?= base_url() ?>employee/document_attach/<?= $Emp_List->UserName ?>" title="Edit or View Documents and other details" target="_blank">
                                    <button type="button" name="Edit_Employee" value="Edit" class="btn btn-info btn-xs">
                                        <span class="glyphicon glyphicon-paperclip"></span>
                                    </button>
                                </a>-->
                                <input type="hidden" name="_key" value="del_Emp_Code"/>
                                <input type="hidden" name="_title"  value="User"/>
                                <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Emp_List->UserName) ?> User ?? All the details related to this user will be deleted!!" name="_msg"/>
                                <input type="hidden" value="<?= $Emp_List->UserName ?>" name="UserName"/>
                                <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                    <span class="glyphicon glyphicon-trash"></span> 
                                </button>
                            </form>
                        </td>

                    </tr>
                    <?php
                }
            }
            ?>


        </tbody>
    </table>
</div>

<!--<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.responsive.min.js" type="text/javascript"></script>-->
<script>
    $(document).ready(function () {
        $(".SelectAllAction").hide();
    });

    function deactiveAll(action) {
        if (confirm('Are you sure you want de-active all ?')) {
            var form_data = {'emp_id': [], 'type': 'deactive'};
            $(".check_box").each(function () {
                if ($(this).prop('checked')) {
                    form_data.emp_id.push($(this).val());
                }
            });


            preloader.on();
            $.ajax({
                url: "<?php echo base_url() . 'tms/' ?>manage_users/index",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        sweetAlert("De-Activated!!", result._err_codes, "success", 3000, false);

                    } else {
                        sweetAlert("Oops...", result._err_codes, "error");
                    }
                    preloader.off();
                }
            });
        }
    }
    $(".selectAll").on('click', function () {
        $(".check_box").prop('checked', $(this).prop('checked'));
        checkBulkAction();
    });

    $(".check_box").on('click', function () {
        checkBulkAction();
    });

    function checkBulkAction() {
        if ($(".check_box:checked").length > 1) {
            $(".SelectAllAction").show();
        } else {
            $(".SelectAllAction").hide();
        }
    }
</script>