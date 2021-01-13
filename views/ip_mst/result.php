<br>
<div class="SelectAllAction pull-left">
    <button class="btn btn-danger" type="button" onclick="deleteAll(0)">Delete All</button>

</div>
<div class="table-responsive" >
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <!--<th>S. No.</th>-->
                <th><input type="checkbox" class="selectAll">Id</th>
                <th>System Code</th>
                <th>Requested User</th>
<!--                                <th>Approved By</th>-->
                <th>Status</th>
                <th>Add date and time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($systemCodeList as $row) {
                ?>
                <tr id = "<?php echo $row['id'] ?>">
                    <td><input type="checkbox" class="check_box" value="<?php echo $row['id'] ?>"><?php echo $row['id'] ?></td>
                    <td><?php echo $row['system_code'] ?></td>
                    <td><?php echo $row['requested_user'] ?></td>
                    <td><?php echo $row['status'] ? "Enbaled" : "Disabled" ?></td>
                    <td><?php echo $row['Add_DateTime'] ?></td>
                    <td>
                        <button data-toggle="tooltip" title="Edit" type="button" class="btn btn-<?php echo $row['status'] ? "danger" : "primary"; ?>" onclick="change_status(<?php echo $row['id'] . "," . (!$row['status']) ?>)">
                            <?php echo $row['status'] ? "Disable" : "Enable"; ?>
                        </button>|<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-danger" onclick="del_ip(<?php echo $row['id'] ?>)">
                           Delete
                        </button>

                    </td>
                </tr>


                    <!--//                                echo "<tr id=" + $row['id'] + ">"
                    //                                . "<td>" + $row['id'] + "</td>"
                    //                                . "<td>" + $row['system_code'] + "</td>"
                    //                                . "<td>" + $row['requested_row'] + "</td>"
                    //                                . "<td>" + $row['status'] + "</td>"
                    //                                . "<td>" + $row['Add_DateTime'] + "</td>"
                    //                                . "<td>"
                    //                                . "<a href=" + base_url() + "ip_mst/c_ip/index/" + $row['id'] + ">"
                    //                                . "<button data-toggle='tooltip' title='Edit' type='button' class='btn btn-success' ><i class='glyphicon glyphicon-edit'></i>"
                    //                                . "</button></a>"
                    //                                . "</td>" + " < /tr>";-->

                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $(".SelectAllAction").hide();
    });

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
    function deleteAll(action) {
        if (confirm('Are you sure you want delete all ?')) {
            var form_data = {'log_id': [], 'type': 'del'};
            $(".check_box").each(function () {
                if ($(this).prop('checked')) {
                    form_data.log_id.push($(this).val());
                }
            });


            preloader.on();
            $.ajax({
                url: "<?php echo base_url()?>ip_mst/c_ip/index",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        sweetAlert("Deleted!!", result._err_codes, "success", 3000, false);

                    } else {
                        sweetAlert("Oops...", result._err_codes, "error");
                    }
                    preloader.off();
                }
            });
        }
    }
</script>
