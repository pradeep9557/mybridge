<div class="col-lg-12 bottom_gap">
   
    <h5 class="page-header">Available timings
        <button class="btn btn-xs btn-danger pull-right" onclick="close_timing_panel()">
        <span class="glyphicon glyphicon-off"></span>
    </button>
    </h5>
    <table class="table table-bordered time_mange" id="time_mange">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Days List</th>
                <th>Str Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $s_no = 1;
            foreach ($timings_details as $each_row){ ?>
            <tr>
                <td><?php echo $s_no++; ?></td>
                <td class="days_col">
                    <?php
                    echo $each_row['days_name'];
                    ?>
                <td class="str_time_col">
                     <?php echo date(H24DB_DT,  strtotime($each_row['str_time'])); ?>
                </td>
                <td class="end_time_col">
                     <?php echo date(H24DB_DT,  strtotime($each_row['end_time'])); ?>
                </td> 
            </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>
