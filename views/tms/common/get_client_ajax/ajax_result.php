<div class="row">  <div class="col-lg-12">
        <h5> Search Result</h5>
        <hr>
    </div>

    <div class="col-lg-12">

        <div class="table-responsive">
            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="ajax_task_list">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th> 
                        <th>Username</th>
                        <th>Status</th>
                        <th>Password</th>
                        <th>User Type</th>
                        <th>Add User</th>
                        <th>Modified</th>
                        <th>Action</th>
<!--<th>Last Modified</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($client_list as $each_client) {
                        ?>
                        <tr class="odd gradeX">
                            <td><?= ++$i ?></td>
                            <td><?php echo $each_client->Emp_Name ?></td>
                            <td><?= $each_client->UserName ?></td>
                            <td><?= $each_client->Status?'Enable':'Disable' ?></td>
                            <?php if (1 && $this->util_model->get_utype() == PARTNER || $this->util_model->get_utype() == DIRECTOR) { ?>
                                <th title="Click to toggle Password">
                                    <input type="password" value="<?php echo $this->util_model->decrypt_string($each_client->Emp_Pass) ?>" class="toggle_pass" readonly/>
                                </th>   
                            <?php }
                            ?>
                            <td><?= $each_client->UserTypeName ?></td>
                            <td><?= $each_client->Add_UserCode ?></td>
                            <td><?php echo date(DF, strtotime($each_client->Mode_DateTime)); ?></td>
                            <td>
                                <form>
                                    <a href="<?= base_url() ?>tms/manage_users/<?php echo $addr . "/" . $each_client->Emp_ID ?>"><button type="button" name="Edit_Employee" title="Edit Basic Details" value="Edit" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-edit"></span> 
                                        </button>
                                    </a>
    <!--                                                <a href="<?= base_url() ?>employee/document_attach/<?= $each_client->UserName ?>" title="Edit or View Documents and other details" target="_blank">
                                        <button type="button" name="Edit_Employee" value="Edit" class="btn btn-info btn-xs">
                                            <span class="glyphicon glyphicon-paperclip"></span>
                                        </button>
                                    </a>-->
                                    <input type="hidden" name="_key" value="del_Emp_Code"/>
                                    <input type="hidden" name="_title"  value="<?php "Client" ?>"/>
                                    <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($each_client->UserName) ?> <?php "Client" ?> ?? All the details related to this user will be deleted!!" name="_msg"/>
                                    <input type="hidden" value="<?= $each_client->UserName ?>" name="UserName"/>
                                    <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
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

    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
<script>
    $(".toggle_pass").on("click", function () {
        $(this).attr("type", "text");
    });
</script>


