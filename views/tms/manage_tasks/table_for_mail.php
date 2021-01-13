<?php
$i = 1;
foreach ($my_tasks as $value) {
    ?>
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
                    </tr>
                    <?php
                    $j = 1;
                    $total_efforts = 0;
                    foreach ($value['sub_task_data'] as $sub_task) {
                        $total_efforts += $sub_task['tstm_efforts'];
                        ?>
                        <tr>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $j++ ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $sub_task['tstm_name'] ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= $sub_task['Emp_Name'] ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?php echo $sub_task['progress_flag'] == COMPLETED_REQUEST ? "Completed" : "In Progress" ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= date("F j, Y, g:i a", strtotime($sub_task['str_date_time'])) ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?= date("F j, Y, g:i a", strtotime($sub_task['end_date_time'])) ?></td>
                            <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;font-size: 12px;"><?php echo $sub_task['tstm_efforts'] . " Hours" ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td colspan="6">

                        </td>
                        <td style="text-align: center;font-weight: bold;border: 1px solid #E6AD5C;padding: 5px 4px;line-height: 1.42857143;vertical-align: top;">Total Efforts : <?= $total_efforts . " Hours" ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php }
?>