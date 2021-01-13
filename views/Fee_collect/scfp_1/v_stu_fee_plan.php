<div class="row">
   
    <div class="table-responsive">
        <table class="table table-bordered table-hover" class="list_stu_cfp" >
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>EnrollNo</th>
                    <th>Courses</th>
                    <th>FeeType</th>
                    <th>Inst Amt.</th>
                    <th>Total Inst.</th>
                    <th>Total Paid</th>
                    <th>Sort</th>
                    <th>Remarks</th>
                    <th>Add/Remove</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $s_no = 1;
                foreach ($stu_exiting_fee_plan as $cfp) {
                              ?>
                              <tr>
                                  <td><?php echo $s_no++ ?>.</td>
                                  <td>
                                      <?php echo $EnrollNo; ?>
                                  </td>
                                  <td><?php echo implode(",", $stu_Courses); ?></td>
                                  <td>
                                      <?php echo $cfp->FeeType_Code; ?>
                                  </td>
                                  <td><?php echo $cfp->Inst_amt; ?></td>
                                  <td><?php echo $cfp->Total_Inst; ?></td>
                                  <td><?php echo $cfp->Total_paid; ?></td>
                                  <td><?php echo $cfp->Sort; ?></td>
                                  <td><?php echo $cfp->Remarks; ?></td>
                                  <td>
                                      <form>
                                           <a href="<?php echo base_url() ?>fees/Fee_Master/sscfp/<?php echo $Stu_ID ?>/<?php echo $cfp->FeeTypeID ?>">
                                               <button type="button" class="btn btn-xs btn-primary" style="margin: 5px 0px">
                                              <span class="glyphicon glyphicon-edit"></span>    
                                          </button></a>
                                          <input type="hidden" name="_key" value="del_scfp"/>
                                          <input  type="hidden" value="You want to delete <?= $cfp->Inst_amt . "x" . $cfp->Total_Inst ?> Plan !!" name="_msg"/>
                                          <input type="hidden" value="<?= $cfp->ID ?>" name="ID"/>
                                          <?php if (!$cfp->Total_paid) { ?>
                                                        <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                            <span class="glyphicon glyphicon-trash"></span> 
                                                        </button>
                                          <?php } ?>
                                      </form>
                                  </td> 
                              </tr>
                <?php } ?>
            </tbody>

        </table>     
    </div>
</div>
<script>
              $(document).ready(function () {
                  $('.list_stu_cfp').DataTable();
              });
</script>