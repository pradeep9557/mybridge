<link href="http://mybridge.local/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="http://mybridge.local/js/jquery-1.11.0.js" type="text/javascript"></script>    
<link href="<?= base_url() ?>js/sweetalert/lib/sweet-alert.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/sweetalert/lib/sweet-alert.js" type="text/javascript"></script>
<form action="http://mybridge.local/tms/manage_tasks/upload_files" id="daily_task_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    
<?php
$i = 1;
foreach ($my_tasks as $value) {
    //print_r($value);
    ?>
    <input type="hidden" name="tm_code" value="<?php echo $value['tm_id'];  ?>">
    <input type="hidden" name="client_id" value="<?php echo $value['client_id'];  ?>">
    <input type="hidden" name="state_id" value="<?php echo $value['state_id'];  ?>">
    <table style="border: 1px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 20px;">
        <tr>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;" colspan="7">Main Task</th>
        </tr>
        <tr>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">S.no</th>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Task Name</th>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Total Sub Tasks</th>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Client Name</th>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">In charge</th>
            <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Progress/Completion</th>
        </tr>
        <tr>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $i++ ?></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $value['tm_name'] ?></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $value['total_sub_task'] ?></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $value['client_name'] ?></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $value['Incharge_name'] ?></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?php echo $value['progress_flag'] == COMPLETED_REQUEST ? "Completed" : "In Progress" ?></td>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Remarks</th>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;font-style: italic;" colspan="5">
                <?php echo $value['extra_note'] ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"></td>
            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;" colspan="7">
                <table style="border: 1px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 20px;">
                    <tr>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;" colspan="7">Sub Tasks</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">S.no</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Sub Task Name</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Assigned to</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Progress/Completion</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Start Date</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">End Date</th>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Efforts</th>
                        <?php if($landingPage){?>
                        <th style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;">Upload Files</th>
                        <?php } ?>
                    </tr>
                    <?php
                    $j = 1;
                    $total_efforts = 0;
                    foreach ($value['sub_task_data'] as $sub_task) {
                        $total_efforts += $sub_task['tstm_efforts'];
                        $tstm_id = $sub_task['tstm_id'];
                        ?>
                        <tr>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $j++ ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $sub_task['tstm_name'] ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $sub_task['Emp_Name'] ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "Completed" : "In Progress" ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= date("F j, Y, g:i a", strtotime($sub_task['str_date_time'])) ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= date("F j, Y, g:i a", strtotime($sub_task['end_date_time'])) ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?php echo $sub_task['tstm_efforts'] . " Hours" ?></td>
                            <?php if($landingPage){?>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><div style="width:50%; float:left;">
                                            <input type="file" multiple="" name="attach_name[<?php echo $tstm_id;?>][]">
                                        </div>
                                        <div style="width:50%; float:left;">
                                            <select name="fileType[<?php echo $tstm_id;?>][]">
                                                <option value="">Select FileType</option>
                                                <option value="Input file">Input file</option>
                                                <option value="Working file">Working file</option>
                                                <option value="File  Report">Final Report</option>
                                            </select>
                                            
                                        </div></td><?php } ?>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="6">

                        </td>
                        <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;">Total Efforts : <?= $total_efforts . " Hours" ?></td>
                        <?php if($landingPage){?>
                        <td><button type="submit" class="btn btn-success btn-md action" id="action_sub">
                                    <span class="glyphicon glyphicon-oppy-disk"></span> Save Work Description
                                </button>
                        </td>
                        <?php } ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php } ?>
</form> 
<script>
$(document).on("ready", function () {
            $("#daily_task_form").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: $(this).attr("action"),
                    method: "POST",
                    success: function (result) {
                        console.log(result);
                        if (result.succ) {
                            swal({
                                title: "Done!",
                                text: result._err_codes,
                                type: "success",
                                timer: 1000
                            });  
                        } else {
                            sweetAlert("Oops...", result._err_codes, "error");
                        }
                    }
                });
            });
        });
</script>