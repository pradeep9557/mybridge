<!-- Called via Ajax -->

<div class="table-responsive">
     <div class="row">
        <p style="  padding: 4px 20px;">
            <span class="box blink"> Sort Codes Description </span>
            <span class="box"> RNo: Receipt Number </span>
            <span class="box"> RDate: Receipt Date</span>
            <span class="box"> Paid: Paid Amount </span>
            <span class="box"> W: Weightage </span>
            <span class="box"> S%: Share(in %) </span>
            <span class="box"> SAmt: Share(in Amount) </span>
        </p></div>
    
    <table class="table table-striped table-bordered table-hover capitalized_word fee_record_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Fee Type</th>
                <th>RNo/RDate/Paid</th>
                <th>W/S%/SAmt</th>
                <th>EnrollNo</th>
                <th>StudentName</th>
                <th>FacultyCode</th>
                <th>BatchCode</th>
                <th>CourseCode</th>
                <th>Mobile1</th>
                <th>Addby</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $total_records = count($record);
            $total_amt = 0;

            foreach ($record as $each_record) {
                          ?>
                          <tr class="odd gradeX">
                              <td><?= ++$i ?>.</td>
                              <td><?= $each_record['FeeType_Code'] ?></td>
                              <td><?= $each_record['ReceiptNo'] ?>/<?php echo date(DF, strtotime($each_record['ReceiptDate'])); ?>/<?php echo $each_record['PaidAmt']; $total_amt+=$each_record['share_amount']; ?></td>
                              <td> <?= $each_record['Weightage'] ?>/<?= $each_record['FacultyShare'] ?>/<?php echo $each_record['share_amount'] ?></td>
                              <td><?= $each_record['EnrollNo'] ?></td>
                              <td><?= $each_record['StudentName'] ?></td>
                              <td><?= $each_record['FacultyCode'] ?></td>
                              <td><?= $each_record['BatchCode'] ?></td>
                              <td><?= $each_record['CourseCode'] ?></td>
                              <td><?= $each_record['Mobile1'] ?></td>
                              <td><?php echo $each_record['Add_UserCode'] ?></td>
                          </tr>
                          <?php
            }
            ?>


        </tbody>
    </table>
</div>
<div class="row">

    <button class="btn btn-primary">
        <?php
        echo "Total Enteries Found: " . $total_records;
        ?>     
    </button>

    <button class="btn btn-primary">
        <?php
        echo "Total Sum: " . $total_amt;
        ?>     
    </button>
    <br>
    <br>
    <button class="btn btn-danger">
        Note : For calculate faculty share, all batches must be assigned to that student, either original or dummy faculties.
    </button>
    <br>
    <br>
    <button class="btn btn-danger">
        Note : After calculating faculty share you cannot undo, in feature only you can update faculty, individually.
    </button>

</div>

<script>
              $(document).ready(function () {
                  $('.fee_record_table').DataTable();
              });
</script>
<script src="<?=  base_url()?>js/custom_js/blink/blinking_effect.js" type="text/javascript"></script>