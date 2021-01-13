<!-- Called via Ajax -->

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover capitalized_word fee_record_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>EnrollNo</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Fee Type</th>
                <th>RNo/RDate/PreBal/Tot</th>
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
            $total_amt = 0;

            foreach ($fees_record as $fee) {
                          ?>
                          <tr class="odd gradeX">
                              <td><?= ++$i ?>.</td>
                              <td><?= $fee->EnrollNo ?></td>
                              <td><?= $fee->StudentName ?></td>
                               <td><?= $fee->Mobile1 ?></td>
                              <td><?= $fee->FeeType_Code ?></td>
                              <td><?= $fee->ReceiptNo ?>/<?php echo date(DF, strtotime($fee->ReceiptDate)); ?>
                              /<?= $fee->PreBalAmt ?>/<?= $fee->TotalAmt ?></td>
                              <td><?= $fee->DisAmt ?></td>
                              <td><?php echo $fee->PaidAmt;
                              $total_amt += $fee->PaidAmt; ?></td>
                              <td><?= $fee->BalanceAmt ?></td>
                              <td><?php echo $fee->Add_UserCode ?></td>
                              <td>
                                  <a class="left_icon" href="<?= base_url() ?>fees/Fee_Master_1/Print_Fee/<?= $fee->ReceiptNo ?>" target="_blank">
                                      <button class="btn-xs btn btn-primary" title="Print" type="button"> <span class="glyphicon glyphicon-print"></span></button>
                                  </a>
                                  <?php
                                  if($cnf[0]!="Fee_Master_1" && $cnf[1]!="all_fee_records"){
                                  if ($total_records == $i) {
                                                ?>

                                                <a class="left_icon"  href='<?= base_url() ?>fees/Fee_Master_1/Fee_Edit/<?= $fee->ReceiptNo ?>'>
                                                    <button class="btn-xs btn btn-success" title="Edit Details of EnrollNo <?= $fee->Stu_ID ?>" type="button"><span class="glyphicon glyphicon-edit"></span></button>
                                                </a> 
                                                <form class="left_icon">
                                                    <input type="hidden" name="_key" value="cancel_fee_receipt"/>
                                                    <input  type="hidden" value="Do you want to cancel fee receipt no <?= $fee->ReceiptNo ?>" name="_msg"/>
                                                    <input type="hidden" value="<?= $fee->ReceiptNo ?>" name="ReceiptNo"/>
                                                    <input type="hidden" value="<?= $fee->Stu_ID ?>" name="Stu_ID"/>
                                                    <input type="hidden" value="<?= $fee->FeeTypeID ?>" name="FeeTypeID"/>
<!--                                                    <input type="hidden" value="<?= $fee->CourseID ?>" name="CourseID"/>-->
                                                    <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                    </button>
                                                    <!-- delete form end -->
                                                </form>
                                  <?php } } ?>
                              </td>
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
               echo "Total Enteries Found: ".$total_records;
              ?>     
    </button>
        
    <button class="btn btn-primary">
              <?php 
               echo "Total Sum: ".$total_amt;
              ?>     
    </button>
    <?php 
     if(FEE_COLLECT_TYPE==2){
    ?>
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
     <?php } ?>      
   </div>

<script>
              $(document).ready(function () {
                  $('.fee_record_table').DataTable();
              });
</script>
