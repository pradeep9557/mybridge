<!-- Called via Ajax -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover capitalized_word fee_record_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>EnrollNo</th>
                <th>Course</th>
                <th>Fee Type</th>
                <th>RNo</th>
                <th>RDate</th>
                <th>PreBal</th>
                <th>Tot</th>
                <th>Dis</th>
                <th>Paid</th>
                <th>Bal</th>
                <th>Addby</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $total_records = count($fees_record);

            foreach ($fees_record as $fee) {
                          ?>
                          <tr class="odd gradeX">
                              <td><?= ++$i ?>.</td>
                              <td><?= $fee->EnrollNo ?></td>
                              <td><?= $fee->CourseCode ?></td>
                              <td><?= $fee->FeeType_Code ?></td>
                              <td><?= $fee->ReceiptNo ?></td>
                              <td><?php echo date(DF, strtotime($fee->ReceiptDate)); ?></td>

                              <td><?= $fee->PreBalAmt ?></td>
                              <td><?= $fee->TotalAmt ?></td>
                              <td><?= $fee->DisAmt ?></td>
                              <td><?= $fee->PaidAmt ?></td>
                              <td><?= $fee->BalanceAmt ?></td>
                              <td><?php echo $fee->Add_UserCode ?></td>
                              <td>
                                  <a class="left_icon" href="<?= base_url() ?>fees/Fee_Master/Print_Fee/<?= $fee->ReceiptNo ?>" target="_blank">
                                      <button class="btn-xs btn btn-primary" title="Print" type="button"> <span class="glyphicon glyphicon-print"></span></button>
                                  </a>
                                  <?php
                                  if ($total_records == $i) {
                                                ?>

                                                <a class="left_icon"  href="javascript:void();" onclick="open_page('<?= base_url() ?>fees/Fee_Master/Fee_Edit/<?= $fee->ReceiptNo ?>', '')">
                                                    <button class="btn-xs btn btn-success" title="Edit Details of EnrollNo <?= $fee->Stu_ID ?>" type="button"><span class="glyphicon glyphicon-edit"></span></button>
                                                </a> 
                                                <form class="left_icon">
                                                    <input type="hidden" name="_key" value="cancel_fee_receipt"/>
                                                    <input  type="hidden" value="Do you want to cancel fee receipt no <?= $fee->ReceiptNo ?>" name="_msg"/>
                                                    <input type="hidden" value="<?= $fee->ReceiptNo ?>" name="ReceiptNo"/>
                                                    <input type="hidden" value="<?= $fee->Stu_ID ?>" name="Stu_ID"/>
                                                    <input type="hidden" value="<?= $fee->FeeTypeID ?>" name="FeeTypeID"/>
                                                    <input type="hidden" value="<?= $fee->CourseID ?>" name="CourseID"/>
                                                    <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                    </button>
                                                    <!-- delete form end -->
                                                </form>
                                  <?php } ?>
                              </td>
                          </tr>
                          <?php
            }
            ?>


        </tbody>
    </table>
</div>

<script>
              $(document).ready(function () {
                  $('.fee_record_table').DataTable();
              });
</script>
